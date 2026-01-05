<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes (Protected - Admin Only)
|--------------------------------------------------------------------------
| Semua route admin memerlukan autentikasi dan role admin
*/

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
   

    // Student Management Routes
    require __DIR__.'/admin/students.php';
    
    // Dashboard
    require __DIR__.'/admin/dashboard.php';
 
    /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    */
    require __DIR__.'/admin/dashboard.php';
    
    /*
    |--------------------------------------------------------------------------
    | User Management
    |--------------------------------------------------------------------------
    */
    require __DIR__.'/admin/users.php';
    
    /*
    |--------------------------------------------------------------------------
    | Content Management
    |--------------------------------------------------------------------------
    */
    require __DIR__.'/admin/news.php';
    require __DIR__.'/admin/categories.php';
    require __DIR__.'/admin/events.php';
    require __DIR__.'/admin/galleries.php';
    require __DIR__.'/admin/documents.php';
    
    /*
    |--------------------------------------------------------------------------
    | Academic Management
    |--------------------------------------------------------------------------
    */
    require __DIR__.'/admin/lecturers.php';
    require __DIR__.'/admin/journals_route.php';
    require __DIR__.'/admin/scholarships.php';
    require __DIR__.'/admin/academic-files.php';
    
    /*
    |--------------------------------------------------------------------------
    | Institution Management
    |--------------------------------------------------------------------------
    */
    require __DIR__.'/admin/profiles.php';
    require __DIR__.'/admin/facilities.php';
    require __DIR__.'/admin/accreditations.php';
    require __DIR__.'/admin/organizational-structures.php';
    
    /*
    |--------------------------------------------------------------------------
    | Letter Management
    |--------------------------------------------------------------------------
    */
    require __DIR__.'/admin/letter-templates.php';
    require __DIR__.'/admin/letter-submissions.php';
    
    /*
    |--------------------------------------------------------------------------
    | Hero Slider
    |--------------------------------------------------------------------------
    */
    require __DIR__.'/admin/hero-sliders.php';

    require __DIR__.'/admin/stats.php';

    require __DIR__.'/admin/settings.php';

});