<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Lecturer extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'nidn',
        'position',
        'employment_status',
        'study_program',
        'expertise',
        'email',
        'phone',
        'google_scholar_url',
        'sinta_id',
        'scopus_id',
        'orcid',
        'courses_taught',
        'teaching_experience',
        'structural_position',
        'academic_degree',
        'education_history',
        'education_s1',
        'education_s2',
        'education_s3',
        'research_interests',
        'publications',
        'conference_papers',
        'books_hki',
        'community_service',
        'certifications',
        'awards',
        'photo',
        'is_visible',
        'is_active',
        'slug',
    ];

    protected $casts = [
        'is_visible' => 'boolean',
        'is_active' => 'boolean',
        'profile_views' => 'integer',
    ];

    // Attributes that should NOT be mass assignable
    protected $guarded = [
        'id',
        'profile_views',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    // Hidden attributes
    protected $hidden = [
        'deleted_at',
    ];

    /**
     * Boot method untuk auto-generate slug dan cleanup
     */
    protected static function boot()
    {
        parent::boot();

        // Auto-generate slug saat create
        static::creating(function ($lecturer) {
            if (empty($lecturer->slug)) {
                $lecturer->slug = Str::slug($lecturer->name);
                
                // Ensure unique slug
                $originalSlug = $lecturer->slug;
                $count = 1;
                while (static::where('slug', $lecturer->slug)->exists()) {
                    $lecturer->slug = $originalSlug . '-' . $count++;
                }
            }
        });

        // Auto-delete photo saat delete
        static::deleting(function ($lecturer) {
            if ($lecturer->photo && Storage::disk('public')->exists($lecturer->photo)) {
                Storage::disk('public')->delete($lecturer->photo);
            }
        });
    }

    /**
     * Accessor untuk photo URL dengan fallback
     */
    public function getPhotoUrlAttribute()
    {
        if ($this->photo && Storage::disk('public')->exists($this->photo)) {
            return asset('storage/' . $this->photo);
        }
        return asset('images/default-lecturer.png');
    }

    /**
     * Accessor untuk display name dengan gelar
     */
    public function getFullNameAttribute()
    {
        $degree = $this->academic_degree ? $this->academic_degree . '. ' : '';
        return $degree . $this->name;
    }

    /**
     * Accessor untuk education summary
     */
    public function getEducationSummaryAttribute()
    {
        $education = [];
        if ($this->education_s1) $education[] = 'S1: ' . $this->education_s1;
        if ($this->education_s2) $education[] = 'S2: ' . $this->education_s2;
        if ($this->education_s3) $education[] = 'S3: ' . $this->education_s3;
        
        return !empty($education) ? implode(' | ', $education) : '-';
    }

    /**
     * Check if profile is complete
     */
    public function isProfileComplete()
    {
        $requiredFields = [
            'name', 'nidn', 'position', 'study_program', 
            'email', 'academic_degree', 'expertise'
        ];
        
        foreach ($requiredFields as $field) {
            if (empty($this->$field)) {
                return false;
            }
        }
        
        return true;
    }

    /**
     * Get profile completion percentage
     */
    public function getProfileCompletenessAttribute()
    {
        $fields = [
            'name', 'nidn', 'position', 'employment_status', 'study_program',
            'expertise', 'email', 'phone', 'photo', 'academic_degree',
            'education_s1', 'education_s2', 'courses_taught', 'teaching_experience',
            'publications', 'certifications', 'google_scholar_url', 'sinta_id'
        ];
        
        $filled = 0;
        foreach ($fields as $field) {
            if (!empty($this->$field)) {
                $filled++;
            }
        }
        
        return round(($filled / count($fields)) * 100);
    }

    /**
     * Scope: Visible lecturers
     */
    public function scopeVisible($query)
    {
        return $query->where('is_visible', true);
    }

    /**
     * Scope: Active lecturers
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope: By study program
     */
    public function scopeByProgram($query, $program)
    {
        return $query->where('study_program', $program);
    }

    /**
     * Scope: By employment status
     */
    public function scopeByEmploymentStatus($query, $status)
    {
        return $query->where('employment_status', $status);
    }

    /**
     * Increment profile views (with session-based rate limiting)
     */
    public function incrementViews()
    {
        $sessionKey = 'lecturer_viewed_' . $this->id;
        if (!session()->has($sessionKey)) {
            $this->increment('profile_views');
            session()->put($sessionKey, true);
        }
    }

    /**
     * Validate NIDN format (10 digits)
     */
    public static function isValidNidn($nidn)
    {
        return preg_match('/^[0-9]{10}$/', $nidn);
    }

    /**
     * Get academic degree options
     */
    public static function academicDegrees()
    {
        return [
            'S1' => 'Sarjana (S1)',
            'S2' => 'Magister (S2)',
            'S3' => 'Doktor (S3)',
            'Prof' => 'Profesor',
        ];
    }

    /**
     * Get employment status options
     */
    public static function employmentStatuses()
    {
        return [
            'Tetap' => 'Dosen Tetap',
            'Tidak Tetap' => 'Dosen Tidak Tetap',
        ];
    }

    /**
     * Get study program badge color
     */
    public function getProgramBadgeColorAttribute()
    {
        return match($this->study_program) {
            'Manajemen' => 'bg-blue-100 text-blue-800',
            'Akutansi' => 'bg-green-100 text-green-800',
            'Magister Manajemen' => 'bg-purple-100 text-purple-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    /**
     * Get employment status badge color
     */
    public function getEmploymentBadgeColorAttribute()
    {
        return match($this->employment_status) {
            'Tetap' => 'bg-success',
            'Tidak Tetap' => 'bg-warning',
            default => 'bg-secondary',
        };
    }
}