<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\Profile;
use App\Models\Scholarship;
use App\Models\Lecturer;
use App\Models\Event;
use Illuminate\Http\Request;
use App\Models\HeroSlider;


class HomeController extends Controller
{
    public function index()
    {
        // 1. Ambil Hero Slider
        $heroSliders = HeroSlider::active()->ordered()->get();

        // 2. Berita terbaru
        $latest_news = News::published()
            ->with('category')
            ->latest('published_at')
            ->take(6)
            ->get();

        // 3. Berita unggulan untuk homepage
        $featured_news = News::published()
            ->where('show_on_homepage', true)
            ->with('category')
            ->latest('published_at')
            ->take(4)
            ->get();

        // 4. Profile Rektor
        $rector_profile = Profile::where('type', 'rektor')->first();
        
        // 5. Profile Dekan/Wakil Dekan untuk Sambutan
        $dean_profile = Profile::whereIn('type', ['kemahasiswaan', 'dekan'])
            ->first();
        
        // 6. Beasiswa aktif
        $active_scholarships = Scholarship::active()
            ->latest()
            ->take(3)
            ->get();

        // 7. Dosen yang ditampilkan
        $lecturers = Lecturer::where('is_active', true)
            ->where('is_visible', true)
            ->latest()
            ->take(10)
            ->get();

        // 8. Event
        $events = Event::where('status', 'published')
            ->whereDate('start_date', '>=', now()->subMonths(6)) 
            ->whereDate('start_date', '<=', now()->addYear())
            ->orderBy('start_date', 'asc')
            ->get();

        // ✅ Return view dilakukan SATU KALI SAJA di akhir
        // Pastikan nama view konsisten (misal: 'frontend.home.home' atau 'frontend.home')
        return view('frontend.home.home', compact(
            'heroSliders',       // Jangan lupa tambahkan ini
            'latest_news',
            'featured_news',
            'rector_profile',
            'dean_profile',
            'active_scholarships',
            'lecturers',
            'events'
        ));
    }
}