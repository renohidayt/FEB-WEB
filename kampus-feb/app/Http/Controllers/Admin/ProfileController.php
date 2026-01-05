<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function index()
    {
        $profiles = Profile::latest()->get();
        return view('admin.profiles.index', compact('profiles'));
    }

    public function create()
    {
        // Cek tipe yang sudah digunakan
        $usedTypes = Profile::pluck('type')->toArray();
        $availableTypes = array_diff_key(Profile::TYPES, array_flip($usedTypes));

        if (empty($availableTypes)) {
            return redirect()->route('admin.profiles.index')
                ->with('error', 'Semua tipe profil sudah dibuat. Silakan edit yang sudah ada.');
        }

        return view('admin.profiles.create', compact('availableTypes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => [
                'required',
                Rule::in(array_keys(Profile::TYPES)),
                Rule::unique('profiles', 'type')
            ],
            'name' => 'nullable|string|max:255',
            'content' => 'nullable|string|max:65000',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
        ], [
            'type.unique' => 'Profil dengan tipe ini sudah ada.',
            'photo.max' => 'Ukuran foto maksimal 5MB.',
        ]);

        try {
            DB::beginTransaction();

            // Upload foto jika ada
            if ($request->hasFile('photo')) {
                $validated['photo'] = $this->storeImage($request->file('photo'), 'profiles');
            }

            Profile::create($validated);

            // Clear cache tipe
            cache()->forget("profile.{$validated['type']}");

            DB::commit();

            return redirect()->route('admin.profiles.index')
                ->with('success', 'Profil berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();

            // Hapus foto jika gagal
            if (!empty($validated['photo'])) {
                Storage::disk('public')->delete($validated['photo']);
            }

            return back()->withInput()
                ->with('error', 'Gagal menyimpan profil: ' . $e->getMessage());
        }
    }

    public function edit(Profile $profile)
    {
        return view('admin.profiles.edit', compact('profile'));
    }

    public function update(Request $request, Profile $profile)
    {
        $validated = $request->validate([
            'type' => [
                'required',
                Rule::in(array_keys(Profile::TYPES)),
                Rule::unique('profiles', 'type')->ignore($profile->id),
            ],
            'name' => 'nullable|string|max:255',
            'content' => 'nullable|string|max:65000',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        try {
            DB::beginTransaction();

            $oldPhoto = $profile->photo;

            // upload foto baru
            if ($request->hasFile('photo')) {
                $validated['photo'] = $this->storeImage($request->file('photo'), 'profiles');

                // Hapus foto lama jika ada
                if ($oldPhoto && Storage::disk('public')->exists($oldPhoto)) {
                    Storage::disk('public')->delete($oldPhoto);
                }
            }

            // Update data
            $profile->update($validated);

            // Clear cache
            cache()->forget("profile.{$profile->type}");

            DB::commit();

            return redirect()->route('admin.profiles.index')
                ->with('success', 'Profil berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();

            // rollback foto baru
            if (!empty($validated['photo']) && $validated['photo'] !== $oldPhoto) {
                Storage::disk('public')->delete($validated['photo']);
            }

            return back()->withInput()
                ->with('error', 'Gagal memperbarui profil: ' . $e->getMessage());
        }
    }

    public function destroy(Profile $profile)
    {
        try {
            DB::beginTransaction();

            // Hapus foto jika ada & memang ada di storage
            if ($profile->photo && Storage::disk('public')->exists($profile->photo)) {
                Storage::disk('public')->delete($profile->photo);
            }

            // Hapus cache
            cache()->forget("profile.{$profile->type}");

            // HAPUS PERMANEN BUKAN SOFT DELETE
            $profile->forceDelete();

            DB::commit();

            return redirect()->route('admin.profiles.index')
                ->with('success', 'Profil berhasil dihapus permanen.');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with('error', 'Gagal menghapus profil: ' . $e->getMessage());
        }
    }

    private function storeImage($file, string $path): string
    {
        $filename = Str::random(40) . '.' . $file->getClientOriginalExtension();
        return $file->storeAs($path, $filename, 'public');
    }
}
