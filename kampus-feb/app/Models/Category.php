<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
    ];

    /**
     * Boot method - HAPUS auto slug di sini
     * Biarkan controller yang handle untuk validasi lebih baik
     */
    protected static function boot()
    {
        parent::boot();
        
        // Pindahkan logic slug ke controller
        // untuk kontrol validasi yang lebih baik
    }

    public function news()
    {
        return $this->hasMany(News::class);
    }

    public function publishedNews()
    {
        return $this->hasMany(News::class)->published();
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeWithNewsCount($query)
    {
        return $query->withCount(['news' => function($q) {
            $q->published();
        }]);
    }

    public function getUrlAttribute()
    {
        return route('news.category', $this->slug);
    }
}