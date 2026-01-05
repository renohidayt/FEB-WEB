<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facility extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category',
        'capacity',
        'description',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function photos()
    {
        return $this->hasMany(FacilityPhoto::class);
    }

    // Helper untuk kategori
    public static function categories()
{
    return [
        'Akademik' => 'Fasilitas Akademik',
        'Laboratorium' => 'Laboratorium',
        'Perpustakaan' => 'Perpustakaan',
        'Ruang' => 'Ruang Kelas & Dosen',
        'Pelayanan' => 'Pelayanan',
        'Umum' => 'Fasilitas Umum',
        'Olahraga' => 'Fasilitas Olahraga',
        'Lainnya' => 'Lainnya',
    ];
}

}