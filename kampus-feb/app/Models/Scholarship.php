<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Scholarship extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'category',
        'amount',
        'poster',
        'description',
        'requirements',
        'provider',
        'contact_person',
        'contact_phone',
        'contact_email',
        'website_url',
        'registration_start',
        'registration_end',
        'announcement_date',
        'quota',
        'is_active',
        'is_featured',
        'views'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'registration_start' => 'date',
        'registration_end' => 'date',
        'announcement_date' => 'date',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
    ];

    // Kategori untuk website
    public static function categories()
    {
        return [
            'pemerintah' => 'Beasiswa Pemerintah',
            'internal' => 'Beasiswa Internal Kampus',
            'prestasi' => 'Beasiswa Prestasi',
            'bantuan_ukt' => 'Beasiswa Bantuan UKT',
            'swasta' => 'Beasiswa Swasta / Mitra',
            'tahfidz' => 'Beasiswa Tahfidz / Keagamaan',
            'penelitian' => 'Beasiswa Penelitian & Skripsi',
            'bantuan_sosial' => 'Beasiswa Bantuan Sosial / Zakat (BAZNAS)',
        ];
    }

    // Jenis beasiswa
    public static function types()
    {
        return [
'prestasi' => 'Beasiswa Prestasi',
'kip-k' => 'Beasiswa KIP-K',
'pemerintah' => 'Beasiswa Pemerintah',
'internal' => 'Beasiswa Internal',
'swasta' => 'Beasiswa Swasta',
'tahfidz' => 'Beasiswa Tahfidz',
'penelitian' => 'Beasiswa Penelitian',
'bantuan_sosial' => 'Beasiswa Bantuan Sosial / Zakat (BAZNAS)',

        ];
    }

    // Helper untuk status pendaftaran
    public function getRegistrationStatus()
    {
        if (!$this->registration_start || !$this->registration_end) {
            return 'unknown';
        }

        $now = now();
        
        if ($now < $this->registration_start) {
            return 'upcoming';
        } elseif ($now >= $this->registration_start && $now <= $this->registration_end) {
            return 'open';
        } else {
            return 'closed';
        }
    }

    // Helper untuk badge status
    public function getStatusBadge()
    {
        $status = $this->getRegistrationStatus();
        
        return match($status) {
            'upcoming' => '<span class="px-3 py-1 text-xs font-semibold text-blue-800 bg-blue-100 rounded-full">Segera Dibuka</span>',
            'open' => '<span class="px-3 py-1 text-xs font-semibold text-green-800 bg-green-100 rounded-full">Pendaftaran Dibuka</span>',
            'closed' => '<span class="px-3 py-1 text-xs font-semibold text-red-800 bg-red-100 rounded-full">Pendaftaran Ditutup</span>',
            default => '<span class="px-3 py-1 text-xs font-semibold text-gray-800 bg-gray-100 rounded-full">-</span>',
        };
    }

    // Badge color untuk kategori
    public function getCategoryBadgeColor()
    {
        return match($this->category) {
            'pemerintah' => 'bg-red-100 text-red-800',
            'internal' => 'bg-blue-100 text-blue-800',
            'prestasi' => 'bg-yellow-100 text-yellow-800',
            'bantuan_ukt' => 'bg-green-100 text-green-800',
            'swasta' => 'bg-purple-100 text-purple-800',
            'tahfidz' => 'bg-indigo-100 text-indigo-800',
            'penelitian' => 'bg-pink-100 text-pink-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    // Format nominal
    public function getFormattedAmount()
    {
        if (!$this->amount) {
            return 'Tidak disebutkan';
        }
        
        return 'Rp ' . number_format($this->amount, 0, ',', '.');
    }

    // Scope
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeOpen($query)
    {
        return $query->where('registration_start', '<=', now())
                     ->where('registration_end', '>=', now());
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    // Increment views
    public function incrementViews()
    {
        $this->increment('views');
    }

    // Sisa hari pendaftaran
    public function getRemainingDays()
    {
        if (!$this->registration_end || $this->getRegistrationStatus() !== 'open') {
            return null;
        }

        return now()->diffInDays($this->registration_end);
    }
}