<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Accreditation extends Model
{
    use HasFactory, SoftDeletes;

    // TYPES
    const TYPE_PT = 'perguruan_tinggi';
    const TYPE_PT_OLD = 'perguruan_tinggi_old';
    const TYPE_PRODI = 'program_studi';
    const TYPE_PRODI_OLD = 'program_studi_old';

    protected $fillable = [
        'type',
        'category',
        'study_program',
        'grade',
        'accreditation_body',
        'certificate_number',
        'certificate_file',
        'valid_from',
        'valid_until',
        'is_active',
        'description',
        'slug',
    ];

    protected $casts = [
        'valid_from' => 'date',
        'valid_until' => 'date',
        'is_active' => 'boolean',
        'download_count' => 'integer',
    ];

    /**
     * Get available accreditation types
     */
    public static function types()
    {
        return [
            self::TYPE_PT => 'Akreditasi Perguruan Tinggi',
            self::TYPE_PT_OLD => 'Akreditasi PT Terdahulu',
            self::TYPE_PRODI => 'Akreditasi Program Studi',
            self::TYPE_PRODI_OLD => 'Riwayat Akreditasi Prodi',
        ];
    }

    /**
     * Get type label
     */
    public function getTypeLabelAttribute()
    {
        return self::types()[$this->type] ?? 'Unknown';
    }

    /**
     * Get categories
     */
    public static function categories()
    {
        return [
            'S1' => 'Strata 1 (S1)',
            'S2' => 'Strata 2 (S2)',
            'D3' => 'Diploma 3 (D3)',
        ];
    }

    /**
     * Existing grades method
     */
    public static function grades()
    {
        return [
            'A' => 'A (Sangat Baik)',
            'B' => 'B (Baik)',
            'C' => 'C (Cukup)',
            'Unggul' => 'Unggul',
            'Baik Sekali' => 'Baik Sekali',
            'Baik' => 'Baik',
        ];
    }

    /**
     * Existing bodies method
     */
    public static function accreditationBodies()
    {
        return [
            'BAN-PT' => 'BAN-PT (Badan Akreditasi Nasional Perguruan Tinggi)',
            'LAM-Infokom' => 'LAM-Infokom',
            'IABEE' => 'IABEE',
            'LAMEMBA' => 'LAMEMBA',
        ];
    }

    /**
     * Check if accreditation is expired
     */
    public function isExpired()
    {
        return $this->valid_until < now();
    }

    /**
     * Check if accreditation is expiring soon (within 6 months)
     */
    public function isExpiringSoon()
    {
        return $this->valid_until->between(now(), now()->addMonths(6));
    }

    /**
     * Get status label
     */
    public function getStatusLabelAttribute()
    {
        if ($this->isExpired()) {
            return 'Kadaluarsa';
        } elseif ($this->isExpiringSoon()) {
            return 'Akan Berakhir';
        } else {
            return 'Aktif';
        }
    }

    /**
     * Get status badge color
     */
    public function getStatusBadgeColorAttribute()
    {
        if ($this->isExpired()) {
            return 'bg-red-100 text-red-800';
        } elseif ($this->isExpiringSoon()) {
            return 'bg-yellow-100 text-yellow-800';
        } else {
            return 'bg-green-100 text-green-800';
        }
    }

    /**
     * Get grade badge color
     */
    public function getGradeBadgeColorAttribute()
    {
        return match($this->grade) {
            'A', 'Unggul' => 'bg-green-100 text-green-800',
            'B', 'Baik Sekali' => 'bg-blue-100 text-blue-800',
            'C', 'Baik' => 'bg-yellow-100 text-yellow-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    /**
     * Get remaining days until expiration
     */
    public function getRemainingDaysAttribute()
    {
        if ($this->isExpired()) {
            return 0;
        }
        return now()->diffInDays($this->valid_until);
    }

    /**
     * Get certificate URL
     */
    public function getCertificateUrlAttribute()
    {
        if ($this->certificate_file && 
            Storage::disk('public')->exists($this->certificate_file)) {
            return asset('storage/' . $this->certificate_file);
        }
        return null;
    }

    /**
     * ============================================
     * SCOPES - UPDATED WITH TYPE FILTER
     * ============================================
     */
    
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeExpired($query)
    {
        return $query->where('valid_until', '<', now());
    }

    public function scopeValid($query)
    {
        return $query->where('valid_until', '>=', now());
    }

    public function scopeExpiringSoon($query)
    {
        return $query->whereBetween('valid_until', [now(), now()->addMonths(6)]);
    }

    public function scopeByGrade($query, $grade)
    {
        return $query->where('grade', $grade);
    }

    public function scopeByProgram($query, $program)
    {
        return $query->where('study_program', $program);
    }

    /**
     * NEW SCOPES FOR TYPE FILTERING
     */
    public function scopePerguruanTinggi($query)
    {
        return $query->where('type', self::TYPE_PT);
    }

    public function scopePerguruanTinggiOld($query)
    {
        return $query->where('type', self::TYPE_PT_OLD);
    }

    public function scopeProgramStudi($query)
    {
        return $query->where('type', self::TYPE_PRODI);
    }

    public function scopeProgramStudiOld($query)
    {
        return $query->where('type', self::TYPE_PRODI_OLD);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    /**
     * NEW: Scope untuk semua data historis program studi (old + expired)
     */
    public function scopeHistorical($query)
    {
        return $query->where(function($q) {
            // Yang sudah di-mark sebagai old
            $q->where('type', self::TYPE_PRODI_OLD)
              // ATAU yang masih type prodi tapi sudah expired
              ->orWhere(function($subQ) {
                  $subQ->where('type', self::TYPE_PRODI)
                       ->where('valid_until', '<', now());
              });
        });
    }

    /**
     * NEW: Scope untuk semua PT historis (old + expired)
     */
    public function scopePerguruanTinggiHistorical($query)
    {
        return $query->where(function($q) {
            $q->where('type', self::TYPE_PT_OLD)
              ->orWhere(function($subQ) {
                  $subQ->where('type', self::TYPE_PT)
                       ->where('valid_until', '<', now());
              });
        });
    }

    /**
     * Increment download count
     */
    public function incrementDownloads()
    {
        $sessionKey = 'accreditation_downloaded_' . $this->id;
        if (!session()->has($sessionKey)) {
            $this->increment('download_count');
            session()->put($sessionKey, true);
        }
    }

    /**
     * Boot method
     */
    protected static function boot()
    {
        parent::boot();

        // Auto-generate slug
        static::creating(function ($accreditation) {
            if (empty($accreditation->slug)) {
                $baseSlug = $accreditation->type . '-' . 
                           ($accreditation->study_program ?? 'pt') . '-' . 
                           $accreditation->grade;
                
                $accreditation->slug = Str::slug($baseSlug);
                
                // Ensure unique slug
                $originalSlug = $accreditation->slug;
                $count = 1;
                while (static::where('slug', $accreditation->slug)->exists()) {
                    $accreditation->slug = $originalSlug . '-' . $count++;
                }
            }
        });

        // Auto-delete certificate file
        static::deleting(function ($accreditation) {
            if ($accreditation->certificate_file && 
                Storage::disk('public')->exists($accreditation->certificate_file)) {
                Storage::disk('public')->delete($accreditation->certificate_file);
            }
        });
    }
}