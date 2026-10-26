---
title: Color Palette Generator
description: Primary color input, palette generation, accessibility checking, and color harmony.
order: 16.8
group: Color Generator
---

# Color Palette Generator

The GsmUi Color Generator creates complete color palettes from a single primary color, with accessibility checking and color harmony options.

## Generator Features

| Feature | Description |
|---|---|
| Single color input | Start with one color |
| Full palette | Generate 50-950 shades |
| Accessibility | WCAG contrast checking |
| Harmony | Color theory palettes |
| Export | CSS, JSON, Tailwind |

## Palette Generation

### Input

```blade
<x-gsmui:color-generator
    wire:model="primaryColor"
    :show-palette="true"
    :show-accessibility="true"
/>
```

### Generated Palette

```
Input: #2563eb (Blue 600)

Generated Palette:
 50: #eff6ff
100: #dbeafe
200: #bfdbfe
300: #93c5fd
400: #60a5fa
500: #3b82f6
600: #2563eb  ← Primary
700: #1d4ed8
800: #1e40af
900: #1e3a8a
950: #172554
```

### Palette Table

| Shade | Hex | RGB | HSL | Usage |
|---|---|---|---|---|
| 50 | `#eff6ff` | 239, 246, 255 | 214, 100%, 97% | Light backgrounds |
| 100 | `#dbeafe` | 219, 234, 254 | 214, 100%, 93% | Hover backgrounds |
| 200 | `#bfdbfe` | 191, 219, 254 | 213, 100%, 87% | Borders |
| 300 | `#93c5fd` | 147, 197, 253 | 213, 99%, 79% | Disabled states |
| 400 | `#60a5fa` | 96, 165, 250 | 214, 96%, 68% | Links |
| 500 | `#3b82f6` | 59, 130, 246 | 217, 91%, 60% | Primary |
| 600 | `#2563eb` | 37, 99, 235 | 221, 83%, 53% | Primary hover |
| 700 | `#1d4ed8` | 29, 78, 216 | 224, 80%, 48% | Active states |
| 800 | `#1e40af` | 30, 64, 175 | 224, 70%, 40% | Dark accents |
| 900 | `#1e3a8a` | 30, 58, 138 | 224, 64%, 33% | Dark backgrounds |
| 950 | `#172554` | 23, 37, 84 | 224, 57%, 21% | Darkest |

## Color Harmony

### Harmony Types

| Type | Colors | Description |
|---|---|---|
| Complementary | 2 | Opposite on wheel |
| Analogous | 3 | Adjacent on wheel |
| Triadic | 3 | Evenly spaced |
| Split-complementary | 3 | Complement + adjacent |
| Tetradic | 4 | Two complementary pairs |

### Harmony Generator

```blade
<x-gsmui:color-harmony
    :primary="$primaryColor"
    type="complementary"
    wire:model="harmonyColors"
/>
```

### Harmony Output

```
Primary: #2563eb (Blue)
Complementary: #eb8625 (Orange)

Analogous:
  - #2563eb (Blue)
  - #25ebd4 (Teal)
  - #256eeb (Indigo)

Triadic:
  - #2563eb (Blue)
  - #eb2563 (Magenta)
  - #63eb25 (Green)
```

## Accessibility Checking

### Contrast Ratios

| Level | Ratio | Usage |
|---|---|---|
| AAA | >= 7:1 | Normal text |
| AA | >= 4.5:1 | Large text |
| AA Large | >= 3:1 | 18px+ text |
| Fail | < 3:1 | Insufficient |

### Contrast Checker

```blade
<x-gsmui:contrast-checker
    :foreground="$textColor"
    :background="$bgColor"
/>
```

### Contrast Output

```
Foreground: #18181b
Background: #ffffff

Contrast Ratio: 16.75:1
WCAG Level: AAA ✅

Passes:
  ✅ Normal text (AAA)
  ✅ Large text (AAA)
  ✅ UI components (AAA)
```

### Accessibility Report

| Combination | Ratio | AA | AAA |
|---|---|---|---|
| #18181b on #ffffff | 16.75:1 | ✅ | ✅ |
| #71717a on #ffffff | 4.65:1 | ✅ | ❌ |
| #2563eb on #ffffff | 4.52:1 | ✅ | ❌ |
| #ffffff on #2563eb | 4.52:1 | ✅ | ❌ |

## Token Generation

### Generated Tokens

```css
:root {
    /* Primary Color Palette */
    --gsmui-color-primary-50: #eff6ff;
    --gsmui-color-primary-100: #dbeafe;
    --gsmui-color-primary-200: #bfdbfe;
    --gsmui-color-primary-300: #93c5fd;
    --gsmui-color-primary-400: #60a5fa;
    --gsmui-color-primary-500: #3b82f6;
    --gsmui-color-primary-600: #2563eb;
    --gsmui-color-primary-700: #1d4ed8;
    --gsmui-color-primary-800: #1e40af;
    --gsmui-color-primary-900: #1e3a8a;
    --gsmui-color-primary-950: #172554;

    /* Semantic Colors */
    --gsmui-color-primary: var(--gsmui-color-primary-600);
    --gsmui-color-primary-hover: var(--gsmui-color-primary-700);
    --gsmui-color-primary-light: var(--gsmui-color-primary-100);
}
```

## Generator API

### PHP API

```php
use Gsmui\Theme\ColorGenerator;

// Generate palette from color
$palette = ColorGenerator::palette('#2563eb');

// Generate with options
$palette = ColorGenerator::palette('#2563eb', [
    'shades' => [50, 100, 200, 300, 400, 500, 600, 700, 800, 900, 950],
    'format' => 'hex', // 'hex', 'rgb', 'hsl'
]);

// Check contrast
$contrast = ColorGenerator::contrast('#18181b', '#ffffff');

// Get harmony
$harmony = ColorGenerator::harmony('#2563eb', 'complementary');
```

### CLI API

```bash
# Generate palette
gsmui-color:generate #2563eb --output=./palette.json

# Check contrast
gsmui-color:contrast #18181b #ffffff

# Generate harmony
gsmui-color:harmony #2563eb --type=complementary
```

## Configuration

```php
// config/theme-engine.php
return [
    'color_generator' => [
        'enabled' => true,
        'default_shades' => [50, 100, 200, 300, 400, 500, 600, 700, 800, 900, 950],
        'accessibility' => [
            'check_contrast' => true,
            'min_ratio_aa' => 4.5,
            'min_ratio_aaa' => 7.0,
        ],
    ],
];
```

## Performance

| Metric | Target |
|---|---|
| Palette generation | < 50ms |
| Contrast check | < 10ms |
| Harmony generation | < 30ms |
| Full report | < 200ms |
