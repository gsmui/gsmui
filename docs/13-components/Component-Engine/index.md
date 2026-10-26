---
title: Component Engine Architecture
description: How the GsmUi component engine registers, resolves, and renders Livewire and Blade components.
order: 13.1
group: Component Engine
---

# Component Engine

The GsmUi component engine is the core runtime that discovers, registers, and renders all Blade and Livewire components. It extends Laravel's Blade anonymous-component system with a plugin-driven architecture for props, slots, and accessibility hooks.

## Overview

| Concept | Description |
|---|---|
| Registration | Auto-discovery of component directories via service provider |
| Resolution | Namespace mapping from `gsmui:` prefix to stub paths |
| Rendering | Two-pass compilation: Blade compile + hydration |
| Slots | Named, scoped, and fallback slot resolution |
| Attribute Forwarding | Transparent passthrough of `$attributes` to child elements |

## Registration

Components are registered in `GsmuiProServiceProvider::bootComponentPath()`:

```php
Blade::anonymousComponentPath(
    package_path('stubs/resources/views/gsmui'),
    'gsmui'
);
```

This maps `<x-gsmui:button>` to `stubs/resources/views/gsmui/button/index.blade.php`.

### Component Manifest

A JSON manifest is generated during package compilation:

```json
{
  "components": [
    { "name": "button", "type": "blade", "path": "button/index.blade.php" },
    { "name": "modal", "type": "livewire", "path": "modal/index.blade.php" }
  ],
  "version": "2.15.0"
}
```

### Registration Pipeline

| Step | Action | Priority |
|---|---|---|
| 1 | Scan stub directory | P0 |
| 2 | Parse component metadata | P0 |
| 3 | Register in Blade namespace | P0 |
| 4 | Register Livewire classes | P1 |
| 5 | Emit `components.registered` event | P2 |

## Resolution

When `<x-gsmui:button>` is encountered:

1. Blade resolver strips namespace prefix
2. Maps to `gsmui::button` → resolves to stub path
3. Checks for `index.blade.php` (anonymous) or class-based component
4. Loads parent attributes and slot content

### Namespace Mapping

| Prefix | Namespace | Path |
|---|---|---|
| `gsmui:` | `gsmui::` | `stubs/resources/views/gsmui/` |
| `flux:` | Redirected | Aliased to `gsmui:` |
| `x-` | Native Blade | Standard Laravel components |

## Rendering Pipeline

```
Component Reference
    ↓
Attribute Collection (parent + defaults)
    ↓
Slot Resolution (named → scoped → fallback)
    ↓
Class Merging (via Gsmui::classes())
    ↓
HTML Generation
    ↓
Post-Render Hooks
```

### Rendering Phases

| Phase | Description | Timing |
|---|---|---|
| Compile | Blade compiles to PHP | Cold / cache clear |
| Hydrate | Bind props, resolve slots | Each request |
| Render | Execute compiled template | Each request |
| Merge | Apply class merging via `Gsmui::classes()` | During render |
| Post-process | CSP headers, accessibility checks | After render |

## Slot System

### Slot Types

| Type | Usage | Syntax |
|---|---|---|
| Default | Single unnamed slot | `<x-gsmui:button>Label</x-gsmui:button>` |
| Named | Multiple content regions | `<x-slot:icon>` |
| Scoped | Expose data to parent | `<x-slot:trigger $open>` |
| Fallback | Default content | `<x-slot:trigger>Default</x-slot:trigger>` |

### Slot Resolution Order

1. Explicitly passed slot
2. Component default slot
3. Hardcoded fallback in component template

## Attribute Forwarding

Attributes pass transparently through component boundaries:

```blade
<x-gsmui:button class="my-class" data-id="42">
    {{ $label }}
</x-gsmui:button>
```

### `$attributes` API

| Method | Description |
|---|---|
| `$attributes->merge(['class' => '...'])` | Merge classes |
| `$attributes->only(['class', 'id'])` | Whitelist attributes |
| `$attributes->except(['type'])` | Blacklist attributes |
| `$attributes->class([...])` | Conditional class list |
| `$attributes->get('data-id')` | Single attribute |

### Class Merging with `Gsmui::classes()`

```php
Gsmui::classes('button')
    ->merge(['base' => 'rounded-lg font-medium'])
    ->variants([
        'primary' => 'bg-blue-600 text-white',
        'danger'  => 'bg-red-600 text-white',
    ])
    ->sizes([
        'sm' => 'text-sm px-3 py-1.5',
        'lg' => 'text-base px-5 py-2.5',
    ]);
```

## Lifecycle Hooks

| Hook | Trigger | Use Case |
|---|---|---|
| `mounting` | Before component mount | Initialize state |
| `rendering` | Before render | Dynamic class computation |
| `rendered` | After render | Post-process output |
| `destroying` | Component removed | Cleanup |

## Accessibility Integration

Every component render passes through the accessibility layer:

| Check | Action |
|---|---|
| Required ARIA attributes | Auto-inject if missing |
| Role validation | Ensure semantic role matches usage |
| Keyboard handlers | Attach if interactive |
| Focus management | Trap/focus logic for overlays |

## Performance

| Metric | Target |
|---|---|
| Component resolution | < 1ms per component |
| Slot resolution | < 0.5ms |
| Class merging | < 2ms per component |
| Total render overhead | < 5ms per page |

## Configuration

```php
// config/gsmui-pro.php
return [
    'components' => [
        'path' => resource_path('views/vendor/gsmui'),
        'namespace' => 'gsmui',
        'cache' => true,
        'csp' => true,
    ],
];
```
