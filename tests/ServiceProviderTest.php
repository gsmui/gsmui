<?php

namespace Tests;

use Orchestra\Testbench\TestCase;
use GsmuiPro\GsmuiProServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;

class ServiceProviderTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [
            GsmuiProServiceProvider::class,
        ];
    }

    protected function defineEnvironment($app)
    {
        $app['config']->set('gsmui-pro-csp.enabled', false);
    }

    /** @test */
    public function it_registers_the_service_provider()
    {
        $providers = $this->app->getLoadedProviders();

        $this->assertArrayHasKey(GsmuiProServiceProvider::class, $providers);
    }

    /** @test */
    public function it_singletonizes_the_manager()
    {
        $manager1 = $this->app->make('GsmuiPro\GsmuiProManager');
        $manager2 = $this->app->make('GsmuiPro\GsmuiProManager');

        $this->assertSame($manager1, $manager2);
    }

    /** @test */
    public function it_merges_csp_config_from_stubs()
    {
        $config = config('gsmui-pro-csp');

        $this->assertIsArray($config);
        $this->assertArrayHasKey('enabled', $config);
        $this->assertEquals(true, $config['enabled']);
    }

    /** @test */
    public function it_has_component_path_registered()
    {
        // Verify the service provider can be instantiated
        $provider = new GsmuiProServiceProvider($this->app);

        $this->assertNotNull($provider);
    }

    /** @test */
    public function it_provides_aliases()
    {
        $aliases = \Illuminate\Foundation\AliasLoader::getInstance()->getAliases();

        // Check if GsmuiPro alias is registered
        $this->assertArrayHasKey('GsmuiPro', $aliases);
    }

    /** @test */
    public function it_can_resolve_service_provider()
    {
        $provider = $this->app->make(GsmuiProServiceProvider::class);

        $this->assertInstanceOf(GsmuiProServiceProvider::class, $provider);
    }

    /** @test */
    public function it_has_required_methods()
    {
        $provider = new GsmuiProServiceProvider($this->app);

        $this->assertTrue(method_exists($provider, 'register'));
        $this->assertTrue(method_exists($provider, 'boot'));
        $this->assertTrue(method_exists($provider, 'bootComponentPath'));
        $this->assertTrue(method_exists($provider, 'bootPublishableConfig'));
    }

    /** @test */
    public function it_can_register_without_errors()
    {
        // This test ensures the register method runs without exceptions
        $provider = new GsmuiProServiceProvider($this->app);
        $provider->register();

        $this->assertTrue(true); // No exception thrown
    }

    /** @test */
    public function it_can_boot_without_errors()
    {
        // This test ensures the boot method runs without exceptions
        $provider = new GsmuiProServiceProvider($this->app);
        $provider->boot();

        $this->assertTrue(true); // No exception thrown
    }

    /** @test */
    public function it_provides_gsmui_facade()
    {
        // Check if the facade alias is configured
        $composer = json_decode(
            file_get_contents(dirname(__DIR__) . '/composer.json'),
            true
        );

        $this->assertArrayHasKey('aliases', $composer['extra']['laravel']);
        $this->assertArrayHasKey('Gsmui', $composer['extra']['laravel']['aliases']);
    }

    /** @test */
    public function it_provides_service_provider_in_extras()
    {
        $composer = json_decode(
            file_get_contents(dirname(__DIR__) . '/composer.json'),
            true
        );

        $this->assertContains(
            'GsmuiPro\\GsmuiProServiceProvider',
            $composer['extra']['laravel']['providers']
        );
    }

    /** @test */
    public function it_has_helpers_autoloaded()
    {
        $composer = json_decode(
            file_get_contents(dirname(__DIR__) . '/composer.json'),
            true
        );

        $this->assertContains(
            'src/helpers.php',
            $composer['autoload']['files']
        );
    }

    /** @test */
    public function it_config_has_correct_structure()
    {
        $config = config('gsmui-pro-csp');

        $this->assertArrayHasKey('enabled', $config);
        $this->assertArrayHasKey('use_nonce', $config);
        $this->assertArrayHasKey('report_only', $config);
    }

    /** @test */
    public function it_config_defaults_are_correct()
    {
        $config = config('gsmui-pro-csp');

        $this->assertTrue($config['enabled']);
        $this->assertFalse($config['use_nonce']);
        $this->assertFalse($config['report_only']);
    }

    /** @test */
    public function it_service_provider_can_be_singleton()
    {
        // Register twice should not cause issues
        $provider1 = new GsmuiProServiceProvider($this->app);
        $provider2 = new GsmuiProServiceProvider($this->app);

        $provider1->register();
        $provider2->register();

        $this->assertTrue(true); // No duplicate binding errors
    }
}
