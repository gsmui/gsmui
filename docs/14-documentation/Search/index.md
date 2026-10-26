---
title: Search
description: Full-text search, faceted filtering, search suggestions, and keyboard navigation.
order: 14.3
group: Search
---

# Search

GsmUi documentation search provides fast, accurate full-text search with faceted filtering and keyboard navigation.

## Search Architecture

| Component | Technology | Purpose |
|---|---|---|
| Index | JSON / Meilisearch | Search data store |
| Client | Lunri.js | Client-side search |
| Server | Meilisearch (optional) | Server-side search |
| UI | Alpine.js + Livewire | Search interface |

## Full-Text Search

### Search Features

| Feature | Description |
|---|---|
| Fuzzy matching | Tolerates typos |
| Stemming | Matches word roots |
| Ranking | Relevance-based ordering |
| Highlighting | Shows matching terms |
| Snippets | Context around matches |

### Search Index

```json
{
  "id": "button-component",
  "title": "Button",
  "content": "A versatile button component...",
  "description": "Button props, events, slots",
  "group": "Components",
  "url": "/docs/components/button",
  "keywords": ["button", "action", "click", "submit"]
}
```

### Indexing Process

| Step | Action |
|---|---|
| 1 | Parse Markdown frontmatter |
| 2 | Extract text content |
| 3 | Tokenize words |
| 4 | Apply stemming |
| 5 | Build inverted index |
| 6 | Store with metadata |

## Faceted Filtering

### Available Facets

| Facet | Values | Description |
|---|---|---|
| `group` | Components, Livewire, etc. | Category filter |
| `status` | stable, beta, deprecated | Stability filter |
| `type` | prop, event, slot, method | Content type |
| `since` | 1.0, 2.0, etc. | Version filter |

### Facet UI

```
┌─────────────────────────────────────────┐
│ Search: [________________] 🔍          │
├─────────────────────────────────────────┤
│ Filter by:                              │
│ ☑ Components (12)                       │
│ ☐ Livewire (9)                          │
│ ☐ Layouts (8)                           │
│ ☐ Navigation (7)                        │
├─────────────────────────────────────────┤
│ Status:                                 │
│ ☑ Stable (25)                           │
│ ☐ Beta (5)                              │
│ ☐ Deprecated (3)                        │
└─────────────────────────────────────────┘
```

### Facet Count Display

| Format | Example |
|---|---|
| Pill | `Components (12)` |
| Badge | `12` |
| Inline | `Components · 12` |

## Search Suggestions

### Suggestion Types

| Type | Trigger | Display |
|---|---|---|
| Autocomplete | Typing | Dropdown below input |
| Related | Post-search | "Related searches" |
| Spelling | Misspelling | "Did you mean..." |
| Recent | Below input | Recent searches |

### Suggestion Algorithm

```php
function getSuggestions(string $query): array
{
    return [
        'exact_matches' => $this->exactSearch($query),
        'prefix_matches' => $this->prefixSearch($query),
        'fuzzy_matches' => $this->fuzzySearch($query, 2),
        'related' => $this->getRelated($query),
    ];
}
```

### Suggestion Limit

| Source | Max Results |
|---|---|
| Exact matches | 5 |
| Prefix matches | 3 |
| Fuzzy matches | 2 |
| Recent searches | 3 |

## Keyboard Navigation

### Keyboard Shortcuts

| Key | Action |
|---|---|
| `Ctrl+K` / `Cmd+K` | Open search |
| `Escape` | Close search |
| `↑` / `↓` | Navigate results |
| `Enter` | Open selected result |
| `Tab` | Move to filters |
| `Home` | First result |
| `End` | Last result |

### Keyboard Handler

```javascript
document.addEventListener('keydown', (e) => {
    if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
        e.preventDefault();
        openSearch();
    }

    if (e.key === 'Escape') {
        closeSearch();
    }
});
```

## Search UI

### Search Dialog

```blade
<gsmui:search-dialog wire:model="showSearch">
    <x-slot:input>
        <gsmui:input
            wire:model.debounce.300ms="query"
            placeholder="Search documentation..."
            icon="search"
        />
    </x-slot:input>

    <x-slot:results>
        @foreach ($results as $result)
            <a href="{{ $result['url'] }}" class="search-result">
                <span class="search-result-group">{{ $result['group'] }}</span>
                <h4 class="search-result-title">{{ $result['title'] }}</h4>
                <p class="search-result-snippet">{{ $result['snippet'] }}</p>
            </a>
        @endforeach
    </x-slot:results>
</gsmui:search-dialog>
```

### Search Result Format

```
┌──────────────────────────────────────┐
│ 🔍 [Search documentation...        ]│
├──────────────────────────────────────┤
│ Components                          │
│ ┌──────────────────────────────────┐│
│ │ Button                          ││
│ │ A versatile button component... ││
│ └──────────────────────────────────┘│
│ ┌──────────────────────────────────┐│
│ │ Input                           ││
│ │ Text input with addons...       ││
│ └──────────────────────────────────┘│
│                                      │
│ Press Enter to select               │
│ ↑↓ to navigate  Esc to close       │
└──────────────────────────────────────┘
```

## Search Configuration

```php
// config/docs.php
return [
    'search' => [
        'enabled' => true,
        'provider' => 'local', // 'local', 'meilisearch', 'algolia'
        'min_length' => 2,
        'max_results' => 20,
        'debounce' => 300,
        'highlight' => true,
        'snippets' => true,
        'facets' => ['group', 'status', 'type'],
    ],
];
```

## Performance

| Metric | Target |
|---|---|
| Search latency | < 50ms |
| Index size (500 pages) | < 500KB |
| Initial load | < 100ms |
| Keyboard responsiveness | < 16ms |
