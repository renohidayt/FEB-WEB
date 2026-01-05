<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\FacilityController as AdminFacilityController;

/*
|--------------------------------------------------------------------------
| Facilities Management Routes
|--------------------------------------------------------------------------
*/

Route::resource('facilities', AdminFacilityController::class)
    ->middleware('throttle:60,1');

Route::delete('facilities/photos/{photo}', [AdminFacilityController::class, 'deletePhoto'])
    ->name('facilities.photos.delete')
    ->middleware('throttle:30,1');