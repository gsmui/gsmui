<?php

declare(strict_types=1);

namespace App\Domains\Components\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Component extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, LogsActivity, SoftDeletes;

    protected $fillable = [
        'name', 'slug', 'description', 'category', 'subcategory', 'version',
        'status', 'is_free', 'is_premium', 'price', 'preview_image',
        'code_example', 'installation_guide', 'props_documentation',
        'events_documentation', 'slots_documentation', 'accessibility_notes',
        'dependencies', 'tags', 'downloads_count', 'rating', 'rating_count',
        'is_featured', 'is_deprecated', 'changelog', 'author_id',
    ];

    protected $casts = [
        'is_free' => 'boolean',
        'is_premium' => 'boolean',
        'is_featured' => 'boolean',
        'is_deprecated' => 'boolean',
        'price' => 'decimal:2',
        'dependencies' => 'array',
        'tags' => 'array',
        'changelog' => 'array',
        'rating' => 'float',
        'downloads_count' => 'integer',
        'rating_count' => 'integer',
    ];

    protected static $logAttributes = ['name', 'slug', 'status', 'version'];
    protected static $logOnlyDirty = true;

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function versions(): HasMany
    {
        return $this->hasMany(ComponentVersion::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(ComponentReview::class);
    }

    public function categories(): MorphToMany
    {
        return $this->morphToMany(ComponentCategory::class, 'categorizable');
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

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeDeprecated($query)
    {
        return $query->where('is_deprecated', true);
    }
}
