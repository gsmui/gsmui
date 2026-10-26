<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Component extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'slug', 'description', 'category', 'subcategory', 'version',
        'status', 'is_free', 'is_premium', 'price', 'preview_image',
        'code_example', 'installation_guide', 'props_documentation',
        'events_documentation', 'slots_documentation', 'accessibility_notes',
        'dependencies', 'tags', 'downloads_count', 'rating', 'rating_count',
        'is_featured', 'is_deprecated', 'changelog', 'author_id',
    ];

    protected function casts(): array
    {
        return [
            'is_free' => 'boolean', 'is_premium' => 'boolean',
            'is_featured' => 'boolean', 'is_deprecated' => 'boolean',
            'price' => 'decimal:2', 'dependencies' => 'array', 'tags' => 'array',
            'changelog' => 'array', 'rating' => 'float',
            'downloads_count' => 'integer', 'rating_count' => 'integer',
        ];
    }

    public function getRouteKeyName(): string { return 'slug'; }
    public function author() { return $this->belongsTo(User::class, 'author_id'); }
    public function scopeFree($query) { return $query->where('is_free', true); }
    public function scopePremium($query) { return $query->where('is_premium', true); }
    public function scopeFeatured($query) { return $query->where('is_featured', true); }
    public function scopeByCategory($query, $category) { return $query->where('category', $category); }
}
