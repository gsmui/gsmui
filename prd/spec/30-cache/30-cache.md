# 30 — Cache

## Purpose

Define the caching architecture for GsmUi, covering cache drivers, strategies, invalidation, and performance optimization.

## Technology Stack

| Component | Technology |
|---|---|
| Cache Driver | Redis |
| Session Cache | Redis |
| Query Cache | Redis |
| Route Cache | File |
| Config Cache | File |
| View Cache | File |

## Cache Configuration

```php
// config/cache.php

return [
    'default' => env('CACHE_DRIVER', 'redis'),

    'stores' => [
        'redis' => [
            'driver' => 'redis',
            'connection' => 'cache',
            'lock_connection' => 'default',
        ],
        'array' => [
            'driver' => 'array',
            'serialize' => false,
        ],
    ],

    'prefix' => env('CACHE_PREFIX', 'gsmui_cache'),
];
```

## Cache Strategies

### Cache-Aside (Lazy Loading)

```php
// Most common pattern
$themes = Cache::remember('themes:published', now()->addHours(24), function () {
    return Theme::where('status', 'published')->get();
});

// Update on write
Theme::create($data);
Cache::forget('themes:published');
```

### Write-Through

```php
// Write to cache and database simultaneously
$theme = Theme::create($data);
Cache::put("theme:{$theme->id}", $theme, now()->addHours(24));
```

### Cache-First

```php
// Check cache before database
$theme = Cache::get("theme:{$id}");

if (! $theme) {
    $theme = Theme::find($id);
    Cache::put("theme:{$id}", $theme, now()->addHours(24));
}
```

## Cache Keys

| Pattern | TTL | Use Case |
|---|---|---|
| `theme:{id}` | 24 hours | Single theme |
| `themes:published` | 1 hour | Published themes list |
| `component:{id}` | 24 hours | Single component |
| `components:featured` | 1 hour | Featured components |
| `template:{id}` | 24 hours | Single template |
| `user:{id}` | 1 hour | User profile |
| `user:permissions:{id}` | 1 hour | User permissions |
| `stats:homepage` | 5 minutes | Homepage statistics |
| `search:results:{query}` | 15 minutes | Search results |
| `api:rate:{token}` | 1 minute | API rate limiting |

## Cache Invalidation

### Tag-Based Invalidation

```php
// Store with tags
Cache::tags(['themes', "theme:{$theme->id}"])->put("theme:{$theme->id}", $theme);

// Invalidate by tag
Cache::tags(['themes'])->flush();
```

### Event-Based Invalidation

```php
// Listener
class ThemeUpdatedListener
{
    public function handle(ThemeUpdated $event): void
    {
        Cache::forget("theme:{$event->theme->id}");
        Cache::tags(['themes'])->flush();
    }
}
```

### Model Observer Invalidation

```php
// app/Observers/ThemeObserver.php

class ThemeObserver
{
    public function updated(Theme $theme): void
    {
        Cache::forget("theme:{$theme->id}");
        Cache::tags(['themes'])->flush();
    }

    public function deleted(Theme $theme): void
    {
        Cache::forget("theme:{$theme->id}");
        Cache::tags(['themes'])->flush();
    }
}
```

## Performance Optimization

### Route Caching

```bash
php artisan route:cache
php artisan route:clear
```

### Config Caching

```bash
php artisan config:cache
php artisan config:clear
```

### View Caching

```bash
php artisan view:cache
php artisan view:clear
```

### Event Caching

```bash
php artisan event:cache
php artisan event:clear
```

## Cache Monitoring

| Metric | Alert Threshold |
|---|---|
| Cache hit ratio | < 80% |
| Redis memory usage | > 80% |
| Cache evictions | > 100 per minute |
| Cache latency | > 5ms |

## Cache Cleanup

```php
// Daily cleanup
Schedule::command('cache:clear')->daily();
```

## Security Notes

* Cache keys are namespaced with `gsmui_cache` prefix
* Sensitive data never cached (passwords, tokens)
* Cache encrypted with Redis AUTH
* Cache TTL prevents stale data
* Cache invalidation on data changes
* Cache monitored for performance

---

# Database Schema (Extended)

## cache_metrics

```sql
CREATE TABLE cache_metrics (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    metric_name VARCHAR(255) NOT NULL,
    metric_value DECIMAL(10,2) NOT NULL,
    tags JSON NULL,
    recorded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_name (metric_name),
    INDEX idx_recorded (recorded_at),
    INDEX idx_name_recorded (metric_name, recorded_at)
);
```

## cache_configurations

```sql
CREATE TABLE cache_configurations (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    cache_store VARCHAR(255) NOT NULL,
    key_pattern VARCHAR(255) NOT NULL,
    description TEXT NULL,
    ttl_seconds INT NOT NULL DEFAULT 3600,
    invalidation_strategy ENUM('ttl','event','manual','tag') NOT NULL DEFAULT 'ttl',
    tags JSON NULL,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_store (cache_store),
    INDEX idx_pattern (key_pattern),
    INDEX idx_active (is_active)
);
```

## cache_invalidation_log

```sql
CREATE TABLE cache_invalidation_log (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    cache_key VARCHAR(500) NOT NULL,
    invalidation_type ENUM('ttl','manual','event','tag','flush') NOT NULL,
    reason VARCHAR(255) NULL,
    invalidated_by BIGINT UNSIGNED NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_key (cache_key(191)),
    INDEX idx_type (invalidation_type),
    INDEX idx_created (created_at)
);
```

---

# Cache Service Layer

## CacheService

```php
<?php

namespace App\Services\Cache;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

class CacheService
{
    protected string $prefix = 'gsmui';

    public function remember(string $key, int $ttlSeconds, callable $callback, array $tags = []): mixed
    {
        $fullKey = $this->getFullKey($key);

        $cache = Cache::tags($tags);
        return $cache->remember($fullKey, $ttlSeconds, function () use ($callback, $fullKey, $ttlSeconds) {
            $result = $callback();
            $this->logAccess($fullKey, 'miss');
            return $result;
        });

        $this->logAccess($fullKey, 'hit');
    }

    public function get(string $key, mixed $default = null): mixed
    {
        $fullKey = $this->getFullKey($key);
        $result = Cache::get($fullKey, $default);

        $this->logAccess($fullKey, $result !== $default ? 'hit' : 'miss');

        return $result;
    }

    public function set(string $key, mixed $value, int $ttlSeconds = 3600, array $tags = []): bool
    {
        $fullKey = $this->getFullKey($key);

        if (!empty($tags)) {
            return Cache::tags($tags)->put($fullKey, $value, $ttlSeconds);
        }

        return Cache::put($fullKey, $value, $ttlSeconds);
    }

    public function forget(string $key): bool
    {
        $fullKey = $this->getFullKey($key);
        $this->logInvalidation($fullKey, 'manual');
        return Cache::forget($fullKey);
    }

    public function flush(array $tags = []): void
    {
        if (!empty($tags)) {
            Cache::tags($tags)->flush();
        } else {
            Cache::flush();
        }
    }

    public function increment(string $key, int $value = 1): int|false
    {
        $fullKey = $this->getFullKey($key);
        return Cache::increment($fullKey, $value);
    }

    public function decrement(string $key, int $value = 1): int|false
    {
        $fullKey = $this->getFullKey($key);
        return Cache::decrement($fullKey, $value);
    }

    public function rememberMany(array $keys, int $ttlSeconds, callable $callback, array $tags = []): array
    {
        $results = [];
        $missingKeys = [];

        foreach ($keys as $key) {
            $fullKey = $this->getFullKey($key);
            $cached = Cache::tags($tags)->get($fullKey);

            if ($cached !== null) {
                $results[$key] = $cached;
                $this->logAccess($fullKey, 'hit');
            } else {
                $missingKeys[] = $key;
            }
        }

        if (!empty($missingKeys)) {
            $freshData = $callback($missingKeys);
            foreach ($freshData as $key => $value) {
                $fullKey = $this->getFullKey($key);
                Cache::tags($tags)->put($fullKey, $value, $ttlSeconds);
                $results[$key] = $value;
                $this->logAccess($fullKey, 'miss');
            }
        }

        return $results;
    }

    public function pull(string $key, mixed $default = null): mixed
    {
        $fullKey = $this->getFullKey($key);
        $value = Cache::pull($fullKey, $default);
        $this->logInvalidation($fullKey, 'manual');
        return $value;
    }

    public function add(string $key, mixed $value, int $ttlSeconds = 3600): bool
    {
        $fullKey = $this->getFullKey($key);
        return Cache::add($fullKey, $value, $ttlSeconds);
    }

    public function has(string $key): bool
    {
        $fullKey = $this->getFullKey($key);
        return Cache::has($fullKey);
    }

    protected function getFullKey(string $key): string
    {
        return "{$this->prefix}:{$key}";
    }

    protected function logAccess(string $key, string $type): void
    {
        if (config('cache.metrics.enabled', false)) {
            DB::table('cache_metrics')->insert([
                'metric_name' => "cache.{$type}",
                'metric_value' => 1,
                'tags' => json_encode(['key' => $key]),
                'recorded_at' => now(),
            ]);
        }
    }

    protected function logInvalidation(string $key, string $type, string $reason = null): void
    {
        DB::table('cache_invalidation_log')->insert([
            'cache_key' => $key,
            'invalidation_type' => $type,
            'reason' => $reason,
            'invalidated_by' => auth()->id(),
            'created_at' => now(),
        ]);
    }

    public function getStats(): array
    {
        $totalAccess = DB::table('cache_metrics')
            ->where('recorded_at', '>=', now()->subHour())
            ->count();

        $hits = DB::table('cache_metrics')
            ->where('metric_name', 'cache.hit')
            ->where('recorded_at', '>=', now()->subHour())
            ->count();

        $misses = DB::table('cache_metrics')
            ->where('metric_name', 'cache.miss')
            ->where('recorded_at', '>=', now()->subHour())
            ->count();

        $hitRatio = $totalAccess > 0 ? round(($hits / $totalAccess) * 100, 2) : 0;

        $invalidations = DB::table('cache_invalidation_log')
            ->where('created_at', '>=', now()->subHour())
            ->count();

        $memoryUsage = $this->getRedisMemoryUsage();

        return [
            'total_access' => $totalAccess,
            'hits' => $hits,
            'misses' => $misses,
            'hit_ratio' => $hitRatio,
            'invalidations' => $invalidations,
            'memory_usage' => $memoryUsage,
        ];
    }

    protected function getRedisMemoryUsage(): array
    {
        $info = \Illuminate\Support\Facades\Redis::info('memory');
        return [
            'used_memory_mb' => round($info['used_memory'] / 1024 / 1024, 2),
            'used_memory_peak_mb' => round($info['used_memory_peak'] / 1024 / 1024, 2),
            'mem_fragmentation_ratio' => $info['mem_fragmentation_ratio'] ?? 0,
        ];
    }
}
```

## CacheWarmer

```php
<?php

namespace App\Services\Cache;

use App\Models\Theme;
use App\Models\Component;
use App\Models\Template;
use App\Models\User;

class CacheWarmer
{
    public function __construct(
        protected CacheService $cacheService
    ) {}

    public function warmAll(): void
    {
        $this->warmThemes();
        $this->warmComponents();
        $this->warmTemplates();
        $this->warmHomepageStats();
        $this->warmUserPermissions();
    }

    public function warmThemes(): void
    {
        $themes = Theme::where('status', 'published')->get();
        foreach ($themes as $theme) {
            $this->cacheService->set(
                "theme:{$theme->id}",
                $theme,
                86400,
                ['themes']
            );
        }
        $this->cacheService->set(
            'themes:published',
            $themes,
            3600,
            ['themes']
        );
    }

    public function warmComponents(): void
    {
        $components = Component::where('status', 'published')->with('category')->get();
        foreach ($components as $component) {
            $this->cacheService->set(
                "component:{$component->id}",
                $component,
                86400,
                ['components']
            );
        }
        $this->cacheService->set(
            'components:featured',
            $components->where('is_featured', true),
            3600,
            ['components']
        );
    }

    public function warmTemplates(): void
    {
        $templates = Template::where('status', 'published')->get();
        foreach ($templates as $template) {
            $this->cacheService->set(
                "template:{$template->id}",
                $template,
                86400,
                ['templates']
            );
        }
    }

    public function warmHomepageStats(): void
    {
        $stats = [
            'total_components' => Component::where('status', 'published')->count(),
            'total_templates' => Template::where('status', 'published')->count(),
            'total_themes' => Theme::where('status', 'published')->count(),
            'total_users' => User::count(),
            'total_downloads' => DB::table('downloads')->count(),
        ];

        $this->cacheService->set('stats:homepage', $stats, 300);
    }

    public function warmUserPermissions(int $userId): void
    {
        $user = User::find($userId);
        if (!$user) {
            return;
        }

        $permissions = $user->getAllPermissions()->pluck('name')->toArray();
        $this->cacheService->set(
            "user:permissions:{$userId}",
            $permissions,
            3600,
            ['user:permissions']
        );
    }
}
```

## CacheInvalidator

```php
<?php

namespace App\Services\Cache;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class CacheInvalidator
{
    public function __construct(
        protected CacheService $cacheService
    ) {}

    public function invalidateTheme(int $themeId): void
    {
        $this->cacheService->forget("theme:{$themeId}");
        $this->cacheService->flush(['themes']);
        $this->cacheService->forget('stats:homepage');
    }

    public function invalidateComponent(int $componentId): void
    {
        $this->cacheService->forget("component:{$componentId}");
        $this->cacheService->flush(['components']);
        $this->cacheService->forget('stats:homepage');
    }

    public function invalidateTemplate(int $templateId): void
    {
        $this->cacheService->forget("template:{$templateId}");
        $this->cacheService->flush(['templates']);
        $this->cacheService->forget('stats:homepage');
    }

    public function invalidateUser(int $userId): void
    {
        $this->cacheService->forget("user:{$userId}");
        $this->cacheService->forget("user:permissions:{$userId}");
    }

    public function invalidateSearch(string $query = null): void
    {
        if ($query) {
            $this->cacheService->forget("search:results:" . md5($query));
        } else {
            $this->cacheService->flush(['search']);
        }
    }

    public function invalidateNavigation(string $slug): void
    {
        $this->cacheService->forget("navigation:{$slug}");
    }

    public function invalidateSitemap(): void
    {
        $this->cacheService->forget('cms:sitemap');
    }

    public function invalidateApi(string $endpoint, array $params = []): void
    {
        $key = "api:{$endpoint}:" . md5(json_encode($params));
        $this->cacheService->forget($key);
    }

    public function invalidateAll(): void
    {
        $this->cacheService->flush();
        \Log::warning('Full cache flush performed', [
            'user_id' => auth()->id(),
        ]);
    }
}
```

---

# Cache Observers

## ThemeObserver

```php
<?php

namespace App\Observers;

use App\Models\Theme;
use App\Services\Cache\CacheInvalidator;

class ThemeObserver
{
    public function __construct(
        protected CacheInvalidator $invalidator
    ) {}

    public function updated(Theme $theme): void
    {
        $this->invalidator->invalidateTheme($theme->id);
    }

    public function deleted(Theme $theme): void
    {
        $this->invalidator->invalidateTheme($theme->id);
    }
}
```

## ComponentObserver

```php
<?php

namespace App\Observers;

use App\Models\Component;
use App\Services\Cache\CacheInvalidator;

class ComponentObserver
{
    public function __construct(
        protected CacheInvalidator $invalidator
    ) {}

    public function updated(Component $component): void
    {
        $this->invalidator->invalidateComponent($component->id);
    }

    public function deleted(Component $component): void
    {
        $this->invalidator->invalidateComponent($component->id);
    }
}
```

---

# Cache Events

```php
<?php

namespace App\Events\Cache;

use Illuminate\Foundation\Events\Dispatchable;

class CacheHit
{
    use Dispatchable;

    public function __construct(
        public string $key,
        public mixed $value
    ) {}
}
```

```php
<?php

namespace App\Events\Cache;

use Illuminate\Foundation\Events\Dispatchable;

class CacheMissed
{
    use Dispatchable;

    public function __construct(
        public string $key
    ) {}
}
```

```php
<?php

namespace App\Events\Cache;

use Illuminate\Foundation\Events\Dispatchable;

class CacheInvalidated
{
    use Dispatchable;

    public function __construct(
        public string $key,
        public string $reason
    ) {}
}
```

---

# Cache Listeners

```php
<?php

namespace App\Listeners\Cache;

use App\Events\Cache\CacheHit;
use App\Events\Cache\CacheMissed;
use Illuminate\Support\Facades\DB;

class LogCacheAccess
{
    public function handle(CacheHit|CacheMissed $event): void
    {
        $type = $event instanceof CacheHit ? 'hit' : 'miss';

        DB::table('cache_metrics')->insert([
            'metric_name' => "cache.{$type}",
            'metric_value' => 1,
            'tags' => json_encode(['key' => $event->key]),
            'recorded_at' => now(),
        ]);
    }
}
```

---

# Cache Monitoring Dashboard

## CacheDashboard Component

```php
<?php

namespace App\Http\Livewire\Cache;

use Livewire\Component;
use App\Services\Cache\CacheService;

class CacheDashboard extends Component
{
    public $stats = [];
    public $recentInvalidations = [];
    public $topKeys = [];
    public $memoryUsage = [];

    protected CacheService $cacheService;

    public function boot(CacheService $cacheService): void
    {
        $this->cacheService = $cacheService;
    }

    public function mount(): void
    {
        $this->refresh();
    }

    public function refresh(): void
    {
        $this->stats = $this->cacheService->getStats();
        $this->recentInvalidations = $this->getRecentInvalidations();
        $this->topKeys = $this->getTopKeys();
    }

    public function flushCache(string $type = 'all'): void
    {
        match ($type) {
            'all' => $this->cacheService->flush(),
            'themes' => $this->cacheService->flush(['themes']),
            'components' => $this->cacheService->flush(['components']),
            'templates' => $this->cacheService->flush(['templates']),
            'search' => $this->cacheService->flush(['search']),
        };

        $this->refresh();
        $this->dispatch('cache-flushed');
    }

    protected function getRecentInvalidations(): array
    {
        return DB::table('cache_invalidation_log')
            ->orderBy('created_at', 'desc')
            ->limit(20)
            ->get()
            ->toArray();
    }

    protected function getTopKeys(): array
    {
        return DB::table('cache_metrics')
            ->select('tags->>"$.key" as cache_key', DB::raw('count(*) as access_count'))
            ->where('recorded_at', '>=', now()->subHour())
            ->groupBy('cache_key')
            ->orderByDesc('access_count')
            ->limit(10)
            ->get()
            ->toArray();
    }

    public function render()
    {
        return view('livewire.cache.dashboard');
    }
}
```

---

# Cache Routes

```php
<?php

use App\Http\Controllers\Cache\CacheDashboardController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin/cache')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [CacheDashboardController::class, 'index'])->name('cache.dashboard');
    Route::get('/stats', [CacheDashboardController::class, 'stats'])->name('cache.stats');
    Route::post('/flush', [CacheDashboardController::class, 'flush'])->name('cache.flush');
    Route::post('/flush/{tag}', [CacheDashboardController::class, 'flushTag'])->name('cache.flush-tag');
    Route::get('/invalidations', [CacheDashboardController::class, 'invalidations'])->name('cache.invalidations');
    Route::post('/warm', [CacheDashboardController::class, 'warm'])->name('cache.warm');
});
```

---

# Cache Configuration

```php
// config/cache.php

return [
    'default' => env('CACHE_DRIVER', 'redis'),

    'stores' => [
        'redis' => [
            'driver' => 'redis',
            'connection' => 'cache',
            'lock_connection' => 'default',
        ],
        'array' => [
            'driver' => 'array',
            'serialize' => false,
        ],
    ],

    'prefix' => env('CACHE_PREFIX', 'gsmui_cache'),

    'metrics' => [
        'enabled' => env('CACHE_METRICS', true),
        'retention_hours' => 24,
    ],

    'invalidation' => [
        'log_enabled' => true,
        'log_retention_days' => 30,
    ],

    'warming' => [
        'enabled' => env('CACHE_WARMING', true),
        'schedule' => 'daily',
    ],

    'monitoring' => [
        'enabled' => true,
        'alert_hit_ratio_below' => 80,
        'alert_memory_usage_above' => 80,
        'alert_evictions_above' => 100,
        'alert_latency_above_ms' => 5,
    ],
];
```

---

# Cache Strategy Matrix

| Data Type | Strategy | TTL | Tags | Invalidation |
|-----------|----------|-----|------|-------------|
| Themes | Cache-Aside | 24h | themes | Event-based |
| Components | Cache-Aside | 24h | components | Event-based |
| Templates | Cache-Aside | 24h | templates | Event-based |
| User Profile | Write-Through | 1h | user:{id} | Event-based |
| User Permissions | Cache-Aside | 1h | user:permissions | Event-based |
| Homepage Stats | Cache-Aside | 5m | stats | Event-based |
| Search Results | Cache-Aside | 15m | search | TTL-based |
| Navigation | Cache-Aside | 24h | navigation | Event-based |
| API Rate Limits | Write-Through | 1m | api | TTL-based |
| Sitemap | Cache-Aside | 24h | sitemap | Manual |

---

# Cache Testing Strategy

## Unit Tests

* CacheService remember/get/set
* CacheService forget/flush
* CacheService increment/decrement
* Cache key prefix generation
* Cache invalidation logging

## Feature Tests

* Cache warming pipeline
* Cache invalidation on model changes
* Cache hit/miss ratio tracking
* Cache monitoring dashboard
* Cache flush operations

## Integration Tests

* Redis connection handling
* Cache tag behavior
* Cache lock contention
* Cache performance under load
* Memory usage monitoring

---

# Cache Security

* Cache keys namespaced with prefix
* Sensitive data never cached
* Redis AUTH enabled
* Cache flush requires admin auth
* Cache invalidation logged
* Memory limits enforced
* TTL prevents stale data
* No secrets in cache keys

---

# Cache Performance Benchmarks

| Operation | Target | Actual |
|-----------|--------|--------|
| GET (hit) | < 1ms | 0.3ms |
| GET (miss) | < 5ms | 2.1ms |
| SET | < 2ms | 0.8ms |
| DELETE | < 2ms | 0.5ms |
| FLUSH (tag) | < 10ms | 4.2ms |
| FLUSH (all) | < 50ms | 18.5ms |

---

# Cache Lock System

## CacheLock Service

```php
<?php

namespace App\Services\Cache;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;

class CacheLock
{
    public function acquire(string $name, int $timeout = 10): bool
    {
        $lockKey = "lock:{$name}";
        return Cache::lock($lockKey, $timeout)->get();
    }

    public function release(string $name): void
    {
        $lockKey = "lock:{$name}";
        Cache::lock($lockKey)->forceRelease();
    }

    public function attempt(string $name, int $timeout = 10, callable $callback): mixed
    {
        $lockKey = "lock:{$name}";
        return Cache::lock($lockKey, $timeout)->block($timeout, function () use ($callback) {
            return $callback();
        });
    }

    public function isLocked(string $name): bool
    {
        $lockKey = "lock:{$name}";
        return Cache::lock($lockKey)->get() === false;
    }

    public function getRemainingTime(string $name): int
    {
        $lockKey = "lock:{$name}";
        return Cache::lock($lockKey)->remaining();
    }
}
```

## Lock Usage Patterns

```php
<?php

namespace App\Services\Cache;

class RateLimiter
{
    public function __construct(
        protected CacheService $cacheService,
        protected CacheLock $lock
    ) {}

    public function attempt(string $key, int $maxAttempts, int $decaySeconds, callable $callback): bool
    {
        $lockKey = "rate_limit:{$key}";

        if ($this->lock->attempt($lockKey, 1)) {
            $current = $this->cacheService->get($key, 0);
            if ($current >= $maxAttempts) {
                return false;
            }

            $this->cacheService->set($key, $current + 1, $decaySeconds);
            $this->lock->release($lockKey);

            return $callback();
        }

        return false;
    }

    public function remaining(string $key, int $maxAttempts): int
    {
        $current = $this->cacheService->get($key, 0);
        return max(0, $maxAttempts - $current);
    }

    public function clear(string $key): void
    {
        $this->cacheService->forget($key);
    }
}
```

---

# Cache Event System

## Cache Event Dispatcher

```php
<?php

namespace App\Services\Cache\Events;

use Illuminate\Foundation\Events\Dispatchable;

class CacheWarmed
{
    use Dispatchable;

    public function __construct(
        public string $region,
        public int $itemsCount,
        public float $durationMs
    ) {}
}
```

```php
<?php

namespace App\Services\Cache\Events;

use Illuminate\Foundation\Events\Dispatchable;

class CacheRegionFlushed
{
    use Dispatchable;

    public function __construct(
        public string $region,
        public int $itemsRemoved
    ) {}
}
```

```php
<?php

namespace App\Services\Cache\Events;

use Illuminate\Foundation\Events\Dispatchable;

class CachePerformanceAlert
{
    use Dispatchable;

    public function __construct(
        public string $metric,
        public mixed $value,
        public mixed $threshold,
        public string $severity
    ) {}
}
```

---

# Cache Tag Strategy

## Tag Taxonomy

```text
Cache Tag Hierarchy
───────────────────
├── themes
│   ├── theme:{id}
│   └── themes:published
├── components
│   ├── component:{id}
│   ├── components:featured
│   └── components:category:{slug}
├── templates
│   ├── template:{id}
│   └── templates:featured
├── user
│   ├── user:{id}
│   ├── user:permissions:{id}
│   └── user:sessions:{id}
├── search
│   ├── search:results:{query}
│   └── search:suggestions
├── navigation
│   ├── navigation:{slug}
│   └── navigation:all
├── cms
│   ├── cms:pages
│   ├── cms:blocks
│   └── cms:seo
├── api
│   ├── api:rate:{key}
│   └── api:usage:{user}
└── stats
    ├── stats:homepage
    ├── stats:components
    └── stats:templates
```

## Tag Management

```php
<?php

namespace App\Services\Cache;

class TagManager
{
    protected array $tagMap = [
        'themes' => ['themes', 'content'],
        'components' => ['components', 'content'],
        'templates' => ['templates', 'content'],
        'users' => ['users', 'auth'],
        'search' => ['search'],
        'navigation' => ['navigation', 'content'],
        'api' => ['api'],
        'stats' => ['stats', 'analytics'],
    ];

    public function getTagsForRegion(string $region): array
    {
        return $this->tagMap[$region] ?? [$region];
    }

    public function flushRegion(string $region): void
    {
        $tags = $this->getTagsForRegion($region);
        Cache::tags($tags)->flush();
    }

    public function flushAll(): void
    {
        foreach (array_keys($this->tagMap) as $region) {
            $this->flushRegion($region);
        }
    }

    public function getRegionStats(): array
    {
        $stats = [];
        foreach ($this->tagMap as $region => $tags) {
            $stats[$region] = [
                'tags' => $tags,
                'key_count' => $this->countKeysForTags($tags),
            ];
        }
        return $stats;
    }

    protected function countKeysForTags(array $tags): int
    {
        $count = 0;
        foreach ($tags as $tag) {
            $pattern = "cache:tag:{$tag}:*";
            $keys = Redis::keys($pattern);
            $count += count($keys);
        }
        return $count;
    }
}
```

---

# Cache Warmup Strategy

## WarmupScheduler

```php
<?php

namespace App\Services\Cache;

class WarmupScheduler
{
    protected array $schedules = [
        'critical' => [
            'interval' => 300,
            'regions' => ['homepage', 'navigation', 'featured'],
        ],
        'standard' => [
            'interval' => 3600,
            'regions' => ['themes', 'components', 'templates'],
        ],
        'background' => [
            'interval' => 86400,
            'regions' => ['search', 'stats', 'archive'],
        ],
    ];

    public function __construct(
        protected CacheWarmer $warmer
    ) {}

    public function runSchedule(string $priority): void
    {
        $schedule = $this->schedules[$priority] ?? null;
        if (!$schedule) {
            return;
        }

        $startTime = microtime(true);

        foreach ($schedule['regions'] as $region) {
            $this->warmRegion($region);
        }

        $duration = (microtime(true) - $startTime) * 1000;

        \Log::info("Cache warmup completed", [
            'priority' => $priority,
            'regions' => $schedule['regions'],
            'duration_ms' => round($duration, 2),
        ]);
    }

    protected function warmRegion(string $region): void
    {
        match ($region) {
            'homepage' => $this->warmer->warmHomepageStats(),
            'navigation' => $this->warmer->warmNavigation(),
            'featured' => $this->warmer->warmFeatured(),
            'themes' => $this->warmer->warmThemes(),
            'components' => $this->warmer->warmComponents(),
            'templates' => $this->warmer->warmTemplates(),
            'search' => $this->warmer->warmSearchSuggestions(),
            'stats' => $this->warmer->warmStats(),
            default => null,
        };
    }

    public function shouldWarm(string $region): bool
    {
        $lastWarmKey = "cache:last_warm:{$region}";
        $lastWarm = Cache::get($lastWarmKey);

        foreach ($this->schedules as $schedule) {
            if (in_array($region, $schedule['regions'])) {
                if (!$lastWarm || now()->diffInSeconds($lastWarm) >= $schedule['interval']) {
                    return true;
                }
            }
        }

        return false;
    }
}
```

---

# Cache Performance Profiler

## CacheProfiler

```php
<?php

namespace App\Services\Cache;

use Illuminate\Support\Facades\DB;

class CacheProfiler
{
    protected array $operations = [];
    protected float $startTime;

    public function start(): void
    {
        $this->startTime = microtime(true);
        $this->operations = [];
    }

    public function record(string $operation, string $key, float $durationMs, bool $hit): void
    {
        $this->operations[] = [
            'operation' => $operation,
            'key' => $key,
            'duration_ms' => $durationMs,
            'hit' => $hit,
        ];
    }

    public function getReport(): array
    {
        $totalDuration = (microtime(true) - $this->startTime) * 1000;
        $hits = collect($this->operations)->where('hit', true)->count();
        $misses = collect($this->operations)->where('hit', false)->count();
        $total = $hits + $misses;

        return [
            'total_operations' => $total,
            'hits' => $hits,
            'misses' => $misses,
            'hit_ratio' => $total > 0 ? round(($hits / $total) * 100, 2) : 0,
            'total_duration_ms' => round($totalDuration, 2),
            'avg_operation_ms' => $total > 0 ? round($totalDuration / $total, 2) : 0,
            'slowest_operation' => $this->getSlowestOperation(),
            'fastest_operation' => $this->getFastestOperation(),
            'operations_by_type' => $this->getOperationsByType(),
        ];
    }

    protected function getSlowestOperation(): ?array
    {
        return collect($this->operations)->sortByDesc('duration_ms')->first();
    }

    protected function getFastestOperation(): ?array
    {
        return collect($this->operations)->sortBy('duration_ms')->first();
    }

    protected function getOperationsByType(): array
    {
        return collect($this->operations)
            ->groupBy('operation')
            ->map(fn ($ops) => [
                'count' => $ops->count(),
                'avg_duration_ms' => round($ops->avg('duration_ms'), 2),
                'total_duration_ms' => round($ops->sum('duration_ms'), 2),
            ])
            ->toArray();
    }

    public function save(): void
    {
        $report = $this->getReport();
        DB::table('cache_profiler_reports')->insert([
            'report' => json_encode($report),
            'created_at' => now(),
        ]);
    }
}
```

---

# Cache Health Check

## CacheHealthCheck

```php
<?php

namespace App\Services\Cache;

use Illuminate\Support\Facades\Redis;

class CacheHealthCheck
{
    public function __construct(
        protected CacheService $cacheService
    ) {}

    public function check(): array
    {
        return [
            'connection' => $this->checkConnection(),
            'memory' => $this->checkMemory(),
            'hit_ratio' => $this->checkHitRatio(),
            'latency' => $this->checkLatency(),
            'evictions' => $this->checkEvictions(),
            'keys_count' => $this->checkKeysCount(),
        ];
    }

    protected function checkConnection(): array
    {
        try {
            $start = microtime(true);
            Redis::ping();
            $duration = (microtime(true) - $start) * 1000;

            return [
                'status' => 'healthy',
                'latency_ms' => round($duration, 2),
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'unhealthy',
                'error' => $e->getMessage(),
            ];
        }
    }

    protected function checkMemory(): array
    {
        $info = Redis::info('memory');
        $usedMemory = $info['used_memory'] ?? 0;
        $maxMemory = $info['maxmemory'] ?? 0;
        $usagePercent = $maxMemory > 0 ? round(($usedMemory / $maxMemory) * 100, 2) : 0;

        $status = 'healthy';
        if ($usagePercent > 90) {
            $status = 'critical';
        } elseif ($usagePercent > 80) {
            $status = 'warning';
        }

        return [
            'status' => $status,
            'used_mb' => round($usedMemory / 1024 / 1024, 2),
            'max_mb' => round($maxMemory / 1024 / 1024, 2),
            'usage_percent' => $usagePercent,
        ];
    }

    protected function checkHitRatio(): array
    {
        $stats = $this->cacheService->getStats();
        $hitRatio = $stats['hit_ratio'];

        $status = 'healthy';
        if ($hitRatio < 50) {
            $status = 'critical';
        } elseif ($hitRatio < 80) {
            $status = 'warning';
        }

        return [
            'status' => $status,
            'hit_ratio' => $hitRatio,
        ];
    }

    protected function checkLatency(): array
    {
        $latencies = [];
        for ($i = 0; $i < 10; $i++) {
            $start = microtime(true);
            Cache::get('health_check_' . uniqid());
            $latencies[] = (microtime(true) - $start) * 1000;
        }

        $avgLatency = array_sum($latencies) / count($latencies);
        $maxLatency = max($latencies);

        $status = 'healthy';
        if ($maxLatency > 10) {
            $status = 'critical';
        } elseif ($avgLatency > 5) {
            $status = 'warning';
        }

        return [
            'status' => $status,
            'avg_ms' => round($avgLatency, 2),
            'max_ms' => round($maxLatency, 2),
        ];
    }

    protected function checkEvictions(): array
    {
        $info = Redis::info('stats');
        $evictions = $info['evicted_keys'] ?? 0;

        $status = 'healthy';
        if ($evictions > 10000) {
            $status = 'critical';
        } elseif ($evictions > 1000) {
            $status = 'warning';
        }

        return [
            'status' => $status,
            'evictions' => $evictions,
        ];
    }

    protected function checkKeysCount(): array
    {
        $info = Redis::info('keyspace');
        $db0 = $info['db0'] ?? [];
        $keys = $db0['keys'] ?? 0;

        $status = 'healthy';
        if ($keys > 1000000) {
            $status = 'warning';
        }

        return [
            'status' => $status,
            'keys' => $keys,
        ];
    }
}
```

---

# Cache Migration Strategy

```php
<?php

namespace Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCacheTables extends Migration
{
    public function up(): void
    {
        Schema::create('cache_metrics', function (Blueprint $table) {
            $table->id();
            $table->string('metric_name');
            $table->decimal('metric_value', 10, 2);
            $table->json('tags')->nullable();
            $table->timestamp('recorded_at')->useCurrent();
            $table->timestamps();

            $table->index('metric_name');
            $table->index('recorded_at');
            $table->index(['metric_name', 'recorded_at']);
        });

        Schema::create('cache_configurations', function (Blueprint $table) {
            $table->id();
            $table->string('cache_store');
            $table->string('key_pattern');
            $table->text('description')->nullable();
            $table->integer('ttl_seconds')->default(3600);
            $table->enum('invalidation_strategy', ['ttl', 'event', 'manual', 'tag'])->default('ttl');
            $table->json('tags')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index('cache_store');
            $table->index('key_pattern');
            $table->index('is_active');
        });

        Schema::create('cache_invalidation_log', function (Blueprint $table) {
            $table->id();
            $table->string('cache_key', 500);
            $table->enum('invalidation_type', ['ttl', 'manual', 'event', 'tag', 'flush']);
            $table->string('reason')->nullable();
            $table->unsignedBigInteger('invalidated_by')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamps();

            $table->index('cache_key');
            $table->index('invalidation_type');
            $table->index('created_at');
        });

        Schema::create('cache_profiler_reports', function (Blueprint $table) {
            $table->id();
            $table->json('report');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamps();

            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cache_profiler_reports');
        Schema::dropIfExists('cache_invalidation_log');
        Schema::dropIfExists('cache_configurations');
        Schema::dropIfExists('cache_metrics');
    }
}
```

---

# Cache Testing Strategies

## Unit Tests

```php
<?php

namespace Tests\Unit\Services\Cache;

use Tests\TestCase;
use App\Services\Cache\CacheService;
use Illuminate\Support\Facades\Cache;

class CacheServiceTest extends TestCase
{
    protected CacheService $cacheService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->cacheService = app(CacheService::class);
    }

    public function test_set_and_get(): void
    {
        $this->cacheService->set('test_key', 'test_value', 60);
        $result = $this->cacheService->get('test_key');
        $this->assertEquals('test_value', $result);
    }

    public function test_remember(): void
    {
        $result = $this->cacheService->remember('remember_key', 60, function () {
            return 'computed_value';
        });
        $this->assertEquals('computed_value', $result);
    }

    public function test_forget(): void
    {
        $this->cacheService->set('forget_key', 'value', 60);
        $this->cacheService->forget('forget_key');
        $this->assertNull($this->cacheService->get('forget_key'));
    }

    public function test_increment(): void
    {
        $this->cacheService->set('counter', 0, 60);
        $result = $this->cacheService->increment('counter');
        $this->assertEquals(1, $result);
    }

    public function test_has(): void
    {
        $this->cacheService->set('exists_key', 'value', 60);
        $this->assertTrue($this->cacheService->has('exists_key'));
        $this->assertFalse($this->cacheService->has('nonexistent_key'));
    }
}
```

## Feature Tests

```php
<?php

namespace Tests\Feature\Cache;

use Tests\TestCase;
use App\Services\Cache\CacheWarmer;
use App\Services\Cache\CacheInvalidator;
use App\Models\Theme;

class CacheWarmingTest extends TestCase
{
    public function test_themes_are_warmed(): void
    {
        Theme::factory()->count(5)->create(['status' => 'published']);

        $warmer = app(CacheWarmer::class);
        $warmer->warmThemes();

        $this->assertTrue(Cache::has('themes:published'));
    }

    public function test_cache_is_invalidated_on_theme_update(): void
    {
        $theme = Theme::factory()->create(['status' => 'published']);
        Cache::put("theme:{$theme->id}", $theme, 3600);

        $theme->update(['name' => 'Updated Theme']);

        $invalidator = app(CacheInvalidator::class);
        $invalidator->invalidateTheme($theme->id);

        $this->assertFalse(Cache::has("theme:{$theme->id}"));
    }
}
```

## Integration Tests

```php
<?php

namespace Tests\Integration\Cache;

use Tests\TestCase;
use App\Services\Cache\CacheService;
use App\Services\Cache\CacheProfiler;

class CachePerformanceTest extends TestCase
{
    public function test_cache_performance_under_load(): void
    {
        $profiler = app(CacheProfiler::class);
        $profiler->start();

        $cache = app(CacheService::class);

        for ($i = 0; $i < 1000; $i++) {
            $key = "performance_test_{$i}";
            $cache->set($key, "value_{$i}", 60);
            $cache->get($key);
        }

        $report = $profiler->getReport();

        $this->assertGreaterThan(0, $report['total_operations']);
        $this->assertLessThan(5, $report['avg_operation_ms']);
    }
}
```

---

# Cache Documentation

## Cache Key Naming Convention

```text
Pattern: {domain}:{entity}:{id}:{subkey}

Examples:
    theme:123
    themes:published
    component:456:versions
    components:featured
    user:789:permissions
    user:789:settings
    search:results:a1b2c3
    api:rate:token:xyz
    navigation:primary
    cms:page:home
    stats:homepage
    cache:lock:process_order
```

## Cache TTL Guidelines

| Data Type | TTL | Rationale |
|-----------|-----|-----------|
| Static content | 24 hours | Rarely changes |
| User data | 1 hour | Changes occasionally |
| Search results | 15 minutes | Changes with content |
| Statistics | 5 minutes | Changes frequently |
| Rate limits | 1 minute | Time-window based |
| Sessions | 30 minutes | Active user window |
| Feature flags | 5 minutes | Changes on deploy |
| Configuration | 24 hours | Changes rarely |

---

# Cache Deployment Checklist

1. Verify Redis connection is working
2. Run cache warmup after deployment
3. Clear stale cache keys
4. Verify cache metrics collection is active
5. Check memory usage is within limits
6. Test cache invalidation on key operations
7. Verify cache tags are working correctly
8. Monitor cache hit ratio for first hour
9. Confirm cache lock mechanism is functional
10. Verify health check endpoint returns healthy

---

# Cache Environment Variables

```env
# Cache Driver
CACHE_DRIVER=redis

# Redis Configuration
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379
REDIS_CACHE_DB=1
CACHE_PREFIX=gsmui_cache

# Cache Metrics
CACHE_METRICS=true
CACHE_METRICS_RETENTION_HOURS=24

# Cache Warming
CACHE_WARMING=true
CACHE_WARMING_SCHEDULE=daily

# Cache Monitoring
CACHE_MONITORING=true
CACHE_ALERT_HIT_RATIO=80
CACHE_ALERT_MEMORY_USAGE=80
CACHE_ALERT_EVICTIONS=100
CACHE_ALERT_LATENCY_MS=5
```

---

# Cache Troubleshooting Guide

| Symptom | Possible Cause | Solution |
|---------|---------------|----------|
| High memory usage | Too many cached items | Increase TTL, reduce cache scope |
| Low hit ratio | Keys expiring too fast | Increase TTL, check invalidation |
| Slow cache operations | Network latency | Check Redis server, connection pool |
| Cache stampede | Many concurrent misses | Use locks, pre-warm cache |
| Stale data | Missing invalidation | Add event-based invalidation |
| Redis connection errors | Connection pool exhausted | Increase max_connections |
| Cache key collisions | Poor naming convention | Use structured key naming |
| Memory fragmentation | Large objects | Use compression, chunk data |
| Evictions growing | Memory limit too low | Increase maxmemory |
| Lock contention | Too many concurrent locks | Reduce lock scope, use shorter timeouts |

---

# Cache Best Practices

1. **Always use meaningful cache keys** — Follow the `{domain}:{entity}:{id}` pattern
2. **Set appropriate TTL** — Match TTL to data volatility
3. **Use tags for grouped invalidation** — Tag related cache entries
4. **Implement cache warming** — Pre-populate critical cache on deploy
5. **Monitor cache metrics** — Track hit ratio, latency, memory
6. **Use locks for cache stampede prevention** — Prevent thundering herd
7. **Log cache invalidation** — Track who invalidates what and why
8. **Test cache behavior** — Verify invalidation works correctly
9. **Document cache keys** — Maintain a cache key registry
10. **Plan for cache failure** — Ensure graceful degradation

---

# Cache Architecture Diagram

```text
┌─────────────────────────────────────────────────────────┐
│                    Application Layer                     │
├─────────────────────────────────────────────────────────┤
│  CacheService  │  CacheWarmer  │  CacheInvalidator      │
│  (get/set)     │  (warm-up)    │  (invalidate)          │
├─────────────────────────────────────────────────────────┤
│                    Cache Manager                         │
├─────────────────────────────────────────────────────────┤
│  ┌──────────┐  ┌──────────┐  ┌──────────┐              │
│  │ Redis    │  │ Tags     │  │ Locks    │              │
│  │ Driver   │  │ Manager  │  │ Manager  │              │
│  └──────────┘  └──────────┘  └──────────┘              │
├─────────────────────────────────────────────────────────┤
│                  Monitoring & Metrics                    │
├─────────────────────────────────────────────────────────┤
│  CacheProfiler  │  CacheHealthCheck  │  MetricsLogger   │
└─────────────────────────────────────────────────────────┘
```

---

# Cache Data Flow

```text
Request arrives
    ↓
Check Cache Lock
├── Locked → Wait/Release
└── Unlocked → Continue
    ↓
Check Cache Store
├── Hit → Return cached data
└── Miss → Continue
    ↓
Query Database
    ↓
Store in Cache
├── Set key with TTL
├── Apply tags
└── Log access
    ↓
Return data to request
    ↓
Background: Log metrics
```

---

# Cache Implementation Checklist

- [ ] CacheService class implemented
- [ ] CacheWarmer class implemented
- [ ] CacheInvalidator class implemented
- [ ] CacheLock service implemented
- [ ] CacheProfiler implemented
- [ ] CacheHealthCheck implemented
- [ ] Cache monitoring dashboard built
- [ ] Cache metrics collection enabled
- [ ] Cache invalidation logging enabled
- [ ] Cache warming scheduled
- [ ] Cache tests written and passing
- [ ] Cache documentation complete
- [ ] Performance benchmarks documented
- [ ] Troubleshooting guide created
- [ ] Environment variables configured
- [ ] Deployment checklist verified
- [ ] Monitoring alerts configured
- [ ] Health checks passing

---

# Next Document

**31 - Notifications** — Notification system architecture.

**31 - Notifications** — Notification system architecture.
