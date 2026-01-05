<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Stat;
use Illuminate\Http\Request;

class StatController extends Controller
{
    /**
     * Display a listing of stats
     */
    public function index()
    {
        $stats = Stat::ordered()->get();
        return view('admin.stats.index', compact('stats'));
    }

    /**
     * Show the form for creating a new stat
     */
    public function create()
    {
        return view('admin.stats.create');
    }

    /**
     * Store a newly created stat
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'key' => 'required|string|max:50|unique:stats,key',
            'label' => 'required|string|max:100',
            'value' => 'required|integer|min:0',
            'icon' => 'nullable|string|max:50',
            'color' => 'required|string|in:blue,green,orange,red,purple,yellow,indigo',
            'order' => 'required|integer|min:0',
            'is_active' => 'boolean'
        ]);

        $validated['is_active'] = $request->has('is_active');

        Stat::create($validated);

        return redirect()->route('admin.stats.index')
            ->with('success', 'Statistik berhasil ditambahkan');
    }

    /**
     * Show the form for editing the specified stat
     */
    public function edit(Stat $stat)
    {
        return view('admin.stats.edit', compact('stat'));
    }

    /**
     * Update the specified stat
     */
    public function update(Request $request, Stat $stat)
    {
        $validated = $request->validate([
            'key' => 'required|string|max:50|unique:stats,key,' . $stat->id,
            'label' => 'required|string|max:100',
            'value' => 'required|integer|min:0',
            'icon' => 'nullable|string|max:50',
            'color' => 'required|string|in:blue,green,orange,red,purple,yellow,indigo',
            'order' => 'required|integer|min:0',
            'is_active' => 'boolean'
        ]);

        $validated['is_active'] = $request->has('is_active');

        $stat->update($validated);

        return redirect()->route('admin.stats.index')
            ->with('success', 'Statistik berhasil diupdate');
    }

    /**
     * Remove the specified stat
     */
    public function destroy(Stat $stat)
    {
        $stat->delete();

        return redirect()->route('admin.stats.index')
            ->with('success', 'Statistik berhasil dihapus');
    }

    /**
     * Update order via AJAX
     */
    public function updateOrder(Request $request)
    {
        $order = $request->input('order', []);
        
        foreach ($order as $index => $id) {
            Stat::where('id', $id)->update(['order' => $index]);
        }

        return response()->json(['success' => true]);
    }
}