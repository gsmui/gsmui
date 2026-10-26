# PRD index

Start with the ledger. It is the only part of this directory that is generated
from evidence, and the only part that states what is actually true today.

| File | What it is | Maintained by |
|---|---|---|
| **[`00-ledger.md`](00-ledger.md)** | Every component's status, backed by a render result | `php scripts/prd-ledger.php` — do not edit by hand |
| [`00-status-system.md`](00-status-system.md) | The 8 marks, the evidence gate, how to read the ledger | hand-written |

If the ledger and any other document disagree, the ledger is right. The others
describe intent; the ledger records outcomes.

## The three layers

This directory holds three kinds of document that were previously three
top-level folders (`gsmui-prd/`, `docs/`, `prompts/`). They are now separated by
how much trust they carry, not by topic.

### `spec/` — the canonical specification

**446 files, topics 05–40.** The plan for what gsmui is and will be: system
architecture, database design, backend and frontend architecture, auth,
permissions, billing, subscriptions, components, and the downstream products
(docs engine, marketplace, playground, MCP, CMS, search, admin).

Depth is very uneven, and that is information rather than a defect:

| Depth | Topics |
|---|---|
| Deep (23–143 files each) | 05 architecture, 06 database, 07 backend, 08 frontend, 09 auth, 10 permissions, 12 subscriptions, 13 components |
| Single file | 11 billing, 14–35 (docs engine, marketplace, showcase, playground, theme generator, chart builder, MCP, blog, CMS, search, admin, user dashboard, media library, API, events, jobs, cache, testing, security, devops, CI/CD, folder structure) |
| Empty | 36 database-schema, 37 livewire-architecture, 38 services, 39 mvp, 40 future-features |

The empty and single-file topics are **unwritten**, not unimportant. Treat a
single 60 KB file on a whole subsystem as a sketch and check against `src/` and
`stubs/` before believing it.

### `source/` — the source documentation set

**232 files, topics 01–24.** A second, independently written specification. It
covers the ground `spec/` does not (01 vision, 02 business, 03 design-system,
04 product-planning) and overlaps it for 05–24.

Kept because the early topics have no counterpart in `spec/`, and because the
flat 8–13 files per topic give uniform coverage where `spec/` is lopsided. It
reads as a generated or bulk-authored set — uniform density regardless of how
complicated the topic is — so prefer `spec/` where the two disagree on the same
subject, and prefer `source/` for topics `spec/` doesn't cover.

`source/index.md` is the original entry point for this set and is written as
end-user documentation (URLs like `/docs/components/forms/input`), not as a plan.

### `archive/` — superseded, kept for provenance

**25 files in 2 folders.** Top-level documents from the old layout, the two July 2026 PRD audits, and the merged additions.

- `0.md` — the original table of contents for `gsmui-prd/`. Superseded by this file.
- `01-vision.md`, `02-market-analysis.md`, `03-brand-guidelines.md`, `04-product-roadmap.md` — 105–140 KB each, from the old flat layout.
- `component-builder.md` — the standalone component-builder prompt (from `prompts/`).
- `Untitled-1.md` — a backlog.
- `prd-audit-report.json`, `prd-audit-final.json` — from 2026-07-15/16. They score `overall_score: 83` across **62 files**, and audit **5**. They describe a docs tree that no longer exists, so their numbers must not be quoted.
- `count_lines.ps1` — a one-off that hardcoded `gsmui-prd/09-authentication/`. Dead since the move.
- `merged-additions/` — 15 `05.xx-addition.md` drafts, 377 KB. Each was verified already merged into its target in `spec/05-system-architecture/` (by matching section heading), so they are duplicates, not pending work.

Nothing in `archive/` should be treated as current.

## Why `spec/` and `source/` are not merged

They use **the same two-digit numbers for different topics** from 15 onward.
Merging by number would silently interleave unrelated documents:

| # | `spec/` | `source/` |
|---|---|---|
| 16 | showcase | theme-engine |
| 18 | theme-generator | ai |
| 19 | chart-builder | admin |
| 20 | mcp | user |
| 21 | blog | cms |
| 22 | cms | devops |
| 23 | search | testing |
| 24 | admin-panel | developer |

Topics 01–04 exist only in `source/`; topics 25–40 only in `spec/`. Topics 05–15
agree on numbering and can be read side by side — that is a fair reading, not an
authoritative one.

**Do not renumber either set to reconcile them.** The numbers are referenced
across both trees and in the archive above. If you need a unified view, write a
mapping, don't move the files.

## Adding a document

- New specification work goes in `spec/`, continuing its numbering.
- Something that documents existing behaviour rather than planning it goes in `source/`.
- Status claims go in the ledger only, and only through the pipeline — see `00-status-system.md`.

Current open work is tracked in the ledger's defect table (`D-001`…`D-017`).
