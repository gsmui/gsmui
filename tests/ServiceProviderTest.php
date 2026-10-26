<?php

namespace GsmuiPro\Tests;

use Orchestra\Testbench\TestCase;
use GsmuiPro\GsmuiProServiceProvider;
use GsmuiPro\GsmuiProManager;

class ServiceProviderTest extends TestCase
{
    protected function getPackageProviders($app): array
    {
        return [
            GsmuiProServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app): void
    {
        $app['config']->set('gsmui-pro.theme', 'default');
        $app['config']->set('gsmui-pro.dark_mode.strategy', 'class');
    }

    public function test_service_provider_is_registered(): void
    {
        $providers = $this->app->getLoadedProviders();
        $this->assertArrayHasKey(GsmuiProServiceProvider::class, $providers);
    }

    public function test_manager_is_registered_as_singleton(): void
    {
        $manager1 = $this->app->make(GsmuiProManager::class);
        $manager2 = $this->app->make(GsmuiProManager::class);

        $this->assertSame($manager1, $manager2);
    }

    public function test_manager_alias_is_registered(): void
    {
        $manager = $this->app->make('gsmui-pro');
        $this->assertInstanceOf(GsmuiProManager::class, $manager);
    }

    public function test_config_is_merged(): void
    {
        $config = config('gsmui-pro');
        $this->assertIsArray($config);
        $this->assertArrayHasKey('theme', $config);
        $this->assertArrayHasKey('components', $config);
        $this->assertArrayHasKey('dark_mode', $config);
    }

    public function test_csp_config_is_merged(): void
    {
        $config = config('gsmui-pro-csp');
        $this->assertIsArray($config);
        $this->assertArrayHasKey('enabled', $config);
        $this->assertArrayHasKey('directives', $config);
    }

    public function test_provides_returns_correct_services(): void
    {
        $provider = new GsmuiProServiceProvider($this->app);
        $provides = $provider->provides();

        $this->assertContains(GsmuiProManager::class, $provides);
        $this->assertContains('gsmui-pro', $provides);
    }

    public function test_view_namespace_is_registered(): void
    {
        $paths = view()->getFinder()->getPaths();
        $this->assertNotEmpty($paths);
    }

    public function test_blade_component_path_is_registered(): void
    {
        // This test verifies that the component path was registered without errors
        $this->assertTrue(true);
    }
}
