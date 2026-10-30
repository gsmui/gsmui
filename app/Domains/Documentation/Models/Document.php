<?php

declare(strict_types=1);

namespace App\Domains\Documentation\Models;

use App\Domains\Users\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Document extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title', 'slug', 'body', 'category', 'subcategory',
        'author_id', 'status', 'version', 'sort_order',
        'is_featured', 'views_count', 'meta_title', 'meta_description',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'views_count' => 'integer',
        'sort_order' => 'integer',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }
}
