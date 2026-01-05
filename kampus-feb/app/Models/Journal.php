<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Journal extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'field',
        'issn',
        'e_issn',
        'manager',
        'accreditation_status',
        'website_url',
        'submit_url',
        'sinta_url',
        'garuda_url',
        'scholar_url',
        'cover_image',
        'frequency',
        'editor_in_chief',
        'publisher',
        'is_active',
        'is_visible',
        'view_count',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_visible' => 'boolean',
        'view_count' => 'integer',
    ];

    protected $guarded = [
        'id',
        'view_count',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * Boot method
     */
    protected static function boot()
    {
        parent::boot();

        // Auto-generate slug
        static::creating(function ($journal) {
            if (empty($journal->slug)) {
                $journal->slug = Str::slug($journal->name);
                
                // Ensure unique slug
                $originalSlug = $journal->slug;
                $count = 1;
                while (static::where('slug', $journal->slug)->exists()) {
                    $journal->slug = $originalSlug . '-' . $count++;
                }
            }
        });

        // Auto-delete cover image
        static::deleting(function ($journal) {
            if ($journal->cover_image && Storage::disk('public')->exists($journal->cover_image)) {
                Storage::disk('public')->delete($journal->cover_image);
            }
        });
    }

    /**
     * Accessor untuk cover image URL
     */
    public function getCoverUrlAttribute()
    {
        if ($this->cover_image && Storage::disk('public')->exists($this->cover_image)) {
            return asset('storage/' . $this->cover_image);
        }
        return asset('images/default-journal.png');
    }

    /**
     * Get accreditation badge color
     */
    public function getAccreditationBadgeColorAttribute()
    {
        return match($this->accreditation_status) {
            'SINTA 1' => 'bg-danger',
            'SINTA 2' => 'bg-warning',
            'SINTA 3' => 'bg-primary',
            'SINTA 4' => 'bg-info',
            'SINTA 5' => 'bg-success',
            'SINTA 6' => 'bg-secondary',
            'Nasional Terakreditasi' => 'bg-success',
            'Nasional' => 'bg-secondary',
            'Internasional' => 'bg-purple',
            default => 'bg-secondary',
        };
    }

    /**
     * Get available accreditation statuses
     */
    public static function accreditationStatuses()
    {
        return [
            'SINTA 1' => 'SINTA 1',
            'SINTA 2' => 'SINTA 2',
            'SINTA 3' => 'SINTA 3',
            'SINTA 4' => 'SINTA 4',
            'SINTA 5' => 'SINTA 5',
            'SINTA 6' => 'SINTA 6',
            'Nasional Terakreditasi' => 'Nasional Terakreditasi',
            'Nasional' => 'Nasional (Belum Terakreditasi)',
            'Internasional' => 'Internasional',
        ];
    }

    /**
     * Scope: Visible journals
     */
    public function scopeVisible($query)
    {
        return $query->where('is_visible', true);
    }

    /**
     * Scope: Active journals
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope: By manager
     */
    public function scopeByManager($query, $manager)
    {
        return $query->where('manager', $manager);
    }

    /**
     * Scope: By accreditation
     */
    public function scopeByAccreditation($query, $status)
    {
        return $query->where('accreditation_status', $status);
    }

    /**
     * Increment view count
     */
    public function incrementViews()
    {
        $sessionKey = 'journal_viewed_' . $this->id;
        if (!session()->has($sessionKey)) {
            $this->increment('view_count');
            session()->put($sessionKey, true);
        }
    }

    /**
     * Check if journal has complete information
     */
    public function isComplete()
    {
        return !empty($this->name) 
            && !empty($this->field)
            && !empty($this->manager)
            && !empty($this->website_url);
    }

    /**
     * Get profile completeness percentage
     */
    public function getCompletenessAttribute()
    {
        $fields = [
            'name', 'description', 'field', 'issn', 'e_issn', 
            'manager', 'accreditation_status', 'website_url', 
            'cover_image', 'frequency', 'editor_in_chief'
        ];
        
        $filled = 0;
        foreach ($fields as $field) {
            if (!empty($this->$field)) {
                $filled++;
            }
        }
        
        return round(($filled / count($fields)) * 100);
    }
}