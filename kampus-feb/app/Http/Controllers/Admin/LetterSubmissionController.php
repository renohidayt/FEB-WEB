<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LetterSubmission;
use Illuminate\Http\Request;

class LetterSubmissionController extends Controller
{
    public function index(Request $request)
    {
        $query = LetterSubmission::with('user', 'template')->latest();
        
        // Filter by status
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }
        
        $submissions = $query->paginate(20);

        $stats = [
            'total' => LetterSubmission::count(),
            'pending' => LetterSubmission::where('status', 'pending')->count(),
            'approved' => LetterSubmission::where('status', 'approved')->count(),
            'rejected' => LetterSubmission::where('status', 'rejected')->count(),
        ];

        return view('admin.letter-submissions.index', compact('submissions', 'stats'));
    }

    public function show(LetterSubmission $letterSubmission)
    {
        $letterSubmission->load('user', 'template', 'processedBy');
        return view('admin.letter-submissions.show', [
            'submission' => $letterSubmission
        ]);
    }

    public function approve(Request $request, LetterSubmission $letterSubmission)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected',
            'admin_notes' => 'nullable|string',
        ]);

        // Jika status rejected, admin_notes wajib diisi
        if ($request->status === 'rejected' && empty($request->admin_notes)) {
            return back()->with('error', 'Alasan penolakan wajib diisi!');
        }

        $letterSubmission->update([
            'status' => $request->status,
            'admin_notes' => $request->admin_notes,
            'processed_at' => now(),
            'processed_by' => auth()->id(),
        ]);

        $message = $request->status === 'approved' 
            ? 'Pengajuan berhasil disetujui!' 
            : 'Pengajuan berhasil ditolak.';

        return back()->with('success', $message);
    }

    public function destroy(LetterSubmission $letterSubmission)
    {
        $letterSubmission->delete();

        return redirect()->route('admin.letter-submissions.index')
            ->with('success', 'Pengajuan berhasil dihapus');
    }
}