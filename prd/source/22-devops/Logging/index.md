# Logging

> PRD — Volume 22: DevOps — Logging

## Overview

The Logging system provides structured logging, configurable log channels, log level management, centralized log aggregation, and log rotation for the gsmui platform.

## Objectives

| Goal | Metric | Target |
|------|--------|--------|
| Log write speed | Time to write a log entry | < 5ms |
| Log search | Time to search last 24h logs | < 2 seconds |
| Log retention | Days of logs available online | 30 days |
| Structured format | Logs in JSON format | 100% |
| Error notification | Time from error to alert | < 1 minute |

## Log Channels

| Channel | Driver | Level | Description |
|---------|--------|-------|-------------|
| `default` | `stack` | `debug` | All logs |
| `stack` | `stack` | `debug` | Daily + stderr |
| `daily` | `daily` | `debug` | Daily rotating files |
| `stderr` | `stderr` | `warning` | Console error output |
| `syslog` | `syslog` | `info` | System logger |
| `errorlog` | `errorlog` | `error` | PHP error log |
| `emergency` | `emergency` | `alert` | Bootstrap errors |
| `sql` | `daily` | `debug` | SQL query log |
| `audit` | `daily` | `info` | User action audit |
| `performance` | `daily` | `info` | Slow queries/requests |
| `security` | `daily` | `warning` | Security events |

### Channel Configuration

```php
// config/logging.php
return [
    'default' => env('LOG_CHANNEL', 'stack'),

    'deprecations' => [
        'channel' => env('LOG_DEPRECATIONS_CHANNEL', 'null'),
        'trace' => env('LOG_DEPRECATIONS_TRACE', false),
    ],

    'channels' => [
        'stack' => [
            'driver' => 'stack',
            'channels' => ['daily', 'stderr'],
            'ignore_exceptions' => false,
        ],

        'daily' => [
            'driver' => 'daily',
            'path' => storage_path('logs/laravel.log'),
            'level' => env('LOG_LEVEL', 'debug'),
            'days' => 14,
            'replace_placeholders' => true,
        ],

        'stderr' => [
            'driver' => 'monolog',
            'level' => env('LOG_LEVEL', 'debug'),
            'handler' => Monolog\Handler\StreamHandler::class,
            'formatter' => env('LOG_STDERR_FORMATTER'),
            'with' => [
                'stream' => 'php://stderr',
            ],
            'processors' => [Monolog\Processor\PsrLogMessageProcessor::class],
        ],

        'sql' => [
            'driver' => 'daily',
            'path' => storage_path('logs/sql.log'),
            'level' => 'debug',
            'days' => 7,
        ],

        'audit' => [
            'driver' => 'daily',
            'path' => storage_path('logs/audit.log'),
            'level' => 'info',
            'days' => 90,
        ],

        'performance' => [
            'driver' => 'daily',
            'path' => storage_path('logs/performance.log'),
            'level' => 'info',
            'days' => 30,
        ],

        'security' => [
            'driver' => 'daily',
            'path' => storage_path('logs/security.log'),
            'level' => 'warning',
            'days' => 90,
        ],

        'papertrail' => [
            'driver' => 'monolog',
            'level' => env('LOG_LEVEL', 'debug'),
            'handler' => env('LOG_PAPERTRAIL_HANDLER', Monolog\Handler\SyslogUdpHandler::class),
            'handler_with' => [
                'host' => env('PAPERTRAIL_URL'),
                'port' => env('PAPERTRAIL_PORT'),
                'connectionString' => 'tls://'.env('PAPERTRAIL_URL').':'.env('PAPERTRAIL_PORT'),
            ],
        ],

        'slack' => [
            'driver' => 'monolog',
            'level' => env('LOG_LEVEL', 'warning'),
            'handler' => Monolog\Handler\SlackWebhookHandler::class,
            'formatter' => env('LOG_SLACK_FORMATTER'),
            'handler_with' => [
                'url' => env('LOG_SLACK_WEBHOOK_URL'),
                'username' => 'Gsmui Logs',
                'emoji' => ':boom:',
                'short' => true,
            ],
        ],
    ],
];
```

## Structured Logging

### JSON Log Format

```json
{
  "message": "User login successful",
  "context": {
    "user_id": 42,
    "email": "user@example.com",
    "ip": "192.168.1.100",
    "user_agent": "Mozilla/5.0..."
  },
  "level": "info",
  "level_name": "INFO",
  "channel": "audit",
  "datetime": "2026-07-15T14:30:22.123456Z",
  "extra": {
    "request_id": "abc-123-def-456",
    "session_id": "xyz-789",
    "trace_id": "trace-abc-123"
  }
}
```

### Log Context

```php
// Adding context to logs
Log::channel('audit')->info('User login', [
    'user_id' => $user->id,
    'email' => $user->email,
    'ip' => $request->ip(),
    'user_agent' => $request->userAgent(),
    'action' => 'login',
]);

// Performance logging
Log::channel('performance')->info('Slow query', [
    'query' => $query,
    'duration_ms' => $duration,
    'bindings' => $bindings,
    'file' => $file,
    'line' => $line,
]);

// Security logging
Log::channel('security')->warning('Failed login attempt', [
    'email' => $email,
    'ip' => $request->ip(),
    'attempts' => $attempts,
    'reason' => 'invalid_password',
]);
```

## Log Levels

| Level | Value | When to Use |
|-------|-------|-------------|
| `emergency` | 600 | System is unusable |
| `alert` | 550 | Action must be taken immediately |
| `critical` | 500 | Critical conditions |
| `error` | 400 | Error conditions |
| `warning` | 300 | Warning conditions |
| `notice` | 250 | Normal but significant conditions |
| `info` | 200 | Informational messages |
| `debug` | 100 | Debug-level messages |

### Level Configuration by Environment

| Channel | Local | Staging | Production |
|---------|-------|---------|-----------|
| `default` | debug | info | warning |
| `sql` | debug | debug | info |
| `audit` | info | info | info |
| `performance` | debug | info | info |
| `security` | debug | warning | warning |

## Centralized Logging

### Log Aggregation Pipeline

```
Application → File/Stderr → Log Shipper → Aggregation → Storage → Query
     ↓              ↓              ↓              ↓           ↓        ↓
  Monolog      Daily files     Fluentd      Elasticsearch  S3/GCS  Kibana
```

### Fluentd Configuration

```xml
<source>
  @type tail
  path /var/www/gsmui/storage/logs/*.log
  pos_file /var/log/fluentd/gsmui.log.pos
  tag gsmui.*
  <parse>
    @type json
    time_key datetime
    time_format %Y-%m-%dT%H:%M:%S.%NZ
  </parse>
</source>

<filter gsmui.**>
  @type record_transformer
  <record>
    hostname "#{Socket.gethostname}"
    service gsmui
  </record>
</filter>

<match gsmui.**>
  @type elasticsearch
  host elasticsearch.example.com
  port 9200
  index_name gsmui-logs
  type_name _doc
  include_tag_key true
  <buffer>
    @type file
    path /var/log/fluentd/buffers/gsmui
    flush_interval 10s
    flush_thread_count 2
    retry_type exponential_backoff
    chunk_limit_size 2M
    queue_limit_length 64
  </buffer>
</match>
```

## Log Rotation

### Rotation Schedule

| Log File | Retention | Max Size | Compress |
|----------|-----------|----------|----------|
| `laravel.log` | 14 days | 50MB | Yes |
| `sql.log` | 7 days | 20MB | Yes |
| `audit.log` | 90 days | 100MB | Yes |
| `performance.log` | 30 days | 50MB | Yes |
| `security.log` | 90 days | 50MB | Yes |

### System Logrotate

```conf
# /etc/logrotate.d/gsmui
/var/www/gsmui/storage/logs/*.log {
    daily
    missingok
    rotate 14
    compress
    delaycompress
    notifempty
    create 0664 www-data www-data
    sharedscripts
    postrotate
        [ -f /var/run/php-fpm.pid ] && kill -USR2 $(cat /var/run/php-fpm.pid)
    endscript
}
```

## Database Schema

```sql
CREATE TABLE logs (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    channel VARCHAR(50) NOT NULL,
    level VARCHAR(20) NOT NULL,
    message TEXT NOT NULL,
    context JSON NULL,
    extra JSON NULL,
    created_at TIMESTAMP NOT NULL,
    KEY logs_channel_index (channel),
    KEY logs_level_index (level),
    KEY logs_created_index (created_at)
) ENGINE=InnoDB
  PARTITION BY RANGE (UNIX_TIMESTAMP(created_at)) (
    PARTITION p2026_07 VALUES LESS THAN (UNIX_TIMESTAMP('2026-08-01')),
    PARTITION p2026_08 VALUES LESS THAN (UNIX_TIMESTAMP('2026-09-01')),
    PARTITION p_future VALUES LESS THAN MAXVALUE
);
```

## Acceptance Criteria

- [ ] All logs are in structured JSON format
- [ ] Each log channel writes to a separate file
- [ ] Log levels are configurable per environment
- [ ] SQL queries are logged to a dedicated channel
- [ ] Audit trail captures all user actions
- [ ] Performance logs track slow queries and requests
- [ ] Security events are logged with full context
- [ ] Log rotation compresses old files automatically
- [ ] Centralized logging aggregates all channels
- [ ] Log search completes within 2 seconds for 24h range
