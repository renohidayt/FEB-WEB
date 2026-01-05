<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Display listing of events (public view)
     */
    public function index(Request $request)
    {
        $query = Event::where('status', 'published');

        // Filter by status (upcoming/past/ongoing)
        if ($request->filled('filter')) {
            if ($request->filter === 'upcoming') {
                $query->upcoming();
            } elseif ($request->filter === 'past') {
                $query->past();
            } elseif ($request->filter === 'ongoing') {
                $today = now()->toDateString();
                $query->where('start_date', '<=', $today)
                      ->where('end_date', '>=', $today);
            }
        } else {
            // Default: show all published events, sorted by date
            $query->orderBy('start_date', 'desc');
        }

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('organizer', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%");
            });
        }

        $events = $query->paginate(12);

        // Get upcoming events for highlight
        $upcomingEvents = Event::upcoming()->limit(3)->get();

        // Get ongoing events
        $ongoingEvents = Event::where('status', 'published')
            ->where('start_date', '<=', now()->toDateString())
            ->where('end_date', '>=', now()->toDateString())
            ->get();

        // Statistics
        $stats = [
            'total' => Event::where('status', 'published')->count(),
            'upcoming' => Event::upcoming()->count(),
            'ongoing' => Event::where('status', 'published')
                ->where('start_date', '<=', now()->toDateString())
                ->where('end_date', '>=', now()->toDateString())
                ->count(),
            'past' => Event::past()->count(),
        ];

        return view('frontend.events.index', compact(
            'events', 
            'upcomingEvents',
            'ongoingEvents',
            'stats'
        ));
    }

    /**
     * Display event detail
     */
    public function show($slug)
    {
        $event = Event::where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        // Get related events (same organizer or upcoming)
        $relatedEvents = Event::where('status', 'published')
            ->where(function($q) use ($event) {
                $q->where('organizer', $event->organizer)
                  ->orWhere('start_date', '>=', now()->toDateString());
            })
            ->where('id', '!=', $event->id)
            ->limit(3)
            ->get();

        return view('frontend.events.show', compact('event', 'relatedEvents'));
    }

    public function getByDate(Request $request)
{
    try {
        $date = $request->input('date', now()->format('Y-m-d'));
        
        // Query dengan filter status published
        $events = Event::where('status', 'published')
            ->whereDate('start_date', $date)
            ->orderBy('start_time', 'asc')
            ->get();
        
        // Log untuk debugging
        \Log::info('Events query', [
            'date' => $date,
            'count' => $events->count(),
            'events' => $events->pluck('id', 'title')
        ]);
        
        // Jika tidak ada events
        if ($events->isEmpty()) {
            return response()->json([
                'success' => false,
                'html' => $this->getEmptyStateHtml(),
                'count' => 0,
                'date' => $date
            ]);
        }
        
        $html = view('frontend.home.partials.events-list', compact('events'))->render();
        
        return response()->json([
            'success' => true,
            'html' => $html,
            'count' => $events->count(),
            'date' => $date
        ]);
        
    } catch (\Exception $e) {
        \Log::error('Error fetching events by date: ' . $e->getMessage());
        
        return response()->json([
            'success' => false,
            'message' => 'Terjadi kesalahan saat memuat event',
            'error' => $e->getMessage()
        ], 500);
    }
}
    
    /**
     * Get empty state HTML
     */
    private function getEmptyStateHtml()
    {
        return '
            <div class="p-12 text-center">
                <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-calendar-times text-3xl text-gray-400"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">Tidak Ada Event</h3>
                <p class="text-gray-600">Tidak ada event pada tanggal ini</p>
            </div>
        ';
    }

}