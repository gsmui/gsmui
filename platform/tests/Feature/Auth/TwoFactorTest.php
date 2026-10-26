<?php

declare(strict_types=1);

namespace Tests\Feature\Auth;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PragmaRX\Google2FA\Google2FA;

class TwoFactorTest extends TestCase
{
    use RefreshDatabase;

    public function test_two_factor_settings_page_requires_authentication(): void
    {
        $response = $this->get('/settings/two-factor-authentication');

        $response->assertRedirect('/login');
    }

    public function test_two_factor_settings_page_can_be_rendered(): void
    {
        $user = $this->createUser();
        $this->actingAs($user);

        $response = $this->get('/settings/two-factor-authentication');

        $response->assertStatus(200);
    }

    public function test_two_factor_can_be_enabled(): void
    {
        $user = $this->createUser();
        $this->actingAs($user);

        $google2fa = new Google2FA();
        $secret = $google2fa->generateSecretKey();

        $response = $this->post('/settings/two-factor-authentication', [
            'secret' => $secret,
            'code' => $google2fa->generateKeyNow($secret),
        ]);

        $response->assertSessionHasNoErrors();
        $user->refresh();
        $this->assertNotNull($user->two_factor_secret);
    }

    public function test_two_factor_requires_valid_code_to_enable(): void
    {
        $user = $this->createUser();
        $this->actingAs($user);

        $google2fa = new Google2FA();
        $secret = $google2fa->generateSecretKey();

        $response = $this->post('/settings/two-factor-authentication', [
            'secret' => $secret,
            'code' => '000000',
        ]);

        $response->assertSessionHasErrors();
    }

    public function test_two_factor_can_be_disabled(): void
    {
        $user = $this->createUser();
        $this->actingAs($user);

        $google2fa = new Google2FA();
        $secret = $google2fa->generateSecretKey();

        $this->post('/settings/two-factor-authentication', [
            'secret' => $secret,
            'code' => $google2fa->generateKeyNow($secret),
        ]);

        $response = $this->delete('/settings/two-factor-authentication');

        $response->assertSessionHasNoErrors();
        $user->refresh();
        $this->assertNull($user->two_factor_secret);
    }

    public function test_two_factor_recovery_codes_are_generated(): void
    {
        $user = $this->createUser();
        $this->actingAs($user);

        $google2fa = new Google2FA();
        $secret = $google2fa->generateSecretKey();

        $this->post('/settings/two-factor-authentication', [
            'secret' => $secret,
            'code' => $google2fa->generateKeyNow($secret),
        ]);

        $user->refresh();
        $this->assertNotNull($user->two_factor_recovery_codes);
        $this->assertIsArray(json_decode($user->two_factor_recovery_codes, true));
    }

    public function test_two_factor_secret_is_hidden_from_response(): void
    {
        $user = $this->createUser();
        $this->actingAs($user);

        $response = $this->getJson('/api/user');

        $response->assertJsonMissing(['two_factor_secret']);
    }
}
