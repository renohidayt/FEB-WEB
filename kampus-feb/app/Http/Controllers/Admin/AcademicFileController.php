<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AcademicFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AcademicFileController extends Controller
{
    public function index(Request $request)
    {
        $query = AcademicFile::query();

        // Filter by type
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        $files = $query->orderBy('created_at', 'desc')->paginate(20);

        return view('admin.academic-files.index', compact('files'));
    }

    public function create()
    {
        return view('admin.academic-files.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:kalender,jadwal',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'academic_year' => 'required|string|max:10',
            'semester' => 'required|in:ganjil,genap',
            'file' => 'required|file|mimes:pdf,csv,xls,xlsx,doc,docx|max:10240', // max 10MB
            'is_active' => 'boolean',
        ]);

        // Upload file
        $file = $request->file('file');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('academic-files', $fileName, 'public');

        // Create record
        AcademicFile::create([
            'type' => $validated['type'],
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'file_path' => $filePath,
            'file_name' => $file->getClientOriginalName(),
            'file_type' => $file->getClientOriginalExtension(),
            'file_size' => $file->getSize(),
            'academic_year' => $validated['academic_year'],
            'semester' => $validated['semester'],
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.academic-files.index')
            ->with('success', 'File berhasil diupload!');
    }

    public function edit(AcademicFile $academicFile)
    {
        return view('admin.academic-files.edit', compact('academicFile'));
    }

    public function update(Request $request, AcademicFile $academicFile)
    {
        $validated = $request->validate([
            'type' => 'required|in:kalender,jadwal',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'academic_year' => 'required|string|max:10',
            'semester' => 'required|in:ganjil,genap',
            'file' => 'nullable|file|mimes:pdf,csv,xls,xlsx,doc,docx|max:10240',
            'is_active' => 'boolean',
        ]);

        // Update file if new file uploaded
        if ($request->hasFile('file')) {
            // Delete old file
            if (Storage::disk('public')->exists($academicFile->file_path)) {
                Storage::disk('public')->delete($academicFile->file_path);
            }

            // Upload new file
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('academic-files', $fileName, 'public');

            $validated['file_path'] = $filePath;
            $validated['file_name'] = $file->getClientOriginalName();
            $validated['file_type'] = $file->getClientOriginalExtension();
            $validated['file_size'] = $file->getSize();
        }

        $validated['is_active'] = $request->has('is_active');

        $academicFile->update($validated);

        return redirect()->route('admin.academic-files.index')
            ->with('success', 'File berhasil diupdate!');
    }

    public function destroy(AcademicFile $academicFile)
    {
        $academicFile->delete();

        return redirect()->route('admin.academic-files.index')
            ->with('success', 'File berhasil dihapus!');
    }

    public function download($id)
{
    $file = AcademicFile::findOrFail($id);

    $filePath = storage_path('app/public/' . $file->file_path);

    if (!file_exists($filePath)) {
        abort(404, 'File not found.');
    }

    // increment download counter
    $file->incrementDownload();

    return response()->download($filePath, $file->original_name);
}

public function kalender()
{
    $files = AcademicFile::where('type', 'kalender')->latest()->get();
    return view('frontend.academic.calendar', compact('files'));
}

public function jadwal()
{
    $files = AcademicFile::where('type', 'jadwal')->latest()->get();
    return view('frontend.academic.schedule', compact('files'));
}

}