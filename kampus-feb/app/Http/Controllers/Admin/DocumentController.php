<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
// ❗ import DI SINI
use Symfony\Component\HttpFoundation\StreamedResponse;

class DocumentController extends Controller
{
    public function index()
    {
        $documents = Document::latest()->paginate(20);
        return view('admin.documents.index', compact('documents'));
    }

    public function create()
    {
        return view('admin.documents.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'file' => 'required|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx|max:20480',
            'category' => 'nullable|max:100',
            'description' => 'nullable',
        ]);

        $validated['file_path'] = $request->file('file')->store('documents', 'public');

        Document::create($validated);

        return redirect()->route('admin.documents.index')
            ->with('success', 'Dokumen berhasil diupload');
    }

    public function edit(Document $document)
    {
        return view('admin.documents.edit', compact('document'));
    }

    // ✅ METHOD DOWNLOAD SUDAH BENAR
    public function download(Document $document)
    {
        if (!Storage::disk('public')->exists($document->file_path)) {
            abort(404, 'File tidak ditemukan');
        }

        $document->increment('downloads');

        $filename = basename($document->file_path);

        return Storage::disk('public')->download(
            $document->file_path,
            $filename
        );
    }

    public function update(Request $request, Document $document)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'file' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx|max:20480',
            'category' => 'nullable|max:100',
            'description' => 'nullable',
        ]);

        if ($request->hasFile('file')) {
            Storage::disk('public')->delete($document->file_path);
            $validated['file_path'] = $request->file('file')->store('documents', 'public');
        }

        $document->update($validated);

        return redirect()->route('admin.documents.index')
            ->with('success', 'Dokumen berhasil diupdate');
    }

    public function destroy(Document $document)
    {
        Storage::disk('public')->delete($document->file_path);
        $document->delete();

        return redirect()->route('admin.documents.index')
            ->with('success', 'Dokumen berhasil dihapus');
    }
}
