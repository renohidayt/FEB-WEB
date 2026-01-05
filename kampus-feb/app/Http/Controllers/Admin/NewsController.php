<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\NewsImage;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class NewsController extends Controller
{
    public function index(Request $request)
    {
        $query = News::with('category', 'author');

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('status')) {
            if ($request->status === 'published') {
                $query->where('is_published', true);
            } elseif ($request->status === 'draft') {
                $query->where('is_published', false);
            }
        }

        if ($request->filled('archive')) {
            $archive = explode('-', $request->archive);
            if (count($archive) === 2) {
                $query->whereYear('published_at', $archive[0])
                      ->whereMonth('published_at', $archive[1]);
            }
        }

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('content', 'like', '%' . $request->search . '%');
            });
        }

        $news = $query->latest('created_at')->paginate(20);
        $categories = Category::all();

        $archives = News::select(
                DB::raw('YEAR(published_at) as year'),
                DB::raw('MONTH(published_at) as month'),
                DB::raw('COUNT(*) as count')
            )
            ->whereNotNull('published_at')
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get();

        return view('admin.news.index', compact('news', 'categories', 'archives'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.news.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'category_id' => 'required|exists:categories,id',
            'content' => 'required',
            'excerpt' => 'nullable|max:500',
            'author_name' => 'nullable|string|max:255',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'additional_images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'image_captions.*' => 'nullable|string|max:255',
            'is_published' => 'boolean',
            'show_on_homepage' => 'boolean',
            'allow_comments' => 'boolean',
            'published_at' => 'nullable|date',
            'meta_title' => 'nullable|max:60',
            'meta_description' => 'nullable|max:160',
            'meta_keywords' => 'nullable|max:255',
            'og_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        // FIX: Handle checkbox dengan benar
        $validated['is_published'] = $request->has('is_published') && $request->is_published == '1';
        $validated['show_on_homepage'] = $request->has('show_on_homepage') && $request->show_on_homepage == '1';
        $validated['allow_comments'] = $request->has('allow_comments') && $request->allow_comments == '1';
        
        $validated['slug'] = $this->generateUniqueSlug($validated['title']);
        $validated['author_id'] = auth()->id();

        // FIX: Set published_at dengan benar
        if ($validated['is_published']) {
            // Jika checkbox tercentang tapi tanggal kosong, gunakan sekarang
            if (empty($validated['published_at'])) {
                $validated['published_at'] = now();
            }
        } else {
            // Jika tidak dipublikasi, set null
            $validated['published_at'] = null;
        }

        // Auto-generate excerpt jika kosong
        if (empty($validated['excerpt'])) {
            $validated['excerpt'] = Str::limit(strip_tags($validated['content']), 200);
        }

        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $request->file('featured_image')->store('news', 'public');
        }

        if ($request->hasFile('og_image')) {
            $validated['og_image'] = $request->file('og_image')->store('news/og', 'public');
        }

        $news = News::create($validated);

        // Handle additional images
        if ($request->hasFile('additional_images')) {
            $this->handleAdditionalImages($request, $news);
        }

        return redirect()->route('admin.news.index')
            ->with('success', 'Berita berhasil ditambahkan!');
    }

    // ========================================
    // METHOD YANG HILANG - TAMBAHKAN INI
    // ========================================
    
    /**
     * Display the specified news article
     */
    public function show(News $news)
    {
        // Eager load relationships to avoid N+1 queries
        $news->load('category', 'author', 'images');
        
        return view('admin.news.show', compact('news'));
    }

    /**
     * Show the form for editing the specified news
     */
    public function edit(News $news)
    {
        $news->load('images');
        $categories = Category::all();
        return view('admin.news.edit', compact('news', 'categories'));
    }

    // ========================================
    // END METHOD YANG HILANG
    // ========================================

    public function update(Request $request, News $news)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'category_id' => 'required|exists:categories,id',
            'content' => 'required',
            'excerpt' => 'nullable|max:500',
            'author_name' => 'nullable|string|max:255',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'additional_images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'image_captions.*' => 'nullable|string|max:255',
            'is_published' => 'boolean',
            'show_on_homepage' => 'boolean',
            'allow_comments' => 'boolean',
            'published_at' => 'nullable|date',
            'meta_title' => 'nullable|max:60',
            'meta_description' => 'nullable|max:160',
            'meta_keywords' => 'nullable|max:255',
            'og_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'delete_images' => 'nullable|array',
            'delete_images.*' => 'exists:news_images,id',
        ]);

        // Handle checkbox dengan benar
        $validated['is_published'] = $request->has('is_published') && $request->is_published == '1';
        $validated['show_on_homepage'] = $request->has('show_on_homepage') && $request->show_on_homepage == '1';
        $validated['allow_comments'] = $request->has('allow_comments') && $request->allow_comments == '1';

        if ($news->title !== $validated['title']) {
            $validated['slug'] = $this->generateUniqueSlug($validated['title'], $news->id);
        }

        if ($validated['is_published'] && !$news->is_published && empty($validated['published_at'])) {
            $validated['published_at'] = now();
        }

        if ($request->hasFile('featured_image')) {
            if ($news->featured_image) {
                Storage::disk('public')->delete($news->featured_image);
            }
            $validated['featured_image'] = $request->file('featured_image')->store('news', 'public');
        }

        if ($request->hasFile('og_image')) {
            if ($news->og_image && $news->og_image !== $news->featured_image) {
                Storage::disk('public')->delete($news->og_image);
            }
            $validated['og_image'] = $request->file('og_image')->store('news/og', 'public');
        }

        $news->update($validated);

        // Handle image deletion
        if ($request->filled('delete_images')) {
            $this->deleteNewsImages($request->delete_images);
        }

        // Handle new additional images
        if ($request->hasFile('additional_images')) {
            $this->handleAdditionalImages($request, $news);
        }

        return redirect()->route('admin.news.index')
            ->with('success', 'Berita berhasil diupdate!');
    }

    public function destroy(News $news)
    {
        if ($news->featured_image) {
            Storage::disk('public')->delete($news->featured_image);
        }

        if ($news->og_image && $news->og_image !== $news->featured_image) {
            Storage::disk('public')->delete($news->og_image);
        }

        // Delete all additional images
        foreach ($news->images as $image) {
            Storage::disk('public')->delete($image->image_path);
            $image->delete();
        }

        $news->delete();

        return redirect()->route('admin.news.index')
            ->with('success', 'Berita berhasil dihapus!');
    }

    public function publish(News $news)
    {
        $isPublishing = !$news->is_published;
        
        $news->update([
            'is_published' => $isPublishing,
            'published_at' => $isPublishing ? ($news->published_at ?? now()) : null,
        ]);

        $message = $isPublishing 
            ? '✅ Berita berhasil dipublikasikan!' 
            : '📝 Berita berhasil dijadikan draft!';
        
        return back()->with('success', $message);
    }

    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:publish,unpublish,delete',
            'ids' => 'required|string'
        ]);

        $ids = array_filter(explode(',', $request->ids));
        $action = $request->action;
        $count = 0;

        if (empty($ids)) {
            return back()->with('error', 'Tidak ada item yang dipilih!');
        }

        switch ($action) {
            case 'publish':
                $count = News::whereIn('id', $ids)->update([
                    'is_published' => true,
                    'published_at' => DB::raw('COALESCE(published_at, NOW())')
                ]);
                $message = "✅ $count berita berhasil diterbitkan!";
                break;

            case 'unpublish':
                $count = News::whereIn('id', $ids)->update([
                    'is_published' => false
                ]);
                $message = "📝 $count berita berhasil dijadikan draft!";
                break;

            case 'delete':
                $newsItems = News::with('images')->whereIn('id', $ids)->get();
                
                foreach ($newsItems as $newsItem) {
                    if ($newsItem->featured_image) {
                        Storage::disk('public')->delete($newsItem->featured_image);
                    }
                    if ($newsItem->og_image && $newsItem->og_image !== $newsItem->featured_image) {
                        Storage::disk('public')->delete($newsItem->og_image);
                    }
                    foreach ($newsItem->images as $image) {
                        Storage::disk('public')->delete($image->image_path);
                    }
                }
                
                $count = News::whereIn('id', $ids)->delete();
                $message = "🗑️ $count berita berhasil dihapus!";
                break;

            default:
                return back()->with('error', 'Aksi tidak valid!');
        }

        return redirect()->route('admin.news.index')
            ->with('success', $message);
    }

    private function handleAdditionalImages(Request $request, News $news)
    {
        $captions = $request->input('image_captions', []);
        $order = $news->images()->max('order') ?? 0;

        foreach ($request->file('additional_images') as $index => $image) {
            $path = $image->store('news/gallery', 'public');
            
            NewsImage::create([
                'news_id' => $news->id,
                'image_path' => $path,
                'caption' => $captions[$index] ?? null,
                'order' => ++$order,
            ]);
        }
    }

    private function deleteNewsImages(array $imageIds)
    {
        $images = NewsImage::whereIn('id', $imageIds)->get();
        
        foreach ($images as $image) {
            Storage::disk('public')->delete($image->image_path);
            $image->delete();
        }
    }

    private function generateUniqueSlug($title, $ignoreId = null)
    {
        $slug = Str::slug($title);
        $originalSlug = $slug;
        $count = 1;

        while (true) {
            $query = News::where('slug', $slug);
            
            if ($ignoreId) {
                $query->where('id', '!=', $ignoreId);
            }
            
            if (!$query->exists()) {
                break;
            }
            
            $slug = $originalSlug . '-' . $count;
            $count++;
        }

        return $slug;
    }
}