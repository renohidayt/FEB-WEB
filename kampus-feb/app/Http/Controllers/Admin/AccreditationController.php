<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Accreditation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class AccreditationController extends Controller
{
    /**
     * Display listing with filters and statistics
     */
    public function index(Request $request)
    {
        $query = Accreditation::latest();

        // Filter by TYPE (NEW)
        if ($request->filled('type')) {
            $query->byType($request->type);
        }

        // Filter by CATEGORY (NEW)
        if ($request->filled('category')) {
            $query->byCategory($request->category);
        }

        // Filter by status
        if ($request->filled('status')) {
            switch ($request->status) {
                case 'active':
                    $query->valid()->where('is_active', true);
                    break;
                case 'expired':
                    $query->expired();
                    break;
                case 'expiring':
                    $query->expiringSoon();
                    break;
            }
        }

        // Filter by grade
        if ($request->filled('grade')) {
            $query->byGrade($request->grade);
        }

        // Filter by program
        if ($request->filled('program')) {
            $query->byProgram($request->program);
        }

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('study_program', 'like', "%{$search}%")
                  ->orWhere('certificate_number', 'like', "%{$search}%")
                  ->orWhere('accreditation_body', 'like', "%{$search}%");
            });
        }

        $accreditations = $query->paginate(20)->withQueryString();

        // Enhanced Statistics with TYPE breakdown
        $stats = [
            'total' => Accreditation::count(),
            'active' => Accreditation::valid()->where('is_active', true)->count(),
            'expired' => Accreditation::expired()->count(),
            'expiring' => Accreditation::expiringSoon()->count(),
            
            // TYPE breakdown
            'pt' => Accreditation::perguruanTinggi()->count(),
            'pt_old' => Accreditation::perguruanTinggiOld()->count(),
            'prodi' => Accreditation::programStudi()->count(),
            'prodi_old' => Accreditation::programStudiOld()->count(),
        ];

        // Get unique categories for filter dropdown
        $categories = Accreditation::select('category')
            ->distinct()
            ->whereNotNull('category')
            ->pluck('category');

        return view('admin.accreditations.index', compact('accreditations', 'stats', 'categories'));
    }

    /**
     * Show create form
     */
    public function create()
    {
        $types = Accreditation::types();
        $categories = Accreditation::categories();
        $grades = Accreditation::grades();
        $bodies = Accreditation::accreditationBodies();
        
        return view('admin.accreditations.create', compact('types', 'categories', 'grades', 'bodies'));
    }

    /**
     * Store new accreditation with strict validation
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            // NEW: Type and Category
            'type' => [
                'required',
                Rule::in(array_keys(Accreditation::types()))
            ],
            'category' => [
                'nullable',
                'string',
                'max:100'
            ],
            
            'study_program' => 'required|string|max:255',
            'grade' => [
                'required',
                Rule::in(array_keys(Accreditation::grades()))
            ],
            'accreditation_body' => 'required|string|max:100',
            'certificate_number' => [
                'nullable',
                'string',
                'max:100',
                // UPDATED: Now includes type in unique check
                Rule::unique('accreditations')
                    ->where('type', $request->type)
                    ->where('study_program', $request->study_program)
            ],
            'valid_from' => 'nullable|date|before_or_equal:valid_until',
            'valid_until' => 'required|date|after:valid_from',
            'description' => 'nullable|string|max:2000',
            
            'certificate_file' => [
                'required',
                'file',
                'mimes:pdf',
                'max:5120',
            ],
            
            'is_active' => 'boolean',
        ], [
            'type.required' => 'Tipe akreditasi wajib dipilih',
            'type.in' => 'Tipe akreditasi tidak valid',
            'certificate_file.required' => 'File sertifikat wajib diupload',
            'certificate_file.mimes' => 'File harus berupa PDF',
            'certificate_file.max' => 'Ukuran file maksimal 5MB',
            'certificate_number.unique' => 'Nomor sertifikat sudah terdaftar untuk tipe dan program ini',
            'valid_until.after' => 'Tanggal berakhir harus setelah tanggal mulai',
        ]);

        // Handle checkbox
        $validated['is_active'] = $request->has('is_active');

        // Handle PDF file upload
        if ($request->hasFile('certificate_file')) {
            $file = $request->file('certificate_file');
            
            // Double-check MIME type
            $allowedMimes = ['application/pdf'];
            if (!in_array($file->getMimeType(), $allowedMimes)) {
                return back()->withErrors([
                    'certificate_file' => 'File harus berupa PDF yang valid'
                ])->withInput();
            }
            
            // Check file extension
            if (strtolower($file->getClientOriginalExtension()) !== 'pdf') {
                return back()->withErrors([
                    'certificate_file' => 'File harus berupa PDF'
                ])->withInput();
            }
            
            // Generate secure filename with type prefix
            $typePrefix = str_replace('_', '-', $validated['type']);
            $filename = $typePrefix . '_' . 
                        Str::slug($validated['study_program']) . '_' . 
                        time() . '_' . 
                        uniqid() . 
                        '.pdf';
            
            $validated['certificate_file'] = $file->storeAs(
                'accreditations', 
                $filename, 
                'public'
            );
        }

        try {
            Accreditation::create($validated);
            
            Log::info('Accreditation created', [
                'type' => $validated['type'],
                'program' => $validated['study_program'],
                'grade' => $validated['grade'],
                'user_id' => auth()->id()
            ]);

            return redirect()->route('admin.accreditations.index')
                ->with('success', 'Data akreditasi berhasil ditambahkan');
                
        } catch (\Exception $e) {
            // Delete uploaded file if database insert fails
            if (isset($validated['certificate_file'])) {
                Storage::disk('public')->delete($validated['certificate_file']);
            }
            
            Log::error('Error creating accreditation: ' . $e->getMessage());
            
            return back()->withErrors([
                'error' => 'Terjadi kesalahan saat menyimpan data'
            ])->withInput();
        }
    }

    /**
     * Show edit form
     */
    public function edit(Accreditation $accreditation)
    {
        $types = Accreditation::types();
        $categories = Accreditation::categories();
        $grades = Accreditation::grades();
        $bodies = Accreditation::accreditationBodies();
        
        return view('admin.accreditations.edit', compact('accreditation', 'types', 'categories', 'grades', 'bodies'));
    }

    /**
     * Update accreditation
     */
    public function update(Request $request, Accreditation $accreditation)
    {
        $validated = $request->validate([
            'type' => [
                'required',
                Rule::in(array_keys(Accreditation::types()))
            ],
            'category' => [
                'nullable',
                'string',
                'max:100'
            ],
            
            'study_program' => 'required|string|max:255',
            'grade' => [
                'required',
                Rule::in(array_keys(Accreditation::grades()))
            ],
            'accreditation_body' => 'required|string|max:100',
            'certificate_number' => [
                'nullable',
                'string',
                'max:100',
                Rule::unique('accreditations')
                    ->ignore($accreditation->id)
                    ->where('type', $request->type)
                    ->where('study_program', $request->study_program)
            ],
            'valid_from' => 'nullable|date|before_or_equal:valid_until',
            'valid_until' => 'required|date',
            'description' => 'nullable|string|max:2000',
            
            'certificate_file' => [
                'nullable',
                'file',
                'mimes:pdf',
                'max:5120',
            ],
            
            'is_active' => 'boolean',
        ], [
            'certificate_file.mimes' => 'File harus berupa PDF',
            'certificate_file.max' => 'Ukuran file maksimal 5MB',
        ]);

        $validated['is_active'] = $request->has('is_active');

        // Handle PDF file upload if new file provided
        if ($request->hasFile('certificate_file')) {
            $file = $request->file('certificate_file');
            
            if ($file->getMimeType() !== 'application/pdf') {
                return back()->withErrors([
                    'certificate_file' => 'File harus berupa PDF yang valid'
                ])->withInput();
            }
            
            // Delete old file
            if ($accreditation->certificate_file && 
                Storage::disk('public')->exists($accreditation->certificate_file)) {
                Storage::disk('public')->delete($accreditation->certificate_file);
            }
            
            // Store new file
            $typePrefix = str_replace('_', '-', $validated['type']);
            $filename = $typePrefix . '_' . 
                        Str::slug($validated['study_program']) . '_' . 
                        time() . '_' . 
                        uniqid() . 
                        '.pdf';
            
            $validated['certificate_file'] = $file->storeAs(
                'accreditations', 
                $filename, 
                'public'
            );
        }

        try {
            $accreditation->update($validated);
            
            Log::info('Accreditation updated', [
                'id' => $accreditation->id,
                'type' => $accreditation->type,
                'program' => $accreditation->study_program,
                'user_id' => auth()->id()
            ]);

            return redirect()->route('admin.accreditations.index')
                ->with('success', 'Data akreditasi berhasil diupdate');
                
        } catch (\Exception $e) {
            Log::error('Error updating accreditation: ' . $e->getMessage());
            
            return back()->withErrors([
                'error' => 'Terjadi kesalahan saat mengupdate data'
            ])->withInput();
        }
    }

    /**
     * Delete accreditation
     */
    public function destroy(Accreditation $accreditation)
    {
        try {
            $accreditation->delete();
            
            Log::info('Accreditation deleted', [
                'id' => $accreditation->id,
                'type' => $accreditation->type,
                'program' => $accreditation->study_program,
                'user_id' => auth()->id()
            ]);

            return redirect()->route('admin.accreditations.index')
                ->with('success', 'Data akreditasi berhasil dihapus');
                
        } catch (\Exception $e) {
            Log::error('Error deleting accreditation: ' . $e->getMessage());
            
            return back()->with('error', 'Terjadi kesalahan saat menghapus data');
        }
    }

    /**
     * Download certificate file
     */
    public function download(Accreditation $accreditation)
    {
        if (!$accreditation->certificate_file || 
            !Storage::disk('public')->exists($accreditation->certificate_file)) {
            return back()->with('error', 'File sertifikat tidak ditemukan');
        }

        $accreditation->incrementDownloads();

        $path = Storage::disk('public')->path($accreditation->certificate_file);
        $name = $accreditation->type . '_' .
                $accreditation->study_program . '_' . 
                $accreditation->grade . '_' . 
                $accreditation->valid_until->format('Y') . '.pdf';

        return response()->download($path, $name);
    }

    /**
     * Restore soft-deleted accreditation
     */
    public function restore($id)
    {
        $accreditation = Accreditation::withTrashed()->findOrFail($id);
        $accreditation->restore();

        return back()->with('success', 'Data akreditasi berhasil dipulihkan');
    }

    /**
     * NEW: Bulk actions
     */
    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:activate,deactivate,delete',
            'ids' => 'required|array',
            'ids.*' => 'exists:accreditations,id'
        ]);

        $count = 0;

        switch ($request->action) {
            case 'activate':
                $count = Accreditation::whereIn('id', $request->ids)->update(['is_active' => true]);
                $message = "$count data berhasil diaktifkan";
                break;
            
            case 'deactivate':
                $count = Accreditation::whereIn('id', $request->ids)->update(['is_active' => false]);
                $message = "$count data berhasil dinonaktifkan";
                break;
            
            case 'delete':
                $count = Accreditation::whereIn('id', $request->ids)->delete();
                $message = "$count data berhasil dihapus";
                break;
        }

        return back()->with('success', $message);
    }
}