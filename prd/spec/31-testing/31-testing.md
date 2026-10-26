# 31 — Testing

## Purpose

Define the testing strategy for GsmUi, covering unit tests, feature tests, browser tests, and code quality tools.

## Technology Stack

| Type | Tool |
|---|---|
| Unit Tests | PHPUnit |
| Feature Tests | PHPUnit + Laravel |
| Browser Tests | Playwright |
| Code Coverage | PHPUnit Coverage |
| Code Quality | PHPStan, PHP CS Fixer |
| Mocking | Mockery |

## Test Structure

```text
tests/
├── Unit/
│   ├── Models/
│   ├── Services/
│   ├── Actions/
│   └── Helpers/
├── Feature/
│   ├── Auth/
│   ├── Marketplace/
│   ├── Billing/
│   ├── Admin/
│   └── API/
├── Browser/
│   ├── auth/
│   ├── marketplace/
│   └── admin/
└── TestCase.php
```

## Unit Tests

### Model Tests

```php
// tests/Unit/Models/UserTest.php

class UserTest extends TestCase
{
    public function test_user_has_roles(): void
    {
        $user = User::factory()->create();
        $user->assignRole('user');

        $this->assertTrue($user->hasRole('user'));
    }

    public function test_user_can_be_suspended(): void
    {
        $user = User::factory()->create();
        $user->suspend('Test reason');

        $this->assertTrue($user->isSuspended());
    }
}
```

### Service Tests

```php
// tests/Unit/Services/OrderServiceTest.php

class OrderServiceTest extends TestCase
{
    public function test_order_can_be_completed(): void
    {
        $order = Order::factory()->create(['status' => 'pending']);
        $service = new OrderService();

        $service->completeOrder($order);

        $this->assertEquals('completed', $order->fresh()->status);
    }
}
```

## Feature Tests

### Authentication Tests

```php
// tests/Feature/Auth/RegistrationTest.php

class RegistrationTest extends TestCase
{
    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');
        $response->assertStatus(200);
    }

    public function test_new_users_can_register(): void
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'terms' => true,
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect('/dashboard');
    }

    public function test_email_is_required(): void
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => '',
            'password' => 'password',
            'password_confirmation' => 'password',
            'terms' => true,
        ]);

        $response->assertSessionHasErrors('email');
    }
}
```

### API Tests

```php
// tests/Feature/Api/ThemeApiTest.php

class ThemeApiTest extends TestCase
{
    public function test_themes_can_be_listed(): void
    {
        $token = $this->createApiToken(['themes:read']);

        $response = $this->withToken($token)
            ->getJson('/api/v1/themes');

        $response->assertOk();
    }

    public function test_themes_require_auth(): void
    {
        $response = $this->getJson('/api/v1/themes');
        $response->assertUnauthorized();
    }
}
```

## Browser Tests

```javascript
// tests/Browser/auth/login.spec.js

const { test, expect } = require('@playwright/test');

test.describe('Login', () => {
    test('user can login', async ({ page }) => {
        await page.goto('/login');
        await page.fill('[name="email"]', 'test@example.com');
        await page.fill('[name="password"]', 'password');
        await page.click('button[type="submit"]');
        await expect(page).toHaveURL('/dashboard');
    });
});
```

## Code Quality

### PHPStan

```bash
# config/phpstan.neon
parameters:
    level: 8
    paths:
        - app
    ignoreErrors: []
```

### PHP CS Fixer

```php
// .php-cs-fixer.php

return (new PhpCsFixer\Config())
    ->setRules([
        '@PER-CS2.0' => true,
        'array_syntax' => ['syntax' => 'short'],
        'no_unused_imports' => true,
        'ordered_imports' => ['sort_algorithm' => 'alpha'],
    ])
    ->setFinder(
        PhpCsFixer\Finder::create()
            ->in('app')
            ->in('tests')
    );
```

## Test Commands

```bash
# Run all tests
php artisan test

# Run with coverage
php artisan test --coverage --min=80

# Run specific test
php artisan test --filter=RegistrationTest

# Run browser tests
npx playwright test
```

## Test Coverage Targets

| Area | Target |
|---|---|
| Models | 90% |
| Services | 85% |
| Actions | 85% |
| Controllers | 80% |
| Livewire | 80% |
| Overall | 80% |
