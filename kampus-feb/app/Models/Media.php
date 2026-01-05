<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Media extends Model
{
    use HasFactory;

    protected $fillable = [
        'album_id',
        'type',
        'title',
        'file_path',
        'file_name',
        'mime_type',
        'file_size',
        'order',
    ];

    protected $casts = [
        'file_size' => 'integer',
        'order' => 'integer',
    ];

    protected $appends = ['url', 'size_formatted'];

    public function album()
    {
        return $this->belongsTo(Album::class);
    }

    public function getUrlAttribute()
    {
        return asset('storage/' . $this->file_path);
    }

    public function getSizeFormattedAttribute()
    {
        $bytes = $this->file_size;
        $units = ['B', 'KB', 'MB', 'GB'];
        
        for ($i = 0; $bytes > 1024; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, 2) . ' ' . $units[$i];
    }

    public function isPhoto()
    {
        return $this->type === 'photo';
    }

    public function isVideo()
    {
        return $this->type === 'video';
    }

    public function deleteFile()
    {
        if (Storage::disk('public')->exists($this->file_path)) {
            Storage::disk('public')->delete($this->file_path);
        }
    }

    protected static function boot()
    {
        parent::boot();

        static::deleted(function ($media) {
            $media->deleteFile();
            $media->album->updateMediaCounts();
        });

        static::created(function ($media) {
            $media->album->updateMediaCounts();
        });
    }
}
