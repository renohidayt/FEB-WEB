<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\LecturerController as AdminLecturerController;

/*
|--------------------------------------------------------------------------
| Lecturers Management Routes
|--------------------------------------------------------------------------
*/

Route::resource('lecturers', AdminLecturerController::class)
    ->middleware('throttle:60,1');