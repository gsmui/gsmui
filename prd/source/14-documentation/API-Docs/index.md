---
title: API Documentation
description: OpenAPI spec, endpoint reference, request/response examples, and error codes.
order: 14.6
group: API Docs
---

# API Documentation

GsmUi provides structured API documentation for both the PHP API and the HTTP API endpoints.

## API Documentation Structure

| Section | Purpose |
|---|---|
| OpenAPI Spec | Machine-readable API definition |
| Endpoint Reference | Human-readable endpoint docs |
| Request Examples | cURL, PHP, JS examples |
| Response Examples | Success and error responses |
| Error Codes | Complete error reference |

## OpenAPI Specification

### Spec Structure

```yaml
openapi: 3.1.0
info:
  title: GsmUi Pro API
  version: 2.15.0
  description: |
    GsmUi Pro component API for Livewire applications.

servers:
  - url: /api
    description: Local development

paths:
  /components:
    get:
      summary: List all components
      tags: [Components]
      responses:
        '200':
          description: Component list
          content:
            application/json:
              schema:
                type: array
                items:
                  $ref: '#/components/schemas/Component'
```

### Schema Definitions

```yaml
components:
  schemas:
    Component:
      type: object
      properties:
        name:
          type: string
          example: "button"
        type:
          type: string
          enum: [blade, livewire]
        version:
          type: string
          example: "2.15.0"
        status:
          type: string
          enum: [stable, beta, deprecated]
        props:
          type: array
          items:
            $ref: '#/components/schemas/Prop'

    Prop:
      type: object
      properties:
        name:
          type: string
        type:
          type: string
        default:
          type: string
        required:
          type: boolean
        description:
          type: string
```

## Endpoint Reference

### Base URL

```
/api/v1
```

### Authentication

| Method | Header | Description |
|---|---|---|
| API Key | `X-API-Key: your-key` | Server-side |
| Bearer Token | `Authorization: Bearer token` | OAuth2 |

### Endpoints

| Method | Endpoint | Description |
|---|---|---|
| `GET` | `/components` | List components |
| `GET` | `/components/{name}` | Get component |
| `GET` | `/components/{name}/props` | List props |
| `GET` | `/components/{name}/events` | List events |
| `GET` | `/components/{name}/slots` | List slots |
| `POST` | `/components/{name}/render` | Render component |

### Component List

```
GET /api/v1/components
```

**Response:**

```json
{
  "data": [
    {
      "name": "button",
      "type": "blade",
      "version": "2.15.0",
      "status": "stable",
      "props_count": 9,
      "url": "/docs/components/button"
    }
  ],
  "meta": {
    "total": 42,
    "page": 1,
    "per_page": 20
  }
}
```

### Component Detail

```
GET /api/v1/components/button
```

**Response:**

```json
{
  "data": {
    "name": "button",
    "type": "blade",
    "version": "2.15.0",
    "status": "stable",
    "description": "A versatile button component",
    "props": [
      {
        "name": "variant",
        "type": "string",
        "default": "primary",
        "required": false,
        "options": ["primary", "secondary", "danger", "ghost", "outline"],
        "description": "Button style variant"
      }
    ],
    "events": [
      {
        "name": "click",
        "payload": "MouseEvent",
        "description": "Fired when button is clicked"
      }
    ],
    "slots": [
      {
        "name": "default",
        "description": "Button content"
      }
    ]
  }
}
```

## Request Examples

### cURL

```bash
# List components
curl -X GET "https://api.gsmui.dev/v1/components" \
  -H "X-API-Key: your-key"

# Get component detail
curl -X GET "https://api.gsmui.dev/v1/components/button" \
  -H "X-API-Key: your-key"

# Render component
curl -X POST "https://api.gsmui.dev/v1/components/button/render" \
  -H "X-API-Key: your-key" \
  -H "Content-Type: application/json" \
  -d '{"props": {"variant": "primary", "size": "md"}, "slots": {"default": "Click me"}}'
```

### PHP (Guzzle)

```php
use GuzzleHttp\Client;

$client = new Client([
    'base_uri' => 'https://api.gsmui.dev/v1',
    'headers' => [
        'X-API-Key' => 'your-key',
        'Accept' => 'application/json',
    ],
]);

// List components
$response = $client->get('/components');
$components = json_decode($response->getBody(), true);

// Get component
$response = $client->get('/components/button');
$component = json_decode($response->getBody(), true);
```

### JavaScript (Fetch)

```javascript
const response = await fetch('/api/v1/components', {
  headers: {
    'X-API-Key': 'your-key',
    'Accept': 'application/json',
  },
});

const { data } = await response.json();
```

## Response Examples

### Success Response

```json
{
  "data": {
    "name": "button",
    "type": "blade",
    "version": "2.15.0"
  },
  "meta": {
    "request_id": "req_abc123",
    "timestamp": "2024-01-15T10:30:00Z"
  }
}
```

### Error Response

```json
{
  "error": {
    "code": "NOT_FOUND",
    "message": "Component 'widget' not found",
    "details": {
      "component": "widget",
      "available": ["button", "input", "select"]
    }
  },
  "meta": {
    "request_id": "req_abc123",
    "timestamp": "2024-01-15T10:30:00Z"
  }
}
```

## Error Codes

| Code | HTTP Status | Description |
|---|---|---|
| `UNAUTHORIZED` | 401 | Invalid or missing API key |
| `FORBIDDEN` | 403 | Insufficient permissions |
| `NOT_FOUND` | 404 | Resource not found |
| `VALIDATION_ERROR` | 422 | Invalid request data |
| `RATE_LIMITED` | 429 | Too many requests |
| `SERVER_ERROR` | 500 | Internal server error |

### Rate Limits

| Plan | Requests/min | Burst |
|---|---|---|
| Free | 60 | 10 |
| Pro | 300 | 50 |
| Enterprise | 1000 | 200 |

## Documentation API

```php
// Get all docs pages
GET /api/v1/docs

// Search docs
GET /api/v1/docs/search?q=button

// Get specific page
GET /api/v1/docs/components/button

// Get page metadata
GET /api/v1/docs/components/button/meta
```
