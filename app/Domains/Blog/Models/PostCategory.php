<?php

declare(strict_types=1);

namespace App\Domains\Blog\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PostCategory extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'description', 'sort_order'];

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class, 'category_id');
    }
}
