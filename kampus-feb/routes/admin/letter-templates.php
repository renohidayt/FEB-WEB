<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\LetterTemplateController;

/*
|--------------------------------------------------------------------------
| Letter Templates Management Routes
|--------------------------------------------------------------------------
*/

Route::resource('letter-templates', LetterTemplateController::class)
    ->middleware('throttle:60,1');