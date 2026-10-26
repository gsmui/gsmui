# Two-Factor Authentication

> TOTP setup, recovery codes, enforcement, trusted devices, backup strategies.

## TOTP Setup

```php
// app/Http/Controllers/TwoFactorController.php
class TwoFactorController extends Controller
{
    public function show(Request $request)
    {
        $user = $request->user();

        if ($user->hasTwoFactorEnabled()) {
            return view('profile.two-factor-enabled');
        }

        $qrCode = $user->twoFactorQrCodeSvg();
        $secret = $user->twoFactorSecret;
        $recoveryCodes = $user->twoFactorRecoveryCodes();

        return view('profile.two-factor-setup', compact('qrCode', 'secret', 'recoveryCodes'));
    }

    public function enable(Request $request)
    {
        $request->validate([
            'code' => ['required', 'string', 'size:6'],
        ]);

        $user = $request->user();

        if (! $user->validateTwoFactorCode($request->code)) {
            return back()->withErrors([
                'code' => ['The provided two-factor authentication code is invalid.'],
            ]);
        }

        $user->enableTwoFactorAuthentication();

        return view('profile.two-factor-recovery-codes', [
            'recoveryCodes' => $user->twoFactorRecoveryCodes(),
        ]);
    }

    public function disable(Request $request)
    {
        $request->validate([
            'password' => ['required', 'string'],
        ]);

        if (! $request->user()->validatePassword($request->password)) {
            return back()->withErrors([
                'password' => ['The password is incorrect.'],
            ]);
        }

        $request->user()->disableTwoFactorAuthentication();

        return back()->with('status', 'Two-factor authentication has been disabled.');
    }
}
```

## Recovery Codes

```php
// app/Models/User.php
class User extends Authenticatable
{
    use HasFactory, Notifiable, TwoFactorAuthenticatable;

    // Generate recovery codes
    public function generateRecoveryCodes(): array
    {
        $codes = collect();

        for ($i = 0; $i < 8; $i++) {
            $codes->push(Str::random(10));
        }

        $this->forceFill([
            'two_factor_recovery_codes' => encrypt($codes->toJson()),
        ])->save();

        return $codes->toArray();
    }

    // Use recovery code
    public function useRecoveryCode(string $code): bool
    {
        $codes = collect(decrypt($this->two_factor_recovery_codes));

        if ($codes->contains($code)) {
            $codes = $codes->reject(fn ($c) => $c === $code)->values();

            $this->forceFill([
                'two_factor_recovery_codes' => encrypt($codes->toJson()),
            ])->save();

            return true;
        }

        return false;
    }

    // Check if recovery code is valid
    public function validateRecoveryCode(string $code): bool
    {
        $codes = collect(decrypt($this->two_factor_recovery_codes));

        return $codes->contains($code);
    }
}
```

## TOTP Validation

```php
class TwoFactorLoginController extends Controller
{
    public function showForm()
    {
        return view('auth.two-factor');
    }

    public function verify(Request $request)
    {
        $request->validate([
            'code' => ['required', 'string'],
        ]);

        $user = User::where('id', session('two_factor_user_id'))->first();

        if (!$user) {
            return redirect()->route('login');
        }

        // Check if it's a recovery code
        if (strlen($request->code) > 6) {
            if ($user->useRecoveryCode($request->code)) {
                auth()->login($user);
                session()->forget('two_factor_user_id');

                return redirect('/dashboard');
            }
        }

        // Validate TOTP code
        if ($user->validateTwoFactorCode($request->code)) {
            auth()->login($user);
            session()->forget('two_factor_user_id');

            return redirect('/dashboard');
        }

        return back()->withErrors([
            'code' => ['The provided code is invalid.'],
        ]);
    }
}
```

## Enforcement

```php
// Force 2FA for all users
class EnforceTwoFactorMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && !auth()->user()->hasTwoFactorEnabled()) {
            if (!$request->is('profile/*', 'two-factor/*', 'logout')) {
                return redirect()->route('two-factor.show')
                    ->with('warning', 'Two-factor authentication is required.');
            }
        }

        return $next($request);
    }
}

// Register middleware
protected $middlewareAliases = [
    '2fa' => EnforceTwoFactorMiddleware::class,
];

// Apply to routes
Route::middleware(['auth', '2fa'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index']);
});
```

## Trusted Devices

```php
class TrustedDevice
{
    public function __construct(
        protected User $user,
        protected Request $request,
    ) {}

    public function remember(): void
    {
        $device = [
            'id' => Str::uuid(),
            'name' => $this->getDeviceName(),
            'ip' => $this->request->ip(),
            'user_agent' => $this->request->userAgent(),
            'created_at' => now()->toIso8601String(),
            'last_used_at' => now()->toIso8601String(),
        ];

        $devices = collect(decrypt($this->user->two_factor_trusted_devices ?? '[]'));
        $devices->push($device);

        $this->user->forceFill([
            'two_factor_trusted_devices' => encrypt($devices->toJson()),
        ])->save();
    }

    public function isTrusted(): bool
    {
        $devices = collect(decrypt($this->user->two_factor_trusted_devices ?? '[]'));

        return $devices->contains(function ($device) {
            return $device['user_agent'] === $this->request->userAgent()
                && $device['ip'] === $this->request->ip();
        });
    }

    public function forget(): void
    {
        $devices = collect(decrypt($this->user->two_factor_trusted_devices ?? '[]'));
        $devices = $devices->reject(function ($device) {
            return $device['user_agent'] === $this->request->userAgent()
                && $device['ip'] === $this->request->ip();
        });

        $this->user->forceFill([
            'two_factor_trusted_devices' => encrypt($devices->toJson()),
        ])->save();
    }

    protected function getDeviceName(): string
    {
        $agent = new UserAgent($this->request->userAgent());

        return "{$agent->platform()} - {$agent->browser()}";
    }
}
```

## Backup Strategies

```php
class TwoFactorBackupService
{
    public function generateBackupCodes(User $user): array
    {
        $codes = [];

        for ($i = 0; $i < 10; $i++) {
            $codes[] = strtoupper(Str::random(4) . '-' . Str::random(4));
        }

        $user->forceFill([
            'two_factor_backup_codes' => encrypt(collect($codes)->toJson()),
        ])->save();

        return $codes;
    }

    public function useBackupCode(User $user, string $code): bool
    {
        $codes = collect(decrypt($user->two_factor_backup_codes));

        if ($codes->contains($code)) {
            $codes = $codes->reject(fn ($c) => $c === $code)->values();

            $user->forceFill([
                'two_factor_backup_codes' => encrypt($codes->toJson()),
            ])->save();

            return true;
        }

        return false;
    }

    public function remainingCodes(User $user): int
    {
        $codes = collect(decrypt($user->two_factor_backup_codes));

        return $codes->count();
    }
}
```

## Recovery Codes View

```blade
{{-- resources/views/profile/two-factor-recovery-codes.blade.php --}}
<x-layouts.app>
    <div class="mx-auto max-w-lg">
        <h1 class="mb-4 text-2xl font-bold">Recovery Codes</h1>

        <div class="mb-6 rounded-lg border border-amber-200 bg-amber-50 p-4">
            <p class="text-sm text-amber-800">
                Store these recovery codes in a safe place. Each code can only be used once.
                If you lose access to your two-factor device, you can use one of these codes to log in.
            </p>
        </div>

        <div class="mb-6 grid grid-cols-2 gap-2 rounded-lg border border-zinc-200 bg-zinc-50 p-4 font-mono text-sm">
            @foreach($recoveryCodes as $code)
                <div class="rounded bg-white px-3 py-1 text-center shadow-sm">
                    {{ $code }}
                </div>
            @endforeach
        </div>

        <div class="flex gap-4">
            <x-gsmui::button onclick="navigator.clipboard.writeText('{{ implode('\n', $recoveryCodes) }}')">
                Copy Codes
            </x-gsmui::button>

            <a href="{{ route('two-factor.download-codes') }}" class="text-blue-600 hover:underline">
                Download Codes
            </a>
        </div>
    </div>
</x-layouts.app>
```

## Testing

```php
class TwoFactorTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_enable_two_factor(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->post('/two-factor/enable', [
                'code' => $user->twoFactorSecret,
            ]);

        $response->assertOk();
        $this->assertTrue($user->fresh()->hasTwoFactorEnabled());
    }

    public function test_user_can_authenticate_with_totp(): void
    {
        $user = User::factory()->create();
        $user->enableTwoFactorAuthentication();

        $response = $this->post('/two-factor/verify', [
            'code' => $user->twoFactorSecret,
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertAuthenticatedAs($user);
    }

    public function test_user_can_use_recovery_code(): void
    {
        $user = User::factory()->create();
        $user->enableTwoFactorAuthentication();

        $codes = $user->twoFactorRecoveryCodes();
        $firstCode = $codes[0];

        $response = $this->post('/two-factor/verify', [
            'code' => $firstCode,
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertAuthenticatedAs($user);
    }
}
```
