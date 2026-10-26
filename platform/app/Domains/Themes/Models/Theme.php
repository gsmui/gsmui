<?php

declare(strict_types=1);

namespace App\Domains\Themes\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Theme extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'slug', 'description', 'author_id', 'status',
        'is_free', 'is_premium', 'price', 'tokens', 'preview_image',
        'downloads_count', 'rating', 'rating_count', 'is_featured',
        'version', 'changelog', 'tags',
    ];

    protected $casts = [
        'tokens' => 'array',
        'tags' => 'array',
        'changelog' => 'array',
        'is_free' => 'boolean',
        'is_premium' => 'boolean',
        'is_featured' => 'boolean',
        'price' => 'decimal:2',
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

    public function variations(): HasMany
    {
        return $this->hasMany(ThemeVariation::class);
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
