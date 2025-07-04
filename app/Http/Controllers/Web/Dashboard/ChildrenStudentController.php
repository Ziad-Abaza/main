<?php

namespace App\Http\Controllers\Web\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreChildrenStudentRequest;
use App\Services\ChildrenStudentImportService;
use App\Jobs\ImportChildrenStudentJob;
use Illuminate\Http\Request;
use App\Models\ChildrenUniversity;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ChildrenStudentsExport;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Throwable;

class ChildrenStudentController extends Controller
{
    protected $importService;

    public function __construct(ChildrenStudentImportService $importService)
    {
        $this->importService = $importService;
    }

    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        try {
            return view('dashboard.children-students.index');
        } catch (\Throwable $th) {
            Log::error("Failed to load children students: " . $th->getMessage());
            return back()->with('error', 'Failed to load children students');
        }
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            $code = $this->importService->generateUniqueCode();

            $initials = 'CU';
            $password = $initials . rand(100, 999) . date('d');

            $metaKeys = ChildrenUniversity::pluck('meta')->filter()->flatMap(function ($meta) {
                return array_keys((array) $meta);
            })->unique()->values()->all();

            return view('dashboard.children-students.create', compact('code', 'password', 'metaKeys'));
        } catch (Throwable $th) {
            Log::error("Failed to load create children student form: " . $th->getMessage());
            return back()->with('error', 'Failed to load create form');
        }
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreChildrenStudentRequest $request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $path = $file->store('excel_imports');

            try {
                Log::info("Starting import process", ['stored_path' => $path]);
                ImportChildrenStudentJob::dispatch($path);
                Log::info("Successfully queued import process");

                return redirect()->route('console.children-students.index')
                    ->with('success', 'Students import has been queued successfully');
            } catch (Throwable $th) {
                Log::error("Error during Excel import: " . $th->getMessage());
                return back()->with('error', 'Error processing Excel import');
            }
        }

        try {
            DB::transaction(function () use ($request) {
                $code = $this->importService->generateUniqueCode();

                $email = $request->input('email', $code . '@children.org');
                $nameForInitials = $request->input('name', 'student child');
                $initials = $this->importService->extractArabicInitials($nameForInitials);
                $default_password = $initials . rand(100, 999) . date('d');
                $password = $request->input('password', $default_password);
                $hashedPassword = Hash::make($password);

                $user = User::create([
                    'name' => $request->input('name'),
                    'email' => $email,
                    'password' => $hashedPassword,
                ]);

                $role = \App\Models\Role::where('name', 'student')->first();
                if ($role) {
                    $user->roles()->attach($role->role_id);
                }

                $meta = [];

                $keys = $request->input('meta_keys', []);
                $values = $request->input('meta_values', []);

                foreach ($keys as $index => $key) {
                    if (!empty($key) && isset($values[$index])) {
                        // Ensure the value is a string, not an array
                        $value = $values[$index];
                        if (is_array($value)) {
                            $meta[$key] = implode(' ', $value);
                        } else {
                            $meta[$key] = (string) $value;
                        }
                    }
                }

                ChildrenUniversity::create([
                    'code' => $code,
                    'user_id' => $user->user_id,
                    'meta' => $meta,
                ]);
            });

            return redirect()->route('console.children-students.index')
                ->with('success', 'Student created successfully');
        } catch (Throwable $th) {
            Log::error("Manual student creation failed", ['error' => $th->getMessage()]);
            return back()->with('error', 'Failed to create student');
        }
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ChildrenUniversity $childrenStudent)
    {
        try {
            return view('dashboard.children-students.edit', compact('childrenStudent'));
        } catch (ModelNotFoundException $e) {
            Log::error("Child not found: " . $e->getMessage());
            return back()->with('error', 'Child not found');
        } catch (Throwable $th) {
            Log::error("Failed to load edit form: " . $th->getMessage());
            return back()->with('error', 'Failed to load edit form');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ChildrenUniversity $childrenStudent)
    {
        try {
            // Validate request
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255|unique:users,email,' . $childrenStudent->user->user_id . ',user_id',
                'code' => 'required|string|max:20|unique:children_universities,code,' . $childrenStudent->id,
            ]);

            DB::transaction(function () use ($childrenStudent, $validated) {
                // Update user
                $childrenStudent->user->update([
                    'name' => $validated['name'],
                    'email' => $validated['email']
                ]);

                // Update child university code
                $childrenStudent->update([
                    'code' => $validated['code']
                ]);

            });

            Log::info("Child updated successfully", ['id' => $childrenStudent->id]);
            return redirect()->route('console.children-students.index')
                ->with('success', 'Child updated successfully');
        } catch (ValidationException $e) {
            Log::warning("Validation failed during update", ['errors' => $e->errors()]);
            return back()->withErrors($e->errors())->withInput();
        } catch (ModelNotFoundException $e) {
            Log::error("Child not found for update: " . $e->getMessage());
            return back()->with('error', 'Child not found');
        } catch (Throwable $th) {
            Log::error("Error during update", ['error' => $th->getMessage()]);
            return back()->with('error', 'Failed to update child');
        }
    }

    /**
     * Export children students data.
     */
    public function export()
    {
        try {
            Log::info("Starting export of children students data");
            return Excel::download(new ChildrenStudentsExport(), 'students.xlsx');
        } catch (Throwable $th) {
            Log::error("Error during export: " . $th->getMessage());
            return back()->with('error', 'Failed to export children students data');
        }
    }
}
