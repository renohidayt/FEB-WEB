<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\GoogleAuthController;
use App\Http\Controllers\Frontend\GlobalSearchController;
use App\Http\Controllers\Student\DashboardController as StudentDashboardController;

/*
|--------------------------------------------------------------------------
| Google OAuth Routes
|--------------------------------------------------------------------------
*/
Route::get('auth/google', [GoogleAuthController::class, 'redirect'])->name('auth.google');
Route::get('auth/google/callback', [GoogleAuthController::class, 'callback'])->name('auth.google.callback');
Route::post('logout', [GoogleAuthController::class, 'logout'])->name('logout');
Route::get('/pencarian', [GlobalSearchController::class, 'search'])->name('global.search');


Route::middleware(['auth'])->prefix('student')->name('student.')->group(function () {
    Route::get('/dashboard', [StudentDashboardController::class, 'index'])->name('dashboard');
});
/*
|--------------------------------------------------------------------------
| Frontend Routes (Public Access)
|--------------------------------------------------------------------------
*/
require __DIR__.'/frontend.php';

/*
|--------------------------------------------------------------------------
| Student Routes (Authenticated Users)
|--------------------------------------------------------------------------
*/
require __DIR__.'/student.php';          // Route mahasiswa /letters dll
require __DIR__.'/student-auth.php'; 
/*
|--------------------------------------------------------------------------
| Admin Routes (Protected - Admin Only)
|--------------------------------------------------------------------------
*/
require __DIR__.'/admin.php';

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';

