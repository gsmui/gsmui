# Fortify Configuration

> Registration, login, password reset, profile updates, middleware, views.

## Installation

```bash
composer require laravel/fortify
php artisan vendor:publish --provider="Laravel\Fortify\FortifyServiceProvider"
php artisan migrate
```

## Configuration

```php
// config/fortify.php
return [
    'guard' => 'web',

    'home' => '/dashboard',

    'middleware' => 'web',

    'limiters' => [
        'login' => 'login',
        'registration' => 'registration',
        'password-reset' => 'password-reset',
    ],

    'views' => true,

    'features' => [
        Features::registration(),
        Features::resetPasswords(),
        Features::emailVerification(),
        Features::updateProfileInformation(),
        Features::updatePasswords(),
        Features::twoFactorAuthentication([
            'confirm' => true,
        ]),
        Features::accountDeletion(),
    ],
];
```

## Service Provider

```php
// app/Providers/FortifyServiceProvider.php
class FortifyServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(FortifyServices::class, function ($app) {
            return new FortifyServices(
                $app->make(CreateNewUser::class),
                $app->make(UpdateUserProfileInformation::class),
                $app->make(UpdateUserPassword::class),
                $app->make(ResetUserPassword::class),
            );
        });
    }

    public function boot(): void
    {
        $this->configureViews();
        $this->configureMiddleware();
    }

    protected function configureViews(): void
    {
        Fortify::viewNamespace('auth');
    }

    protected function configureMiddleware(): void
    {
        Fortify::authenticateMiddlewareUsing(function (Request $request) {
            return auth()->attempt([
                'email' => $request->email,
                'password' => $request->password,
                'active' => true,
            ], $request->boolean('remember'));
        });
    }
}
```

## Registration

```php
// app/Actions/Fortify/CreateNewUser.php
class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    public function create(array $input): User
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : [],
        ])->validate();

        return DB::transaction(function () use ($input) {
            $user = User::create([
                'name' => $input['name'],
                'email' => $input['email'],
                'password' => Hash::make($input['password']),
            ]);

            if (isset($input['company'])) {
                $user->company()->create(['name' => $input['company']]);
            }

            return $user;
        });
    }
}
```

## Login

```php
// app/Actions/Fortify/AuthenticateUser.php
class AuthenticateUser
{
    public function authenticate(Request $request): User
    {
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials do not match our records.'],
            ]);
        }

        if ($user->is_banned) {
            throw ValidationException::withMessages([
                'email' => ['Your account has been suspended.'],
            ]);
        }

        if (!$user->hasVerifiedEmail() && config('fortify.emailVerification')) {
            throw ValidationException::withMessages([
                'email' => ['Please verify your email address first.'],
            ]);
        }

        auth()->login($user, $request->boolean('remember'));

        activity()->performedOn($user)->log('Login');

        return $user;
    }
}
```

## Password Reset

```php
// app/Actions/Fortify/ResetUserPassword.php
class ResetUserPassword implements ResetsUserPasswords
{
    use PasswordValidationRules;

    public function reset(User $user, array $input): void
    {
        Validator::make($input, [
            'password' => $this->passwordRules(),
        ])->validate();

        $user->forceFill([
            'password' => Hash::make($input['password']),
            'password_changed_at' => now(),
        ])->save();

        event(new PasswordReset($user));
    }
}
```

## Profile Updates

```php
// app/Actions/Fortify/UpdateUserProfileInformation.php
class UpdateUserProfileInformation implements UpdatesUserProfileInformation
{
    public function update(User $user, array $input): void
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
        ])->validate();

        if ($input['email'] !== $user->email) {
            $user->forceFill([
                'name' => $input['name'],
                'email' => $input['email'],
                'email_verified_at' => null,
            ])->save();
        } else {
            $user->forceFill([
                'name' => $input['name'],
            ])->save();
        }
    }
}
```

## Views

```blade
{{-- resources/views/auth/login.blade.php --}}
<x-layouts.auth>
    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="space-y-4">
            <div>
                <label for="email" class="block text-sm font-medium text-zinc-700">
                    Email address
                </label>
                <input type="email" id="email" name="email" value="{{ old('email') }}"
                       required autofocus
                       class="mt-1 block w-full rounded-lg border border-zinc-300 px-3 py-2 shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                @error('email')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-zinc-700">
                    Password
                </label>
                <input type="password" id="password" name="password" required
                       class="mt-1 block w-full rounded-lg border border-zinc-300 px-3 py-2 shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                @error('password')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-between">
                <label class="flex items-center">
                    <input type="checkbox" name="remember" class="rounded border-zinc-300">
                    <span class="ml-2 text-sm text-zinc-600">Remember me</span>
                </label>

                @if(Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-sm text-blue-600 hover:underline">
                        Forgot password?
                    </a>
                @endif
            </div>

            <button type="submit" class="w-full rounded-lg bg-blue-600 px-4 py-2 text-white hover:bg-blue-700">
                Sign in
            </button>
        </div>
    </form>
</x-layouts.auth>
```

## Middleware

```php
// app/Http/Kernel.php
protected $middlewareGroups = [
    'web' => [
        // ...
    ],
];

protected $middlewareAliases = [
    'fortify' => EnsureFrontendRequestsAreStateful::class,
    'auth' => Authenticate::class,
    'verified' => EnsureEmailIsVerified::class,
];

// Custom middleware
class EnsureUserIsActive
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && !auth()->user()->active) {
            auth()->logout();
            return redirect()->route('login')->with('error', 'Your account is inactive.');
        }

        return $next($request);
    }
}
```

## Testing

```php
class FortifyTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_register(): void
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertDatabaseHas('users', ['email' => 'test@example.com']);
    }

    public function test_user_can_login(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('password'),
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertAuthenticatedAs($user);
    }
}
```
