# API Tokens

> Token types, abilities, scopes, rotation, revocation, rate limiting.

## Token Types

```php
// Personal access tokens (Sanctum)
$user = User::find(1);
$token = $user->createToken('API Token');
$plainTextToken = $token->plainTextToken;

// Token with abilities
$token = $user->createToken('API Token', ['products:read', 'orders:write']);

// Token with expiration
$token = $user->createToken('API Token', ['products:read'])
    ->expiresAt(now()->addDays(30));

// API Token model
class ApiToken extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'token',
        'abilities',
        'expires_at',
        'last_used_at',
    ];

    protected $casts = [
        'abilities' => 'array',
        'expires_at' => 'datetime',
        'last_used_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function isExpired(): bool
    {
        return $this->expires_at && $this->expires_at->isPast();
    }

    public function can(string $ability): bool
    {
        return in_array('*', $this->abilities) || in_array($ability, $this->abilities);
    }
}
```

## Token Abilities

```php
// Define abilities
class TokenAbilityManager
{
    public const ABILITIES = [
        'products' => ['read', 'write', 'delete'],
        'orders' => ['read', 'write', 'cancel'],
        'users' => ['read', 'write', 'delete'],
        'reports' => ['read'],
        'settings' => ['read', 'write'],
    ];

    public function getDefaultAbilities(): array
    {
        return ['products:read', 'orders:read', 'users:read'];
    }

    public function validateAbilities(array $abilities): bool
    {
        foreach ($abilities as $ability) {
            $parts = explode(':', $ability);

            if (count($parts) !== 2) {
                return false;
            }

            [$resource, $action] = $parts;

            if (!isset(self::ABILITIES[$resource])) {
                return false;
            }

            if (!in_array($action, self::ABILITIES[$resource])) {
                return false;
            }
        }

        return true;
    }
}

// Usage
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/products', [ProductController::class, 'index'])
        ->middleware('can:products:read');

    Route::post('/products', [ProductController::class, 'store'])
        ->middleware('can:products:write');

    Route::delete('/products/{product}', [ProductController::class, 'destroy'])
        ->middleware('can:products:delete');
});
```

## Token Scopes

```php
// Token scopes (similar to abilities)
class TokenScope
{
    public function __construct(
        public string $name,
        public string $description,
        public array $abilities,
    ) {}
}

// Define scopes
class TokenScopeManager
{
    public function getScopes(): array
    {
        return [
            'read-only' => new TokenScope(
                'read-only',
                'Can only read resources',
                ['products:read', 'orders:read', 'users:read']
            ),
            'admin' => new TokenScope(
                'admin',
                'Full access to all resources',
                ['*']
            ),
            'orders-manager' => new TokenScope(
                'orders-manager',
                'Can manage orders',
                ['orders:read', 'orders:write', 'orders:cancel']
            ),
        ];
    }

    public function createTokenWithScope(User $user, string $scopeName): NewAccessToken
    {
        $scopes = $this->getScopes();

        if (!isset($scopes[$scopeName])) {
            throw new \InvalidArgumentException("Unknown scope: {$scopeName}");
        }

        return $user->createToken(
            $scopes[$scopeName]->description,
            $scopes[$scopeName]->abilities
        );
    }
}
```

## Token Rotation

```php
class TokenRotationService
{
    public function rotate(User $user, int $tokenId): NewAccessToken
    {
        $oldToken = $user->tokens()->find($tokenId);

        if (!$oldToken) {
            throw new \RuntimeException('Token not found');
        }

        // Create new token with same abilities
        $newToken = $user->createToken(
            $oldToken->name . ' (rotated)',
            $oldToken->abilities,
            $oldToken->expires_at
        );

        // Delete old token
        $oldToken->delete();

        // Log rotation
        activity()
            ->performedOn($user)
            ->withProperties([
                'old_token_id' => $tokenId,
                'new_token_id' => $newToken->accessToken->id,
            ])
            ->log('API token rotated');

        return $newToken;
    }

    public function rotateAll(User $user): array
    {
        $tokens = $user->tokens()->get();
        $newTokens = [];

        foreach ($tokens as $token) {
            $newTokens[] = $this->rotate($user, $token->id);
        }

        return $newTokens;
    }
}
```

## Token Revocation

```php
class TokenRevocationService
{
    public function revoke(User $user, int $tokenId): void
    {
        $token = $user->tokens()->find($tokenId);

        if (!$token) {
            throw new \RuntimeException('Token not found');
        }

        $token->delete();

        activity()
            ->performedOn($user)
            ->withProperties(['token_id' => $tokenId])
            ->log('API token revoked');
    }

    public function revokeAll(User $user): void
    {
        $count = $user->tokens()->count();

        $user->tokens()->delete();

        activity()
            ->performedOn($user)
            ->withProperties(['count' => $count])
            ->log('All API tokens revoked');
    }

    public function revokeExpired(): int
    {
        $count = PersonalAccessToken::query()
            ->where('expires_at', '<', now())
            ->delete();

        return $count;
    }
}
```

## Rate Limiting

```php
class TokenRateLimiter
{
    public function __construct(
        protected RateLimiter $limiter,
    ) {}

    public function handle(Request $request, Closure $next)
    {
        $token = $request->user()->currentAccessToken();

        $rateLimit = $this->getRateLimit($token);

        if ($this->limiter->tooManyAttempts($this->getKey($token), $rateLimit['max'])) {
            $seconds = $this->limiter->availableIn($this->getKey($token));

            return response()->json([
                'error' => 'Too many requests',
                'retry_after' => $seconds,
            ], 429)->withHeaders([
                'X-RateLimit-Limit' => $rateLimit['max'],
                'X-RateLimit-Remaining' => 0,
                'Retry-After' => $seconds,
            ]);
        }

        $this->limiter->hit($this->getKey($token), $rateLimit['decay']);

        $response = $next($request);

        return $response->withHeaders([
            'X-RateLimit-Limit' => $rateLimit['max'],
            'X-RateLimit-Remaining' => $this->limiter->remaining($this->getKey($token), $rateLimit['max']),
        ]);
    }

    protected function getRateLimit($token): array
    {
        // Different rate limits based on token abilities
        if (in_array('*', $token->abilities)) {
            return ['max' => 1000, 'decay' => 60];
        }

        return ['max' => 100, 'decay' => 60];
    }

    protected function getKey($token): string
    {
        return "api_token:{$token->id}";
    }
}
```

## Token Management API

```php
class ApiTokenController extends Controller
{
    public function index(Request $request)
    {
        $tokens = $request->user()->tokens;

        return ApiTokenResource::collection($tokens);
    }

    public function store(StoreTokenRequest $request)
    {
        $token = $request->user()->createToken(
            $request->name,
            $request->abilities ?? ['*']
        );

        return new ApiTokenResource($token->accessToken);
    }

    public function destroy(Request $request, int $id)
    {
        $token = $request->user()->tokens()->find($id);

        if (!$token) {
            abort(404);
        }

        $token->delete();

        return response()->json(null, 204);
    }

    public function rotate(Request $request, int $id)
    {
        $newToken = app(TokenRotationService::class)->rotate(
            $request->user(),
            $id
        );

        return new ApiTokenResource($newToken->accessToken);
    }
}
```

## Token Resource

```php
class ApiTokenResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'abilities' => $this->abilities,
            'created_at' => $this->created_at->toISOString(),
            'expires_at' => $this->expires_at?->toISOString(),
            'last_used_at' => $this->last_used_at?->toISOString(),
            'is_expired' => $this->isExpired(),
            'last_used_ago' => $this->last_used_at?->diffForHumans(),
        ];
    }
}
```

## Token Testing

```php
class ApiTokenTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_token(): void
    {
        $user = User::factory()->create();

        $token = $user->createToken('Test Token');

        $this->assertNotEmpty($token->plainTextToken);
        $this->assertDatabaseHas('personal_access_tokens', [
            'tokenable_id' => $user->id,
            'name' => 'Test Token',
        ]);
    }

    public function test_token_can_check_abilities(): void
    {
        $user = User::factory()->create();
        $token = $user->createToken('Test Token', ['products:read']);

        $this->assertTrue($token->accessToken->can('products:read'));
        $this->assertFalse($token->accessToken->can('products:write'));
    }

    public function test_token_can_be_revoked(): void
    {
        $user = User::factory()->create();
        $token = $user->createToken('Test Token');

        $user->tokens()->where('id', $token->accessToken->id)->delete();

        $this->assertDatabaseMissing('personal_access_tokens', [
            'id' => $token->accessToken->id,
        ]);
    }

    public function test_expired_token_is_invalid(): void
    {
        $user = User::factory()->create();
        $token = $user->createToken('Test Token')
            ->expiresAt(now()->subHour());

        $this->assertTrue($token->accessToken->isExpired());
    }
}
```

## Token Security

| Practice | Recommendation |
|---|---|
| Expiration | Set reasonable expiry (30-90 days) |
| Abilities | Use principle of least privilege |
| Rotation | Rotate tokens every 90 days |
| Revocation | Revoke on security incidents |
| Rate limiting | Apply per-token rate limits |
| Logging | Log all token operations |
