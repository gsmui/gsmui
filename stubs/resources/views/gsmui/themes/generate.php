<?php

/**
 * Theme CSS Generator
 * 
 * Reads themes.php config and generates individual CSS files
 * for each theme, organized by category.
 */

$config = include __DIR__ . '/themes.php';
$themes = $config['themes'];
$bases = $config['palettes']['bases'];
$accents = $config['palettes']['accents'];

// Status colors
$statusLight = [
    '--color-success' => '#16a34a',
    '--color-success-hover' => '#15803d',
    '--color-success-foreground' => '#ffffff',
    '--color-success-content' => '#166534',
    '--color-success-light' => '#f0fdf4',
    '--color-success-border' => '#bbf7d0',
    '--color-warning' => '#d97706',
    '--color-warning-hover' => '#b45309',
    '--color-warning-foreground' => '#ffffff',
    '--color-warning-content' => '#92400e',
    '--color-warning-light' => '#fffbeb',
    '--color-warning-border' => '#fde68a',
    '--color-danger' => '#dc2626',
    '--color-danger-hover' => '#b91c1c',
    '--color-danger-foreground' => '#ffffff',
    '--color-danger-content' => '#991b1b',
    '--color-danger-light' => '#fef2f2',
    '--color-danger-border' => '#fecaca',
    '--color-info' => '#0284c7',
    '--color-info-hover' => '#0369a1',
    '--color-info-foreground' => '#ffffff',
    '--color-info-content' => '#075985',
    '--color-info-light' => '#f0f9ff',
    '--color-info-border' => '#bae6fd',
];

$statusDark = [
    '--color-success' => '#22c55e',
    '--color-success-hover' => '#4ade80',
    '--color-success-foreground' => '#000000',
    '--color-success-content' => '#86efac',
    '--color-success-light' => '#0d2818',
    '--color-success-border' => '#166534',
    '--color-warning' => '#f59e0b',
    '--color-warning-hover' => '#fbbf24',
    '--color-warning-foreground' => '#000000',
    '--color-warning-content' => '#fcd34d',
    '--color-warning-light' => '#3b2a08',
    '--color-warning-border' => '#92400e',
    '--color-danger' => '#ef4444',
    '--color-danger-hover' => '#f87171',
    '--color-danger-foreground' => '#ffffff',
    '--color-danger-content' => '#fca5a5',
    '--color-danger-light' => '#351520',
    '--color-danger-border' => '#991b1b',
    '--color-info' => '#0ea5e9',
    '--color-info-hover' => '#38bdf8',
    '--color-info-foreground' => '#000000',
    '--color-info-content' => '#7dd3fc',
    '--color-info-light' => '#0a2e4a',
    '--color-info-border' => '#075985',
];

$utility = [
    '--color-radius' => '.75rem',
    '--color-radius-sm' => '.5rem',
    '--color-radius-lg' => '1rem',
    '--color-shadow' => '0 1px 3px 0 rgb(0 0 0 / 0.1), 0 1px 2px -1px rgb(0 0 0 / 0.1)',
    '--color-shadow-lg' => '0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1)',
    '--color-shadow-xl' => '0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1)',
    '--color-shadow-dark' => '0 1px 3px 0 rgb(0 0 0 / 0.3), 0 1px 2px -1px rgb(0 0 0 / 0.3)',
    '--color-shadow-lg-dark' => '0 10px 15px -3px rgb(0 0 0 / 0.3), 0 4px 6px -4px rgb(0 0 0 / 0.3)',
    '--color-font-mono' => 'ui-monospace, SFMono-Regular, "SF Mono", Menlo, Consolas, monospace',
    '--color-font-sans' => 'ui-sans-serif, system-ui, -apple-system, sans-serif',
];

function generateThemeCSS($baseData, $accentData, $statusLight, $statusDark, $utility) {
    $css = "/* Gsmui Theme — CSS Variables */\n";
    $css .= "/* Auto-generated. Do not edit directly. */\n\n";

    // Light mode
    $css .= ":root {\n";
    foreach ($baseData['light'] as $key => $value) {
        $css .= "    --color-{$key}: {$value};\n";
    }
    foreach ($accentData['light'] as $key => $value) {
        $css .= "    --color-{$key}: {$value};\n";
    }
    foreach ($statusLight as $var => $value) {
        $css .= "    {$var}: {$value};\n";
    }
    foreach ($utility as $var => $value) {
        $css .= "    {$var}: {$value};\n";
    }
    $css .= "}\n\n";

    // Dark mode
    $css .= ".dark {\n";
    foreach ($baseData['dark'] as $key => $value) {
        $css .= "    --color-{$key}: {$value};\n";
    }
    foreach ($accentData['dark'] as $key => $value) {
        $css .= "    --color-{$key}: {$value};\n";
    }
    foreach ($statusDark as $var => $value) {
        $css .= "    {$var}: {$value};\n";
    }
    foreach ($utility as $var => $value) {
        $v = str_replace(['-dark'], '', $var);
        $css .= "    {$v}: {$value};\n";
    }
    $css .= "}\n";

    return $css;
}

$count = 0;
$outputDir = __DIR__;

foreach ($themes as $theme) {
    $baseName = $theme['base'];
    $accentName = $theme['accent'];
    $category = $theme['cat'];
    $themeId = $theme['id'];
    
    $baseData = $bases[$baseName] ?? null;
    $accentData = $accents[$accentName] ?? null;
    
    if (!$baseData || !$accentData) {
        echo "Skipping {$themeId}: missing base '{$baseName}' or accent '{$accentName}'\n";
        continue;
    }
    
    $css = generateThemeCSS($baseData, $accentData, $statusLight, $statusDark, $utility);
    
    $catDir = $outputDir . '/' . $category;
    if (!is_dir($catDir)) {
        mkdir($catDir, 0755, true);
    }
    
    $filename = $catDir . '/' . $themeId . '.css';
    file_put_contents($filename, $css);
    $count++;
}

echo "Generated {$count} theme CSS files.\n";
