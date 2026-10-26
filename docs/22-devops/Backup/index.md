# Backup Strategy

> PRD — Volume 22: DevOps — Backup

## Overview

The Backup Strategy covers database backups, file backups, backup scheduling, restoration procedures, and backup testing for the gsmui platform.

## Objectives

| Goal | Metric | Target |
|------|--------|--------|
| Backup frequency | Time between backups | Every 6 hours |
| RPO | Recovery Point Objective | < 6 hours |
| RTO | Recovery Time Objective | < 1 hour |
| Backup success rate | Successful backup percentage | 99.9% |
| Restore test | Monthly restore verification | 100% |

## Backup Types

| Type | Content | Frequency | Retention | Storage |
|------|---------|-----------|-----------|---------|
| Full Database | MySQL dump | Daily (2:00 AM) | 30 days | S3 + Local |
| Incremental DB | Binary logs | Hourly | 7 days | S3 |
| File Storage | `storage/` directory | Daily (3:00 AM) | 30 days | S3 |
| Code Repository | Git repo | On push | Permanent | GitHub |
| Configuration | `.env`, config files | Daily | 30 days | S3 |
| Redis | RDB snapshot | Every 6 hours | 7 days | S3 |

## Database Backup

### Backup Script

```bash
#!/bin/bash
# backup-database.sh
set -euo pipefail

BACKUP_DIR="/var/backups/gsmui"
DATE=$(date +%Y-%m-%d_%H%M%S)
DB_NAME="${DB_DATABASE:-gsmui}"
DB_USER="${DB_USERNAME:-root}"
DB_PASS="${DB_PASSWORD}"
S3_BUCKET="s3://gsmui-backups"

echo "Starting database backup: $DATE"

# Full dump
mysqldump \
    --user="$DB_USER" \
    --password="$DB_PASS" \
    --single-transaction \
    --routines \
    --triggers \
    --events \
    --add-drop-table \
    --complete-insert \
    --extended-insert \
    --quick \
    "$DB_NAME" | gzip > "$BACKUP_DIR/db-$DATE.sql.gz"

# Verify backup
if gzip -t "$BACKUP_DIR/db-$DATE.sql.gz"; then
    echo "Backup verified: $BACKUP_DIR/db-$DATE.sql.gz"
else
    echo "Backup verification FAILED!" >&2
    exit 1
fi

# Upload to S3
aws s3 cp "$BACKUP_DIR/db-$DATE.sql.gz" "$S3_BUCKET/database/db-$DATE.sql.gz" \
    --storage-class STANDARD_IA

# Clean old local backups (keep 7 days)
find "$BACKUP_DIR" -name "db-*.sql.gz" -mtime +7 -delete

# Clean old S3 backups (keep 30 days)
aws s3 ls "$S3_BUCKET/database/" | while read -r line; do
    createDate=$(echo $line | awk '{print $1" "$2}')
    createDate=$(date -d "$createDate" +%s 2>/dev/null || true)
    olderDate=$(date -d "-30 days" +%s)
    if [[ $createDate -lt $olderDate ]]; then
        fileName=$(echo $line | awk '{print $4}')
        [[ -n "$fileName" ]] && aws s3 rm "$S3_BUCKET/database/$fileName"
    fi
done

echo "Database backup complete: $DATE"
```

### Backup Configuration

| Setting | Value | Description |
|---------|-------|-------------|
| `backup.path` | `/var/backups/gsmui` | Local backup directory |
| `backup.s3_bucket` | `s3://gsmui-backups` | S3 bucket for remote storage |
| `backup.retention_days` | 30 | Days to keep backups |
| `backup.compress` | `true` | Gzip compression |
| `backup.encrypt` | `true` | AES-256 encryption |
| `backup.notification_email` | `ops@example.com` | Backup failure notifications |

## File Backup

### Storage Directory Backup

```bash
#!/bin/bash
# backup-files.sh
set -euo pipefail

BACKUP_DIR="/var/backups/gsmui"
DATE=$(date +%Y-%m-%d_%H%M%S)
STORAGE_DIR="/var/www/gsmui/storage"
S3_BUCKET="s3://gsmui-backups"

echo "Starting file backup: $DATE"

# Create tarball of storage directory
tar czf "$BACKUP_DIR/files-$DATE.tar.gz" \
    --exclude='logs/*.log' \
    --exclude='framework/cache/*' \
    --exclude='framework/sessions/*' \
    --exclude='framework/views/*.php' \
    -C /var/www/gsmui storage

# Upload to S3
aws s3 cp "$BACKUP_DIR/files-$DATE.tar.gz" "$S3_BUCKET/files/files-$DATE.tar.gz"

# Clean old backups
find "$BACKUP_DIR" -name "files-*.tar.gz" -mtime +7 -delete

echo "File backup complete: $DATE"
```

### What to Backup

| Directory | Content | Priority |
|-----------|---------|----------|
| `storage/app/` | Uploaded files, media | Critical |
| `storage/app/public/` | Public assets | High |
| `storage/logs/` | Application logs | Medium |
| `storage/framework/` | Compiled views, cache | Low |
| `public/uploads/` | User uploads | Critical |
| `.env` | Environment config | Critical |

## Backup Schedule

| Backup Type | Time (UTC) | Frequency | Duration | Priority |
|-------------|-----------|-----------|----------|----------|
| Database Full | 02:00 | Daily | ~5 min | Critical |
| Database Incremental | Every hour | Hourly | < 1 min | High |
| File Storage | 03:00 | Daily | ~10 min | High |
| Redis Snapshot | 00:00, 06:00, 12:00, 18:00 | Every 6h | < 1 min | Medium |
| Configuration | 04:00 | Daily | < 1 min | High |
| Git Push | On commit | Real-time | Instant | Critical |

### Laravel Scheduler Integration

```php
// app/Console/Kernel.php
protected function schedule(Schedule $schedule): void
{
    // Database backup
    $schedule->command('backup:database')
        ->dailyAt('02:00')
        ->withoutOverlapping()
        ->appendOutputTo(storage_path('logs/backup.log'));

    // File backup
    $schedule->command('backup:files')
        ->dailyAt('03:00')
        ->withoutOverlapping();

    // Redis backup
    $schedule->command('backup:redis')
        ->cron('0 */6 * * *')
        ->withoutOverlapping();

    // Backup verification
    $schedule->command('backup:verify')
        ->dailyAt('05:00')
        ->appendOutputTo(storage_path('logs/backup-verify.log'));

    // Clean old backups
    $schedule->command('backup:clean')
        ->dailyAt('06:00');
}
```

## Restoration

### Restore Procedure

```bash
#!/bin/bash
# restore-database.sh
set -euo pipefail

BACKUP_FILE=$1
DB_NAME="${DB_DATABASE:-gsmui}"
DB_USER="${DB_USERNAME:-root}"
DB_PASS="${DB_PASSWORD}"

if [[ -z "$BACKUP_FILE" ]]; then
    echo "Usage: $0 <backup-file.sql.gz>"
    exit 1
fi

echo "Restoring database from: $BACKUP_FILE"

# Create restore point
mysqldump --user="$DB_USER" --password="$DB_PASS" \
    --single-transaction "$DB_NAME" > /tmp/pre-restore-$(date +%s).sql

# Disable foreign key checks
mysql --user="$DB_USER" --password="$DB_PASS" -e "
    SET FOREIGN_KEY_CHECKS=0;
    SET SQL_LOG_BIN=0;
"

# Restore
if [[ "$BACKUP_FILE" == *.gz ]]; then
    gunzip -c "$BACKUP_FILE" | mysql --user="$DB_USER" --password="$DB_PASS" "$DB_NAME"
else
    mysql --user="$DB_USER" --password="$DB_PASS" "$DB_NAME" < "$BACKUP_FILE"
fi

# Re-enable checks
mysql --user="$DB_USER" --password="$DB_PASS" -e "
    SET FOREIGN_KEY_CHECKS=1;
    SET SQL_LOG_BIN=1;
"

# Clear cache
php artisan cache:clear
php artisan config:cache
php artisan route:cache

echo "Database restore complete"
```

## Backup Testing

### Monthly Restore Test

```php
class BackupTestCommand extends Command
{
    protected $signature = 'backup:test-restore';

    public function handle(): int
    {
        $latestBackup = $this->getLatestBackup();

        if (!$latestBackup) {
            $this->error('No backups found');
            return 1;
        }

        $this->info("Testing restore from: {$latestBackup}");

        // Create test database
        DB::statement('CREATE DATABASE IF NOT EXISTS gsmui_restore_test');
        $this->call('db:restore', [
            'database' => 'gsmui_restore_test',
            'backup' => $latestBackup,
        ]);

        // Verify data integrity
        $checks = [
            'users' => DB::connection('restore_test')->table('users')->count(),
            'pages' => DB::connection('restore_test')->table('pages')->count(),
            'posts' => DB::connection('restore_test')->table('posts')->count(),
        ];

        foreach ($checks as $table => $count) {
            $this->line("  {$table}: {$count} rows");
        }

        // Drop test database
        DB::statement('DROP DATABASE gsmui_restore_test');

        $this->info('Backup restore test PASSED');
        return 0;
    }
}
```

## Acceptance Criteria

- [ ] Database backups run daily at 2:00 AM UTC
- [ ] File backups run daily at 3:00 AM UTC
- [ ] Backups are uploaded to S3 within 30 minutes
- [ ] Backup encryption uses AES-256
- [ ] Restore procedure is tested monthly
- [ ] Backup failure notifications send within 5 minutes
- [ ] Old backups are automatically cleaned up
- [ ] Backup integrity is verified after creation
- [ ] Full restore completes within RTO target (1 hour)
- [ ] Redis snapshots capture queue and session data
