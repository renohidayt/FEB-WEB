<?php
// ==================================
// 1. UPDATE FRONTEND CONTROLLER
// File: app/Http/Controllers/Frontend/ProfileController.php
// ==================================

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\Models\OrganizationalStructure; // TAMBAHKAN INI
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function show($type)
    {
        $profile = Profile::where('type', $type)->firstOrFail();
        return view('frontend.profile.show', compact('profile'));
    }

    public function deanGreeting(): View
    {
        $dekan = Profile::getByType(Profile::TYPE_DEKAN);
        
        return view('frontend.profile.dean-greeting', compact('dekan'));
    }

    /**
     * Halaman Visi & Misi
     */
    public function visiMisi(): View
    {
        $visiMisi = Profile::getByType(Profile::TYPE_VISI_MISI);
        
        return view('frontend.profile.visi-misi', compact('visiMisi'));
    }

    /**
     * Halaman Struktur Organisasi (UPDATED)
     */
    public function strukturOrganisasi(): View
    {
        // Get Profile content (jika ada penjelasan tambahan)
        $struktur = Profile::getByType(Profile::TYPE_STRUKTUR);
        
        // Get organizational structure tree (hanya yang aktif)
        $structures = OrganizationalStructure::with(['children' => function($query) {
                $query->where('is_active', true)->orderBy('order');
            }])
            ->roots()
            ->where('is_active', true)
            ->get();
        
        return view('frontend.profile.struktur-organisasi', compact('struktur', 'structures'));
    }

    /**
     * Halaman Sarana & Prasarana
     */
    public function saranaPrasarana(): View
    {
        $sarana = Profile::getByType(Profile::TYPE_SARANA);
        
        return view('frontend.profile.sarana-prasarana', compact('sarana'));
    }

    /**
     * Halaman Kemahasiswaan
     */
    public function kemahasiswaan(): View
    {
        $kemahasiswaan = Profile::getByType(Profile::TYPE_KEMAHASISWAAN);
        
        return view('frontend.profile.kemahasiswaan', compact('kemahasiswaan'));
    }

    /**
     * Halaman Sejarah (static content)
     */
    public function sejarah(): View
    {
        return view('frontend.profile.history');
    }

    public function keunggulanKompetitif()
    {
        // Pastikan nama file blade sesuai dengan folder Anda
        // Contoh: resources/views/frontend/profile/keunggulan.blade.php
        return view('frontend.profile.keunggulan'); 
    }
}