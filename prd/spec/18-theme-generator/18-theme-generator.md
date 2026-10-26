# 18 - Theme Generator

**Project:** GsmUi
**Version:** 1.0.0

---

# Purpose

The Theme Generator is a visual tool for creating, customizing, and exporting GsmUi themes. It provides real-time preview of design token changes and generates production-ready CSS variables.

---

# Vision

Enable anyone to create beautiful, consistent themes for GsmUi without writing CSS — through an intuitive visual interface.

---

# Core Features

## Visual Editors

* Color picker
* Typography editor
* Spacing editor
* Border radius editor
* Shadow editor
* Animation editor

## Live Preview

* Real-time component preview
* Dark/light mode toggle
* Multiple preview layouts
* Responsive preview
* Device frames

## Export Options

* CSS variables file
* Tailwind config
* JSON tokens
* Figma variables
* Theme package

## Theme Management

* Save themes
* Load themes
* Fork themes
* Version history
* Share themes

---

# Theme Generator Layout

```text
┌─────────────────────────────────────────────────────┐
│ GsmUi Theme Generator                   [Export ▼]  │
├───────────┬─────────────────────────────────────────┤
│           │                                         │
│ Token     │        Preview Area                     │
│ Editors   │                                         │
│           │  ┌─────────────────────────────────┐   │
│ Colors    │  │                                 │   │
│ ─────────│  │     Component Preview            │   │
│ Primary   │  │                                 │   │
│ Secondary │  │  [Button] [Input] [Card]         │   │
│ Accent    │  │                                 │   │
│ Neutral   │  │  [Alert] [Badge] [Table]         │   │
│           │  │                                 │   │
│ Typography│  └─────────────────────────────────┘   │
│ ─────────│                                         │
│ Font      │        Token Values                     │
│ Size      │  ┌─────────────────────────────────┐   │
│ Weight    │  │ --gsm-primary: #3b82f6           │   │
│ Line      │  │ --gsm-primary-hover: #2563eb     │   │
│ Height    │  │ --gsm-radius: 0.5rem             │   │
│           │  │ --gsm-shadow: 0 1px 3px rgba()  │   │
│ Spacing   │  └─────────────────────────────────┘   │
│ ─────────│                                         │
│ Base      │        Export Preview                    │
│ Scale     │  ┌─────────────────────────────────┐   │
│           │  │ :root {                          │   │
│ Borders   │  │   --gsm-primary: #3b82f6;       │   │
│ ─────────│  │   --gsm-primary-hover: #2563eb; │   │
│ Radius    │  │ }                               │   │
│ Width     │  └─────────────────────────────────┘   │
│ Style     │                                         │
│           │                                         │
│ Shadows   │                                         │
│ ─────────│                                         │
│ XS → XL   │                                         │
│           │                                         │
│ Colors    │                                         │
│ Palette   │                                         │
└───────────┴─────────────────────────────────────────┘
```

---

# Design Token System

## Color Tokens

```css
:root {
  /* Primary */
  --gsm-primary-50: #eff6ff;
  --gsm-primary-100: #dbeafe;
  --gsm-primary-200: #bfdbfe;
  --gsm-primary-300: #93c5fd;
  --gsm-primary-400: #60a5fa;
  --gsm-primary-500: #3b82f6;
  --gsm-primary-600: #2563eb;
  --gsm-primary-700: #1d4ed8;
  --gsm-primary-800: #1e40af;
  --gsm-primary-900: #1e3a8a;
  --gsm-primary-950: #172554;
  
  /* Semantic */
  --gsm-success: #22c55e;
  --gsm-warning: #f59e0b;
  --gsm-error: #ef4444;
  --gsm-info: #3b82f6;
}
```

## Typography Tokens

```css
:root {
  /* Font Family */
  --gsm-font-sans: 'Inter', system-ui, sans-serif;
  --gsm-font-mono: 'JetBrains Mono', monospace;
  
  /* Font Size */
  --gsm-text-xs: 0.75rem;
  --gsm-text-sm: 0.875rem;
  --gsm-text-base: 1rem;
  --gsm-text-lg: 1.125rem;
  --gsm-text-xl: 1.25rem;
  --gsm-text-2xl: 1.5rem;
  --gsm-text-3xl: 1.875rem;
  --gsm-text-4xl: 2.25rem;
  
  /* Font Weight */
  --gsm-font-normal: 400;
  --gsm-font-medium: 500;
  --gsm-font-semibold: 600;
  --gsm-font-bold: 700;
  
  /* Line Height */
  --gsm-leading-none: 1;
  --gsm-leading-tight: 1.25;
  --gsm-leading-normal: 1.5;
  --gsm-leading-relaxed: 1.75;
}
```

## Spacing Tokens

```css
:root {
  --gsm-spacing-0: 0;
  --gsm-spacing-1: 0.25rem;
  --gsm-spacing-2: 0.5rem;
  --gsm-spacing-3: 0.75rem;
  --gsm-spacing-4: 1rem;
  --gsm-spacing-5: 1.25rem;
  --gsm-spacing-6: 1.5rem;
  --gsm-spacing-8: 2rem;
  --gsm-spacing-10: 2.5rem;
  --gsm-spacing-12: 3rem;
  --gsm-spacing-16: 4rem;
  --gsm-spacing-20: 5rem;
  --gsm-spacing-24: 6rem;
}
```

## Border Tokens

```css
:root {
  /* Radius */
  --gsm-radius-none: 0;
  --gsm-radius-sm: 0.125rem;
  --gsm-radius-md: 0.375rem;
  --gsm-radius-lg: 0.5rem;
  --gsm-radius-xl: 0.75rem;
  --gsm-radius-2xl: 1rem;
  --gsm-radius-full: 9999px;
  
  /* Width */
  --gsm-border-width: 1px;
}
```

## Shadow Tokens

```css
:root {
  --gsm-shadow-none: none;
  --gsm-shadow-xs: 0 1px 2px 0 rgb(0 0 0 / 0.05);
  --gsm-shadow-sm: 0 1px 3px 0 rgb(0 0 0 / 0.1), 0 1px 2px -1px rgb(0 0 0 / 0.1);
  --gsm-shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
  --gsm-shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
  --gsm-shadow-xl: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
}
```

---

# Color Picker Features

## Color Selection

* Visual color wheel
* Hue/saturation/lightness sliders
* Hex input
* RGB input
* HSL input
* Color blindness simulation

## Color Harmony

* Complementary colors
* Analogous colors
* Triadic colors
* Split-complementary
* Monochromatic

## Palette Generation

* Auto-generate shades (50-950)
* Export palette
* Import palette
* Copy palette

---

# Typography Editor

## Font Selection

* Google Fonts integration
* System fonts
* Custom font upload
* Font preview

## Scale Editor

* Modular scale
* Custom sizes
* Preview text
* Responsive preview

---

# Preview Components

The theme preview should include:

* Buttons (all variants)
* Inputs (all types)
* Cards
* Alerts
* Badges
* Tables
* Navigation
* Modals
* Forms
* Typography samples

---

# Export Formats

## CSS Variables

```css
:root {
  --gsm-primary: #3b82f6;
  /* ... */
}

.dark {
  --gsm-primary: #60a5fa;
  /* ... */
}
```

## Tailwind Config

```javascript
module.exports = {
  theme: {
    extend: {
      colors: {
        primary: {
          50: '#eff6ff',
          // ...
          500: '#3b82f6',
          // ...
        }
      }
    }
  }
}
```

## JSON Tokens

```json
{
  "color": {
    "primary": {
      "50": "#eff6ff",
      "500": "#3b82f6"
    }
  }
}
```

---

# Theme Package Structure

```text
my-theme/

├── README.md
├── theme.json
├── css/
│   ├── variables.css
│   └── tailwind.css
├── preview/
│   ├── screenshots/
│   └── demo.html
└── package.json
```

---

# Technical Architecture

```text
Frontend
├── Color Picker Component
├── Typography Editor
├── Spacing Editor
├── Preview Renderer
└── Export Engine

Backend
├── Theme Service
├── Token Parser
├── Package Generator
├── Storage Service
└── Analytics

Storage
├── Themes (Database)
├── Token Files (S3)
└── Packages (S3)
```

---

# Database Schema

Key tables:

* `themes` — Theme definitions
* `theme_tokens` — Design tokens
* `theme_versions` — Version history
* `theme_forks` — Fork relationships
* `theme_downloads` — Download tracking

---

# Admin Features

* Theme moderation
* Featured themes
* Category management
* Analytics dashboard
* Token validation
* Package generation

---

# Success Metrics

* 10,000+ themes created
* 1,000+ shared themes
* <1s token preview render
* 80%+ export usage
* 4.5+ user satisfaction

---

# Detailed Color Picker Implementation

## Color Picker Component

```javascript
class ColorPicker {
    constructor(container, options = {}) {
        this.container = container;
        this.options = {
            format: options.format || 'hex',
            alpha: options.alpha || false,
            swatches: options.swatches || [],
            onChange: options.onChange || (() => {}),
        };
        
        this.color = {
            h: 0,
            s: 100,
            l: 50,
            a: 1,
        };
        
        this.init();
    }
    
    init() {
        this.render();
        this.setupEventListeners();
        this.updatePreview();
    }
    
    render() {
        this.container.innerHTML = `
            <div class="color-picker">
                <div class="color-picker__gradient" data-gradient>
                    <div class="color-picker__cursor" data-cursor></div>
                </div>
                <div class="color-picker__hue" data-hue>
                    <div class="color-picker__hue-slider" data-hue-slider></div>
                </div>
                ${this.options.alpha ? `
                <div class="color-picker__alpha" data-alpha>
                    <div class="color-picker__alpha-slider" data-alpha-slider></div>
                </div>
                ` : ''}
                <div class="color-picker__inputs">
                    <input type="text" class="color-picker__hex" data-hex-input />
                    <input type="number" class="color-picker__r" data-r-input min="0" max="255" />
                    <input type="number" class="color-picker__g" data-g-input min="0" max="255" />
                    <input type="number" class="color-picker__b" data-b-input min="0" max="255" />
                </div>
                ${this.options.swatches.length ? `
                <div class="color-picker__swatches" data-swatches>
                    ${this.options.swatches.map(color => `
                        <button class="color-picker__swatch" data-color="${color}" style="background: ${color}"></button>
                    `).join('')}
                </div>
                ` : ''}
            </div>
        `;
    }
    
    setupEventListeners() {
        // Gradient interaction
        const gradient = this.container.querySelector('[data-gradient]');
        gradient.addEventListener('mousedown', (e) => this.startGradientDrag(e));
        
        // Hue slider
        const hue = this.container.querySelector('[data-hue]');
        hue.addEventListener('mousedown', (e) => this.startHueDrag(e));
        
        // Alpha slider
        if (this.options.alpha) {
            const alpha = this.container.querySelector('[data-alpha]');
            alpha.addEventListener('mousedown', (e) => this.startAlphaDrag(e));
        }
        
        // Hex input
        const hexInput = this.container.querySelector('[data-hex-input]');
        hexInput.addEventListener('input', (e) => this.handleHexInput(e.target.value));
        
        // RGB inputs
        const rInput = this.container.querySelector('[data-r-input]');
        const gInput = this.container.querySelector('[data-g-input]');
        const bInput = this.container.querySelector('[data-b-input]');
        
        [rInput, gInput, bInput].forEach(input => {
            input.addEventListener('input', () => this.handleRgbInput());
        });
        
        // Swatches
        const swatches = this.container.querySelector('[data-swatches]');
        if (swatches) {
            swatches.addEventListener('click', (e) => {
                if (e.target.classList.contains('color-picker__swatch')) {
                    this.setColor(e.target.dataset.color);
                }
            });
        }
    }
    
    startGradientDrag(e) {
        const gradient = this.container.querySelector('[data-gradient]');
        const rect = gradient.getBoundingClientRect();
        
        const update = (e) => {
            const x = Math.max(0, Math.min(1, (e.clientX - rect.left) / rect.width));
            const y = Math.max(0, Math.min(1, (e.clientY - rect.top) / rect.height));
            
            this.color.s = x * 100;
            this.color.l = (1 - y) * 100;
            
            this.updatePreview();
            this.onChange();
        };
        
        update(e);
        
        const onMove = (e) => update(e);
        const onUp = () => {
            document.removeEventListener('mousemove', onMove);
            document.removeEventListener('mouseup', onUp);
        };
        
        document.addEventListener('mousemove', onMove);
        document.addEventListener('mouseup', onUp);
    }
    
    startHueDrag(e) {
        const hue = this.container.querySelector('[data-hue]');
        const rect = hue.getBoundingClientRect();
        
        const update = (e) => {
            const x = Math.max(0, Math.min(1, (e.clientX - rect.left) / rect.width));
            this.color.h = x * 360;
            
            this.updatePreview();
            this.onChange();
        };
        
        update(e);
        
        const onMove = (e) => update(e);
        const onUp = () => {
            document.removeEventListener('mousemove', onMove);
            document.removeEventListener('mouseup', onUp);
        };
        
        document.addEventListener('mousemove', onMove);
        document.addEventListener('mouseup', onUp);
    }
    
    setColor(color) {
        // Parse color string
        const parsed = this.parseColor(color);
        if (parsed) {
            this.color = { ...this.color, ...parsed };
            this.updatePreview();
            this.onChange();
        }
    }
    
    parseColor(color) {
        // Handle hex
        if (color.startsWith('#')) {
            return this.hexToHsl(color);
        }
        
        // Handle rgb
        const rgbMatch = color.match(/rgb\((\d+),\s*(\d+),\s*(\d+)\)/);
        if (rgbMatch) {
            return this.rgbToHsl(
                parseInt(rgbMatch[1]),
                parseInt(rgbMatch[2]),
                parseInt(rgbMatch[3])
            );
        }
        
        return null;
    }
    
    hexToHsl(hex) {
        const r = parseInt(hex.slice(1, 3), 16) / 255;
        const g = parseInt(hex.slice(3, 5), 16) / 255;
        const b = parseInt(hex.slice(5, 7), 16) / 255;
        
        return this.rgbToHsl(r * 255, g * 255, b * 255);
    }
    
    rgbToHsl(r, g, b) {
        r /= 255;
        g /= 255;
        b /= 255;
        
        const max = Math.max(r, g, b);
        const min = Math.min(r, g, b);
        let h, s, l = (max + min) / 2;
        
        if (max === min) {
            h = s = 0;
        } else {
            const d = max - min;
            s = l > 0.5 ? d / (2 - max - min) : d / (max + min);
            
            switch (max) {
                case r: h = ((g - b) / d + (g < b ? 6 : 0)) / 6; break;
                case g: h = ((b - r) / d + 2) / 6; break;
                case b: h = ((r - g) / d + 4) / 6; break;
            }
        }
        
        return {
            h: Math.round(h * 360),
            s: Math.round(s * 100),
            l: Math.round(l * 100),
        };
    }
    
    updatePreview() {
        // Update gradient background
        const gradient = this.container.querySelector('[data-gradient]');
        gradient.style.backgroundColor = `hsl(${this.color.h}, 100%, 50%)`;
        
        // Update cursor position
        const cursor = this.container.querySelector('[data-cursor]');
        cursor.style.left = `${this.color.s}%`;
        cursor.style.top = `${100 - this.color.l}%`;
        
        // Update hue slider
        const hueSlider = this.container.querySelector('[data-hue-slider]');
        hueSlider.style.left = `${(this.color.h / 360) * 100}%`;
        
        // Update inputs
        const hex = this.hslToHex(this.color.h, this.color.s, this.color.l);
        this.container.querySelector('[data-hex-input]').value = hex;
        
        const rgb = this.hslToRgb(this.color.h, this.color.s, this.color.l);
        this.container.querySelector('[data-r-input]').value = rgb.r;
        this.container.querySelector('[data-g-input]').value = rgb.g;
        this.container.querySelector('[data-b-input]').value = rgb.b;
    }
    
    onChange() {
        this.options.onChange(this.getColor());
    }
    
    getColor() {
        const hex = this.hslToHex(this.color.h, this.color.s, this.color.l);
        return {
            hex,
            hsl: { ...this.color },
            rgb: this.hslToRgb(this.color.h, this.color.s, this.color.l),
        };
    }
}
```

## Color Harmony Algorithms

```php
class ColorHarmony
{
    public function getComplementary(int $hue): array
    {
        return [
            $hue,
            ($hue + 180) % 360,
        ];
    }
    
    public function getAnalogous(int $hue, int $spread = 30): array
    {
        return [
            ($hue - $spread + 360) % 360,
            $hue,
            ($hue + $spread) % 360,
        ];
    }
    
    public function getTriadic(int $hue): array
    {
        return [
            $hue,
            ($hue + 120) % 360,
            ($hue + 240) % 360,
        ];
    }
    
    public function getSplitComplementary(int $hue, int $spread = 30): array
    {
        return [
            $hue,
            ($hue + 180 - $spread + 360) % 360,
            ($hue + 180 + $spread) % 360,
        ];
    }
    
    public function getMonochromatic(int $hue, int $saturation, int $lightness): array
    {
        return [
            ['h' => $hue, 's' => $saturation, 'l' => max(10, $lightness - 30)],
            ['h' => $hue, 's' => $saturation, 'l' => max(10, $lightness - 15)],
            ['h' => $hue, 's' => $saturation, 'l' => $lightness],
            ['h' => $hue, 's' => $saturation, 'l' => min(90, $lightness + 15)],
            ['h' => $hue, 's' => $saturation, 'l' => min(90, $lightness + 30)],
        ];
    }
    
    public function generatePalette(int $hue, string $type = 'analogous'): array
    {
        return match ($type) {
            'complementary' => $this->getComplementary($hue),
            'analogous' => $this->getAnalogous($hue),
            'triadic' => $this->getTriadic($hue),
            'split-complementary' => $this->getSplitComplementary($hue),
            default => $this->getAnalogous($hue),
        };
    }
}
```

## Palette Generation

```php
class PaletteGenerator
{
    public function generateShades(int $hue, int $saturation, int $lightness): array
    {
        $shades = [];
        
        $lightnessSteps = [95, 90, 80, 70, 60, 50, 40, 30, 20, 10, 5];
        
        foreach ($lightnessSteps as $index => $light) {
            $shade = 50 + ($index * 100);
            
            $shades[$shade] = [
                'h' => $hue,
                's' => $saturation,
                'l' => $light,
                'hex' => $this->hslToHex($hue, $saturation, $light),
            ];
        }
        
        return $shades;
    }
    
    public function importPalette(string $data): array
    {
        // Handle Tailwind config format
        if (str_contains($data, 'module.exports')) {
            return $this->parseTailwindConfig($data);
        }
        
        // Handle CSS variables format
        if (str_contains($data, '--')) {
            return $this->parseCssVariables($data);
        }
        
        // Handle JSON format
        if (str_starts_with($data, '{')) {
            return json_decode($data, true);
        }
        
        return [];
    }
    
    private function parseTailwindConfig(string $config): array
    {
        // Extract colors object from Tailwind config
        preg_match('/colors:\s*\{([^}]+)\}/s', $config, $matches);
        
        if (isset($matches[1])) {
            // Parse the colors object
            $colors = [];
            
            preg_match_all("/(\w+):\s*'([^']+)'/", $matches[1], $colorMatches);
            
            foreach ($colorMatches[1] as $index => $name) {
                $colors[$name] = $colorMatches[2][$index];
            }
            
            return $colors;
        }
        
        return [];
    }
    
    private function parseCssVariables(string $css): array
    {
        $variables = [];
        
        preg_match_all('/--gsm-([^:]+):\s*([^;]+);/', $css, $matches);
        
        foreach ($matches[1] as $index => $name) {
            $variables[$name] = trim($matches[2][$index]);
        }
        
        return $variables;
    }
}
```

---

# Typography Editor Details

## Font Selection System

```php
class FontService
{
    public function getGoogleFonts(): array
    {
        return Cache::remember('google_fonts', 86400, function () {
            $response = Http::get('https://www.googleapis.com/webfonts/v1/webfonts', [
                'key' => config('services.googlefonts.key'),
                'sort' => 'popularity',
            ]);
            
            return $response->json('items', []);
        });
    }
    
    public function getSystemFonts(): array
    {
        return [
            'system-ui',
            '-apple-system',
            'BlinkMacSystemFont',
            'Segoe UI',
            'Roboto',
            'Helvetica Neue',
            'Arial',
            'sans-serif',
        ];
    }
    
    public function getFontPreview(string $fontFamily, string $text = 'The quick brown fox'): string
    {
        $encoded = urlencode($fontFamily);
        $url = "https://fonts.googleapis.com/css2?family={$encoded}&display=swap";
        
        return <<<HTML
        <link href="{$url}" rel="stylesheet">
        <div style="font-family: '{$fontFamily}', sans-serif; font-size: 24px; line-height: 1.5;">
            {$text}
        </div>
        HTML;
    }
    
    public function uploadCustomFont(UploadedFile $file): array
    {
        $path = $file->store('fonts', 's3');
        
        $fontName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        
        return [
            'name' => $fontName,
            'url' => Storage::disk('s3')->url($path),
            'format' => $file->getClientOriginalExtension(),
        ];
    }
}
```

## Type Scale Editor

```php
class TypeScaleEditor
{
    private const MODULAR_SCALES = [
        'minor-second' => 1.067,
        'major-second' => 1.125,
        'minor-third' => 1.2,
        'major-third' => 1.25,
        'perfect-fourth' => 1.333,
        'augmented-fourth' => 1.414,
        'perfect-fifth' => 1.5,
        'golden-ratio' => 1.618,
    ];
    
    public function generateScale(string $baseSize, string $scale): array
    {
        $ratio = self::MODULAR_SCALES[$scale] ?? 1.25;
        $base = $this->parseSize($baseSize);
        
        $steps = ['xs', 'sm', 'base', 'lg', 'xl', '2xl', '3xl', '4xl'];
        $scaleValues = [];
        
        foreach ($steps as $index => $step) {
            $exponent = $index - 2; // base is at index 2
            $size = $base * pow($ratio, $exponent);
            
            $scaleValues[$step] = [
                'size' => round($size, 3),
                'rem' => round($size / 16, 4),
                'px' => round($size),
            ];
        }
        
        return $scaleValues;
    }
    
    private function parseSize(string $size): float
    {
        if (str_ends_with($size, 'px')) {
            return (float) str_replace('px', '', $size);
        }
        
        if (str_ends_with($size, 'rem')) {
            return (float) str_replace('rem', '', $size) * 16;
        }
        
        return (float) $size;
    }
    
    public function generateCss(array $scale): string
    {
        $css = ":root {\n";
        
        foreach ($scale as $step => $value) {
            $css .= "    --gsm-text-{$step}: {$value['rem']}rem;\n";
        }
        
        $css .= "}\n";
        
        return $css;
    }
}
```

---

# Spacing Editor Details

## Spacing Scale Generator

```php
class SpacingScaleGenerator
{
    public function generateScale(float $base, string $ratio, int $steps): array
    {
        $scale = [];
        
        for ($i = 0; $i <= $steps; $i++) {
            $value = $base * pow($ratio, $i);
            
            $scale[$i] = [
                'value' => round($value, 3),
                'rem' => round($value / 16, 4),
                'px' => round($value),
            ];
        }
        
        return $scale;
    }
    
    public function generateCss(array $scale): string
    {
        $css = ":root {\n";
        
        foreach ($scale as $step => $value) {
            $css .= "    --gsm-spacing-{$step}: {$value['rem']}rem;\n";
        }
        
        $css .= "}\n";
        
        return $css;
    }
    
    public function getSpacingPresets(): array
    {
        return [
            'tailwind' => [
                'base' => 4,
                'ratio' => 1,
                'steps' => [0, 1, 2, 3, 4, 5, 6, 8, 10, 12, 16, 20, 24],
            ],
            'bootstrap' => [
                'base' => 4,
                'ratio' => 1,
                'steps' => [0, 1, 2, 3, 4, 5],
            ],
            'custom' => [
                'base' => 4,
                'ratio' => 1.5,
                'steps' => range(0, 12),
            ],
        ];
    }
}
```

---

# Preview System Details

## Component Preview Renderer

```php
class ThemePreviewRenderer
{
    private array $components = [
        'buttons' => [
            'primary' => '<x-gsm-button variant="primary">Primary</x-gsm-button>',
            'secondary' => '<x-gsm-button variant="secondary">Secondary</x-gsm-button>',
            'danger' => '<x-gsm-button variant="danger">Danger</x-gsm-button>',
            'ghost' => '<x-gsm-button variant="ghost">Ghost</x-gsm-button>',
        ],
        'inputs' => [
            'text' => '<x-gsm-input label="Text Input" placeholder="Enter text..." />',
            'email' => '<x-gsm-input type="email" label="Email" placeholder="email@example.com" />',
            'password' => '<x-gsm-input type="password" label="Password" placeholder="••••••••" />',
        ],
        'cards' => [
            'default' => '<x-gsm-card><x-gsm-card-body>Card Content</x-gsm-card-body></x-gsm-card>',
            'with-header' => '<x-gsm-card><x-gsm-card-header>Header</x-gsm-card-header><x-gsm-card-body>Body</x-gsm-card-body></x-gsm-card>',
        ],
        'alerts' => [
            'info' => '<x-gsm-alert type="info">Info Alert</x-gsm-alert>',
            'success' => '<x-gsm-alert type="success">Success Alert</x-gsm-alert>',
            'warning' => '<x-gsm-alert type="warning">Warning Alert</x-gsm-alert>',
            'error' => '<x-gsm-alert type="error">Error Alert</x-gsm-alert>',
        ],
        'badges' => [
            'default' => '<x-gsm-badge>Badge</x-gsm-badge>',
            'success' => '<x-gsm-badge color="success">Success</x-gsm-badge>',
            'warning' => '<x-gsm-badge color="warning">Warning</x-gsm-badge>',
        ],
    ];
    
    public function renderAll(array $tokens): string
    {
        $html = '<div class="theme-preview">';
        
        foreach ($this->components as $category => $variants) {
            $html .= "<div class=\"preview-section\">";
            $html .= "<h3 class=\"text-lg font-semibold mb-4\">" . ucfirst($category) . "</h3>";
            $html .= "<div class=\"flex flex-wrap gap-4\">";
            
            foreach ($variants as $variant => $code) {
                $html .= "<div class=\"preview-item\">{$code}</div>";
            }
            
            $html .= "</div></div>";
        }
        
        $html .= '</div>';
        
        return $html;
    }
    
    public function generatePreviewPage(array $tokens): string
    {
        $css = $this->generateCssFromTokens($tokens);
        $components = $this->renderAll($tokens);
        
        return <<<HTML
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Theme Preview</title>
            <link rel="stylesheet" href="/css/gsmui.css">
            <style>
                {$css}
            </style>
        </head>
        <body class="bg-white dark:bg-zinc-900 text-zinc-900 dark:text-white p-8">
            {$components}
        </body>
        </html>
        HTML;
    }
    
    private function generateCssFromTokens(array $tokens): string
    {
        $css = ":root {\n";
        
        foreach ($tokens as $category => $values) {
            foreach ($values as $name => $value) {
                $css .= "    --gsm-{$category}-{$name}: {$value};\n";
            }
        }
        
        $css .= "}\n";
        
        return $css;
    }
}
```

## Dark Mode Preview

```php
class DarkModePreview
{
    public function renderWithDarkMode(array $tokens): array
    {
        $lightTokens = $this->generateLightTokens($tokens);
        $darkTokens = $this->generateDarkTokens($tokens);
        
        return [
            'light' => $this->renderPreview($lightTokens),
            'dark' => $this->renderPreview($darkTokens),
        ];
    }
    
    private function generateLightTokens(array $baseTokens): array
    {
        return $baseTokens;
    }
    
    private function generateDarkTokens(array $baseTokens): array
    {
        $darkTokens = $baseTokens;
        
        // Invert colors for dark mode
        if (isset($darkTokens['colors']['background'])) {
            $darkTokens['colors']['background'] = $this->invertColor($darkTokens['colors']['background']);
        }
        
        if (isset($darkTokens['colors']['text'])) {
            $darkTokens['colors']['text'] = $this->invertColor($darkTokens['colors']['text']);
        }
        
        // Lighten primary colors for dark backgrounds
        if (isset($darkTokens['colors']['primary'])) {
            $darkTokens['colors']['primary'] = $this->lightenColor($darkTokens['colors']['primary'], 20);
        }
        
        return $darkTokens;
    }
    
    private function invertColor(string $hex): string
    {
        $rgb = $this->hexToRgb($hex);
        
        $inverted = [
            'r' => 255 - $rgb['r'],
            'g' => 255 - $rgb['g'],
            'b' => 255 - $rgb['b'],
        ];
        
        return $this->rgbToHex($inverted['r'], $inverted['g'], $inverted['b']);
    }
    
    private function lightenColor(string $hex, int $percent): string
    {
        $rgb = $this->hexToRgb($hex);
        
        $lightened = [
            'r' => min(255, $rgb['r'] + (255 - $rgb['r']) * ($percent / 100)),
            'g' => min(255, $rgb['g'] + (255 - $rgb['g']) * ($percent / 100)),
            'b' => min(255, $rgb['b'] + (255 - $rgb['b']) * ($percent / 100)),
        ];
        
        return $this->rgbToHex($lightened['r'], $lightened['g'], $lightened['b']);
    }
}
```

---

# Export Engine Details

## CSS Variables Export

```php
class CssVariablesExporter
{
    public function export(array $tokens): string
    {
        $css = "/* GsmUi Theme Variables */\n";
        $css .= "/* Generated by GsmUi Theme Generator */\n\n";
        
        $css .= ":root {\n";
        $css .= $this->generateVariables($tokens);
        $css .= "}\n\n";
        
        $css .= ".dark {\n";
        $css .= $this->generateDarkVariables($tokens);
        $css .= "}\n";
        
        return $css;
    }
    
    private function generateVariables(array $tokens): string
    {
        $css = "";
        
        foreach ($tokens as $category => $values) {
            $css .= "    /* {$category} */\n";
            
            foreach ($values as $name => $value) {
                $css .= "    --gsm-{$category}-{$name}: {$value};\n";
            }
            
            $css .= "\n";
        }
        
        return $css;
    }
    
    private function generateDarkVariables(array $tokens): string
    {
        $css = "";
        $darkTokens = $this->generateDarkModeTokens($tokens);
        
        foreach ($darkTokens as $category => $values) {
            $css .= "    /* {$category} */\n";
            
            foreach ($values as $name => $value) {
                $css .= "    --gsm-{$category}-{$name}: {$value};\n";
            }
            
            $css .= "\n";
        }
        
        return $css;
    }
}
```

## Tailwind Config Export

```php
class TailwindConfigExporter
{
    public function export(array $tokens): string
    {
        $config = [
            'theme' => [
                'extend' => [
                    'colors' => $this->generateColors($tokens),
                    'fontFamily' => $this->generateFontFamilies($tokens),
                    'fontSize' => $this->generateFontSizes($tokens),
                    'spacing' => $this->generateSpacing($tokens),
                    'borderRadius' => $this->generateBorderRadius($tokens),
                    'boxShadow' => $this->generateBoxShadow($tokens),
                ],
            ],
        ];
        
        return "module.exports = " . $this->formatConfig($config) . ";\n";
    }
    
    private function generateColors(array $tokens): array
    {
        $colors = [];
        
        if (isset($tokens['colors']['primary'])) {
            $colors['primary'] = $tokens['colors']['primary'];
        }
        
        if (isset($tokens['colors']['secondary'])) {
            $colors['secondary'] = $tokens['colors']['secondary'];
        }
        
        return $colors;
    }
    
    private function formatConfig(array $config): string
    {
        $json = json_encode($config, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        
        // Convert JSON to JS object syntax
        $json = preg_replace('/"([^"]+)":/', '$1:', $json);
        
        return $json;
    }
}
```

## JSON Tokens Export

```php
class JsonTokensExporter
{
    public function export(array $tokens): string
    {
        $output = [
            'gsmui' => $this->flattenTokens($tokens),
        ];
        
        return json_encode($output, JSON_PRETTY_PRINT);
    }
    
    private function flattenTokens(array $tokens): array
    {
        $flat = [];
        
        foreach ($tokens as $category => $values) {
            foreach ($values as $name => $value) {
                $flat["--gsm-{$category}-{$name}"] = [
                    'value' => $value,
                    'type' => $category,
                ];
            }
        }
        
        return $flat;
    }
}
```

---

# Theme Package Structure Details

## Package Generator

```php
class ThemePackageGenerator
{
    public function generate(array $tokens, array $metadata): string
    {
        $tempDir = sys_get_temp_dir() . '/gsmui-theme-' . Str::random(8);
        
        mkdir($tempDir);
        mkdir($tempDir . '/css');
        mkdir($tempDir . '/preview');
        
        // Generate CSS files
        file_put_contents(
            $tempDir . '/css/variables.css',
            $this->cssExporter->export($tokens)
        );
        
        file_put_contents(
            $tempDir . '/css/tailwind.css',
            $this->tailwindExporter->export($tokens)
        );
        
        // Generate theme.json
        file_put_contents(
            $tempDir . '/theme.json',
            json_encode($metadata, JSON_PRETTY_PRINT)
        );
        
        // Generate README.md
        file_put_contents(
            $tempDir . '/README.md',
            $this->generateReadme($metadata)
        );
        
        // Generate package.json
        file_put_contents(
            $tempDir . '/package.json',
            json_encode([
                'name' => Str::slug($metadata['name']),
                'version' => $metadata['version'],
                'description' => $metadata['description'],
            ], JSON_PRETTY_PRINT)
        );
        
        // Generate preview HTML
        file_put_contents(
            $tempDir . '/preview/demo.html',
            $this->previewRenderer->generatePreviewPage($tokens)
        );
        
        // Create ZIP
        $zipPath = sys_get_temp_dir() . '/' . Str::slug($metadata['name']) . '.zip';
        
        $zip = new ZipArchive();
        $zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE);
        
        $this->addDirToZip($tempDir, $tempDir, $zip);
        
        $zip->close();
        
        // Cleanup
        $this->deleteDir($tempDir);
        
        return $zipPath;
    }
    
    private function addDirToZip(string $dir, string $baseDir, ZipArchive $zip): void
    {
        $files = scandir($dir);
        
        foreach ($files as $file) {
            if ($file === '.' || $file === '..') continue;
            
            $path = $dir . '/' . $file;
            $relativePath = ltrim(str_replace($baseDir, '', $path), '/');
            
            if (is_dir($path)) {
                $zip->addEmptyDir($relativePath);
                $this->addDirToZip($path, $baseDir, $zip);
            } else {
                $zip->addFile($path, $relativePath);
            }
        }
    }
}
```

---

# API Contracts Details

## Theme Generator API Specification

```yaml
openapi: 3.0.0
info:
  title: GsmUi Theme Generator API
  version: 1.0.0
  description: API for the GsmUi Theme Generator

paths:
  /api/themes:
    get:
      summary: List themes
      tags: [Themes]
      parameters:
        - name: sort
          in: query
          schema:
            type: string
            enum: [newest, popular, featured]
        - name: page
          in: query
          schema:
            type: integer
      responses:
        '200':
          description: Theme list

    post:
      summary: Create theme
      tags: [Themes]
      security:
        - bearerAuth: []
      requestBody:
        required: true
        content:
          application/json:
            schema:
              type: object
              required:
                - name
                - tokens
              properties:
                name:
                  type: string
                description:
                  type: string
                tokens:
                  type: object
      responses:
        '201':
          description: Theme created

  /api/themes/{id}:
    get:
      summary: Get theme
      tags: [Themes]
      parameters:
        - name: id
          in: path
          required: true
          schema:
            type: string
      responses:
        '200':
          description: Theme details

    put:
      summary: Update theme
      tags: [Themes]
      security:
        - bearerAuth: []
      parameters:
        - name: id
          in: path
          required: true
          schema:
            type: string
      responses:
        '200':
          description: Theme updated

    delete:
      summary: Delete theme
      tags: [Themes]
      security:
        - bearerAuth: []
      parameters:
        - name: id
          in: path
          required: true
          schema:
            type: string
      responses:
        '204':
          description: Theme deleted

  /api/themes/preview:
    post:
      summary: Preview theme
      tags: [Preview]
      requestBody:
        required: true
        content:
          application/json:
            schema:
              type: object
              required:
                - tokens
              properties:
                tokens:
                  type: object
                mode:
                  type: string
                  enum: [light, dark, both]
      responses:
        '200':
          description: Preview HTML

  /api/themes/export:
    post:
      summary: Export theme
      tags: [Export]
      requestBody:
        required: true
        content:
          application/json:
            schema:
              type: object
              required:
                - tokens
                - format
              properties:
                tokens:
                  type: object
                format:
                  type: string
                  enum: [css, tailwind, json, package]
      responses:
        '200':
          description: Exported file

  /api/themes/colors/harmony:
    post:
      summary: Generate color harmony
      tags: [Colors]
      requestBody:
        required: true
        content:
          application/json:
            schema:
              type: object
              required:
                - hue
                - type
              properties:
                hue:
                  type: integer
                type:
                  type: string
                  enum: [complementary, analogous, triadic, split-complementary, monochromatic]
      responses:
        '200':
          description: Color palette

components:
  schemas:
    Theme:
      type: object
      properties:
        id:
          type: string
        name:
          type: string
        description:
          type: string
        tokens:
          type: object
        is_public:
          type: boolean
        created_at:
          type: string
          format: date-time

    Tokens:
      type: object
      properties:
        colors:
          type: object
        typography:
          type: object
        spacing:
          type: object
        borders:
          type: object
        shadows:
          type: object

  securitySchemes:
    bearerAuth:
      type: http
      scheme: bearer
      bearerFormat: JWT
```

---

# Theme Management Details

## Theme Version Control

```php
class ThemeVersionControl
{
    public function createVersion(Theme $theme, array $tokens): ThemeVersion
    {
        $version = ThemeVersion::create([
            'theme_id' => $theme->id,
            'version' => $this->getNextVersion($theme),
            'tokens' => $tokens,
            'changelog' => $changelog ?? 'Initial version',
            'created_by' => auth()->id(),
        ]);
        
        $theme->update(['current_version' => $version->version]);
        
        return $version;
    }
    
    public function getVersions(Theme $theme): Collection
    {
        return ThemeVersion::where('theme_id', $theme->id)
            ->orderBy('created_at', 'desc')
            ->get();
    }
    
    public function revertToVersion(Theme $theme, ThemeVersion $version): void
    {
        $theme->update(['tokens' => $version->tokens]);
        
        $this->createVersion($theme, $version->tokens);
    }
    
    private function getNextVersion(Theme $theme): string
    {
        $latest = ThemeVersion::where('theme_id', $theme->id)
            ->orderBy('created_at', 'desc')
            ->first();
        
        if (!$latest) {
            return '1.0.0';
        }
        
        $parts = explode('.', $latest->version);
        $parts[2] = (int) $parts[2] + 1;
        
        return implode('.', $parts);
    }
}
```

## Theme Forking System

```php
class ThemeForkService
{
    public function fork(Theme $original, User $user): Theme
    {
        $forked = Theme::create([
            'name' => "{$original->name} (Fork)",
            'description' => "Forked from {$original->name}",
            'tokens' => $original->tokens,
            'user_id' => $user->id,
            'forked_from' => $original->id,
            'is_public' => false,
        ]);
        
        // Track fork
        ThemeFork::create([
            'original_id' => $original->id,
            'forked_id' => $forked->id,
            'forked_by' => $user->id,
        ]);
        
        // Increment fork count
        $original->increment('fork_count');
        
        // Notify original author
        if ($original->user_id !== $user->id) {
            Notification::send(
                $original->user,
                new ThemeForkedNotification($original, $forked)
            );
        }
        
        return $forked;
    }
    
    public function getForks(Theme $theme): Collection
    {
        return Theme::where('forked_from', $theme->id)
            ->with('user')
            ->get();
    }
    
    public function getForkTree(Theme $theme): array
    {
        $tree = [
            'theme' => $theme,
            'forks' => [],
        ];
        
        $forks = $this->getForks($theme);
        
        foreach ($forks as $fork) {
            $tree['forks'][] = $this->getForkTree($fork);
        }
        
        return $tree;
    }
}
```

## Theme Sharing

```php
class ThemeShareService
{
    public function createShareLink(Theme $theme, array $options = []): ThemeShare
    {
        return ThemeShare::create([
            'theme_id' => $theme->id,
            'token' => Str::random(32),
            'created_by' => auth()->id(),
            'expires_at' => $options['expires_at'] ?? now()->addDays(30),
            'password' => isset($options['password']) ? bcrypt($options['password']) : null,
        ]);
    }
    
    public function accessShareLink(string $token, string $password = null): ?Theme
    {
        $share = ThemeShare::where('token', $token)
            ->where('expires_at', '>', now())
            ->first();
        
        if (!$share) {
            return null;
        }
        
        if ($share->password && !Hash::check($password, $share->password)) {
            return null;
        }
        
        $share->increment('access_count');
        
        return $share->theme;
    }
    
    public function getShareAnalytics(ThemeShare $share): array
    {
        return [
            'access_count' => $share->access_count,
            'last_accessed' => $share->last_accessed_at,
            'created_at' => $share->created_at,
            'expires_at' => $share->expires_at,
        ];
    }
}
```

## Theme Download System

```php
class ThemeDownloadService
{
    public function download(Theme $theme, User $user = null): string
    {
        // Track download
        ThemeDownload::create([
            'theme_id' => $theme->id,
            'user_id' => $user?->id,
            'ip_address' => request()->ip(),
        ]);
        
        $theme->increment('download_count');
        
        // Generate package
        $packagePath = $this->packageGenerator->generate($theme->tokens, [
            'name' => $theme->name,
            'description' => $theme->description,
            'version' => $theme->current_version,
            'author' => $theme->user->name,
        ]);
        
        return $packagePath;
    }
    
    public function getDownloadStats(Theme $theme): array
    {
        return [
            'total_downloads' => $theme->download_count,
            'downloads_today' => ThemeDownload::where('theme_id', $theme->id)
                ->whereDate('created_at', today())
                ->count(),
            'downloads_this_week' => ThemeDownload::where('theme_id', $theme->id)
                ->where('created_at', '>=', now()->subWeek())
                ->count(),
            'downloads_this_month' => ThemeDownload::where('theme_id', $theme->id)
                ->where('created_at', '>=', now()->subMonth())
                ->count(),
        ];
    }
}
```

## Theme Search

```php
class ThemeSearchService
{
    public function search(string $query, array $filters = []): array
    {
        $search = new SearchQuery();
        
        $search->setQuery($query)
            ->setAttributesToHighlight(['name', 'description'])
            ->setFilter($this->buildFilters($filters))
            ->setSort($this->buildSort($filters));
        
        $results = $this->meilisearch->index('themes')->search($search);
        
        return [
            'hits' => $results['hits'],
            'total' => $results['nbHits'],
            'processing_time' => $results['processingTimeMs'],
        ];
    }
    
    private function buildFilters(array $filters): array
    {
        $filterBuilder = FilterBuilder::and();
        
        if (isset($filters['is_public'])) {
            $filterBuilder->addFilter(
                Filter::attribute('is_public')->isEqualTo($filters['is_public'])
            );
        }
        
        if (isset($filters['min_downloads'])) {
            $filterBuilder->addFilter(
                Filter::attribute('download_count')->gte($filters['min_downloads'])
            );
        }
        
        return $filterBuilder->getFilters();
    }
    
    private function buildSort(array $filters): array
    {
        return match ($filters['sort'] ?? 'relevance') {
            'newest' => ['created_at:desc'],
            'popular' => ['download_count:desc'],
            'forks' => ['fork_count:desc'],
            default => [],
        };
    }
}
```

## Theme Analytics

```php
class ThemeAnalyticsService
{
    public function getThemeMetrics(Theme $theme, int $days = 30): array
    {
        $startDate = now()->subDays($days);
        
        return [
            'views' => $this->getViews($theme, $startDate),
            'downloads' => $this->getDownloads($theme, $startDate),
            'forks' => $this->getForks($theme, $startDate),
            'shares' => $this->getShares($theme, $startDate),
            'unique_viewers' => $this->getUniqueViewers($theme, $startDate),
        ];
    }
    
    public function getViewsChart(Theme $theme, int $days = 30): array
    {
        $startDate = now()->subDays($days);
        
        $views = DB::table('theme_views')
            ->where('theme_id', $theme->id)
            ->where('created_at', '>=', $startDate)
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as views')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get();
        
        return [
            'labels' => $views->pluck('date'),
            'data' => $views->pluck('views'),
        ];
    }
    
    private function getViews(Theme $theme, Carbon $startDate): int
    {
        return DB::table('theme_views')
            ->where('theme_id', $theme->id)
            ->where('created_at', '>=', $startDate)
            ->count();
    }
    
    private function getDownloads(Theme $theme, Carbon $startDate): int
    {
        return ThemeDownload::where('theme_id', $theme->id)
            ->where('created_at', '>=', $startDate)
            ->count();
    }
    
    private function getForks(Theme $theme, Carbon $startDate): int
    {
        return ThemeFork::where('original_id', $theme->id)
            ->where('created_at', '>=', $startDate)
            ->count();
    }
    
    private function getShares(Theme $theme, Carbon $startDate): int
    {
        return ThemeShare::where('theme_id', $theme->id)
            ->where('created_at', '>=', $startDate)
            ->count();
    }
    
    private function getUniqueViewers(Theme $theme, Carbon $startDate): int
    {
        return DB::table('theme_views')
            ->where('theme_id', $theme->id)
            ->where('created_at', '>=', $startDate)
            ->distinct('ip_address')
            ->count();
    }
}
```

---

# Color Blindness Simulation

```php
class ColorBlindnessSimulator
{
    public function simulate(string $hex, string $type): string
    {
        $rgb = $this->hexToRgb($hex);
        
        $matrix = match ($type) {
            'protanopia' => [
                [0.567, 0.433, 0.000],
                [0.558, 0.442, 0.000],
                [0.000, 0.242, 0.758],
            ],
            'deuteranopia' => [
                [0.625, 0.375, 0.000],
                [0.700, 0.300, 0.000],
                [0.000, 0.300, 0.700],
            ],
            'tritanopia' => [
                [0.950, 0.050, 0.000],
                [0.000, 0.433, 0.567],
                [0.000, 0.475, 0.525],
            ],
            'achromatopsia' => [
                [0.299, 0.587, 0.114],
                [0.299, 0.587, 0.114],
                [0.299, 0.587, 0.114],
            ],
        };
        
        $simulated = [
            'r' => $rgb['r'] * $matrix[0][0] + $rgb['g'] * $matrix[0][1] + $rgb['b'] * $matrix[0][2],
            'g' => $rgb['r'] * $matrix[1][0] + $rgb['g'] * $matrix[1][1] + $rgb['b'] * $matrix[1][2],
            'b' => $rgb['r'] * $matrix[2][0] + $rgb['g'] * $matrix[2][1] + $rgb['b'] * $matrix[2][2],
        ];
        
        return $this->rgbToHex(
            (int) min(255, max(0, $simulated['r'])),
            (int) min(255, max(0, $simulated['g'])),
            (int) min(255, max(0, $simulated['b']))
        );
    }
    
    public function simulateAll(string $hex): array
    {
        return [
            'original' => $hex,
            'protanopia' => $this->simulate($hex, 'protanopia'),
            'deuteranopia' => $this->simulate($hex, 'deuteranopia'),
            'tritanopia' => $this->simulate($hex, 'tritanopia'),
            'achromatopsia' => $this->simulate($hex, 'achromatopsia'),
        ];
    }
}
```

---

# Contrast Checker

```php
class ContrastChecker
{
    public function getContrastRatio(string $hex1, string $hex2): float
    {
        $l1 = $this->getRelativeLuminance($hex1);
        $l2 = $this->getRelativeLuminance($hex2);
        
        $lighter = max($l1, $l2);
        $darker = min($l1, $l2);
        
        return ($lighter + 0.05) / ($darker + 0.05);
    }
    
    public function getWcagRating(float $ratio): string
    {
        if ($ratio >= 7) {
            return 'AAA';
        } elseif ($ratio >= 4.5) {
            return 'AA';
        } elseif ($ratio >= 3) {
            return 'AA Large';
        }
        
        return 'Fail';
    }
    
    private function getRelativeLuminance(string $hex): float
    {
        $rgb = $this->hexToRgb($hex);
        
        $r = $this->linearize($rgb['r'] / 255);
        $g = $this->linearize($rgb['g'] / 255);
        $b = $this->linearize($rgb['b'] / 255);
        
        return 0.2126 * $r + 0.7152 * $g + 0.0722 * $b;
    }
    
    private function linearize(float $channel): float
    {
        return $channel <= 0.03928
            ? $channel / 12.92
            : pow(($channel + 0.055) / 1.055, 2.4);
    }
    
    public function suggestContrast(string $hex1, string $hex2): array
    {
        $ratio = $this->getContrastRatio($hex1, $hex2);
        
        if ($ratio >= 4.5) {
            return ['status' => 'good', 'message' => 'Contrast ratio meets WCAG AA standards'];
        }
        
        // Suggest darker/lighter variant
        $suggestions = [];
        
        // Try darkening the darker color
        $darker = $this->darkenColor($hex2, 20);
        $newRatio = $this->getContrastRatio($hex1, $darker);
        if ($newRatio >= 4.5) {
            $suggestions[] = $darker;
        }
        
        // Try lightening the lighter color
        $lighter = $this->lightenColor($hex1, 20);
        $newRatio = $this->getContrastRatio($lighter, $hex2);
        if ($newRatio >= 4.5) {
            $suggestions[] = $lighter;
        }
        
        return [
            'status' => 'poor',
            'current_ratio' => $ratio,
            'suggestions' => $suggestions,
        ];
    }
}
```

---

# Success Metrics Details

## Key Performance Indicators

| Metric | Current | Target | Measurement |
|--------|---------|--------|-------------|
| Themes Created | 5,000 | 10,000+ | Database count |
| Shared Themes | 500 | 1,000+ | Database count |
| Token Preview Render | 1.2s | <1s | Average render time |
| Export Usage | 75% | 80%+ | Exports / Themes |
| User Satisfaction | 4.3/5 | 4.5/5 | Survey score |
| Theme Downloads | 10,000/month | 20,000+ | Download count |
| Fork Rate | 15% | 20%+ | Forks / Themes |

## Performance Metrics

| Metric | Current | Target | Measurement |
|--------|---------|--------|-------------|
| Color Picker Response | 50ms | <30ms | Input latency |
| Preview Update | 200ms | <150ms | Update time |
| Export Generation | 500ms | <400ms | Generation time |
| Package Creation | 2s | <1.5s | Creation time |
| Search Response | 150ms | <100ms | Query time |

## User Engagement Metrics

| Metric | Current | Target | Measurement |
|--------|---------|--------|-------------|
| Return Users | 45% | 55%+ | Monthly retention |
| Theme Customization | 80% | 85%+ | Users modifying tokens |
| Export Format Usage | 60% CSS | Balanced | Format distribution |
| Share Rate | 10% | 15%+ | Shares / Themes |

---

# Next Document

**19 - Chart Builder** — Visual chart creation and configuration tool.
