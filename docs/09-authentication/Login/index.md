# Login Flows

> Email/password, remember me, throttling, failed attempts, login notifications.

## Login Flow

```php
// app/Http/Controllers/Auth/LoginController.php
class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            activity()->performedOn(Auth::user())->log('Login');

            return redirect()->intended('/dashboard');
        }

        RateLimiter::increment('login:' . $request->ip());

        throw ValidationException::withMessages([
            'email' => ['The provided credentials do not match our records.'],
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
```

## Email & Password Validation

```php
class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => ['required', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:8'],
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'Please enter your email address.',
            'email.email' => 'Please enter a valid email address.',
            'password.required' => 'Please enter your password.',
        ];
    }
}
```

## Remember Me

```php
// In login attempt
if (Auth::attempt($credentials, $request->boolean('remember'))) {
    // "remember" checkbox was checked
    // User gets a long-lived cookie

    $request->session()->regenerate();

    return redirect()->intended('/dashboard');
}

// Check if user chose remember me
if (Auth::attempt($credentials, $remember = true)) {
    // Token stored in remember_web cookie
}

// Logout clears remember token
Auth::logout();
$request->session()->invalidate();
$request->session()->regenerateToken();
```

## Throttling

```php
// Rate limiting configuration
RateLimiter::for('login', function (Request $request) {
    return Limit::perMinute(5)->by($request->ip());
});

// In LoginController
public function login(Request $request)
{
    if (RateLimiter::tooManyAttempts('login:' . $request->ip(), 5)) {
        $seconds = RateLimiter::availableIn('login:' . $request->ip());

        return back()->withErrors([
            'email' => "Too many login attempts. Please try again in {$seconds} seconds.",
        ]);
    }

    if (Auth::attempt($credentials, $remember)) {
        RateLimiter::clear('login:' . $request->ip());
        $request->session()->regenerate();

        return redirect()->intended('/dashboard');
    }

    RateLimiter::increment('login:' . $request->ip());

    return back()->withErrors([
        'email' => ['The provided credentials do not match our records.'],
    ]);
}
```

## Failed Attempts

```php
// Track failed attempts
class FailedLoginTracker
{
    public function record(string $email, string $ip): void
    {
        $key = "failed_login:{$email}:{$ip}";

        $attempts = Cache::increment($key, 1);

        if ($attempts === 1) {
            Cache::put($key, 1, now()->addHours(24));
        }

        if ($attempts >= 5) {
            $this->lockAccount($email);
            $this->notifyUser($email);
        }
    }

    public function clear(string $email, string $ip): void
    {
        Cache::forget("failed_login:{$email}:{$ip}");
    }

    protected function lockAccount(string $email): void
    {
        User::where('email', $email)->update(['locked' => true]);
    }

    protected function notifyUser(string $email): void
    {
        $user = User::where('email', $email)->first();

        if ($user) {
            Notification::send($user, new AccountLockedNotification());
        }
    }
}
```

## Login Notifications

```php
// Send notification on successful login
class SendLoginNotification
{
    public function handle(User $user, Request $request): void
    {
        $location = $this->getLocation($request);
        $device = $this->getDevice($request);

        Notification::send($user, new LoginNotification(
            ip: $request->ip(),
            location: $location,
            device: $device,
            time: now(),
        ));
    }

    protected function getLocation(Request $request): string
    {
        // Use geoip service
        return geoip($request->ip())->city ?? 'Unknown';
    }

    protected function getDevice(Request $request): string
    {
        $agent = new UserAgent($request->userAgent());

        return "{$agent->platform()} - {$agent->browser()}";
    }
}

// Notification class
class LoginNotification extends Notification
{
    use Queueable;

    public function __construct(
        public string $ip,
        public string $location,
        public string $device,
        public Carbon $time,
    ) {}

    public function toArray(object $notifiable): array
    {
        return [
            'message' => 'New login detected',
            'ip' => $this->ip,
            'location' => $this->location,
            'device' => $this->device,
            'time' => $this->time->toDateTimeString(),
        ];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('New Login Detected')
            ->greeting("Hello {$notifiable->name},")
            ->line('A new login to your account was detected.')
            ->line("IP: {$this->ip}")
            ->line("Location: {$this->location}")
            ->line("Device: {$this->device}")
            ->line("Time: {$this->time->toDateTimeString()}")
            ->action('Secure Your Account', url('/security'))
            ->line('If this was not you, please secure your account immediately.');
    }
}
```

## Session Security

```php
// Session configuration
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
    'cookie' => env('SESSION_COOKIE', 'gsmui_session'),
    'path' => '/',
    'domain' => env('SESSION_DOMAIN'),
    'secure' => env('SESSION_SECURE_COOKIE'),
    'http_only' => true,
    'same_site' => 'lax',
    'partitioned' => false,
];
```

## Login View

```blade
{{-- resources/views/auth/login.blade.php --}}
<x-layouts.auth>
    <form method="POST" action="{{ route('login') }}">
        @csrf

        @if(session('error'))
            <div class="mb-4 rounded-lg border border-red-200 bg-red-50 p-4 text-sm text-red-600">
                {{ session('error') }}
            </div>
        @endif

        <div class="space-y-4">
            <x-gsmui::input
                label="Email"
                name="email"
                type="email"
                :value="old('email')"
                required
                autofocus
                :error="$errors->first('email')"
            />

            <x-gsmui::input
                label="Password"
                name="password"
                type="password"
                required
                :error="$errors->first('password')"
            />

            <div class="flex items-center justify-between">
                <label class="flex items-center gap-2">
                    <input type="checkbox" name="remember" class="rounded border-zinc-300">
                    <span class="text-sm text-zinc-600">Remember me</span>
                </label>

                @if(Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-sm text-blue-600 hover:underline">
                        Forgot password?
                    </a>
                @endif
            </div>

            <x-gsmui::button type="submit" class="w-full">
                Sign in
            </x-gsmui::button>
        </div>
    </form>

    <x-slot name="footer">
        <p class="text-sm text-zinc-500">
            Don't have an account?
            <a href="{{ route('register') }}" class="text-blue-600 hover:underline">Register</a>
        </p>
    </x-slot>
</x-layouts.auth>
```
