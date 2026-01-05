<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Journal;
use Illuminate\Http\Request;

class JournalController extends Controller
{
    /**
     * Display listing of journals (public view)
     */
    public function index(Request $request)
    {
        $query = Journal::visible()->active()->latest();

        // Filter by manager
        if ($request->filled('manager')) {
            $query->where('manager', $request->manager);
        }

        // Filter by accreditation
        if ($request->filled('accreditation')) {
            $query->where('accreditation_status', $request->accreditation);
        }

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('field', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $journals = $query->paginate(12);

        // Get unique managers for filter
        $managers = Journal::visible()
            ->active()
            ->distinct()
            ->pluck('manager')
            ->filter()
            ->sort()
            ->values();

        // Get accreditation statuses
        $accreditationStatuses = Journal::accreditationStatuses();

        return view('frontend.journals.index', compact('journals', 'managers', 'accreditationStatuses'));
    }

    /**
     * Display journal detail
     */
    public function show($slug)
    {
        $journal = Journal::visible()
            ->active()
            ->where('slug', $slug)
            ->firstOrFail();

        // Increment view count
        $journal->incrementViews();

        // Get related journals
        $relatedJournals = Journal::visible()
            ->active()
            ->where('manager', $journal->manager)
            ->where('id', '!=', $journal->id)
            ->limit(3)
            ->get();

        return view('frontend.journals.show', compact('journal', 'relatedJournals'));
    }
}