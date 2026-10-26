# Registration

> Form design, validation, email verification, welcome flow, terms acceptance.

## Registration Flow

```php
// app/Http/Controllers/Auth/RegisterController.php
class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'terms' => ['accepted'],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        // Send verification email
        $user->sendEmailVerificationNotification();

        // Send welcome email
        WelcomeEmail::dispatch($user);

        // Auto-login
        Auth::login($user);

        return redirect('/verify-email');
    }
}
```

## Form Design

```blade
{{-- resources/views/auth/register.blade.php --}}
<x-layouts.auth>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="space-y-4">
            <x-gsmui::input
                label="Full name"
                name="name"
                type="text"
                :value="old('name')"
                required
                autofocus
                :error="$errors->first('name')"
                placeholder="John Doe"
            />

            <x-gsmui::input
                label="Email address"
                name="email"
                type="email"
                :value="old('email')"
                required
                :error="$errors->first('email')"
                placeholder="john@example.com"
            />

            <x-gsmui::input
                label="Password"
                name="password"
                type="password"
                required
                :error="$errors->first('password')"
                placeholder="Minimum 8 characters"
            />

            <x-gsmui::input
                label="Confirm password"
                name="password_confirmation"
                type="password"
                required
                placeholder="Confirm your password"
            />

            <div class="flex items-start gap-3">
                <input type="checkbox" name="terms" id="terms" required
                       class="mt-1 h-4 w-4 rounded border-zinc-300">
                <label for="terms" class="text-sm text-zinc-600">
                    I agree to the
                    <a href="/terms" class="text-blue-600 hover:underline">Terms of Service</a>
                    and
                    <a href="/privacy" class="text-blue-600 hover:underline">Privacy Policy</a>
                </label>
            </div>
            @error('terms')
                <p class="text-sm text-red-600">{{ $message }}</p>
            @enderror

            <x-gsmui::button type="submit" class="w-full">
                Create account
            </x-gsmui::button>
        </div>
    </form>

    <x-slot name="footer">
        <p class="text-sm text-zinc-500">
            Already have an account?
            <a href="{{ route('login') }}" class="text-blue-600 hover:underline">Sign in</a>
        </p>
    </x-slot>
</x-layouts.auth>
```

## Validation Rules

```php
class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                Password::min(8)
                    ->mixedCase()
                    ->numbers()
                    ->symbols(),
            ],
            'terms' => ['accepted'],
        ];
    }

    public function messages(): array
    {
        return [
            'email.unique' => 'An account with this email already exists.',
            'password.confirmed' => 'Passwords do not match.',
            'terms.accepted' => 'You must accept the terms and conditions.',
        ];
    }
}
```

## Email Verification

```php
// app/Models/User.php
class User extends Authenticatable
{
    use HasFactory, Notifiable, MustVerifyEmail;

    // Custom verification email
    protected static function boot(): void
    {
        parent::boot();

        static::created(function (User $user) {
            $user->sendEmailVerificationNotification();
        });
    }
}

// Verification controller
class EmailVerificationController extends Controller
{
    public function show()
    {
        return view('auth.verify-email');
    }

    public function verify(Request $request)
    {
        $request->validate([
            'id' => ['required', 'string'],
            'hash' => ['required', 'string'],
        ]);

        if (!$request->user()->markEmailAsVerified()) {
            abort(403);
        }

        event(new Verified($request->user()));

        return redirect('/dashboard')->with('verified', true);
    }
}
```

## Welcome Flow

```php
// app/Listeners/SendWelcomeEmail.php
class SendWelcomeEmail
{
    public function handle(UserCreated $event): void
    {
        WelcomeEmail::dispatch($event->user);
    }
}

// app/Mail/WelcomeEmail.php
class WelcomeEmail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(
        public User $user
    ) {}

    public function build(): static
    {
        return $this
            ->subject('Welcome to ' . config('app.name'))
            ->markdown('emails.welcome', [
                'user' => $this->user,
                'dashboardUrl' => url('/dashboard'),
            ]);
    }
}
```

```blade
{{-- resources/views/emails/welcome.blade.php --}}
<x-mail::message>
# Welcome, {{ $user->name }}!

Thank you for joining {{ config('app.name') }}. We're excited to have you on board.

## Get Started

Here are a few things you can do to get started:

- Complete your profile
- Explore the dashboard
- Create your first product

<x-mail::button :url="$dashboardUrl">
Go to Dashboard
</x-mail::button>

Thanks,<br>
{{ config('app.name') }} Team
</x-mail::message>
```

## Terms Acceptance

```php
// Store acceptance timestamp
$user->forceFill([
    'terms_accepted_at' => now(),
    'terms_accepted_ip' => request()->ip(),
    'terms_accepted_user_agent' => request()->userAgent(),
])->save();

// Check acceptance
if (!$user->terms_accepted_at) {
    return redirect('/accept-terms');
}

// Log acceptance
activity()
    ->performedOn($user)
    ->withProperties([
        'ip' => request()->ip(),
        'user_agent' => request()->userAgent(),
    ])
    ->log('Terms accepted');
```

## Registration Rate Limiting

```php
// Rate limiting
RateLimiter::for('registration', function (Request $request) {
    return Limit::perHour(3)->by($request->ip());
});

// In controller
public function register(Request $request)
{
    if (RateLimiter::tooManyAttempts('registration:' . $request->ip(), 3)) {
        $seconds = RateLimiter::availableIn('registration:' . $request->ip());

        return back()->withErrors([
            'email' => "Too many registration attempts. Please try again in {$seconds} seconds.",
        ]);
    }

    // ... registration logic

    RateLimiter::clear('registration:' . $request->ip());
}
```

## Registration Testing

```php
class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_register(): void
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
            'terms' => '1',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com',
            'name' => 'Test User',
        ]);
    }

    public function test_registration_requires_terms(): void
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
        ]);

        $response->assertSessionHasErrors('terms');
    }

    public function test_password_must_be_confirmed(): void
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'Password123!',
            'password_confirmation' => 'DifferentPassword',
            'terms' => '1',
        ]);

        $response->assertSessionHasErrors('password');
    }
}
```
