# CI/CD Pipeline

> PRD — Volume 22: DevOps — CI/CD Pipeline

## Overview

The CI/CD pipeline automates testing, linting, building, and deployment using GitHub Actions. It enforces code quality gates, runs comprehensive test suites, builds production assets, and deploys with zero downtime.

## Objectives

| Goal | Metric | Target |
|------|--------|--------|
| Pipeline speed | Full pipeline completion | < 10 minutes |
| Test reliability | Flaky test rate | < 1% |
| Build success | First-pass build success rate | 95%+ |
| Deployment frequency | Deployments per day | 5+ |
| Rollback time | Time to rollback a deployment | < 2 minutes |

## Pipeline Stages

```
┌─────────┐   ┌─────────┐   ┌─────────┐   ┌─────────┐   ┌─────────┐
│  Lint   │──▶│  Test   │──▶│  Build  │──▶│  Deploy │──▶│ Verify  │
│  & Type │   │  Suite  │   │  Assets │   │  Stage  │   │  Smoke  │
└─────────┘   └─────────┘   └─────────┘   └─────────┘   └─────────┘
```

### Stage Details

| Stage | Duration | Failure Action | Required |
|-------|----------|---------------|----------|
| Lint & Type Check | ~1 min | Block pipeline | Yes |
| PHP Unit Tests | ~2 min | Block pipeline | Yes |
| Feature Tests | ~3 min | Block pipeline | Yes |
| Browser Tests | ~4 min | Block pipeline | Yes |
| Build Frontend Assets | ~2 min | Block pipeline | Yes |
| Deploy to Staging | ~1 min | Block pipeline | Yes |
| Smoke Tests | ~1 min | Block pipeline | Yes |
| Deploy to Production | ~2 min | Manual approval | Yes |
| Post-Deploy Verify | ~1 min | Auto-rollback | Yes |

## GitHub Actions Workflow

### Main Pipeline

```yaml
name: CI/CD Pipeline

on:
  push:
    branches: [main, develop]
  pull_request:
    branches: [main]

concurrency:
  group: ${{ github.workflow }}-${{ github.ref }}
  cancel-in-progress: true

jobs:
  lint:
    name: Lint & Type Check
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v4
      - uses: shivammathur/setup-php@v2
        with:
          php-version: '8.3'
          extensions: mbstring, xml, ctype, json, bcmath, gd, zip, redis
          coverage: none
      - name: Install Dependencies
        run: composer install --prefer-dist --no-progress
      - name: PHP CS Fixer
        run: vendor/bin/php-cs-fixer fix --dry-run --diff
      - name: PHPStan
        run: vendor/bin/phpstan analyse --memory-limit=2G
      - name: Pint
        run: vendor/bin/pint --test

  test:
    name: Test Suite
    runs-on: ubuntu-latest
    needs: lint
    services:
      mysql:
        image: mysql:8.0
        env:
          MYSQL_ROOT_PASSWORD: root
          MYSQL_DATABASE: testing
        ports:
          - 3306:3306
        options: >-
          --health-cmd="mysqladmin ping"
          --health-interval=10s
          --health-timeout=5s
          --health-retries=5
      redis:
        image: redis:7-alpine
        ports:
          - 6379:6379
    steps:
      - uses: actions/checkout@v4
      - uses: shivammathur/setup-php@v2
        with:
          php-version: '8.3'
          extensions: mbstring, xml, ctype, json, bcmath, gd, zip, redis
          coverage: xdebug
      - name: Install Dependencies
        run: composer install --prefer-dist --no-progress
      - name: Prepare Environment
        run: cp .env.testing .env
      - name: Generate Key
        run: php artisan key:generate
      - name: Migrate Database
        run: php artisan migrate --force
      - name: Unit Tests
        run: vendor/bin/phpunit --testsuite=Unit --coverage-clover=coverage-unit.xml
      - name: Feature Tests
        run: vendor/bin/phpunit --testsuite=Feature --coverage-clover=coverage-feature.xml
      - name: Upload Coverage
        uses: codecov/codecov-action@v3
        with:
          files: coverage-unit.xml,coverage-feature.xml

  browser:
    name: Browser Tests
    runs-on: ubuntu-latest
    needs: lint
    steps:
      - uses: actions/checkout@v4
      - uses: shivammathur/setup-php@v2
        with:
          php-version: '8.3'
      - name: Install PHP Dependencies
        run: composer install --prefer-dist --no-progress
      - name: Setup Node
        uses: actions/setup-node@v4
        with:
          node-version: 20
          cache: npm
      - name: Install Node Dependencies
        run: npm ci
      - name: Build Assets
        run: npm run build
      - name: Install Playwright
        run: npx playwright install --with-deps chromium
      - name: Start Server
        run: php artisan serve --port=8000 &
      - name: Run Browser Tests
        run: npx playwright test
      - name: Upload Artifacts
        if: failure()
        uses: actions/upload-artifact@v4
        with:
          name: playwright-report
          path: tests/Browser/report/

  build:
    name: Build Assets
    runs-on: ubuntu-latest
    needs: test
    steps:
      - uses: actions/checkout@v4
      - uses: actions/setup-node@v4
        with:
          node-version: 20
          cache: npm
      - run: npm ci
      - run: npm run build
      - name: Upload Build Artifacts
        uses: actions/upload-artifact@v4
        with:
          name: public-build
          path: public/build/

  deploy-staging:
    name: Deploy to Staging
    runs-on: ubuntu-latest
    needs: [test, browser, build]
    if: github.ref == 'refs/heads/develop'
    environment: staging
    steps:
      - uses: actions/checkout@v4
      - name: Download Build
        uses: actions/download-artifact@v4
        with:
          name: public-build
          path: public/build/
      - name: Deploy
        run: |
          ssh ${{ secrets.STAGING_SSH }} "cd /var/www/staging && \
            git pull origin develop && \
            composer install --no-dev && \
            php artisan migrate --force && \
            php artisan config:cache && \
            php artisan route:cache && \
            php artisan view:cache"
      - name: Clear Cache
        run: ssh ${{ secrets.STAGING_SSH }} "cd /var/www/staging && php artisan cache:clear"

  deploy-production:
    name: Deploy to Production
    runs-on: ubuntu-latest
    needs: [test, browser, build]
    if: github.ref == 'refs/heads/main'
    environment: production
    steps:
      - uses: actions/checkout@v4
      - name: Deploy
        run: |
          ssh ${{ secrets.PRODUCTION_SSH }} "cd /var/www/production && \
            php artisan envoyer:deploy"
```

## Caching Strategy

| Cache | Key | Restore | Save |
|-------|-----|---------|------|
| Composer | `composer-${{ hashFiles('composer.lock') }}` | Yes | Yes |
| npm | `npm-${{ hashFiles('package-lock.json') }}` | Yes | Yes |
| PHPStan | `phpstan-${{ github.sha }}` | Yes | Yes |
| Playwright | `playwright-${{ hashFiles('tests/Browser/package.json') }}` | Yes | Yes |
| Build | `build-${{ github.sha }}` | No | Yes |

### Cache Configuration

```yaml
- name: Cache Composer Dependencies
  uses: actions/cache@v4
  with:
    path: vendor
    key: ${{ runner.os }}-composer-${{ hashFiles('**/composer.lock') }}
    restore-keys: |
      ${{ runner.os }}-composer-

- name: Cache npm Dependencies
  uses: actions/cache@v4
  with:
    path: node_modules
    key: ${{ runner.os }}-npm-${{ hashFiles('**/package-lock.json') }}
    restore-keys: |
      ${{ runner.os }}-npm-
```

## Quality Gates

| Gate | Tool | Threshold | Blocking |
|------|------|-----------|----------|
| Code Style | PHP CS Fixer | 0 violations | Yes |
| Static Analysis | PHPStan | Level 8, 0 errors | Yes |
| Larastan | Larastan | 0 errors | Yes |
| Unit Tests | PHPUnit | 100% pass | Yes |
| Feature Tests | PHPUnit | 100% pass | Yes |
| Browser Tests | Playwright | 100% pass | Yes |
| Code Coverage | Xdebug | > 80% | Warning |
| Bundle Size | Webpack | < 500KB gzip | Warning |
| Security Audit | Composer Audit | 0 critical | Yes |

## Deployment Environments

| Environment | Branch | URL | Auto-Deploy |
|------------|--------|-----|-------------|
| Local | Any | `localhost:8000` | No |
| Development | `develop` | `dev.example.com` | Yes |
| Staging | `staging` | `staging.example.com` | Yes |
| Production | `main` | `example.com` | Manual approval |

### Environment Protection Rules

```yaml
# Required reviewers for production
environment:
  name: production
  protection_rules:
    - type: required_reviewers
      review_count: 2
    - type: wait_timer
      minutes: 5
```

## Branch Strategy

| Branch | Purpose | Merges Into |
|--------|---------|-------------|
| `feature/*` | New features | `develop` |
| `bugfix/*` | Bug fixes | `develop` |
| `hotfix/*` | Critical fixes | `main` + `develop` |
| `release/*` | Release prep | `main` + `develop` |
| `develop` | Integration | `main` |
| `main` | Production | — |

## Notification Configuration

| Event | Channel | Message |
|-------|---------|---------|
| Pipeline passed | Slack `#deploys` | "Deployed {sha} to {env}" |
| Pipeline failed | Slack `#deploys` + email | "Build failed: {reason}" |
| Deploy succeeded | Slack `#deploys` | "✅ {env} updated" |
| Deploy failed | Slack `#deploys` + PagerDuty | "❌ {env} deploy failed" |

## Acceptance Criteria

- [ ] Pipeline runs lint, test, build, deploy stages sequentially
- [ ] Caching reduces repeat build times by 50%+
- [ ] Quality gates block deployment on failure
- [ ] Browser tests run against a live server instance
- [ ] Staging auto-deploys on `develop` branch push
- [ ] Production requires manual approval before deployment
- [ ] Failed deployments trigger auto-rollback
- [ ] Notifications send to Slack on all deployment events
- [ ] Coverage reports upload to Codecov
- [ ] Concurrency groups cancel in-progress runs on new pushes
