<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Facility;
use App\Models\Lecturer;
use App\Models\Gallery;
use App\Models\RectorProfile;
use App\Models\Scholarship;

class HomeController extends Controller
{
    public function index()
    {
        $featured_news = News::where('show_on_homepage', true)
            ->where('is_published', true)
            ->latest()
            ->take(5)
            ->get();

        $latest_news = News::where('is_published', true)
            ->latest()
            ->take(8)
            ->get();

        $facilities = Facility::latest()->take(6)->get();

        $lecturers = Lecturer::where('is_visible', 1)
            ->latest()
            ->take(6)
            ->get();

        $gallery = Gallery::latest()->take(8)->get();

        $rector_profile = RectorProfile::first();

        // 🆕 New: Beasiswa yang masih aktif (optional filter)
        $active_scholarships = Scholarship::where('is_active', 1)
            ->latest()
            ->take(6)
            ->get();

        return view('frontend.home', compact(
            'featured_news',
            'latest_news',
            'facilities',
            'lecturers',
            'gallery',
            'rector_profile',
            'active_scholarships'
        ));
    }
}
