# Complete Permission Matrix

## Overview

This document provides the complete permission matrix for gsmui — mapping every role against every feature, CRUD operation, API endpoint, and UI element. Use this as the source of truth for authorization configuration.

## Roles × Features Grid

| Feature | super_admin | admin | creator | user | viewer |
|---------|:-----------:|:-----:|:-------:|:----:|:------:|
| **Users** | | | | | |
| Create users | ✅ | ✅ | ❌ | ❌ | ❌ |
| View users | ✅ | ✅ | ❌ | ❌ | ❌ |
| Update users | ✅ | ✅ | ❌ | ❌ | ❌ |
| Delete users | ✅ | ❌ | ❌ | ❌ | ❌ |
| Impersonate users | ✅ | ❌ | ❌ | ❌ | ❌ |
| Ban users | ✅ | ✅ | ❌ | ❌ | ❌ |
| **Roles & Permissions** | | | | | |
| Manage roles | ✅ | ❌ | ❌ | ❌ | ❌ |
| Assign roles | ✅ | ❌ | ❌ | ❌ | ❌ |
| View permissions | ✅ | ❌ | ❌ | ❌ | ❌ |
| Create custom roles | ✅ | ❌ | ❌ | ❌ | ❌ |
| **Content — Posts** | | | | | |
| Create posts | ✅ | ✅ | ✅ | ❌ | ❌ |
| View own posts | ✅ | ✅ | ✅ | ❌ | ❌ |
| View any posts | ✅ | ✅ | ✅ | ✅ | ✅ |
| Update own posts | ✅ | ✅ | ✅ | ❌ | ❌ |
| Update any posts | ✅ | ✅ | ❌ | ❌ | ❌ |
| Delete own posts | ✅ | ✅ | ❌ | ❌ | ❌ |
| Delete any posts | ✅ | ✅ | ❌ | ❌ | ❌ |
| Publish posts | ✅ | ✅ | ✅ | ❌ | ❌ |
| Feature posts | ✅ | ✅ | ❌ | ❌ | ❌ |
| Sticky posts | ✅ | ✅ | ❌ | ❌ | ❌ |
| Schedule posts | ✅ | ✅ | ✅ | ❌ | ❌ |
| Export posts | ✅ | ✅ | ❌ | ❌ | ❌ |
| **Content — Pages** | | | | | |
| Create pages | ✅ | ✅ | ✅ | ❌ | ❌ |
| View pages | ✅ | ✅ | ✅ | ✅ | ✅ |
| Update pages | ✅ | ✅ | ✅ | ❌ | ❌ |
| Delete pages | ✅ | ✅ | ❌ | ❌ | ❌ |
| Publish pages | ✅ | ✅ | ✅ | ❌ | ❌ |
| **Content — Media** | | | | | |
| Upload media | ✅ | ✅ | ✅ | ✅ | ❌ |
| View media | ✅ | ✅ | ✅ | ✅ | ✅ |
| Delete media | ✅ | ✅ | ❌ | ❌ | ❌ |
| **Comments** | | | | | |
| View comments | ✅ | ✅ | ✅ | ✅ | ✅ |
| Moderate comments | ✅ | ✅ | ❌ | ❌ | ❌ |
| Delete comments | ✅ | ✅ | ❌ | ❌ | ❌ |
| **Settings** | | | | | |
| View settings | ✅ | ✅ | ❌ | ❌ | ❌ |
| Update settings | ✅ | ✅ | ❌ | ❌ | ❌ |
| Manage integrations | ✅ | ✅ | ❌ | ❌ | ❌ |
| **Billing** | | | | | |
| View billing | ✅ | ✅ | ❌ | ❌ | ❌ |
| Manage billing | ✅ | ✅ | ❌ | ❌ | ❌ |
| View invoices | ✅ | ✅ | ✅ | ✅ | ❌ |
| Issue refunds | ✅ | ✅ | ❌ | ❌ | ❌ |
| **API** | | | | | |
| Access API | ✅ | ✅ | ✅ | ✅ | ❌ |
| Manage API keys | ✅ | ✅ | ❌ | ❌ | ❌ |
| View API logs | ✅ | ✅ | ❌ | ❌ | ❌ |
| **Reports** | | | | | |
| View analytics | ✅ | ✅ | ✅ | ❌ | ❌ |
| Export reports | ✅ | ✅ | ❌ | ❌ | ❌ |
| View audit log | ✅ | ❌ | ❌ | ❌ | ❌ |

## CRUD Permissions

| Resource | Create | Read | Update | Delete | Scope |
|----------|:------:|:----:|:------:|:------:|-------|
| User | `users.create` | `users.read` | `users.update` | `users.delete` | Global |
| Post | `posts.create` | `posts.read` | `posts.update` | `posts.delete` | Global or own |
| Page | `pages.create` | `pages.read` | `pages.update` | `pages.delete` | Global |
| Comment | `comments.create` | `comments.read` | `comments.update` | `comments.delete` | Own |
| Media | `media.upload` | `media.read` | `media.update` | `media.delete` | Global or own |
| Role | `roles.create` | `roles.read` | `roles.update` | `roles.delete` | Global |
| Permission | `permissions.create` | `permissions.read` | `permissions.update` | `permissions.delete` | Global |
| Team | `teams.create` | `teams.read` | `teams.update` | `teams.delete` | Owned teams |
| Invoice | — | `invoices.read` | — | — | Own |
| Subscription | — | `subscriptions.read` | `subscriptions.update` | `subscriptions.cancel` | Own |
| Settings | — | `settings.read` | `settings.update` | — | Global |

## API Permissions

| Endpoint | Method | Permission | Scope |
|----------|--------|------------|-------|
| `GET /api/users` | `GET` | `users.read` | Global |
| `POST /api/users` | `POST` | `users.create` | Global |
| `PUT /api/users/{id}` | `PUT` | `users.update` | Global or self |
| `DELETE /api/users/{id}` | `DELETE` | `users.delete` | Global |
| `GET /api/posts` | `GET` | `posts.read` | Published: any, Drafts: own |
| `POST /api/posts` | `POST` | `posts.create` | Global |
| `PUT /api/posts/{id}` | `PUT` | `posts.update` | Own |
| `DELETE /api/posts/{id}` | `DELETE` | `posts.delete` | Own (unpublished) |
| `GET /api/pages` | `GET` | `pages.read` | Published |
| `POST /api/pages` | `POST` | `pages.create` | Global |
| `PUT /api/pages/{id}` | `PUT` | `pages.update` | Global |
| `DELETE /api/pages/{id}` | `DELETE` | `pages.delete` | Global |
| `GET /api/comments` | `GET` | `comments.read` | Published |
| `POST /api/comments` | `POST` | `comments.create` | Authenticated |
| `DELETE /api/comments/{id}` | `DELETE` | `comments.delete` | Own or moderate |
| `GET /api/media` | `GET` | `media.read` | Global |
| `POST /api/media` | `POST` | `media.upload` | Authenticated |
| `DELETE /api/media/{id}` | `DELETE` | `media.delete` | Own |
| `GET /api/settings` | `GET` | `settings.read` | Admin+ |
| `PUT /api/settings` | `PUT` | `settings.update` | Admin+ |
| `GET /api/reports/{type}` | `GET` | `reports.view` | Admin+ |
| `POST /api/reports/export` | `POST` | `reports.export` | Admin+ |

## UI Permissions

| UI Element | Permission | Component | Notes |
|------------|------------|-----------|-------|
| User Management Nav | `users.read` | `sidebar` | Visible in admin panel |
| Create User Button | `users.create` | `users/index.blade.php` | |
| Edit User Button | `users.update` | `users/show.blade.php` | |
| Delete User Button | `users.delete` | `users/show.blade.php` | |
| New Post Button | `posts.create` | `posts/index.blade.php` | |
| Edit Post Button | `posts.update` | `posts/show.blade.php` | Own or any |
| Delete Post Button | `posts.delete` | `posts/show.blade.php` | Own (unpublished) |
| Publish Post Button | `posts.publish` | `posts/edit.blade.php` | |
| Settings Nav | `settings.read` | `sidebar` | Visible to admin+ |
| Billing Nav | `billing.read` | `sidebar` | Visible to admin+ |
| API Keys Section | `api.manage` | `settings/api.blade.php` | |
| Export Button | `reports.export` | `reports/index.blade.php` | |
| Audit Log Nav | `audit.read` | `sidebar` | Super admin only |

## Wildcard Patterns

| Pattern | Matches | Scope |
|---------|---------|-------|
| `*` | All permissions | Everything |
| `users.*` | All user permissions | User management |
| `posts.*` | All post permissions | Post management |
| `*.create` | All create operations | Global |
| `*.read` | All read operations | Global |
| `*.update` | All update operations | Global |
| `*.delete` | All delete operations | Global |
| `settings.*` | All settings permissions | System config |
| `billing.*` | All billing permissions | Financial |

## Permission Conflict Resolution

| Scenario | Resolution |
|----------|------------|
| `allow` vs `deny` | `deny` wins |
| Global `allow` vs team `deny` | Team `deny` wins within team |
| Role `allow` vs role `deny` | Least restrictive wins (global), most restrictive (team) |
| Inherited `allow` vs direct `deny` | Direct `deny` always wins |
| Two roles with different permissions | Permissions are additive |

## Migration Guide

### Adding New Permissions

```php
// database/migrations/xxxx_add_new_permissions.php
Schema::table('permissions', function (Blueprint $table) {
    $table->string('name')->unique();
});

Permission::create(['name' => 'new.feature', 'set' => 'features']);
```

### Updating the Matrix

1. Add permission to `config/permissions.php`
2. Run `php artisan permissions:sync`
3. Update this document
4. Assign to appropriate roles
5. Test with Playwright
6. Deploy with migration

## Best Practices

1. **Least privilege** — start with the most restrictive role and grant up
2. **Audit quarterly** — review matrix against actual usage patterns
3. **Document exceptions** — any deviation from the matrix should be recorded
4. **Test edge cases** — especially cross-team and multi-role scenarios
5. **Version control** — keep this matrix in sync with code changes
6. **Automate checks** — use CI to verify permissions match the matrix
