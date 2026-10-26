---
title: Overlay Components
description: Overlay — modal, dialog, popover, tooltip, dropdown, drawer, lightbox.
order: 13.11
group: Overlays
---

# Overlay Components

GsmUi overlay components create layered UI elements for modals, popovers, tooltips, and drawers.

## Component Catalog

| Component | Type | File | Purpose |
|---|---|---|---|
| Modal | Livewire | `overlays/modal.blade.php` | Modal dialogs |
| Dialog | Blade | `overlays/dialog.blade.php` | Confirmation dialogs |
| Popover | Blade | `overlays/popover.blade.php` | Content popover |
| Tooltip | Blade | `overlays/tooltip.blade.php` | Hover tooltips |
| Dropdown | Livewire | `overlays/dropdown.blade.php` | Dropdown menus |
| Drawer | Livewire | `overlays/drawer.blade.php` | Slide-in panels |
| Lightbox | Livewire | `overlays/lightbox.blade.php` | Image lightbox |

## Modal

```blade
<gsmui:modal wire:model="showModal" title="Edit User" size="lg">
    <form wire:submit="save">
        <gsmui:input wire:model="name" label="Name" />
        <gsmui:input wire:model="email" label="Email" type="email" class="mt-4" />
    </form>

    <x-slot:footer>
        <gsmui:button wire:click="$set('showModal', false)" variant="ghost">Cancel</gsmui:button>
        <gsmui:button wire:click="save" variant="primary" :loading="$isSaving">Save</gsmui:button>
    </x-slot:footer>
</gsmui:modal>
```

| Prop | Type | Default | Description |
|---|---|---|---|
| `wire:model` | string | — | Visibility binding |
| `title` | string | `null` | Modal header title |
| `size` | string | `md` | `sm`, `md`, `lg`, `xl`, `full` |
| `closeable` | bool | `true` | Show close button |
| `closeOnEscape` | bool | `true` | Escape closes |
| `closeOnOverlay` | bool | `true` | Overlay click closes |
| `scrollable` | bool | `true` | Scroll body content |

### Modal Sizes

| Size | Width | Max Height |
|---|---|---|
| `sm` | `max-w-sm` (384px) | `80vh` |
| `md` | `max-w-lg` (512px) | `80vh` |
| `lg` | `max-w-2xl` (672px) | `85vh` |
| `xl` | `max-w-4xl` (896px) | `90vh` |
| `full` | `calc(100vw - 2rem)` | `90vh` |

### Modal Focus Management

| Action | Behavior |
|---|---|
| Open | Focus moves to first focusable element |
| Tab | Traps focus within modal |
| Shift+Tab | Reverse tab within modal |
| Escape | Close modal, return focus to trigger |
| Close | Return focus to original trigger |

## Dialog

```blade
<gsmui:dialog
    wire:model="showConfirm"
    title="Delete User"
    icon="alert-triangle"
    icon-variant="danger"
    confirm-label="Delete"
    confirm-variant="danger"
    cancel-label="Cancel"
    :loading="$isDeleting"
>
    <p>Are you sure you want to delete <strong>{{ $userName }}</strong>?</p>
    <p class="text-sm text-zinc-500 mt-2">This action cannot be undone.</p>

    <x-slot:confirm>
        <gsmui:button wire:click="delete" variant="danger" :loading="$isDeleting">Delete</gsmui:button>
    </x-slot:confirm>
</gsmui:dialog>
```

| Prop | Type | Default | Description |
|---|---|---|---|
| `wire:model` | string | — | Visibility binding |
| `title` | string | — | Dialog title |
| `icon` | string | `null` | Icon name |
| `icon-variant` | string | `info` | `info`, `warning`, `danger` |
| `confirm-label` | string | `Confirm` | Confirm button text |
| `confirm-variant` | string | `primary` | Confirm button variant |
| `cancel-label` | string | `Cancel` | Cancel button text |

## Popover

```blade
<gsmui:popover placement="bottom-start" width="64">
    <x-slot:trigger>
        <gsmui:button>Options</gsmui:button>
    </x-slot:trigger>

    <div class="p-4">
        <h4 class="font-semibold mb-2">Settings</h4>
        <p class="text-sm text-zinc-600">Configure your preferences here.</p>
    </div>
</gsmui:popover>
```

| Prop | Type | Default | Description |
|---|---|---|---|
| `placement` | string | `bottom-start` | Popover position |
| `width` | string | `auto` | Width (px, `auto`, `trigger`) |
| `offset` | int | `8` | Distance from trigger |
| `arrow` | bool | `true` | Show arrow |
| `close-on-click-outside` | bool | `true` | Auto-close |
| `close-on-escape` | bool | `true` | Escape closes |
| `transition` | string | `fade` | Animation |

### Placement Options

| Position | Description |
|---|---|
| `top` | Above trigger, centered |
| `top-start` | Above trigger, left-aligned |
| `top-end` | Above trigger, right-aligned |
| `bottom` | Below trigger, centered |
| `bottom-start` | Below trigger, left-aligned |
| `bottom-end` | Below trigger, right-aligned |
| `left` | Left of trigger, centered |
| `right` | Right of trigger, centered |

## Tooltip

```blade
<gsmui:tooltip content="Save changes" placement="top">
    <gsmui:button variant="ghost" icon="save" />
</gsmui:tooltip>

<gsmui:tooltip content="This action is permanent" placement="bottom" :delay="300">
    <gsmui:badge variant="danger">Permanent</gsmui:badge>
</gsmui:tooltip>
```

| Prop | Type | Default | Description |
|---|---|---|---|
| `content` | string | — | Tooltip text |
| `placement` | string | `top` | Position |
| `delay` | int | `100` | Show delay ms |
| `duration` | int | `0` | Auto-hide ms (0 = stay) |
| `arrow` | bool | `true` | Show arrow |

## Dropdown

```blade
<gsmui:dropdown placement="bottom-end" width="48">
    <x-slot:trigger>
        <gsmui:button icon="ellipsis-vertical" variant="ghost" />
    </x-slot:trigger>

    <gsmui:dropdown-item icon="pencil" wire:click="edit">Edit</gsmui:dropdown-item>
    <gsmui:dropdown-item icon="copy" wire:click="duplicate">Duplicate</gsmui:dropdown-item>
    <gsmui:dropdown-item icon="archive" wire:click="archive">Archive</gsmui:dropdown-item>
    <gsmui:dropdown-divider />
    <gsmui:dropdown-item icon="trash" wire:click="delete" variant="danger">Delete</gsmui:dropdown-item>
</gsmui:dropdown>
```

| Prop | Type | Default | Description |
|---|---|---|---|
| `placement` | string | `bottom-start` | Menu position |
| `width` | string | `trigger` | Width matching |
| `align` | string | `start` | `start`, `end` |
| `close-on-select` | bool | `true` | Close after click |

## Drawer

```blade
<gsmui:drawer wire:model="showDrawer" title="Filters" placement="right" size="md">
    <form class="space-y-6">
        <gsmui:form-field name="status" type="select" label="Status">
            <option value="">All</option>
            <option value="active">Active</option>
            <option value="inactive">Inactive</option>
        </gsmui:form-field>

        <gsmui:form-field name="dateRange" type="date" label="Date Range" />
    </form>

    <x-slot:footer>
        <gsmui:button variant="ghost" wire:click="$set('showDrawer', false)">Cancel</gsmui:button>
        <gsmui:button variant="primary" wire:click="applyFilters">Apply Filters</gsmui:button>
    </x-slot:footer>
</gsmui:drawer>
```

| Prop | Type | Default | Description |
|---|---|---|---|
| `wire:model` | string | — | Visibility binding |
| `title` | string | `null` | Drawer header |
| `placement` | string | `right` | `left`, `right` |
| `size` | string | `md` | `sm`, `md`, `lg`, `full` |
| `closeable` | bool | `true` | Show close button |

### Drawer Sizes

| Size | Width |
|---|---|
| `sm` | `w-80` (320px) |
| `md` | `w-96` (384px) |
| `lg` | `w-[50vw]` |
| `full` | `w-full` |

## Lightbox

```blade
<gsmui:lightbox
    :images="$galleryImages"
    wire:model="lightboxIndex"
    :show-caption="true"
    :zoomable="true"
/>
```

| Prop | Type | Default | Description |
|---|---|---|---|
| `images` | array | — | Image collection |
| `wire:model` | string | — | Active index binding |
| `show-caption` | bool | `true` | Show image caption |
| `zoomable` | bool | `true` | Enable zoom |
| `swipeable` | bool | `true` | Swipe to navigate |
| `show-counter` | bool | `true` | "1 / 5" counter |

### Image Format

```php
$images = [
    [
        'src' => '/images/photo-1.jpg',
        'alt' => 'Photo description',
        'caption' => 'Photo taken in 2024',
        'width' => 1920,
        'height' => 1080,
    ],
];
```

## Z-Index Management

| Layer | Z-Index | Component |
|---|---|---|
| Base | 0 | Content |
| Dropdown | 1000 | Dropdown menus |
| Sticky | 1020 | Sticky headers |
| Popover | 1040 | Popovers, tooltips |
| Modal | 1060 | Modals, dialogs |
| Drawer | 1050 | Drawers |
| Toast | 1080 | Toast notifications |
| Lightbox | 1070 | Lightbox overlay |

## Focus Trap

All modal-type overlays trap focus:

| Feature | Implementation |
|---|---|
| Initial focus | First focusable element or dialog |
| Tab cycling | Shift+Tab from first → last |
| Return focus | Focus restored to trigger on close |
| Inert content | Background marked `aria-hidden="true"` |
