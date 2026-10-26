# Seeders

## Overview

GsmUi uses seeders for test data, demo data, and production setup. This document covers seeder strategy, factory patterns, test data, and production seeders.

## Seeder Strategy

### Environment Types

| Environment | Purpose | Data Source | Frequency |
|-------------|---------|-------------|-----------|
| Development | Local dev | Factories + Fixtures | On setup |
| Testing | PHPUnit | Factories | Each test |
| Staging | Pre-production | Fixtures + Production subset | On deploy |
| Production | Live | Production seeder | On setup |

### Seeder Organization

```php
// Database/Seeders/DatabaseSeeder.php
class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            // Core data
            RoleSeeder::class,
            PlanSeeder::class,
            CategorySeeder::class,
            
            // Only in development
            ...($this->isDev() ? [
                UserSeeder::class,
                ProductSeeder::class,
                OrderSeeder::class,
            ] : []),
        ]);
    }
    
    private function isDev(): bool
    {
        return app()->environment('local', 'testing');
    }
}
```

## Factory Patterns

### User Factory

```php
// database/factories/UserFactory.php
class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        return [
            'id' => Str::uuid7(),
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password_hash' => Hash::make('password'),
            'is_admin' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    public function admin(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_admin' => true,
        ]);
    }

    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    public function withProfile(): static
    {
        return $this->has(UserProfile::factory());
    }

    public function withOAuth(string $provider = 'github'): static
    {
        return $this->has(OAuthIdentity::factory()->state(['provider' => $provider]));
    }
}
```

### Product Factory

```php
// database/factories/ProductFactory.php
class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        $name = fake()->unique()->words(3, true);
        
        return [
            'id' => Str::uuid7(),
            'slug' => Str::slug($name),
            'name' => title_case($name),
            'tagline' => fake()->sentence(),
            'description' => fake()->paragraphs(3, true),
            'base_price' => fake()->numberBetween(0, 19900),
            'currency' => 'USD',
            'status' => 'draft',
            'is_featured' => fake()->boolean(20),
            'download_count' => fake()->numberBetween(0, 1000),
            'sales_count' => fake()->numberBetween(0, 500),
            'featured_image' => fake()->imageUrl(600, 400, 'products'),
            'license_type' => fake()->randomElement(['single', 'team', 'agency']),
            'created_by' => User::factory(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    public function published(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'published',
            'published_at' => now()->subDays(rand(1, 30)),
        ]);
    }

    public function featured(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_featured' => true,
        ]);
    }

    public function free(): static
    {
        return $this->state(fn (array $attributes) => [
            'base_price' => 0,
        ]);
    }

    public function withComponents(int $count = 3): static
    {
        return $this->has(Component::factory()->count($count));
    }

    public function withVariants(int $count = 2): static
    {
        return $this->has(ProductVariant::factory()->count($count));
    }
}
```

### Order Factory

```php
// database/factories/OrderFactory.php
class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition(): array
    {
        return [
            'id' => Str::uuid7(),
            'order_number' => $this->generateOrderNumber(),
            'user_id' => User::factory(),
            'status' => 'pending',
            'subtotal' => fake()->numberBetween(1000, 100000),
            'tax_amount' => 0,
            'discount_amount' => 0,
            'total' => fake()->numberBetween(1000, 100000),
            'currency' => 'USD',
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    public function pending(): static
    {
        return $this->state(['status' => 'pending']);
    }

    public function processing(): static
    {
        return $this->state(['status' => 'processing']);
    }

    public function fulfilled(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'fulfilled',
            'placed_at' => now()->subDays(rand(1, 7)),
            'fulfilled_at' => now()->subHours(rand(1, 24)),
        ]);
    }

    public function cancelled(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'cancelled',
            'cancelled_at' => now()->subDays(rand(1, 7)),
        ]);
    }

    public function withItems(int $count = 2): static
    {
        return $this->has(OrderItem::factory()->count($count));
    }

    public function withPayment(): static
    {
        return $this->has(Payment::factory()->succeeded());
    }

    private function generateOrderNumber(): string
    {
        return 'GSMUI-' . strtoupper(uniqid());
    }
}
```

### License Factory

```php
// database/factories/LicenseFactory.php
class LicenseFactory extends Factory
{
    protected $model = License::class;

    public function definition(): array
    {
        return [
            'id' => Str::uuid7(),
            'license_key' => $this->generateLicenseKey(),
            'user_id' => User::factory(),
            'product_id' => Product::factory(),
            'order_id' => Order::factory(),
            'status' => 'active',
            'download_count' => fake()->numberBetween(0, 5),
            'max_downloads' => 10,
            'activated_at' => now(),
            'expires_at' => now()->addYear(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    public function active(): static
    {
        return $this->state(['status' => 'active']);
    }

    public function expired(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'expired',
            'expires_at' => now()->subDay(),
        ]);
    }

    public function revoked(): static
    {
        return $this->state(['status' => 'revoked']);
    }

    private function generateLicenseKey(): string
    {
        $segments = [];
        for ($i = 0; $i < 4; $i++) {
            $segments[] = strtoupper(bin2hex(random_bytes(2)));
        }
        return 'GSMUI-' . implode('-', $segments);
    }
}
```

## Production Seeders

### Plan Seeder

```php
// database/seeders/PlanSeeder.php
class PlanSeeder extends Seeder
{
    public function run(): void
    {
        $plans = [
            [
                'id' => Str::uuid7(),
                'name' => 'Free',
                'slug' => 'free',
                'description' => 'Perfect for trying out GsmUi components.',
                'monthly_price' => 0,
                'annual_price' => 0,
                'max_downloads' => 5,
                'features' => ['5 downloads/month', 'Community support', 'Basic components'],
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'id' => Str::uuid7(),
                'name' => 'Pro',
                'slug' => 'pro',
                'description' => 'For professional developers and small teams.',
                'monthly_price' => 2900,
                'annual_price' => 29000,
                'max_downloads' => 50,
                'features' => ['50 downloads/month', 'Priority support', 'All components', 'Early access'],
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'id' => Str::uuid7(),
                'name' => 'Team',
                'slug' => 'team',
                'description' => 'For teams and agencies.',
                'monthly_price' => 7900,
                'annual_price' => 79000,
                'max_downloads' => 200,
                'features' => ['200 downloads/month', 'Dedicated support', 'All components', 'Custom branding', 'API access'],
                'is_active' => true,
                'sort_order' => 3,
            ],
        ];

        foreach ($plans as $plan) {
            Plan::updateOrCreate(
                ['slug' => $plan['slug']],
                $plan
            );
        }
    }
}
```

### Category Seeder

```php
// database/seeders/CategorySeeder.php
class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'UI Kits', 'slug' => 'ui-kits', 'sort_order' => 1],
            ['name' => 'Components', 'slug' => 'components', 'sort_order' => 2],
            ['name' => 'Templates', 'slug' => 'templates', 'sort_order' => 3],
            ['name' => 'Icons', 'slug' => 'icons', 'sort_order' => 4],
            ['name' => 'Themes', 'slug' => 'themes', 'sort_order' => 5],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['slug' => $category['slug']],
                $category
            );
        }
    }
}
```

### Role Seeder

```php
// database/seeders/RoleSeeder.php
class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            ['name' => 'User', 'slug' => 'user'],
            ['name' => 'Author', 'slug' => 'author'],
            ['name' => 'Editor', 'slug' => 'editor'],
            ['name' => 'Admin', 'slug' => 'admin'],
        ];

        foreach ($roles as $role) {
            Role::updateOrCreate(
                ['slug' => $role['slug']],
                $role
            );
        }
    }
}
```

## Test Data Seeders

### Development Seeder

```php
// database/seeders/DevelopmentSeeder.php
class DevelopmentSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user
        $admin = User::factory()->admin()->create([
            'name' => 'Admin',
            'email' => 'admin@gsmui.test',
        ]);

        // Create regular users
        $users = User::factory()->count(10)->withProfile()->create();

        // Create products with components
        Product::factory()
            ->count(20)
            ->published()
            ->withComponents(5)
            ->withVariants(3)
            ->create();

        // Create orders with items and licenses
        foreach ($users as $user) {
            Order::factory()
                ->fulfilled()
                ->withItems(3)
                ->withPayment()
                ->create(['user_id' => $user->id]);
        }

        // Create documentation
        $sections = ['Getting Started', 'Components', 'API Reference', 'Blog'];
        foreach ($sections as $index => $sectionName) {
            $section = Section::create([
                'name' => $sectionName,
                'slug' => Str::slug($sectionName),
                'sort_order' => $index,
            ]);

            Page::factory()
                ->count(5)
                ->published()
                ->create(['section_id' => $section->id]);
        }
    }
}
```

### Demo Seeder

```php
// database/seeders/DemoSeeder.php
class DemoSeeder extends Seeder
{
    public function run(): void
    {
        // Create demo user
        $demo = User::factory()->create([
            'name' => 'Demo User',
            'email' => 'demo@gsmui.test',
            'password' => Hash::make('password'),
        ]);

        // Create sample products
        $products = [
            ['name' => 'GsmUi Starter Kit', 'base_price' => 0, 'is_featured' => true],
            ['name' => 'GsmUi Pro Kit', 'base_price' => 9900, 'is_featured' => true],
            ['name' => 'GsmUi Enterprise', 'base_price' => 29900, 'is_featured' => false],
        ];

        foreach ($products as $product) {
            Product::factory()
                ->published()
                ->withComponents(3)
                ->create($product);
        }

        // Create demo license
        $product = Product::first();
        License::factory()->create([
            'user_id' => $demo->id,
            'product_id' => $product->id,
        ]);
    }
}
```

## Seeder Commands

### Running Seeders

```bash
# Run all seeders
php artisan db:seed

# Run specific seeder
php artisan db:seed --class=PlanSeeder

# Run in specific environment
php artisan db:seed --env=local

# Force (production)
php artisan db:seed --force
```

### Migration + Seed

```bash
# Fresh database with seed
php artisan migrate:fresh --seed

# Fresh with specific seeder
php artisan migrate:fresh --seed --class=ProductionSeeder
```

## Seeder Performance

### Batch Insert

```php
class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [];
        for ($i = 0; $i < 1000; $i++) {
            $products[] = [
                'id' => Str::uuid7(),
                'slug' => fake()->unique()->slug(),
                'name' => fake()->words(3, true),
                // ... other fields
            ];
        }

        // Batch insert (100 at a time)
        foreach (collect($products)->chunk(100) as $chunk) {
            Product::insert($chunk->toArray());
        }
    }
}
```

### Foreign Key Checks

```php
public function run(): void
{
    // Disable foreign key checks for bulk insert
    DB::statement('SET FOREIGN_KEY_CHECKS=0');
    
    // ... seed data
    
    DB::statement('SET FOREIGN_KEY_CHECKS=1');
}
```

## Related Documents

- [Migrations](../Migrations/index.md)
- [Tables](../Tables/index.md)
- [Design Principles](../Design-Principles/index.md)
- [Constraints](../Constraints/index.md)
