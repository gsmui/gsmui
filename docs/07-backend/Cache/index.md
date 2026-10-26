# Cache Implementation

> Repository caching, tag-based invalidation, remember patterns, cache warming, flush strategies.

## Cache Configuration

```php
// config/cache.php
return [
    'default' => env('CACHE_DRIVER', 'redis'),

    'stores' => [
        'redis' => [
            'driver' => 'redis',
            'connection' => 'cache',
            'prefix' => env('REDIS_CACHE_PREFIX', 'gsmui_cache'),
        ],
        'database' => [
            'driver' => 'database',
            'table' => 'cache',
            'connection' => null,
            'lock_connection' => 'default',
        ],
    ],

    'prefix' => env('CACHE_PREFIX', 'gsmui'),
];
```

## Repository Caching

```php
class CachedProductRepository implements ProductRepositoryInterface
{
    public function __construct(
        protected ProductRepositoryInterface $repository,
        protected CacheService $cache,
    ) {}

    public function findById(int $id): ?Product
    {
        return $this->cache->remember(
            "products:{$id}",
            3600,
            fn () => $this->repository->findById($id)
        );
    }

    public function findBySku(string $sku): ?Product
    {
        return $this->cache->remember(
            "products:sku:{$sku}",
            3600,
            fn () => $this->repository->findBySku($sku)
        );
    }

    public function paginate(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $cacheKey = 'products:paginate:' . md5(json_encode($filters) . $perPage);

        return $this->cache->remember($cacheKey, 300, function () use ($filters, $perPage) {
            return $this->repository->paginate($filters, $perPage);
        });
    }
}
```

## Tag-Based Invalidation

```php
class TaggedCacheService
{
    public function remember(string $key, int $ttl, Closure $callback, array $tags = []): mixed
    {
        $store = Cache::tags($tags);

        return $store->remember($key, $ttl, $callback);
    }

    public function flushByTag(string $tag): void
    {
        Cache::tags([$tag])->flush();
    }

    public function forgetByTag(string $tag, string $key): void
    {
        Cache::tags([$tag])->forget($key);
    }
}

// Usage
class ProductCacheService
{
    public function rememberProduct(Product $product, Closure $callback): mixed
    {
        return Cache::tags(['products', "vendor:{$product->vendor_id}"])
            ->remember("product:{$product->id}", 3600, $callback);
    }

    public function flushProduct(Product $product): void
    {
        Cache::tags(['products'])->forget("product:{$product->id}");
    }

    public function flushVendorProducts(int $vendorId): void
    {
        Cache::tags(["vendor:{$vendorId}"])->flush();
    }
}
```

## Remember Patterns

```php
// Basic remember
$product = Cache::remember("product:{$id}", 3600, function () use ($id) {
    return Product::with('category')->find($id);
});

// Remember forever
$categories = Cache::rememberForever('categories:all', function () {
    return Category::all();
});

// Remember with null handling
$product = Cache::remember("product:{$id}", 3600, function () use ($id) {
    return Product::find($id); // May return null
});

// Conditional remember
if (Cache::has("product:{$id}")) {
    $product = Cache::get("product:{$id}");
} else {
    $product = Product::find($id);
    if ($product) {
        Cache::put("product:{$id}", $product, 3600);
    }
}

// Atomic lock for cache stampede prevention
$product = Cache::lock("product:{$id}:lock", 10)->block(5, function () use ($id) {
    return Cache::remember("product:{$id}", 3600, function () use ($id) {
        return Product::find($id);
    });
});
```

## Cache Warming

```php
class CacheWarmerJob implements ShouldQueue
{
    public function handle(): void
    {
        $this->warmCategories();
        $this->warmProducts();
        $this->warmPopularProducts();
    }

    protected function warmCategories(): void
    {
        $categories = Category::all();

        Cache::tags(['categories'])->rememberForever('categories:all', function () use ($categories) {
            return $categories;
        });
    }

    protected function warmProducts(): void
    {
        Product::chunk(100, function ($products) {
            foreach ($products as $product) {
                Cache::tags(['products'])->put(
                    "product:{$product->id}",
                    $product,
                    now()->addHours(2)
                );
            }
        });
    }

    protected function warmPopularProducts(): void
    {
        $popular = Product::withCount('orders')
            ->orderByDesc('orders_count')
            ->limit(50)
            ->get();

        Cache::tags(['products', 'popular'])->put(
            'products:popular',
            $popular,
            now()->addHours(1)
        );
    }
}

// Schedule cache warming
$schedule->job(new CacheWarmerJob)->hourly();
```

## Flush Strategies

```php
class CacheFlushService
{
    // Flush all cache
    public function flushAll(): void
    {
        Cache::flush();
    }

    // Flush by tag
    public function flushTag(string $tag): void
    {
        Cache::tags([$tag])->flush();
    }

    // Flush by prefix
    public function flushByPrefix(string $prefix): void
    {
        $redis = Cache::getStore()->getRedis();
        $keys = $redis->keys("*{$prefix}*");

        foreach ($keys as $key) {
            $redis->del($key);
        }
    }

    // Selective flush
    public function flushStale(int $maxAge = 3600): void
    {
        // Implementation depends on cache driver
        // For Redis, use SCAN to find expired keys
    }
}
```

## Cache Statistics

```php
class CacheStatsService
{
    public function getStats(): array
    {
        $redis = Cache::getStore()->getRedis();

        return [
            'hits' => $redis->get('stats:cache:hits') ?? 0,
            'misses' => $redis->get('stats:cache:misses') ?? 0,
            'hit_rate' => $this->calculateHitRate(),
            'memory_used' => $redis->info()['used_memory_human'] ?? 'N/A',
            'key_count' => $redis->dbSize(),
        ];
    }

    protected function calculateHitRate(): float
    {
        $hits = Cache::get('stats:cache:hits') ?? 0;
        $misses = Cache::get('stats:cache:misses') ?? 0;
        $total = $hits + $misses;

        return $total > 0 ? round($hits / $total * 100, 2) : 0;
    }
}
```

## Cache Testing

```php
class CacheServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_remember_caches_result(): void
    {
        $product = Product::factory()->create();

        $result = Cache::remember("product:{$product->id}", 3600, function () use ($product) {
            return Product::find($product->id);
        });

        $this->assertEquals($product->id, $result->id);

        // Verify it's cached
        $cached = Cache::get("product:{$product->id}");
        $this->assertNotNull($cached);
    }

    public function test_flush_by_tag_removes_tagged_items(): void
    {
        Cache::tags(['products'])->put('product:1', 'data', 3600);

        Cache::tags(['products'])->flush();

        $this->assertNull(Cache::get('product:1'));
    }

    public function test_cache_miss_returns_callback_result(): void
    {
        $result = Cache::remember('nonexistent', 3600, fn () => 'computed');

        $this->assertEquals('computed', $result);
        $this->assertEquals('computed', Cache::get('nonexistent'));
    }
}
```

## Cache Driver Comparison

| Driver | Speed | Persistence | Tags | Use Case |
|---|---|---|---|---|
| Redis | Fast | Optional | Yes | Production |
| Memcached | Fast | No | Yes | High-traffic |
| Database | Slow | Yes | No | Development |
| File | Slow | Yes | No | Local dev |
| Array | Fastest | No | No | Testing |
