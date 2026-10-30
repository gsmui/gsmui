<?php

declare(strict_types=1);

namespace App\Domains\Showcase\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShowcaseItem extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id', 'title', 'slug', 'description', 'body',
        'thumbnail', 'gallery', 'category', 'tags',
        'likes_count', 'comments_count', 'status', 'featured',
    ];

    protected $casts = [
        'gallery' => 'array',
        'tags' => 'array',
        'likes_count' => 'integer',
        'comments_count' => 'integer',
        'featured' => 'boolean',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(ShowcaseComment::class);
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }
}
