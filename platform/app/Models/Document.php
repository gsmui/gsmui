<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Document extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'author_id', 'title', 'slug', 'body', 'category', 'subcategory',
        'status', 'version', 'sort_order', 'is_featured', 'views_count',
        'meta_title', 'meta_description',
    ];

    protected function casts(): array
    {
        return [
            'sort_order' => 'integer',
            'is_featured' => 'boolean',
            'views_count' => 'integer',
        ];
    }

    public function getRouteKeyName(): string { return 'slug'; }
    public function author() { return $this->belongsTo(User::class, 'author_id'); }
}
