---
title: Category System
description: Category tree, tagging, filtering, and featured collections.
order: 15.7
group: Categories
---

# Category System

The GsmUi Marketplace uses a hierarchical category system with tagging and filtering for product discovery.

## Category Features

| Feature | Description |
|---|---|
| Category tree | Hierarchical categories |
| Tagging | Free-form tags |
| Filtering | Multi-facet filtering |
| Featured collections | Curated product lists |
| Search integration | Category-aware search |

## Category Tree

### Category Structure

```
Marketplace
├── Components
│   ├── Form
│   │   ├── Input
│   │   ├── Select
│   │   ├── Date Picker
│   │   └── File Upload
│   ├── Data
│   │   ├── DataTable
│   │   ├── Chart
│   │   └── Calendar
│   ├── Navigation
│   │   ├── Sidebar
│   │   ├── Tabs
│   │   └── Breadcrumbs
│   ├── Overlay
│   │   ├── Modal
│   │   ├── Drawer
│   │   └── Tooltip
│   └── Feedback
│       ├── Alert
│       ├── Toast
│       └── Progress
├── Themes
│   ├── Dashboard
│   ├── E-commerce
│   └── Portfolio
├── Templates
│   ├── Starter Kits
│   ├── Page Templates
│   └── Email Templates
└── Plugins
    ├── Integrations
    ├── Tools
    └── Utilities
```

### Category Schema

```json
{
  "id": "form",
  "name": "Form",
  "slug": "form",
  "parent_id": "components",
  "description": "Form input components",
  "icon": "edit",
  "product_count": 24,
  "children": [
    {"id": "input", "name": "Input", "product_count": 8},
    {"id": "select", "name": "Select", "product_count": 5}
  ]
}
```

## Tagging System

### Tag Types

| Type | Description | Examples |
|---|---|---|
| Feature | Product features | `dark-mode`, `responsive` |
| Technology | Tech stack | `livewire`, `alpine` |
| Use Case | Application type | `dashboard`, `saas` |
| Style | Visual style | `minimal`, `modern` |
| Compatibility | Version support | `laravel-10`, `livewire-3` |

### Tag Display

```blade
<gsmui:tag-list :tags="['livewire', 'dark-mode', 'responsive', 'dashboard']" />
```

### Tag Output

```
livewire  dark-mode  responsive  dashboard
```

### Tag Variants

| Variant | Style |
|---|---|
| `default` | Gray background |
| `primary` | Blue background |
| `success` | Green background |
| `warning` | Amber background |

## Filtering

### Filter UI

```blade
<x-gsmui:marketplace-filters
    :categories="$categories"
    :tags="$tags"
    :types="['component', 'theme', 'template', 'plugin']"
    :price-ranges="['free', 'under-25', '25-50', '50-100', 'over-100']"
    wire:model="filters"
/>
```

### Filter Output

```
┌─────────────────────────────────────────────┐
│ 🔍 Filters                                  │
├─────────────────────────────────────────────┤
│ Category                                    │
│ ☑ Components                                │
│   ☑ Form                                    │
│   ☐ Data                                    │
│   ☐ Navigation                              │
├─────────────────────────────────────────────┤
│ Type                                        │
│ ☑ Component                                 │
│ ☐ Theme                                     │
│ ☐ Template                                  │
├─────────────────────────────────────────────┤
│ Price                                       │
│ ☐ Free                                      │
│ ☑ Under $25                                 │
│ ☐ $25–$50                                   │
│ ☐ $50–$100                                  │
│ ☐ Over $100                                 │
├─────────────────────────────────────────────┤
│ Rating                                      │
│ ⭐⭐⭐⭐ & up                               │
├─────────────────────────────────────────────┤
│ Compatibility                               │
│ ☑ Livewire 3.x                              │
│ ☑ Laravel 10+                               │
└─────────────────────────────────────────────┘
```

### Filter Options

| Filter | Options |
|---|---|
| Category | Hierarchical tree |
| Type | Component, Theme, Template, Plugin |
| Price | Range filters |
| Rating | Minimum star rating |
| Compatibility | Version filters |
| Sort | Popular, Newest, Price, Rating |

## Featured Collections

### Collection Display

```blade
<x-gsmui:featured-collection
    title="Popular Components"
    :products="$featuredProducts"
    :limit="6"
/>
```

### Collection Output

```
┌─────────────────────────────────────────────┐
│ ⭐ Popular Components                       │
├─────────────────────────────────────────────┤
│ ┌──────┐ ┌──────┐ ┌──────┐                │
│ │ Card │ │ Card │ │ Card │                │
│ │      │ │      │ │      │                │
│ └──────┘ └──────┘ └──────┘                │
│ ┌──────┐ ┌──────┐ ┌──────┐                │
│ │ Card │ │ Card │ │ Card │                │
│ │      │ │      │ │      │                │
│ └──────┘ └──────┘ └──────┘                │
│                                             │
│ [View All →]                                │
└─────────────────────────────────────────────┘
```

### Collection Types

| Type | Criteria |
|---|---|
| Trending | Most views this week |
| Top Rated | Highest rated |
| New Arrivals | Recently added |
| Editor's Pick | Curated selections |
| Free | $0 products |

## Category Management

### Admin Interface

```blade
<x-gsmui:category-manager
    :categories="$categories"
    wire:model="selectedCategory"
/>
```

### Category Actions

| Action | Description |
|---|---|
| Create | Add new category |
| Edit | Modify category |
| Delete | Remove category |
| Reorder | Change sort order |
| Merge | Combine categories |

## Category Configuration

```php
// config/marketplace.php
return [
    'categories' => [
        'enabled' => true,
        'max_depth' => 4,
        'allow_multiple' => true,
        'featured_limit' => 12,
        'tags_enabled' => true,
        'filters' => [
            'category' => true,
            'type' => true,
            'price' => true,
            'rating' => true,
            'compatibility' => true,
        ],
    ],
];
```
