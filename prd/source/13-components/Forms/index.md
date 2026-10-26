---
title: Form System
description: Form builder, validation, field types, conditional logic, multi-step forms, and file upload integration.
order: 13.7
group: Forms
---

# Form System

GsmUi provides a comprehensive form system combining Blade field components with Livewire validation, conditional logic, and multi-step wizard support.

## Form Builder

```blade
<gsmui:form wire:submit="save" :schema="$formSchema">
    <gsmui:form-field name="name" label="Full name" required />
    <gsmui:form-field name="email" label="Email" type="email" required />

    <gsmui:form-section title="Address">
        <gsmui:form-field name="street" label="Street" />
        <div class="grid grid-cols-2 gap-4">
            <gsmui:form-field name="city" label="City" />
            <gsmui:form-field name="zip" label="ZIP Code" />
        </div>
    </gsmui:form-section>

    <x-slot:footer>
        <gsmui:button type="button" variant="ghost" wire:click="cancel">Cancel</gsmui:button>
        <gsmui:button type="submit" variant="primary" :loading="$isSaving">Save</gsmui:button>
    </x-slot:footer>
</gsmui:form>
```

### Form Props

| Prop | Type | Default | Description |
|---|---|---|---|
| `wire:submit` | string | — | Submit handler method |
| `schema` | array | `null` | Declarative field schema |
| `live` | bool | `false` | Real-time validation |
| `validate-on` | string | `blur` | `blur`, `change`, `submit` |
| `show-errors` | bool | `true` | Display validation errors |

## Validation

### Server-Side (Livewire)

```php
public function rules(): array
{
    return [
        'name' => 'required|string|min:2|max:255',
        'email' => 'required|email|unique:users,email',
        'age' => 'nullable|integer|min:18|max:120',
        'website' => 'nullable|url',
    ];
}

public function messages(): array
{
    return [
        'email.unique' => 'This email is already registered.',
        'age.min' => 'You must be at least 18 years old.',
    ];
}
```

### Client-Side (HTML5)

```blade
<gsmui:input
    wire:model="email"
    type="email"
    required
    pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$"
    minlength="5"
    maxlength="255"
/>
```

### Validation Events

| Event | Trigger | Behavior |
|---|---|---|
| `blur` | Field loses focus | Validate single field |
| `change` | Value changes | Validate on each keystroke |
| `submit` | Form submitted | Validate all fields |
| `debounce-500` | 500ms after change | Debounced validation |

## Field Types

| Type | Component | Props |
|---|---|---|
| Text | `<gsmui:form-field type="text">` | `placeholder`, `maxlength` |
| Email | `<gsmui:form-field type="email">` | `placeholder` |
| Password | `<gsmui:form-field type="password">` | `toggleable` |
| Number | `<gsmui:form-field type="number">` | `min`, `max`, `step` |
| Tel | `<gsmui:form-field type="tel">` | `mask` |
| URL | `<gsmui:form-field type="url">` | `placeholder` |
| Textarea | `<gsmui:form-field type="textarea">` | `rows`, `autoresize` |
| Select | `<gsmui:form-field type="select">` | `options`, `placeholder` |
| Multi-select | `<gsmui:form-field type="multiselect">` | `options`, `max` |
| Checkbox | `<gsmui:form-field type="checkbox">` | `description` |
| Radio group | `<gsmui:form-field type="radio">` | `options`, `inline` |
| Toggle | `<gsmui:form-field type="toggle">` | `description` |
| Date | `<gsmui:form-field type="date">` | `min`, `max`, `format` |
| Time | `<gsmui:form-field type="time">` | `min`, `max`, `step` |
| DateTime | `<gsmui:form-field type="datetime">` | `format`, `timezone` |
| File | `<gsmui:form-field type="file">` | `accept`, `max-size`, `max-files` |
| Color | `<gsmui:form-field type="color">` | `swatches` |
| Range | `<gsmui:form-field type="range">` | `min`, `max`, `step` |

## Conditional Logic

### Show/Hide Fields

```php
public function getShowPhoneProperty(): bool
{
    return $this->contactMethod === 'phone';
}
```

```blade
<gsmui:form-field
    name="phone"
    type="tel"
    label="Phone number"
    x-show="$get('showPhone')"
    x-transition
/>
```

### Field Dependencies

| Condition | Syntax | Example |
|---|---|---|
| Equals | `=` | `contactMethod = "phone"` |
| Not equals | `!=` | `status != "draft"` |
| Contains | `contains` | `tags contains "important"` |
| Greater than | `>` | `age > 18` |
| Less than | `<` | `amount < 1000` |
| In list | `in` | `role in ["admin","editor"]` |

### Computed Fields

```php
public function getFullNameProperty(): string
{
    return trim("{$this->firstName} {$this->lastName}");
}
```

## Multi-Step Forms

```blade
<gsmui:multi-step wire:model="currentStep" :total-steps="3">
    <gsmui:step label="Personal Info">
        <gsmui:form-field name="firstName" label="First name" required />
        <gsmui:form-field name="lastName" label="Last name" required />
    </gsmui:step>

    <gsmui:step label="Contact">
        <gsmui:form-field name="email" label="Email" type="email" required />
        <gsmui:form-field name="phone" label="Phone" type="tel" />
    </gsmui:step>

    <gsmui:step label="Review">
        <div class="space-y-2">
            <p><strong>Name:</strong> {{ $firstName }} {{ $lastName }}</p>
            <p><strong>Email:</strong> {{ $email }}</p>
        </div>
    </gsmui:step>

    <x-slot:footer>
        <gsmui:button
            type="button"
            wire:click="previousStep"
            x-show="$get('currentStep') > 1"
        >Back</gsmui:button>
        <gsmui:button
            type="button"
            wire:click="nextStep"
            x-show="$get('currentStep') < 3"
        >Next</gsmui:button>
        <gsmui:button
            type="submit"
            variant="primary"
            x-show="$get('currentStep') === 3"
        >Submit</gsmui:button>
    </x-slot:footer>
</gsmui:multi-step>
```

### Multi-Step Props

| Prop | Type | Default | Description |
|---|---|---|---|
| `wire:model` | string | — | Current step binding |
| `total-steps` | int | — | Total steps count |
| `linear` | bool | `true` | Prevent skipping steps |
| `show-progress` | bool | `true` | Show progress bar |

## File Upload Integration

```blade
<gsmui:form-field name="avatar" type="file" label="Profile photo">
    <x-slot:hint>Max 5MB. JPG, PNG, or GIF.</x-slot:hint>
</gsmui:form-field>
```

```php
public function save(): void
{
    $this->validate();

    if ($this->avatar) {
        $path = $this->avatar->store('avatars', 'public');
        $this->user->update(['avatar' => $path]);
    }
}
```

## Accessibility

| Feature | Implementation |
|---|---|
| Labels | Every field has an associated `<label>` |
| Error messages | `aria-describedby` links to error text |
| Required fields | `aria-required="true"` on input |
| Invalid fields | `aria-invalid="true"` on input |
| Error summary | Focus moved to error list on submit |
| Keyboard | Full Tab/Enter/Space navigation |
