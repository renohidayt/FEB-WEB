<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\HeroSliderController;

/*
|--------------------------------------------------------------------------
| Hero Sliders Management Routes
|--------------------------------------------------------------------------
*/

Route::resource('hero-sliders', HeroSliderController::class);

Route::post('hero-sliders/update-order', [HeroSliderController::class, 'updateOrder'])
    ->name('hero-sliders.update-order');