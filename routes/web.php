<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\Auth\AuthController;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;


/*
|--------------------------------------------------------------------------
| Web Routes for Dashboard
|--------------------------------------------------------------------------
*/

// accept dashboard routes
Route::get('/{any}', function () {
    return view('welcome');
})->where('any', '^(?!dashboard|console|logout).*');


/*
|===========================================
|> Group: Guest Dashboard Routes
|===========================================
*/

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

require __DIR__ . '/dashboard.php';
require __DIR__ . '/instructor.php';
