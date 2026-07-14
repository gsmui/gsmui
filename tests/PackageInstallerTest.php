<?php

namespace Tests;

use Orchestra\Testbench\TestCase;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Artisan;
use GsmuiPro\GsmuiProServiceProvider;

class PackageInstallerTest extends TestCase
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
    public function it_registers_the_gsmui_pro_manager_singleton()
    {
        $this->assertTrue($this->app->bound('GsmuiPro\GsmuiProManager'));
    }

    /** @test */
    public function it_merges_csp_config()
    {
        $config = config('gsmui-pro-csp');

        $this->assertIsArray($config);
        $this->assertArrayHasKey('enabled', $config);
        $this->assertArrayHasKey('use_nonce', $config);
        $this->assertArrayHasKey('report_only', $config);
    }

    /** @test */
    public function it_registers_blade_component_path()
    {
        $service = $this->app->make(GsmuiProServiceProvider::class);

        $this->assertNotNull($service);
    }

    /** @test */
    public function it_has_required_source_files()
    {
        $base = dirname(__DIR__);

        $this->assertFileExists($base . '/src/GsmuiProServiceProvider.php');
        $this->assertFileExists($base . '/src/GsmuiProManager.php');
        $this->assertFileExists($base . '/src/helpers.php');
        $this->assertFileExists($base . '/composer.json');
    }

    /** @test */
    public function it_has_required_config_files()
    {
        $base = dirname(__DIR__);

        $this->assertFileExists($base . '/stubs/config/gsmui-pro-csp.php');
    }

    /** @test */
    public function it_has_required_view_files()
    {
        $base = dirname(__DIR__);
        $views = $base . '/stubs/resources/views/gsmui';

        $this->assertDirectoryExists($views);
        $this->assertDirectoryExists($views . '/button');
        $this->assertDirectoryExists($views . '/input');
        $this->assertDirectoryExists($views . '/modal');
        $this->assertDirectoryExists($views . '/card');
    }

    /** @test */
    public function it_has_required_dist_files()
    {
        $base = dirname(__DIR__);

        $this->assertFileExists($base . '/dist/gsmui.js');
        $this->assertFileExists($base . '/dist/manifest.json');
    }

    /** @test */
    public function it_can_publish_csp_config()
    {
        $configPath = config_path('gsmui-pro-csp.php');

        // Clean up if exists
        if (File::exists($configPath)) {
            File::delete($configPath);
        }

        Artisan::call('vendor:publish', [
            '--tag' => 'gsmui-pro-csp-config',
        ]);

        $this->assertFileExists($configPath);

        // Clean up
        File::delete($configPath);
    }

    /** @test */
    public function it_composer_json_has_correct_metadata()
    {
        $composer = json_decode(
            file_get_contents(dirname(__DIR__) . '/composer.json'),
            true
        );

        $this->assertEquals('gsmui/gsmui-pro', $composer['name']);
        $this->assertArrayHasKey('require', $composer);
        $this->assertArrayHasKey('extra', $composer);
        $this->assertArrayHasKey('laravel', $composer['extra']);
        $this->assertArrayHasKey('providers', $composer['extra']['laravel']);
    }

    /** @test */
    public function it_composer_json_requires_laravel_packages()
    {
        $composer = json_decode(
            file_get_contents(dirname(__DIR__) . '/composer.json'),
            true
        );

        $this->assertArrayHasKey('illuminate/console', $composer['require']);
        $this->assertArrayHasKey('illuminate/support', $composer['require']);
        $this->assertArrayHasKey('illuminate/view', $composer['require']);
    }

    /** @test */
    public function it_composer_json_requires_livewire()
    {
        $composer = json_decode(
            file_get_contents(dirname(__DIR__) . '/composer.json'),
            true
        );

        $this->assertArrayHasKey('livewire/livewire', $composer['require']);
    }

    /** @test */
    public function it_has_autoload_configuration()
    {
        $composer = json_decode(
            file_get_contents(dirname(__DIR__) . '/composer.json'),
            true
        );

        $this->assertArrayHasKey('autoload', $composer);
        $this->assertArrayHasKey('psr-4', $composer['autoload']);
        $this->assertArrayHasKey('GsmuiPro\\\\', $composer['autoload']['psr-4']);
    }

    /** @test */
    public function it_has_helpers_file_autoloaded()
    {
        $composer = json_decode(
            file_get_contents(dirname(__DIR__) . '/composer.json'),
            true
        );

        $this->assertContains('src/helpers.php', $composer['autoload']['files']);
    }

    /** @test */
    public function it_has_serve_script()
    {
        $composer = json_decode(
            file_get_contents(dirname(__DIR__) . '/composer.json'),
            true
        );

        $this->assertArrayHasKey('scripts', $composer);
        $this->assertArrayHasKey('serve', $composer['scripts']);
    }

    /** @test */
    public function it_has_readme_file()
    {
        $this->assertFileExists(dirname(__DIR__) . '/README.md');
    }

    /** @test */
    public function it_has_changelog_file()
    {
        $this->assertFileExists(dirname(__DIR__) . '/CHANGELOG.md');
    }

    /** @test */
    public function it_has_license_file()
    {
        $this->assertFileExists(dirname(__DIR__) . '/LICENSE.md');
    }

    /** @test */
    public function it_has_tests_directory()
    {
        $this->assertDirectoryExists(dirname(__DIR__) . '/tests');
        $this->assertDirectoryExists(dirname(__DIR__) . '/tests/Browser');
    }
}
