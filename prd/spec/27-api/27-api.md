# 27 - API

**Project:** GsmUi
**Version:** 1.0.0

---

# Purpose

The API exposes GsmUi capabilities through a versioned REST API for mobile clients, CLI tools, MCP integration, and third-party applications.

---

# Vision

Provide a clean, consistent, and well-documented API that enables any client to integrate with GsmUi's full feature set.

---

# Core Features

## API Design

* RESTful architecture
* JSON:API spec compliance
* Versioned endpoints
* Pagination
* Filtering
* Sorting
* Field selection

## Authentication

* Sanctum tokens
* OAuth 2.0 (future)
* API key authentication
* Rate limiting

## Documentation

* OpenAPI/Swagger spec
* Interactive docs
* Code examples
* SDKs

---

# API Architecture

```text
Client (Mobile/CLI/Third-party)
    ↓
HTTP Request
    ↓
Rate Limiter
    ↓
Authentication Middleware
    ↓
API Router
    ↓
Controller
    ↓
Form Request (validation)
    ↓
Action / Service
    ↓
Resource Transformer
    ↓
JSON Response
```

---

# API Endpoints

## Components

```
GET    /api/v1/components              List components
GET    /api/v1/components/{id}         Get component
GET    /api/v1/components/{id}/docs    Get component docs
GET    /api/v1/components/{id}/examples Get examples
```

## Documentation

```
GET    /api/v1/docs                    List docs
GET    /api/v1/docs/{slug}             Get doc page
GET    /api/v1/docs/search             Search docs
```

## Templates

```
GET    /api/v1/templates               List templates
GET    /api/v1/templates/{id}          Get template
GET    /api/v1/templates/{id}/download Download template
```

## Themes

```
GET    /api/v1/themes                  List themes
GET    /api/v1/themes/{id}             Get theme
GET    /api/v1/themes/{id}/tokens      Get theme tokens
```

## User

```
GET    /api/v1/user/profile            Get profile
PUT    /api/v1/user/profile            Update profile
GET    /api/v1/user/subscriptions      List subscriptions
GET    /api/v1/user/downloads          List downloads
```

## Marketplace

```
GET    /api/v1/marketplace/products    List products
GET    /api/v1/marketplace/products/{id} Get product
POST   /api/v1/marketplace/orders      Create order
```

## Search

```
GET    /api/v1/search                  Search all
GET    /api/v1/search/components       Search components
GET    /api/v1/search/docs             Search docs
```

---

# Request Format

## Headers

```http
Authorization: Bearer {token}
Content-Type: application/json
Accept: application/json
X-GsmUi-Version: 2024-01-15
```

## Query Parameters

```
?page=1
&per_page=20
&sort=-created_at
&filter[category]=actions
&fields[components]=name,description,category
```

---

# Response Format

## Success Response

```json
{
  "data": {
    "id": "comp_abc123",
    "type": "component",
    "attributes": {
      "name": "button",
      "description": "Production-ready button component",
      "category": "actions",
      "version": "1.0.0",
      "status": "stable"
    },
    "relationships": {
      "category": {
        "data": {
          "type": "category",
          "id": "cat_actions"
        }
      }
    }
  },
  "meta": {
    "api_version": "2024-01-15",
    "request_id": "req_xyz789"
  }
}
```

## Collection Response

```json
{
  "data": [...],
  "meta": {
    "total": 150,
    "per_page": 20,
    "current_page": 1,
    "last_page": 8
  },
  "links": {
    "self": "/api/v1/components?page=1",
    "next": "/api/v1/components?page=2",
    "prev": null,
    "last": "/api/v1/components?page=8"
  }
}
```

## Error Response

```json
{
  "errors": [
    {
      "status": "422",
      "title": "Validation Error",
      "detail": "The name field is required.",
      "source": {
        "pointer": "/data/attributes/name"
      }
    }
  ],
  "meta": {
    "api_version": "2024-01-15",
    "request_id": "req_xyz789"
  }
}
```

---

# Authentication

## Token Authentication

```bash
# Create token
curl -X POST https://api.gsmui.com/api/v1/tokens \
  -H "Content-Type: application/json" \
  -d '{"email": "user@example.com", "password": "password"}'

# Use token
curl https://api.gsmui.com/api/v1/components \
  -H "Authorization: Bearer {token}"
```

## API Key Authentication

```bash
# Use API key
curl https://api.gsmui.com/api/v1/components \
  -H "X-GsmUi-Key: gsm_live_xxxxx"
```

---

# Rate Limiting

| Tier | Requests/Minute | Requests/Hour | Requests/Day |
|------|-----------------|---------------|--------------|
| Free | 60 | 1,000 | 10,000 |
| Pro | 120 | 5,000 | 50,000 |
| Enterprise | 600 | 25,000 | 250,000 |

## Rate Limit Headers

```http
X-RateLimit-Limit: 60
X-RateLimit-Remaining: 45
X-RateLimit-Reset: 1640995200
```

---

# Versioning

## Version Strategy

* Header-based versioning
* `X-GsmUi-Version: 2024-01-15`
* Latest stable version by default
* 12-month deprecation notice

## Version Lifecycle

```text
Release → Active → Deprecated → Sunset
 (0)      (12mo)    (12mo)       (removed)
```

---

# SDKs

## Official SDKs

* PHP SDK
* JavaScript SDK
* Python SDK (future)
* Ruby SDK (future)
* Go SDK (future)

## SDK Features

* Type-safe requests
* Automatic retries
* Pagination helpers
* Webhook handling

---

# Webhooks

## Webhook Events

```
component.created
component.updated
template.purchased
subscription.created
subscription.renewed
order.completed
```

## Webhook Format

```json
{
  "event": "component.created",
  "created_at": "2024-01-15T10:00:00Z",
  "data": {
    "id": "comp_abc123",
    "name": "button",
    "category": "actions"
  }
}
```

---

# Technical Architecture

```text
Client Request
    ↓
Load Balancer (CloudFlare)
    ↓
API Gateway (Laravel)
├── Rate Limiter
├── Authentication
├── Version Router
├── Request Parser
    ↓
Controller
├── Form Request
├── Action
├── Service
├── Resource
    ↓
JSON Response
```

---

# Database Schema

Key tables:

* `api_tokens` — Sanctum tokens
* `api_keys` — API keys
* `api_logs` — Request logs
* `api_webhooks` — Webhook configs
* `api_webhook_deliveries` — Delivery logs

---

# Monitoring

Track API health:

* Response times
* Error rates
* Rate limit hits
* Authentication failures
* Popular endpoints
* Client usage

---

# Admin Features

* Token management
* API key management
* Usage analytics
* Rate limit configuration
* Webhook management
* API logs

---

# Success Metrics

* <100ms average response time
* 99.9% uptime
* 99.5% success rate
* 100% documentation coverage
* 90%+ developer satisfaction

---

# Database Schema (Extended)

## api_tokens

```sql
CREATE TABLE api_tokens (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    name VARCHAR(255) NOT NULL,
    token VARCHAR(255) UNIQUE NOT NULL,
    abilities TEXT NOT NULL,
    last_used_at TIMESTAMP NULL,
    last_used_ip VARCHAR(45) NULL,
    expires_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_user (user_id),
    INDEX idx_token (token),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
```

## api_keys

```sql
CREATE TABLE api_keys (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    name VARCHAR(255) NOT NULL,
    key_hash VARCHAR(255) NOT NULL,
    key_prefix VARCHAR(10) NOT NULL,
    type ENUM('live','test') NOT NULL DEFAULT 'test',
    abilities JSON NULL,
    rate_limit_minute INT DEFAULT 60,
    rate_limit_hour INT DEFAULT 1000,
    rate_limit_day INT DEFAULT 10000,
    last_used_at TIMESTAMP NULL,
    last_used_ip VARCHAR(45) NULL,
    expires_at TIMESTAMP NULL,
    revoked_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_user (user_id),
    INDEX idx_key_hash (key_hash),
    INDEX idx_prefix (key_prefix),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
```

## api_logs

```sql
CREATE TABLE api_logs (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    api_token_id BIGINT UNSIGNED NULL,
    api_key_id BIGINT UNSIGNED NULL,
    method VARCHAR(10) NOT NULL,
    path VARCHAR(500) NOT NULL,
    query_params JSON NULL,
    request_body JSON NULL,
    request_headers JSON NULL,
    response_status INT NOT NULL,
    response_body JSON NULL,
    response_time_ms DECIMAL(10,2) NULL,
    ip_address VARCHAR(45) NULL,
    user_agent TEXT NULL,
    user_id BIGINT UNSIGNED NULL,
    api_version VARCHAR(50) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_token (api_token_id),
    INDEX idx_key (api_key_id),
    INDEX idx_user (user_id),
    INDEX idx_method (method),
    INDEX idx_status (response_status),
    INDEX idx_created (created_at),
    INDEX idx_path (path),
    FOREIGN KEY (api_token_id) REFERENCES api_tokens(id) ON DELETE SET NULL,
    FOREIGN KEY (api_key_id) REFERENCES api_keys(id) ON DELETE SET NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
);
```

## api_webhooks

```sql
CREATE TABLE api_webhooks (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    url VARCHAR(500) NOT NULL,
    events JSON NOT NULL,
    secret VARCHAR(255) NOT NULL,
    is_active BOOLEAN DEFAULT TRUE,
    last_triggered_at TIMESTAMP NULL,
    failure_count INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_user (user_id),
    INDEX idx_active (is_active),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
```

## api_webhook_deliveries

```sql
CREATE TABLE api_webhook_deliveries (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    webhook_id BIGINT UNSIGNED NOT NULL,
    event VARCHAR(255) NOT NULL,
    payload JSON NOT NULL,
    response_status INT NULL,
    response_body TEXT NULL,
    response_time_ms DECIMAL(10,2) NULL,
    attempts INT DEFAULT 0,
    delivered_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_webhook (webhook_id),
    INDEX idx_event (event),
    INDEX idx_delivered (delivered_at),
    FOREIGN KEY (webhook_id) REFERENCES api_webhooks(id) ON DELETE CASCADE
);
```

## api_rate_limits

```sql
CREATE TABLE api_rate_limits (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    key_type ENUM('token','key','ip') NOT NULL,
    key_value VARCHAR(255) NOT NULL,
    window ENUM('minute','hour','day') NOT NULL,
    attempts INT DEFAULT 1,
    reset_at TIMESTAMP NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE INDEX idx_unique (key_type, key_value, window),
    INDEX idx_reset (reset_at)
);
```

---

# API Service Layer

## ApiService

```php
<?php

namespace App\Services\Api;

use App\Models\ApiToken;
use App\Models\ApiKey;
use App\Models\ApiLog;
use App\Models\ApiWebhook;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class ApiService
{
    public function createToken(string $name, array $abilities = ['*']): array
    {
        $token = auth()->user()->createToken($name, $abilities);

        return [
            'id' => $token->accessToken->id,
            'name' => $name,
            'token' => $token->plainTextToken,
            'abilities' => $abilities,
            'created_at' => $token->accessToken->created_at,
        ];
    }

    public function revokeToken(int $tokenId): bool
    {
        return auth()->user()->tokens()->where('id', $tokenId)->delete() > 0;
    }

    public function revokeAllTokens(): int
    {
        return auth()->user()->tokens()->delete();
    }

    public function validateToken(string $token): ?ApiToken
    {
        $tokenModel = ApiToken::where('token', hash('sha256', $token))->first();

        if (!$tokenModel) {
            return null;
        }

        if ($tokenModel->expires_at && $tokenModel->expires_at->isPast()) {
            return null;
        }

        $tokenModel->update([
            'last_used_at' => now(),
            'last_used_ip' => request()->ip(),
        ]);

        return $tokenModel;
    }

    public function createApiKey(string $name, string $type = 'test', array $abilities = null): array
    {
        $plainKey = 'gsm_' . $type . '_' . Str::random(32);
        $keyHash = hash('sha256', $plainKey);
        $keyPrefix = substr($plainKey, 0, 12);

        $apiKey = auth()->user()->apiKeys()->create([
            'name' => $name,
            'key_hash' => $keyHash,
            'key_prefix' => $keyPrefix,
            'type' => $type,
            'abilities' => $abilities,
        ]);

        return [
            'id' => $apiKey->id,
            'name' => $name,
            'key' => $plainKey,
            'type' => $type,
            'created_at' => $apiKey->created_at,
        ];
    }

    public function validateApiKey(string $key): ?ApiKey
    {
        $keyHash = hash('sha256', $key);
        $apiKey = ApiKey::where('key_hash', $keyHash)->first();

        if (!$apiKey || $apiKey->revoked_at) {
            return null;
        }

        if ($apiKey->expires_at && $apiKey->expires_at->isPast()) {
            return null;
        }

        $apiKey->update([
            'last_used_at' => now(),
            'last_used_ip' => request()->ip(),
        ]);

        return $apiKey;
    }

    public function checkRateLimit(string $keyType, string $keyValue, string $window = 'minute'): bool
    {
        $limit = $this->getRateLimit($keyType, $window);
        $key = "api_rate:{$keyType}:{$keyValue}:{$window}";

        return RateLimiter::tooManyAttempts($key, $limit) === false;
    }

    public function incrementRateLimit(string $keyType, string $keyValue, string $window = 'minute'): void
    {
        $key = "api_rate:{$keyType}:{$keyValue}:{$window}";
        $decay = match ($window) {
            'minute' => 60,
            'hour' => 3600,
            'day' => 86400,
        };

        RateLimiter::hit($key, $decay);
    }

    protected function getRateLimit(string $keyType, string $window): int
    {
        return match ($window) {
            'minute' => match ($keyType) {
                'free' => 60,
                'pro' => 120,
                'enterprise' => 600,
                default => 60,
            },
            'hour' => match ($keyType) {
                'free' => 1000,
                'pro' => 5000,
                'enterprise' => 25000,
                default => 1000,
            },
            'day' => match ($keyType) {
                'free' => 10000,
                'pro' => 50000,
                'enterprise' => 250000,
                default => 10000,
            },
            default => 60,
        };
    }

    public function logRequest(array $data): void
    {
        ApiLog::create([
            'api_token_id' => $data['token_id'] ?? null,
            'api_key_id' => $data['key_id'] ?? null,
            'method' => $data['method'],
            'path' => $data['path'],
            'query_params' => $data['query_params'] ?? null,
            'request_body' => $data['request_body'] ?? null,
            'request_headers' => $data['request_headers'] ?? null,
            'response_status' => $data['response_status'],
            'response_body' => $data['response_body'] ?? null,
            'response_time_ms' => $data['response_time_ms'] ?? null,
            'ip_address' => $data['ip_address'] ?? request()->ip(),
            'user_agent' => $data['user_agent'] ?? request()->userAgent(),
            'user_id' => $data['user_id'] ?? auth()->id(),
            'api_version' => $data['api_version'] ?? null,
        ]);
    }

    public function getUsageStats(int $userId, int $days = 30): array
    {
        $from = now()->subDays($days);
        $tokens = auth()->user()->tokens()->pluck('id');
        $keys = auth()->user()->apiKeys()->pluck('id');

        $logs = ApiLog::where(function ($query) use ($tokens, $keys) {
            $query->whereIn('api_token_id', $tokens)
                  ->orWhereIn('api_key_id', $keys);
        })
        ->where('created_at', '>=', $from)
        ->get();

        $totalCalls = $logs->count();
        $callsByDay = $logs->groupBy(fn ($log) => $log->created_at->format('Y-m-d'))
            ->map(fn ($dayLogs) => $dayLogs->count())
            ->toArray();
        $callsByEndpoint = $logs->groupBy('path')
            ->map(fn ($endpointLogs) => $endpointLogs->count())
            ->sortDesc()
            ->take(10)
            ->toArray();
        $errorRate = $logs->where('response_status', '>=', 400)->count() / max($totalCalls, 1);
        $avgResponseTime = $logs->avg('response_time_ms');
        $callsByStatus = $logs->groupBy('response_status')
            ->map(fn ($statusLogs) => $statusLogs->count())
            ->toArray();

        return [
            'total_calls' => $totalCalls,
            'calls_by_day' => $callsByDay,
            'calls_by_endpoint' => $callsByEndpoint,
            'error_rate' => round($errorRate * 100, 2),
            'avg_response_time_ms' => round($avgResponseTime, 2),
            'calls_by_status' => $callsByStatus,
        ];
    }
}
```

## WebhookService

```php
<?php

namespace App\Services\Api;

use App\Models\ApiWebhook;
use App\Models\ApiWebhookDelivery;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class WebhookService
{
    public function create(array $data): ApiWebhook
    {
        return auth()->user()->webhooks()->create([
            'url' => $data['url'],
            'events' => $data['events'],
            'secret' => Str::random(40),
            'is_active' => $data['is_active'] ?? true,
        ]);
    }

    public function update(ApiWebhook $webhook, array $data): ApiWebhook
    {
        $webhook->update(collect($data)->only([
            'url', 'events', 'is_active',
        ])->toArray());

        return $webhook;
    }

    public function delete(ApiWebhook $webhook): bool
    {
        return $webhook->delete() > 0;
    }

    public function trigger(string $event, array $payload): void
    {
        $webhooks = ApiWebhook::where('is_active', true)
            ->whereJsonContains('events', $event)
            ->get();

        foreach ($webhooks as $webhook) {
            $this->deliver($webhook, $event, $payload);
        }
    }

    protected function deliver(ApiWebhook $webhook, string $event, array $payload): void
    {
        $body = json_encode([
            'event' => $event,
            'created_at' => now()->toIso8601String(),
            'data' => $payload,
        ]);

        $signature = hash_hmac('sha256', $body, $webhook->secret);

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'X-GsmUi-Signature' => $signature,
            'X-GsmUi-Event' => $event,
        ])->timeout(10)->post($webhook->url, $body);

        $delivery = ApiWebhookDelivery::create([
            'webhook_id' => $webhook->id,
            'event' => $event,
            'payload' => $payload,
            'response_status' => $response->status(),
            'response_body' => $response->body(),
            'delivered_at' => now(),
        ]);

        if ($response->failed()) {
            $webhook->increment('failure_count');
            if ($webhook->failure_count >= 10) {
                $webhook->update(['is_active' => false]);
            }
        } else {
            $webhook->update([
                'failure_count' => 0,
                'last_triggered_at' => now(),
            ]);
        }
    }

    public function verifySignature(string $payload, string $signature, string $secret): bool
    {
        $expected = hash_hmac('sha256', $payload, $secret);
        return hash_equals($expected, $signature);
    }

    public function getDeliveries(ApiWebhook $webhook, int $limit = 50): \Illuminate\Support\Collection
    {
        return $webhook->deliveries()
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    public function retryDelivery(ApiWebhookDelivery $delivery): bool
    {
        $webhook = $delivery->webhook;
        return $this->deliver($webhook, $delivery->event, $delivery->payload);
    }
}
```

---

# API Controllers

## ApiController

```php
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Api\ApiService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function __construct(
        protected ApiService $apiService
    ) {}

    public function index(Request $request): JsonResponse
    {
        $tokens = $request->user()->tokens()->get();
        $keys = $request->user()->apiKeys()->get();

        return response()->json([
            'tokens' => $tokens->map(fn ($t) => [
                'id' => $t->id,
                'name' => $t->name,
                'abilities' => $t->abilities,
                'last_used_at' => $t->last_used_at,
                'expires_at' => $t->expires_at,
            ]),
            'keys' => $keys->map(fn ($k) => [
                'id' => $k->id,
                'name' => $k->name,
                'type' => $k->type,
                'key_prefix' => $k->key_prefix,
                'last_used_at' => $k->last_used_at,
                'is_active' => is_null($k->revoked_at),
            ]),
        ]);
    }

    public function storeToken(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $result = $this->apiService->createToken($request->input('name'));

        return response()->json($result, 201);
    }

    public function destroyToken(Request $request, int $tokenId): JsonResponse
    {
        $this->apiService->revokeToken($tokenId);
        return response()->json(null, 204);
    }

    public function storeKey(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:live,test',
        ]);

        $result = $this->apiService->createKey(
            $request->input('name'),
            $request->input('type')
        );

        return response()->json($result, 201);
    }

    public function destroyKey(Request $request, int $keyId): JsonResponse
    {
        $key = $request->user()->apiKeys()->findOrFail($keyId);
        $key->update(['revoked_at' => now()]);
        return response()->json(null, 204);
    }

    public function usage(Request $request): JsonResponse
    {
        $stats = $this->apiService->getUsageStats(
            $request->user()->id,
            $request->input('days', 30)
        );

        return response()->json($stats);
    }
}
```

## ComponentApiController

```php
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Component;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ComponentApiController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Component::with(['category', 'author'])
            ->where('status', 'published');

        if ($request->has('filter')) {
            $filters = $request->input('filter');
            if (isset($filters['category'])) {
                $query->where('category_id', $filters['category']);
            }
            if (isset($filters['search'])) {
                $query->where('name', 'LIKE', "%{$filters['search']}%");
            }
        }

        $sort = $request->input('sort', '-created_at');
        $direction = str_starts_with($sort, '-') ? 'desc' : 'asc';
        $field = ltrim($sort, '-');
        $query->orderBy($field, $direction);

        $perPage = min($request->input('per_page', 20), 100);
        $components = $query->paginate($perPage);

        return response()->json([
            'data' => $components->map(fn ($c) => [
                'id' => $c->uuid,
                'type' => 'component',
                'attributes' => [
                    'name' => $c->name,
                    'description' => $c->description,
                    'category' => $c->category->name,
                    'version' => $c->version,
                    'status' => $c->status,
                    'author' => $c->author->name,
                    'created_at' => $c->created_at->toIso8601String(),
                ],
            ]),
            'meta' => [
                'total' => $components->total(),
                'per_page' => $components->perPage(),
                'current_page' => $components->currentPage(),
                'last_page' => $components->lastPage(),
            ],
            'links' => [
                'self' => $components->url($components->currentPage()),
                'next' => $components->nextUrl(),
                'prev' => $components->previousUrl(),
            ],
        ]);
    }

    public function show(string $id): JsonResponse
    {
        $component = Component::with(['category', 'author', 'examples'])
            ->where('uuid', $id)
            ->firstOrFail();

        return response()->json([
            'data' => [
                'id' => $component->uuid,
                'type' => 'component',
                'attributes' => [
                    'name' => $component->name,
                    'description' => $component->description,
                    'category' => $component->category->name,
                    'version' => $component->version,
                    'status' => $component->status,
                    'author' => $component->author->name,
                    'documentation' => $component->documentation,
                    'created_at' => $component->created_at->toIso8601String(),
                ],
                'relationships' => [
                    'category' => [
                        'data' => [
                            'type' => 'category',
                            'id' => $component->category->uuid,
                        ],
                    ],
                ],
            ],
        ]);
    }

    public function docs(string $id): JsonResponse
    {
        $component = Component::where('uuid', $id)->firstOrFail();

        return response()->json([
            'data' => [
                'id' => $component->uuid,
                'type' => 'documentation',
                'attributes' => [
                    'content' => $component->documentation,
                    'api_reference' => $component->api_reference,
                    'examples' => $component->examples->toArray(),
                ],
            ],
        ]);
    }

    public function examples(string $id): JsonResponse
    {
        $component = Component::where('uuid', $id)->firstOrFail();

        return response()->json([
            'data' => $component->examples->map(fn ($example) => [
                'id' => $example->id,
                'type' => 'example',
                'attributes' => [
                    'title' => $example->title,
                    'code' => $example->code,
                    'preview' => $example->preview_html,
                ],
            ]),
        ]);
    }
}
```

---

# API Middleware

## ApiVersionMiddleware

```php
<?php

namespace App\Http\Middleware\Api;

use Closure;
use Illuminate\Http\Request;

class ApiVersionMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $version = $request->header('X-GsmUi-Version', config('api.default_version'));

        if (!in_array($version, config('api.supported_versions'))) {
            return response()->json([
                'errors' => [['status' => '400', 'title' => 'Unsupported API version']],
            ], 400);
        }

        $request->merge(['api_version' => $version]);

        return $next($request);
    }
}
```

## ApiRateLimitMiddleware

```php
<?php

namespace App\Http\Middleware\Api;

use Closure;
use Illuminate\Http\Request;
use App\Services\Api\ApiService;

class ApiRateLimitMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $apiService = app(ApiService::class);

        $keyType = $this->getKeyType($request);
        $keyValue = $this->getKeyValue($request);

        if (!$apiService->checkRateLimit($keyType, $keyValue, 'minute')) {
            return response()->json([
                'errors' => [['status' => '429', 'title' => 'Rate limit exceeded']],
            ], 429)->withHeaders([
                'X-RateLimit-Limit' => config("api.rate_limits.{$keyType}.minute"),
                'X-RateLimit-Remaining' => 0,
                'X-RateLimit-Reset' => now()->addMinute()->timestamp,
            ]);
        }

        $apiService->incrementRateLimit($keyType, $keyValue, 'minute');

        $response = $next($request);

        return $response->withHeaders([
            'X-RateLimit-Limit' => config("api.rate_limits.{$keyType}.minute"),
            'X-RateLimit-Remaining' => $this->getRemaining($keyType, $keyValue),
            'X-RateLimit-Reset' => now()->addMinute()->timestamp,
        ]);
    }

    protected function getKeyType(Request $request): string
    {
        if ($request->user()) {
            return $request->user()->subscription_plan ?? 'free';
        }
        return 'ip';
    }

    protected function getKeyValue(Request $request): string
    {
        if ($request->user()) {
            return (string) $request->user()->id;
        }
        return $request->ip();
    }

    protected function getRemaining(string $keyType, string $keyValue): int
    {
        $limit = config("api.rate_limits.{$keyType}.minute", 60);
        $key = "api_rate:{$keyType}:{$keyValue}:minute";
        $attempts = \Illuminate\Support\Facades\RateLimiter::attempts($key);
        return max(0, $limit - $attempts);
    }
}
```

## ApiLogMiddleware

```php
<?php

namespace App\Http\Middleware\Api;

use Closure;
use Illuminate\Http\Request;
use App\Services\Api\ApiService;

class ApiLogMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $startTime = microtime(true);

        $response = $next($request);

        $endTime = microtime(true);
        $responseTimeMs = round(($endTime - $startTime) * 1000, 2);

        if (config('api.logging.enabled')) {
            app(ApiService::class)->logRequest([
                'token_id' => $request->user()?->currentAccessToken()?->id,
                'key_id' => $request->input('api_key_id'),
                'method' => $request->method(),
                'path' => $request->path(),
                'query_params' => $request->query(),
                'request_body' => $request->except(['password', 'token', 'secret']),
                'response_status' => $response->getStatusCode(),
                'response_time_ms' => $responseTimeMs,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'user_id' => $request->user()?->id,
                'api_version' => $request->input('api_version'),
            ]);
        }

        return $response;
    }
}
```

---

# API Routes

```php
<?php

use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Api\ComponentApiController;
use App\Http\Controllers\Api\DocApiController;
use App\Http\Controllers\Api\TemplateApiController;
use App\Http\Controllers\Api\ThemeApiController;
use App\Http\Controllers\Api\SearchApiController;
use App\Http\Controllers\Api\UserApiController;
use App\Http\Controllers\Api\MarketplaceApiController;
use App\Http\Controllers\Api\WebhookController;
use Illuminate\Support\Facades\Route;

Route::prefix('api/v1')->middleware(['api.version', 'api.log'])->group(function () {
    // Public endpoints
    Route::get('/components', [ComponentApiController::class, 'index']);
    Route::get('/components/{id}', [ComponentApiController::class, 'show']);
    Route::get('/components/{id}/docs', [ComponentApiController::class, 'docs']);
    Route::get('/components/{id}/examples', [ComponentApiController::class, 'examples']);

    Route::get('/docs', [DocApiController::class, 'index']);
    Route::get('/docs/{slug}', [DocApiController::class, 'show']);
    Route::get('/docs/search', [DocApiController::class, 'search']);

    Route::get('/templates', [TemplateApiController::class, 'index']);
    Route::get('/templates/{id}', [TemplateApiController::class, 'show']);

    Route::get('/themes', [ThemeApiController::class, 'index']);
    Route::get('/themes/{id}', [ThemeApiController::class, 'show']);
    Route::get('/themes/{id}/tokens', [ThemeApiController::class, 'tokens']);

    Route::get('/search', [SearchApiController::class, 'index']);
    Route::get('/search/components', [SearchApiController::class, 'components']);
    Route::get('/search/docs', [SearchApiController::class, 'docs']);

    // Authenticated endpoints
    Route::middleware(['auth:sanctum', 'api.rate_limit'])->group(function () {
        // User
        Route::get('/user/profile', [UserApiController::class, 'profile']);
        Route::put('/user/profile', [UserApiController::class, 'updateProfile']);
        Route::get('/user/subscriptions', [UserApiController::class, 'subscriptions']);
        Route::get('/user/downloads', [UserApiController::class, 'downloads']);

        // API management
        Route::get('/api/keys', [ApiController::class, 'index']);
        Route::post('/api/tokens', [ApiController::class, 'storeToken']);
        Route::delete('/api/tokens/{id}', [ApiController::class, 'destroyToken']);
        Route::post('/api/keys', [ApiController::class, 'storeKey']);
        Route::delete('/api/keys/{id}', [ApiController::class, 'destroyKey']);
        Route::get('/api/usage', [ApiController::class, 'usage']);

        // Marketplace
        Route::get('/marketplace/products', [MarketplaceApiController::class, 'index']);
        Route::get('/marketplace/products/{id}', [MarketplaceApiController::class, 'show']);
        Route::post('/marketplace/orders', [MarketplaceApiController::class, 'createOrder']);

        // Webhooks
        Route::get('/webhooks', [WebhookController::class, 'index']);
        Route::post('/webhooks', [WebhookController::class, 'store']);
        Route::put('/webhooks/{webhook}', [WebhookController::class, 'update']);
        Route::delete('/webhooks/{webhook}', [WebhookController::class, 'destroy']);
        Route::get('/webhooks/{webhook}/deliveries', [WebhookController::class, 'deliveries']);
    });
});
```

---

# API Form Requests

## StoreTokenRequest

```php
<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class StoreTokenRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Token name is required.',
            'name.max' => 'Token name must not exceed 255 characters.',
        ];
    }
}
```

## StoreApiKeyRequest

```php
<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class StoreApiKeyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'type' => 'required|in:live,test',
            'abilities' => 'nullable|array',
            'expires_at' => 'nullable|date|after:now',
        ];
    }
}
```

---

# API Error Handling

## Error Responses

```json
{
  "errors": [
    {
      "status": "401",
      "title": "Unauthenticated",
      "detail": "Invalid or missing API token."
    }
  ]
}
```

## Error Codes

| Code | Title | Description |
|------|-------|-------------|
| 400 | Bad Request | Invalid request format |
| 401 | Unauthenticated | Missing or invalid credentials |
| 403 | Forbidden | Insufficient permissions |
| 404 | Not Found | Resource does not exist |
| 405 | Method Not Allowed | HTTP method not supported |
| 409 | Conflict | Resource already exists |
| 422 | Validation Error | Invalid input data |
| 429 | Too Many Requests | Rate limit exceeded |
| 500 | Server Error | Internal server error |
| 503 | Service Unavailable | Service temporarily down |

---

# API Caching Strategy

| Endpoint | TTL | Cache Key Pattern |
|----------|-----|-------------------|
| GET /components | 15 min | `api:components:{page}:{filters}` |
| GET /components/{id} | 1 hour | `api:component:{id}` |
| GET /docs | 15 min | `api:docs:{page}` |
| GET /docs/{slug} | 1 hour | `api:doc:{slug}` |
| GET /templates | 15 min | `api:templates:{page}` |
| GET /themes | 15 min | `api:themes:{page}` |
| GET /user/profile | 5 min | `api:user:{id}:profile` |
| GET /search | 5 min | `api:search:{query}` |

---

# API Testing Strategy

## Unit Tests

* Token creation and validation
* API key creation and validation
* Rate limit logic
* Webhook signature verification
* Log creation

## Feature Tests

* All endpoint responses
* Authentication flows
* Rate limiting behavior
* Pagination
* Filtering and sorting
* Error responses

## Integration Tests

* Webhook delivery pipeline
* API version routing
* Cache behavior
* Queue job processing

---

# API Security

* HTTPS enforced on all endpoints
* CORS configured for allowed origins
* CSRF disabled for API routes
* Input validation on all endpoints
* SQL injection prevention via Eloquent
* XSS prevention via JSON responses
* Rate limiting per user/IP
* Request logging for audit trail
* Token/key hashing (never stored plaintext)
* Webhook signature verification

---

# API Configuration

```php
// config/api.php

return [
    'default_version' => env('API_DEFAULT_VERSION', '2024-01-15'),
    'supported_versions' => [
        '2024-01-15',
        '2023-06-01',
    ],
    'rate_limits' => [
        'free' => [
            'minute' => 60,
            'hour' => 1000,
            'day' => 10000,
        ],
        'pro' => [
            'minute' => 120,
            'hour' => 5000,
            'day' => 50000,
        ],
        'enterprise' => [
            'minute' => 600,
            'hour' => 25000,
            'day' => 250000,
        ],
    ],
    'logging' => [
        'enabled' => env('API_LOGGING', true),
        'retention_days' => 30,
    ],
    'cors' => [
        'allowed_origins' => ['*'],
        'allowed_methods' => ['GET', 'POST', 'PUT', 'DELETE', 'PATCH'],
        'allowed_headers' => ['*'],
        'max_age' => 86400,
    ],
    'webhooks' => [
        'max_per_user' => 10,
        'timeout' => 10,
        'max_retries' => 3,
        'disable_threshold' => 10,
    ],
];
```

---

# API Resources

## ComponentResource

```php
<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class ComponentResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->uuid,
            'type' => 'component',
            'attributes' => [
                'name' => $this->name,
                'slug' => $this->slug,
                'description' => $this->description,
                'category' => $this->category->name,
                'version' => $this->version,
                'status' => $this->status,
                'author' => $this->author->name,
                'downloads' => $this->downloads_count,
                'rating' => $this->rating,
                'preview_url' => $this->preview_url,
                'created_at' => $this->created_at->toIso8601String(),
                'updated_at' => $this->updated_at->toIso8601String(),
            ],
            'relationships' => [
                'category' => [
                    'data' => ['type' => 'category', 'id' => $this->category->uuid],
                ],
                'author' => [
                    'data' => ['type' => 'user', 'id' => $this->author->uuid],
                ],
            ],
            'links' => [
                'self' => route('api.v1.components.show', $this->uuid),
                'docs' => route('api.v1.components.docs', $this->uuid),
                'examples' => route('api.v1.components.examples', $this->uuid),
            ],
        ];
    }
}
```

## TemplateResource

```php
<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class TemplateResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->uuid,
            'type' => 'template',
            'attributes' => [
                'name' => $this->name,
                'slug' => $this->slug,
                'description' => $this->description,
                'price' => $this->price,
                'currency' => $this->currency,
                'version' => $this->version,
                'status' => $this->status,
                'author' => $this->author->name,
                'preview_url' => $this->preview_url,
                'download_url' => $this->download_url,
                'tags' => $this->tags->pluck('name'),
                'created_at' => $this->created_at->toIso8601String(),
                'updated_at' => $this->updated_at->toIso8601String(),
            ],
            'relationships' => [
                'author' => [
                    'data' => ['type' => 'user', 'id' => $this->author->uuid],
                ],
            ],
            'links' => [
                'self' => route('api.v1.templates.show', $this->uuid),
                'download' => route('api.v1.templates.download', $this->uuid),
            ],
        ];
    }
}
```

## ThemeResource

```php
<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class ThemeResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->uuid,
            'type' => 'theme',
            'attributes' => [
                'name' => $this->name,
                'slug' => $this->slug,
                'description' => $this->description,
                'price' => $this->price,
                'currency' => $this->currency,
                'version' => $this->version,
                'status' => $this->status,
                'author' => $this->author->name,
                'preview_url' => $this->preview_url,
                'colors' => $this->colors,
                'typography' => $this->typography,
                'created_at' => $this->created_at->toIso8601String(),
                'updated_at' => $this->updated_at->toIso8601String(),
            ],
            'links' => [
                'self' => route('api.v1.themes.show', $this->uuid),
                'tokens' => route('api.v1.themes.tokens', $this->uuid),
            ],
        ];
    }
}
```

---

# API Versioning Strategy

## Version Header Handling

```php
<?php

namespace App\Http\Middleware\Api;

use Closure;
use Illuminate\Http\Request;

class ApiVersionMiddleware
{
    protected array $supportedVersions = [
        '2024-01-15' => '2024-01-15',
        '2023-06-01' => '2023-06-01',
    ];

    protected string $defaultVersion = '2024-01-15';
    protected string $deprecatedVersion = '2023-06-01';

    public function handle(Request $request, Closure $next)
    {
        $version = $request->header('X-GsmUi-Version', $this->defaultVersion);

        if (!isset($this->supportedVersions[$version])) {
            return response()->json([
                'errors' => [[
                    'status' => '400',
                    'title' => 'Unsupported API version',
                    'detail' => "Version '{$version}' is not supported. Supported versions: " . implode(', ', array_keys($this->supportedVersions)),
                ]],
            ], 400);
        }

        $request->merge(['api_version' => $version]);

        $response = $next($request);

        $response->headers->set('X-GsmUi-Version', $version);

        if ($version === $this->deprecatedVersion) {
            $response->headers->set('Deprecation', 'true');
            $response->headers->set('Sunset', now()->addMonths(6)->toRfc7231String());
            $response->headers->set('Link', '<' . url('/api/v1/docs/migration/2024-01-15') . '>; rel="successor-version"');
        }

        return $response;
    }
}
```

## Version Deprecation Notifications

```php
<?php

namespace App\Services\Api;

class VersionDeprecationService
{
    public function notifyDeprecation(string $version, string $newVersion): void
    {
        $users = DB::table('api_logs')
            ->where('api_version', $version)
            ->where('created_at', '>=', now()->subDays(30))
            ->pluck('user_id')
            ->unique();

        foreach ($users as $userId) {
            $user = User::find($userId);
            if ($user) {
                $user->notify(new ApiVersionDeprecationNotification($version, $newVersion));
            }
        }
    }

    public function getUsageByVersion(int $days = 30): array
    {
        return DB::table('api_logs')
            ->where('created_at', '>=', now()->subDays($days))
            ->select('api_version', DB::raw('count(*) as usage_count'))
            ->groupBy('api_version')
            ->get()
            ->pluck('usage_count', 'api_version')
            ->toArray();
    }
}
```

---

# API Transform Layer

## JsonApiTransformer

```php
<?php

namespace App\Services\Api\Transformers;

class JsonApiTransformer
{
    public function transform($data, string $type): array
    {
        if ($data instanceof \Illuminate\Database\Eloquent\Collection) {
            return $this->transformCollection($data, $type);
        }

        return $this->transformResource($data, $type);
    }

    protected function transformResource($model, string $type): array
    {
        return [
            'id' => $model->uuid ?? $model->id,
            'type' => $type,
            'attributes' => $this->getAttributes($model),
            'relationships' => $this->getRelationships($model),
            'links' => $this->getLinks($model, $type),
        ];
    }

    protected function transformCollection($collection, string $type): array
    {
        return $collection->map(fn ($model) => $this->transformResource($model, $type))->toArray();
    }

    protected function getAttributes($model): array
    {
        $attributes = $model->toArray();
        unset($attributes['id']);
        return $attributes;
    }

    protected function getRelationships($model): array
    {
        $relationships = [];
        $relations = $model->getRelations();

        foreach ($relations as $name => $relation) {
            if ($relation instanceof \Illuminate\Database\Eloquent\Model) {
                $relationships[$name] = [
                    'data' => [
                        'type' => $name,
                        'id' => $relation->uuid ?? $relation->id,
                    ],
                ];
            } elseif ($relation instanceof \Illuminate\Database\Eloquent\Collection) {
                $relationships[$name] = [
                    'data' => $relation->map(fn ($r) => [
                        'type' => $name,
                        'id' => $r->uuid ?? $r->id,
                    ])->toArray(),
                ];
            }
        }

        return $relationships;
    }

    protected function getLinks($model, string $type): array
    {
        $id = $model->uuid ?? $model->id;
        return [
            'self' => "/api/v1/{$type}s/{$id}",
        ];
    }
}
```

---

# API Action Classes

## CreateComponentAction

```php
<?php

namespace App\Services\Api\Actions;

use App\Models\Component;
use App\Events\Components\ComponentCreated;
use Illuminate\Support\Facades\DB;

class CreateComponentAction
{
    public function execute(array $data, int $userId): Component
    {
        return DB::transaction(function () use ($data, $userId) {
            $component = Component::create([
                'uuid' => \Illuminate\Support\Str::uuid(),
                'name' => $data['name'],
                'slug' => $this->generateSlug($data['name']),
                'description' => $data['description'] ?? null,
                'category_id' => $data['category_id'],
                'author_id' => $userId,
                'version' => $data['version'] ?? '1.0.0',
                'status' => 'draft',
                'documentation' => $data['documentation'] ?? null,
                'code' => $data['code'] ?? null,
            ]);

            event(new ComponentCreated($component->id, $component->toArray()));

            return $component;
        });
    }

    protected function generateSlug(string $name): string
    {
        $slug = \Illuminate\Support\Str::slug($name);
        $original = $slug;
        $counter = 1;
        while (Component::where('slug', $slug)->exists()) {
            $slug = "{$original}-{$counter}";
            $counter++;
        }
        return $slug;
    }
}
```

## PublishComponentAction

```php
<?php

namespace App\Services\Api\Actions;

use App\Models\Component;
use App\Events\Components\ComponentPublished;
use Illuminate\Support\Facades\DB;

class PublishComponentAction
{
    public function execute(Component $component): Component
    {
        return DB::transaction(function () use ($component) {
            $component->update([
                'status' => 'published',
                'published_at' => now(),
            ]);

            event(new ComponentPublished($component->id, $component->toArray()));

            return $component;
        });
    }
}
```

## PurchaseTemplateAction

```php
<?php

namespace App\Services\Api\Actions;

use App\Models\Template;
use App\Models\Order;
use App\Events\Marketplace\TemplatePurchased;
use App\Events\Marketplace\OrderCreated;
use App\Events\Marketplace\OrderCompleted;
use Illuminate\Support\Facades\DB;

class PurchaseTemplateAction
{
    public function execute(Template $template, int $userId, array $paymentData): Order
    {
        return DB::transaction(function () use ($template, $userId, $paymentData) {
            $order = Order::create([
                'user_id' => $userId,
                'product_type' => 'template',
                'product_id' => $template->id,
                'amount' => $template->price,
                'currency' => $template->currency,
                'payment_method' => $paymentData['payment_method'],
                'payment_id' => $paymentData['payment_id'],
                'status' => 'completed',
                'completed_at' => now(),
            ]);

            event(new OrderCreated($order->id, $order->toArray()));
            event(new OrderCompleted($order->id, $order->toArray()));
            event(new TemplatePurchased($template->id, [
                'user_id' => $userId,
                'order_id' => $order->id,
                'amount' => $template->price,
                'license_type' => 'pro',
            ]));

            return $order;
        });
    }
}
```

---

# API Testing

## Postman Collection Structure

```json
{
  "info": {
    "name": "GsmUi API v1",
    "description": "Complete API collection for GsmUi platform",
    "version": "1.0.0"
  },
  "item": [
    {
      "name": "Authentication",
      "item": [
        {
          "name": "Create Token",
          "request": {
            "method": "POST",
            "url": "{{base_url}}/api/v1/tokens",
            "body": {
              "mode": "raw",
              "raw": "{\"name\": \"Test Token\"}"
            }
          }
        }
      ]
    },
    {
      "name": "Components",
      "item": [
        {
          "name": "List Components",
          "request": {
            "method": "GET",
            "url": {
              "raw": "{{base_url}}/api/v1/components?page=1&per_page=20",
              "host": ["{{base_url}}"],
              "path": ["api", "v1", "components"],
              "query": [
                {"key": "page", "value": "1"},
                {"key": "per_page", "value": "20"}
              ]
            }
          }
        },
        {
          "name": "Get Component",
          "request": {
            "method": "GET",
            "url": {
              "raw": "{{base_url}}/api/v1/components/{{component_id}}",
              "host": ["{{base_url}}"],
              "path": ["api", "v1", "components", "{{component_id}}"]
            }
          }
        }
      ]
    }
  ],
  "variable": [
    {"key": "base_url", "value": "https://api.gsmui.com"},
    {"key": "component_id", "value": "comp_abc123"},
    {"key": "api_token", "value": ""}
  ]
}
```

---

# API Documentation

## OpenAPI Specification (Partial)

```yaml
openapi: 3.0.3
info:
  title: GsmUi API
  description: RESTful API for GsmUi platform integration
  version: 1.0.0
  contact:
    name: GsmUi Support
    email: api@gsmui.com

servers:
  - url: https://api.gsmui.com/api/v1
    description: Production
  - url: https://staging-api.gsmui.com/api/v1
    description: Staging

security:
  - BearerAuth: []
  - ApiKeyAuth: []

components:
  securitySchemes:
    BearerAuth:
      type: http
      scheme: bearer
      bearerFormat: JWT
    ApiKeyAuth:
      type: apiKey
      in: header
      name: X-GsmUi-Key

  schemas:
    Component:
      type: object
      properties:
        id:
          type: string
          format: uuid
        type:
          type: string
          enum: [component]
        attributes:
          type: object
          properties:
            name:
              type: string
            description:
              type: string
            category:
              type: string
            version:
              type: string
            status:
              type: string
              enum: [draft, published, archived]

    Error:
      type: object
      properties:
        errors:
          type: array
          items:
            type: object
            properties:
              status:
                type: string
              title:
                type: string
              detail:
                type: string

paths:
  /components:
    get:
      summary: List components
      tags: [Components]
      parameters:
        - name: page
          in: query
          schema:
            type: integer
            default: 1
        - name: per_page
          in: query
          schema:
            type: integer
            default: 20
            maximum: 100
        - name: sort
          in: query
          schema:
            type: string
            enum: [created_at, -created_at, name, -name]
        - name: filter[category]
          in: query
          schema:
            type: string
      responses:
        '200':
          description: Paginated list of components
          content:
            application/json:
              schema:
                type: object
                properties:
                  data:
                    type: array
                    items:
                      $ref: '#/components/schemas/Component'
                  meta:
                    type: object
                    properties:
                      total:
                        type: integer
                      per_page:
                        type: integer
                      current_page:
                        type: integer
                      last_page:
                        type: integer

  /components/{id}:
    get:
      summary: Get component
      tags: [Components]
      parameters:
        - name: id
          in: path
          required: true
          schema:
            type: string
      responses:
        '200':
          description: Component details
        '404':
          description: Component not found
```

---

# API Error Tracking

## Sentry Integration

```php
<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ApiErrorTrackingProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->afterResolving('kernel', function ($kernel) {
            $kernel->pushMiddleware(function ($request, $next) {
                try {
                    return $next($request);
                } catch (\Exception $e) {
                    if ($request->is('api/*')) {
                        \Sentry\configureScope(function (\Sentry\State\Hub $scope) use ($request) {
                            $scope->setTag('api_version', $request->input('api_version'));
                            $scope->setUser([
                                'id' => $request->user()?->id,
                                'email' => $request->user()?->email,
                            ]);
                            $scope->setExtra('request_data', $request->all());
                        });

                        \Sentry\captureException($e);
                    }

                    throw $e;
                }
            });
        });
    }
}
```

---

# Next Document

**28 - Events** — Domain event system architecture.
