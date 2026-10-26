---
title: "Code Editor"
description: "Browser-based editing environment with Monaco editor integration"
volume: "17"
---

# Code Editor

The Code Editor is a powerful, browser-based editing environment for writing and modifying component code within the playground. It provides a familiar IDE experience with advanced features for efficient development.

## Overview

The code editor integrates industry-standard editing capabilities with gsmui-specific optimizations. It supports multiple file types, real-time syntax validation, and intelligent code assistance tailored to Livewire and Alpine.js development.

## Core Features

### Monaco Editor Integration

| Feature | Description |
|---------|-------------|
| Multi-file editing | Tabbed interface for multiple open files |
| Split view | Side-by-side editing with linked scrolling |
| Minimap | Visual overview of entire file structure |
| Find & replace | Regex support, case sensitivity, whole word matching |
| Multi-cursor | Edit multiple locations simultaneously |
| Code folding | Collapse/expand sections for better readability |

### Syntax Highlighting

```php
// Blade template highlighting
<div class="{{ $classes }}">
    @if($active)
        <span class="text-primary">{{ $label }}</span>
    @endif
</div>
```

| Language | Support Level |
|----------|---------------|
| PHP | Full - with Laravel/Flux helpers |
| Blade | Full - including components and directives |
| JavaScript | Full - ES2024+ syntax |
| Alpine.js | Full - x-data, x-bind, x-on directives |
| HTML/CSS | Full - with Tailwind CSS class recognition |
| JSON | Full - configuration files |

### Auto-Completion

- **Component suggestions**: `<gsmui:` triggers component completion
- **Prop completion**: Attributes contextually filtered by component type
- **Tailwind classes**: IntelliSense for utility classes with JIT compilation
- **Blade directives**: `@if`, `@foreach`, `@yield`, `@extends` completions
- **PHP functions**: Laravel helpers, collection methods, Eloquent query builder
- **Import paths**: Auto-complete for `use` statements and imports

### Linting & Validation

| Linter | Purpose |
|--------|---------|
| PHP-CS-Fixer | Code style enforcement |
| ESLint | JavaScript best practices |
| Livewire Lint | Livewire-specific patterns |
| Accessibility Lint | ARIA and WCAG compliance checks |
| Tailwind Lint | Class ordering and conflicts |

Real-time validation shows errors as you type with quick-fix suggestions.

## Themes

### Built-in Themes

| Theme | Description |
|-------|-------------|
| Light | Clean, high-contrast light theme |
| Dark | Developer-friendly dark theme |
| High Contrast | Accessibility-focused high contrast |
| Solarized Light | Warm, eye-friendly light theme |
| Solarized Dark | Popular warm dark theme |
| Monokai | Classic syntax coloring |
| One Dark Pro | Atom-inspired dark theme |

### Theme Customization

```yaml
editor.theme:
  background: "#1e1e2e"
  foreground: "#cdd6f4"
  keyword: "#cba6f7"
  string: "#a6e3a1"
  comment: "#6c7086"
  function: "#89b4fa"
  variable: "#f38ba8"
  lineHighlight: "#313244"
```

## Keyboard Shortcuts

| Action | Windows/Linux | macOS |
|--------|---------------|-------|
| Command Palette | `Ctrl+Shift+P` | `Cmd+Shift+P` |
| Save | `Ctrl+S` | `Cmd+S` |
| Find | `Ctrl+F` | `Cmd+F` |
| Replace | `Ctrl+H` | `Cmd+H` |
| Go to Line | `Ctrl+G` | `Cmd+G` |
| Toggle Comment | `Ctrl+/` | `Cmd+/` |
| Format Document | `Shift+Alt+F` | `Shift+Option+F` |
| Duplicate Line | `Shift+Alt+Down` | `Shift+Option+Down` |
| Delete Line | `Ctrl+Shift+K` | `Cmd+Shift+K` |
| Toggle Minimap | `Ctrl+Shift+M` | `Cmd+Shift+M` |

## Editor Configuration

```yaml
editor:
  fontSize: 14
  fontFamily: "'Fira Code', 'JetBrains Mono', monospace"
  fontLigatures: true
  tabSize: 4
  insertSpaces: true
  wordWrap: "on"
  lineNumbers: true
  renderWhitespace: "boundary"
  bracketPairColorization: true
  smoothScrolling: true
  cursorBlinking: "smooth"
  cursorSmoothCaretAnimation: "on"
  formatOnSave: true
  formatOnPaste: true
  suggestOnTriggerCharacters: true
  acceptSuggestionOnCommitCharacter: true
```

## File Support

### Supported File Types

| Extension | Language | Features |
|-----------|----------|----------|
| `.blade.php` | Blade | Component highlighting, directive completion |
| `.php` | PHP | Full Laravel support |
| `.js` | JavaScript | ES2024, Alpine.js |
| `.css` | CSS | Tailwind CSS utilities |
| `.html` | HTML | Full HTML5 |
| `.json` | JSON | Configuration files |
| `.yaml` | YAML | Configuration files |
| `.md` | Markdown | Preview rendering |
| `.php` (Livewire) | Livewire | Component class completion |

### Component Templates

When creating new files, the editor offers templates:

- **Blank Component**: Empty Livewire class
- **Form Component**: Input with validation
- **Modal Component**: Dialog with header/body/footer
- **Table Component**: Data table with sorting/pagination
- **Dashboard Widget**: Card-based statistics display

## Performance

- Lazy loading of language services
- Web Worker-based linting (non-blocking)
- Incremental parsing for large files
- Virtual scrolling for long documents
- IndexedDB caching of configuration

## Accessibility

- Full screen reader support for editor operations
- Keyboard navigation for all editor features
- High contrast mode for visual impairments
- Configurable font sizes and line heights
- Focus indicators for all interactive elements

## Integration Points

- **Live Preview**: Changes reflect instantly in preview pane
- **AI Assistant**: Inline suggestions and refactoring
- **Export**: Copy or download edited code
- **Share**: Generate shareable links to specific code states
- **Templates**: Insert pre-built component patterns

## Security

| Measure | Description |
|---------|-------------|
| Content Security Policy | CSP headers enforced in editor iframe |
| Input sanitization | Prevent XSS in code content |
| Sandboxed execution | Code runs in isolated environment |
| File access restrictions | No access to local file system |
| Network restrictions | Limited external requests |
| Permission controls | Role-based editor access |

## Testing

| Test Type | Description |
|-----------|-------------|
| Unit tests | Editor component logic |
| Integration tests | Editor with other playground features |
| Performance tests | Large file handling |
| Accessibility tests | WCAG 2.1 AA compliance |
| Security tests | Vulnerability scanning |

## Edge Cases

| Scenario | Handling |
|----------|----------|
| Very large files (>10MB) | Virtual scrolling, lazy loading |
| Special characters | Proper encoding and escaping |
| Concurrent edits | Conflict resolution |
| Offline mode | Cached language services |
| Browser compatibility | Feature detection and fallbacks |
| Memory pressure | Resource cleanup and optimization