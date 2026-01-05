<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Lecturer;
use Illuminate\Http\Request;

class LecturerController extends Controller
{
    /**
     * Display listing of lecturers (public view)
     */
    public function index(Request $request)
    {
        $query = Lecturer::visible()->active()->latest();

        // Filter by study program
        if ($request->filled('study_program')) {
            $query->byProgram($request->study_program);
        }

        // Filter by employment status
        if ($request->filled('employment_status')) {
            $query->byEmploymentStatus($request->employment_status);
        }

        // Filter by academic degree
        if ($request->filled('academic_degree')) {
            $query->where('academic_degree', $request->academic_degree);
        }

        // Search functionality (expanded to include new fields)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('expertise', 'like', "%{$search}%")
                  ->orWhere('position', 'like', "%{$search}%")
                  ->orWhere('research_interests', 'like', "%{$search}%")
                  ->orWhere('nidn', 'like', "%{$search}%")
                  ->orWhere('courses_taught', 'like', "%{$search}%");
            });
        }

        $lecturers = $query->paginate(12);

        // Get unique study programs for filter
        $studyPrograms = [
            'Akuntansi',
            'Manajemen',
            'Magister Manajemen',
        ];

        // Get academic degrees for filter
        $academicDegrees = Lecturer::academicDegrees();

        // Get employment statuses for filter
        $employmentStatuses = Lecturer::employmentStatuses();

        return view('frontend.lecturers.index', compact(
            'lecturers', 
            'studyPrograms', 
            'academicDegrees',
            'employmentStatuses'
        ));
    }

    /**
     * Display lecturer detail with comprehensive information
     */
    public function show($slug)
    {
        $lecturer = Lecturer::visible()
            ->active()
            ->where('slug', $slug)
            ->firstOrFail();

        // Increment profile views
        $lecturer->incrementViews();

        // Get related lecturers from same program
        $relatedLecturers = Lecturer::visible()
            ->active()
            ->where('study_program', $lecturer->study_program)
            ->where('id', '!=', $lecturer->id)
            ->limit(4)
            ->get();

        // Parse publications for better display
        $publications = $this->parseTextToArray($lecturer->publications);
        $conferencePapers = $this->parseTextToArray($lecturer->conference_papers);
        $books = $this->parseTextToArray($lecturer->books_hki);
        $communityServices = $this->parseTextToArray($lecturer->community_service);
        $certifications = $this->parseTextToArray($lecturer->certifications);
        $awards = $this->parseTextToArray($lecturer->awards);

        return view('frontend.lecturers.show', compact(
            'lecturer', 
            'relatedLecturers',
            'publications',
            'conferencePapers',
            'books',
            'communityServices',
            'certifications',
            'awards'
        ));
    }

    /**
     * Helper function to parse text into array (by newline)
     */
    private function parseTextToArray($text)
    {
        if (empty($text)) {
            return [];
        }
        
        return array_filter(
            array_map('trim', explode("\n", $text)),
            function($item) {
                return !empty($item);
            }
        );
    }

    /**
     * Export lecturer CV/profile as PDF (optional feature)
     */
    public function exportPdf($slug)
    {
        $lecturer = Lecturer::visible()
            ->active()
            ->where('slug', $slug)
            ->firstOrFail();

        // This would require a PDF library like DomPDF or similar
        // Implementation depends on your requirements
        
        return view('frontend.lecturers.pdf', compact('lecturer'));
    }
}