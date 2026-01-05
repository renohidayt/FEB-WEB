<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Display settings form
     */
    public function index()
    {
        $groups = [
            'general' => Setting::byGroup('general')->orderBy('order')->get(),
            'contact' => Setting::byGroup('contact')->orderBy('order')->get(),
            'social_media' => Setting::byGroup('social_media')->orderBy('order')->get(),
            'working_hours' => Setting::byGroup('working_hours')->orderBy('order')->get(),
        ];

        return view('admin.settings.index', compact('groups'));
    }

    /**
     * Update settings
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'settings' => 'required|array',
            'settings.*' => 'nullable|string|max:1000', // Allow nullable values
        ]);

        foreach ($validated['settings'] as $key => $value) {
            // Simpan bahkan jika kosong (null/empty string)
            Setting::set($key, $value ?? '');
        }

        // Clear all cache
        Setting::clearCache();

        return redirect()->route('admin.settings.index')
            ->with('success', 'Pengaturan berhasil diperbarui!');
    }
}