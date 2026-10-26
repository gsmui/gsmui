# Queue Management

> PRD — Volume 22: DevOps — Queue Management

## Overview

The Queue Management system configures job dispatching, driver selection, retry logic, rate limiting, and failure handling. It supports Redis, database, SQS, and sync drivers with configurable priorities.

## Objectives

| Goal | Metric | Target |
|------|--------|--------|
| Job throughput | Jobs processed per second | 100+ |
| Job latency | Average time to pickup | < 1 second |
| Failure recovery | Failed job retry success rate | 90%+ |
| Memory usage | Per-worker memory consumption | < 256MB |
| Queue depth | Max acceptable queue depth | < 500 |

## Driver Selection

| Driver | Use Case | Throughput | Reliability | Complexity |
|--------|----------|-----------|-------------|------------|
| `redis` | Default, high performance | 10,000+/min | High | Low |
| `database` | Simple setups, persistence | 500/min | Medium | Low |
| `sqs` | AWS infrastructure | 3,000+/min | High | Medium |
| `sync` | Development/testing | N/A | N/A | None |
| `beanstalkd` | Lightweight alternative | 5,000+/min | High | Medium |

### Driver Configuration

```php
// config/queue.php
return [
    'default' => env('QUEUE_CONNECTION', 'redis'),

    'connections' => [
        'redis' => [
            'driver' => 'redis',
            'connection' => 'default',
            'queue' => env('REDIS_QUEUE', 'default'),
            'retry_after' => 90,
            'block_for' => null,
            'after_commit' => false,
        ],

        'database' => [
            'driver' => 'database',
            'connection' => null,
            'table' => 'jobs',
            'queue' => 'default',
            'retry_after' => 90,
            'after_commit' => false,
        ],

        'sqs' => [
            'driver' => 'sqs',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'prefix' => env('SQS_PREFIX', 'https://sqs.us-east-1.amazonaws.com/your-account-id'),
            'queue' => env('SQS_QUEUE', 'default'),
            'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
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

## Queue Configuration

### Queue Priorities

| Queue | Priority | Description | Max Workers |
|-------|----------|-------------|-------------|
| `critical` | 1 (highest) | System-critical operations | 3 |
| `high` | 2 | User-facing operations | 5 |
| `default` | 3 | Standard background work | 10 |
| `emails` | 4 | Email sending | 5 |
| `notifications` | 5 | Push/notification delivery | 3 |
| `media` | 6 | Image/file processing | 3 |
| `imports` | 7 | CSV/data imports | 2 |
| `low` | 8 (lowest) | Analytics, logging | 2 |

### Queue Routing

```php
// Dispatch to specific queues
SendWelcomeEmail::dispatch($user)->onQueue('emails');
ProcessImage::dispatch($media)->onQueue('media');
SyncAnalytics::dispatch($event)->onQueue('low');

// Route by priority
class JobRouter
{
    public static function route(Job $job, string $priority): string
    {
        return match ($priority) {
            'critical' => 'critical',
            'high' => 'high',
            'low' => 'low',
            default => 'default',
        };
    }
}
```

## Job Dispatching

### Dispatch Patterns

| Pattern | Method | Use Case |
|---------|--------|----------|
| Immediate | `Job::dispatch()` | Standard async jobs |
| Delayed | `->delay(now()->addMinutes(5))` | Scheduled future execution |
| Chained | `Bus::chain([...])` | Sequential job execution |
| Batched | `Bus::batch([...])` | Parallel with coordination |
| Unique | `->unique('lock-key')` | Prevent duplicate jobs |
| Singleton | `->onConnection('redis')` | One instance at a time |
| Queue-specific | `->onQueue('emails')` | Target specific queue |
| Via | `->through([$middleware])` | Add job middleware |

### Batch Processing

```php
use Illuminate\Bus\Batch;

$batch = Bus::batch([
    new ProcessImport($importId, 'chunk-1'),
    new ProcessImport($importId, 'chunk-2'),
    new ProcessImport($importId, 'chunk-3'),
    new ProcessImport($importId, 'chunk-4'),
])
->then(function (Batch $batch) use ($importId) {
    ImportComplete::dispatch($importId);
})
->finally(function (Batch $batch) use ($importId) {
    if ($batch->hasFailures()) {
        ImportFailed::dispatch($importId, $batch->failedJobIds());
    }
})
->name('import-' . $importId)
->onConnection('redis')
->onQueue('imports')
->dispatch();
```

## Retry Logic

### Retry Configuration

| Job Type | Max Attempts | Retry Delay | Backoff | Timeout |
|----------|-------------|-------------|---------|---------|
| Email | 3 | 60s | Exponential | 30s |
| Image processing | 3 | 120s | Exponential | 300s |
| Payment | 5 | 300s | Exponential | 60s |
| Import | 3 | 300s | Linear | 600s |
| Webhook | 5 | 60s | Exponential | 30s |
| Notification | 2 | 30s | Linear | 15s |
| Default | 3 | 60s | Exponential | 60s |

### Exponential Backoff

```php
class ProcessPayment implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 5;
    public int $timeout = 60;
    public int $backoff = 30; // seconds

    public function backoff(): array
    {
        return [30, 60, 120, 300, 600];
    }

    public function failed(Throwable $exception): void
    {
        // Notify admin of permanent failure
        PaymentFailed::dispatch($this->paymentId, $exception->getMessage());
    }
}
```

### Retry Commands

```bash
# Retry all failed jobs
php artisan queue:retry all

# Retry specific job
php artisan queue:retry {job-id}

# Retry jobs by queue
php artisan queue:retry --queue=emails

# Clear failed jobs
php artisan queue:flush

# List failed jobs
php artisan queue:failed
```

## Rate Limiting

### Job Middleware

```php
class RateLimited
{
    protected RateLimiter $limiter;

    public function __construct(RateLimiter $limiter)
    {
        $this->limiter = $limiter;
    }

    public function handle(object $job, Closure $next): void
    {
        $key = 'rate-limit:' . class_basename($job);

        if ($this->limiter->too($key, 10, 60)) {
            $job->release(60); // Release back to queue after 60s
            return;
        }

        $this->limiter->hit($key, 60);
        $next($job);
    }
}

// Usage in job
class SendEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function middleware(): array
    {
        return [new RateLimited];
    }
}
```

## Failed Job Handling

### Failure Tracking

```sql
CREATE TABLE failed_jobs (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    uuid VARCHAR(255) NOT NULL,
    connection TEXT NOT NULL,
    queue TEXT NOT NULL,
    payload LONGTEXT NOT NULL,
    exception LONGTEXT NOT NULL,
    failed_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY failed_jobs_uuid_unique (uuid)
);

CREATE TABLE job_batches (
    id VARCHAR(255) PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    total_jobs INT NOT NULL,
    pending_jobs INT NOT NULL,
    failed_jobs INT NOT NULL,
    failed_job_ids LONGTEXT NOT NULL,
    options MEDIUMTEXT NULL,
    cancelled_at TIMESTAMP NULL,
    created_at TIMESTAMP NULL,
    finished_at TIMESTAMP NULL
);
```

### Failure Notifications

```php
class JobFailedListener
{
    public function handle(JobFailed $event): void
    {
        $job = $event->job;
        $exception = $event->exception;

        // Log failure
        Log::error('Job failed', [
            'job' => $job->resolveName(),
            'id' => $job->getJobId(),
            'queue' => $job->getQueue(),
            'exception' => $exception->getMessage(),
            'attempts' => $job->attempts(),
        ]);

        // Notify on critical queue failures
        if (str_contains($job->getQueue(), 'critical')) {
            Notification::send(
                User::admin()->get(),
                new CriticalJobFailed($job, $exception)
            );
        }
    }
}
```

## Acceptance Criteria

- [ ] Redis driver handles 10,000+ jobs per minute
- [ ] Job priorities are respected across queues
- [ ] Chained jobs execute in correct sequence
- [ ] Batch jobs coordinate completion callbacks
- [ ] Rate limiting prevents job flooding
- [ ] Exponential backoff increases retry delays
- [ ] Failed jobs are tracked in the database
- [ ] Critical queue failures trigger alerts
- [ ] Workers timeout jobs exceeding limits
- [ ] Queue depth monitoring alerts on backlogs
