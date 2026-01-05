<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Scholarship;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ScholarshipController extends Controller
{
    public function index(Request $request)
    {
        $query = Scholarship::latest();

        // Filter berdasarkan kategori
        if ($request->has('category') && $request->category != '') {
            $query->where('category', $request->category);
        }

        // Filter berdasarkan status
        if ($request->has('status')) {
            if ($request->status === 'open') {
                $query->where('registration_start', '<=', now())
                      ->where('registration_end', '>=', now());
            } elseif ($request->status === 'closed') {
                $query->where('registration_end', '<', now());
            } elseif ($request->status === 'upcoming') {
                $query->where('registration_start', '>', now());
            }
        }

        $scholarships = $query->paginate(20);

        // Statistik
        $stats = [
            'total' => Scholarship::count(),
            'active' => Scholarship::where('is_active', true)->count(),
            'open' => Scholarship::where('registration_start', '<=', now())
                                 ->where('registration_end', '>=', now())
                                 ->count(),
            'featured' => Scholarship::where('is_featured', true)->count(),
        ];

        return view('admin.scholarships.index', compact('scholarships', 'stats'));
    }

    public function create()
    {
        return view('admin.scholarships.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'type' => 'required|in:prestasi,kip-k,pemerintah,internal,swasta,tahfidz,penelitian,bantuan_sosial',
            'category' => 'required|in:pemerintah,internal,prestasi,bantuan_ukt,swasta,tahfidz,penelitian,bantuan_sosial',
            'amount' => 'nullable|numeric|min:0',
            'poster' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
            'description' => 'required',
            'requirements' => 'required',
            'provider' => 'nullable|max:255',
            'contact_person' => 'nullable|max:255',
            'contact_phone' => 'nullable|max:20',
            'contact_email' => 'nullable|email|max:255',
            'website_url' => 'nullable|url|max:500',
            'registration_start' => 'nullable|date',
            'registration_end' => 'nullable|date|after_or_equal:registration_start',
            'announcement_date' => 'nullable|date',
            'quota' => 'nullable|integer|min:1',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['is_featured'] = $request->has('is_featured');

        if ($request->hasFile('poster')) {
            $validated['poster'] = $request->file('poster')->store('scholarships', 'public');
        }

        Scholarship::create($validated);

        return redirect()->route('admin.scholarships.index')
            ->with('success', 'Beasiswa berhasil ditambahkan');
    }

    public function show(Scholarship $scholarship)
    {
        return view('admin.scholarships.show', compact('scholarship'));
    }

    public function edit(Scholarship $scholarship)
    {
        return view('admin.scholarships.edit', compact('scholarship'));
    }

    public function update(Request $request, Scholarship $scholarship)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'type' => 'required|in:prestasi,kip-k,pemerintah,internal,swasta,tahfidz,penelitian,bantuan_sosial',
            'category' => 'required|in:pemerintah,internal,prestasi,bantuan_ukt,swasta,tahfidz,penelitian,bantuan_sosial',
            'amount' => 'nullable|numeric|min:0',
            'poster' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
            'description' => 'required',
            'requirements' => 'required',
            'provider' => 'nullable|max:255',
            'contact_person' => 'nullable|max:255',
            'contact_phone' => 'nullable|max:20',
            'contact_email' => 'nullable|email|max:255',
            'website_url' => 'nullable|url|max:500',
            'registration_start' => 'nullable|date',
            'registration_end' => 'nullable|date|after_or_equal:registration_start',
            'announcement_date' => 'nullable|date',
            'quota' => 'nullable|integer|min:1',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['is_featured'] = $request->has('is_featured');

        if ($request->hasFile('poster')) {
            if ($scholarship->poster) {
                Storage::disk('public')->delete($scholarship->poster);
            }
            $validated['poster'] = $request->file('poster')->store('scholarships', 'public');
        }

        $scholarship->update($validated);

        return redirect()->route('admin.scholarships.index')
            ->with('success', 'Beasiswa berhasil diupdate');
    }

    public function destroy(Scholarship $scholarship)
    {
        if ($scholarship->poster) {
            Storage::disk('public')->delete($scholarship->poster);
        }
        
        $scholarship->delete();

        return redirect()->route('admin.scholarships.index')
            ->with('success', 'Beasiswa berhasil dihapus');
    }
}