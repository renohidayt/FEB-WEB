<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\LetterSubmissionController;

/*
|--------------------------------------------------------------------------
| Letter Submission Routes
|--------------------------------------------------------------------------
| Index: PUBLIC (everyone can view)
| Create/Store/Actions: AUTH REQUIRED
*/

// ✅ PUBLIC Routes (No auth required)
Route::prefix('letters')->name('letters.')->group(function () {
    // View templates (PUBLIC)
    Route::get('/', [LetterSubmissionController::class, 'index'])->name('index');
});

// ✅ AUTHENTICATED Routes (Login required)
Route::prefix('letters')->name('letters.')->middleware('auth')->group(function () {
    // Create new submission
    Route::get('/create/{template}', [LetterSubmissionController::class, 'create'])->name('create');
    Route::post('/', [LetterSubmissionController::class, 'store'])->name('store');
    
    // View own submission
    Route::get('/{submission}', [LetterSubmissionController::class, 'show'])->name('show');
    
    // Actions
    Route::post('/{submission}/cancel', [LetterSubmissionController::class, 'cancel'])->name('cancel');
    Route::get('/{submission}/download', [LetterSubmissionController::class, 'download'])->name('download');
    Route::get('/{submission}/attachment/{index}', [LetterSubmissionController::class, 'downloadAttachment'])->name('attachment.download');
});