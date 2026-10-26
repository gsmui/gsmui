<?php

declare(strict_types=1);

namespace App\Core;

use Illuminate\Foundation\Application as BaseApplication;

class Application extends BaseApplication
{
    /**
     * The path to the application root.
     */
    public const basePath = __DIR__ . '/../..';

    /**
     * The application namespace.
     */
    public const APP_NAMESPACE = 'App';

    /**
     * Get the path to the application configuration directory.
     */
    public function configPath(): string
    {
        return self::basePath . '/config';
    }

    /**
     * Get the path to the application database directory.
     */
    public function databasePath(): string
    {
        return self::basePath . '/database';
    }

    /**
     * Get the path to the resources directory.
     */
    public function resourcePath(): string
    {
        return self::basePath . '/resources';
    }

    /**
     * Get the path to the application storage directory.
     */
    public function storagePath(): string
    {
        return self::basePath . '/storage';
    }
}
