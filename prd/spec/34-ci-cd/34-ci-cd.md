# 34 — CI/CD

## Purpose

Define the Continuous Integration and Continuous Deployment pipeline for GsmUi.

## Pipeline Stages

```text
Push to Git
    ↓
Stage 1: Code Quality
    ├── Lint (PHP CS Fixer)
    ├── Static Analysis (PHPStan)
    └── Security Scan
    ↓
Stage 2: Testing
    ├── Unit Tests
    ├── Feature Tests
    └── Browser Tests
    ↓
Stage 3: Build
    ├── Install Dependencies
    ├── Build Assets (Vite)
    └── Optimize
    ↓
Stage 4: Deploy
    ├── Deploy to Staging
    ├── Run Migrations
    ├── Run Smoke Tests
    └── Deploy to Production
    ↓
Stage 5: Post-Deploy
    ├── Clear Caches
    ├── Restart Workers
    ├── Health Check
    └── Notify
```

## GitHub Actions

```yaml
# .github/workflows/ci.yml

name: CI

on:
  push:
    branches: [main]
  pull_request:
    branches: [main]

jobs:
  lint:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v4
      - uses: shivammathur/setup-php@v2
        with:
          php-version: '8.4'
      - run: composer install
      - run: vendor/bin/php-cs-fixer fix --dry-run --diff

  static-analysis:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v4
      - uses: shivammathur/setup-php@v2
        with:
          php-version: '8.4'
      - run: composer install
      - run: vendor/bin/phpstan analyse

  test:
    runs-on: ubuntu-latest
    needs: [lint, static-analysis]
    services:
      mysql:
        image: mysql:8.4
        env:
          MYSQL_ROOT_PASSWORD: password
          MYSQL_DATABASE: testing
        ports:
          - 3306:3306
      redis:
        image: redis:7
        ports:
          - 6379:6379
    steps:
      - uses: actions/checkout@v4
      - uses: shivammathur/setup-php@v2
        with:
          php-version: '8.4'
          extensions: dom, curl, mbstring, zip
      - run: composer install
      - run: cp .env.testing .env
      - run: php artisan migrate --force
      - run: php artisan test --coverage --min=80

  browser-test:
    runs-on: ubuntu-latest
    needs: [test]
    steps:
      - uses: actions/checkout@v4
      - uses: actions/setup-node@v4
        with:
          node-version: '20'
      - run: npm ci
      - run: npx playwright install
      - run: npx playwright test

  deploy-staging:
    runs-on: ubuntu-latest
    needs: [browser-test]
    if: github.ref == 'refs/heads/main'
    steps:
      - uses: actions/checkout@v4
      - run: # Deploy to staging

  deploy-production:
    runs-on: ubuntu-latest
    needs: [deploy-staging]
    if: github.ref == 'refs/heads/main'
    steps:
      - uses: actions/checkout@v4
      - run: # Deploy to production
```

## Branch Strategy

| Branch | Purpose | Deploy To |
|---|---|---|
| `main` | Production | Production |
| `develop` | Development | Staging |
| `feature/*` | Features | Preview |
| `hotfix/*` | Hotfixes | Production (fast) |

## Deployment Commands

```bash
# Deploy to production
php artisan deploy:production

# Rollback
php artisan deploy:rollback

# Health check
php artisan health:check
```

## Environment Promotion

```text
Feature Branch → Preview Environment
    ↓
Develop Branch → Staging
    ↓
Main Branch → Production
```

## Post-Deploy Checklist

* [ ] Migrations run
* [ ] Config cached
* [ ] Routes cached
* [ ] Views cached
* [ ] Queue workers restarted
* [ ] Horizon restarted
* [ ] Health check passes
* [ ] Error rate normal
* [ ] Response times normal
