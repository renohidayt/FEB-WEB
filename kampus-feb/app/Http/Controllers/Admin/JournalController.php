<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Journal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class JournalController extends Controller
{
    /**
     * Display listing with filters
     */
    public function index(Request $request)
    {
        $query = Journal::latest();

        // Filter by manager
        if ($request->filled('manager')) {
            $query->where('manager', $request->manager);
        }

        // Filter by accreditation
        if ($request->filled('accreditation_status')) {
            $query->where('accreditation_status', $request->accreditation_status);
        }

        // Filter by visibility
        if ($request->filled('is_visible')) {
            $query->where('is_visible', $request->is_visible);
        }

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('field', 'like', "%{$search}%")
                  ->orWhere('issn', 'like', "%{$search}%")
                  ->orWhere('e_issn', 'like', "%{$search}%");
            });
        }

        $journals = $query->paginate(12);

        // Statistics
        $stats = [
            'total' => Journal::count(),
            'visible' => Journal::visible()->count(),
            'active' => Journal::active()->count(),
            'sinta' => Journal::where('accreditation_status', 'like', 'SINTA%')->count(),
        ];

        return view('admin.journals.index', compact('journals', 'stats'));
    }

    /**
     * Show create form
     */
    public function create()
    {
        $accreditationStatuses = Journal::accreditationStatuses();
        return view('admin.journals.create', compact('accreditationStatuses'));
    }

    /**
     * Store new journal
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|min:3',
            'description' => 'nullable|string|max:2000',
            'field' => 'required|string|max:255',
            'issn' => 'nullable|string|max:20|regex:/^[0-9]{4}-[0-9]{3}[0-9X]$/',
            'e_issn' => 'nullable|string|max:20|regex:/^[0-9]{4}-[0-9]{3}[0-9X]$/',
            'manager' => 'required|string|max:255',
            'accreditation_status' => 'nullable|in:' . implode(',', array_keys(Journal::accreditationStatuses())),
            
            // URLs
            'website_url' => 'nullable|url|max:500',
            'submit_url' => 'nullable|url|max:500',
            'sinta_url' => 'nullable|url|max:500',
            'garuda_url' => 'nullable|url|max:500',
            'scholar_url' => 'nullable|url|max:500',
            
            // Additional Info
            'frequency' => 'nullable|string|max:100',
            'editor_in_chief' => 'nullable|string|max:255',
            'publisher' => 'nullable|string|max:255',
            
            // Cover Image
            'cover_image' => [
                'nullable',
                'file',
                'mimes:jpeg,png,jpg',
                'max:2048',
                'dimensions:min_width=300,min_height=400,max_width=2000,max_height=3000'
            ],
            
            'is_visible' => 'boolean',
            'is_active' => 'boolean',
        ], [
            'name.required' => 'Nama jurnal wajib diisi',
            'field.required' => 'Bidang jurnal wajib diisi',
            'manager.required' => 'Pengelola jurnal wajib diisi',
            'issn.regex' => 'Format ISSN tidak valid (contoh: 1234-567X)',
            'e_issn.regex' => 'Format e-ISSN tidak valid (contoh: 1234-567X)',
            'website_url.url' => 'Format URL website tidak valid',
            'cover_image.dimensions' => 'Cover minimal 300x400px dan maksimal 2000x3000px',
        ]);

        // Handle checkbox
        $validated['is_visible'] = $request->has('is_visible');
        $validated['is_active'] = $request->has('is_active') ?? true;

        // Handle cover image upload
        if ($request->hasFile('cover_image')) {
            $file = $request->file('cover_image');
            
            // Validate MIME type
            $allowedMimes = ['image/jpeg', 'image/png', 'image/jpg'];
            if (!in_array($file->getMimeType(), $allowedMimes)) {
                return back()->withErrors([
                    'cover_image' => 'File harus berupa gambar JPEG atau PNG'
                ])->withInput();
            }
            
            $filename = 'journal_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $validated['cover_image'] = $file->storeAs('journals', $filename, 'public');
        }

        try {
            Journal::create($validated);
            
            Log::info('Journal created', [
                'name' => $validated['name'],
                'user_id' => auth()->id()
            ]);

            return redirect()->route('admin.journals.index')
                ->with('success', 'Jurnal berhasil ditambahkan');
                
        } catch (\Exception $e) {
            Log::error('Error creating journal: ' . $e->getMessage());
            return back()->withErrors([
                'error' => 'Terjadi kesalahan saat menyimpan data'
            ])->withInput();
        }
    }

    /**
     * Show edit form
     */
    public function edit(Journal $journal)
    {
        $accreditationStatuses = Journal::accreditationStatuses();
        return view('admin.journals.edit', compact('journal', 'accreditationStatuses'));
    }

    /**
     * Update journal
     */
    public function update(Request $request, Journal $journal)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|min:3',
            'description' => 'nullable|string|max:2000',
            'field' => 'required|string|max:255',
            'issn' => 'nullable|string|max:20|regex:/^[0-9]{4}-[0-9]{3}[0-9X]$/',
            'e_issn' => 'nullable|string|max:20|regex:/^[0-9]{4}-[0-9]{3}[0-9X]$/',
            'manager' => 'required|string|max:255',
            'accreditation_status' => 'nullable|in:' . implode(',', array_keys(Journal::accreditationStatuses())),
            
            // URLs
            'website_url' => 'nullable|url|max:500',
            'submit_url' => 'nullable|url|max:500',
            'sinta_url' => 'nullable|url|max:500',
            'garuda_url' => 'nullable|url|max:500',
            'scholar_url' => 'nullable|url|max:500',
            
            // Additional Info
            'frequency' => 'nullable|string|max:100',
            'editor_in_chief' => 'nullable|string|max:255',
            'publisher' => 'nullable|string|max:255',
            
            // Cover Image
            'cover_image' => [
                'nullable',
                'file',
                'mimes:jpeg,png,jpg',
                'max:2048',
                'dimensions:min_width=300,min_height=400,max_width=2000,max_height=3000'
            ],
            
            'is_visible' => 'boolean',
            'is_active' => 'boolean',
        ], [
            'issn.regex' => 'Format ISSN tidak valid (contoh: 1234-567X)',
            'e_issn.regex' => 'Format e-ISSN tidak valid (contoh: 1234-567X)',
            'cover_image.dimensions' => 'Cover minimal 300x400px dan maksimal 2000x3000px',
        ]);

        $validated['is_visible'] = $request->has('is_visible');
        $validated['is_active'] = $request->has('is_active');

        // Handle cover image upload
        if ($request->hasFile('cover_image')) {
            $file = $request->file('cover_image');
            
            // Validate MIME type
            $allowedMimes = ['image/jpeg', 'image/png', 'image/jpg'];
            if (!in_array($file->getMimeType(), $allowedMimes)) {
                return back()->withErrors([
                    'cover_image' => 'File harus berupa gambar JPEG atau PNG'
                ])->withInput();
            }
            
            // Delete old cover
            if ($journal->cover_image && Storage::disk('public')->exists($journal->cover_image)) {
                Storage::disk('public')->delete($journal->cover_image);
            }
            
            $filename = 'journal_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $validated['cover_image'] = $file->storeAs('journals', $filename, 'public');
        }

        try {
            $journal->update($validated);
            
            Log::info('Journal updated', [
                'id' => $journal->id,
                'name' => $journal->name,
                'user_id' => auth()->id()
            ]);

            return redirect()->route('admin.journals.index')
                ->with('success', 'Jurnal berhasil diupdate');
                
        } catch (\Exception $e) {
            Log::error('Error updating journal: ' . $e->getMessage());
            return back()->withErrors([
                'error' => 'Terjadi kesalahan saat mengupdate data'
            ])->withInput();
        }
    }

    /**
     * Delete journal
     */
    public function destroy(Journal $journal)
    {
        try {
            $journal->delete();
            
            Log::info('Journal deleted', [
                'id' => $journal->id,
                'name' => $journal->name,
                'user_id' => auth()->id()
            ]);

            return redirect()->route('admin.journals.index')
                ->with('success', 'Jurnal berhasil dihapus');
                
        } catch (\Exception $e) {
            Log::error('Error deleting journal: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat menghapus data');
        }
    }

    /**
     * Toggle visibility
     */
    public function toggleVisibility(Journal $journal)
    {
        $journal->update([
            'is_visible' => !$journal->is_visible
        ]);

        return back()->with('success', 'Status visibility berhasil diubah');
    }
}