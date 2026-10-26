# Coding Standards

> PRD — Volume 24: Developer Guide — Coding Standards

## Overview

This document defines coding standards for the gsmui platform including PSR-12 compliance, Laravel conventions, PHP 8.3+ features, type declarations, and strict typing.

## Objectives

| Goal | Metric | Target |
|------|--------|--------|
| PSR-12 compliance | Code style violations | 0 |
| PHPStan level | Static analysis level | 8 |
| Type coverage | Files with strict types | 100% |
| Return types | Functions with return types | 100% |
| Code consistency | Naming convention adherence | 100% |

## PSR-12 Compliance

### File Structure

```php
<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    // ...
}
```

### Key Rules

| Rule | Description |
|------|-------------|
| `<?php` tag | Always required |
| `declare(strict_types=1)` | Always on second line |
| Namespace | One blank line after `declare` |
| Imports | Alphabetical, one per line |
| Class braces | Opening on same line |
| Method braces | Opening on next line |
| Visibility | Always explicit |
| One blank line | After method opening brace |

## Laravel Conventions

### Naming

| Element | Convention | Example |
|---------|-----------|---------|
| Models | Singular, PascalCase | `Post`, `UserProfile` |
| Controllers | Plural, PascalCase | `PostsController` |
| Migrations | Snake case, timestamped | `2026_01_01_create_posts_table` |
| Routes | kebab-case | `/blog-posts/{slug}` |
| Variables | camelCase | `$postTitle` |
| Methods | camelCase | `getPostTitle()` |
| Properties | camelCase | `$postTitle` |
| Constants | UPPER_SNAKE_CASE | `MAX_LOGIN_ATTEMPTS` |
| Config | snake_case | `posts.per_page` |

### Model Conventions

```php
class Post extends Model
{
    // 1. Traits
    use HasFactory, SoftDeletes;

    // 2. Constants
    const STATUS_DRAFT = 'draft';
    const STATUS_PUBLISHED = 'published';

    // 3. Properties
    protected $fillable = ['title', 'slug', 'content'];
    protected $casts = ['published_at' => 'datetime'];
    protected $appends = ['reading_time'];

    // 4. Relationships (alphabetical)
    public function author(): BelongsTo { /* ... */ }
    public function categories(): BelongsToMany { /* ... */ }
    public function comments(): HasMany { /* ... */ }

    // 5. Scopes (alphabetical)
    public function scopeByCategory(Builder $query, string $category): Builder { /* ... */ }
    public function scopePublished(Builder $query): Builder { /* ... */ }

    // 6. Accessors & Mutators
    protected function readingTime(): Attribute { /* ... */ }

    // 7. Public methods
    public function publish(): void { /* ... */ }

    // 8. Protected/Private methods
    protected function generateSlug(): string { /* ... */ }
}
```

### Controller Conventions

```php
class PostsController extends Controller
{
    // 1. Constructor (dependency injection)
    public function __construct(
        protected PostRepository $posts,
    ) {}

    // 2. Resource methods (index, show, create, store, edit, update, destroy)
    public function index(): View
    {
        // ...
    }

    public function show(Post $post): View
    {
        // ...
    }

    public function store(StorePostRequest $request): RedirectResponse
    {
        // ...
    }

    // 3. Custom methods
    public function publish(Post $post): RedirectResponse
    {
        // ...
    }
}
```

## PHP 8.3+ Features

### Typed Properties

```php
class User extends Model
{
    public string $name;
    public string $email;
    public ?Carbon $email_verified_at = null;
    protected int $loginAttempts = 0;
    private readonly string $token;
}
```

### Readonly Properties

```php
class PostDTO
{
    public function __construct(
        public readonly int $id,
        public readonly string $title,
        public readonly string $slug,
        public readonly Carbon $createdAt,
    ) {}
}
```

### Enums

```php
enum PostStatus: string
{
    case Draft = 'draft';
    case Published = 'published';
    case Archived = 'archived';

    public function label(): string
    {
        return match ($this) {
            self::Draft => 'Draft',
            self::Published => 'Published',
            self::Archived => 'Archived',
        };
    }

    public function isPublishable(): bool
    {
        return $this === self::Draft;
    }
}
```

### Match Expressions

```php
public function getRedirectUrl(Post $post): string
{
    return match ($post->status) {
        PostStatus::Draft => '/admin/posts/' . $post->id . '/edit',
        PostStatus::Published => '/blog/' . $post->slug,
        PostStatus::Archived => '/blog/archive',
    };
}
```

### Named Arguments

```php
$post = Post::factory()->create(
    title: 'My Post',
    slug: 'my-post',
    status: PostStatus::Published,
);
```

### First-class Callable Syntax

```php
$callback = $this->handleError(...);
Collection::times(5, fn () => fake()->name());
```

### Fiber (Advanced)

```php
$fiber = new Fiber(function (): void {
    $result = doExpensiveCalculation();
    Fiber::suspend($result);
});

$value = $fiber->start();
```

## Type Declarations

### Strict Types

```php
<?php

declare(strict_types=1);

function calculateTotal(float $price, int $quantity): float
{
    return $price * $quantity;
}
```

### Return Types

```php
// Always declare return types
public function getName(): string { /* ... */ }
public function getPosts(): Collection { /* ... */ }
public function isActive(): bool { /* ... */ }
public function calculateTotal(): float { /* ... */ }
public function processData(): array { /* ... */ }
```

### Parameter Types

```php
public function createPost(
    string $title,
    string $slug,
    ?string $excerpt = null,
    PostStatus $status = PostStatus::Draft,
): Post {
    // ...
}
```

### Union Types

```php
public function getValue(): int|string
{
    return $this->value;
}

public function processInput(int|string $input): string
{
    return match (true) {
        is_int($input) => "Number: {$input}",
        is_string($input) => "Text: {$input}",
    };
}
```

### Intersection Types

```php
public function getData(): HasId&HasTimestamps
{
    return $this->model;
}
```

## Code Style Tools

### PHP CS Fixer

```php
// .php-cs-fixer.php
return (new PhpCsFixer\Config())
    ->setRules([
        '@PER-CS2.0' => true,
        '@PER-CS2.0:risky' => true,
        '@PHP83Migration' => true,
        'array_syntax' => ['syntax' => 'short'],
        'ordered_imports' => ['sort_algorithm' => 'alpha'],
        'no_unused_imports' => true,
        'single_quote' => true,
        'trailing_comma_in_multiline' => true,
    ])
    ->setFinder(
        PhpCsFixer\Finder::create()
            ->in(__DIR__ . '/app')
            ->in(__DIR__ . '/src')
            ->in(__DIR__ . '/tests')
    );
```

### PHPStan

```php
// phpstan.neon
parameters:
    level: 8
    paths:
        - app
        - src
    treatPhpDocTypesAsCertain: false
    reportUnmatchedIgnoredErrors: true
```

### Laravel Pint

```bash
# Fix code style
vendor/bin/pint

# Dry run (check only)
vendor/bin/pint --test

# Fix specific path
vendor/bin/pint app/Models
```

## Acceptance Criteria

- [ ] All files have `declare(strict_types=1)`
- [ ] PSR-12 coding standard is followed
- [ ] PHPStan level 8 passes with 0 errors
- [ ] All functions have return type declarations
- [ ] All parameters have type declarations
- [ ] PHP 8.3+ features used where appropriate
- [ ] Enums used for fixed sets of values
- [ ] Readonly properties used for immutable data
- [ ] Laravel naming conventions are followed
- [ ] PHP CS Fixer passes with 0 violations
