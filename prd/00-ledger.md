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

Render-smoke source: `tests/render-smoke-results.json` (152 components tested).

## Summary

| Status | Count |
|---|---:|
| ✅ shipped | 87 |
| 🟡 partial | 53 |
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

Fixing each cause is a single change repeated across components — e.g. F1/F2
need one helper, not 12 edits. Fix order: F1, F2, F3, F5 (blocking), then F4, F6.

## Structural defects (non-component)

These are package-level issues found in the audit that block shipped-quality
regardless of any single component. Each has a `file:line` evidence pointer.

| ID | Defect | Evidence | Status |
|---|---|---|---|
| D-001 | `Gsmui` facade was never aliased, so every view threw `Class "Gsmui" not found` | fixed in `src/GsmuiProServiceProvider.php` | ✅ shipped |
| D-002 | API mismatch: 316 views call fluent `Gsmui::classes()->add()`, manager exposed `classes(string): array` | fixed via `src/ClassBuilder.php` | ✅ shipped |
| D-003 | Base dependency `gsmui/gsmui` missing from `composer.json` require | `composer.json` | 🟡 partial |
| D-004 | Malformed SVG cascades to every icon consumer | `stubs/resources/views/gsmui/icon/index.blade.php:113` | 🟡 partial |
| D-005 | Invalid markup | `gsmui/avatar/index.blade.php:35` | 🟡 partial |
| D-006 | Invalid range-slider markup | `gsmui/range-slider/index.blade.php:29-30` | 🟡 partial |
| D-007 | Invalid image-gallery markup | `gsmui/image-gallery/index.blade.php:128` | 🟡 partial |
| D-008 | Themes reference broken | `gsmui/themes/index.blade.php:9` | 🟡 partial |
| D-009 | Bogus `route()` calls would throw at runtime | `dock`, `radial-progress`, `steps` | 🟡 partial |
| D-010 | No `phpunit.xml` committed; suite could not run at all | fixed — `phpunit.xml` added | ✅ shipped |
| D-011 | No render-smoke coverage; regressions were invisible | fixed — `tests/RenderSmokeTest.php` (151 components) | ✅ shipped |

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

### `missing_index` — 1 component(s)

No `index.blade.php` — the component cannot be used via `gsmui:<name>`.

`select`

## Full component table

| Component | Tag | Status | Reason | Files | Props | JS |
|---|---|---|---|---:|---:|---|
| [`accordion`](../docs/03-components/accordion.md) | `gsmui:accordion` | ✅ shipped | render-smoke pass, no flags | 5 | 2 | yes |
| [`activity-log`](../docs/03-components/activity-log.md) | `gsmui:activity-log` | ✅ shipped | render-smoke pass, no flags | 1 | 3 | yes |
| [`admin-panel`](../docs/03-components/admin-panel.md) | `gsmui:admin-panel` | ✅ shipped | render-smoke pass, no flags | 1 | 5 | yes |
| [`ai`](../docs/03-components/ai.md) | `gsmui:ai` | 🟡 partial | renders, but has flags: inline_style | 11 | 1 | — |
| [`analytics`](../docs/03-components/analytics.md) | `gsmui:analytics` | 🟡 partial | renders, but has flags: inline_style | 1 | 3 | yes |
| [`announcements`](../docs/03-components/announcements.md) | `gsmui:announcements` | ✅ shipped | render-smoke pass, no flags | 1 | 2 | yes |
| [`api-layer`](../docs/03-components/api-layer.md) | `gsmui:api-layer` | ✅ shipped | render-smoke pass, no flags | 1 | 3 | yes |
| [`api-tokens`](../docs/03-components/api-tokens.md) | `gsmui:api-tokens` | ✅ shipped | render-smoke pass, no flags | 1 | 2 | yes |
| [`audio`](../docs/03-components/audio.md) | `gsmui:audio` | 🟡 partial | renders, but has flags: inline_style | 11 | 5 | yes |
| [`auth`](../docs/03-components/auth.md) | `gsmui:auth` | ❓ unknown | gallery page — not unit-testable | 64 | 1 | — |
| [`autocomplete`](../docs/03-components/autocomplete.md) | `gsmui:autocomplete` | ✅ shipped | render-smoke pass, no flags | 3 | 2 | yes |
| [`avatar`](../docs/03-components/avatar.md) | `gsmui:avatar` | ✅ shipped | render-smoke pass, no flags | 2 | 19 | yes |
| [`backup-manager`](../docs/03-components/backup-manager.md) | `gsmui:backup-manager` | ✅ shipped | render-smoke pass, no flags | 1 | 3 | yes |
| [`badge`](../docs/03-components/badge.md) | `gsmui:badge` | ✅ shipped | render-smoke pass, no flags | 2 | 8 | yes |
| [`billing`](../docs/03-components/billing.md) | `gsmui:billing` | ✅ shipped | render-smoke pass, no flags | 1 | 5 | yes |
| [`blog`](../docs/03-components/blog.md) | `gsmui:blog` | ✅ shipped | render-smoke pass, no flags | 1 | 4 | yes |
| [`board`](../docs/03-components/board.md) | `gsmui:board` | ❓ unknown | gallery page — not unit-testable | 22 | 4 | yes |
| [`brand`](../docs/03-components/brand.md) | `gsmui:brand` | ✅ shipped | render-smoke pass, no flags | 1 | 4 | yes |
| [`breadcrumbs`](../docs/03-components/breadcrumbs.md) | `gsmui:breadcrumbs` | ✅ shipped | render-smoke pass, no flags | 2 | 2 | yes |
| [`browser`](../docs/03-components/browser.md) | `gsmui:browser` | 🟡 partial | renders, but has flags: inline_style | 4 | 3 | yes |
| [`button`](../docs/03-components/button.md) | `gsmui:button` | ✅ shipped | render-smoke pass, no flags | 2 | 15 | yes |
| [`cache-layer`](../docs/03-components/cache-layer.md) | `gsmui:cache-layer` | 🟡 partial | renders, but has flags: inline_style | 1 | 4 | yes |
| [`calendar`](../docs/03-components/calendar.md) | `gsmui:calendar` | ✅ shipped | render-smoke pass, no flags | 1 | 11 | yes |
| [`callout`](../docs/03-components/callout.md) | `gsmui:callout` | ✅ shipped | render-smoke pass, no flags | 1 | 4 | yes |
| [`card`](../docs/03-components/card.md) | `gsmui:card` | ✅ shipped | render-smoke pass, no flags | 1 | 5 | yes |
| [`carousel`](../docs/03-components/carousel.md) | `gsmui:carousel` | 🟡 partial | renders, but has flags: pluck | 3 | 9 | yes |
| [`chart`](../docs/03-components/chart.md) | `gsmui:chart` | 🟡 partial | renders, but has flags: inline_style | 27 | 42 | yes |
| [`chat`](../docs/03-components/chat.md) | `gsmui:chat` | ✅ shipped | render-smoke pass, no flags | 2 | 8 | yes |
| [`checkbox`](../docs/03-components/checkbox.md) | `gsmui:checkbox` | ✅ shipped | render-smoke pass, no flags | 2 | 8 | yes |
| [`clipboard`](../docs/03-components/clipboard.md) | `gsmui:clipboard` | ✅ shipped | render-smoke pass, no flags | 1 | 6 | yes |
| [`cms`](../docs/03-components/cms.md) | `gsmui:cms` | ✅ shipped | render-smoke pass, no flags | 1 | 4 | yes |
| [`code`](../docs/03-components/code.md) | `gsmui:code` | ✅ shipped | render-smoke pass, no flags | 4 | 2 | yes |
| [`color-picker`](../docs/03-components/color-picker.md) | `gsmui:color-picker` | 🟡 partial | renders, but has flags: inline_style | 9 | 12 | yes |
| [`combobox`](../docs/03-components/combobox.md) | `gsmui:combobox` | 🟡 partial | F5 — PHP/Blade syntax error | 1 | 26 | yes |
| [`command`](../docs/03-components/command.md) | `gsmui:command` | 🟡 partial | renders, but has flags: pluck | 5 | 1 | yes |
| [`composer`](../docs/03-components/composer.md) | `gsmui:composer` | ✅ shipped | render-smoke pass, no flags | 1 | 8 | yes |
| [`countdown`](../docs/03-components/countdown.md) | `gsmui:countdown` | 🟡 partial | renders, but has flags: inline_style | 3 | 6 | yes |
| [`credit-card`](../docs/03-components/credit-card.md) | `gsmui:credit-card` | 🟡 partial | renders, but has flags: inline_style | 11 | 11 | yes |
| [`crm`](../docs/03-components/crm.md) | `gsmui:crm` | ✅ shipped | render-smoke pass, no flags | 1 | 4 | yes |
| [`customization`](../docs/03-components/customization.md) | `gsmui:customization` | 🟡 partial | renders, but has flags: inline_style | 3 | 9 | yes |
| [`data-import-export`](../docs/03-components/data-import-export.md) | `gsmui:data-import-export` | ✅ shipped | render-smoke pass, no flags | 1 | 0 | yes |
| [`datagrid`](../docs/03-components/datagrid.md) | `gsmui:datagrid` | 🟡 partial | F5 — PHP/Blade syntax error | 1 | 20 | yes |
| [`datagrid-pro`](../docs/03-components/datagrid-pro.md) | `gsmui:datagrid-pro` | 🟡 partial | renders, but has flags: inline_style | 1 | 21 | yes |
| [`date-picker`](../docs/03-components/date-picker.md) | `gsmui:date-picker` | ✅ shipped | render-smoke pass, no flags | 6 | 20 | yes |
| [`description-list`](../docs/03-components/description-list.md) | `gsmui:description-list` | 🟡 partial | renders, but has flags: inline_style | 1 | 5 | — |
| [`diff`](../docs/03-components/diff.md) | `gsmui:diff` | ✅ shipped | render-smoke pass, no flags | 1 | 7 | yes |
| [`divider`](../docs/03-components/divider.md) | `gsmui:divider` | ✅ shipped | render-smoke pass, no flags | 1 | 7 | yes |
| [`dock`](../docs/03-components/dock.md) | `gsmui:dock` | ❓ unknown | gallery page — not unit-testable | 104 | 1 | — |
| [`docs-engine`](../docs/03-components/docs-engine.md) | `gsmui:docs-engine` | ✅ shipped | render-smoke pass, no flags | 1 | 5 | yes |
| [`draw`](../docs/03-components/draw.md) | `gsmui:draw` | ❓ unknown | gallery page — not unit-testable | 361 | 6 | yes |
| [`dropdown`](../docs/03-components/dropdown.md) | `gsmui:dropdown` | ✅ shipped | render-smoke pass, no flags | 9 | 5 | yes |
| [`editor`](../docs/03-components/editor.md) | `gsmui:editor` | ❓ unknown | gallery page — not unit-testable | 25 | 4 | yes |
| [`email-templates`](../docs/03-components/email-templates.md) | `gsmui:email-templates` | ✅ shipped | render-smoke pass, no flags | 1 | 2 | yes |
| [`emoji`](../docs/03-components/emoji.md) | `gsmui:emoji` | ✅ shipped | render-smoke pass, no flags | 6 | 5 | — |
| [`empty-state`](../docs/03-components/empty-state.md) | `gsmui:empty-state` | ✅ shipped | render-smoke pass, no flags | 1 | 5 | yes |
| [`errors`](../docs/03-components/errors.md) | `gsmui:errors` | ✅ shipped | render-smoke pass, no flags | 1 | 5 | yes |
| [`events-system`](../docs/03-components/events-system.md) | `gsmui:events-system` | ✅ shipped | render-smoke pass, no flags | 1 | 3 | yes |
| [`feature-flags`](../docs/03-components/feature-flags.md) | `gsmui:feature-flags` | 🟡 partial | renders, but has flags: inline_style | 1 | 2 | yes |
| [`field`](../docs/03-components/field.md) | `gsmui:field` | ✅ shipped | render-smoke pass, no flags | 6 | 1 | yes |
| [`file-item`](../docs/03-components/file-item.md) | `gsmui:file-item` | 🟡 partial | renders, but has flags: pluck | 2 | 9 | yes |
| [`file-manager`](../docs/03-components/file-manager.md) | `gsmui:file-manager` | ✅ shipped | render-smoke pass, no flags | 1 | 3 | yes |
| [`file-upload`](../docs/03-components/file-upload.md) | `gsmui:file-upload` | 🟡 partial | renders, but has flags: inline_style, pluck | 2 | 8 | yes |
| [`flex`](../docs/03-components/flex.md) | `gsmui:flex` | ✅ shipped | render-smoke pass, no flags | 2 | 9 | — |
| [`form-builder`](../docs/03-components/form-builder.md) | `gsmui:form-builder` | 🟡 partial | F5 — PHP/Blade syntax error | 1 | 5 | yes |
| [`form-wizard`](../docs/03-components/form-wizard.md) | `gsmui:form-wizard` | ✅ shipped | render-smoke pass, no flags | 1 | 5 | yes |
| [`frame`](../docs/03-components/frame.md) | `gsmui:frame` | ❓ unknown | gallery page — not unit-testable | 101 | 0 | yes |
| [`grid`](../docs/03-components/grid.md) | `gsmui:grid` | ✅ shipped | render-smoke pass, no flags | 1 | 8 | — |
| [`heading`](../docs/03-components/heading.md) | `gsmui:heading` | ✅ shipped | render-smoke pass, no flags | 1 | 3 | yes |
| [`health-dashboard`](../docs/03-components/health-dashboard.md) | `gsmui:health-dashboard` | ✅ shipped | render-smoke pass, no flags | 1 | 3 | yes |
| [`help-center`](../docs/03-components/help-center.md) | `gsmui:help-center` | ✅ shipped | render-smoke pass, no flags | 1 | 3 | yes |
| [`hero`](../docs/03-components/hero.md) | `gsmui:hero` | ❓ unknown | gallery page — not unit-testable | 51 | 1 | — |
| [`hover`](../docs/03-components/hover.md) | `gsmui:hover` | 🟡 partial | renders, but has flags: inline_style | 4 | 16 | yes |
| [`icon`](../docs/03-components/icon.md) | `gsmui:icon` | ✅ shipped | render-smoke pass, no flags | 17 | 3 | yes |
| [`image-gallery`](../docs/03-components/image-gallery.md) | `gsmui:image-gallery` | ❓ unknown | gallery page — not unit-testable | 81 | 1 | — |
| [`indicator`](../docs/03-components/indicator.md) | `gsmui:indicator` | ✅ shipped | render-smoke pass, no flags | 1 | 9 | yes |
| [`input`](../docs/03-components/input.md) | `gsmui:input` | 🟡 partial | F4 — Uses a variable/prop it never declared | 1 | 17 | yes |
| [`jobs`](../docs/03-components/jobs.md) | `gsmui:jobs` | 🟡 partial | renders, but has flags: inline_style | 1 | 4 | yes |
| [`json-viewer`](../docs/03-components/json-viewer.md) | `gsmui:json-viewer` | ✅ shipped | render-smoke pass, no flags | 1 | 8 | yes |
| [`kanban`](../docs/03-components/kanban.md) | `gsmui:kanban` | ✅ shipped | render-smoke pass, no flags | 6 | 2 | yes |
| [`kbd`](../docs/03-components/kbd.md) | `gsmui:kbd` | ✅ shipped | render-smoke pass, no flags | 3 | 5 | yes |
| [`layouts`](../docs/03-components/layouts.md) | `gsmui:layouts` | ✅ shipped | render-smoke pass, no flags | 11 | 32 | yes |
| [`lightbox`](../docs/03-components/lightbox.md) | `gsmui:lightbox` | ✅ shipped | render-smoke pass, no flags | 1 | 3 | yes |
| [`maintenance-mode`](../docs/03-components/maintenance-mode.md) | `gsmui:maintenance-mode` | ✅ shipped | render-smoke pass, no flags | 1 | 4 | yes |
| [`marketplace`](../docs/03-components/marketplace.md) | `gsmui:marketplace` | ✅ shipped | render-smoke pass, no flags | 1 | 4 | yes |
| [`mask`](../docs/03-components/mask.md) | `gsmui:mask` | 🟡 partial | renders, but has flags: inline_style | 1 | 4 | yes |
| [`mcp-server`](../docs/03-components/mcp-server.md) | `gsmui:mcp-server` | ✅ shipped | render-smoke pass, no flags | 1 | 4 | yes |
| [`media-library`](../docs/03-components/media-library.md) | `gsmui:media-library` | ✅ shipped | render-smoke pass, no flags | 1 | 5 | yes |
| [`menu`](../docs/03-components/menu.md) | `gsmui:menu` | 🟡 partial | F4 — Uses a variable/prop it never declared | 3 | 2 | yes |
| [`modal`](../docs/03-components/modal.md) | `gsmui:modal` | 🟡 partial | F4 — Uses a variable/prop it never declared | 3 | 7 | yes |
| [`navbar`](../docs/03-components/navbar.md) | `gsmui:navbar` | ✅ shipped | render-smoke pass, no flags | 2 | 1 | yes |
| [`navlist`](../docs/03-components/navlist.md) | `gsmui:navlist` | ✅ shipped | render-smoke pass, no flags | 3 | 0 | yes |
| [`navmenu`](../docs/03-components/navmenu.md) | `gsmui:navmenu` | ✅ shipped | render-smoke pass, no flags | 3 | 1 | yes |
| [`notification-center`](../docs/03-components/notification-center.md) | `gsmui:notification-center` | ✅ shipped | render-smoke pass, no flags | 1 | 3 | yes |
| [`onboarding`](../docs/03-components/onboarding.md) | `gsmui:onboarding` | ✅ shipped | render-smoke pass, no flags | 1 | 4 | yes |
| [`otp`](../docs/03-components/otp.md) | `gsmui:otp` | ✅ shipped | render-smoke pass, no flags | 1 | 6 | yes |
| [`pagination`](../docs/03-components/pagination.md) | `gsmui:pagination` | ✅ shipped | render-smoke pass, no flags | 1 | 9 | yes |
| [`payment-icon-card`](../docs/03-components/payment-icon-card.md) | `gsmui:payment-icon-card` | ✅ shipped | render-smoke pass, no flags | 7 | 5 | yes |
| [`phone`](../docs/03-components/phone.md) | `gsmui:phone` | 🟡 partial | renders, but has flags: inline_style | 6 | 3 | yes |
| [`pillbox`](../docs/03-components/pillbox.md) | `gsmui:pillbox` | 🟡 partial | renders, but has flags: pluck | 13 | 1 | yes |
| [`playground`](../docs/03-components/playground.md) | `gsmui:playground` | 🟡 partial | renders, but has flags: inline_style | 1 | 5 | yes |
| [`popover`](../docs/03-components/popover.md) | `gsmui:popover` | ✅ shipped | render-smoke pass, no flags | 1 | 0 | yes |
| [`profile`](../docs/03-components/profile.md) | `gsmui:profile` | ✅ shipped | render-smoke pass, no flags | 1 | 10 | yes |
| [`progress`](../docs/03-components/progress.md) | `gsmui:progress` | 🟡 partial | renders, but has flags: inline_style | 1 | 5 | yes |
| [`query-builder`](../docs/03-components/query-builder.md) | `gsmui:query-builder` | 🟡 partial | renders, but has flags: inline_style | 1 | 9 | yes |
| [`radial-progress`](../docs/03-components/radial-progress.md) | `gsmui:radial-progress` | ❓ unknown | gallery page — not unit-testable | 102 | 1 | — |
| [`radio`](../docs/03-components/radio.md) | `gsmui:radio` | ✅ shipped | render-smoke pass, no flags | 2 | 7 | yes |
| [`range-slider`](../docs/03-components/range-slider.md) | `gsmui:range-slider` | ❓ unknown | gallery page — not unit-testable | 21 | 1 | — |
| [`rating`](../docs/03-components/rating.md) | `gsmui:rating` | 🟡 partial | renders, but has flags: inline_style | 1 | 6 | yes |
| [`roles-permissions`](../docs/03-components/roles-permissions.md) | `gsmui:roles-permissions` | ✅ shipped | render-smoke pass, no flags | 1 | 4 | yes |
| [`scheduled-tasks`](../docs/03-components/scheduled-tasks.md) | `gsmui:scheduled-tasks` | ✅ shipped | render-smoke pass, no flags | 1 | 2 | yes |
| [`scheduler`](../docs/03-components/scheduler.md) | `gsmui:scheduler` | 🟡 partial | F5 — PHP/Blade syntax error | 1 | 11 | yes |
| [`scroll-area`](../docs/03-components/scroll-area.md) | `gsmui:scroll-area` | 🟡 partial | renders, but has flags: inline_style | 1 | 4 | — |
| [`search`](../docs/03-components/search.md) | `gsmui:search` | ✅ shipped | render-smoke pass, no flags | 1 | 6 | yes |
| [`select`](../docs/03-components/select.md) | `gsmui:select` | 🟡 partial | no index.blade.php | 16 | 1 | yes |
| [`seo-manager`](../docs/03-components/seo-manager.md) | `gsmui:seo-manager` | ✅ shipped | render-smoke pass, no flags | 1 | 3 | yes |
| [`separator`](../docs/03-components/separator.md) | `gsmui:separator` | ✅ shipped | render-smoke pass, no flags | 1 | 4 | yes |
| [`sidebar`](../docs/03-components/sidebar.md) | `gsmui:sidebar` | 🟡 partial | F4 — Uses a variable/prop it never declared | 3 | 5 | yes |
| [`skeleton`](../docs/03-components/skeleton.md) | `gsmui:skeleton` | 🟡 partial | renders, but has flags: inline_style | 1 | 4 | yes |
| [`slider`](../docs/03-components/slider.md) | `gsmui:slider` | 🟡 partial | renders, but has flags: pluck | 2 | 1 | yes |
| [`social-auth`](../docs/03-components/social-auth.md) | `gsmui:social-auth` | ✅ shipped | render-smoke pass, no flags | 1 | 0 | yes |
| [`spacer`](../docs/03-components/spacer.md) | `gsmui:spacer` | ✅ shipped | render-smoke pass, no flags | 1 | 2 | — |
| [`spinner`](../docs/03-components/spinner.md) | `gsmui:spinner` | ✅ shipped | render-smoke pass, no flags | 1 | 2 | — |
| [`stack`](../docs/03-components/stack.md) | `gsmui:stack` | ✅ shipped | render-smoke pass, no flags | 1 | 7 | — |
| [`stat`](../docs/03-components/stat.md) | `gsmui:stat` | ✅ shipped | render-smoke pass, no flags | 1 | 6 | yes |
| [`status`](../docs/03-components/status.md) | `gsmui:status` | ❓ unknown | gallery page — not unit-testable | 107 | 0 | — |
| [`steps`](../docs/03-components/steps.md) | `gsmui:steps` | ❓ unknown | gallery page — not unit-testable | 53 | 1 | — |
| [`survey-builder`](../docs/03-components/survey-builder.md) | `gsmui:survey-builder` | ✅ shipped | render-smoke pass, no flags | 1 | 2 | yes |
| [`switch`](../docs/03-components/switch.md) | `gsmui:switch` | ✅ shipped | render-smoke pass, no flags | 1 | 6 | yes |
| [`tab`](../docs/03-components/tab.md) | `gsmui:tab` | 🟡 partial | renders, but has flags: pluck | 3 | 7 | yes |
| [`table`](../docs/03-components/table.md) | `gsmui:table` | 🟡 partial | F4 — Uses a variable/prop it never declared | 5 | 2 | yes |
| [`tablet`](../docs/03-components/tablet.md) | `gsmui:tablet` | 🟡 partial | renders, but has flags: inline_style | 5 | 4 | yes |
| [`tag`](../docs/03-components/tag.md) | `gsmui:tag` | ✅ shipped | render-smoke pass, no flags | 1 | 8 | yes |
| [`team`](../docs/03-components/team.md) | `gsmui:team` | 🟡 partial | renders, but has flags: inline_style | 12 | 13 | yes |
| [`templates`](../docs/03-components/templates.md) | `gsmui:templates` | ❓ unknown | gallery page — not unit-testable | 263 | 1 | yes |
| [`terminal`](../docs/03-components/terminal.md) | `gsmui:terminal` | 🟡 partial | renders, but has flags: inline_style | 3 | 3 | yes |
| [`text`](../docs/03-components/text.md) | `gsmui:text` | ✅ shipped | render-smoke pass, no flags | 2 | 4 | yes |
| [`textarea`](../docs/03-components/textarea.md) | `gsmui:textarea` | ✅ shipped | render-smoke pass, no flags | 1 | 6 | yes |
| [`theme-switcher`](../docs/03-components/theme-switcher.md) | `gsmui:theme-switcher` | 🟡 partial | renders, but has flags: inline_style | 1 | 4 | yes |
| [`themes`](../docs/03-components/themes.md) | `gsmui:themes` | 🟡 partial | renders, but has flags: inline_style | 2 | 2 | yes |
| [`time-picker`](../docs/03-components/time-picker.md) | `gsmui:time-picker` | ✅ shipped | render-smoke pass, no flags | 4 | 9 | yes |
| [`timeline`](../docs/03-components/timeline.md) | `gsmui:timeline` | ✅ shipped | render-smoke pass, no flags | 6 | 3 | yes |
| [`toast`](../docs/03-components/toast.md) | `gsmui:toast` | 🟡 partial | renders, but has flags: inline_style | 1 | 2 | yes |
| [`tooltip`](../docs/03-components/tooltip.md) | `gsmui:tooltip` | 🟡 partial | F4 — Uses a variable/prop it never declared | 2 | 9 | yes |
| [`translations`](../docs/03-components/translations.md) | `gsmui:translations` | ✅ shipped | render-smoke pass, no flags | 1 | 3 | yes |
| [`tree`](../docs/03-components/tree.md) | `gsmui:tree` | 🟡 partial | renders, but has flags: inline_style, pluck | 2 | 7 | yes |
| [`two-factor-auth`](../docs/03-components/two-factor-auth.md) | `gsmui:two-factor-auth` | ✅ shipped | render-smoke pass, no flags | 1 | 4 | yes |
| [`user-dashboard`](../docs/03-components/user-dashboard.md) | `gsmui:user-dashboard` | ✅ shipped | render-smoke pass, no flags | 1 | 5 | yes |
| [`video`](../docs/03-components/video.md) | `gsmui:video` | 🟡 partial | renders, but has flags: inline_style | 11 | 7 | yes |
| [`webhooks`](../docs/03-components/webhooks.md) | `gsmui:webhooks` | ✅ shipped | render-smoke pass, no flags | 1 | 3 | yes |
| [`whiteboard`](../docs/03-components/whiteboard.md) | `gsmui:whiteboard` | 🟡 partial | renders, but has flags: inline_style | 1 | 4 | yes |
| [`window`](../docs/03-components/window.md) | `gsmui:window` | 🟡 partial | renders, but has flags: inline_style | 3 | 5 | yes |
| [`with-field`](../docs/03-components/with-field.md) | `gsmui:with-field` | 🟡 partial | F4 — Uses a variable/prop it never declared | 1 | 13 | yes |
| [`workflow-designer`](../docs/03-components/workflow-designer.md) | `gsmui:workflow-designer` | 🟡 partial | renders, but has flags: inline_style | 1 | 7 | yes |
