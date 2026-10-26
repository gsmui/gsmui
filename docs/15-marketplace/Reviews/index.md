---
title: Review System
description: Review submission, moderation, helpful votes, and developer responses.
order: 15.5
group: Reviews
---

# Review System

The GsmUi Marketplace includes a review system for product feedback and quality assessment.

## Review Features

| Feature | Description |
|---|---|
| Star ratings | 1-5 star rating system |
| Written reviews | Detailed text reviews |
| Helpful votes | Community voting |
| Developer responses | Creator replies |
| Moderation | Content moderation |

## Review Display

### Review Card

```blade
<x-gsmui:review-card
    :review="$review"
    :show-helpful="true"
    :show-response="true"
/>
```

### Review Card Output

```
┌─────────────────────────────────────────────┐
│ ⭐⭐⭐⭐⭐  Great component!                │
│ by John D. · Verified Purchase · 3 days ago │
├─────────────────────────────────────────────┤
│ This date picker saved me hours of work.    │
│ The range selection and localization are    │
│ exactly what I needed.                      │
│                                             │
│ 👍 12 helpful  |  💬 Reply                  │
├─────────────────────────────────────────────┤
│ 💬 Developer Response (Jan 16, 2024)        │
│ Thanks John! Glad it helped.                │
└─────────────────────────────────────────────┘
```

### Review Schema

| Field | Type | Description |
|---|---|---|
| `id` | int | Review ID |
| `user` | object | Review author |
| `rating` | int | 1-5 stars |
| `title` | string | Review title |
| `content` | string | Review text |
| `verified` | bool | Verified purchase |
| `helpful` | int | Helpful vote count |
| `response` | object | Developer reply |
| `created_at` | timestamp | Review date |

## Review Submission

### Submit Form

```blade
<gsmui:form wire:submit="submitReview">
    <gsmui:form-field name="rating" label="Rating" required>
        <gsmui:star-rating wire:model="rating" :max="5" />
    </gsmui:form-field>

    <gsmui:form-field
        name="title"
        label="Review title"
        placeholder="Summarize your experience"
        required
    />

    <gsmui:form-field
        name="content"
        type="textarea"
        label="Your review"
        rows="4"
        placeholder="Tell others about your experience..."
        required
    />

    <gsmui:button type="submit" variant="primary">Submit Review</gsmui:button>
</gsmui:form>
```

### Submission Guidelines

| Rule | Description |
|---|---|
| Purchase required | Must own product |
| One review per product | Can edit existing |
| Content policy | No spam, harassment |
| Language | English only |

### Review Validation

```php
public function rules(): array
{
    return [
        'rating' => 'required|integer|min:1|max:5',
        'title' => 'required|string|max:100',
        'content' => 'required|string|min:10|max:1000',
    ];
}
```

## Moderation

### Moderation Queue

```
┌─────────────────────────────────────────────┐
│ 📋 Review Moderation Queue (3 pending)      │
├─────────────────────────────────────────────┤
│ Review 1: ⭐⭐⭐⭐⭐ "Great!"              │
│ [Approve] [Reject] [Flag]                  │
├─────────────────────────────────────────────┤
│ Review 2: ⭐ "Bad"                         │
│ [Approve] [Reject] [Flag]                  │
├─────────────────────────────────────────────┤
│ Review 3: ⭐⭐⭐ "Okay"                    │
│ [Approve] [Reject] [Flag]                  │
└─────────────────────────────────────────────┘
```

### Moderation Rules

| Rule | Action |
|---|---|
| Spam | Auto-reject |
| Harassment | Auto-reject + ban |
| Profanity | Flag for review |
| Off-topic | Flag for review |
| Low quality | Flag for review |

### Moderation Actions

| Action | Description |
|---|---|
| Approve | Publish review |
| Reject | Remove review |
| Flag | Mark for review |
| Edit | Moderator edit |
| Ban user | Prevent future reviews |

## Helpful Votes

### Voting Interface

```blade
<gsmui:helpful-votes
    :review-id="$review['id']"
    :count="$review['helpful']"
    wire:model="helpfulCount"
/>
```

### Voting Rules

| Rule | Description |
|---|---|
| One vote per user | Prevents abuse |
| Verified purchase | Only buyers can vote |
| Public voting | Votes are visible |

### Helpful Display

```
👍 12 helpful  ·  👎 2 unhelpful
```

## Developer Responses

### Response Interface

```blade
<gsmui:review-response
    :review="$review"
    wire:model="response"
>
    <gsmui:form-field
        name="response"
        type="textarea"
        label="Your response"
        rows="3"
        placeholder="Thank the reviewer or address their feedback..."
    />

    <gsmui:button type="submit" variant="primary" size="sm">
        Post Response
    </gsmui:button>
</gsmui:review-response>
```

### Response Rules

| Rule | Description |
|---|---|
| Creator only | Only product creator |
| One response | Can edit response |
| Public | Response is visible |
| Timely | Within 30 days |

### Response Display

```
💬 Developer Response (Jan 16, 2024)
Thanks for the kind words! I'm glad the range
selection worked well for your use case.
```

## Review Analytics

### Review Summary

| Metric | Value |
|---|---|
| Total reviews | 45 |
| Average rating | 4.8 |
| 5-star reviews | 35 |
| 4-star reviews | 7 |
| 3-star reviews | 2 |
| 2-star reviews | 1 |
| 1-star reviews | 0 |

### Rating Distribution

```
5★ ████████████████████ 35 (78%)
4★ ████ 7 (16%)
3★ █ 2 (4%)
2★ ▏ 1 (2%)
1★ 0 (0%)
```

## Review Configuration

```php
// config/marketplace.php
return [
    'reviews' => [
        'enabled' => true,
        'moderation' => true,
        'verified_badge' => true,
        'helpful_votes' => true,
        'developer_responses' => true,
        'min_length' => 10,
        'max_length' => 1000,
    ],
];
```
