---
title: Navigation Components
description: Navigation — navbar, sidebar-nav, tabs, pagination, breadcrumb, mega-menu, command-palette.
order: 13.9
group: Navigation
---

# Navigation Components

GsmUi navigation components provide accessible, responsive navigation patterns for web applications.

## Navigation Catalog

| Component | Type | File | Purpose |
|---|---|---|---|
| Navbar | Blade | `navigation/navbar.blade.php` | Top navigation bar |
| Sidebar Nav | Blade | `navigation/sidebar-nav.blade.php` | Side navigation |
| Tabs | Livewire | `tabs/index.blade.php` | Content tabs |
| Pagination | Blade | `navigation/pagination.blade.php` | Page navigation |
| Breadcrumb | Blade | `navigation/breadcrumb.blade.php` | Path trail |
| Mega Menu | Livewire | `navigation/mega-menu.blade.php` | Multi-column dropdown |
| Command Palette | Livewire | `navigation/command-palette.blade.php` | Quick actions |

## Navbar

```blade
<gsmui:navbar :sticky="true">
    <x-slot:brand>
        <img src="/logo.svg" alt="GsmUi" class="h-8" />
    </x-slot:brand>

    <gsmui:navbar-nav :items="[
        ['label' => 'Dashboard', 'href' => '/dashboard', 'active' => true],
        ['label' => 'Users', 'href' => '/users'],
        ['label' => 'Settings', 'href' => '/settings'],
    ]" />

    <x-slot:actions>
        <gsmui:navbar-search placeholder="Search..." />
        <gsmui:navbar-notifications :count="3" />
        <gsmui:avatar src="/images/user.jpg" size="sm" />
    </x-slot:actions>
</gsmui:navbar>
```

| Prop | Type | Default | Description |
|---|---|---|---|
| `sticky` | bool | `false` | Sticky to top |
| `transparent` | bool | `false` | Transparent background |
| `shadow` | bool | `false` | Add shadow |
| `border` | bool | `true` | Bottom border |
| `compact` | bool | `false` | Reduced height |

### Navbar Height Variants

| Variant | Height | Padding | Use Case |
|---|---|---|---|
| `default` | `h-16` | `px-6` | Standard apps |
| `compact` | `h-12` | `px-4` | Dense interfaces |
| `spacious` | `h-20` | `px-8` | Marketing sites |

## Sidebar Nav

```blade
<gsmui:sidebar-nav
    :items="[
        [
            'label' => 'Getting Started',
            'icon' => 'rocket',
            'children' => [
                ['label' => 'Installation', 'href' => '/docs/install'],
                ['label' => 'Quick Start', 'href' => '/docs/quickstart'],
            ],
        ],
        [
            'label' => 'Components',
            'icon' => 'layers',
            'href' => '/docs/components',
            'badge' => '12',
        ],
    ]"
    :collapsible="true"
    variant="grouped"
/>
```

| Prop | Type | Default | Description |
|---|---|---|---|
| `items` | array | — | Navigation items |
| `collapsible` | bool | `false` | Allow collapse |
| `variant` | string | `default` | `default`, `grouped`, `pills` |
| `size` | string | `md` | `sm`, `md`, `lg` |

### Nav Item Structure

| Key | Type | Required | Description |
|---|---|---|---|
| `label` | string | Yes | Display text |
| `href` | string | No | URL |
| `icon` | string | No | Icon name |
| `children` | array | No | Sub-items |
| `badge` | string/int | No | Badge count |
| `active` | bool | No | Active state |
| `disabled` | bool | No | Disabled state |

## Tabs

```blade
<gsmui:tabs wire:model="activeTab" variant="underline" size="md">
    <gsmui:tab name="overview" label="Overview">
        <p>Overview content</p>
    </gsmui:tab>
    <gsmui:tab name="analytics" label="Analytics">
        <p>Analytics content</p>
    </gsmui:tab>
    <gsmui:tab name="settings" label="Settings" :disabled="true">
        <p>Settings content</p>
    </gsmui:tab>
</gsmui:tabs>
```

| Prop | Type | Default | Description |
|---|---|---|---|
| `wire:model` | string | — | Active tab binding |
| `variant` | string | `underline` | `underline`, `pills`, `boxed`, `enclosed` |
| `size` | string | `md` | `sm`, `md`, `lg` |
| `stretch` | bool | `false` | Full-width tabs |
| `autoactivate` | bool | `true` | Auto-activate on keyboard |

### Tab Variants

| Variant | Style | Active Indicator | Best For |
|---|---|---|---|
| `underline` | Bottom border | 2px bottom border | Settings, forms |
| `pills` | Background | Background fill | Navigation |
| `boxed` | Bordered | Background fill | Dense UI |
| `enclosed` | Card-like | Top border | Content sections |

## Pagination

```blade
<gsmui:pagination
    :total="$totalItems"
    :per-page="$perPage"
    :current="$currentPage"
    wire:model="page"
/>
```

| Prop | Type | Default | Description |
|---|---|---|---|
| `total` | int | — | Total items |
| `per-page` | int | `15` | Items per page |
| `current` | int | `1` | Current page |
| `sibling-count` | int | `1` | Pages shown around current |
| `show-first-last` | bool | `true` | Show first/last buttons |
| `show-info` | bool | `false` | Show "1–15 of 100" |

### Pagination Output

```html
← Prev  1  [2]  3  4  ...  10  Next →
```

## Breadcrumb

```blade
<gsmui:breadcrumb
    :items="[
        ['label' => 'Home', 'href' => '/'],
        ['label' => 'Products', 'href' => '/products'],
        ['label' => 'Widget Pro'],
    ]"
    separator="chevron"
    :home-icon="true"
/>
```

| Prop | Type | Default | Description |
|---|---|---|---|
| `items` | array | — | Breadcrumb items |
| `separator` | string | `chevron` | `chevron`, `slash`, `dot`, `arrow` |
| `home-icon` | bool | `false` | Show home icon |
| `compact` | bool | `false` | Reduced spacing |

## Mega Menu

```blade
<gsmui:mega-menu>
    <x-slot:trigger>
        <gsmui:navbar-item>Products</gsmui:navbar-item>
    </x-slot:trigger>

    <div class="grid grid-cols-4 gap-8 p-6">
        <div>
            <h4 class="font-semibold mb-3">Platform</h4>
            <gsmui:mega-menu-item href="/product/components" icon="layers">
                <x-slot:title>Components</x-slot:title>
                <x-slot:description>100+ UI components</x-slot:description>
            </gsmui:mega-menu-item>
        </div>
        <!-- More columns -->
    </div>
</gsmui:mega-menu>
```

| Prop | Type | Default | Description |
|---|---|---|---|
| `width` | string | `full` | `full`, `lg`, `xl` |
| `columns` | int | `4` | Grid columns |
| `close-on-escape` | bool | `true` | Close on Escape |

## Command Palette

```blade
<gsmui:command-palette
    wire:model="showPalette"
    :commands="$commands"
    placeholder="Type a command..."
/>
```

### Commands Format

```php
$commands = [
    ['id' => 'dashboard', 'label' => 'Go to Dashboard', 'href' => '/dashboard', 'icon' => 'home'],
    ['id' => 'users', 'label' => 'Go to Users', 'href' => '/users', 'icon' => 'users'],
    ['id' => 'settings', 'label' => 'Open Settings', 'href' => '/settings', 'icon' => 'settings'],
];
```

| Prop | Type | Default | Description |
|---|---|---|---|
| `wire:model` | string | — | Visibility binding |
| `commands` | array | — | Command list |
| `placeholder` | string | `Search...` | Input placeholder |
| `groups` | bool | `true` | Group by category |
| `recent` | bool | `true` | Show recent commands |

### Keyboard Shortcuts

| Key | Action |
|---|---|
| `Ctrl+K` / `Cmd+K` | Open palette |
| `Escape` | Close palette |
| `↑` / `↓` | Navigate results |
| `Enter` | Execute command |
| `Tab` | Cycle through groups |

## Accessibility

| Component | ARIA Role | Keyboard Support |
|---|---|---|
| Navbar | `navigation` | Arrow keys, Tab |
| Sidebar Nav | `tree` | Arrow keys, Enter, Space |
| Tabs | `tablist` / `tab` | Arrow keys, Home, End |
| Pagination | `navigation` | Arrow keys, Tab |
| Breadcrumb | `navigation` | Tab |
| Mega Menu | `menu` | Arrow keys, Escape |
| Command Palette | `dialog` | Arrow keys, Enter, Escape |
