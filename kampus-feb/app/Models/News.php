<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class News extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'category_id',
        'content',
        'excerpt',
        'featured_image',
        'author_id',
        'author_name', // Field baru untuk input penulis manual
        'views',
        'reading_time',
        'is_published',
        'show_on_homepage',
        'allow_comments',
        'published_at',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'og_image',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'show_on_homepage' => 'boolean',
        'allow_comments' => 'boolean',
        'published_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($news) {
            if (empty($news->slug)) {
                $news->slug = Str::slug($news->title);
            }
            
            if (empty($news->author_id)) {
                $news->author_id = auth()->id();
            }

            // Auto-calculate reading time
            if (!empty($news->content)) {
                $words = str_word_count(strip_tags($news->content));
                $news->reading_time = ceil($words / 200);
            }
        });

        static::updating(function ($news) {
            // Recalculate reading time on update
            if ($news->isDirty('content')) {
                $words = str_word_count(strip_tags($news->content));
                $news->reading_time = ceil($words / 200);
            }
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function images()
    {
        return $this->hasMany(NewsImage::class)->orderBy('order');
    }

    /*
    |--------------------------------------------------------------------------
    | Query Scopes
    |--------------------------------------------------------------------------
    */

    public function scopePublished($query)
    {
        return $query->where('is_published', true)
                    ->whereNotNull('published_at')
                    ->where('published_at', '<=', now());
    }

    public function scopeDraft($query)
    {
        return $query->where('is_published', false);
    }

    public function scopeOnHomepage($query)
    {
        return $query->where('show_on_homepage', true);
    }

    public function scopeCommentsAllowed($query)
    {
        return $query->where('allow_comments', true);
    }

    public function scopeLatestPublished($query)
    {
        return $query->orderBy('published_at', 'desc');
    }

    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors & Mutators
    |--------------------------------------------------------------------------
    */

    public function getExcerptAttribute($value)
    {
        if ($value) {
            return $value;
        }
        return Str::limit(strip_tags($this->content), 150, '...');
    }

    public function getMetaTitleAttribute($value)
    {
        return $value ?: $this->title;
    }

    public function getMetaDescriptionAttribute($value)
    {
        return $value ?: $this->excerpt;
    }

    public function getOgImageAttribute($value)
    {
        return $value ?: $this->featured_image;
    }

    public function getFeaturedImageUrlAttribute()
    {
        return $this->featured_image 
            ? asset('storage/' . $this->featured_image)
            : asset('images/default-news.jpg');
    }

    public function getOgImageUrlAttribute()
    {
        $ogImage = $this->og_image ?: $this->featured_image;
        return $ogImage 
            ? asset('storage/' . $ogImage)
            : asset('images/default-og.jpg');
    }

    // Get display author name (prioritize manual input over user)
    public function getAuthorDisplayNameAttribute()
    {
        return $this->author_name ?: ($this->author->name ?? 'Unknown');
    }

    /*
    |--------------------------------------------------------------------------
    | Helper Methods
    |--------------------------------------------------------------------------
    */

    public function incrementViews()
    {
        $this->increment('views');
    }

    public function getReadingTime()
    {
        return $this->reading_time ?: ceil(str_word_count(strip_tags($this->content)) / 200);
    }

    public function getReadingTimeText()
    {
        $minutes = $this->getReadingTime();
        return $minutes . ' menit baca';
    }

    public function getFormattedPublishedDate()
    {
        if (!$this->published_at) {
            return null;
        }
        
        return $this->published_at->locale('id')->isoFormat('D MMMM YYYY');
    }

    public function getPublishedDateForHumans()
    {
        if (!$this->published_at) {
            return null;
        }
        
        return $this->published_at->locale('id')->diffForHumans();
    }

    public function isNew()
    {
        if (!$this->published_at) {
            return false;
        }
        
        return $this->published_at->isAfter(now()->subDays(7));
    }

    public function getUrlAttribute()
    {
        return route('news.show', $this->slug);
    }

    public function getEditUrlAttribute()
    {
        return route('admin.news.edit', $this);
    }
}