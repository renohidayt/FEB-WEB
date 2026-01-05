<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\News;
use App\Models\Lecturer;
use App\Models\Event;
use App\Models\Journal;

class GlobalSearchController extends Controller
{
    public function search(Request $request)
    {
        $keyword = $request->input('search');

        // Validasi input kosong
        if (empty($keyword)) {
            return redirect()->back();
        }

        // 1. Cari Berita (Copy logika dari NewsController)
        $news = News::published()
            ->where(function($q) use ($keyword) {
                $q->where('title', 'like', "%{$keyword}%")
                  ->orWhere('content', 'like', "%{$keyword}%")
                  ->orWhere('excerpt', 'like', "%{$keyword}%");
            })
            ->latest('published_at')
            ->take(5) // Ambil 5 teratas saja agar halaman tidak kepanjangan
            ->get();

        // 2. Cari Dosen (Copy logika dari LecturerController)
        $lecturers = Lecturer::visible()->active()
            ->where(function($q) use ($keyword) {
                $q->where('name', 'like', "%{$keyword}%")
                  ->orWhere('expertise', 'like', "%{$keyword}%")
                  ->orWhere('position', 'like', "%{$keyword}%")
                  ->orWhere('nidn', 'like', "%{$keyword}%");
            })
            ->take(6)
            ->get();

        // 3. Cari Event (Copy logika dari EventController)
        $events = Event::where('status', 'published')
            ->where(function($q) use ($keyword) {
                $q->where('title', 'like', "%{$keyword}%")
                  ->orWhere('description', 'like', "%{$keyword}%")
                  ->orWhere('location', 'like', "%{$keyword}%");
            })
            ->orderBy('start_date', 'desc')
            ->take(4)
            ->get();

        // 4. Cari Jurnal (Copy logika dari JournalController)
        $journals = Journal::visible()->active()
            ->where(function($q) use ($keyword) {
                $q->where('name', 'like', "%{$keyword}%")
                  ->orWhere('field', 'like', "%{$keyword}%");
            })
            ->take(4)
            ->get();

        return view('frontend.global-search', compact(
            'keyword', 'news', 'lecturers', 'events', 'journals'
        ));
    }
}