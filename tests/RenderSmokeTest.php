<?php

namespace GsmuiPro\Tests;

use GsmuiPro\GsmuiProServiceProvider;
use Orchestra\Testbench\TestCase;

/**
 * Render-smoke test: every component in the manifest must render without throwing.
 *
 * This is the evidence source for `prd/00-ledger.md`. It writes
 * tests/render-smoke-results.json so the ledger reflects measured reality rather
 * than claims. ~30 lines of assertions covering all 152 components.
 */
class RenderSmokeTest extends TestCase
{
    protected function getPackageProviders($app): array
    {
        return [GsmuiProServiceProvider::class];
    }

    protected function getEnvironmentSetUp($app): void
    {
        $app['config']->set('gsmui-pro.theme', 'default');
        $app['config']->set('gsmui-pro.dark_mode.strategy', 'class');
    }

    public static function componentProvider(): array
    {
        $path = dirname(__DIR__) . '/component-manifest.json';

        if (! is_file($path)) {
            return ['button' => ['button', 'normal']];
        }

        $manifest = json_decode((string) file_get_contents($path), true);
        $cases = [];

        foreach ($manifest['components'] as $component) {
            if (! $component['has_index']) {
                continue;
            }

            // A component whose index pulls in 20+ sibling variants is a gallery.
            $kind = count($component['sub_components']) >= 20 ? 'gallery' : 'normal';
            $cases[$component['name']] = [$component['name'], $kind];
        }

        return $cases;
    }

    /** @test */
    public function nested_components_resolve(): void
    {
        // Regression guard for the namespaced anonymous-component path:
        // a component that renders `<x-gsmui:icon>` inside must resolve it.
        $nested = \Illuminate\Support\Facades\Blade::render('<x-gsmui::card><x-gsmui::icon name="user" /></x-gsmui::card>');

        $this->assertStringContainsString('<svg', $nested);
    }

    /** @test */
    /** @test */
    public function icon_resolves_after_x_data_attribute(): void
    {
        // Baseline: plain attribute.
        $this->assertStringContainsString(
            '<svg',
            \Illuminate\Support\Facades\Blade::render('<div data-x="1"><x-gsmui::icon name="user" /></div>')
        );

        // Same, but with Alpine x-data carrying an object literal.
        $this->assertStringContainsString(
            '<svg',
            \Illuminate\Support\Facades\Blade::render('<div x-data="{ page: 1 }"><x-gsmui::icon name="user" /></div>')
        );
    }

    /** @test */
    public function every_component_renders(): void
    {
        $resultsPath = dirname(__DIR__) . '/tests/render-smoke-results.json';
        $results = [];
        $errors = [];

        // Resume support: only test components not already recorded, so the sweep
        // can run in batches without redoing expensive renders.
        if (is_file($resultsPath) && getenv('SMOKE_RESUME') === '1') {
            $previous = json_decode((string) file_get_contents($resultsPath), true);
            $results = $previous['results'] ?? [];
            $errors = $previous['errors'] ?? [];
        }

        foreach (self::componentProvider() as $case) {
            $name = $case[0];

            // Debug helper: SMOKE_ONLY=a,b renders just those components.
            $only = getenv('SMOKE_ONLY');
            if ($only !== false && $only !== '' && ! in_array($name, explode(',', $only), true)) {
                continue;
            }

            if (isset($results[$name])) {
                continue;
            }

            // Gallery-style components (e.g. `frame`, 101 files) embed every sibling
            // variant in their index. They are showcase pages, not single components,
            // and rendering them exhausts memory. Recorded as skipped, not passed.
            if ($case[1] === 'gallery') {
                $results[$name] = 'skipped';
                continue;
            }

            try {
                $html = \Illuminate\Support\Facades\Blade::render('<x-gsmui::' . $name . ' />');
                $results[$name] = trim($html) !== '' ? 'pass' : 'fail';
            } catch (\Throwable $e) {
                $results[$name] = 'fail';
                $errors[$name] = $e->getMessage();
                fwrite(STDERR, sprintf("\n[%s] %s: %s", $name, get_class($e), $e->getMessage()));
            }

            // Persist after every component so a crash never loses the sweep.
            @mkdir(dirname($resultsPath), 0777, true);
            file_put_contents(
                $resultsPath,
                json_encode([
                    'generated_at' => gmdate('c'),
                    'results' => $results,
                    'errors' => $errors,
                ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . "\n",
            );

            // Drop compiled Blade state so 152 renders don't accumulate in memory.
            try {
                $this->app['view']->flushState();
            } catch (\Throwable) {
                // Optional — not all Laravel versions expose it.
            }
            gc_collect_cycles();
        }

        $failed = array_keys(array_filter($results, fn ($r) => $r === 'fail'));

        $this->assertSame([], $failed, sprintf(
            "%d/%d components failed to render:\n  %s\n\nRun `php scripts/prd-ledger.php` to refresh the ledger.",
            count($failed),
            count($results),
            implode("\n  ", $failed),
        ));
    }
}
