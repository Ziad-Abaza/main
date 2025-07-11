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
use Spatie\Permission\Models\Role;
use Throwable;
use App\Services\CacheService;

class ChildrenStudentController extends Controller
{
    protected $importService;
    protected $cacheService;

    public function __construct(
        ChildrenStudentImportService $importService,
        CacheService $cacheService
    ) {
        $this->importService = $importService;
        $this->cacheService = $cacheService;

        $this->middleware(['auth', 'can:manage_child'])->only([
            'index',
            'create',
            'store',
            'edit',
            'update',
            'export'
        ]);
    }

    /**
     * Display a listing of the resource with caching.
     */
    public function index()
    {
        try {
            // Generate unique cache key for children students
            $cacheKey = 'children_students_index';

            return $this->cacheService->remember($cacheKey, function () {
                return view('dashboard.children-students.index');
            });
        } catch (Throwable $th) {
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

                // Clear cache after importing
                $this->cacheService->forget('children_students_index');

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

                $role = Role::where('name', 'student')->first();
                if ($role) {
                    $user->assignRole($role);
                }

                $meta = [];

                $keys = $request->input('meta_keys', []);
                $values = $request->input('meta_values', []);

                foreach ($keys as $index => $key) {
                    if (!empty($key) && isset($values[$index])) {
                        $value = $values[$index];
                        $meta[$key] = is_array($value) ? implode(' ', $value) : (string) $value;
                    }
                }

                ChildrenUniversity::create([
                    'code' => $code,
                    'user_id' => $user->user_id,
                    'meta' => $meta,
                ]);
            });

            // Clear cache after creating a new student
            $this->cacheService->forget('children_students_index');

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
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255|unique:users,email,' . $childrenStudent->user->user_id . ',user_id',
                'code' => 'required|string|max:20|unique:children_universities,code,' . $childrenStudent->id,
            ]);

            DB::transaction(function () use ($childrenStudent, $validated) {
                $childrenStudent->user->update([
                    'name' => $validated['name'],
                    'email' => $validated['email']
                ]);

                $childrenStudent->update([
                    'code' => $validated['code']
                ]);
            });

            // Clear cache after updating a student
            $this->cacheService->forget('children_students_index');

            return redirect()->route('console.children-students.index')
                ->with('success', 'Child updated successfully');
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (ModelNotFoundException $e) {
            return back()->with('error', 'Child not found');
        } catch (Throwable $th) {
            return back()->with('error', 'Failed to update child');
        }
    }

    /**
     * Export children students data.
     */
    public function export()
    {
        try {
            return Excel::download(new ChildrenStudentsExport(), 'students.xlsx');
        } catch (Throwable $th) {
            return back()->with('error', 'Failed to export children students data');
        }
    }
}
