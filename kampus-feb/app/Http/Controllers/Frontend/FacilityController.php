<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Facility;
use Illuminate\Http\Request;

class FacilityController extends Controller
{
    /**
     * Display listing of facilities for public
     */
    public function index(Request $request)
    {
        $query = Facility::with('photos')
            ->where('is_active', true)
            ->latest();

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Paginate with photos relationship
        $facilities = $query->paginate(12);

        return view('frontend.facilities.index', compact('facilities'));
    }

    /**
     * Show single facility detail (optional - bisa pakai modal atau dedicated page)
     */
    public function show($id)
    {
        $facility = Facility::with('photos')
            ->where('is_active', true)
            ->findOrFail($id);

        return view('frontend.facilities.show', compact('facility'));
    }

    /**
     * Get facility data as JSON for modal (alternative)
     */
    public function getFacilityData($id)
    {
        $facility = Facility::with('photos')
            ->where('is_active', true)
            ->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $facility
        ]);
    }
}