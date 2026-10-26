---
title: Theme Builder UI
description: Visual editor, live preview, component preview, and export options.
order: 16.1
group: Theme Builder
---

# Theme Builder UI

The GsmUi Theme Builder is a visual tool for creating, customizing, and exporting themes without writing CSS.

## Builder Features

| Feature | Description |
|---|---|
| Visual editor | Point-and-click customization |
| Live preview | Real-time component preview |
| Component preview | Test all components |
| Export options | Multiple output formats |
| Import themes | Load existing themes |

## Visual Editor

### Editor Interface

```
┌─────────────────────────────────────────────────────┐
│ 🎨 Theme Builder                          [Export] │
├───────────┬─────────────────────────────────────────┤
│           │                                         │
│ Tokens    │  Live Preview                          │
│           │                                         │
│ Colors    │  ┌─────────────────────────────────┐  │
│ ○ Primary │  │                                 │  │
│ ○ Surface │  │  [Button]  [Input]  [Card]      │  │
│ ○ Text    │  │                                 │  │
│ ○ Border  │  │  [Modal]   [Table]  [Toast]     │  │
│           │  │                                 │  │
│ Spacing   │  └─────────────────────────────────┘  │
│ ○ Scale   │                                         │
│           │  Component Code                        │
│ Radius    │  ┌─────────────────────────────────┐  │
│ ○ Default │  │ <gsmui:button variant="primary"> │  │
│           │  │   Click me                       │  │
│ Typography│  │ </gsmui:button>                   │  │
│ ○ Font    │  └─────────────────────────────────┘  │
│ ○ Size    │                                         │
│           │                                         │
└───────────┴─────────────────────────────────────────┘
```

### Editor Panels

| Panel | Purpose |
|---|---|
| Colors | Color token editing |
| Spacing | Scale customization |
| Typography | Font settings |
| Radius | Border radius |
| Shadows | Shadow definitions |
| Components | Component-specific |

## Live Preview

### Preview Components

| Component | Preview |
|---|---|
| Button | All variants and sizes |
| Input | All states |
| Card | Various layouts |
| Modal | Modal appearance |
| Table | Data table |
| Alert | Alert types |

### Preview Controls

| Control | Description |
|---|---|
| Theme toggle | Switch between themes |
| Dark mode | Preview dark variant |
| Responsive | Test viewports |
| Component filter | Show specific components |

### Preview Configuration

```blade
<x-gsmui:theme-preview
    :tokens="$currentTokens"
    :components="['button', 'input', 'card', 'modal']"
    :show-code="true"
    height="600"
/>
```

## Component Preview

### Preview Grid

```blade
<x-gsmui:component-preview-grid
    :tokens="$currentTokens"
    :categories="['form', 'data', 'overlay']"
/>
```

### Preview Layout

```
┌─────────────────────────────────────────────┐
│ Components                                  │
├─────────────────────────────────────────────┤
│                                             │
│ Button                                      │
│ [Primary] [Secondary] [Danger] [Ghost]     │
│                                             │
│ Input                                       │
│ [Normal] [Focus] [Error] [Disabled]        │
│                                             │
│ Card                                        │
│ ┌─────────────────────┐                    │
│ │ Card Title          │                    │
│ │ Card content...     │                    │
│ └─────────────────────┘                    │
│                                             │
│ Modal                                       │
│ ┌─────────────────────┐                    │
│ │ × Modal Title       │                    │
│ │ Modal content...    │                    │
│ │ [Cancel] [Confirm]  │                    │
│ └─────────────────────┘                    │
│                                             │
└─────────────────────────────────────────────┘
```

## Export Options

### Export Formats

| Format | Description | Use Case |
|---|---|---|
| CSS Variables | `--gsmui-*` variables | Direct use |
| Tailwind Config | Tailwind plugin | Tailwind projects |
| JSON Tokens | Design tokens | Build tools |
| SCSS Variables | Sass variables | Sass projects |
| Theme Package | Complete package | Marketplace |

### Export Dialog

```blade
<x-gsmui:theme-export
    :tokens="$currentTokens"
    wire:model="showExport"
>
    <gsmui:form-field
        name="format"
        type="select"
        label="Export Format"
        :options="[
            'css' => 'CSS Variables',
            'tailwind' => 'Tailwind Config',
            'json' => 'JSON Tokens',
            'scss' => 'SCSS Variables',
            'package' => 'Theme Package',
        ]"
    />

    <gsmui:form-field
        name="prefix"
        label="Variable Prefix"
        placeholder="gsmui"
    />

    <gsmui:form-field
        name="include_dark"
        type="toggle"
        label="Include dark mode"
    />
</x-gsmui:theme-export>
```

### Export Preview

```css
/* CSS Variables Export */
:root {
    --gsmui-color-primary: #2563eb;
    --gsmui-color-primary-hover: #1d4ed8;
    --gsmui-color-surface: #ffffff;
    --gsmui-color-text: #18181b;
    --gsmui-radius: 0.5rem;
    --gsmui-shadow: 0 1px 2px rgba(0,0,0,0.05);
}

[data-theme="dark"] {
    --gsmui-color-primary: #3b82f6;
    --gsmui-color-surface: #18181b;
    --gsmui-color-text: #fafafa;
}
```

## Import Themes

### Import Dialog

```blade
<x-gsmui:theme-import wire:model="showImport">
    <gsmui:form-field
        name="file"
        type="file"
        label="Theme file"
        accept=".json,.css"
    />

    <gsmui:form-field
        name="merge"
        type="toggle"
        label="Merge with current theme"
    />
</x-gsmui:theme-import>
```

### Import Formats

| Format | Source |
|---|---|
| JSON | Gsmui theme file |
| CSS | CSS variables file |
| Tailwind | Tailwind config |
| Figma | Figma tokens |

## Theme History

### Version History

```
┌─────────────────────────────────────────────┐
│ 📜 Theme History                            │
├─────────────────────────────────────────────┤
│ v3.0 (current)    Apr 15, 2024  [Restore]  │
│ v2.1              Apr 10, 2024  [Restore]  │
│ v2.0              Mar 28, 2024  [Restore]  │
│ v1.0              Mar 15, 2024  [Restore]  │
└─────────────────────────────────────────────┘
```

## Builder Configuration

```php
// config/theme-engine.php
return [
    'builder' => [
        'enabled' => true,
        'autosave' => true,
        'autosave_interval' => 30, // seconds
        'max_versions' => 50,
        'export_formats' => ['css', 'tailwind', 'json', 'scss', 'package'],
        'import_formats' => ['json', 'css', 'tailwind', 'figma'],
    ],
];
```

## Keyboard Shortcuts

| Shortcut | Action |
|---|---|
| `Ctrl+S` | Save theme |
| `Ctrl+E` | Export theme |
| `Ctrl+Z` | Undo |
| `Ctrl+Shift+Z` | Redo |
| `Ctrl+P` | Toggle preview |
