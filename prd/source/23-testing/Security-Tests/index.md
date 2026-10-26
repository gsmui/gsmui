# Security Testing

> PRD — Volume 23: Quality Assurance — Security Testing

## Overview

Security testing validates OWASP Top 10 compliance, dependency scanning, penetration testing, and CSP validation for the gsmui platform.

## Objectives

| Goal | Metric | Target |
|------|--------|--------|
| OWASP coverage | Top 10 checks | 100% |
| Vulnerabilities | Critical/High severity | 0 |
| Dependencies | Known CVEs | 0 |
| CSP | Policy enforcement | 100% |
| Penetration | Successful exploits | 0 |

## OWASP Top 10 Checks

### A01: Broken Access Control

| Check | Test Method | Status |
|-------|-------------|--------|
| Horizontal privilege escalation | Test user accessing other user's resources | ✅ |
| Vertical privilege escalation | Test regular user accessing admin routes | ✅ |
| IDOR vulnerabilities | Test ID enumeration on API endpoints | ✅ |
| Missing function-level access | Test admin functions without auth | ✅ |
| CORS misconfiguration | Test cross-origin requests | ✅ |
| Directory traversal | Test path manipulation | ✅ |

```php
class AccessControlTest extends TestCase
{
    public function test_regular_user_cannot_access_admin(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $response = $this->get('/admin/pages');
        $response->assertForbidden();

        $response = $this->post('/admin/pages', ['title' => 'Test']);
        $response->assertForbidden();
    }

    public function test_user_cannot_access_other_users_resources(): void
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();

        $post = Post::factory()->create(['author_id' => $otherUser->id]);

        $this->actingAs($user);

        $response = $this->put("/admin/posts/{$post->id}", ['title' => 'Hacked']);
        $response->assertForbidden();
    }
}
```

### A02: Cryptographic Failures

| Check | Test Method | Status |
|-------|-------------|--------|
| Password hashing | Verify bcrypt/argon2 | ✅ |
| Sensitive data encryption | Check database encryption | ✅ |
| HTTPS enforcement | Test HTTP redirect | ✅ |
| Secure cookie flags | Check Set-Cookie headers | ✅ |
| API key exposure | Scan logs and responses | ✅ |

### A03: Injection

| Check | Test Method | Status |
|-------|-------------|--------|
| SQL injection | Test parameterized queries | ✅ |
| XSS (stored) | Test user input rendering | ✅ |
| XSS (reflected) | Test URL parameters | ✅ |
| Command injection | Test shell commands | ✅ |
| LDAP injection | Test LDAP queries | ✅ |
| NoSQL injection | Test MongoDB queries | ✅ |

```php
class InjectionTest extends TestCase
{
    public function test_sql_injection_prevented(): void
    {
        $response = $this->get("/blog?q=' OR '1'='1");
        $response->assertStatus(200);

        // Should not return all posts
        $this->assertDatabaseCount('posts', 0);
    }

    public function test_xss_prevented_in_input(): void
    {
        $this->actingAsAdmin();

        $response = $this->post('/admin/pages', [
            'title' => '<script>alert("xss")</script>',
            'slug' => 'xss-test',
        ]);

        $response->assertStatus(200);

        $response = $this->get('/pages/xss-test');
        $response->assertDontSee('<script>');
        $response->assertSee('&lt;script&gt;');
    }
}
```

### A04: Insecure Design

| Check | Test Method | Status |
|-------|-------------|--------|
| Threat modeling | Review architecture | ✅ |
| Business logic flaws | Test edge cases | ✅ |
| Rate limiting | Test API rate limits | ✅ |
| Resource consumption | Test file upload limits | ✅ |

### A05: Security Misconfiguration

| Check | Test Method | Status |
|-------|-------------|--------|
| Default credentials | Scan for defaults | ✅ |
| Error handling | Test error responses | ✅ |
| Directory listing | Test directory access | ✅ |
| Unnecessary features | Audit enabled features | ✅ |
| Security headers | Check response headers | ✅ |

```php
class SecurityHeadersTest extends TestCase
{
    public function test_security_headers_present(): void
    {
        $response = $this->get('/');

        $response->assertHeader('X-Content-Type-Options', 'nosniff');
        $response->assertHeader('X-Frame-Options', 'SAMEORIGIN');
        $response->assertHeader('X-XSS-Protection', '1; mode=block');
        $response->assertHeader('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->assertHeader('Content-Security-Policy');
    }
}
```

### A06: Vulnerable Components

| Check | Test Method | Frequency |
|-------|-------------|-----------|
| Composer audit | `composer audit` | Every PR |
| npm audit | `npm audit` | Every PR |
| CVE scanning | Snyk/Dependabot | Daily |

### A07: Authentication Failures

| Check | Test Method | Status |
|-------|-------------|--------|
| Brute force protection | Test rapid login attempts | ✅ |
| Credential stuffing | Test common password list | ✅ |
| Session management | Test session fixation | ✅ |
| Password policy | Test password requirements | ✅ |
| MFA support | Test 2FA enrollment | ✅ |

### A08: Data Integrity Failures

| Check | Test Method | Status |
|-------|-------------|--------|
| Deserialization | Test unsafe unserialization | ✅ |
| CI/CD pipeline | Audit build process | ✅ |
| Software supply chain | Verify dependencies | ✅ |

### A09: Logging Failures

| Check | Test Method | Status |
|-------|-------------|--------|
| Audit logging | Verify user actions logged | ✅ |
| Error logging | Verify errors captured | ✅ |
| Log integrity | Test log tampering | ✅ |

### A10: SSRF

| Check | Test Method | Status |
|-------|-------------|--------|
| URL fetching | Test internal URL access | ✅ |
| Webhook URLs | Validate target URLs | ✅ |

## Dependency Scanning

### Composer Audit

```bash
# Check for known vulnerabilities
composer audit

# Example output
Found 2 security vulnerabilities listed by advisory ID:
 - GHSA-xxxx-xxxx-xxxx (moderate)
   laravel/framework: 10.0.0 < 10.48.4
   CVE-2024-XXXXX: ...
   Fix: composer update laravel/framework
```

### npm Audit

```bash
npm audit
npm audit fix
```

### Automated Scanning

```yaml
name: Security Scan

on:
  schedule:
    - cron: '0 6 * * *'  # Daily
  pull_request:
    branches: [main]

jobs:
  security:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v4
      - name: Composer Audit
        run: composer audit --format=json > composer-audit.json
      - name: npm Audit
        run: npm audit --json > npm-audit.json
      - name: Upload Results
        uses: actions/upload-artifact@v4
        with:
          name: security-reports
          path: |
            composer-audit.json
            npm-audit.json
```

## CSP Validation

### Content Security Policy

```
default-src 'self';
script-src 'self' 'unsafe-inline' 'unsafe-eval';
style-src 'self' 'unsafe-inline';
img-src 'self' data: https:;
font-src 'self';
connect-src 'self' https://api.example.com;
media-src 'self';
object-src 'none';
frame-ancestors 'self';
base-uri 'self';
form-action 'self';
```

### CSP Test

```php
class CspTest extends TestCase
{
    public function test_csp_header_is_present(): void
    {
        $response = $this->get('/');

        $response->assertHeader('Content-Security-Policy');
    }

    public function test_csp_blocks_inline_scripts(): void
    {
        $response = $this->get('/');

        $csp = $response->headers->get('Content-Security-Policy');
        $this->assertStringContainsString("script-src 'self'", $csp);
    }

    public function test_csp_blocks_external_resources(): void
    {
        $response = $this->get('/');

        $csp = $response->headers->get('Content-Security-Policy');
        $this->assertStringNotContainsString('https://cdn.example.com', $csp);
    }
}
```

## Penetration Testing Checklist

| Category | Test | Priority |
|----------|------|----------|
| Authentication | Credential brute force | High |
| Authentication | Session hijacking | High |
| Authentication | Password reset flow | High |
| Authorization | Privilege escalation | High |
| Authorization | IDOR on API endpoints | High |
| Input | SQL injection | Critical |
| Input | XSS (stored/reflected) | Critical |
| Input | File upload malicious files | High |
| API | Rate limiting bypass | Medium |
| API | Mass assignment | High |
| Session | Cookie manipulation | High |
| Session | CSRF token bypass | High |

## Acceptance Criteria

- [ ] Zero OWASP Top 10 critical vulnerabilities
- [ ] All dependencies pass security audit
- [ ] CSP policy blocks unauthorized resources
- [ ] Security headers present on all responses
- [ ] SQL injection attempts are prevented
- [ ] XSS attacks are blocked
- [ ] Access control is enforced on all routes
- [ ] Brute force protection is active
- [ ] Audit logging captures all actions
- [ ] Penetration test findings are addressed
