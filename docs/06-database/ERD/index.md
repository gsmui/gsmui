# Entity-Relationship Diagrams

## Overview

This document contains ERD diagrams for all major domains in the GsmUi platform. Each diagram shows entities, attributes, and relationships.

## System-Wide ERD

```mermaid
erDiagram
    users ||--o{ orders : places
    users ||--o{ licenses : owns
    users ||--o{ reviews : writes
    users ||--o{ comments : writes
    users ||--o{ subscriptions : has
    users ||--o| user_profiles : has
    users ||--o| user_settings : has
    users ||--o{ oauth_identities : has

    products ||--o{ components : contains
    products ||--o{ product_variants : has
    products ||--o{ order_items : includes
    products ||--o{ licenses : grants
    products ||--o{ reviews : receives
    products ||--o{ comments : receives
    products }|--|{ categories : categorized
    products }|--|{ tags : tagged

    orders ||--o{ order_items : contains
    orders ||--o| payments : has
    orders ||--o{ licenses : generates

    subscriptions }|--|| plans : follows
    subscriptions ||--o{ invoices : generates

    pages }|--|| sections : belongs_to
    blog_posts }|--|| sections : belongs_to
```

## Users Domain

```mermaid
erDiagram
    users {
        uuid id PK
        string name
        string email UK
        string password_hash
        timestamp email_verified_at
        timestamp last_login_at
        timestamp created_at
        timestamp updated_at
        timestamp deleted_at
    }

    user_profiles {
        uuid id PK
        uuid user_id FK
        string avatar_url
        text bio
        string company
        string website
        timestamp created_at
        timestamp updated_at
    }

    user_settings {
        uuid id PK
        uuid user_id FK
        string locale
        string theme
        json preferences
        timestamp created_at
        timestamp updated_at
    }

    oauth_identities {
        uuid id PK
        uuid user_id FK
        string provider
        string provider_id
        string access_token
        string refresh_token
        timestamp token_expires_at
        timestamp created_at
        timestamp updated_at
    }

    users ||--o| user_profiles : "has profile"
    users ||--o| user_settings : "has settings"
    users ||--o{ oauth_identities : "has identities"
```

## Products Domain

```mermaid
erDiagram
    products {
        uuid id PK
        string slug UK
        string name
        string tagline
        text description
        int base_price
        enum status
        boolean is_featured
        int download_count
        int sales_count
        uuid created_by FK
        timestamp published_at
        timestamp created_at
        timestamp updated_at
        timestamp deleted_at
    }

    product_variants {
        uuid id PK
        uuid product_id FK
        string name
        int price
        int sort_order
        timestamp created_at
        timestamp updated_at
    }

    components {
        uuid id PK
        uuid product_id FK
        string name
        string file_path
        int size_bytes
        enum component_type
        enum status
        timestamp created_at
        timestamp updated_at
    }

    categories {
        uuid id PK
        string name
        string slug UK
        text description
        uuid parent_id FK
        int sort_order
        timestamp created_at
        timestamp updated_at
    }

    tags {
        uuid id PK
        string name
        string slug UK
        timestamp created_at
    }

    product_categories {
        uuid product_id FK
        uuid category_id FK
        int sort_order
        timestamp created_at
    }

    taggables {
        uuid tag_id FK
        uuid taggable_id
        string taggable_type
    }

    products ||--o{ product_variants : "has variants"
    products ||--o{ components : "has components"
    products }|--|{ categories : "categorized"
    products }|--|{ tags : "tagged"
    categories ||--o{ categories : "parent-child"
```

## Orders Domain

```mermaid
erDiagram
    orders {
        uuid id PK
        string order_number UK
        uuid user_id FK
        enum status
        int subtotal
        int tax_amount
        int discount_amount
        int total
        string currency
        timestamp placed_at
        timestamp fulfilled_at
        timestamp cancelled_at
        timestamp created_at
        timestamp updated_at
    }

    order_items {
        uuid id PK
        uuid order_id FK
        uuid product_id FK
        uuid variant_id FK
        string product_name
        string variant_name
        int quantity
        int unit_price
        int total
        timestamp created_at
    }

    payments {
        uuid id PK
        uuid order_id FK
        string stripe_payment_intent_id
        string stripe_charge_id
        enum status
        int amount
        string currency
        timestamp paid_at
        timestamp refunded_at
        json metadata
        timestamp created_at
        timestamp updated_at
    }

    orders ||--o{ order_items : "contains"
    orders ||--o| payments : "has payment"
```

## Licenses Domain

```mermaid
erDiagram
    licenses {
        uuid id PK
        string license_key UK
        uuid user_id FK
        uuid product_id FK
        uuid order_id FK
        enum status
        int download_count
        int max_downloads
        timestamp activated_at
        timestamp expires_at
        timestamp last_download_at
        timestamp created_at
        timestamp updated_at
        timestamp deleted_at
    }

    downloads {
        uuid id PK
        uuid license_id FK
        uuid user_id FK
        string ip_address
        string user_agent
        string file_path
        int file_size
        timestamp downloaded_at
    }

    licenses ||--o{ downloads : "has downloads"
    licenses }|--|| products : "for product"
    licenses }|--|| orders : "from order"
```

## Subscriptions Domain

```mermaid
erDiagram
    subscriptions {
        uuid id PK
        uuid user_id FK
        uuid plan_id FK
        string stripe_subscription_id
        enum status
        int monthly_price
        int monthly_downloads
        int current_downloads
        timestamp current_period_start
        timestamp current_period_end
        timestamp trial_ends_at
        timestamp canceled_at
        timestamp created_at
        timestamp updated_at
    }

    plans {
        uuid id PK
        string name
        string slug UK
        string description
        int monthly_price
        int annual_price
        int max_downloads
        json features
        boolean is_active
        int sort_order
        timestamp created_at
        timestamp updated_at
    }

    invoices {
        uuid id PK
        uuid user_id FK
        uuid subscription_id FK
        string stripe_invoice_id
        enum status
        int amount
        string currency
        string invoice_url
        timestamp issued_at
        timestamp paid_at
        timestamp created_at
    }

    subscriptions }|--|| plans : "follows plan"
    subscriptions ||--o{ invoices : "has invoices"
```

## Documentation Domain

```mermaid
erDiagram
    sections {
        uuid id PK
        string name
        string slug UK
        text description
        uuid parent_id FK
        int sort_order
        enum status
        timestamp created_at
        timestamp updated_at
    }

    pages {
        uuid id PK
        uuid section_id FK
        string slug
        string title
        longtext body
        longtext body_html
        int sort_order
        enum status
        uuid created_by FK
        timestamp published_at
        timestamp created_at
        timestamp updated_at
        timestamp deleted_at
    }

    component_docs {
        uuid id PK
        uuid product_id FK
        uuid page_id FK
        string component_name
        text description
        json props
        json events
        json slots
        json examples
        timestamp created_at
        timestamp updated_at
    }

    sections ||--o{ pages : "contains pages"
    pages ||--o| component_docs : "documents component"
```

## Blog Domain

```mermaid
erDiagram
    blog_posts {
        uuid id PK
        uuid section_id FK
        string slug
        string title
        string excerpt
        longtext body
        longtext body_html
        string featured_image
        enum status
        uuid author_id FK
        timestamp published_at
        timestamp created_at
        timestamp updated_at
        timestamp deleted_at
    }

    blog_categories {
        uuid id PK
        string name
        string slug UK
        text description
        int sort_order
        timestamp created_at
        timestamp updated_at
    }

    blog_post_categories {
        uuid post_id FK
        uuid category_id FK
        timestamp created_at
    }

    blog_posts }|--|{ blog_categories : "categorized"
```

## Comments & Reviews

```mermaid
erDiagram
    comments {
        uuid id PK
        uuid user_id FK
        string commentable_type
        uuid commentable_id
        uuid parent_id FK
        text body
        enum status
        timestamp created_at
        timestamp updated_at
        timestamp deleted_at
    }

    reviews {
        uuid id PK
        uuid user_id FK
        string reviewable_type
        uuid reviewable_id
        int rating
        string title
        text body
        enum status
        timestamp created_at
        timestamp updated_at
        timestamp deleted_at
    }

    comments ||--o{ comments : "has replies"
```

## Media & Audit

```mermaid
erDiagram
    media {
        uuid id PK
        string mediable_type
        uuid mediable_id
        string type
        string file_name
        string file_path
        string mime_type
        int file_size
        json metadata
        uuid uploaded_by FK
        timestamp created_at
    }

    audit_logs {
        bigint id PK
        uuid user_id FK
        string event
        string auditable_type
        uuid auditable_id
        json old_values
        json new_values
        string ip_address
        string user_agent
        timestamp created_at
    }
```

## Index Overview

| Table | Primary Key | Unique Indexes | Regular Indexes |
|-------|-------------|----------------|-----------------|
| `users` | `id` | `email` | `created_at` |
| `products` | `id` | `slug` | `status+featured`, `created_at` |
| `orders` | `id` | `order_number` | `user_id+status`, `created_at` |
| `licenses` | `id` | `license_key` | `user_id+status`, `product_id` |
| `pages` | `id` | `slug` (per section) | `section_id+sort_order` |
| `blog_posts` | `id` | `slug` | `author_id+status`, `published_at` |

## Related Documents

- [Tables](../Tables/index.md)
- [Relationships](../Relationships/index.md)
- [Indexes](../Indexes/index.md)
- [Constraints](../Constraints/index.md)
