<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Facility;
use App\Models\FacilityPhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class FacilityController extends Controller
{
    public function index(Request $request)
    {
        $query = Facility::withCount('photos')->latest();

        // Filter berdasarkan kategori
        if ($request->has('category') && $request->category != '') {
            $query->where('category', $request->category);
        }

        $facilities = $query->paginate(20);
        
        return view('admin.facilities.index', compact('facilities'));
    }

    public function create()
    {
        return view('admin.facilities.create');
    }

    public function store(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | DEBUG LOGS — Untuk cek masalah MULTIPLE UPLOAD
        |--------------------------------------------------------------------------
        */
        Log::info('=== UPLOAD DEBUG ===');
        Log::info('Has photos:', ['result' => $request->hasFile('photos')]);
        Log::info('Photos is array:', ['result' => is_array($request->file('photos'))]);

        if ($request->hasFile('photos')) {
            $photos = $request->file('photos');

            Log::info('Photos count:', [
                'count' => is_array($photos) ? count($photos) : 'NOT ARRAY'
            ]);

            if (is_array($photos)) {
                foreach ($photos as $index => $photo) {
                    Log::info("Photo {$index}:", [
                        'name' => $photo->getClientOriginalName(),
                        'size' => $photo->getSize(),
                        'valid' => $photo->isValid(),
                    ]);
                }
            }
        }


        /*
        |--------------------------------------------------------------------------
        | VALIDASI INPUT
        |--------------------------------------------------------------------------
        */
        $validated = $request->validate([
            'name' => 'required|max:255',
            'category' => 'required|max:100',
            'capacity' => 'nullable|max:50',
            'description' => 'nullable',
            'is_active' => 'boolean',
        ]);

        // Validasi foto terpisah
        if ($request->hasFile('photos')) {
            $request->validate([
                'photos'   => 'array|min:1',
                'photos.*' => 'image|mimes:jpeg,png,jpg|max:5120',
            ]);
        }

        $validated['is_active'] = $request->has('is_active');

        $facility = Facility::create($validated);


        /*
        |--------------------------------------------------------------------------
        | UPLOAD MULTIPLE PHOTOS
        |--------------------------------------------------------------------------
        */
        $uploadCount = 0;

        if ($request->hasFile('photos')) {
            $photos = $request->file('photos');

            Log::info('Starting upload loop...');

            foreach ($photos as $index => $photo) {
                Log::info("Processing photo index {$index}");

                $path = $photo->store('facilities', 'public');

                Log::info("Stored at: {$path}");

                FacilityPhoto::create([
                    'facility_id' => $facility->id,
                    'photo'       => $path,
                ]);

                $uploadCount++;
            }
        }

        Log::info('Upload completed:', ['total' => $uploadCount]);
        Log::info('=== END DEBUG ===');


        return redirect()->route('admin.facilities.index')
            ->with('success', "Fasilitas berhasil ditambahkan dengan {$uploadCount} foto");
    }




    public function edit(Facility $facility)
    {
        $facility->load('photos');
        return view('admin.facilities.edit', compact('facility'));
    }

    public function update(Request $request, Facility $facility)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'category' => 'required|max:100',
            'capacity' => 'nullable|max:50',
            'description' => 'nullable',
            'is_active' => 'boolean',
            'photos.*' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $facility->update($validated);

        // Upload new photos
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                $path = $photo->store('facilities', 'public');
                FacilityPhoto::create([
                    'facility_id' => $facility->id,
                    'photo' => $path,
                ]);
            }
        }

        return redirect()->route('admin.facilities.index')
            ->with('success', 'Fasilitas berhasil diupdate');
    }

    public function destroy(Facility $facility)
    {
        foreach ($facility->photos as $photo) {
            Storage::disk('public')->delete($photo->photo);
        }

        $facility->delete();

        return redirect()->route('admin.facilities.index')
            ->with('success', 'Fasilitas berhasil dihapus');
    }

    public function deletePhoto(FacilityPhoto $photo)
    {
        Storage::disk('public')->delete($photo->photo);
        $photo->delete();

        return back()->with('success', 'Foto berhasil dihapus');
    }
}
