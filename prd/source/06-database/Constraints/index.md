# Constraints

## Overview

Constraints enforce data integrity at the database level. GsmUi uses foreign keys, unique constraints, check constraints, NOT NULL, and default values to ensure data consistency.

## Constraint Types

| Type | Purpose | MySQL Support | Enforcement |
|------|---------|---------------|-------------|
| PRIMARY KEY | Unique row identifier | ✓ | Immediate |
| FOREIGN KEY | Referential integrity | ✓ | Immediate |
| UNIQUE | Unique values | ✓ | Immediate |
| NOT NULL | Required fields | ✓ | Immediate |
| CHECK | Business rules | ✓ | Immediate |
| DEFAULT | Default values | ✓ | On insert |

## Foreign Keys

### User Domain

| Table | Column | References | On Delete | On Update |
|-------|--------|------------|-----------|-----------|
| `user_profiles` | `user_id` | `users(id)` | CASCADE | CASCADE |
| `user_settings` | `user_id` | `users(id)` | CASCADE | CASCADE |
| `oauth_identities` | `user_id` | `users(id)` | CASCADE | CASCADE |
| `sessions` | `user_id` | `users(id)` | CASCADE | CASCADE |

### Product Domain

| Table | Column | References | On Delete | On Update |
|-------|--------|------------|-----------|-----------|
| `products` | `created_by` | `users(id)` | SET NULL | CASCADE |
| `product_variants` | `product_id` | `products(id)` | CASCADE | CASCADE |
| `components` | `product_id` | `products(id)` | CASCADE | CASCADE |
| `product_categories` | `product_id` | `products(id)` | CASCADE | CASCADE |
| `product_categories` | `category_id` | `categories(id)` | CASCADE | CASCADE |
| `categories` | `parent_id` | `categories(id)` | SET NULL | CASCADE |
| `taggables` | `tag_id` | `tags(id)` | CASCADE | CASCADE |

### Order Domain

| Table | Column | References | On Delete | On Update |
|-------|--------|------------|-----------|-----------|
| `orders` | `user_id` | `users(id)` | RESTRICT | CASCADE |
| `order_items` | `order_id` | `orders(id)` | CASCADE | CASCADE |
| `order_items` | `product_id` | `products(id)` | RESTRICT | CASCADE |
| `order_items` | `variant_id` | `product_variants(id)` | SET NULL | CASCADE |
| `payments` | `order_id` | `orders(id)` | CASCADE | CASCADE |

### License Domain

| Table | Column | References | On Delete | On Update |
|-------|--------|------------|-----------|-----------|
| `licenses` | `user_id` | `users(id)` | RESTRICT | CASCADE |
| `licenses` | `product_id` | `products(id)` | RESTRICT | CASCADE |
| `licenses` | `order_id` | `orders(id)` | RESTRICT | CASCADE |
| `downloads` | `license_id` | `licenses(id)` | CASCADE | CASCADE |
| `downloads` | `user_id` | `users(id)` | CASCADE | CASCADE |

### Billing Domain

| Table | Column | References | On Delete | On Update |
|-------|--------|------------|-----------|-----------|
| `subscriptions` | `user_id` | `users(id)` | RESTRICT | CASCADE |
| `subscriptions` | `plan_id` | `plans(id)` | RESTRICT | CASCADE |
| `invoices` | `user_id` | `users(id)` | RESTRICT | CASCADE |
| `invoices` | `subscription_id` | `subscriptions(id)` | SET NULL | CASCADE |

### CMS Domain

| Table | Column | References | On Delete | On Update |
|-------|--------|------------|-----------|-----------|
| `pages` | `section_id` | `sections(id)` | CASCADE | CASCADE |
| `pages` | `created_by` | `users(id)` | SET NULL | CASCADE |
| `sections` | `parent_id` | `sections(id)` | SET NULL | CASCADE |
| `blog_posts` | `section_id` | `sections(id)` | CASCADE | CASCADE |
| `blog_posts` | `author_id` | `users(id)` | SET NULL | CASCADE |

## Cascade Rules

### Decision Matrix

| Parent | Child | Cascade | Rationale |
|--------|-------|---------|-----------|
| User | Profile | CASCADE | User-owned data |
| User | Settings | CASCADE | User-owned data |
| User | OAuth | CASCADE | User-owned data |
| User | Orders | RESTRICT | Preserve financial records |
| User | Licenses | RESTRICT | Preserve license history |
| User | Reviews | CASCADE | User-owned content |
| User | Comments | CASCADE | User-owned content |
| Product | Variants | CASCADE | Product-owned data |
| Product | Components | CASCADE | Product-owned assets |
| Product | OrderItems | RESTRICT | Preserve order history |
| Product | Licenses | RESTRICT | Preserve license history |
| Order | Items | CASCADE | Order-owned items |
| Order | Payments | CASCADE | Order-owned payments |
| License | Downloads | CASCADE | License-owned downloads |
| Category | Products | CASCADE | Category-owned pivots |
| Tag | Taggables | CASCADE | Tag-owned pivots |

## Unique Constraints

| Table | Column(s) | Index Name | Description |
|-------|-----------|------------|-------------|
| `users` | `email` | `uniq_users_email` | Email uniqueness |
| `products` | `slug` | `uniq_products_slug` | URL slug |
| `orders` | `order_number` | `uniq_orders_order_number` | Order number |
| `licenses` | `license_key` | `uniq_licenses_license_key` | License key |
| `oauth_identities` | `provider, provider_id` | `uniq_oauth_provider_id` | OAuth identity |
| `subscriptions` | `stripe_subscription_id` | `uniq_stripe_subscription_id` | Stripe subscription |
| `plans` | `slug` | `uniq_plans_slug` | Plan slug |
| `categories` | `slug` | `uniq_categories_slug` | Category slug |
| `tags` | `slug` | `uniq_tags_slug` | Tag slug |
| `sections` | `slug` | `uniq_sections_slug` | Section slug |
| `sessions` | `id` | Primary key | Session ID |

## Check Constraints

### Price Constraints

```sql
-- Non-negative prices
ALTER TABLE products ADD CONSTRAINT chk_products_price CHECK (base_price >= 0);
ALTER TABLE product_variants ADD CONSTRAINT chk_variants_price CHECK (price >= 0);
ALTER TABLE order_items ADD CONSTRAINT chk_items_price CHECK (unit_price >= 0 AND total >= 0);
ALTER TABLE orders ADD CONSTRAINT chk_orders_totals CHECK (subtotal >= 0 AND total >= 0);
```

### Quantity Constraints

```sql
-- Positive quantities
ALTER TABLE order_items ADD CONSTRAINT chk_items_quantity CHECK (quantity > 0);
ALTER TABLE licenses ADD CONSTRAINT chk_licenses_downloads CHECK (download_count >= 0 AND max_downloads > 0);
```

### Status Constraints

```sql
-- Valid status values
ALTER TABLE products ADD CONSTRAINT chk_products_status 
    CHECK (status IN ('draft', 'published', 'archived'));

ALTER TABLE orders ADD CONSTRAINT chk_orders_status 
    CHECK (status IN ('pending', 'processing', 'fulfilled', 'cancelled', 'refunded'));

ALTER TABLE licenses ADD CONSTRAINT chk_licenses_status 
    CHECK (status IN ('active', 'expired', 'revoked'));

ALTER TABLE subscriptions ADD CONSTRAINT chk_subscriptions_status 
    CHECK (status IN ('active', 'trialing', 'past_due', 'canceled', 'unpaid'));
```

### Date Constraints

```sql
-- Valid date ranges
ALTER TABLE subscriptions ADD CONSTRAINT chk_subscription_dates 
    CHECK (current_period_end > current_period_start);

ALTER TABLE licenses ADD CONSTRAINT chk_license_expiry 
    CHECK (expires_at IS NULL OR expires_at > activated_at);
```

### Composite Check Constraints

```sql
-- Order totals consistency
ALTER TABLE orders ADD CONSTRAINT chk_orders_math 
    CHECK (subtotal + tax_amount - discount_amount = total);

-- Download limit
ALTER TABLE licenses ADD CONSTRAINT chk_download_limit 
    CHECK (download_count <= max_downloads);
```

## NOT NULL Constraints

### Required Fields

| Table | Column | Reason |
|-------|--------|--------|
| `users` | `name` | Display name required |
| `users` | `email` | Authentication required |
| `products` | `slug` | URL required |
| `products` | `name` | Display name required |
| `products` | `description` | Content required |
| `orders` | `order_number` | Reference required |
| `orders` | `user_id` | Owner required |
| `orders` | `total` | Financial record |
| `licenses` | `license_key` | Validation required |
| `licenses` | `user_id` | Owner required |
| `licenses` | `product_id` | Product reference |
| `licenses` | `order_id` | Order reference |

## Default Values

| Table | Column | Default | Description |
|-------|--------|---------|-------------|
| `users` | `is_admin` | FALSE | Non-admin by default |
| `products` | `base_price` | 0 | Free by default |
| `products` | `currency` | 'USD' | Default currency |
| `products` | `status` | 'draft' | Draft by default |
| `products` | `is_featured` | FALSE | Not featured |
| `products` | `download_count` | 0 | No downloads |
| `products` | `sales_count` | 0 | No sales |
| `products` | `license_type` | 'single' | Single license |
| `orders` | `status` | 'pending' | Pending by default |
| `orders` | `subtotal` | 0 | Zero subtotal |
| `orders` | `tax_amount` | 0 | No tax |
| `orders` | `discount_amount` | 0 | No discount |
| `orders` | `total` | 0 | Zero total |
| `orders` | `currency` | 'USD' | Default currency |
| `licenses` | `status` | 'active' | Active by default |
| `licenses` | `download_count` | 0 | No downloads |
| `licenses` | `max_downloads` | 10 | Default limit |
| `plans` | `is_active` | TRUE | Active by default |
| `plans` | `sort_order` | 0 | First position |

## Constraint Naming

### Convention

```
{type}_{table}_{column(s)}
```

| Type | Pattern | Example |
|------|---------|---------|
| Foreign key | `fk_{table}_{column}` | `fk_orders_user` |
| Unique | `uniq_{table}_{column}` | `uniq_users_email` |
| Check | `chk_{table}_{column}` | `chk_products_price` |
| Primary key | `pk_{table}` | `pk_products` |

### Migration Example

```php
Schema::create('orders', function (Blueprint $table) {
    $table->uuid('id')->primary();
    $table->string('order_number')->unique('uniq_orders_order_number');
    $table->foreignUuid('user_id')
        ->constrained('users')
        ->onDelete('restrict')
        ->onUpdate('cascade');
    $table->enum('status', ['pending', 'processing', 'fulfilled', 'cancelled', 'refunded'])
        ->default('pending');
    $table->integer('subtotal')->default(0);
    $table->integer('tax_amount')->default(0);
    $table->integer('discount_amount')->default(0);
    $table->integer('total')->default(0);
    $table->string('currency', 3)->default('USD');
    
    $table->index(['user_id', 'status'], 'idx_orders_user_status');
    $table->index(['status', 'created_at'], 'idx_orders_status_created');
});
```

## Related Documents

- [Tables](../Tables/index.md)
- [Design Principles](../Design-Principles/index.md)
- [Indexes](../Indexes/index.md)
- [ERD Diagrams](../ERD/index.md)
