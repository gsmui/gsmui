<?php

namespace GsmuiPro;

use Illuminate\Support\Facades\Facade;

/**
 * @method static array classes(string $component)
 * @method static void registerCategory(string $name, array $components = [])
 * @method static void registerComponent(string $name, array $config = [])
 * @method static array getCategories()
 * @method static array getComponents()
 * @method static ?array getComponent(string $name)
 * @method static void setTheme(string $theme)
 * @method static string getTheme()
 * @method static array getThemes()
 * @method static void registerTheme(string $name)
 * @method static void setCssVariable(string $name, string $value)
 * @method static array getCssVariables()
 * @method static string generateCssVariables()
 * @method static int getComponentCount()
 * @method static array getComponentNames()
 * @method static bool hasComponent(string $name)
 * @method static array getComponentsByCategory(string $category)
 * @method static string mergeClasses(string $component, ?string $variant = null, ?string $size = null, array $extra = [])
 * @method static string uniqueId(string $prefix = 'gsmui')
 * @method static string kebab(string $string)
 * @method static string camel(string $string)
 * @method static string pascal(string $string)
 * @method static string snake(string $string)
 * @method static string getVersion()
 * @method static array getInfo()
 *
 * @see \GsmuiPro\GsmuiProManager
 */
class GsmuiPro extends Facade
{
    /**
     * Get the registered name of the component.
     */
    protected static function getFacadeAccessor(): string
    {
        return GsmuiProManager::class;
    }
}
