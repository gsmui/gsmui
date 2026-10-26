---
title: MCP Integration Docs
description: MCP server setup, tool reference, prompt templates, and examples.
order: 14.8
group: MCP Docs
---

# MCP Integration Documentation

Model Context Protocol (MCP) integration allows AI assistants to interact with GsmUi documentation programmatically.

## MCP Overview

| Concept | Description |
|---|---|
| MCP Server | Exposes Gsmui docs as MCP tools |
| MCP Tools | Callable functions for AI assistants |
| MCP Prompts | Pre-built prompt templates |
| MCP Resources | Doc content as MCP resources |

## MCP Server Setup

### Installation

```bash
composer require gsmui/mcp-server
```

### Configuration

```php
// config/mcp.php
return [
    'gsmui' => [
        'enabled' => true,
        'tools' => [
            'search_docs' => true,
            'get_component' => true,
            'generate_code' => true,
            'validate_props' => true,
        ],
        'rate_limit' => 100,
    ],
];
```

### Server Registration

```php
// app/Providers/McpServiceProvider.php
use Gsmui\Mcp\McpServer;

public function register(): void
{
    $this->app->singleton(McpServer::class, function () {
        $server = new McpServer('gsmui-docs');
        
        $server->tool('search_docs', [
            'description' => 'Search GsmUi documentation',
            'inputSchema' => [
                'type' => 'object',
                'properties' => [
                    'query' => ['type' => 'string'],
                ],
                'required' => ['query'],
            ],
        ], function (array $params) {
            return GsmuiDocs::search($params['query']);
        });
        
        return $server;
    });
}
```

## MCP Tools Reference

### search_docs

Search GsmUi documentation.

| Parameter | Type | Required | Description |
|---|---|---|---|
| `query` | string | Yes | Search query |
| `limit` | int | No | Max results (default: 5) |
| `group` | string | No | Filter by group |

**Response:**

```json
{
  "results": [
    {
      "title": "Button Component",
      "url": "/docs/components/button",
      "snippet": "A versatile button component...",
      "relevance": 0.95
    }
  ]
}
```

### get_component

Get detailed component information.

| Parameter | Type | Required | Description |
|---|---|---|---|
| `name` | string | Yes | Component name |
| `section` | string | No | Specific section |

**Response:**

```json
{
  "name": "button",
  "description": "A versatile button component",
  "props": [
    {
      "name": "variant",
      "type": "string",
      "default": "primary",
      "options": ["primary", "secondary", "danger"]
    }
  ],
  "events": ["click"],
  "slots": ["default"],
  "example": "<gsmui:button variant=\"primary\">Click</gsmui:button>"
}
```

### generate_code

Generate component code from natural language.

| Parameter | Type | Required | Description |
|---|---|---|---|
| `description` | string | Yes | Code description |
| `language` | string | No | Output language (default: blade) |

**Response:**

```json
{
  "code": "<gsmui:button variant=\"primary\" loading>\n    Save\n</gsmui:button>",
  "components_used": ["button"],
  "explanation": "A primary button with loading state."
}
```

### validate_props

Validate component props.

| Parameter | Type | Required | Description |
|---|---|---|---|
| `component` | string | Yes | Component name |
| `props` | object | Yes | Props to validate |

**Response:**

```json
{
  "valid": true,
  "warnings": [],
  "suggestions": ["Consider adding an icon for better UX"]
}
```

## MCP Prompts

### Prompt Templates

| Prompt | Description |
|---|---|
| `component_help` | Get help with a component |
| `migration_guide` | Get migration instructions |
| `best_practices` | Component best practices |
| `troubleshoot` | Debug component issues |

### Prompt Usage

```json
{
  "prompt": "component_help",
  "args": {
    "component": "button",
    "context": "I need to add a loading state"
  }
}
```

### Prompt Response

```json
{
  "response": "To add a loading state to a button, use the `loading` prop...",
  "examples": [
    "<gsmui:button loading>Saving...</gsmui:button>"
  ],
  "related_docs": [
    "/docs/components/button#loading"
  ]
}
```

## MCP Resources

### Available Resources

| Resource | URI | Description |
|---|---|---|
| Component List | `gsmui://components` | All components |
| Component Detail | `gsmui://components/{name}` | Component info |
| Props Reference | `gsmui://components/{name}/props` | Props list |
| Events Reference | `gsmui://components/{name}/events` | Events list |

### Resource Access

```json
{
  "method": "resources/read",
  "params": {
    "uri": "gsmui://components/button"
  }
}
```

## Examples

### AI Assistant Integration

```python
# Python MCP client example
from mcp import Client

client = Client("gsmui-docs")

# Search docs
results = await client.call_tool("search_docs", {
    "query": "how to create a modal"
})

# Get component details
component = await client.call_tool("get_component", {
    "name": "modal"
})

# Generate code
code = await client.call_tool("generate_code", {
    "description": "A confirmation dialog with yes/no buttons"
})
```

### Cursor IDE Integration

```json
// .cursor/mcp.json
{
  "mcpServers": {
    "gsmui": {
      "command": "php",
      "args": ["artisan", "mcp:serve"],
      "env": {
        "GSMUI_MCP_ENABLED": "true"
      }
    }
  }
}
```

## Security

| Concern | Implementation |
|---|---|
| Authentication | API key required |
| Rate limiting | Per-key limits |
| Content filtering | No harmful code |
| Sandboxing | Code execution isolated |
