<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AcademicFileController;

/*
|--------------------------------------------------------------------------
| Academic Files Management Routes
|--------------------------------------------------------------------------
*/

Route::resource('academic-files', AcademicFileController::class)
    ->middleware('throttle:60,1');