<?php

namespace App\Http\Controllers;

use App\Models\AcademicFile;
use Illuminate\Support\Facades\Storage;

class AcademicFileController extends Controller
{
    public function kalender()
    {
        $files = AcademicFile::active()
            ->kalender()
            ->orderBy('academic_year', 'desc')
            ->get();

        return view('academic-files.kalender', compact('files'));
    }

    public function jadwal()
    {
        $files = AcademicFile::active()
            ->jadwal()
            ->orderBy('academic_year', 'desc')
            ->get();

        return view('academic-files.jadwal', compact('files'));
    }

    public function download($id)
    {
        $file = AcademicFile::findOrFail($id);

        // Increment download count
        $file->incrementDownload();

        // Return file download
        return Storage::disk('public')->download($file->file_path, $file->file_name);
    }
}