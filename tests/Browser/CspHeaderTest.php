<?php

namespace Tests\Browser;

use GsmuiPro\Http\Middleware\CspMiddleware;
use Orchestra\Testbench\TestCase;

class CspHeaderTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [
            \GsmuiPro\GsmuiProServiceProvider::class,
        ];
    }

    protected function defineEnvironment($app)
    {
        // Ensure CSP is enabled for tests
        $app['config']->set('gsmui-pro-csp.enabled', true);
        $app['config']->set('gsmui-pro-csp.use_nonce', false);
    }

    /** @test */
    public function it_sets_csp_header_on_responses()
    {
        $this->app->make('router')->get('_csp-test', function () {
            return response('<html><body>OK</body></html>');
        })->middleware(CspMiddleware::class);

        $response = $this->get('_csp-test');

        $response->assertHeader('Content-Security-Policy');
    }

    /** @test */
    public function csp_header_contains_expected_directives()
    {
        $this->app->make('router')->get('_csp-test2', function () {
            return response('<html><body>OK</body></html>');
        })->middleware(CspMiddleware::class);

        $response = $this->get('_csp-test2');

        $csp = $response->headers->get('Content-Security-Policy');

        $this->assertStringContainsString("default-src 'self'", $csp);
        $this->assertStringContainsString("script-src 'self'", $csp);
        $this->assertStringContainsString("style-src 'self'", $csp);
        $this->assertStringContainsString("img-src 'self' data:", $csp);
        $this->assertStringContainsString('base-uri', $csp);
        $this->assertStringContainsString('form-action', $csp);
        $this->assertStringContainsString('frame-ancestors', $csp);
    }

    /** @test */
    public function csp_header_does_not_contain_unsafe_eval()
    {
        $this->app->make('router')->get('_csp-test3', function () {
            return response('<html><body>OK</body></html>');
        })->middleware(CspMiddleware::class);

        $response = $this->get('_csp-test3');

        $csp = $response->headers->get('Content-Security-Policy');

        $this->assertStringNotContainsString("'unsafe-eval'", $csp);
    }

    /** @test */
    public function csp_is_skipped_when_disabled()
    {
        $this->app['config']->set('gsmui-pro-csp.enabled', false);

        $this->app->make('router')->get('_csp-test4', function () {
            return response('<html><body>OK</body></html>');
        })->middleware(CspMiddleware::class);

        $response = $this->get('_csp-test4');

        $response->assertHeaderMissing('Content-Security-Policy');
    }

    /** @test */
    public function nonce_is_injected_when_configured()
    {
        $this->app['config']->set('gsmui-pro-csp.use_nonce', true);

        $this->app->make('router')->get('_csp-test5', function () {
            return response('<html><body>OK</body></html>');
        })->middleware(CspMiddleware::class);

        $response = $this->get('_csp-test5');

        $csp = $response->headers->get('Content-Security-Policy');

        $this->assertStringContainsString("'nonce-", $csp);
        // When nonce is used, unsafe-inline for script-src should be dropped
        $this->assertStringNotContainsString("'unsafe-inline'", $csp);
    }

    /** @test */
    public function report_only_header_is_set_when_configured()
    {
        $this->app['config']->set('gsmui-pro-csp.report_only', true);

        $this->app->make('router')->get('_csp-test6', function () {
            return response('<html><body>OK</body></html>');
        })->middleware(CspMiddleware::class);

        $response = $this->get('_csp-test6');

        $response->assertHeader('Content-Security-Policy-Report-Only');
        $response->assertHeaderMissing('Content-Security-Policy');
    }

    /** @test */
    public function upgrade_insecure_requests_directive_is_present()
    {
        $this->app->make('router')->get('_csp-test7', function () {
            return response('<html><body>OK</body></html>');
        })->middleware(CspMiddleware::class);

        $response = $this->get('_csp-test7');

        $csp = $response->headers->get('Content-Security-Policy');

        $this->assertStringContainsString('upgrade-insecure-requests', $csp);
    }
}
