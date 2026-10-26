---
title: Code Playground
description: Monaco editor integration, live preview, component snippets, and theme preview.
order: 14.5
group: Playground
---

# Code Playground

The GsmUi documentation playground provides an interactive environment for editing and previewing code directly in documentation pages.

## Playground Features

| Feature | Description |
|---|---|
| Monaco Editor | Full VS Code editor experience |
| Live Preview | Real-time component rendering |
| Component Snippets | Pre-built code templates |
| Theme Preview | See code in different themes |
| Share | Generate shareable links |

## Monaco Editor

### Editor Configuration

```blade
<x-gsmui:code-editor
    wire:model="code"
    language="blade"
    :theme="$isDark ? 'vs-dark' : 'vs'"
    :options="[
        'minimap' => false,
        'lineNumbers' => 'on',
        'fontSize' => 14,
        'tabSize' => 4,
    ]"
    height="400"
/>
```

### Editor Options

| Option | Type | Default | Description |
|---|---|---|---|
| `language` | string | `html` | Syntax language |
| `theme` | string | `vs` | Editor theme |
| `fontSize` | int | `14` | Font size |
| `tabSize` | int | `4` | Tab width |
| `minimap` | bool | `false` | Show minimap |
| `lineNumbers` | string | `on` | Line numbers |
| `readOnly` | bool | `false` | Read-only mode |
| `height` | int | `400` | Editor height |

### Supported Languages

| Language | Extension | Monaco ID |
|---|---|---|
| PHP | `.php` | `php` |
| Blade | `.blade.php` | `html` |
| JavaScript | `.js` | `javascript` |
| TypeScript | `.ts` | `typescript` |
| HTML | `.html` | `html` |
| CSS | `.css` | `css` |
| JSON | `.json` | `json` |
| Markdown | `.md` | `markdown` |

## Live Preview

### Preview Container

```blade
<x-gsmui:code-preview
    :code="$editorCode"
    language="blade"
    :debounce="300"
>
    <x-slot:loading>
        <gsmui:spinner size="md" label="Compiling..." />
    </x-slot:loading>

    <x-slot:error>
        <gsmui:alert variant="danger" :dismissible="false">
            Compilation error
        </gsmui:alert>
    </x-slot:error>
</xsmui:code-preview>
```

### Preview Pipeline

```
User edits code
    ↓
Debounce (300ms)
    ↓
Send to server
    ↓
Compile Blade
    ↓
Render HTML
    ↓
Return to preview
    ↓
Update iframe
```

### Preview Features

| Feature | Description |
|---|---|
| Hot reload | Updates on code change |
| Error display | Shows compilation errors |
| Responsive | Resizable preview area |
| Full screen | Expand to full viewport |
| Isolation | Sandboxed iframe |

## Component Snippets

### Snippet Library

| Snippet | Category | Code |
|---|---|---|
| Basic Button | Button | `<x-gsmui:button>Click</x-gsmui:button>` |
| Form | Form | Multi-field form template |
| Modal | Overlay | Modal with form |
| Data Table | Data | Table with sorting |
| Dashboard | Layout | Full dashboard layout |

### Snippet Manager

```blade
<x-gsmui:snippet-manager
    :snippets="$snippets"
    wire:model="activeSnippet"
    :categories="['Button', 'Form', 'Overlay', 'Layout']"
/>
```

### Snippet Schema

```json
{
  "id": "basic-button",
  "name": "Basic Button",
  "category": "Button",
  "description": "A simple button component",
  "code": "<gsmui:button>Click me</gsmui:button>",
  "tags": ["button", "action"]
}
```

### Using Snippets

| Action | Description |
|---|---|
| Click to insert | Replaces editor content |
| Drag to insert | Inserts at cursor |
| Append | Add to existing code |
| Replace selection | Overwrite selected text |

## Theme Preview

### Theme Switcher

```blade
<gsmui:theme-switcher
    wire:model="previewTheme"
    :themes="['default', 'dark', 'ocean', 'forest']"
/>
```

### Theme-Aware Preview

```blade
<div data-theme="{{ $previewTheme }}">
    <x-gsmui:code-preview :code="$code" />
</div>
```

### Theme Tokens in Preview

| Token | Light | Dark |
|---|---|---|
| Background | `#ffffff` | `#18181b` |
| Text | `#18181b` | `#fafafa` |
| Border | `#e4e4e7` | `#27272a` |
| Primary | `#2563eb` | `#3b82f6` |

## Share Links

### Generating Share Links

```php
public function shareCode(): string
{
    $encoded = base64_encode($this->code);
    return route('playground.show', ['code' => $encoded]);
}
```

### Share Link Format

```
/playground?code=PHgtZ3NtdTp...&theme=dark&lang=blade
```

### Share Options

| Parameter | Description |
|---|---|
| `code` | Base64-encoded code |
| `theme` | Editor theme |
| `lang` | Language mode |
| `view` | `editor`, `preview`, `split` |

## Playground Layout

### Split View

```
┌─────────────────┬─────────────────┐
│                 │                 │
│  Monaco Editor  │  Live Preview   │
│                 │                 │
│  <gsmui:button  │  ┌───────────┐ │
│  >Click</gsmui  │  │  [Click]  │ │
│  :button>       │  └───────────┘ │
│                 │                 │
├─────────────────┴─────────────────┤
│  Snippets: [Button] [Form] [...] │
└───────────────────────────────────┘
```

### Responsive Behavior

| Viewport | Layout |
|---|---|
| Desktop | Side-by-side |
| Tablet | Stacked (toggle) |
| Mobile | Full-screen toggle |

## Performance

| Metric | Target |
|---|---|
| Editor load | < 1s |
| Preview render | < 500ms |
| Share link gen | < 100ms |
| Snippet load | < 200ms |
