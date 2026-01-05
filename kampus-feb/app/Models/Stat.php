<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stat extends Model
{
    protected $fillable = [
        'key',
        'label',
        'value',
        'icon',
        'color',
        'order',
        'is_active'
    ];

    protected $casts = [
        'value' => 'integer',
        'order' => 'integer',
        'is_active' => 'boolean'
    ];

    /**
     * Scope untuk hanya mengambil stats yang aktif
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope untuk order by order column
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc');
    }

    /**
     * Get color class for display
     */
    public function getColorClass(): string
    {
        return match($this->color) {
            'blue' => 'text-blue-600 bg-blue-100',
            'green' => 'text-green-600 bg-green-100',
            'orange' => 'text-orange-600 bg-orange-100',
            'red' => 'text-red-600 bg-red-100',
            'purple' => 'text-purple-600 bg-purple-100',
            'yellow' => 'text-yellow-600 bg-yellow-100',
            'indigo' => 'text-indigo-600 bg-indigo-100',
            default => 'text-gray-600 bg-gray-100'
        };
    }

    /**
     * Get gradient class for display
     */
    public function getGradientClass(): string
    {
        return match($this->color) {
            'blue' => 'from-blue-500 to-blue-600',
            'green' => 'from-green-500 to-green-600',
            'orange' => 'from-orange-500 to-orange-600',
            'red' => 'from-red-500 to-red-600',
            'purple' => 'from-purple-500 to-purple-600',
            'yellow' => 'from-yellow-500 to-yellow-600',
            'indigo' => 'from-indigo-500 to-indigo-600',
            default => 'from-gray-500 to-gray-600'
        };
    }

    /**
     * Format number with separator
     */
    public function getFormattedValueAttribute(): string
    {
        return number_format($this->value, 0, ',', '.');
    }
}