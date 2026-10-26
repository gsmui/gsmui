---
title: Version Management
description: Version selector, diff view, migration guides, and deprecation notices.
order: 14.4
group: Versioning
---

# Version Management

GsmUi documentation supports multiple versions simultaneously, with a version selector, content diffing, migration guides, and deprecation notices.

## Version Architecture

| Component | Purpose |
|---|---|
| Version selector | UI for switching versions |
| Content diffing | Visual change comparison |
| Migration guides | Upgrade instructions |
| Deprecation notices | Inline warnings |
| Version API | Programmatic version access |

## Version Selector

### Selector UI

```blade
<gsmui:version-selector
    :versions="['3.0', '2.15', '2.14', '2.13']"
    :current="$currentVersion"
    wire:model="version"
/>
```

### Selector Display

```
┌─────────────────────┐
│ v3.0 (latest)    ▾ │
├─────────────────────┤
│ v3.0 (latest)       │  ← Current
│ v2.15               │
│ v2.14               │
│ v2.13               │
│ v2.12 (deprecated)  │
└─────────────────────┘
```

### Version Metadata

| Field | Type | Description |
|---|---|---|
| `version` | string | Version number |
| `label` | string | Display label |
| `status` | string | `latest`, `stable`, `deprecated`, `eol` |
| `date` | string | Release date |
| `url` | string | Version base URL |

### Version Status

| Status | Badge | Behavior |
|---|---|---|
| `latest` | Green | Default selection |
| `stable` | Blue | Full support |
| `deprecated` | Amber | Warning banner |
| `eol` | Red | End-of-life banner |

## Content Diffing

### Diff View

```blade
<gsmui:version-diff
    :from-version="'2.14'"
    :to-version="'2.15'"
    :files="['components/button.md', 'components/input.md']"
/>
```

### Diff Display

```diff
## Button Component

- <x-gsmui:button variant="primary">
+ <x-gsmui:button variant="primary" size="md">

- Props: variant, disabled, loading
+ Props: variant, size, disabled, loading, icon
```

### Diff Types

| Type | Color | Description |
|---|---|---|
| Added | Green | New content |
| Removed | Red | Deleted content |
| Changed | Amber | Modified content |
| Moved | Blue | Relocated content |

### Diff Granularity

| Level | Description |
|---|---|
| Page | Full page comparison |
| Section | Heading-level comparison |
| Line | Line-by-line comparison |
| Word | Inline word changes |

## Migration Guides

### Guide Structure

```markdown
---
title: Migration Guide — v2.14 → v2.15
from: "2.14"
to: "2.15"
---

# Migration Guide: v2.14 → v2.15

## Breaking Changes

### Button `variant` prop renamed
The `variant` prop has been renamed to `type` for consistency.

:::diff{from="2.14" to="2.15"}
```blade
- <x-gsmui:button variant="primary">
+ <x-gsmui:button type="primary">
```
:::

## New Features

### New `icon` prop
Buttons now support an `icon` prop for inline icons.

## Deprecations

### `loading` prop → `busy`
The `loading` prop is deprecated. Use `busy` instead.
```

### Migration Guide Schema

| Field | Type | Description |
|---|---|---|
| `title` | string | Guide title |
| `from` | string | Source version |
| `to` | string | Target version |
| `breaking` | array | Breaking changes |
| `new` | array | New features |
| `deprecated` | array | Deprecated items |
| `removed` | array | Removed items |

## Deprecation Notices

### Inline Deprecation

```markdown
:::deprecated{since="2.15" replacement="icon"}
The `loading` prop is deprecated. Use the `icon` prop with a spinner instead.
:::
```

### Deprecation Banner

```html
<div class="deprecation-notice">
  <strong>Deprecated since v2.15</strong>
  <p>This prop has been replaced by <code>icon</code>.</p>
  <a href="/docs/migration/2.14-2.15">View migration guide →</a>
</div>
```

### Deprecation Levels

| Level | Display | Behavior |
|---|---|---|
| `notice` | Blue banner | Informational |
| `warning` | Amber banner | Will be removed |
| `critical` | Red banner | Removed in next version |

## Version Routing

### URL Structure

```
/docs/v3.0/components/button    ← Version 3.0
/docs/v2.15/components/button   ← Version 2.15
/docs/components/button         ← Latest version
```

### Redirect Behavior

| URL | Redirects To |
|---|---|
| `/docs/components` | `/docs/v3.0/components` |
| `/docs/v2/components` | `/docs/v2.15/components` |
| `/docs/old-version` | `/docs/v3.0` + warning |

## Version Management

### Adding a Version

```bash
# Tag current docs
gsmui-docs version:tag 2.15

# Create new version
gsmui-docs version:create 3.0 --from 2.15

# Generate migration guide
gsmui-docs migration:generate 2.14 3.0
```

### Version Configuration

```php
// config/docs.php
return [
    'versioning' => [
        'enabled' => true,
        'default' => 'latest',
        'show_selector' => true,
        'auto_redirect' => true,
        'deprecation_notices' => true,
        'migration_guides' => true,
    ],
];
```

## Version API

```php
// Get current version
$version = Docs::currentVersion(); // "3.0"

// Get all versions
$versions = Docs::versions(); // ["3.0", "2.15", "2.14"]

// Check if deprecated
Docs::isDeprecated('2.13'); // true

// Get deprecation notice
Docs::deprecationNotice('loading', '2.15');
```
