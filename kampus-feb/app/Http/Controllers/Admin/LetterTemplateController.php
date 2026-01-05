<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LetterTemplate;
use Illuminate\Http\Request;

class LetterTemplateController extends Controller
{
    public function index()
    {
        $templates = LetterTemplate::withCount('submissions')->latest()->paginate(20);
        return view('admin.letter-templates.index', compact('templates'));
    }

    public function create()
    {
        return view('admin.letter-templates.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
            'content' => 'nullable',
            'form_fields' => 'nullable',
            'requires_approval_signature' => 'nullable|boolean',  // ← TAMBAH
            'approval_title' => 'nullable|required_if:requires_approval_signature,1|max:255',  // ← TAMBAH
            'approval_name' => 'nullable|required_if:requires_approval_signature,1|max:255',   // ← TAMBAH
            'approval_nip' => 'nullable|max:50',  // ← TAMBAH
        ]);

        // Decode JSON form_fields
        if (isset($validated['form_fields']) && is_string($validated['form_fields'])) {
            $validated['form_fields'] = json_decode($validated['form_fields'], true);
        }

        $validated['is_active'] = $request->has('is_active');
        $validated['requires_approval_signature'] = $request->has('requires_approval_signature');  // ← TAMBAH

        LetterTemplate::create($validated);

        return redirect()->route('admin.letter-templates.index')
            ->with('success', 'Template surat berhasil dibuat!');
    }

    public function show(LetterTemplate $letterTemplate)
    {
        $letterTemplate->load('submissions');
        return view('admin.letter-templates.show', compact('letterTemplate'));
    }

    public function edit(LetterTemplate $letterTemplate)
    {
        return view('admin.letter-templates.edit', compact('letterTemplate'));
    }

    public function update(Request $request, LetterTemplate $letterTemplate)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
            'content' => 'nullable',
            'form_fields' => 'nullable',
            'requires_approval_signature' => 'nullable|boolean',  // ← TAMBAH
            'approval_title' => 'nullable|required_if:requires_approval_signature,1|max:255',  // ← TAMBAH
            'approval_name' => 'nullable|required_if:requires_approval_signature,1|max:255',   // ← TAMBAH
            'approval_nip' => 'nullable|max:50',  // ← TAMBAH
        ]);

        if (isset($validated['form_fields']) && is_string($validated['form_fields'])) {
            $validated['form_fields'] = json_decode($validated['form_fields'], true);
        }

        $validated['is_active'] = $request->has('is_active');
        $validated['requires_approval_signature'] = $request->has('requires_approval_signature');  // ← TAMBAH

        $letterTemplate->update($validated);

        return redirect()->route('admin.letter-templates.index')
            ->with('success', 'Template surat berhasil diupdate!');
    }

    public function destroy(LetterTemplate $letterTemplate)
    {
        $letterTemplate->delete();

        return redirect()->route('admin.letter-templates.index')
            ->with('success', 'Template surat berhasil dihapus!');
    }
}