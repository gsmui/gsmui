<?php

declare(strict_types=1);

namespace App\Domains\Playground\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'playground_projects';

    protected $fillable = [
        'user_id', 'name', 'slug', 'description', 'files',
        'visibility', 'forked_from_id', 'forks_count', 'views_count',
    ];

    protected $casts = [
        'files' => 'array',
        'forks_count' => 'integer',
        'views_count' => 'integer',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function forkedFrom(): BelongsTo
    {
        return $this->belongsTo(self::class, 'forked_from_id');
    }

    public function scopePublic($query)
    {
        return $query->where('visibility', 'public');
    }
}
