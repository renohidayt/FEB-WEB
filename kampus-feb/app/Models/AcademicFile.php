<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class AcademicFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'title',
        'description',
        'file_path',
        'file_name',
        'file_type',
        'file_size',
        'academic_year',
        'semester',
        'is_active',
        'download_count',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Scope
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeKalender($query)
    {
        return $query->where('type', 'kalender');
    }

    public function scopeJadwal($query)
    {
        return $query->where('type', 'jadwal');
    }

    // Helper methods
    public function getFileSizeFormatted()
    {
        $size = $this->file_size;
        $units = ['B', 'KB', 'MB', 'GB'];
        
        for ($i = 0; $size > 1024 && $i < count($units) - 1; $i++) {
            $size /= 1024;
        }
        
        return round($size, 2) . ' ' . $units[$i];
    }

    public function getDownloadUrl()
    {
        return route('academic-files.download', $this->id);
    }

    public function incrementDownload()
    {
        $this->increment('download_count');
    }

    // Delete file when model is deleted
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($file) {
            if (Storage::disk('public')->exists($file->file_path)) {
                Storage::disk('public')->delete($file->file_path);
            }
        });
    }
}