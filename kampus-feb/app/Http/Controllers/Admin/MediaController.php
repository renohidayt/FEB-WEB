<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Album;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MediaController extends Controller
{
    public function index(Album $album)
    {
        $album->load(['media' => function($query) {
            $query->orderBy('order');
        }]);

        return view('admin.albums.media', compact('album'));
    }

    public function upload(Request $request, Album $album)
    {
        $request->validate([
            'files' => 'required|array',
            'files.*' => 'file|mimes:jpeg,png,jpg,gif,mp4,mov,avi|max:51200',
        ]);

        $uploadedCount = 0;

        foreach ($request->file('files') as $file) {
            $type = str_starts_with($file->getMimeType(), 'image/') ? 'photo' : 'video';
            $folder = $type === 'photo' ? 'photos' : 'videos';
            
            $filename = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) 
                        . '-' . time() . '-' . Str::random(6) 
                        . '.' . $file->getClientOriginalExtension();
            
            $path = $file->storeAs("albums/{$album->id}/{$folder}", $filename, 'public');

            $album->media()->create([
                'type' => $type,
                'title' => pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME),
                'file_path' => $path,
                'file_name' => $filename,
                'mime_type' => $file->getMimeType(),
                'file_size' => $file->getSize(),
                'order' => $album->media()->max('order') + 1,
            ]);

            $uploadedCount++;
        }

        return redirect()->route('admin.albums.media.index', $album)
            ->with('success', "{$uploadedCount} file berhasil diupload!");
    }

    public function update(Request $request, Album $album, Media $media)
    {
        if ($media->album_id !== $album->id) {
            abort(404);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $media->update($validated);

        return back()->with('success', 'Media berhasil diupdate!');
    }

    public function destroy(Album $album, Media $media)
    {
        if ($media->album_id !== $album->id) {
            abort(404);
        }

        $media->delete();

        return back()->with('success', 'Media berhasil dihapus!');
    }

    public function reorder(Request $request, Album $album)
    {
        $request->validate([
            'media_order' => 'required|array',
            'media_order.*' => 'exists:media,id',
        ]);

        foreach ($request->media_order as $order => $mediaId) {
            Media::where('id', $mediaId)
                ->where('album_id', $album->id)
                ->update(['order' => $order]);
        }

        return back()->with('success', 'Urutan media berhasil diupdate!');
    }

    public function bulkDelete(Request $request, Album $album)
    {
        $request->validate([
            'media_ids' => 'required|array',
            'media_ids.*' => 'exists:media,id',
        ]);

        $media = Media::whereIn('id', $request->media_ids)
            ->where('album_id', $album->id)
            ->get();

        foreach ($media as $item) {
            $item->delete();
        }

        return back()->with('success', count($media) . ' media berhasil dihapus!');
    }
}
