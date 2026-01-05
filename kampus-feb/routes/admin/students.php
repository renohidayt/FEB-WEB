<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\StudentController;

/*
|--------------------------------------------------------------------------
| Student Management Routes (Admin Only)
|--------------------------------------------------------------------------
*/

Route::resource('students', StudentController::class);

Route::get('students-import', [StudentController::class, 'importForm'])
    ->name('students.import-form');

Route::post('students-import', [StudentController::class, 'import'])
    ->name('students.import');

Route::get('students/template/download', [StudentController::class, 'downloadTemplate'])
    ->name('students.download-template');
