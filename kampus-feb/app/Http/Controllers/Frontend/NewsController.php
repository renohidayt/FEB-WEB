<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class NewsController extends Controller
{
    /**
     * Display a listing of published news
     */
    public function index(Request $request)
    {
        $query = News::with(['category', 'author'])
            ->published()
            ->latest('published_at');

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%")
                  ->orWhere('excerpt', 'like', "%{$search}%")
                  ->orWhere('meta_keywords', 'like', "%{$search}%");
            });
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Sort options
        $sort = $request->get('sort', 'latest');
        switch ($sort) {
            case 'popular':
                $query->orderBy('views', 'desc');
                break;
            case 'oldest':
                $query->oldest('published_at');
                break;
            case 'latest':
            default:
                $query->latest('published_at');
                break;
        }

        $news = $query->paginate(12)->withQueryString();
        
        // Cache categories with news count (24 hours)
        $categories = Cache::remember('categories_with_count', 86400, function () {
            return Category::withCount(['news' => function($query) {
                $query->published();
            }])->orderBy('name')->get();
        });
        
        // Cache popular news (1 hour)
        $popularNews = Cache::remember('popular_news', 3600, function () {
            return News::with(['category'])
                ->published()
                ->orderBy('views', 'desc')
                ->take(5)
                ->get();
        });

        // Latest news for sidebar (30 minutes)
        $latestNews = Cache::remember('latest_news_sidebar', 1800, function () {
            return News::with(['category'])
                ->published()
                ->latest('published_at')
                ->take(5)
                ->get();
        });

        return view('frontend.news.index', compact('news', 'categories', 'popularNews', 'latestNews', 'sort'));
    }

    /**
     * Display the specified news article
     */
    public function show($slug)
    {
        // Eager load necessary relationships including images
        $news = News::with(['category', 'author', 'images' => function($query) {
                $query->orderBy('order');
            }])
            ->where('slug', $slug)
            ->published()
            ->firstOrFail();

        // Increment views with rate limiting to prevent spam
        $this->incrementViews($news);

        // Cache related news for this article (2 hours)
        $relatedNews = Cache::remember("related_news_{$news->id}", 7200, function () use ($news) {
            return News::with(['category', 'author'])
                ->published()
                ->where('category_id', $news->category_id)
                ->where('id', '!=', $news->id)
                ->latest('published_at')
                ->take(4)
                ->get();
        });

        // Cache categories with news count (24 hours)
        $categories = Cache::remember('categories_with_count', 86400, function () {
            return Category::withCount(['news' => function($query) {
                $query->published();
            }])->orderBy('name')->get();
        });

        // Cache archives (24 hours)
        $archives = Cache::remember('news_archives_with_names', 86400, function () {
            $monthNames = [
                1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
            ];

            return News::select(
                    DB::raw('YEAR(published_at) as year'),
                    DB::raw('MONTH(published_at) as month'),
                    DB::raw('COUNT(*) as count')
                )
                ->published()
                ->whereNotNull('published_at')
                ->groupBy('year', 'month')
                ->orderBy('year', 'desc')
                ->orderBy('month', 'desc')
                ->take(12)
                ->get()
                ->map(function($archive) use ($monthNames) {
                    $archive->month_name = $monthNames[$archive->month];
                    return $archive;
                });
        });

        // Cache popular news (1 hour) - exclude current news
        $popularNews = Cache::remember("popular_news_exclude_{$news->id}", 3600, function () use ($news) {
            return News::with(['category'])
                ->published()
                ->where('id', '!=', $news->id)
                ->orderBy('views', 'desc')
                ->take(5)
                ->get();
        });

        // Latest news for sidebar (cached, 30 minutes)
        $latestNews = Cache::remember('latest_news_sidebar', 1800, function () {
            return News::with(['category'])
                ->published()
                ->latest('published_at')
                ->take(5)
                ->get();
        });

        // Log activity for analytics (optional)
        // activity()->log("Viewed news: {$news->title}");

        return view('frontend.news.show', compact('news', 'relatedNews', 'categories', 'archives', 'popularNews', 'latestNews'));
    }

    /**
     * Display news by category
     */
    public function category($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();

        $query = News::with(['category', 'author'])
            ->where('category_id', $category->id)
            ->published()
            ->latest('published_at');

        $news = $query->paginate(12);

        // Cache categories with news count
        $categories = Cache::remember('categories_with_count', 86400, function () {
            return Category::withCount(['news' => function($query) {
                $query->published();
            }])->orderBy('name')->get();
        });

        // Popular news in this category (cached per category, 2 hours)
        $popularNews = Cache::remember("popular_news_category_{$category->id}", 7200, function () use ($category) {
            return News::with(['category'])
                ->published()
                ->where('category_id', $category->id)
                ->orderBy('views', 'desc')
                ->take(5)
                ->get();
        });

        return view('frontend.news.category', compact('category', 'news', 'categories', 'popularNews'));
    }

    /**
     * Display news archive (by month/year)
     */
    public function archive(Request $request)
    {
        // Validate archive parameters
        $request->validate([
            'year' => 'nullable|integer|min:2000|max:' . (date('Y') + 1),
            'month' => 'nullable|integer|min:1|max:12',
        ]);

        // Cache archive list with month names (24 hours)
        $archives = Cache::remember('news_archives_with_names', 86400, function () {
            $monthNames = [
                1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
            ];

            return News::select(
                    DB::raw('YEAR(published_at) as year'),
                    DB::raw('MONTH(published_at) as month'),
                    DB::raw('COUNT(*) as count')
                )
                ->published()
                ->whereNotNull('published_at')
                ->groupBy('year', 'month')
                ->orderBy('year', 'desc')
                ->orderBy('month', 'desc')
                ->get()
                ->map(function($archive) use ($monthNames) {
                    $archive->month_name = $monthNames[$archive->month];
                    return $archive;
                });
        });

        $news = collect();
        $selectedYear = null;
        $selectedMonth = null;

        // If specific archive selected
        if ($request->filled('year') && $request->filled('month')) {
            $selectedYear = (int) $request->year;
            $selectedMonth = (int) $request->month;

            $news = News::with(['category', 'author'])
                ->published()
                ->whereYear('published_at', $selectedYear)
                ->whereMonth('published_at', $selectedMonth)
                ->latest('published_at')
                ->paginate(15)
                ->withQueryString();
        }

        // Cache categories
        $categories = Cache::remember('categories_with_count', 86400, function () {
            return Category::withCount(['news' => function($query) {
                $query->published();
            }])->orderBy('name')->get();
        });

        return view('frontend.news.archive', compact('archives', 'news', 'selectedYear', 'selectedMonth', 'categories'));
    }

    /**
     * Search news with advanced options
     */
    public function search(Request $request)
    {
        $request->validate([
            'q' => 'required|string|min:3|max:100',
            'category' => 'nullable|exists:categories,id',
            'date_from' => 'nullable|date',
            'date_to' => 'nullable|date|after_or_equal:date_from',
        ]);

        $query = News::with(['category', 'author'])
            ->published();

        // Search query
        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%")
                  ->orWhere('excerpt', 'like', "%{$search}%")
                  ->orWhere('meta_keywords', 'like', "%{$search}%");
            });
        }

        // Category filter
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Date range filter
        if ($request->filled('date_from')) {
            $query->whereDate('published_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('published_at', '<=', $request->date_to);
        }

        $news = $query->latest('published_at')
            ->paginate(15)
            ->withQueryString();

        $categories = Category::withCount(['news' => function($query) {
            $query->published();
        }])->orderBy('name')->get();

        return view('frontend.news.search', compact('news', 'categories'));
    }

    /**
     * Get trending news (most viewed in last 7 days)
     */
    public function trending()
    {
        // Cache trending news for 1 hour
        $trendingNews = Cache::remember('trending_news', 3600, function () {
            return News::with(['category', 'author'])
                ->published()
                ->where('published_at', '>=', now()->subDays(7))
                ->orderBy('views', 'desc')
                ->take(10)
                ->get();
        });

        $categories = Cache::remember('categories_with_count', 86400, function () {
            return Category::withCount(['news' => function($query) {
                $query->published();
            }])->orderBy('name')->get();
        });

        return view('frontend.news.trending', compact('trendingNews', 'categories'));
    }

    /**
     * Increment news views with rate limiting
     */
    protected function incrementViews(News $news)
    {
        // Create unique key per user/IP and news article
        $key = 'news_view_' . $news->id . '_' . request()->ip();
        
        // Rate limit: 1 view per user per article per hour
        if (RateLimiter::tooManyAttempts($key, 1)) {
            return;
        }

        // Increment views
        $news->increment('views');

        // Mark this view in rate limiter
        RateLimiter::hit($key, 3600); // 1 hour
    }

    /**
     * Generate sitemap for news
     */
    public function sitemap()
    {
        // Cache sitemap for 24 hours
        $news = Cache::remember('news_sitemap', 86400, function () {
            return News::select('slug', 'updated_at', 'published_at')
                ->published()
                ->latest('published_at')
                ->get();
        });

        return response()->view('frontend.news.sitemap', compact('news'))
            ->header('Content-Type', 'text/xml');
    }

    /**
     * RSS Feed
     */
    public function feed()
    {
        // Cache RSS feed for 1 hour
        $news = Cache::remember('news_rss_feed', 3600, function () {
            return News::with(['category', 'author'])
                ->published()
                ->latest('published_at')
                ->take(20)
                ->get();
        });

        return response()->view('frontend.news.feed', compact('news'))
            ->header('Content-Type', 'application/rss+xml');
    }

    /**
     * Clear all news-related caches (for admin use)
     */
    public function clearCache()
    {
        // This should be protected with admin middleware
        Cache::forget('categories_with_count');
        Cache::forget('popular_news');
        Cache::forget('latest_news_sidebar');
        Cache::forget('news_archives');
        Cache::forget('news_archives_with_names');
        Cache::forget('trending_news');
        Cache::forget('news_sitemap');
        Cache::forget('news_rss_feed');

        // Clear individual category caches
        $categories = Category::all();
        foreach ($categories as $category) {
            Cache::forget("popular_news_category_{$category->id}");
        }

        // Clear individual news caches
        $allNews = News::all();
        foreach ($allNews as $newsItem) {
            Cache::forget("related_news_{$newsItem->id}");
            Cache::forget("popular_news_exclude_{$newsItem->id}");
        }

        return back()->with('success', 'Cache berita berhasil dibersihkan!');
    }
}