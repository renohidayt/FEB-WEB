<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Scholarship;
use Illuminate\Http\Request;

class ScholarshipController extends Controller
{
    /**
     * Display listing of scholarships (public view)
     */
    public function index(Request $request)
    {
        $query = Scholarship::active()->latest();

        // Filter by category
        if ($request->filled('category')) {
            $query->byCategory($request->category);
        }

        // Filter by status
        if ($request->filled('status')) {
            if ($request->status === 'open') {
                $query->open();
            } elseif ($request->status === 'upcoming') {
                $query->where('registration_start', '>', now());
            } elseif ($request->status === 'closed') {
                $query->where('registration_end', '<', now());
            }
        }

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('provider', 'like', "%{$search}%");
            });
        }

        $scholarships = $query->paginate(12);

        // Get categories for filter
        $categories = Scholarship::categories();

        // Get featured scholarships
        $featuredScholarships = Scholarship::active()
            ->featured()
            ->limit(3)
            ->get();

        // Statistics
        $stats = [
            'total' => Scholarship::active()->count(),
            'open' => Scholarship::active()->open()->count(),
            'upcoming' => Scholarship::active()->where('registration_start', '>', now())->count(),
        ];

        return view('frontend.scholarships.index', compact(
            'scholarships', 
            'categories', 
            'featuredScholarships',
            'stats'
        ));
    }

    /**
     * Display scholarship detail
     */
    public function show(Scholarship $scholarship)
    {
        // Only show active scholarships
        if (!$scholarship->is_active) {
            abort(404);
        }

        // Increment views
        $scholarship->incrementViews();

        // Get related scholarships (same category)
        $relatedScholarships = Scholarship::active()
            ->byCategory($scholarship->category)
            ->where('id', '!=', $scholarship->id)
            ->limit(3)
            ->get();

        return view('frontend.scholarships.show', compact('scholarship', 'relatedScholarships'));
    }
}