---
title: Theme Export
description: Export formats, package structure, distribution, and marketplace publishing.
order: 16.5
group: Export
---

# Theme Export

The GsmUi Theme Export system packages themes for distribution, installation, and marketplace publishing.

## Export Formats

| Format | Extension | Use Case |
|---|---|---|
| CSS Variables | `.css` | Direct use |
| JSON Tokens | `.json` | Build tools |
| SCSS Variables | `.scss` | Sass projects |
| Tailwind Plugin | `.js` | Tailwind projects |
| Theme Package | `.zip` | Marketplace |

## Package Structure

### Theme Package Layout

```
ocean-theme/
├── composer.json
├── package.json
├── README.md
├── CHANGELOG.md
├── LICENSE.md
├── config/
│   └── theme.php
├── resources/
│   ├── css/
│   │   ├── variables.css
│   │   ├── components.css
│   │   └── utilities.css
│   ├── scss/
│   │   └── _variables.scss
│   ├── js/
│   │   └── tailwind-plugin.js
│   └── tokens/
│       └── tokens.json
├── screenshots/
│   ├── preview.png
│   ├── dark.png
│   └── components.png
└── src/
    └── ThemeServiceProvider.php
```

### Package Manifest

```json
{
    "name": "gsmui/theme-ocean",
    "type": "gsmui-theme",
    "description": "A calming blue theme for GsmUi",
    "version": "2.1.0",
    "keywords": ["gsmui", "theme", "blue", "dark-mode"],
    "license": "MIT",
    "require": {
        "gsmui/gsmui-pro": ">=2.10.0",
        "php": ">=8.1",
        "laravel/framework": ">=10.0"
    },
    "extra": {
        "laravel": {
            "providers": [
                "Gsmui\\Themes\\Ocean\\ThemeServiceProvider"
            ]
        }
    }
}
```

## Export Dialog

### Export UI

```blade
<x-gsmui:theme-export-dialog
    :theme="$theme"
    wire:model="showExport"
>
    <gsmui:form-field
        name="name"
        label="Theme name"
        placeholder="My Theme"
        required
    />

    <gsmui:form-field
        name="version"
        label="Version"
        placeholder="1.0.0"
        required
    />

    <gsmui:form-field
        name="format"
        type="select"
        label="Export format"
        :options="[
            'package' => 'Theme Package (zip)',
            'css' => 'CSS Variables',
            'json' => 'JSON Tokens',
            'scss' => 'SCSS Variables',
            'tailwind' => 'Tailwind Plugin',
        ]"
    />

    <gsmui:form-field
        name="include_dark"
        type="toggle"
        label="Include dark mode"
    />

    <gsmui:form-field
        name="include_docs"
        type="toggle"
        label="Include documentation"
    />
</x-gsmui:theme-export-dialog>
```

## Distribution

### Distribution Methods

| Method | Description |
|---|---|
| Marketplace | Gsmui Marketplace |
| Composer | Laravel package |
| NPM | JavaScript package |
| Direct download | ZIP file |
| Git repository | Git repo |

### Marketplace Publishing

```php
// Publish to marketplace
GsmuiMarketplace::publishTheme($theme, [
    'name' => 'Ocean Theme',
    'description' => 'A calming blue theme',
    'price' => 39.00,
    'category' => 'theme',
    'tags' => ['blue', 'dark-mode', 'modern'],
    'screenshots' => [...],
    'demo_url' => 'https://demo.gsmui.dev/ocean',
]);
```

### Composer Package

```json
{
    "name": "gsmui/theme-ocean",
    "type": "gsmui-theme",
    "require": {
        "gsmui/gsmui-pro": ">=2.10.0"
    },
    "extra": {
        "laravel": {
            "providers": [
                "Gsmui\\Themes\\Ocean\\ThemeServiceProvider"
            ]
        }
    }
}
```

### NPM Package

```json
{
    "name": "@gsmui/theme-ocean",
    "version": "2.1.0",
    "main": "dist/css/variables.css",
    "files": ["dist/", "src/"]
}
```

## Export Options

### Export Settings

| Option | Default | Description |
|---|---|---|
| `minify` | `true` | Minify CSS output |
| `source_map` | `false` | Include source maps |
| `dark_mode` | `true` | Include dark variant |
| `docs` | `true` | Include documentation |
| `screenshots` | `true` | Include screenshots |

### Export Validation

```php
$validation = GsmuiTheme::validateForExport($theme);

// Returns
[
    'valid' => true,
    'warnings' => [
        'Consider adding more screenshots',
    ],
    'requirements' => [
        'name' => true,
        'version' => true,
        'description' => true,
        'author' => true,
    ],
]
```

## Export API

### PHP API

```php
use Gsmui\Theme\Export;

// Export as CSS
$css = Export::toCss($theme);

// Export as JSON
$json = Export::toJson($theme);

// Export as package
$package = Export::toPackage($theme, [
    'name' => 'Ocean Theme',
    'version' => '2.1.0',
]);

// Save export
Export::save($theme, storage_path('themes/ocean.zip'));
```

### CLI API

```bash
# Export theme
gsmui-theme:export ocean --format=package --output=./ocean-theme.zip

# Export as CSS
gsmui-theme:export ocean --format=css --output=./ocean.css

# Export with options
gsmui-theme:export ocean --minify --dark-mode --output=./ocean.zip
```

## Versioning

### Version Strategy

| Version Type | Description | Example |
|---|---|---|
| Major | Breaking changes | 3.0.0 |
| Minor | New features | 2.1.0 |
| Patch | Bug fixes | 2.1.1 |

### Changelog Format

```markdown
# Changelog

## 2.1.0 (2024-04-15)
- Added new color tokens
- Improved dark mode contrast
- Fixed border radius on modals

## 2.0.0 (2024-03-01)
- Breaking: Updated token naming
- New spacing scale
- Added SCSS export
```
