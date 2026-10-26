---
title: Marketplace Products
description: Product types, submission process, review criteria, and pricing guidelines.
order: 15.1
group: Products
---

# Marketplace Products

The GsmUi Marketplace is a platform for discovering, purchasing, and distributing UI components, themes, templates, and plugins.

## Product Types

| Type | Description | Price Range |
|---|---|---|
| Component | Individual Livewire/Blade components | $5–$49 |
| Theme | Complete visual themes | $15–$99 |
| Template | Full page/application templates | $25–$149 |
| Plugin | Functional extensions | $10–$99 |
| Bundle | Collection of related products | $49–$299 |

### Component Products

| Category | Examples |
|---|---|
| Form | Date picker, rich text editor, file upload |
| Data | DataTable, chart, calendar |
| Navigation | Sidebar, mega menu, command palette |
| Feedback | Toast, alert, progress |
| Overlay | Modal, drawer, lightbox |

## Submission Process

### Submission Workflow

```
Creator account setup
    ↓
Product creation
    ↓
Upload assets
    ↓
Set pricing
    ↓
Submit for review
    ↓
Review process (1-3 days)
    ↓
Approval / Rejection
    ↓
Publish to marketplace
```

### Submission Requirements

| Requirement | Description |
|---|---|
| Code quality | PSR-12, Laravel conventions |
| Documentation | README with usage examples |
| Tests | PHPUnit or Pest tests |
| Assets | Screenshots, demo URL |
| License | Clear licensing terms |

### Submission Form

```blade
<gsmui:form wire:submit="submitProduct">
    <gsmui:form-field name="name" label="Product Name" required />
    <gsmui:form-field name="type" type="select" label="Product Type" :options="$types" required />
    <gsmui:form-field name="description" type="textarea" label="Description" rows="4" required />
    <gsmui:form-field name="price" type="number" label="Price ($)" min="0" step="0.01" />
    <gsmui:form-field name="category" type="select" label="Category" :options="$categories" required />
    <gsmui:form-field name="demo_url" type="url" label="Demo URL" />
    <gsmui:form-field name="repository" type="url" label="Repository URL" />
</gsmui:form>
```

## Review Criteria

### Quality Checklist

| Criterion | Weight | Minimum |
|---|---|---|
| Code quality | 25% | Pass PSR-12 |
| Documentation | 20% | README + API docs |
| Testing | 15% | 80% coverage |
| Design | 15% | Responsive, accessible |
| Performance | 10% | < 50KB bundle |
| Security | 10% | No vulnerabilities |
| Uniqueness | 5% | Non-duplicate |

### Review Stages

| Stage | Reviewer | Duration |
|---|---|---|
| Automated | CI checks | Instant |
| Code review | Team member | 1-2 days |
| Design review | UI designer | 1 day |
| Final approval | Marketplace team | 1 day |

### Review Decision

| Decision | Action |
|---|---|
| Approved | Published immediately |
| Revision needed | Returned with feedback |
| Rejected | Rejected with reason |

## Pricing Guidelines

### Pricing Tiers

| Tier | Price | Typical Products |
|---|---|---|
| Free | $0 | Simple components |
| Entry | $5–$15 | Single components |
| Standard | $15–$49 | Complex components |
| Premium | $49–$99 | Templates, bundles |
| Enterprise | $99+ | Complete solutions |

### Revenue Split

| Platform | Creator |
|---|---|
| 20% | 80% |

### Payment Methods

| Method | Payout Schedule |
|---|---|
| Stripe | Weekly |
| PayPal | Monthly |
| Bank transfer | Monthly |

## Product Listing

### Listing Display

```
┌─────────────────────────────────────────────┐
│ 📦 Advanced Date Picker                     │
│ by John Smith ⭐⭐⭐⭐⭐ (4.9)             │
├─────────────────────────────────────────────┤
│ [Screenshot]                                │
│                                             │
│ A feature-rich date picker with range      │
│ selection, time picker, and localization.   │
│                                             │
│ $24.99  |  [Buy Now]  |  [Preview]         │
│                                             │
│ v2.1.0  |  Updated Jan 15, 2024            │
│ Laravel 10+ | Livewire 3.x                 │
└─────────────────────────────────────────────┘
```

### Listing Schema

| Field | Required | Description |
|---|---|---|
| `name` | Yes | Product name |
| `description` | Yes | Short description |
| `price` | Yes | Price in USD |
| `category` | Yes | Product category |
| `screenshots` | Yes | At least 3 images |
| `demo_url` | No | Live demo link |
| `documentation` | Yes | Usage docs |
| `changelog` | Yes | Version history |

## Product Management

### Creator Dashboard

| Section | Description |
|---|---|
| Products | Manage listings |
| Sales | View transactions |
| Analytics | Usage statistics |
| Support | Customer inquiries |

### Product Actions

| Action | Description |
|---|---|
| Edit | Update listing |
| Archive | Remove from sale |
| Update | Release new version |
| Duplicate | Clone product |

## Licensing

| License | Price | Usage |
|---|---|---|
| Single site | Base price | 1 project |
| Multi site | 2× base | 5 projects |
| Unlimited | 3× base | Unlimited |
| Enterprise | Custom | White-label |

## Marketplace Configuration

```php
// config/marketplace.php
return [
    'enabled' => true,
    'commission_rate' => 0.20,
    'min_price' => 0,
    'max_price' => 999,
    'review_period_days' => 3,
    'payout_schedule' => 'weekly',
    'allowed_types' => ['component', 'theme', 'template', 'plugin', 'bundle'],
];
```
