# Theme Engine

> CSS variables, token architecture, theme switching, custom themes, marketplace themes.

## Token Architecture

```
tokens/
├── colors/
│   ├── base.json          # Core palette (blue-500, etc.)
│   ├── semantic.json      # Meaning tokens (primary, success, error)
│   └── component.json     # Component-specific (button-bg, input-border)
├── spacing/
│   └── scale.json         # Spacing scale (1-12)
├── typography/
│   └── scale.json         # Font sizes, line heights
├── shadows/
│   └── elevation.json     # Shadow levels (sm, md, lg)
└── borders/
    └── radius.json        # Border radius scale
```

```json
// tokens/colors/semantic.json
{
  "color": {
    "primary": {
      "default": "{color.blue.600}",
      "hover": "{color.blue.700}",
      "light": "{color.blue.50}",
      "dark": "{color.blue.900}"
    },
    "secondary": {
      "default": "{color.zinc.600}",
      "hover": "{color.zinc.700}",
      "light": "{color.zinc.50}",
      "dark": "{color.zinc.900}"
    },
    "success": {
      "default": "{color.green.600}",
      "light": "{color.green.50}",
      "dark": "{color.green.900}"
    },
    "danger": {
      "default": "{color.red.600}",
      "light": "{color.red.50}",
      "dark": "{color.red.900}"
    }
  }
}
```

## CSS Variables

```css
/* resources/css/themes/default.css */
:root {
  /* Colors */
  --gsmui-color-primary: 14 165 233;
  --gsmui-color-primary-hover: 2 132 199;
  --gsmui-color-secondary: 107 114 128;
  --gsmui-color-success: 22 163 74;
  --gsmui-color-danger: 220 38 38;
  --gsmui-color-warning: 234 179 8;

  /* Backgrounds */
  --gsmui-bg: 255 255 255;
  --gsmui-bg-secondary: 249 250 251;
  --gsmui-bg-tertiary: 243 244 246;

  /* Text */
  --gsmui-text: 17 24 39;
  --gsmui-text-secondary: 107 114 128;
  --gsmui-text-muted: 156 163 175;

  /* Borders */
  --gsmui-border: 229 231 235;
  --gsmui-border-hover: 209 213 219;

  /* Shadows */
  --gsmui-shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
  --gsmui-shadow: 0 1px 3px 0 rgb(0 0 0 / 0.1);
  --gsmui-shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1);

  /* Spacing */
  --gsmui-radius-sm: 0.25rem;
  --gsmui-radius: 0.5rem;
  --gsmui-radius-lg: 0.75rem;
  --gsmui-radius-xl: 1rem;
}

/* Dark theme */
.dark {
  --gsmui-color-primary: 56 189 248;
  --gsmui-bg: 31 41 55;
  --gsmui-bg-secondary: 55 65 81;
  --gsmui-text: 249 250 251;
  --gsmui-text-secondary: 156 163 175;
  --gsmui-border: 75 85 99;
}

/* Custom theme */
[data-theme="forest"] {
  --gsmui-color-primary: 34 197 94;
  --gsmui-color-primary-hover: 22 163 74;
  --gsmui-bg: 255 255 255;
  --gsmui-bg-secondary: 240 253 244;
  --gsmui-text: 5 46 22;
  --gsmui-border: 187 247 208;
}

[data-theme="sunset"] {
  --gsmui-color-primary: 249 115 22;
  --gsmui-color-hover: 234 88 12;
  --gsmui-bg: 255 255 255;
  --gsmui-bg-secondary: 255 247 237;
  --gsmui-text: 124 45 18;
  --gsmui-border: 253 186 116;
}
```

## Theme Switching

```php
// app/Http/Controllers/ThemeController.php
class ThemeController extends Controller
{
    public function update(Request $request)
    {
        $validated = $request->validate([
            'theme' => 'required|in:default,dark,forest,sunset',
        ]);

        session(['theme' => $validated['theme']]);

        return response()->json(['theme' => $validated['theme']]);
    }
}
```

```blade
{{-- Theme switcher component --}}
<div x-data="{
    theme: '{{ session('theme', 'default') }}',
    setTheme(theme) {
        this.theme = theme;
        document.documentElement.setAttribute('data-theme', theme);
        $wire.setTheme(theme);
    }
}" x-init="
    document.documentElement.setAttribute('data-theme', this.theme);
">
    <button @click="setTheme('default')" :class="theme === 'default' ? 'bg-blue-100' : ''">
        Default
    </button>
    <button @click="setTheme('dark')" :class="theme === 'dark' ? 'bg-blue-100' : ''">
        Dark
    </button>
    <button @click="setTheme('forest')" :class="theme === 'forest' ? 'bg-green-100' : ''">
        Forest
    </button>
    <button @click="setTheme('sunset')" :class="theme === 'sunset' ? 'bg-orange-100' : ''">
        Sunset
    </button>
</div>
```

## Theme Registration

```php
// app/Providers/ThemeServiceProvider.php
class ThemeServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(ThemeManager::class, function ($app) {
            return new ThemeManager($app->config->get('themes', []));
        });
    }

    public function boot(): void
    {
        $themes = config('themes.available', []);

        foreach ($themes as $name => $config) {
            $this->publishes([
                $config['path'] => resource_path("css/themes/{$name}.css"),
            ], 'themes');
        }
    }
}

// config/themes.php
return [
    'default' => 'default',
    'available' => [
        'default' => [
            'name' => 'Default',
            'path' => __DIR__.'/../resources/css/themes/default.css',
        ],
        'dark' => [
            'name' => 'Dark',
            'path' => __DIR__.'/../resources/css/themes/dark.css',
        ],
        'forest' => [
            'name' => 'Forest',
            'path' => __DIR__.'/../resources/css/themes/forest.css',
        ],
        'sunset' => [
            'name' => 'Sunset',
            'path' => __DIR__.'/../resources/css/themes/sunset.css',
        ],
    ],
];
```

## Component Theme Integration

```blade
{{-- Button component with theme awareness --}}
@props([
    'variant' => 'primary',
    'size' => 'md',
])

<button {{ $attributes->class([
    'gsmui-button',
    'gsmui-button-primary' => $variant === 'primary',
    'gsmui-button-secondary' => $variant === 'secondary',
    'gsmui-button-ghost' => $variant === 'ghost',
    'gsmui-button-danger' => $variant === 'danger',
    'gsmui-button-sm' => $size === 'sm',
    'gsmui-button-md' => $size === 'md',
    'gsmui-button-lg' => $size === 'lg',
]) }}>
    {{ $slot }}
</button>
```

```css
/* Theme-aware component styles */
.gsmui-button-primary {
    background-color: rgb(var(--gsmui-color-primary));
    color: white;
}

.gsmui-button-primary:hover {
    background-color: rgb(var(--gsmui-color-primary-hover));
}

.gsmui-input {
    border-color: rgb(var(--gsmui-border));
    background-color: rgb(var(--gsmui-bg));
    color: rgb(var(--gsmui-text));
}

.gsmui-input:focus {
    border-color: rgb(var(--gsmui-color-primary));
    box-shadow: 0 0 0 1px rgb(var(--gsmui-color-primary));
}
```

## Marketplace Themes

```php
class ThemeMarketplace
{
    public function getAvailable(): array
    {
        return [
            [
                'id' => 'midnight',
                'name' => 'Midnight Pro',
                'author' => 'Gsmui',
                'price' => 29,
                'preview' => '/images/themes/midnight.png',
                'colors' => [
                    'primary' => '#6366f1',
                    'secondary' => '#8b5cf6',
                ],
            ],
        ];
    }

    public function install(string $themeId): void
    {
        $theme = $this->findTheme($themeId);

        $this->downloadTheme($theme);
        $this->registerTheme($theme);
        $this->publishAssets($theme);
    }
}
```

## Theme Testing

```php
class ThemeTest extends TestCase
{
    public function test_default_theme_has_required_variables(): void
    {
        $css = file_get_contents(resource_path('css/themes/default.css'));

        $requiredVars = [
            '--gsmui-color-primary',
            '--gsmui-bg',
            '--gsmui-text',
            '--gsmui-border',
        ];

        foreach ($requiredVars as $var) {
            $this->assertStringContainsString($var, $css, "Missing CSS variable: {$var}");
        }
    }

    public function test_dark_mode_variables_are_set(): void
    {
        $css = file_get_contents(resource_path('css/themes/default.css'));

        $this->assertStringContainsString('.dark {', $css);
        $this->assertStringContainsString('--gsmui-bg:', $css);
    }
}
```
