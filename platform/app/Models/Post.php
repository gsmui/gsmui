<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'slug', 'excerpt', 'body', 'body_html', 'author_id',
        'status', 'featured_image', 'featured_image_alt', 'meta_title',
        'meta_description', 'published_at', 'views_count', 'reading_time',
        'is_featured',
    ];

    protected function casts(): array
    {
        return [
            'published_at' => 'datetime', 'views_count' => 'integer',
            'reading_time' => 'integer', 'is_featured' => 'boolean',
        ];
    }

    public function getRouteKeyName(): string { return 'slug'; }
    public function author() { return $this->belongsTo(User::class, 'author_id'); }
    public function scopePublished($query) { return $query->where('status', 'published')->whereNotNull('published_at'); }
    public function scopeFeatured($query) { return $query->where('is_featured', true); }
}
