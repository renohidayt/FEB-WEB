<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Accreditation;
use Illuminate\Support\Facades\Storage;

class FrontendAccreditationController extends Controller
{
    /**
     * Landing page dengan 3 folder cards
     */
    public function index()
    {
        $stats = [
            // Akreditasi PT (Current + Old)
            'pt_current' => Accreditation::perguruanTinggi()
                ->valid()
                ->where('is_active', true)
                ->count(),
            'pt_old' => Accreditation::perguruanTinggiHistorical()->count(),
            
            // Akreditasi Prodi (Current & Valid)
            'program_studi_count' => Accreditation::programStudi()
                ->valid()
                ->where('is_active', true)
                ->count(),
            
            // Riwayat (Menggunakan scope historical)
            'history_count' => Accreditation::historical()->count(),
            
            // Grade breakdown for current prodi
            'grade_a' => Accreditation::programStudi()
                ->valid()
                ->where(function($q) {
                    $q->where('grade', 'A')
                      ->orWhere('grade', 'Unggul');
                })
                ->count(),
            'grade_b' => Accreditation::programStudi()
                ->valid()
                ->where(function($q) {
                    $q->where('grade', 'B')
                      ->orWhere('grade', 'Baik Sekali');
                })
                ->count(),
        ];

        return view('frontend.profile.accreditation.index', compact('stats'));
    }

    /**
     * Folder 1: Akreditasi Perguruan Tinggi
     * Shows: perguruan_tinggi + perguruan_tinggi_old + expired PT
     */
    public function institution()
    {
        // Current PT Accreditation (yang masih valid dan aktif)
        $currentAccreditation = Accreditation::perguruanTinggi()
            ->valid()
            ->where('is_active', true)
            ->latest('valid_until')
            ->first();

        // Old/Previous PT Accreditations (include expired)
        $oldAccreditations = Accreditation::perguruanTinggiHistorical()
            ->orderBy('valid_until', 'desc')
            ->get();

        // Statistics
        $stats = [
            'current_grade' => $currentAccreditation->grade ?? 'N/A',
            'valid_until' => $currentAccreditation ? 
                           $currentAccreditation->valid_until->format('d F Y') : 'N/A',
            'accreditation_body' => $currentAccreditation->accreditation_body ?? 'BAN-PT',
            'total_history' => $oldAccreditations->count(),
        ];

        return view('frontend.profile.accreditation.institution', compact(
            'currentAccreditation', 
            'oldAccreditations',
            'stats'
        ));
    }

    /**
     * Folder 2: Akreditasi Program Studi
     * Shows: program_studi (active & valid only)
     */
    public function programs()
    {
        // Get all active program studi accreditations (yang masih valid)
        $accreditations = Accreditation::programStudi()
            ->valid()
            ->where('is_active', true)
            ->orderBy('study_program')
            ->get();

        // Group by category if exists
        $groupedByCategory = $accreditations->groupBy('category');

        // Statistics
        $stats = [
            'total' => $accreditations->count(),
            'grade_a' => $accreditations->whereIn('grade', ['A', 'Unggul'])->count(),
            'grade_b' => $accreditations->whereIn('grade', ['B', 'Baik Sekali'])->count(),
            'grade_c' => $accreditations->whereIn('grade', ['C', 'Baik'])->count(),
            'categories' => $groupedByCategory->keys()->filter()->values(),
        ];

        return view('frontend.profile.accreditation.programs', compact(
            'accreditations',
            'groupedByCategory',
            'stats'
        ));
    }

    /**
     * Folder 3: Riwayat Akreditasi
     * Shows: program_studi_old + expired program_studi accreditations
     */
   public function history()
{
    // PT: All historical (inactive OR expired)
    $ptHistorical = Accreditation::perguruanTinggi()
        ->where(function($q) {
            $q->where('is_active', false)
              ->orWhere('valid_until', '<', now());
        })
        ->orderBy('valid_until', 'desc')
        ->get();

    // Prodi: All historical (inactive OR expired)
    $prodiHistorical = Accreditation::programStudi()
        ->where(function($q) {
            $q->where('is_active', false)
              ->orWhere('valid_until', '<', now());
        })
        ->orderBy('valid_until', 'desc')
        ->get();

    // Group prodi by study program
    $groupedByProgram = $prodiHistorical->groupBy('study_program');
    
    // 🔥 ADD PT as a special "program" with key "Perguruan Tinggi"
    if ($ptHistorical->count() > 0) {
        $groupedByProgram->prepend($ptHistorical, 'Perguruan Tinggi STIE Sebelas April');
    }

    $stats = [
        'total_records' => $ptHistorical->count() + $prodiHistorical->count(),
        'pt_records' => $ptHistorical->count(),
        'prodi_records' => $prodiHistorical->count(),
        'programs_count' => $groupedByProgram->count(),
        'oldest_year' => collect([$ptHistorical, $prodiHistorical])
            ->flatten()
            ->filter(fn($item) => $item->valid_from)
            ->min('valid_from')?->format('Y') ?? 'N/A',
        'latest_year' => collect([$ptHistorical, $prodiHistorical])
            ->flatten()
            ->max('valid_until')?->format('Y') ?? 'N/A',
    ];

    return view('frontend.profile.accreditation.history', compact(
        'ptHistorical',
        'prodiHistorical',
        'groupedByProgram',
        'stats'
    ));
}

    /**
     * Download certificate
     */
    public function download(Accreditation $accreditation)
    {
        if (!$accreditation->certificate_file || 
            !Storage::disk('public')->exists($accreditation->certificate_file)) {
            return back()->with('error', 'File sertifikat tidak ditemukan');
        }

        // Increment download counter
        $accreditation->incrementDownloads();

        $path = Storage::disk('public')->path($accreditation->certificate_file);
        $name = $accreditation->type . '_' .
                $accreditation->study_program . '_' . 
                $accreditation->grade . '_' . 
                $accreditation->valid_until->format('Y') . '.pdf';

        return response()->download($path, $name);
    }
}