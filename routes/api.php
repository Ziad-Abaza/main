<?php

use App\Http\Controllers\Api\General\InstructorController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\General\CourseController as GeneralCourseController;
use App\Http\Controllers\Api\General\HomeController;
use App\Http\Controllers\Api\User\QuizController;
use App\Http\Controllers\Api\User\VideoController;
use App\Http\Controllers\Api\User\ProgressController;
use App\Http\Controllers\Api\User\CourseController as UserCourseController;
use App\Http\Controllers\Api\User\AssignmentController;
use App\Http\Controllers\Api\General\CategoryController;
use App\Http\Controllers\Api\Instructor\SubmissionController;
/*
|===========================================
|> Authentication Routes
|===========================================
*/

Route::prefix('auth')->group(function () {
    Route::middleware(['guest', 'login.throttle'])->group(function () {
        Route::post('/register', [AuthController::class, 'register']);
        Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
    });

    // Sanctum protected routes
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/user', function (Request $request) {
            return $request->user();
        });
    });
});


/*
|===========================================
|> General Routes
|===========================================
*/

// Home Page Routes
Route::prefix('home')->group(function () {
    Route::get('/', [HomeController::class, 'index']);
});

/*
|===========================================
|> Group: Courses Routes
|===========================================
*/
Route::prefix('courses')->group(function () {
    Route::get('/', [GeneralCourseController::class, 'index']);

    Route::get('/{courseId}', [GeneralCourseController::class, 'show']);
    Route::post('/{courseId}/enroll', [GeneralCourseController::class, 'enroll'])->middleware('auth:sanctum');
});

Route::prefix('categories')->group(function () {
    Route::get('/', [CategoryController::class, 'index']);
    Route::get('/{categoryId}', [CategoryController::class, 'show']);
});
/*
|===========================================
|> Group: User Routes
|===========================================
*/

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    // Video Routes
    Route::prefix('videos')->group(function () {
        Route::get('/course/{courseId}', [VideoController::class, 'index']);
        Route::get('/{videoId}', [VideoController::class, 'show']);
    });

    // Quiz Routes
    Route::prefix('quizzes')->group(function () {
        Route::get('/video/{videoId}', [QuizController::class, 'showQuizForVideo']);
        Route::post('/video/{videoId}', [QuizController::class, 'submitQuizAnswers']);
        Route::get('/video/{videoId}/quiz-results', [QuizController::class, 'getQuizResults']);
    });

    // User Progress Routes
    Route::prefix('progress')->group(function () {
        Route::get('/enrolled-courses', [ProgressController::class, 'enrolledCourses']);
        Route::get('/courses/{course}/progress', [ProgressController::class, 'courseProgress']);
        Route::post('/videos/{video}/complete', [ProgressController::class, 'markVideoComplete']);
    });

    // User-Specific Course Routes
    Route::prefix('user/courses')->group(function () {
        Route::get('/', [UserCourseController::class, 'index']);
    });

    // Assignment Routes
    Route::prefix('assignments')->group(function () {
        Route::get('/', [AssignmentController::class, 'getAllAssignments']);
        Route::get('/{assignment}', [AssignmentController::class, 'show']);
        Route::get('/{assignment}/download', [AssignmentController::class, 'downloadAttachment']);
        Route::get('/{assignment}/view', [AssignmentController::class, 'viewAttachment']);
        Route::post('/{assignment}/submit', [AssignmentController::class, 'submit']);
        Route::patch('/{assignment}/submit', [AssignmentController::class, 'updateSubmission']);
        Route::delete('/{assignment}/submit', [AssignmentController::class, 'destroySubmission']);
        Route::get('/{assignment}/submissions/{submission}/download', [AssignmentController::class, 'downloadSubmission']);
    });

    // Instructor Submissions Routes
    Route::middleware('auth:sanctum')->prefix('instructor')->group(function () {
        Route::prefix('assignments/{assignment}/submissions')->group(function () {
            Route::get('/', [SubmissionController::class, 'index']);
            Route::get('/{submission}', [SubmissionController::class, 'show']);
            Route::post('/{submission}', [SubmissionController::class, 'update']);
        });
    });
});


/*
|===========================================
|> Group: Instructor Routes
|===========================================
*/

Route::prefix('instructors')->group(function () {
    Route::get('/', [InstructorController::class, 'index']);
    Route::get('/{instructor_profile_id}', [InstructorController::class, 'show']);
});
