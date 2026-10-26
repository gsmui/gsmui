<?php

namespace GsmuiPro\Tests;

use Orchestra\Testbench\TestCase;
use GsmuiPro\GsmuiProServiceProvider;
use GsmuiPro\GsmuiProManager;

class PackageInstallerTest extends TestCase
{
    protected function getPackageProviders($app): array
    {
        return [
            GsmuiProServiceProvider::class,
        ];
    }

    public function test_package_can_be_installed(): void
    {
        $manager = $this->app->make(GsmuiProManager::class);
        $this->assertInstanceOf(GsmuiProManager::class, $manager);
    }

    public function test_config_files_exist(): void
    {
        $this->assertFileExists(__DIR__.'/../stubs/config/gsmui-pro.php');
        $this->assertFileExists(__DIR__.'/../stubs/config/gsmui-pro-csp.php');
    }

    public function test_helpers_are_loaded(): void
    {
        $this->assertTrue(function_exists('gsmui'));
        $this->assertTrue(function_exists('gsmui_classes'));
        $this->assertTrue(function_exists('gsmui_id'));
        $this->assertTrue(function_exists('gsmui_version'));
        $this->assertTrue(function_exists('gsmui_theme'));
        $this->assertTrue(function_exists('gsmui_set_theme'));
        $this->assertTrue(function_exists('gsmui_css_variables'));
        $this->assertTrue(function_exists('gsmui_kebab'));
        $this->assertTrue(function_exists('gsmui_camel'));
        $this->assertTrue(function_exists('gsmui_pascal'));
        $this->assertTrue(function_exists('gsmui_snake'));
    }

    public function test_facade_can_be_used(): void
    {
        $version = \GsmuiPro\GsmuiPro::getVersion();
        $this->assertIsString($version);
    }

    public function test_manager_singleton_is_same_instance(): void
    {
        $manager1 = gsmui();
        $manager2 = gsmui();

        $this->assertSame($manager1, $manager2);
    }

    public function test_default_theme_is_set(): void
    {
        $theme = gsmui_theme();
        $this->assertEquals('default', $theme);
    }

    public function test_theme_can_be_changed(): void
    {
        gsmui_set_theme('blue');
        $this->assertEquals('blue', gsmui_theme());
    }

    public function test_unique_id_is_unique(): void
    {
        $ids = [];
        for ($i = 0; $i < 100; $i++) {
            $ids[] = gsmui_id();
        }
        $this->assertCount(100, array_unique($ids));
    }

    public function test_string_helpers_work(): void
    {
        $this->assertEquals('hello-world', gsmui_kebab('helloWorld'));
        $this->assertEquals('helloWorld', gsmui_camel('hello-world'));
        $this->assertEquals('HelloWorld', gsmui_pascal('hello-world'));
        $this->assertEquals('hello_world', gsmui_snake('hello-world'));
    }

    public function test_version_helper_returns_string(): void
    {
        $version = gsmui_version();
        $this->assertIsString($version);
        $this->assertNotEmpty($version);
    }

    public function test_css_variables_generation(): void
    {
        gsmui()->setCssVariable('primary', '#3b82f6');
        $css = gsmui_css_variables();

        $this->assertStringContainsString(':root', $css);
        $this->assertStringContainsString('--gsmui-primary', $css);
    }
}
