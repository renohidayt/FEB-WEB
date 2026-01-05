<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeroSlider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class HeroSliderController extends Controller
{
    public function index()
    {
        $sliders = HeroSlider::ordered()->get();
        return view('admin.hero-sliders.index', compact('sliders'));
    }

    public function create()
    {
        return view('admin.hero-sliders.create');
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'title' => 'required|max:255',
                'subtitle' => 'nullable|max:500',
                'tagline' => 'nullable|max:255',
                'button_text' => 'nullable|max:100',
                'button_link' => 'nullable|max:500',
                'media_type' => 'required|in:image,video',
                'media_path' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
                'video_embed' => 'nullable|max:500',
                'video_platform' => 'nullable|in:youtube,vimeo,wistia,custom',
                'order' => 'required|integer|min:0',
                'is_active' => 'boolean'
            ]);

            $validated['is_active'] = $request->has('is_active');

            // Upload image
            if ($request->hasFile('media_path')) {
                $validated['media_path'] = $request->file('media_path')->store('hero-sliders', 'public');
            }

            // Logic Media Type
            if ($request->media_type === 'video') {
                // Cek ketersediaan data video
                if ($request->video_embed && $request->video_platform) {
                    
                    $embedCode = $request->video_embed;

                    // 🛠️ FIX OTOMATIS WISTIA (STORE)
                    if ($request->video_platform === 'wistia') {

    // Jika user paste URL wistia
    if (preg_match('/medias\/([a-zA-Z0-9]+)/', $embedCode, $match)) {
        $embedCode = $match[1];
    }

    // Jika user isi ID langsung (3vpgllgh0b)
    elseif (preg_match('/^[a-zA-Z0-9]+$/', $embedCode)) {
        // biarkan, ini sudah ID valid
        $embedCode = $embedCode;
    }

    else {
        return redirect()->back()
            ->withInput()
            ->with('error', '❌ ID / URL Wistia tidak valid');
    }
}


                    // Simpan ID yang sudah bersih
                    $validated['video_embed'] = $embedCode;
                    $validated['video_platform'] = $request->video_platform;
                    
                    // Kosongkan path gambar karena ini video
                    $validated['media_path'] = null;

                } else {
                    // Jika user pilih video tapi tidak isi link
                    return redirect()->back()
                        ->withInput()
                        ->with('error', '❌ URL Video dan Platform wajib diisi untuk video background.');
                }
            } else {
                // Jika Image, kosongkan data video
                $validated['video_embed'] = null;
                $validated['video_platform'] = null;
            }

            HeroSlider::create($validated);

            return redirect()->route('admin.hero-sliders.index')
                ->with('success', '✅ Hero slider berhasil ditambahkan!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput()
                ->with('error', '❌ Validasi gagal. Periksa data Anda.');

        } catch (\Exception $e) {
            Log::error('Hero Slider Store Error: ' . $e->getMessage());

            return redirect()->back()
                ->withInput()
                ->with('error', '❌ Gagal menyimpan slider: ' . $e->getMessage());
        }
    }

    public function edit(HeroSlider $heroSlider)
    {
        return view('admin.hero-sliders.edit', compact('heroSlider'));
    }

    public function update(Request $request, HeroSlider $heroSlider)
    {
        try {
            $validated = $request->validate([
                'title' => 'required|max:255',
                'subtitle' => 'nullable|max:500',
                'tagline' => 'nullable|max:255',
                'button_text' => 'nullable|max:100',
                'button_link' => 'nullable|max:500',
                'media_type' => 'required|in:image,video',
                'media_path' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
                'video_embed' => 'nullable|max:500',
                'video_platform' => 'nullable|in:youtube,vimeo,wistia,custom',
                'order' => 'required|integer|min:0',
                'is_active' => 'boolean'
            ]);

            $validated['is_active'] = $request->has('is_active');

            // Update image (jika ada upload baru)
            if ($request->hasFile('media_path')) {
                if ($heroSlider->media_path) {
                    Storage::disk('public')->delete($heroSlider->media_path);
                }
                $validated['media_path'] = $request->file('media_path')->store('hero-sliders', 'public');
            }

            // Logic Media Type
            if ($request->media_type === 'video') {
                if ($request->video_embed && $request->video_platform) {
                    
                    $embedCode = $request->video_embed;

                    // 🛠️ FIX OTOMATIS WISTIA (UPDATE)
                    if ($request->video_platform === 'wistia') {
                        if (strpos($embedCode, '/medias/') !== false) {
                            $parts = explode('/medias/', $embedCode);
                            $embedCode = end($parts);
                        }
                    }

                    $validated['video_embed'] = $embedCode;
                    $validated['video_platform'] = $request->video_platform;
                    
                    // Hapus image lama jika ganti ke video
                    if ($heroSlider->media_path) {
                        Storage::disk('public')->delete($heroSlider->media_path);
                        $validated['media_path'] = null;
                    }
                }
            } else {
                // Jika ganti ke image, kosongkan video data
                $validated['video_embed'] = null;
                $validated['video_platform'] = null;
            }

            $heroSlider->update($validated);

            return redirect()->route('admin.hero-sliders.index')
                ->with('success', '✅ Hero slider berhasil diupdate!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput()
                ->with('error', '❌ Validasi gagal. Periksa data Anda.');

        } catch (\Exception $e) {
            Log::error('Hero Slider Update Error: ' . $e->getMessage());

            return redirect()->back()
                ->withInput()
                ->with('error', '❌ Gagal update slider: ' . $e->getMessage());
        }
    }

    public function destroy(HeroSlider $heroSlider)
    {
        try {
            if ($heroSlider->media_path) {
                Storage::disk('public')->delete($heroSlider->media_path);
            }
            $heroSlider->delete();

            return redirect()->route('admin.hero-sliders.index')
                ->with('success', '✅ Hero slider berhasil dihapus');

        } catch (\Exception $e) {
            Log::error('Hero Slider Delete Error: ' . $e->getMessage());

            return redirect()->back()
                ->with('error', '❌ Gagal menghapus slider: ' . $e->getMessage());
        }
    }

    public function updateOrder(Request $request)
    {
        $order = $request->input('order', []);
        foreach ($order as $index => $id) {
            HeroSlider::where('id', $id)->update(['order' => $index]);
        }
        return response()->json(['success' => true]);
    }
}