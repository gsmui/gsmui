---
title: Component Marketplace
description: Third-party components, quality standards, and compatibility matrix.
order: 15.4
group: Marketplace Components
---

# Component Marketplace

The GsmUi Component Marketplace offers community and third-party components that extend the core library.

## Component Types

| Type | Description | Examples |
|---|---|---|
| Form | Input components | Rich text editor, color picker |
| Data | Data display | DataTable, tree view, timeline |
| Chart | Visualizations | Bar chart, heatmap, treemap |
| Navigation | Nav components | Command palette, breadcrumbs |
| Overlay | Popup components | Lightbox, context menu |
| Layout | Layout components | Masonry grid, split pane |

## Third-Party Components

### Listing Display

```
┌─────────────────────────────────────────────┐
│ 📦 Rich Text Editor                         │
│ by EditorPro ⭐⭐⭐⭐ (4.7)                │
├─────────────────────────────────────────────┤
│ [Preview]                                   │
│                                             │
│ Full-featured WYSIWYG editor with Markdown  │
│ support, image upload, and syntax highlight.│
│                                             │
│ $29.00  |  [Preview]  |  [Buy]             │
│                                             │
│ ✓ Toolbar  ✓ Markdown  ✓ Code blocks       │
│ ✓ Images  ✓ Tables  ✓ Collaboration        │
│ GsmUi 2.12+ | Livewire 3.x | Alpine 3.x   │
└─────────────────────────────────────────────┘
```

### Component Metadata

| Field | Description |
|---|---|
| `name` | Component name |
| `author` | Creator name |
| `version` | Current version |
| `price` | Component price |
| `description` | Feature description |
| `dependencies` | Required packages |
| `compatibility` | Version requirements |

## Quality Standards

### Quality Tiers

| Tier | Criteria | Badge |
|---|---|---|
| Verified | Official or audited | ✓ Verified |
| Premium | High quality, paid | ⭐ Premium |
| Community | Community submitted | 🌐 Community |

### Quality Checklist

| Criterion | Weight | Required |
|---|---|---|
| Code quality | 20% | Yes |
| Documentation | 15% | Yes |
| Testing | 15% | Yes |
| Accessibility | 15% | Yes |
| Performance | 10% | Yes |
| Security | 10% | Yes |
| Design | 10% | Yes |
| Uniqueness | 5% | No |

### Quality Metrics

| Metric | Target | Measurement |
|---|---|---|
| Code coverage | > 80% | PHPUnit/Pest |
| Bundle size | < 50KB | Webpack bundle analyzer |
| Lighthouse score | > 90 | Lighthouse audit |
| Accessibility | WCAG 2.1 AA | axe-core |
| Load time | < 200ms | Performance API |

## Compatibility Matrix

### Version Compatibility

| Component | GsmUi | Livewire | Alpine | PHP |
|---|---|---|---|---|
| Rich Text Editor | 2.12+ | 3.x | 3.x | 8.1+ |
| DataTable Pro | 2.10+ | 3.x | 3.x | 8.0+ |
| Chart Builder | 2.14+ | 3.x | 3.x | 8.1+ |
| File Manager | 2.11+ | 3.x | 3.x | 8.0+ |
| Calendar | 2.13+ | 3.x | 3.x | 8.1+ |

### Compatibility Check

```php
$check = GsmuiMarketplace::checkCompatibility($component);

// Returns
[
    'compatible' => true,
    'requirements' => [
        'gsmui' => '>= 2.12',
        'livewire' => '>= 3.0',
        'alpine' => '>= 3.0',
        'php' => '>= 8.1',
    ],
    'conflicts' => [],
    'warnings' => [],
]
```

### Compatibility Issues

| Issue Type | Severity | Action |
|---|---|---|
| Version mismatch | Critical | Block install |
| Deprecated API | Warning | Show notice |
| Missing dependency | Critical | Block install |
| Performance issue | Warning | Show notice |

## Component Installation

### Install Process

```bash
# Via CLI
gsmui:install rich-text-editor

# Via marketplace UI
# Click "Buy" → "Install" → "Configure"
```

### Install Steps

| Step | Action |
|---|---|
| 1 | Verify compatibility |
| 2 | Download component |
| 3 | Install dependencies |
| 4 | Publish assets |
| 5 | Register component |
| 6 | Run migrations (if any) |

### Install Configuration

```blade
<x-gsmui:component-install
    :component="$component"
    wire:model="showInstall"
>
    <gsmui:form-field
        name="publishAssets"
        type="toggle"
        label="Publish assets"
        :description="'Copy component assets to public directory'"
    />

    <gsmui:form-field
        name="runMigrations"
        type="toggle"
        label="Run migrations"
        :description="'Install required database tables'"
    />
</x-gsmui:component-install>
```

## Component Management

### Installed Components

| Action | Description |
|---|---|
| Update | Apply updates |
| Disable | Keep files, disable usage |
| Remove | Delete component |
| Configure | Change settings |

### Component Updates

```php
// Check for updates
$updates = GsmuiMarketplace::checkUpdates();

// Returns
[
    ['component' => 'rich-text-editor', 'current' => '2.1.0', 'latest' => '2.2.0'],
    ['component' => 'data-table-pro', 'current' => '3.0.0', 'latest' => '3.1.0'],
]
```

## Pricing

### Pricing Tiers

| Tier | Price | Features |
|---|---|---|
| Free | $0 | Basic functionality |
| Standard | $10–$29 | Full features |
| Premium | $29–$79 | Priority support |
| Enterprise | Custom | White-label |

### License Types

| License | Price | Usage |
|---|---|---|
| Single project | Base | 1 project |
| Multi-project | 2× | 5 projects |
| Unlimited | 3× | Unlimited |
| Enterprise | Custom | Custom terms |

## Community Components

### Submission Guidelines

| Requirement | Description |
|---|---|
| Source code | GitHub repository |
| Documentation | README with examples |
| License | MIT or compatible |
| Tests | At least 80% coverage |

### Community Quality

| Level | Criteria |
|---|---|
| Basic | Code compiles, docs exist |
| Standard | Tests pass, accessible |
| Premium | Full quality checklist |
| Verified | Audited by team |
