# Domain-Driven Design

## Overview

GsmUi follows Domain-Driven Design principles to organize business logic into bounded contexts, each with its own models, services, and invariants. This document defines the domain model, aggregates, entities, value objects, and context mapping.

## Strategic Design

### Bounded Contexts

```mermaid
graph TB
    subgraph "GsmUi Platform"
        subgraph "Core Context"
            AC[Auth Context]
            UC[User Context]
        end
        subgraph "Marketplace Context"
            PC[Product Context]
            OC[Order Context]
            LC[License Context]
        end
        subgraph "Documentation Context"
            DC[Docs Context]
            SC[Search Context]
        end
        subgraph "Billing Context"
            BC[Billing Context]
            SC2[Subscription Context]
        end
        subgraph "Content Context"
            CBC[Blog Context]
            TMC[Theme Context]
        end
    end

    AC --> UC
    UC --> OC
    OC --> LC
    PC --> OC
    DC --> SC
    BC --> OC
    SC2 --> LC
```

### Context Map

```mermaid
graph LR
    subgraph "Upstream"
        Auth[Authentication<br/>Context]
        User[User Context]
        Product[Product Context]
    end

    subgraph "Downstream"
        Order[Order Context]
        License[License Context]
        Search[Search Context]
        Docs[Documentation Context]
    end

    Auth -->|Customer/Supplier| User
    User -->|Customer/Supplier| Order
    Product -->|Conformist| Search
    Product -->|Customer/Supplier| Order
    Order -->|Customer/Supplier| License
    User -->|Anti-Corruption Layer| Auth
```

| Consumer | Provider | Relationship | Protocol |
|----------|----------|--------------|----------|
| Order Context | Product Context | Customer/Supplier | Domain Events |
| Order Context | User Context | Customer/Supplier | Direct Repository Access |
| Search Context | Product Context | Conformist | Event Listener |
| License Context | Order Context | Customer/Supplier | Domain Events |
| Auth Context | User Context | Shared Kernel | Eloquent Model |
| Docs Context | Search Context | Published Language | API |

## Bounded Context: Core (Authentication & Users)

### Aggregates

#### User Aggregate

```mermaid
classDiagram
    class User {
        +UUID id
        +string name
        +string email
        +string password_hash
        +DateTime email_verified_at
        +DateTime created_at
        +verifyEmail()
        +changePassword()
        +hasRole()
    }

    class UserProfile {
        +UUID id
        +UUID user_id
        +string avatar_url
        +string bio
        +string company
        +string website
        +update()
    }

    class OAuthIdentity {
        +UUID id
        +UUID user_id
        +string provider
        +string provider_id
        +string access_token
        +DateTime token_expires_at
    }

    class Role {
        +UUID id
        +string name
        +string slug
        +Collection permissions
    }

    User "1" *-- "1" UserProfile
    User "1" *-- "*" OAuthIdentity
    User "*" -- "*" Role
```

**Invariants:**
- Email must be unique and verified for order placement
- Password minimum 8 characters, bcrypt hashed
- OAuth identities must have valid provider + provider_id combination

#### Value Objects

| Value Object | Properties | Validation |
|--------------|------------|------------|
| `EmailAddress` | value: string | RFC 5322 format, unique |
| `Password` | value: string (hashed) | Min 8 chars, bcrypt |
| `Money` | amount: int, currency: string | Minor units, ISO 4217 |
| `Slug` | value: string | URL-safe, unique per context |
| `UUID` | value: string (v7) | Version 7, time-ordered |

### Domain Events

| Event | Aggregate | Trigger | Handler |
|-------|-----------|---------|---------|
| `UserRegistered` | User | Email registration | Send verification, create profile |
| `EmailVerified` | User | Click verify link | Enable account features |
| `OAuthConnected` | User | OAuth callback | Create/update identity |
| `PasswordChanged` | User | Password update | Invalidate other sessions |

## Bounded Context: Marketplace

### Aggregates

#### Product Aggregate

```mermaid
classDiagram
    class Product {
        +UUID id
        +string slug
        +string name
        +string tagline
        +text description
        +Money base_price
        +ProductStatus status
        +DateTime published_at
        +publish()
        +unpublish()
        +updatePrice()
    }

    class ProductVariant {
        +UUID id
        +UUID product_id
        +string name
        +Money price
        +int sort_order
        +reorder()
    }

    class Component {
        +UUID id
        +UUID product_id
        +string name
        +string file_path
        +int size_bytes
        +ComponentType type
        +getDownloadUrl()
    }

    class Category {
        +UUID id
        +string name
        +string slug
        +UUID parent_id
        +getChildren()
    }

    class Tag {
        +UUID id
        +string name
        +string slug
    }

    Product "1" *-- "*" ProductVariant
    Product "1" *-- "*" Component
    Product "*" -- "*" Category
    Product "*" -- "*" Tag
```

**Invariants:**
- Product must have at least one variant to be published
- Price cannot be negative
- Slug must be unique across all products
- Published products must have description and featured image

#### Order Aggregate

```mermaid
classDiagram
    class Order {
        +UUID id
        +string number
        +OrderStatus status
        +Money subtotal
        +Money tax
        +Money total
        +DateTime placed_at
        +DateTime fulfilled_at
        +place()
        +fulfill()
        +cancel()
        +refund()
    }

    class OrderItem {
        +UUID id
        +UUID order_id
        +UUID product_id
        +UUID variant_id
        +string product_name
        +int quantity
        +Money unit_price
        +Money total
    }

    class Payment {
        +UUID id
        +UUID order_id
        +string stripe_payment_intent_id
        +PaymentStatus status
        +Money amount
        +DateTime paid_at
        +confirm()
        +refund()
    }

    Order "1" *-- "*" OrderItem
    Order "1" *-- "1" Payment
```

**State Machine:**

```mermaid
stateDiagram-v2
    [*] --> pending
    pending --> processing : place()
    processing --> fulfilled : fulfill()
    processing --> cancelled : cancel()
    fulfilled --> refunded : refund()
    cancelled --> [*]
    refunded --> [*]
```

#### License Aggregate

```mermaid
classDiagram
    class License {
        +UUID id
        +string key
        +UUID user_id
        +UUID product_id
        +UUID order_id
        +LicenseStatus status
        +DateTime expires_at
        +int download_count
        +activate()
        +deactivate()
        +incrementDownloads()
        +isExpired()
    }

    class LicenseDomainEvent {
        +UUID license_id
        +string event_type
        +DateTime occurred_at
    }

    License --> LicenseDomainEvent
```

## Bounded Context: Documentation

### Aggregates

```mermaid
classDiagram
    class Page {
        +UUID id
        +string slug
        +string title
        +text body
        +int sort_order
        +PageStatus status
        +UUID section_id
        +publish()
        +reorder()
    }

    class Section {
        +UUID id
        +string name
        +string slug
        +int sort_order
        +UUID parent_id
        +getPages()
    }

    class ComponentDoc {
        +UUID id
        +UUID product_id
        +string component_name
        +text description
        +json props
        +json events
        +json slots
        +json examples
    }

    class SearchResult {
        +UUID id
        +string type
        +string title
        +string url
        +float score
        +Collection highlights
    }

    Section "1" *-- "*" Page
    ComponentDoc "*" --> "1" Page
```

## Bounded Context: Billing

### Aggregates

```mermaid
classDiagram
    class Subscription {
        +UUID id
        +UUID user_id
        +string stripe_subscription_id
        +SubscriptionStatus status
        +Money monthly_price
        +DateTime current_period_start
        +DateTime current_period_end
        +DateTime canceled_at
        +subscribe()
        +cancel()
        +resume()
        +changePlan()
    }

    class Plan {
        +UUID id
        +string name
        +string slug
        +Money monthly_price
        +Money annual_price
        +int max_downloads
        +Collection features
        +isAvailable()
    }

    class Invoice {
        +UUID id
        +UUID user_id
        +string stripe_invoice_id
        +Money amount
        +InvoiceStatus status
        +DateTime issued_at
        +DateTime paid_at
        +getPdfUrl()
    }

    Subscription "1" --> "1" Plan
    User "1" --> "*" Subscription
    User "1" --> "*" Invoice
```

## Context Map Patterns

### Shared Kernel

The `User` model is shared between Authentication, Order, and License contexts. Changes require coordination.

```
Shared Kernel: User Model
├── Authentication: OAuth, password, roles
├── Order: user_id foreign key
├── License: user_id foreign key
└── Billing: subscription ownership
```

### Customer/Supplier

| Consumer | Supplier | Contract |
|----------|----------|----------|
| Order Context | Product Context | `ProductRepository::findAvailable()` |
| License Context | Order Context | `OrderFulfilled` event |
| Search Context | Product Context | `ProductIndexed` event |
| Billing Context | User Context | `User::currentSubscription()` |

### Anti-Corruption Layer

The Auth context uses an ACL when interacting with the User context to prevent external OAuth provider models from leaking into the domain.

```php
class OAuthUserProfileMapper
{
    public function mapFromGitHub(GitHubUser $github): array
    {
        return [
            'name' => $github->getName(),
            'email' => $github->getEmail(),
            'avatar_url' => $github->getAvatarUrl(),
        ];
    }
}
```

## Domain Services

| Service | Context | Responsibility |
|---------|---------|----------------|
| `PricingService` | Marketplace | Calculate totals, apply discounts, compute taxes |
| `FulfillmentService` | Order | Generate downloads, send licenses, deliver files |
| `SearchIndexerService` | Search | Index products, pages, components to Meilisearch |
| `SubscriptionService` | Billing | Manage plan changes, proration, renewals |
| `LicenseValidationService` | License | Validate keys, check expiration, rate limits |

## Invariant Summary

| Context | Invariant | Enforcement |
|---------|-----------|-------------|
| User | Email unique and verified | DB unique constraint + application check |
| Product | Published products need variants | `publish()` method validation |
| Order | Total = sum(items) + tax | `place()` calculation |
| License | Key format: GSMUI-XXXX-XXXX-XXXX | Regex + DB unique |
| Subscription | One active per user | Unique partial index |

## Related Documents

- [Backend Architecture](../Backend-Architecture/index.md)
- [ERD Diagrams](../../06-database/ERD/index.md)
- [Table Definitions](../../06-database/Tables/index.md)
- [Relationships](../../06-database/Relationships/index.md)
