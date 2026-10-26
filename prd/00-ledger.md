---
id: 00-ledger
title: Completion Ledger
status: generated
owner: package
evidence: component-manifest.json + tests/render-smoke-results.json
updated: 2026-10-26
---

# Completion Ledger

> **Generated file — do not edit by hand.** Regenerate with `php scripts/prd-ledger.php`.
> Manual edits are overwritten. To change a status, change the evidence.

This file answers the only question that matters: **what is actually done?**
It replaces the empty `39-mvp/` and `40-future-features/` directories, which
contained no files and therefore answered nothing.

## How status is derived

| Mark | Meaning | Gate |
|---|---|---|
| ✅ shipped | Works end-to-end | render-smoke **pass** AND zero flags |
| 🟡 partial | Exists, known-defective | render-smoke **fail**, or passes with flags, or no `index.blade.php` |
| 🚧 in-progress | Actively being built | assigned, started (manual) |
| 📋 planned | Approved, not started | in roadmap (manual) |
| 💡 proposed | Unapproved idea | in `prd/00-backlog.md` (manual) |
| ⛔ blocked | Cannot proceed | named blocker (manual) |
| 🗑️ deprecated | Slated for removal | has migration note (manual) |
| ❓ unknown | Never audited | **default** — no evidence either way |

Render-smoke source: `tests/render-smoke-results.json` (153 components tested).

## Summary

| Status | Count |
|---|---:|
| ✅ shipped | 88 |
| 🟡 partial | 52 |
| 🚧 in-progress | 0 |
| 📋 planned | 0 |
| 💡 proposed | 0 |
| ⛔ blocked | 0 |
| 🗑️ deprecated | 0 |
| ❓ unknown | 13 |
| **total** | **153** |

## Why components fail (grouped by root cause)

The measured failures are **not** independent bugs. They collapse into a few
shared causes, so the count of fixes needed is far smaller than the count of
failing components. Ordered by blast radius.

| Cause | Description | Components | Count |
|---|---|---|---:|
| **F4** | Uses a variable/prop it never declared | `input`, `menu`, `modal`, `sidebar`, `table`, `tooltip`, `with-field` | 7 |
| **F5** | PHP/Blade syntax error | `combobox`, `datagrid`, `form-builder`, `scheduler` | 4 |

Each cause is one change repeated across components, not N independent bugs.
Fix the cause, re-run the sweep, and watch the count drop.

## Structural defects (non-component)

These are package-level issues found in the audit that block shipped-quality
regardless of any single component. Each has a `file:line` evidence pointer.

| ID | Defect | Evidence | Status |
|---|---|---|---|
| D-001 | `Gsmui` facade was never aliased, so every view threw `Class "Gsmui" not found` | fixed in `src/GsmuiProServiceProvider.php` | ✅ shipped |
| D-002 | API mismatch: 316 views call fluent `Gsmui::classes()->add()`, manager exposed `classes(string): array` | fixed via `src/ClassBuilder.php` | ✅ shipped |
| D-003 | Base dependency `gsmui/gsmui` missing from `composer.json` require | `composer.json` | 🟡 partial |
| D-004 | Malformed SVG in the icon map broke every icon consumer | fixed — `stubs/resources/views/gsmui/icon/index.blade.php:110` (unterminated entry) | ✅ shipped |
| D-005 | `match` arm written inside an array literal, plus an inline style | fixed — `gsmui/avatar/index.blade.php` | ✅ shipped |
| D-006 | Invalid range-slider markup | `gsmui/range-slider/index.blade.php` | 🟡 partial |
| D-007 | Invalid image-gallery markup | `gsmui/image-gallery/index.blade.php` | 🟡 partial |
| D-008 | `include __DIR__` resolved to the compiled-view cache, not the package | fixed — resolves via the `gsmui` view hint | ✅ shipped |
| D-009 | Bogus `route()` calls would throw at runtime | `dock`, `radial-progress`, `steps` | 🟡 partial |
| D-010 | No `phpunit.xml` committed; the suite could not run at all | fixed — `phpunit.xml` added | ✅ shipped |
| D-011 | No render-smoke coverage; regressions were invisible | fixed — `tests/RenderSmokeTest.php` | ✅ shipped |
| D-012 | 599 tags use `<x-gsmui:name>`; Laravel only resolves the `::` form | fixed — normalised in `GsmuiProServiceProvider::registerSingleColonAliases()` | ✅ shipped |
| D-013 | `wire()`/`pluck()` treated as attribute-bag methods; `wire()` only exists during a Livewire request | fixed — macros registered in the provider | ✅ shipped |
| D-014 | `spinner` referenced by `combobox` and `datagrid` but never existed | fixed — component added | ✅ shipped |
| D-015 | `select` had 7 partials and no `index.blade.php` | fixed — `select/index.blade.php` added | ✅ shipped |
| D-016 | `@blaze(...)` used in 701 templates but the package is not a dependency | `composer.json` | 🟡 partial |
| D-017 | 13 gallery components embed every sibling variant in `index` and cannot be render-tested | e.g. `frame` (101 files) | 🟡 partial |

## Component flags by type

### `inline_style` — 51 component(s)

Inline `style=` attributes — CSP/`unsafe-inline` risk and unthemed.

`ai`, `analytics`, `audio`, `auth`, `board`, `browser`, `cache-layer`, `chart`, `color-picker`, `countdown`, `credit-card`, `customization`, `datagrid`, `datagrid-pro`, `description-list`, `dock`, `draw`, `feature-flags`, `file-upload`, `form-builder`, `frame`, `hover`, `image-gallery`, `jobs`, `mask`, `modal`, `phone`, `playground`, `progress`, `query-builder`, `radial-progress`, `range-slider`, `rating`, `scheduler`, `scroll-area`, `skeleton`, `status`, `steps`, `table`, `tablet`, `team`, `templates`, `terminal`, `theme-switcher`, `themes`, `toast`, `tree`, `video`, `whiteboard`, `window`, `workflow-designer`

### `pluck` — 9 component(s)

`->pluck()` inside a Blade view — should be a computed property or method.

`carousel`, `command`, `editor`, `file-item`, `file-upload`, `pillbox`, `slider`, `tab`, `tree`

### `route_call` — 3 component(s)

Calls `route()` on a hardcoded name — throws unless the host app defines that route.

`dock`, `radial-progress`, `steps`

## Full component table

| Component | Tag | Status | Reason | Files | Props | JS |
|---|---|---|---|---:|---:|---|
| `accordion` | `gsmui:accordion` | ✅ shipped | render-smoke pass, no flags | 5 | 2 | yes |
| `activity-log` | `gsmui:activity-log` | ✅ shipped | render-smoke pass, no flags | 1 | 3 | yes |
| `admin-panel` | `gsmui:admin-panel` | ✅ shipped | render-smoke pass, no flags | 1 | 5 | yes |
| `ai` | `gsmui:ai` | 🟡 partial | renders, but has flags: inline_style | 11 | 1 | — |
| `analytics` | `gsmui:analytics` | 🟡 partial | renders, but has flags: inline_style | 1 | 3 | yes |
| `announcements` | `gsmui:announcements` | ✅ shipped | render-smoke pass, no flags | 1 | 2 | yes |
| `api-layer` | `gsmui:api-layer` | ✅ shipped | render-smoke pass, no flags | 1 | 3 | yes |
| `api-tokens` | `gsmui:api-tokens` | ✅ shipped | render-smoke pass, no flags | 1 | 2 | yes |
| `audio` | `gsmui:audio` | 🟡 partial | renders, but has flags: inline_style | 11 | 5 | yes |
| `auth` | `gsmui:auth` | ❓ unknown | gallery page — not unit-testable | 64 | 1 | — |
| `autocomplete` | `gsmui:autocomplete` | ✅ shipped | render-smoke pass, no flags | 3 | 2 | yes |
| `avatar` | `gsmui:avatar` | ✅ shipped | render-smoke pass, no flags | 2 | 19 | yes |
| `backup-manager` | `gsmui:backup-manager` | ✅ shipped | render-smoke pass, no flags | 1 | 3 | yes |
| `badge` | `gsmui:badge` | ✅ shipped | render-smoke pass, no flags | 2 | 8 | yes |
| `billing` | `gsmui:billing` | ✅ shipped | render-smoke pass, no flags | 1 | 5 | yes |
| `blog` | `gsmui:blog` | ✅ shipped | render-smoke pass, no flags | 1 | 4 | yes |
| `board` | `gsmui:board` | ❓ unknown | gallery page — not unit-testable | 22 | 4 | yes |
| `brand` | `gsmui:brand` | ✅ shipped | render-smoke pass, no flags | 1 | 4 | yes |
| `breadcrumbs` | `gsmui:breadcrumbs` | ✅ shipped | render-smoke pass, no flags | 2 | 2 | yes |
| `browser` | `gsmui:browser` | 🟡 partial | renders, but has flags: inline_style | 4 | 3 | yes |
| `button` | `gsmui:button` | ✅ shipped | render-smoke pass, no flags | 2 | 15 | yes |
| `cache-layer` | `gsmui:cache-layer` | 🟡 partial | renders, but has flags: inline_style | 1 | 4 | yes |
| `calendar` | `gsmui:calendar` | ✅ shipped | render-smoke pass, no flags | 1 | 11 | yes |
| `callout` | `gsmui:callout` | ✅ shipped | render-smoke pass, no flags | 1 | 4 | yes |
| `card` | `gsmui:card` | ✅ shipped | render-smoke pass, no flags | 1 | 5 | yes |
| `carousel` | `gsmui:carousel` | 🟡 partial | renders, but has flags: pluck | 3 | 9 | yes |
| `chart` | `gsmui:chart` | 🟡 partial | renders, but has flags: inline_style | 27 | 42 | yes |
| `chat` | `gsmui:chat` | ✅ shipped | render-smoke pass, no flags | 2 | 8 | yes |
| `checkbox` | `gsmui:checkbox` | ✅ shipped | render-smoke pass, no flags | 2 | 8 | yes |
| `clipboard` | `gsmui:clipboard` | ✅ shipped | render-smoke pass, no flags | 1 | 6 | yes |
| `cms` | `gsmui:cms` | ✅ shipped | render-smoke pass, no flags | 1 | 4 | yes |
| `code` | `gsmui:code` | ✅ shipped | render-smoke pass, no flags | 4 | 2 | yes |
| `color-picker` | `gsmui:color-picker` | 🟡 partial | renders, but has flags: inline_style | 9 | 12 | yes |
| `combobox` | `gsmui:combobox` | 🟡 partial | F5 — PHP/Blade syntax error | 1 | 26 | yes |
| `command` | `gsmui:command` | 🟡 partial | renders, but has flags: pluck | 5 | 1 | yes |
| `composer` | `gsmui:composer` | ✅ shipped | render-smoke pass, no flags | 1 | 8 | yes |
| `countdown` | `gsmui:countdown` | 🟡 partial | renders, but has flags: inline_style | 3 | 6 | yes |
| `credit-card` | `gsmui:credit-card` | 🟡 partial | renders, but has flags: inline_style | 11 | 11 | yes |
| `crm` | `gsmui:crm` | ✅ shipped | render-smoke pass, no flags | 1 | 4 | yes |
| `customization` | `gsmui:customization` | 🟡 partial | renders, but has flags: inline_style | 3 | 9 | yes |
| `data-import-export` | `gsmui:data-import-export` | ✅ shipped | render-smoke pass, no flags | 1 | 0 | yes |
| `datagrid` | `gsmui:datagrid` | 🟡 partial | F5 — PHP/Blade syntax error | 1 | 20 | yes |
| `datagrid-pro` | `gsmui:datagrid-pro` | 🟡 partial | renders, but has flags: inline_style | 1 | 21 | yes |
| `date-picker` | `gsmui:date-picker` | ✅ shipped | render-smoke pass, no flags | 6 | 20 | yes |
| `description-list` | `gsmui:description-list` | 🟡 partial | renders, but has flags: inline_style | 1 | 5 | — |
| `diff` | `gsmui:diff` | ✅ shipped | render-smoke pass, no flags | 1 | 7 | yes |
| `divider` | `gsmui:divider` | ✅ shipped | render-smoke pass, no flags | 1 | 7 | yes |
| `dock` | `gsmui:dock` | ❓ unknown | gallery page — not unit-testable | 104 | 1 | — |
| `docs-engine` | `gsmui:docs-engine` | ✅ shipped | render-smoke pass, no flags | 1 | 5 | yes |
| `draw` | `gsmui:draw` | ❓ unknown | gallery page — not unit-testable | 361 | 6 | yes |
| `dropdown` | `gsmui:dropdown` | ✅ shipped | render-smoke pass, no flags | 9 | 5 | yes |
| `editor` | `gsmui:editor` | ❓ unknown | gallery page — not unit-testable | 25 | 4 | yes |
| `email-templates` | `gsmui:email-templates` | ✅ shipped | render-smoke pass, no flags | 1 | 2 | yes |
| `emoji` | `gsmui:emoji` | ✅ shipped | render-smoke pass, no flags | 6 | 5 | — |
| `empty-state` | `gsmui:empty-state` | ✅ shipped | render-smoke pass, no flags | 1 | 5 | yes |
| `errors` | `gsmui:errors` | ✅ shipped | render-smoke pass, no flags | 1 | 5 | yes |
| `events-system` | `gsmui:events-system` | ✅ shipped | render-smoke pass, no flags | 1 | 3 | yes |
| `feature-flags` | `gsmui:feature-flags` | 🟡 partial | renders, but has flags: inline_style | 1 | 2 | yes |
| `field` | `gsmui:field` | ✅ shipped | render-smoke pass, no flags | 6 | 1 | yes |
| `file-item` | `gsmui:file-item` | 🟡 partial | renders, but has flags: pluck | 2 | 9 | yes |
| `file-manager` | `gsmui:file-manager` | ✅ shipped | render-smoke pass, no flags | 1 | 3 | yes |
| `file-upload` | `gsmui:file-upload` | 🟡 partial | renders, but has flags: inline_style, pluck | 2 | 8 | yes |
| `flex` | `gsmui:flex` | ✅ shipped | render-smoke pass, no flags | 2 | 9 | — |
| `form-builder` | `gsmui:form-builder` | 🟡 partial | F5 — PHP/Blade syntax error | 1 | 5 | yes |
| `form-wizard` | `gsmui:form-wizard` | ✅ shipped | render-smoke pass, no flags | 1 | 5 | yes |
| `frame` | `gsmui:frame` | ❓ unknown | gallery page — not unit-testable | 101 | 0 | yes |
| `grid` | `gsmui:grid` | ✅ shipped | render-smoke pass, no flags | 1 | 8 | — |
| `heading` | `gsmui:heading` | ✅ shipped | render-smoke pass, no flags | 1 | 3 | yes |
| `health-dashboard` | `gsmui:health-dashboard` | ✅ shipped | render-smoke pass, no flags | 1 | 3 | yes |
| `help-center` | `gsmui:help-center` | ✅ shipped | render-smoke pass, no flags | 1 | 3 | yes |
| `hero` | `gsmui:hero` | ❓ unknown | gallery page — not unit-testable | 51 | 1 | — |
| `hover` | `gsmui:hover` | 🟡 partial | renders, but has flags: inline_style | 4 | 16 | yes |
| `icon` | `gsmui:icon` | ✅ shipped | render-smoke pass, no flags | 17 | 3 | yes |
| `image-gallery` | `gsmui:image-gallery` | ❓ unknown | gallery page — not unit-testable | 81 | 1 | — |
| `indicator` | `gsmui:indicator` | ✅ shipped | render-smoke pass, no flags | 1 | 9 | yes |
| `input` | `gsmui:input` | 🟡 partial | F4 — Uses a variable/prop it never declared | 1 | 17 | yes |
| `jobs` | `gsmui:jobs` | 🟡 partial | renders, but has flags: inline_style | 1 | 4 | yes |
| `json-viewer` | `gsmui:json-viewer` | ✅ shipped | render-smoke pass, no flags | 1 | 8 | yes |
| `kanban` | `gsmui:kanban` | ✅ shipped | render-smoke pass, no flags | 6 | 2 | yes |
| `kbd` | `gsmui:kbd` | ✅ shipped | render-smoke pass, no flags | 3 | 5 | yes |
| `layouts` | `gsmui:layouts` | ✅ shipped | render-smoke pass, no flags | 11 | 32 | yes |
| `lightbox` | `gsmui:lightbox` | ✅ shipped | render-smoke pass, no flags | 1 | 3 | yes |
| `maintenance-mode` | `gsmui:maintenance-mode` | ✅ shipped | render-smoke pass, no flags | 1 | 4 | yes |
| `marketplace` | `gsmui:marketplace` | ✅ shipped | render-smoke pass, no flags | 1 | 4 | yes |
| `mask` | `gsmui:mask` | 🟡 partial | renders, but has flags: inline_style | 1 | 4 | yes |
| `mcp-server` | `gsmui:mcp-server` | ✅ shipped | render-smoke pass, no flags | 1 | 4 | yes |
| `media-library` | `gsmui:media-library` | ✅ shipped | render-smoke pass, no flags | 1 | 5 | yes |
| `menu` | `gsmui:menu` | 🟡 partial | F4 — Uses a variable/prop it never declared | 3 | 2 | yes |
| `modal` | `gsmui:modal` | 🟡 partial | F4 — Uses a variable/prop it never declared | 3 | 7 | yes |
| `navbar` | `gsmui:navbar` | ✅ shipped | render-smoke pass, no flags | 2 | 1 | yes |
| `navlist` | `gsmui:navlist` | ✅ shipped | render-smoke pass, no flags | 3 | 0 | yes |
| `navmenu` | `gsmui:navmenu` | ✅ shipped | render-smoke pass, no flags | 3 | 1 | yes |
| `notification-center` | `gsmui:notification-center` | ✅ shipped | render-smoke pass, no flags | 1 | 3 | yes |
| `onboarding` | `gsmui:onboarding` | ✅ shipped | render-smoke pass, no flags | 1 | 4 | yes |
| `otp` | `gsmui:otp` | ✅ shipped | render-smoke pass, no flags | 1 | 6 | yes |
| `pagination` | `gsmui:pagination` | ✅ shipped | render-smoke pass, no flags | 1 | 9 | yes |
| `payment-icon-card` | `gsmui:payment-icon-card` | ✅ shipped | render-smoke pass, no flags | 7 | 5 | yes |
| `phone` | `gsmui:phone` | 🟡 partial | renders, but has flags: inline_style | 6 | 3 | yes |
| `pillbox` | `gsmui:pillbox` | 🟡 partial | renders, but has flags: pluck | 13 | 1 | yes |
| `playground` | `gsmui:playground` | 🟡 partial | renders, but has flags: inline_style | 1 | 5 | yes |
| `popover` | `gsmui:popover` | ✅ shipped | render-smoke pass, no flags | 1 | 0 | yes |
| `profile` | `gsmui:profile` | ✅ shipped | render-smoke pass, no flags | 1 | 10 | yes |
| `progress` | `gsmui:progress` | 🟡 partial | renders, but has flags: inline_style | 1 | 5 | yes |
| `query-builder` | `gsmui:query-builder` | 🟡 partial | renders, but has flags: inline_style | 1 | 9 | yes |
| `radial-progress` | `gsmui:radial-progress` | ❓ unknown | gallery page — not unit-testable | 102 | 1 | — |
| `radio` | `gsmui:radio` | ✅ shipped | render-smoke pass, no flags | 2 | 7 | yes |
| `range-slider` | `gsmui:range-slider` | ❓ unknown | gallery page — not unit-testable | 21 | 1 | — |
| `rating` | `gsmui:rating` | 🟡 partial | renders, but has flags: inline_style | 1 | 6 | yes |
| `roles-permissions` | `gsmui:roles-permissions` | ✅ shipped | render-smoke pass, no flags | 1 | 4 | yes |
| `scheduled-tasks` | `gsmui:scheduled-tasks` | ✅ shipped | render-smoke pass, no flags | 1 | 2 | yes |
| `scheduler` | `gsmui:scheduler` | 🟡 partial | F5 — PHP/Blade syntax error | 1 | 11 | yes |
| `scroll-area` | `gsmui:scroll-area` | 🟡 partial | renders, but has flags: inline_style | 1 | 4 | — |
| `search` | `gsmui:search` | ✅ shipped | render-smoke pass, no flags | 1 | 6 | yes |
| `select` | `gsmui:select` | ✅ shipped | render-smoke pass, no flags | 17 | 9 | yes |
| `seo-manager` | `gsmui:seo-manager` | ✅ shipped | render-smoke pass, no flags | 1 | 3 | yes |
| `separator` | `gsmui:separator` | ✅ shipped | render-smoke pass, no flags | 1 | 4 | yes |
| `sidebar` | `gsmui:sidebar` | 🟡 partial | F4 — Uses a variable/prop it never declared | 3 | 5 | yes |
| `skeleton` | `gsmui:skeleton` | 🟡 partial | renders, but has flags: inline_style | 1 | 4 | yes |
| `slider` | `gsmui:slider` | 🟡 partial | renders, but has flags: pluck | 2 | 1 | yes |
| `social-auth` | `gsmui:social-auth` | ✅ shipped | render-smoke pass, no flags | 1 | 0 | yes |
| `spacer` | `gsmui:spacer` | ✅ shipped | render-smoke pass, no flags | 1 | 2 | — |
| `spinner` | `gsmui:spinner` | ✅ shipped | render-smoke pass, no flags | 1 | 2 | — |
| `stack` | `gsmui:stack` | ✅ shipped | render-smoke pass, no flags | 1 | 7 | — |
| `stat` | `gsmui:stat` | ✅ shipped | render-smoke pass, no flags | 1 | 6 | yes |
| `status` | `gsmui:status` | ❓ unknown | gallery page — not unit-testable | 107 | 0 | — |
| `steps` | `gsmui:steps` | ❓ unknown | gallery page — not unit-testable | 53 | 1 | — |
| `survey-builder` | `gsmui:survey-builder` | ✅ shipped | render-smoke pass, no flags | 1 | 2 | yes |
| `switch` | `gsmui:switch` | ✅ shipped | render-smoke pass, no flags | 1 | 6 | yes |
| `tab` | `gsmui:tab` | 🟡 partial | renders, but has flags: pluck | 3 | 7 | yes |
| `table` | `gsmui:table` | 🟡 partial | F4 — Uses a variable/prop it never declared | 5 | 2 | yes |
| `tablet` | `gsmui:tablet` | 🟡 partial | renders, but has flags: inline_style | 5 | 4 | yes |
| `tag` | `gsmui:tag` | ✅ shipped | render-smoke pass, no flags | 1 | 8 | yes |
| `team` | `gsmui:team` | 🟡 partial | renders, but has flags: inline_style | 12 | 13 | yes |
| `templates` | `gsmui:templates` | ❓ unknown | gallery page — not unit-testable | 263 | 1 | yes |
| `terminal` | `gsmui:terminal` | 🟡 partial | renders, but has flags: inline_style | 3 | 3 | yes |
| `text` | `gsmui:text` | ✅ shipped | render-smoke pass, no flags | 2 | 4 | yes |
| `textarea` | `gsmui:textarea` | ✅ shipped | render-smoke pass, no flags | 1 | 6 | yes |
| `theme-switcher` | `gsmui:theme-switcher` | 🟡 partial | renders, but has flags: inline_style | 1 | 4 | yes |
| `themes` | `gsmui:themes` | 🟡 partial | renders, but has flags: inline_style | 2 | 2 | yes |
| `time-picker` | `gsmui:time-picker` | ✅ shipped | render-smoke pass, no flags | 4 | 9 | yes |
| `timeline` | `gsmui:timeline` | ✅ shipped | render-smoke pass, no flags | 6 | 3 | yes |
| `toast` | `gsmui:toast` | 🟡 partial | renders, but has flags: inline_style | 1 | 2 | yes |
| `tooltip` | `gsmui:tooltip` | 🟡 partial | F4 — Uses a variable/prop it never declared | 2 | 9 | yes |
| `translations` | `gsmui:translations` | ✅ shipped | render-smoke pass, no flags | 1 | 3 | yes |
| `tree` | `gsmui:tree` | 🟡 partial | renders, but has flags: inline_style, pluck | 2 | 7 | yes |
| `two-factor-auth` | `gsmui:two-factor-auth` | ✅ shipped | render-smoke pass, no flags | 1 | 4 | yes |
| `user-dashboard` | `gsmui:user-dashboard` | ✅ shipped | render-smoke pass, no flags | 1 | 5 | yes |
| `video` | `gsmui:video` | 🟡 partial | renders, but has flags: inline_style | 11 | 7 | yes |
| `webhooks` | `gsmui:webhooks` | ✅ shipped | render-smoke pass, no flags | 1 | 3 | yes |
| `whiteboard` | `gsmui:whiteboard` | 🟡 partial | renders, but has flags: inline_style | 1 | 4 | yes |
| `window` | `gsmui:window` | 🟡 partial | renders, but has flags: inline_style | 3 | 5 | yes |
| `with-field` | `gsmui:with-field` | 🟡 partial | F4 — Uses a variable/prop it never declared | 1 | 13 | yes |
| `workflow-designer` | `gsmui:workflow-designer` | 🟡 partial | renders, but has flags: inline_style | 1 | 7 | yes |
