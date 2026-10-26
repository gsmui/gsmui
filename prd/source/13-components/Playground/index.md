---
title: Component Playground
description: Interactive playground for live preview, code view, props editing, theme switching, and responsive testing.
order: 13.12
group: Playground
---

# Component Playground

The GsmUi Playground is an interactive development environment for exploring, testing, and customizing components in real time.

## Features

| Feature | Description |
|---|---|
| Live Preview | Real-time component rendering |
| Code View | Generated Blade/Livewire code |
| Props Editor | Interactive prop configuration |
| Theme Switcher | Toggle themes and dark mode |
| Responsive Test | Test at different viewports |
| Accessibility Audit | Check ARIA and keyboard support |

## Playground Interface

```blade
<x-gsmui:playground
    component="button"
    :default-props="[
        'variant' => 'primary',
        'size' => 'md',
        'children' => 'Click me',
    ]"
>
    <x-slot:preview>
        {{-- Component renders here --}}
    </x-slot:preview>

    <x-slot:controls>
        {{-- Props editor --}}
    </x-slot:controls>

    <x-slot:code>
        {{-- Generated code --}}
    </x-slot:code>
</x-gsmui:playground>
```

## Props Editor

### Editor Controls

| Control Type | Prop Type | Editor UI |
|---|---|---|
| String | `string` | Text input |
| Number | `int`, `float` | Number input |
| Boolean | `bool` | Toggle switch |
| Select | `enum` | Dropdown |
| Color | `color` | Color picker |
| Icon | `icon` | Icon selector |
| Array | `array` | JSON editor |

### Props Panel Layout

```
┌─────────────────────────────────────────────┐
│ Props Editor                                │
├─────────────────────────────────────────────┤
│ variant   [primary ▾]                       │
│ size      [md ▾]                            │
│ disabled  [OFF]                             │
│ loading   [OFF]                             │
│ icon      [search 🔍]                       │
│ icon-position [left ▾]                      │
│ class     [________________]                │
└─────────────────────────────────────────────┘
```

### Example Props Configuration

```php
$propsConfig = [
    'variant' => [
        'type' => 'select',
        'options' => ['primary', 'secondary', 'danger', 'ghost', 'outline'],
        'default' => 'primary',
    ],
    'size' => [
        'type' => 'select',
        'options' => ['xs', 'sm', 'md', 'lg', 'xl'],
        'default' => 'md',
    ],
    'disabled' => [
        'type' => 'boolean',
        'default' => false,
    ],
    'loading' => [
        'type' => 'boolean',
        'default' => false,
    ],
    'icon' => [
        'type' => 'icon',
        'default' => null,
    ],
];
```

## Live Preview

The preview panel renders the component with current prop values:

### Preview Features

| Feature | Description |
|---|---|
| Hot reload | Props changes update instantly |
| State persistence | Maintains state across prop changes |
| Event logging | Logs dispatched events |
| Error display | Shows component errors inline |

### Preview Container

```blade
<div class="playground-preview bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-lg p-8">
    {{-- Component renders here --}}
</div>
```

## Code View

Shows generated Blade code for the current configuration:

### Code Display

```blade
{{-- Generated Code --}}
<gsmui:button
    variant="primary"
    size="md"
    icon="search"
    icon-position="left"
>
    Search
</gsmui:button>
```

### Code Features

| Feature | Description |
|---|---|
| Syntax highlighting | Blade/Livewire syntax |
| Copy button | One-click copy |
| Format | Auto-formatted code |
| Diff | Shows prop changes |

## Theme Switcher

Toggle between themes in the playground:

### Theme Options

| Theme | Description |
|---|---|
| `default` | Light mode default |
| `dark` | Dark mode |
| `ocean` | Blue-toned theme |
| `forest` | Green-toned theme |
| `sunset` | Warm tones |
| `high-contrast` | Accessibility focus |

### Theme Preview Grid

```blade
<div class="grid grid-cols-3 gap-2">
    <button class="theme-swatch bg-white border-2 border-blue-500" data-theme="default">
        Default
    </button>
    <button class="theme-swatch bg-zinc-900 border-2 border-transparent" data-theme="dark">
        Dark
    </button>
    <button class="theme-swatch bg-cyan-50 border-2 border-transparent" data-theme="ocean">
        Ocean
    </button>
</div>
```

## Responsive Test

Test components at different viewport sizes:

| Preset | Width | Height | Device |
|---|---|---|---|
| Mobile S | 320px | 568px | iPhone SE |
| Mobile L | 425px | 812px | iPhone 12 |
| Tablet | 768px | 1024px | iPad |
| Laptop | 1024px | 768px | Laptop |
| Desktop | 1440px | 900px | Desktop |
| 4K | 2560px | 1440px | 4K Display |

### Responsive Controls

```blade
<div class="flex items-center gap-2">
    <gsmui:button size="xs" icon="smartphone" wire:click="setViewport(320)" />
    <gsmui:button size="xs" icon="tablet" wire:click="setViewport(768)" />
    <gsmui:button size="xs" icon="monitor" wire:click="setViewport(1440)" />
    <gsmui:input type="number" wire:model="customWidth" class="w-24" />
</div>
```

## Accessibility Audit

Built-in accessibility checks:

### Audit Checks

| Check | Severity | Description |
|---|---|---|
| Missing label | Error | No accessible name |
| Missing role | Warning | No ARIA role |
| Keyboard trap | Error | Focus trapped incorrectly |
| Color contrast | Warning | Low contrast ratio |
| Missing focus | Warning | No visible focus indicator |
| ARIA mismatch | Error | ARIA attributes mismatch |

### Audit Panel

```blade
<div class="space-y-2">
    <div class="flex items-center gap-2 text-green-600">
        <gsmui:icon name="check-circle" size="sm" />
        <span>Label present</span>
    </div>
    <div class="flex items-center gap-2 text-amber-600">
        <gsmui:icon name="alert-triangle" size="sm" />
        <span>No ARIA role defined</span>
    </div>
</div>
```

## Playground API

### Opening the Playground

```blade
{{-- In docs page --}}
<gsmui:playground-link component="button" />
```

### Programmatic Access

```php
// In Livewire component
public function mount(string $component): void
{
    $this->component = $component;
    $this->props = $this->getDefaultProps($component);
    $this->theme = config('gsmui.theme.default');
}

public function updateProp(string $key, mixed $value): void
{
    $this->props[$key] = $value;
}
```
