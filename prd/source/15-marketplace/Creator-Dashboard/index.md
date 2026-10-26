---
title: Creator Dashboard
description: Product management, sales analytics, payout tracking, and support tools.
order: 15.8
group: Creator Dashboard
---

# Creator Dashboard

The Creator Dashboard provides marketplace sellers with tools to manage products, track sales, and engage with customers.

## Dashboard Features

| Feature | Description |
|---|---|
| Product Management | CRUD for listings |
| Sales Analytics | Revenue and trends |
| Payout Tracking | Payment history |
| Customer Support | Inquiry management |
| Performance Metrics | Quality scores |

## Dashboard Layout

### Main Dashboard

```
┌─────────────────────────────────────────────┐
│ 📊 Creator Dashboard                        │
├──────────┬──────────────────────────────────┤
│ Sidebar  │ Overview                         │
│          │                                  │
│ Products │ Revenue: $12,450 (+15%)         │
│ Sales    │ Sales: 234 (+12%)               │
│ Payouts  │ Avg Rating: 4.8                  │
│ Support  │                                  │
│ Settings │ [Chart: Monthly Revenue]         │
│          │                                  │
│          │ Recent Sales                     │
│          │ ┌────────────────────────────┐   │
│          │ │ 1. Button Pro - $29       │   │
│          │ │ 2. Modal Kit - $49        │   │
│          │ │ 3. Theme - $39            │   │
│          │ └────────────────────────────┘   │
└──────────┴──────────────────────────────────┘
```

## Product Management

### Product List

```blade
<x-gsmui:creator-products
    :products="$products"
    :stats="$productStats"
/>
```

### Product Table

| Product | Price | Sales | Revenue | Rating |
|---|---|---|---|---|
| Button Pro | $29 | 89 | $2,581 | 4.8 |
| Modal Kit | $49 | 56 | $2,744 | 4.9 |
| Ocean Theme | $39 | 45 | $1,755 | 4.7 |
| Form Builder | $79 | 34 | $2,686 | 4.6 |

### Product Actions

| Action | Description |
|---|---|
| Edit | Update listing |
| Archive | Remove from sale |
| Duplicate | Clone product |
| Analytics | View stats |
| Support | View inquiries |

### Product Editor

```blade
<gsmui:form wire:submit="saveProduct">
    <gsmui:form-field name="name" label="Product Name" required />
    <gsmui:form-field name="description" type="textarea" label="Description" rows="4" />
    <gsmui:form-field name="price" type="number" label="Price ($)" min="0" step="0.01" />
    <gsmui:form-field name="category" type="select" label="Category" :options="$categories" />
    <gsmui:form-field name="tags" label="Tags" :tags="true" />
</gsmui:form>
```

## Sales Analytics

### Revenue Chart

```blade
<x-gsmui:sales-chart
    :data="$salesData"
    type="line"
    :period="'monthly'"
    height="300"
/>
```

### Revenue Metrics

| Metric | Current | Previous | Change |
|---|---|---|---|
| Revenue | $12,450 | $10,820 | +15% |
| Orders | 234 | 209 | +12% |
| Avg Order | $53.20 | $51.77 | +3% |
| Refunds | $180 | $210 | -14% |

### Sales Breakdown

| Product | Sales | Revenue | % of Total |
|---|---|---|---|
| Button Pro | 89 | $2,581 | 20.7% |
| Modal Kit | 56 | $2,744 | 22.0% |
| Ocean Theme | 45 | $1,755 | 14.1% |
| Form Builder | 34 | $2,686 | 21.6% |
| Other | 10 | $2,684 | 21.6% |

### Sales Trend

```
Monthly Sales (2024)
Jan: ████████████ $8,200
Feb: ██████████████ $9,800
Mar: ████████████████ $11,200
Apr: ██████████████████ $12,450
```

## Payout Tracking

### Payout History

```blade
<x-gsmui:payout-history
    :payouts="$payouts"
    :balance="$currentBalance"
/>
```

### Payout Table

| Date | Amount | Method | Status |
|---|---|---|---|
| Apr 1 | $2,450 | Stripe | ✅ Completed |
| Mar 15 | $1,800 | Stripe | ✅ Completed |
| Mar 1 | $2,100 | PayPal | ✅ Completed |
| Feb 15 | $1,950 | Stripe | ✅ Completed |

### Payout Summary

| Metric | Amount |
|---|---|
| Current Balance | $3,200 |
| Pending | $800 |
| Last Payout | $2,450 |
| Next Payout | Apr 15 |

## Customer Support

### Support Inbox

```blade
<x-gsmui:support-inbox
    :inquiries="$inquiries"
    :unread-count="$unreadCount"
/>
```

### Support Metrics

| Metric | Count | Status |
|---|---|---|
| Open inquiries | 5 | 🔴 Needs attention |
| Responded today | 12 | ✅ |
| Avg response time | 2.5 hours | ✅ |
| Satisfaction | 4.7/5 | ✅ |

### Inquiry List

| Customer | Product | Subject | Status |
|---|---|---|---|
| John D. | Button Pro | Integration help | Open |
| Jane S. | Modal Kit | Feature request | Open |
| Bob W. | Ocean Theme | Customization | Responded |

## Performance Metrics

### Quality Score

| Metric | Score | Status |
|---|---|---|
| Code Quality | 92/100 | ✅ |
| Documentation | 88/100 | ✅ |
| Support | 95/100 | ✅ |
| Customer Rating | 4.8/5 | ✅ |

### Seller Badges

| Badge | Criteria | Status |
|---|---|---|
| Top Seller | > 100 sales | ✅ |
| Fast Response | < 4hr response | ✅ |
| High Quality | > 4.5 rating | ✅ |
| Verified | Identity verified | ✅ |

## Dashboard Configuration

```php
// config/marketplace.php
return [
    'creator' => [
        'enabled' => true,
        'min_products' => 1,
        'analytics_retention' => 365,
        'support_enabled' => true,
        'payout_threshold' => 50,
    ],
];
```
