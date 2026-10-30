<?php

declare(strict_types=1);

namespace App\Domains\Users\Actions;

use App\Domains\Users\Models\User;
use App\Domains\Users\Models\ApiKey;
use Illuminate\Support\Str;

class ManageApiKeyAction
{
    public function create(User $user, array $data): ApiKey
    {
        $key = 'gsmui_' . Str::random(32);

        $apiKey = ApiKey::create([
            'user_id' => $user->id,
            'name' => $data['name'],
            'key' => hash('sha256', $key),
            'key_prefix' => substr($key, 0, 12),
            'abilities' => $data['abilities'] ?? ['*'],
            'last_used_at' => null,
            'expires_at' => $data['expires_at'] ?? null,
        ]);

        return tap($apiKey, function ($apiKey) use ($key) {
            $apiKey->plain_text_key = $key;
        });
    }

    public function update(ApiKey $apiKey, array $data): ApiKey
    {
        $apiKey->update([
            'name' => $data['name'] ?? $apiKey->name,
            'abilities' => $data['abilities'] ?? $apiKey->abilities,
            'expires_at' => $data['expires_at'] ?? $apiKey->expires_at,
        ]);

        return $apiKey;
    }

    public function delete(ApiKey $apiKey): bool
    {
        return $apiKey->delete();
    }

    public function revoke(User $user): bool
    {
        return $user->apiKeys()->delete();
    }

    public function validate(string $key): ?ApiKey
    {
        $hashedKey = hash('sha256', $key);

        $apiKey = ApiKey::where('key', $hashedKey)
            ->where(function ($query) {
                $query->whereNull('expires_at')
                    ->orWhere('expires_at', '>', now());
            })
            ->first();

        if ($apiKey) {
            $apiKey->update(['last_used_at' => now()]);
        }

        return $apiKey;
    }
}
