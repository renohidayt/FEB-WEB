<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'start_date',
        'end_date',
        'start_time',
        'end_time',
        'location',
        'organizer',
        'participants',
        'url',
        'poster',
        'keywords',
        'description',
        'status'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    // Auto generate slug
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($event) {
            if (empty($event->slug)) {
                $event->slug = Str::slug($event->title);
            }
        });
    }

    // Scope untuk event yang akan datang
    public function scopeUpcoming($query)
    {
        return $query->where('start_date', '>=', now()->toDateString())
                    ->where('status', 'published')
                    ->orderBy('start_date', 'asc');
    }

    // Scope untuk event yang sudah lewat
    public function scopePast($query)
    {
        return $query->where('end_date', '<', now()->toDateString())
                    ->where('status', 'published')
                    ->orderBy('start_date', 'desc');
    }

    // Check apakah event sedang berlangsung
    public function isOngoing()
    {
        $today = now()->toDateString();
        return $this->start_date <= $today && $this->end_date >= $today;
    }

    // Format tanggal untuk display
    public function getFormattedDateAttribute()
    {
        if ($this->start_date->format('Y-m-d') === $this->end_date->format('Y-m-d')) {
            return $this->start_date->format('d/m/Y');
        }
        return $this->start_date->format('d/m/Y') . ' - ' . $this->end_date->format('d/m/Y');
    }

    // Format waktu untuk display
    public function getFormattedTimeAttribute()
    {
        return date('H:i:s', strtotime($this->start_time)) . ' - ' . date('H:i:s', strtotime($this->end_time));
    }
}