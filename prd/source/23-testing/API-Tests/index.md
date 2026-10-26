# API Testing

> PRD — Volume 23: Quality Assurance — API Testing

## Overview

API testing validates RESTful endpoints including authentication, rate limiting, response validation, and contract testing for the gsmui platform API.

## Objectives

| Goal | Metric | Target |
|------|--------|--------|
| Endpoint coverage | All API endpoints tested | 100% |
| Authentication | All auth flows verified | 100% |
| Response format | Consistent JSON responses | 100% |
| Rate limiting | Limits enforced correctly | 100% |
| Contract compliance | API matches documentation | 100% |

## Endpoint Testing

### API Test Structure

```php
class PageApiTest extends TestCase
{
    public function test_it_lists_pages(): void
    {
        Page::factory()->count(5)->published()->create();

        $response = $this->getJson('/api/pages');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'title', 'slug', 'status'],
                ],
                'links' => ['first', 'last', 'prev', 'next'],
                'meta' => ['current_page', 'last_page', 'per_page', 'total'],
            ]);
    }

    public function test_it_returns_single_page(): void
    {
        $page = Page::factory()->published()->create();

        $response = $this->getJson("/api/pages/{$page->id}");

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $page->id,
                    'title' => $page->title,
                ],
            ]);
    }

    public function test_it_creates_page(): void
    {
        $this->actingAsAdmin();

        $response = $this->postJson('/api/pages', [
            'title' => 'New API Page',
            'slug' => 'new-api-page',
            'type' => 'static',
            'content' => 'API content',
        ]);

        $response->assertStatus(201)
            ->assertJsonStructure(['data' => ['id', 'title', 'slug']]);

        $this->assertDatabaseHas('pages', ['slug' => 'new-api-page']);
    }

    public function test_it_updates_page(): void
    {
        $this->actingAsAdmin();
        $page = Page::factory()->create();

        $response = $this->putJson("/api/pages/{$page->id}", [
            'title' => 'Updated Title',
        ]);

        $response->assertStatus(200)
            ->assertJson(['data' => ['title' => 'Updated Title']]);
    }

    public function test_it_deletes_page(): void
    {
        $this->actingAsAdmin();
        $page = Page::factory()->create();

        $response = $this->deleteJson("/api/pages/{$page->id}");

        $response->assertStatus(204);
        $this->assertSoftDeleted('pages', ['id' => $page->id]);
    }
}
```

## Authentication

### Token-Based Auth Tests

```php
class ApiAuthenticationTest extends TestCase
{
    public function test_it_authenticates_with_valid_token(): void
    {
        $user = User::factory()->create();
        $token = $user->createToken('test-token')->plainTextToken;

        $response = $this->getJson('/api/user', [
            'Authorization' => "Bearer {$token}",
        ]);

        $response->assertStatus(200)
            ->assertJson(['data' => ['id' => $user->id]]);
    }

    public function test_it_rejects_invalid_token(): void
    {
        $response = $this->getJson('/api/user', [
            'Authorization' => 'Bearer invalid-token',
        ]);

        $response->assertStatus(401);
    }

    public function test_it_rejects_missing_token(): void
    {
        $response = $this->getJson('/api/user');

        $response->assertStatus(401);
    }

    public function test_it_revokes_token_on_logout(): void
    {
        $user = User::factory()->create();
        $token = $user->createToken('test-token')->plainTextToken;

        $this->deleteJson('/api/logout', [], [
            'Authorization' => "Bearer {$token}",
        ]);

        $this->assertDatabaseMissing('personal_access_tokens', [
            'token' => hash('sha256', $token),
        ]);
    }
}
```

## Rate Limiting

```php
class RateLimitingTest extends TestCase
{
    public function test_api_rate_limit_is_enforced(): void
    {
        $user = User::factory()->create();
        $token = $user->createToken('test-token')->plainTextToken;

        // Make requests up to the limit
        for ($i = 0; $i < 60; $i++) {
            $this->getJson('/api/pages', [
                'Authorization' => "Bearer {$token}",
            ]);
        }

        // Next request should be rate limited
        $response = $this->getJson('/api/pages', [
            'Authorization' => "Bearer {$token}",
        ]);

        $response->assertStatus(429)
            ->assertJson(['message' => 'Too many requests.']);
    }

    public function test_rate_limit_headers_are_present(): void
    {
        $user = User::factory()->create();
        $token = $user->createToken('test-token')->plainTextToken;

        $response = $this->getJson('/api/pages', [
            'Authorization' => "Bearer {$token}",
        ]);

        $response->assertHeader('X-RateLimit-Limit', '60');
        $response->assertHeader('X-RateLimit-Remaining', '59');
    }
}
```

## Response Validation

### JSON Schema Validation

```php
class ApiResponseValidationTest extends TestCase
{
    public function test_page_response_has_correct_schema(): void
    {
        $page = Page::factory()->published()->create();

        $response = $this->getJson("/api/pages/{$page->id}");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'title',
                    'slug',
                    'excerpt',
                    'content',
                    'status',
                    'type',
                    'seo' => ['meta_title', 'meta_description'],
                    'author' => ['id', 'name'],
                    'categories' => [
                        '*' => ['id', 'name', 'slug'],
                    ],
                    'created_at',
                    'updated_at',
                ],
            ]);
    }

    public function test_error_response_has_correct_schema(): void
    {
        $response = $this->getJson('/api/pages/999999');

        $response->assertStatus(404)
            ->assertJsonStructure([
                'message',
                'errors',
            ]);
    }

    public function test_validation_error_has_correct_schema(): void
    {
        $this->actingAsAdmin();

        $response = $this->postJson('/api/pages', []);

        $response->assertStatus(422)
            ->assertJsonStructure([
                'message',
                'errors' => [
                    'title' => ['*'],
                    'slug' => ['*'],
                ],
            ]);
    }
}
```

### Content-Type Validation

```php
class ContentTypeTest extends TestCase
{
    public function test_api_returns_json(): void
    {
        $response = $this->getJson('/api/pages');

        $response->assertHeader('Content-Type', 'application/json');
    }

    public function test_api_rejects_xml(): void
    {
        $response = $this->get('/api/pages', [], [
            'Accept' => 'application/xml',
        ]);

        $response->assertStatus(406);
    }
}
```

## Contract Testing

### API Contract Definition

```yaml
# openapi.yaml (abbreviated)
openapi: 3.0.0
paths:
  /api/pages:
    get:
      summary: List pages
      responses:
        '200':
          content:
            application/json:
              schema:
                type: object
                properties:
                  data:
                    type: array
                    items:
                      $ref: '#/components/schemas/Page'
                  meta:
                    $ref: '#/components/schemas/PaginationMeta'
    post:
      summary: Create page
      requestBody:
        required: true
        content:
          application/json:
            schema:
              $ref: '#/components/schemas/CreatePageRequest'
      responses:
        '201':
          content:
            application/json:
              schema:
                $ref: '#/components/schemas/Page'

components:
  schemas:
    Page:
      type: object
      properties:
        id:
          type: integer
        title:
          type: string
        slug:
          type: string
        status:
          type: string
          enum: [draft, published, archived]
```

### Contract Test

```php
class PageApiContractTest extends TestCase
{
    public function test_list_pages_matches_contract(): void
    {
        Page::factory()->count(3)->published()->create();

        $response = $this->getJson('/api/pages');

        $response->assertStatus(200);
        $data = $response->json('data');

        $this->assertIsArray($data);
        foreach ($data as $page) {
            $this->assertArrayHasKey('id', $page);
            $this->assertArrayHasKey('title', $page);
            $this->assertArrayHasKey('slug', $page);
            $this->assertArrayHasKey('status', $page);
            $this->assertContains($page['status'], ['draft', 'published', 'archived']);
        }
    }
}
```

## Acceptance Criteria

- [ ] All API endpoints have test coverage
- [ ] Authentication is tested with valid/invalid tokens
- [ ] Rate limiting is enforced and headers are present
- [ ] Response schemas match OpenAPI specification
- [ ] Error responses follow consistent format
- [ ] Pagination works correctly with cursor/offset
- [ ] Content-Type negotiation is enforced
- [ ] CORS headers are configured correctly
- [ ] API versioning works as expected
- [ ] Contract tests validate against OpenAPI spec
