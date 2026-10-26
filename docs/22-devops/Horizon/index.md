# Horizon Setup

> PRD — Volume 22: DevOps — Horizon

## Overview

Laravel Horizon provides a dashboard and code-driven configuration for Redis queues. This document covers Horizon setup, dashboard configuration, job supervisors, queue workers, scaling strategies, and monitoring.

## Objectives

| Goal | Metric | Target |
|------|--------|--------|
| Job throughput | Jobs processed per minute | 1,000+ |
| Job latency | 95th percentile wait time | < 5 seconds |
| Failure rate | Failed jobs percentage | < 0.1% |
| Dashboard uptime | Dashboard availability | 99.9% |
| Supervisor restart | Time to restart failed workers | < 30 seconds |

## Horizon Configuration

### config/horizon.php

```php
return [
    'environments' => [
        'production' => [
            'supervisor-1' => [
                'connection' => 'redis',
                'queue' => ['default', 'emails', 'notifications', 'media', 'imports'],
                'balance' => 'auto',
                'autoScalingStrategy' => 'time',
                'maxProcesses' => 10,
                'maxTime' => 3600,
                'maxJobs' => 1000,
                'memory' => 256,
                'tries' => 3,
                'timeout' => 60,
                'nice' => 0,
            ],
            'supervisor-2' => [
                'connection' => 'redis',
                'queue' => ['critical', 'scheduling'],
                'balance' => 'simple',
                'maxProcesses' => 3,
                'maxTime' => 3600,
                'maxJobs' => 500,
                'memory' => 256,
                'tries' => 5,
                'timeout' => 120,
                'nice' => 0,
            ],
        ],
        'local' => [
            'supervisor-1' => [
                'connection' => 'redis',
                'queue' => ['default'],
                'balance' => 'simple',
                'maxProcesses' => 3,
                'memory' => 128,
                'tries' => 3,
                'timeout' => 60,
            ],
        ],
    ],

    'metrics' => [
        'trim_keep' => 30, // days
        'latest_jobs' => 100,
    ],

    'waits' => [
        'redis' => 60,
    ],

    'trim' => [
        'recent' => 60,
        'failed' => 10080,
        'failed_jobs' => 10080,
        'recent_failed' => 10080,
        'jobs' => 100,
        'purge' => 0,
    ],
];
```

## Job Supervisors

| Supervisor | Queues | Balance | Max Processes | Purpose |
|-----------|--------|---------|---------------|---------|
| `supervisor-1` | default, emails, notifications | auto | 10 | General workloads |
| `supervisor-2` | critical, scheduling | simple | 3 | Time-sensitive jobs |
| `supervisor-3` | imports, media | auto | 5 | Heavy processing |

### Auto-Scaling Strategy

| Strategy | Description | Best For |
|----------|-------------|----------|
| `auto` | Adds/removes workers based on queue depth | Variable workloads |
| `simple` | Fixed number of workers | Predictable workloads |
| `false` | No auto-scaling | Development |

### Scaling Rules

```php
'scaling' => [
    'default' => [
        'min' => 1,
        'max' => 10,
        'scale_up' => [
            'queue_size' => 10,     // Scale up when queue has 10+ jobs
            'cpu_usage' => 70,      // Scale up when CPU > 70%
            'memory_usage' => 80,   // Scale up when memory > 80%
        ],
        'scale_down' => [
            'queue_size' => 0,      // Scale down when queue is empty
            'cooldown' => 60,       // Wait 60s before scaling down
        ],
    ],
    'critical' => [
        'min' => 1,
        'max' => 3,
        'scale_up' => ['queue_size' => 5],
        'scale_down' => ['queue_size' => 0, 'cooldown' => 30],
    ],
],
```

## Queue Workers

### Worker Configuration

| Queue | Connection | Tries | Timeout | Memory | Nice |
|-------|-----------|-------|---------|--------|------|
| `default` | redis | 3 | 60s | 256MB | 0 |
| `emails` | redis | 3 | 30s | 128MB | 0 |
| `notifications` | redis | 2 | 15s | 128MB | 0 |
| `critical` | redis | 5 | 120s | 512MB | 0 |
| `media` | redis | 3 | 300s | 512MB | 5 |
| `imports` | redis | 3 | 600s | 1024MB | 10 |
| `scheduling` | redis | 5 | 120s | 256MB | 0 |

### Job Dispatching

```php
// Standard dispatch
ProcessImage::dispatch($mediaId);

// Delayed dispatch
SendEmail::dispatch($user, $data)->delay(now()->addMinutes(5));

// On specific queue
ImportCsv::dispatch($importId)->onQueue('imports');

// Unique job (prevent duplicates)
SyncAnalytics::dispatch($analyticsId)->unique('analytics-sync');

// Chained jobs
dispatch(function () use ($importId) {
    return [
        new ParseCsv($importId),
        new ValidateRows($importId),
        new ImportRows($importId),
        new NotifyImportComplete($importId),
    ];
});
```

## Dashboard

### Dashboard Access

| Route | Description | Auth Required |
|-------|-------------|---------------|
| `/horizon` | Main dashboard | Yes (admin) |
| `/horizon/api/stats` | Real-time stats API | Yes |
| `/horizon/api/metrics` | Historical metrics | Yes |
| `/horizon/api/jobs` | Job listing | Yes |
| `/horizon/api/failed` | Failed jobs | Yes |

### Dashboard Metrics

| Metric | Description | Update Frequency |
|--------|-------------|-----------------|
| Processes | Active worker processes | Real-time |
| Queue Depth | Jobs waiting per queue | Real-time |
| Throughput | Jobs processed per minute | 5 seconds |
| Wait Time | 95th percentile wait | 5 seconds |
| Runtime | 95th percentile runtime | 5 seconds |
| Failures | Failed jobs count | Real-time |
| Recent Jobs | Last 100 completed jobs | Real-time |
| Throughput History | Jobs/min over time | 5 minutes |

## Monitoring & Alerts

### Alert Channels

| Alert | Condition | Channel |
|-------|-----------|---------|
| Worker Down | Worker process dies | PagerDuty + Slack |
| Queue Backlog | Queue depth > 100 for 5 min | Slack |
| High Latency | 95th percentile > 30s | Slack |
| Memory Warning | Worker memory > 80% | Slack |
| Failure Spike | > 10 failures in 5 min | PagerDuty + Slack |
| Long Job | Job running > 5 min | Slack |

### Monitoring Command

```php
class HorizonMonitor extends Command
{
    protected $signature = 'horizon:monitor';

    public function handle(): void
    {
        $stats = Horizon::stats();

        // Check queue depth
        foreach ($stats['queues'] as $queue => $depth) {
            if ($depth > 100) {
                $this->alert("Queue backlog: {$queue} has {$depth} jobs");
            }
        }

        // Check worker processes
        if ($stats['processes'] < 1) {
            $this->critical("No active workers!");
        }

        // Check failure rate
        if ($stats['failure_rate'] > 1) {
            $this->alert("High failure rate: {$stats['failure_rate']}%");
        }
    }
}
```

## Database Schema (Horizon Tables)

```sql
-- Horizon uses Redis, but we track additional metrics in MySQL
CREATE TABLE horizon_metrics (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    metric_type VARCHAR(50) NOT NULL,
    queue VARCHAR(100) NULL,
    value DECIMAL(10,2) NOT NULL,
    recorded_at TIMESTAMP NOT NULL,
    KEY horizon_metrics_type_index (metric_type),
    KEY horizon_metrics_recorded_index (recorded_at)
);

CREATE TABLE horizon_jobs_log (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    job_id VARCHAR(255) NOT NULL,
    connection VARCHAR(50) NOT NULL,
    queue VARCHAR(100) NOT NULL,
    payload TEXT NOT NULL,
    status VARCHAR(20) NOT NULL,
    started_at TIMESTAMP NULL,
    completed_at TIMESTAMP NULL,
    failed_at TIMESTAMP NULL,
    error TEXT NULL,
    attempts INT UNSIGNED NOT NULL DEFAULT 0,
    runtime DECIMAL(8,2) NULL,
    created_at TIMESTAMP NULL,
    KEY horizon_jobs_log_status_index (status),
    KEY horizon_jobs_log_queue_index (queue),
    KEY horizon_jobs_log_created_index (created_at)
);
```

## Acceptance Criteria

- [ ] Horizon dashboard displays real-time queue metrics
- [ ] Auto-scaling adjusts workers based on queue depth
- [ ] Critical queue workers have higher priority than default
- [ ] Failed jobs retry according to configured attempt limits
- [ ] Dashboard requires admin authentication
- [ ] Alerts notify on worker failures and queue backlogs
- [ ] Metrics history retains data for 30 days
- [ ] Workers restart gracefully on deployment
- [ ] Long-running jobs timeout at configured limits
- [ ] Memory limits prevent worker OOM kills
