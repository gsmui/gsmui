# 23 - Search

**Project:** GsmUi
**Version:** 1.0.0

---

# Purpose

Search is a first-class capability in GsmUi, enabling users to find components, documentation, themes, templates, blog posts, and marketplace products in milliseconds.

---

# Vision

Provide instant, accurate search across the entire GsmUi platform with a beautiful, keyboard-driven experience.

---

# Core Features

## Search Experience

* Instant results (<100ms)
* Keyboard navigation (Cmd+K)
* Fuzzy matching
* Category filtering
* Recent searches
* Saved searches
* Search suggestions

## Searchable Content

* Components
* Documentation
* Templates
* Themes
* Blog posts
* Marketplace products
* Showcase projects
* API reference

---

# Search UI

## Command Palette

```text
┌─────────────────────────────────────────┐
│ 🔍 Search GsmUi...                     │
├─────────────────────────────────────────┤
│                                         │
│ Recent                                  │
│ ───────────────────────────────────────│
│ 🔍 button component                     │
│ 🔍 installation guide                   │
│ 🔍 dark mode theme                      │
│                                         │
│ Suggestions                             │
│ ───────────────────────────────────────│
│ 📦 Components                           │
│    Button, Input, Card, Modal           │
│ 📚 Documentation                        │
│    Getting Started, Installation        │
│ 🎨 Themes                               │
│    Default, Dark, Ocean                 │
│ 📝 Blog                                 │
│    Latest posts...                      │
│                                         │
├─────────────────────────────────────────┤
│ ↑↓ Navigate  ↵ Select  esc Close       │
└─────────────────────────────────────────┘
```

## Search Results

```text
Search Results: "button"
─────────────────────────────────────────

Components (3)
──────────────
📦 Button
   Production-ready button component
   Category: Actions  ⭐ 4.9

📦 IconButton
   Icon-only button variant
   Category: Actions  ⭐ 4.8

📦 SplitButton
   Button with dropdown
   Category: Actions  ⭐ 4.7

Documentation (5)
──────────────────
📚 Button Documentation
   Complete guide to button component

📚 Getting Started
   Installation and setup guide

Themes (2)
───────────
🎨 Default Theme
   Includes button styles

🎨 Dark Theme
   Dark mode button styles
```

---

# Search Architecture

## Index Structure

```text
Search Index (Meilisearch)

├── Components
│   ├── Name (weighted: high)
│   ├── Description (weighted: medium)
│   ├── Category (weighted: low)
│   ├── Props (weighted: medium)
│   └── Tags (weighted: medium)
├── Documentation
│   ├── Title (weighted: high)
│   ├── Content (weighted: medium)
│   └── Category (weighted: low)
├── Templates
│   ├── Name (weighted: high)
│   ├── Description (weighted: medium)
│   ├── Features (weighted: medium)
│   └── Tags (weighted: medium)
├── Themes
│   ├── Name (weighted: high)
│   ├── Description (weighted: medium)
│   └── Tags (weighted: medium)
├── Blog Posts
│   ├── Title (weighted: high)
│   ├── Content (weighted: medium)
│   ├── Tags (weighted: medium)
│   └── Author (weighted: low)
└── Marketplace
    ├── Name (weighted: high)
    ├── Description (weighted: medium)
    ├── Features (weighted: medium)
    └── Tags (weighted: medium)
```

## Indexing Pipeline

```text
Content Created/Updated
    ↓
Event Dispatched
    ↓
Index Job Queued
    ↓
Content Parsed
    ↓
Metadata Extracted
    ↓
Meilisearch Updated
    ↓
Search Available
```

---

# Search Features

## Autocomplete

```text
User types: "but"
    ↓
Suggestions:
    ├── button (component)
    ├── button-group (component)
    ├── Getting Started (doc)
    └── "button" in blog posts
```

## Faceted Search

```text
Filter by:
─────────
Category: [Components] [Docs] [Templates]
Type:     [Actions] [Forms] [Layout]
Price:    [Free] [Premium]
Rating:   [4+ stars] [3+ stars]
```

## Advanced Search

* Exact phrase matching
* Wildcard search
* Boolean operators
* Field-specific search
* Date range filtering

---

# Keyboard Navigation

| Shortcut | Action |
|----------|--------|
| Cmd+K / Ctrl+K | Open search |
| ↑↓ | Navigate results |
| Enter | Select result |
| Escape | Close search |
| Tab | Switch categories |
| / | Focus search input |

---

# Search Analytics

Track search effectiveness:

* Query frequency
* Click-through rate
* Zero-result queries
* Refinement patterns
* Popular results
* Search exit rate

---

# Technical Architecture

```text
Frontend
├── Command Palette Component
├── Search Results Component
├── Autocomplete Component
└── Filter Components

Backend
├── Search Service
├── Index Manager
├── Query Parser
├── Result Ranker
└── Analytics Logger

Infrastructure
├── Meilisearch (primary)
├── Redis (cache)
├── Queue (indexing)
└── Database (metadata)
```

---

# Database Schema

Key tables:

* `search_index` — Search index metadata
* `search_queries` — Query logs
* `search_clicks` — Click tracking
* `search_suggestions` — Popular suggestions

---

# Performance Requirements

| Metric | Target |
|--------|--------|
| Search Response | <100ms |
| Autocomplete | <50ms |
| Index Update | <1s |
| Index Rebuild | <5min |

---

# Admin Features

* Index management
* Search analytics
* Synonym management
* Stop words configuration
* Boost rules
* Search tuning

---

# Success Metrics

* <100ms search response
* 90%+ click-through rate
* <5% zero-result rate
* 1M+ searches/month
* 4.5+ search satisfaction

---

# Next Document

**24 - Admin Panel** — Centralized administration interface.
