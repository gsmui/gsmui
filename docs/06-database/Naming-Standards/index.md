# Naming Standards

## Overview

Consistent naming conventions reduce cognitive load, prevent errors, and make the schema self-documenting. GsmUi follows Laravel/Eloquent conventions with additional standards for indexes, foreign keys, and migrations.

## Table Naming

### Conventions

| Rule | Example | Anti-Example |
|------|---------|--------------|
| Plural nouns | `products` | `product` |
| snake_case | `order_items` | `orderItems` |
| No prefixes | `users` | `gsmui_users` |
| Pivot tables | `product_categories` | `category_product` |
| Join tables | `model_has_roles` | `roles_models` |

### Table Name Reference

| Table | Description | Plural | snake_case |
|-------|-------------|--------|------------|
| `users` | User accounts | ✓ | ✓ |
| `products` | Product catalog | ✓ | ✓ |
| `product_variants` | Product pricing tiers | ✓ | ✓ |
| `components` | Product components | ✓ | ✓ |
| `categories` | Product categories | ✓ | ✓ |
| `orders` | Purchase orders | ✓ | ✓ |
| `order_items` | Order line items | ✓ | ✓ |
| `payments` | Payment records | ✓ | ✓ |
| `licenses` | License keys | ✓ | ✓ |
| `downloads` | Download tracking | ✓ | ✓ |
| `reviews` | Product reviews | ✓ | ✓ |
| `comments` | User comments | ✓ | ✓ |
| `pages` | Documentation pages | ✓ | ✓ |
| `sections` | Doc sections | ✓ | ✓ |
| `blog_posts` | Blog articles | ✓ | ✓ |
| `tags` | Content tags | ✓ | ✓ |
| `taggables` | Tag pivot | ✓ | ✓ |
| `media` | File attachments | ✓ | ✓ |
| `audit_logs` | Audit trail | ✓ | ✓ |
| `failed_jobs` | Failed queue jobs | ✓ | ✓ |
| `sessions` | User sessions | ✓ | ✓ |
| `subscriptions` | User subscriptions | ✓ | ✓ |
| `plans` | Subscription plans | ✓ | ✓ |
| `invoices` | Billing invoices | ✓ | ✓ |

## Column Naming

### General Rules

| Rule | Example | Anti-Example |
|------|---------|--------------|
| snake_case | `created_at` | `createdAt` |
| Singular for FK | `user_id` | `user_ids` |
| Boolean prefix | `is_featured` | `featured` |
| Timestamp suffix | `created_at` | `created` |
| Count suffix | `products_count` | `products_number` |
| Status as enum | `status` | `state` |

### Column Name Reference

| Column | Type | Description |
|--------|------|-------------|
| `id` | CHAR(36) | Primary key (UUID v7) |
| `uuid` | CHAR(36) | Public-facing UUID |
| `slug` | VARCHAR(255) | URL-friendly identifier |
| `name` | VARCHAR(255) | Display name |
| `title` | VARCHAR(255) | Title |
| `description` | TEXT | Description |
| `body` | LONGTEXT | Rich content |
| `status` | ENUM | Current state |
| `type` | VARCHAR(255) | Classification |
| `price` | INT | Price in cents |
| `quantity` | INT | Count |
| `sort_order` | INT | Display order |
| `is_featured` | BOOLEAN | Featured flag |
| `is_active` | BOOLEAN | Active flag |
| `is_public` | BOOLEAN | Visibility flag |
| `created_at` | TIMESTAMP | Creation time |
| `updated_at` | TIMESTAMP | Last update time |
| `deleted_at` | TIMESTAMP | Soft delete time |
| `created_by` | CHAR(36) | Creator user ID |
| `updated_by` | CHAR(36) | Last updater user ID |

## Foreign Key Conventions

### Naming Pattern

```
{related_table_singular}_id
```

| Relationship | Foreign Key | Example |
|--------------|-------------|---------|
| User → Orders | `user_id` | `orders.user_id` |
| Product → Components | `product_id` | `components.product_id` |
| Order → Items | `order_id` | `order_items.order_id` |
| Category → Products | `category_id` | `product_categories.category_id` |

### Composite Foreign Keys

```sql
-- Pivot table with composite FK
CREATE TABLE product_categories (
    product_id CHAR(36) NOT NULL,
    category_id CHAR(36) NOT NULL,
    sort_order INT DEFAULT 0,
    PRIMARY KEY (product_id, category_id),
    FOREIGN KEY fk_product (product_id) REFERENCES products(id) ON DELETE CASCADE,
    FOREIGN KEY fk_category (category_id) REFERENCES categories(id) ON DELETE CASCADE
);
```

### Cascade Rules

| Rule | Usage | Example |
|------|-------|---------|
| `CASCADE` | Dependent data | Delete user → delete orders |
| `SET NULL` | Optional reference | Delete category → null category_id |
| `RESTRICT` | Protected data | Delete order with licenses → blocked |
| `NO ACTION` | Default | Same as RESTRICT |

## Index Naming

### Convention

```
idx_{table}_{columns}
```

| Index Type | Pattern | Example |
|------------|---------|---------|
| Single column | `idx_{table}_{column}` | `idx_products_slug` |
| Composite | `idx_{table}_{col1}_{col2}` | `idx_products_status_featured` |
| Unique | `uniq_{table}_{column}` | `uniq_users_email` |
| Foreign key | `fk_{table}_{related}` | `fk_orders_user` |
| Full-text | `ft_{table}_{columns}` | `ft_products_name_description` |

### Index Examples

```sql
-- Single column
CREATE INDEX idx_products_slug ON products(slug);

-- Composite
CREATE INDEX idx_products_status_featured ON products(status, is_featured);

-- Unique
CREATE UNIQUE INDEX uniq_users_email ON users(email);

-- Foreign key (implicit)
CREATE INDEX fk_orders_user ON orders(user_id);

-- Full-text
CREATE FULLTEXT INDEX ft_products_name_description ON products(name, description);
```

## Migration Naming

### Convention

```
YYYY_MM_DD_HHMMSS_{action}_{table}.php
```

| Action | Pattern | Example |
|--------|---------|---------|
| Create table | `create_{table}` | `2024_01_15_000001_create_products_table.php` |
| Add column | `add_{column}_to_{table}` | `2024_01_15_000002_add_featured_to_products_table.php` |
| Modify column | `modify_{column}_in_{table}` | `2024_01_15_000003_modify_price_in_products_table.php` |
| Drop column | `drop_{column}_from_{table}` | `2024_01_15_000004_drop_legacy_from_products_table.php` |
| Create index | `index_{table}_{columns}` | `2024_01_15_000005_index_products_status.php` |
| Seed data | `seed_{table}` | `2024_01_15_000006_seed_plans_table.php` |

### Migration Structure

```php
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('slug')->unique();
            $table->string('name');
            $table->text('tagline')->nullable();
            $table->longText('description');
            $table->integer('base_price')->default(0);
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft');
            $table->boolean('is_featured')->default(false);
            $table->timestamp('published_at')->nullable();
            $table->foreignUuid('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['status', 'is_featured']);
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
```

## Relationship Naming

### Eloquent Convention

| Relationship | Method Name | Return Type |
|--------------|-------------|-------------|
| One-to-One | `{relation}` | `HasOne` |
| One-to-Many | `{relations}` | `HasMany` |
| Many-to-Many | `{relations}` | `BelongsToMany` |
| Morph One | `{relation}` | `MorphOne` |
| Morph Many | `{relations}` | `MorphMany` |
| Morph To | `{relation}able` | `MorphTo` |

### Accessor/Mutator Naming

| Type | Pattern | Example |
|------|---------|---------|
| Accessor | `get{Name}Attribute` | `getNameAttribute()` |
| Mutator | `set{Name}Attribute` | `setNameAttribute($value)` |
| Boolean accessor | `is{Name}Attribute` | `isFeaturedAttribute()` |
| Count accessor | `get{Name}CountAttribute` | `getProductsCountAttribute()` |

## Status Enum Values

### Standard Status Values

| Entity | Statuses |
|--------|----------|
| Product | `draft`, `published`, `archived` |
| Order | `pending`, `processing`, `fulfilled`, `cancelled`, `refunded` |
| License | `active`, `expired`, `revoked` |
| Subscription | `active`, `trialing`, `past_due`, `canceled`, `unpaid` |
| Payment | `pending`, `succeeded`, `failed`, `refunded` |
| Page | `draft`, `published`, `archived` |
| Blog Post | `draft`, `review`, `published`, `archived` |
| Comment | `pending`, `approved`, `rejected` |
| Review | `pending`, `approved`, `rejected` |

## Related Documents

- [Design Principles](../Design-Principles/index.md)
- [Relationships](../Relationships/index.md)
- [Tables](../Tables/index.md)
- [Indexes](../Indexes/index.md)
