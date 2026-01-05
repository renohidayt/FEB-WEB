<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AlbumController;
use App\Http\Controllers\Admin\GalleryController as AdminGalleryController;

/*
|--------------------------------------------------------------------------
| Gallery & Albums Management Routes
|--------------------------------------------------------------------------
*/

// Albums
Route::resource('albums', AlbumController::class)
    ->middleware('throttle:60,1');

Route::get('albums/{album}/media', [AlbumController::class, 'mediaIndex'])
    ->name('albums.media.index')
    ->middleware('throttle:60,1');

Route::post('albums/{album}/media/upload', [AlbumController::class, 'uploadMedia'])
    ->name('albums.media.upload')
    ->middleware('throttle:20,1');

Route::delete('albums/{album}/media/{media}', [AlbumController::class, 'destroyMedia'])
    ->name('albums.media.destroy')
    ->middleware('throttle:30,1');

Route::patch('albums/{album}/toggle-publish', [AlbumController::class, 'togglePublish'])
    ->name('albums.toggle-publish');

// Galleries
Route::resource('galleries', AdminGalleryController::class)
    ->except(['edit', 'update', 'show'])
    ->middleware('throttle:60,1');