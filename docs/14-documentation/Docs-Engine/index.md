---
title: Documentation Engine
description: Documentation engine — markdown processing, syntax highlighting, table of contents, search indexing.
order: 14.1
group: Docs Engine
---

# Documentation Engine

The GsmUi documentation engine is a custom static-site generator built for component documentation. It processes Markdown with custom extensions, generates syntax-highlighted code blocks, builds a table of contents, and indexes content for search.

## Architecture

| Layer | Technology | Purpose |
|---|---|---|
| Content | Markdown + Blade | Source files |
| Processing | Custom parser | Markdown → HTML |
| Highlighting | Shiki / Prism | Code syntax highlighting |
| TOC | AST analysis | Auto-generated table of contents |
| Search | Lunri.js / Meilisearch | Full-text indexing |
| Output | Static HTML | Deployment-ready |

## Markdown Processing

### Processing Pipeline

```
Source .md file
    ↓
Frontmatter extraction (YAML)
    ↓
Markdown parsing (CommonMark + extensions)
    ↓
Custom fence processing (code groups, demos)
    ↓
Blade directive compilation
    ↓
Syntax highlighting
    ↓
TOC generation
    ↓
HTML output
```

### Frontmatter Schema

```yaml
---
title: Button Component
description: A versatile button component with multiple variants.
order: 2
group: Components
icon: pointer
status: stable
deprecated: false
since: 1.0.0
---
```

| Field | Type | Required | Description |
|---|---|---|---|
| `title` | string | Yes | Page title |
| `description` | string | Yes | Meta description |
| `order` | int | No | Sort order |
| `group` | string | No | Sidebar group |
| `icon` | string | No | Sidebar icon |
| `status` | string | No | `stable`, `beta`, `deprecated` |
| `since` | string | No | Version introduced |
| `deprecated` | bool | No | Deprecation flag |

## Syntax Highlighting

### Language Support

| Language | Extension | Alias |
|---|---|---|
| PHP | `.php` | `php`, `php8` |
| Blade | `.blade.php` | `blade` |
| JavaScript | `.js` | `js`, `javascript` |
| TypeScript | `.ts` | `ts`, `typescript` |
| HTML | `.html` | `html`, `blade` |
| CSS | `.css` | `css`, `scss` |
| Bash | `.sh` | `bash`, `shell` |
| JSON | `.json` | `json` |

### Highlighting Features

| Feature | Description |
|---|---|
| Line numbers | Optional line numbering |
| Highlights | Highlight specific lines |
| Diff | Show additions/removals |
| File name | Show filename header |
| Copy button | One-click copy |

### Code Block Syntax

```markdown
```php filename="app/Http/Controllers/UserController.php" highlight="5-8"
public function index()
{
    $users = User::all();
    return view('users.index', compact('users'));
}
```​
```

## Table of Contents

### TOC Generation

The TOC is auto-generated from headings:

| Heading Level | Depth | Indentation |
|---|---|---|
| `# H1` | 1 | Root |
| `## H2` | 2 | Level 1 |
| `### H3` | 3 | Level 2 |
| `#### H4` | 4 | Level 3 |

### TOC Output

```html
<nav class="toc">
  <ul>
    <li><a href="#installation">Installation</a></li>
    <li>
      <a href="#usage">Usage</a>
      <ul>
        <li><a href="#basic-usage">Basic Usage</a></li>
        <li><a href="#variants">Variants</a></li>
      </ul>
    </li>
  </ul>
</nav>
```

### TOC Configuration

| Option | Type | Default | Description |
|---|---|---|---|
| `depth` | int | `3` | Maximum heading level |
| `smooth` | bool | `true` | Smooth scroll |
| `activeClass` | string | `active` | Active item class |
| `sticky` | bool | `true` | Sticky positioning |

## Search Indexing

### Indexing Pipeline

```
Markdown content
    ↓
Text extraction (strip markup)
    ↓
Tokenization
    ↓
Stemming / lemmatization
    ↓
Index storage (JSON)
    ↓
Client-side search initialization
```

### Search Index Schema

```json
{
  "id": "button",
  "title": "Button Component",
  "description": "A versatile button component",
  "content": "Button variants primary secondary...",
  "group": "Components",
  "url": "/docs/components/button",
  "keywords": ["button", "action", "click"]
}
```

### Indexing Options

| Option | Type | Default | Description |
|---|---|---|---|
| `minLength` | int | `3` | Minimum word length |
| `stopWords` | array | Common words | Words to exclude |
| `boost` | array | — | Field boosting |

## Page Rendering

### Render Modes

| Mode | Description | Use Case |
|---|---|---|
| Static | Pre-rendered HTML | Default |
| Dynamic | Server-rendered | Live updates |
| Hybrid | Static + islands | Interactive sections |

### Page Structure

```html
<article class="docs-page">
  <header class="docs-header">
    <h1>Title</h1>
    <p class="description">Description</p>
  </header>

  <div class="docs-content">
    <!-- Markdown content -->
  </div>

  <footer class="docs-footer">
    <!-- Prev/next navigation -->
  </footer>
</article>
```

## Navigation

### Sidebar Structure

| Group | Items | Sort Order |
|---|---|---|
| Getting Started | Installation, Quick Start | By `order` |
| Components | Button, Input, Select... | By `order` |
| Livewire | Modal, Tabs, Toast... | By `order` |
| Advanced | Theming, Patterns | By `order` |

### Page Navigation

```php
$prevPage = $pages->where('order', '<', $current->order)->last();
$nextPage = $pages->where('order', '>', $current->order)->first();
```

## Configuration

```php
// config/docs.php
return [
    'engine' => [
        'source' => resource_path('docs'),
        'output' => public_path('docs'),
        'theme' => 'default',
        'syntax' => 'shiki',
        'search' => 'local', // 'local', 'meilisearch', 'algolia'
        'toc' => [
            'depth' => 3,
            'sticky' => true,
        ],
    ],
];
```

## Performance

| Metric | Target |
|---|---|
| Build time | < 5s for 100 pages |
| Search index size | < 500KB for 500 pages |
| Search latency | < 50ms |
| Page load | < 1s (LCP) |
