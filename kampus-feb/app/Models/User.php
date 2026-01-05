<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Cache;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * ✅ Gunakan $fillable untuk whitelist (lebih aman daripada $guarded)
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'google_id',
        'avatar',
        'role',
        'is_active',
        'phone',
        'last_login_at',
    ];

    /**
     * ✅ Hide sensitive attributes
     */
    protected $hidden = [
        'password',
        'remember_token',
        'google_id', // ✅ Tambahkan google_id untuk keamanan
    ];

    /**
     * ✅ Cast attributes to proper types
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login_at' => 'datetime',
        'is_active' => 'boolean',
        'password' => 'hashed',
    ];

    /**
     * ✅ Default values untuk new users
     */
    protected $attributes = [
        'role' => 'user',
        'is_active' => true,
    ];

    /**
     * ✅ Boot method untuk auto-lowercase email
     */
    protected static function boot()
    {
        parent::boot();

        // Auto lowercase email saat creating/updating
        static::saving(function ($user) {
            if ($user->isDirty('email')) {
                $user->email = strtolower($user->email);
            }
        });

        // Clear cache saat user di-update/delete
        static::updated(function ($user) {
            Cache::forget("user.{$user->id}.permissions");
        });

        static::deleted(function ($user) {
            Cache::forget("user.{$user->id}.permissions");
        });
    }

    // ==================== ROLE CHECKS ====================

    /**
     * Check if user is super admin
     */
    public function isSuperAdmin(): bool
    {
        return $this->role === 'super_admin';
    }

    /**
     * Check if user is admin (including super admin)
     */
    public function isAdmin(): bool
    {
        return in_array($this->role, ['super_admin', 'admin']);
    }

    /**
     * Check if user is regular user
     */
    public function isUser(): bool
    {
        return $this->role === 'user';
    }

    /**
     * ✅ Check if user has specific role
     */
    public function hasRole(string|array $roles): bool
    {
        if (is_array($roles)) {
            return in_array($this->role, $roles);
        }
        
        return $this->role === $roles;
    }

    /**
     * ✅ Check if user can manage other user
     */
    public function canManage(User $user): bool
    {
        // Super admin can manage everyone
        if ($this->isSuperAdmin()) {
            return true;
        }

        // Admin can only manage regular users
        if ($this->isAdmin() && $user->isUser()) {
            return true;
        }

        return false;
    }

    // ==================== ATTRIBUTES ====================

    /**
     * Get role badge color
     */
    public function getRoleBadgeColorAttribute(): string
    {
        return match($this->role) {
            'super_admin' => 'bg-purple-100 text-purple-800',
            'admin' => 'bg-blue-100 text-blue-800',
            'user' => 'bg-gray-100 text-gray-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    /**
     * Get role label
     */
    public function getRoleLabelAttribute(): string
    {
        return match($this->role) {
            'super_admin' => 'Super Admin',
            'admin' => 'Admin',
            'user' => 'User',
            default => 'Unknown',
        };
    }

    /**
     * Get status badge color
     */
    public function getStatusBadgeColorAttribute(): string
    {
        return $this->is_active 
            ? 'bg-green-100 text-green-800' 
            : 'bg-red-100 text-red-800';
    }

    /**
     * ✅ Get initials for avatar
     */
    public function getInitialsAttribute(): string
    {
        $words = explode(' ', $this->name);
        
        if (count($words) >= 2) {
            return strtoupper(substr($words[0], 0, 1) . substr($words[1], 0, 1));
        }
        
        return strtoupper(substr($this->name, 0, 2));
    }

    /**
     * ✅ Get avatar URL with fallback
     */
    public function getAvatarUrlAttribute(): string
    {
        if ($this->avatar && filter_var($this->avatar, FILTER_VALIDATE_URL)) {
            return $this->avatar;
        }

        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) 
            . '&background=random&size=200';
    }

    // ==================== METHODS ====================

    /**
     * Update last login timestamp
     */
    public function updateLastLogin(): void
    {
        $this->update(['last_login_at' => now()]);
    }

    /**
     * ✅ Toggle active status
     */
    public function toggleStatus(): bool
    {
        return $this->update(['is_active' => !$this->is_active]);
    }

    /**
     * ✅ Activate user
     */
    public function activate(): bool
    {
        return $this->update(['is_active' => true]);
    }

    /**
     * ✅ Deactivate user
     */
    public function deactivate(): bool
    {
        return $this->update(['is_active' => false]);
    }

    /**
     * ✅ Check if user is currently active
     */
    public function isActive(): bool
    {
        return $this->is_active === true;
    }

    /**
     * ✅ Check if user has ever logged in
     */
    public function hasLoggedIn(): bool
    {
        return $this->last_login_at !== null;
    }

    // ==================== SCOPES ====================

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeInactive($query)
    {
        return $query->where('is_active', false);
    }

    public function scopeAdmins($query)
    {
        return $query->whereIn('role', ['super_admin', 'admin']);
    }

    public function scopeSuperAdmins($query)
    {
        return $query->where('role', 'super_admin');
    }

    public function scopeRegularUsers($query)
    {
        return $query->where('role', 'user');
    }

    /**
     * ✅ Scope by role
     */
    public function scopeRole($query, string|array $roles)
    {
        if (is_array($roles)) {
            return $query->whereIn('role', $roles);
        }
        
        return $query->where('role', $roles);
    }

    /**
     * ✅ Scope search users
     */
    public function scopeSearch($query, ?string $search)
    {
        if (!$search) {
            return $query;
        }

        return $query->where(function($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%")
              ->orWhere('phone', 'like', "%{$search}%");
        });
    }

    /**
     * ✅ Scope recently active users
     */
    public function scopeRecentlyActive($query, int $days = 7)
    {
        return $query->where('last_login_at', '>=', now()->subDays($days));
    }

    /**
     * ✅ Scope never logged in
     */
    public function scopeNeverLoggedIn($query)
    {
        return $query->whereNull('last_login_at');
    }

    /**
 * Relationship to Student
 */
public function student()
{
    return $this->hasOne(Student::class);
}

/**
 * Check if user is a student
 */
public function isStudent(): bool
{
    return $this->student !== null;
}

/**
 * Get student NIM if exists
 */
public function getNimAttribute(): ?string
{
    return $this->student?->nim;
}
}