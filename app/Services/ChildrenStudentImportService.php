<?php

namespace App\Services;

use App\Models\User;
use App\Models\ChildrenUniversity;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\UserCourseProgress;
use App\Models\Level;
use App\Models\Role;

class ChildrenStudentImportService
{
    public function import($filePath)
    {
        Log::info("✅ Starting import of children students from: $filePath");

        try {
            $spreadsheet = $this->loadSpreadsheet($filePath);
            $worksheet = $spreadsheet->getActiveSheet();
            $highestRow = $worksheet->getHighestRow();
            $headerRow = $this->getHeaderRow($worksheet);

            for ($rowIndex = 2; $rowIndex <= $highestRow; $rowIndex++) {
                try {
                    $rowData = [];
                    foreach ($headerRow as $col => $fieldName) {
                        $cellValue = $worksheet->getCellByColumnAndRow($col, $rowIndex)->getValue();
                        $rowData[$fieldName] = $cellValue;
                    }

                    $processed = $this->processRow($rowData);
                    if (!$processed) {
                        Log::warning("⚠️ Empty name at row $rowIndex, skipping.");
                        continue;
                    }

                    $email = $this->generateEmail($processed['code']);
                    if (User::where('email', $email)->exists()) {
                        Log::warning("⚠️ Duplicate email $email at row $rowIndex, skipping.");
                        continue;
                    }

                    $password = $this->generatePassword($processed['name']);
                    $hashedPassword = Hash::make($password);
                    $encryptPassword = encrypt($password);

                    $levelId = $this->resolveLevelId($processed['level']);
                    if (!$levelId) {
                        Log::warning("⚠️ Level not found at row $rowIndex, skipping.");
                        continue;
                    }

                    $className = $this->ensureString($processed['class_name'] ?? null);
                    $image = $this->extractImageFromMeta($processed['meta']);

                    $this->createUserAndStudent(
                        $processed,
                        $email,
                        $password,
                        $hashedPassword,
                        $encryptPassword,
                        $levelId,
                        $className,
                        $image
                    );

                } catch (\Throwable $e) {
                    Log::error("❌ Error importing row $rowIndex: " . $e->getMessage());
                }
            }

            Log::info("✅ Import completed successfully.");

        } catch (\Throwable $e) {
            Log::error("❌ Failed to import file: " . $e->getMessage());
            throw $e;
        }
    }

    private function loadSpreadsheet($filePath)
    {
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $reader->setReadDataOnly(true);
        return $reader->load($filePath);
    }

    private function getHeaderRow($worksheet)
    {
        $highestColumn = $worksheet->getHighestColumn();
        $headerRow = [];

        foreach (range(1, \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestColumn)) as $col) {
            $cellValue = $worksheet->getCellByColumnAndRow($col, 1)->getValue();
            $headerRow[$col] = trim((string) $cellValue);
        }

        return $headerRow;
    }

    private function processRow($rowData)
    {
        if (empty($rowData['name'])) {
            return null;
        }

        $processed = [
            'name' => $this->ensureString($rowData['name']),
            'code' => $this->getCodeFromRow($rowData),
            'level' => $rowData['level'] ?? null,
            'class_name' => $rowData['class_name'] ?? null,
            'meta' => [],
        ];

        unset($rowData['name'], $rowData['code'], $rowData['level'], $rowData['class_name']);
        foreach ($rowData as $key => $value) {
            $processed['meta'][$key] = $this->ensureString($value);
        }

        return $processed;
    }

    private function ensureString($value)
    {
        return is_array($value) ? implode(' ', $value) : (string)$value;
    }

    private function getCodeFromRow($rowData)
    {
        if (!empty($rowData['code'])) {
            return $this->ensureString($rowData['code']);
        } elseif (!empty($rowData['academic_id'])) {
            return $this->ensureString($rowData['academic_id']);
        } else {
            return $this->generateUniqueCode(1001);
        }
    }

    private function generateEmail($code)
    {
        return $code . '@children.org';
    }

    private function generatePassword($name)
    {
        $initials = $this->extractArabicInitials($name);
        return $initials . rand(111, 999) . '0' . date('d');
    }


    private function getCoursesByLevelId($levelId)
    {
        return DB::table('course_level')
            ->where('level_id', $levelId)
            ->pluck('course_id');
    }

    private function resolveLevelId($levelName)
    {
        $levelName = $this->ensureString($levelName);
        $levelName = trim($levelName);
        $level = Level::whereRaw('LOWER(TRIM(name)) = ?', [mb_strtolower($levelName)])->first();
        return $level?->level_id;
    }

    private function extractImageFromMeta(&$metaData)
    {
        $image = null;
        if (isset($metaData['image'])) {
            $image = $metaData['image'];
            unset($metaData['image']);
        }
        return $image;
    }

    private function createUserAndStudent($data, $email, $password, $hashedPassword, $encryptPassword, $levelId, $className, $image)
    {
        DB::transaction(function () use ($data, $email, $hashedPassword, $encryptPassword, $levelId, $className, $image) {
            $user = User::create([
                'name'     => $data['name'],
                'email'    => $email,
                'password' => $hashedPassword,
            ]);

            $role = Role::where('name', 'student')->first();
            if ($role) {
                $user->roles()->attach($role->role_id);
            }

            ChildrenUniversity::create([
                'code'      => $data['code'],
                'user_id'   => $user->user_id,
                'password'  => $encryptPassword,
                'level_id'  => $levelId,
                'class_name'=> $className,
                'meta'      => $data['meta'],
                'image'     => $image,
            ]);

            $courseIds = $this->getCoursesByLevelId($levelId);

            foreach ($courseIds as $courseId) {
                UserCourseProgress::create([
                    'user_course_id' => (string) Str::uuid(),
                    'user_id'        => $user->user_id,
                    'course_id'      => $courseId,
                    'completion_percentage' => 0,
                ]);
            }
        });
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

        while (ChildrenUniversity::where('code', $prefix . $newNumberPadded)->exists()) {
            $newNumber++;
            $newNumberPadded = str_pad($newNumber, 4, '0', STR_PAD_LEFT);
        }

        return $prefix . $newNumberPadded;
    }

    public function extractArabicInitials($name)
    {
        if (!is_string($name)) {
            $name = (string)$name;
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
