<?php

declare(strict_types=1);

namespace App\Domains\Users\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class ApiKey extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'name', 'key_hash', 'key_preview', 'abilities',
        'last_used_at', 'expires_at',
    ];

    protected $casts = [
        'abilities' => 'array',
        'last_used_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::creating(function (ApiKey $apiKey): void {
            if ($apiKey->key_hash) {
                return;
            }

            $key = 'gsmui_'.Str::random(40);

            $apiKey->key_hash = hash('sha256', $key);
            $apiKey->key_preview = Str::substr($key, 0, 12).'…';
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getIsActiveAttribute(): bool
    {
        return ! $this->isExpired();
    }

    public function isExpired(): bool
    {
        return $this->expires_at !== null && $this->expires_at->isPast();
    }
}
