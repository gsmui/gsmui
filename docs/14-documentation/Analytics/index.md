---
title: Documentation Analytics
description: Page views, search queries, feedback, popular pages, and content gaps.
order: 14.10
group: Analytics
---

# Documentation Analytics

GsmUi documentation includes built-in analytics for understanding user behavior and content effectiveness.

## Analytics Features

| Feature | Description |
|---|---|
| Page Views | Traffic tracking |
| Search Queries | What users search for |
| Feedback | User ratings and comments |
| Popular Pages | Most visited content |
| Content Gaps | Missing or weak content |

## Page Views

### Tracking Implementation

```html
<!-- Auto-included in docs pages -->
<script>
    gsmuiAnalytics.track('page_view', {
        path: '/docs/components/button',
        title: 'Button Component',
        referrer: document.referrer,
    });
</script>
```

### Page View Metrics

| Metric | Description |
|---|---|
| Views | Total page views |
| Unique Views | Unique visitors |
| Time on Page | Average read time |
| Bounce Rate | Single-page exits |
| Scroll Depth | How far users scroll |

### Page View Dashboard

```
┌─────────────────────────────────────────────┐
│ 📊 Documentation Analytics                  │
├─────────────────────────────────────────────┤
│ Total Views: 125,430    ↑ 12% vs last month│
│ Unique Visitors: 45,200  ↑ 8%              │
│ Avg. Time on Page: 3m 42s                   │
│ Bounce Rate: 32%         ↓ 5%              │
└─────────────────────────────────────────────┘
```

### View Tracking Table

| Page | Views | Unique | Avg. Time | Bounce |
|---|---|---|---|---|
| `/components/button` | 15,230 | 8,450 | 4:12 | 28% |
| `/components/input` | 12,890 | 7,230 | 3:45 | 31% |
| `/components/modal` | 11,450 | 6,890 | 5:20 | 25% |
| `/getting-started` | 18,900 | 12,300 | 2:15 | 45% |

## Search Queries

### Search Analytics

| Metric | Description |
|---|---|
| Queries | Total searches |
| Unique Queries | Distinct searches |
| No Results | Failed searches |
| Click-through | Search → page click |
| Position | Average result position |

### Search Query Log

```json
{
  "query": "button loading state",
  "results_count": 3,
  "clicked_result": "button#loading",
  "position": 1,
  "timestamp": "2024-01-15T10:30:00Z"
}
```

### Top Searches

| Rank | Query | Results | Click Rate |
|---|---|---|---|
| 1 | button | 5 | 89% |
| 2 | modal | 4 | 85% |
| 3 | form validation | 8 | 72% |
| 4 | dark mode | 6 | 68% |
| 5 | toast notification | 3 | 91% |

### Failed Searches

| Query | Count | Suggestion |
|---|---|---|
| "datepicker" | 45 | Create date-picker page |
| "loading spinner" | 32 | Improve spinner docs |
| "validation rules" | 28 | Add validation guide |

## Feedback System

### Feedback Widget

```blade
<x-gsmui:feedback-widget :page="$currentPage" />

<!-- Output -->
<div class="feedback-widget">
    <p>Was this page helpful?</p>
    <button>👍 Yes</button>
    <button>👎 No</button>
</div>
```

### Feedback Data

| Field | Type | Description |
|---|---|---|
| `page` | string | Page path |
| `rating` | int | 1-5 stars or thumbs |
| `comment` | string | Optional comment |
| `timestamp` | datetime | Feedback time |

### Feedback Analytics

| Page | Rating | Comments | Issues |
|---|---|---|---|
| `/components/button` | 4.8 | 12 | 2 |
| `/components/input` | 4.6 | 8 | 3 |
| `/components/modal` | 4.9 | 5 | 1 |
| `/getting-started` | 4.2 | 15 | 8 |

## Popular Pages

### Ranking Algorithm

```
Score = (Views × 0.3) + (Time × 0.3) + (Rating × 0.2) + (Links × 0.2)
```

### Popular Pages List

| Rank | Page | Score | Views | Rating |
|---|---|---|---|---|
| 1 | Getting Started | 92 | 18,900 | 4.2 |
| 2 | Button | 88 | 15,230 | 4.8 |
| 3 | Input | 85 | 12,890 | 4.6 |
| 4 | Modal | 82 | 11,450 | 4.9 |
| 5 | Form | 79 | 9,870 | 4.5 |

### Trending Pages

| Page | Trend | Change |
|---|---|---|
| `/components/color-picker` | 📈 | +150% |
| `/components/slider` | 📈 | +85% |
| `/livewire/tabs` | 📈 | +60% |
| `/theming` | 📈 | +45% |

## Content Gaps

### Gap Detection

| Gap Type | Detection Method |
|---|---|
| Low rating | Pages with < 4.0 rating |
| High bounce | Pages with > 50% bounce |
| No results | Search queries with 0 results |
| Outdated | Pages not updated in 6+ months |

### Content Gap Report

| Gap | Severity | Recommendation |
|---|---|---|
| Date picker docs | High | Create comprehensive guide |
| Validation rules | Medium | Add validation reference |
| Migration guide | High | Create v2→v3 migration |
| Theming guide | Medium | Expand theming docs |

### Gap Priorities

| Priority | Criteria |
|---|---|
| Critical | High traffic + low rating |
| High | High traffic + high bounce |
| Medium | Frequent searches + no results |
| Low | Low traffic + outdated |

## Analytics Dashboard

### Dashboard Components

| Widget | Description |
|---|---|
| Traffic Overview | Views, visitors, trends |
| Search Overview | Top queries, failures |
| Content Performance | Page rankings |
| Feedback Summary | Ratings, issues |
| Gap Analysis | Missing content |

### Dashboard Layout

```
┌──────────────────────┬──────────────────────┐
│ 📊 Traffic Overview  │ 🔍 Search Overview   │
│                      │                      │
│  [Line chart]        │  [Bar chart]         │
│                      │                      │
├──────────────────────┼──────────────────────┤
│ 📄 Popular Pages     │ 💬 Feedback          │
│                      │                      │
│  [Table]             │  [Rating breakdown]  │
│                      │                      │
├──────────────────────┴──────────────────────┤
│ 🔍 Content Gaps                              │
│                                             │
│  [Gap cards]                                │
│                                             │
└─────────────────────────────────────────────┘
```

## Configuration

```php
// config/docs.php
return [
    'analytics' => [
        'enabled' => true,
        'provider' => 'internal', // 'internal', 'plausible', 'umami'
        'feedback' => true,
        'search_tracking' => true,
        'retention_days' => 90,
    ],
];
```
