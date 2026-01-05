<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\EventController as AdminEventController;

/*
|--------------------------------------------------------------------------
| Events Management Routes
|--------------------------------------------------------------------------
*/

Route::resource('events', AdminEventController::class)
    ->middleware('throttle:60,1');