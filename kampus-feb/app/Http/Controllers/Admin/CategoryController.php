<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('news')->paginate(20);
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    // CategoryController.php - Perbaikan store()
public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|max:100|unique:categories,name',
        'description' => 'nullable|max:500',
    ]);

    $validated['slug'] = Str::slug($validated['name']);
    
    // Cek slug unik (jika nama sama tapi beda case)
    $counter = 1;
    $originalSlug = $validated['slug'];
    while (Category::where('slug', $validated['slug'])->exists()) {
        $validated['slug'] = $originalSlug . '-' . $counter++;
    }

    Category::create($validated);

    return redirect()->route('admin.categories.index')
        ->with('success', 'Kategori berhasil ditambahkan');
}

// Perbaikan update()
public function update(Request $request, Category $category)
{
    $validated = $request->validate([
        'name' => 'required|max:100|unique:categories,name,' . $category->id,
        'description' => 'nullable|max:500',
    ]);

    $validated['slug'] = Str::slug($validated['name']);
    
    // Cek slug unik kecuali untuk kategori ini sendiri
    $counter = 1;
    $originalSlug = $validated['slug'];
    while (Category::where('slug', $validated['slug'])
                   ->where('id', '!=', $category->id)
                   ->exists()) {
        $validated['slug'] = $originalSlug . '-' . $counter++;
    }

    $category->update($validated);

    return redirect()->route('admin.categories.index')
        ->with('success', 'Kategori berhasil diupdate');
}

    public function destroy(Category $category)
{
    // Cek apakah kategori memiliki berita
    if ($category->news()->count() > 0) {
        return redirect()->route('admin.categories.index')
            ->with('error', 'Tidak dapat menghapus kategori yang masih memiliki berita');
    }

    $category->delete();

    return redirect()->route('admin.categories.index')
        ->with('success', 'Kategori berhasil dihapus');
}
public function edit($id)
{
    $category = Category::findOrFail($id);
    return view('admin.categories.edit', compact('category'));
}

    
}