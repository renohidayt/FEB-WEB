<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CategoryController;

/*
|--------------------------------------------------------------------------
| Categories Management Routes
|--------------------------------------------------------------------------
*/

Route::resource('categories', CategoryController::class)
    ->except(['show'])
    ->middleware('throttle:60,1');