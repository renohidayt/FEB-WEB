<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    public function index()
    {
        $galleries = Gallery::latest()->paginate(20);
        return view('admin.galleries.index', compact('galleries'));
    }

    public function create()
    {
        return view('admin.galleries.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'nullable|max:255',
            'caption' => 'nullable',
            'file' => 'required|file|mimes:jpeg,png,jpg,mp4,mov|max:51200',
            'file_type' => 'required|in:image,video',
            'album' => 'nullable|max:100',
        ]);

        $validated['file_path'] = $request->file('file')->store('gallery', 'public');

        Gallery::create($validated);

        return redirect()->route('admin.galleries.index')
            ->with('success', 'Media berhasil diupload');
    }

    public function destroy(Gallery $gallery)
    {
        Storage::disk('public')->delete($gallery->file_path);
        $gallery->delete();

        return redirect()->route('admin.galleries.index')
            ->with('success', 'Media berhasil dihapus');
    }
}