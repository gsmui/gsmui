---
id: 00-status-system
title: Status and Evidence System
status: shipped
owner: package
evidence: scripts/prd-ledger.php + prd/00-ledger.md
updated: 2026-10-27
---

# Status and Evidence System

Every claim about completion in this repository resolves to one of eight marks,
and each mark has a **gate** — a mechanical test that must pass before the mark
may be used.

The previous documentation set could not answer "what is done?". It held 197
unchecked boxes, 8 checked ones, and 46 files using `Status:` with four
conflicting vocabularies. Checkboxes were never aggregated, so no file, script,
or human could produce an answer from them. `39-mvp/` and `40-features/` — the
two directories that were supposed to hold the answer — were empty.

## The eight marks

| Mark | Meaning | Gate |
|---|---|---|
| ✅ shipped | Works end-to-end | render-smoke **pass** AND zero structural flags |
| 🟡 partial | Exists, known-defective | render-smoke **fail**, passes with flags, or missing `index.blade.php` |
| 🚧 in-progress | Actively being built | assigned to a person, work started |
| 📋 planned | Approved, not started | appears in the roadmap |
| 💡 proposed | Unapproved idea | appears in `00-backlog.md` |
| ⛔ blocked | Cannot proceed | a named blocker is recorded |
| 🗑️ deprecated | Slated for removal | a migration note exists |
| ❓ unknown | Never audited | **the default** |

## The one rule

**A status requires evidence. Evidence is a passing test or a `file:line`.**

Concretely, no component may be marked ✅ unless
`tests/render-smoke-results.json` records `pass` for it. The status is not
typed into a document — it is computed:

```
stubs/resources/views/gsmui/  →  scripts/build-component-manifest.php
                                        ↓
                              component-manifest.json
                                        ↓
              tests/RenderSmokeTest.php ──→ render-smoke-results.json
                                        ↓
                              scripts/prd-ledger.php
                                        ↓
                                 prd/00-ledger.md
```

Because `00-ledger.md` is generated, editing it by hand has no effect. To change
a status you must change the evidence — fix the component, re-run the sweep,
regenerate. This is the whole point: the ledger cannot drift from reality.

## Why `unknown` is the default

An unaudited component is not "probably fine". Of the 151 components with an
`index.blade.php`, 131 render and 9 do not; 13 are gallery pages that embed
every sibling variant and cannot be rendered as a unit. Assuming the best
without a test is exactly the reasoning that produced an empty MVP directory.

## Current state

| Status | Count |
|---|---:|
| ✅ shipped | 90 |
| 🟡 partial | 50 |
| ❓ unknown | 13 |

Of the 153 components, 131 render and 9 do not; 13 are gallery pages that embed
every sibling variant and cannot be rendered as a unit.

The gap between 90 and the 131 that render is structural flags — inline styles,
`route()` calls, `pluck()` misuse. Those components work but violate stated house
rules, so they stay 🟡 until the flags clear. This distinction is the ledger's
main value: "renders" and "meets the house standard" are different claims, and
only the second one earns ✅.

## From 0 to 90, measured

The starting state of this repository had no way to answer the status question at
all. Establishing the sweep immediately corrected a pessimistic guess: a static
audit had suggested 97 of 151 components were broken. The measured figure was 47.
The difference was one missing facade alias, which failed every component that
touched `Gsmui::classes()` — a single line that looked like 47 bugs.

The remaining 9 failures collapse into two causes: 4 Blade syntax errors
(`combobox`, `datagrid`, `form-builder`, `scheduler`) and 5 components that read a
variable or slot property that nothing guarantees (`menu`, `modal`, `sidebar`,
`table`, `tooltip`). `input` was in the second group and is fixed: it read
`$slot->icon` in an expression where `||` bound tighter than `??`.

That pattern held: 34 measured failures collapsed into 6 root causes, and after
fixing those causes the remaining failures collapsed into 2. Failures cluster.
Counting them is misleading; classifying them is what makes them fixable, which
is why the ledger groups by cause instead of listing components alphabetically.

## Adding a component

1. Create `stubs/resources/views/gsmui/<name>/index.blade.php`.
2. Run `php scripts/build-component-manifest.php`.
3. Run the sweep: `php scripts/run-smoke.php`.
4. Run `php scripts/prd-ledger.php`.
5. The component appears in the ledger at whatever status the evidence supports.

Do not add a ✅ by hand. There is nowhere to put one.
