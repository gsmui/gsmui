<?php

declare(strict_types=1);

namespace App\Domains\Charts\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Chart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'name', 'slug', 'type', 'data',
        'config', 'is_public', 'views_count',
    ];

    protected $casts = [
        'data' => 'array',
        'config' => 'array',
        'is_public' => 'boolean',
        'views_count' => 'integer',
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
