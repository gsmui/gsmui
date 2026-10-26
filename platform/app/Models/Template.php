<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'slug', 'description', 'long_description', 'category',
        'status', 'is_free', 'is_premium', 'price', 'preview_image',
        'demo_url', 'download_url', 'version', 'author_id',
        'downloads_count', 'rating', 'rating_count', 'is_featured',
        'tags', 'requirements', 'changelog', 'screenshots',
    ];

    protected function casts(): array
    {
        return [
            'is_free' => 'boolean', 'is_premium' => 'boolean',
            'is_featured' => 'boolean', 'price' => 'decimal:2',
            'tags' => 'array', 'requirements' => 'array',
            'changelog' => 'array', 'screenshots' => 'array',
            'rating' => 'float', 'downloads_count' => 'integer',
            'rating_count' => 'integer',
        ];
    }

    public function getRouteKeyName(): string { return 'slug'; }
    public function author() { return $this->belongsTo(User::class, 'author_id'); }
    public function scopeFree($query) { return $query->where('is_free', true); }
    public function scopePremium($query) { return $query->where('is_premium', true); }
    public function scopeFeatured($query) { return $query->where('is_featured', true); }
}
