<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;

/*
|--------------------------------------------------------------------------
| User Management Routes
|--------------------------------------------------------------------------
*/

Route::prefix('users')->name('users.')->group(function () {
    
    Route::get('/', [UserController::class, 'index'])
        ->name('index')
        ->middleware('throttle:60,1');
    
    Route::get('/create', [UserController::class, 'create'])
        ->name('create')
        ->middleware('throttle:60,1');
    
    Route::post('/', [UserController::class, 'store'])
        ->name('store')
        ->middleware('throttle:10,1');
    
    Route::get('/{user}/edit', [UserController::class, 'edit'])
        ->name('edit')
        ->middleware('throttle:60,1');
    
    Route::match(['put', 'patch'], '/{user}', [UserController::class, 'update'])
        ->name('update')
        ->middleware('throttle:10,1');
    
    Route::delete('/{user}', [UserController::class, 'destroy'])
        ->name('destroy')
        ->middleware('throttle:20,1');
    
    Route::post('/{user}/toggle-status', [UserController::class, 'toggleStatus'])
        ->name('toggle-status')
        ->middleware('throttle:30,1');
});