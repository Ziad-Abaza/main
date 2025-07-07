<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\Dashboard\RoleController;
use App\Http\Controllers\Web\Dashboard\UserController;
use App\Http\Controllers\Web\Auth\AuthController;
use App\Http\Controllers\Web\Dashboard\CategoryController;
use App\Http\Controllers\Web\Dashboard\CourseController;
use App\Http\Controllers\Web\Dashboard\LevelController;
use App\Http\Controllers\Web\Dashboard\LevelCourseController;
use App\Http\Controllers\Web\Dashboard\ChildrenStudentController;
use App\Http\Controllers\Web\Dashboard\DashboardController;
use App\Http\Controllers\Web\Instructor\AbsenceController;
use Illuminate\Support\Facades\Log;
use App\Livewire\Dashboard\ChildrenStudentsTable;
use App\Http\Controllers\Web\Dashboard\FaqController;
use App\Http\Controllers\Web\Dashboard\BlogController;
use App\Http\Controllers\Web\Dashboard\ContactController;






/*
|===========================================
|> Group: Authentication & Admin Access
|===========================================
*/

Route::middleware('guest')->prefix('console')->group(function () {
    Route::get('/login', [AuthController::class, 'showAdminLoginForm'])->name('console.login');
    Route::post('/login', [AuthController::class, 'adminLogin'])->name('console.login.post')->middleware('login.throttle');
});


Route::middleware(['auth', 'role:admin'])->prefix('console')->group(function () {


    Route::get('/', [DashboardController::class, 'index'])->name('console');

    // -----------------------------
    // User Management Routes
    // -----------------------------
    Route::prefix('users')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('console.users.index');
        Route::get('/edit/{user}', [UserController::class, 'edit'])->name('console.users.edit');
        Route::post('/update/{user}', [UserController::class, 'update'])->name('console.users.update');
        Route::delete('/delete/{user}', [UserController::class, 'destroy'])->name('console.users.delete');
    });

    Route::prefix('profile')->group(function () {
        Route::get('/', [UserController::class, 'profile'])->name('console.profile.index');
        Route::get('/edit', [UserController::class, 'editProfile'])->name('console.profile.edit');
        Route::post('/update', [UserController::class, 'updateProfile'])->name('console.profile.update');

        Route::get('/change-password', [UserController::class, 'showChangePasswordForm'])->name('console.profile.change-password');
        Route::post('/change-password', [UserController::class, 'changePassword'])->name('console.profile.change-password.post');
    });

    // -----------------------------
    // Role Management Routes
    // -----------------------------
    Route::prefix('roles')->group(function () {
        Route::get('/', [RoleController::class, 'index'])->name('console.roles.index');
        Route::get('/create', [RoleController::class, 'create'])->name('console.roles.create');
        Route::post('/store', [RoleController::class, 'store'])->name('console.roles.store');
        Route::get('/edit/{role}', [RoleController::class, 'edit'])->name('console.roles.edit');
        Route::post('/update/{role}', [RoleController::class, 'update'])->name('console.roles.update');
        Route::delete('/delete/{role}', [RoleController::class, 'destroy'])->name('console.roles.delete');
    });

    // -----------------------------
    // Category Management Routes
    // -----------------------------
    Route::prefix('categories')->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->name('console.categories.index');
        Route::get('/create', [CategoryController::class, 'create'])->name('console.categories.create');
        Route::post('/store', [CategoryController::class, 'store'])->name('console.categories.store');
        Route::get('/edit/{category}', [CategoryController::class, 'edit'])->name('console.categories.edit');
        Route::post('/update/{category}', [CategoryController::class, 'update'])->name('console.categories.update');
        Route::delete('/delete/{category}', [CategoryController::class, 'destroy'])->name('console.categories.delete');
    });

    // -----------------------------
    // Course Management Routes
    // -----------------------------
    Route::prefix('courses')->group(function () {
        Route::get('/', [CourseController::class, 'index'])->name('console.courses.index');
        Route::get('/create', [CourseController::class, 'create'])->name('console.courses.create');
        Route::post('/store', [CourseController::class, 'store'])->name('console.courses.store');
        Route::get('/{course}', [CourseController::class, 'show'])->name('console.courses.show');
        Route::get('/edit/{course}', [CourseController::class, 'edit'])->name('console.courses.edit');
        Route::post('/update/{course}', [CourseController::class, 'update'])->name('console.courses.update');
        Route::delete('/delete/{course}', [CourseController::class, 'destroy'])->name('console.courses.delete');
    });

    // -----------------------------
    // Absence Routes
    // -----------------------------
    Route::prefix('absences')->group(function () {
        Route::get('/', [AbsenceController::class, 'index'])->name('console.absences.index');
        Route::get('/scan', [AbsenceController::class, 'scanQrCode'])->name('console.absences.scan');
        Route::post('/record', [AbsenceController::class, 'recordAbsence'])->name('console.absences.record');
        Route::get('/generate', [AbsenceController::class, 'generateQrCodeView'])->name('console.absences.generate');
        Route::get('/generate-qr', [AbsenceController::class, 'generateQrCode'])->name('console.absences.generate-qr');
        Route::get('/download-qr', [AbsenceController::class, 'downloadQrCode'])->name('console.absences.download-qr');
        Route::get('/{absence}/edit', [AbsenceController::class, 'edit'])->name('console.absences.edit');
        Route::post('/{absence}', [AbsenceController::class, 'update'])->name('console.absences.update');
        Route::delete('/{absence}', [AbsenceController::class, 'destroy'])->name('console.absences.delete');
        Route::get('/export', [AbsenceController::class, 'export'])->name('console.absences.export');
    });

    // -----------------------------
    // Children Students Management
    // -----------------------------
    Route::prefix('children-students')->controller(ChildrenStudentController::class)->group(function () {
        Route::get('/', 'index')->name('console.children-students.index');
        // Route::get('/', ChildrenStudentsTable::class)->name('console.children-students.index');

        Route::get('/create', 'create')->name('console.children-students.create');
        Route::post('/store', 'store')->name('console.children-students.store');
        Route::get('/edit/{childrenStudent}', 'edit')->name('console.children-students.edit');
        Route::post('/update/{childrenStudent}', 'update')->name('console.children-students.update');
        Route::delete('/delete/{childrenStudent}', 'destroy')->name('console.children-students.delete');
        Route::post('/delete-all', 'destroyAll')->name('console.children-students.delete-all');
        Route::get('/export', 'export')->name('console.children-students.export');
        Route::get('/{userId}/password', 'getPassword')->name('console.children-students.password.show');
    });

    // -----------------------------
    // Level Management Routes
    // -----------------------------
    Route::prefix('levels')->group(function () {
        Route::get('/', [LevelController::class, 'index'])->name('console.levels.index');
        Route::get('/create', [LevelController::class, 'create'])->name('console.levels.create');
        Route::post('/store', [LevelController::class, 'store'])->name('console.levels.store');
        Route::get('/{level}', [LevelController::class, 'show'])->name('console.levels.show');
        Route::get('/edit/{level}', [LevelController::class, 'edit'])->name('console.levels.edit');
        Route::post('/update/{level}', [LevelController::class, 'update'])->name('console.levels.update');
        Route::delete('/delete/{level}', [LevelController::class, 'destroy'])->name('console.levels.delete');
    });

    // -----------------------------
    // Level-Course Management Routes
    // -----------------------------
    Route::prefix('level-courses')->group(function () {
        Route::get('/', [LevelCourseController::class, 'index'])->name('console.level-courses.index');
        Route::get('/create', [LevelCourseController::class, 'create'])->name('console.level-courses.create');
        Route::post('/store', [LevelCourseController::class, 'store'])->name('console.level-courses.store');
        Route::get('/{level}', [LevelCourseController::class, 'show'])->name('console.level-courses.show');
        Route::get('/edit/{level}', [LevelCourseController::class, 'edit'])->name('console.level-courses.edit');
        Route::post('/update/{level}', [LevelCourseController::class, 'update'])->name('console.level-courses.update');
        Route::delete('/{level}/remove/{course}', [LevelCourseController::class, 'destroy'])->name('console.level-courses.delete');
    });

    // FAQ Management
    Route::prefix('faqs')->group(function () {
        Route::get('/', [FaqController::class, 'index'])->name('dashboard.faq.index');
        Route::get('/create', [FaqController::class, 'create'])->name('dashboard.faq.create');
        Route::post('/store', [FaqController::class, 'store'])->name('dashboard.faq.store');
        Route::get('/edit/{faq}', [FaqController::class, 'edit'])->name('dashboard.faq.edit');
        Route::put('/update/{faq}', [FaqController::class, 'update'])->name('dashboard.faq.update');
        Route::delete('/delete/{faq}', [FaqController::class, 'destroy'])->name('dashboard.faq.destroy');
    });

    // Blog Management
    Route::prefix('blogs')->group(function () {
        Route::get('/', [BlogController::class, 'index'])->name('dashboard.blog.index');
        Route::get('/create', [BlogController::class, 'create'])->name('dashboard.blog.create');
        Route::post('/store', [BlogController::class, 'store'])->name('dashboard.blog.store');
        Route::get('/edit/{blog}', [BlogController::class, 'edit'])->name('dashboard.blog.edit');
        Route::put('/update/{blog}', [BlogController::class, 'update'])->name('dashboard.blog.update');
        Route::delete('/delete/{blog}', [BlogController::class, 'destroy'])->name('dashboard.blog.destroy');
    });

    // Contact Management
    Route::prefix('contacts')->group(function () {
        Route::get('/', [ContactController::class, 'index'])->name('dashboard.contact.index');
        Route::delete('/delete/{contact}', [ContactController::class, 'destroy'])->name('dashboard.contact.destroy');
    });

    // Students Management
    Route::get('/students', [\App\Http\Controllers\Web\Dashboard\StudentController::class, 'list'])->name('console.students.index');
    Route::get('/students/scan', [\App\Http\Controllers\Web\Dashboard\StudentController::class, 'scanForm'])->name('console.students.scan');
    Route::post('/students/scan', [\App\Http\Controllers\Web\Dashboard\StudentController::class, 'scan'])->name('console.students.scan');
    Route::get('/students/{student}', [\App\Http\Controllers\Web\Dashboard\StudentController::class, 'show'])->name('console.students.show');
    Route::get('/students/{student}/absences', [\App\Http\Controllers\Web\Dashboard\StudentController::class, 'absences'])->name('console.students.absences');
});
