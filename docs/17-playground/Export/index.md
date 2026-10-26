---
title: "Export Options"
description: "Export playground code to various formats and external services"
volume: "17"
---

# Export Options

Export your playground code to various formats and external services for continued development, sharing, or production deployment.

## Overview

The Export system provides multiple pathways to get your code out of the playground environment, whether for local development, external editors, or online IDEs. Each export format is optimized for its target platform.

## Export Methods

### Download as ZIP

| Option | Description |
|--------|-------------|
| Full project | All files with dependencies |
| Single file | Current file only |
| Selected files | Custom file selection |
| With dependencies | Include node_modules/vendor |
| Minified | Optimized production build |

#### ZIP Contents Structure

```
project-export/
├── app/
│   └── Http/
│       └── Livewire/
│           └── Components/
│               └── ContactForm.php
├── resources/
│   └── views/
│       └── livewire/
│           └── contact-form.blade.php
├── routes/
│   └── web.php
├── composer.json
├── package.json
└── README.md
```

#### Export Configuration

```yaml
export:
  zip:
    include:
      - composer.json
      - package.json
      - .env.example
    exclude:
      - vendor/
      - node_modules/
      - .git/
    format: "zip"
    compression: "deflate"
    split_files: false
    max_size: "50MB"
```

### Copy to Clipboard

| Format | Description |
|--------|-------------|
| Raw code | Plain text without formatting |
| Markdown | Formatted with syntax highlighting |
| HTML | Rendered preview with styles |
| PHP | Livewire class only |
| Blade | Template only |

#### Clipboard Formats

```yaml
clipboard:
  formats:
    - name: "Plain Text"
      format: "text/plain"
      description: "Raw code without formatting"
      
    - name: "Rich Text"
      format: "text/html"
      description: "Formatted with syntax highlighting"
      
    - name: "Markdown"
      format: "text/markdown"
      description: "Code blocks with language tags"
```

### CodeSandbox Integration

| Feature | Details |
|---------|---------|
| Direct import | One-click sandbox creation |
| Dependency resolution | Auto-install required packages |
| Laravel preset | Pre-configured Laravel environment |
| Live preview | Embedded preview window |
| Fork capability | Users can fork your sandbox |

#### CodeSandbox Export Process

1. Package project files in sandpack format
2. Generate `sandbox.config.json`
3. Create `package.json` with dependencies
4. POST to CodeSandbox API
5. Return sandbox URL and embed code

```yaml
codesandbox:
  template: "laravel"
  dependencies:
    - "livewire/livewire"
    - "alpinejs/alpinejs"
  dev_dependencies:
    - "tailwindcss"
    - "postcss"
    - "autoprefixer"
  entry: "/resources/views/livewire/component.blade.php"
```

### StackBlitz Integration

| Feature | Details |
|---------|---------|
| WebContainer | Runs in browser without server |
| Instant setup | No wait for environment |
| NPM install | Automatic dependency resolution |
| Hot reload | Live preview on changes |
| GitHub sync | Push directly to repository |

#### StackBlitz Export Configuration

```yaml
stackblitz:
  project:
    title: "gsmui Component"
    description: "Exported from gsmui playground"
    template: "node"
  files:
    - path: "package.json"
      content: "..."
    - path: "index.js"
      content: "..."
    - path: "index.html"
      content: "..."
```

### CodePen Export

| Feature | Details |
|---------|---------|
| Three-panel view | HTML, CSS, JS separation |
| Auto-run | Preview updates live |
| Embedding | iframe embed codes |
| Sharing | Public/private pens |
| Forking | Users can remix your pen |

#### CodePen Data Format

```yaml
codepen:
  html:
    content: "<div x-data=\"{ count: 0 }\">...</div>"
    language: "html"
  css:
    content: ".button { @apply bg-primary; }"
    language: "scss"
  js:
    content: "Alpine.data('counter', () => ({...}))"
    language: "javascript"
  settings:
    title: "gsmui Component"
    description: "Interactive component demo"
    tags: ["gsmui", "livewire", "alpine"]
    editors: "001"
```

## Export Formats

### Supported Languages

| Language | Extension | Export Support |
|----------|-----------|----------------|
| PHP | `.php` | Full Livewire class |
| Blade | `.blade.php` | Template with directives |
| JavaScript | `.js` | Alpine.js + utilities |
| CSS | `.css` | Tailwind + custom styles |
| HTML | `.html` | Standalone markup |
| Markdown | `.md` | Documentation |
| JSON | `.json` | Configuration files |
| YAML | `.yaml` | Configuration files |

### Export Profiles

```yaml
profiles:
  laravel_full:
    description: "Complete Laravel project"
    includes:
      - app/
      - resources/
      - routes/
      - config/
      - database/
      - composer.json
      - package.json
      
  component_only:
    description: "Just the component files"
    includes:
      - "app/Http/Livewire/*.php"
      - "resources/views/livewire/*.blade.php"
      
  standalone:
    description: "Independent HTML file"
    includes:
      - index.html (with inlined CSS/JS)
      
  documentation:
    description: "Component documentation"
    includes:
      - README.md
      - examples/
      - screenshots/
```

## Export Settings

### Default Configuration

```yaml
export_defaults:
  format: "zip"
  include_readme: true
  include_dependencies: false
  minify: false
  source_maps: true
  license: "MIT"
  
  filenames:
    readme: "README.md"
    license: "LICENSE"
    composer: "composer.json"
    package: "package.json"
```

### Custom Export Options

| Option | Values | Default |
|--------|--------|---------|
| Format | zip, tar.gz, 7z | zip |
| Encoding | utf-8, utf-16 | utf-8 |
| Line endings | lf, crlf | lf |
| Indentation | spaces, tabs | spaces |
| Indent size | 2, 4, 8 | 4 |
| Minify | true, false | false |
| Source maps | true, false | true |

## Export History

### History Management

| Feature | Description |
|---------|-------------|
| Recent exports | Last 20 exports saved |
| Re-export | One-click re-download |
| Export comparison | Diff between exports |
| Favorite exports | Pin常用 exports |
| Auto-save | Optional auto-export on change |

### History Display

```yaml
history:
  columns:
    - timestamp
    - format
    - files_count
    - file_size
    - duration
  sorting:
    default: "timestamp"
    direction: "desc"
  filtering:
    by_format: true
    by_date: true
    by_size: true
```

## Integration Points

- **Share**: Generate shareable export links
- **Templates**: Export template implementations
- **Projects**: Export entire project state
- **Collaboration**: Shared export configurations
- **AI Assistant**: AI-optimized export settings

## Performance

| Metric | Target |
|--------|--------|
| ZIP generation | < 2 seconds |
| CodeSandbox creation | < 5 seconds |
| StackBlitz creation | < 3 seconds |
| CodePen creation | < 2 seconds |
| Clipboard copy | < 100ms |
| Max export size | 50MB |
| Concurrent exports | 3 |

## Error Handling

### Common Errors

| Error | Cause | Solution |
|-------|-------|----------|
| File too large | exceeds 50MB limit | Exclude vendor/node_modules |
| Network timeout | Slow connection | Retry or use smaller export |
| Invalid format | Unsupported file type | Check file extensions |
| API limit exceeded | Too many exports | Wait and retry |
| Dependency conflict | Missing packages | Review composer.json |

### Recovery Options

- Automatic retry with exponential backoff
- Partial export if some files fail
- Fallback to alternative export method
- Offline export for supported formats

## Security

| Measure | Description |
|---------|-------------|
| File validation | Scan exported files for malware |
| Permission checks | Verify export permissions |
| Size limits | Prevent excessive exports |
| Rate limiting | Limit export frequency |
| Content sanitization | Remove sensitive data |

## Testing

| Test Type | Description |
|-----------|-------------|
| Unit tests | Export format generation |
| Integration tests | External service integration |
| Performance tests | Large file export |
| Security tests | Malicious content detection |
| Compatibility tests | Export format validation |

## Edge Cases

| Scenario | Handling |
|----------|----------|
| Corrupted files | Skip and warn |
| Missing dependencies | Partial export with notice |
| API failures | Retry with backoff |
| Large projects | Chunked export |
| Special characters | Proper encoding |
| Binary files | Base64 encoding