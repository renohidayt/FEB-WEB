<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\NewsController as AdminNewsController;

/*
|--------------------------------------------------------------------------
| News Management Routes
|--------------------------------------------------------------------------
*/

// PENTING: Custom routes HARUS di atas resource route
Route::patch('news/{news}/publish', [AdminNewsController::class, 'publish'])
    ->name('news.publish')
    ->middleware('throttle:60,1');

Route::post('news/bulk-action', [AdminNewsController::class, 'bulkAction'])
    ->name('news.bulk-action')
    ->middleware('throttle:30,1');

// Resource route di bawah
Route::resource('news', AdminNewsController::class)
    ->middleware('throttle:60,1');