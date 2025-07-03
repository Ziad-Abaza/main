<?php

namespace App\Services;

use App\Models\User;
use App\Models\ChildrenUniversity;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class ChildrenStudentImportServicecopy
{
    public function import($filePath)
    {
        Log::info("✅ Starting import of children students from: $filePath");

        try {
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            $reader->setReadDataOnly(true);
            $spreadsheet = $reader->load($filePath);
            $worksheet = $spreadsheet->getActiveSheet();
            $highestRow = $worksheet->getHighestRow();
            $highestColumn = $worksheet->getHighestColumn();
            $headerRow = [];

            foreach (range(1, \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestColumn)) as $col) {
                $cellValue = $worksheet->getCellByColumnAndRow($col, 1)->getValue();
                $headerRow[$col] = trim((string) $cellValue);
            }

            for ($rowIndex = 2; $rowIndex <= $highestRow; $rowIndex++) {
                try {
                    $rowData = [];
                    foreach ($headerRow as $col => $fieldName) {
                        $cellValue = $worksheet->getCellByColumnAndRow($col, $rowIndex)->getValue();
                        $rowData[$fieldName] = trim((string) $cellValue);
                    }

                    if (empty($rowData['name'])) {
                        Log::warning("⚠️ Empty name at row $rowIndex, skipping.");
                        continue;
                    }

                    // Ensure name is a string
                    $name = is_array($rowData['name']) ? implode(' ', $rowData['name']) : (string) $rowData['name'];
                    // Determine code
                    if (!empty($rowData['code'])) {
                        $code = is_array($rowData['code']) ? implode('', $rowData['code']) : (string) $rowData['code'];
                    } elseif (!empty($rowData['academic_id'])) {
                        $code = is_array($rowData['academic_id']) ? implode('', $rowData['academic_id']) : (string) $rowData['academic_id'];
                    } else {
                        $code = $this->generateUniqueCode(1001); // start from 22501001
                    }

                    // Always use code as email
                    $email = $code . '@children.org';

                    // Check for duplicate email
                    if (User::where('email', $email)->exists()) {
                        Log::warning("⚠️ Duplicate email $email at row $rowIndex, skipping.");
                        continue;
                    }

                    $initials = $this->extractArabicInitials($name);
                    $password = $initials . rand(111, 999) .'0'. date('d');
                    $hashedPassword = Hash::make($password);
                    $encryptPassword = encrypt($password);

                    // Resolve level_id from level name in Excel
                    $levelName = $rowData['level'] ?? null;
                    $levelId = null;
                    if ($levelName) {
                        // Ensure levelName is a string, trim, and lowercase for comparison
                        $levelName = is_array($levelName) ? implode(' ', $levelName) : (string) $levelName;
                        $levelName = trim($levelName);
                        $level = \App\Models\Level::whereRaw('LOWER(TRIM(name)) = ?', [mb_strtolower($levelName)])->first();
                        if ($level) {
                            $levelId = $level->level_id;
                        } else {
                            Log::warning("⚠️ Level '$levelName' not found at row $rowIndex, skipping.");
                            continue;
                        }
                    }

                    // Extract class_name from meta if present, like image
                    $className = null;
                    if (isset($rowData['class_name'])) {
                        $classNameValue = $rowData['class_name'];
                        // Handle case where class_name might be an array
                        if (is_array($classNameValue)) {
                            $className = trim(implode(' ', $classNameValue));
                        } else {
                            $className = trim((string) $classNameValue);
                        }
                        unset($rowData['class_name']);
                    }

                    $metaData = $rowData;
                    unset($metaData['name']);
                    unset($metaData['code']);
                    unset($metaData['level']);

                    // Ensure all meta data values are strings, not arrays
                    foreach ($metaData as $key => $value) {
                        if (is_array($value)) {
                            $metaData[$key] = implode(' ', $value);
                        } else {
                            $metaData[$key] = (string) $value;
                        }
                    }

                    // Remove image from meta if present
                    $image = null;
                    if (isset($metaData['image'])) {
                        $image = is_array($metaData['image']) ? implode(' ', $metaData['image']) : (string) $metaData['image'];
                        unset($metaData['image']);
                    }

                    DB::transaction(function () use ($name, $email, $hashedPassword, $code, $metaData, $encryptPassword, $image, $levelId, $className) {
                        $user = User::create([
                            'name'     => $name,
                            'email'    => $email,
                            'password' => $hashedPassword,
                        ]);

                        $role = \App\Models\Role::where('name', 'student')->first();

                        if ($role) {
                            $user->roles()->attach($role->role_id);
                        }

                        ChildrenUniversity::create([
                            'code'      => $code,
                            'user_id'   => $user->user_id,
                            'password'  => $encryptPassword,
                            'level_id'  => $levelId,
                            'class_name'=> $className,
                            'meta'      => $metaData,
                            'image'     => $image,
                        ]);
                    });
                } catch (\Throwable $rowException) {
                    Log::error("❌ Error importing row $rowIndex: " . $rowException->getMessage());
                }
            }

            Log::info("✅ Import completed successfully.");
        } catch (\Throwable $e) {
            Log::error("❌ Failed to import file: " . $e->getMessage());
            throw $e;
        }
    }

    public function generateUniqueCode($start = 1)
    {
        $prefix = '2250';
        $minNumber = $start;
        $maxCode = ChildrenUniversity::where('code', 'like', $prefix . '%')
            ->orderBy('code', 'desc')
            ->value('code');

        $newNumber = $maxCode ? max(((int) substr($maxCode, -4)) + 1, $minNumber) : $minNumber;
        $newNumberPadded = str_pad($newNumber, 4, '0', STR_PAD_LEFT);

        // Ensure code is unique
        while (ChildrenUniversity::where('code', $prefix . $newNumberPadded)->exists()) {
            $newNumber++;
            $newNumberPadded = str_pad($newNumber, 4, '0', STR_PAD_LEFT);
        }

        return $prefix . $newNumberPadded;
    }

    public function extractArabicInitials($name)
    {
        // Ensure name is a string
        if (!is_string($name)) {
            $name = (string) $name;
        }

        $map = [
            'ا' => 'A',
            'ب' => 'B',
            'ت' => 'T',
            'ث' => 'TH',
            'ج' => 'J',
            'ح' => 'H',
            'خ' => 'KH',
            'د' => 'D',
            'ذ' => 'DH',
            'ر' => 'R',
            'ز' => 'Z',
            'س' => 'S',
            'ش' => 'SH',
            'ص' => 'S',
            'ض' => 'D',
            'ط' => 'T',
            'ظ' => 'Z',
            'ع' => 'A',
            'غ' => 'GH',
            'ف' => 'F',
            'ق' => 'Q',
            'ك' => 'K',
            'ل' => 'L',
            'م' => 'M',
            'ن' => 'N',
            'ه' => 'H',
            'و' => 'W',
            'ي' => 'Y',
            'ء' => 'A',
            'ى' => 'A',
            'ئ' => 'Y',
            'ؤ' => 'W',
            'إ' => 'I',
            'أ' => 'A',
            'آ' => 'A'
        ];

        $initials = '';
        $firstTwo = mb_substr($name, 0, 2, 'UTF-8');

        for ($i = 0; $i < mb_strlen($firstTwo); $i++) {
            $char = mb_substr($firstTwo, $i, 1, 'UTF-8');
            $initials .= $map[$char] ?? strtoupper($char);
        }

        return strtoupper($initials);
    }
}
