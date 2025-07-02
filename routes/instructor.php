<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\Instructor\CourseController;
use App\Http\Controllers\Web\Instructor\VideoController;
use App\Http\Controllers\Web\Instructor\DashboardController;
use App\Http\Controllers\Web\Instructor\QuizController;
use App\Http\Controllers\Web\Instructor\AbsenceController;
use App\Http\Controllers\Web\Instructor\AssignmentController;
use App\Http\Controllers\Web\Instructor\SubmissionController;
use App\Http\Controllers\Web\Auth\AuthController;
use App\Http\Controllers\Web\Instructor\CourseEnrollmentController;
use App\Http\Controllers\Web\Instructor\ProfileController;
use App\Http\Controllers\Web\Instructor\CourseQuizController;
use App\Http\Controllers\Web\Instructor\CourseQuizQuestionController;
use App\Http\Controllers\Web\Instructor\StudentController;

/*
|===========================================
|> Group: Authentication & Instructor Dashboard Routes
|===========================================
*/

// Route::middleware('guest')->prefix('dashboard')->group(function () {
//     Route::get('/login', [AuthController::class, 'showInstructorLoginForm'])->name('dashboard.login');
//     Route::post('/login', [AuthController::class, 'instructorLogin'])->name('dashboard.login.post')->middleware('login.throttle');
// });

Route::middleware(['auth', 'role:instructor'])->prefix('dashboard')->group(function () {

    // index
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Absence Routes
    Route::prefix('absences')->name('dashboard.absences.')->group(function () {
        Route::get('/', [AbsenceController::class, 'index'])->name('index');
        Route::get('/scan', [AbsenceController::class, 'scanQrCode'])->name('scan');
        Route::post('/record', [AbsenceController::class, 'recordAbsence'])->name('record');
        Route::delete('/record', [AbsenceController::class, 'destroy'])->name('record');
        Route::get('/generate', [AbsenceController::class, 'generateQrCodeView'])->name('generate');
        Route::get('/generate-qr', [AbsenceController::class, 'generateQrCode'])->name('generate-qr');
        Route::get('/download-qr', [AbsenceController::class, 'downloadQrCode'])->name('download-qr');
    });

    Route::prefix('courses')->name('dashboard.')->group(function () {
        Route::get('/', [CourseController::class, 'index'])->name('courses.index');
        Route::get('/create', [CourseController::class, 'create'])->name('courses.create');
        Route::post('/', [CourseController::class, 'store'])->name('courses.store');
        Route::get('/{course}', [CourseController::class, 'show'])->name('courses.show');
        Route::get('/{course}/edit', [CourseController::class, 'edit'])->name('courses.edit');
        Route::post('/{course}', [CourseController::class, 'update'])->name('courses.update');
        Route::delete('/{course}', [CourseController::class, 'destroy'])->name('courses.destroy');
    });

    Route::prefix('courses/{course}/videos')->name('dashboard.courses.')->group(function () {
        Route::get('/', [VideoController::class, 'index'])->name('videos.index');
        Route::get('/create', [VideoController::class, 'create'])->name('videos.create');
        Route::post('/', [VideoController::class, 'store'])->name('videos.store');
        Route::get('/{video}', [VideoController::class, 'show'])->name('videos.show');
        Route::get('/{video}/edit', [VideoController::class, 'edit'])->name('videos.edit');
        Route::post('/{video}', [VideoController::class, 'update'])->name('videos.update');
        Route::delete('/{video}', [VideoController::class, 'destroy'])->name('videos.destroy');
    });

    Route::prefix('courses/videos')->name('dashboard.courses.')->group(function () {
        // Quiz Routes
        Route::get('/{video}/quiz', [QuizController::class, 'index'])->name('videos.quiz.index');
        Route::get('/{video}/quiz/create', [QuizController::class, 'create'])->name('videos.quiz.create');
        Route::post('/{video}/quiz', [QuizController::class, 'store'])->name('videos.quiz.store');
        Route::get('/{video}/quiz/{question}', [QuizController::class, 'edit'])->name('videos.quiz.edit');
        Route::post('/{video}/quiz/{question}', [QuizController::class, 'update'])->name('videos.quiz.update');
        Route::delete('/{video}/quiz/{question}', [QuizController::class, 'destroy'])->name('videos.quiz.destroy');
    });

    Route::prefix('courses/{course}/assignments')->name('dashboard.courses.')->group(function () {
        Route::get('/', [AssignmentController::class, 'index'])->name('assignments.index');
        Route::get('/create', [AssignmentController::class, 'create'])->name('assignments.create');
        Route::post('/', [AssignmentController::class, 'store'])->name('assignments.store');
        Route::get('/{assignment}/edit', [AssignmentController::class, 'edit'])->name('assignments.edit');
        Route::post('/{assignment}', [AssignmentController::class, 'update'])->name('assignments.update');
        Route::delete('/{assignment}', [AssignmentController::class, 'destroy'])->name('assignments.destroy');
    });

    Route::prefix('courses/{course}/assignments/{assignment}/submissions')->name('dashboard.courses.assignments.')->group(function(){
        Route::get('/', [SubmissionController::class,'index'])->name('submissions.index');
        Route::get('/{submission}/edit', [SubmissionController::class,'edit'])->name('submissions.edit');
        Route::post('/{submission}', [SubmissionController::class,'update'])->name('submissions.update');
    });

    Route::prefix('enrollments')->name('dashboard.')->group(function () {
        Route::get('/', [CourseEnrollmentController::class, 'index'])->name('enrollments.index');
    });


    Route::prefix('profile')->name('dashboard.profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'index'])->name('index');
        Route::get('/edit', [ProfileController::class, 'edit'])->name('edit');
        Route::post('/update', [ProfileController::class, 'update'])->name('update');
        Route::get('/change-password', [ProfileController::class, 'changePassword'])->name('change-password');
        Route::post('/change-password', [ProfileController::class, 'updatePassword'])->name('update-password');
    });

    Route::prefix('courses/{course}/quizzes')->name('dashboard.courses.')->group(function () {
        Route::get('/', [CourseQuizController::class, 'index'])->name('quiz.index');
        Route::get('/create', [CourseQuizController::class, 'create'])->name('quiz.create');
        Route::post('/', [CourseQuizController::class, 'store'])->name('quiz.store');
        Route::get('/{quiz}/edit', [CourseQuizController::class, 'edit'])->name('quiz.edit');
        Route::post('/{quiz}', [CourseQuizController::class, 'update'])->name('quiz.update');
        Route::delete('/{quiz}', [CourseQuizController::class, 'destroy'])->name('quiz.destroy');
        // extra routes for controlling quiz timing
        Route::post('/{quiz}/extend', [CourseQuizController::class, 'extend'])->name('quiz.extend');
        Route::post('/{quiz}/stop', [CourseQuizController::class, 'stop'])->name('quiz.stop');
    });

    Route::prefix('courses/{course}/quizzes/{quiz}/questions')->name('dashboard.courses.quiz.questions.')->group(function(){
        Route::get('/', [CourseQuizQuestionController::class, 'index'])->name('index');
        Route::get('/create', [CourseQuizQuestionController::class, 'create'])->name('create');
        Route::post('/', [CourseQuizQuestionController::class, 'store'])->name('store');
        Route::get('/{question}/edit', [CourseQuizQuestionController::class, 'edit'])->name('edit');
        Route::post('/{question}', [CourseQuizQuestionController::class, 'update'])->name('update');
        Route::delete('/{question}', [CourseQuizQuestionController::class, 'destroy'])->name('destroy');
    });

    // Students Routes (like absence)
    Route::prefix('students')->name('dashboard.students.')->group(function () {
        Route::get('/', [StudentController::class, 'index'])->name('index'); // scan form
        Route::post('/scan', [StudentController::class, 'scan'])->name('scan'); // process scan
        Route::get('/list', [StudentController::class, 'list'])->name('list'); // all students table
        Route::get('/{student}', [StudentController::class, 'show'])->name('show'); // student details
    });

});
