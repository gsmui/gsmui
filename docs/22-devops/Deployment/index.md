# Deployment

> PRD — Volume 22: DevOps — Deployment

## Overview

This document covers zero-downtime deployment strategies, deployment tools (Envoyer, Laravel Forge, Vapor), infrastructure as code, and rollback procedures for the gsmui platform.

## Objectives

| Goal | Metric | Target |
|------|--------|--------|
| Deployment time | Full deployment completion | < 5 minutes |
| Downtime | User-facing downtime during deploy | 0 seconds |
| Rollback time | Time to revert to previous version | < 2 minutes |
| Deployment frequency | Deploys per day | 5+ |
| Success rate | Successful deployment percentage | 98%+ |

## Deployment Methods

| Method | Use Case | Complexity | Downtime |
|--------|----------|-----------|----------|
| Envoyer | Traditional VPS | Low | Zero |
| Laravel Forge | Server management | Low | Zero |
| Laravel Vapor | Serverless (AWS) | Medium | Zero |
| Docker Deploy | Container orchestration | Medium | Zero |
| Manual SSH | Emergency hotfixes | Low | Minimal |

## Zero-Downtime Deployment

### Symlink-Based Deployment

```
current → /var/www/releases/2026-07-15-143022
```

### Deployment Script

```bash
#!/bin/bash
set -euo pipefail

APP_DIR="/var/www/gsmui"
RELEASES_DIR="$APP_DIR/releases"
SHARED_DIR="$APP_DIR/shared"
CURRENT_LINK="$APP_DIR/current"
RELEASE_NAME=$(date +%Y-%m-%d-%H%M%S)
RELEASE_DIR="$RELEASES_DIR/$RELEASE_NAME"

echo "🚀 Starting deployment: $RELEASE_NAME"

# Create release directory
mkdir -p "$RELEASE_DIR"
cd "$RELEASE_DIR"

# Clone/copy code
git clone --depth 1 --branch main git@github.com:user/gsmui.git .
git checkout $GITHUB_SHA

# Install dependencies
composer install --no-dev --prefer-dist --no-interaction
npm ci --prefer-offline
npm run build

# Link shared resources
ln -nfs "$SHARED_DIR/storage" storage
ln -nfs "$SHARED_DIR/.env" .env

# Run migrations
php artisan migrate --force

# Cache configuration
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

# Clear old cache
php artisan cache:clear
php artisan cache:cache

# Switch symlink (atomic)
ln -nfs "$RELEASE_DIR" "$CURRENT_LINK"

# Restart PHP-FPM
sudo systemctl reload php8.3-fpm

# Restart queue workers
php artisan queue:restart

# Prune old releases (keep last 5)
cd "$RELEASES_DIR"
ls -1t | tail -n +6 | xargs rm -rf

echo "✅ Deployment complete: $RELEASE_NAME"
```

## Envoyer Integration

### Envoyer Configuration

| Setting | Value |
|---------|-------|
| Repository | `git@github.com:user/gsmui.git` |
| Branch | `main` |
| PHP Version | 8.3 |
| Keep Releases | 5 |
| Health Check URL | `/health` |
| Health Check Timeout | 30s |

### Envoyer Hooks

| Hook | Script |
|------|--------|
| Before Activate | `php artisan down` |
| After Activate | `php artisan up && php artisan queue:restart` |
| After Purge | `php artisan config:cache && php artisan route:cache` |

### Health Check Response

```php
// routes/web.php
Route::get('/health', function () {
    $checks = [
        'app' => true,
        'database' => DB::connection()->getPdo() ? true : false,
        'redis' => Redis::ping(),
        'storage' => is_writable(storage_path()),
    ];

    $healthy = !in_array(false, $checks);

    return response()->json([
        'status' => $healthy ? 'healthy' : 'unhealthy',
        'checks' => $checks,
        'version' => config('app.version'),
        'timestamp' => now()->toIso8601String(),
    ], $healthy ? 200 : 503);
});
```

## Laravel Forge

### Server Specs

| Configuration | Development | Production |
|--------------|-------------|-----------|
| Provider | DigitalOcean | AWS / Linode |
| Plan | 2GB / 1 CPU | 8GB / 4 CPU |
| OS | Ubuntu 22.04 | Ubuntu 22.04 |
| PHP | 8.3 | 8.3 |
| MySQL | 8.0 | 8.0 (RDS) |
| Redis | 7.x | 7.x (ElastiCache) |

### Forge Site Configuration

```yaml
# Nginx configuration
site:
  name: example.com
  web_directory: public
  php_version: "8.3"
  nginx:
    ssl: true
    http2: true
    security_headers: true
    client_max_body_size: 100M
    fastcgi_buffers: "16 16k"
    fastcgi_buffer_size: "32k"
```

## Laravel Vapor

### vapor.yml

```yaml
name: gsmui
id: xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx

environments:
  production:
    memory: 1024
    cli-memory: 512
    runtime: php-8.3-fpm
    warmup: true
    cache:
      enabled: true
      store: dynamodb
      prefix: gsmui-
    queue:
      memory: 512
      timeout: 60
      retries: 3
    database: gsmui-production
    redis: gsmui-production
    domain: example.com
    aliases:
      - www.example.com
    redirects:
      - /old-page
    logs:
      api: true
      scheduler: true
    cron: "* * * * *"

  staging:
    memory: 512
    cli-memory: 256
    runtime: php-8.3-fpm
    warmup: true
    database: gsmui-staging
    redis: gsmui-staging
    domain: staging.example.com
    cron: "*/5 * * * *"
```

## Infrastructure as Code

### Terraform (AWS)

```hcl
# main.tf
terraform {
  required_providers {
    aws = {
      source  = "hashicorp/aws"
      version = "~> 5.0"
    }
  }

  backend "s3" {
    bucket = "gsmui-terraform"
    key    = "production/terraform.tfstate"
    region = "us-east-1"
  }
}

module "vpc" {
  source  = "terraform-aws-modules/vpc/aws"
  version = "5.0"

  name = "gsmui-vpc"
  cidr = "10.0.0.0/16"

  azs             = ["us-east-1a", "us-east-1b", "us-east-1c"]
  private_subnets = ["10.0.1.0/24", "10.0.2.0/24", "10.0.3.0/24"]
  public_subnets  = ["10.0.101.0/24", "10.0.102.0/24", "10.0.103.0/24"]

  enable_nat_gateway = true
  single_nat_gateway = false
}

module "rds" {
  source  = "terraform-aws-modules/rds/aws"
  version = "6.0"

  identifier = "gsmui-production"

  engine         = "mysql"
  engine_version = "8.0"
  instance_class = "db.r6g.large"

  allocated_storage     = 100
  max_allocated_storage = 500

  db_name  = "gsmui"
  username = "admin"
  port     = 3306

  vpc_security_group_ids = [module.vpc.default_security_group_id]
  subnet_ids             = module.vpc.private_subnets

  backup_retention_period = 30
  multi_az               = true
  storage_encrypted      = true
}

module "elasticache" {
  source  = "terraform-aws-modules/elasticache/aws"
  version = "1.0"

  cluster_id = "gsmui-production"
  engine     = "redis"
  engine_version = "7.0"
  node_type  = "cache.r6g.large"
  num_cache_nodes = 1

  subnet_ids         = module.vpc.private_subnets
  security_group_ids = [module.vpc.default_security_group_id]
}
```

## Rollback Procedure

### Automated Rollback

```php
// Rollback command
class RollbackCommand extends Command
{
    protected $signature = 'deploy:rollback {--releases=1 : Number of releases to rollback}';

    public function handle(): int
    {
        $releases = collect(scandir($this->releasesDir))
            ->filter(fn($d) => !in_array($d, ['.', '..']))
            ->sort()->values();

        $currentLink = readlink($this->currentLink);
        $currentIndex = $releases->search(basename($currentLink));

        if ($currentIndex === 0) {
            $this->error('No previous release to rollback to.');
            return 1;
        }

        $previousRelease = $releases[$currentIndex - 1];
        $previousPath = $this->releasesDir . '/' . $previousRelease;

        // Atomic symlink switch
        symlink($previousPath, $this->currentLink . '.tmp');
        rename($this->currentLink . '.tmp', $this->currentLink);

        // Restart services
        $this->call('queue:restart');
        $this->call('config:cache');

        $this->info("Rolled back to: $previousRelease");
        return 0;
    }
}
```

## Acceptance Criteria

- [ ] Deployments complete with zero user-facing downtime
- [ ] Atomic symlink switching prevents partial deployments
- [ ] Health checks verify application health before traffic switch
- [ ] Rollback restores previous version in under 2 minutes
- [ ] Database migrations are backward-compatible
- [ ] Queue workers restart after deployment
- [ ] Old releases are pruned automatically
- [ ] Shared storage persists across deployments
- [ ] Environment variables are not overwritten during deploy
- [ ] Deployment logs capture all commands and output
