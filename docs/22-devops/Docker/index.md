# Docker Setup

> PRD — Volume 22: DevOps — Docker

## Overview

This document defines the Docker configuration for the gsmui platform, including development and production Dockerfiles, docker-compose orchestration, multi-stage builds, volume management, and environment-specific configurations.

## Objectives

| Goal | Metric | Target |
|------|--------|--------|
| Image size | Production image size | < 200MB |
| Build time | Full build from cache | < 2 minutes |
| Start time | Container ready to serve | < 10 seconds |
| Security | CVE vulnerabilities in base image | 0 critical |
| Reproducibility | Identical builds across environments | 100% |

## Project Structure

```
.
├── docker/
│   ├── nginx/
│   │   ├── Dockerfile
│   │   └── nginx.conf
│   ├── php/
│   │   ├── Dockerfile
│   │   ├── php.ini
│   │   └── opcache.ini
│   ├── node/
│   │   └── Dockerfile
│   ├── postgres/
│   │   └── init.sql
│   └── redis/
│       └── redis.conf
├── docker-compose.yml
├── docker-compose.prod.yml
├── .dockerignore
└── Dockerfile
```

## Production Dockerfile (Multi-Stage)

### Stage 1: Build Assets

```dockerfile
FROM node:20-alpine AS frontend
WORKDIR /app
COPY package*.json ./
RUN npm ci --prefer-offline
COPY . .
RUN npm run build
```

### Stage 2: PHP Dependencies

```dockerfile
FROM composer:2 AS dependencies
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --no-autoloader --prefer-dist
COPY . .
RUN composer dump-autoload --optimize --no-dev
```

### Stage 3: Production Image

```dockerfile
FROM php:8.3-fpm-alpine AS production

RUN apk add --no-cache \
    nginx \
    supervisor \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    libzip-dev \
    oniguruma-dev \
    icu-dev \
    libxml2-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install \
        pdo_mysql \
        mbstring \
        exif \
        bcmath \
        dom \
        zip \
        opcache \
        pcntl \
        intl \
    && pecl install redis \
    && docker-php-ext-enable redis

COPY docker/php/php.ini /usr/local/etc/php/php.ini
COPY docker/php/opcache.ini /usr/local/etc/php/conf.d/opcache.ini

WORKDIR /var/www/html

COPY --from=dependencies /app/vendor vendor/
COPY --from=frontend /app/public/build public/build/
COPY . .

RUN chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

COPY docker/nginx/nginx.conf /etc/nginx/http.d/default.conf
COPY docker/supervisor/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

EXPOSE 80
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
```

## Development docker-compose.yml

```yaml
version: '3.8'

services:
  app:
    build:
      context: .
      dockerfile: docker/php/Dockerfile
      target: development
    container_name: gsmui-app
    restart: unless-stopped
    working_dir: /var/www/html
    volumes:
      - .:/var/www/html
      - vendor:/var/www/html/vendor
      - node_modules:/var/www/html/node_modules
    ports:
      - "8000:8000"
    environment:
      - APP_ENV=local
      - APP_DEBUG=true
      - DB_CONNECTION=mysql
      - DB_HOST=mysql
      - DB_PORT=3306
      - DB_DATABASE=gsmui
      - DB_USERNAME=sail
      - DB_PASSWORD=password
      - REDIS_HOST=redis
      - CACHE_DRIVER=redis
      - SESSION_DRIVER=redis
      - QUEUE_CONNECTION=redis
    depends_on:
      mysql:
        condition: service_healthy
      redis:
        condition: service_healthy

  mysql:
    image: mysql:8.0
    container_name: gsmui-mysql
    restart: unless-stopped
    ports:
      - "3306:3306"
    environment:
      MYSQL_ROOT_PASSWORD: rootpassword
      MYSQL_DATABASE: gsmui
      MYSQL_USER: sail
      MYSQL_PASSWORD: password
    volumes:
      - mysql-data:/var/lib/mysql
    healthcheck:
      test: ["CMD", "mysqladmin", "ping", "-h", "localhost"]
      interval: 10s
      timeout: 5s
      retries: 5

  redis:
    image: redis:7-alpine
    container_name: gsmui-redis
    restart: unless-stopped
    ports:
      - "6379:6379"
    volumes:
      - redis-data:/data
    healthcheck:
      test: ["CMD", "redis-cli", "ping"]
      interval: 10s
      timeout: 5s
      retries: 5

  node:
    image: node:20-alpine
    container_name: gsmui-node
    working_dir: /var/www/html
    volumes:
      - .:/var/www/html
      - node_modules:/var/www/html/node_modules
    command: npm run dev
    ports:
      - "5173:5173"

  mailpit:
    image: axllent/mailpit
    container_name: gsmui-mailpit
    ports:
      - "1025:1025"
      - "8025:8025"

volumes:
  mysql-data:
  redis-data:
  vendor:
  node_modules:
```

## Production docker-compose.prod.yml

```yaml
version: '3.8'

services:
  app:
    build:
      context: .
      dockerfile: Dockerfile
      target: production
    container_name: gsmui-prod
    restart: always
    ports:
      - "80:80"
    environment:
      - APP_ENV=production
      - APP_DEBUG=false
      - DB_CONNECTION=mysql
      - DB_HOST=${DB_HOST}
      - DB_PORT=3306
      - DB_DATABASE=${DB_DATABASE}
      - DB_USERNAME=${DB_USERNAME}
      - DB_PASSWORD=${DB_PASSWORD}
      - REDIS_HOST=redis
      - CACHE_DRIVER=redis
      - SESSION_DRIVER=redis
      - QUEUE_CONNECTION=redis
    volumes:
      - storage:/var/www/html/storage
    healthcheck:
      test: ["CMD", "curl", "-f", "http://localhost/health"]
      interval: 30s
      timeout: 10s
      retries: 3

  nginx:
    image: nginx:alpine
    container_name: gsmui-nginx
    restart: always
    ports:
      - "443:443"
      - "80:80"
    volumes:
      - ./docker/nginx/nginx.prod.conf:/etc/nginx/nginx.conf:ro
      - storage:/var/www/html/storage:ro
      - certbot-conf:/etc/letsencrypt:ro
    depends_on:
      - app

  redis:
    image: redis:7-alpine
    container_name: gsmui-redis
    restart: always
    command: redis-server --appendonly yes --requirepass ${REDIS_PASSWORD}
    volumes:
      - redis-data:/data

  queue:
    build:
      context: .
      dockerfile: Dockerfile
      target: production
    container_name: gsmui-queue
    restart: always
    command: php artisan queue:work --sleep=3 --tries=3 --max-time=3600
    volumes:
      - storage:/var/www/html/storage
    environment:
      - QUEUE_CONNECTION=redis
    depends_on:
      - redis

  scheduler:
    build:
      context: .
      dockerfile: Dockerfile
      target: production
    container_name: gsmui-scheduler
    restart: always
    command: php artisan schedule:work
    volumes:
      - storage:/var/www/html/storage
    depends_on:
      - redis

volumes:
  storage:
  redis-data:
  certbot-conf:
```

## Volume Management

| Volume | Purpose | Persistence |
|--------|---------|-------------|
| `mysql-data` | Database storage | Persistent |
| `redis-data` | Cache/queue storage | Persistent |
| `storage` | Laravel storage directory | Persistent |
| `vendor` | PHP dependencies (dev) | Named |
| `node_modules` | Node dependencies (dev) | Named |

### Backup Strategy

```bash
# Database backup
docker exec gsmui-mysql mysqldump -u root -p gsmui > backup-$(date +%Y%m%d).sql

# Redis backup
docker exec gsmui-redis redis-cli BGSAVE

# Storage backup
docker run --rm -v gsmui_storage:/data -v $(pwd):/backup alpine tar czf /backup/storage-$(date +%Y%m%d).tar.gz /data
```

## Health Checks

| Service | Check | Interval | Timeout | Retries |
|---------|-------|----------|---------|---------|
| app | HTTP GET `/health` | 30s | 10s | 3 |
| mysql | `mysqladmin ping` | 10s | 5s | 5 |
| redis | `redis-cli ping` | 10s | 5s | 5 |
| nginx | HTTP GET `/` | 30s | 5s | 3 |

## Environment Variables

| Variable | Development | Production | Required |
|----------|------------|-----------|----------|
| `APP_ENV` | `local` | `production` | Yes |
| `APP_DEBUG` | `true` | `false` | Yes |
| `APP_KEY` | Auto-generated | Generated | Yes |
| `DB_HOST` | `mysql` | External host | Yes |
| `DB_DATABASE` | `gsmui` | External DB | Yes |
| `DB_USERNAME` | `sail` | External user | Yes |
| `DB_PASSWORD` | `password` | External pass | Yes |
| `REDIS_HOST` | `redis` | External host | Yes |
| `REDIS_PASSWORD` | — | Required | In production |

## .dockerignore

```
node_modules
vendor
storage/logs/*
storage/framework/cache/*
storage/framework/sessions/*
storage/framework/views/*
.env
.env.*
!.env.example
.git
.github
.vscode
.idea
tests
docs
*.md
docker-compose*.yml
```

## Acceptance Criteria

- [ ] Production image builds under 200MB
- [ ] Multi-stage build separates build and runtime dependencies
- [ ] Health checks verify all services are operational
- [ ] Volumes persist data across container restarts
- [ ] Environment variables configure all services per environment
- [ ] Docker Compose starts full stack in under 30 seconds
- [ ] Hot-reload works in development mode
- [ ] Queue workers restart automatically on failure
- [ ] SSL termination handles HTTPS in production
- [ ] Backup scripts capture database, Redis, and storage
