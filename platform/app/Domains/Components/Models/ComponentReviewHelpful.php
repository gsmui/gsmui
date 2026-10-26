<?php

declare(strict_types=1);

namespace App\Domains\Components\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ComponentReviewHelpful extends Model
{
    use HasFactory;

    protected $fillable = [
        'review_id', 'user_id',
    ];

    public function review(): BelongsTo
    {
        return $this->belongsTo(ComponentReview::class, 'review_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
