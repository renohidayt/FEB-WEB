<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'nim',
        'nik',
        'nama',
        'program_studi',
        'tanggal_masuk',
        'status',
        'jenis',
        'biaya_masuk',
        'jenis_kelamin',
        'tempat_tanggal_lahir',
        'agama',
        'alamat',
        'status_sync'
    ];

    protected $casts = [
        'tanggal_masuk' => 'date',
        'tempat_tanggal_lahir' => 'date',
        'biaya_masuk' => 'decimal:2'
    ];

    /**
     * Relationship to User
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope active students
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'AKTIF');
    }

    /**
     * Scope by program studi
     */
    public function scopeByProdi($query, string $prodi)
    {
        return $query->where('program_studi', $prodi);
    }

    /**
     * Get formatted NIM
     */
    public function getFormattedNimAttribute(): string
    {
        return $this->nim;
    }

    /**
     * Get status badge color
     */
    public function getStatusBadgeAttribute(): string
    {
        return match($this->status) {
            'AKTIF' => '<span class="badge bg-success">Aktif</span>',
            'CUTI' => '<span class="badge bg-warning">Cuti</span>',
            'LULUS' => '<span class="badge bg-info">Lulus</span>',
            'KELUAR' => '<span class="badge bg-danger">Keluar</span>',
            default => '<span class="badge bg-secondary">Unknown</span>'
        };
    }
}