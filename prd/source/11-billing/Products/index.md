# Product Catalog

## Overview

The product catalog is the foundation of gsmui's billing system. Products represent everything you sell — digital goods, subscriptions, and bundles. This document covers product types, pricing models, SKUs, and metadata management.

## Product Types

| Type | Description | Billing Model | Example |
|------|-------------|---------------|---------|
| `digital` | Downloadable files, software | One-time purchase | eBook, plugin |
| `subscription` | Recurring access | Monthly/annual | SaaS, membership |
| `bundle` | Grouped products | Combined pricing | Course + templates |
| `service` | Professional services | Hourly/project | Consulting, support |

### Product Model

```php
class Product extends Model
{
    protected $fillable = [
        'name', 'slug', 'type', 'status', 'description',
        'short_description', 'image', 'metadata',
    ];

    protected $casts = [
        'metadata' => 'array',
        'is_active' => 'boolean',
    ];

    public function skus(): HasMany
    {
        return $this->hasMany(Sku::class);
    }

    public function prices(): HasMany
    {
        return $this->hasMany(Price::class);
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }
}
```

### Product Status Lifecycle

```
┌──────────┐    activate    ┌──────────┐
│ Draft    │ ────────────► │ Active   │
└──────────┘                └──────────┘
                                 │
                           deactivate
                                 │
                                 ▼
                           ┌──────────┐     reactivate   ┌──────────┐
                           │ Inactive │ ────────────────► │ Active   │
                           └──────────┘                   └──────────┘
                                 │
                             archive
                                 │
                                 ▼
                           ┌──────────┐
                           │ Archived │
                           └──────────┘
```

## Pricing Models

| Model | Description | Use Case |
|-------|-------------|----------|
| `flat` | Fixed price | Physical goods, one-time |
| `tiered` | Volume-based pricing | SaaS, API usage |
| `graduated` | Step-based pricing | Usage with thresholds |
| `unit` | Per-unit pricing | Per-seat, per-transaction |
| `package` | Bundled pricing | Combo products |

### Price Definitions

```php
class Price extends Model
{
    protected $fillable = [
        'product_id', 'name', 'type', 'currency', 'amount',
        'recurring_interval', 'recurring_interval_count',
        'trial_period_days', 'metadata',
    ];

    protected $casts = [
        'amount' => 'integer', // stored in cents
        'metadata' => 'array',
    ];

    // Pricing tiers
    public function tiers(): HasMany
    {
        return $this->hasMany(PriceTier::class);
    }
}
```

### Pricing Table

| Price Type | Fields | Example |
|------------|--------|---------|
| `flat` | `amount`, `currency` | $29.00 one-time |
| `tiered` | `tiers[].up_to`, `tiers[].flat_amount` | $10 for 1-100, $8 for 101-1000 |
| `graduated` | `tiers[].up_to`, `tiers[].unit_amount` | First 100 @ $0.01, next 900 @ $0.005 |
| `unit` | `unit_amount`, `currency` | $5 per seat |
| `package` | `package_size`, `unit_amount` | $50 per 1000 API calls |

## SKU Management

### SKU Schema

| Column | Type | Description |
|--------|------|-------------|
| `id` | `bigint` | Primary key |
| `product_id` | `bigint` | FK to products |
| `sku` | `string` | Unique SKU code |
| `name` | `string` | Display name |
| `status` | `enum` | active / inactive / archived |
| `inventory_quantity` | `int?` | Null = unlimited |
| `metadata` | `json` | |
| `created_at` | `timestamp` | |
| `updated_at` | `timestamp` | |

### SKU Operations

```php
// Create SKU
$product->skus()->create([
    'sku' => 'PRO-ENT-001',
    'name' => 'Enterprise Plan',
    'inventory_quantity' => null, // unlimited
]);

// Check inventory
if ($sku->hasInventory()) {
    // process order
}

// Decrement inventory
$sku->decrementInventory(1);

// Generate SKU
$sku = SkuGenerator::for($product, 'Enterprise');
// Result: PRO-ENT-2024-001
```

## Product Metadata

### Metadata Schema

```json
{
    "features": [
        "unlimited_projects",
        "priority_support",
        "custom_domain"
    ],
    "limits": {
        "storage_gb": 100,
        "api_calls_monthly": 100000,
        "team_members": 25
    },
    "integrations": ["slack", "github", "jira"],
    "support_level": "priority",
    "sla_uptime": 99.9,
    "onboarding": "dedicated"
}
```

### Metadata Access

```php
// Get metadata
$product->metadata['features'];

// Nested access
$product->metadata['limits']['storage_gb'];

// Check feature
in_array('priority_support', $product->metadata['features'] ?? []);

// Update metadata
$product->update([
    'metadata' => array_merge($product->metadata ?? [], [
        'new_feature' => true,
    ]),
]);
```

## Product Database Schema

### Products Table

| Column | Type | Description |
|--------|------|-------------|
| `id` | `bigint` | Primary key |
| `name` | `string` | |
| `slug` | `string` | URL-safe identifier |
| `type` | `enum` | digital / subscription / bundle / service |
| `status` | `enum` | draft / active / inactive / archived |
| `description` | `text?` | |
| `short_description` | `string?` | |
| `image` | `string?` | Path to product image |
| `metadata` | `json` | Flexible key-value store |
| `is_taxable` | `bool` | Default: true |
| `tax_class` | `string?` | Tax classification |
| `created_at` | `timestamp` | |
| `updated_at` | `timestamp` | |

### Prices Table

| Column | Type | Description |
|--------|------|-------------|
| `id` | `bigint` | Primary key |
| `product_id` | `bigint` | FK to products |
| `name` | `string` | Price label |
| `type` | `enum` | flat / tiered / graduated / unit / package |
| `currency` | `string` | ISO 4217 |
| `amount` | `bigint` | Amount in smallest currency unit |
| `recurring_interval` | `enum?` | day / week / month / year |
| `recurring_interval_count` | `int?` | Default: 1 |
| `trial_period_days` | `int?` | |
| `metadata` | `json` | |
| `created_at` | `timestamp` | |
| `updated_at` | `timestamp` | |

## Product Management API

```php
// List products
$products = Product::active()
    ->with('prices')
    ->orderBy('name')
    ->paginate(20);

// Create product
$product = Product::create([
    'name' => 'Pro Plan',
    'slug' => 'pro-plan',
    'type' => 'subscription',
    'description' => 'Full access to all features',
    'metadata' => [
        'features' => ['unlimited', 'priority'],
        'limits' => ['storage_gb' => 50],
    ],
]);

// Add price
$product->prices()->create([
    'name' => 'Monthly',
    'type' => 'flat',
    'currency' => 'USD',
    'amount' => 2900, // $29.00
    'recurring_interval' => 'month',
]);
```

## Best Practices

1. **Use descriptive slugs** — they appear in URLs and invoices
2. **Store amounts in cents** — avoid floating-point issues
3. **Version prices** — never modify existing price records
4. **Use metadata** for flexible data — avoid schema changes
5. **Keep products and prices separate** — prices can change independently
6. **Archive, don't delete** — preserves historical data
