# 32 — Security

## Purpose

Define the security architecture for GsmUi, covering application security, data protection, compliance, and security best practices.

## Security Architecture

| Layer | Implementation |
|---|---|
| Authentication | Fortify + Sanctum |
| Authorization | Policies + Gates + RBAC |
| Input Validation | Form Requests + Validation |
| Output Encoding | Blade escaping |
| CSRF Protection | Laravel CSRF tokens |
| XSS Protection | Content Security Policy |
| SQL Injection | Eloquent ORM |
| Rate Limiting | Laravel RateLimiter |
| Encryption | APP_KEY (AES-256) |
| Hashing | Argon2id |

## Security Headers

```php
// app/Http/Middleware/SecurityHeaders.php

class SecurityHeaders
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('X-Frame-Options', 'DENY');
        $response->headers->set('X-XSS-Protection', '1; mode=block');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->headers->set('Permissions-Policy', 'camera=(), microphone=(), geolocation=()');
        $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');

        return $response;
    }
}
```

## Content Security Policy

```php
// config/csp.php

return [
    'policy' => [
        'default-src' => ["'self'"],
        'script-src' => ["'self'"],
        'style-src' => ["'self'", "'unsafe-inline'"],
        'img-src' => ["'self'", 'data:', 'https:'],
        'font-src' => ["'self'"],
        'connect-src' => ["'self'"],
        'frame-ancestors' => ["'none'"],
        'form-action' => ["'self'"],
    ],
];
```

## Data Protection

### Encryption

| Data | Method | Storage |
|---|---|---|
| Passwords | Argon2id | Database |
| API Tokens | SHA-256 | Database |
| 2FA Secrets | AES-256 | Database |
| Recovery Codes | AES-256 | Database |
| Sessions | AES-256 | Redis |
| Cookies | AES-256 | HTTP-only |

### Sensitive Data Handling

```php
// Never log sensitive data
Log::info('User login', [
    'user_id' => $user->id,
    'ip' => request()->ip(),
    // Never: 'password', 'token', 'secret'
]);

// Never return sensitive data in responses
return $user->only(['id', 'name', 'email']);
```

## Security Checklist

### Authentication

* [ ] Password hashing with Argon2id
* [ ] Rate limiting on login
* [ ] Email verification required
* [ ] 2FA available
* [ ] Session fixation prevention
* [ ] Secure cookie flags

### Authorization

* [ ] RBAC with Spatie Permission
* [ ] Resource-level policies
* [ ] Global gates for admin abilities
* [ ] Middleware enforcement

### Input/Output

* [ ] Form Request validation
* [ ] Blade escaping (no raw output)
* [ ] Parameterized queries (Eloquent)
* [ ] File upload validation

### Infrastructure

* [ ] HTTPS enforced
* [ ] Security headers
* [ ] CSP configured
* [ ] Rate limiting
* [ ] Error logging (no stack traces in production)

### Data

* [ ] Encryption at rest
* [ ] Encryption in transit
* [ ] No secrets in code
* [ ] No secrets in logs
* [ ] Secure file storage

## Vulnerability Management

| Vulnerability | Severity | Response Time |
|---|---|---|
| Critical | 9.0-10.0 | 24 hours |
| High | 7.0-8.9 | 72 hours |
| Medium | 4.0-6.9 | 1 week |
| Low | 0.1-3.9 | 1 month |

## Security Audit

| Audit | Frequency |
|---|---|
| Dependency scan | Daily |
| Code scan | Weekly |
| Penetration test | Quarterly |
| Security review | Monthly |

## Compliance

| Standard | Status |
|---|---|
| GDPR | Planned |
| SOC 2 | Future |
| ISO 27001 | Future |
