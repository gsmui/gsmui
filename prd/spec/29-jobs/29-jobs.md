# 29 — Jobs (Background Processing)

## Purpose

Define the background job architecture for GsmUi, covering queue configuration, job design, scheduling, monitoring, and failure handling.

## Technology Stack

| Component | Technology |
|---|---|
| Queue Driver | Redis (production), sync (dev) |
| Job Scheduler | Laravel Scheduler |
| Queue Monitor | Laravel Horizon |
| Failed Jobs | Database table |

## Queue Configuration

```php
// config/queue.php

return [
    'default' => env('QUEUE_CONNECTION', 'redis'),

    'connections' => [
        'sync' => [
            'driver' => 'sync',
        ],
        'redis' => [
            'driver' => 'redis',
            'connection' => 'default',
            'queue' => env('REDIS_QUEUE', 'default'),
            'retry_after' => 90,
            'block_for' => null,
        ],
    ],

    'batching' => [
        'database' => env('DB_CONNECTION', 'mysql'),
        'table' => 'job_batches',
    ],

    'failed' => [
        'driver' => env('QUEUE_FAILED_DRIVER', 'database-uuids'),
        'database' => env('DB_CONNECTION', 'mysql'),
        'table' => 'failed_jobs',
    ],
];
```

## Job Categories

### Authentication Jobs

| Job | Purpose | Queue |
|---|---|---|
| `SendEmailVerification` | Send verification email | mail |
| `SendPasswordReset` | Send reset email | mail |
| `SendLoginAlert` | Notify new device login | mail |
| `CleanupExpiredTokens` | Remove expired tokens | default |
| `CleanupExpiredSessions` | Remove expired sessions | default |

### Marketplace Jobs

| Job | Purpose | Queue |
|---|---|---|
| `ProcessOrder` | Complete order processing | default |
| `GenerateLicense` | Create license key | default |
| `ProcessDownload` | Prepare download file | default |
| `ProcessRefund` | Handle refund | default |
| `SendOrderConfirmation` | Order email | mail |
| `SendRefundConfirmation` | Refund email | mail |

### Billing Jobs

| Job | Purpose | Queue |
|---|---|---|
| `SyncSubscriptionStatus` | Sync with payment provider | default |
| `ProcessWebhook` | Handle payment webhook | default |
| `GenerateInvoice` | Create invoice PDF | default |
| `SendInvoiceEmail` | Invoice email | mail |
| `CheckDunning` | Handle failed payments | default |

### Content Jobs

| Job | Purpose | Queue |
|---|---|---|
| `GenerateSearchIndex` | Index content for search | default |
| `ProcessImageUpload` | Resize/optimize images | default |
| `GenerateThumbnail` | Create thumbnails | default |
| `SyncDocumentation` | Sync docs with code | default |
| `GenerateSitemap` | Build sitemap.xml | default |

### System Jobs

| Job | Purpose | Queue |
|---|---|---|
| `CleanupActivityLog` | Archive old logs | default |
| `CleanupLoginHistory` | Remove old login history | default |
| `BackupDatabase` | Database backup | default |
| `HealthCheck` | System health monitoring | default |
| `SyncAnalytics` | Sync analytics data | default |

## Job Design

### Base Job Class

```php
// app/Jobs/BaseJob.php

abstract class BaseJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;
    public int $timeout = 60;
    public int $maxExceptions = 3;
    public array $backoff = [30, 60, 120];

    public function failure(?Throwable $exception): void
    {
        Log::error("Job failed: " . static::class, [
            'exception' => $exception,
            'job_id' => $this->job->getJobId(),
        ]);

        activity('job-failed')
            ->withProperties([
                'job' => static::class,
                'exception' => $exception->getMessage(),
            ])
            ->log('Background job failed');
    }
}
```

### Example Job

```php
// app/Jobs/Marketplace/ProcessOrder.php

class ProcessOrder extends BaseJob
{
    public function __construct(
        public Order $order,
    ) {}

    public function handle(OrderService $orderService): void
    {
        $orderService->completeOrder($this->order);

        SendOrderConfirmation::dispatch($this->order);
        GenerateLicense::dispatch($this->order);
    }

    public function failed(Throwable $exception): void
    {
        parent::failed($exception);

        $this->order->update(['status' => 'failed']);
    }
}
```

## Job Scheduling

```php
// app/Console/Kernel.php

protected function schedule(Schedule $schedule): void
{
    // Cleanup jobs
    $schedule->job(new CleanupExpiredTokens)->daily();
    $schedule->job(new CleanupExpiredSessions)->daily();
    $schedule->job(new CleanupActivityLog)->daily();
    $schedule->job(new CleanupLoginHistory)->daily();

    // Billing jobs
    $schedule->job(new CheckDunning)->hourly();
    $schedule->job(new SyncSubscriptionStatus)->hourly();

    // System jobs
    $schedule->job(new HealthCheck)->everyFiveMinutes();
    $schedule->job(new GenerateSitemap)->daily();
    $schedule->job(new SyncAnalytics)->hourly();
}
```

## Horizon Configuration

```php
// config/horizon.php

return [
    'environments' => [
        'production' => [
            'supervisor-1' => [
                'connection' => 'redis',
                'queue' => ['default', 'mail', 'critical'],
                'balance' => 'auto',
                'autoScalingStrategy' => 'time',
                'maxProcesses' => 10,
                'maxTime' => 3600,
                'maxJobs' => 1000,
                'memory' => 128,
                'tries' => 3,
                'timeout' => 60,
                'nice' => 0,
            ],
        ],
        'local' => [
            'supervisor-1' => [
                'connection' => 'redis',
                'queue' => ['default', 'mail'],
                'balance' => 'simple',
                'maxProcesses' => 3,
                'maxTime' => 3600,
                'maxJobs' => 1000,
                'memory' => 128,
                'tries' => 3,
                'timeout' => 60,
                'nice' => 0,
            ],
        ],
    ],
];
```

## Queue Priorities

| Queue | Priority | Use Case |
|---|---|---|
| critical | Highest | Security alerts, system errors |
| mail | High | Email notifications |
| default | Normal | General background jobs |
| slow | Low | Analytics, cleanup, indexing |

## Failed Job Handling

| Attempt | Delay | Action |
|---|---|---|
| 1 | Immediate | Process job |
| 2 | 30 seconds | Retry |
| 3 | 60 seconds | Retry |
| 4 | 120 seconds | Retry |
| Failed | — | Move to failed_jobs table |

## Monitoring

| Metric | Alert Threshold |
|---|---|
| Queue depth | > 1000 jobs |
| Failed jobs per hour | > 10 |
| Job processing time | > 60 seconds |
| Worker memory usage | > 256 MB |

## Security Notes

* Jobs never log sensitive data (passwords, tokens)
* Failed jobs logged with context
* Job retries use exponential backoff
* Critical jobs have dedicated queue
* Rate limiting on queue dispatching
* Job payloads encrypted with APP_KEY

---

# Database Schema (Extended)

## jobs

```sql
CREATE TABLE jobs (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    queue VARCHAR(255) NOT NULL,
    payload LONGTEXT NOT NULL,
    attempts TINYINT UNSIGNED NOT NULL,
    reserved_at INT UNSIGNED NULL,
    available_at INT UNSIGNED NOT NULL,
    created_at INT UNSIGNED NOT NULL,
    INDEX idx_queue (queue),
    INDEX idx_reserved_at (reserved_at),
    INDEX idx_available_at (available_at)
);
```

## failed_jobs

```sql
CREATE TABLE failed_jobs (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    uuid VARCHAR(255) UNIQUE NOT NULL,
    connection TEXT NOT NULL,
    queue TEXT NOT NULL,
    payload LONGTEXT NOT NULL,
    exception LONGTEXT NOT NULL,
    failed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_uuid (uuid),
    INDEX idx_queue (queue(191))
);
```

## job_batches

```sql
CREATE TABLE job_batches (
    id VARCHAR(255) PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    total_jobs INT NOT NULL,
    pending_jobs INT NOT NULL,
    failed_jobs INT NOT NULL,
    failed_job_ids LONGTEXT NOT NULL,
    options MEDIUMTEXT NULL,
    cancelled_at INT NULL,
    created_at INT NOT NULL,
    finished_at INT NULL,
    INDEX idx_name (name),
    INDEX idx_created_at (created_at)
);
```

## job_history

```sql
CREATE TABLE job_history (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    job_type VARCHAR(255) NOT NULL,
    job_id BIGINT UNSIGNED NULL,
    batch_id VARCHAR(255) NULL,
    queue VARCHAR(255) NOT NULL,
    status ENUM('queued','processing','completed','failed','cancelled') NOT NULL DEFAULT 'queued',
    attempts INT DEFAULT 0,
    max_attempts INT DEFAULT 3,
    payload JSON NULL,
    result JSON NULL,
    error TEXT NULL,
    started_at TIMESTAMP NULL,
    completed_at TIMESTAMP NULL,
    failed_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_type (job_type),
    INDEX idx_status (status),
    INDEX idx_queue (queue),
    INDEX idx_batch (batch_id),
    INDEX idx_created (created_at)
);
```

## scheduled_tasks

```sql
CREATE TABLE scheduled_tasks (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    command VARCHAR(500) NOT NULL,
    schedule VARCHAR(100) NOT NULL,
    description TEXT NULL,
    is_active BOOLEAN DEFAULT TRUE,
    last_run_at TIMESTAMP NULL,
    last_status ENUM('success','failed','running') NULL,
    last_duration_ms INT NULL,
    last_error TEXT NULL,
    next_run_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_name (name),
    INDEX idx_active (is_active),
    INDEX idx_next_run (next_run_at)
);
```

---

# Job Service Layer

## JobService

```php
<?php

namespace App\Services\Jobs;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Queue;
use Illuminate\Bus\Batch;
use Illuminate\Support\Str;

class JobService
{
    public function dispatch(string $jobClass, mixed $payload = null, array $options = []): string
    {
        $jobId = Str::uuid();

        DB::table('job_history')->insert([
            'job_type' => $jobClass,
            'job_id' => $jobId,
            'queue' => $options['queue'] ?? 'default',
            'status' => 'queued',
            'max_attempts' => $options['tries'] ?? 3,
            'payload' => json_encode($payload),
        ]);

        $job = new $jobClass($payload);
        $job->onQueue($options['queue'] ?? 'default');
        $job->onConnection($options['connection'] ?? 'redis');

        if (isset($options['delay'])) {
            $job->delay($options['delay']);
        }

        $job->dispatch();

        return $jobId;
    }

    public function dispatchBatch(array $jobs, array $options = []): ?string
    {
        if (empty($jobs)) {
            return null;
        }

        $batchId = Str::uuid();
        $batch = Bus::batch($jobs)
            ->name($options['name'] ?? 'Batch: ' . $batchId)
            ->then(function (Batch $batch) use ($batchId) {
                DB::table('job_history')
                    ->where('batch_id', $batchId)
                    ->update(['status' => 'completed', 'completed_at' => now()]);
            })
            ->catch(function (Batch $batch, Throwable $e) use ($batchId) {
                DB::table('job_history')
                    ->where('batch_id', $batchId)
                    ->update(['status' => 'failed', 'error' => $e->getMessage()]);
            })
            ->finally(function (Batch $batch) use ($batchId) {
                DB::table('job_batches')
                    ->where('id', $batchId)
                    ->update(['finished_at' => now()->timestamp]);
            })
            ->onConnection($options['connection'] ?? 'redis')
            ->onQueue($options['queue'] ?? 'default')
            ->dispatch();

        DB::table('job_history')->insert([
            'job_type' => 'Batch',
            'batch_id' => $batch->id,
            'queue' => $options['queue'] ?? 'default',
            'status' => 'queued',
            'max_attempts' => 1,
            'payload' => json_encode(['job_count' => count($jobs)]),
        ]);

        return $batch->id;
    }

    public function getStatus(string $jobId): ?array
    {
        $history = DB::table('job_history')
            ->where('job_id', $jobId)
            ->orWhere('batch_id', $jobId)
            ->first();

        if (!$history) {
            return null;
        }

        return [
            'id' => $history->job_id ?? $history->batch_id,
            'type' => $history->job_type,
            'queue' => $history->queue,
            'status' => $history->status,
            'attempts' => $history->attempts,
            'max_attempts' => $history->max_attempts,
            'started_at' => $history->started_at,
            'completed_at' => $history->completed_at,
            'failed_at' => $history->failed_at,
            'error' => $history->error,
            'duration_ms' => $history->last_duration_ms,
        ];
    }

    public function getQueueStats(): array
    {
        $queues = ['critical', 'mail', 'default', 'slow'];
        $stats = [];

        foreach ($queues as $queue) {
            $pending = DB::table('jobs')->where('queue', $queue)->count();
            $failed = DB::table('failed_jobs')->where('queue', $queue)->count();
            $processing = DB::table('job_history')
                ->where('queue', $queue)
                ->where('status', 'processing')
                ->count();

            $recentCompleted = DB::table('job_history')
                ->where('queue', $queue)
                ->where('status', 'completed')
                ->where('completed_at', '>=', now()->subHour())
                ->count();

            $recentFailed = DB::table('job_history')
                ->where('queue', $queue)
                ->where('status', 'failed')
                ->where('failed_at', '>=', now()->subHour())
                ->count();

            $avgDuration = DB::table('job_history')
                ->where('queue', $queue)
                ->where('status', 'completed')
                ->where('completed_at', '>=', now()->subHour())
                ->avg('last_duration_ms');

            $stats[$queue] = [
                'pending' => $pending,
                'processing' => $processing,
                'failed' => $failed,
                'completed_last_hour' => $recentCompleted,
                'failed_last_hour' => $recentFailed,
                'avg_duration_ms' => round($avgDuration ?? 0, 2),
            ];
        }

        $stats['totals'] = [
            'pending' => array_sum(array_column($stats, 'pending')),
            'processing' => array_sum(array_column($stats, 'processing')),
            'failed' => array_sum(array_column($stats, 'failed')),
        ];

        return $stats;
    }

    public function getFailedJobs(int $limit = 50, int $offset = 0): array
    {
        $jobs = DB::table('failed_jobs')
            ->orderBy('failed_at', 'desc')
            ->limit($limit)
            ->offset($offset)
            ->get()
            ->map(fn ($job) => [
                'id' => $job->id,
                'uuid' => $job->uuid,
                'queue' => $job->queue,
                'payload' => json_decode($job->payload, true),
                'exception' => $job->exception,
                'failed_at' => $job->failed_at,
            ])
            ->toArray();

        $total = DB::table('failed_jobs')->count();

        return [
            'total' => $total,
            'jobs' => $jobs,
        ];
    }

    public function retryJob(int $failedJobId): bool
    {
        $failedJob = DB::table('failed_jobs')->where('id', $failedJobId)->first();
        if (!$failedJob) {
            return false;
        }

        $payload = json_decode($failedJob->payload, true);
        $jobClass = $payload['job'] ?? null;

        if (!$jobClass || !class_exists($jobClass)) {
            return false;
        }

        DB::table('failed_jobs')->where('id', $failedJobId)->delete();

        $this->dispatch($jobClass, $payload['data'] ?? null, [
            'queue' => $failedJob->queue,
        ]);

        return true;
    }

    public function retryAllFailed(): int
    {
        $failedJobs = DB::table('failed_jobs')->get();
        $retryCount = 0;

        foreach ($failedJobs as $failedJob) {
            if ($this->retryJob($failedJob->id)) {
                $retryCount++;
            }
        }

        return $retryCount;
    }

    public function clearFailed(): int
    {
        $count = DB::table('failed_jobs')->count();
        DB::table('failed_jobs')->truncate();
        return $count;
    }

    public function getJobTypes(): array
    {
        return [
            'authentication' => [
                'jobs' => [
                    'SendEmailVerification',
                    'SendPasswordReset',
                    'SendLoginAlert',
                    'CleanupExpiredTokens',
                    'CleanupExpiredSessions',
                ],
                'queue' => 'mail',
            ],
            'marketplace' => [
                'jobs' => [
                    'ProcessOrder',
                    'GenerateLicense',
                    'ProcessDownload',
                    'ProcessRefund',
                    'SendOrderConfirmation',
                    'SendRefundConfirmation',
                ],
                'queue' => 'default',
            ],
            'billing' => [
                'jobs' => [
                    'SyncSubscriptionStatus',
                    'ProcessWebhook',
                    'GenerateInvoice',
                    'SendInvoiceEmail',
                    'CheckDunning',
                ],
                'queue' => 'default',
            ],
            'content' => [
                'jobs' => [
                    'GenerateSearchIndex',
                    'ProcessImageUpload',
                    'GenerateThumbnail',
                    'SyncDocumentation',
                    'GenerateSitemap',
                ],
                'queue' => 'default',
            ],
            'system' => [
                'jobs' => [
                    'CleanupActivityLog',
                    'CleanupLoginHistory',
                    'BackupDatabase',
                    'HealthCheck',
                    'SyncAnalytics',
                ],
                'queue' => 'default',
            ],
        ];
    }
}
```

---

# Concrete Job Implementations

## ProcessOrder

```php
<?php

namespace App\Jobs\Marketplace;

use App\Services\Jobs\BaseJob;
use App\Models\Order;
use App\Services\Marketplace\OrderService;

class ProcessOrder extends BaseJob
{
    public function __construct(
        public Order $order,
    ) {
        $this->onQueue('default');
    }

    public function handle(OrderService $orderService): void
    {
        DB::table('job_history')
            ->where('job_type', static::class)
            ->where('payload', 'LIKE', "%{$this->order->id}%")
            ->update([
                'status' => 'processing',
                'started_at' => now(),
                'attempts' => DB::raw('attempts + 1'),
            ]);

        $orderService->completeOrder($this->order);

        SendOrderConfirmation::dispatch($this->order);
        GenerateLicense::dispatch($this->order);

        DB::table('job_history')
            ->where('job_type', static::class)
            ->where('payload', 'LIKE', "%{$this->order->id}%")
            ->update([
                'status' => 'completed',
                'completed_at' => now(),
                'last_duration_ms' => $this->getDurationMs(),
            ]);
    }

    public function failed(\Throwable $exception): void
    {
        parent::failed($exception);

        $this->order->update(['status' => 'failed']);

        DB::table('job_history')
            ->where('job_type', static::class)
            ->where('payload', 'LIKE', "%{$this->order->id}%")
            ->update([
                'status' => 'failed',
                'failed_at' => now(),
                'error' => $exception->getMessage(),
            ]);
    }
}
```

## GenerateSitemap

```php
<?php

namespace App\Jobs\Content;

use App\Services\Jobs\BaseJob;
use App\Cms\Services\SeoService;
use Illuminate\Support\Facades\Storage;

class GenerateSitemap extends BaseJob
{
    public int $timeout = 120;
    public int $tries = 1;
    public string $queue = 'slow';

    public function handle(SeoService $seoService): void
    {
        $sitemap = $seoService->generateSitemap();

        Storage::disk('public')->put('sitemap.xml', $sitemap);
        Storage::disk('public')->put('sitemap.xml.gz', gzencode($sitemap));
    }
}
```

## IndexComponentForSearch

```php
<?php

namespace App\Jobs\Search;

use App\Services\Jobs\BaseJob;
use App\Models\Component;
use App\Services\Search\SearchService;

class IndexComponentForSearch extends BaseJob
{
    public function __construct(
        public int $componentId,
    ) {
        $this->onQueue('default');
    }

    public function handle(SearchService $searchService): void
    {
        $component = Component::find($this->componentId);
        if (!$component) {
            return;
        }

        $searchService->indexComponent($component);
    }
}
```

## ProcessImageUpload

```php
<?php

namespace App\Jobs\Media;

use App\Services\Jobs\BaseJob;
use App\Models\Media;
use App\Services\Media\ThumbnailService;
use App\Services\Media\MetadataService;

class ProcessImageUpload extends BaseJob
{
    public function __construct(
        public int $mediaId,
    ) {
        $this->onQueue('default');
    }

    public function handle(ThumbnailService $thumbnailService, MetadataService $metadataService): void
    {
        $media = Media::find($this->mediaId);
        if (!$media || $media->file_type !== 'image') {
            return;
        }

        $thumbnailService->generate($media);
    }
}
```

## CleanupActivityLog

```php
<?php

namespace App\Jobs\System;

use App\Services\Jobs\BaseJob;
use Illuminate\Support\Facades\DB;

class CleanupActivityLog extends BaseJob
{
    public int $timeout = 300;
    public int $tries = 1;
    public string $queue = 'slow';

    public function handle(): void
    {
        $retentionDays = config('jobs.cleanup.activity_log_days', 90);

        $deleted = DB::table('activity_log')
            ->where('created_at', '<', now()->subDays($retentionDays))
            ->delete();

        \Log::info("Activity log cleanup", ['deleted' => $deleted]);
    }
}
```

## HealthCheck

```php
<?php

namespace App\Jobs\System;

use App\Services\Jobs\BaseJob;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class HealthCheck extends BaseJob
{
    public int $timeout = 30;
    public int $tries = 1;
    public string $queue = 'default';

    public function handle(): void
    {
        $checks = [
            'database' => $this->checkDatabase(),
            'redis' => $this->checkRedis(),
            'queue' => $this->checkQueue(),
            'storage' => $this->checkStorage(),
        ];

        $allHealthy = !in_array(false, array_values($checks));

        if (!$allHealthy) {
            \Log::critical("Health check failed", $checks);
            // Send alert
        }

        DB::table('health_checks')->insert([
            'checks' => json_encode($checks),
            'is_healthy' => $allHealthy,
            'created_at' => now(),
        ]);
    }

    protected function checkDatabase(): bool
    {
        try {
            DB::connection()->getPdo();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    protected function checkRedis(): bool
    {
        try {
            return \Illuminate\Support\Facades\Redis::ping();
        } catch (\Exception $e) {
            return false;
        }
    }

    protected function checkQueue(): bool
    {
        try {
            $depth = DB::table('jobs')->count();
            return $depth < 1000;
        } catch (\Exception $e) {
            return false;
        }
    }

    protected function checkStorage(): bool
    {
        try {
            return \Illuminate\Support\Facades\Storage::disk('local')->put('health-check', 'ok');
        } catch (\Exception $e) {
            return false;
        }
    }
}
```

---

# Job Middleware

## RateLimitedMiddleware

```php
<?php

namespace App\Jobs\Middleware;

use Illuminate\Support\Facades\RateLimiter;

class RateLimitedMiddleware
{
    public function handle(object $job, \Closure $next): void
    {
        $key = 'job:' . class_basename($job);

        if (RateLimiter::tooManyAttempts($key, $job->maxTries ?? 3)) {
            $job->release(RateLimiter::availableIn($key));
            return;
        }

        RateLimiter::hit($key, 60);

        $next($job);
    }
}
```

## EnsureUniqueMiddleware

```php
<?php

namespace App\Jobs\Middleware;

use Illuminate\Support\Facades\Cache;

class EnsureUniqueMiddleware
{
    public function handle(object $job, \Closure $next): void
    {
        $uniqueKey = 'job_unique:' . class_basename($job) . ':' . md5(serialize($job));

        if (Cache::has($uniqueKey)) {
            $job->delete();
            return;
        }

        Cache::put($uniqueKey, true, 300);

        $next($job);

        Cache::forget($uniqueKey);
    }
}
```

---

# Job Dashboard

## DashboardController

```php
<?php

namespace App\Http\Controllers\Jobs;

use App\Http\Controllers\Controller;
use App\Services\Jobs\JobService;
use Illuminate\Http\Request;

class JobDashboardController extends Controller
{
    public function __construct(
        protected JobService $jobService
    ) {}

    public function index()
    {
        $stats = $this->jobService->getQueueStats();
        $failedJobs = $this->jobService->getFailedJobs(20);
        $jobTypes = $this->jobService->getJobTypes();

        return view('jobs.dashboard', compact('stats', 'failedJobs', 'jobTypes'));
    }

    public function stats(): \Illuminate\Http\JsonResponse
    {
        return response()->json($this->jobService->getQueueStats());
    }

    public function failed(Request $request): \Illuminate\Http\JsonResponse
    {
        $limit = $request->input('limit', 50);
        $offset = $request->input('offset', 0);

        return response()->json($this->jobService->getFailedJobs($limit, $offset));
    }

    public function retry(int $id): \Illuminate\Http\JsonResponse
    {
        $success = $this->jobService->retryJob($id);
        return response()->json(['success' => $success]);
    }

    public function retryAll(): \Illuminate\Http\JsonResponse
    {
        $count = $this->jobService->retryAllFailed();
        return response()->json(['retried' => $count]);
    }

    public function clear(): \Illuminate\Http\JsonResponse
    {
        $count = $this->jobService->clearFailed();
        return response()->json(['cleared' => $count]);
    }
}
```

---

# Job Routes

```php
<?php

use App\Http\Controllers\Jobs\JobDashboardController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin/jobs')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [JobDashboardController::class, 'index'])->name('jobs.dashboard');
    Route::get('/stats', [JobDashboardController::class, 'stats'])->name('jobs.stats');
    Route::get('/failed', [JobDashboardController::class, 'failed'])->name('jobs.failed');
    Route::post('/failed/{id}/retry', [JobDashboardController::class, 'retry'])->name('jobs.retry');
    Route::post('/failed/retry-all', [JobDashboardController::class, 'retryAll'])->name('jobs.retry-all');
    Route::delete('/failed/clear', [JobDashboardController::class, 'clear'])->name('jobs.clear');
});
```

---

# Job Caching Strategy

| Cache Key | TTL | Purpose |
|-----------|-----|---------|
| `job:stats:queue:{queue}` | 1 min | Queue statistics |
| `job:unique:{class}:{hash}` | 5 min | Unique job lock |
| `job:rate:{class}` | 1 min | Rate limiting |
| `job:health:check` | 5 min | Health check results |

---

# Job Events

```php
<?php

namespace App\Events\Jobs;

use Illuminate\Foundation\Events\Dispatchable;

class JobCompleted
{
    use Dispatchable;

    public function __construct(
        public string $jobType,
        public string $jobId,
        public string $queue,
        public int $durationMs,
    ) {}
}
```

```php
<?php

namespace App\Events\Jobs;

use Illuminate\Foundation\Events\Dispatchable;

class JobFailed
{
    use Dispatchable;

    public function __construct(
        public string $jobType,
        public string $jobId,
        public string $queue,
        public string $error,
    ) {}
}
```

---

# Job Configuration

```php
// config/jobs.php

return [
    'default_queue' => env('JOB_DEFAULT_QUEUE', 'default'),
    'mail_queue' => env('JOB_MAIL_QUEUE', 'mail'),
    'critical_queue' => env('JOB_CRITICAL_QUEUE', 'critical'),
    'slow_queue' => env('JOB_SLOW_QUEUE', 'slow'),

    'timeouts' => [
        'default' => 60,
        'mail' => 30,
        'critical' => 120,
        'slow' => 300,
    ],

    'tries' => [
        'default' => 3,
        'mail' => 3,
        'critical' => 5,
        'slow' => 1,
    ],

    'backoff' => [
        'default' => [30, 60, 120],
        'mail' => [10, 30],
        'critical' => [5, 15, 30, 60],
        'slow' => [60],
    ],

    'cleanup' => [
        'activity_log_days' => 90,
        'login_history_days' => 30,
        'job_history_days' => 30,
        'health_check_days' => 7,
    ],

    'monitoring' => [
        'enabled' => true,
        'alert_threshold_queue_depth' => 1000,
        'alert_threshold_failed_per_hour' => 10,
        'alert_threshold_processing_time_ms' => 60000,
        'alert_threshold_memory_mb' => 256,
    ],
];
```

---

# Job Testing Strategy

## Unit Tests

* Job handle method execution
* Job failure handling
* Job middleware behavior
* Queue configuration
* Rate limiting logic

## Feature Tests

* Job dispatching
* Job batch execution
* Job scheduling
* Failed job retry
* Job monitoring

## Integration Tests

* Queue worker behavior
* Horizon dashboard
* Job scheduling accuracy
* Cross-queue prioritization

---

# Job Security

* Job payloads never contain secrets
* Failed jobs sanitize sensitive data
* Job queue access restricted
* Horizon dashboard behind auth
* Rate limiting on job dispatch
* Job batches have size limits
* Timeout prevents hanging jobs
* Memory limits prevent OOM

---

# Job Pipeline

## Pipeline Configuration

```php
<?php

namespace App\Services\Jobs\Pipelines;

use Illuminate\Pipeline\Pipeline;

class JobPipeline
{
    public function through(array $middleware): static
    {
        $this->middleware = $middleware;
        return $this;
    }

    public function via(string $stage): static
    {
        $this->stage = $stage;
        return $this;
    }

    public function run(mixed $payload, \Closure $next): mixed
    {
        return app(Pipeline::class)
            ->send($payload)
            ->through($this->middleware)
            ->then($next);
    }
}
```

## Job Pipeline Middleware

```php
<?php

namespace App\Services\Jobs\Pipelines;

class ValidatePayloadMiddleware
{
    public function handle(mixed $payload, \Closure $next): mixed
    {
        if (empty($payload)) {
            throw new \InvalidArgumentException('Job payload cannot be empty');
        }

        return $next($payload);
    }
}
```

```php
<?php

namespace App\Services\Jobs\Pipelines;

class LogJobStartMiddleware
{
    public function handle(mixed $payload, \Closure $next): mixed
    {
        \Log::info('Job started', [
            'job' => get_class($this),
            'payload' => $payload,
        ]);

        $result = $next($payload);

        \Log::info('Job completed', [
            'job' => get_class($this),
        ]);

        return $result;
    }
}
```

---

# Job Batch Processing

## BatchService

```php
<?php

namespace App\Services\Jobs;

use Illuminate\Support\Facades\DB;
use Illuminate\Bus\Batch;

class BatchService
{
    public function createBatch(string $name, array $jobs, array $options = []): Batch
    {
        return Bus::batch($jobs)
            ->name($name)
            ->onConnection($options['connection'] ?? 'redis')
            ->onQueue($options['queue'] ?? 'default')
            ->then(function (Batch $batch) {
                $this->onBatchComplete($batch);
            })
            ->catch(function (Batch $batch, \Throwable $e) {
                $this->onBatchFailed($batch, $e);
            })
            ->finally(function (Batch $batch) {
                $this->onBatchFinally($batch);
            })
            ->allowFailures()
            ->dispatch();
    }

    protected function onBatchComplete(Batch $batch): void
    {
        DB::table('job_batches')
            ->where('id', $batch->id)
            ->update(['finished_at' => now()->timestamp]);

        \Log::info("Batch completed", [
            'batch_id' => $batch->id,
            'name' => $batch->name,
            'total_jobs' => $batch->totalJobs,
            'failed_jobs' => $batch->failedJobs,
        ]);
    }

    protected function onBatchFailed(Batch $batch, \Throwable $e): void
    {
        \Log::error("Batch failed", [
            'batch_id' => $batch->id,
            'name' => $batch->name,
            'error' => $e->getMessage(),
        ]);
    }

    protected function onBatchFinally(Batch $batch): void
    {
        DB::table('job_batches')
            ->where('id', $batch->id)
            ->update(['finished_at' => now()->timestamp]);
    }

    public function getBatch(string $batchId): ?array
    {
        $batch = DB::table('job_batches')->where('id', $batchId)->first();
        if (!$batch) {
            return null;
        }

        return [
            'id' => $batch->id,
            'name' => $batch->name,
            'total_jobs' => $batch->total_jobs,
            'pending_jobs' => $batch->pending_jobs,
            'failed_jobs' => $batch->failed_jobs,
            'failed_job_ids' => json_decode($batch->failed_job_ids, true),
            'created_at' => $batch->created_at,
            'finished_at' => $batch->finished_at,
            'cancelled_at' => $batch->cancelled_at,
        ];
    }

    public function cancelBatch(string $batchId): bool
    {
        $batch = Bus::findBatch($batchId);
        if (!$batch) {
            return false;
        }

        $batch->cancel();
        return true;
    }
}
```

---

# Job Scheduler Commands

## ScheduleRunCommand

```php
<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\Jobs\ScheduleService;

class ScheduleRunCommand extends Command
{
    protected $signature = 'schedule:run-custom';
    protected $description = 'Run custom scheduled tasks';

    public function handle(ScheduleService $scheduleService): int
    {
        $results = $scheduleService->runDueTasks();

        foreach ($results as $result) {
            if ($result['status'] === 'success') {
                $this->info("Task {$result['name']} completed in {$result['duration_ms']}ms");
            } else {
                $this->error("Task {$result['name']} failed: {$result['error']}");
            }
        }

        return Command::SUCCESS;
    }
}
```

## ScheduleService

```php
<?php

namespace App\Services\Jobs;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Process;

class ScheduleService
{
    public function registerTask(string $name, string $command, string $schedule, string $description = null): void
    {
        DB::table('scheduled_tasks')->updateOrInsert(
            ['name' => $name],
            [
                'command' => $command,
                'schedule' => $schedule,
                'description' => $description,
                'is_active' => true,
                'next_run_at' => $this->calculateNextRun($schedule),
            ]
        );
    }

    public function runDueTasks(): array
    {
        $tasks = DB::table('scheduled_tasks')
            ->where('is_active', true)
            ->where('next_run_at', '<=', now())
            ->get();

        $results = [];

        foreach ($tasks as $task) {
            $result = $this->runTask($task);
            $results[] = $result;

            DB::table('scheduled_tasks')
                ->where('id', $task->id)
                ->update([
                    'last_run_at' => now(),
                    'last_status' => $result['status'],
                    'last_duration_ms' => $result['duration_ms'],
                    'last_error' => $result['error'],
                    'next_run_at' => $this->calculateNextRun($task->schedule),
                ]);
        }

        return $results;
    }

    protected function runTask(object $task): array
    {
        $startTime = microtime(true);

        try {
            $process = Process::timeout(300)->run($task->command);
            $durationMs = round((microtime(true) - $startTime) * 1000);

            return [
                'name' => $task->name,
                'status' => $process->successful() ? 'success' : 'failed',
                'duration_ms' => $durationMs,
                'output' => $process->output(),
                'error' => $process->errorOutput(),
            ];
        } catch (\Exception $e) {
            $durationMs = round((microtime(true) - $startTime) * 1000);

            return [
                'name' => $task->name,
                'status' => 'failed',
                'duration_ms' => $durationMs,
                'output' => null,
                'error' => $e->getMessage(),
            ];
        }
    }

    protected function calculateNextRun(string $schedule): \DateTime
    {
        $now = now();

        return match ($schedule) {
            'every_minute' => $now->addMinute(),
            'every_five_minutes' => $now->addMinutes(5),
            'every_fifteen_minutes' => $now->addMinutes(15),
            'every_thirty_minutes' => $now->addMinutes(30),
            'hourly' => $now->addHour(),
            'daily' => $now->addDay(),
            'weekly' => $now->addWeek(),
            'monthly' => $now->addMonth(),
            default => $now->addHour(),
        };
    }

    public function getTasks(): array
    {
        return DB::table('scheduled_tasks')
            ->orderBy('name')
            ->get()
            ->toArray();
    }

    public function toggleTask(int $taskId, bool $isActive): bool
    {
        return DB::table('scheduled_tasks')
            ->where('id', $taskId)
            ->update(['is_active' => $isActive]) > 0;
    }

    public function deleteTask(int $taskId): bool
    {
        return DB::table('scheduled_tasks')
            ->where('id', $taskId)
            ->delete() > 0;
    }
}
```

---

# Job Monitoring Service

## MonitoringService

```php
<?php

namespace App\Services\Jobs;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class MonitoringService
{
    public function getMetrics(): array
    {
        return [
            'queue_depth' => $this->getQueueDepth(),
            'processing' => $this->getProcessingCount(),
            'failed_last_hour' => $this->getFailedLastHour(),
            'completed_last_hour' => $this->getCompletedLastHour(),
            'avg_processing_time' => $this->getAvgProcessingTime(),
            'memory_usage' => $this->getMemoryUsage(),
            'worker_count' => $this->getWorkerCount(),
        ];
    }

    protected function getQueueDepth(): array
    {
        $queues = ['critical', 'mail', 'default', 'slow'];
        $depth = [];

        foreach ($queues as $queue) {
            $depth[$queue] = DB::table('jobs')->where('queue', $queue)->count();
        }

        $depth['total'] = array_sum($depth);
        return $depth;
    }

    protected function getProcessingCount(): int
    {
        return DB::table('job_history')
            ->where('status', 'processing')
            ->count();
    }

    protected function getFailedLastHour(): int
    {
        return DB::table('failed_jobs')
            ->where('failed_at', '>=', now()->subHour())
            ->count();
    }

    protected function getCompletedLastHour(): int
    {
        return DB::table('job_history')
            ->where('status', 'completed')
            ->where('completed_at', '>=', now()->subHour())
            ->count();
    }

    protected function getAvgProcessingTime(): float
    {
        return DB::table('job_history')
            ->where('status', 'completed')
            ->where('completed_at', '>=', now()->subHour())
            ->avg('last_duration_ms') ?? 0;
    }

    protected function getMemoryUsage(): array
    {
        return [
            'current_mb' => round(memory_get_usage(true) / 1024 / 1024, 2),
            'peak_mb' => round(memory_get_peak_usage(true) / 1024 / 1024, 2),
        ];
    }

    protected function getWorkerCount(): int
    {
        $processes = shell_exec('ps aux | grep "queue:work" | grep -v grep | wc -l');
        return (int) trim($processes ?? '0');
    }

    public function checkAlerts(): array
    {
        $metrics = $this->getMetrics();
        $alerts = [];
        $config = config('jobs.monitoring');

        if ($metrics['queue_depth']['total'] > $config['alert_threshold_queue_depth']) {
            $alerts[] = [
                'type' => 'warning',
                'message' => "Queue depth is {$metrics['queue_depth']['total']} (threshold: {$config['alert_threshold_queue_depth']})",
            ];
        }

        if ($metrics['failed_last_hour'] > $config['alert_threshold_failed_per_hour']) {
            $alerts[] = [
                'type' => 'critical',
                'message' => "Failed jobs in last hour: {$metrics['failed_last_hour']} (threshold: {$config['alert_threshold_failed_per_hour']})",
            ];
        }

        if ($metrics['avg_processing_time'] > $config['alert_threshold_processing_time_ms']) {
            $alerts[] = [
                'type' => 'warning',
                'message' => "Avg processing time: {$metrics['avg_processing_time']}ms (threshold: {$config['alert_threshold_processing_time_ms']}ms)",
            ];
        }

        if ($metrics['memory_usage']['current_mb'] > $config['alert_threshold_memory_mb']) {
            $alerts[] = [
                'type' => 'critical',
                'message' => "Memory usage: {$metrics['memory_usage']['current_mb']}MB (threshold: {$config['alert_threshold_memory_mb']}MB)",
            ];
        }

        return $alerts;
    }
}
```

---

# Job Livewire Components

## JobDashboard Component

```php
<?php

namespace App\Http\Livewire\Jobs;

use Livewire\Component;
use App\Services\Jobs\JobService;
use App\Services\Jobs\MonitoringService;

class JobDashboard extends Component
{
    public $stats = [];
    public $failedJobs = [];
    public $metrics = [];
    public $alerts = [];
    public $autoRefresh = true;
    public $refreshInterval = 30;

    protected JobService $jobService;
    protected MonitoringService $monitoringService;

    public function boot(JobService $jobService, MonitoringService $monitoringService): void
    {
        $this->jobService = $jobService;
        $this->monitoringService = $monitoringService;
    }

    public function mount(): void
    {
        $this->refresh();
    }

    public function refresh(): void
    {
        $this->stats = $this->jobService->getQueueStats();
        $this->failedJobs = $this->jobService->getFailedJobs(20)['jobs'];
        $this->metrics = $this->monitoringService->getMetrics();
        $this->alerts = $this->monitoringService->checkAlerts();
    }

    public function retryJob(int $jobId): void
    {
        $this->jobService->retryJob($jobId);
        $this->refresh();
        $this->dispatch('job-retried');
    }

    public function retryAll(): void
    {
        $count = $this->jobService->retryAllFailed();
        $this->refresh();
        $this->dispatch('jobs-retried', count: $count);
    }

    public function clearFailed(): void
    {
        $this->jobService->clearFailed();
        $this->refresh();
        $this->dispatch('jobs-cleared');
    }

    public function updatedAutoRefresh(): void
    {
        if ($this->autoRefresh) {
            $this->dispatch('start-auto-refresh', interval: $this->refreshInterval);
        } else {
            $this->dispatch('stop-auto-refresh');
        }
    }

    public function render()
    {
        return view('livewire.jobs.dashboard');
    }
}
```

---

# Job Blade Templates

## Dashboard View

```blade
{{-- resources/views/livewire/jobs/dashboard.blade.php --}}
<div class="space-y-6">
    {{-- Alerts --}}
    @foreach($alerts as $alert)
        <div class="rounded-lg p-4 {{ $alert['type'] === 'critical' ? 'bg-red-50 text-red-800' : 'bg-yellow-50 text-yellow-800' }}">
            <div class="flex items-center gap-2">
                <x-heroicon-o-exclamation-triangle class="w-5 h-5" />
                <span>{{ $alert['message'] }}</span>
            </div>
        </div>
    @endforeach

    {{-- Queue Stats --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        @foreach(['critical', 'mail', 'default', 'slow'] as $queue)
            <div class="bg-white dark:bg-zinc-800 rounded-lg p-4 border">
                <h3 class="text-sm font-medium text-zinc-500">{{ ucfirst($queue) }} Queue</h3>
                <div class="mt-2 space-y-1">
                    <div class="flex justify-between">
                        <span class="text-sm text-zinc-600">Pending</span>
                        <span class="font-medium">{{ $stats[$queue]['pending'] ?? 0 }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-zinc-600">Processing</span>
                        <span class="font-medium">{{ $stats[$queue]['processing'] ?? 0 }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-zinc-600">Failed (1h)</span>
                        <span class="font-medium text-red-600">{{ $stats[$queue]['failed_last_hour'] ?? 0 }}</span>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- Failed Jobs --}}
    <div class="bg-white dark:bg-zinc-800 rounded-lg border">
        <div class="px-4 py-3 border-b flex items-center justify-between">
            <h2 class="text-lg font-semibold">Failed Jobs</h2>
            <div class="flex gap-2">
                <button wire:click="retryAll" class="btn btn-sm btn-primary">Retry All</button>
                <button wire:click="clearFailed" class="btn btn-sm btn-danger">Clear All</button>
            </div>
        </div>
        <div class="divide-y">
            @forelse($failedJobs as $job)
                <div class="px-4 py-3 flex items-center justify-between">
                    <div>
                        <div class="font-medium">{{ class_basename($job['payload']['job'] ?? 'Unknown') }}</div>
                        <div class="text-sm text-zinc-500">{{ $job['failed_at'] }}</div>
                    </div>
                    <button wire:click="retryJob({{ $job['id'] }})" class="btn btn-sm btn-secondary">
                        Retry
                    </button>
                </div>
            @empty
                <div class="px-4 py-8 text-center text-zinc-500">No failed jobs</div>
            @endforelse
        </div>
    </div>

    {{-- Auto Refresh Toggle --}}
    <div class="flex items-center gap-2">
        <label class="text-sm text-zinc-600">Auto-refresh:</label>
        <input type="checkbox" wire:model="autoRefresh" class="toggle">
        <span class="text-sm text-zinc-500">Every {{ $refreshInterval }}s</span>
    </div>
</div>
```

---

# Job Migrations

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobTables extends Migration
{
    public function up(): void
    {
        Schema::create('job_history', function (Blueprint $table) {
            $table->id();
            $table->string('job_type');
            $table->string('job_id')->nullable();
            $table->string('batch_id')->nullable();
            $table->string('queue');
            $table->enum('status', ['queued', 'processing', 'completed', 'failed', 'cancelled'])->default('queued');
            $table->integer('attempts')->default(0);
            $table->integer('max_attempts')->default(3);
            $table->json('payload')->nullable();
            $table->json('result')->nullable();
            $table->text('error')->nullable();
            $table->timestamp('started_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamp('failed_at')->nullable();
            $table->timestamps();

            $table->index('job_type');
            $table->index('status');
            $table->index('queue');
            $table->index('batch_id');
            $table->index('created_at');
        });

        Schema::create('scheduled_tasks', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('command');
            $table->string('schedule');
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamp('last_run_at')->nullable();
            $table->enum('last_status', ['success', 'failed', 'running'])->nullable();
            $table->integer('last_duration_ms')->nullable();
            $table->text('last_error')->nullable();
            $table->timestamp('next_run_at')->nullable();
            $table->timestamps();

            $table->index('name');
            $table->index('is_active');
            $table->index('next_run_at');
        });

        Schema::create('health_checks', function (Blueprint $table) {
            $table->id();
            $table->json('checks');
            $table->boolean('is_healthy');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('health_checks');
        Schema::dropIfExists('scheduled_tasks');
        Schema::dropIfExists('job_history');
    }
}
```

---

# Job Performance Tuning

| Setting | Production | Staging | Development |
|---------|------------|---------|-------------|
| maxProcesses | 10 | 3 | 1 |
| maxTime | 3600 | 3600 | 3600 |
| maxJobs | 1000 | 500 | 100 |
| memory | 128 | 128 | 128 |
| balance | auto | simple | simple |
| timeout (default) | 60 | 60 | 60 |
| timeout (slow) | 300 | 300 | 300 |
| tries (default) | 3 | 3 | 1 |
| tries (critical) | 5 | 5 | 3 |

---

# Job Security Notes

* Job payloads are serialized and never logged in plain text
* Failed jobs sanitize passwords, tokens, and secrets before storage
* Job queue connections use Redis AUTH for authentication
* Horizon dashboard requires admin authentication
* Rate limiting prevents job queue flooding
* Job batches have configurable maximum sizes
* Timeouts prevent hanging jobs from consuming resources
* Memory limits prevent out-of-memory crashes
* Failed job retry is rate-limited to prevent infinite loops
* Job queue access is restricted to authorized workers only
* Encrypted payloads for sensitive job data (APP_KEY)
* Job signatures prevent tampering with queued jobs

---

# Job Deployment Checklist

1. Run `php artisan queue:restart` after deployment
2. Verify Horizon is running: `php artisan horizon:status`
3. Check queue depths are below thresholds
4. Verify scheduled tasks are registered
5. Monitor failed jobs for first 30 minutes
6. Confirm worker memory usage is stable
7. Test critical job paths end-to-end
8. Verify webhook deliveries are working
9. Check job batch processing is functional
10. Confirm monitoring alerts are configured

---

# Job Troubleshooting Guide

| Symptom | Possible Cause | Solution |
|---------|---------------|----------|
| Jobs stuck in queue | Worker not running | Restart queue worker |
| High memory usage | Memory leak in job | Profile job, increase limit |
| Jobs failing silently | Missing exception handling | Add try-catch, check logs |
| Slow job processing | Heavy database queries | Optimize queries, add caching |
| Batch jobs partially failing | One job in batch fails | Check `allowFailures` setting |
| Horizon not balancing | Supervisor misconfiguration | Check Horizon config |
| Duplicate jobs running | No unique lock middleware | Add EnsureUniqueMiddleware |
| Scheduled task not running | Cron not configured | Verify crontab entry |
| Queue depth growing | Workers too slow | Scale up workers |
| Jobs lost after restart | Missing retry logic | Configure retry_after |

---

# Job Environment Variables

```env
# Queue Configuration
QUEUE_CONNECTION=redis
REDIS_QUEUE=default

# Horizon
HORIZON_PREFIX=horizon:

# Monitoring
JOB_MONITORING_ENABLED=true
JOB_ALERT_QUEUE_DEPTH=1000
JOB_ALERT_FAILED_PER_HOUR=10
JOB_ALERT_PROCESSING_TIME_MS=60000
JOB_ALERT_MEMORY_MB=256

# Cleanup
JOB_ACTIVITY_LOG_DAYS=90
JOB_LOGIN_HISTORY_DAYS=30
JOB_HISTORY_DAYS=30
```

---

# Next Document

**30 - Cache** — Caching architecture and strategies.
