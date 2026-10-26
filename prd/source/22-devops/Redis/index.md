# Redis

> PRD — Volume 22: DevOps — Redis

## Overview

Redis serves as the primary cache, session store, and queue backend for the gsmui platform. This document covers configuration, clustering, persistence, memory management, and monitoring.

## Objectives

| Goal | Metric | Target |
|------|--------|--------|
| Cache hit rate | Cache hits / total requests | 95%+ |
| Response time | Redis command latency | < 1ms |
| Memory usage | Peak memory consumption | < 80% of allocated |
| Persistence | Data loss window | < 5 seconds |
| Availability | Redis uptime | 99.99% |

## Configuration

### Laravel Redis Config

```php
// config/database.php
'redis' => [

    'client' => env('REDIS_CLIENT', 'phpredis'),

    'options' => [
        'cluster' => env('REDIS_CLUSTER', 'redis'),
        'prefix' => env('REDIS_PREFIX', 'gsmui:'),
        'serializer' => Redis::SERIALIZER_IGBINARY,
        'compression' => Redis::COMPRESSION_LZ4,
    ],

    'default' => [
        'url' => env('REDIS_URL'),
        'host' => env('REDIS_HOST', '127.0.0.1'),
        'username' => env('REDIS_USERNAME'),
        'password' => env('REDIS_PASSWORD'),
        'port' => env('REDIS_PORT', '6379'),
        'database' => env('REDIS_DB', '0'),
        'read_timeout' => 60,
    ],

    'cache' => [
        'url' => env('REDIS_URL'),
        'host' => env('REDIS_HOST', '127.0.0.1'),
        'port' => env('REDIS_PORT', '6379'),
        'database' => env('REDIS_CACHE_DB', '1'),
    ],

    'queue' => [
        'url' => env('REDIS_URL'),
        'host' => env('REDIS_HOST', '127.0.0.1'),
        'port' => env('REDIS_PORT', '6379'),
        'database' => env('REDIS_QUEUE_DB', '2'),
    ],

    'session' => [
        'url' => env('REDIS_URL'),
        'host' => env('REDIS_HOST', '127.0.0.1'),
        'port' => env('REDIS_PORT', '6379'),
        'database' => env('REDIS_SESSION_DB', '3'),
    ],
],
```

### Redis Server Config

```conf
# redis.conf
bind 0.0.0.0
port 6379
protected-mode yes
requirepass ${REDIS_PASSWORD}

# Memory
maxmemory 2gb
maxmemory-policy allkeys-lru

# Persistence
save 900 1
save 300 10
save 60 10000
appendonly yes
appendfsync everysec

# Performance
hz 10
dynamic-hz yes
tcp-backlog 511
tcp-keepalive 300

# Logging
loglevel notice
logfile ""

# Security
rename-command FLUSHDB ""
rename-command FLUSHALL ""
rename-command DEBUG ""
```

## Database Allocation

| DB | Purpose | Key Prefix | Max Memory |
|----|---------|------------|------------|
| 0 | General cache | `gsmui:` | 512MB |
| 1 | Application cache | `gsmui:cache:` | 512MB |
| 2 | Queue (Horizon) | `gsmui:queue:` | 1GB |
| 3 | Sessions | `gsmui:session:` | 256MB |
| 4 | Rate limiting | `gsmui:rate:` | 128MB |
| 5 | Locks | `gsmui:lock:` | 64MB |
| 6 | Events/Notifications | `gsmui:events:` | 128MB |
| 7 | Real-time (Broadcasting) | `gsmui:broadcast:` | 256MB |

## Clustering

### Cluster Configuration

```php
// config/database.php - Cluster mode
'redis' => [
    'client' => env('REDIS_CLIENT', 'phpredis'),
    'cluster' => true,

    'clusters' => [
        'default' => [
            [
                'host' => env('REDIS_HOST_1', '127.0.0.1'),
                'port' => 6379,
                'password' => env('REDIS_PASSWORD'),
                'database' => 0,
            ],
            [
                'host' => env('REDIS_HOST_2', '127.0.0.1'),
                'port' => 6380,
                'password' => env('REDIS_PASSWORD'),
                'database' => 0,
            ],
            [
                'host' => env('REDIS_HOST_3', '127.0.0.1'),
                'port' => 6381,
                'password' => env('REDIS_PASSWORD'),
                'database' => 0,
            ],
        ],
    ],
],
```

### Sentinel (High Availability)

```
┌─────────────┐    ┌─────────────┐    ┌─────────────┐
│  Sentinel 1 │    │  Sentinel 2 │    │  Sentinel 3 │
└──────┬──────┘    └──────┬──────┘    └──────┬──────┘
       │                  │                  │
       └──────────┬───────┴──────────┬──────┘
                  │                  │
            ┌─────┴─────┐    ┌──────┴────┐
            │  Master   │    │  Replica  │
            └─────┬─────┘    └──────┬────┘
                  │                  │
            ┌─────┴─────┐    ┌──────┴────┐
            │  Replica  │    │  Replica  │
            └───────────┘    └───────────┘
```

## Persistence

### RDB Snapshots

| Setting | Value | Description |
|---------|-------|-------------|
| `save 900 1` | 900s / 1 key | Save if 1 key changed in 15 min |
| `save 300 10` | 300s / 10 keys | Save if 10 keys changed in 5 min |
| `save 60 10000` | 60s / 10000 keys | Save if 10k keys changed in 1 min |

### AOF (Append-Only File)

| Setting | Value | Description |
|---------|-------|-------------|
| `appendonly yes` | Enabled | Enable AOF persistence |
| `appendfsync everysec` | Per second | Fsync every second (balanced) |
| `auto-aof-rewrite-percentage 100` | 100% | Rewrite when AOF doubles |
| `auto-aof-rewrite-min-size 64mb` | 64MB | Min size for rewrite |

### Persistence Strategy

| Scenario | RDB | AOF | Data Loss Window |
|----------|-----|-----|-----------------|
| Default | Yes | Yes (everysec) | ~1 second |
| High durability | Yes | Yes (always) | 0 (with performance cost) |
| Cache only | No | No | All data (acceptable) |

## Memory Management

### Eviction Policies

| Policy | Description | Use Case |
|--------|-------------|----------|
| `allkeys-lru` | Evict any key using LRU | General cache (recommended) |
| `volatile-lru` | Evict keys with TTL using LRU | Cache with some persistent keys |
| `allkeys-lfu` | Evict any key using LFU | Access-frequency-based |
| `volatile-lfu` | Evict keys with TTL using LFU | Frequency-based with TTL |
| `allkeys-random` | Evict random keys | Equal importance keys |
| `volatile-random` | Evict random keys with TTL | Random with TTL |
| `volatile-ttl` | Evict keys with shortest TTL | TTL-based |
| `noeviction` | Don't evict, return errors | Critical data |

### Memory Monitoring

```bash
# Check memory usage
redis-cli info memory

# Check key count per database
redis-cli info keyspace

# Find large keys
redis-cli --bigkeys

# Check memory fragmentation
redis-cli info memory | grep mem_fragmentation_ratio
```

### Memory Optimization

```php
// Use compact serialization
Redis::set('key', $value, ['serializer' => Redis::SERIALIZER_IGBINARY]);

// Set TTL on cache keys
Cache::tags(['users'])->put($key, $value, now()->addHours(2));

// Use Hash for related data
Redis::hset('user:1', 'name', 'John', 'email', 'john@example.com');

// Use Set for unique collections
Redis::sadd('online:users', $userId);
```

## Monitoring

### Redis Metrics

| Metric | Description | Warning Threshold |
|--------|-------------|------------------|
| `used_memory` | Current memory usage | > 80% of maxmemory |
| `mem_fragmentation_ratio` | Memory fragmentation | > 1.5 |
| `connected_clients` | Active connections | > 1000 |
| `blocked_clients` | Blocked connections | > 0 |
| `instantaneous_ops_per_sec` | Operations per second | > 50,000 |
| `rejected_connections` | Rejected connections | > 0 |
| `expired_keys` | Total expired keys | Monitoring only |
| `evicted_keys` | Total evicted keys | > 0 (concerning) |

### Health Check

```php
class RedisHealthCheck
{
    public function check(): array
    {
        try {
            $start = microtime(true);
            Redis::ping();
            $latency = (microtime(true) - $start) * 1000;

            $info = Redis::info('memory');
            $memoryUsage = $info['used_memory'] / $info['maxmemory'] * 100;

            return [
                'status' => 'healthy',
                'latency_ms' => round($latency, 2),
                'memory_usage_percent' => round($memoryUsage, 1),
                'connected_clients' => Redis::info('clients')['connected_clients'],
            ];
        } catch (Exception $e) {
            return [
                'status' => 'unhealthy',
                'error' => $e->getMessage(),
            ];
        }
    }
}
```

## Acceptance Criteria

- [ ] Cache hit rate exceeds 95%
- [ ] Redis response latency stays under 1ms
- [ ] Memory usage stays below 80% of allocation
- [ ] Persistence captures data within 1-second window
- [ ] Cluster failover completes in under 30 seconds
- [ ] Sentinel promotes replica on master failure
- [ ] Eviction policy prevents OOM kills
- [ ] Monitoring alerts on high memory and latency
- [ ] Key prefix prevents collisions between applications
- [ ] Sessions and queues use separate databases
