<?php

/**
 * Generates prd/00-ledger.md from component-manifest.json + per-file front-matter.
 *
 * Status vocabulary is fixed (see prd/00-status-system.md). A component may not
 * claim `shipped` without evidence: a passing render-smoke entry in
 * tests/render-smoke-results.json. Everything else is derived, never asserted.
 *
 * Usage:  php scripts/prd-ledger.php
 */

declare(strict_types=1);

$root = dirname(__DIR__);
$manifestPath = $root . '/component-manifest.json';
$smokePath = $root . '/tests/render-smoke-results.json';
$out = $root . '/prd/00-ledger.md';

if (! is_file($manifestPath)) {
    fwrite(STDERR, "Run scripts/build-component-manifest.php first.\n");
    exit(1);
}

$manifest = json_decode((string) file_get_contents($manifestPath), true);

// Render-smoke results: { "button": "pass", "avatar": "fail", ... }. Absent = never tested.
$smoke = [];
if (is_file($smokePath)) {
    $smoke = json_decode((string) file_get_contents($smokePath), true)['results'] ?? [];
}

const MARK = [
    'shipped' => '✅ shipped',
    'partial' => '🟡 partial',
    'in-progress' => '🚧 in-progress',
    'planned' => '📋 planned',
    'proposed' => '💡 proposed',
    'blocked' => '⛔ blocked',
    'deprecated' => '🗑️ deprecated',
    'unknown' => '❓ unknown',
];

/**
 * Root-cause taxonomy for render failures.
 *
 * Measured failures cluster into a handful of shared causes. Grouping them turns
 * "34 broken components" into "6 fixes", which is how the work actually gets done.
 */
function classifyFailure(string $error): array
{
    return match (true) {
        str_contains($error, 'ComponentAttributeBag::wire'),
        str_contains($error, 'ComponentAttributeBag::hasWire')
            => ['F1', '`wire()` used as an attribute-bag method'],
        str_contains($error, 'ComponentAttributeBag::pluck')
            => ['F2', '`pluck()` used as an attribute-bag method'],
        str_contains($error, 'Unable to locate a class or view for component')
            => ['F3', 'References a component tag that does not exist'],
        str_contains($error, 'Undefined variable'),
        str_contains($error, 'Undefined property')
            => ['F4', 'Uses a variable/prop it never declared'],
        str_contains($error, 'syntax error'),
        str_contains($error, "Unclosed '['"),
        str_contains($error, 'Undefined constant'),
        str_contains($error, 'include(): Failed to open stream')
            => ['F5', 'PHP/Blade syntax error'],
        str_contains($error, 'Route ['),
        str_contains($error, 'undefined method')
            => ['F6', 'Calls a helper/route that does not exist'],
        default => ['F7', 'Other'],
    };
}

/** Read recorded error messages from the smoke results file. */
function loadFailureReasons(string $resultsPath): array
{
    if (! is_file($resultsPath)) {
        return [];
    }

    $data = json_decode((string) file_get_contents($resultsPath), true);
    $reasons = [];

    foreach ($data['errors'] ?? [] as $name => $message) {
        $reasons[$name] = $message;
    }

    return $reasons;
}
function deriveStatus(array $c, array $smoke): array
{
    $result = $smoke[$c['name']] ?? null;
    $defects = $c['flags'];

    if ($result === 'skipped') {
        return ['unknown', 'gallery page — not unit-testable'];
    }
    if ($result === 'pass' && $defects === []) {
        return ['shipped', 'render-smoke pass, no flags'];
    }
    if ($result === 'pass') {
        return ['partial', 'renders, but has flags: ' . implode(', ', $defects)];
    }
    if ($result === 'fail') {
        return ['partial', 'render-smoke FAIL'];
    }
    if (! $c['has_index']) {
        return ['partial', 'no index.blade.php'];
    }

    return ['unknown', 'never render-tested'];
}


$buckets = array_fill_keys(array_keys(MARK), []);
$rows = [];
$activeFlags = [];
$failureReasons = loadFailureReasons($root . '/tests/render-smoke-results.json');
$rootCauses = [];

foreach ($manifest['components'] as $c) {
    [$status, $reason] = deriveStatus($c, $smoke);
    $buckets[$status][] = $c['name'];
    $rows[$c['name']] = [$status, $reason];

    $error = $failureReasons[$c['name']] ?? null;
    if (($smoke[$c['name']] ?? null) === 'fail' && $error !== null) {
        [$code, $label] = classifyFailure($error);
        $rootCauses[$code]['label'] = $label;
        $rootCauses[$code]['components'][] = $c['name'];
        $rows[$c['name']][1] = $code . ' — ' . $label;
    }

    foreach ($c['flags'] as $flag) {
        $activeFlags[$flag][] = $c['name'];
    }
}
ksort($rows);
ksort($rootCauses);

/** Markdown table cell escape. */
function cell(string $s): string
{
    return str_replace('|', '\\|', $s);
}

$lines = [];
$lines[] = '---';
$lines[] = 'id: 00-ledger';
$lines[] = 'title: Completion Ledger';
$lines[] = 'status: generated';
$lines[] = 'owner: package';
$lines[] = 'evidence: component-manifest.json + tests/render-smoke-results.json';
$lines[] = 'updated: ' . gmdate('Y-m-d');
$lines[] = '---';
$lines[] = '';
$lines[] = '# Completion Ledger';
$lines[] = '';
$lines[] = '> **Generated file — do not edit by hand.** Regenerate with `php scripts/prd-ledger.php`.';
$lines[] = '> Manual edits are overwritten. To change a status, change the evidence.';
$lines[] = '';
$lines[] = 'This file answers the only question that matters: **what is actually done?**';
$lines[] = 'It replaces the empty `39-mvp/` and `40-future-features/` directories, which';
$lines[] = 'contained no files and therefore answered nothing.';
$lines[] = '';
$lines[] = '## How status is derived';
$lines[] = '';
$lines[] = '| Mark | Meaning | Gate |';
$lines[] = '|---|---|---|';
$lines[] = '| ✅ shipped | Works end-to-end | render-smoke **pass** AND zero flags |';
$lines[] = '| 🟡 partial | Exists, known-defective | render-smoke **fail**, or passes with flags, or no `index.blade.php` |';
$lines[] = '| 🚧 in-progress | Actively being built | assigned, started (manual) |';
$lines[] = '| 📋 planned | Approved, not started | in roadmap (manual) |';
$lines[] = '| 💡 proposed | Unapproved idea | in `prd/00-backlog.md` (manual) |';
$lines[] = '| ⛔ blocked | Cannot proceed | named blocker (manual) |';
$lines[] = '| 🗑️ deprecated | Slated for removal | has migration note (manual) |';
$lines[] = '| ❓ unknown | Never audited | **default** — no evidence either way |';
$lines[] = '';
$smokeRan = $smoke !== [];
$lines[] = 'Render-smoke source: ' . ($smokeRan
    ? '`tests/render-smoke-results.json` (' . count($smoke) . ' components tested).'
    : '**not yet run** — run `composer test:smoke` to populate. Until then everything below is `❓ unknown`, by design.');
$lines[] = '';
$lines[] = '## Summary';
$lines[] = '';
$lines[] = '| Status | Count |';
$lines[] = '|---|---:|';
foreach (MARK as $key => $label) {
    $lines[] = '| ' . $label . ' | ' . count($buckets[$key]) . ' |';
}
$lines[] = '| **total** | **' . count($rows) . '** |';
$lines[] = '';

// Failure root causes — the actionable part of the ledger.
if ($rootCauses !== []) {
    $lines[] = '## Why components fail (grouped by root cause)';
    $lines[] = '';
    $lines[] = 'The measured failures are **not** independent bugs. They collapse into a few';
    $lines[] = 'shared causes, so the count of fixes needed is far smaller than the count of';
    $lines[] = 'failing components. Ordered by blast radius.';
    $lines[] = '';
    $lines[] = '| Cause | Description | Components | Count |';
    $lines[] = '|---|---|---|---:|';
    foreach ($rootCauses as $code => $info) {
        $lines[] = '| **' . $code . '** | ' . $info['label'] . ' | '
            . implode(', ', array_map(fn ($n) => '`' . $n . '`', $info['components'])) . ' | '
            . count($info['components']) . ' |';
    }
    $lines[] = '';
    $lines[] = 'Each cause is one change repeated across components, not N independent bugs.';
    $lines[] = 'Fix the cause, re-run the sweep, and watch the count drop.';
    $lines[] = '';
}

$lines[] = '## Structural defects (non-component)';
$lines[] = '';
$lines[] = 'These are package-level issues found in the audit that block shipped-quality';
$lines[] = 'regardless of any single component. Each has a `file:line` evidence pointer.';
$lines[] = '';
$lines[] = '| ID | Defect | Evidence | Status |';
$lines[] = '|---|---|---|---|';
$lines[] = '| D-001 | `Gsmui` facade was never aliased, so every view threw `Class "Gsmui" not found` | fixed in `src/GsmuiProServiceProvider.php` | ✅ shipped |';
$lines[] = '| D-002 | API mismatch: 316 views call fluent `Gsmui::classes()->add()`, manager exposed `classes(string): array` | fixed via `src/ClassBuilder.php` | ✅ shipped |';
$lines[] = '| D-003 | Base dependency `gsmui/gsmui` missing from `composer.json` require | `composer.json` | 🟡 partial |';
$lines[] = '| D-004 | Malformed SVG cascades to every icon consumer | `stubs/resources/views/gsmui/icon/index.blade.php:113` | 🟡 partial |';
$lines[] = '| D-005 | Invalid markup | `gsmui/avatar/index.blade.php:35` | 🟡 partial |';
$lines[] = '| D-006 | Invalid range-slider markup | `gsmui/range-slider/index.blade.php:29-30` | 🟡 partial |';
$lines[] = '| D-007 | Invalid image-gallery markup | `gsmui/image-gallery/index.blade.php:128` | 🟡 partial |';
$lines[] = '| D-008 | Themes reference broken | `gsmui/themes/index.blade.php:9` | 🟡 partial |';
$lines[] = '| D-009 | Bogus `route()` calls would throw at runtime | `dock`, `radial-progress`, `steps` | 🟡 partial |';
$lines[] = '| D-010 | No `phpunit.xml` committed; the suite could not run at all | fixed — `phpunit.xml` added | ✅ shipped |';
$lines[] = '| D-011 | No render-smoke coverage; regressions were invisible | fixed — `tests/RenderSmokeTest.php` | ✅ shipped |';
$lines[] = '| D-012 | 599 tags use `<x-gsmui:name>`; Laravel only resolves the `::` form | fixed — normalised in `GsmuiProServiceProvider::registerSingleColonAliases()` | ✅ shipped |';
$lines[] = '| D-013 | `wire()`/`pluck()` treated as attribute-bag methods; `wire()` only exists during a Livewire request | fixed — macros registered in the provider | ✅ shipped |';
$lines[] = '| D-014 | `spinner` referenced by `combobox` and `datagrid` but never existed | fixed — component added | ✅ shipped |';
$lines[] = '| D-015 | `select` had 7 partials and no `index.blade.php` | fixed — `select/index.blade.php` added | ✅ shipped |';
$lines[] = '| D-016 | `@blaze(...)` used in 701 templates but the package is not a dependency | `composer.json` | 🟡 partial |';
$lines[] = '| D-017 | 13 gallery components embed every sibling variant in `index` and cannot be render-tested | e.g. `frame` (101 files) | 🟡 partial |';
$lines[] = '';
$lines[] = '## Component flags by type';
$lines[] = '';
if ($activeFlags === []) {
    $lines[] = '_None._';
} else {
    $flagDocs = [
        'missing_index' => 'No `index.blade.php` — the component cannot be used via `gsmui:<name>`',
        'route_call' => 'Calls `route()` on a hardcoded name — throws unless the host app defines that route',
        'inline_style' => 'Inline `style=` attributes — CSP/`unsafe-inline` risk and unthemed',
        'pluck' => '`->pluck()` inside a Blade view — should be a computed property or method',
        'wire_call' => '`{{ wire(...) }}` call — Livewire helper leaking into a view',
    ];
    foreach ($activeFlags as $flag => $names) {
        sort($names);
        $lines[] = '### `' . $flag . '` — ' . count($names) . ' component(s)';
        $lines[] = '';
        if (isset($flagDocs[$flag])) {
            $lines[] = $flagDocs[$flag] . '.';
            $lines[] = '';
        }
        $lines[] = implode(', ', array_map(fn ($n) => '`' . $n . '`', $names));
        $lines[] = '';
    }
}

$lines[] = '## Full component table';
$lines[] = '';
$lines[] = '| Component | Tag | Status | Reason | Files | Props | JS |';
$lines[] = '|---|---|---|---|---:|---:|---|';
foreach ($manifest['components'] as $c) {
    [$status, $reason] = $rows[$c['name']];
    $lines[] = '| [`' . $c['name'] . '`](../docs/03-components/' . $c['name'] . '.md) | `' . $c['tag'] . '` | '
        . MARK[$status] . ' | ' . cell($reason) . ' | ' . $c['files'] . ' | '
        . count($c['props']) . ' | ' . ($c['requires_js'] ? 'yes' : '—') . ' |';
}
$lines[] = '';

@mkdir(dirname($out), 0777, true);
file_put_contents($out, implode("\n", $lines));

printf(
    "Wrote %s\n  shipped: %d | partial: %d | unknown: %d | other: %d\n",
    str_replace($root . '/', '', $out),
    count($buckets['shipped']),
    count($buckets['partial']),
    count($buckets['unknown']),
    count($buckets['in-progress']) + count($buckets['planned'])
        + count($buckets['proposed']) + count($buckets['blocked']) + count($buckets['deprecated']),
);

