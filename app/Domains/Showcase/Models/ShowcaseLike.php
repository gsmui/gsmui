<?php

declare(strict_types=1);

namespace App\Domains\Showcase\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ShowcaseLike extends Model
{
    use HasFactory;

    protected $fillable = [
        'showcase_item_id', 'user_id',
    ];

    public function showcaseItem(): BelongsTo
    {
        return $this->belongsTo(ShowcaseItem::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
