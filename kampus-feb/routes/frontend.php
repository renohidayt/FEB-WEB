<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\NewsController;
use App\Http\Controllers\Frontend\LecturerController;
use App\Http\Controllers\Frontend\ScholarshipController as FrontendScholarshipController;
use App\Http\Controllers\Frontend\GalleryController as FrontendGalleryController;
use App\Http\Controllers\Frontend\OrganizationalStructureController as FrontendOrgController;
use App\Http\Controllers\Frontend\EventController;
use App\Http\Controllers\Frontend\ProfileController as FrontendProfile;
use App\Http\Controllers\Frontend\FrontendAccreditationController;
use App\Http\Controllers\Frontend\FacilityController as FrontendFacility;
use App\Http\Controllers\Frontend\AcademicController;
use App\Http\Controllers\Admin\AcademicFileController;
use App\Http\Controllers\Frontend\JournalController;
use App\Http\Controllers\Frontend\DocumentController as FrontendDocumentController;


/*
|--------------------------------------------------------------------------
| Homepage
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');

/*
|--------------------------------------------------------------------------
| Static Pages
|--------------------------------------------------------------------------
*/
Route::get('/kontak', function () {
    return view('frontend.contact');
})->name('contact');

Route::get('/program-studi', function () {
    return view('frontend.study-programs.index');
})->name('study-programs.index');

/*
|--------------------------------------------------------------------------
| News Routes
|--------------------------------------------------------------------------
*/
Route::prefix('news')->name('news.')->group(function () {
    Route::get('/', [NewsController::class, 'index'])->name('index');
    Route::get('/archive', [NewsController::class, 'archive'])->name('archive');
    Route::get('/category/{category:slug}', [NewsController::class, 'category'])->name('category');
    Route::get('/{slug}', [NewsController::class, 'show'])->name('show');
});

/*
|--------------------------------------------------------------------------
| Lecturers Routes
|--------------------------------------------------------------------------
*/
Route::get('/dosen', [LecturerController::class, 'index'])->name('lecturers.index');
Route::get('/dosen/{slug}', [LecturerController::class, 'show'])->name('lecturers.show');

/*
|--------------------------------------------------------------------------
| Academic Routes
|--------------------------------------------------------------------------
*/
Route::get('/kalender-akademik', [AcademicFileController::class, 'kalender'])
    ->name('kalender-akademik');

Route::get('/jadwal-perkuliahan', [AcademicFileController::class, 'jadwal'])
    ->name('jadwal-perkuliahan');

Route::get('/academic-files/{id}/download', [AcademicFileController::class, 'download'])
    ->name('academic-files.download');

Route::prefix('academic')->group(function () {
    Route::get('schedule', [AcademicController::class, 'schedule'])->name('academic.schedule');
    Route::get('calendar', [AcademicController::class, 'calendar'])->name('academic.calendar');
});

/*
|--------------------------------------------------------------------------
| Facilities Routes
|--------------------------------------------------------------------------
*/
Route::prefix('fasilitas')->name('facilities.')->group(function () {
    Route::get('/', [FrontendFacility::class, 'index'])->name('index');
    Route::get('/{id}', [FrontendFacility::class, 'show'])->name('show');
    Route::get('/api/{id}', [FrontendFacility::class, 'getFacilityData'])->name('data');
});

/*
|--------------------------------------------------------------------------
| Organizational Structure
|--------------------------------------------------------------------------
*/
Route::get('/organizational-structure', [FrontendOrgController::class, 'index'])
    ->name('organizational-structure');

/*
|--------------------------------------------------------------------------
| Events Routes
|--------------------------------------------------------------------------
*/
Route::prefix('events')->name('events.')->group(function () {
    Route::get('/', [EventController::class, 'index'])->name('index');
    Route::get('/calendar', [EventController::class, 'calendar'])->name('calendar');
    Route::get('/{event:slug}', [EventController::class, 'show'])->name('show');
});

Route::get('/api/events/by-date', [EventController::class, 'getByDate']);

/*
|--------------------------------------------------------------------------
| Scholarships Routes
|--------------------------------------------------------------------------
*/
Route::get('/beasiswa', [FrontendScholarshipController::class, 'index'])->name('scholarships.index');
Route::get('/beasiswa/{scholarship}', [FrontendScholarshipController::class, 'show'])->name('scholarships.show');

/*
|--------------------------------------------------------------------------
| Profile Routes
|--------------------------------------------------------------------------
*/
Route::prefix('profil')->name('profile.')->group(function () {
    Route::get('/sejarah', [FrontendProfile::class, 'sejarah'])->name('history');
    Route::get('/sambutan-dekan', [FrontendProfile::class, 'deanGreeting'])->name('dean');
    Route::get('/visi-misi', [FrontendProfile::class, 'visiMisi'])->name('visi-misi');
    Route::get('/keunggulan-kompetitif', [FrontendProfile::class, 'keunggulanKompetitif'])
    ->name('keunggulan');

    Route::get('/struktur-organisasi', [FrontendProfile::class, 'strukturOrganisasi'])->name('struktur');
    Route::get('/sarana-prasarana', [FrontendProfile::class, 'saranaPrasarana'])->name('sarana');
    Route::get('/kemahasiswaan', [FrontendProfile::class, 'kemahasiswaan'])->name('kemahasiswaan');

    // Accreditation Routes
    Route::prefix('akreditasi')->name('accreditation.')->group(function () {
        Route::get('/', [FrontendAccreditationController::class, 'index'])->name('index');
        Route::get('/perguruan-tinggi', [FrontendAccreditationController::class, 'institution'])->name('institution');
        Route::get('/program-studi', [FrontendAccreditationController::class, 'programs'])->name('programs');
        Route::get('/riwayat', [FrontendAccreditationController::class, 'history'])->name('history');
        Route::get('/download/{accreditation:slug}', [FrontendAccreditationController::class, 'download'])->name('download');
    });
});

/*
|--------------------------------------------------------------------------
| Gallery Routes
|--------------------------------------------------------------------------
*/
Route::get('/galeri', [FrontendGalleryController::class, 'index'])->name('galleries.index');
Route::get('/galeri/{slug}', [FrontendGalleryController::class, 'show'])->name('galleries.show');
Route::get('/media', [FrontendGalleryController::class, 'allMedia'])->name('galleries.all-media');

/*
|--------------------------------------------------------------------------
| Frontend Journal Routes (Public)
|--------------------------------------------------------------------------
*/

Route::get('/journals', [JournalController::class, 'index'])->name('journals.index');
Route::get('/journals/{slug}', [JournalController::class, 'show'])->name('journals.show');

/*
|--------------------------------------------------------------------------
| Documents Routes (Frontend - Public)
|--------------------------------------------------------------------------
*/

Route::prefix('dokumen')->name('documents.')->group(function () {
    Route::get('/', [FrontendDocumentController::class, 'index'])->name('index');
    Route::get('/{document}/download', [FrontendDocumentController::class, 'download'])->name('download');
});

/*
|--------------------------------------------------------------------------
| Legal Pages Routes (Public)
|--------------------------------------------------------------------------
*/

Route::get('/privacy-policy', function () {
    return view('legal.privacy-policy');
})->name('privacy.policy');

Route::get('/terms-of-service', function () {
    return view('legal.terms-of-service');
})->name('terms.service');