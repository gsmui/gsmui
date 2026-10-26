# Jobs

> Job architecture: chains, middleware, retries, batching, throttling, Horizon monitoring.

## Job Definition

```php
// app/Jobs/ProcessOrderJob
class ProcessOrderJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public readonly Order $order
    ) {}

    public function handle(
        PaymentServiceInterface $payment,
        InventoryServiceInterface $inventory,
        NotificationServiceInterface $notifications
    ): void {
        $payment->charge($this->order);
        $inventory->deduct($this->order->items);
        $notifications->orderProcessed($this->order);

        $this->order->update(['status' => 'processed']);
    }

    public function failed(Throwable $exception): void
    {
        $this->order->update(['status' => 'failed']);

        report($exception);
    }
}
```

## Job Chaining

```php
// Sequential chain
dispatch_chain([
    new ValidateOrderJob($order),
    new ProcessPaymentJob($order),
    new SendConfirmationJob($order),
    new UpdateInventoryJob($order),
])->onConnection('redis')->onQueue('orders');

// Or fluent
dispatch(new ValidateOrderJob($order))
    ->chain([
        new ProcessPaymentJob($order),
        new SendConfirmationJob($order),
    ]);
```

## Job Middleware

```php
// app/Jobs/Middleware/RateLimited.php
class RateLimited
{
    public function handle(object $job, Closure $next): void
    {
        $key = 'rate-limit:' . class_basename($job);

        if (Cache::increment($key) > 5) {
            $job->release(now()->addMinutes(1));
            return;
        }

        Cache::put($key, 1, now()->addMinute());

        $next($job);
    }
}

// app/Jobs/Middleware/WithoutOverlapping.php
class WithoutOverlapping
{
    public function handle(object $job, Closure $next): void
    {
        $lockKey = 'job:' . class_basename($job) . ':' . $job->order->id;

        if (Lock::acquire($lockKey, 60)) {
            try {
                $next($job);
            } finally {
                Lock::release($lockKey);
            }
        } else {
            $job->release(30);
        }
    }
}

// Apply to job
class ProcessOrderJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function middleware(): array
    {
        return [
            new RateLimited,
            new WithoutOverlapping,
            new EnsureModelExists,
        ];
    }
}
```

## Retries & Failures

```php
class ProcessOrderJob implements ShouldQueue
{
    public int $tries = 3;
    public int $backoff = 60;
    public bool $maxExceptions = 3;
    public bool $failOnTimeout = true;

    public function backoff(): array
    {
        return [10, 30, 60]; // Progressive backoff
    }

    public function retryUntil(): Carbon
    {
        return now()->addHours(2);
    }

    public function failed(Throwable $exception): void
    {
        $this->order->update(['status' => 'failed']);

        FailedJobNotification::dispatch($this->order, $exception);

        report($exception);
    }
}
```

## Job Batching

```php
use Illuminate\Bus\Batch;
use Illuminate\Support\Facades\Bus;

class ImportProductsJob implements ShouldQueue
{
    public function handle(): void
    {
        $batch = Bus::batch([
            new ImportProductsFromCSV($file1),
            new ImportProductsFromCSV($file2),
            new ImportProductsFromCSV($file3),
        ])
        ->then(function (Batch $batch) {
            Log::info("All imports completed: {$batch->id}");
        })
        ->finally(function (Batch $batch) {
            $this->notifyComplete($batch);
        })
        ->onConnection('redis')
        ->onQueue('imports')
        ->allowFailures()
        ->name('product-import-' . now()->timestamp)
        ->dispatch();
    }
}

// Track batch progress
$batch = Bus::findBatch($batchId);
echo $batch->progress(); // 0-100
echo $batch->finished(); // bool
```

## Throttling

```php
class SendEmailJob implements ShouldQueue
{
    public function middleware(): array
    {
        return [
            (new WithoutOverlapping('email'))->releaseAfter(60),
            (new ThrottlesExceptionsWithRedis(10, 60))->by('email:' . $this->user->id),
        ];
    }
}

// Custom throttling middleware
class ThrottlesJobs
{
    public function __construct(
        protected int $maxAttempts,
        protected int $decayMinutes
    ) {}

    public function handle(object $job, Closure $next): void
    {
        $key = 'throttle:' . class_basename($job);

        $attempts = Cache::get($key, 0);

        if ($attempts >= $this->maxAttempts) {
            $job->release(now()->addMinutes($this->decayMinutes));
            return;
        }

        Cache::put($key, $attempts + 1, now()->addMinutes($this->decayMinutes));

        $next($job);
    }
}
```

## Horizon Monitoring

```php
// config/horizon.php
return [
    'environments' => [
        'production' => [
            'supervisor-1' => [
                'connection' => 'redis',
                'queue' => ['default', 'emails', 'notifications'],
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
    ],
];
```

## Job Testing

```php
class ProcessOrderJobTest extends TestCase
{
    use RefreshDatabase, InteractsWithQueue, QueueConnectionAssertions;

    public function test_job_processes_order(): void
    {
        $order = Order::factory()->create(['status' => 'pending']);

        ProcessOrderJob::dispatch($order);

        $this->assertQueueHas('default', ProcessOrderJob::class);
    }

    public function test_job_chain_executes_in_order(): void
    {
        $order = Order::factory()->create();

        $batch = Bus::batch([
            new ValidateOrderJob($order),
            new ProcessPaymentJob($order),
        ])->dispatch();

        $this->assertQueuedWithChain([
            ValidateOrderJob::class,
            ProcessPaymentJob::class,
        ]);
    }

    public function test_job_retries_on_exception(): void
    {
        $job = new ProcessOrderJob(Order::factory()->create());
        $job->tries = 3;

        $job->handle($this->mock(PaymentServiceInterface::class));

        $this->assertQueued(ProcessOrderJob::class);
    }
}
```

## Job Priority

```php
// In queue config
'connections' => [
    'redis' => [
        'driver' => 'redis',
        'queue' => 'default',
        'retry_after' => 90,
        'block_for' => null,
    ],
],

// Dispatch to priority queue
dispatch(new HighPriorityJob())->onQueue('high');
dispatch(new LowPriorityJob())->onQueue('low');
```

## Scheduled Jobs

```php
// app/Console/Kernel.php
class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule): void
    {
        $schedule->job(new CleanExpiredSessionsJob)->daily();
        $schedule->job(new SyncSearchIndexJob)->everyFifteenMinutes();
        $schedule->job(new GenerateReportsJob)->dailyAt('02:00');
        $schedule->job(new PruneOldJobsJob)->hourly();
    }
}
```
