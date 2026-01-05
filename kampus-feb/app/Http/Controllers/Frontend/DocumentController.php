<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    /**
     * Display a listing of documents (Public Page)
     */
    public function index(Request $request)
    {
        $query = Document::query();

        // Filter by category if provided
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Search functionality
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        $documents = $query->latest()->paginate(12);
        
        // Get all categories for filter
        $categories = Document::select('category')
            ->whereNotNull('category')
            ->distinct()
            ->pluck('category');

        return view('frontend.documents.index', compact('documents', 'categories'));
    }

    /**
     * Download document and increment download counter
     */
    public function download(Document $document)
    {
        // Check if file exists
        if (!Storage::disk('public')->exists($document->file_path)) {
            abort(404, 'File tidak ditemukan');
        }

        // Increment download counter
        $document->increment('downloads');

        // Get original filename
        $filename = $document->name . '.' . pathinfo($document->file_path, PATHINFO_EXTENSION);

        // Return download response
        return Storage::disk('public')->download(
            $document->file_path,
            $filename
        );
    }
}