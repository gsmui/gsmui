# GsmUi Platform

The complete Laravel UI ecosystem - a platform for components, templates, documentation, and developer tools.

## Requirements

- PHP 8.2+
- Laravel 11+
- Node.js 18+
- SQLite/MySQL/PostgreSQL

## Installation

```bash
cd platform

# Install PHP dependencies
composer install

# Install JS dependencies
npm install

# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate

# Run migrations
php artisan migrate

# Seed database
php artisan db:seed

# Build assets
npm run dev

# Start development server
php artisan serve
```

## Default Users

After seeding, you can log in with:

- **Admin**: admin@gsmui.dev / password
- **Editor**: editor@gsmui.dev / password
- **User**: user@gsmui.dev / password

## Architecture

### Directory Structure

```
platform/
├── app/
│   ├── Http/
│   │   ├── Controllers/     # Web & API controllers
│   │   ├── Livewire/        # Livewire components
│   │   └── Middleware/       # HTTP middleware
│   ├── Models/              # Eloquent models
│   ├── Providers/           # Service providers
│   └── Services/            # Business logic
├── config/                  # Configuration files
├── database/
│   ├── migrations/          # Database migrations
│   └── seeders/             # Database seeders
├── resources/
│   ├── css/                 # Stylesheets (Tailwind)
│   ├── js/                  # JavaScript (Alpine.js)
│   └── views/
│       ├── layouts/         # Blade layouts
│       ├── livewire/        # Livewire views
│       └── pages/           # Page views
└── routes/                  # Route files
```

### Key Features

- **Authentication**: Laravel Fortify with email verification, 2FA
- **Authorization**: Spatie Laravel Permission (roles & permissions)
- **Admin Panel**: Livewire-based admin dashboard
- **User Dashboard**: Projects, favorites, downloads, profile
- **Theme System**: CSS variables with light/dark mode
- **Design Tokens**: Consistent spacing, colors, typography

### Models

- User, UserProfile
- Component, ComponentCategory, ComponentVersion, ComponentReview
- Theme, ThemeVariation
- Template, TemplateCategory, TemplateReview
- Post, PostCategory, Comment
- Showcase
- Subscription, Invoice
- Project, ApiKey, UserNotification

### Routes

- `/` - Marketing home page
- `/components` - Component library
- `/templates` - Template marketplace
- `/docs` - Documentation
- `/blog` - Blog posts
- `/showcase` - Community showcase
- `/playground` - Interactive playground
- `/pricing` - Pricing page
- `/admin/*` - Admin panel (admin only)
- `/dashboard/*` - User dashboard (authenticated)
- `/api/*` - REST API (Sanctum)

## Development

```bash
# Run tests
php artisan test

# Run PHPStan
vendor/bin/phpstan analyse

# Format code
./vendor/bin/pint
```

## License

Proprietary - All rights reserved.
