# Password Reset

> Token generation, email flow, security rules, rate limiting, audit logging.

## Password Reset Flow

```php
// app/Http/Controllers/Auth/ForgotPasswordController.php
class ForgotPasswordController extends Controller
{
    public function showLinkRequestForm()
    {
        return view('auth.forgot-password');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with('status', __($status))
            : back()->withErrors(['email' => __($status)]);
    }
}

// app/Http/Controllers/Auth/ResetPasswordController.php
class ResetPasswordController extends Controller
{
    public function showResetForm(Request $request, string $token)
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->email,
        ]);
    }

    public function reset(Request $request)
    {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', Password::min(8)->mixedCase()->numbers()],
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                    'password_changed_at' => now(),
                ])->save();

                event(new PasswordReset($user));

                // Revoke all other sessions
                $user->sessions()->where('id', '!=', $user->current_session_id)->delete();
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', __($status))
            : back()->withErrors(['email' => __($status)]);
    }
}
```

## Token Generation

```php
// Custom token generation
class PasswordResetService
{
    public function generateToken(User $user): string
    {
        $token = Str::random(60);

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $user->email],
            [
                'token' => Hash::make($token),
                'created_at' => now(),
                'expires_at' => now()->addHours(6),
            ]
        );

        return $token;
    }

    public function validateToken(string $email, string $token): bool
    {
        $record = DB::table('password_reset_tokens')
            ->where('email', $email)
            ->first();

        if (!$record) {
            return false;
        }

        if (Carbon::parse($record->expires_at)->isPast()) {
            $this->deleteToken($email);
            return false;
        }

        return Hash::check($token, $record->token);
    }

    public function deleteToken(string $email): void
    {
        DB::table('password_reset_tokens')
            ->where('email', $email)
            ->delete();
    }
}
```

## Email Flow

```php
// app/Mail/ResetPasswordEmail.php
class ResetPasswordEmail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $email,
        public string $token
    ) {}

    public function build(): static
    {
        $resetUrl = url(route('password.reset', [
            'token' => $this->token,
            'email' => $this->email,
        ]));

        return $this
            ->subject('Reset Your Password')
            ->markdown('emails.password-reset', [
                'resetUrl' => $resetUrl,
                'email' => $this->email,
            ]);
    }
}

// Sending the email
Password::sendResetLink(['email' => $email]);
```

```blade
{{-- resources/views/emails/password-reset.blade.php --}}
<x-mail::message>
# Reset Your Password

We received a request to reset the password for this email address.

<x-mail::button :url="$resetUrl">
Reset Password
</x-mail::button>

This link will expire in 6 hours.

If you didn't request a password reset, no further action is required.

Thanks,<br>
{{ config('app.name') }} Team
</x-mail::message>
```

## Security Rules

```php
class PasswordResetSecurity
{
    // Rate limit reset requests
    public function checkRateLimit(string $email): bool
    {
        $key = "password_reset:{$email}";

        if (RateLimiter::tooManyAttempts($key, 3)) {
            $seconds = RateLimiter::availableIn($key);
            throw new \RuntimeException(
                "Too many reset attempts. Please try again in {$seconds} seconds."
            );
        }

        RateLimiter::increment($key, 60);

        return true;
    }

    // Check for suspicious activity
    public function checkSuspiciousActivity(string $email, Request $request): void
    {
        $recentResets = DB::table('password_reset_tokens')
            ->where('email', $email)
            ->where('created_at', '>=', now()->subHour())
            ->count();

        if ($recentResets > 5) {
            // Log suspicious activity
            activity()
                ->withProperties([
                    'email' => $email,
                    'ip' => $request->ip(),
                    'attempts' => $recentResets,
                ])
                ->log('Suspicious password reset activity');

            // Notify user
            $user = User::where('email', $email)->first();
            if ($user) {
                Notification::send($user, new SuspiciousResetNotification());
            }
        }
    }

    // Validate IP consistency
    public function validateIpConsistency(string $email, Request $request): bool
    {
        $lastIp = Cache::get("password_reset_ip:{$email}");

        if ($lastIp && $lastIp !== $request->ip()) {
            // Different IP than previous reset attempt
            activity()
                ->withProperties([
                    'email' => $email,
                    'previous_ip' => $lastIp,
                    'current_ip' => $request->ip(),
                ])
                ->log('Password reset IP mismatch');

            return false;
        }

        Cache::put("password_reset_ip:{$email}", $request->ip(), 3600);

        return true;
    }
}
```

## Rate Limiting

```php
// config/fortify.php
'limiters' => [
    'password-reset' => 'password-reset',
],

// Route rate limiting
Route::middleware('throttle:password-reset')->group(function () {
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail']);
    Route::post('/reset-password', [ResetPasswordController::class, 'reset']);
});

// Custom rate limiter
RateLimiter::for('password-reset', function (Request $request) {
    return Limit::perMinute(3)->by($request->input('email'));
});
```

## Audit Logging

```php
class PasswordResetAuditor
{
    public function logResetRequest(string $email, Request $request): void
    {
        activity()
            ->withProperties([
                'email' => $email,
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'type' => 'request',
            ])
            ->log('Password reset requested');
    }

    public function logResetSuccess(string $email, Request $request): void
    {
        activity()
            ->withProperties([
                'email' => $email,
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'type' => 'success',
            ])
            ->log('Password reset completed');
    }

    public function logResetFailure(string $email, string $reason, Request $request): void
    {
        activity()
            ->withProperties([
                'email' => $email,
                'ip' => $request->ip(),
                'reason' => $reason,
                'type' => 'failure',
            ])
            ->log('Password reset failed');
    }
}
```

## Reset Password View

```blade
{{-- resources/views/auth/reset-password.blade.php --}}
<x-layouts.auth>
    <form method="POST" action="{{ route('password.update') }}">
        @csrf

        <input type="hidden" name="token" value="{{ $token }}">

        <div class="space-y-4">
            <x-gsmui::input
                label="Email"
                name="email"
                type="email"
                :value="$email ?? old('email')"
                required
                readonly
                :error="$errors->first('email')"
            />

            <x-gsmui::input
                label="New password"
                name="password"
                type="password"
                required
                :error="$errors->first('password')"
                placeholder="Minimum 8 characters"
            />

            <x-gsmui::input
                label="Confirm new password"
                name="password_confirmation"
                type="password"
                required
                placeholder="Confirm your new password"
            />

            <x-gsmui::button type="submit" class="w-full">
                Reset Password
            </x-gsmui::button>
        </div>
    </form>
</x-layouts.auth>
```

## Testing

```php
class PasswordResetTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_request_password_reset(): void
    {
        $user = User::factory()->create();

        $response = $this->post('/forgot-password', [
            'email' => $user->email,
        ]);

        $response->assertSessionHas('status');
        $this->assertDatabaseHas('password_reset_tokens', [
            'email' => $user->email,
        ]);
    }

    public function test_user_can_reset_password(): void
    {
        $user = User::factory()->create();
        $token = app(PasswordResetService::class)->generateToken($user);

        $response = $this->post('/reset-password', [
            'token' => $token,
            'email' => $user->email,
            'password' => 'NewPassword123!',
            'password_confirmation' => 'NewPassword123!',
        ]);

        $response->assertRedirect('/login');
        $this->assertTrue(Hash::check('NewPassword123!', $user->fresh()->password));
    }

    public function test_expired_token_is_rejected(): void
    {
        $user = User::factory()->create();

        DB::table('password_reset_tokens')->insert([
            'email' => $user->email,
            'token' => Hash::make('expired-token'),
            'created_at' => now()->subHours(7),
        ]);

        $response = $this->post('/reset-password', [
            'token' => 'expired-token',
            'email' => $user->email,
            'password' => 'NewPassword123!',
            'password_confirmation' => 'NewPassword123!',
        ]);

        $response->assertSessionHasErrors();
    }
}
```
