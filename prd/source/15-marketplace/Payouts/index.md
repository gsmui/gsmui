---
title: Payout System
description: Payout schedule, payout methods, commission rates, and tax reporting.
order: 15.9
group: Payouts
---

# Payout System

The GsmUi Marketplace payout system handles creator payments, commission tracking, and tax reporting.

## Payout Features

| Feature | Description |
|---|---|
| Payout schedule | Automatic payouts |
| Multiple methods | Stripe, PayPal, bank transfer |
| Commission tracking | Platform fees |
| Tax reporting | 1099 and tax documents |
| Balance management | Real-time balance |

## Payout Schedule

### Schedule Options

| Schedule | Frequency | Minimum | Fee |
|---|---|---|---|
| Weekly | Every Monday | $50 | Free |
| Bi-weekly | 1st & 15th | $50 | Free |
| Monthly | 1st of month | $100 | Free |
| Manual | On demand | $50 | $2 |

### Schedule Configuration

```blade
<gsmui:form wire:submit="updatePayoutSchedule">
    <gsmui:form-field
        name="schedule"
        type="select"
        label="Payout Schedule"
        :options="[
            'weekly' => 'Weekly',
            'bi-weekly' => 'Bi-weekly',
            'monthly' => 'Monthly',
        ]"
    />

    <gsmui:form-field
        name="minimum"
        type="number"
        label="Minimum Payout ($)"
        :min="50"
    />
</gsmui:form>
```

## Payout Methods

### Supported Methods

| Method | Currency | Processing Time | Fee |
|---|---|---|---|
| Stripe | USD, EUR, GBP | 2-5 days | 2.9% + $0.30 |
| PayPal | USD | Instant | 3.49% + $0.49 |
| Bank Transfer | USD | 3-5 days | $5 |
| Wire Transfer | USD, EUR | 1-2 days | $25 |

### Method Selection

```blade
<gsmui:payout-methods
    :methods="$availableMethods"
    :active="$activeMethod"
    wire:model="selectedMethod"
/>
```

### Method Display

```
┌─────────────────────────────────────────────┐
│ 💳 Payout Methods                           │
├─────────────────────────────────────────────┤
│ ● Stripe (•••• 4242)      [Edit] [Delete]  │
│ ○ PayPal (john@email.com) [Edit] [Delete]  │
│ + Add New Method                           │
└─────────────────────────────────────────────┘
```

### Method Schema

| Field | Description |
|---|---|
| `type` | Method type |
| `account` | Account identifier |
| `verified` | Verification status |
| `default` | Default method |
| `added_at` | Addition date |

## Commission Rates

### Commission Structure

| Product Type | Commission | Creator Gets |
|---|---|---|
| Component | 20% | 80% |
| Theme | 20% | 80% |
| Template | 20% | 80% |
| Plugin | 20% | 80% |
| Bundle | 15% | 85% |

### Volume Discounts

| Monthly Revenue | Commission | Creator Gets |
|---|---|---|
| $0–$1,000 | 20% | 80% |
| $1,001–$5,000 | 18% | 82% |
| $5,001–$10,000 | 15% | 85% |
| $10,001+ | 12% | 88% |

### Commission Tracking

```php
$earnings = [
    'gross' => 12450.00,
    'commission' => 2490.00,
    'net' => 9960.00,
    'payouts' => 6760.00,
    'balance' => 3200.00,
];
```

## Balance Management

### Balance Display

```blade
<x-gsmui:balance-card
    :balance="$balance"
    :pending="$pending"
    :next-payout="$nextPayout"
/>
```

### Balance Output

```
┌─────────────────────────────────────────────┐
│ 💰 Balance Summary                          │
├─────────────────────────────────────────────┤
│ Available Balance    $3,200.00              │
│ Pending              $800.00                │
│ ─────────────────────────────              │
│ Total               $4,000.00              │
│                                             │
│ Next payout: Apr 15, 2024                  │
│ Method: Stripe (•••• 4242)                  │
│ Estimated amount: $3,200.00                 │
└─────────────────────────────────────────────┘
```

### Balance Breakdown

| Source | Amount |
|---|---|
| Product sales | $9,960.00 |
| Bundle sales | $1,800.00 |
| Theme sales | $690.00 |
| Refunds | -$180.00 |
| **Net** | **$12,270.00** |

## Tax Reporting

### Tax Documents

| Document | Purpose | Available |
|---|---|---|
| 1099-K | US tax reporting | January |
| Earnings report | Income tracking | Monthly |
| Commission statement | Fee breakdown | Monthly |
| Transaction log | Detailed transactions | Real-time |

### Tax Information Form

```blade
<gsmui:form wire:submit="updateTaxInfo">
    <gsmui:form-field
        name="tax_id"
        label="Tax ID (SSN or EIN)"
        placeholder="XXX-XX-XXXX"
    />

    <gsmui:form-field
        name="w9_completed"
        type="toggle"
        label="W-9 completed"
        :description="'Required for US creators earning $600+'"
    />
</gsmui:form>
```

### Tax Thresholds

| Region | Threshold | Document Required |
|---|---|---|
| US | $600/year | 1099-K |
| EU | €1,000/year | Tax report |
| UK | £1,000/year | Tax report |
| Other | Varies | Local form |

## Payout History

### Transaction Log

```blade
<x-gsmui:payout-history
    :transactions="$transactions"
    :filters="['type', 'status', 'date']"
/>
```

### Transaction Table

| Date | Type | Description | Amount | Status |
|---|---|---|---|---|
| Apr 1 | Payout | Stripe payout | -$2,450 | Completed |
| Apr 1 | Sale | Button Pro | +$23.20 | Completed |
| Apr 1 | Sale | Modal Kit | +$39.20 | Completed |
| Mar 31 | Refund | Modal Kit refund | -$49.00 | Completed |

### Transaction Types

| Type | Description |
|---|---|
| Sale | Product sale |
| Payout | Payout to creator |
| Refund | Product refund |
| Adjustment | Manual adjustment |
| Bonus | Promotional bonus |

## Payout Configuration

```php
// config/marketplace.php
return [
    'payouts' => [
        'enabled' => true,
        'minimum' => 50,
        'schedule' => 'bi-weekly',
        'methods' => ['stripe', 'paypal', 'bank_transfer'],
        'commission_rates' => [
            'default' => 0.20,
            'bundle' => 0.15,
        ],
        'volume_discounts' => [
            ['threshold' => 1000, 'rate' => 0.18],
            ['threshold' => 5000, 'rate' => 0.15],
            ['threshold' => 10000, 'rate' => 0.12],
        ],
        'tax' => [
            'enabled' => true,
            'threshold_us' => 600,
        ],
    ],
];
```
