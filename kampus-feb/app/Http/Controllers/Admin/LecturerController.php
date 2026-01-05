<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lecturer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class LecturerController extends Controller
{
    /**
     * Display listing with filters
     */
    public function index(Request $request)
    {
        $query = Lecturer::latest();

        // Filter by study program
        if ($request->filled('study_program')) {
            $query->where('study_program', $request->study_program);
        }

        // Filter by employment status
        if ($request->filled('employment_status')) {
            $query->where('employment_status', $request->employment_status);
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
                  ->orWhere('nidn', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('position', 'like', "%{$search}%");
            });
        }

        $lecturers = $query->paginate(20);

        // Statistics
        $stats = [
            'total' => Lecturer::count(),
            'visible' => Lecturer::visible()->count(),
            'active' => Lecturer::active()->count(),
            'tetap' => Lecturer::where('employment_status', 'Tetap')->count(),
        ];

        return view('admin.lecturers.index', compact('lecturers', 'stats'));
    }

    /**
     * Show create form
     */
    public function create()
    {
        $degrees = Lecturer::academicDegrees();
        $employmentStatuses = Lecturer::employmentStatuses();
        return view('admin.lecturers.create', compact('degrees', 'employmentStatuses'));
    }

    /**
     * Store new lecturer with enhanced validation
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            // Biodata Utama
            'name' => 'required|string|max:255|min:3',
            'nidn' => [
                'required',
                'string',
                'size:10',
                'regex:/^[0-9]{10}$/',
                'unique:lecturers,nidn'
            ],
            'position' => 'nullable|string|max:100',
            'employment_status' => 'required|in:Tetap,Tidak Tetap',
            'study_program' => 'nullable|string|max:100',
            'academic_degree' => 'nullable|in:S1,S2,S3,Prof',
            
            // Bidang Keahlian
            'expertise' => 'nullable|string|max:1000',
            'research_interests' => 'nullable|string|max:1000',
            
            // Kontak & Identitas Digital
            'email' => 'nullable|email:rfc,dns|max:255|unique:lecturers,email',
            'phone' => 'nullable|string|regex:/^[0-9+\-\s()]{8,20}$/|max:20',
            'google_scholar_url' => 'nullable|url|max:500',
            'sinta_id' => 'nullable|string|max:50',
            'scopus_id' => 'nullable|string|max:50',
            'orcid' => 'nullable|string|max:50|regex:/^[0-9]{4}-[0-9]{4}-[0-9]{4}-[0-9]{3}[0-9X]$/',
            
            // Riwayat Pendidikan
            'education_history' => 'nullable|string|max:2000',
            'education_s1' => 'nullable|string|max:500',
            'education_s2' => 'nullable|string|max:500',
            'education_s3' => 'nullable|string|max:500',
            
            // Pengalaman Akademik
            'courses_taught' => 'nullable|string|max:2000',
            'teaching_experience' => 'nullable|string|max:2000',
            'structural_position' => 'nullable|string|max:200',
            
            // Publikasi & Penelitian
            'publications' => 'nullable|string|max:5000',
            'conference_papers' => 'nullable|string|max:5000',
            'books_hki' => 'nullable|string|max:2000',
            
            // Pengabdian Masyarakat
            'community_service' => 'nullable|string|max:3000',
            
            // Sertifikasi & Penghargaan
            'certifications' => 'nullable|string|max:2000',
            'awards' => 'nullable|string|max:2000',
            
            // Foto
            'photo' => [
                'nullable',
                'file',
                'mimes:jpeg,png,jpg',
                'max:2048',
                'dimensions:min_width=200,min_height=200,max_width=2000,max_height=2000'
            ],
            
            'is_visible' => 'boolean',
            'is_active' => 'boolean',
        ], [
            'nidn.regex' => 'NIDN harus berupa 10 digit angka',
            'nidn.size' => 'NIDN harus 10 digit',
            'nidn.unique' => 'NIDN sudah terdaftar',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah digunakan',
            'phone.regex' => 'Format nomor telepon tidak valid',
            'orcid.regex' => 'Format ORCID tidak valid (contoh: 0000-0001-2345-6789)',
            'google_scholar_url.url' => 'URL Google Scholar tidak valid',
            'photo.dimensions' => 'Foto minimal 200x200px dan maksimal 2000x2000px',
            'employment_status.required' => 'Status dosen wajib dipilih',
        ]);

        // Handle checkbox
        $validated['is_visible'] = $request->has('is_visible');
        $validated['is_active'] = $request->has('is_active') ?? true;

        // Handle file upload with additional security
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            
            // Double-check MIME type
            $allowedMimes = ['image/jpeg', 'image/png', 'image/jpg'];
            if (!in_array($file->getMimeType(), $allowedMimes)) {
                return back()->withErrors([
                    'photo' => 'File harus berupa gambar JPEG atau PNG'
                ])->withInput();
            }
            
            // Generate secure filename
            $filename = 'lecturer_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $validated['photo'] = $file->storeAs('lecturers', $filename, 'public');
        }

        try {
            Lecturer::create($validated);
            
            Log::info('Lecturer created', [
                'nidn' => $validated['nidn'],
                'name' => $validated['name'],
                'user_id' => auth()->id()
            ]);

            return redirect()->route('admin.lecturers.index')
                ->with('success', 'Data dosen berhasil ditambahkan');
                
        } catch (\Exception $e) {
            Log::error('Error creating lecturer: ' . $e->getMessage());
            return back()->withErrors([
                'error' => 'Terjadi kesalahan saat menyimpan data'
            ])->withInput();
        }
    }

    /**
     * Show edit form
     */
    public function edit(Lecturer $lecturer)
    {
        $degrees = Lecturer::academicDegrees();
        $employmentStatuses = Lecturer::employmentStatuses();
        return view('admin.lecturers.edit', compact('lecturer', 'degrees', 'employmentStatuses'));
    }

    /**
     * Update lecturer with validation
     */
    public function update(Request $request, Lecturer $lecturer)
    {
        $validated = $request->validate([
            // Biodata Utama
            'name' => 'required|string|max:255|min:3',
            'nidn' => [
                'required',
                'string',
                'size:10',
                'regex:/^[0-9]{10}$/',
                Rule::unique('lecturers', 'nidn')->ignore($lecturer->id)
            ],
            'position' => 'nullable|string|max:100',
            'employment_status' => 'required|in:Tetap,Tidak Tetap',
            'study_program' => 'nullable|string|max:100',
            'academic_degree' => 'nullable|in:S1,S2,S3,Prof',
            
            // Bidang Keahlian
            'expertise' => 'nullable|string|max:1000',
            'research_interests' => 'nullable|string|max:1000',
            
            // Kontak & Identitas Digital
            'email' => [
                'nullable',
                'email:rfc,dns',
                'max:255',
                Rule::unique('lecturers', 'email')->ignore($lecturer->id)
            ],
            'phone' => 'nullable|string|regex:/^[0-9+\-\s()]{8,20}$/|max:20',
            'google_scholar_url' => 'nullable|url|max:500',
            'sinta_id' => 'nullable|string|max:50',
            'scopus_id' => 'nullable|string|max:50',
            'orcid' => 'nullable|string|regex:/^[0-9]{4}-[0-9]{4}-[0-9]{4}-[0-9]{3}[0-9X]$/',
            
            // Riwayat Pendidikan
            'education_history' => 'nullable|string|max:2000',
            'education_s1' => 'nullable|string|max:500',
            'education_s2' => 'nullable|string|max:500',
            'education_s3' => 'nullable|string|max:500',
            
            // Pengalaman Akademik
            'courses_taught' => 'nullable|string|max:2000',
            'teaching_experience' => 'nullable|string|max:2000',
            'structural_position' => 'nullable|string|max:200',
            
            // Publikasi & Penelitian
            'publications' => 'nullable|string|max:5000',
            'conference_papers' => 'nullable|string|max:5000',
            'books_hki' => 'nullable|string|max:2000',
            
            // Pengabdian Masyarakat
            'community_service' => 'nullable|string|max:3000',
            
            // Sertifikasi & Penghargaan
            'certifications' => 'nullable|string|max:2000',
            'awards' => 'nullable|string|max:2000',
            
            // Foto
            'photo' => [
                'nullable',
                'file',
                'mimes:jpeg,png,jpg',
                'max:2048',
                'dimensions:min_width=200,min_height=200,max_width=2000,max_height=2000'
            ],
            
            'is_visible' => 'boolean',
            'is_active' => 'boolean',
        ], [
            'nidn.regex' => 'NIDN harus berupa 10 digit angka',
            'nidn.size' => 'NIDN harus 10 digit',
            'email.email' => 'Format email tidak valid',
            'phone.regex' => 'Format nomor telepon tidak valid',
            'orcid.regex' => 'Format ORCID tidak valid (contoh: 0000-0001-2345-6789)',
            'photo.dimensions' => 'Foto minimal 200x200px dan maksimal 2000x2000px',
        ]);

        $validated['is_visible'] = $request->has('is_visible');
        $validated['is_active'] = $request->has('is_active');

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            
            // Validate MIME type
            $allowedMimes = ['image/jpeg', 'image/png', 'image/jpg'];
            if (!in_array($file->getMimeType(), $allowedMimes)) {
                return back()->withErrors([
                    'photo' => 'File harus berupa gambar JPEG atau PNG'
                ])->withInput();
            }
            
            // Delete old photo
            if ($lecturer->photo && Storage::disk('public')->exists($lecturer->photo)) {
                Storage::disk('public')->delete($lecturer->photo);
            }
            
            $filename = 'lecturer_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $validated['photo'] = $file->storeAs('lecturers', $filename, 'public');
        }

        try {
            $lecturer->update($validated);
            
            Log::info('Lecturer updated', [
                'id' => $lecturer->id,
                'nidn' => $lecturer->nidn,
                'user_id' => auth()->id()
            ]);

            return redirect()->route('admin.lecturers.index')
                ->with('success', 'Data dosen berhasil diupdate');
                
        } catch (\Exception $e) {
            Log::error('Error updating lecturer: ' . $e->getMessage());
            return back()->withErrors([
                'error' => 'Terjadi kesalahan saat mengupdate data'
            ])->withInput();
        }
    }

    /**
     * Delete lecturer with soft delete
     */
    public function destroy(Lecturer $lecturer)
    {
        try {
            $lecturer->delete();
            
            Log::info('Lecturer deleted', [
                'id' => $lecturer->id,
                'nidn' => $lecturer->nidn,
                'user_id' => auth()->id()
            ]);

            return redirect()->route('admin.lecturers.index')
                ->with('success', 'Data dosen berhasil dihapus');
                
        } catch (\Exception $e) {
            Log::error('Error deleting lecturer: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat menghapus data');
        }
    }

    /**
     * Toggle visibility (AJAX-friendly)
     */
    public function toggleVisibility(Lecturer $lecturer)
    {
        $lecturer->update([
            'is_visible' => !$lecturer->is_visible
        ]);

        return back()->with('success', 'Status visibility berhasil diubah');
    }

    /**
     * Restore soft-deleted lecturer
     */
    public function restore($id)
    {
        $lecturer = Lecturer::withTrashed()->findOrFail($id);
        $lecturer->restore();

        return back()->with('success', 'Data dosen berhasil dipulihkan');
    }
}