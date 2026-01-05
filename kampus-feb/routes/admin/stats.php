<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\StatController;

/*
|--------------------------------------------------------------------------
| Admin Stats Routes
|--------------------------------------------------------------------------
| CRUD untuk kelola statistik yang tampil di homepage
*/

Route::resource('stats', StatController::class);
Route::post('stats/update-order', [StatController::class, 'updateOrder'])->name('stats.update-order');