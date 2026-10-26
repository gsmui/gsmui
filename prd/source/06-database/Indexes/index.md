# Index Strategy

## Overview

GsmUi uses a comprehensive indexing strategy to optimize query performance. This document covers composite indexes, partial indexes, covering indexes, and their performance implications.

## Index Types

| Type | Purpose | MySQL Support | Usage |
|------|---------|---------------|-------|
| B-Tree | Default, range queries | ✓ | Most queries |
| Hash | Exact match only | Memory only | Rare |
| Full-text | Text search | ✓ | Search queries |
| Composite | Multi-column | ✓ | Filtered queries |
| Partial | Conditional | Functional index | Selective queries |
| Covering | Index-only | Implicit | Read-heavy |

## Index Naming Convention

```
idx_{table}_{column(s)}
uniq_{table}_{column}
ft_{table}_{columns}
fk_{table}_{related}
```

## Primary Key Indexes

All tables use UUID v7 as primary keys, which are time-ordered and globally unique.

| Table | PK Column | Type |
|-------|-----------|------|
| All entities | `id` | CHAR(36) |
| `audit_logs` | `id` | BIGINT (auto-increment) |
| `failed_jobs` | `id` | BIGINT (auto-increment) |

## Unique Indexes

| Table | Column(s) | Index Name |
|-------|-----------|------------|
| `users` | `email` | `uniq_users_email` |
| `products` | `slug` | `uniq_products_slug` |
| `orders` | `order_number` | `uniq_orders_order_number` |
| `licenses` | `license_key` | `uniq_licenses_license_key` |
| `oauth_identities` | `provider, provider_id` | `uniq_oauth_provider_id` |
| `subscriptions` | `stripe_subscription_id` | `uniq_stripe_subscription_id` |
| `plans` | `slug` | `uniq_plans_slug` |
| `categories` | `slug` | `uniq_categories_slug` |
| `tags` | `slug` | `uniq_tags_slug` |
| `sections` | `slug` | `uniq_sections_slug` |
| `sessions` | `id` | Primary key |

## Composite Indexes

### Products Table

```sql
-- Filter by status and featured
CREATE INDEX idx_products_status_featured ON products(status, is_featured);

-- Filter by status, sort by created_at
CREATE INDEX idx_products_status_created ON products(status, created_at);

-- Filter by status, sort by sales count
CREATE INDEX idx_products_status_sales ON products(status, sales_count);

-- Full-text search
CREATE FULLTEXT INDEX ft_products_name_description ON products(name, description, tagline);
```

### Orders Table

```sql
-- User's orders filtered by status
CREATE INDEX idx_orders_user_status ON orders(user_id, status);

-- Orders filtered by status, sort by created
CREATE INDEX idx_orders_status_created ON orders(status, created_at);

-- Orders filtered by status, sort by total
CREATE INDEX idx_orders_status_total ON orders(status, total);
```

### Licenses Table

```sql
-- User's active licenses
CREATE INDEX idx_licenses_user_status ON licenses(user_id, status);

-- Product licenses filtered by status
CREATE INDEX idx_licenses_product_status ON licenses(product_id, status);

-- License lookup by key and status
CREATE INDEX idx_licenses_key_status ON licenses(license_key, status);
```

### Order Items Table

```sql
-- Order's items
CREATE INDEX idx_order_items_order ON order_items(order_id);

-- Product sales
CREATE INDEX idx_order_items_product ON order_items(product_id);

-- Product sales by date
CREATE INDEX idx_order_items_product_created ON order_items(product_id, created_at);
```

## Partial Indexes (Functional Indexes)

MySQL 8.4 supports functional indexes which can serve as partial indexes.

```sql
-- Active products only
CREATE INDEX idx_products_active ON products((CASE WHEN status = 'published' THEN slug END));

-- Recent orders (last 30 days)
CREATE INDEX idx_orders_recent ON orders(created_at);

-- Active licenses
CREATE INDEX idx_licenses_active ON licenses((CASE WHEN status = 'active' THEN license_key END));

-- Non-deleted products
CREATE INDEX idx_products_not_deleted ON products((CASE WHEN deleted_at IS NULL THEN id END));
```

## Covering Indexes

A covering index includes all columns needed for a query, allowing the database to serve the query from the index alone.

### Product Listing Covering Index

```sql
-- Query: SELECT id, slug, name, base_price, status FROM products WHERE status = 'published'
CREATE INDEX idx_products_covering_listing ON products(
    status, is_featured, created_at,
    id, slug, name, base_price, featured_image
);
```

### Order History Covering Index

```sql
-- Query: SELECT id, order_number, status, total FROM orders WHERE user_id = ?
CREATE INDEX idx_orders_covering_history ON orders(
    user_id, status, created_at,
    id, order_number, total
);
```

### License Validation Covering Index

```sql
-- Query: SELECT id, status, download_count, max_downloads, expires_at FROM licenses WHERE license_key = ?
CREATE INDEX idx_licenses_covering_validation ON licenses(
    license_key,
    id, status, download_count, max_downloads, expires_at
);
```

## Full-Text Indexes

### Search Configuration

```sql
-- Products search
CREATE FULLTEXT INDEX ft_products_search ON products(
    name, tagline, description
) WITH PARSER ngram;

-- Documentation search
CREATE FULLTEXT INDEX ft_pages_search ON pages(
    title, body
) WITH PARSER ngram;

-- Blog search
CREATE FULLTEXT INDEX ft_blog_search ON blog_posts(
    title, excerpt, body
) WITH PARSER ngram;
```

### Full-Text Query Examples

```sql
-- Search products
SELECT id, name, tagline, 
    MATCH(name, tagline, description) AGAINST('button component' IN BOOLEAN MODE) AS relevance
FROM products
WHERE status = 'published'
AND MATCH(name, tagline, description) AGAINST('button component' IN BOOLEAN MODE)
ORDER BY relevance DESC
LIMIT 20;

-- Search with exclusions
SELECT id, title, body
FROM pages
WHERE MATCH(title, body) AGAINST('+button -modal' IN BOOLEAN MODE);
```

## Index Performance

### Impact Analysis

| Operation | Without Index | With Index | Improvement |
|-----------|---------------|------------|-------------|
| Product by slug | Full table scan | Index seek | 1000x |
| User orders | Full table scan | Index range | 500x |
| License validation | Full table scan | Index seek | 1000x |
| Product search | Full table scan | Full-text | 50x |
| Category products | Full table scan | Index join | 100x |

### Index Size Impact

| Index | Estimated Size | Rows | Growth Rate |
|-------|----------------|------|-------------|
| Primary keys | ~4 bytes/row | — | Static |
| Unique indexes | ~36 bytes/row | — | Static |
| Composite indexes | ~20-50 bytes/row | — | Static |
| Full-text indexes | ~1x data size | — | Proportional |
| JSON indexes | ~2x data size | — | Proportional |

### Write Performance

| Index Count | INSERT Impact | UPDATE Impact | DELETE Impact |
|-------------|---------------|---------------|---------------|
| 0 | 1x | 1x | 1x |
| 5 | 1.5x | 1.3x | 1.2x |
| 10 | 2x | 1.8x | 1.5x |
| 15 | 3x | 2.5x | 2x |
| 20+ | 4x+ | 3x+ | 2.5x+ |

## Index Maintenance

### Monitoring Index Usage

```sql
-- Find unused indexes
SELECT 
    object_schema,
    object_name,
    index_name
FROM performance_schema.table_io_waits_summary_by_index_usage
WHERE index_name IS NOT NULL
AND count_star = 0
AND object_schema = 'gsmui_production'
ORDER BY object_name;

-- Index statistics
SELECT 
    database_name,
    table_name,
    index_name,
    stat_value AS pages,
    stat_value * @@innodb_page_size / 1024 / 1024 AS size_mb
FROM mysql.innodb_index_stats
WHERE stat_name = 'size'
AND database_name = 'gsmui_production'
ORDER BY stat_value DESC;
```

### Index Rebuild

```sql
-- Analyze table statistics
ANALYZE TABLE products;
ANALYZE TABLE orders;
ANALYZE TABLE licenses;

-- Optimize table (rebuild indexes)
OPTIMIZE TABLE products;
OPTIMIZE TABLE orders;
```

### Index Review Checklist

| Check | Description | Action |
|-------|-------------|--------|
| Unused indexes | Index never used | Remove |
| Duplicate indexes | Same columns, different names | Remove |
| Missing indexes | Slow queries without indexes | Add |
| Over-indexed | > 15 indexes per table | Review |
| Large indexes | > 1GB per index | Optimize |

## Query Optimization

### EXPLAIN Analysis

```sql
EXPLAIN SELECT p.id, p.name, p.slug, c.name AS category
FROM products p
JOIN product_categories pc ON p.id = pc.product_id
JOIN categories c ON pc.category_id = c.id
WHERE p.status = 'published'
AND p.is_featured = true
ORDER BY p.created_at DESC
LIMIT 10;
```

### Key Metrics

| Metric | Target | Warning |
|--------|--------|---------|
| rows examined | < 1000 | > 10,000 |
| rows returned | < 100 | > 1000 |
| type | ref, range | ALL, index |
| key | idx_* | NULL |
| Extra | Using index | Using filesort, Using temporary |

## Related Documents

- [Tables](../Tables/index.md)
- [Design Principles](../Design-Principles/index.md)
- [Constraints](../Constraints/index.md)
- [ERD Diagrams](../ERD/index.md)
