---
title: Feedback Components
description: Feedback — alert, toast, banner, progress, skeleton, spinner, empty-state, error-boundary.
order: 13.10
group: Feedback
---

# Feedback Components

GsmUi feedback components communicate status, progress, and errors to users.

## Component Catalog

| Component | Type | File | Purpose |
|---|---|---|---|
| Alert | Blade | `feedback/alert.blade.php` | Inline messages |
| Toast | Livewire | `feedback/toast.blade.php` | Temporary notifications |
| Banner | Blade | `feedback/banner.blade.php` | Full-width notices |
| Progress | Blade | `feedback/progress.blade.php` | Progress indication |
| Skeleton | Blade | `feedback/skeleton.blade.php` | Loading placeholder |
| Spinner | Blade | `feedback/spinner.blade.php` | Loading indicator |
| Empty State | Blade | `feedback/empty-state.blade.php` | No-data placeholder |
| Error Boundary | Blade | `feedback/error-boundary.blade.php` | Error catch/display |

## Alert

```blade
<gsmui:alert variant="success" title="Changes saved" :dismissible="true">
    Your profile has been updated successfully.
</gsmui:alert>

<gsmui:alert variant="danger" icon="alert-circle">
    Something went wrong. Please try again.
</gsmui:alert>
```

| Prop | Type | Default | Description |
|---|---|---|---|
| `variant` | string | `info` | `info`, `success`, `warning`, `danger` |
| `title` | string | `null` | Alert title |
| `icon` | string | `null` | Icon override |
| `dismissible` | bool | `false` | Show close button |
| `bordered` | bool | `true` | Left border |
| `filled` | bool | `false` | Background fill |

### Alert Variants

| Variant | Border | Background | Text | Icon |
|---|---|---|---|---|
| `info` | `border-blue-500` | `bg-blue-50` | `text-blue-800` | Info |
| `success` | `border-green-500` | `bg-green-50` | `text-green-800` | CheckCircle |
| `warning` | `border-amber-500` | `bg-amber-50` | `text-amber-800` | AlertTriangle |
| `danger` | `border-red-500` | `bg-red-50` | `text-red-800` | XCircle |

## Toast

```blade
<!-- In component class -->
public function save(): void
{
    $this->validate();
    $this->item->save();

    $this->dispatch('toast', [
        'type' => 'success',
        'message' => 'Item saved successfully.',
        'duration' => 4000,
        'action' => [
            'label' => 'Undo',
            'method' => 'undo',
        ],
    ]);
}
```

| Prop | Type | Default | Description |
|---|---|---|---|
| `type` | string | `info` | `info`, `success`, `warning`, `error` |
| `message` | string | — | Toast message |
| `title` | string | `null` | Toast title |
| `duration` | int | `5000` | Auto-dismiss ms (0 = sticky) |
| `dismissible` | bool | `true` | Show close button |
| `position` | string | `bottom-right` | Screen position |
| `action` | array | `null` | Action button config |

### Toast Positions

| Position | CSS |
|---|---|
| `top-right` | `top-4 right-4` |
| `top-left` | `top-4 left-4` |
| `bottom-right` | `bottom-4 right-4` |
| `bottom-left` | `bottom-4 left-4` |
| `top-center` | `top-4 left-1/2 -translate-x-1/2` |
| `bottom-center` | `bottom-4 left-1/2 -translate-x-1/2` |

## Banner

```blade
<gsmui:banner variant="warning" icon="alert-triangle">
    <p class="font-medium">Scheduled maintenance</p>
    <p>The system will be unavailable on Saturday from 2–4 AM UTC.</p>
</gsmui:banner>

<gsmui:banner variant="info" dismissible>
    <p>New: GsmUi Pro 3.0 is now available.</p>
    <gsmui:button size="sm" variant="link">Learn more →</gsmui:button>
</gsmui:banner>
```

| Prop | Type | Default | Description |
|---|---|---|---|
| `variant` | string | `info` | `info`, `success`, `warning`, `danger` |
| `icon` | string | `null` | Icon override |
| `dismissible` | bool | `false` | Show close button |
| `fixed` | bool | `false` | Fixed to top of page |

## Progress

```blade
<gsmui:progress :value="65" label="Upload progress" :show-value="true" />

<gsmui:progress :value="30" variant="danger" :indeterminate="false" label="Almost there..." />

<gsmui:progress variant="info" :indeterminate="true" label="Loading..." />
```

| Prop | Type | Default | Description |
|---|---|---|---|
| `value` | int | `0` | Current value (0-100) |
| `max` | int | `100` | Maximum value |
| `variant` | string | `primary` | `primary`, `success`, `warning`, `danger` |
| `label` | string | `null` | Progress label |
| `show-value` | bool | `false` | Show percentage |
| `indeterminate` | bool | `false` | Animated indeterminate |
| `size` | string | `md` | `sm`, `md`, `lg` |
| `striped` | bool | `false` | Striped pattern |

### Progress Sizes

| Size | Height | Text |
|---|---|---|
| `sm` | `h-1.5` | None |
| `md` | `h-2.5` | Optional |
| `lg` | `h-4` | Included |

## Skeleton

```blade
<gsmui:skeleton type="text" :lines="3" />

<gsmui:skeleton type="avatar" size="lg" />

<gsmui:skeleton type="card" :lines="4" />

<gsmui:skeleton type="table" :rows="5" :cols="4" />
```

| Prop | Type | Default | Description |
|---|---|---|---|
| `type` | string | `text` | `text`, `avatar`, `card`, `table`, `image` |
| `lines` | int | `1` | Number of lines |
| `rows` | int | `5` | Table rows |
| `cols` | int | `3` | Table columns |
| `size` | string | `md` | `sm`, `md`, `lg`, `xl` |
| `animated` | bool | `true` | Shimmer animation |

## Spinner

```blade
<gsmui:spinner size="sm" />
<gsmui:spinner size="md" label="Loading..." />
<gsmui:spinner size="lg" variant="primary" />
```

| Prop | Type | Default | Description |
|---|---|---|---|
| `size` | string | `md` | `xs`, `sm`, `md`, `lg`, `xl` |
| `variant` | string | `primary` | Color variant |
| `label` | string | `null` | Accessible label |

### Spinner Sizes

| Size | Width | Height | Stroke |
|---|---|---|---|
| `xs` | `h-3 w-3` | `h-3 w-3` | `1.5` |
| `sm` | `h-4 w-4` | `h-4 w-4` | `2` |
| `md` | `h-6 w-6` | `h-6 w-6` | `2.5` |
| `lg` | `h-8 w-8` | `h-8 w-8` | `3` |
| `xl` | `h-12 w-12` | `h-12 w-12` | `3.5` |

## Empty State

```blade
<gsmui:empty-state
    icon="inbox"
    title="No messages"
    description="You don't have any messages yet. Start a conversation to see messages here."
>
    <gsmui:button variant="primary">New Message</gsmui:button>
</gsmui:empty-state>
```

| Prop | Type | Default | Description |
|---|---|---|---|
| `icon` | string | `null` | Display icon |
| `title` | string | — | Main message |
| `description` | string | `null` | Secondary message |
| `size` | string | `md` | `sm`, `md`, `lg` |

## Error Boundary

```blade
<gsmui:error-boundary>
    {{-- Content that might throw --}}
    <x-dynamic-component :component="$widget" />
</gsmui:error-boundary>
```

```blade
<!-- Error fallback -->
<gsmui:error-boundary>
    <x-slot:fallback>
        <gsmui:empty-state
            icon="alert-triangle"
            title="Something went wrong"
            description="An error occurred while rendering this component."
        >
            <gsmui:button wire:click="retry" variant="primary">Try Again</gsmui:button>
        </gsmui:empty-state>
    </x-slot:fallback>
</gsmui:error-boundary>
```

| Prop | Type | Default | Description |
|---|---|---|---|
| `show-details` | bool | `false` | Show error details |
| `log-errors` | bool | `true` | Send to error tracking |
| `on-error` | string | `null` | Livewire method to call |

## Accessibility

| Component | ARIA | Behavior |
|---|---|---|
| Alert | `role="alert"` | Announced to screen readers |
| Toast | `role="status"` | Live region for updates |
| Banner | `role="banner"` | — |
| Progress | `role="progressbar"` | `aria-valuenow`, `aria-valuemax` |
| Skeleton | `aria-hidden="true"` | Hidden from screen readers |
| Spinner | `role="status"` + `aria-label` | Announced as loading |
| Empty State | N/A | Informational |
| Error Boundary | `role="alert"` | Error announced |
