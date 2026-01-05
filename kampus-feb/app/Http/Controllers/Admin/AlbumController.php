<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Album;
// PENTING: Pastikan Model Media di-import. 
// Jika nama modelnya 'AlbumMedia', gunakan baris ini:
use App\Models\AlbumMedia; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class AlbumController extends Controller
{
    public function index()
    {
        $albums = Album::with('media')
            ->withCount(['media as photos_count' => function ($query) {
                $query->where('type', 'photo');
            }, 'media as videos_count' => function ($query) {
                $query->where('type', 'video');
            }])
            ->latest()
            ->paginate(15);

        return view('admin.albums.index', compact('albums'));
    }

    public function create()
    {
        return view('admin.albums.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date' => 'nullable|date',
            'cover' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Cover max 2MB
            'cover_url' => 'nullable|url',
            'is_published' => 'boolean',
        ]);

        if ($request->hasFile('cover')) {
            $file = $request->file('cover');
            $filename = Str::slug($validated['name']) . '-' . time() . '.' . $file->getClientOriginalExtension();
            $validated['cover'] = $file->storeAs('albums/covers', $filename, 'public');
        } elseif ($request->filled('cover_url')) {
            $validated['cover'] = $validated['cover_url'];
        }

        Album::create($validated);

        return redirect()->route('admin.albums.index')
            ->with('success', 'Album berhasil dibuat!');
    }

    public function show(Album $album)
    {
        // Load media urutkan terbaru/sesuai order
        $album->load(['media' => function($query) {
            $query->latest(); 
        }]);

        return view('admin.albums.show', compact('album'));
    }

    public function edit(Album $album)
    {
        return view('admin.albums.edit', compact('album'));
    }

    public function update(Request $request, Album $album)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date' => 'nullable|date',
            'cover' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'cover_url' => 'nullable|url',
            'is_published' => 'boolean',
        ]);

        if ($request->hasFile('cover')) {
            // Hapus cover lama jika ada dan bukan URL
            if ($album->cover && !filter_var($album->cover, FILTER_VALIDATE_URL)) {
                Storage::disk('public')->delete($album->cover);
            }

            $file = $request->file('cover');
            $filename = Str::slug($validated['name']) . '-' . time() . '.' . $file->getClientOriginalExtension();
            $validated['cover'] = $file->storeAs('albums/covers', $filename, 'public');
        } elseif ($request->filled('cover_url')) {
            $validated['cover'] = $validated['cover_url'];
        }

        $album->update($validated);

        return redirect()->route('admin.albums.index')
            ->with('success', 'Album berhasil diupdate!');
    }

    public function destroy(Album $album)
    {
        // Hapus semua file media fisik
        foreach ($album->media as $media) {
            if (Storage::disk('public')->exists($media->file_path)) {
                Storage::disk('public')->delete($media->file_path);
            }
        }
        
        // Hapus record media di DB (biasanya otomatis via cascade, tapi manual lebih aman)
        $album->media()->delete();

        // Hapus cover album
        if ($album->cover && !filter_var($album->cover, FILTER_VALIDATE_URL)) {
            Storage::disk('public')->delete($album->cover);
        }

        $album->delete();

        return redirect()->route('admin.albums.index')
            ->with('success', 'Album berhasil dihapus!');
    }

    // ----------------------------------------------------------------
    // BAGIAN MEDIA (FOTO & VIDEO)
    // ----------------------------------------------------------------

    public function uploadMedia(Request $request, Album $album)
    {
        // REVISI VALIDASI:
        // 1. Tambahkan mimes lengkap untuk video
        // 2. Naikkan max size ke 100MB (102400 KB) atau sesuaikan kebutuhan server
        $request->validate([
            'files.*' => [
                'required', 
                'file', 
                'mimes:jpeg,jpg,png,gif,webp,mp4,mov,avi,mkv', 
                'max:102400' // 100 MB (102400 KB)
            ],
        ], [
            'files.*.max' => 'Ukuran file terlalu besar. Maksimal 100MB per file.',
            'files.*.mimes' => 'Format file tidak didukung.'
        ]);

        foreach ($request->file('files', []) as $file) {
            // Tentukan folder berdasarkan tipe (opsional, biar rapi)
            $type = str_contains($file->getMimeType(), 'image') ? 'photos' : 'videos';
            $path = $file->store("albums/{$album->id}/{$type}", 'public');

            $album->media()->create([
                'title' => pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME),
                'file_path' => $path,
                'file_name' => $file->getClientOriginalName(),
                'mime_type' => $file->getClientMimeType(),
                'type' => str_contains($file->getMimeType(), 'image') ? 'photo' : 'video',
                'file_size' => $file->getSize(),
                'order' => 0,
            ]);
        }

        return redirect()->back()->with('success', 'Media berhasil diupload!');
    }

    /**
     * Hapus Media Spesifik
     * Perhatikan parameter ke-2: $id bukan binding model agar lebih aman jika binding error
     */
   public function destroyMedia(Album $album, $id)
{
    // CARA BARU: Cari media melalui relasi album (otomatis memfilter album_id)
    $media = $album->media()->findOrFail($id);

    // 1. Hapus file fisik dari storage
    if ($media->file_path && Storage::disk('public')->exists($media->file_path)) {
        Storage::disk('public')->delete($media->file_path);
    }

    // 2. Hapus data dari database
    $media->delete();

    return redirect()->back()->with('success', 'File berhasil dihapus!');
}
    /**
     * Menampilkan halaman kelola media (Gallery)
     */
    public function mediaIndex(Album $album)
    {
        // Load relasi media agar bisa ditampilkan
        $album->load(['media' => function($query) {
            $query->latest(); // Mengurutkan dari yang terbaru
        }]);

        // PENTING: Pastikan nama view ini sesuai dengan lokasi file blade Anda.
        // Jika file blade perbaikan tadi Anda simpan sebagai 'show.blade.php', gunakan 'admin.albums.show'
        // Jika Anda simpan sebagai 'media/index.blade.php', gunakan 'admin.albums.media.index'
        return view('admin.albums.media.index', compact('album'));
    }
}