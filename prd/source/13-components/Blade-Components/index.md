---
title: Blade Components
description: Core Blade component library — button, input, select, checkbox, radio, textarea, toggle, badge, avatar, card, table.
order: 13.2
group: Blade Components
---

# Blade Components

GsmUi provides a complete set of Blade anonymous components for common UI patterns. All components are accessible, themeable, and follow consistent sizing and styling conventions.

## Component Catalog

| Component | Type | File | Description |
|---|---|---|---|
| Button | Blade | `button/index.blade.php` | Action trigger with variants |
| Input | Blade | `input/index.blade.php` | Text input with addons |
| Select | Livewire | `select/index.blade.php` | Searchable dropdown |
| Checkbox | Blade | `checkbox/index.blade.php` | Boolean toggle |
| Radio | Blade | `radio/index.blade.php` | Single selection from group |
| Textarea | Blade | `textarea/index.blade.php` | Multi-line text input |
| Toggle | Livewire | `toggle/index.blade.php` | Switch-style boolean |
| Badge | Blade | `badge/index.blade.php` | Status indicator |
| Avatar | Blade | `avatar/index.blade.php` | User image/name |
| Card | Blade | `card/index.blade.php` | Container with header/footer |
| Table | Livewire | `table/index.blade.php` | Data table with sorting |

## Button

```blade
<gsmui:button variant="primary" size="md" wire:click="save">
    Save Changes
</gsmui:button>
```

| Prop | Type | Default | Options |
|---|---|---|---|
| `variant` | string | `primary` | `primary`, `secondary`, `danger`, `ghost`, `outline` |
| `size` | string | `md` | `sm`, `md`, `lg`, `xs` |
| `disabled` | bool | `false` | — |
| `loading` | bool | `false` | — |
| `icon` | string | `null` | Lucide icon name |
| `icon-position` | string | `left` | `left`, `right` |
| `as` | string | `button` | `button`, `a`, `div` |
| `href` | string | `null` | URL for `as="a"` |

### Button Variants

| Variant | Background | Text | Border |
|---|---|---|---|
| `primary` | `bg-blue-600` | `text-white` | none |
| `secondary` | `bg-zinc-100 dark:bg-zinc-800` | `text-zinc-700 dark:text-zinc-300` | none |
| `danger` | `bg-red-600` | `text-white` | none |
| `ghost` | `bg-transparent` | `text-zinc-700` | none |
| `outline` | `bg-transparent` | `text-zinc-700` | `border-zinc-300` |

## Input

```blade
<gsmui:input
    wire:model="email"
    type="email"
    label="Email address"
    placeholder="you@example.com"
    required
/>
```

| Prop | Type | Default | Description |
|---|---|---|---|
| `wire:model` | string | — | Livewire binding |
| `type` | string | `text` | Input type |
| `label` | string | `null` | Visible label |
| `placeholder` | string | `null` | Placeholder text |
| `disabled` | bool | `false` | Disabled state |
| `invalid` | bool | `false` | Error state |
| `hint` | string | `null` | Help text below input |
| `prefix` | string | `null` | Prefix addon |
| `suffix` | string | `null` | Suffix addon |
| `size` | string | `md` | `sm`, `md`, `lg` |

### Input Sizes

| Size | Height | Text | Padding |
|---|---|---|---|
| `sm` | `h-8` | `text-sm` | `px-2.5` |
| `md` | `h-10` | `text-sm` | `px-3` |
| `lg` | `h-12` | `text-base` | `px-4` |

## Select

```blade
<gsmui:select wire:model="status" label="Status" placeholder="Select status">
    <option value="active">Active</option>
    <option value="inactive">Inactive</option>
    <option value="archived">Archived</option>
</gsmui:select>
```

| Prop | Type | Default | Description |
|---|---|---|---|
| `wire:model` | string | — | Livewire binding |
| `label` | string | `null` | Select label |
| `placeholder` | string | `null` | Placeholder option |
| `searchable` | bool | `false` | Enable search filter |
| `clearable` | bool | `false` | Show clear button |
| `disabled` | bool | `false` | Disabled state |
| `multiple` | bool | `false` | Multiple selection |

## Checkbox

```blade
<gsmui:checkbox wire:model="remember" label="Remember me" />
```

| Prop | Type | Default | Description |
|---|---|---|---|
| `wire:model` | string | — | Boolean binding |
| `label` | string | — | Checkbox label |
| `description` | string | `null` | Help text |
| `disabled` | bool | `false` | Disabled state |
| `value` | string | — | Value when checked |

## Radio

```blade
<gsmui:radio-group wire:model="plan" label="Choose plan">
    <gsmui:radio value="free" label="Free" />
    <gsmui:radio value="pro" label="Pro — $19/mo" />
    <gsmui:radio value="enterprise" label="Enterprise — $99/mo" />
</gsmui:radio-group>
```

| Prop | Type | Default | Description |
|---|---|---|---|
| `wire:model` | string | — | Selection binding |
| `value` | string | — | Radio value |
| `label` | string | — | Radio label |
| `description` | string | `null` | Sub-label text |
| `disabled` | bool | `false` | Disabled state |

## Textarea

```blade
<gsmui:textarea wire:model="bio" label="Bio" rows="4" maxlength="500" />
```

| Prop | Type | Default | Description |
|---|---|---|---|
| `wire:model` | string | — | Text binding |
| `label` | string | `null` | Textarea label |
| `rows` | int | `3` | Visible rows |
| `maxlength` | int | `null` | Max character count |
| `autoresize` | bool | `false` | Auto-grow height |
| `placeholder` | string | `null` | Placeholder text |

## Toggle

```blade
<gsmui:toggle wire:model="notifications" label="Enable notifications" />
```

| Prop | Type | Default | Description |
|---|---|---|---|
| `wire:model` | string | — | Boolean binding |
| `label` | string | — | Toggle label |
| `size` | string | `md` | `sm`, `md`, `lg` |
| `disabled` | bool | `false` | Disabled state |

## Badge

```blade
<gsmui:badge variant="success">Active</gsmui:badge>
<gsmui:badge variant="warning" size="sm">Pending</gsmui:badge>
```

| Prop | Type | Default | Options |
|---|---|---|---|
| `variant` | string | `primary` | `primary`, `success`, `warning`, `danger`, `neutral` |
| `size` | string | `md` | `sm`, `md`, `lg` |
| `dot` | bool | `false` | Show status dot |

## Avatar

```blade
<gsmui:avatar src="/images/user.jpg" alt="John Doe" size="lg" />
<gsmui:avatar name="Jane Smith" size="md" />
```

| Prop | Type | Default | Description |
|---|---|---|---|
| `src` | string | `null` | Image URL |
| `alt` | string | `null` | Alt text |
| `name` | string | `null` | Initials fallback |
| `size` | string | `md` | `xs`, `sm`, `md`, `lg`, `xl` |
| `shape` | string | `circle` | `circle`, `square` |

## Card

```blade
<gsmui:card>
    <x-slot:header>
        <h3 class="text-lg font-semibold">Card Title</h3>
    </x-slot:header>

    <p>Card content goes here.</p>

    <x-slot:footer>
        <gsmui:button size="sm">Action</gsmui:button>
    </x-slot:footer>
</gsmui:card>
```

| Prop | Type | Default | Description |
|---|---|---|---|
| `padding` | bool | `true` | Internal padding |
| `shadow` | string | `sm` | Shadow size |
| `border` | bool | `true` | Show border |

## Table

```blade
<gsmui:table :columns="$columns" :rows="$users" :sortable="true" />
```

| Prop | Type | Default | Description |
|---|---|---|---|
| `columns` | array | — | Column definitions |
| `rows` | array | — | Row data |
| `sortable` | bool | `false` | Enable column sorting |
| `striped` | bool | `false` | Alternating row colors |
| `hoverable` | bool | `true` | Hover highlight |
| `compact` | bool | `false` | Reduced padding |

### Column Definition

```php
$columns = [
    ['key' => 'name', 'label' => 'Name', 'sortable' => true],
    ['key' => 'email', 'label' => 'Email'],
    ['key' => 'role', 'label' => 'Role', 'align' => 'center'],
];
```

## Accessibility

| Component | ARIA Pattern | Keyboard Support |
|---|---|---|
| Button | N/A | Enter, Space |
| Input | `aria-label` or `<label>` | Full keyboard |
| Select | `role="combobox"` | Arrow keys, Escape |
| Checkbox | `role="checkbox"` | Space |
| Radio | `role="radiogroup"` | Arrow keys |
| Textarea | `<label>` | Full keyboard |
| Toggle | `role="switch"` | Space |
| Table | `role="grid"` | Arrow keys |
