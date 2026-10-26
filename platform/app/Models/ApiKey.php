<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ApiKey extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'name', 'key', 'abilities', 'last_used_at', 'expires_at'];

    protected function casts(): array
    {
        return ['last_used_at' => 'datetime', 'expires_at' => 'datetime'];
    }

    protected static function booted(): void
    {
        static::creating(function ($apiKey) {
            $apiKey->key = 'gsmui_' . Str::random(40);
        });
    }

    public function user() { return $this->belongsTo(User::class); }
    public function isExpired(): bool { return $this->expires_at && $this->expires_at->isPast(); }
}
