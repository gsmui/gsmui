# 33 — DevOps

## Purpose

Define the DevOps infrastructure for GsmUi, covering deployment, server configuration, monitoring, and operations.

## Infrastructure Stack

| Component | Technology |
|---|---|
| Server | Laravel Cloud / AWS |
| Database | MySQL 8.4 |
| Cache | Redis 7 |
| Queue | Redis + Horizon |
| Storage | S3-compatible |
| CDN | Cloudflare |
| DNS | Cloudflare |

## Server Requirements

| Resource | Minimum | Recommended |
|---|---|---|
| CPU | 2 vCPU | 4 vCPU |
| RAM | 4 GB | 8 GB |
| Storage | 20 GB SSD | 50 GB SSD |
| PHP | 8.4+ | 8.4+ |
| Node.js | 20 LTS | 20 LTS |
| Composer | 2.x | 2.x |
| MySQL | 8.4 | 8.4 |
| Redis | 7.0 | 7.0+ |

## Environment Configuration

```bash
# .env.production

APP_ENV=production
APP_DEBUG=false
APP_KEY=base64:...
APP_URL=https://gsmui.dev

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=gsmui
DB_USERNAME=gsmui
DB_PASSWORD=...

REDIS_HOST=127.0.0.1
REDIS_PORT=6379
REDIS_PASSWORD=...

QUEUE_CONNECTION=redis
SESSION_DRIVER=redis
CACHE_DRIVER=redis

MAIL_MAILER=ses
MAIL_FROM_ADDRESS=noreply@gsmui.dev
```

## Deployment Process

```text
Code Push (git)
    ↓
CI Pipeline (GitHub Actions)
    ↓
Tests Pass
    ↓
Build Assets (Vite)
    ↓
Deploy to Production
    ↓
Run Migrations
    ↓
Clear Caches
    ↓
Restart Workers
```

## Monitoring

| Tool | Purpose |
|---|---|
| Laravel Telescope | Debugging |
| Laravel Horizon | Queue monitoring |
| Spatie Health | Health checks |
| Sentry | Error tracking |
| Uptime Robot | Uptime monitoring |

## Health Checks

```php
// config/health.php

return [
    'checks' => [
        \Spatie\Health\Checks\Checks\CacheCheck::class,
        \Spatie\Health\Checks\Checks\DatabaseCheck::class,
        \Spatie\Health\Checks\Checks\RedisCheck::class,
        \Spatie\Health\Checks\Checks\ScheduleCheck::class,
        \Spatie\Health\Checks\Checks\QueueCheck::class,
    ],
];
```

## Backup Strategy

| Data | Frequency | Retention |
|---|---|---|
| Database | Daily | 30 days |
| Database | Weekly | 12 weeks |
| Files | Daily | 30 days |
| Config | On change | Indefinite |

## Scaling Strategy

| Component | Strategy |
|---|---|
| Web | Horizontal (load balancer) |
| Queue | Horizontal (multiple workers) |
| Database | Vertical + read replicas |
| Cache | Cluster mode |
| Storage | S3 (unlimited) |

## Security Operations

| Operation | Frequency |
|---|---|
| OS updates | Weekly |
| Security patches | Immediate |
| SSL renewal | Auto (Let's Encrypt) |
| Access review | Monthly |
| Log rotation | Daily |
