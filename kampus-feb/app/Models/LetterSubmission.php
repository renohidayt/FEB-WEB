<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class LetterSubmission extends Model
{
    use HasFactory;

    protected $fillable = [
        'letter_template_id',
        'user_id',
        'nama_mahasiswa',
        'nim',
        'prodi',
        'email',
        'no_hp',
        'form_data',
        'attachments',
        'status',
        'admin_notes',
        'generated_letter_path',
        'submitted_at',
        'processed_at',
        'processed_by',
    ];

    protected $casts = [
        'form_data' => 'array',
        'attachments' => 'array',
        'submitted_at' => 'datetime',
        'processed_at' => 'datetime',
    ];

    /**
     * Relationship to template
     */
    public function template()
    {
        return $this->belongsTo(LetterTemplate::class, 'letter_template_id');
    }

    /**
     * Relationship to user (submitter)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relationship to admin who processed
     */
    public function processedBy()
    {
        return $this->belongsTo(User::class, 'processed_by');
    }

    /**
     * Get status badge HTML
     */
    public function getStatusBadgeAttribute()
    {
        return match($this->status) {
            'pending' => '<span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs font-semibold">
                            <i class="fas fa-clock mr-1"></i>Menunggu
                         </span>',
            'processing' => '<span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-semibold">
                               <i class="fas fa-spinner mr-1"></i>Diproses
                            </span>',
            'approved' => '<span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs font-semibold">
                             <i class="fas fa-check-circle mr-1"></i>Disetujui
                          </span>',
            'rejected' => '<span class="px-3 py-1 bg-red-100 text-red-800 rounded-full text-xs font-semibold">
                             <i class="fas fa-times-circle mr-1"></i>Ditolak
                          </span>',
            'cancelled' => '<span class="px-3 py-1 bg-gray-100 text-gray-800 rounded-full text-xs font-semibold">
                              <i class="fas fa-ban mr-1"></i>Dibatalkan
                           </span>',
            default => '<span class="px-3 py-1 bg-gray-100 text-gray-800 rounded-full text-xs font-semibold">Unknown</span>',
        };
    }

    /**
     * Get status text only (no HTML)
     */
    public function getStatusTextAttribute()
    {
        return match($this->status) {
            'pending' => 'Menunggu',
            'processing' => 'Diproses',
            'approved' => 'Disetujui',
            'rejected' => 'Ditolak',
            'cancelled' => 'Dibatalkan',
            default => 'Unknown',
        };
    }

    /**
     * Get status color class
     */
    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'pending' => 'yellow',
            'processing' => 'blue',
            'approved' => 'green',
            'rejected' => 'red',
            'cancelled' => 'gray',
            default => 'gray',
        };
    }

    /**
     * Check if submission can be cancelled
     */
    public function canBeCancelled(): bool
    {
        return $this->status === 'pending';
    }

    /**
     * Check if submission can be processed
     */
    public function canBeProcessed(): bool
    {
        return in_array($this->status, ['pending', 'processing']);
    }

    /**
     * Check if letter is ready to download
     */
    public function hasGeneratedLetter(): bool
    {
        return !empty($this->generated_letter_path) && 
               \Storage::disk('public')->exists($this->generated_letter_path);
    }

    /**
     * Get attachments count
     */
    public function getAttachmentsCountAttribute()
    {
        return is_array($this->attachments) ? count($this->attachments) : 0;
    }

    /**
     * Scope: Filter by status
     */
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope: Pending submissions
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope: Approved submissions
     */
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    /**
     * Scope: By user
     */
    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope: Recent submissions
     */
    public function scopeRecent($query, $days = 7)
    {
        return $query->where('submitted_at', '>=', now()->subDays($days));
    }
}