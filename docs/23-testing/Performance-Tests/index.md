# Performance Testing

> PRD — Volume 23: Quality Assurance — Performance Testing

## Overview

Performance testing covers load testing, stress testing, benchmarking, profiling, and optimization for the gsmui platform.

## Objectives

| Goal | Metric | Target |
|------|--------|--------|
| Response time | P95 response time | < 500ms |
| Throughput | Requests per second | 100+ |
| Concurrency | Simultaneous users | 500+ |
| Memory usage | Peak memory per request | < 128MB |
| Database queries | Queries per request | < 20 |

## Load Testing

### k6 Configuration

```javascript
// load-test.js
import http from 'k6/http';
import { check, sleep } from 'k6';
import { Rate, Trend } from 'k6/metrics';

const errorRate = new Rate('errors');
const responseTime = new Trend('response_time');

export const options = {
    stages: [
        { duration: '2m', target: 100 },   // Ramp up
        { duration: '5m', target: 100 },   // Sustained load
        { duration: '2m', target: 200 },   // Peak load
        { duration: '5m', target: 200 },   // Sustained peak
        { duration: '2m', target: 0 },     // Ramp down
    ],
    thresholds: {
        http_req_duration: ['p(95)<500', 'p(99)<1000'],
        http_req_failed: ['rate<0.01'],
        errors: ['rate<0.01'],
    },
};

export default function () {
    const BASE_URL = __ENV.BASE_URL || 'http://localhost:8000';

    // Homepage
    let res = http.get(`${BASE_URL}/`);
    check(res, {
        'homepage status 200': (r) => r.status === 200,
        'homepage response < 500ms': (r) => r.timings.duration < 500,
    });
    errorRate.add(res.status !== 200);
    responseTime.add(res.timings.duration);

    sleep(1);

    // Blog listing
    res = http.get(`${BASE_URL}/blog`);
    check(res, {
        'blog status 200': (r) => r.status === 200,
        'blog response < 500ms': (r) => r.timings.duration < 500,
    });

    sleep(1);

    // Single post
    res = http.get(`${BASE_URL}/blog/sample-post`);
    check(res, {
        'post status 200': (r) => r.status === 200,
    });

    sleep(Math.random() * 3 + 1);
}
```

### Artillery Configuration

```yaml
# artillery.yml
config:
  target: "http://localhost:8000"
  phases:
    - duration: 60
      arrivalRate: 10
      name: "Warm up"
    - duration: 120
      arrivalRate: 50
      name: "Sustained load"
    - duration: 60
      arrivalRate: 100
      name: "Peak load"
  defaults:
    headers:
      Accept: "text/html"
  ensure:
    p95: 500
    maxErrorRate: 1

scenarios:
  - name: "Browse website"
    flow:
      - get:
          url: "/"
      - think: 2
      - get:
          url: "/blog"
      - think: 3
      - get:
          url: "/blog/post-1"

  - name: "Admin workflow"
    flow:
      - post:
          url: "/login"
          json:
            email: "admin@example.com"
            password: "password"
          capture:
            - header: "set-cookie"
              as: "session"
      - get:
          url: "/admin/pages"
          headers:
            Cookie: "{{session}}"
```

## Stress Testing

### Stress Test Script

```javascript
// stress-test.js
import http from 'k6/http';
import { check } from 'k6';

export const options = {
    stages: [
        { duration: '1m', target: 100 },
        { duration: '2m', target: 500 },   // Stress
        { duration: '1m', target: 1000 },  // High stress
        { duration: '2m', target: 500 },   // Recovery
        { duration: '1m', target: 0 },
    ],
    thresholds: {
        http_req_duration: ['p(95)<1000'],
        http_req_failed: ['rate<0.05'],
    },
};

export default function () {
    const res = http.get('http://localhost:8000/');
    check(res, {
        'status is 200': (r) => r.status === 200,
        'response time < 1s': (r) => r.timings.duration < 1000,
    });
}
```

## Benchmarking

### PHP Benchmark

```php
class BenchmarkTest extends TestCase
{
    public function test_homepage_response_time(): void
    {
        $iterations = 100;
        $times = [];

        for ($i = 0; $i < $iterations; $i++) {
            $start = microtime(true);
            $this->get('/');
            $times[] = (microtime(true) - $start) * 1000;
        }

        $avg = array_sum($times) / count($times);
        $p95 = $this->percentile($times, 95);
        $p99 = $this->percentile($times, 99);

        $this->assertLessThan(200, $avg, "Average response time: {$avg}ms");
        $this->assertLessThan(500, $p95, "P95 response time: {$p95}ms");
        $this->assertLessThan(1000, $p99, "P99 response time: {$p99}ms");
    }

    private function percentile(array $data, int $percentile): float
    {
        $index = (count($data) - 1) * ($percentile / 100);
        $lower = floor($index);
        $upper = ceil($index);
        $weight = $index - $lower;

        return $data[$lower] * (1 - $weight) + $data[$upper] * $weight;
    }
}
```

### Database Query Benchmark

```php
class QueryBenchmarkTest extends TestCase
{
    public function test_post_listing_queries(): void
    {
        Post::factory()->count(100)->published()->create();

        $start = microtime(true);
        $queries = [];

        DB::listen(function ($query) use (&$queries) {
            $queries[] = $query->sql;
        });

        $this->get('/blog');

        $queryCount = count($queries);
        $time = (microtime(true) - $start) * 1000;

        $this->assertLessThan(15, $queryCount, "Query count: {$queryCount}");
        $this->assertLessThan(200, $time, "Query time: {$time}ms");
    }
}
```

## Profiling

### Laravel Debugbar Integration

```php
class ProfilingTest extends TestCase
{
    public function test_admin_dashboard_profile(): void
    {
        $this->actingAsAdmin();

        $response = $this->get('/admin/dashboard');

        // Assert timing metrics
        $response->assertSuccessful();

        // Check memory usage
        $memory = memory_get_peak_usage(true) / 1024 / 1024;
        $this->assertLessThan(64, $memory, "Memory usage: {$memory}MB");
    }
}
```

### Xdebug Profiling

```bash
# Enable profiling
XDEBUG_MODE=profile php artisan serve

# Analyze with QCachegrind
qcachegrind storage/logs/cachegrind.out.*
```

## Optimization Checklist

| Area | Check | Target |
|------|-------|--------|
| Database | N+1 queries | 0 |
| Database | Missing indexes | 0 |
| Cache | Cache hit rate | > 95% |
| Assets | Bundle size (gzip) | < 500KB |
| Assets | Image optimization | WebP + lazy load |
| Response | Gzip/Brotli | Enabled |
| Response | HTTP/2 | Enabled |
| Response | CDN cache | > 80% hit rate |
| Code | Memory per request | < 128MB |
| Code | Execution time | < 200ms |

## Acceptance Criteria

- [ ] P95 response time is under 500ms under load
- [ ] Application handles 500+ concurrent users
- [ ] Database queries per page are under 20
- [ ] Memory usage stays under 128MB per request
- [ ] Static assets are served via CDN
- [ ] Gzip/Brotli compression is enabled
- [ ] No N+1 query issues
- [ ] Cache hit rate exceeds 95%
- [ ] Stress test shows graceful degradation
- [ ] Benchmark tests track performance over time
