<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\LetterSubmissionController as AdminLetterSubmissionController;

/*
|--------------------------------------------------------------------------
| Letter Submissions Management Routes
|--------------------------------------------------------------------------
*/

Route::resource('letter-submissions', AdminLetterSubmissionController::class)
    ->except(['create', 'store', 'edit', 'update'])
    ->parameters(['letter-submissions' => 'letterSubmission'])
    ->middleware('throttle:60,1');

Route::post('letter-submissions/{letterSubmission}/approve', [AdminLetterSubmissionController::class, 'approve'])
    ->name('letter-submissions.approve')
    ->middleware('throttle:30,1');