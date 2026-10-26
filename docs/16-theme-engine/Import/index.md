---
title: Theme Import
description: Import formats, compatibility check, and migration from other frameworks.
order: 16.6
group: Import
---

# Theme Import

The GsmUi Theme Import system enables loading themes from various sources and formats.

## Import Features

| Feature | Description |
|---|---|
| Multiple formats | CSS, JSON, SCSS, Tailwind |
| Compatibility check | Validate before import |
| Migration tools | Convert from other frameworks |
| Conflict resolution | Handle naming conflicts |
| Preview | Preview before applying |

## Import Formats

### Supported Formats

| Format | Extension | Source |
|---|---|---|
| Gsmui Theme | `.json` | Gsmui export |
| CSS Variables | `.css` | CSS file |
| SCSS Variables | `.scss` | Sass file |
| Tailwind Config | `.js` | Tailwind config |
| Figma Tokens | `.json` | Figma plugin |
| Design Tokens | `.json` | W3C standard |

### Import Dialog

```blade
<x-gsmui:theme-import-dialog wire:model="showImport">
    <gsmui:form-field
        name="source"
        type="select"
        label="Import source"
        :options="[
            'file' => 'Upload file',
            'url' => 'From URL',
            'figma' => 'From Figma',
            'tailwind' => 'From Tailwind config',
        ]"
    />

    <gsmui:form-field
        name="file"
        type="file"
        label="Theme file"
        accept=".json,.css,.scss,.js"
        :required="true"
        x-show="$get('source') === 'file'"
    />

    <gsmui:form-field
        name="url"
        type="url"
        label="Theme URL"
        placeholder="https://example.com/theme.json"
        :required="true"
        x-show="$get('source') === 'url'"
    />

    <gsmui:form-field
        name="merge"
        type="toggle"
        label="Merge with current theme"
    />

    <gsmui:form-field
        name="preview"
        type="toggle"
        label="Preview before applying"
    />
</x-gsmui:theme-import-dialog>
```

## Compatibility Check

### Validation Steps

| Step | Check | Action |
|---|---|---|
| 1 | Format validation | Verify file structure |
| 2 | Token validation | Check required tokens |
| 3 | Value validation | Validate token values |
| 4 | Conflict check | Detect naming conflicts |
| 5 | Compatibility | Check Gsmui version |

### Validation Output

```php
$validation = GsmuiTheme::validateImport($themeFile);

// Returns
[
    'valid' => true,
    'format' => 'gsmui',
    'version' => '2.1.0',
    'tokens' => [
        'total' => 150,
        'valid' => 148,
        'warnings' => 2,
    ],
    'conflicts' => [
        ['token' => 'color.primary', 'current' => '#2563eb', 'import' => '#10b981'],
    ],
    'recommendations' => [
        'Consider merging color tokens for better compatibility',
    ],
]
```

### Conflict Resolution

| Strategy | Description |
|---|---|
| Override | Replace current values |
| Merge | Keep both, import wins |
| Skip | Keep current values |
| Manual | User decides per conflict |

## Migration from Other Frameworks

### Supported Frameworks

| Framework | Migration Tool | Coverage |
|---|---|---|
| Tailwind CSS | Tailwind converter | 90% |
| Bootstrap | Bootstrap mapper | 75% |
| Bulma | Bulma converter | 70% |
| Chakra UI | Chakra mapper | 80% |
| Material UI | MUI converter | 65% |

### Tailwind Migration

```php
$migration = GsmuiTheme::migrateFromTailwind($tailwindConfig);

// Returns Gsmui theme with mapped tokens
[
    'color.primary' => $tailwindConfig['theme']['colors']['blue']['600'],
    'color.surface' => $tailwindConfig['theme']['colors']['white'],
    'radius.md' => $tailwindConfig['theme']['borderRadius']['md'],
    // ...
]
```

### Bootstrap Migration

```php
$migration = GsmuiTheme::migrateFromBootstrap($bootstrapScss);

// Maps Bootstrap variables to Gsmui tokens
$mapping = [
    '$primary' => 'color.primary',
    '$body-bg' => 'color.surface',
    '$body-color' => 'color.text',
    '$border-color' => 'color.border',
    '$border-radius' => 'radius.md',
    '$font-family-sans' => 'font.sans',
];
```

### Migration Process

```
Select source framework
    ↓
Upload config/scss file
    ↓
Parse framework tokens
    ↓
Map to Gsmui tokens
    ↓
Validate mapping
    ↓
Preview result
    ↓
Apply or export
```

## Import Preview

### Preview Interface

```blade
<x-gsmui:theme-import-preview
    :imported="$importedTheme"
    :current="$currentTheme"
    :diff="$tokenDiff"
/>
```

### Preview Layout

```
┌─────────────────────────────────────────────┐
│ Theme Import Preview                         │
├────────────────────┬────────────────────────┤
│ Current Theme      │ Imported Theme         │
│                    │                        │
│ [Button preview]   │ [Button preview]       │
│ [Input preview]    │ [Input preview]        │
│ [Card preview]     │ [Card preview]         │
├────────────────────┴────────────────────────┤
│ Token Changes                               │
│                                              │
│ + color.primary: #10b981 (was #2563eb)     │
│ + color.surface: #f8fafc (was #ffffff)     │
│ ~ radius.md: 0.5rem (was 0.375rem)        │
│                                              │
│ [Apply]  [Cancel]  [Export]                 │
└─────────────────────────────────────────────┘
```

## Import API

### PHP API

```php
use Gsmui\Theme\Import;

// Import from file
$theme = Import::fromFile($filePath);

// Import from URL
$theme = Import::fromUrl($url);

// Import from Tailwind
$theme = Import::fromTailwind($tailwindConfig);

// Import from SCSS
$theme = Import::fromScss($scssContent);

// Validate before import
$valid = Import::validate($themeFile);
```

### CLI API

```bash
# Import theme
gsmui-theme:import ./ocean-theme.json

# Import from Tailwind
gsmui-theme:import --from=tailwind --config=./tailwind.config.js

# Import with preview
gsmui-theme:import ./theme.json --preview

# Import and merge
gsmui-theme:import ./theme.json --merge
```

## Import Configuration

```php
// config/theme-engine.php
return [
    'import' => [
        'enabled' => true,
        'formats' => ['json', 'css', 'scss', 'tailwind', 'figma'],
        'conflict_resolution' => 'prompt', // 'override', 'merge', 'skip', 'prompt'
        'preview_before_apply' => true,
        'backup_before_import' => true,
        'migration' => [
            'tailwind' => true,
            'bootstrap' => true,
            'bulma' => true,
        ],
    ],
];
```

## Performance

| Metric | Target |
|---|---|
| File parse | < 100ms |
| Validation | < 50ms |
| Migration | < 500ms |
| Preview render | < 200ms |
