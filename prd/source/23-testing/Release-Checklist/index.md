# Release Checklist

> PRD — Volume 23: Quality Assurance — Release Checklist

## Overview

This document defines the pre-release, deployment, post-release verification, and rollback plan for the gsmui platform.

## Release Phases

| Phase | Duration | Owner | Gates |
|-------|----------|-------|-------|
| Pre-release | 1-2 days | Lead Developer | All checks pass |
| Deployment | 5-10 minutes | DevOps | Zero downtime |
| Post-release | 1 hour | QA Team | Smoke tests pass |
| Monitoring | 24 hours | On-call | No incidents |

## Pre-Release Checklist

### Code Quality

| Check | Command | Status |
|-------|---------|--------|
| Tests passing | `php artisan test` | ☐ |
| Browser tests | `npx playwright test` | ☐ |
| Linting | `vendor/bin/pint --test` | ☐ |
| Static analysis | `vendor/bin/phpstan analyse` | ☐ |
| Security audit | `composer audit` | ☐ |
| npm audit | `npm audit` | ☐ |

### Documentation

| Check | Owner | Status |
|-------|-------|--------|
| CHANGELOG updated | Lead | ☐ |
| README updated (if needed) | Lead | ☐ |
| API docs updated (if needed) | Lead | ☐ |
| Upgrade guide (if breaking) | Lead | ☐ |

### Database

| Check | Command | Status |
|-------|---------|--------|
| Migrations reviewed | Manual review | ☐ |
| Migrations tested locally | `php artisan migrate:fresh --seed` | ☐ |
| Backward compatible | Manual review | ☐ |
| Rollback scripts ready | Manual review | ☐ |

### Configuration

| Check | Status |
|-------|--------|
| Environment variables documented | ☐ |
| Config changes reviewed | ☐ |
| Feature flags configured | ☐ |
| Queue workers updated | ☐ |
| Scheduler entries verified | ☐ |

## Deployment Checklist

### Pre-Deployment

| Step | Command | Status |
|------|---------|--------|
| Enable maintenance mode | `php artisan down` | ☐ |
| Create database backup | `backup:database` | ☐ |
| Verify backup integrity | `backup:verify` | ☐ |
| Notify team | Slack notification | ☐ |

### Deployment

| Step | Command | Status |
|------|---------|--------|
| Pull latest code | `git pull origin main` | ☐ |
| Install dependencies | `composer install --no-dev` | ☐ |
| Build assets | `npm ci && npm run build` | ☐ |
| Run migrations | `php artisan migrate --force` | ☐ |
| Cache config | `php artisan config:cache` | ☐ |
| Cache routes | `php artisan route:cache` | ☐ |
| Cache views | `php artisan view:cache` | ☐ |
| Restart queue workers | `php artisan queue:restart` | ☐ |
| Restart Horizon | `php artisan horizon:terminate` | ☐ |
| Disable maintenance mode | `php artisan up` | ☐ |

### Post-Deployment

| Step | Command | Status |
|------|---------|--------|
| Health check | `curl https://example.com/health` | ☐ |
| Smoke tests | Run smoke test suite | ☐ |
| Monitor error logs | `tail -f storage/logs/laravel.log` | ☐ |
| Verify queue workers | `php artisan horizon:status` | ☐ |
| Verify scheduler | `php artisan schedule:list` | ☐ |
| Check performance | New Relic / Sentry | ☐ |

## Post-Release Verification

### Smoke Tests

| Test | URL | Expected | Status |
|------|-----|----------|--------|
| Homepage loads | `/` | 200 OK | ☐ |
| Blog listing | `/blog` | 200 OK | ☐ |
| Single post | `/blog/sample` | 200 OK | ☐ |
| Page listing | `/pages` | 200 OK | ☐ |
| Search | `/search?q=test` | 200 OK | ☐ |
| Login | `/login` | 200 OK | ☐ |
| Admin dashboard | `/admin` | Redirect to login | ☐ |
| API endpoints | `/api/pages` | 200 OK | ☐ |
| Media upload | Upload test file | Success | ☐ |
| Queue processing | Dispatch test job | Processed | ☐ |

### Performance Verification

| Metric | Threshold | Actual | Status |
|--------|-----------|--------|--------|
| Response time (P95) | < 500ms | | ☐ |
| Time to first byte | < 200ms | | ☐ |
| Error rate | < 0.1% | | ☐ |
| Cache hit rate | > 95% | | ☐ |
| Queue depth | < 50 | | ☐ |

### Monitoring

| Check | Tool | Status |
|-------|------|--------|
| Error rate spike | Sentry | ☐ |
| Performance degradation | New Relic | ☐ |
| Uptime monitoring | Pingdom | ☐ |
| Log anomalies | ELK/Loki | ☐ |

## Rollback Plan

### Rollback Triggers

| Trigger | Threshold | Action |
|---------|-----------|--------|
| Error rate > 5% | 5 minutes | Immediate rollback |
| Response time > 2s | 10 minutes | Investigate, rollback if needed |
| Critical bug | Any | Immediate rollback |
| Data corruption | Any | Stop traffic, rollback |
| Security vulnerability | Any | Immediate rollback |

### Rollback Procedure

```bash
#!/bin/bash
# rollback.sh
set -euo pipefail

echo "Starting rollback..."

# 1. Enable maintenance mode
php artisan down --message="Rolling back deployment" --retry=60

# 2. Rollback database (if needed)
# php artisan migrate:rollback --step=1

# 3. Checkout previous release
PREVIOUS_TAG=$(git describe --tags --abbrev=0 HEAD~1)
git checkout $PREVIOUS_TAG

# 4. Install dependencies
composer install --no-dev --optimize-autoloader

# 5. Build assets
npm ci && npm run build

# 6. Cache configuration
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 7. Restart services
php artisan queue:restart
php artisan horizon:terminate

# 8. Disable maintenance mode
php artisan up

# 9. Verify
curl -f https://example.com/health || exit 1

echo "Rollback complete to $PREVIOUS_TAG"
```

### Rollback Communication

```
ROLLBACK NOTICE

Version: [Previous Version]
Reason: [Reason]
Impact: [Impact Description]
Duration: [Expected Duration]
ETA: [Time to Complete]

Actions:
1. Rollback initiated at [TIME]
2. Database changes reverted at [TIME]
3. Application restored at [TIME]
4. Monitoring active for [DURATION]

Next Steps:
- Root cause analysis scheduled for [TIME]
- Post-mortem to follow
```

## Release Sign-Off

| Role | Name | Status | Date |
|------|------|--------|------|
| Lead Developer | | ☐ Approved | |
| QA Lead | | ☐ Approved | |
| DevOps | | ☐ Approved | |
| Product Owner | | ☐ Approved | |

## Acceptance Criteria

- [ ] All pre-release checks pass
- [ ] Deployment completes with zero downtime
- [ ] All smoke tests pass post-deployment
- [ ] Performance metrics meet thresholds
- [ ] Monitoring confirms no anomalies
- [ ] Rollback plan is tested and ready
- [ ] Team is notified of release completion
- [ ] Release is tagged in Git
- [ ] CHANGELOG is updated
- [ ] Sign-off obtained from all stakeholders
