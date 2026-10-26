<?php

declare(strict_types=1);

namespace App\Domains\Marketplace\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'slug', 'description', 'author_id', 'type',
        'price', 'sale_price', 'status', 'preview_image',
        'demo_url', 'version', 'changelog', 'tags',
        'downloads_count', 'rating', 'rating_count', 'is_featured',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'tags' => 'array',
        'changelog' => 'array',
        'is_featured' => 'boolean',
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

    public function reviews(): HasMany
    {
        return $this->hasMany(ProductReview::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
