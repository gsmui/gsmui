---
title: Component API Reference
description: Complete API reference for all components — props, events, slots, methods, CSS classes, and accessibility.
order: 13.13
group: Component API
---

# Component API Reference

Complete API documentation for all Gsmui components. Each component entry includes props, events, slots, methods, CSS classes, and accessibility details.

## API Structure

Every component follows this API pattern:

| Section | Description |
|---|---|
| Props | Configuration properties |
| Events | Emitted/dispatched events |
| Slots | Content injection points |
| Methods | Programmatic API |
| CSS Classes | Styling hooks |
| Accessibility | ARIA and keyboard support |

## Button API

### Props

| Prop | Type | Default | Description |
|---|---|---|---|
| `variant` | `string` | `'primary'` | Button style |
| `size` | `string` | `'md'` | Button size |
| `disabled` | `bool` | `false` | Disabled state |
| `loading` | `bool` | `false` | Loading state |
| `icon` | `string` | `null` | Icon name |
| `icon-position` | `string` | `'left'` | Icon placement |
| `as` | `string` | `'button'` | Element type |
| `href` | `string` | `null` | Link URL |
| `type` | `string` | `'button'` | Button type |

### Events

| Event | Payload | Description |
|---|---|---|
| `click` | `MouseEvent` | Button clicked |

### Slots

| Slot | Scope | Description |
|---|---|---|
| `default` | — | Button content |
| `icon` | — | Custom icon |

### CSS Classes

| Class | Description |
|---|---|
| `gsmui-button` | Root element |
| `gsmui-button--primary` | Variant modifier |
| `gsmui-button--md` | Size modifier |
| `gsmui-button--loading` | Loading state |
| `gsmui-button--disabled` | Disabled state |

---

## Input API

### Props

| Prop | Type | Default | Description |
|---|---|---|---|
| `wire:model` | `string` | — | Livewire binding |
| `type` | `string` | `'text'` | Input type |
| `label` | `string` | `null` | Visible label |
| `placeholder` | `string` | `null` | Placeholder text |
| `disabled` | `bool` | `false` | Disabled state |
| `invalid` | `bool` | `false` | Error state |
| `hint` | `string` | `null` | Help text |
| `prefix` | `string` | `null` | Prefix addon |
| `suffix` | `string` | `null` | Suffix addon |
| `size` | `string` | `'md'` | Input size |

### Events

| Event | Payload | Description |
|---|---|---|
| `input` | `InputEvent` | Value changed |
| `change` | `Event` | Value committed |
| `focus` | `FocusEvent` | Input focused |
| `blur` | `FocusEvent` | Input blurred |

### Slots

| Slot | Scope | Description |
|---|---|---|
| `prefix` | — | Prefix content |
| `suffix` | — | Suffix content |
| `hint` | — | Custom hint |
| `error` | `$error` | Custom error message |

### CSS Classes

| Class | Description |
|---|---|
| `gsmui-input` | Root element |
| `gsmui-input--md` | Size modifier |
| `gsmui-input--invalid` | Error state |

---

## Modal API

### Props

| Prop | Type | Default | Description |
|---|---|---|---|
| `wire:model` | `string` | — | Visibility binding |
| `title` | `string` | `null` | Modal title |
| `size` | `string` | `'md'` | Modal size |
| `closeable` | `bool` | `true` | Close button |
| `closeOnEscape` | `bool` | `true` | Escape key closes |
| `closeOnOverlay` | `bool` | `true` | Overlay click closes |

### Events

| Event | Payload | Description |
|---|---|---|
| `open` | — | Modal opened |
| `close` | — | Modal closed |
| `escape` | — | Escape pressed |

### Slots

| Slot | Scope | Description |
|---|---|---|
| `default` | — | Modal body |
| `header` | — | Custom header |
| `footer` | — | Modal footer |

### Methods

| Method | Description |
|---|---|
| `open()` | Programmatically open |
| `close()` | Programmatically close |
| `toggle()` | Toggle visibility |

---

## Table API

### Props

| Prop | Type | Default | Description |
|---|---|---|---|
| `columns` | `array` | — | Column definitions |
| `rows` | `array` | — | Row data |
| `sortable` | `bool` | `false` | Enable sorting |
| `selectable` | `bool` | `false` | Enable row selection |
| `striped` | `bool` | `false` | Alternating rows |
| `hoverable` | `bool` | `true` | Hover highlight |
| `compact` | `bool` | `false` | Reduced padding |

### Events

| Event | Payload | Description |
|---|---|---|
| `sort` | `{ column, direction }` | Column sorted |
| `select` | `{ rows, all }` | Rows selected |

### Methods

| Method | Description |
|---|---|
| `selectAll()` | Select all rows |
| `deselectAll()` | Deselect all rows |
| `sort(column, direction)` | Sort by column |

---

## Tabs API

### Props

| Prop | Type | Default | Description |
|---|---|---|---|
| `wire:model` | `string` | — | Active tab binding |
| `variant` | `string` | `'underline'` | Tab style |
| `size` | `string` | `'md'` | Tab size |
| `stretch` | `bool` | `false` | Full width |

### Events

| Event | Payload | Description |
|---|---|---|
| `change` | `{ name, index }` | Tab changed |

### Methods

| Method | Description |
|---|---|
| `select(name)` | Activate tab by name |
| `next()` | Activate next tab |
| `previous()` | Activate previous tab |

---

## Global CSS Classes

| Class | Description |
|---|---|
| `gsmui-*` | Component root classes |
| `gsmui-theme-dark` | Dark mode modifier |
| `gsmui-size-*` | Size modifiers |
| `gsmui-variant-*` | Variant modifiers |
| `gsmui-state-*` | State modifiers |

## Accessibility Quick Reference

| Component | ARIA Role | Keyboard |
|---|---|---|
| Button | Native `<button>` | Enter, Space |
| Input | Native `<input>` | Full keyboard |
| Select | `combobox` | Arrow, Escape |
| Modal | `dialog` | Tab trap, Escape |
| Tabs | `tablist` | Arrow, Home, End |
| Table | `grid` | Arrow keys |
| Dropdown | `menu` | Arrow, Enter, Escape |
| Tooltip | `tooltip` | — |
| Toast | `status` | — |
| Progress | `progressbar` | — |
