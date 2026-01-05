<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ScholarshipController as AdminScholarshipController;

/*
|--------------------------------------------------------------------------
| Scholarships Management Routes
|--------------------------------------------------------------------------
*/

Route::prefix('scholarships')->name('scholarships.')->group(function () {
    
    Route::get('/', [AdminScholarshipController::class, 'index'])
        ->name('index')
        ->middleware('throttle:60,1');
    
    Route::get('/create', [AdminScholarshipController::class, 'create'])
        ->name('create')
        ->middleware('throttle:60,1');
    
    Route::post('/', [AdminScholarshipController::class, 'store'])
        ->name('store')
        ->middleware('throttle:10,1');
    
    Route::get('/{scholarship}/edit', [AdminScholarshipController::class, 'edit'])
        ->name('edit')
        ->middleware('throttle:60,1');
    
    Route::match(['put', 'patch'], '/{scholarship}', [AdminScholarshipController::class, 'update'])
        ->name('update')
        ->middleware('throttle:10,1');
    
    Route::delete('/{scholarship}', [AdminScholarshipController::class, 'destroy'])
        ->name('destroy')
        ->middleware('throttle:20,1');
    
    Route::patch('/{scholarship}/toggle-active', [AdminScholarshipController::class, 'toggleActive'])
        ->name('toggle-active')
        ->middleware('throttle:30,1');
    
    Route::patch('/{scholarship}/toggle-featured', [AdminScholarshipController::class, 'toggleFeatured'])
        ->name('toggle-featured')
        ->middleware('throttle:30,1');
    
    Route::get('/{scholarship}', [AdminScholarshipController::class, 'show'])
        ->name('show')
        ->middleware('throttle:60,1');
});