<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Album extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'cover',
        'date',
        'photos_count',
        'videos_count',
        'is_published',
    ];

    protected $casts = [
        'date' => 'date',
        'is_published' => 'boolean',
        'photos_count' => 'integer',
        'videos_count' => 'integer',
    ];

    protected $appends = ['cover_url'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($album) {
            if (empty($album->slug)) {
                $album->slug = Str::slug($album->name);
            }
        });

        static::updating(function ($album) {
            if ($album->isDirty('name')) {
                $album->slug = Str::slug($album->name);
            }
        });
    }

    public function media()
    {
        return $this->hasMany(Media::class)->orderBy('order');
    }

    public function photos()
    {
        return $this->hasMany(Media::class)->where('type', 'photo')->orderBy('order');
    }

    public function videos()
    {
        return $this->hasMany(Media::class)->where('type', 'video')->orderBy('order');
    }

    public function getCoverUrlAttribute()
    {
        if ($this->cover) {
            if (filter_var($this->cover, FILTER_VALIDATE_URL)) {
                return $this->cover;
            }
            return asset('storage/' . $this->cover);
        }
        return asset('images/default-cover.jpg');
    }

    public function updateMediaCounts()
    {
        $this->photos_count = $this->photos()->count();
        $this->videos_count = $this->videos()->count();
        $this->save();
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopeLatest($query)
    {
        return $query->orderBy('date', 'desc');
    }

    
}
