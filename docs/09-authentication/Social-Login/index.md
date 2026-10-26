# Social Login

> OAuth providers, account linking, profile sync, provider-specific flows.

## Configuration

```php
// config/services.php
return [
    'github' => [
        'client_id' => env('GITHUB_CLIENT_ID'),
        'client_secret' => env('GITHUB_CLIENT_SECRET'),
        'redirect' => env('GITHUB_REDIRECT_URI', '/auth/github/callback'),
    ],

    'google' => [
        'client_id' => env('GOOGLE_CLIENT_ID'),
        'client_secret' => env('GOOGLE_CLIENT_SECRET'),
        'redirect' => env('GOOGLE_REDIRECT_URI', '/auth/google/callback'),
    ],

    'facebook' => [
        'client_id' => env('FACEBOOK_CLIENT_ID'),
        'client_secret' => env('FACEBOOK_CLIENT_SECRET'),
        'redirect' => env('FACEBOOK_REDIRECT_URI', '/auth/facebook/callback'),
    ],
];
```

## OAuth Flow

```php
// routes/web.php
Route::get('/auth/{provider}', [SocialAuthController::class, 'redirect'])
    ->name('social.redirect');

Route::get('/auth/{provider}/callback', [SocialAuthController::class, 'callback'])
    ->name('social.callback');

// app/Http/Controllers/SocialAuthController.php
class SocialAuthController extends Controller
{
    public function redirect(string $provider)
    {
        $this->validateProvider($provider);

        return Socialite::driver($provider)
            ->scopes($this->getScopes($provider))
            ->redirect();
    }

    public function callback(string $provider)
    {
        $this->validateProvider($provider);

        try {
            $socialUser = Socialite::driver($provider)->user();
        } catch (\Exception $e) {
            return redirect()->route('login')
                ->withErrors(['social' => 'Unable to authenticate with ' . $provider]);
        }

        $user = $this->findOrCreateUser($socialUser, $provider);

        auth()->login($user, true);

        activity()
            ->performedOn($user)
            ->withProperties(['provider' => $provider])
            ->log('Social login');

        return redirect('/dashboard');
    }

    protected function validateProvider(string $provider): void
    {
        $validProviders = ['github', 'google', 'facebook', 'twitter'];

        if (!in_array($provider, $validProviders)) {
            abort(404);
        }
    }

    protected function getScopes(string $provider): array
    {
        return match($provider) {
            'github' => ['read:user', 'user:email'],
            'google' => ['email', 'profile'],
            'facebook' => ['email', 'public_profile'],
            default => [],
        };
    }
}
```

## Account Linking

```php
class AccountLinker
{
    public function findOrCreateUser(SocialiteUser $socialUser, string $provider): User
    {
        // Check if social account exists
        $socialAccount = SocialAccount::where('provider', $provider)
            ->where('provider_id', $socialUser->getId())
            ->first();

        if ($socialAccount) {
            return $socialAccount->user;
        }

        // Check if user with same email exists
        $user = User::where('email', $socialUser->getEmail())->first();

        if ($user) {
            // Link account
            $user->socialAccounts()->create([
                'provider' => $provider,
                'provider_id' => $socialUser->getId(),
                'token' => $socialUser->token,
                'refresh_token' => $socialUser->refreshToken,
                'expires_at' => $socialUser->expiresIn
                    ? now()->addSeconds($socialUser->expiresIn)
                    : null,
            ]);

            return $user;
        }

        // Create new user
        return DB::transaction(function () use ($socialUser, $provider) {
            $user = User::create([
                'name' => $socialUser->getName(),
                'email' => $socialUser->getEmail(),
                'email_verified_at' => now(),
                'avatar' => $socialUser->getAvatar(),
            ]);

            $user->socialAccounts()->create([
                'provider' => $provider,
                'provider_id' => $socialUser->getId(),
                'token' => $socialUser->token,
                'refresh_token' => $socialUser->refreshToken,
                'expires_at' => $socialUser->expiresIn
                    ? now()->addSeconds($socialUser->expiresIn)
                    : null,
            ]);

            return $user;
        });
    }
}
```

## Profile Sync

```php
class ProfileSyncService
{
    public function sync(User $user, SocialiteUser $socialUser, string $provider): void
    {
        $updates = [
            'name' => $socialUser->getName(),
            'avatar' => $this->getAvatar($socialUser, $provider),
            'locale' => $socialUser->getLocale(),
        ];

        // Only update if values changed
        $dirty = collect($updates)->filter(fn ($value, $key) =>
            $user->{$key} !== $value
        )->toArray();

        if (!empty($dirty)) {
            $user->update($dirty);
        }

        // Sync social account token
        $user->socialAccounts()
            ->where('provider', $provider)
            ->update([
                'token' => $socialUser->token,
                'refresh_token' => $socialUser->refreshToken,
                'expires_at' => $socialUser->expiresIn
                    ? now()->addSeconds($socialUser->expiresIn)
                    : null,
            ]);
    }

    protected function getAvatar(SocialiteUser $socialUser, string $provider): ?string
    {
        $avatar = $socialUser->getAvatar();

        if ($avatar) {
            // Download and store avatar
            return $this->storeAvatar($avatar, $provider);
        }

        return null;
    }

    protected function storeAvatar(string $url, string $provider): string
    {
        $filename = "{$provider}_" . Str::uuid() . '.jpg';

        $path = Storage::disk('public')->put(
            "avatars/{$filename}",
            file_get_contents($url)
        );

        return "avatars/{$filename}";
    }
}
```

## Provider-Specific Flows

```php
class GitHubProvider extends AbstractProvider
{
    protected function getAuthUrl($state)
    {
        return $this->buildAuthUrlFromBase(
            'https://github.com/login/oauth/authorize',
            $state
        );
    }

    protected function getTokenUrl()
    {
        return 'https://github.com/login/oauth/access_token';
    }

    protected function getUserByToken($token)
    {
        $userUrl = 'https://api.github.com/user';

        $response = $this->getHttpClient()->get($userUrl, [
            'headers' => [
                'Authorization' => "token {$token}",
            ],
        ]);

        return json_decode($response->getBody(), true);
    }

    protected function mapUserToPrimary(array $user)
    {
        return [
            'id' => $user['id'],
            'name' => $user['name'] ?? $user['login'],
            'email' => $user['email'],
            'avatar' => $user['avatar_url'],
        ];
    }
}
```

## Frontend Integration

```blade
{{-- Social login buttons --}}
<div class="space-y-3">
    <a href="{{ route('social.redirect', 'github') }}"
       class="flex w-full items-center justify-center gap-3 rounded-lg border border-zinc-300 bg-white px-4 py-2 text-sm font-medium text-zinc-700 shadow-sm hover:bg-zinc-50">
        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
            <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/>
        </svg>
        Continue with GitHub
    </a>

    <a href="{{ route('social.redirect', 'google') }}"
       class="flex w-full items-center justify-center gap-3 rounded-lg border border-zinc-300 bg-white px-4 py-2 text-sm font-medium text-zinc-700 shadow-sm hover:bg-zinc-50">
        <svg class="h-5 w-5" viewBox="0 0 24 24">
            <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
            <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
            <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
            <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
        </svg>
        Continue with Google
    </a>
</div>
```

## Social Account Management

```php
// List connected accounts
$socialAccounts = $user->socialAccounts;

// Disconnect account
$user->socialAccounts()->where('provider', $provider)->delete();

// Check if provider is connected
$isConnected = $user->socialAccounts()->where('provider', $provider)->exists();
```

```blade
{{-- Connected accounts --}}
<div class="space-y-4">
    @foreach(['github', 'google', 'facebook'] as $provider)
        @php
            $account = $user->socialAccounts()->where('provider', $provider)->first();
        @endphp

        <div class="flex items-center justify-between rounded-lg border border-zinc-200 p-4">
            <div class="flex items-center gap-3">
                <x-gsmui::icon :name="$provider" class="h-6 w-6" />
                <div>
                    <p class="font-medium capitalize">{{ $provider }}</p>
                    @if($account)
                        <p class="text-sm text-zinc-500">Connected</p>
                    @else
                        <p class="text-sm text-zinc-500">Not connected</p>
                    @endif
                </div>
            </div>

            @if($account)
                <form method="POST" action="{{ route('social.disconnect', $provider) }}">
                    @csrf
                    @method('DELETE')
                    <x-gsmui::button type="submit" variant="ghost" size="sm">
                        Disconnect
                    </x-gsmui::button>
                </form>
            @else
                <a href="{{ route('social.redirect', $provider) }}"
                   class="text-sm text-blue-600 hover:underline">
                    Connect
                </a>
            @endif
        </div>
    @endforeach
</div>
```
