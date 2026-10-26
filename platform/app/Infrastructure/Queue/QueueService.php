<?php

declare(strict_types=1);

namespace App\Infrastructure\Queue;

use Illuminate\Support\Facades\Queue;

class QueueService
{
    /**
     * Dispatch a job to the queue.
     */
    public function dispatch(object $job, string $queue = 'default'): void
    {
        dispatch($job->onQueue($queue));
    }

    /**
     * Dispatch a job later.
     */
    public function later(int $delay, object $job, string $queue = 'default'): void
    {
        dispatch($job->delay($delay)->onQueue($queue));
    }

    /**
     * Get the size of a queue.
     */
    public function size(string $queue = 'default'): int
    {
        return Queue::size($queue);
    }

    /**
     * Get the number of failed jobs.
     */
    public function failedJobs(): int
    {
        return \App\Domains\System\Models\FailedJob::count();
    }

    /**
     * Retry a failed job.
     */
    public function retry(int $jobId): void
    {
        \App\Domains\System\Models\FailedJob::find($jobId)->retry();
    }

    /**
     * Clear all failed jobs.
     */
    public function clearFailedJobs(): void
    {
        \App\Domains\System\Models\FailedJob::truncate();
    }
}
