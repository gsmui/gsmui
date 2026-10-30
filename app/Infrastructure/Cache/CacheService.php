<?php

declare(strict_types=1);

namespace App\Infrastructure\Cache;

use Illuminate\Support\Facades\Cache;

class CacheService
{
    /**
     * Get a value from cache.
     */
    public function get(string $key, mixed $default = null): mixed
    {
        return Cache::get($key, $default);
    }

    /**
     * Set a value in cache.
     */
    public function set(string $key, mixed $value, int $ttl = 3600): bool
    {
        return Cache::put($key, $value, $ttl);
    }

    /**
     * Get or set a value in cache.
     */
    public function remember(string $key, int $ttl, callable $callback): mixed
    {
        return Cache::remember($key, $ttl, $callback);
    }

    /**
     * Invalidate cache for a pattern.
     */
    public function invalidate(string $pattern): void
    {
        $keys = Cache::tags([$pattern])->flush();
    }

    /**
     * Flush all cache.
     */
    public function flush(): void
    {
        Cache::flush();
    }

    /**
     * Get cache with tag support.
     */
    public function tagged(array $tags): \Illuminate\Cache\TaggedCache
    {
        return Cache::tags($tags);
    }

    /**
     * Increment a cache value.
     */
    public function increment(string $key, int $value = 1): int|false
    {
        return Cache::increment($key, $value);
    }

    /**
     * Decrement a cache value.
     */
    public function decrement(string $key, int $value = 1): int|false
    {
        return Cache::decrement($key, $value);
    }

    /**
     * Check if a key exists in cache.
     */
    public function has(string $key): bool
    {
        return Cache::has($key);
    }

    /**
     * Remove a key from cache.
     */
    public function forget(string $key): bool
    {
        return Cache::forget($key);
    }
}
