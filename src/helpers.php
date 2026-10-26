<?php

use GsmuiPro\GsmuiProManager;

if (! function_exists('gsmui')) {
    /**
     * Get the Gsmui Pro manager instance.
     */
    function gsmui(): GsmuiProManager
    {
        return app(GsmuiProManager::class);
    }
}

if (! function_exists('gsmui_classes')) {
    /**
     * Get merged classes for a component.
     */
    function gsmui_classes(string $component, ?string $variant = null, ?string $size = null, array $extra = []): string
    {
        return GsmuiProManager::mergeClasses($component, $variant, $size, $extra);
    }
}

if (! function_exists('gsmui_id')) {
    /**
     * Generate a unique ID for a Gsmui component.
     */
    function gsmui_id(string $prefix = 'gsmui'): string
    {
        return GsmuiProManager::uniqueId($prefix);
    }
}

if (! function_exists('gsmui_version')) {
    /**
     * Get the Gsmui Pro version.
     */
    function gsmui_version(): string
    {
        return gsmui()->getVersion();
    }
}

if (! function_exists('gsmui_theme')) {
    /**
     * Get the current theme.
     */
    function gsmui_theme(): string
    {
        return gsmui()->getTheme();
    }
}

if (! function_exists('gsmui_set_theme')) {
    /**
     * Set the current theme.
     */
    function gsmui_set_theme(string $theme): void
    {
        gsmui()->setTheme($theme);
    }
}

if (! function_exists('gsmui_css_variables')) {
    /**
     * Generate CSS custom properties for the current theme.
     */
    function gsmui_css_variables(): string
    {
        return gsmui()->generateCssVariables();
    }
}

if (! function_exists('gsmui_kebab')) {
    /**
     * Convert a string to kebab-case.
     */
    function gsmui_kebab(string $string): string
    {
        return GsmuiProManager::kebab($string);
    }
}

if (! function_exists('gsmui_camel')) {
    /**
     * Convert a string to camelCase.
     */
    function gsmui_camel(string $string): string
    {
        return GsmuiProManager::camel($string);
    }
}

if (! function_exists('gsmui_pascal')) {
    /**
     * Convert a string to PascalCase.
     */
    function gsmui_pascal(string $string): string
    {
        return GsmuiProManager::pascal($string);
    }
}

if (! function_exists('gsmui_snake')) {
    /**
     * Convert a string to snake_case.
     */
    function gsmui_snake(string $string): string
    {
        return GsmuiProManager::snake($string);
    }
}
