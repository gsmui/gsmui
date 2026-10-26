# Unit Testing

> PRD — Volume 23: Quality Assurance — Unit Testing

## Overview

This document defines the unit testing strategy for the gsmui platform using PHPUnit, including test structure, mocking, factories, code coverage, and CI integration.

## Objectives

| Goal | Metric | Target |
|------|--------|--------|
| Code coverage | Line coverage percentage | 80%+ |
| Test execution | Full unit test suite time | < 2 minutes |
| Test reliability | Flaky test rate | < 1% |
| Test pass rate | Tests passing on main branch | 100% |
| Test maintainability | Tests updated with code changes | 100% |

## PHPUnit Setup

### Configuration

```xml
<!-- phpunit.xml -->
<phpunit xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
         xsi:noNamespaceSchemaLocation="vendor/phpunit/phpunit/phpunit.xsd"
         bootstrap="vendor/autoload.php"
         colors="true"
         failOnRisky="true"
         failOnWarning="true"
         beStrictAboutTestsThatDoNotTestAnything="true"
         beStrictAboutOutputDuringTests="true"
         beStrictAboutTodoAnnotatedTests="true"
         cacheDirectory=".phpunit.cache">

    <testsuites>
        <testsuite name="Unit">
            <directory>tests/Unit</directory>
        </testsuite>
        <testsuite name="Feature">
            <directory>tests/Feature</directory>
        </testsuite>
        <testsuite name="Architecture">
            <file>tests/Architecture</file>
        </testsuite>
    </testsuites>

    <source>
        <include>
            <directory suffix=".php">app</directory>
            <directory suffix=".php">src</directory>
        </include>
    </source>

    <coverage>
        <report>
            <html outputDirectory="coverage-html"/>
            <clover outputFile="coverage.xml"/>
            <text outputFile="php://stdout" showUncoveredFiles="true"/>
        </report>
    </coverage>

    <php>
        <env name="APP_ENV" value="testing"/>
        <env name="DB_CONNECTION" value="sqlite"/>
        <env name="DB_DATABASE" value=":memory:"/>
        <env name="CACHE_DRIVER" value="array"/>
        <env name="QUEUE_CONNECTION" value="sync"/>
        <env name="SESSION_DRIVER" value="array"/>
        <env name="MAIL_MAILER" value="array"/>
        <env name="BROADCAST_DRIVER" value="log"/>
    </php>
</phpunit>
```

### Base TestCase

```php
namespace Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\WithFaker;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutExceptionHandling();
    }

    protected function actingAsAdmin(): static
    {
        $admin = User::factory()->admin()->create();
        $this->actingAs($admin);

        return $this;
    }

    protected function jsonRequest(string $method, string $uri, array $data = []): \Illuminate\Testing\TestResponse
    {
        return $this->json($method, $uri, $data, [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ]);
    }
}
```

## Test Structure

### Directory Structure

```
tests/
├── Unit/
│   ├── Models/
│   │   ├── UserTest.php
│   │   ├── PostTest.php
│   │   └── PageTest.php
│   ├── Services/
│   │   ├── SeoServiceTest.php
│   │   ├── MediaServiceTest.php
│   │   └── CacheServiceTest.php
│   ├── Jobs/
│   │   ├── ProcessImageTest.php
│   │   └── SendEmailTest.php
│   ├── Events/
│   │   └── UserRegisteredTest.php
│   ├── Notifications/
│   │   └── WelcomeNotificationTest.php
│   └── Support/
│       ├── HelpersTest.php
│       └── CollectionTest.php
├── Feature/
│   ├── Http/
│   │   ├── Controllers/
│   │   ├── Livewire/
│   │   └── Middleware/
│   └── ...
├── Architecture/
│   └── ArchTest.php
├── Browser/
│   └── ...
├── CreatesApplication.php
└── TestCase.php
```

### Test Naming Convention

```php
class UserTest extends TestCase
{
    /** @test */
    public function it_can_create_a_user(): void
    {
        // Arrange, Act, Assert
    }

    /** @test */
    public function it_requires_a_name(): void
    {
        // ...
    }

    /** @test */
    public function it_can_have_posts(): void
    {
        // ...
    }

    /** @test */
    public function it_soft_deletes_when_removed(): void
    {
        // ...
    }
}
```

## Mocking

### Mock Types

| Type | Use Case | Method |
|------|----------|--------|
| Service Mock | Replace service dependencies | `$this->mock()` |
| Facade Mock | Mock static facade calls | `Facade::fake()` |
| Event Fake | Capture dispatched events | `Event::fake()` |
| Mail Fake | Capture sent mail | `Mail::fake()` |
| Queue Fake | Capture dispatched jobs | `Queue::fake()` |
| Storage Fake | Mock filesystem | `Storage::fake()` |
| HTTP Fake | Mock HTTP requests | `Http::fake()` |
| Notification Fake | Capture notifications | `Notification::fake()` |

### Mock Examples

```php
class PostTest extends TestCase
{
    public function test_it_sends_notification_on_publish(): void
    {
        Notification::fake();

        $post = Post::factory()->draft()->create();
        $post->publish();

        Notification::assertSentTo(
            $post->author,
            PostPublishedNotification::class
        );
    }

    public function test_it_dispatches_image_processing_job(): void
    {
        Queue::fake();

        $media = Media::factory()->image()->create();

        ProcessImage::dispatch($media);

        Queue::assertPushed(ProcessImage::class, function ($job) use ($media) {
            return $job->mediaId === $media->id;
        });
    }

    public function test_it_makes_http_request_to_webhook(): void
    {
        Http::fake([
            'webhook.example.com/*' => Http::response(['status' => 'ok'], 200),
        ]);

        $this->post('/api/webhooks/test');

        Http::assertSent(function ($request) {
            return $request->url() === 'webhook.example.com/hooks/test';
        });
    }
}
```

## Factories

### Factory Definition

```php
class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
            'role' => 'user',
        ];
    }

    public function admin(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'admin',
        ]);
    }

    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
```

### Factory Usage

```php
// Create single model
$user = User::factory()->create();

// Create with overrides
$user = User::factory()->create(['name' => 'John']);

// Create with relations
$post = Post::factory()
    ->for(User::factory()->admin())
    ->withCategories(3)
    ->create();

// Create multiple
$users = User::factory()->count(10)->create();

// Create and persist
$user = User::factory()->createOne();
```

## Code Coverage

### Coverage Configuration

| Metric | Target | Blocking |
|--------|--------|----------|
| Line coverage | 80% | Warning |
| Branch coverage | 75% | Warning |
| Function coverage | 90% | Warning |
| Class coverage | 95% | Warning |

### Coverage Report Commands

```bash
# Generate HTML report
vendor/bin/phpunit --coverage-html=coverage-html

# Generate Clover XML (for CI)
vendor/bin/phpunit --coverage-clover=coverage.xml

# Generate text summary
vendor/bin/phpunit --coverage-text

# Coverage for specific directory
vendor/bin/phpunit --coverage-html=coverage-html --coverage-filter=app/Models
```

## CI Integration

### GitHub Actions Workflow

```yaml
name: Unit Tests

on:
  push:
    branches: [main, develop]
  pull_request:
    branches: [main]

jobs:
  test:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v4
      - uses: shivammathur/setup-php@v2
        with:
          php-version: '8.3'
          coverage: xdebug
      - name: Install Dependencies
        run: composer install --prefer-dist --no-progress
      - name: Run Unit Tests
        run: vendor/bin/phpunit --testsuite=Unit --coverage-clover=coverage.xml
      - name: Upload Coverage
        uses: codecov/codecov-action@v3
        with:
          file: coverage.xml
```

## Acceptance Criteria

- [ ] All unit tests run in under 2 minutes
- [ ] Code coverage meets 80% minimum threshold
- [ ] Tests use factories for model creation
- [ ] External services are mocked appropriately
- [ ] Test naming follows `it_can_*` convention
- [ ] Tests are isolated (no shared state)
- [ ] Database is reset between tests (RefreshDatabase)
- [ ] CI fails on test failures
- [ ] Coverage reports upload to Codecov
- [ ] Flaky tests are quarantined and fixed
