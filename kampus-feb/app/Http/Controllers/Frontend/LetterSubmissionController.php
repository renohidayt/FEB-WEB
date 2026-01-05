<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\LetterTemplate;
use App\Models\LetterSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LetterSubmissionController extends Controller
{
    /**
     * Display list of templates (PUBLIC) and user submissions (IF LOGGED IN)
     * ✅ No auth required for viewing templates
     */
    public function index()
    {
        // Get active templates (PUBLIC)
        $templates = LetterTemplate::where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->get();

        // Get user's submissions ONLY if logged in
        $submissions = collect(); // Empty collection by default
        
        if (auth()->check()) {
            $submissions = LetterSubmission::where('user_id', auth()->id())
                ->with(['template', 'processedBy'])
                ->latest()
                ->paginate(10);
        }

        return view('frontend.letters.index', compact('templates', 'submissions'));
    }

    /**
     * Show form to create submission
     * ✅ AUTH REQUIRED - Redirect to login if not authenticated
     */
    public function create(LetterTemplate $template)
    {
        // ✅ Check authentication
        if (!auth()->check()) {
            return redirect()->route('student.login')
                ->with('info', 'Silakan login terlebih dahulu untuk mengajukan surat.');
        }

        // Check if template is active
        if (!$template->is_active) {
            return redirect()->route('letters.index')
                ->with('error', 'Template surat tidak tersedia.');
        }

        // Get student data if exists
        $student = auth()->user()->student;

        return view('frontend.letters.create', compact('template', 'student'));
    }

    /**
     * Store new submission
     * ✅ AUTH REQUIRED
     */
    public function store(Request $request)
    {
        // ✅ Double check authentication
        if (!auth()->check()) {
            return redirect()->route('student.login')
                ->with('error', 'Anda harus login untuk mengajukan surat.');
        }

        $validated = $request->validate([
            'letter_template_id' => 'required|exists:letter_templates,id',
            'form_data' => 'required|array',
            'attachments.*' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        // Get user and student data
        $user = auth()->user();
        $student = $user->student;

        // Prepare data
        $submissionData = [
            'letter_template_id' => $validated['letter_template_id'],
            'user_id' => $user->id,
            'nama_mahasiswa' => $student ? $student->nama : $user->name,
            'nim' => $student ? $student->nim : null,
            'prodi' => $student ? $student->program_studi : null,
            'email' => $user->email,
            'no_hp' => $student ? $student->user->phone : null,
            'form_data' => $validated['form_data'],
            'status' => 'pending',
            'submitted_at' => now(),
        ];

        // Handle file uploads
        if ($request->hasFile('attachments')) {
            $attachmentPaths = [];
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('letter-attachments', 'public');
                $attachmentPaths[] = $path;
            }
            $submissionData['attachments'] = $attachmentPaths;
        }

        $submission = LetterSubmission::create($submissionData);

        return redirect()->route('letters.show', $submission)
            ->with('success', 'Pengajuan surat berhasil dikirim!');
    }

    /**
     * Show submission detail
     * ✅ AUTH REQUIRED + Authorization check
     */
    public function show(LetterSubmission $submission)
    {
        // ✅ Check authentication
        if (!auth()->check()) {
            return redirect()->route('student.login')
                ->with('info', 'Silakan login untuk melihat detail pengajuan.');
        }

        // Authorization check: Only owner or admin can view
        if ($submission->user_id !== auth()->id() && !auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized');
        }

        $submission->load(['template', 'user', 'processedBy']);

        return view('frontend.letters.show', compact('submission'));
    }

    /**
     * Cancel pending submission
     * ✅ AUTH REQUIRED
     */
    public function cancel(LetterSubmission $submission)
    {
        // ✅ Check authentication
        if (!auth()->check()) {
            abort(403);
        }

        // Authorization check
        if ($submission->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        // Only pending submissions can be cancelled
        if ($submission->status !== 'pending') {
            return back()->with('error', 'Hanya pengajuan dengan status pending yang dapat dibatalkan.');
        }

        $submission->update(['status' => 'cancelled']);

        return redirect()->route('letters.index')
            ->with('success', 'Pengajuan surat berhasil dibatalkan.');
    }

    /**
     * Download generated letter
     * ✅ AUTH REQUIRED
     */
    public function download(LetterSubmission $submission)
    {
        // ✅ Check authentication
        if (!auth()->check()) {
            abort(403);
        }

        // Authorization check
        if ($submission->user_id !== auth()->id() && !auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized');
        }

        // Check if letter is generated
        if (!$submission->generated_letter_path) {
            return back()->with('error', 'Surat belum dihasilkan.');
        }

        // Check if file exists
        if (!Storage::disk('public')->exists($submission->generated_letter_path)) {
            return back()->with('error', 'File surat tidak ditemukan.');
        }

        return Storage::disk('public')->download(
            $submission->generated_letter_path,
            'Surat_' . $submission->id . '.pdf'
        );
    }

    /**
     * Download attachment
     * ✅ AUTH REQUIRED
     */
    public function downloadAttachment(LetterSubmission $submission, $index)
    {
        // ✅ Check authentication
        if (!auth()->check()) {
            abort(403);
        }

        // Authorization check
        if ($submission->user_id !== auth()->id() && !auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized');
        }

        $attachments = $submission->attachments ?? [];

        if (!isset($attachments[$index])) {
            abort(404, 'Attachment not found');
        }

        $path = $attachments[$index];

        if (!Storage::disk('public')->exists($path)) {
            abort(404, 'File not found');
        }

        return Storage::disk('public')->download($path);
    }
}