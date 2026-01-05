<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrganizationalStructure extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'position',
        'nip',
        'email',
        'phone',
        'photo',
        'parent_id',
        'order',
        'type',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get parent (atasan)
     */
    public function parent()
    {
        return $this->belongsTo(OrganizationalStructure::class, 'parent_id');
    }

    /**
     * Get children (bawahan langsung)
     */
    public function children()
    {
        return $this->hasMany(OrganizationalStructure::class, 'parent_id')
                    ->orderBy('order');
    }

    /**
     * Get all descendants (semua bawahan, termasuk cucu, cicit, dst)
     */
    public function descendants()
    {
        return $this->children()->with('descendants');
    }

    /**
     * Get ancestors (semua atasan sampai root)
     */
    public function ancestors()
    {
        $ancestors = collect([]);
        $parent = $this->parent;

        while ($parent) {
            $ancestors->push($parent);
            $parent = $parent->parent;
        }

        return $ancestors;
    }

    /**
     * Check if this is root (Dekan/Rektor)
     */
    public function isRoot()
    {
        return is_null($this->parent_id);
    }

    /**
     * Check if has children
     */
    public function hasChildren()
    {
        return $this->children()->exists();
    }

    /**
     * Get level/depth in hierarchy (0 = root)
     */
    public function getLevel()
    {
        return $this->ancestors()->count();
    }

    /**
     * Scope: Get only root nodes
     */
    public function scopeRoots($query)
    {
        return $query->whereNull('parent_id')->orderBy('order');
    }

    /**
     * Scope: Get only active
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope: By type
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Get full hierarchical path
     * Example: "Dekan > Wakil Dekan I > Ketua Prodi TI"
     */
    public function getHierarchyPath()
    {
        $path = collect([$this->position]);
        
        foreach ($this->ancestors() as $ancestor) {
            $path->prepend($ancestor->position);
        }

        return $path->implode(' > ');
    }

    /**
     * Boot method
     */
    protected static function boot()
    {
        parent::boot();

        // Auto-set order when creating
        static::creating(function ($structure) {
            if (is_null($structure->order)) {
                $maxOrder = static::where('parent_id', $structure->parent_id)->max('order');
                $structure->order = $maxOrder + 1;
            }
        });

        // Delete photo when deleting record
        static::deleting(function ($structure) {
            if ($structure->photo) {
                \Storage::delete($structure->photo);
            }
        });
    }
}