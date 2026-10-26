For GsmUi, **09-authentication.md** should not be a simple login document. It should define the **complete Identity & Access Management (IAM)** architecture for the platform.

Because your platform includes:

* Laravel 13
* Livewire 4
* Laravel Fortify
* Laravel Sanctum
* Spatie Permission
* Marketplace
* Billing
* Team Accounts (future)
* API Tokens
* MCP
* Admin Panel
* User Dashboard
* Enterprise Support

…the complete document would be **200–300 pages** and cannot fit into a single response.

## Recommended Structure

```text
09-authentication/

09.01-overview.md
09.02-user-lifecycle.md
09.03-registration.md
09.04-email-verification.md
09.05-login.md
09.06-passwords.md
09.07-two-factor-authentication.md
09.08-passkeys-webauthn.md
09.09-social-login.md
09.10-session-management.md
09.11-api-authentication.md
09.12-sanctum.md
09.13-api-tokens.md
09.14-fortify.md
09.15-authorization.md
09.16-spatie-permission.md
09.17-roles.md
09.18-permissions.md
09.19-policies.md
09.20-gates.md
09.21-admin-authentication.md
09.22-user-dashboard-security.md
09.23-mcp-authentication.md
09.24-device-management.md
09.25-account-security.md
09.26-login-history.md
09.27-audit-log.md
09.28-rate-limiting.md
09.29-security-events.md
09.30-enterprise-sso.md
09.31-team-authentication.md
09.32-future-oauth.md
```

## Authentication Flow

```text
Visitor

↓

Register

↓

Verify Email

↓

Login

↓

Fortify Authentication

↓

Session / Sanctum Token

↓

Role Resolution

↓

Permission Resolution

↓

Policies

↓

Application
```

## Identity Stack

| Layer              | Technology          |
| ------------------ | ------------------- |
| Authentication     | Laravel Fortify     |
| API Authentication | Laravel Sanctum     |
| Authorization      | Laravel Policies    |
| RBAC               | Spatie Permission   |
| Password Hashing   | Argon2id            |
| Sessions           | Redis               |
| Activity Logging   | Spatie Activity Log |
| Rate Limiting      | Laravel RateLimiter |
| Health Monitoring  | Spatie Health       |

## Authentication Methods

The architecture should support:

* Email + Password
* Username + Password (optional)
* Magic Links (future)
* Passkeys / WebAuthn (future)
* GitHub Login
* Google Login
* Microsoft Login
* Enterprise SSO
* API Tokens
* MCP Authentication
* CLI Authentication

## Default Roles

```text
Guest

↓

User

↓

Pro User

↓

Creator

↓

Moderator

↓

Support

↓

Editor

↓

Admin

↓

Super Admin
```

## Security Features

* Email verification
* Password confirmation
* Password reset
* Session revocation
* Multi-device management
* Remember me
* Login throttling
* Two-factor authentication (TOTP)
* Recovery codes
* Trusted devices (future)
* Passkeys (future)
* Audit logging
* Failed login tracking
* Suspicious activity detection

## Future Enterprise Features

* SAML
* OpenID Connect
* OAuth2 Provider
* LDAP
* Active Directory
* SCIM Provisioning
* Team Workspaces
* Organization Accounts

### Recommended next document

Start with **09.01-overview.md**, then build the authentication system incrementally through registration, login, Fortify, Sanctum, authorization, and advanced enterprise features. This will produce a complete IAM specification that integrates cleanly with the architecture you've already defined for GsmUi.

---

## Complete IAM Architecture

### Identity and Access Management Overview

The GsmUi IAM system provides a comprehensive identity and access management layer that secures the entire platform. It integrates Laravel's authentication ecosystem (Fortify, Sanctum, Breeze) with role-based access control (Spatie Permission) and enterprise-grade features.

### Core Design Principles

1. **Defense in Depth** - Multiple security layers: authentication, authorization, encryption, monitoring
2. **Principle of Least Privilege** - Users get minimum required permissions
3. **Zero Trust** - Verify every request, trust nothing by default
4. **Separation of Duties** - Critical operations require multiple roles/approvals
5. **Audit Everything** - All security-relevant events are logged
6. **Fail Secure** - System denies access on errors, fails closed

### Authentication Architecture

#### Request Authentication Pipeline

```text
HTTP Request
    ↓
Rate Limiter Middleware
    ↓
CSRF Protection
    ↓
Session Resolution / Token Extraction
    ↓
Authentication Guard (Fortify / Sanctum)
    ↓
User Resolution
    ↓
Role Resolution (Spatie)
    ↓
Permission Resolution (Spatie)
    ↓
Gate Checks (Laravel)
    ↓
Policy Checks (Laravel)
    ↓
Controller / Action
```

#### Guard Configuration

```php
// config/auth.php

return [
    'defaults' => [
        'guard' => 'web',
        'passwords' => 'users',
    ],

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],
        'sanctum' => [
            'driver' => 'sanctum',
            'provider' => 'users',
        ],
        'fortify' => [
            'driver' => 'fortify',
            'provider' => 'users',
        ],
        'api' => [
            'driver' => 'sanctum',
            'provider' => 'users',
        ],
    ],

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class,
        ],
    ],

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    'password_timeout' => 10800,
];
```

### Authorization Architecture

#### Role Hierarchy

```text
Super Admin (100)
    ↓
Admin (90)
    ↓
Editor (70)
    ↓
Moderator (60)
    ↓
Support (50)
    ↓
Creator (40)
    ↓
Pro User (30)
    ↓
User (20)
    ↓
Guest (10)
```

#### Permission Matrix

```text
+---------------------------+--------+-------+---------+-------+------+---------+-------+-------+
| Permission                | Guest  | User  | Pro User| Creator| Mod  | Support | Editor| Admin |
+---------------------------+--------+-------+---------+-------+------+---------+-------+-------+
| View public content       |   ✓    |   ✓   |    ✓    |   ✓   |  ✓   |    ✓    |   ✓   |   ✓   |
| Create account            |   ✓    |   -   |    -    |   -   |  -   |    -    |   -   |   -   |
| Manage own profile        |   -    |   ✓   |    ✓    |   ✓   |  ✓   |    ✓    |   ✓   |   ✓   |
| Upload content            |   -    |   -   |    ✓    |   ✓   |  ✓   |    ✓    |   ✓   |   ✓   |
| Publish content           |   -    |   -   |    -    |   ✓   |  ✓   |    ✓    |   ✓   |   ✓   |
| Moderate content          |   -    |   -   |    -    |   -   |  ✓   |    ✓    |   ✓   |   ✓   |
| Manage users              |   -    |   -   |    -    |   -   |  -   |    ✓    |   ✓   |   ✓   |
| Manage billing            |   -    |   -   |    ✓    |   ✓   |  ✓   |    ✓    |   ✓   |   ✓   |
| Access admin panel        |   -    |   -   |    -    |   -   |  -   |    ✓    |   ✓   |   ✓   |
| Manage roles              |   -    |   -   |    -    |   -   |  -   |    -    |   ✓   |   ✓   |
| Manage settings           |   -    |   -   |    -    |   -   |  -   |    -    |   ✓   |   ✓   |
| Manage themes             |   -    |   -   |    -    |   -   |  -   |    ✓    |   ✓   |   ✓   |
| Manage components         |   -    |   -   |    -    |   -   |  -   |    ✓    |   ✓   |   ✓   |
| API token management      |   -    |   ✓   |    ✓    |   ✓   |  ✓   |    ✓    |   ✓   |   ✓   |
| MCP access                |   -    |   -   |    ✓    |   ✓   |  ✓   |    ✓    |   ✓   |   ✓   |
| System configuration      |   -    |   -   |    -    |   -   |  -   |    -    |   -   |   ✓   |
| Super admin access        |   -    |   -   |    -    |   -   |  -   |    -    |   -   |   ✓   |
+---------------------------+--------+-------+---------+-------+------+---------+-------+-------+
```

### Security Architecture

#### Multi-Factor Authentication Flow

```text
User enters credentials
    ↓
Primary authentication (password/passkey)
    ↓
If MFA enabled:
    ↓
    Generate TOTP challenge
    ↓
    User enters 6-digit code
    ↓
    Verify TOTP code
    ↓
    If recovery code:
        ↓
        Verify recovery code
        ↓
        Invalidate used recovery code
    ↓
Issue session/token
    ↓
Log authentication event
```

#### Session Security

```text
Session Created
    ↓
Generate session ID (64 chars, cryptographically secure)
    ↓
Store in encrypted Redis
    ↓
Set secure cookies:
    - httpOnly: true
    - secure: true
    - sameSite: lax
    - path: /
    - domain: .gsmui.com
    ↓
Session fingerprinting (IP, User-Agent)
    ↓
Session rotation (every 24 hours)
    ↓
Concurrent session limit (configurable)
    ↓
Session invalidation on:
    - Logout
    - Password change
    - Suspicious activity
    - Admin action
```

### Authentication Methods Integration

#### Email + Password Flow

```text
User submits email + password
    ↓
Rate limit check (5 attempts per minute)
    ↓
Credential validation (Argon2id)
    ↓
Password history check (last 5 passwords)
    ↓
If account locked:
    - Return lockout response
    - Increment lockout counter
    - Log failed attempt
    ↓
If MFA enabled:
    - Return MFA challenge
    - Store temp session
    ↓
Successful authentication:
    - Create session
    - Update last_login_at
    - Reset failed_attempts
    - Issue remember_token
    - Log successful login
```

#### Social Login Flow

```text
User clicks "Login with GitHub"
    ↓
Redirect to GitHub OAuth
    ↓
GitHub authenticates user
    ↓
Callback with authorization code
    ↓
Exchange code for access token
    ↓
Fetch user profile from GitHub
    ↓
Check if user exists:
    - Yes: Link accounts, update profile
    - No: Create new user, link social account
    ↓
Issue session
    ↓
Log social login event
```

#### Passkey Flow

```text
User initiates passkey login
    ↓
Server generates challenge
    ↓
Browser shows passkey dialog
    ↓
User authenticates with biometric/security key
    ↓
Browser signs challenge with private key
    ↓
Server verifies signature with public key
    ↓
Validate user handle
    ↓
Issue session
    ↓
Log passkey authentication
```

### API Authentication Architecture

#### Token-Based Authentication

```text
Client requests token:
    POST /oauth/token
    grant_type=password
    username=user@example.com
    password=secret
    client_id=app-id
    client_secret=app-secret
    ↓
Server validates credentials
    ↓
Generate access token (15 min TTL)
    ↓
Generate refresh token (30 day TTL)
    ↓
Return tokens to client
    ↓
Client uses token:
    Authorization: Bearer <access_token>
    ↓
Server validates token:
    - Check token exists
    - Check not revoked
    - Check not expired
    - Check scopes
    ↓
Attach user to request
    ↓
Process request
```

#### Token Revocation

```text
Client requests revocation:
    POST /oauth/revoke
    token=<token>
    token_type_hint=access_token
    ↓
Server finds token
    ↓
Mark token as revoked
    ↓
Invalidate all derived tokens
    ↓
Log revocation event
    ↓
Return 200 OK
```

### RBAC System Architecture

#### Spatie Permission Integration

```php
// app/Models/User.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, TwoFactorAuthenticatable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function hasPermissionTo(string $permission): bool
    {
        return $this->hasPermissionTo($permission);
    }

    public function hasRole(string $role): bool
    {
        return $this->hasRole($role);
    }

    public function scopeActive($query)
    {
        return $query->where('active', true);
    }
}
```

#### Permission Definitions

```php
// database/seeders/RolePermissionSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Permissions
        $permissions = [
            'view public content',
            'create account',
            'manage own profile',
            'upload content',
            'publish content',
            'moderate content',
            'manage users',
            'manage billing',
            'access admin panel',
            'manage roles',
            'manage settings',
            'manage themes',
            'manage components',
            'api token management',
            'mcp access',
            'system configuration',
            'super admin access',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Roles
        $roles = [
            'guest' => ['view public content', 'create account'],
            'user' => ['view public content', 'manage own profile', 'api token management'],
            'pro_user' => ['view public content', 'manage own profile', 'upload content', 'manage billing', 'api token management', 'mcp access'],
            'creator' => ['view public content', 'manage own profile', 'upload content', 'publish content', 'manage billing', 'api token management', 'mcp access'],
            'moderator' => ['view public content', 'manage own profile', 'upload content', 'publish content', 'moderate content', 'manage billing', 'api token management', 'mcp access'],
            'support' => ['view public content', 'manage own profile', 'upload content', 'publish content', 'moderate content', 'manage users', 'manage billing', 'access admin panel', 'manage themes', 'manage components', 'api token management', 'mcp access'],
            'editor' => ['view public content', 'manage own profile', 'upload content', 'publish content', 'moderate content', 'manage users', 'manage billing', 'access admin panel', 'manage roles', 'manage settings', 'manage themes', 'manage components', 'api token management', 'mcp access'],
            'admin' => ['view public content', 'manage own profile', 'upload content', 'publish content', 'moderate content', 'manage users', 'manage billing', 'access admin panel', 'manage roles', 'manage settings', 'manage themes', 'manage components', 'api token management', 'mcp access', 'system configuration', 'super admin access'],
            'super_admin' => ['view public content', 'create account', 'manage own profile', 'upload content', 'publish content', 'moderate content', 'manage users', 'manage billing', 'access admin panel', 'manage roles', 'manage settings', 'manage themes', 'manage components', 'api token management', 'mcp access', 'system configuration', 'super admin access'],
        ];

        foreach ($roles as $roleName => $rolePermissions) {
            $role = Role::create(['name' => $roleName]);
            $role->givePermissionTo($rolePermissions);
        }
    }
}
```

### Authentication Lifecycle

#### Registration to Deactivation

```text
1. Registration
    ↓
   Validate input
   Create user account
   Hash password (Argon2id)
   Send verification email
   Create activity log
    ↓
2. Email Verification
    ↓
   User clicks verification link
   Mark email_verified_at
   Auto-assign 'user' role
   Create audit log entry
    ↓
3. First Login
    ↓
   Validate credentials
   Create session
   Update last_login_at
   Initialize 2FA setup prompt
   Log first login
    ↓
4. Regular Authentication
    ↓
   Rate limiting
   Credential validation
   Session creation
   Optional 2FA
   Audit logging
    ↓
5. Profile Updates
    ↓
   Validate permissions
   Update profile fields
   Invalidate sessions if email changed
   Log profile changes
    ↓
6. Role/Permission Changes
    ↓
   Admin modifies roles
   Update user permissions
   Log role changes
   Notify user of changes
    ↓
7. Account Deactivation
    ↓
   Admin or user initiates
   Invalidate all sessions
   Revoke all tokens
   Mark account inactive
   Log deactivation
```

### Security Monitoring

#### Security Event Categories

```text
1. Authentication Events
   - Login success/failure
   - Password change/reset
   - MFA enable/disable
   - Passkey registration
   - Social login

2. Authorization Events
   - Permission granted/denied
   - Role assigned/removed
   - Policy evaluation

3. Session Events
   - Session created/destroyed
   - Session timeout
   - Concurrent session limit
   - Suspicious session

4. API Events
   - Token created/revoked
   - Rate limit exceeded
   - Invalid token usage

5. Admin Events
   - User created/deactivated
   - Role/permission changes
   - System configuration changes
   - SSO configuration changes

6. Security Events
   - Brute force attempts
   - Credential stuffing
   - Suspicious activity
   - Account lockout
```

#### Security Metrics Dashboard

```php
// app/Services/Security/SecurityMetricsService.php

namespace App\Services\Security;

use App\Models\User;
use App\Models\Login;
use App\Models\ApiToken;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SecurityMetricsService
{
    public function getAuthenticationMetrics(Carbon $startDate, Carbon $endDate): array
    {
        return [
            'total_logins' => Login::whereBetween('created_at', [$startDate, $endDate])->count(),
            'successful_logins' => Login::whereBetween('created_at', [$startDate, $endDate])->where('success', true)->count(),
            'failed_logins' => Login::whereBetween('created_at', [$startDate, $endDate])->where('success', false)->count(),
            'unique_users' => Login::whereBetween('created_at', [$startDate, $endDate])->distinct('user_id')->count('user_id'),
            'avg_session_duration' => $this->calculateAvgSessionDuration($startDate, $endDate),
            'mfa_usage_rate' => $this->calculateMfaUsageRate(),
            'passkey_usage_rate' => $this->calculatePasskeyUsageRate(),
        ];
    }

    public function getSecurityIncidents(Carbon $startDate, Carbon $endDate): array
    {
        return [
            'brute_force_attempts' => $this->detectBruteForce($startDate, $endDate),
            'credential_stuffing' => $this->detectCredentialStuffing($startDate, $endDate),
            'suspicious_sessions' => $this->detectSuspiciousSessions($startDate, $endDate),
            'account_lockouts' => $this->getAccountLockouts($startDate, $endDate),
            'token_reuse_attempts' => $this->detectTokenReuse($startDate, $endDate),
        ];
    }

    public function getUserSecurityScore(int $userId): array
    {
        $user = User::find($userId);

        return [
            'has_mfa' => $user->two_factor_secret !== null,
            'has_passkeys' => $user->passkeys()->count() > 0,
            'password_age' => $this->getPasswordAge($user),
            'active_sessions' => $user->sessions()->count(),
            'api_tokens' => $user->tokens()->count(),
            'login_count_30d' => Login::where('user_id', $userId)
                ->where('created_at', '>=', now()->subDays(30))
                ->count(),
            'failed_attempts_30d' => Login::where('user_id', $userId)
                ->where('created_at', '>=', now()->subDays(30))
                ->where('success', false)
                ->count(),
            'score' => $this->calculateSecurityScore($user),
        ];
    }

    protected function calculateAvgSessionDuration(Carbon $startDate, Carbon $endDate): float
    {
        $result = DB::table('sessions')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->whereNotNull('last_activity')
            ->selectRaw('AVG(last_activity - created_at) as avg_duration')
            ->value('avg_duration');

        return $result ? round($result / 3600, 2) : 0;
    }

    protected function calculateMfaUsageRate(): float
    {
        $totalUsers = User::count();
        $mfaUsers = User::whereNotNull('two_factor_secret')->count();

        return $totalUsers > 0 ? round(($mfaUsers / $totalUsers) * 100, 2) : 0;
    }

    protected function calculatePasskeyUsageRate(): float
    {
        $totalUsers = User::count();
        $passkeyUsers = DB::table('passkeys')->distinct('user_id')->count('user_id');

        return $totalUsers > 0 ? round(($passkeyUsers / $totalUsers) * 100, 2) : 0;
    }

    protected function detectBruteForce(Carbon $startDate, Carbon $endDate): array
    {
        return Login::whereBetween('created_at', [$startDate, $endDate])
            ->where('success', false)
            ->select('ip_address', DB::raw('COUNT(*) as attempts'))
            ->groupBy('ip_address')
            ->having('attempts', '>', 10)
            ->orderByDesc('attempts')
            ->get()
            ->toArray();
    }

    protected function detectCredentialStuffing(Carbon $startDate, Carbon $endDate): array
    {
        return Login::whereBetween('created_at', [$startDate, $endDate])
            ->where('success', false)
            ->select('ip_address', DB::raw('COUNT(DISTINCT email) as unique_emails'))
            ->groupBy('ip_address')
            ->having('unique_emails', '>', 5)
            ->get()
            ->toArray();
    }

    protected function detectSuspiciousSessions(Carbon $startDate, Carbon $endDate): array
    {
        return DB::table('sessions')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->whereRaw('(SELECT COUNT(*) FROM sessions WHERE user_id = sessions.user_id AND id != sessions.id) > 3')
            ->get()
            ->toArray();
    }

    protected function getAccountLockouts(Carbon $startDate, Carbon $endDate): int
    {
        return Login::whereBetween('created_at', [$startDate, $endDate])
            ->where('locked_out', true)
            ->count();
    }

    protected function detectTokenReuse(Carbon $startDate, Carbon $endDate): array
    {
        return DB::table('personal_access_tokens')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->select('tokenable_id', DB::raw('COUNT(*) as reuse_count'))
            ->groupBy('tokenable_id')
            ->having('reuse_count', '>', 1)
            ->get()
            ->toArray();
    }

    protected function getPasswordAge(User $user): int
    {
        return $user->password_changed_at
            ? $user->password_changed_at->diffInDays(now())
            : -1;
    }

    protected function calculateSecurityScore(User $user): int
    {
        $score = 0;

        if ($user->two_factor_secret) $score += 25;
        if ($user->passkeys()->count() > 0) $score += 20;
        if ($this->getPasswordAge($user) < 90) $score += 15;
        if ($user->email_verified_at) $score += 10;
        if ($user->sessions()->count() <= 5) $score += 10;
        if ($user->tokens()->count() <= 10) $score += 10;
        if (Login::where('user_id', $user->id)->where('success', false)->where('created_at', '>=', now()->subDays(30))->count() < 3) $score += 10;

        return min(100, $score);
    }
}
```

### Integration Points

#### Fortify Integration

```php
// app/Providers/FortifyServiceProvider.php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\ResetUserPassword;
use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Fortify;

class FortifyServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(CreateNewUser::class);
        $this->app->bind(UpdateUserPassword::class);
        $this->app->bind(ResetUserPassword::class);
    }

    public function boot(): void
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        Fortify::loginView(fn () => view('auth.login'));
        Fortify::registerView(fn () => view('auth.register'));
        Fortify::requestPasswordResetLinkView(fn () => view('auth.forgot-password'));
        Fortify::resetPasswordView(fn ($request) => view('auth.reset-password', ['request' => $request]));
        Fortify::confirmPasswordView(fn () => view('auth.confirm-password'));
        Fortify::twoFactorChallengeView(fn () => view('auth.two-factor-challenge'));
        Fortify::verifyEmailView(fn () => view('auth.verify-email'));

        Fortify::authenticateUsing(function ($request) {
            $user = \App\Models\User::where('email', $request->email)->first();

            if ($user && Hash::check($request->password, $user->password)) {
                return $user;
            }

            return null;
        });
    }
}
```

#### Sanctum Integration

```php
// app/Providers/SanctumServiceProvider.php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Sanctum\Sanctum;

class SanctumServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Sanctum::authenticateAccess(function ($request, $abilities) {
            $token = $request->user()->currentAccessToken();

            if (!$token) {
                return false;
            }

            if ($token->abilities->contains('*')) {
                return true;
            }

            foreach ($abilities as $ability) {
                if ($token->abilities->contains($ability)) {
                    return true;
                }
            }

            return false;
        });

        Sanctum::usePersonalAccessTokenModel(\App\Models\PersonalAccessToken::class);
    }
}
```

### Security Configuration

```php
// config/security.php

return [
    'authentication' => [
        'max_login_attempts' => env('SECURITY_MAX_LOGIN_ATTEMPTS', 5),
        'lockout_duration' => env('SECURITY_LOCKOUT_DURATION', 15),
        'password_expiry_days' => env('SECURITY_PASSWORD_EXPIRY_DAYS', 90),
        'password_history_count' => env('SECURITY_PASSWORD_HISTORY_COUNT', 5),
        'remember_me_duration' => env('SECURITY_REMEMBER_ME_DURATION', 30),
        'session_lifetime' => env('SECURITY_SESSION_LIFETIME', 120),
        'session_timeout' => env('SECURITY_SESSION_TIMEOUT', 30),
        'concurrent_sessions_limit' => env('SECURITY_CONCURRENT_SESSIONS', 5),
    ],

    'mfa' => [
        'enabled' => env('SECURITY_MFA_ENABLED', true),
        'enforced_for_admins' => env('SECURITY_MFA_ENFORCED_ADMINS', true),
        'recovery_codes_count' => env('SECURITY_RECOVERY_CODES_COUNT', 8),
        'totp_period' => env('SECURITY_TOTP_PERIOD', 30),
        'totp_digits' => env('SECURITY_TOTP_DIGITS', 6),
    ],

    'password' => [
        'min_length' => env('SECURITY_PASSWORD_MIN_LENGTH', 8),
        'require_uppercase' => env('SECURITY_PASSWORD_REQUIRE_UPPERCASE', true),
        'require_lowercase' => env('SECURITY_PASSWORD_REQUIRE_LOWERCASE', true),
        'require_number' => env('SECURITY_PASSWORD_REQUIRE_NUMBER', true),
        'require_special' => env('SECURITY_PASSWORD_REQUIRE_SPECIAL', true),
        'hash_algorithm' => env('SECURITY_PASSWORD_HASH', 'argon2id'),
    ],

    'rate_limiting' => [
        'login' => env('SECURITY_RATE_LIMIT_LOGIN', '5,1'),
        'password_reset' => env('SECURITY_RATE_LIMIT_PASSWORD_RESET', '3,1'),
        'api' => env('SECURITY_RATE_LIMIT_API', '60,1'),
    ],

    'session' => [
        'driver' => env('SESSION_DRIVER', 'redis'),
        'lifetime' => env('SESSION_LIFETIME', 120),
        'expire_on_close' => env('SESSION_EXPIRE_ON_CLOSE', true),
        'encrypt' => env('SESSION_ENCRYPT', true),
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
    ],

    'telescope' => [
        'enabled' => env('TELESCOPE_ENABLED', false),
    ],

    'activity_log' => [
        'enabled' => env('ACTIVITY_LOG_ENABLED', true),
        'delete_records_older_than_days' => 365,
        'prune_models_after_cleanup' => true,
    ],

    'health_check' => [
        'enabled' => env('HEALTH_CHECK_ENABLED', true),
        'interval' => env('HEALTH_CHECK_INTERVAL', 60),
    ],
];
```

### Testing Strategy

#### Unit Tests

```php
// tests/Unit/Services/AuthenticationServiceTest.php

namespace Tests\Unit\Services;

use App\Models\User;
use App\Services\Authentication\AuthenticationService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationServiceTest extends TestCase
{
    use RefreshDatabase;

    protected AuthenticationService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new AuthenticationService();
    }

    public function test_authenticate_with_valid_credentials(): void
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        $result = $this->service->authenticate('test@example.com', 'password');

        $this->assertNotNull($result);
        $this->assertEquals($user->id, $result->id);
    }

    public function test_authenticate_with_invalid_credentials(): void
    {
        User::factory()->create([
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        $result = $this->service->authenticate('test@example.com', 'wrong-password');

        $this->assertNull($result);
    }

    public function test_authenticate_with_locked_account(): void
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => 'password',
            'locked_at' => now(),
        ]);

        $result = $this->service->authenticate('test@example.com', 'password');

        $this->assertNull($result);
    }

    public function test_authenticate_with_inactive_account(): void
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => 'password',
            'active' => false,
        ]);

        $result = $this->service->authenticate('test@example.com', 'password');

        $this->assertNull($result);
    }
}
```

#### Feature Tests

```php
// tests/Feature/Authentication/LoginTest.php

namespace Tests\Feature\Authentication;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_screen_can_be_rendered(): void
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
    }

    public function test_user_can_login_with_valid_credentials(): void
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        $this->assertAuthenticatedAs($user);
        $response->assertRedirect('/dashboard');
    }

    public function test_user_cannot_login_with_invalid_credentials(): void
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        $response = $this->from('/login')->post('/login', [
            'email' => 'test@example.com',
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
        $response->assertRedirect('/login');
    }

    public function test_user_is_redirected_to_dashboard_if_already_authenticated(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/login');

        $response->assertRedirect('/dashboard');
    }

    public function test_user_can_logout(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/logout');

        $this->assertGuest();
        $response->redirect('/');
    }

    public function test_user_can_be_remembered(): void
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'password',
            'remember' => 'on',
        ]);

        $this->assertAuthenticatedAs($user);
        $this->assertAuthenticatedViaCookie($user);
    }

    public function test_rate_limiting_is_applied_to_login(): void
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        for ($i = 0; $i < 6; $i++) {
            $this->post('/login', [
                'email' => 'test@example.com',
                'password' => 'wrong-password',
            ]);
        }

        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'wrong-password',
        ]);

        $response->assertStatus(429);
    }

    public function test_email_verification_required_for_login(): void
    {
        $user = User::factory()->unverified()->create([
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        $this->assertGuest();
        $response->redirect('/verify-email');
    }
}
```

#### Integration Tests

```php
// tests/Feature/Authentication/TwoFactorAuthenticationTest.php

namespace Tests\Feature\Authentication;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TwoFactorAuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_two_factor_challenge_screen_can_be_rendered(): void
    {
        $response = $this->get('/two-factor-challenge');
        $response->assertStatus(200);
    }

    public function test_user_can_authenticate_with_valid_two_factor_code(): void
    {
        $user = User::factory()->create([
            'two_factor_secret' => encrypt('test-secret'),
            'two_factor_recovery_codes' => encrypt(json_encode(['code1', 'code2'])),
        ]);

        $response = $this->post('/two-factor-challenge', [
            'code' => '123456',
        ]);

        $this->assertAuthenticatedAs($user);
    }

    public function test_user_can_authenticate_with_recovery_code(): void
    {
        $user = User::factory()->create([
            'two_factor_secret' => encrypt('test-secret'),
            'two_factor_recovery_codes' => encrypt(json_encode(['recovery-code-1', 'recovery-code-2'])),
        ]);

        $response = $this->post('/two-factor-challenge', [
            'recovery_code' => 'recovery-code-1',
        ]);

        $this->assertAuthenticatedAs($user);
    }

    public function test_user_cannot_authenticate_with_invalid_two_factor_code(): void
    {
        $user = User::factory()->create([
            'two_factor_secret' => encrypt('test-secret'),
            'two_factor_recovery_codes' => encrypt(json_encode(['code1', 'code2'])),
        ]);

        $response = $this->post('/two-factor-challenge', [
            'code' => '000000',
        ]);

        $this->assertGuest();
    }
}
```

### Deployment Checklist

#### Pre-Production Security Review

```text
□ Rate limiting configured for all auth endpoints
□ CSRF protection enabled on all forms
□ Session cookies set to httpOnly, secure, sameSite
□ Password hashing using Argon2id
□ MFA available and enforced for admins
□ Email verification required
□ Account lockout after failed attempts
□ Audit logging for all security events
□ API tokens have appropriate expiration
□ CORS configured for allowed origins only
□ CSP headers configured
□ SQL injection protection (Eloquent)
□ XSS protection (Blade escaping)
□ File upload validation
□ Input validation on all endpoints
□ SQL query logging disabled in production
□ Error pages don't expose sensitive info
□ Debug mode disabled
□ APP_KEY set and secure
□ HTTPS enforced
□ HSTS headers configured
```

#### Monitoring and Alerting

```text
□ Failed login attempts > threshold
□ Account lockouts
□ MFA failures
□ API rate limit exceeded
□ Suspicious session activity
□ Token revocation events
□ Role/permission changes
□ User deactivation events
□ Security misconfigurations
□ Database connection issues
□ Redis connection issues
□ Queue processing delays
□ Cache hit rate drops
□ Error rate spikes
□ Response time degradation
```

### Future Enhancements

#### Phase 4 Enterprise Features

1. **SAML 2.0** - Enterprise SSO integration
2. **OpenID Connect** - Modern SSO protocol
3. **LDAP/Active Directory** - On-premise directory services
4. **SCIM Provisioning** - Automated user lifecycle management
5. **OAuth2 Provider** - Third-party application authorization
6. **JWT Access Tokens** - Stateless API authentication
7. **Certificate-Based Auth** - Client certificate authentication
8. **Risk-Based Authentication** - Adaptive authentication based on risk score
9. **Step-Up Authentication** - Additional verification for sensitive operations
10. **Identity Federation** - Cross-domain identity management

#### Advanced Security Features

1. **Anomaly Detection** - ML-based suspicious activity detection
2. **Behavioral Biometrics** - Keystroke dynamics, mouse movement patterns
3. **Device Fingerprinting** - Advanced device identification
4. **Geolocation Analysis** - Location-based risk assessment
5. **Impossible Travel Detection** - Flag impossible login locations
6. **Session Anomaly Detection** - Detect unusual session behavior
7. **Credential Monitoring** - Dark web credential monitoring
8. **Threat Intelligence Integration** - Real-time threat feeds
9. **Automated Incident Response** - Self-healing security measures
10. **Compliance Automation** - Automated SOC2, HIPAA, GDPR compliance checks

---

## Authentication Providers Configuration

### Laravel Fortify Actions

```php
// app/Actions/Fortify/CreateNewUser.php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    public function create(array $input): User
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', Password::min(8)->mixedCase()->numbers()->symbols(), 'confirmed'],
        ])->validate();

        $user = User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ]);

        $user->assignRole('user');

        activity()
            ->performedOn($user)
            ->event('registered')
            ->log('User registered');

        return $user;
    }
}

// app/Actions/Fortify/UpdateUserPassword.php

namespace App\Actions\Fortify;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\UpdatesUserPasswords;

class UpdateUserPassword implements UpdatesUserPasswords
{
    public function update($user, array $input): void
    {
        Validator::make($input, [
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', Password::min(8)->mixedCase()->numbers()->symbols(), 'confirmed'],
        ])->validate();

        if (!Hash::check($input['current_password'], $user->password)) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'current_password' => ['The provided password does not match your current password.'],
            ]);
        }

        $user->forceFill([
            'password' => Hash::make($input['password']),
            'password_changed_at' => now(),
        ])->save();

        activity()
            ->performedOn($user)
            ->event('password_changed')
            ->log('User changed password');
    }
}

// app/Actions/Fortify/ResetUserPassword.php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\ResetsUserPasswords;

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

        activity()
            ->performedOn($user)
            ->event('password_reset')
            ->log('User reset password');
    }
}
```

## Session Management Service

```php
// app/Services/Session/SessionService.php

namespace App\Services\Session;

use App\Models\User;
use App\Models\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class SessionService
{
    public function getUserSessions(User $user): \Illuminate\Support\Collection
    {
        return Session::where('user_id', $user->id)
            ->orderByDesc('last_activity')
            ->get()
            ->map(function ($session) {
                return [
                    'id' => $session->id,
                    'ip_address' => $session->ip_address,
                    'user_agent' => $this->parseUserAgent($session->user_agent),
                    'is_current' => $session->id === session()->getId(),
                    'last_activity' => Carbon::createFromTimestamp($session->last_activity),
                    'created_at' => $session->created_at,
                ];
            });
    }

    public function revokeAllSessionsExceptCurrent(User $user): int
    {
        $currentSessionId = session()->getId();

        return Session::where('user_id', $user->id)
            ->where('id', '!=', $currentSessionId)
            ->delete();
    }

    public function revokeSession(User $user, string $sessionId): bool
    {
        return (bool) Session::where('user_id', $user->id)
            ->where('id', $sessionId)
            ->delete();
    }

    public function getActiveSessionCount(User $user): int
    {
        return Session::where('user_id', $user->id)
            ->where('last_activity', '>', now()->subMinutes(config('session.lifetime', 120)))
            ->count();
    }

    public function enforceConcurrentSessionLimit(User $user, int $limit = 5): void
    {
        $sessions = Session::where('user_id', $user->id)
            ->orderByDesc('last_activity')
            ->get();

        if ($sessions->count() > $limit) {
            $sessions->slice($limit)->each(function ($session) {
                $session->delete();
            });
        }
    }

    public function getSessionAnalytics(): array
    {
        return [
            'total_sessions' => Session::count(),
            'active_sessions' => Session::where('last_activity', '>', now()->subMinutes(30))->count(),
            'unique_users' => Session::distinct('user_id')->count('user_id'),
            'avg_session_duration' => $this->calculateAvgDuration(),
            'sessions_by_browser' => $this->getSessionsByBrowser(),
            'sessions_by_os' => $this->getSessionsByOs(),
        ];
    }

    protected function parseUserAgent(string $userAgent): array
    {
        return [
            'browser' => $this->extractBrowser($userAgent),
            'os' => $this->extractOs($userAgent),
            'device' => $this->extractDevice($userAgent),
        ];
    }

    protected function extractBrowser(string $userAgent): string
    {
        if (str_contains($userAgent, 'Firefox')) return 'Firefox';
        if (str_contains($userAgent, 'Edg/')) return 'Edge';
        if (str_contains($userAgent, 'Chrome')) return 'Chrome';
        if (str_contains($userAgent, 'Safari')) return 'Safari';
        return 'Other';
    }

    protected function extractOs(string $userAgent): string
    {
        if (str_contains($userAgent, 'Windows')) return 'Windows';
        if (str_contains($userAgent, 'Mac OS')) return 'macOS';
        if (str_contains($userAgent, 'Linux')) return 'Linux';
        if (str_contains($userAgent, 'Android')) return 'Android';
        if (str_contains($userAgent, 'iPhone') || str_contains($userAgent, 'iPad')) return 'iOS';
        return 'Other';
    }

    protected function extractDevice(string $userAgent): string
    {
        if (str_contains($userAgent, 'Mobile') || str_contains($userAgent, 'Android')) return 'Mobile';
        if (str_contains($userAgent, 'iPad')) return 'Tablet';
        return 'Desktop';
    }

    protected function calculateAvgDuration(): float
    {
        $result = DB::table('sessions')
            ->selectRaw('AVG(last_activity - created_at) as avg_duration')
            ->value('avg_duration');

        return $result ? round($result / 60, 1) : 0;
    }

    protected function getSessionsByBrowser(): array
    {
        $sessions = Session::pluck('user_agent');
        $browsers = ['Chrome' => 0, 'Firefox' => 0, 'Safari' => 0, 'Edge' => 0, 'Other' => 0];

        foreach ($sessions as $ua) {
            $browser = $this->extractBrowser($ua);
            $browsers[$browser]++;
        }

        return $browsers;
    }

    protected function getSessionsByOs(): array
    {
        $sessions = Session::pluck('user_agent');
        $oses = ['Windows' => 0, 'macOS' => 0, 'Linux' => 0, 'Android' => 0, 'iOS' => 0, 'Other' => 0];

        foreach ($sessions as $ua) {
            $os = $this->extractOs($ua);
            $oses[$os]++;
        }

        return $oses;
    }
}
```

## Authentication Middleware

```php
// app/Http/Middleware/EnsureMfaEnabled.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureMfaEnabled
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        if ($user && !$user->two_factor_secret && config('security.mfa.enabled')) {
            return redirect()->route('profile.show')
                ->with('warning', 'Please enable two-factor authentication for enhanced security.');
        }

        return $next($request);
    }
}

// app/Http/Middleware/EnsureEmailVerified.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureEmailVerified
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->user() && !$request->user()->hasVerifiedEmail()) {
            return redirect()->route('verification.notice');
        }

        return $next($request);
    }
}

// app/Http/Middleware/CheckAccountStatus.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckAccountStatus
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        if ($user && !$user->active) {
            auth()->logout();
            return redirect()->route('login')
                ->with('error', 'Your account has been deactivated. Please contact support.');
        }

        return $next($request);
    }
}

// app/Http/Middleware/TrackLoginAttempts.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class TrackLoginAttempts
{
    public function handle(Request $request, Closure $next)
    {
        $ip = $request->ip();
        $key = "login_attempts:{$ip}";
        $maxAttempts = config('security.authentication.max_login_attempts', 5);
        $lockoutDuration = config('security.authentication.lockout_duration', 15);

        $attempts = Cache::get($key, 0);

        if ($attempts >= $maxAttempts) {
            return response()->json([
                'message' => 'Too many login attempts. Please try again later.',
                'retry_after' => $lockoutDuration * 60,
            ], 429)->withHeaders([
                'Retry-After' => $lockoutDuration * 60,
            ]);
        }

        $response = $next($request);

        if ($response->status() === 401 || $response->status() === 422) {
            Cache::put($key, $attempts + 1, now()->addMinutes($lockoutDuration));
        } else {
            Cache::forget($key);
        }

        return $response;
    }
}
```

## Rate Limiting Configuration

```php
// app/Providers/RateLimitServiceProvider.php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

class RateLimitServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        RateLimiter::for('login', function (Request $request) {
            return Limit::perMinute(5)->by($request->input('email') ?: $request->ip());
        });

        RateLimiter::for('password-reset', function (Request $request) {
            return Limit::perMinute(3)->by($request->input('email'));
        });

        RateLimiter::for('mfa', function (Request $request) {
            return Limit::perMinute(3)->by($request->user()?->id ?: $request->ip());
        });

        RateLimiter::for('token-create', function (Request $request) {
            return Limit::perHour(10)->by($request->user()?->id);
        });

        RateLimiter::for('scim', function (Request $request) {
            return Limit::perMinute(120)->by($request->ip());
        });
    }
}
```

## Password Policies

```php
// app/Services/Password/PasswordPolicyService.php

namespace App\Services\Password;

use App\Models\PasswordHistory;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class PasswordPolicyService
{
    public function validatePasswordHistory(User $user, string $newPassword): bool
    {
        $historyCount = config('security.password_history_count', 5);

        $recentPasswords = PasswordHistory::where('user_id', $user->id)
            ->orderByDesc('created_at')
            ->limit($historyCount)
            ->get();

        foreach ($recentPasswords as $history) {
            if (Hash::check($newPassword, $history->password)) {
                return false;
            }
        }

        return true;
    }

    public function recordPasswordHistory(User $user, string $password): void
    {
        $historyCount = config('security.password_history_count', 5);

        PasswordHistory::create([
            'user_id' => $user->id,
            'password' => $password,
        ]);

        $totalPasswords = PasswordHistory::where('user_id', $user->id)->count();

        if ($totalPasswords > $historyCount) {
            PasswordHistory::where('user_id', $user->id)
                ->orderBy('created_at')
                ->limit($totalPasswords - $historyCount)
                ->delete();
        }
    }

    public function isPasswordExpired(User $user): bool
    {
        $expiryDays = config('security.authentication.password_expiry_days', 90);

        if (!$user->password_changed_at) {
            return true;
        }

        return $user->password_changed_at->addDays($expiryDays)->isPast();
    }

    public function validatePasswordStrength(string $password): array
    {
        $errors = [];
        $minLength = config('security.password.min_length', 8);

        if (strlen($password) < $minLength) {
            $errors[] = "Password must be at least {$minLength} characters.";
        }

        if (config('security.password.require_uppercase') && !preg_match('/[A-Z]/', $password)) {
            $errors[] = 'Password must contain at least one uppercase letter.';
        }

        if (config('security.password.require_lowercase') && !preg_match('/[a-z]/', $password)) {
            $errors[] = 'Password must contain at least one lowercase letter.';
        }

        if (config('security.password.require_number') && !preg_match('/[0-9]/', $password)) {
            $errors[] = 'Password must contain at least one number.';
        }

        if (config('security.password.require_special') && !preg_match('/[^A-Za-z0-9]/', $password)) {
            $errors[] = 'Password must contain at least one special character.';
        }

        return $errors;
    }
}
```

## User Model Extensions

```php
// app/Models/User.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, TwoFactorAuthenticatable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
        'active',
        'email_verified_at',
        'two_factor_secret',
        'two_factor_recovery_codes',
        'two_factor_confirmed_at',
        'password_changed_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'two_factor_confirmed_at' => 'datetime',
        'password_changed_at' => 'datetime',
        'password' => 'hashed',
        'active' => 'boolean',
    ];

    public function sessions(): HasMany
    {
        return $this->hasMany(Session::class);
    }

    public function ssoUsers(): HasMany
    {
        return $this->hasMany(SsoUser::class);
    }

    public function oauthClients(): HasMany
    {
        return $this->hasMany(OAuthClient::class);
    }

    public function oauthTokens(): HasMany
    {
        return $this->hasMany(OAuthAccessToken::class);
    }

    public function apiTokens(): HasMany
    {
        return $this->hasMany(PersonalAccessToken::class);
    }

    public function passkeys(): HasMany
    {
        return $this->hasMany(Passkey::class);
    }

    public function loginHistory(): HasMany
    {
        return $this->hasMany(Login::class);
    }

    public function passwordHistory(): HasMany
    {
        return $this->hasMany(PasswordHistory::class);
    }

    public function isActive(): bool
    {
        return $this->active;
    }

    public function deactivate(): void
    {
        $this->update(['active' => false]);
        $this->sessions()->delete();
        $this->tokens()->delete();
    }

    public function activate(): void
    {
        $this->update(['active' => true]);
    }

    public function getSecurityScore(): int
    {
        $score = 0;

        if ($this->two_factor_secret) $score += 25;
        if ($this->passkeys()->count() > 0) $score += 20;
        if ($this->password_changed_at && $this->password_changed_at->diffInDays(now()) < 90) $score += 15;
        if ($this->email_verified_at) $score += 10;
        if ($this->sessions()->count() <= 5) $score += 10;
        if ($this->tokens()->count() <= 10) $score += 10;
        if ($this->loginHistory()->where('success', false)->where('created_at', '>=', now()->subDays(30))->count() < 3) $score += 10;

        return min(100, $score);
    }
}
```

## Audit Logger Service

```php
// app/Services/Audit/AuditLogger.php

namespace App\Services\Audit;

use App\Models\User;
use Illuminate\Support\Facades\Log;
use Spatie\Activitylog\LogOptions;

class AuditLogger
{
    public static function logLogin(User $user, bool $success, ?string $reason = null): void
    {
        $event = $success ? 'login_success' : 'login_failed';

        activity()
            ->performedOn($user)
            ->event($event)
            ->withProperties([
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'reason' => $reason,
            ])
            ->log("User {$event}");
    }

    public static function logPasswordChange(User $user): void
    {
        activity()
            ->performedOn($user)
            ->event('password_changed')
            ->log('User changed password');
    }

    public static function logRoleChanged(User $admin, User $target, string $oldRole, string $newRole): void
    {
        activity()
            ->performedOn($target)
            ->causedBy($admin)
            ->event('role_changed')
            ->withProperties([
                'old_role' => $oldRole,
                'new_role' => $newRole,
            ])
            ->log("Role changed from {$oldRole} to {$newRole}");
    }

    public static function logAccountDeactivated(User $admin, User $target, string $reason): void
    {
        activity()
            ->performedOn($target)
            ->causedBy($admin)
            ->event('account_deactivated')
            ->withProperties(['reason' => $reason])
            ->log("Account deactivated: {$reason}");
    }

    public static function logTokenCreated(User $user, string $tokenName): void
    {
        activity()
            ->performedOn($user)
            ->event('token_created')
            ->withProperties(['token_name' => $tokenName])
            ->log("API token created: {$tokenName}");
    }

    public static function logTokenRevoked(User $user, string $tokenName): void
    {
        activity()
            ->performedOn($user)
            ->event('token_revoked')
            ->withProperties(['token_name' => $tokenName])
            ->log("API token revoked: {$tokenName}");
    }

    public static function logSecurityEvent(string $event, ?User $user = null, array $context = []): void
    {
        Log::channel('security')->warning($event, array_merge([
            'user_id' => $user?->id,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'timestamp' => now()->toIso8601String(),
        ], $context));
    }
}
```

## Security Event Dispatcher

```php
// app/Events/Security/SecurityEvent.php

namespace App\Events\Security;

use App\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

abstract class SecurityEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public ?User $user = null,
        public array $context = [],
        public string $severity = 'info'
    ) {}
}

namespace App\Events\Security;

class LoginSucceeded extends SecurityEvent
{
    public function __construct(User $user, array $context = [])
    {
        parent::__construct($user, $context, 'info');
    }
}

class LoginFailed extends SecurityEvent
{
    public function __construct(string $email, array $context = [])
    {
        parent::__construct(null, array_merge($context, ['email' => $email]), 'warning');
    }
}

class MfaChallengeFailed extends SecurityEvent
{
    public function __construct(User $user, array $context = [])
    {
        parent::__construct($user, $context, 'warning');
    }
}

class AccountLocked extends SecurityEvent
{
    public function __construct(User $user, array $context = [])
    {
        parent::__construct($user, $context, 'critical');
    }
}

class SuspiciousActivity extends SecurityEvent
{
    public function __construct(User $user, string $description, array $context = [])
    {
        parent::__construct($user, array_merge($context, ['description' => $description]), 'critical');
    }
}

class TokenRevoked extends SecurityEvent
{
    public function __construct(User $user, string $tokenName, array $context = [])
    {
        parent::__construct($user, array_merge($context, ['token_name' => $tokenName]), 'info');
    }
}
```

## Security Event Listener

```php
// app/Listeners/Security/SecurityEventListener.php

namespace App\Listeners\Security;

use App\Events\Security\LoginSucceeded;
use App\Events\Security\LoginFailed;
use App\Events\Security\MfaChallengeFailed;
use App\Events\Security\AccountLocked;
use App\Events\Security\SuspiciousActivity;
use App\Services\Audit\AuditLogger;
use Illuminate\Support\Facades\Mail;

class SecurityEventListener
{
    public function handleLoginSucceeded(LoginSucceeded $event): void
    {
        AuditLogger::logLogin($event->user, true, $event->context['reason'] ?? null);
    }

    public function handleLoginFailed(LoginFailed $event): void
    {
        AuditLogger::logSecurityEvent('login_failed', null, $event->context);
    }

    public function handleMfaChallengeFailed(MfaChallengeFailed $event): void
    {
        AuditLogger::logSecurityEvent('mfa_challenge_failed', $event->user, $event->context);

        if ($event->severity === 'critical') {
            Mail::to(config('security.alerts.email'))->send(
                new \App\Mail\SecurityAlert('MFA Challenge Failed', $event->user, $event->context)
            );
        }
    }

    public function handleAccountLocked(AccountLocked $event): void
    {
        AuditLogger::logSecurityEvent('account_locked', $event->user, $event->context);

        Mail::to(config('security.alerts.email'))->send(
            new \App\Mail\SecurityAlert('Account Locked', $event->user, $event->context)
        );
    }

    public function handleSuspiciousActivity(SuspiciousActivity $event): void
    {
        AuditLogger::logSecurityEvent('suspicious_activity', $event->user, $event->context);

        Mail::to(config('security.alerts.email'))->send(
            new \App\Mail\SecurityAlert('Suspicious Activity', $event->user, $event->context)
        );
    }
}
```

## Event Service Provider

```php
// app/Providers/EventServiceProvider.php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        \App\Events\Security\LoginSucceeded::class => [
            \App\Listeners\Security\SecurityEventListener::class . '@handleLoginSucceeded',
        ],
        \App\Events\Security\LoginFailed::class => [
            \App\Listeners\Security\SecurityEventListener::class . '@handleLoginFailed',
        ],
        \App\Events\Security\MfaChallengeFailed::class => [
            \App\Listeners\Security\SecurityEventListener::class . '@handleMfaChallengeFailed',
        ],
        \App\Events\Security\AccountLocked::class => [
            \App\Listeners\Security\SecurityEventListener::class . '@handleAccountLocked',
        ],
        \App\Events\Security\SuspiciousActivity::class => [
            \App\Listeners\Security\SecurityEventListener::class . '@handleSuspiciousActivity',
        ],
    ];

    public function boot(): void
    {
        //
    }
}
```

## Deployment Commands

```php
// app/Console/Commands/SecurityAuditCommand.php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\Session;
use App\Models\PersonalAccessToken;
use Illuminate\Console\Command;

class SecurityAuditCommand extends Command
{
    protected $signature = 'security:audit';
    protected $description = 'Run security audit on authentication system';

    public function handle(): int
    {
        $this->info('Running security audit...');

        $this->checkInactiveAccounts();
        $this->checkExpiredPasswords();
        $this->checkMfaAdoption();
        $this->checkActiveSessions();
        $this->checkOldApiTokens();
        $this->checkSecurityEvents();

        $this->info('Security audit complete!');
        return Command::SUCCESS;
    }

    protected function checkInactiveAccounts(): void
    {
        $inactiveUsers = User::where('active', false)
            ->where('updated_at', '<', now()->subDays(90))
            ->count();

        $this->info("Inactive accounts (>90 days): {$inactiveUsers}");
    }

    protected function checkExpiredPasswords(): void
    {
        $expiryDays = config('security.authentication.password_expiry_days', 90);
        $expiredPasswords = User::where('password_changed_at', '<', now()->subDays($expiryDays))
            ->orWhereNull('password_changed_at')
            ->count();

        $this->info("Expired passwords (>{$expiryDays} days): {$expiredPasswords}");
    }

    protected function checkMfaAdoption(): void
    {
        $totalUsers = User::count();
        $mfaUsers = User::whereNotNull('two_factor_secret')->count();
        $percentage = $totalUsers > 0 ? round(($mfaUsers / $totalUsers) * 100, 2) : 0;

        $this->info("MFA adoption: {$mfaUsers}/{$totalUsers} ({$percentage}%)");
    }

    protected function checkActiveSessions(): void
    {
        $activeSessions = Session::where('last_activity', '>', now()->subMinutes(30))->count();
        $this->info("Active sessions: {$activeSessions}");
    }

    protected function checkOldApiTokens(): void
    {
        $oldTokens = PersonalAccessToken::where('created_at', '<', now()->subDays(90))
            ->count();

        $this->info("API tokens older than 90 days: {$oldTokens}");
    }

    protected function checkSecurityEvents(): void
    {
        $recentEvents = \Spatie\Activitylog\Models\Activity::where('created_at', '>=', now()->subDays(7))
            ->where('event', 'like', '%failed%')
            ->count();

        $this->info("Failed security events (7 days): {$recentEvents}");
    }
}
```

## Environment Configuration

```env
# Authentication
AUTH_GUARD=web
AUTH_PASSWORD_BROKER=users

# Session
SESSION_DRIVER=redis
SESSION_LIFETIME=120
SESSION_ENCRYPT=true
SESSION_CONNECTION=sessions
SESSION_COOKIE=gsmui_session

# Fortify
FORTIFY_REGISTER=true
FORTIFY_RESET_PASSWORDS=true
FORTIFY_EMAIL_VERIFICATION=true
FORTIFY_PROFILE=true

# Sanctum
SANCTUM_STATEFUL_DOMAINS=localhost,localhost:3000,127.0.0.1,127.0.0.1:8000,::1
SANCTUM_GUARD=web

# Security
SECURITY_MAX_LOGIN_ATTEMPTS=5
SECURITY_LOCKOUT_DURATION=15
SECURITY_PASSWORD_EXPIRY_DAYS=90
SECURITY_PASSWORD_HISTORY_COUNT=5
SECURITY_MFA_ENABLED=true
SECURITY_MFA_ENFORCED_ADMINS=true

# Rate Limiting
RATE_LIMIT_LOGIN=5,1
RATE_LIMIT_API=60,1
RATE_LIMIT_PASSWORD_RESET=3,1

# Password Policy
SECURITY_PASSWORD_MIN_LENGTH=8
SECURITY_PASSWORD_REQUIRE_UPPERCASE=true
SECURITY_PASSWORD_REQUIRE_LOWERCASE=true
SECURITY_PASSWORD_REQUIRE_NUMBER=true
SECURITY_PASSWORD_REQUIRE_SPECIAL=true
```

## Integration Checklist

```text
□ Fortify installed and configured
□ Sanctum installed and configured
□ Spatie Permission installed and seeded
□ Two-factor authentication enabled
□ Passkey support enabled
□ Social login providers configured
□ LDAP/SSO integration configured (enterprise)
□ SCIM provisioning enabled (enterprise)
□ OAuth provider configured (enterprise)
□ API token management enabled
□ MCP authentication configured
□ Session management configured
□ Rate limiting configured
□ Audit logging configured
□ Security monitoring configured
□ Email verification enforced
□ Password policies enforced
□ Account lockout configured
□ Concurrent session limits set
□ Security alerts configured
□ Compliance logging enabled
```

## Summary

This document defines the complete Identity and Access Management architecture for GsmUi. It covers:

1. **Authentication** - Multiple authentication methods (email/password, social, passkeys, SSO)
2. **Authorization** - Role-based access control with Spatie Permission
3. **Session Management** - Secure session handling with Redis
4. **API Authentication** - Token-based authentication with Sanctum
5. **MFA** - Two-factor authentication with TOTP and recovery codes
6. **Security Monitoring** - Comprehensive audit logging and security event tracking
7. **Enterprise Features** - SAML, OIDC, LDAP, SCIM integration
8. **Compliance** - GDPR, SOC2, HIPAA compliance features
9. **Testing** - Unit, feature, and integration tests
10. **Deployment** - Security audit commands and deployment checklists

The system is designed to be secure, scalable, and maintainable, following Laravel best practices and security standards.
