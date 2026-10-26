@blaze(fold: true, unsafe: ['css'])

@props([
    'theme' => 'zinc-blue',
    'id' => null,
])

@php
// Compiled views are cached in storage/framework/views, so __DIR__ is not this
// component's directory. Resolve the package's source views through the
// registered "gsmui" namespace instead of guessing relative paths.
$viewPaths = app('view')->getFinder()->getHints()['gsmui'] ?? [];
$themeData = include rtrim($viewPaths[0] ?? '__MISSING__', '/') . '/themes/themes.php';
$themes = $themeData['themes'];
$bases = $themeData['palettes']['bases'];
$accents = $themeData['palettes']['accents'];

// Find the theme configuration
$themeConfig = null;
foreach ($themes as $t) {
    if ($t['id'] === $theme) {
        $themeConfig = $t;
        break;
    }
}

// Default to first theme if not found
if (!$themeConfig) {
    $themeConfig = $themes[0];
}

$baseName = $themeConfig['base'];
$accentName = $themeConfig['accent'];
$baseData = $bases[$baseName] ?? $bases['zinc'];
$accentData = $accents[$accentName] ?? $accents['blue'];

// Generate CSS variables
$cssVars = [];

// Status colors (consistent across themes)
$statusColors = [
    '--color-success' => '#16a34a',
    '--color-success-hover' => '#15803d',
    '--color-success-foreground' => '#ffffff',
    '--color-success-content' => '#166534',
    '--color-success-light' => '#f0fdf4',
    '--color-warning' => '#d97706',
    '--color-warning-hover' => '#b45309',
    '--color-warning-foreground' => '#ffffff',
    '--color-warning-content' => '#92400e',
    '--color-warning-light' => '#fffbeb',
    '--color-danger' => '#dc2626',
    '--color-danger-hover' => '#b91c1c',
    '--color-danger-foreground' => '#ffffff',
    '--color-danger-content' => '#991b1b',
    '--color-danger-light' => '#fef2f2',
    '--color-info' => '#0284c7',
    '--color-info-hover' => '#0369a1',
    '--color-info-foreground' => '#ffffff',
    '--color-info-content' => '#075985',
    '--color-info-light' => '#f0f9ff',
];

$statusColorsDark = [
    '--color-success-dark' => '#22c55e',
    '--color-success-hover-dark' => '#4ade80',
    '--color-success-foreground-dark' => '#000000',
    '--color-success-content-dark' => '#86efac',
    '--color-warning-dark' => '#f59e0b',
    '--color-warning-hover-dark' => '#fbbf24',
    '--color-warning-foreground-dark' => '#000000',
    '--color-warning-content-dark' => '#fcd34d',
    '--color-danger-dark' => '#ef4444',
    '--color-danger-hover-dark' => '#f87171',
    '--color-danger-foreground-dark' => '#ffffff',
    '--color-danger-content-dark' => '#fca5a5',
    '--color-info-dark' => '#0ea5e9',
    '--color-info-hover-dark' => '#38bdf8',
    '--color-info-foreground-dark' => '#000000',
    '--color-info-content-dark' => '#7dd3fc',
];

// Light mode variables
foreach ($baseData['light'] as $key => $value) {
    $cssVars["--color-{$key}"] = $value;
}

// Light mode accent variables
foreach ($accentData['light'] as $key => $value) {
    $cssVars["--color-{$key}"] = $value;
}

// Light mode status
foreach ($statusColors as $key => $value) {
    $cssVars[$key] = $value;
}

// Dark mode variables
foreach ($baseData['dark'] as $key => $value) {
    $cssVars["--color-{$key}-dark"] = $value;
}

// Dark mode accent variables
foreach ($accentData['dark'] as $key => $value) {
    $cssVars["--color-{$key}-dark"] = $value;
}

// Dark mode status
foreach ($statusColorsDark as $key => $value) {
    $cssVars[$key] = $value;
}

// Derived utility variables
$cssVars['--color-radius'] = '.75rem';
$cssVars['--color-radius-sm'] = '.5rem';
$cssVars['--color-radius-lg'] = '1rem';
$cssVars['--color-shadow'] = '0 1px 3px 0 rgb(0 0 0 / 0.1), 0 1px 2px -1px rgb(0 0 0 / 0.1)';
$cssVars['--color-shadow-lg'] = '0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1)';
$cssVars['--color-shadow-dark'] = '0 1px 3px 0 rgb(0 0 0 / 0.3), 0 1px 2px -1px rgb(0 0 0 / 0.3)';

// Build CSS string
$css = ":root {\n";
foreach ($cssVars as $var => $value) {
    if (strpos($var, '-dark') === false) {
        $css .= "    {$var}: {$value};\n";
    }
}
$css .= "}\n\n";

$css .= ".dark {\n";
foreach ($cssVars as $var => $value) {
    if (strpos($var, '-dark') !== false) {
        $css .= "    {$var}: {$value};\n";
    }
}
$css .= "}\n\n";

// Generate theme-specific class
$css .= ".theme-{$theme} {\n";
foreach ($cssVars as $var => $value) {
    if (strpos($var, '-dark') === false) {
        $css .= "    {$var}: {$value};\n";
    }
}
$css .= "}\n\n";
$css .= ".dark.theme-{$theme}, .theme-{$theme}.dark {\n";
foreach ($cssVars as $var => $value) {
    if (strpos($var, '-dark') !== false) {
        $css .= "    {$var}: {$value};\n";
    }
}
$css .= "}\n";

$themeId = $id ?: 'gsmui-theme-' . str()->random(6);
@endphp

{{-- Apply theme: inject CSS variables into the page --}}
<style id="{{ $themeId }}" data-gsmui-theme="{{ $theme }}">
    {!! $css !!}
</style>

<script>
    (function() {
        var html = document.documentElement;
        var themes = html.className.split(' ').filter(function(c) { return c.indexOf('theme-') === 0; });
        themes.forEach(function(t) { html.classList.remove(t); });
        html.classList.add('theme-{{ $theme }}');
    })();
</script>
