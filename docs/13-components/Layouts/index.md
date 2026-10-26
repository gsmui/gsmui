---
title: Layout Components
description: Layout components — sidebar, header, footer, breadcrumbs, page-header, grid, stack, divider.
order: 13.8
group: Layouts
---

# Layout Components

GsmUi layout components provide structural building blocks for page layouts. They handle responsive behavior, spacing, and alignment so you can focus on content.

## Layout Catalog

| Component | File | Purpose |
|---|---|---|
| Sidebar | `layouts/sidebar.blade.php` | Side navigation panel |
| Header | `layouts/header.blade.php` | Top bar |
| Footer | `layouts/footer.blade.php` | Page footer |
| Breadcrumbs | `layouts/breadcrumbs.blade.php` | Navigation trail |
| Page Header | `layouts/page-header.blade.php` | Page title + actions |
| Grid | `layouts/grid.blade.php` | Responsive grid |
| Stack | `layouts/stack.blade.php` | Vertical/horizontal stacking |
| Divider | `layouts/divider.blade.php` | Visual separator |

## Sidebar

```blade
<gsmui:sidebar :collapsible="true" :collapsed="$sidebarCollapsed">
    <x-slot:brand>
        <img src="/logo.svg" alt="GsmUi" class="h-8" />
    </x-slot:brand>

    <gsmui:sidebar-nav :items="[
        ['label' => 'Dashboard', 'icon' => 'home', 'href' => '/dashboard'],
        ['label' => 'Users', 'icon' => 'users', 'href' => '/users'],
        ['label' => 'Settings', 'icon' => 'settings', 'href' => '/settings'],
    ]" />

    <x-slot:footer>
        <gsmui:sidebar-user name="John Doe" email="john@example.com" />
    </x-slot:footer>
</gsmui:sidebar>
```

| Prop | Type | Default | Description |
|---|---|---|---|
| `collapsible` | bool | `false` | Allow collapse |
| `collapsed` | bool | `false` | Initial state |
| `width` | string | `64` | Width in rem |
| `position` | string | `left` | `left`, `right` |
| `overlay` | bool | `false` | Mobile overlay mode |

### Sidebar States

| State | Width | Behavior |
|---|---|---|
| Expanded | `w-64` | Full labels + icons |
| Collapsed | `w-16` | Icons only |
| Mobile | `w-full` | Overlay drawer |
| Hidden | `0` | Off-screen |

## Header

```blade
<gsmui:header sticky>
    <div class="flex items-center justify-between">
        <gsmui:header-brand href="/dashboard">
            <img src="/logo.svg" alt="GsmUi" class="h-8" />
        </gsmui:header-brand>

        <gsmui:header-nav :items="$mainNav" />

        <div class="flex items-center gap-3">
            <gsmui:header-search placeholder="Search..." />
            <gsmui:header-notifications :count="$unreadCount" />
            <gsmui:avatar src="/images/user.jpg" alt="User" size="sm" />
        </div>
    </div>
</gsmui:header>
```

| Prop | Type | Default | Description |
|---|---|---|---|
| `sticky` | bool | `false` | Sticky to top |
| `transparent` | bool | `false` | Transparent background |
| `shadow` | bool | `false` | Add shadow |
| `border` | bool | `true` | Bottom border |

## Footer

```blade
<gsmui:footer :columns="[
    [
        'title' => 'Product',
        'links' => [
            ['label' => 'Features', 'href' => '/features'],
            ['label' => 'Pricing', 'href' => '/pricing'],
        ],
    ],
    [
        'title' => 'Company',
        'links' => [
            ['label' => 'About', 'href' => '/about'],
            ['label' => 'Blog', 'href' => '/blog'],
        ],
    ],
]" copyright="© 2026 GsmUi. All rights reserved." />
```

| Prop | Type | Default | Description |
|---|---|---|---|
| `columns` | array | `[]` | Link columns |
| `copyright` | string | `null` | Copyright text |
| `logo` | string | `null` | Logo image URL |
| `social` | array | `[]` | Social media links |

## Breadcrumbs

```blade
<gsmui:breadcrumbs :items="[
    ['label' => 'Home', 'href' => '/'],
    ['label' => 'Users', 'href' => '/users'],
    ['label' => 'John Doe'],
]" />
```

| Prop | Type | Default | Description |
|---|---|---|---|
| `items` | array | — | Breadcrumb items |
| `separator` | string | `/` | Separator character |
| `home-icon` | bool | `false` | Show home icon |
| `compact` | bool | `false` | Reduce spacing |

### Breadcrumb Item

| Key | Type | Required | Description |
|---|---|---|---|
| `label` | string | Yes | Display text |
| `href` | string | No | Link URL (omits last item) |
| `icon` | string | No | Icon name |
| `active` | bool | No | Active state |

## Page Header

```blade
<gsmui:page-header
    title="Users"
    description="Manage your team members and their roles."
    :breadcrumb="['Home', 'Users']"
>
    <x-slot:actions>
        <gsmui:button variant="ghost">Export</gsmui:button>
        <gsmui:button variant="primary">Add User</gsmui:button>
    </x-slot:actions>
</gsmui:page-header>
```

| Prop | Type | Default | Description |
|---|---|---|---|
| `title` | string | — | Page title |
| `description` | string | `null` | Subtitle text |
| `breadcrumb` | array | `[]` | Breadcrumb items |

## Grid

```blade
<gsmui:grid cols="3" gap="6" responsive>
    <gsmui:card>Column 1</gsmui:card>
    <gsmui:card>Column 2</gsmui:card>
    <gsmui:card>Column 3</gsmui:card>
</gsmui:grid>
```

| Prop | Type | Default | Description |
|---|---|---|---|
| `cols` | int/string | `1` | Columns (1-12 or responsive) |
| `gap` | string | `4` | Gap size |
| `responsive` | bool | `true` | Auto-collapse on mobile |
| `min-width` | string | `0` | Minimum column width |

### Responsive Columns

| Value | Behavior |
|---|---|
| `1` | Always 1 column |
| `2` | 1 col mobile, 2 col desktop |
| `3` | 1 mobile, 2 tablet, 3 desktop |
| `4` | 1 mobile, 2 tablet, 3 lg, 4 xl |
| `auto-fill` | Auto-fill with min-width |
| `auto-fit` | Auto-fit with min-width |

## Stack

```blade
<gsmui:stack direction="vertical" gap="4">
    <gsmui:card>Item 1</gsmui:card>
    <gsmui:card>Item 2</gsmui:card>
    <gsmui:card>Item 3</gsmui:card>
</gsmui:stack>

<gsmui:stack direction="horizontal" gap="4" align="center">
    <gsmui:avatar size="sm" />
    <div>
        <p class="font-medium">John Doe</p>
        <p class="text-sm text-zinc-500">john@example.com</p>
    </div>
</gsmui:stack>
```

| Prop | Type | Default | Description |
|---|---|---|---|
| `direction` | string | `vertical` | `vertical`, `horizontal` |
| `gap` | string | `4` | Gap size |
| `align` | string | `stretch` | `start`, `center`, `end`, `stretch` |
| `justify` | string | `start` | `start`, `center`, `end`, `between` |
| `wrap` | bool | `false` | Allow wrapping |

## Divider

```blade
<gsmui:divider />
<gsmui:divider label="OR" />
<gsmui:divider orientation="vertical" class="h-6" />
```

| Prop | Type | Default | Description |
|---|---|---|---|
| `label` | string | `null` | Center label |
| `orientation` | string | `horizontal` | `horizontal`, `vertical` |
| `spacing` | string | `4` | Vertical spacing |

## Responsive Behavior

| Component | Mobile | Tablet | Desktop |
|---|---|---|---|
| Sidebar | Hidden / overlay | Collapsible | Fixed |
| Header | Hamburger menu | Full nav | Full nav |
| Footer | Stacked links | 2-col links | 4-col links |
| Grid | 1 column | 2 columns | N columns |
| Page Header | Stacked title + actions | Side-by-side | Side-by-side |
