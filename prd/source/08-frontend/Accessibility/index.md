# Accessibility

> ARIA patterns, focus management, keyboard navigation, screen reader testing, WCAG 2.1 AA.

## ARIA Patterns

```blade
{{-- Modal dialog --}}
<div role="dialog" aria-modal="true" aria-labelledby="modal-title">
    <h2 id="modal-title">Confirm Action</h2>
    <p>Are you sure you want to proceed?</p>
    <div role="group" aria-label="Actions">
        <button type="button">Cancel</button>
        <button type="button">Confirm</button>
    </div>
</div>

{{-- Dropdown menu --}}
<div x-data="{ open: false }">
    <button aria-haspopup="true" :aria-expanded="open" @click="open = !open">
        Options
    </button>
    <div x-show="open" role="menu" aria-label="Options">
        <a href="#" role="menuitem">Edit</a>
        <a href="#" role="menuitem">Duplicate</a>
        <a href="#" role="menuitem" class="text-red-600">Delete</a>
    </div>
</div>

{{-- Tabs --}}
<div x-data="{ tab: 'tab1' }">
    <div role="tablist" aria-label="Product sections">
        <button role="tab" :aria-selected="tab === 'tab1'" @click="tab = 'tab1'" id="tab1">
            Details
        </button>
        <button role="tab" :aria-selected="tab === 'tab2'" @click="tab = 'tab2'" id="tab2">
            Pricing
        </button>
    </div>

    <div role="tabpanel" aria-labelledby="tab1" x-show="tab === 'tab1'">
        Details content
    </div>
    <div role="tabpanel" aria-labelledby="tab2" x-show="tab === 'tab2'">
        Pricing content
    </div>
</div>
```

## Focus Management

```blade
{{-- Trap focus in modal --}}
<div x-data="{
    trapFocus(event) {
        const focusable = this.$el.querySelectorAll(
            'button, [href], input, select, textarea, [tabindex]:not([tabindex=\'-1\'])'
        );
        const first = focusable[0];
        const last = focusable[focusable.length - 1];

        if (event.key === 'Tab') {
            if (event.shiftKey && document.activeElement === first) {
                event.preventDefault();
                last.focus();
            } else if (!event.shiftKey && document.activeElement === last) {
                event.preventDefault();
                first.focus();
            }
        }
    }
}" @keydown="trapFocus($event)">
    <input type="text" aria-label="Name">
    <button type="button">Save</button>
</div>

{{-- Focus visible styles --}}
<style>
    /* Don't show focus ring for mouse users */
    :focus:not(:focus-visible) {
        outline: none;
    }

    /* Show focus ring for keyboard users */
    :focus-visible {
        outline: 2px solid rgb(14 165 233);
        outline-offset: 2px;
    }
</style>
```

## Keyboard Navigation

```blade
{{-- Arrow key navigation --}}
<div x-data="{
    items: ['Item 1', 'Item 2', 'Item 3'],
    active: 0,
    handleKeydown(event) {
        if (event.key === 'ArrowDown') {
            event.preventDefault();
            this.active = (this.active + 1) % this.items.length;
        } else if (event.key === 'ArrowUp') {
            event.preventDefault();
            this.active = (this.active - 1 + this.items.length) % this.items.length;
        } else if (event.key === 'Enter' || event.key === ' ') {
            event.preventDefault();
            this.select(this.items[this.active]);
        } else if (event.key === 'Escape') {
            this.close();
        }
    }
}" @keydown="handleKeydown($event)" role="listbox" aria-label="Items">
    <template x-for="(item, index) in items" :key="index">
        <div role="option" :aria-selected="index === active"
             @click="active = index" :tabindex="index === active ? 0 : -1"
             :class="index === active ? 'bg-blue-50' : ''"
             x-text="item">
        </div>
    </template>
</div>

{{-- Skip navigation link --}}
<a href="#main-content" class="sr-only focus:not-sr-only focus:absolute focus:top-4 focus:left-4 focus:z-50 focus:rounded-lg focus:bg-blue-600 focus:px-4 focus:py-2 focus:text-white">
    Skip to main content
</a>
```

## Form Accessibility

```blade
{{-- Accessible form --}}
<form>
    <div class="space-y-4">
        {{-- Input with label --}}
        <div>
            <label for="email" class="block text-sm font-medium text-zinc-700">
                Email address <span class="text-red-500">*</span>
            </label>
            <input type="email" id="email" name="email" required
                   aria-describedby="email-hint email-error"
                   aria-invalid="false"
                   class="mt-1 block w-full rounded-lg border border-zinc-300 px-3 py-2">
            <p id="email-hint" class="mt-1 text-sm text-zinc-500">
                We'll never share your email.
            </p>
            <p id="email-error" class="mt-1 text-sm text-red-600" role="alert">
                Please enter a valid email address.
            </p>
        </div>

        {{-- Select --}}
        <div>
            <label for="country" class="block text-sm font-medium text-zinc-700">
                Country
            </label>
            <select id="country" name="country" aria-describedby="country-hint">
                <option value="">Select a country</option>
                <option value="us">United States</option>
                <option value="uk">United Kingdom</option>
            </select>
            <p id="country-hint" class="mt-1 text-sm text-zinc-500">
                Required for shipping calculations.
            </p>
        </div>

        {{-- Checkbox --}}
        <div class="flex items-start gap-3">
            <input type="checkbox" id="terms" name="terms" required
                   aria-describedby="terms-error"
                   class="mt-1 h-4 w-4 rounded border-zinc-300">
            <div>
                <label for="terms" class="text-sm text-zinc-700">
                    I agree to the <a href="/terms" class="text-blue-600 underline">Terms of Service</a>
                </label>
                <p id="terms-error" class="text-sm text-red-600" role="alert">
                    You must accept the terms.
                </p>
            </div>
        </div>
    </div>
</form>
```

## Screen Reader Support

```blade
{{-- Live regions for dynamic content --}}
<div aria-live="polite" aria-atomic="true" class="sr-only">
    @if(session('success'))
        {{ session('success') }}
    @endif
</div>

{{-- Status messages --}}
<div role="status" aria-live="polite">
    @if($loading)
        Loading products...
    @endif
</div>

{{-- Error summaries --}}
<div role="alert" aria-live="assertive">
    @if($errors->any())
        <div class="rounded-lg border border-red-200 bg-red-50 p-4">
            <h3 class="text-sm font-medium text-red-800">
                There {{ $errors->count() === 1 ? 'is' : 'are' }} {{ $errors->count() }} error(s)
            </h3>
            <ul class="mt-2 list-inside list-disc text-sm text-red-700">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</div>

{{-- Icon with accessible label --}}
<button aria-label="Delete product">
    <svg class="h-5 w-5" aria-hidden="true" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
    </svg>
</button>
```

## Color Contrast

| Element | WCAG AA Ratio | WCAG AAA Ratio |
|---|---|---|
| Normal text (< 18pt) | 4.5:1 | 7:1 |
| Large text (≥ 18pt) | 3:1 | 4.5:1 |
| UI components | 3:1 | 4.5:1 |
| Focus indicators | 3:1 | 4.5:1 |

## Testing Checklist

- [ ] All interactive elements reachable via keyboard
- [ ] Focus order is logical and intuitive
- [ ] Focus visible on all interactive elements
- [ ] No keyboard traps
- [ ] All images have alt text
- [ ] All forms have labels
- [ ] Error messages associated with fields
- [ ] Color is not sole indicator of state
- [ ] Text resizable to 200% without loss
- [ ] Screen reader can access all content
- [ ] ARIA attributes correctly applied
- [ ] Touch targets ≥ 44x44px
