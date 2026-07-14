# Gsmui Pro Component Builder Prompt

You are building a UI component for **Gsmui Pro** (fork of Flux Pro), a Laravel Livewire UI component library. Read this entire prompt before writing any code. It defines the system's architecture, conventions, security rules, and CSP constraints.

---

## 1. Architecture

- **Container + sub-elements**: Container component (e.g. `date-picker/index.blade.php`) wraps sub-elements (`date-picker/button.blade.php`, `date-picker/input.blade.php`, `date-picker/selected.blade.php`)
- **Custom elements**: UI behavior uses custom elements registered via `element("name", Class)` → `<ui-name>`. Nearly all JS is in custom elements extending `UIElement` or `UIControl`.
- **JS mixins**: Use existing mixins: `Controllable`, `Disableable`, `Submittable`, `Focusable`, `Activatable`, `Filterable`, `Popoverable`, `Dialogable`, `Closeable`. Copy patterns from sibling components.
- **Sub-elements call methods on the root element**: A `<ui-option>` calls methods on its parent `<ui-select>` root.
- **Use `detangle()`** to prevent sync loops between `Controllable` and internal state subscriptions.
- **State lives in JS classes**, not Alpine. Alpine (`x-data`, `x-init`, `x-effect`) is rarely used — only when reasonably necessary.

## 2. Blade Component Structure

Every component lives in `stubs/resources/views/gsmui/<component>/index.blade.php`.

### Template skeleton

```blade
@blaze(fold: true, unsafe: [
    // Props listed in `unsafe` are consumed internally by this component
    // and are NOT passed through as HTML attributes to the root element.
    // `fold: true` enables compile-time template folding for performance.
    'name', 'label', 'placeholder', 'invalid', 'size',
    'error:name', 'error:bag',
])

@props([
    'placeholder' => null,
    'invalid' => null,
    'size' => null,
    'name' => null,
])

@php
$showName = isset($name);
if (! isset($name)) {
    $name = $attributes->whereStartsWith('wire:model')->first();
}

// Support .self modifier on wire:model...
if (($wireModel = $attributes->wire('model')) && $wireModel->directive && ! $wireModel->hasModifier('self')) {
    unset($attributes[$wireModel->directive]);
    $wireModel->directive .= '.self';
    $attributes = $attributes->merge([$wireModel->directive => $wireModel->value]);
}

// Mark invalid if the property has errors...
$invalid ??= ($name && ($errors->has($name) || $errors->has($name . '.*')));

$classes = Gsmui::classes()
    ->add('block min-w-0')
    ->add('border-0 p-0 bg-transparent') // Revert Tailwind Forms plugin styles
    ;
@endphp

<gsmui:with-field :$attributes :$name>
    <ui-component-name
        {{ $attributes->class($classes) }}
        data-gsmui-control
        data-gsmui-component-name
        @if ($showName) name="{{ $name }}" @endif
    >
        {{ $slot }}
    </ui-component-name>
</gsmui:with-field>
```

### Component naming

- **Blade namespace**: `gsmui:component-name` (e.g. `gsmui:date-picker`, `gsmui:select.input`)
- **Data attributes**: `data-gsmui-component-part` (e.g. `data-gsmui-date-picker`, `data-gsmui-pillbox-input`)
- **Custom elements**: `ui-component-name` (e.g. `ui-select`, `ui-slider`, `ui-calendar`)
- **JS class**: registered via `element("name", Class)` in `dist/gsmui.js`
- **php class** (when needed): `Gsmui::classes()` for class merging

## 3. Naming Conventions

- **Short, natural prop names**: `dropper` not `eye-dropper`
- **`-able` suffix**: `clearable`, `copyable`, `searchable`, `expandable`
- **`type` prop for variants**: `type="input"` vs `type="button"`, not boolean props like `:input="true"`
- **Sub-components as dot notation**: `gsmui:date-picker.button`, `gsmui:select.option`

## 4. Styling Conventions

- **Cursors**: `cursor-pointer` only for navigation elements. Buttons and clickable widgets keep default cursor.
- **Focus rings**: Prefer native browser outlines on `<button>`, `<input>`. On custom elements with `tabindex="0"`, use: `has-focus-visible:outline-2 has-focus-visible:outline-[-webkit-focus-ring-color]`. Never use `focus:outline-none focus:ring-2`.
- **Dialog/popover**: Copy from date-picker:
  ```blade
  max-sm:max-h-full! rounded-xl shadow-xl sm:shadow-2xs max-sm:fixed! max-sm:inset-0! sm:backdrop:bg-transparent bg-white dark:bg-zinc-700 sm:border border-zinc-200 dark:border-white/10 p-3
  ```
- **Trigger button**: Copy from `date-picker/button.blade.php`:
  - Height: `h-10 / h-8 / h-6` (default / sm / xs)
  - Text: `text-base sm:text-sm / text-sm / text-xs`
  - Radius: `rounded-lg / rounded-md / rounded-md`
- **Input**: Copy from `gsmui:input` outline variant: `bg-white dark:bg-white/10`, `border-zinc-200 border-b-zinc-300/80 dark:border-white/10`, `shadow-xs`, `rounded-lg`
- **Disabled**: Custom elements need `[&[disabled]]:shadow-none!` attribute selectors (CSS `:disabled` only works on native form elements)
- **Invalid**: Layer `data-invalid:` classes on top of base styles — never ternary-swap entire class blocks
- **Lock scroll when popover is open**: Copy date-picker pattern (uses `lockScroll` from utils)

## 5. JavaScript Conventions

- **Use `setAttribute`/`removeAttribute` from utils.js**, not native DOM methods. These have MutationObserver implications.
- **Fire both `input` and `change` events** on value changes. `change` fires on pointer commit (mouse release), not on popover close.
- **MutationObserver should watch `value` attribute** in addition to config attributes.
- **Use `WeakMap` for internal state** — never store state on DOM elements as expando properties.
- **Keyboard navigation**: Arrow keys move in grids. Home/End = horizontal edges. PageUp/PageDown = vertical edges.
- **Lean on the browser**: A `<canvas>` parses any CSS color. Don't ship lookup tables.

## 6. Alpine.js Usage

- Alpine is **rarely used** in Gsmui Pro. Move interaction logic to JS when it needs disabled-state awareness or component coordination.
- When Alpine IS used, use `Alpine.data("gsmuiComponentName", ...)` — NOT inline `x-data` in templates.

## 7. Blade / PHP Conventions

- **Aria-labels use `__()`** for localization. Set from Blade (where `__()` runs). JS uses Blade-set value as primary, hardcoded English as fallback.
- **Use real `<gsmui:button>` for action buttons**. Only use `<gsmui:button as="div">` when nested inside a `<button>` (nested-button constraint).
- **ARIA**: Input trigger = `role="combobox"` on `<input>`. Button trigger = native `<button>` with `aria-haspopup="dialog"`. Follow ARIA APG patterns.
- **Prop order** (for consistency across the library): `wire:model`, `value`, `name`, `format`, `type`, `placeholder`, `size` → behavioral props (`clearable`, `copyable`, `swatches`, `dropper`) → `label`, `description`, `disabled`, `invalid`. Never alphabetical.

## 8. Security (Always Enforce)

### No-go patterns (blocked by CSP)

| Pattern | Why it's blocked |
|---|---|
| CDN script/style/font tags | Violates `script-src 'self'` / `style-src 'self'` |
| `eval()`, `Function()` constructor | Violates CSP, opens RCE vector |
| `innerHTML`, `outerHTML`, `insertAdjacentHTML` | XSS vector — use DOM methods instead |
| `blob:` URIs for executable content | CSP block |
| `data:` URIs for scripts | CSP block |
| Inline event handlers (`onclick`, `onerror`, etc.) | CSP block |
| `__proto__`, `constructor` manipulation | Prototype pollution vector |
| Dynamic `require()` / `import()` | CSP block |

### Safe patterns

- **`Object.defineProperties`** with explicit descriptors (enumerable, configurable, get/set)
- **`WeakMap`/`WeakSet`** for internal state (DOM element as keys)
- **`adoptedStyleSheets`** + `CSSStyleSheet` for dynamic CSS (CSP-safe)
- **`setAttribute`/`removeAttribute`** from utils.js (MutationObserver-aware)
- **`event.isTrusted`** check on security-sensitive event handlers
- **Always escape Blade output** with `{{ }}` (never `{!! !!}` for user content)

### Prototype modification rules

If you MUST modify a native prototype (like the popover polyfill does):
- Use `Object.defineProperties` with explicit property descriptors
- Save the original method (`const original = prototype.method`)
- Wrap the original, don't replace it blindly
- Validate inputs (e.g. `instanceof Element`, `isTrusted`)
- Never use `__proto__` or dynamic property assignment on prototypes

## 9. CSP Compliance

Gsmui Pro's CSP header is: `default-src 'self'; script-src 'self'; style-src 'self' 'unsafe-inline'; img-src 'self' data:`

This means:
- **All scripts must be self-hosted** in `dist/` — no CDN
- **All styles must be bundled** in `dist/editor.css` or injected via `adoptedStyleSheets`
- **No external network requests** from JS — each addition needs config update
- **No Web Workers or Service Workers** — each addition needs CSP config update
- **No fonts** beyond system font stack

## 10. Component Development Checklist

Before claiming a component is done:

- [ ] Blade template follows the skeleton structure above
- [ ] All output uses `{{ }}` (escaped) unless intentional unescaped with `{!! !!}` for safe hardcoded strings
- [ ] Custom element registered via `element("name", Class)`
- [ ] Data attributes use `data-gsmui-*` prefix
- [ ] Gsmui Pro's Facade used as `Gsmui::classes()` not `Flux::classes()`
- [ ] Component prefix is `gsmui:` not `flux:`
- [ ] CSS variables use `--gsmui-*` not `--flux-*`
- [ ] No external URLs, CDN resources, or `eval()` in JS
- [ ] All event handlers check `event.isTrusted` for security-sensitive operations
- [ ] Keyboard navigation works (Arrow keys, Home, End, Escape)
- [ ] Disabled and invalid states are visually distinct
- [ ] Scroll is locked when popover/dialog is open
- [ ] Works in dark mode
- [ ] RTL-friendly (use `rtl:` variants where applicable)
- [ ] Verified with Playwright (screenshot + interaction test)
