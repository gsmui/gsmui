<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Theme extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'slug', 'description', 'version', 'status', 'is_free',
        'is_premium', 'price', 'preview_image', 'config', 'design_tokens',
        'css_variables', 'author_id', 'downloads_count', 'rating',
        'rating_count', 'is_featured', 'is_default', 'tags',
    ];

    protected function casts(): array
    {
        return [
            'is_free' => 'boolean', 'is_premium' => 'boolean',
            'is_featured' => 'boolean', 'is_default' => 'boolean',
            'price' => 'decimal:2', 'config' => 'array',
            'design_tokens' => 'array', 'css_variables' => 'array',
            'tags' => 'array', 'rating' => 'float',
            'downloads_count' => 'integer', 'rating_count' => 'integer',
        ];
    }

    public function getRouteKeyName(): string { return 'slug'; }
    public function author() { return $this->belongsTo(User::class, 'author_id'); }
    public function scopeFree($query) { return $query->where('is_free', true); }
    public function scopePremium($query) { return $query->where('is_premium', true); }
    public function scopeFeatured($query) { return $query->where('is_featured', true); }
}
