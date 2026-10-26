<?php

declare(strict_types=1);

namespace App\Domains\Playground\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'name', 'slug', 'description', 'code',
        'language', 'framework', 'is_public', 'forked_from',
        'views_count', 'likes_count', 'last_run_at',
    ];

    protected $casts = [
        'is_public' => 'boolean',
        'views_count' => 'integer',
        'likes_count' => 'integer',
        'last_run_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopePublic($query)
    {
        return $query->where('is_public', true);
    }
}
