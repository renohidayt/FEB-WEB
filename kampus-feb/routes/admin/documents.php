<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DocumentController;

Route::get('documents/{document}/download', [DocumentController::class, 'download'])
    ->name('documents.download');

Route::resource('documents', DocumentController::class)
    ->middleware('throttle:60,1');
Route::get('documents/{document}/download', 
    [DocumentController::class, 'download']
)->name('documents.download');