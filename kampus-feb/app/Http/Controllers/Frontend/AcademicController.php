<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\AcademicFile;
use App\Models\AcademicCalendar;

class AcademicController extends Controller
{
    // Menampilkan jadwal perkuliahan (AcademicFile tipe 'jadwal')
    public function schedule()
    {
        $schedules = AcademicFile::active()->jadwal()->orderBy('created_at', 'desc')->get();
        return view('frontend.academic.schedule', compact('schedules'));
    }

    // Menampilkan kalender akademik (bisa dari AcademicCalendar atau AcademicFile tipe 'kalender')
    public function calendar()
{
    // Mengambil data kalender dari AcademicFile
    $calendars = AcademicFile::active()->kalender()->orderBy('created_at', 'desc')->get();

    return view('frontend.academic.calendar', compact('calendars'));
}

}
