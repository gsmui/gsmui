<?php

namespace GsmuiPro;

use Illuminate\Support\Str;

class GsmuiProManager
{
    /**
     * Registered component categories.
     */
    protected array $categories = [];

    /**
     * Registered components.
     */
    protected array $components = [];

    /**
     * Active theme.
     */
    protected string $theme = 'default';

    /**
     * Available themes.
     */
    protected array $themes = [
        'default',
        'blue',
        'green',
        'purple',
        'red',
        'orange',
        'pink',
        'teal',
        'indigo',
        'slate',
        'emerald',
    ];

    /**
     * Custom CSS variables.
     */
    protected array $cssVariables = [];

    /**
     * Start a fluent class list for a Blade component.
     *
     * Matches the call style used throughout the package's views:
     *   Gsmui::classes()->add('block')->add('rounded-xl')
     */
    public static function classes(?string $component = null): ClassBuilder
    {
        $builder = new ClassBuilder();

        if ($component !== null) {
            $builder->merge(static::flattenClasses(static::getComponentDefaults($component)));
            $builder->merge(static::flattenClasses(static::getComponentOverrides($component)));
        }

        return $builder;
    }

    /**
     * Flatten a nested defaults array into a flat list of class strings.
     *
     * Class tables are authored as `['base' => '...', 'primary' => '...']`,
     * so only the string values matter here.
     */
    protected static function flattenClasses(array $classes): array
    {
        $flat = [];

        array_walk_recursive($classes, function ($value) use (&$flat) {
            if (is_string($value) && trim($value) !== '') {
                $flat[] = trim($value);
            }
        });

        return $flat;
    }

    /**
     * Split off the attributes that start with a given prefix.
     *
     * Returns a bag containing only the prefixed attributes, with the prefix
     * stripped, so a component can forward `container:class="..."` onward.
     */
    public static function attributesAfter(string $prefix, mixed $attributes): \Illuminate\View\ComponentAttributeBag
    {
        $bag = $attributes instanceof \Illuminate\View\ComponentAttributeBag
            ? $attributes->getAttributes()
            : (array) $attributes;

        $matching = [];

        foreach ($bag as $key => $value) {
            if (str_starts_with($key, $prefix)) {
                $matching[substr($key, strlen($prefix))] = $value;
            }
        }

        return new \Illuminate\View\ComponentAttributeBag($matching);
    }

    /**
     * Get default classes for a component as a flat string.
     */
    public static function classList(string $component): string
    {
        return (string) static::classes($component);
    }

    /**
     * Get default classes for a component.
     */
    protected static function getComponentDefaults(string $component): array
    {
        $defaults = [
            'button' => [
                'base' => 'inline-flex items-center justify-center gap-2 rounded-lg font-medium transition-all duration-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2',
                'primary' => 'bg-zinc-900 text-white hover:bg-zinc-800 dark:bg-white dark:text-zinc-900 dark:hover:bg-zinc-100',
                'secondary' => 'bg-zinc-100 text-zinc-900 hover:bg-zinc-200 dark:bg-zinc-800 dark:text-zinc-100 dark:hover:bg-zinc-700',
                'danger' => 'bg-red-500 text-white hover:bg-red-600',
                'ghost' => 'text-zinc-600 hover:text-zinc-900 hover:bg-zinc-100 dark:text-zinc-400 dark:hover:text-white dark:hover:bg-zinc-800',
                'subtle' => 'text-zinc-500 hover:text-zinc-700 hover:bg-zinc-50 dark:text-zinc-400 dark:hover:text-zinc-200 dark:hover:bg-zinc-800',
                'sm' => 'h-8 px-3 text-sm',
                'md' => 'h-10 px-4 text-sm',
                'lg' => 'h-12 px-6 text-base',
            ],
            'input' => [
                'base' => 'block w-full rounded-lg border bg-white px-3 py-2 text-sm shadow-xs transition-colors duration-200 placeholder:text-zinc-400 focus:outline-none disabled:cursor-not-allowed disabled:opacity-50 dark:bg-white/10',
                'border' => 'border-zinc-300 focus:border-zinc-500 dark:border-white/10 dark:focus:border-white/20',
                'error' => 'border-red-500 focus:border-red-500 focus:ring-red-500/20',
                'sm' => 'h-8 text-sm',
                'md' => 'h-10 text-sm',
                'lg' => 'h-12 text-base',
            ],
            'card' => [
                'base' => 'rounded-xl border bg-white p-6 shadow-sm dark:bg-zinc-900 dark:border-white/10',
                'hover' => 'transition-shadow duration-200 hover:shadow-md',
            ],
            'modal' => [
                'overlay' => 'fixed inset-0 z-50 bg-black/50 backdrop-blur-sm',
                'content' => 'fixed left-1/2 top-1/2 z-50 -translate-x-1/2 -translate-y-1/2 rounded-xl bg-white p-6 shadow-2xl dark:bg-zinc-900',
            ],
            'badge' => [
                'base' => 'inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium',
                'default' => 'bg-zinc-100 text-zinc-800 dark:bg-zinc-800 dark:text-zinc-200',
                'success' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300',
                'warning' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300',
                'danger' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300',
                'info' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300',
            ],
            'tooltip' => [
                'base' => 'absolute z-50 rounded-lg bg-zinc-900 px-3 py-1.5 text-xs text-white shadow-lg dark:bg-zinc-700',
            ],
        ];

        return $defaults[$component] ?? [];
    }

    /**
     * Get component overrides from config.
     */
    protected static function getComponentOverrides(string $component): array
    {
        $overrides = config("gsmui-pro.components.{$component}", []);

        return is_array($overrides) ? $overrides : [];
    }

    /**
     * Register a component category.
     */
    public function registerCategory(string $name, array $components = []): void
    {
        $this->categories[$name] = $components;
    }

    /**
     * Register a component.
     */
    public function registerComponent(string $name, array $config = []): void
    {
        $this->components[$name] = $config;
    }

    /**
     * Get all registered categories.
     */
    public function getCategories(): array
    {
        return $this->categories;
    }

    /**
     * Get all registered components.
     */
    public function getComponents(): array
    {
        return $this->components;
    }

    /**
     * Get a specific component config.
     */
    public function getComponent(string $name): ?array
    {
        return $this->components[$name] ?? null;
    }

    /**
     * Set the active theme.
     */
    public function setTheme(string $theme): void
    {
        if (! in_array($theme, $this->themes, true)) {
            throw new \InvalidArgumentException("Invalid theme: {$theme}. Available themes: " . implode(', ', $this->themes));
        }

        $this->theme = $theme;
    }

    /**
     * Get the active theme.
     */
    public function getTheme(): string
    {
        return $this->theme;
    }

    /**
     * Get all available themes.
     */
    public function getThemes(): array
    {
        return $this->themes;
    }

    /**
     * Register a custom theme.
     */
    public function registerTheme(string $name): void
    {
        if (! in_array($name, $this->themes, true)) {
            $this->themes[] = $name;
        }
    }

    /**
     * Set a CSS variable.
     */
    public function setCssVariable(string $name, string $value): void
    {
        $this->cssVariables[$name] = $value;
    }

    /**
     * Get all CSS variables.
     */
    public function getCssVariables(): array
    {
        return $this->cssVariables;
    }

    /**
     * Generate CSS custom properties string.
     */
    public function generateCssVariables(): string
    {
        $lines = [];

        foreach ($this->cssVariables as $name => $value) {
            $lines[] = "  --gsmui-{$name}: {$value};";
        }

        return ":root {\n" . implode("\n", $lines) . "\n}";
    }

    /**
     * Get component count.
     */
    public function getComponentCount(): int
    {
        return count($this->components);
    }

    /**
     * Get all component names.
     */
    public function getComponentNames(): array
    {
        return array_keys($this->components);
    }

    /**
     * Check if a component exists.
     */
    public function hasComponent(string $name): bool
    {
        return isset($this->components[$name]);
    }

    /**
     * Get components by category.
     */
    public function getComponentsByCategory(string $category): array
    {
        return $this->categories[$category] ?? [];
    }

    /**
     * Merge classes with defaults.
     */
    public static function mergeClasses(string $component, ?string $variant = null, ?string $size = null, array $extra = []): string
    {
        $defaults = static::getComponentDefaults($component);
        $classes = [];

        // Base classes
        if (isset($defaults['base'])) {
            $classes[] = $defaults['base'];
        }

        // Variant classes
        if ($variant && isset($defaults[$variant])) {
            $classes[] = $defaults[$variant];
        }

        // Size classes
        if ($size && isset($defaults[$size])) {
            $classes[] = $defaults[$size];
        }

        // Extra classes
        $classes = array_merge($classes, $extra);

        return implode(' ', array_filter($classes));
    }

    /**
     * Generate a unique ID for components.
     */
    public static function uniqueId(string $prefix = 'gsmui'): string
    {
        return $prefix . '-' . Str::random(8);
    }

    /**
     * Convert a string to kebab-case.
     */
    public static function kebab(string $string): string
    {
        return Str::kebab($string);
    }

    /**
     * Convert a string to camelCase.
     */
    public static function camel(string $string): string
    {
        return Str::camel($string);
    }

    /**
     * Convert a string to PascalCase.
     */
    public static function pascal(string $string): string
    {
        return Str::studly($string);
    }

    /**
     * Convert a string to snake_case.
     */
    /**
     * Convert a string to snake_case, accepting kebab-case input too.
     *
     * `Str::snake()` only splits on case and spaces, so `hello-world` would come
     * back unchanged. Component names are commonly written in kebab-case, so
     * hyphens are normalised first.
     */
    public static function snake(string $string): string
    {
        return Str::snake(str_replace('-', '_', $string));
    }

    /**
     * Get version of the package.
     */
    public function getVersion(): string
    {
        return config('gsmui-pro.version', '2.15.0');
    }

    /**
     * Get package info.
     */
    public function getInfo(): array
    {
        return [
            'name' => 'gsmui-pro',
            'version' => $this->getVersion(),
            'component_count' => $this->getComponentCount(),
            'theme' => $this->theme,
            'themes' => $this->themes,
        ];
    }
}
