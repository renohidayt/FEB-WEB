<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademicCalendar extends Model
{
    use HasFactory;

    protected $fillable = [
        'academic_year',
        'semester',
        'event_name',
        'description',
        'start_date',
        'end_date',
        'event_type',
        'color',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    // Scope untuk filter data aktif
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeSemester($query, $semester)
    {
        return $query->where('semester', $semester);
    }

    public function scopeAcademicYear($query, $year)
    {
        return $query->where('academic_year', $year);
    }

    public function scopeEventType($query, $type)
    {
        return $query->where('event_type', $type);
    }

    // Helper methods
    public function getEventTypeLabelAttribute()
    {
        $types = [
            'perkuliahan' => 'Perkuliahan',
            'ujian' => 'Ujian',
            'libur' => 'Libur',
            'wisuda' => 'Wisuda',
            'registrasi' => 'Registrasi',
            'lainnya' => 'Lainnya',
        ];

        return $types[$this->event_type] ?? 'Lainnya';
    }

    public function getSemesterLabelAttribute()
    {
        return $this->semester === 'ganjil' ? 'Ganjil' : 'Genap';
    }

    public function getDurationDaysAttribute()
    {
        if (!$this->end_date) {
            return 1;
        }

        return $this->start_date->diffInDays($this->end_date) + 1;
    }

    public function getFormattedDateRangeAttribute()
    {
        $start = $this->start_date->translatedFormat('d F Y');
        
        if (!$this->end_date || $this->start_date->eq($this->end_date)) {
            return $start;
        }

        $end = $this->end_date->translatedFormat('d F Y');
        
        return "{$start} - {$end}";
    }

    public function isOngoing()
    {
        $now = now()->startOfDay();
        $start = $this->start_date->startOfDay();
        $end = $this->end_date ? $this->end_date->endOfDay() : $start->endOfDay();

        return $now->between($start, $end);
    }

    public function isUpcoming()
    {
        return $this->start_date->isFuture();
    }

    public function isPast()
    {
        $end = $this->end_date ?? $this->start_date;
        return $end->isPast();
    }
}