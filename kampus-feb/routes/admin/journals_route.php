<?php

use App\Http\Controllers\Admin\JournalController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Journal Management Routes
|--------------------------------------------------------------------------
| Routes untuk mengelola jurnal ilmiah
*/

Route::resource('journals', JournalController::class);

// Additional routes
Route::post('journals/{journal}/toggle-visibility', [JournalController::class, 'toggleVisibility'])
    ->name('journals.toggle-visibility');