# Disaster Recovery

> PRD — Volume 22: DevOps — Disaster Recovery

## Overview

This document defines the disaster recovery plan including RTO/RPO targets, failover strategy, backup restoration procedures, and runbook for emergency situations.

## Objectives

| Goal | Metric | Target |
|------|--------|--------|
| RTO | Recovery Time Objective | < 1 hour |
| RPO | Recovery Point Objective | < 6 hours |
| Failover time | Automatic failover duration | < 30 seconds |
| Data loss tolerance | Maximum acceptable data loss | < 6 hours |
| DR test frequency | Scheduled DR drills | Quarterly |

## RTO/RPO Matrix

| System Component | RTO | RPO | Strategy |
|-----------------|-----|-----|----------|
| Application Server | 5 min | 0 | Auto-scaling group |
| Database (Primary) | 30 min | 0 | Multi-AZ replication |
| Database (Backup) | 1 hour | 6 hours | Daily snapshots |
| Redis Cache | 5 min | 0 | Cluster failover |
| File Storage | 30 min | 6 hours | S3 cross-region |
| DNS | 5 min | N/A | Low TTL, fast propagation |
| Queue Workers | 5 min | 0 | Auto-restart |

## Failover Strategy

### Architecture

```
                    ┌─────────────────┐
                    │   Route 53      │
                    │   (DNS Failover)│
                    └────────┬────────┘
                             │
              ┌──────────────┼──────────────┐
              │              │              │
     ┌────────┴────────┐   │   ┌─────────┴────────┐
     │   Primary AZ    │   │   │   Standby AZ     │
     │   (us-east-1a)  │   │   │   (us-east-1b)   │
     │                 │   │   │                   │
     │  ┌──────────┐  │   │   │  ┌──────────┐    │
     │  │ App Server│  │   │   │  │ App Server│    │
     │  └──────────┘  │   │   │  └──────────┘    │
     │  ┌──────────┐  │   │   │  ┌──────────┐    │
     │  │ MySQL    │──┼───┴───┼──│ MySQL    │    │
     │  │ Primary  │  │       │  │ Replica  │    │
     │  └──────────┘  │       │  └──────────┘    │
     │  ┌──────────┐  │       │  ┌──────────┐    │
     │  │ Redis    │──┼───────┼──│ Redis    │    │
     │  │ Primary  │  │       │  │ Replica  │    │
     │  └──────────┘  │       │  └──────────┘    │
     └─────────────────┘       └──────────────────┘
```

### Database Failover

```php
// config/database.php
'mysql' => [
    'read' => [
        'host' => [
            env('DB_READ_HOST_1', '127.0.0.1'),
            env('DB_READ_HOST_2', '127.0.0.2'),
        ],
    ],
    'write' => [
        'host' => env('DB_HOST', '127.0.0.1'),
    ],
    'sticky' => true,
],
```

### Redis Failover

```php
// Sentinel configuration
'sentinel' => [
    'master' => env('REDIS_SENTINEL_MASTER', 'mymaster'),
    'nodes' => [
        ['host' => 'sentinel-1', 'port' => 26379],
        ['host' => 'sentinel-2', 'port' => 26379],
        ['host' => 'sentinel-3', 'port' => 26379],
    ],
    'replication_timeout' => 5000,
    'sentinel_password' => env('REDIS_SENTINEL_PASSWORD'),
],
```

## Emergency Runbook

### Runbook: Database Failure

| Step | Action | Owner | ETA |
|------|--------|-------|-----|
| 1 | Detect failure (monitoring alert) | Automated | 0 min |
| 2 | Assess impact (data loss?) | On-call | 2 min |
| 3 | Enable read-only mode | On-call | 3 min |
| 4 | Promote read replica to primary | DBA | 5 min |
| 5 | Update application config | DevOps | 2 min |
| 6 | Verify application health | On-call | 5 min |
| 7 | Notify stakeholders | Lead | 5 min |
| 8 | Post-incident review | Team | 24 hours |

### Runbook: Application Server Failure

| Step | Action | Owner | ETA |
|------|--------|-------|-----|
| 1 | Detect failure (health check) | Automated | 0 min |
| 2 | Auto-scaling launches replacement | AWS | 2 min |
| 3 | Load balancer removes unhealthy | AWS | 30 sec |
| 4 | Verify new instance health | Automated | 1 min |
| 5 | Clear old session data | DevOps | 2 min |
| 6 | Monitor for recurrence | On-call | 15 min |

### Runbook: Redis Failure

| Step | Action | Owner | ETA |
|------|--------|-------|-----|
| 1 | Detect failure (connection error) | Automated | 0 min |
| 2 | Sentinel promotes replica | Sentinel | 5 sec |
| 3 | Application reconnects | Laravel | 10 sec |
| 4 | Verify cache hit rate | On-call | 1 min |
| 5 | Warm cache if needed | DevOps | 5 min |

### Runbook: Complete Outage

| Step | Action | Owner | ETA |
|------|--------|-------|-----|
| 1 | Detect outage (external monitoring) | Automated | 0 min |
| 2 | Declare incident (PagerDuty) | On-call | 2 min |
| 3 | Assemble incident team | Lead | 5 min |
| 4 | Assess scope (all services?) | Team | 5 min |
| 5 | Activate DR site | DevOps | 15 min |
| 6 | Restore from latest backup | DBA | 30 min |
| 7 | Verify data integrity | Team | 15 min |
| 8 | Switch DNS to DR site | DevOps | 5 min |
| 9 | Verify end-to-end functionality | QA | 10 min |
| 10 | Communicate resolution | Lead | 5 min |

## Incident Communication

### Communication Template

```
INCIDENT UPDATE — [STATUS]

Severity: [SEVERITY]
Start Time: [TIME]
Duration: [DURATION]
Impact: [DESCRIPTION]

Current Status: [STATUS]
Next Update: [TIME]

Mitigation: [ACTIONS TAKEN]
 ETA to Resolution: [ETA]
```

### Notification Channels

| Severity | Internal | External | Frequency |
|----------|----------|----------|-----------|
| SEV-1 (Critical) | PagerDuty + Slack | Status page + Email | Every 15 min |
| SEV-2 (Major) | PagerDuty + Slack | Status page | Every 30 min |
| SEV-3 (Minor) | Slack | Status page | Every hour |
| SEV-4 (Low) | Slack | None | Daily |

## DR Testing

### Quarterly DR Drill

| Test | Scope | Success Criteria |
|------|-------|-----------------|
| Database failover | Primary → Replica | < 30 second switch |
| Full restore | Restore from backup | < 1 hour completion |
| DNS failover | Primary → DR region | < 5 minute propagation |
| Application failover | Multi-AZ | Zero user impact |
| Data integrity | Post-restore verification | 100% data match |

### DR Test Script

```php
class DisasterRecoveryTest extends TestCase
{
    public function test_database_failover(): void
    {
        $startTime = microtime(true);

        // Simulate primary failure
        DB::purge('mysql');

        // Connect to replica
        config(['database.connections.mysql.write.host' => env('DB_READ_HOST_1')]);

        // Verify connectivity
        $this->assertTrue(DB::connection()->ping());

        $failoverTime = microtime(true) - $startTime;
        $this->assertLessThan(30, $failoverTime, 'Failover should complete in under 30 seconds');
    }

    public function test_backup_restoration(): void
    {
        $backup = $this->getLatestBackup();
        $startTime = microtime(true);

        $this->artisan('backup:restore', ['backup' => $backup]);

        $restoreTime = microtime(true) - $startTime;
        $this->assertLessThan(3600, $restoreTime, 'Restore should complete in under 1 hour');

        // Verify data integrity
        $this->assertDatabaseCount('users', User::count());
    }
}
```

## Acceptance Criteria

- [ ] RTO for application is under 5 minutes
- [ ] RPO for database is under 6 hours
- [ ] Database failover completes in under 30 seconds
- [ ] DR site can serve full application load
- [ ] Emergency runbook covers all critical scenarios
- [ ] Incident communication reaches stakeholders within 5 minutes
- [ ] DR drills are conducted quarterly
- [ ] Backup restoration is tested monthly
- [ ] All team members know their DR roles
- [ ] Post-incident reviews are conducted within 24 hours
