<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;

/*
|--------------------------------------------------------------------------
| Profiles Management Routes
|--------------------------------------------------------------------------
*/

Route::prefix('profiles')->name('profiles.')->group(function () {
    
    Route::get('/', [AdminProfileController::class, 'index'])
        ->name('index')
        ->middleware('throttle:60,1');
    
    Route::get('/create', [AdminProfileController::class, 'create'])
        ->name('create')
        ->middleware('throttle:60,1');
    
    Route::post('/', [AdminProfileController::class, 'store'])
        ->name('store')
        ->middleware('throttle:10,1');
    
    Route::get('/{profile}/edit', [AdminProfileController::class, 'edit'])
        ->name('edit')
        ->middleware('throttle:60,1');
    
    Route::match(['put', 'patch'], '/{profile}', [AdminProfileController::class, 'update'])
        ->name('update')
        ->middleware('throttle:10,1');
    
    Route::delete('/{profile}', [AdminProfileController::class, 'destroy'])
        ->name('destroy')
        ->middleware('throttle:20,1');
});