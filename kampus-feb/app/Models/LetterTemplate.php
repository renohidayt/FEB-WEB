<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LetterTemplate extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'content',
        'form_fields',
        'is_active',
        'sort_order',
        'requires_approval_signature',  // ← TAMBAH
        'approval_title',                // ← TAMBAH
        'approval_name',                 // ← TAMBAH
        'approval_nip',                  // ← TAMBAH
    ];

    protected $casts = [
        'form_fields' => 'array',
        'is_active' => 'boolean',
        'requires_approval_signature' => 'boolean',  // ← TAMBAH
    ];

    public function submissions()
    {
        return $this->hasMany(LetterSubmission::class);
    }

    public function pendingSubmissions()
    {
        return $this->submissions()->where('status', 'pending');
    }

    public function approvedSubmissions()
    {
        return $this->submissions()->where('status', 'approved');
    }
    
    public function scopeActive($query)
    {
        return $query->where('is_active', 1); 
    }
}