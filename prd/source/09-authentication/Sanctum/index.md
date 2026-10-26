# Sanctum Setup

> SPA authentication, API tokens, token abilities, mobile auth, token management.

## Installation

```bash
composer require laravel/sanctum
php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
php artisan migrate
```

## Configuration

```php
// config/sanctum.php
return [
    'stateful' => explode(',', env('SANCTUM_STATEFUL_DOMAINS', sprintf(
        '%s%s',
        'localhost,localhost:3000,127.0.0.1,127.0.0.1:8000,::1',
        env('APP_URL') ? ','.parse_url(env('APP_URL'), PHP_URL_HOST) : ''
    ))),

    'guard' => ['web'],

    'expiration' => null, // Token expiration in minutes (null = never)

    'token_prefix' => env('SANCTUM_TOKEN_PREFIX', ''),

    'middleware' => [
        'authenticate_session' => Laravel\Sanctum\Http\Middleware\AuthenticateSession::class,
        'encrypt_cookies' => Illuminate\Cookie\Middleware\EncryptCookies::class,
        'validate_csrf_token' => Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class,
    ],
];
```

## SPA Authentication

```php
// routes/web.php
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});

// routes/api.php (protected by sanctum)
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('products', ProductController::class);
});
```

```javascript
// resources/js/app.js
import axios from 'axios';

// Configure axios for SPA auth
axios.defaults.withCredentials = true;

// CSRF cookie
await axios.get('/sanctum/csrf-cookie');

// Login
await axios.post('/login', {
    email: 'user@example.com',
    password: 'password',
});

// Now API requests are authenticated
const response = await axios.get('/api/products');
```

## API Tokens

```php
// Create token
$user = User::find(1);
$token = $user->createToken('api-token');
$plainTextToken = $token->plainTextToken;

// Create token with abilities
$token = $user->createToken('api-token', ['products:read', 'orders:write']);

// Create token with expiration
$token = $user->createToken('api-token', ['products:read'])
    ->expiresAt(now()->addDays(30);

// Check token abilities
if ($request->user()->tokenCan('products:read')) {
    // Grant access
}

// Revoke specific token
$user->tokens()->where('id', $token->id)->delete();

// Revoke all tokens
$user->tokens()->delete();
```

## Token Abilities

```php
// Define abilities in middleware
Route::middleware('can:products:read')->group(function () {
    Route::get('/products', [ProductController::class, 'index']);
});

// Check abilities in controller
class ProductController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->user()->tokenCan('products:read')) {
            abort(403);
        }

        return Product::all();
    }
}

// Token abilities in routes
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/products', [ProductController::class, 'index'])
        ->middleware('can:products:read');

    Route::post('/products', [ProductController::class, 'store'])
        ->middleware('can:products:write');
});
```

## Mobile Authentication

```php
// Mobile device token creation
class MobileAuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'device_name' => 'required|string',
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $token = $user->createToken(
            $credentials['device_name'],
            ['*'], // All abilities
            now()->addDays(30)
        );

        return response()->json([
            'user' => $user,
            'token' => $token->plainTextToken,
            'expires_at' => $token->accessToken->expires_at,
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out']);
    }
}
```

## Token Management

```php
// List user tokens
$tokens = $request->user()->tokens;

// Revoke specific token
$request->user()->tokens()->where('id', $tokenId)->delete();

// Revoke all tokens except current
$request->user()->tokens()
    ->where('id', '!=', $request->user()->currentAccessToken()->id)
    ->delete();

// Check token expiration
$token = $request->user()->currentAccessToken();
if ($token->expires_at && $token->expires_at->isPast()) {
    abort(401, 'Token expired');
}

// Token metadata
$token = $request->user()->currentAccessToken();
return [
    'name' => $token->name,
    'abilities' => $token->abilities,
    'created_at' => $token->created_at,
    'expires_at' => $token->expires_at,
    'last_used_at' => $token->last_used_at,
];
```

## Middleware Configuration

```php
// app/Http/Kernel.php
protected $middlewareAliases = [
    'sanctum.auth' => \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
];

// Protect API routes
Route::middleware(['api', 'auth:sanctum'])->group(function () {
    Route::apiResource('products', ProductController::class);
});

// Custom token validation middleware
class ValidateTokenAbilities
{
    public function handle(Request $request, Closure $next, ...$abilities)
    {
        foreach ($abilities as $ability) {
            if (!$request->user()->tokenCan($ability)) {
                abort(403, "Missing ability: {$ability}");
            }
        }

        return $next($request);
    }
}
```

## Testing

```php
class SanctumTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_token(): void
    {
        $user = User::factory()->create();

        $token = $user->createToken('test-token');

        $this->assertNotEmpty($token->plainTextToken);
        $this->assertDatabaseHas('personal_access_tokens', [
            'tokenable_id' => $user->id,
            'name' => 'test-token',
        ]);
    }

    public function test_api_requires_auth(): void
    {
        $response = $this->getJson('/api/products');

        $response->assertUnauthorized();
    }

    public function test_api_works_with_token(): void
    {
        $user = User::factory()->create();
        $token = $user->createToken('api-token', ['products:read']);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token->plainTextToken,
        ])->getJson('/api/products');

        $response->assertOk();
    }

    public function test_token_can_be_revoked(): void
    {
        $user = User::factory()->create();
        $token = $user->createToken('test-token');

        $user->tokens()->where('id', $token->accessToken->id)->delete();

        $this->assertDatabaseMissing('personal_access_tokens', [
            'id' => $token->accessToken->id,
        ]);
    }
}
```
