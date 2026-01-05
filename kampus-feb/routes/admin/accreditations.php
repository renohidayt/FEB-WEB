<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AccreditationController;

/*
|--------------------------------------------------------------------------
| Accreditations Management Routes
|--------------------------------------------------------------------------
*/

Route::prefix('accreditations')->name('accreditations.')->group(function () {
    
    Route::get('/', [AccreditationController::class, 'index'])
        ->name('index')
        ->middleware('throttle:60,1');
    
    Route::get('/create', [AccreditationController::class, 'create'])
        ->name('create')
        ->middleware('throttle:60,1');
    
    Route::post('/', [AccreditationController::class, 'store'])
        ->name('store')
        ->middleware('throttle:10,1');
    
    Route::get('/{accreditation}/edit', [AccreditationController::class, 'edit'])
        ->name('edit')
        ->middleware('throttle:60,1');
    
    Route::match(['put', 'patch'], '/{accreditation}', [AccreditationController::class, 'update'])
        ->name('update')
        ->middleware('throttle:10,1');
    
    Route::delete('/{accreditation}', [AccreditationController::class, 'destroy'])
        ->name('destroy')
        ->middleware('throttle:20,1');
    
    Route::get('/{accreditation}/download', [AccreditationController::class, 'download'])
        ->name('download')
        ->middleware('throttle:30,1');
    
    Route::post('/{id}/restore', [AccreditationController::class, 'restore'])
        ->name('restore')
        ->middleware('throttle:20,1');
});