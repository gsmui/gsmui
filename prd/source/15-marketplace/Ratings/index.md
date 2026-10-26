---
title: Rating System
description: Star ratings, rating criteria, aggregate scores, and rating display.
order: 15.6
group: Ratings
---

# Rating System

The GsmUi Marketplace rating system provides structured product ratings with multiple criteria and aggregate scoring.

## Rating Features

| Feature | Description |
|---|---|
| Star ratings | 1-5 star visual rating |
| Multi-criteria | Rate different aspects |
| Aggregate score | Weighted average |
| Rating badges | Visual quality indicators |
| Trend tracking | Rating changes over time |

## Star Ratings

### Rating Display

```blade
<gsmui:star-rating :rating="4.8" :max="5" :show-value="true" />
```

### Rating Output

```
⭐⭐⭐⭐⭐ 4.8 (45 reviews)
```

### Star Sizes

| Size | Dimensions | Use Case |
|---|---|---|
| `sm` | `h-3 w-3` | Inline ratings |
| `md` | `h-4 w-4` | Card ratings |
| `lg` | `h-5 w-5` | Featured ratings |
| `xl` | `h-6 w-6` | Hero ratings |

## Rating Criteria

### Criteria Types

| Criterion | Weight | Description |
|---|---|---|
| Quality | 30% | Code quality, best practices |
| Documentation | 20% | Docs clarity, examples |
| Support | 20% | Developer responsiveness |
| Value | 15% | Price vs features |
| Design | 15% | Visual quality, UX |

### Multi-Criteria Form

```blade
<gsmui:rating-criteria
    wire:model="ratings"
    :criteria="[
        ['key' => 'quality', 'label' => 'Code Quality'],
        ['key' => 'documentation', 'label' => 'Documentation'],
        ['key' => 'support', 'label' => 'Support'],
        ['key' => 'value', 'label' => 'Value'],
        ['key' => 'design', 'label' => 'Design'],
    ]"
/>
```

### Criteria Output

```
Quality       ⭐⭐⭐⭐⭐ 5.0
Documentation ⭐⭐⭐⭐½ 4.5
Support       ⭐⭐⭐⭐⭐ 4.8
Value         ⭐⭐⭐⭐ 4.2
Design        ⭐⭐⭐⭐⭐ 4.9

Overall: ⭐⭐⭐⭐⭐ 4.7
```

## Aggregate Scores

### Score Calculation

```php
function calculateAggregateScore(array $ratings): float
{
    $weights = [
        'quality' => 0.30,
        'documentation' => 0.20,
        'support' => 0.20,
        'value' => 0.15,
        'design' => 0.15,
    ];

    $total = 0;
    foreach ($weights as $criterion => $weight) {
        $total += $ratings[$criterion] * $weight;
    }

    return round($total, 1);
}
```

### Aggregate Display

| Score Range | Badge | Label |
|---|---|---|
| 4.5–5.0 | ⭐⭐⭐⭐⭐ | Excellent |
| 4.0–4.4 | ⭐⭐⭐⭐ | Great |
| 3.5–3.9 | ⭐⭐⭐½ | Good |
| 3.0–3.4 | ⭐⭐⭐ | Average |
| < 3.0 | ⭐⭐ | Below Average |

## Rating Display

### Product Rating Card

```blade
<x-gsmui:product-rating
    :product="$product"
    :rating="$product['aggregate_rating']"
    :review-count="$product['review_count']"
    :criteria="$product['criteria']"
/>
```

### Rating Card Output

```
┌─────────────────────────────────────────────┐
│ 📊 Rating Summary                           │
├─────────────────────────────────────────────┤
│ Overall: ⭐⭐⭐⭐⭐ 4.8 (45 reviews)      │
│                                             │
│ Quality:       ██████████ 5.0              │
│ Documentation: ████████░ 4.5              │
│ Support:       █████████░ 4.8              │
│ Value:         ████████░ 4.2              │
│ Design:        █████████░ 4.9              │
└─────────────────────────────────────────────┘
```

### Rating Badge

```blade
<gsmui:rating-badge :rating="4.8" size="md" />
```

### Badge Output

```
┌───────────┐
│ ⭐ 4.8    │
│ Excellent │
└───────────┘
```

## Rating Trends

### Trend Display

```blade
<gsmui:rating-trend
    :current="4.8"
    :previous="4.5"
    :period="30"
/>
```

### Trend Output

```
4.8 ⬆ +0.3 (30 days)
```

### Trend Indicators

| Change | Icon | Color |
|---|---|---|
| Increase | ⬆ | Green |
| Decrease | ⬇ | Red |
| Stable | ➡ | Gray |

## Rating History

### History Chart

```blade
<gsmui:rating-chart
    :data="$ratingHistory"
    type="line"
    height="200"
/>
```

### History Data

```php
$ratingHistory = [
    ['date' => '2024-01-01', 'rating' => 4.5, 'count' => 30],
    ['date' => '2024-01-08', 'rating' => 4.6, 'count' => 35],
    ['date' => '2024-01-15', 'rating' => 4.8, 'count' => 45],
];
```

## Rating Management

### Rating Actions

| Action | Description |
|---|---|
| Edit | Update your rating |
| Delete | Remove your rating |
| Flag | Report inappropriate rating |

### Creator View

| Metric | Description |
|---|---|
| Average rating | Overall score |
| Rating count | Total reviews |
| Trend | Rating change |
| Criteria breakdown | Per-criterion scores |

## Rating Configuration

```php
// config/marketplace.php
return [
    'ratings' => [
        'enabled' => true,
        'min_rating' => 1,
        'max_rating' => 5,
        'criteria' => [
            'quality' => ['weight' => 0.30, 'label' => 'Quality'],
            'documentation' => ['weight' => 0.20, 'label' => 'Documentation'],
            'support' => ['weight' => 0.20, 'label' => 'Support'],
            'value' => ['weight' => 0.15, 'label' => 'Value'],
            'design' => ['weight' => 0.15, 'label' => 'Design'],
        ],
        'display' => [
            'show_criteria' => true,
            'show_trend' => true,
            'show_distribution' => true,
        ],
    ],
];
```
