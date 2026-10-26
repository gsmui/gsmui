<?php

declare(strict_types=1);

namespace App\Domains\Components\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ComponentReview extends Model
{
    use HasFactory;

    protected $fillable = [
        'component_id', 'user_id', 'rating', 'title', 'body',
        'is_approved', 'helpful_count',
    ];

    protected $casts = [
        'rating' => 'integer',
        'is_approved' => 'boolean',
        'helpful_count' => 'integer',
    ];

    public function component(): BelongsTo
    {
        return $this->belongsTo(Component::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
