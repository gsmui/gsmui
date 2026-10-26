---
title: Livewire Components
description: Interactive Livewire components — modal, dropdown, toast, tabs, accordion, date-picker, color-picker, slider, file-upload.
order: 13.3
group: Livewire Components
---

# Livewire Components

GsmUi Livewire components provide server-side interactivity with real-time UI updates. Each component extends `Livewire\Component` and integrates with the GsmUi rendering pipeline.

## Component Catalog

| Component | File | Complexity | Dependencies |
|---|---|---|---|
| Modal | `modal/index.blade.php` | Medium | — |
| Dropdown | `dropdown/index.blade.php` | Low | — |
| Toast | `toast/index.blade.php` | Medium | Alpine.js |
| Tabs | `tabs/index.blade.php` | Low | — |
| Accordion | `accordion/index.blade.php` | Low | — |
| Date Picker | `date-picker/index.blade.php` | High | Alpine.js |
| Color Picker | `color-picker/index.blade.php` | High | Alpine.js |
| Slider | `slider/index.blade.php` | Medium | Alpine.js |
| File Upload | `file-upload/index.blade.php` | High | Livewire Upload |

## Modal

```blade
<gsmui:modal wire:model="showModal" title="Confirm Action">
    <p>Are you sure you want to proceed?</p>

    <x-slot:footer>
        <gsmui:button wire:click="$set('showModal', false)" variant="ghost">Cancel</gsmui:button>
        <gsmui:button wire:click="confirm" variant="primary">Confirm</gsmui:button>
    </x-slot:footer>
</gsmui:modal>
```

| Prop | Type | Default | Description |
|---|---|---|---|
| `wire:model` | string | — | Visibility binding |
| `title` | string | `null` | Modal header title |
| `size` | string | `md` | `sm`, `md`, `lg`, `xl`, `full` |
| `closeable` | bool | `true` | Show close button |
| `closeOnEscape` | bool | `true` | Escape key closes |
| `closeOnOverlay` | bool | `true` | Overlay click closes |

### Modal Sizes

| Size | Width | Max Height |
|---|---|---|
| `sm` | `max-w-sm` | `80vh` |
| `md` | `max-w-lg` | `80vh` |
| `lg` | `max-w-2xl` | `85vh` |
| `xl` | `max-w-4xl` | `90vh` |
| `full` | `max-w-[calc(100vw-2rem)]` | `90vh` |

## Dropdown

```blade
<gsmui:dropdown>
    <x-slot:trigger>
        <gsmui:button>Actions</gsmui:button>
    </x-slot:trigger>

    <gsmui:dropdown-item wire:click="edit">Edit</gsmui:dropdown-item>
    <gsmui:dropdown-item wire:click="duplicate">Duplicate</gsmui:dropdown-item>
    <gsmui:dropdown-divider />
    <gsmui:dropdown-item wire:click="delete" variant="danger">Delete</gsmui:dropdown-item>
</gsmui:dropdown>
```

| Prop | Type | Default | Description |
|---|---|---|---|
| `placement` | string | `bottom-start` | Popover position |
| `width` | string | `trigger` | `trigger`, `auto` |
| `closeOnSelect` | bool | `true` | Close after selection |

## Toast

```php
// In your Livewire component
$this->dispatch('toast', [
    'type' => 'success',
    'message' => 'Changes saved successfully.',
    'duration' => 5000,
]);
```

| Type | Color | Icon | Auto-dismiss |
|---|---|---|---|
| `success` | Green | CheckCircle | 5s |
| `error` | Red | XCircle | 8s |
| `warning` | Amber | AlertTriangle | 6s |
| `info` | Blue | Info | 5s |

### Toast Options

| Option | Type | Default | Description |
|---|---|---|---|
| `type` | string | `info` | Toast type |
| `message` | string | — | Toast message |
| `duration` | int | `5000` | Auto-dismiss ms |
| `dismissible` | bool | `true` | Show close button |
| `position` | string | `bottom-right` | Screen position |

## Tabs

```blade
<gsmui:tabs wire:model="activeTab">
    <gsmui:tab name="details" label="Details">
        <p>Tab 1 content</p>
    </gsmui:tab>
    <gsmui:tab name="settings" label="Settings">
        <p>Tab 2 content</p>
    </gsmui:tab>
    <gsmui:tab name="activity" label="Activity" :badge="$activityCount">
        <p>Tab 3 content</p>
    </gsmui:tab>
</gsmui:tabs>
```

| Prop | Type | Default | Description |
|---|---|---|---|
| `wire:model` | string | — | Active tab name |
| `variant` | string | `underline` | `underline`, `pills`, `boxed` |
| `size` | string | `md` | `sm`, `md`, `lg` |

## Accordion

```blade
<gsmui:accordion>
    <gsmui:accordion-item name="item-1" label="Getting Started">
        <p>Content for the first section.</p>
    </gsmui:accordion-item>
    <gsmui:accordion-item name="item-2" label="Configuration">
        <p>Content for the second section.</p>
    </gsmui:accordion-item>
</gsmui:accordion>
```

| Prop | Type | Default | Description |
|---|---|---|---|
| `multiple` | bool | `false` | Allow multiple open |
| `default` | string/array | `null` | Initially open items |

## Date Picker

```blade
<gsmui:date-picker
    wire:model="startDate"
    label="Start date"
    format="YYYY-MM-DD"
    :clearable="true"
/>
```

| Prop | Type | Default | Description |
|---|---|---|---|
| `wire:model` | string | — | Date binding (ISO string) |
| `format` | string | `YYYY-MM-DD` | Display format |
| `min` | string | `null` | Minimum date |
| `max` | string | `null` | Maximum date |
| `range` | bool | `false` | Date range mode |
| `time` | bool | `false` | Include time picker |
| `first-day-of-week` | int | `0` | 0=Sun, 1=Mon |

## Color Picker

```blade
<gsmui:color-picker
    wire:model="brandColor"
    label="Brand color"
    :swatches="['#0ea5e9', '#10b981', '#f59e0b']"
    :dropper="true"
    format="hex"
/>
```

| Prop | Type | Default | Description |
|---|---|---|---|
| `wire:model` | string | — | Color value binding |
| `format` | string | `hex` | Output: `hex`, `rgb`, `hsl` |
| `swatches` | array | `[]` | Preset color swatches |
| `dropper` | bool | `false` | Enable eye dropper |
| `clearable` | bool | `false` | Allow empty value |

## Slider

```blade
<gsmui:slider
    wire:model="volume"
    :min="0"
    :max="100"
    :step="1"
    label="Volume"
    :show-value="true"
/>
```

| Prop | Type | Default | Description |
|---|---|---|---|
| `wire:model` | string | — | Numeric binding |
| `min` | int | `0` | Minimum value |
| `max` | int | `100` | Maximum value |
| `step` | int/float | `1` | Step increment |
| `label` | string | `null` | Slider label |
| `show-value` | bool | `false` | Display current value |
| `range` | bool | `false` | Dual-thumb range mode |

## File Upload

```blade
<gsmui:file-upload
    wire:model="attachments"
    :max-files="5"
    :max-size="10240"
    accept="image/*,.pdf"
    label="Upload files"
/>
```

| Prop | Type | Default | Description |
|---|---|---|---|
| `wire:model` | string | — | File collection binding |
| `max-files` | int | `10` | Maximum file count |
| `max-size` | int | `5120` | Max size per file (KB) |
| `accept` | string | `*` | MIME type filter |
| `multiple` | bool | `true` | Allow multiple files |
| `drag-and-drop` | bool | `true` | Enable drop zone |
| `preview` | bool | `true` | Show file previews |

## Performance

| Component | Initial Load | Re-render | Memory |
|---|---|---|---|
| Modal | ~2KB JS | < 10ms | ~50KB |
| Date Picker | ~8KB JS | < 20ms | ~120KB |
| Color Picker | ~6KB JS | < 15ms | ~100KB |
| File Upload | ~4KB JS | < 30ms | Variable |
| Table | ~3KB JS | < 25ms | ~80KB |
