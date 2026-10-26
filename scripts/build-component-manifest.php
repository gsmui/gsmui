<?php

/**
 * Builds component-manifest.json from the Blade component tree.
 *
 * Single source of truth for: docs/03-components/**, prd/00-ledger.md and
 * mcp/gsmui-server. Everything downstream reads the JSON, never the Blade tree,
 * so the three artifacts cannot drift apart.
 *
 * Usage:  php scripts/build-component-manifest.php
 */

declare(strict_types=1);

$root = dirname(__DIR__);
$views = $root . '/stubs/resources/views/gsmui';
$out = $root . '/component-manifest.json';

if (! is_dir($views)) {
    fwrite(STDERR, "Component directory not found: {$views}\n");
    exit(1);
}

/** Recursively list Blade files for a component directory. */
function bladeFiles(string $dir): array
{
    $files = [];
    $it = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir, FilesystemIterator::SKIP_DOTS));
    foreach ($it as $file) {
        if ($file->isFile() && str_ends_with($file->getFilename(), '.blade.php')) {
            $files[] = str_replace('\\', '/', $file->getPathname());
        }
    }
    sort($files);

    return $files;
}

/**
 * Parse `@props([...])` from a Blade template without evaluating it.
 *
 * Handles the shapes actually used in this repo:
 *   @props(['a', 'b' => 'x', 'c' => ['x','y'], 'd' => false])
 *   @props(['a' => Gsmui::classes(...)])   // non-literal default -> '[computed]'
 */
function parseProps(string $source): array
{
    if (! preg_match('/@props\s*\(\s*\[(.*?)\]\s*\)/s', $source, $m)) {
        return [];
    }

    foreach (splitTopLevel($m[1]) as $part) {
        if (preg_match("/^'([^']+)'\s*=>\s*(.+)$/s", $part, $pm)) {
            $default = normaliseDefault(trim($pm[2]));
            $props[$pm[1]] = ['default' => $default, 'has_default' => $default !== null];
        } elseif (preg_match("/^'([^']+)'$/", $part, $pm)) {
            $props[$pm[1]] = ['default' => null, 'has_default' => false];
        }
    }

    return $props ?? [];
}

/** Split on top-level commas only (ignore commas inside [] / () / quotes). */
function splitTopLevel(string $body): array
{
    $parts = [];
    $buf = '';
    $depth = 0;
    $quote = null;

    for ($i = 0, $len = strlen($body); $i < $len; $i++) {
        $ch = $body[$i];
        if ($quote !== null) {
            if ($ch === '\\') { $buf .= $ch . ($body[++$i] ?? ''); continue; }
            if ($ch === $quote) { $quote = null; }
            $buf .= $ch;
            continue;
        }
        if ($ch === "'" || $ch === '"') { $quote = $ch; $buf .= $ch; continue; }
        if ($ch === '[' || $ch === '(') { $depth++; $buf .= $ch; continue; }
        if ($ch === ']' || $ch === ')') { $depth--; $buf .= $ch; continue; }
        if ($ch === ',' && $depth === 0) { $parts[] = trim($buf); $buf = ''; continue; }
        $buf .= $ch;
    }
    if (trim($buf) !== '') { $parts[] = trim($buf); }

    return $parts;
}

/** Turn a PHP literal into a short readable default; non-literals become '[computed]'. */
function normaliseDefault(string $raw): mixed
{
    if ($raw === 'true') { return true; }
    if ($raw === 'false') { return false; }
    if ($raw === 'null') { return null; }
    if (preg_match('/^-?\d+(\.\d+)?$/', $raw)) { return $raw + 0; }
    if (preg_match("/^'((?:[^'\\\\]|\\\\.)*)'$/s", $raw, $m)) { return $m[1]; }
    if (preg_match('/^\[(.*)\]$/s', $raw, $m)) {
        $inner = trim($m[1]);
        if (strlen($inner) > 60 || str_contains($inner, '=>')) {
            return '[array]';
        }
        return trim(preg_replace('/\s+/', ' ', $inner));
    }

    return '[computed]';
}

$components = [];
$dirs = array_values(array_filter(
    scandir($views),
    fn ($d) => is_dir("{$views}/{$d}") && ! str_starts_with($d, '.')
));
sort($dirs);

foreach ($dirs as $name) {
    $dir = "{$views}/{$name}";
    $files = bladeFiles($dir);
    $relative = array_map(fn ($f) => str_replace($root . '/', '', $f), $files);

    $entry = [
        'name' => $name,
        'tag' => 'gsmui:' . $name,
        'files' => count($files),
        'has_index' => is_file("{$dir}/index.blade.php"),
        'sub_components' => [],
        'props' => [],
        'uses' => ['gsmui_classes' => 0, 'blaze' => 0, 'inline_style' => 0,
                   'wire_call' => 0, 'pluck' => 0, 'route_call' => 0],
        'requires_js' => false,
        'status' => 'unknown',
        'evidence' => $relative[0] ?? null,
    ];

    foreach ($files as $file) {
        $slug = basename($file, '.blade.php');
        if ($slug !== 'index' && ! in_array($slug, $entry['sub_components'], true)) {
            $entry['sub_components'][] = $slug;
        }

        $src = (string) file_get_contents($file);

        if ($slug === 'index') {
            foreach (parseProps($src) as $prop => $meta) {
                $entry['props'][$prop] = $meta;
            }
        }

        $entry['uses']['gsmui_classes'] += substr_count($src, 'Gsmui::classes');
        $entry['uses']['blaze']        += (int) preg_match_all('/@blaze/', $src);
        $entry['uses']['inline_style'] += (int) preg_match_all('/\bstyle="/', $src);
        $entry['uses']['wire_call']    += (int) preg_match_all('/\{\{\s*wire\(/', $src);
        $entry['uses']['pluck']        += (int) preg_match_all('/->pluck\(/', $src);
        $entry['uses']['route_call']   += (int) preg_match_all('/route\(\s*[\'"]/', $src);

        if (preg_match('/<script|data-gsmui|wire:poll|\bui-[a-z]/', $src) === 1) {
            $entry['requires_js'] = true;
        }
    }

    sort($entry['sub_components']);
    ksort($entry['props']);

    // Deterministic defect flags derived from the audit (data, not prose).
    $entry['flags'] = array_keys(array_filter([
        'inline_style' => $entry['uses']['inline_style'] > 0,
        'wire_call' => $entry['uses']['wire_call'] > 0,
        'pluck' => $entry['uses']['pluck'] > 0,
        'route_call' => $entry['uses']['route_call'] > 0,
        'missing_index' => ! $entry['has_index'],
    ]));

    $components[] = $entry;
}

$usesKeys = ['gsmui_classes', 'blaze', 'inline_style', 'wire_call', 'pluck', 'route_call'];
$totals = [
    'components' => count($components),
    'with_index' => count(array_filter($components, fn ($c) => $c['has_index'])),
    'blade_files' => array_sum(array_column($components, 'files')),
];
foreach ($usesKeys as $key) {
    $totals[$key] = array_sum(array_map(fn ($c) => $c['uses'][$key], $components));
}

$manifest = [
    'generated_by' => 'scripts/build-component-manifest.php',
    'package' => 'gsmui/gsmui-pro',
    'prefix' => 'gsmui:',
    'totals' => $totals,
    'components' => $components,
];

$jsonFlags = JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_INVALID_UTF8_SUBSTITUTE;
file_put_contents($out, json_encode($manifest, $jsonFlags) . "\n");

printf(
    "Wrote %s\n  components: %d (%d with index)\n  blade files: %d\n  Gsmui::classes: %d | @blaze: %d | inline style=: %d | wire(): %d | pluck(): %d | route(): %d\n",
    str_replace($root . '/', '', $out),
    $totals['components'], $totals['with_index'], $totals['blade_files'],
    $totals['gsmui_classes'], $totals['blaze'], $totals['inline_style'],
    $totals['wire_call'], $totals['pluck'], $totals['route_call'],
);

