# 20 - MCP (Model Context Protocol)

**Project:** GsmUi
**Version:** 1.0.0

---

# Purpose

The MCP Server exposes GsmUi capabilities to AI assistants through a standardized protocol, enabling AI-powered code generation, documentation lookup, and component discovery.

---

# Vision

Make GsmUi the most AI-friendly Laravel UI framework by providing rich, structured data that enables AI assistants to generate accurate, production-ready code.

---

# Core Features

## AI Integration

* Component search and discovery
* Documentation lookup
* Code generation
* Theme assistance
* Template recommendations
* Best practices guidance

## Protocol Support

* JSON-RPC over HTTP
* WebSocket/SSE transports
* OAuth 2.0 authentication
* Rate limiting
* Error handling

## Tools & Resources

* Component catalog
* Documentation index
* Code examples
* Theme tokens
* Template library
* API reference

---

# MCP Architecture

```text
AI Assistant (Claude, GPT, etc.)
    ↓
MCP Client
    ↓
HTTP/WebSocket Transport
    ↓
GsmUi MCP Server
    ├── Authentication
    ├── Rate Limiting
    ├── Tool Router
    ├── Resource Manager
    └── Response Builder
    ↓
GsmUi Services
    ├── Component Service
    ├── Documentation Service
    ├── Theme Service
    ├── Template Service
    └── Search Service
    ↓
Database / Cache / Search
```

---

# MCP Tools

## Component Tools

### search_components

Search for GsmUi components by name, category, or functionality.

```json
{
  "name": "search_components",
  "arguments": {
    "query": "button",
    "category": "actions",
    "limit": 10
  }
}
```

### get_component_details

Get detailed information about a specific component.

```json
{
  "name": "get_component_details",
  "arguments": {
    "component": "button"
  }
}
```

### generate_component_code

Generate Blade/Livewire code for a component.

```json
{
  "name": "generate_component_code",
  "arguments": {
    "component": "button",
    "variant": "primary",
    "size": "md",
    "content": "Click me"
  }
}
```

## Documentation Tools

### search_docs

Search documentation for guides and tutorials.

```json
{
  "name": "search_docs",
  "arguments": {
    "query": "installation",
    "type": "guide"
  }
}
```

### get_doc_page

Retrieve a specific documentation page.

```json
{
  "name": "get_doc_page",
  "arguments": {
    "path": "getting-started/installation"
  }
}
```

## Theme Tools

### get_theme_tokens

Get current theme design tokens.

```json
{
  "name": "get_theme_tokens",
  "arguments": {
    "theme": "default",
    "category": "colors"
  }
}
```

### generate_theme_css

Generate CSS variables for a theme.

```json
{
  "name": "generate_theme_css",
  "arguments": {
    "primary": "#3b82f6",
    "radius": "0.5rem"
  }
}
```

## Template Tools

### search_templates

Search for application templates.

```json
{
  "name": "search_templates",
  "arguments": {
    "query": "saas",
    "features": ["billing", "dashboard"]
  }
}
```

### get_template_details

Get template information and installation instructions.

```json
{
  "name": "get_template_details",
  "arguments": {
    "template": "saas-starter"
  }
}
```

---

# MCP Resources

## Component Catalog

```json
{
  "uri": "gsmui://components",
  "name": "GsmUi Component Catalog",
  "description": "Complete list of available components",
  "mimeType": "application/json"
}
```

## Documentation Index

```json
{
  "uri": "gsmui://docs",
  "name": "GsmUi Documentation",
  "description": "Searchable documentation index",
  "mimeType": "application/json"
}
```

## Theme Tokens

```json
{
  "uri": "gsmui://themes/default",
  "name": "Default Theme Tokens",
  "description": "Default theme design tokens",
  "mimeType": "application/json"
}
```

---

# Authentication

## OAuth 2.0 Flow

```text
AI Assistant
    ↓
Authorization Request
    ↓
User Authentication
    ↓
Scope Approval
    ↓
Access Token
    ↓
API Access
```

## Scopes

| Scope | Description |
|-------|-------------|
| `components:read` | Access component catalog |
| `docs:read` | Access documentation |
| `themes:read` | Access theme tokens |
| `templates:read` | Access template catalog |
| `code:generate` | Generate code |

---

# Rate Limiting

| Tier | Requests/Minute | Requests/Hour |
|------|-----------------|---------------|
| Free | 10 | 100 |
| Pro | 60 | 1,000 |
| Enterprise | 600 | 10,000 |

---

# Error Handling

## Error Response Format

```json
{
  "jsonrpc": "2.0",
  "error": {
    "code": -32600,
    "message": "Invalid Request",
    "data": {
      "tool": "search_components",
      "reason": "Missing required argument: query"
    }
  }
}
```

## Error Codes

| Code | Description |
|------|-------------|
| -32700 | Parse error |
| -32600 | Invalid request |
| -32601 | Method not found |
| -32602 | Invalid params |
| -32603 | Internal error |
| -32000 | Rate limit exceeded |
| -32001 | Authentication required |
| -32002 | Insufficient permissions |

---

# Code Generation Examples

## AI Prompt

> "Create a login form with email and password fields using GsmUi components"

## AI Response (using MCP)

```json
{
  "tool": "generate_component_code",
  "result": {
    "blade": "<form method=\"POST\" action=\"{{ route('login') }}\">\n    @csrf\n    <x-gsm-input\n        type=\"email\"\n        name=\"email\"\n        label=\"Email\"\n        wire:model=\"email\"\n        required\n    />\n    <x-gsm-input\n        type=\"password\"\n        name=\"password\"\n        label=\"Password\"\n        wire:model=\"password\"\n        required\n    />\n    <x-gsm-button type=\"submit\" variant=\"primary\">\n        Sign In\n    </x-gsm-button>\n</form>",
    "livewire": "<?php\n\nnamespace App\\Livewire;\n\nuse Livewire\\Component;\n\nclass Login extends Component\n{\n    public $email = '';\n    public $password = '';\n\n    public function login()\n    {\n        // Authentication logic\n    }\n\n    public function render()\n    {\n        return view('livewire.login');\n    }\n}",
    "imports": [
      "gsmui:input",
      "gsmui:button"
    ]
  }
}
```

---

# Technical Architecture

```text
MCP Server
├── HTTP Server (Laravel Route)
├── WebSocket Server (Optional)
├── Authentication Middleware
├── Rate Limiter
├── Tool Registry
│   ├── Component Tools
│   ├── Documentation Tools
│   ├── Theme Tools
│   └── Template Tools
├── Resource Registry
│   ├── Component Catalog
│   ├── Documentation Index
│   ├── Theme Tokens
│   └── Template Catalog
├── Response Builder
└── Analytics Logger

Services
├── Component Service
├── Documentation Service
├── Theme Service
├── Template Service
└── Search Service

Storage
├── Database (Metadata)
├── Cache (Responses)
└── Search (Full-text)
```

---

# Database Schema

Key tables:

* `mcp_clients` — Registered AI clients
* `mcp_tokens` — Authentication tokens
* `mcp_usage` — API usage tracking
* `mcp_rate_limits` — Rate limit tracking
* `mcp_analytics` — Usage analytics

---

# Monitoring & Analytics

Track MCP usage:

* Tool invocations
* Response times
* Error rates
* Popular queries
* AI assistant usage
* Code generation stats

---

# Security

* OAuth 2.0 authentication
* Rate limiting
* Input validation
* Output sanitization
* Request logging
* Audit trail

---

# Admin Features

* Client management
* Token management
* Usage analytics
* Rate limit configuration
* Tool management
* Resource management

---

# SDK & Integration

## Official SDKs

* PHP SDK
* JavaScript SDK
* Python SDK (future)

## Integration Examples

* Claude Desktop
* ChatGPT
* VS Code Copilot
* JetBrains AI
* Cursor

---

# Success Metrics

* 1,000+ registered AI clients
* 100,000+ tool invocations/month
* <200ms average response time
* 95%+ code accuracy
* 4.5+ developer satisfaction

---

# Detailed MCP Tools Implementation

## Component Tools Details

### search_components Implementation

```php
class SearchComponentsTool implements McpTool
{
    public function getName(): string
    {
        return 'search_components';
    }
    
    public function getDescription(): string
    {
        return 'Search for GsmUi components by name, category, or functionality';
    }
    
    public function getParameters(): array
    {
        return [
            'query' => [
                'type' => 'string',
                'description' => 'Search query',
                'required' => true,
            ],
            'category' => [
                'type' => 'string',
                'description' => 'Filter by category',
                'required' => false,
                'enum' => ['actions', 'forms', 'layout', 'navigation', 'data-display', 'feedback', 'overlays', 'media', 'charts'],
            ],
            'limit' => [
                'type' => 'integer',
                'description' => 'Maximum results to return',
                'required' => false,
                'default' => 10,
            ],
        ];
    }
    
    public function execute(array $parameters): McpResult
    {
        $query = $parameters['query'];
        $category = $parameters['category'] ?? null;
        $limit = $parameters['limit'] ?? 10;
        
        $search = new SearchQuery();
        $search->setQuery($query)
            ->setAttributesToHighlight(['name', 'description', 'tags'])
            ->setLimit($limit);
        
        if ($category) {
            $search->setFilter(['category' => $category]);
        }
        
        $results = $this->meilisearch->index('components')->search($search);
        
        return new McpResult([
            'components' => array_map(function ($hit) {
                return [
                    'name' => $hit['name'],
                    'slug' => $hit['slug'],
                    'category' => $hit['category'],
                    'description' => $hit['description'],
                    'props' => $hit['props'] ?? [],
                    'events' => $hit['events'] ?? [],
                    'slots' => $hit['slots'] ?? [],
                ];
            }, $results['hits']),
            'total' => $results['nbHits'],
        ]);
    }
}
```

### get_component_details Implementation

```php
class GetComponentDetailsTool implements McpTool
{
    public function getName(): string
    {
        return 'get_component_details';
    }
    
    public function getDescription(): string
    {
        return 'Get detailed information about a specific component';
    }
    
    public function getParameters(): array
    {
        return [
            'component' => [
                'type' => 'string',
                'description' => 'Component slug or name',
                'required' => true,
            ],
            'version' => [
                'type' => 'string',
                'description' => 'Documentation version',
                'required' => false,
            ],
        ];
    }
    
    public function execute(array $parameters): McpResult
    {
        $componentSlug = $parameters['component'];
        $version = $parameters['version'] ?? null;
        
        $component = Component::where('slug', $componentSlug)
            ->orWhere('name', $componentSlug)
            ->first();
        
        if (!$component) {
            return new McpResult(null, "Component not found: {$componentSlug}");
        }
        
        $documentation = $this->getDocumentation($component, $version);
        
        return new McpResult([
            'name' => $component->name,
            'slug' => $component->slug,
            'category' => $component->category,
            'description' => $component->description,
            'version' => $component->version,
            'props' => $documentation['props'] ?? [],
            'events' => $documentation['events'] ?? [],
            'slots' => $documentation['slots'] ?? [],
            'examples' => $documentation['examples'] ?? [],
            'accessibility' => $documentation['accessibility'] ?? [],
            'related' => $documentation['related'] ?? [],
        ]);
    }
    
    private function getDocumentation(Component $component, ?string $version): array
    {
        $query = ComponentDocumentation::where('component_id', $component->id);
        
        if ($version) {
            $query->where('version', $version);
        }
        
        $doc = $query->orderBy('created_at', 'desc')->first();
        
        return $doc?->toArray() ?? [];
    }
}
```

### generate_component_code Implementation

```php
class GenerateComponentCodeTool implements McpTool
{
    public function getName(): string
    {
        return 'generate_component_code';
    }
    
    public function getDescription(): string
    {
        return 'Generate Blade/Livewire code for a component';
    }
    
    public function getParameters(): array
    {
        return [
            'component' => [
                'type' => 'string',
                'description' => 'Component name',
                'required' => true,
            ],
            'variant' => [
                'type' => 'string',
                'description' => 'Component variant',
                'required' => false,
            ],
            'size' => [
                'type' => 'string',
                'description' => 'Component size',
                'required' => false,
            ],
            'content' => [
                'type' => 'string',
                'description' => 'Component content',
                'required' => false,
            ],
            'props' => [
                'type' => 'object',
                'description' => 'Additional props',
                'required' => false,
            ],
            'format' => [
                'type' => 'string',
                'description' => 'Output format',
                'required' => false,
                'enum' => ['blade', 'livewire', 'alpine'],
                'default' => 'blade',
            ],
        ];
    }
    
    public function execute(array $parameters): McpResult
    {
        $component = $parameters['component'];
        $variant = $parameters['variant'] ?? null;
        $size = $parameters['size'] ?? null;
        $content = $parameters['content'] ?? null;
        $props = $parameters['props'] ?? [];
        $format = $parameters['format'] ?? 'blade';
        
        $code = match ($format) {
            'blade' => $this->generateBlade($component, $variant, $size, $content, $props),
            'livewire' => $this->generateLivewire($component, $variant, $size, $content, $props),
            'alpine' => $this->generateAlpine($component, $variant, $size, $content, $props),
        };
        
        return new McpResult([
            'code' => $code,
            'format' => $format,
            'imports' => $this->getImports($component),
        ]);
    }
    
    private function generateBlade(string $component, ?string $variant, ?string $size, ?string $content, array $props): string
    {
        $tag = "x-gsm-{$component}";
        $attributes = $this->buildAttributes($variant, $size, $props);
        
        if ($content) {
            return "<{$tag}{$attributes}>\n    {$content}\n</{$tag}>";
        }
        
        return "<{$tag}{$attributes} />";
    }
    
    private function buildAttributes(?string $variant, ?string $size, array $props): string
    {
        $attributes = [];
        
        if ($variant) {
            $attributes[] = "variant=\"{$variant}\"";
        }
        
        if ($size) {
            $attributes[] = "size=\"{$size}\"";
        }
        
        foreach ($props as $key => $value) {
            if (is_bool($value)) {
                $attributes[] = $value ? ":{$key}" : '';
            } elseif (is_string($value)) {
                $attributes[] = "{$key}=\"{$value}\"";
            } elseif (is_array($value)) {
                $attributes[] = ":{$key}=\"" . addslashes(json_encode($value)) . "\"";
            }
        }
        
        return ' ' . implode(' ', array_filter($attributes));
    }
}
```

## Documentation Tools Details

### search_docs Implementation

```php
class SearchDocsTool implements McpTool
{
    public function getName(): string
    {
        return 'search_docs';
    }
    
    public function getDescription(): string
    {
        return 'Search documentation for guides and tutorials';
    }
    
    public function getParameters(): array
    {
        return [
            'query' => [
                'type' => 'string',
                'description' => 'Search query',
                'required' => true,
            ],
            'type' => [
                'type' => 'string',
                'description' => 'Filter by type',
                'required' => false,
                'enum' => ['guide', 'tutorial', 'api', 'reference', 'changelog'],
            ],
            'version' => [
                'type' => 'string',
                'description' => 'Filter by version',
                'required' => false,
            ],
            'limit' => [
                'type' => 'integer',
                'description' => 'Maximum results',
                'required' => false,
                'default' => 5,
            ],
        ];
    }
    
    public function execute(array $parameters): McpResult
    {
        $query = $parameters['query'];
        $type = $parameters['type'] ?? null;
        $version = $parameters['version'] ?? null;
        $limit = $parameters['limit'] ?? 5;
        
        $search = new SearchQuery();
        $search->setQuery($query)
            ->setAttributesToHighlight(['title', 'content'])
            ->setAttributesToCrop(['content:200'])
            ->setLimit($limit);
        
        $filters = [];
        if ($type) {
            $filters[] = "type = '{$type}'";
        }
        if ($version) {
            $filters[] = "version = '{$version}'";
        }
        
        if (!empty($filters)) {
            $search->setFilter(implode(' AND ', $filters));
        }
        
        $results = $this->meilisearch->index('documentation')->search($search);
        
        return new McpResult([
            'results' => array_map(function ($hit) {
                return [
                    'title' => $hit['title'],
                    'slug' => $hit['slug'],
                    'type' => $hit['type'],
                    'excerpt' => $hit['_formatted']['content'] ?? Str::limit($hit['content'], 200),
                    'url' => route('docs.show', $hit['slug']),
                ];
            }, $results['hits']),
            'total' => $results['nbHits'],
        ]);
    }
}
```

### get_doc_page Implementation

```php
class GetDocPageTool implements McpTool
{
    public function getName(): string
    {
        return 'get_doc_page';
    }
    
    public function getDescription(): string
    {
        return 'Retrieve a specific documentation page';
    }
    
    public function getParameters(): array
    {
        return [
            'path' => [
                'type' => 'string',
                'description' => 'Documentation page path',
                'required' => true,
            ],
            'version' => [
                'type' => 'string',
                'description' => 'Documentation version',
                'required' => false,
            ],
        ];
    }
    
    public function execute(array $parameters): McpResult
    {
        $path = $parameters['path'];
        $version = $parameters['version'] ?? null;
        
        $query = DocPage::where('slug', $path)
            ->where('status', 'published');
        
        if ($version) {
            $query->where('version', $version);
        }
        
        $page = $query->first();
        
        if (!$page) {
            return new McpResult(null, "Page not found: {$path}");
        }
        
        return new McpResult([
            'title' => $page->title,
            'slug' => $page->slug,
            'content' => $page->content,
            'html' => $page->rendered_html,
            'category' => $page->category,
            'type' => $page->type,
            'version' => $page->version,
            'last_updated' => $page->updated_at->toIso8601String(),
        ]);
    }
}
```

## Theme Tools Details

### get_theme_tokens Implementation

```php
class GetThemeTokensTool implements McpTool
{
    public function getName(): string
    {
        return 'get_theme_tokens';
    }
    
    public function getDescription(): string
    {
        return 'Get current theme design tokens';
    }
    
    public function getParameters(): array
    {
        return [
            'theme' => [
                'type' => 'string',
                'description' => 'Theme name',
                'required' => false,
                'default' => 'default',
            ],
            'category' => [
                'type' => 'string',
                'description' => 'Filter by category',
                'required' => false,
                'enum' => ['colors', 'typography', 'spacing', 'borders', 'shadows'],
            ],
        ];
    }
    
    public function execute(array $parameters): McpResult
    {
        $themeName = $parameters['theme'] ?? 'default';
        $category = $parameters['category'] ?? null;
        
        $theme = Theme::where('slug', $themeName)
            ->orWhere('name', $themeName)
            ->first();
        
        if (!$theme) {
            return new McpResult(null, "Theme not found: {$themeName}");
        }
        
        $tokens = $theme->tokens;
        
        if ($category) {
            $tokens = $tokens[$category] ?? [];
        }
        
        return new McpResult([
            'theme' => $theme->name,
            'tokens' => $tokens,
            'css' => $this->generateCss($tokens),
        ]);
    }
    
    private function generateCss(array $tokens): string
    {
        $css = ":root {\n";
        
        foreach ($tokens as $category => $values) {
            foreach ($values as $name => $value) {
                $css .= "    --gsm-{$category}-{$name}: {$value};\n";
            }
        }
        
        $css .= "}\n";
        
        return $css;
    }
}
```

### generate_theme_css Implementation

```php
class GenerateThemeCssTool implements McpTool
{
    public function getName(): string
    {
        return 'generate_theme_css';
    }
    
    public function getDescription(): string
    {
        return 'Generate CSS variables for a theme';
    }
    
    public function getParameters(): array
    {
        return [
            'primary' => [
                'type' => 'string',
                'description' => 'Primary color hex',
                'required' => false,
            ],
            'secondary' => [
                'type' => 'string',
                'description' => 'Secondary color hex',
                'required' => false,
            ],
            'radius' => [
                'type' => 'string',
                'description' => 'Border radius',
                'required' => false,
            ],
            'font' => [
                'type' => 'string',
                'description' => 'Font family',
                'required' => false,
            ],
        ];
    }
    
    public function execute(array $parameters): McpResult
    {
        $tokens = $this->buildTokens($parameters);
        $css = $this->generateCss($tokens);
        
        return new McpResult([
            'css' => $css,
            'tokens' => $tokens,
        ]);
    }
    
    private function buildTokens(array $params): array
    {
        $tokens = [];
        
        if (isset($params['primary'])) {
            $primary = $params['primary'];
            $tokens['colors']['primary'] = $this->generateColorScale($primary);
            $tokens['colors']['primary-50'] = $this->lightenColor($primary, 95);
            $tokens['colors']['primary-100'] = $this->lightenColor($primary, 90);
            $tokens['colors']['primary-500'] = $primary;
            $tokens['colors']['primary-900'] = $this->darkenColor($primary, 80);
        }
        
        if (isset($params['radius'])) {
            $tokens['borders']['radius'] = $params['radius'];
        }
        
        if (isset($params['font'])) {
            $tokens['typography']['font-family'] = $params['font'];
        }
        
        return $tokens;
    }
}
```

## Template Tools Details

### search_templates Implementation

```php
class SearchTemplatesTool implements McpTool
{
    public function getName(): string
    {
        return 'search_templates';
    }
    
    public function getDescription(): string
    {
        return 'Search for application templates';
    }
    
    public function getParameters(): array
    {
        return [
            'query' => [
                'type' => 'string',
                'description' => 'Search query',
                'required' => true,
            ],
            'category' => [
                'type' => 'string',
                'description' => 'Filter by category',
                'required' => false,
            ],
            'features' => [
                'type' => 'array',
                'description' => 'Required features',
                'required' => false,
            ],
            'price_range' => [
                'type' => 'string',
                'description' => 'Price range',
                'required' => false,
            ],
            'limit' => [
                'type' => 'integer',
                'description' => 'Maximum results',
                'required' => false,
                'default' => 10,
            ],
        ];
    }
    
    public function execute(array $parameters): McpResult
    {
        $query = $parameters['query'];
        $category = $parameters['category'] ?? null;
        $features = $parameters['features'] ?? [];
        $limit = $parameters['limit'] ?? 10;
        
        $search = new SearchQuery();
        $search->setQuery($query)
            ->setAttributesToHighlight(['name', 'description', 'features'])
            ->setLimit($limit);
        
        $filters = [];
        if ($category) {
            $filters[] = "category = '{$category}'";
        }
        if (!empty($features)) {
            foreach ($features as $feature) {
                $filters[] = "features = '{$feature}'";
            }
        }
        
        if (!empty($filters)) {
            $search->setFilter(implode(' AND ', $filters));
        }
        
        $results = $this->meilisearch->index('templates')->search($search);
        
        return new McpResult([
            'templates' => array_map(function ($hit) {
                return [
                    'name' => $hit['name'],
                    'slug' => $hit['slug'],
                    'category' => $hit['category'],
                    'description' => $hit['description'],
                    'price' => $hit['price'],
                    'rating' => $hit['rating'],
                    'features' => $hit['features'] ?? [],
                ];
            }, $results['hits']),
            'total' => $results['nbHits'],
        ]);
    }
}
```

---

# Resource Management Details

## Component Catalog Resource

```php
class ComponentCatalogResource implements McpResource
{
    public function getUri(): string
    {
        return 'gsmui://components';
    }
    
    public function getName(): string
    {
        return 'GsmUi Component Catalog';
    }
    
    public function getDescription(): string
    {
        return 'Complete list of available components';
    }
    
    public function getMimeType(): string
    {
        return 'application/json';
    }
    
    public function getContent(): string
    {
        $components = Component::all()->map(function ($component) {
            return [
                'name' => $component->name,
                'slug' => $component->slug,
                'category' => $component->category,
                'description' => $component->description,
                'props_count' => count($component->props ?? []),
                'events_count' => count($component->events ?? []),
                'slots_count' => count($component->slots ?? []),
            ];
        });
        
        return json_encode([
            'components' => $components,
            'total' => $components->count(),
            'categories' => $components->pluck('category')->unique()->values(),
        ], JSON_PRETTY_PRINT);
    }
}
```

## Documentation Index Resource

```php
class DocumentationIndexResource implements McpResource
{
    public function getUri(): string
    {
        return 'gsmui://docs';
    }
    
    public function getName(): string
    {
        return 'GsmUi Documentation';
    }
    
    public function getContent(): string
    {
        $pages = DocPage::where('status', 'published')
            ->select(['title', 'slug', 'category', 'type', 'version'])
            ->get();
        
        return json_encode([
            'pages' => $pages,
            'total' => $pages->count(),
            'categories' => $pages->pluck('category')->unique()->values(),
            'types' => $pages->pluck('type')->unique()->values(),
            'versions' => $pages->pluck('version')->unique()->values(),
        ], JSON_PRETTY_PRINT);
    }
}
```

---

# Authentication Details

## OAuth 2.0 Implementation

```php
class McpOAuthServer
{
    public function handleAuthorizationRequest(Request $request): Response
    {
        $validated = $request->validate([
            'client_id' => 'required|string|exists:mcp_clients,id',
            'redirect_uri' => 'required|url',
            'response_type' => 'required|in:code',
            'scope' => 'sometimes|string',
            'state' => 'sometimes|string',
        ]);
        
        // Verify client
        $client = McpClient::find($validated['client_id']);
        
        if (!$client || !$client->isValidRedirect($validated['redirect_uri'])) {
            return response()->json(['error' => 'invalid_client'], 400);
        }
        
        // Generate authorization code
        $code = Str::random(40);
        
        AuthorizationCode::create([
            'client_id' => $client->id,
            'code' => $code,
            'redirect_uri' => $validated['redirect_uri'],
            'scope' => $validated['scope'] ?? '',
            'expires_at' => now()->addMinutes(10),
        ]);
        
        // Redirect with code
        $redirectUrl = $validated['redirect_uri'] . '?' . http_build_query([
            'code' => $code,
            'state' => $validated['state'] ?? '',
        ]);
        
        return redirect($redirectUrl);
    }
    
    public function handleTokenRequest(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'grant_type' => 'required|in:authorization_code',
            'code' => 'required|string',
            'redirect_uri' => 'required|url',
            'client_id' => 'required|string',
            'client_secret' => 'required|string',
        ]);
        
        // Verify authorization code
        $authCode = AuthorizationCode::where('code', $validated['code'])
            ->where('expires_at', '>', now())
            ->first();
        
        if (!$authCode) {
            return response()->json(['error' => 'invalid_grant'], 400);
        }
        
        // Verify client
        $client = McpClient::find($validated['client_id']);
        
        if (!$client || !Hash::check($validated['client_secret'], $client->secret)) {
            return response()->json(['error' => 'invalid_client'], 400);
        }
        
        // Generate access token
        $accessToken = Str::random(60);
        $refreshToken = Str::random(60);
        
        AccessToken::create([
            'client_id' => $client->id,
            'access_token' => Hash::make($accessToken),
            'refresh_token' => Hash::make($refreshToken),
            'scope' => $authCode->scope,
            'expires_at' => now()->addHours(1),
        ]);
        
        // Delete used authorization code
        $authCode->delete();
        
        return response()->json([
            'access_token' => $accessToken,
            'refresh_token' => $refreshToken,
            'token_type' => 'Bearer',
            'expires_in' => 3600,
            'scope' => $authCode->scope,
        ]);
    }
}
```

---

# Rate Limiting Details

## Rate Limiter Implementation

```php
class McpRateLimiter
{
    private const TIERS = [
        'free' => [
            'requests_per_minute' => 10,
            'requests_per_hour' => 100,
            'requests_per_day' => 1000,
        ],
        'pro' => [
            'requests_per_minute' => 60,
            'requests_per_hour' => 1000,
            'requests_per_day' => 10000,
        ],
        'enterprise' => [
            'requests_per_minute' => 600,
            'requests_per_hour' => 10000,
            'requests_per_day' => 100000,
        ],
    ];
    
    public function check(McpClient $client): RateLimitResult
    {
        $tier = $client->tier ?? 'free';
        $limits = self::TIERS[$tier];
        
        $minuteKey = "mcp_rate:{$client->id}:minute:" . date('Y-m-d-H-i');
        $hourKey = "mcp_rate:{$client->id}:hour:" . date('Y-m-d-H');
        $dayKey = "mcp_rate:{$client->id}:day:" . date('Y-m-d');
        
        $minuteCount = Cache::get($minuteKey, 0);
        $hourCount = Cache::get($hourKey, 0);
        $dayCount = Cache::get($dayKey, 0);
        
        if ($minuteCount >= $limits['requests_per_minute']) {
            return new RateLimitResult(false, 'minute', $limits['requests_per_minute'] - $minuteCount);
        }
        
        if ($hourCount >= $limits['requests_per_hour']) {
            return new RateLimitResult(false, 'hour', $limits['requests_per_hour'] - $hourCount);
        }
        
        if ($dayCount >= $limits['requests_per_day']) {
            return new RateLimitResult(false, 'day', $limits['requests_per_day'] - $dayCount);
        }
        
        // Increment counters
        Cache::put($minuteKey, $minuteCount + 1, now()->addMinute());
        Cache::put($hourKey, $hourCount + 1, now()->addHour());
        Cache::put($dayKey, $dayCount + 1, now()->addDay());
        
        return new RateLimitResult(true, null, 0, [
            'X-RateLimit-Limit-Minute' => $limits['requests_per_minute'],
            'X-RateLimit-Remaining-Minute' => $limits['requests_per_minute'] - $minuteCount - 1,
            'X-RateLimit-Limit-Hour' => $limits['requests_per_hour'],
            'X-RateLimit-Remaining-Hour' => $limits['requests_per_hour'] - $hourCount - 1,
        ]);
    }
}
```

---

# Code Generation Examples Details

## Complex Code Generation

```php
class CodeGenerationService
{
    public function generateFromPrompt(string $prompt): array
    {
        // Analyze prompt to determine components needed
        $analysis = $this->analyzePrompt($prompt);
        
        $components = [];
        $livewire = null;
        
        foreach ($analysis['components'] as $componentRequest) {
            $components[] = $this->generateComponent($componentRequest);
        }
        
        if ($analysis['requires_livewire']) {
            $livewire = $this->generateLivewireComponent($analysis);
        }
        
        $blade = $this->assembleBlade($components, $analysis);
        
        return [
            'blade' => $blade,
            'livewire' => $livewire,
            'components' => $components,
            'imports' => $this->getImports($components),
        ];
    }
    
    private function analyzePrompt(string $prompt): array
    {
        $analysis = [
            'components' => [],
            'requires_livewire' => false,
            'form_fields' => [],
            'actions' => [],
        ];
        
        // Detect form components
        if (str_contains($prompt, 'form')) {
            $analysis['requires_livewire'] = true;
            $analysis['components'][] = 'form';
            
            if (str_contains($prompt, 'email')) {
                $analysis['form_fields'][] = 'email';
            }
            if (str_contains($prompt, 'password')) {
                $analysis['form_fields'][] = 'password';
            }
            if (str_contains($prompt, 'name')) {
                $analysis['form_fields'][] = 'text';
            }
        }
        
        // Detect button components
        if (str_contains($prompt, 'button') || str_contains($prompt, 'submit')) {
            $analysis['components'][] = 'button';
            $analysis['actions'][] = 'submit';
        }
        
        // Detect card components
        if (str_contains($prompt, 'card') || str_contains($prompt, 'container')) {
            $analysis['components'][] = 'card';
        }
        
        return $analysis;
    }
    
    private function assembleBlade(array $components, array $analysis): string
    {
        $blade = '';
        
        if ($analysis['requires_livewire']) {
            $blade .= "<form wire:submit=\"submit\">\n";
        }
        
        foreach ($components as $component) {
            $blade .= $component['code'] . "\n";
        }
        
        if ($analysis['requires_livewire']) {
            $blade .= "</form>";
        }
        
        return $blade;
    }
}
```

---

# SDK & Integration Details

## PHP SDK

```php
class GsmuiMcpClient
{
    private string $baseUrl;
    private string $accessToken;
    private HttpClient $http;
    
    public function __construct(string $baseUrl, string $accessToken)
    {
        $this->baseUrl = $baseUrl;
        $this->accessToken = $accessToken;
        $this->http = new HttpClient();
    }
    
    public function searchComponents(string $query, array $options = []): array
    {
        return $this->call('search_components', [
            'query' => $query,
            ...$options,
        ]);
    }
    
    public function getComponent(string $component): array
    {
        return $this->call('get_component_details', [
            'component' => $component,
        ]);
    }
    
    public function generateCode(string $component, array $options = []): array
    {
        return $this->call('generate_component_code', [
            'component' => $component,
            ...$options,
        ]);
    }
    
    public function searchDocs(string $query, array $options = []): array
    {
        return $this->call('search_docs', [
            'query' => $query,
            ...$options,
        ]);
    }
    
    private function call(string $method, array $params): array
    {
        $response = $this->http->post("{$this->baseUrl}/mcp", [
            'jsonrpc' => '2.0',
            'method' => $method,
            'params' => $params,
            'id' => uniqid(),
        ], [
            'headers' => [
                'Authorization' => "Bearer {$this->accessToken}",
                'Content-Type' => 'application/json',
            ],
        ]);
        
        $result = json_decode($response->body(), true);
        
        if (isset($result['error'])) {
            throw new McpException($result['error']['message'], $result['error']['code']);
        }
        
        return $result['result'];
    }
}
```

---

# Success Metrics Details

## Key Performance Indicators

| Metric | Current | Target | Measurement |
|--------|---------|--------|-------------|
| Registered AI Clients | 500 | 1,000+ | Database count |
| Tool Invocations | 50,000/month | 100,000+ | API logs |
| Average Response Time | 250ms | <200ms | API monitoring |
| Code Accuracy | 90% | 95%+ | User feedback |
| Developer Satisfaction | 4.2/5 | 4.5/5 | Survey score |
| API Uptime | 99% | 99.9% | Monitoring |

## Performance Metrics

| Metric | Current | Target | Measurement |
|--------|---------|--------|-------------|
| Search Response | 150ms | <100ms | Query time |
| Code Generation | 300ms | <200ms | Generation time |
| Token Refresh | 100ms | <50ms | Refresh time |
| Cache Hit Rate | 80% | 90%+ | Cache stats |

---

# Monitoring & Analytics Details

## Tool Invocation Tracking

```php
class McpAnalytics
{
    public function trackInvocation(McpClient $client, string $tool, array $params, array $result, float $duration): void
    {
        DB::table('mcp_invocations')->insert([
            'client_id' => $client->id,
            'tool' => $tool,
            'params' => json_encode($params),
            'result_size' => strlen(json_encode($result)),
            'duration_ms' => $duration,
            'success' => !isset($result['error']),
            'created_at' => now(),
        ]);
    }
    
    public function getToolStats(int $days = 30): array
    {
        $startDate = now()->subDays($days);
        
        return DB::table('mcp_invocations')
            ->where('created_at', '>=', $startDate)
            ->select(
                'tool',
                DB::raw('COUNT(*) as count'),
                DB::raw('AVG(duration_ms) as avg_duration'),
                DB::raw('SUM(CASE WHEN success = 1 THEN 1 ELSE 0 END) as success_count'),
                DB::raw('SUM(CASE WHEN success = 0 THEN 1 ELSE 0 END) as error_count')
            )
            ->groupBy('tool')
            ->orderByDesc('count')
            ->get()
            ->toArray();
    }
    
    public function getClientStats(int $days = 30): array
    {
        $startDate = now()->subDays($days);
        
        return DB::table('mcp_invocations')
            ->join('mcp_clients', 'mcp_clients.id', '=', 'mcp_invocations.client_id')
            ->where('mcp_invocations.created_at', '>=', $startDate)
            ->select(
                'mcp_clients.name',
                'mcp_clients.tier',
                DB::raw('COUNT(*) as invocations'),
                DB::raw('AVG(duration_ms) as avg_duration')
            )
            ->groupBy('mcp_clients.id', 'mcp_clients.name', 'mcp_clients.tier')
            ->orderByDesc('invocations')
            ->get()
            ->toArray();
    }
    
    public function getPopularQueries(int $limit = 20): array
    {
        return Cache::remember('mcp_popular_queries', 3600, function () use ($limit) {
            return DB::table('mcp_invocations')
                ->where('tool', 'search_components')
                ->where('created_at', '>=', now()->subDays(30))
                ->select('params', DB::raw('COUNT(*) as count'))
                ->groupBy('params')
                ->orderByDesc('count')
                ->limit($limit)
                ->get()
                ->map(function ($row) {
                    $params = json_decode($row->params, true);
                    return [
                        'query' => $params['query'] ?? '',
                        'count' => $row->count,
                    ];
                })
                ->toArray();
        });
    }
    
    public function getErrorStats(int $days = 30): array
    {
        $startDate = now()->subDays($days);
        
        return DB::table('mcp_invocations')
            ->where('created_at', '>=', $startDate)
            ->where('success', false)
            ->select(
                'tool',
                DB::raw('COUNT(*) as count'),
                DB::raw('GROUP_CONCAT(DISTINCT SUBSTRING(params, 1, 100)) as sample_params')
            )
            ->groupBy('tool')
            ->orderByDesc('count')
            ->get()
            ->toArray();
    }
}
```

## Response Time Monitoring

```php
class ResponseTimeMonitor
{
    public function recordResponseTime(string $tool, float $duration): void
    {
        $bucket = $this->getTimeBucket();
        
        DB::table('mcp_response_times')->updateOrInsert(
            ['tool' => $tool, 'bucket' => $bucket],
            [
                'count' => DB::raw('count + 1'),
                'total_ms' => DB::raw('total_ms + ' . $duration),
                'min_ms' => DB::raw('LEAST(min_ms, ' . $duration . ')'),
                'max_ms' => DB::raw('GREATEST(max_ms, ' . $duration . ')'),
                'updated_at' => now(),
            ]
        );
    }
    
    public function getPercentiles(string $tool, int $hours = 24): array
    {
        $startTime = now()->subHours($hours);
        
        $durations = DB::table('mcp_invocations')
            ->where('tool', $tool)
            ->where('created_at', '>=', $startTime)
            ->orderBy('duration_ms')
            ->pluck('duration_ms')
            ->toArray();
        
        $count = count($durations);
        if ($count === 0) {
            return ['p50' => 0, 'p90' => 0, 'p95' => 0, 'p99' => 0];
        }
        
        return [
            'p50' => $durations[(int) ($count * 0.5)] ?? 0,
            'p90' => $durations[(int) ($count * 0.9)] ?? 0,
            'p95' => $durations[(int) ($count * 0.95)] ?? 0,
            'p99' => $durations[(int) ($count * 0.99)] ?? 0,
        ];
    }
    
    public function getSlowRequests(int $thresholdMs = 1000, int $limit = 50): array
    {
        return DB::table('mcp_invocations')
            ->where('duration_ms', '>', $thresholdMs)
            ->orderBy('duration_ms', 'desc')
            ->limit($limit)
            ->get()
            ->toArray();
    }
    
    private function getTimeBucket(): string
    {
        return now()->format('Y-m-d-H');
    }
}
```

## AI Assistant Usage Analytics

```php
class AiAssistantAnalytics
{
    public function getAssistantStats(int $days = 30): array
    {
        $startDate = now()->subDays($days);
        
        return DB::table('mcp_invocations')
            ->join('mcp_clients', 'mcp_clients.id', '=', 'mcp_invocations.client_id')
            ->where('mcp_invocations.created_at', '>=', $startDate)
            ->select(
                'mcp_clients.name as assistant',
                DB::raw('COUNT(*) as invocations'),
                DB::raw('COUNT(DISTINCT mcp_invocations.client_id) as unique_clients'),
                DB::raw('AVG(duration_ms) as avg_duration'),
                DB::raw('SUM(CASE WHEN success = 1 THEN 1 ELSE 0 END) / COUNT(*) * 100 as success_rate')
            )
            ->groupBy('mcp_clients.name')
            ->orderByDesc('invocations')
            ->get()
            ->toArray();
    }
    
    public function getAssistantToolUsage(string $assistant, int $days = 30): array
    {
        $startDate = now()->subDays($days);
        
        return DB::table('mcp_invocations')
            ->join('mcp_clients', 'mcp_clients.id', '=', 'mcp_invocations.client_id')
            ->where('mcp_clients.name', $assistant)
            ->where('mcp_invocations.created_at', '>=', $startDate)
            ->select(
                'tool',
                DB::raw('COUNT(*) as count')
            )
            ->groupBy('tool')
            ->orderByDesc('count')
            ->get()
            ->toArray();
    }
    
    public function getCodeGenerationStats(int $days = 30): array
    {
        $startDate = now()->subDays($days);
        
        $generations = DB::table('mcp_invocations')
            ->where('tool', 'generate_component_code')
            ->where('created_at', '>=', $startDate)
            ->get();
        
        $stats = [
            'total' => $generations->count(),
            'by_component' => [],
            'by_format' => [],
        ];
        
        foreach ($generations as $gen) {
            $params = json_decode($gen->params, true);
            $component = $params['component'] ?? 'unknown';
            $format = $params['format'] ?? 'blade';
            
            $stats['by_component'][$component] = ($stats['by_component'][$component] ?? 0) + 1;
            $stats['by_format'][$format] = ($stats['by_format'][$format] ?? 0) + 1;
        }
        
        arsort($stats['by_component']);
        arsort($stats['by_format']);
        
        return $stats;
    }
}
```

---

# Security Details

## Request Validation

```php
class McpRequestValidator
{
    public function validateRequest(array $request): ValidationResult
    {
        $errors = [];
        
        // Validate JSON-RPC structure
        if (!isset($request['jsonrpc']) || $request['jsonrpc'] !== '2.0') {
            $errors[] = 'Invalid JSON-RPC version';
        }
        
        if (!isset($request['method']) || !is_string($request['method'])) {
            $errors[] = 'Missing or invalid method';
        }
        
        if (!isset($request['id'])) {
            $errors[] = 'Missing request id';
        }
        
        // Validate method name
        if (isset($request['method']) && !$this->isValidMethod($request['method'])) {
            $errors[] = 'Invalid method: ' . $request['method'];
        }
        
        // Validate parameters
        if (isset($request['params']) && !is_array($request['params'])) {
            $errors[] = 'Invalid params';
        }
        
        return new ValidationResult(empty($errors), $errors);
    }
    
    private function isValidMethod(string $method): bool
    {
        $validMethods = [
            'search_components',
            'get_component_details',
            'generate_component_code',
            'search_docs',
            'get_doc_page',
            'get_theme_tokens',
            'generate_theme_css',
            'search_templates',
            'get_template_details',
        ];
        
        return in_array($method, $validMethods);
    }
}
```

## Output Sanitization

```php
class McpOutputSanitizer
{
    public function sanitize(array $data): array
    {
        return $this->sanitizeArray($data);
    }
    
    private function sanitizeArray(array $data): array
    {
        $sanitized = [];
        
        foreach ($data as $key => $value) {
            $sanitizedKey = $this->sanitizeString($key);
            
            if (is_array($value)) {
                $sanitized[$sanitizedKey] = $this->sanitizeArray($value);
            } elseif (is_string($value)) {
                $sanitized[$sanitizedKey] = $this->sanitizeString($value);
            } else {
                $sanitized[$sanitizedKey] = $value;
            }
        }
        
        return $sanitized;
    }
    
    private function sanitizeString(string $value): string
    {
        // Remove potential XSS
        $value = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
        
        // Remove null bytes
        $value = str_replace("\0", '', $value);
        
        // Limit length
        $value = substr($value, 0, 10000);
        
        return $value;
    }
}
```

## Audit Trail

```php
class McpAuditTrail
{
    public function logRequest(McpClient $client, array $request, array $response, float $duration): void
    {
        DB::table('mcp_audit_log')->insert([
            'client_id' => $client->id,
            'method' => $request['method'] ?? 'unknown',
            'params' => json_encode($request['params'] ?? []),
            'response_code' => isset($response['error']) ? $response['error']['code'] : 200,
            'duration_ms' => $duration,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'created_at' => now(),
        ]);
    }
    
    public function getAuditLog(McpClient $client = null, int $limit = 100): array
    {
        $query = DB::table('mcp_audit_log')
            ->join('mcp_clients', 'mcp_clients.id', '=', 'mcp_audit_log.client_id')
            ->select(
                'mcp_audit_log.*',
                'mcp_clients.name as client_name'
            );
        
        if ($client) {
            $query->where('mcp_audit_log.client_id', $client->id);
        }
        
        return $query->orderBy('mcp_audit_log.created_at', 'desc')
            ->limit($limit)
            ->get()
            ->toArray();
    }
    
    public function getSuspiciousActivity(int $hours = 24): array
    {
        $startTime = now()->subHours($hours);
        
        // High error rate
        $highErrorClients = DB::table('mcp_audit_log')
            ->where('created_at', '>=', $startTime)
            ->groupBy('client_id')
            ->havingRaw('SUM(CASE WHEN response_code >= 400 THEN 1 ELSE 0 END) / COUNT(*) > 0.5')
            ->pluck('client_id');
        
        // High request rate
        $highRateClients = DB::table('mcp_audit_log')
            ->where('created_at', '>=', $startTime)
            ->groupBy('client_id')
            ->havingRaw('COUNT(*) > 1000')
            ->pluck('client_id');
        
        // Unusual methods
        $unusualMethods = DB::table('mcp_audit_log')
            ->where('created_at', '>=', $startTime)
            ->whereNotIn('method', [
                'search_components',
                'get_component_details',
                'generate_component_code',
                'search_docs',
                'get_doc_page',
            ])
            ->get();
        
        return [
            'high_error_clients' => $highErrorClients,
            'high_rate_clients' => $highRateClients,
            'unusual_methods' => $unusualMethods,
        ];
    }
}
```

---

# Error Handling Details

## Error Response Builder

```php
class McpErrorResponseBuilder
{
    public function buildError(int $code, string $message, array $data = []): array
    {
        $response = [
            'jsonrpc' => '2.0',
            'error' => [
                'code' => $code,
                'message' => $message,
            ],
            'id' => request()->input('id'),
        ];
        
        if (!empty($data)) {
            $response['error']['data'] = $data;
        }
        
        return $response;
    }
    
    public function parseError(\Throwable $e): array
    {
        return match (true) {
            $e instanceof ValidationException => $this->buildError(
                -32602,
                'Invalid params',
                ['errors' => $e->errors()]
            ),
            $e instanceof AuthenticationException => $this->buildError(
                -32001,
                'Authentication required'
            ),
            $e instanceof AuthorizationException => $this->buildError(
                -32002,
                'Insufficient permissions'
            ),
            $e instanceof RateLimitException => $this->buildError(
                -32000,
                'Rate limit exceeded',
                ['retry_after' => $e->getRetryAfter()]
            ),
            $e instanceof ModelNotFoundException => $this->buildError(
                -32602,
                'Resource not found'
            ),
            default => $this->buildError(
                -32603,
                'Internal error',
                ['message' => config('app.debug') ? $e->getMessage() : 'An error occurred']
            ),
        };
    }
}
```

## Error Codes Reference

```php
class McpErrorCodes
{
    public const PARSE_ERROR = -32700;
    public const INVALID_REQUEST = -32600;
    public const METHOD_NOT_FOUND = -32601;
    public const INVALID_PARAMS = -32602;
    public const INTERNAL_ERROR = -32603;
    
    public const RATE_LIMIT_EXCEEDED = -32000;
    public const AUTHENTICATION_REQUIRED = -32001;
    public const INSUFFICIENT_PERMISSIONS = -32002;
    public const RESOURCE_NOT_FOUND = -32003;
    public const VALIDATION_ERROR = -32004;
    
    public const DESCRIPTIONS = [
        self::PARSE_ERROR => 'Parse error',
        self::INVALID_REQUEST => 'Invalid Request',
        self::METHOD_NOT_FOUND => 'Method not found',
        self::INVALID_PARAMS => 'Invalid params',
        self::INTERNAL_ERROR => 'Internal error',
        self::RATE_LIMIT_EXCEEDED => 'Rate limit exceeded',
        self::AUTHENTICATION_REQUIRED => 'Authentication required',
        self::INSUFFICIENT_PERMISSIONS => 'Insufficient permissions',
        self::RESOURCE_NOT_FOUND => 'Resource not found',
        self::VALIDATION_ERROR => 'Validation error',
    ];
    
    public function getDescription(int $code): string
    {
        return self::DESCRIPTIONS[$code] ?? 'Unknown error';
    }
}
```

---

# API Contracts Details

## MCP API Specification

```yaml
openapi: 3.0.0
info:
  title: GsmUi MCP API
  version: 1.0.0
  description: Model Context Protocol API for AI assistants

paths:
  /mcp:
    post:
      summary: MCP JSON-RPC endpoint
      tags: [MCP]
      requestBody:
        required: true
        content:
          application/json:
            schema:
              type: object
              required:
                - jsonrpc
                - method
                - id
              properties:
                jsonrpc:
                  type: string
                  enum: ['2.0']
                method:
                  type: string
                params:
                  type: object
                id:
                  type: string
      responses:
        '200':
          description: JSON-RPC response
          content:
            application/json:
              schema:
                type: object
                properties:
                  jsonrpc:
                    type: string
                  result:
                    type: object
                  error:
                    type: object
                  id:
                    type: string

  /mcp/auth/authorize:
    get:
      summary: OAuth authorization
      tags: [Auth]
      parameters:
        - name: client_id
          in: query
          required: true
          schema:
            type: string
        - name: redirect_uri
          in: query
          required: true
          schema:
            type: string
        - name: response_type
          in: query
          required: true
          schema:
            type: string
            enum: [code]
        - name: scope
          in: query
          schema:
            type: string
        - name: state
          in: query
          schema:
            type: string
      responses:
        '302':
          description: Redirect with authorization code

  /mcp/auth/token:
    post:
      summary: Exchange authorization code for token
      tags: [Auth]
      requestBody:
        required: true
        content:
          application/json:
            schema:
              type: object
              required:
                - grant_type
                - code
                - redirect_uri
                - client_id
                - client_secret
              properties:
                grant_type:
                  type: string
                  enum: [authorization_code]
                code:
                  type: string
                redirect_uri:
                  type: string
                client_id:
                  type: string
                client_secret:
                  type: string
      responses:
        '200':
          description: Access token
          content:
            application/json:
              schema:
                type: object
                properties:
                  access_token:
                    type: string
                  refresh_token:
                    type: string
                  token_type:
                    type: string
                  expires_in:
                    type: integer
                  scope:
                    type: string

  /mcp/resources/{uri}:
    get:
      summary: Get MCP resource
      tags: [Resources]
      parameters:
        - name: uri
          in: path
          required: true
          schema:
            type: string
      responses:
        '200':
          description: Resource content

components:
  securitySchemes:
    bearerAuth:
      type: http
      scheme: bearer
      bearerFormat: JWT

  schemas:
    ToolInvocation:
      type: object
      properties:
        tool:
          type: string
        params:
          type: object
        result:
          type: object
        duration_ms:
          type: number
        success:
          type: boolean

    Resource:
      type: object
      properties:
        uri:
          type: string
        name:
          type: string
        description:
          type: string
        mimeType:
          type: string
```

---

# Next Document

**21 - Blog** — Content management system for the GsmUi blog.
