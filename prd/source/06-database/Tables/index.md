# Table Definitions

## Overview

Complete table definitions for all entities in the GsmUi platform. Each table includes column definitions, types, constraints, and indexes.

## Core Tables

### users

| Column | Type | Nullable | Default | Description |
|--------|------|----------|---------|-------------|
| `id` | CHAR(36) | NO | UUID v7 | Primary key |
| `name` | VARCHAR(255) | NO | — | Display name |
| `email` | VARCHAR(255) | NO | UNIQUE | Email address |
| `email_verified_at` | TIMESTAMP | YES | NULL | Email verification time |
| `password_hash` | VARCHAR(255) | YES | NULL | Bcrypt hash |
| `remember_token` | VARCHAR(100) | YES | NULL | Remember me token |
| `two_factor_secret` | VARCHAR(255) | YES | NULL | 2FA secret |
| `two_factor_recovery_codes` | JSON | YES | NULL | 2FA recovery codes |
| `is_admin` | BOOLEAN | NO | FALSE | Admin flag |
| `last_login_at` | TIMESTAMP | YES | NULL | Last login time |
| `last_login_ip` | VARCHAR(45) | YES | NULL | Last login IP |
| `created_at` | TIMESTAMP | NO | CURRENT | Creation time |
| `updated_at` | TIMESTAMP | NO | CURRENT | Last update |
| `deleted_at` | TIMESTAMP | YES | NULL | Soft delete |

### products

| Column | Type | Nullable | Default | Description |
|--------|------|----------|---------|-------------|
| `id` | CHAR(36) | NO | UUID v7 | Primary key |
| `slug` | VARCHAR(255) | NO | UNIQUE | URL slug |
| `name` | VARCHAR(255) | NO | — | Product name |
| `tagline` | VARCHAR(500) | YES | NULL | Short description |
| `description` | LONGTEXT | NO | — | Full description |
| `description_html` | LONGTEXT | YES | NULL | Rendered HTML |
| `base_price` | INT | NO | 0 | Price in cents |
| `currency` | VARCHAR(3) | NO | 'USD' | Currency code |
| `status` | ENUM | NO | 'draft' | Product status |
| `is_featured` | BOOLEAN | NO | FALSE | Featured flag |
| `download_count` | INT | NO | 0 | Total downloads |
| `sales_count` | INT | NO | 0 | Total sales |
| `featured_image` | VARCHAR(2048) | YES | NULL | Image URL |
| `preview_url` | VARCHAR(2048) | YES | NULL | Preview URL |
| `github_repo` | VARCHAR(255) | YES | NULL | GitHub repo |
| `version` | VARCHAR(50) | YES | NULL | Version string |
| `license_type` | VARCHAR(50) | NO | 'single' | License type |
| `created_by` | CHAR(36) | YES | NULL | Creator user ID |
| `published_at` | TIMESTAMP | YES | NULL | Publish time |
| `created_at` | TIMESTAMP | NO | CURRENT | Creation time |
| `updated_at` | TIMESTAMP | NO | CURRENT | Last update |
| `deleted_at` | TIMESTAMP | YES | NULL | Soft delete |

### orders

| Column | Type | Nullable | Default | Description |
|--------|------|----------|---------|-------------|
| `id` | CHAR(36) | NO | UUID v7 | Primary key |
| `order_number` | VARCHAR(50) | NO | UNIQUE | Order number |
| `user_id` | CHAR(36) | NO | — | Buyer user ID |
| `status` | ENUM | NO | 'pending' | Order status |
| `subtotal` | INT | NO | 0 | Subtotal in cents |
| `tax_amount` | INT | NO | 0 | Tax in cents |
| `discount_amount` | INT | NO | 0 | Discount in cents |
| `total` | INT | NO | 0 | Total in cents |
| `currency` | VARCHAR(3) | NO | 'USD' | Currency code |
| `coupon_code` | VARCHAR(50) | YES | NULL | Applied coupon |
| `notes` | TEXT | YES | NULL | Order notes |
| `placed_at` | TIMESTAMP | YES | NULL | Placement time |
| `fulfilled_at` | TIMESTAMP | YES | NULL | Fulfillment time |
| `cancelled_at` | TIMESTAMP | YES | NULL | Cancellation time |
| `refund_reason` | TEXT | YES | NULL | Refund reason |
| `created_at` | TIMESTAMP | NO | CURRENT | Creation time |
| `updated_at` | TIMESTAMP | NO | CURRENT | Last update |

### licenses

| Column | Type | Nullable | Default | Description |
|--------|------|----------|---------|-------------|
| `id` | CHAR(36) | NO | UUID v7 | Primary key |
| `license_key` | VARCHAR(50) | NO | UNIQUE | License key |
| `user_id` | CHAR(36) | NO | — | License owner |
| `product_id` | CHAR(36) | NO | — | Licensed product |
| `order_id` | CHAR(36) | NO | — | Source order |
| `status` | ENUM | NO | 'active' | License status |
| `download_count` | INT | NO | 0 | Downloads used |
| `max_downloads` | INT | NO | 10 | Download limit |
| `activated_at` | TIMESTAMP | YES | NULL | Activation time |
| `expires_at` | TIMESTAMP | YES | NULL | Expiration time |
| `last_download_at` | TIMESTAMP | YES | NULL | Last download |
| `last_download_ip` | VARCHAR(45) | YES | NULL | Last download IP |
| `created_at` | TIMESTAMP | NO | CURRENT | Creation time |
| `updated_at` | TIMESTAMP | NO | CURRENT | Last update |
| `deleted_at` | TIMESTAMP | YES | NULL | Soft delete |

## Marketplace Tables

### product_variants

| Column | Type | Nullable | Default | Description |
|--------|------|----------|---------|-------------|
| `id` | CHAR(36) | NO | UUID v7 | Primary key |
| `product_id` | CHAR(36) | NO | — | Parent product |
| `name` | VARCHAR(255) | NO | — | Variant name |
| `price` | INT | NO | — | Price in cents |
| `sort_order` | INT | NO | 0 | Display order |
| `created_at` | TIMESTAMP | NO | CURRENT | Creation time |
| `updated_at` | TIMESTAMP | NO | CURRENT | Last update |

### components

| Column | Type | Nullable | Default | Description |
|--------|------|----------|---------|-------------|
| `id` | CHAR(36) | NO | UUID v7 | Primary key |
| `product_id` | CHAR(36) | NO | — | Parent product |
| `name` | VARCHAR(255) | NO | — | Component name |
| `description` | TEXT | YES | NULL | Description |
| `file_path` | VARCHAR(500) | NO | — | File path |
| `file_name` | VARCHAR(255) | NO | — | File name |
| `file_size` | INT | NO | 0 | Size in bytes |
| `mime_type` | VARCHAR(100) | YES | NULL | MIME type |
| `component_type` | ENUM | NO | 'blade' | Component type |
| `status` | ENUM | NO | 'active' | Component status |
| `version` | VARCHAR(50) | YES | NULL | Version |
| `sort_order` | INT | NO | 0 | Display order |
| `created_at` | TIMESTAMP | NO | CURRENT | Creation time |
| `updated_at` | TIMESTAMP | NO | CURRENT | Last update |

### categories

| Column | Type | Nullable | Default | Description |
|--------|------|----------|---------|-------------|
| `id` | CHAR(36) | NO | UUID v7 | Primary key |
| `name` | VARCHAR(255) | NO | — | Category name |
| `slug` | VARCHAR(255) | NO | UNIQUE | URL slug |
| `description` | TEXT | YES | NULL | Description |
| `parent_id` | CHAR(36) | YES | NULL | Parent category |
| `sort_order` | INT | NO | 0 | Display order |
| `created_at` | TIMESTAMP | NO | CURRENT | Creation time |
| `updated_at` | TIMESTAMP | NO | CURRENT | Last update |

### tags

| Column | Type | Nullable | Default | Description |
|--------|------|----------|---------|-------------|
| `id` | CHAR(36) | NO | UUID v7 | Primary key |
| `name` | VARCHAR(255) | NO | — | Tag name |
| `slug` | VARCHAR(255) | NO | UNIQUE | URL slug |
| `created_at` | TIMESTAMP | NO | CURRENT | Creation time |

## Order Tables

### order_items

| Column | Type | Nullable | Default | Description |
|--------|------|----------|---------|-------------|
| `id` | CHAR(36) | NO | UUID v7 | Primary key |
| `order_id` | CHAR(36) | NO | — | Parent order |
| `product_id` | CHAR(36) | NO | — | Product |
| `variant_id` | CHAR(36) | YES | NULL | Variant |
| `product_name` | VARCHAR(255) | NO | — | Product name snapshot |
| `variant_name` | VARCHAR(255) | YES | NULL | Variant name snapshot |
| `quantity` | INT | NO | 1 | Quantity |
| `unit_price` | INT | NO | — | Price per unit |
| `total` | INT | NO | — | Line total |
| `created_at` | TIMESTAMP | NO | CURRENT | Creation time |

### payments

| Column | Type | Nullable | Default | Description |
|--------|------|----------|---------|-------------|
| `id` | CHAR(36) | NO | UUID v7 | Primary key |
| `order_id` | CHAR(36) | NO | — | Parent order |
| `stripe_payment_intent_id` | VARCHAR(255) | YES | NULL | Stripe PI ID |
| `stripe_charge_id` | VARCHAR(255) | YES | NULL | Stripe charge ID |
| `status` | ENUM | NO | 'pending' | Payment status |
| `amount` | INT | NO | — | Amount in cents |
| `currency` | VARCHAR(3) | NO | 'USD' | Currency code |
| `paid_at` | TIMESTAMP | YES | NULL | Payment time |
| `refunded_at` | TIMESTAMP | YES | NULL | Refund time |
| `metadata` | JSON | YES | NULL | Extra data |
| `created_at` | TIMESTAMP | NO | CURRENT | Creation time |
| `updated_at` | TIMESTAMP | NO | CURRENT | Last update |

## Billing Tables

### plans

| Column | Type | Nullable | Default | Description |
|--------|------|----------|---------|-------------|
| `id` | CHAR(36) | NO | UUID v7 | Primary key |
| `name` | VARCHAR(255) | NO | — | Plan name |
| `slug` | VARCHAR(255) | NO | UNIQUE | URL slug |
| `description` | TEXT | YES | NULL | Description |
| `monthly_price` | INT | NO | — | Monthly price |
| `annual_price` | INT | NO | — | Annual price |
| `max_downloads` | INT | NO | — | Download limit |
| `features` | JSON | NO | '[]' | Feature list |
| `is_active` | BOOLEAN | NO | TRUE | Active flag |
| `sort_order` | INT | NO | 0 | Display order |
| `created_at` | TIMESTAMP | NO | CURRENT | Creation time |
| `updated_at` | TIMESTAMP | NO | CURRENT | Last update |

### subscriptions

| Column | Type | Nullable | Default | Description |
|--------|------|----------|---------|-------------|
| `id` | CHAR(36) | NO | UUID v7 | Primary key |
| `user_id` | CHAR(36) | NO | — | Subscriber |
| `plan_id` | CHAR(36) | NO | — | Subscription plan |
| `stripe_subscription_id` | VARCHAR(255) | NO | UNIQUE | Stripe sub ID |
| `stripe_customer_id` | VARCHAR(255) | NO | — | Stripe customer |
| `status` | ENUM | NO | 'active' | Subscription status |
| `monthly_price` | INT | NO | — | Current price |
| `billing_cycle` | ENUM | NO | 'monthly' | Billing cycle |
| `current_period_start` | TIMESTAMP | YES | NULL | Period start |
| `current_period_end` | TIMESTAMP | YES | NULL | Period end |
| `trial_ends_at` | TIMESTAMP | YES | NULL | Trial end |
| `canceled_at` | TIMESTAMP | YES | NULL | Cancellation |
| `cancel_reason` | TEXT | YES | NULL | Cancel reason |
| `created_at` | TIMESTAMP | NO | CURRENT | Creation time |
| `updated_at` | TIMESTAMP | NO | CURRENT | Last update |

### invoices

| Column | Type | Nullable | Default | Description |
|--------|------|----------|---------|-------------|
| `id` | CHAR(36) | NO | UUID v7 | Primary key |
| `user_id` | CHAR(36) | NO | — | Invoice owner |
| `subscription_id` | CHAR(36) | YES | NULL | Related subscription |
| `stripe_invoice_id` | VARCHAR(255) | NO | UNIQUE | Stripe invoice ID |
| `status` | ENUM | NO | 'pending' | Invoice status |
| `amount` | INT | NO | — | Amount in cents |
| `currency` | VARCHAR(3) | NO | 'USD' | Currency code |
| `invoice_url` | VARCHAR(2048) | YES | NULL | PDF URL |
| `issued_at` | TIMESTAMP | YES | NULL | Issue date |
| `paid_at` | TIMESTAMP | YES | NULL | Payment date |
| `created_at` | TIMESTAMP | NO | CURRENT | Creation time |

## CMS Tables

### sections

| Column | Type | Nullable | Default | Description |
|--------|------|----------|---------|-------------|
| `id` | CHAR(36) | NO | UUID v7 | Primary key |
| `name` | VARCHAR(255) | NO | — | Section name |
| `slug` | VARCHAR(255) | NO | UNIQUE | URL slug |
| `description` | TEXT | YES | NULL | Description |
| `parent_id` | CHAR(36) | YES | NULL | Parent section |
| `sort_order` | INT | NO | 0 | Display order |
| `status` | ENUM | NO | 'published' | Section status |
| `created_at` | TIMESTAMP | NO | CURRENT | Creation time |
| `updated_at` | TIMESTAMP | NO | CURRENT | Last update |

### pages

| Column | Type | Nullable | Default | Description |
|--------|------|----------|---------|-------------|
| `id` | CHAR(36) | NO | UUID v7 | Primary key |
| `section_id` | CHAR(36) | NO | — | Parent section |
| `slug` | VARCHAR(255) | NO | — | URL slug |
| `title` | VARCHAR(255) | NO | — | Page title |
| `body` | LONGTEXT | NO | — | Page content |
| `body_html` | LONGTEXT | YES | NULL | Rendered HTML |
| `excerpt` | TEXT | YES | NULL | Short description |
| `sort_order` | INT | NO | 0 | Display order |
| `status` | ENUM | NO | 'draft' | Page status |
| `created_by` | CHAR(36) | YES | NULL | Author |
| `published_at` | TIMESTAMP | YES | NULL | Publish time |
| `created_at` | TIMESTAMP | NO | CURRENT | Creation time |
| `updated_at` | TIMESTAMP | NO | CURRENT | Last update |
| `deleted_at` | TIMESTAMP | YES | NULL | Soft delete |

### blog_posts

| Column | Type | Nullable | Default | Description |
|--------|------|----------|---------|-------------|
| `id` | CHAR(36) | NO | UUID v7 | Primary key |
| `section_id` | CHAR(36) | NO | — | Blog section |
| `slug` | VARCHAR(255) | NO | — | URL slug |
| `title` | VARCHAR(255) | NO | — | Post title |
| `excerpt` | TEXT | YES | NULL | Short description |
| `body` | LONGTEXT | NO | — | Post content |
| `body_html` | LONGTEXT | YES | NULL | Rendered HTML |
| `featured_image` | VARCHAR(2048) | YES | NULL | Image URL |
| `status` | ENUM | NO | 'draft' | Post status |
| `author_id` | CHAR(36) | YES | NULL | Author user ID |
| `published_at` | TIMESTAMP | YES | NULL | Publish time |
| `created_at` | TIMESTAMP | NO | CURRENT | Creation time |
| `updated_at` | TIMESTAMP | NO | CURRENT | Last update |
| `deleted_at` | TIMESTAMP | YES | NULL | Soft delete |

## Utility Tables

### downloads

| Column | Type | Nullable | Default | Description |
|--------|------|----------|---------|-------------|
| `id` | CHAR(36) | NO | UUID v7 | Primary key |
| `license_id` | CHAR(36) | NO | — | License used |
| `user_id` | CHAR(36) | NO | — | User downloading |
| `ip_address` | VARCHAR(45) | YES | NULL | Client IP |
| `user_agent` | TEXT | YES | NULL | Browser UA |
| `file_path` | VARCHAR(500) | NO | — | Downloaded file |
| `file_size` | INT | NO | 0 | File size |
| `downloaded_at` | TIMESTAMP | NO | CURRENT | Download time |

### audit_logs

| Column | Type | Nullable | Default | Description |
|--------|------|----------|---------|-------------|
| `id` | BIGINT | NO | AUTO | Primary key |
| `user_id` | CHAR(36) | YES | NULL | Acting user |
| `event` | VARCHAR(255) | NO | — | Event type |
| `auditable_type` | VARCHAR(255) | NO | — | Model class |
| `auditable_id` | CHAR(36) | NO | — | Model ID |
| `old_values` | JSON | YES | NULL | Previous values |
| `new_values` | JSON | YES | NULL | New values |
| `ip_address` | VARCHAR(45) | YES | NULL | Client IP |
| `user_agent` | TEXT | YES | NULL | Browser UA |
| `created_at` | TIMESTAMP | NO | CURRENT | Event time |

### sessions

| Column | Type | Nullable | Default | Description |
|--------|------|----------|---------|-------------|
| `id` | VARCHAR(255) | NO | — | Session ID |
| `user_id` | CHAR(36) | YES | NULL | Session owner |
| `ip_address` | VARCHAR(45) | YES | NULL | Client IP |
| `user_agent` | TEXT | YES | NULL | Browser UA |
| `payload` | LONGTEXT | NO | — | Session data |
| `last_activity` | INT | NO | — | Last activity timestamp |

### failed_jobs

| Column | Type | Nullable | Default | Description |
|--------|------|----------|---------|-------------|
| `id` | BIGINT | NO | AUTO | Primary key |
| `uuid` | VARCHAR(255) | NO | UNIQUE | Job UUID |
| `connection` | TEXT | NO | — | Queue connection |
| `queue` | TEXT | NO | — | Queue name |
| `payload` | LONGTEXT | NO | — | Job payload |
| `exception` | LONGTEXT | NO | — | Exception text |
| `failed_at` | TIMESTAMP | NO | CURRENT | Failure time |

## Related Documents

- [ERD Diagrams](../ERD/index.md)
- [Schemas](../Schemas/index.md)
- [Indexes](../Indexes/index.md)
- [Constraints](../Constraints/index.md)
