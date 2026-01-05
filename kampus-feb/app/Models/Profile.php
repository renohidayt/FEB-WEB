<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Profile extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'type',
        'name',
        'photo',
        'content',
    ];

    // ✅ Type constants - Tambah VISI_MISI
    public const TYPE_DEKAN = 'dekan';
    public const TYPE_KEMAHASISWAAN = 'kemahasiswaan';
    public const TYPE_STRUKTUR = 'struktur';
    public const TYPE_SARANA = 'sarana';
    public const TYPE_VISI_MISI = 'visi_misi'; // ✅ Tambah ini

    public const TYPES = [
        self::TYPE_DEKAN => 'Dekan',
        self::TYPE_KEMAHASISWAAN => 'Kemahasiswaan',
        self::TYPE_STRUKTUR => 'Struktur Organisasi',
        self::TYPE_SARANA => 'Sarana & Prasarana',
        self::TYPE_VISI_MISI => 'Visi & Misi', // ✅ Tambah ini
    ];

    // Accessor untuk full URL
    public function getPhotoUrlAttribute(): ?string
{
    if (!$this->photo) {
        return null;
    }

    // Kalau URL sudah lengkap
    if (str_starts_with($this->photo, 'http')) {
        return $this->photo;
    }

    // Cek apakah file benar-benar ada
    if (Storage::disk('public')->exists($this->photo)) {
        return asset('storage/' . $this->photo);
    }

    // Fallback — jika Laravel tidak mendeteksi file, tetap tampilkan URL langsung
    return asset('storage/' . $this->photo);
}


    // Helper dengan caching
    public static function getByType(string $type): ?self
    {
        return cache()->remember("profile.{$type}", 3600, function () use ($type) {
            return self::where('type', $type)->first();
        });
    }

    // Clear cache saat update/delete
    protected static function boot()
    {
        parent::boot();

        static::saved(function ($profile) {
            cache()->forget("profile.{$profile->type}");
        });

        static::deleted(function ($profile) {
            cache()->forget("profile.{$profile->type}");
        });
    }
}