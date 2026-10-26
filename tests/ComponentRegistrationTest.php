<?php

namespace GsmuiPro\Tests;

use Orchestra\Testbench\TestCase;
use GsmuiPro\GsmuiProServiceProvider;
use GsmuiPro\GsmuiProManager;

class ComponentRegistrationTest extends TestCase
{
    protected GsmuiProManager $manager;

    protected function setUp(): void
    {
        parent::setUp();

        $this->app->register(GsmuiProServiceProvider::class);
        $this->manager = $this->app->make(GsmuiProManager::class);
    }

    public function test_component_can_be_registered(): void
    {
        $this->manager->registerComponent('test-button', [
            'type' => 'button',
            'variant' => 'primary',
        ]);

        $this->assertTrue($this->manager->hasComponent('test-button'));
        $this->assertEquals([
            'type' => 'button',
            'variant' => 'primary',
        ], $this->manager->getComponent('test-button'));
    }

    public function test_category_can_be_registered(): void
    {
        $this->manager->registerCategory('forms', ['input', 'select', 'textarea']);

        $this->assertEquals(['input', 'select', 'textarea'], $this->manager->getComponentsByCategory('forms'));
    }

    public function test_theme_can_be_set(): void
    {
        $this->manager->setTheme('blue');
        $this->assertEquals('blue', $this->manager->getTheme());
    }

    public function test_invalid_theme_throws_exception(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->manager->setTheme('invalid-theme');
    }

    public function test_custom_theme_can_be_registered(): void
    {
        $this->manager->registerTheme('custom');
        $this->assertContains('custom', $this->manager->getThemes());
    }

    public function test_css_variable_can_be_set(): void
    {
        $this->manager->setCssVariable('primary', '#3b82f6');
        $variables = $this->manager->getCssVariables();

        $this->assertArrayHasKey('primary', $variables);
        $this->assertEquals('#3b82f6', $variables['primary']);
    }

    public function test_css_variables_can_be_generated(): void
    {
        $this->manager->setCssVariable('primary', '#3b82f6');
        $css = $this->manager->generateCssVariables();

        $this->assertStringContainsString(':root', $css);
        $this->assertStringContainsString('--gsmui-primary', $css);
        $this->assertStringContainsString('#3b82f6', $css);
    }

    public function test_component_count(): void
    {
        $initialCount = $this->manager->getComponentCount();

        $this->manager->registerComponent('new-component');
        $this->assertEquals($initialCount + 1, $this->manager->getComponentCount());
    }

    public function test_get_component_names(): void
    {
        $this->manager->registerComponent('button');
        $this->manager->registerComponent('input');

        $names = $this->manager->getComponentNames();
        $this->assertContains('button', $names);
        $this->assertContains('input', $names);
    }

    public function test_classes_merge_works(): void
    {
        // Views call the fluent form: Gsmui::classes()->add(...)->add(...).
        $classes = GsmuiProManager::classes()->add('a')->add('b');

        $this->assertInstanceOf(\GsmuiPro\ClassBuilder::class, $classes);
        $this->assertSame('a b', (string) $classes);
        $this->assertSame(['a', 'b'], $classes->toArray());
    }

    public function test_classes_include_component_defaults(): void
    {
        $classes = (string) GsmuiProManager::classes('button')->add('extra');

        $this->assertStringContainsString('inline-flex', $classes);
        $this->assertStringEndsWith('extra', $classes);
    }

    public function test_unique_id_generation(): void
    {
        $id1 = GsmuiProManager::uniqueId();
        $id2 = GsmuiProManager::uniqueId();

        $this->assertNotEquals($id1, $id2);
        $this->assertStringStartsWith('gsmui-', $id1);
    }

    public function test_string_helpers(): void
    {
        $this->assertEquals('hello-world', GsmuiProManager::kebab('helloWorld'));
        $this->assertEquals('helloWorld', GsmuiProManager::camel('hello-world'));
        $this->assertEquals('HelloWorld', GsmuiProManager::pascal('hello-world'));
        $this->assertEquals('hello_world', GsmuiProManager::snake('hello-world'));
    }

    public function test_version_returns_string(): void
    {
        $version = $this->manager->getVersion();
        $this->assertIsString($version);
        $this->assertNotEmpty($version);
    }

    public function test_info_returns_array(): void
    {
        $info = $this->manager->getInfo();

        $this->assertIsArray($info);
        $this->assertArrayHasKey('name', $info);
        $this->assertArrayHasKey('version', $info);
        $this->assertArrayHasKey('component_count', $info);
        $this->assertArrayHasKey('theme', $info);
        $this->assertArrayHasKey('themes', $info);
    }
}
