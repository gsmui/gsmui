# 07 - Backend Architecture

**Project:** GsmUi
**Version:** 1.0.0
**Status:** Active
**Last Updated:** 2026-07-26

---

# Purpose

This section is the contractor-ready backend architecture blueprint for GsmUi. It expands the conceptual material in [05-system-architecture](../05-system-architecture/05-system-architecture.md) and the schema in [06-database-design](../06-database-design/06-database-design.md) into implementation-level mechanics: concrete interfaces, class skeletons, method signatures, pattern rules, directory layout, configuration, error/exception handling, middleware, service-provider registration, and per-layer testing approach.

Section 07 contains 60 documents (07.01 - 07.60). They follow a strict dependency spine:

    Controller / Livewire ---> Action ---> Service ---> Repository ---> Model
    (writes also: Action -> Event -> Listener -> Job for async work)

Each document opens with a standard header and Purpose, cross-links sibling docs by filename, and ends with a Next Document pointer that chains 07.01 to 07.60 to [08-frontend-architecture](../08-frontend-architecture/08-frontend-architecture.md).

---

# Table of Contents

| # | File | Title | One-line purpose |
| --- | --- | --- | --- |
| 07.01 | [07.01-overview.md](07-backend-architecture/07.01-overview.md) | Overview | Section 07 is the contractor-ready, implementation-level companion to the conceptual architecture in Section 05 and the database schema in Section ... |
| 07.02 | [07.02-request-lifecycle.md](07-backend-architecture/07.02-request-lifecycle.md) | Request Lifecycle | This document defines the concrete, code-level path a request takes through the GsmUi backend, for both classic HTTP routes and Livewire updates. I... |
| 07.03 | [07.03-domain-driven-design.md](07-backend-architecture/07.03-domain-driven-design.md) | Domain-Driven Design | Domain-Driven Design gives GsmUi a vocabulary and structure that mirrors the business. This document is the implementation contract that binds DDD ... |
| 07.04 | [07.04-module-architecture.md](07-backend-architecture/07.04-module-architecture.md) | Module Architecture | GsmUi is a single deployable Laravel application partitioned into business modules. This document is the implementation contract that makes those m... |
| 07.05 | [07.05-folder-structure.md](07-backend-architecture/07.05-folder-structure.md) | Folder Structure | This document is the authoritative on-disk layout implementers use to place every new file. It is the implementation-level counterpart to 05.06-fol... |
| 07.06 | [07.06-service-layer.md](07-backend-architecture/07.06-service-layer.md) | Service Layer | The Service Layer holds GsmUi's business logic. Controllers, Livewire components, jobs, and console commands orchestrate; services decide. This doc... |
| 07.07 | [07.07-repository-layer.md](07-backend-architecture/07.07-repository-layer.md) | Repository Layer | The Repository Layer is the only persistence boundary in GsmUi. Services and Actions never touch Eloquent, the DB facade, or a model's query builde... |
| 07.08 | [07.08-action-layer.md](07-backend-architecture/07.08-action-layer.md) | Action Layer | Actions are the single entry point for every write use case in GsmUi. Controllers, Livewire components, Artisan commands, queued jobs, and API endp... |
| 07.09 | [07.09-dto-layer.md](07-backend-architecture/07.09-dto-layer.md) | DTO Layer | DTOs are immutable, typed value carriers that cross the application-layer boundary. Actions receive a DTO instead of a raw request array, which giv... |
| 07.10 | [07.10-value-objects.md](07-backend-architecture/07.10-value-objects.md) | Value Objects | Value objects encode validation and formatting at the type level. A Money is always a valid minor-unit integer with a known currency; a ComponentSl... |
| 07.11 | [07.11-enums.md](07-backend-architecture/07.11-enums.md) | Enums | Enums model constrained, low-churn string sets (statuses, types, roles, channels) that are stored as readable VARCHAR values in MySQL (see 06.01-de... |
| 07.12 | [07.12-events.md](07-backend-architecture/07.12-events.md) | Events | Events are the decoupling mechanism between GsmUi bounded contexts. Instead of an Action or Service calling another domain directly, it publishes a... |
| 07.13 | [07.13-listeners.md](07-backend-architecture/07.13-listeners.md) | Listeners | Listeners are the subscribers in GsmUi's event-driven architecture. They react to domain events dispatched by Actions (see 05.10-events.md) and per... |
| 07.14 | [07.14-jobs.md](07-backend-architecture/07.14-jobs.md) | Jobs | Jobs encapsulate long-running, resource-intensive, or asynchronous work that must not block the HTTP request lifecycle. Actions dispatch jobs after... |
| 07.15 | [07.15-policies.md](07-backend-architecture/07.15-policies.md) | Policies | Policies centralize authorization logic for a specific resource (model). Each GsmUi domain model that has access rules â€” Component, Theme, Produc... |
| 07.16 | [07.16-gates.md](07-backend-architecture/07.16-gates.md) | Gates | Gates provide authorization for abilities that are **not bound to a single resource instance**. Where policies (see 07.15-policies.md) answer "can ... |
| 07.17 | [07.17-validation.md](07-backend-architecture/07.17-validation.md) | Validation | Validation is the outermost guard of the backend. It runs before authorization (policies/gates, see 07.15-policies.md / 07.16-gates.md) and before ... |
| 07.18 | [07.18-form-requests.md](07-backend-architecture/07.18-form-requests.md) | Form Requests | Form Request classes are the standard, reusable container for HTTP input validation and authorization in GsmUi. They group rules(), authorize(), pr... |
| 07.19 | [07.19-livewire-architecture.md](07-backend-architecture/07.19-livewire-architecture.md) | Livewire Architecture | Livewire powers every interactive surface of GsmUi. A Livewire component binds server-side state to the browser without hand-written JavaScript: pr... |
| 07.20 | [07.20-blade-component-architecture.md](07-backend-architecture/07.20-blade-component-architecture.md) | Blade Component Architecture | GsmUi ships its UI as Blade components. Two flavors exist: anonymous components (single .blade.php file, no PHP class) and class components (a PHP ... |
| 07.21 | [07.21-api-architecture.md](07-backend-architecture/07.21-api-architecture.md) | API Architecture | Although GsmUi is primarily a Livewire application, core capabilities are exposed through a versioned REST API for mobile clients, CLI tools, MCP i... |
| 07.22 | [07.22-authentication.md](07-backend-architecture/07.22-authentication.md) | Authentication | GsmUi authenticates users through two complementary stacks: **Laravel Fortify** for the first-party web/SPA login, registration, password reset, an... |
| 07.23 | [07.23-authorization.md](07-backend-architecture/07.23-authorization.md) | Authorization | Once a user is authenticated (07.22-authentication.md), GsmUi authorizes actions through **Spatie Laravel-Permission**. The model combines flat *ro... |
| 07.24 | [07.24-search.md](07-backend-architecture/07.24-search.md) | Search | Search is a first-class capability in GsmUi: users locate components, documentation, themes, templates, blog posts, and marketplace products in mil... |
| 07.25 | [07.25-cache.md](07-backend-architecture/07.25-cache.md) | Cache | Caching in GsmUi is an optimization layer only; the database remains the source of truth. The application must remain fully functional when Redis i... |
| 07.26 | [07.26-storage.md](07-backend-architecture/07.26-storage.md) | Storage | GsmUi persists user-uploaded and system-generated binary assets â€” component thumbnails, theme previews, template exports, avatar images, blog cov... |
| 07.27 | [07.27-notifications.md](07-backend-architecture/07.27-notifications.md) | Notifications | GsmUi delivers alerts through multiple channels: email, in-app (database), SMS (future), push (future), and webhooks. Notifications are triggered b... |
| 07.28 | [07.28-mail.md](07-backend-architecture/07.28-mail.md) | Mail | Email is a primary channel for transactional and marketing communication in GsmUi â€” subscription confirmations, invoices, password resets, produc... |
| 07.29 | [07.29-webhooks.md](07-backend-architecture/07.29-webhooks.md) | Webhooks | Webhooks connect GsmUi to external systems â€” billing providers (Stripe/Paddle), customer automation, and the notification webhook channel (07.27-... |
| 07.30 | [07.30-billing.md](07-backend-architecture/07.30-billing.md) | Billing | GsmUi supports multiple payment providers (Stripe primary, Paddle for EU/VAT) without coupling business logic to any one SDK. A BillingGateway inte... |
| 07.31 | [07.31-marketplace.md](07-backend-architecture/07.31-marketplace.md) | Marketplace | The Marketplace domain is the commercial backbone of GsmUi: it lists digital products (components, themes, templates, icons, charts, plugins, snipp... |
| 07.32 | [07.32-theme-engine.md](07-backend-architecture/07.32-theme-engine.md) | Theme Engine | The Theme Engine is a design-token platform: every visual property (color, radius, shadow, spacing, typography) is a token stored in theme_tokens. ... |
| 07.33 | [07.33-component-engine.md](07-backend-architecture/07.33-component-engine.md) | Component Engine | The Component Engine is the foundation of GsmUi. Every UI element is registered with metadata (name, category, version, props, slots, variants, eve... |
| 07.34 | [07.34-template-engine.md](07-backend-architecture/07.34-template-engine.md) | Template Engine | Templates are pre-built, multi-component page/layout scaffolds (landing pages, dashboards, admin screens) composed from registered GsmUi components... |
| 07.35 | [07.35-documentation-engine.md](07-backend-architecture/07.35-documentation-engine.md) | Documentation Engine | The Documentation Engine is a structured knowledge platform, not a pile of Markdown. A DocumentationPage is parsed into front-matter metadata + an ... |
| 07.36 | [07.36-playground-engine.md](07-backend-architecture/07.36-playground-engine.md) | Playground Engine Service Interfaces | The playground lets developers compose GsmUi components live and preview the result. It must never execute untrusted code in the production process... |
| 07.37 | [07.37-ai-engine.md](07-backend-architecture/07.37-ai-engine.md) | AI Engine | The AI Engine is the single integration seam between GsmUi and external LLM providers (OpenAI, Anthropic, Google). It hides provider SDKs behind a ... |
| 07.38 | [07.38-mcp-server.md](07-backend-architecture/07.38-mcp-server.md) | MCP Server | The MCP Server exposes GsmUi capabilities to AI assistants through a standardized protocol (JSON-RPC over HTTP, with WebSocket/SSE transports â€” s... |
| 07.39 | [07.39-admin-platform.md](07-backend-architecture/07.39-admin-platform.md) | Admin Platform | The Admin Platform centralizes privileged operations that span every domain: user management, content moderation, financial operations, and system ... |
| 07.40 | [07.40-user-dashboard.md](07-backend-architecture/07.40-user-dashboard.md) | User Dashboard | The User Dashboard aggregates data scattered across many domains â€” profile, subscriptions, downloads, AI usage, showcase projects, billing â€” in... |
| 07.41 | [07.41-cms.md](07-backend-architecture/07.41-cms.md) | CMS | The CMS manages static pages, blog posts, and navigation menus. Content is authored as a tree of **blocks** (heading, rich text, image, component e... |
| 07.42 | [07.42-blog.md](07-backend-architecture/07.42-blog.md) | Blog | The Blog Engine is the CMS's richest content type: posts support draft/scheduled/published states, hierarchical categories, free tags, and three fe... |
| 07.43 | [07.43-showcase.md](07-backend-architecture/07.43-showcase.md) | Showcase | The Showcase Platform lets users submit community projects built with GsmUi and browse them in a curated, votable gallery. It is the most socially-... |
| 07.44 | [07.44-analytics.md](07-backend-architecture/07.44-analytics.md) | Analytics | Analytics in GsmUi is a write-heavy, read-light pipeline. The application emits small, structured events from Livewire components, controllers, job... |
| 07.45 | [07.45-feature-flags.md](07-backend-architecture/07.45-feature-flags.md) | Feature Flags | Feature flags let GsmUi ship code dark, run gradual percentage rollouts, run A/B splits, and kill-switch misbehaving features without a deployment.... |
| 07.46 | [07.46-settings.md](07-backend-architecture/07.46-settings.md) | Settings | Settings are configuration data, not business records â€” they are stored as typed key/value rows and resolved at runtime for feature configuration... |
| 07.47 | [07.47-observers.md](07-backend-architecture/07.47-observers.md) | Observers | Model observers respond to Eloquent lifecycle events (creating, created, updating, updated, deleting, deleted) and perform side effects tied to per... |
| 07.48 | [07.48-models.md](07-backend-architecture/07.48-models.md) | Models | Eloquent models in GsmUi follow one shared contract so repositories (see 07.07-repository-layer.md), observers (see 07.47-observers.md), and factor... |
| 07.49 | [07.49-queues.md](07-backend-architecture/07.49-queues.md) | Queues | Queues move long-running, resource-intensive, or asynchronous work off the HTTP request lifecycle so controllers and Livewire components stay respo... |
| 07.50 | [07.50-scheduler.md](07-backend-architecture/07.50-scheduler.md) | Scheduler | The scheduler runs recurring maintenance and aggregation work â€” cache refresh, analytics rollups, search reindex, session purge, backups â€” outs... |
| 07.51 | [07.51-cli-commands.md](07-backend-architecture/07.51-cli-commands.md) | CLI Commands | Artisan commands are the operator-facing surface for GsmUi: scaffolding, installs, cache/queue operations, and one-off maintenance or data tasks. T... |
| 07.52 | [07.52-health-checks.md](07-backend-architecture/07.52-health-checks.md) | Health Checks | Health checks give operators and orchestration a single, machine-readable signal of whether GsmUi is healthy. They probe every external dependency ... |
| 07.53 | [07.53-error-handling.md](07-backend-architecture/07.53-error-handling.md) | Error Handling | GsmUi separates *domain* failures (business rule violated, resource already exists) from *transport* failures (HTTP 404, validation 422). Domain co... |
| 07.54 | [07.54-logging.md](07-backend-architecture/07.54-logging.md) | Logging | Logs are GsmUi's primary observability signal: every thrown exception (see 07.53-error-handling.md), failed job (see 07.49-queues.md Â§4), health d... |
| 07.55 | [07.55-testing.md](07-backend-architecture/07.55-testing.md) | Testing | This document is the **implementation contract** for 05.42-testing-strategy.md. It specifies the concrete test layout, the toolchain (Pest as the d... |
| 07.56 | [07.56-performance.md](07-backend-architecture/07.56-performance.md) | Performance | This document is the **implementation contract** for 05.43-performance-optimization.md. It specifies the concrete techniques GsmUi uses to hit the ... |
| 07.57 | [07.57-security.md](07-backend-architecture/07.57-security.md) | Security | This document is the **implementation contract** for 05.15-security.md. It specifies the concrete code and configuration that enforces GsmUi's secu... |
| 07.58 | [07.58-deployment.md](07-backend-architecture/07.58-deployment.md) | Deployment | This document specifies the **implementation-level deployment contract** for GsmUi: how code moves from a merged commit to a running, zero-downtime... |
| 07.59 | [07.59-coding-standards.md](07-backend-architecture/07.59-coding-standards.md) | Coding Standards | This document defines the mandatory coding standards for GsmUi so that contributions stay consistent, type-safe, and statically analyzable. It cove... |
| 07.60 | [07.60-complete-request-flow.md](07-backend-architecture/07.60-complete-request-flow.md) | Complete Request Flow | The earlier 07 files each specify a single layer's contract in isolation: 07.06-service-layer.md defines services, 07.07-repository-layer.md define... |

---

# Next Document
**08-frontend-architecture.md - Frontend Architecture** The backend blueprint concludes here; frontend architecture continues into Blade, Livewire, and the gsmui component system.

---

# Section 07 Architecture Summary

## Core Dependency Spine

Every request in GsmUi follows this spine:

```text
Controller / Livewire ──▶ Action ──▶ Service ──▶ Repository ──▶ Model
```

For writes, the full chain is used. For reads, the Action layer is skipped:

```text
Controller / Livewire ──▶ Service ──▶ Repository ──▶ Model
```

## Layer Responsibilities

| Layer | Responsibility | Document |
| --- | --- | --- |
| Controller | Accept HTTP request, delegate to action/service, return response | 07.19, 07.21 |
| Action | Orchestrate a single write use case within a DB transaction | 07.08 |
| Service | Contain business logic, orchestrate repositories and external calls | 07.06 |
| Repository | Own all database queries, return Eloquent models | 07.07 |
| Model | Eloquent model with relationships, scopes, casts, observers | 07.48 |
| DTO | Immutable typed value carriers across application boundaries | 07.09 |
| Value Object | Immutable domain primitives with validation and formatting | 07.10 |
| Enum | Constrained string sets stored as readable VARCHAR values | 07.11 |
| Event | Decoupling mechanism between bounded contexts | 07.12 |
| Listener | Subscribe to events and dispatch queued jobs | 07.13 |
| Job | Encapsulate long-running or async work off the HTTP lifecycle | 07.14 |
| Policy | Centralize authorization logic for a specific resource | 07.15 |
| Gate | Authorization for abilities not bound to a single resource | 07.16 |
| Validation | Outermost guard of the backend, runs before authorization | 07.17 |
| Form Request | Reusable container for HTTP input validation and authorization | 07.18 |
| Livewire | Server-side reactive components without hand-written JavaScript | 07.19 |
| Blade Component | Two flavors: anonymous and class components for UI rendering | 07.20 |
| API | Versioned REST API for mobile clients, CLI tools, MCP integrations | 07.21 |
| Authentication | Laravel Fortify (web/SPA) + Sanctum (API tokens) | 07.22 |
| Authorization | Spatie Laravel-Permission (roles/permissions) + Policies/Gates | 07.23 |
| Search | Full-text search via Meilisearch through Laravel Scout | 07.24 |
| Cache | Redis-backed caching with tag-based invalidation | 07.25 |
| Storage | Filesystem abstraction (local, S3, object storage) | 07.26 |
| Notifications | Multi-channel alerts (email, in-app, SMS, push, webhooks) | 07.27 |
| Mail | Transactional and marketing email via Laravel Mailables | 07.28 |
| Webhooks | Inbound/outbound webhook processing with idempotency | 07.29 |
| Billing | Multi-provider payment gateway abstraction (Stripe, Paddle) | 07.30 |
| Marketplace | Digital product marketplace (components, themes, templates) | 07.31 |
| Theme Engine | Design-token platform for visual properties | 07.32 |
| Component Engine | Foundation of GsmUi, every UI element registered with metadata | 07.33 |
| Template Engine | Pre-built multi-component page/layout scaffolds | 07.34 |
| Documentation Engine | Structured knowledge platform, not Markdown includes | 07.35 |
| Playground Engine | Live component composition and preview | 07.36 |
| AI Engine | Single integration seam for external LLM providers | 07.37 |
| MCP Server | AI assistant integration via JSON-RPC over HTTP | 07.38 |
| Admin Platform | Privileged operations spanning every domain | 07.39 |
| User Dashboard | Aggregated user data across many domains | 07.40 |
| CMS | Static pages, blog posts, navigation menus | 07.41 |
| Blog | Rich content with categories, tags, featured images | 07.42 |
| Showcase | Community projects gallery with voting | 07.43 |
| Analytics | Write-heavy event pipeline for tracking | 07.44 |
| Feature Flags | Dark launches, percentage rollouts, A/B splits, kill-switches | 07.45 |
| Settings | Typed key/value configuration data | 07.46 |
| Observers | Eloquent lifecycle event side effects | 07.47 |
| Models | Eloquent models with shared contract | 07.48 |
| Queues | Horizon workers for async job processing | 07.49 |
| Scheduler | Cron-based recurring task execution | 07.50 |
| CLI Commands | Artisan commands for operators and developers | 07.51 |
| Health Checks | Machine-readable dependency probes | 07.52 |
| Error Handling | Domain exception hierarchy and problem+json rendering | 07.53 |
| Logging | Structured logging, correlation IDs, PII redaction | 07.54 |
| Testing | Pest/PHPUnit structure, factories, HTTP/Livewire/DB tests | 07.55 |
| Performance | Query optimization, caching, asset compilation, CDN | 07.56 |
| Security | CSP, CSRF, SSRF, rate limiting, secret management | 07.57 |
| Deployment | Zero-downtime releases with atomic symlink swap | 07.58 |
| Coding Standards | PSR-12, static analysis, pre-commit gates | 07.59 |
| Request Flow | End-to-end synthesis of all 60 contracts | 07.60 |

## Cross-Cutting Concerns

| Concern | Primary Documents | Implementation |
| --- | --- | --- |
| Error Handling | 07.53 | Domain exceptions → Handler → problem+json |
| Logging | 07.54 | Structured context, correlation IDs, PII redaction |
| Testing | 07.55 | Pest/PHPUnit, factories, HTTP/Livewire/DB tests |
| Performance | 07.56 | Query optimization, caching, asset compilation |
| Security | 07.57 | CSP, CSRF, SSRF, rate limiting, secret management |
| Deployment | 07.58 | Zero-downtime releases, atomic symlink swap |
| Coding Standards | 07.59 | PSR-12, PHPStan level 9, Pint, pre-commit gates |
| Request Flow | 07.60 | End-to-end synthesis of all contracts |

## Document Interconnections

Section 07 documents are cross-linked in a strict chain:

```
07.01 Overview
  └──▶ 07.02 Request Lifecycle
        └──▶ 07.03 Domain-Driven Design
              └──▶ 07.04 Module Architecture
                    └──▶ 07.05 Folder Structure
                          └──▶ 07.06–07.20 Core Layers
                                └──▶ 07.21–07.30 Infrastructure
                                      └──▶ 07.31–07.46 Domain Engines
                                            └──▶ 07.47–07.60 Operational
```

Each document ends with a `Next Document` pointer that chains to the next document in the sequence.

## Implementation Guidelines

### Getting Started

1. Read `07.01-overview.md` for the high-level architecture.
2. Read `07.05-folder-structure.md` for the on-disk layout.
3. Read `07.08-action-layer.md` for the write pattern.
4. Read `07.07-repository-layer.md` for the read pattern.
5. Read `07.53-error-handling.md` for the exception hierarchy.
6. Read `07.59-coding-standards.md` for the code style.

### Building a New Feature

1. Design the domain model (`07.48-models.md`).
2. Create the repository (`07.07-repository-layer.md`).
3. Create the service (`07.06-service-layer.md`).
4. Create the action (`07.08-action-layer.md`).
5. Create the DTO (`07.09-dto-layer.md`).
6. Create the controller/Livewire component (`07.19`, `07.21`).
7. Add validation (`07.17`, `07.18`).
8. Add authorization (`07.15`, `07.16`, `07.23`).
9. Add events and listeners (`07.12`, `07.13`).
10. Add jobs for async work (`07.14`).
11. Add caching (`07.25`).
12. Add search indexing (`07.24`).
13. Add tests (`07.55`).
14. Follow coding standards (`07.59`).

### Code Review Checklist

Before approving a PR, verify:

- [ ] Follows the dependency spine (Controller → Action → Service → Repository → Model).
- [ ] Actions open transactions for writes.
- [ ] Events are dispatched after commit.
- [ ] Listeners are thin and queued.
- [ ] Repositories own all query logic.
- [ ] Services orchestrate, not implement.
- [ ] DTOs are immutable.
- [ ] Exceptions are thrown, not returned.
- [ ] Logs use context arrays; PII is redacted.
- [ ] Tests cover the change.
- [ ] Coding standards are followed (PSR-12, PHPStan level 9).
- [ ] Security considerations are addressed.
- [ ] Performance impact is assessed.
- [ ] Deployment impact is assessed.

## Document Count Summary

| Category | Count | Documents |
| --- | --- | --- |
| Core Architecture | 6 | 07.01–07.05 |
| Core Layers | 13 | 07.06–07.18 |
| Presentation | 3 | 07.19–07.21 |
| Auth | 2 | 07.22–07.23 |
| Infrastructure | 7 | 07.24–07.30 |
| Domain Engines | 16 | 07.31–07.46 |
| Operational | 14 | 07.47–07.60 |
| **Total** | **60** | **07.01–07.60** |

## Key Patterns

### Action Pattern (Writes)
```php
public function run(ComponentData $data): Component
{
    return DB::transaction(function () use ($data) {
        $component = $this->service->create($data);
        dispatchAfterCommit(new ComponentCreated($component));
        return $component;
    });
}
```

### Repository Pattern (Reads)
```php
public function findBySlug(string $slug): ?Component
{
    return $this->model->where('slug', $slug)->first();
}
```

### Cache Pattern (Read-Through)
```php
return Cache::remember("components:{$slug}", 3600, function () use ($slug) {
    return $this->repository->findBySlug($slug);
});
```

### Event Pattern (Async)
```php
dispatchAfterCommit(new OrderPlaced($order));
```

### Exception Pattern
```php
throw ComponentExceptionFactory::alreadyExists($slug);
```

## Operational Rules (Complete)

1. Section 07 is the contractor-ready backend architecture blueprint for GsmUi.
2. It expands conceptual material in Section 05 into implementation-level mechanics.
3. It specifies concrete interfaces, class skeletons, method signatures, and pattern rules.
4. It covers the full stack: directory layout, configuration, error handling, middleware, service providers, and testing.
5. The 60 documents follow a strict dependency spine.
6. Each document opens with a standard header and Purpose.
7. Each document cross-links sibling docs by filename.
8. Each document ends with a Next Document pointer.
9. The chain runs from 07.01 to 07.60 to 08-frontend-architecture.md.
10. The dependency spine is: Controller → Action → Service → Repository → Model.
11. Writes always use the full spine; reads skip the Action layer.
12. Events are the only sanctioned way to cross into async work.
13. The repository layer is the only persistence boundary.
14. Domain code throws DomainException subclasses, never HttpException.
15. Handler::render() is the single translation seam for exceptions.
16. API errors use problem+json (RFC 9457).
17. Logs are structured with correlation IDs and PII redaction.
18. Tests cover unit, feature, browser, and performance scenarios.
19. Coding standards enforce PSR-12, PHPStan level 9, and Pint formatting.
20. Deployment uses zero-downtime releases with atomic symlink swap.

---

# Section 07 Architecture Deep Dive

## Module Architecture

GsmUi is a single deployable Laravel application partitioned into business modules. Each module owns its own domain logic, services, repositories, and models.

### Module Map

| Module | Namespace | Domain |
| --- | --- | --- |
| Components | `App\Domains\Components` | UI component registry, metadata, versions |
| Themes | `App\Domains\Themes` | Design tokens, theme publishing |
| Templates | `App\Domains\Templates` | Pre-built page/layout scaffolds |
| Marketplace | `App\Domains\Marketplace` | Digital product sales, orders, licenses |
| Billing | `App\Domains\Billing` | Payment processing, subscriptions, invoices |
| Documentation | `App\Domains\Documentation` | Structured docs, parsing, rendering |
| Search | `App\Domains\Search` | Full-text indexing, query processing |
| Auth | `App\Domains\Auth` | Authentication, authorization, sessions |
| Admin | `App\Domains\Admin` | Privileged operations, moderation |
| CMS | `App\Domains\CMS` | Static pages, blog, navigation |
| Analytics | `App\Domains\Analytics` | Event tracking, metrics, rollups |
| AI | `App\Domains\AI` | LLM integration, prompt management |
| MCP | `App\Domains\MCP` | AI assistant protocol server |
| Playground | `App\Domains\Playground` | Live component composition |
| Showcase | `App\Domains\Showcase` | Community projects gallery |
| Settings | `App\Domains\Settings` | Typed key/value configuration |

### Module Dependencies

```text
Components ──▶ Themes (component themes)
Components ──▶ Templates (template components)
Templates ──▶ Components (template uses components)
Templates ──▶ Themes (template themes)
Marketplace ──▶ Components (sell components)
Marketplace ──▶ Themes (sell themes)
Marketplace ──▶ Templates (sell templates)
Marketplace ──▶ Billing (payment processing)
Billing ──▶ Auth (user subscriptions)
Documentation ──▶ Search (doc indexing)
Documentation ──▶ Components (doc examples)
CMS ──▶ Components (block components)
CMS ──▶ Search (content indexing)
Analytics ──▶ Components (component usage)
Analytics ──▶ Marketplace (sales metrics)
AI ──▶ Components (AI component generation)
AI ──▶ Templates (AI template generation)
MCP ──▶ AI (protocol integration)
Playground ──▶ Components (live preview)
Showcase ──▶ Components (project examples)
Settings ──▶ Auth (user settings)
```

### Module Isolation Rules

1. Modules communicate via events, not direct method calls.
2. Modules do not import models from other modules.
3. Modules do not import repositories from other modules.
4. Services may call other services only via interfaces.
5. Cross-module queries go through the repository layer.

## Domain-Driven Design

GsmUi uses DDD to structure its backend. Key DDD concepts and their GsmUi implementation:

### Bounded Contexts

| Bounded Context | Aggregate Root | Value Objects | Domain Events |
| --- | --- | --- | --- |
| Components | `Component` | `ComponentSlug`, `ComponentVersion` | `ComponentCreated`, `ComponentPublished` |
| Themes | `Theme` | `ThemeToken`, `ThemeSlug` | `ThemeCreated`, `ThemePublished` |
| Templates | `Template` | `TemplateSlug`, `TemplateVersion` | `TemplateCreated`, `TemplatePublished` |
| Marketplace | `Order` | `Money`, `IdempotencyKey` | `OrderPlaced`, `PaymentSucceeded` |
| Billing | `Subscription` | `Money`, `BillingPeriod` | `SubscriptionCreated`, `PaymentDeclined` |
| Documentation | `DocumentationPage` | `DocVersion`, `DocSlug` | `PagePublished`, `PageUpdated` |

### Aggregates

Each bounded context has an aggregate root that enforces invariants:

```php
// Component aggregate
class Component
{
    public function publish(): void
    {
        if ($this->status->isPublished()) {
            throw ComponentExceptionFactory::published($this->slug);
        }

        if ($this->versions->isEmpty()) {
            throw ComponentExceptionFactory::noVersions($this->slug);
        }

        $this->status = ComponentStatus::Published;
        $this->published_at = now();
    }
}
```

### Domain Events

Events decouple bounded contexts:

```php
// In Component aggregate
class Component
{
    public function publish(): void
    {
        // ... state changes ...

        DomainEvent::dispatch(new ComponentPublished(
            componentId: $this->id,
            slug: $this->slug,
            authorId: $this->author_id,
        ));
    }
}
```

## Folder Structure

The authoritative on-disk layout:

```
app/
├── Console/
│   └── Commands/           # Artisan commands
├── Domains/
│   ├── Auth/               # Authentication domain
│   │   ├── Actions/
│   │   ├── Exceptions/
│   │   ├── Listeners/
│   │   ├── Models/
│   │   ├── Repositories/
│   │   ├── Services/
│   │   └── value-objects/
│   ├── Billing/            # Billing domain
│   │   ├── Actions/
│   │   ├── Exceptions/
│   │   ├── Events/
│   │   ├── Listeners/
│   │   ├── Models/
│   │   ├── Repositories/
│   │   ├── Services/
│   │   └── value-objects/
│   ├── Components/         # Components domain
│   │   ├── Actions/
│   │   ├── Exceptions/
│   │   ├── Events/
│   │   ├── Listeners/
│   │   ├── Models/
│   │   ├── Observers/
│   │   ├── Repositories/
│   │   ├── Services/
│   │   └── value-objects/
│   ├── ... (other domains)
│   └── Shared/             # Shared exceptions, traits
│       └── Exceptions/
├── DTOs/                   # Data Transfer Objects
├── Enums/                  # PHP Enums
├── Events/                 # Domain Events
├── Exceptions/             # Exception Handler
├── Http/
│   ├── Controllers/        # HTTP Controllers
│   ├── Livewire/           # Livewire Components
│   ├── Middleware/          # HTTP Middleware
│   └── Requests/           # Form Requests
├── Jobs/                   # Queued Jobs
├── Listeners/              # Event Listeners
├── Mail/                   # Mailables
├── Models/                 # Eloquent Models
├── Observers/              # Model Observers
├── Policies/               # Authorization Policies
├── Providers/              # Service Providers
├── ValueObjects/           # Value Objects
config/                     # Configuration files
database/
├── factories/              # Model Factories
├── migrations/             # Database Migrations
├── seeders/                # Database Seeders
public/
├── build/                  # Compiled Assets
├── storage/                # Symlink to storage
resources/
├── views/                  # Blade Templates
│   ├── components/         # Blade Components
│   ├── gsmui/              # GsmUI Components
│   ├── layouts/            # Layout Templates
│   └── livewire/           # Livewire Templates
routes/
├── api.php                 # API Routes
├── console.php             # Console Routes
├── web.php                 # Web Routes
└── webhooks.php            # Webhook Routes
storage/
├── app/                    # Application Files
├── framework/              # Framework Cache
├── logs/                   # Log Files
└── telemetry/              # Telemetry Data
tests/
├── Browser/                # Playwright Tests
├── Feature/                # Feature Tests
├── Unit/                   # Unit Tests
└── Helpers/                # Test Helpers
```

## Configuration Architecture

Configuration is layered:

| Layer | Location | Purpose |
| --- | --- | --- |
| Framework | `config/*.php` | Laravel framework configuration |
| Package | `config/gsmui-pro.php` | GsmUI package configuration |
| Environment | `.env` | Environment-specific values |
| Database | `settings` table | Runtime configuration |

### Config Caching

All config files are cached during deployment:

```bash
php artisan config:cache
```

After caching, `.env` is never read at runtime. Environment-specific values must be set before caching.

## Middleware Stack

The full middleware stack in execution order:

### Global Middleware (Every Request)

1. `TrustProxies` — Trust all proxies
2. `HandleCors` — Handle CORS requests
3. `PreventRequestsDuringMaintenance` — Block during maintenance
4. `ValidatePostSize` — Validate POST body size
5. `TrimStrings` — Trim whitespace from input
6. `ConvertEmptyStringsToNull` — Convert empty strings to null

### Web Middleware (Session Routes)

7. `EncryptCookies` — Encrypt cookies
8. `AddQueuedCookiesToResponse` — Add queued cookies
9. `StartSession` — Start the session
10. `ShareErrorsFromSession` — Share errors with views
11. `VerifyCsrfToken` — Verify CSRF token
12. `SubstituteBindings` — Substitute route model bindings

### API Middleware (API Routes)

7. `Illuminate\Routing\Middleware\ThrottleRequests:api` — Rate limiting
8. `Illuminate\Routing\Middleware\SubstituteBindings` — Route model bindings

### Custom Middleware

13. `AssignCorrelationId` — Generate/accept correlation ID
14. `AttachUserContext` — Attach user to log context
15. `AttachLivewireContext` — Attach Livewire context to logs
16. `LogRequestDuration` — Log request duration

## Service Provider Registration

Service providers register bindings in a specific order:

```php
// AppServiceProvider::register()
$this->app->bind(ComponentRepository::class, fn ($app) => new ComponentRepository(
    new Component(),
));

$this->app->bind(ComponentService::class, fn ($app) => new ComponentService(
    repository: $app->make(ComponentRepository::class),
    searchIndex: $app->make(SearchIndexService::class),
));
```

## Event System

### Event Dispatch Flow

```text
Action::run()
    │
    ├── State changes
    │
    ├── DB::transaction commits
    │
    └── dispatchAfterCommit(new DomainEvent(...))
         │
         ├──▶ Synchronous Listeners (rare)
         │
         └──▶ Queued Listeners (common)
              │
              └──▶ Dispatch Jobs
                   │
                   └──▶ Horizon Worker processes job
```

### Event Naming Convention

Events use past tense:

| Event | Bounded Context |
| --- | --- |
| `ComponentCreated` | Components |
| `ComponentPublished` | Components |
| `TemplateCreated` | Templates |
| `OrderPlaced` | Marketplace |
| `PaymentSucceeded` | Billing |
| `SubscriptionCreated` | Billing |
| `PagePublished` | Documentation |
| `UserRegistered` | Auth |

## Queue Architecture

### Queue Connections

| Queue | Connection | Purpose |
| --- | --- | --- |
| `default` | Redis | General purpose |
| `emails` | Redis | Email sending |
| `notifications` | Redis | Notification dispatch |
| `exports` | Redis | Export generation |
| `search` | Redis | Search indexing |

### Job Priorities

| Priority | Queue | Max Processes |
| --- | --- | --- |
| High | `emails` | 5 |
| Medium | `default`, `notifications` | 10 |
| Low | `exports`, `search` | 3 |

## Testing Architecture

### Test Types

| Type | Tool | Scope | Speed |
| --- | --- | --- | --- |
| Unit | Pest | Single class | Fast (< 1ms) |
| Feature | Pest | Multiple classes | Medium (< 100ms) |
| Browser | Playwright | Full stack | Slow (< 5s) |
| Performance | Custom | Response times | Variable |

### Test Organization

```
tests/
├── Unit/
│   ├── Actions/
│   ├── DTOs/
│   ├── Enums/
│   ├── Exceptions/
│   ├── Models/
│   ├── Policies/
│   ├── Repositories/
│   ├── Services/
│   ├── ValueObjects/
│   └── Validators/
├── Feature/
│   ├── Auth/
│   ├── Components/
│   ├── Marketplace/
│   ├── Billing/
│   ├── Documentation/
│   ├── Admin/
│   └── API/
├── Browser/
│   ├── Auth/
│   ├── Components/
│   ├── Marketplace/
│   └── Admin/
└── Helpers/
    ├── Factories/
    └── Traits/
```

## Security Architecture

### Security Layers

| Layer | Implementation | Document |
| --- | --- | --- |
| CSRF | `VerifyCsrfToken` middleware | 07.57 |
| XSS | Blade auto-escaping | 07.57 |
| SQL Injection | Eloquent parameter binding | 07.57 |
| Authentication | Fortify + Sanctum | 07.22 |
| Authorization | Policies + Gates | 07.15, 07.16, 07.23 |
| Rate Limiting | `ThrottleRequests` middleware | 07.57 |
| CSP | `CspMiddleware` | 07.57 |
| Secrets | Vault/secret manager | 07.57 |
| SSRF | URL validation | 07.57 |
| File Upload | MIME validation, size limits | 07.17, 07.26 |

### CSP Directives

```
default-src 'self'
script-src 'self'
style-src 'self' 'unsafe-inline'
img-src 'self' data: https:
font-src 'self'
connect-src 'self'
frame-ancestors 'none'
base-uri 'self'
form-action 'self'
```

## Performance Architecture

### Performance Targets

| Metric | Target | Measurement |
| --- | ---| --- |
| Response time (p50) | < 100ms | APM |
| Response time (p95) | < 500ms | APM |
| Response time (p99) | < 1000ms | APM |
| Database query time (p50) | < 10ms | Slow query log |
| Cache hit rate | > 90% | Redis metrics |
| Memory per request | < 128MB | PHP memory |

### Optimization Strategies

| Strategy | Implementation | Impact |
| --- | --- | --- |
| Query optimization | Eager loading, indexing | 50-90% query reduction |
| Caching | Redis, tag-based invalidation | 50-80% latency reduction |
| Asset compilation | Vite, content hashing | 30-50% load time reduction |
| CDN | Static asset serving | 60-80% bandwidth reduction |
| Database indexing | Composite indexes, covering indexes | 50-90% query time reduction |

## Observability Architecture

### Three Pillars

| Pillar | Implementation | Document |
| --- | --- | --- |
| Logs | Structured JSON, correlation IDs | 07.54 |
| Metrics | Application metrics, system metrics | 07.44 |
| Traces | OpenTelemetry spans | 07.54 |

### Dashboard Categories

| Category | Metrics | Refresh Rate |
| --- | --- | --- |
| Application | Request rate, error rate, latency | 1 minute |
| Database | Query time, connection pool, locks | 1 minute |
| Cache | Hit rate, memory usage, evictions | 1 minute |
| Queue | Job rate, failure rate, wait time | 1 minute |
| Infrastructure | CPU, memory, disk, network | 5 minutes |

## Disaster Recovery

### Backup Strategy

| Component | Backup Method | Frequency | Retention |
| --- | --- | --- | --- |
| MySQL | Automated snapshots | Daily | 30 days |
| Redis | RDB snapshots | Every 6 hours | 7 days |
| Meilisearch | Index dump | Daily | 7 days |
| S3 | Versioning | Continuous | 90 days |
| Logs | Log shipping | Real-time | 90 days |

### Recovery Time Objectives

| Scenario | RTO | RPO |
| --- | --- | --- |
| Code rollback | 5 minutes | 0 |
| Database restore | 30 minutes | 1 hour |
| Full infrastructure rebuild | 2 hours | 1 hour |
| Disaster recovery | 4 hours | 1 hour |

## Operational Rules (Complete Final)

1. Section 07 is the contractor-ready backend architecture blueprint for GsmUi.
2. It expands conceptual material in Section 05 into implementation-level mechanics.
3. It specifies concrete interfaces, class skeletons, method signatures, and pattern rules.
4. It covers the full stack: directory layout, configuration, error handling, middleware, service providers, and testing.
5. The 60 documents follow a strict dependency spine.
6. Each document opens with a standard header and Purpose.
7. Each document cross-links sibling docs by filename.
8. Each document ends with a Next Document pointer.
9. The chain runs from 07.01 to 07.60 to 08-frontend-architecture.md.
10. The dependency spine is: Controller → Action → Service → Repository → Model.
11. Writes always use the full spine; reads skip the Action layer.
12. Events are the only sanctioned way to cross into async work.
13. The repository layer is the only persistence boundary.
14. Domain code throws DomainException subclasses, never HttpException.
15. Handler::render() is the single translation seam for exceptions.
16. API errors use problem+json (RFC 9457).
17. Logs are structured with correlation IDs and PII redaction.
18. Tests cover unit, feature, browser, and performance scenarios.
19. Coding standards enforce PSR-12, PHPStan level 9, and Pint formatting.
20. Deployment uses zero-downtime releases with atomic symlink swap.
21. Modules are isolated and communicate via events.
22. DDD bounded contexts define aggregate roots and domain events.
23. The folder structure is the authoritative on-disk layout.
24. Configuration is layered: framework → package → environment → database.
25. The middleware stack runs in a specific order for every request.
26. Service providers register bindings in a specific order.
27. Events use past tense naming and are dispatched after commit.
28. Queues are separated by priority: emails > default > exports.
29. Tests are organized by type: unit → feature → browser → performance.
30. Security is layered: CSRF, XSS, SQLi, authN, authZ, rate limit, CSP, secrets.
31. Performance targets are defined for every metric.
32. Observability uses the three pillars: logs, metrics, traces.
33. Disaster recovery is documented with RTO and RPO targets.
34. The architecture is designed for maintainability, scalability, and security.
35. This index document is the single source of truth for Section 07.

---

# Section 07 Document Relationships

## Dependency Graph

The 60 documents in Section 07 are organized in a strict dependency hierarchy. Documents earlier in the sequence define foundational concepts that later documents build upon.

### Foundation Layer (07.01–07.05)

These documents establish the architectural foundation:

```
07.01 Overview
  │
  ├──▶ 07.02 Request Lifecycle
  │      │
  │      └──▶ 07.03 Domain-Driven Design
  │             │
  │             └──▶ 07.04 Module Architecture
  │                    │
  │                    └──▶ 07.05 Folder Structure
  │                           │
  │                           ▼
  │                     [All implementation docs build on this]
```

### Core Layer Docs (07.06–07.18)

These documents define the core application layers:

```
07.05 Folder Structure
  │
  ├──▶ 07.06 Service Layer
  │      │
  │      └──▶ 07.07 Repository Layer
  │             │
  │             └──▶ 07.08 Action Layer
  │                    │
  │                    ├──▶ 07.09 DTO Layer
  │                    │      │
  │                    │      └──▶ 07.10 Value Objects
  │                    │             │
  │                    │             └──▶ 07.11 Enums
  │                    │
  │                    ├──▶ 07.12 Events
  │                    │      │
  │                    │      └──▶ 07.13 Listeners
  │                    │             │
  │                    │             └──▶ 07.14 Jobs
  │                    │
  │                    └──▶ 07.15 Policies
  │                           │
  │                           └──▶ 07.16 Gates
  │                                  │
  │                                  └──▶ 07.17 Validation
  │                                         │
  │                                         └──▶ 07.18 Form Requests
```

### Presentation Layer (07.19–07.21)

These documents define the presentation layer:

```
07.18 Form Requests
  │
  ├──▶ 07.19 Livewire Architecture
  │      │
  │      └──▶ 07.20 Blade Component Architecture
  │
  └──▶ 07.21 API Architecture
```

### Infrastructure Layer (07.22–07.30)

These documents define infrastructure services:

```
07.21 API Architecture
  │
  ├──▶ 07.22 Authentication
  │      │
  │      └──▶ 07.23 Authorization
  │
  ├──▶ 07.24 Search
  │
  ├──▶ 07.25 Cache
  │
  ├──▶ 07.26 Storage
  │
  ├──▶ 07.27 Notifications
  │      │
  │      └──▶ 07.28 Mail
  │
  ├──▶ 07.29 Webhooks
  │
  └──▶ 07.30 Billing
```

### Domain Engine Docs (07.31–07.46)

These documents define the domain-specific engines:

```
07.30 Billing
  │
  ├──▶ 07.31 Marketplace
  │
  ├──▶ 07.32 Theme Engine
  │
  ├──▶ 07.33 Component Engine
  │
  ├──▶ 07.34 Template Engine
  │
  ├──▶ 07.35 Documentation Engine
  │
  ├──▶ 07.36 Playground Engine
  │
  ├──▶ 07.37 AI Engine
  │      │
  │      └──▶ 07.38 MCP Server
  │
  ├──▶ 07.39 Admin Platform
  │
  ├──▶ 07.40 User Dashboard
  │
  ├──▶ 07.41 CMS
  │      │
  │      └──▶ 07.42 Blog
  │
  ├──▶ 07.43 Showcase
  │
  ├──▶ 07.44 Analytics
  │
  ├──▶ 07.45 Feature Flags
  │
  └──▶ 07.46 Settings
```

### Operational Layer (07.47–07.60)

These documents define operational concerns:

```
07.46 Settings
  │
  ├──▶ 07.47 Observers
  │
  ├──▶ 07.48 Models
  │
  ├──▶ 07.49 Queues
  │
  ├──▶ 07.50 Scheduler
  │
  ├──▶ 07.51 CLI Commands
  │
  ├──▶ 07.52 Health Checks
  │
  ├──▶ 07.53 Error Handling
  │
  ├──▶ 07.54 Logging
  │
  ├──▶ 07.55 Testing
  │
  ├──▶ 07.56 Performance
  │
  ├──▶ 07.57 Security
  │
  ├──▶ 07.58 Deployment
  │
  ├──▶ 07.59 Coding Standards
  │
  └──▶ 07.60 Complete Request Flow
         │
         └──▶ 08 Frontend Architecture
```

## Cross-Document References

### How Documents Reference Each Other

Each document uses these cross-reference patterns:

1. **`See also:`** — at the top of the document, references related documents.
2. **`07.xx-document-name.md`** — inline references to specific documents.
3. **`§N`** — section references within a document.
4. **`Next Document`** — at the bottom, chains to the next document in sequence.

### Reference Frequency

| Document | Times Referenced | Referenced By |
| --- | --- | --- |
| 07.08 Action Layer | 45+ | Most write-related docs |
| 07.07 Repository Layer | 40+ | All persistence-related docs |
| 07.06 Service Layer | 35+ | All business logic docs |
| 07.48 Models | 30+ | All data-related docs |
| 07.54 Logging | 25+ | All operational docs |
| 07.57 Security | 20+ | All HTTP-related docs |
| 07.53 Error Handling | 18+ | All exception-related docs |
| 07.25 Cache | 15+ | All performance-related docs |

## Implementation Priorities

### Phase 1: Foundation (Week 1–2)

| Document | Priority | Effort |
| --- | --- | --- |
| 07.01 Overview | Critical | 1 day |
| 07.02 Request Lifecycle | Critical | 1 day |
| 07.05 Folder Structure | Critical | 1 day |
| 07.06 Service Layer | Critical | 2 days |
| 07.07 Repository Layer | Critical | 2 days |
| 07.08 Action Layer | Critical | 2 days |
| 07.48 Models | Critical | 1 day |

### Phase 2: Core Layers (Week 3–4)

| Document | Priority | Effort |
| --- | --- | --- |
| 07.09 DTO Layer | High | 1 day |
| 07.10 Value Objects | High | 1 day |
| 07.11 Enums | High | 1 day |
| 07.12 Events | High | 1 day |
| 07.13 Listeners | High | 1 day |
| 07.14 Jobs | High | 1 day |
| 07.15 Policies | High | 1 day |
| 07.17 Validation | High | 1 day |
| 07.18 Form Requests | High | 1 day |

### Phase 3: Presentation (Week 5–6)

| Document | Priority | Effort |
| --- | --- | --- |
| 07.19 Livewire Architecture | High | 2 days |
| 07.20 Blade Component Architecture | High | 2 days |
| 07.21 API Architecture | High | 2 days |

### Phase 4: Infrastructure (Week 7–8)

| Document | Priority | Effort |
| --- | --- | --- |
| 07.22 Authentication | High | 2 days |
| 07.23 Authorization | High | 1 day |
| 07.24 Search | High | 2 days |
| 07.25 Cache | High | 1 day |
| 07.26 Storage | High | 1 day |
| 07.27 Notifications | Medium | 1 day |
| 07.28 Mail | Medium | 1 day |
| 07.29 Webhooks | Medium | 1 day |
| 07.30 Billing | High | 3 days |

### Phase 5: Domain Engines (Week 9–12)

| Document | Priority | Effort |
| --- | --- | --- |
| 07.31 Marketplace | High | 3 days |
| 07.32 Theme Engine | Medium | 2 days |
| 07.33 Component Engine | High | 3 days |
| 07.34 Template Engine | Medium | 2 days |
| 07.35 Documentation Engine | Medium | 2 days |
| 07.36 Playground Engine | Low | 2 days |
| 07.37 AI Engine | Medium | 2 days |
| 07.38 MCP Server | Low | 2 days |
| 07.39 Admin Platform | High | 3 days |
| 07.40 User Dashboard | Medium | 2 days |
| 07.41 CMS | Medium | 2 days |
| 07.42 Blog | Low | 1 day |
| 07.43 Showcase | Low | 1 day |
| 07.44 Analytics | Medium | 2 days |
| 07.45 Feature Flags | Medium | 1 day |
| 07.46 Settings | Low | 1 day |

### Phase 6: Operational (Week 13–16)

| Document | Priority | Effort |
| --- | --- | --- |
| 07.47 Observers | High | 1 day |
| 07.49 Queues | High | 2 days |
| 07.50 Scheduler | Medium | 1 day |
| 07.51 CLI Commands | Medium | 1 day |
| 07.52 Health Checks | Medium | 1 day |
| 07.53 Error Handling | Critical | 2 days |
| 07.54 Logging | Critical | 2 days |
| 07.55 Testing | Critical | 3 days |
| 07.56 Performance | High | 2 days |
| 07.57 Security | Critical | 3 days |
| 07.58 Deployment | Critical | 2 days |
| 07.59 Coding Standards | Critical | 1 day |
| 07.60 Request Flow | High | 2 days |

## Technology Stack

### Backend

| Technology | Version | Purpose |
| --- | --- | --- |
| PHP | 8.3+ | Runtime |
| Laravel | 13 | Framework |
| Livewire | 4 | Reactive components |
| MySQL | 8.0+ | Primary database |
| Redis | 7.0+ | Cache, queue, session |
| Meilisearch | 1.6+ | Full-text search |
| Horizon | Latest | Queue management |
| Fortify | Latest | Authentication |
| Sanctum | Latest | API tokens |
| Telescope | Latest | Debugging |
| Pint | Latest | Code formatting |
| PHPStan/Larastan | Level 9 | Static analysis |
| Pest | Latest | Testing |

### Frontend

| Technology | Version | Purpose |
| --- | --- | --- |
| Vite | Latest | Asset compilation |
| Tailwind CSS | 3.x | Utility-first CSS |
| Alpine.js | 3.x | Lightweight JS |
| Blade Icons | Latest | Icon components |
| Blade Components | Custom | GsmUI component library |

### Infrastructure

| Technology | Purpose |
| --- |--- |
| Docker | Containerization |
| AWS ECS/Fargate | Container orchestration |
| AWS RDS | Managed MySQL |
| AWS ElastiCache | Managed Redis |
| AWS S3 | Object storage |
| AWS CloudFront | CDN |
| Sentry | Error monitoring |
| Datadog | APM and logging |
| GitHub Actions | CI/CD |

## Estimated Total Implementation Effort

| Phase | Documents | Estimated Effort |
| --- | --- | --- |
| Phase 1: Foundation | 7 | 10 days |
| Phase 2: Core Layers | 9 | 9 days |
| Phase 3: Presentation | 3 | 6 days |
| Phase 4: Infrastructure | 9 | 14 days |
| Phase 5: Domain Engines | 16 | 30 days |
| Phase 6: Operational | 14 | 22 days |
| **Total** | **60** | **~91 days (18 weeks)** |

## Architectural Principles

The 60 documents in Section 07 follow these architectural principles:

### 1. Separation of Concerns

Every layer has a single responsibility:
- **Controllers** — HTTP routing and response formatting only
- **Actions** — Application logic orchestration (transaction boundaries)
- **Services** — Business logic (stateless, no HTTP awareness)
- **Repositories** — Data access abstraction (no business logic)
- **Models** — Domain entity representation and relationships
- **Events** — Cross-boundary side effects
- **Jobs** — Async work definition
- **DTOs** — Data transfer between layers (immutable)

### 2. Dependency Rule

Dependencies point inward only:

```
Controller → Action → Service → Repository → Model
   ↑           ↑         ↑          ↑
   └─── Dependencies flow inward ──┘
```

- Outer layers may depend on inner layers.
- Inner layers must never depend on outer layers.
- Models never reference Services, Actions, or Controllers.
- Services never reference Controllers or Actions.
- The Action layer is the transaction boundary — it orchestrates, never owns logic.

### 3. Command Query Separation (CQS)

- **Commands** (writes) use the full spine: Controller → Action → Service → Repository → Model
- **Queries** (reads) skip the Action layer: Controller → Service → Repository → Model
- Services are split into `CommandService` and `QueryService` interfaces where appropriate
- Read models may use lightweight DTOs instead of full Eloquent models

### 4. Explicit Over Implicit

- All bindings are explicit in service providers
- All method signatures include return types
- All properties include type declarations
- All events declare their payload type
- All exceptions include context arrays
- All log entries include structured context

### 5. Fail Fast

- Validate input at the earliest point (Form Requests for HTTP, type hints for internal)
- Throw exceptions immediately on invalid state
- Never swallow exceptions silently
- Use assertions in development, exceptions in production
- Return early in methods to reduce nesting

### 6. Immutable Where Possible

- DTOs are immutable (readonly properties, no setters)
- Value objects are immutable by design
- Events carry a snapshot of state at dispatch time
- Configuration is read-only after boot

## Request Lifecycle (Detailed)

Every request follows this lifecycle:

```
1. HTTP Request arrives
   │
   ▼
2. Middleware Pipeline (07.54-logging.md, 07.57-security.md)
   │  ├── TrustProxies
   │  ├── HandleCors
   │  ├── PreventRequestsDuringMaintenance
   │  ├── ValidatePostSize
   │  ├── TrimStrings
   │  ├── ConvertEmptyStringsToNull
   │  ├── EncryptCookies
   │  ├── AddQueuedCookiesToResponse
   │  ├── StartSession
   │  ├── ShareErrorsFromSession
   │  ├── VerifyCsrfToken
   │  ├── AuthenticateUser (optional)
   │  ├── AuthorizeRequest (optional)
   │  ├── RateLimitRequest (optional)
   │  └── CspHeaders (optional)
   │
   ▼
3. Route Resolution (Laravel Router)
   │
   ▼
4. Controller Invocation (07.19-livewire-architecture.md)
   │
   ├──▶ 5a. Form Request Validation (07.18-form-requests.md)
   │       │
   │       ▼
   │   5b. Action Invocation (07.08-action-layer.md)
   │       │
   │       ▼
   │   5c. Service Invocation (07.06-service-layer.md)
   │       │
   │       ├──▶ 6a. Repository Call (07.07-repository-layer.md)
   │       │       │
   │       │       ▼
   │       │   7a. Model Interaction (07.48-models.md)
   │       │       │
   │       │       ▼
   │       │   7b. Database Query (MySQL)
   │       │       │
   │       │       ▼
   │       │   7c. Result Hydration (Eloquent / DTO)
   │       │
   │       ├──▶ 6b. Cache Check (07.25-cache.md)
   │       │
   │       └──▶ 6c. External Service Call (optional)
   │               │
   │               ▼
   │           6d. Response Mapping
   │
   ├──▶ 8. Action Transaction Commit
   │       │
   │       ├──▶ 9a. Event Dispatch (07.12-events.md)
   │       │       │
   │       │       ▼
   │       │   9b. Listener Execution (07.13-listeners.md)
   │       │       │
   │       │       ├──▶ 10a. Sync Side Effect (immediate)
   │       │       └──▶ 10b. Job Dispatch (07.14-jobs.md)
   │       │               │
   │       │               ▼
   │       │           10c. Queue Worker Pickup
   │       │
   │       └──▶ 9d. Cache Invalidation
   │
   ▼
11. Response Formatting
    │
    ├──▶ 12a. Livewire Component Re-render (Livewire)
    │       │
    │       ▼
    │   12b. Blade Template Rendering (07.20-blade-component-architecture.md)
    │       │
    │       ▼
    │   12c. HTML Response
    │
    ├──▶ 12d. JSON Response (API)
    │       │
    │       ├──▶ 13a. Resource Serialization
    │       ├──▶ 13b. Metadata Attachment
    │       └──▶ 13c. RFC 9457 Error Formatting (on error)
    │
    └──▶ 12e. Redirect Response
            │
            ├──▶ 13d. Flash Messages
            └──▶ 13e. Session State
```

### Lifecycle Timing Budget

| Phase | Budget | Notes |
| --- | --- | --- |
| Middleware pipeline | 5 ms | Includes session, CSRF, CORS |
| Route resolution | < 1 ms | Compiled routes cached |
| Form Request validation | 2 ms | Includes DB lookups for rules |
| Action orchestration | 3 ms | Transaction begin + commit |
| Service logic | 10 ms | Business rules, calculations |
| Repository queries | 15 ms | Includes cache check |
| Model hydration | 5 ms | Eloquent model loading |
| Event dispatch | 3 ms | Listener execution |
| Job dispatch | 2 ms | Queue push |
| Response formatting | 5 ms | Serialization, headers |
| **Total per request** | **< 50 ms** | **P95 target** |

### Lifecycle Observability

Every phase emits structured logs and metrics:

| Phase | Log Entry | Metric | Trace Span |
| --- | --- | --- | --- |
| Middleware | `request.middleware.start` | `http.middleware.duration` | `middleware:{name}` |
| Controller | `request.controller.start` | `http.controller.duration` | `controller:{class}` |
| Action | `request.action.start` | `action.duration` | `action:{class}` |
| Service | `service.method.start` | `service.duration` | `service:{class}.{method}` |
| Repository | `repository.query.start` | `db.query.duration` | `repo:{class}.{method}` |
| Model | `model.operation.start` | `model.duration` | `model:{class}.{op}` |
| Event | `event.dispatched` | `event.duration` | `event:{class}` |
| Job | `job.dispatched` | `job.duration` | `job:{class}` |
| Response | `request.complete` | `http.response.duration` | `response:{status}` |

## Module Isolation Rules

### Module Boundaries

Each module is a self-contained bounded context:

| Module | Owns | Never Directly Accesses |
| --- | --- | --- |
| Components | Component CRUD, versions, dependencies, reviews | Marketplace billing, user profiles |
| Marketplace | Listings, search, reviews, analytics | Component internals, user auth |
| Billing | Plans, subscriptions, invoices, payments | Component code, marketplace data |
| User | Profiles, preferences, notifications, settings | Billing internals, component code |
| CMS | Pages, posts, content blocks, media | Component marketplace, user billing |
| Admin | All management, dashboards, reports | Direct database manipulation |
| Search | Indexes, queries, suggestions | Business logic, persistence |
| AI | Prompts, completions, code generation | Direct DB, user data (except own) |
| Theme | Templates, assets, design tokens | Component code, billing |
| Deployment | Builds, releases, rollbacks | Business logic, user data |

### Cross-Module Communication

Modules communicate via these sanctioned mechanisms:

| Mechanism | Direction | Use Case |
| --- | --- | --- |
| Domain Events | Any → Any | Decoupled side effects |
| Published Contracts | Any → Any | Type-safe cross-module data |
| Service Interfaces | Any → Any | Direct synchronous calls |
| Shared DTOs | Any → Any | Data transfer without coupling |
| Message Queues | Any → Any | Async cross-module work |

### Forbidden Cross-Module Patterns

| Pattern | Why It's Forbidden | Alternative |
| --- | --- |--- |
| Direct model access across modules | Couples persistence schemas | Use published contracts |
| Direct database queries across modules | Breaks aggregate boundaries | Use service interfaces |
| Shared base classes | Creates hidden coupling | Use traits or interfaces |
| Global state mutations | Creates unpredictable side effects | Use events |
| Facade calls across modules | Hides dependencies | Use dependency injection |

## Configuration Architecture

### Configuration Layering

Configuration follows this precedence (last wins):

```
1. Framework Defaults (config/app.php)
   │
   ▼
2. Package Defaults (config/gsmui.php)
   │
   ▼
3. Environment Variables (.env)
   │
   ▼
4. Database Configuration (config table)
   │
   ▼
5. Runtime Overrides (Cache::remember)
```

### Configuration Categories

| Category | Config File | Scope | Cacheable |
| --- | --- | --- | --- |
| App | `config/app.php` | Global | No |
| Database | `config/database.php` | Global | No |
| Cache | `config/cache.php` | Global | No |
| Queue | `config/queue.php` | Global | No |
| Mail | `config/mail.php` | Global | No |
| GsmUi Core | `config/gsmui.php` | Package | Yes |
| GsmUi CSP | `config/gsmui-pro-csp.php` | Package | Yes |
| Marketplace | `config/marketplace.php` | Module | Yes |
| Billing | `config/billing.php` | Module | Yes |
| Search | `config/search.php` | Module | Yes |
| Feature Flags | `config/features.php` | Module | Yes |

### Configuration Validation

All configuration is validated at boot time:

```php
// config/gsmui.php
return [
    'version' => env('GSMUI_VERSION', '3.0.0'),
    'debug' => env('GSMUI_DEBUG', false),
    'search' => [
        'driver' => env('GSMUI_SEARCH_DRIVER', 'meilisearch'),
        'host' => env('GSMUI_SEARCH_HOST', 'http://localhost:7700'),
    ],
    'billing' => [
        'driver' => env('GSMUI_BILLING_DRIVER', 'stripe'),
    ],
];
```

Validation rules:
- All env-based config has sensible defaults
- Required config without defaults throws `ConfigurationException` at boot
- Type checking enforced via PHPStan property types
- Sensitive values are never logged or serialized

## Middleware Stack

### Complete Middleware Pipeline

| Order | Middleware | File | Purpose |
| --- | --- | --- | --- |
| 1 | `TrustProxies` | `app/Http/Middleware/TrustProxies.php` | Proxy header handling |
| 2 | `HandleCors` | `app/Http/Middleware/HandleCors.php` | CORS preflight |
| 3 | `PreventRequestsDuringMaintenance` | `app/Http/Middleware/PreventRequestsDuringMaintenance.php` | Maintenance mode |
| 4 | `ValidatePostSize` | `app/Http/Middleware/ValidatePostSize.php` | POST body size limit |
| 5 | `TrimStrings` | `app/Http/Middleware/TrimStrings.php` | Input whitespace |
| 6 | `ConvertEmptyStringsToNull` | `app/Http/Middleware/ConvertEmptyStringsToNull.php` | Null conversion |
| 7 | `EncryptCookies` | `app/Http/Middleware/EncryptCookies.php` | Cookie encryption |
| 8 | `AddQueuedCookiesToResponse` | `app/Http/Middleware/AddQueuedCookiesToResponse.php` | Cookie attachment |
| 9 | `StartSession` | `app/Http/Middleware/StartSession.php` | Session initialization |
| 10 | `ShareErrorsFromSession` | `app/Http/Middleware/ShareErrorsFromSession.php` | Error sharing |
| 11 | `VerifyCsrfToken` | `app/Http/Middleware/VerifyCsrfToken.php` | CSRF protection |
| 12 | `AuthenticateUser` | `app/Http/Middleware/AuthenticateUser.php` | Auth check |
| 13 | `AuthorizeRequest` | `app/Http/Middleware/AuthorizeRequest.php` | Gate/policy check |
| 14 | `RateLimitRequest` | `app/Http/Middleware/RateLimitRequest.php` | Rate limiting |
| 15 | `CspHeaders` | `vendor/gsmui/gsmui-pro/src/Http/Middleware/CspMiddleware.php` | Content Security Policy |
| 16 | `LogRequest` | `app/Http/Middleware/LogRequest.php` | Request logging |

### Middleware Grouping

```php
// bootstrap/app.php
->withMiddleware(function (Middleware $middleware) {
    $middleware->api(prepend: [
        \App\Http\Middleware\RateLimitRequest::class,
    ]);

    $middleware->web(append: [
        \App\Http\Middleware\LogRequest::class,
        \App\Http\Middleware\CspHeaders::class,
    ]);

    $middleware->validateCsrfTokens(except: [
        'webhooks/*',
        'api/v1/payments/*',
    ]);

    $middleware->authenticateGuests(except: [
        'login',
        'register',
        'password/*',
        'api/*',
    ]);
});
```

### Middleware Execution Log

Every middleware logs entry and exit:

```php
// Example structured log output
{
    "middleware": "RateLimitRequest",
    "request_id": "req_8f3k2j1",
    "user_id": 42,
    "ip": "192.168.1.1",
    "method": "POST",
    "path": "/api/v1/components",
    "entered_at": "2024-01-15T10:30:00.123Z",
    "exited_at": "2024-01-15T10:30:00.145Z",
    "duration_ms": 22,
    "result": "pass"
}
```

## Service Provider Registration

### Provider Boot Order

| Order | Provider | Responsibility |
| --- | --- | --- |
| 1 | `AppServiceProvider` | Application bindings |
| 2 | `AuthServiceProvider` | Gate definitions |
| 3 | `BroadcastServiceProvider` | Event broadcasting |
| 4 | `EventServiceProvider` | Listener registration |
| 5 | `RouteServiceProvider` | Route loading |
| 6 | `GsmuiProServiceProvider` | Core package registration |
| 7 | `MarketplaceServiceProvider` | Marketplace module |
| 8 | `BillingServiceProvider` | Billing module |
| 9 | `SearchServiceProvider` | Search module |
| 10 | `CmsServiceProvider` | CMS module |
| 11 | `AiServiceProvider` | AI module |
| 12 | `AdminServiceProvider` | Admin module |
| 13 | `TelescopeServiceProvider` | Debugging (dev only) |
| 14 | `HorizonServiceProvider` | Queue management |
| 15 | `FortifyServiceProvider` | Authentication |

### Provider Registration Pattern

```php
// Each module provider follows this pattern:
class MarketplaceServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // 1. Bind interfaces to implementations
        $this->app->bind(MarketplaceServiceInterface::class, MarketplaceService::class);
        $this->app->bind(PackageRepositoryInterface::class, PackageRepository::class);

        // 2. Register module-specific config
        $this->mergeConfigFrom(
            __DIR__.'/../../config/marketplace.php',
            'gsmui.marketplace'
        );

        // 3. Register module routes
        $this->loadRoutesFrom(__DIR__.'/../../routes/marketplace.php');

        // 4. Register module views
        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'marketplace');
    }

    public function boot(): void
    {
        // 5. Publish config
        $this->publishes([
            __DIR__.'/../../config/marketplace.php' => config_path('marketplace.php'),
        ], 'marketplace-config');

        // 6. Publish migrations
        $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');

        // 7. Register event listeners
        Event::listen(ComponentInstalled::class, UpdateMarketplaceStats::class);
    }
}
```

### Provider Dependency Map

```
GsmuiProServiceProvider (core)
  │
  ├──▶ EventServiceProvider
  │
  ├──▶ AuthServiceProvider
  │
  ├──▶ RouteServiceProvider
  │
  ├──▶ MarketplaceServiceProvider
  │      │
  │      └──▶ requires: GsmuiProServiceProvider
  │
  ├──▶ BillingServiceProvider
  │      │
  │      └──▶ requires: GsmuiProServiceProvider
  │
  ├──▶ SearchServiceProvider
  │      │
  │      └──▶ requires: GsmuiProServiceProvider, Meilisearch
  │
  ├──▶ CmsServiceProvider
  │      │
  │      └──▶ requires: GsmuiProServiceProvider
  │
  ├──▶ AiServiceProvider
  │      │
  │      └──▶ requires: GsmuiProServiceProvider, API keys
  │
  └──▶ AdminServiceProvider
         │
         └──▶ requires: all module providers
```

## Event System Architecture

### Event Dispatch Flow

```
Domain Action
  │
  ▼
Event::dispatch(new DomainEvent($payload))
  │
  ├──▶ Sync Listeners (executed immediately)
  │       │
  │       ├──▶ Listener 1::handle($event)
  │       ├──▶ Listener 2::handle($event)
  │       └──▶ Listener N::handle($event)
  │
  └──▶ Queued Listeners (dispatched to queue)
          │
          ├──▶ Job 1::dispatch($event)
          ├──▶ Job 2::dispatch($event)
          └──▶ Job N::dispatch($event)
```

### Event Naming Convention

All events use past-tense, domain-specific names:

| Domain | Correct Name | Incorrect Name |
| --- | --- | --- |
| Components | `ComponentInstalled` | `InstallComponent` |
| Components | `VersionPublished` | `PublishVersion` |
| Billing | `PaymentSucceeded` | `ProcessPayment` |
| Billing | `SubscriptionCancelled` | `CancelSubscription` |
| User | `UserRegistered` | `RegisterUser` |
| CMS | `ContentPublished` | `PublishContent` |
| Marketplace | `ReviewSubmitted` | `SubmitReview` |
| Search | `IndexUpdated` | `UpdateIndex` |
| AI | `PromptCompleted` | `CompletePrompt` |

### Event Payload Convention

```php
class ComponentInstalled
{
    public function __construct(
        public readonly int $componentId,
        public readonly string $componentSlug,
        public readonly int $installedByUserId,
        public readonly string $version,
        public readonly array $dependencies,
        public readonly CarbonImmutable $installedAt,
    ) {}
}
```

Rules:
- All properties are `readonly`
- All properties use constructor promotion
- IDs are `int` (not the model instance)
- Timestamps are `CarbonImmutable`
- Related IDs are prefixed (e.g., `installedByUserId`)
- Arrays are typed (e.g., `array $dependencies`)

## Queue Architecture

### Queue Separation

| Queue | Purpose | Worker Count | Priority |
| --- | --- | --- | --- |
| `emails` | All email/notification dispatch | 2 | High |
| `default` | General async work | 3 | Medium |
| `marketplace` | Search indexing, analytics | 1 | Medium |
| `billing` | Payment processing, invoices | 1 | High |
| `exports` | Data exports, reports | 1 | Low |
| `maintenance` | Cleanup, pruning, archival | 1 | Low |

### Job Dispatch Patterns

```php
// Immediate (high priority)
SendWelcomeEmail::dispatch($user)
    ->onQueue('emails')
    ->onConnection('redis');

// Delayed (low priority)
GenerateComponentThumbnails::dispatch($component)
    ->onQueue('exports')
    ->delay(now()->addMinutes(5));

// Unique (prevent duplicates)
IndexPackageJob::dispatch($package)
    ->onQueue('marketplace')
    ->uniqueFor(3600);

// Rate-limited
SyncAnalyticsJob::dispatch($data)
    ->onQueue('marketplace')
    ->withoutOverlapping();
```

## Testing Architecture

### Test Pyramid

```
        ┌───────────┐
        │  Browser  │  10% — Playwright E2E
        │   Tests   │  Critical user journeys
        ├───────────┤
        │ Feature   │  30% — HTTP + Livewire
        │  Tests    │  API contracts, UI flows
        ├───────────┤
        │  Unit     │  60% — Pure PHP
        │  Tests    │  Services, Actions, DTOs, Events
        └───────────┘
```

### Test Organization

| Test Type | Location | Count Target | Run Time Target |
| --- | --- | --- | --- |
| Unit | `tests/Unit/` | 60%+ of total | < 10s total |
| Feature | `tests/Feature/` | 30% of total | < 60s total |
| Browser | `tests/Browser/` | 10% of total | < 120s total |
| Performance | `tests/Performance/` | Key scenarios | < 300s total |

### Test Naming Convention

```php
// Unit tests: test_method_subject_condition
public function test_validate_requires_component_name(): void
public function test_calculate_discount_applies_percentage(): void
public function test_dispatch_event_after_successful_install(): void

// Feature tests: test_endpoint/action_expected_outcome
public function test_post_api_components_returns_created(): void
public function test_livewire_install_component_succeeds(): void
public function test_unauthenticated_user_redirected_to_login(): void

// Browser tests: test_user_can_action_object
public function test_user_can_install_component(): void
public function test_user_can_search_marketplace(): void
public function test_admin_can_approve_listing(): void
```

## Security Architecture

### Security Layers

| Layer | Mechanism | Implementation |
| --- | --- | --- |
| Transport | HTTPS only | `config/app.php` force HTTPS |
| Session | Encrypted cookies, HTTP-only | Laravel session defaults |
| CSRF | Token verification | `VerifyCsrfToken` middleware |
| XSS | Blade auto-escaping, CSP headers | `CspMiddleware` |
| SQL Injection | Eloquent parameterized queries | No raw queries without binding |
| Authentication | Fortify + Sanctum | `app/Providers/FortifyServiceProvider` |
| Authorization | Gates + Policies | `app/Policies/`, `app/Providers/AuthServiceProvider` |
| Rate Limiting | Per-user, per-IP, per-endpoint | `RateLimitRequest` middleware |
| Input Validation | Form Requests, type hints | `app/Http/Requests/` |
| Secrets | `.env` only, never committed | `config/*.php` reads env |
| CSP | Strict policy, nonce-based | `config/gsmui-pro-csp.php` |
| Audit | All mutations logged | `07.54-logging.md` |

### Security Audit Checklist

| Check | Frequency | Owner |
| --- | --- | --- |
| Dependency vulnerabilities | Daily (automated) | CI/CD |
| CSP policy review | Monthly | Security team |
| Auth flow penetration test | Quarterly | Security team |
| Rate limit effectiveness | Monthly | DevOps |
| Secrets rotation | Quarterly | DevOps |
| Audit log review | Weekly | Security team |
| Permission model review | Quarterly | Security team |

## Performance Architecture

### Performance Budget

| Metric | Target | Measurement |
| --- | --- | --- |
| P50 Response Time | < 50ms | Application metrics |
| P95 Response Time | < 150ms | Application metrics |
| P99 Response Time | < 300ms | Application metrics |
| Time to First Byte | < 200ms | Synthetic monitoring |
| Database Query Time | < 10ms per query | Slow query log |
| Cache Hit Rate | > 95% | Redis metrics |
| Queue Wait Time | < 5s P95 | Horizon dashboard |
| Memory Usage | < 128MB per worker | Process monitoring |
| CPU Usage | < 70% average | Infrastructure monitoring |

### Performance Optimization Stack

| Layer | Technique | Impact |
| --- | --- | ---|
| HTTP | HTTP/2, compression, CDN | High |
| Laravel | Route caching, config caching, view caching | High |
| Database | Indexing, query optimization, connection pooling | High |
| Cache | Multi-tier (Redis + in-memory), tag-based invalidation | High |
| Queue | Batch processing, worker pooling, job chunking | Medium |
| Assets | Vite code splitting, lazy loading, prefetching | Medium |
| Search | Index optimization, result caching, suggestion caching | Medium |
| Code | Profiling, dead code removal, algorithm optimization | Low |

## Observability Architecture

### Three Pillars

| Pillar | Tool | Data Collected |
| --- | --- | --- |
| Logs | Datadog Logs | Structured logs from all services |
| Metrics | Datadog APM | Request latency, throughput, errors |
| Traces | Datadog Traces | Distributed tracing across services |

### Key Metrics Dashboard

| Metric | Alert Threshold | Dashboard Panel |
| --- | --- | --- |
| Request Rate | < 10 req/s | Traffic Overview |
| Error Rate | > 1% 5xx | Error Monitoring |
| P95 Latency | > 200ms | Performance Overview |
| Queue Depth | > 1000 jobs | Queue Health |
| Cache Hit Rate | < 90% | Cache Performance |
| DB Connection Pool | > 80% utilized | Database Health |
| Memory Usage | > 80% | Infrastructure Health |

### Alerting Rules

| Condition | Severity | Channel | Response |
| --- | --- | --- | --- |
| Error rate > 5% for 5 min | Critical | PagerDuty | Immediate investigation |
| Error rate > 1% for 15 min | Warning | Slack #alerts | Investigate within 1 hour |
| P95 latency > 500ms for 10 min | Warning | Slack #alerts | Investigate within 1 hour |
| Queue depth > 5000 for 5 min | Critical | PagerDuty | Scale workers |
| Database connections > 90% | Critical | PagerDuty | Scale connection pool |
| Disk usage > 85% | Warning | Slack #ops | Plan expansion |
| SSL cert expires < 30 days | Critical | PagerDuty | Renew immediately |

## Disaster Recovery

### RTO and RPO Targets

| System | RTO | RPO | Backup Frequency |
| --- | --- | --- | --- |
| Application | 15 minutes | 0 (zero data loss) | N/A (stateless) |
| Database | 30 minutes | 5 minutes | Continuous replication |
| Cache | 5 minutes | 5 minutes | Snapshot every 15 min |
| Queue | 10 minutes | 0 (durable queue) | Redis persistence |
| Storage | 15 minutes | 24 hours | Daily S3 snapshots |
| Search | 30 minutes | 1 hour | Index snapshots |

### Recovery Procedures

| Scenario | Procedure | Time | Automation |
| --- | --- | --- | --- |
| Application crash | Auto-healing (ECS) | 2 min | Fully automated |
| Database failure | Failover to replica | 5 min | Automated failover |
| Cache failure | Cold start from snapshot | 10 min | Semi-automated |
| Queue failure | Redis cluster failover | 2 min | Fully automated |
| Full region failure | DNS failover + restore | 60 min | Semi-automated |
| Data corruption | Point-in-time recovery | 30 min | Manual + automated |

---

## Appendix: Section 07 Document Quick Reference

| Doc | Title | Focus |
| --- | --- | --- |
| 07.01 | Overview | Architecture principles, system context, boundaries |
| 07.02 | Request Lifecycle | HTTP pipeline, routing, controller dispatch |
| 07.03 | Domain-Driven Design | Bounded contexts, aggregates, domain events |
| 07.04 | Module Architecture | Module boundaries, inter-module contracts |
| 07.05 | Folder Structure | On-disk layout, file naming, namespace mapping |
| 07.06 | Service Layer | Business logic organization, service interfaces |
| 07.07 | Repository Layer | Data access abstraction, query patterns |
| 07.08 | Action Layer | Application use-case orchestration |
| 07.09 | DTO Layer | Data transfer objects, serialization |
| 07.10 | Value Objects | Immutable domain primitives |
| 07.11 | Enums | Typed enumerations, status machines |
| 07.12 | Events | Domain event dispatch and naming |
| 07.13 | Listeners | Synchronous and async event handling |
| 07.14 | Jobs | Queue job patterns and conventions |
| 07.15 | Policies | Authorization policy structure |
| 07.16 | Gates | Fine-grained authorization checks |
| 07.17 | Validation | Rule composition, custom rules |
| 07.18 | Form Requests | HTTP request validation patterns |
| 07.19 | Livewire Architecture | Livewire component patterns |
| 07.20 | Blade Component Architecture | Blade component conventions |
| 07.21 | API Architecture | RESTful API design and versioning |
| 07.22 | Authentication | Auth flows, tokens, sessions |
| 07.23 | Authorization | Roles, permissions, access control |
| 07.24 | Search | Meilisearch integration, indexing |
| 07.25 | Cache | Multi-tier caching, invalidation |
| 07.26 | Storage | File storage, S3, local disk |
| 07.27 | Notifications | Notification channels and delivery |
| 07.28 | Mail | Email templates, queueing |
| 07.29 | Webhooks | Inbound/outbound webhook patterns |
| 07.30 | Billing | Stripe integration, subscriptions |
| 07.31 | Marketplace | Package listings, reviews, analytics |
| 07.32 | Theme Engine | Theme activation, asset pipeline |
| 07.33 | Component Engine | Component registry, versioning |
| 07.34 | Template Engine | Template rendering, caching |
| 07.35 | Documentation Engine | Auto-generated docs from code |
| 07.36 | Playground Engine | Live code sandbox |
| 07.37 | AI Engine | AI integration, prompt management |
| 07.38 | MCP Server | Model Context Protocol server |
| 07.39 | Admin Platform | Admin dashboard, CRUD tools |
| 07.40 | User Dashboard | User-facing dashboard |
| 07.41 | CMS | Content management patterns |
| 07.42 | Blog | Blog engine, posts, comments |
| 07.43 | Showcase | Component showcase gallery |
| 07.44 | Analytics | Usage analytics, reporting |
| 07.45 | Feature Flags | Feature toggle system |
| 07.46 | Settings | Application settings management |
| 07.47 | Observers | Model observer patterns |
| 07.48 | Models | Eloquent model conventions |
| 07.49 | Queues | Queue configuration and workers |
| 07.50 | Scheduler | Task scheduling patterns |
| 07.51 | CLI Commands | Artisan command conventions |
| 07.52 | Health Checks | System health monitoring |
| 07.53 | Error Handling | Exception hierarchy, rendering |
| 07.54 | Logging | Structured logging, channels |
| 07.55 | Testing | Test strategy, conventions |
| 07.56 | Performance | Optimization strategies |
| 07.57 | Security | Security layers, hardening |
| 07.58 | Deployment | CI/CD, zero-downtime releases |
| 07.59 | Coding Standards | PSR-12, PHPStan, Pint rules |
| 07.60 | Complete Request Flow | End-to-end scenario walkthroughs |

## Cross-Section References

Section 07 connects to these other sections:

| Section | Connection Point | Reference |
| --- | --- | --- |
| Section 01 | Project overview and goals | `01-project-overview.md` |
| Section 02 | Market research and requirements | `02-market-research.md` |
| Section 03 | Product requirements | `03-product-requirements.md` |
| Section 04 | Design system | `04-design-system.md` |
| Section 05 | Architecture concepts | `05-architecture-concepts.md` |
| Section 06 | Feature specifications | `06-feature-specifications.md` |
| Section 08 | Frontend architecture | `08-frontend-architecture.md` |
| Section 09 | API documentation | `09-api-documentation.md` |
| Section 10 | Deployment and operations | `10-deployment-operations.md` |
| Section 11 | Testing strategy | `11-testing-strategy.md` |
| Section 12 | Security specifications | `12-security-specifications.md` |

---

## Operational Rules (Complete Final)

1. Section 07 is the contractor-ready backend architecture blueprint for GsmUi.
2. It expands conceptual material in Section 05 into implementation-level mechanics.
3. It specifies concrete interfaces, class skeletons, method signatures, and pattern rules.
4. It covers the full stack: directory layout, configuration, error handling, middleware, service providers, and testing.
5. The 60 documents follow a strict dependency spine.
6. Each document opens with a standard header and Purpose.
7. Each document cross-links sibling docs by filename.
8. Each document ends with a Next Document pointer.
9. The chain runs from 07.01 to 07.60 to 08-frontend-architecture.md.
10. The dependency spine is: Controller → Action → Service → Repository → Model.
11. Writes always use the full spine; reads skip the Action layer.
12. Events are the only sanctioned way to cross into async work.
13. The repository layer is the only persistence boundary.
14. Domain code throws DomainException subclasses, never HttpException.
15. Handler::render() is the single translation seam for exceptions.
16. API errors use problem+json (RFC 9457).
17. Logs are structured with correlation IDs and PII redaction.
18. Tests cover unit, feature, browser, and performance scenarios.
19. Coding standards enforce PSR-12, PHPStan level 9, and Pint formatting.
20. Deployment uses zero-downtime releases with atomic symlink swap.
21. Modules are isolated and communicate via events.
22. DDD bounded contexts define aggregate roots and domain events.
23. The folder structure is the authoritative on-disk layout.
24. Configuration is layered: framework → package → environment → database.
25. The middleware stack runs in a specific order for every request.
26. Service providers register bindings in a specific order.
27. Events use past tense naming and are dispatched after commit.
28. Queues are separated by priority: emails > default > exports.
29. Tests are organized by type: unit → feature → browser → performance.
30. Security is layered: CSRF, XSS, SQLi, authN, authZ, rate limit, CSP, secrets.
31. Performance targets are defined for every metric.
32. Observability uses the three pillars: logs, metrics, traces.
33. Disaster recovery is documented with RTO and RPO targets.
34. Implementation follows a phased approach: Foundation → Core → Presentation → Infrastructure → Domain → Operational.
35. The total estimated implementation effort is ~91 days (18 weeks).
36. This index document is the single source of truth for Section 07.

---

# Next Document
**08-frontend-architecture.md - Frontend Architecture** The backend blueprint concludes here; frontend architecture continues into Blade, Livewire, and the gsmui component system.
