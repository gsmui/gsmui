# Monitoring

> PRD — Volume 22: DevOps — Monitoring

## Overview

The Monitoring system provides application metrics, server health monitoring, alerting, dashboards, and Application Performance Monitoring (APM) for the gsmui platform.

## Objectives

| Goal | Metric | Target |
|------|--------|--------|
| Alert response time | Time from incident to notification | < 1 minute |
| Dashboard refresh | Real-time metric update interval | 5 seconds |
| Metric retention | Historical metric storage | 90 days |
| Uptime | Application availability | 99.95% |
| MTTR | Mean time to recovery | < 30 minutes |

## Application Metrics

### Key Metrics

| Category | Metric | Description | Alert Threshold |
|----------|--------|-------------|-----------------|
| HTTP | Request rate | Requests per second | < 10 or > 1000 |
| HTTP | Response time (p95) | 95th percentile latency | > 2 seconds |
| HTTP | Error rate (5xx) | Server error percentage | > 1% |
| HTTP | Error rate (4xx) | Client error percentage | > 5% |
| Queue | Queue depth | Pending jobs per queue | > 100 |
| Queue | Job throughput | Jobs processed per minute | < 10 |
| Queue | Failed jobs | Jobs failed per hour | > 10 |
| Database | Query time (p95) | 95th percentile query time | > 500ms |
| Database | Connection pool | Active DB connections | > 80% |
| Cache | Hit rate | Cache hits / total | < 90% |
| Cache | Eviction rate | Keys evicted per minute | > 100 |
| Memory | PHP memory usage | Peak memory per request | > 128MB |
| Storage | Disk usage | Disk space utilization | > 85% |

### Metrics Collection

```php
class MetricsCollector
{
    public function recordRequest(Request $request, Response $response, float $duration): void
    {
        $metric = [
            'method' => $request->method(),
            'path' => $request->route()?->getName() ?? $request->path(),
            'status' => $response->status(),
            'duration' => $duration,
            'memory' => memory_get_peak_usage(true),
            'timestamp' => now()->timestamp,
        ];

        // Store in Redis for real-time
        Redis::lpush('metrics:requests', json_encode($metric));
        Redis::ltrim('metrics:requests', 0, 9999);

        // Increment counters
        Redis::incr("metrics:status:{$response->status()}");
        Redis::incr("metrics:path:{$metric['path']}");

        // Record in time series
        $this->recordTimeSeries('http_requests', 1, [
            'method' => $metric['method'],
            'status' => $metric['status'],
            'path' => $metric['path'],
        ]);

        $this->recordTimeSeries('http_duration', $duration, [
            'path' => $metric['path'],
        ]);
    }

    private function recordTimeSeries(string $metric, float $value, array $tags): void
    {
        $key = "ts:{$metric}:" . date('YmdHi');
        Redis::zadd($key, [$value => microtime(true)]);
        Redis::expire($key, 86400 * 7); // 7 days retention
    }
}
```

## Server Metrics

| Metric | Source | Collection Interval |
|--------|--------|-------------------|
| CPU usage | `/proc/stat` | 10 seconds |
| Memory usage | `/proc/meminfo` | 10 seconds |
| Disk I/O | `iostat` | 30 seconds |
| Network I/O | `/proc/net/dev` | 30 seconds |
| Load average | `/proc/loadavg` | 10 seconds |
| Open files | `/proc/sys/fs/file-nr` | 60 seconds |
| Process count | `ps aux` | 60 seconds |

### Server Health Check

```php
class ServerHealthCheck
{
    public function check(): array
    {
        return [
            'cpu' => $this->getCpuUsage(),
            'memory' => $this->getMemoryUsage(),
            'disk' => $this->getDiskUsage(),
            'load' => sys_getloadavg(),
            'uptime' => $this->getUptime(),
            'services' => $this->checkServices(),
        ];
    }

    private function checkServices(): array
    {
        return [
            'mysql' => $this->checkMysql(),
            'redis' => $this->checkRedis(),
            'nginx' => $this->checkNginx(),
            'php-fpm' => $this->checkPhpFpm(),
            'horizon' => $this->checkHorizon(),
        ];
    }
}
```

## Alerting

### Alert Rules

| Alert | Condition | Severity | Channel | Cooldown |
|-------|-----------|----------|---------|----------|
| High error rate | 5xx > 1% for 5 min | Critical | PagerDuty | 5 min |
| High latency | p95 > 2s for 5 min | Warning | Slack | 10 min |
| Queue backlog | Depth > 100 for 10 min | Warning | Slack | 15 min |
| Disk full | Usage > 85% | Critical | PagerDuty | 30 min |
| Memory high | Usage > 90% | Critical | PagerDuty | 5 min |
| Service down | Any service unreachable | Critical | PagerDuty | 1 min |
| SSL expiring | Certificate < 30 days | Warning | Email | 24 hours |
| Database connections | > 80% pool used | Warning | Slack | 10 min |
| Failed jobs spike | > 50 in 5 min | Warning | Slack | 5 min |
| Cache hit rate | < 80% for 15 min | Warning | Slack | 15 min |

### Alert Manager

```php
class AlertManager
{
    private array $channels = [
        'pagerduty' => PagerDutyChannel::class,
        'slack' => SlackChannel::class,
        'email' => EmailChannel::class,
        'webhook' => WebhookChannel::class,
    ];

    public function fire(string $rule, array $context): void
    {
        $alert = Alert::create([
            'rule' => $rule,
            'severity' => $context['severity'],
            'message' => $this->buildMessage($rule, $context),
            'context' => $context,
            'status' => 'firing',
        ]);

        // Check cooldown
        if ($this->isOnCooldown($rule)) {
            return;
        }

        // Send to configured channels
        foreach ($context['channels'] as $channel) {
            $this->channels[$channel]::send($alert);
        }

        // Log alert
        Log::warning("Alert fired: {$rule}", $context);
    }
}
```

## Dashboards

### Dashboard Panels

| Panel | Type | Data Source | Refresh |
|-------|------|------------|---------|
| Request Rate | Line chart | Metrics API | 5s |
| Response Time | Line chart | Metrics API | 5s |
| Error Rate | Gauge | Metrics API | 5s |
| Queue Depth | Bar chart | Horizon API | 5s |
| Active Users | Number | Session store | 30s |
| Database Queries | Line chart | APM collector | 10s |
| Cache Performance | Gauge | Redis INFO | 10s |
| Server Resources | Gauges | Server metrics | 10s |
| Recent Errors | Table | Error log | 30s |
| Deployment Timeline | Timeline | Deploy hook | On event |

## APM (Application Performance Monitoring)

### Transaction Tracing

```php
class ApmMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $transaction = app(ApmCollector::class)->startTransaction([
            'name' => $request->route()?->getName() ?? $request->path(),
            'type' => 'request',
            'method' => $request->method(),
        ]);

        try {
            $response = $next($request);

            $transaction->setData('status_code', $response->status());
            $transaction->setData('memory', memory_get_peak_usage(true));

            return $response;
        } catch (Throwable $e) {
            $transaction->setError($e);
            throw $e;
        } finally {
            $transaction->end();
        }
    }
}
```

### Slow Query Detection

```php
class SlowQueryDetector
{
    public function __construct(protected float $threshold = 100) {} // ms

    public function logQuery(string $query, float $duration, array $bindings): void
    {
        if ($duration > $this->threshold) {
            Log::warning('Slow query detected', [
                'query' => $query,
                'duration_ms' => round($duration, 2),
                'bindings' => $bindings,
                'trace' => debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 5),
            ]);

            Metrics::record('db.slow_query', 1, [
                'query_hash' => md5($query),
            ]);
        }
    }
}
```

## Monitoring Stack

| Component | Tool | Purpose |
|-----------|------|---------|
| Metrics | Prometheus / VictoriaMetrics | Time-series storage |
| Visualization | Grafana | Dashboards |
| Logging | Loki / ELK | Log aggregation |
| Alerting | Alertmanager / Grafana | Alert routing |
| APM | Sentry / Temporal | Transaction tracing |
| Uptime | UptimeRobot / Checkly | External monitoring |

## Acceptance Criteria

- [ ] Application metrics update every 5 seconds
- [ ] Server metrics collected every 10-30 seconds
- [ ] Alerts fire within 1 minute of threshold breach
- [ ] Dashboards display real-time system health
- [ ] APM traces capture full request lifecycle
- [ ] Slow queries are detected and logged
- [ ] Alert cooldown prevents notification spam
- [ ] Metrics are retained for 90 days
- [ ] External uptime checks run every 60 seconds
- [ ] Alert routing reaches the correct on-call engineer
