<?php

declare(strict_types=1);

namespace App\Domains\Templates\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Template extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'slug', 'description', 'author_id', 'category_id',
        'status', 'is_free', 'is_premium', 'price', 'preview_image',
        'demo_url', 'download_url', 'version', 'changelog',
        'tags', 'downloads_count', 'rating', 'rating_count',
        'is_featured', 'framework', 'industry',
    ];

    protected $casts = [
        'is_free' => 'boolean',
        'is_premium' => 'boolean',
        'is_featured' => 'boolean',
        'price' => 'decimal:2',
        'tags' => 'array',
        'changelog' => 'array',
        'rating' => 'float',
        'downloads_count' => 'integer',
        'rating_count' => 'integer',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(TemplateCategory::class, 'category_id');
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(TemplateReview::class);
    }

    public function scopeFree($query)
    {
        return $query->where('is_free', true);
    }

    public function scopePremium($query)
    {
        return $query->where('is_premium', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }
}
