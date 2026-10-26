---
title: "MCP Server"
description: "Model Context Protocol server for AI integration"
volume: "18"
---

# MCP Server

Model Context Protocol (MCP) server implementation for integrating AI capabilities with the gsmui ecosystem.

## Overview

The MCP Server provides a standardized interface for AI models to interact with gsmui components, access project resources, and execute commands. It enables external AI tools to seamlessly integrate with the playground environment.

## Server Setup

### Installation

```bash
# Via Composer
composer require gsmui/mcp-server

# Via npm (for JavaScript integration)
npm install @gsmui/mcp-server
```

### Configuration

```yaml
# config/mcp.php
return [
    'server' => [
        'host' => '0.0.0.0',
        'port' => 8080,
        'protocol' => 'stdio', // or 'sse'
    ],
    
    'authentication' => [
        'enabled' => true,
        'type' => 'token', // or 'oauth', 'api_key'
        'tokens' => [
            'dev' => env('MCP_DEV_TOKEN'),
            'prod' => env('MCP_PROD_TOKEN'),
        ],
    ],
    
    'rate_limiting' => [
        'enabled' => true,
        'max_requests' => 100,
        'per_seconds' => 60,
    ],
    
    'logging' => [
        'enabled' => true,
        'level' => 'info', // debug, info, warning, error
        'file' => storage_path('logs/mcp.log'),
    ],
];
```

### Server Initialization

```php
use Gsmui\Mcp\Server;

$server = new Server([
    'name' => 'gsmui-mcp',
    'version' => '1.0.0',
]);

// Register tools
$server->registerTool(new ComponentGeneratorTool());
$server->registerTool(new ThemeGeneratorTool());
$server->registerTool(new CodeAnalysisTool());

// Register resources
$server->registerResource(new ProjectResource());
$server->registerResource(new ComponentResource());

// Start server
$server->start();
```

## Tool Definitions

### Available Tools

| Tool | Description |
|------|-------------|
| `generate_component` | Create Livewire components from description |
| `generate_theme` | Generate color palettes and themes |
| `analyze_code` | Analyze code for issues and improvements |
| `refactor_code` | Refactor code with best practices |
| `generate_tests` | Create unit/feature tests |
| `validate_accessibility` | Check WCAG compliance |
| `optimize_performance` | Identify performance bottlenecks |

### Tool Schema

```json
{
  "name": "generate_component",
  "description": "Generate a Livewire component from natural language description",
  "inputSchema": {
    "type": "object",
    "properties": {
      "description": {
        "type": "string",
        "description": "Component description"
      },
      "type": {
        "type": "string",
        "enum": ["form", "modal", "table", "widget", "page"],
        "description": "Component type"
      },
      "options": {
        "type": "object",
        "properties": {
          "include_tests": { "type": "boolean" },
          "include_validation": { "type": "boolean" },
          "include_documentation": { "type": "boolean" }
        }
      }
    },
    "required": ["description", "type"]
  }
}
```

### Tool Execution

```yaml
tool_execution:
  process:
    - validate_input
    - check_permissions
    - execute_tool
    - format_output
    - log_execution
    
  error_handling:
    - validation_error: 400
    - permission_error: 403
    - not_found: 404
    - execution_error: 500
    
  timeout:
    default: 30
    max: 120
```

## Prompt Templates

### Built-in Prompts

| Prompt | Description |
|--------|-------------|
| `component_creation` | Guide for creating components |
| `theme_generation` | Theme creation workflow |
| `code_review` | Code review checklist |
| `accessibility_check` | A11y validation steps |
| `performance_optimization` | Performance improvement guide |

### Prompt Template Format

```yaml
prompt_templates:
  component_creation:
    name: "Component Creation"
    description: "Step-by-step component creation"
    template: |
      Create a Livewire component with the following requirements:
      
      Description: {{description}}
      Type: {{type}}
      Features: {{features}}
      
      Steps:
      1. Analyze requirements
      2. Design component structure
      3. Implement PHP class
      4. Create Blade template
      5. Add validation rules
      6. Write tests
      7. Document usage
      
    variables:
      - name: description
        type: string
        required: true
        
      - name: type
        type: string
        enum: [form, modal, table, widget]
        required: true
        
      - name: features
        type: array
        required: false
```

### Custom Prompts

```yaml
custom_prompts:
  create:
    - name: "My Custom Prompt"
      description: "Custom workflow"
      template: "..."
      variables: [...]
      
  share:
    - public: true
    - team_only: false
    - marketplace: true
    
  versioning:
    - semantic_versioning: true
    - change_log: true
```

## Resource Management

### Resource Types

| Resource | Description |
|----------|-------------|
| Project | Project files and configuration |
| Component | Individual component files |
| Template | Reusable templates |
| Snippet | Code snippets |
| Theme | Theme configurations |
| Documentation | Project documentation |

### Resource Schema

```json
{
  "name": "project",
  "description": "Access to project files and configuration",
  "uri": "gsmui://project/{project_id}",
  "mimeType": "application/json",
  "schema": {
    "type": "object",
    "properties": {
      "project_id": { "type": "string" },
      "files": { "type": "array" },
      "config": { "type": "object" }
    }
  }
}
```

### Resource Access

```yaml
resource_access:
  permissions:
    read: true
    write: false
    delete: false
    
  scope:
    - current_project
    - shared_projects
    - templates
    
  caching:
    enabled: true
    ttl: 300
    strategy: "lru"
```

## Security

### Authentication Methods

| Method | Description |
|--------|-------------|
| Token | Bearer token authentication |
| OAuth 2.0 | OAuth flow integration |
| API Key | Simple API key |
| JWT | JSON Web Token |
| mTLS | Mutual TLS certificates |

### Authorization

```yaml
authorization:
  roles:
    - name: "admin"
      permissions:
        - "tools:*"
        - "resources:*"
        - "prompts:*"
        
    - name: "developer"
      permissions:
        - "tools:read"
        - "tools:execute"
        - "resources:read"
        - "prompts:read"
        
    - name: "viewer"
      permissions:
        - "tools:read"
        - "resources:read"
        - "prompts:read"
```

### Security Measures

| Measure | Description |
|---------|-------------|
| Input validation | Sanitize all inputs |
| Rate limiting | Prevent abuse |
| CORS configuration | Restrict origins |
| CSP headers | Content Security Policy |
| Audit logging | Track all operations |
| Encryption | TLS for all traffic |

## Protocol Details

### JSON-RPC 2.0

```json
{
  "jsonrpc": "2.0",
  "id": "request-123",
  "method": "tools/call",
  "params": {
    "name": "generate_component",
    "arguments": {
      "description": "Contact form with validation",
      "type": "form"
    }
  }
}
```

### Response Format

```json
{
  "jsonrpc": "2.0",
  "id": "request-123",
  "result": {
    "content": [
      {
        "type": "text",
        "text": "Component generated successfully"
      },
      {
        "type": "resource",
        "resource": {
          "uri": "gsmui://files/contact-form.php",
          "text": "<?php..."
        }
      }
    ]
  }
}
```

### Error Response

```json
{
  "jsonrpc": "2.0",
  "id": "request-123",
  "error": {
    "code": -32600,
    "message": "Invalid Request",
    "data": {
      "details": "Missing required parameter: description"
    }
  }
}
```

## Integration Examples

### PHP Integration

```php
use Gsmui\Mcp\Client;

$client = new Client([
    'transport' => 'stdio',
    'command' => 'gsmui-mcp-server',
]);

// List available tools
$tools = $client->listTools();

// Execute a tool
$result = $client->callTool('generate_component', [
    'description' => 'User profile card',
    'type' => 'widget',
]);

// Read a resource
$resource = $client->readResource('gsmui://project/config');
```

### JavaScript Integration

```javascript
import { McpClient } from '@gsmui/mcp-server';

const client = new McpClient({
  transport: 'sse',
  url: 'http://localhost:8080/sse',
});

// Connect and authenticate
await client.connect({ token: 'your-api-token' });

// Execute tool
const result = await client.callTool('generate_component', {
  description: 'Navigation menu',
  type: 'component',
});

console.log(result);
```

### CLI Integration

```bash
# Start MCP server
gsmui-mcp-server --port 8080

# Test connection
gsmui-mcp-cli ping

# List tools
gsmui-mcp-cli tools list

# Execute tool
gsmui-mcp-cli tools call generate_component \
  --description "Login form" \
  --type form
```

## Monitoring

### Metrics

| Metric | Description |
|--------|-------------|
| Request count | Total requests processed |
| Response time | Average response latency |
| Error rate | Failed request percentage |
| Active connections | Current connections |
| Memory usage | Server memory consumption |

### Health Check

```http
GET /health

{
  "status": "healthy",
  "version": "1.0.0",
  "uptime": 86400,
  "tools": 15,
  "resources": 8,
  "connections": 42
}
```

### Logging

```yaml
logging:
  levels:
    - DEBUG: Detailed debug information
    - INFO: General operation information
    - WARNING: Warning conditions
    - ERROR: Error conditions
    - CRITICAL: Critical failures
    
  format: |
    [{timestamp}] {level}: {message} {context}
    
  channels:
    - daily
    - stderr
    - syslog
```

## Performance

| Metric | Target |
|--------|--------|
| Response time | < 100ms |
| Throughput | 1000 req/sec |
| Concurrent connections | 100 |
| Memory usage | < 256MB |
| CPU usage | < 50% |

## Browser Support

The MCP Server is a backend service that provides REST and WebSocket APIs. Client libraries are available for PHP, JavaScript, Python, and Go.

## Testing

| Test Type | Description |
|-----------|-------------|
| Unit tests | Tool execution logic |
| Integration tests | Client-server communication |
| Performance tests | Load testing |
| Security tests | Authentication bypass |
| Protocol tests | JSON-RPC validation |

## Edge Cases

| Scenario | Handling |
|----------|----------|
| Tool timeout | Graceful termination |
| Invalid JSON-RPC | Proper error response |
| Authentication failure | 401 Unauthorized |
| Rate limiting | 429 Too Many Requests |
| Server overload | Connection queuing |
| Malformed requests | Input validation