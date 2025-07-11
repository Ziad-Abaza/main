<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->api(prepend: [
            \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
        ]);

        $middleware->alias([
            'verified' => \App\Http\Middleware\EnsureEmailIsVerified::class,
            'panel.access' => \App\Http\Middleware\CheckPanelAccess::class,
            'auth' => \App\Http\Middleware\Authenticate::class,
            'login.throttle' => \App\Http\Middleware\ThrottleLoginAttempts::class,
            'course.enrolled' => \App\Http\Middleware\EnsureUserEnrolledInCourse::class,
    ]);


    })
    // ->withSchedule(function (\Illuminate\Console\Scheduling\Schedule $schedule) {
    //     $schedule->command('absences:delete-old-exported')
    //         ->daily()
    //         ->withoutOverlapping();
    // })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();


