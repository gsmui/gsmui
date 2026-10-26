# Project Structure

> PRD — Volume 24: Developer Guide — Folder Structure

## Overview

This document defines the project structure for the gsmui platform including `app/` layout, module structure, domain organization, and configuration files.

## Directory Structure

```
gsmui/
├── app/
│   ├── Actions/
│   │   ├── Auth/
│   │   ├── Blog/
│   │   ├── Media/
│   │   └── Pages/
│   ├── Console/
│   │   ├── Commands/
│   │   └── Kernel.php
│   ├── Contracts/
│   │   ├── Repositories/
│   │   ├── Services/
│   │   └── Events/
│   ├── Enums/
│   │   ├── PostStatus.php
│   │   ├── PageType.php
│   │   └── UserRole.php
│   ├── Events/
│   │   ├── Blog/
│   │   ├── Media/
│   │   └── Pages/
│   ├── Exceptions/
│   │   ├── Handler.php
│   │   └── Exceptions.php
│   ├── Http/
│   │   ├── Controllers/
│   │   ├── Livewire/
│   │   ├── Middleware/
│   │   └── Requests/
│   ├── Jobs/
│   │   ├── Blog/
│   │   ├── Media/
│   │   └── Queue/
│   ├── Listeners/
│   │   ├── Blog/
│   │   └── Pages/
│   ├── Mail/
│   │   ├── Blog/
│   │   └── User/
│   ├── Models/
│   │   ├── Concerns/
│   │   ├── Post.php
│   │   ├── Page.php
│   │   └── User.php
│   ├── Notifications/
│   │   ├── Blog/
│   │   └── User/
│   ├── Observers/
│   │   ├── PostObserver.php
│   │   └── PageObserver.php
│   ├── Policies/
│   │   ├── PostPolicy.php
│   │   └── PagePolicy.php
│   ├── Providers/
│   │   ├── AppServiceProvider.php
│   │   └── EventServiceProvider.php
│   ├── Repositories/
│   │   ├── Contracts/
│   │   ├── Eloquent/
│   │   └── Cache/
│   └── Services/
│       ├── SeoService.php
│       ├── MediaService.php
│       └── CacheService.php
├── config/
│   ├── app.php
│   ├── auth.php
│   ├── blog.php
│   ├── cache.php
│   ├── database.php
│   ├── gsmui.php
│   ├── media.php
│   ├── pages.php
│   ├── queue.php
│   ├── seo.php
│   └── services.php
├── database/
│   ├── factories/
│   ├── migrations/
│   ├── seeders/
│   └── testdata/
├── docs/
│   ├── 21-cms/
│   ├── 22-devops/
│   ├── 23-testing/
│   └── 24-developer/
├── docker/
│   ├── nginx/
│   ├── php/
│   └── supervisor/
├── public/
│   ├── build/
│   ├── css/
│   ├── images/
│   └── index.php
├── resources/
│   ├── css/
│   ├── js/
│   ├── views/
│   │   ├── components/
│   │   ├── layouts/
│   │   ├── livewire/
│   │   └── pages/
│   └── lang/
├── routes/
│   ├── api.php
│   ├── channels.php
│   ├── console.php
│   └── web.php
├── storage/
│   ├── app/
│   ├── framework/
│   └── logs/
├── stubs/
│   ├── config/
│   └── resources/
├── tests/
│   ├── Architecture/
│   ├── Browser/
│   ├── Feature/
│   ├── Unit/
│   ├── CreatesApplication.php
│   └── TestCase.php
├── .env.example
├── .gitignore
├── composer.json
├── docker-compose.yml
├── Dockerfile
├── package.json
├── phpunit.xml
├── pint.json
├── README.md
└── vite.config.js
```

## Module Organization

### By Feature (Recommended)

```
app/
├── Blog/
│   ├── Actions/
│   ├── Events/
│   ├── Http/
│   ├── Jobs/
│   ├── Listeners/
│   ├── Mail/
│   ├── Models/
│   ├── Observers/
│   ├── Policies/
│   └── Services/
├── Pages/
│   ├── Actions/
│   ├── Events/
│   ├── Http/
│   ├── Jobs/
│   ├── Listeners/
│   ├── Mail/
│   ├── Models/
│   ├── Observers/
│   ├── Policies/
│   └── Services/
└── Media/
    ├── Actions/
    ├── Events/
    ├── Http/
    ├── Jobs/
    ├── Listeners/
    ├── Mail/
    ├── Models/
    ├── Observers/
    ├── Policies/
    └── Services/
```

### By Layer (Traditional)

```
app/
├── Http/
│   ├── Controllers/
│   ├── Livewire/
│   ├── Middleware/
│   └── Requests/
├── Models/
├── Services/
├── Repositories/
├── Events/
├── Listeners/
├── Jobs/
└── Mail/
```

## Namespace Mapping

| Directory | Namespace | Example |
|-----------|-----------|---------|
| `app/Actions/` | `App\Actions\` | `App\Actions\Blog\CreatePost` |
| `app/Console/` | `App\Console\` | `App\Console\Commands\SendDigest` |
| `app/Enums/` | `App\Enums\` | `App\Enums\PostStatus` |
| `app/Events/` | `App\Events\` | `App\Events\Blog\PostPublished` |
| `app/Http/` | `App\Http\` | `App\Http\Controllers\PostsController` |
| `app/Jobs/` | `App\Jobs\` | `App\Jobs\Blog\ProcessImage` |
| `app/Listeners/` | `App\Listeners\` | `App\Listeners\Blog\NotifySubscribers` |
| `app/Mail/` | `App\Mail\` | `App\Mail\Blog\PostPublishedMail` |
| `app/Models/` | `App\Models\` | `App\Models\Post` |
| `app/Notifications/` | `App\Notifications\` | `App\Notifications\Blog\PostNotification` |
| `app/Policies/` | `App\Policies\` | `App\Policies\PostPolicy` |
| `app/Services/` | `App\Services\` | `App\Services\SeoService` |

## Configuration Files

| File | Purpose |
|------|---------|
| `config/app.php` | Application name, URL, timezone |
| `config/auth.php` | Authentication guards and providers |
| `config/blog.php` | Blog settings, post types, comments |
| `config/cache.php` | Cache stores and prefixes |
| `config/database.php` | Database connections |
| `config/gsmui.php` | GSmui package configuration |
| `config/media.php` | Media library settings |
| `config/pages.php` | Page types and templates |
| `config/queue.php` | Queue connections and workers |
| `config/seo.php` | SEO defaults and sitemap |
| `config/services.php` | Third-party service credentials |

## Acceptance Criteria

- [ ] Directory structure follows Laravel conventions
- [ ] Feature modules are clearly separated
- [ ] Namespaces match directory structure
- [ ] Config files are organized by domain
- [ ] Tests mirror `app/` structure
- [ ] Shared code lives in `app/Support/`
- [ ] Contracts/interfaces in `app/Contracts/`
- [ ] Enums in `app/Enums/`
- [ ] Documentation in `docs/`
- [ ] Docker configs in `docker/`
