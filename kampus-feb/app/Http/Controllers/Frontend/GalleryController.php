<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Album;
use App\Models\Gallery;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    /**
     * Display listing of albums (public view)
     */
    public function index(Request $request)
    {
        $query = Album::published()
            ->with('media')
            ->withCount(['photos', 'videos']);

        // Filter by type
        if ($request->filled('type')) {
            if ($request->type === 'photos') {
                $query->has('photos');
            } elseif ($request->type === 'videos') {
                $query->has('videos');
            }
        }

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Sort by date
        $query->latest();

        $albums = $query->paginate(12);

        // Get featured albums (latest 3)
        $featuredAlbums = Album::published()
            ->withCount(['photos', 'videos'])
            ->latest()
            ->limit(3)
            ->get();

        // Statistics
        $stats = [
            'total_albums' => Album::published()->count(),
            'total_photos' => Album::published()->withSum('photos', 'id')->get()->sum('photos_count'),
            'total_videos' => Album::published()->withSum('videos', 'id')->get()->sum('videos_count'),
        ];

        return view('frontend.galleries.index', compact(
            'albums',
            'featuredAlbums',
            'stats'
        ));
    }

    /**
     * Display album detail with media
     */
    public function show($slug)
    {
        $album = Album::published()
            ->where('slug', $slug)
            ->with(['media' => function($query) {
                $query->orderBy('order');
            }])
            ->withCount(['photos', 'videos'])
            ->firstOrFail();

        // Get related albums (latest albums)
        $relatedAlbums = Album::published()
            ->where('id', '!=', $album->id)
            ->withCount(['photos', 'videos'])
            ->latest()
            ->limit(3)
            ->get();

        return view('frontend.galleries.show', compact('album', 'relatedAlbums'));
    }

    /**
     * Display all photos (alternative simple gallery view)
     */
    public function allMedia(Request $request)
    {
        $query = Gallery::query();

        // Filter by type
        if ($request->filled('type')) {
            if ($request->type === 'image') {
                $query->images();
            } elseif ($request->type === 'video') {
                $query->videos();
            }
        }

        // Filter by album
        if ($request->filled('album')) {
            $query->byAlbum($request->album);
        }

        $media = $query->latest()->paginate(20);

        // Get unique albums for filter
        $albumNames = Gallery::distinct()
            ->whereNotNull('album')
            ->pluck('album');

        return view('frontend.galleries.all-media', compact('media', 'albumNames'));
    }
}