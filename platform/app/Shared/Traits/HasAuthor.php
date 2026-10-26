<?php

declare(strict_types=1);

namespace App\Shared\Traits;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait HasAuthor
{
    /**
     * Boot the has author trait.
     */
    public static function bootHasAuthor(): void
    {
        static::creating(function ($model) {
            if (empty($model->author_id) && auth()->check()) {
                $model->author_id = auth()->id();
            }
        });
    }

    /**
     * Get the author.
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    /**
     * Check if the given user is the author.
     */
    public function isAuthor($user): bool
    {
        return $this->author_id === ($user->id ?? $user);
    }
}
