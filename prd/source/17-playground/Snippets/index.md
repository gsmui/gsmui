---
title: "Code Snippets"
description: "Comprehensive snippet library for reusable code patterns"
volume: "17"
---

# Code Snippets

A comprehensive snippet library for storing, organizing, and sharing frequently used code patterns and components.

## Overview

Code Snippets provide a personal library of reusable code fragments that can be quickly inserted into projects. They support categorization, search, and sharing for team productivity.

## Snippet Library

### Library Structure

```yaml
library:
  root: "snippets/"
  structure:
    - categories/
      - forms/
      - components/
      - layouts/
      - utilities/
    - favorites/
    - recent/
    - shared/
```

### Default Categories

| Category | Description | Examples |
|----------|-------------|----------|
| Forms | Input components | Contact, login, search |
| Components | UI elements | Button, card, modal |
| Layouts | Page structures | Dashboard, sidebar |
| Utilities | Helper functions | Validation, formatting |
| Animations | Motion effects | Fade, slide, scale |
| API | API patterns | CRUD, authentication |

## Create & Save Snippets

### Snippet Properties

| Property | Description |
|----------|-------------|
| Title | Descriptive name |
| Description | Usage explanation |
| Language | PHP, Blade, JS, CSS, HTML |
| Category | Classification |
| Tags | Searchable keywords |
| Code | The actual code |
| Preview | Visual preview |
| Author | Creator username |
| Created | Creation timestamp |
| Updated | Last modification |
| Version | Semantic version |
| Forked from | Original snippet ID |

### Snippet Creation

```yaml
snippet_creation:
  required_fields:
    - title
    - language
    - code
    
  optional_fields:
    - description
    - category
    - tags
    - preview_image
    
  validation:
    title:
      min_length: 3
      max_length: 100
      
    description:
      max_length: 500
      
    code:
      max_length: 10000
      
    tags:
      max_count: 10
      max_length: 30
```

### Code Editor Integration

- **Inline creation**: Select code → Save as snippet
- **Drag & drop**: Drag code blocks to snippet panel
- **Paste detection**: Auto-detect code from clipboard
- **Import**: Import from GitHub Gist, Pastebin

## Snippet Categories

### Category Hierarchy

```
Snippets/
├── Components/
│   ├── Buttons/
│   ├── Cards/
│   ├── Modals/
│   └── Forms/
├── Layouts/
│   ├── Headers/
│   ├── Sidebars/
│   └── Footers/
├── Utilities/
│   ├── Helpers/
│   ├── Mixins/
│   └── Transformers/
└── Templates/
    ├── Starter/
    ├── Advanced/
    └── Examples/
```

### Custom Categories

```yaml
custom_categories:
  - name: "My Components"
    icon: "component"
    color: "blue"
    subcategories:
      - name: "Form Elements"
      - name: "Display Components"
      
  - name: "Project Specific"
    icon: "folder"
    color: "green"
    subcategories:
      - name: "CRM"
      - name: "E-commerce"
```

### Category Management

| Action | Description |
|--------|-------------|
| Create | Add new category |
| Rename | Change category name |
| Merge | Combine categories |
| Delete | Remove category |
| Reorder | Change display order |
| Export | Export category contents |

## Search & Filter

### Search Capabilities

| Feature | Description |
|---------|-------------|
| Full-text search | Search code content |
| Tag search | Filter by tags |
| Language filter | Show specific languages |
| Category filter | Browse by category |
| Author filter | Snippets by specific user |
| Date range | Filter by creation date |

### Search Syntax

```yaml
search_syntax:
  basic: "contact form"
  language: "lang:php"
  tag: "tag:validation"
  category: "cat:forms"
  author: "author:john"
  date: "created:>2024-01-01"
  combined: "lang:blade tag:modal created:>2024-01-01"
```

### Search Results

| Result Field | Description |
|--------------|-------------|
| Title | Snippet name |
| Preview | Code preview (first 5 lines) |
| Language | Code language |
| Category | Classification |
| Tags | Associated tags |
| Author | Creator |
| Stars | Popularity score |
| Copies | Usage count |

## Snippet Features

### Code Highlighting

| Language | Support |
|----------|---------|
| PHP | Full syntax highlighting |
| Blade | Blade-specific tokens |
| JavaScript | ES2024 syntax |
| HTML | Tag attribute highlighting |
| CSS | Property/value highlighting |
| JSON | Schema validation |
| YAML | Configuration highlighting |

### Live Preview

```yaml
preview:
  modes:
    - rendered    # Visual output
    - code        # Syntax highlighted
    - diff        # Changes from original
    
  options:
    auto_refresh: true
    show_line_numbers: true
    word_wrap: false
    font_size: 14
```

### Version History

| Feature | Description |
|---------|-------------|
| Auto-versioning | Save on every edit |
| Manual versions | Named snapshots |
| Diff comparison | Compare versions |
| Restore | Rollback to any version |
| Branching | Create variations |

### Collaboration Features

| Feature | Description |
|---------|-------------|
| Shared snippets | Team snippet library |
| Permissions | View, edit, fork rights |
| Comments | Discuss snippets |
| Approvals | Review before publishing |
| History | Track all changes |

## Sharing Options

### Visibility Levels

| Level | Description |
|-------|-------------|
| Private | Only you can see |
| Unlisted | Anyone with link |
| Public | Listed in library |
| Team | Organization members |

### Sharing Methods

```yaml
sharing:
  methods:
    - direct_link:
        format: "https://gsmui.dev/snippets/{id}"
        
    - embed_code:
        format: "<iframe src=\"...\">"
        
    - export:
        formats: ["json", "markdown", "raw"]
        
    - api:
        endpoint: "GET /api/snippets/{id}"
```

## Import & Export

### Import Sources

| Source | Format |
|--------|--------|
| GitHub Gist | JSON, raw |
| Pastebin | Raw, HTML |
| CodePen | JSON |
| Local files | JSON, markdown |
| Clipboard | Any format |

### Export Formats

| Format | Description |
|--------|-------------|
| JSON | Structured data with metadata |
| Markdown | Code blocks with docs |
| Raw | Plain code only |
| Zip | Multiple snippets |

### Export Configuration

```yaml
export:
  options:
    include_metadata: true
    include_previews: true
    format: "json"
    compression: "gzip"
    
  batch:
    max_snippets: 100
    include_categories: true
```

## Snippet Analytics

### Usage Metrics

| Metric | Description |
|--------|-------------|
| Copies | Times snippet copied |
| Forks | Times snippet forked |
| Views | Times snippet viewed |
| Stars | User favorites |
| Shares | External shares |

### Analytics Dashboard

```yaml
analytics:
  charts:
    - usage_over_time
    - popular_snippets
    - language_distribution
    - category_breakdown
    
  insights:
    - most_copied
    - most_starred
    - trending
    - recommended_for_you
```

## API Reference

### List Snippets

```http
GET /api/snippets?category=forms&language=php&limit=20
```

### Get Snippet

```http
GET /api/snippets/{id}
```

### Create Snippet

```http
POST /api/snippets
Content-Type: application/json

{
  "title": "Contact Form",
  "language": "php",
  "code": "...",
  "category": "forms",
  "tags": ["contact", "form", "validation"]
}
```

### Update Snippet

```http
PUT /api/snippets/{id}
Content-Type: application/json

{
  "title": "Updated Contact Form",
  "code": "..."
}
```

### Delete Snippet

```http
DELETE /api/snippets/{id}
```

## Keyboard Shortcuts

| Action | Windows | macOS |
|--------|---------|-------|
| Save as snippet | `Ctrl+Shift+S` | `Cmd+Shift+S` |
| Search snippets | `Ctrl+Shift+F` | `Cmd+Shift+F` |
| Insert snippet | `Ctrl+Shift+I` | `Cmd+Shift+I` |
| Copy snippet | `Ctrl+C` | `Cmd+C` |
| Edit snippet | `Ctrl+E` | `Cmd+E` |

## Integration Points

- **Code Editor**: Insert snippets directly
- **Templates**: Snippets within templates
- **AI Assistant**: AI-enhanced snippets
- **Projects**: Project-specific snippets
- **Share**: Share snippet collections

## Performance

| Metric | Target |
|--------|--------|
| Search response | < 100ms |
| Snippet load | < 50ms |
| Preview render | < 200ms |
| Save operation | < 300ms |
| Max snippet size | 50KB |
| Max snippets | 10,000 per user |

## Storage

| Limit | Value |
|-------|-------|
| Free tier | 100 snippets |
| Pro tier | 10,000 snippets |
| Team tier | Unlimited |
| Max size per snippet | 50KB |
| Max tags per snippet | 10 |
| Max categories | 100 |

## Security

| Measure | Description |
|---------|-------------|
| Code validation | Scan snippets for vulnerabilities |
| Access control | Role-based snippet access |
| Encryption | Encrypt stored snippets |
| Audit logging | Track snippet access |
| Rate limiting | Prevent snippet spam |

## Testing

| Test Type | Description |
|-----------|-------------|
| Unit tests | Snippet CRUD operations |
| Integration tests | Snippet sharing |
| Performance tests | Large snippet libraries |
| Security tests | Malicious code detection |
| UI tests | Snippet interface |

## Edge Cases

| Scenario | Handling |
|----------|----------|
| Duplicate snippets | Deduplication |
| Large code blocks | Chunked storage |
| Special characters | Proper escaping |
| Concurrent edits | Conflict resolution |
| Import failures | Error recovery |
| Storage limits | Graceful degradation