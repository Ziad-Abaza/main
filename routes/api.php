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
use App\Http\Controllers\Api\Lms\AssignmentController;
use App\Http\Controllers\Api\General\CategoryController;
use App\Http\Controllers\Api\Instructor\SubmissionController;
use App\Http\Controllers\Api\Lms\CourseQuizController;
use App\Http\Controllers\Api\General\FaqController as ApiFaqController;
use App\Http\Controllers\Api\General\BlogController as ApiBlogController;
use App\Http\Controllers\Api\General\ContactController as ApiContactController;
use App\Http\Controllers\Api\User\OverviewController;
use App\Http\Controllers\Api\User\SettingsController;
use App\Http\Controllers\Api\General\NewsController;
use App\Http\Controllers\Payment\PaymentController;

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
        Route::get('/user', [AuthController::class, 'user']);
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

Route::prefix('news')->group(function () {
    Route::get('/', [NewsController::class, 'index']);
    Route::get('/{news}', [NewsController::class, 'show']);
});


/*
|===========================================
|> Payment Routes
|===========================================
*/

Route::post('/payment/process', [PaymentController::class, 'paymentProcess']);
Route::match(['GET', 'POST'], '/payment/callback', [PaymentController::class, 'callBack']);



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
    // Course-level Quizzes (New LMS Routes)
    Route::prefix('lms/quizzes')->group(function () {
        Route::get('/course/{courseId}', [CourseQuizController::class, 'index']);
        Route::get('/{quiz}', [CourseQuizController::class, 'show']);
        Route::post('/{quiz}/submit', [CourseQuizController::class, 'submit']);
        Route::get('/{quiz}/results', [CourseQuizController::class, 'results']);
    });
    // Route::get('/', [CourseQuizController::class, 'index']);
    // Route::get('/all', [CourseQuizController::class, 'index']);
    // Route::get('/course/{courseId}', [CourseQuizController::class, 'showQuizForCourse']);
    // Route::post('/course/{courseId}', [CourseQuizController::class, 'submitQuizAnswers']);
    // Route::get('/course/{courseId}/quiz-results', [CourseQuizController::class, 'getQuizResults']);
    // Route::post('/{quizId}/submit', [CourseQuizController::class, 'submitQuizById']);
    // Route::get('/{quizId}', [CourseQuizController::class, 'show']);

    // User Progress Routes
    Route::prefix('progress')->group(function () {
        Route::get('/enrolled-courses', [ProgressController::class, 'enrolledCourses']);
        Route::get('/courses/{course}/progress', [ProgressController::class, 'courseProgress']);
        Route::post('
        /videos/{video}/complete', [ProgressController::class, 'markVideoComplete']);
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

    // Overview (Dashboard) Stats Routes
    Route::prefix('overview')->group(function () {
        Route::get('/courses-stats', [OverviewController::class, 'coursesStats']);
        Route::get('/assignments-stats', [OverviewController::class, 'assignmentsStats']);
        Route::get('/graph-data', [OverviewController::class, 'graphData']);
    });

    // User Settings Route
    Route::patch('/user/settings', [SettingsController::class, 'update']);
    Route::post('/user/settings', [SettingsController::class, 'update']);
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

// FAQ API
Route::get('/faqs', [ApiFaqController::class, 'index']);
Route::get('/faqs/{faq}', [ApiFaqController::class, 'show']);

// Blog API
Route::get('/blogs', [ApiBlogController::class, 'index']);
Route::get('/blogs/{blog}', [ApiBlogController::class, 'show']);

// Contact API
Route::post('/contact', [ApiContactController::class, 'store']);
