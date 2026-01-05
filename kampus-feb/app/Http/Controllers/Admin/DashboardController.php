<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\Event;
use App\Models\User;
use App\Models\Document;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistics
        $stats = [
            // News Stats
            'news' => News::count(),
            'news_published' => News::where('is_published', true)->count(),
            
            // Events Stats
            'events' => Event::count(),
            'events_upcoming' => Event::where('start_date', '>', now())
                                     ->where('status', 'published')
                                     ->count(),
            
            // Users Stats
            'users' => User::count(),
            'users_active' => User::where('is_active', true)->count(),
            
            // Documents Stats
            'documents' => Document::count(),
            'downloads' => Document::sum('downloads') ?? 0,
        ];

        // Recent News (Latest 5 published news)
        $recentNews = News::where('is_published', true)
            ->with('category', 'author')
            ->latest('published_at')
            ->take(5)
            ->get();

        // Upcoming Events (Next 5 events)
        $upcomingEvents = Event::where('start_date', '>', now())
            ->where('status', 'published')
            ->orderBy('start_date', 'asc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentNews', 'upcomingEvents'));
    }
}