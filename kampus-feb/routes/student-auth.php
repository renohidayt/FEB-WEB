<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\StudentAuthController;

/*
|--------------------------------------------------------------------------
| Student Authentication Routes
|--------------------------------------------------------------------------
*/

// Student Login (Guest)
Route::middleware('guest')->group(function () {
    Route::get('student/login', [StudentAuthController::class, 'showLoginForm'])
        ->name('student.login');
    
    Route::post('student/login', [StudentAuthController::class, 'login'])
        ->name('student.login.post');
});

// Student Logout (Auth)
Route::middleware('auth')->post('student/logout', [StudentAuthController::class, 'logout'])
    ->name('student.logout');
