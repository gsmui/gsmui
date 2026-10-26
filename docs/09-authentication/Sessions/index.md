# Session Management

> Driver config, session limits, concurrent sessions, device tracking, logout.

## Session Configuration

```php
// config/session.php
return [
    'driver' => env('SESSION_DRIVER', 'database'),

    'lifetime' => env('SESSION_LIFETIME', 120),

    'expire_on_close' => false,

    'encrypt' => true,

    'files' => storage_path('framework/sessions'),

    'connection' => env('SESSION_CONNECTION'),

    'table' => 'sessions',

    'store' => env('SESSION_STORE'),

    'lottery' => [2, 100],

    'cookie' => env(
        'SESSION_COOKIE',
        Str::slug(env('APP_NAME', 'laravel'), '_').'_session'
    ),

    'path' => '/',

    'domain' => env('SESSION_DOMAIN'),

    'secure' => env('SESSION_SECURE_COOKIE'),

    'http_only' => true,

    'same_site' => 'lax',

    'partitioned' => false,
];
```

## Session Driver Setup

```php
// Database driver
// php artisan session:table
// php artisan migrate

Schema::create('sessions', function (Blueprint $table) {
    $table->string('id')->primary();
    $table->foreignId('user_id')->nullable()->index();
    $table->string('ip_address', 45)->nullable();
    $table->text('user_agent')->nullable();
    $table->longText('payload');
    $table->integer('last_activity')->index();
});
```

## Session Limits

```php
class SessionManager
{
    public function __construct(
        protected Repository $cache,
    ) {}

    public function limitSessions(User $user, int $maxSessions = 5): void
    {
        $sessions = $user->sessions()
            ->orderBy('last_activity', 'desc')
            ->get();

        if ($sessions->count() > $maxSessions) {
            $sessions->slice($maxSessions)->each->delete();
        }
    }

    public function getSessionCount(User $user): int
    {
        return $user->sessions()->count();
    }

    public function isSessionValid(Session $session): bool
    {
        return $session->last_activity > now()->subMinutes(
            config('session.lifetime')
        )->timestamp;
    }
}
```

## Concurrent Sessions

```php
class ConcurrentSessionHandler
{
    public function __construct(
        protected SessionManager $sessionManager,
    ) {}

    public function handleLogin(User $user, Request $request): void
    {
        // Check concurrent session limit
        $maxSessions = config('auth.max_concurrent_sessions', 3);

        if ($user->sessions()->count() >= $maxSessions) {
            // Log out oldest session
            $oldestSession = $user->sessions()
                ->orderBy('last_activity')
                ->first();

            if ($oldestSession) {
                $oldestSession->delete();

                event(new SessionTerminated($user, $oldestSession));
            }
        }

        // Create new session
        $this->createSession($user, $request);
    }

    protected function createSession(User $user, Request $request): void
    {
        Session::create([
            'user_id' => $user->id,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'payload' => '',
            'last_activity' => now()->timestamp,
        ]);
    }

    public function terminateAllSessions(User $user): void
    {
        $user->sessions()->delete();

        event(new AllSessionsTerminated($user));
    }

    public function terminateOtherSessions(User $user, string $currentSessionId): void
    {
        $user->sessions()
            ->where('id', '!=', $currentSessionId)
            ->delete();

        event(new OtherSessionsTerminated($user));
    }
}
```

## Device Tracking

```php
class DeviceTracker
{
    public function __construct(
        protected UserAgent $userAgent,
    ) {}

    public function getDevices(User $user): Collection
    {
        return $user->sessions()
            ->get()
            ->map(fn ($session) => $this->parseDevice($session))
            ->groupBy('platform')
            ->map(fn ($devices) => $devices->first());
    }

    protected function parseDevice(Session $session): array
    {
        $ua = new UserAgent($session->user_agent);

        return [
            'id' => $session->id,
            'platform' => $ua->platform(),
            'browser' => $ua->browser(),
            'is_mobile' => $ua->isMobile(),
            'ip_address' => $session->ip_address,
            'last_active' => Carbon::createFromTimestamp($session->last_activity),
            'is_current' => $session->id === request()->session()->getId(),
        ];
    }

    public function getCurrentDevice(User $user): array
    {
        $session = $user->sessions()
            ->where('id', request()->session()->getId())
            ->first();

        return $this->parseDevice($session);
    }
}
```

## Logout

```php
class LogoutController extends Controller
{
    public function logout(Request $request)
    {
        auth()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function logoutOtherDevices(Request $request)
    {
        $request->validate([
            'password' => ['required', 'string'],
        ]);

        if (!Hash::check($request->password, $request->user()->password)) {
            return back()->withErrors([
                'password' => ['The password is incorrect.'],
            ]);
        }

        $request->user()->sessions()
            ->where('id', '!=', $request->session()->getId())
            ->delete();

        return back()->with('status', 'Other sessions have been logged out.');
    }

    public function logoutAll(Request $request)
    {
        $request->user()->sessions()->delete();

        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
```

## Session Events

```php
class SessionEventSubscriber
{
    public function subscribe(Dispatcher $events): void
    {
        $events->listen(Login::class, [self::class, 'handleLogin']);
        $events->listen(Logout::class, [self::class, 'handleLogout']);
        $events->listen(Authenticated::class, [self::class, 'handleAuthenticated']);
    }

    public function handleLogin(Login $event): void
    {
        activity()
            ->performedOn($event->user)
            ->withProperties([
                'ip' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ])
            ->log('User logged in');
    }

    public function handleLogout(Logout $event): void
    {
        activity()
            ->performedOn($event->user)
            ->log('User logged out');
    }

    public function handleAuthenticated(Authenticated $event): void
    {
        $event->user->update(['last_login_at' => now()]);
    }
}
```

## Session Testing

```php
class SessionTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_login(): void
    {
        $user = User::factory()->create();

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticatedAs($user);
    }

    public function test_session_is_created_on_login(): void
    {
        $user = User::factory()->create();

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertDatabaseHas('sessions', [
            'user_id' => $user->id,
        ]);
    }

    public function test_session_is_deleted_on_logout(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->post('/logout');

        $this->assertGuest();
    }

    public function test_concurrent_session_limit(): void
    {
        $user = User::factory()->create();

        // Create 5 sessions
        for ($i = 0; $i < 5; $i++) {
            Session::create([
                'user_id' => $user->id,
                'ip_address' => '127.0.0.1',
                'user_agent' => 'Test',
                'payload' => '',
                'last_activity' => now()->subMinutes($i)->timestamp,
            ]);
        }

        $sessionManager = new SessionManager(Cache::fake());
        $sessionManager->limitSessions($user, 3);

        $this->assertEquals(3, $user->sessions()->count());
    }
}
```
