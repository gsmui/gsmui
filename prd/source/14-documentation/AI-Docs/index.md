---
title: AI-Powered Documentation
description: Semantic search, contextual suggestions, auto-generated examples, and chat interface.
order: 14.7
group: AI Docs
---

# AI-Powered Documentation

GsmUi integrates AI capabilities into the documentation platform for enhanced discoverability and user experience.

## AI Features

| Feature | Description |
|---|---|
| Semantic Search | AI-powered search understanding |
| Contextual Suggestions | Smart "related content" |
| Auto-Generated Examples | AI code generation |
| Chat Interface | Ask questions directly |
| Content Summarization | Auto-generated summaries |

## Semantic Search

### How It Works

```
User query
    ↓
Embed query (OpenAI / local model)
    ↓
Find similar document embeddings
    ↓
Rank by relevance
    ↓
Return results with context
```

### Semantic Search API

```php
// Search with AI
$results = GsmuiDocs::aiSearch('How do I make a button that loads?');

// Returns
[
    'query' => 'How do I make a button that loads?',
    'intent' => 'loading_state',
    'results' => [
        [
            'title' => 'Button Component',
            'section' => 'Loading State',
            'relevance' => 0.95,
            'snippet' => 'Use the `loading` prop to show a spinner...',
            'context' => 'The button `loading` prop displays...',
        ],
    ],
    'suggestions' => [
        'Try: Button loading state',
        'Try: Spinner in button',
    ],
];
```

### Search Intents

| Intent | Detection | Response |
|---|---|---|
| `how_to` | "How do I..." | Step-by-step guide |
| `component_lookup` | Component name | Component page |
| `prop_lookup` | "prop name" | Prop reference |
| `error_help` | Error message | Troubleshooting |
| `comparison` | "vs" / "or" | Comparison table |

## Contextual Suggestions

### Related Content

```blade
<x-gsmui:ai-suggestions
    :page="$currentPage"
    :context="$userContext"
/>
```

### Suggestion Sources

| Source | Weight | Description |
|---|---|---|
| Same component | 1.0 | Directly related |
| Same category | 0.8 | Same group |
| Shared props | 0.7 | Common usage |
| User history | 0.6 | Browsing pattern |
| Popular pages | 0.5 | Community usage |

### Suggestion Display

```
┌──────────────────────────────────┐
│ 📚 Related Documentation         │
├──────────────────────────────────┤
│ • Button Loading State          │
│ • Button Variants               │
│ • Spinner Component             │
│ • Disabled State Pattern        │
└──────────────────────────────────┘
```

## Auto-Generated Examples

### Example Generation

```php
// Generate example from description
$example = GsmuiDocs::aiExample(
    'Create a login form with email and password fields',
    'blade'
);

// Returns
'<form wire:submit="login">
    <gsmui:input wire:model="email" type="email" label="Email" />
    <gsmui:input wire:model="password" type="password" label="Password" />
    <gsmui:button type="submit">Sign in</gsmui:button>
</form>'
```

### Generation Options

| Option | Type | Description |
|---|---|---|
| `language` | string | Output language |
| `framework` | string | Laravel, Livewire, etc. |
| `style` | string | `minimal`, `complete`, `detailed` |
| `include_comments` | bool | Add code comments |

### Example Quality

| Quality | Description |
|---|---|
| Syntax valid | Correct Blade/Livewire syntax |
| Component match | Uses correct components |
| Props valid | Valid prop combinations |
| Accessible | Includes ARIA attributes |

## Chat Interface

### Chat Widget

```blade
<x-gsmui:docs-chat
    :context="$currentPage"
    placeholder="Ask about GsmUi..."
/>
```

### Chat Features

| Feature | Description |
|---|---|
| Context-aware | Knows current page |
| Code generation | Generates component code |
| Explanation | Explains concepts |
| Troubleshooting | Helps with errors |
| Follow-up | Maintains conversation |

### Chat Example

```
User: How do I make a button that shows a loading spinner?

AI: To add a loading state to a button, use the `loading` prop:

<gsmui:button loading>
    Saving...
</gsmui:button>

The button will show a spinner and be disabled while loading.

You can also bind it to a Livewire property:

<gsmui:button wire:click="save" :loading="$isSaving">
    Save Changes
</gsmui:button>
```

### Chat Configuration

```php
// config/docs.php
return [
    'ai' => [
        'enabled' => true,
        'provider' => 'openai', // 'openai', 'local'
        'model' => 'gpt-4',
        'max_tokens' => 1000,
        'temperature' => 0.3,
        'context_window' => 5,
    ],
];
```

## Content Summarization

### Auto-Summary Generation

```php
$summary = GsmuiDocs::summarize($pageContent);

// Returns
[
    'short' => 'Button component with variants, sizes, and states.',
    'medium' => 'The button component provides multiple variants, sizes, and interactive states including loading and disabled.',
    'detailed' => 'The button component is a fundamental UI element...',
];
```

### Summary Display

| Length | Characters | Use Case |
|---|---|---|
| Short | 50-100 | Search results |
| Medium | 150-200 | Card descriptions |
| Detailed | 300-500 | Meta descriptions |

## AI API

```php
// Semantic search
$results = GsmuiDocs::ai()->search($query);

// Generate example
$code = GsmuiDocs::ai()->example($description);

// Summarize content
$summary = GsmuiDocs::ai()->summarize($content);

// Chat completion
$response = GsmuiDocs::ai()->chat($messages, $context);
```

## Privacy & Security

| Concern | Implementation |
|---|---|
| Data storage | No user data stored |
| API keys | Encrypted at rest |
| Rate limiting | Per-user limits |
| Content filtering | No harmful content |
