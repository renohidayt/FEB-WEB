<?php
// app/Http/Controllers/Admin/OrganizationalStructureController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrganizationalStructure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OrganizationalStructureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get tree structure for display
        $structures = OrganizationalStructure::with('children')
            ->roots()
            ->get();
        
        // Get all for table view
        $allStructures = OrganizationalStructure::with('parent')
            ->orderBy('order')
            ->paginate(20);

        return view('admin.organizational-structures.index', compact('structures', 'allStructures'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Get all structures for parent dropdown (exclude descendants to prevent circular reference)
        $parentOptions = OrganizationalStructure::orderBy('order')->get();
        
        return view('admin.organizational-structures.create', compact('parentOptions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'nip' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'parent_id' => 'nullable|exists:organizational_structures,id',
            'order' => 'nullable|integer',
            'type' => 'required|in:structural,academic,administrative',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);
        

        // Handle photo upload
        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('organizational-structures', 'public');
        }

        // Check for circular reference
        if ($request->parent_id) {
            $parent = OrganizationalStructure::find($request->parent_id);
            if ($parent && $this->wouldCreateCircularReference($parent, null)) {
                return back()->withErrors(['parent_id' => 'Tidak dapat membuat struktur melingkar'])->withInput();
            }
        }

        OrganizationalStructure::create($validated);

        return redirect()->route('admin.organizational-structures.index')
            ->with('success', 'Struktur organisasi berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(OrganizationalStructure $organizationalStructure)
    {
        $organizationalStructure->load(['parent', 'children', 'descendants']);
        
        return view('admin.organizational-structures.show', compact('organizationalStructure'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OrganizationalStructure $organizationalStructure)
    {
        // Get parent options excluding current node and its descendants
        $parentOptions = OrganizationalStructure::where('id', '!=', $organizationalStructure->id)
            ->orderBy('order')
            ->get()
            ->reject(function ($item) use ($organizationalStructure) {
                // Exclude descendants to prevent circular reference
                return $organizationalStructure->descendants()->pluck('id')->contains($item->id);
            });

        return view('admin.organizational-structures.edit', compact('organizationalStructure', 'parentOptions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, OrganizationalStructure $organizationalStructure)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'nip' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'parent_id' => 'nullable|exists:organizational_structures,id',
            'order' => 'nullable|integer',
            'type' => 'required|in:structural,academic,administrative',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        // Check for circular reference
        if ($request->parent_id && $request->parent_id != $organizationalStructure->parent_id) {
            $parent = OrganizationalStructure::find($request->parent_id);
            if ($parent && $this->wouldCreateCircularReference($parent, $organizationalStructure->id)) {
                return back()->withErrors(['parent_id' => 'Tidak dapat membuat struktur melingkar'])->withInput();
            }
        }

        // Handle photo upload
        if ($request->hasFile('photo')) {
            // Delete old photo
            if ($organizationalStructure->photo) {
                Storage::disk('public')->delete($organizationalStructure->photo);
            }
            $validated['photo'] = $request->file('photo')->store('organizational-structures', 'public');
        }

        $organizationalStructure->update($validated);

        return redirect()->route('admin.organizational-structures.index')
            ->with('success', 'Struktur organisasi berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OrganizationalStructure $organizationalStructure)
    {
        // Check if has children
        if ($organizationalStructure->hasChildren()) {
            return back()->with('error', 'Tidak dapat menghapus struktur yang memiliki bawahan. Hapus bawahan terlebih dahulu.');
        }

        // Delete photo
        if ($organizationalStructure->photo) {
            Storage::disk('public')->delete($organizationalStructure->photo);
        }

        $organizationalStructure->delete();

        return redirect()->route('admin.organizational-structures.index')
            ->with('success', 'Struktur organisasi berhasil dihapus');
    }

    /**
     * Update order (untuk drag & drop reordering)
     */
    public function updateOrder(Request $request)
    {
        $request->validate([
            'items' => 'required|array',
            'items.*.id' => 'required|exists:organizational_structures,id',
            'items.*.order' => 'required|integer',
        ]);

        foreach ($request->items as $item) {
            OrganizationalStructure::where('id', $item['id'])
                ->update(['order' => $item['order']]);
        }

        return response()->json(['message' => 'Urutan berhasil diupdate']);
    }

    /**
     * Get tree data for frontend display (API endpoint)
     */
    public function getTree()
    {
        $structures = OrganizationalStructure::with('descendants')
            ->roots()
            ->active()
            ->get();

        return response()->json($structures);
    }

    /**
     * Check if setting this parent would create circular reference
     */
    private function wouldCreateCircularReference($parent, $currentId = null)
    {
        if (!$parent) {
            return false;
        }

        // Check if parent is the current node
        if ($currentId && $parent->id == $currentId) {
            return true;
        }

        // Check if any ancestor is the current node
        $ancestor = $parent->parent;
        while ($ancestor) {
            if ($currentId && $ancestor->id == $currentId) {
                return true;
            }
            $ancestor = $ancestor->parent;
        }

        return false;
    }
}