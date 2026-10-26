# Enterprise Features

## Overview

Enterprise features extend gsmui's permission system with SSO/SAML, directory sync, custom roles, audit logs, and compliance tools designed for large organizations.

## SSO/SAML Integration

### Supported Providers

| Provider | Protocol | Status |
|----------|----------|--------|
| Okta | SAML 2.0 | Supported |
| Azure AD | SAML 2.0 | Supported |
| Google Workspace | OIDC | Supported |
| OneLogin | SAML 2.0 | Supported |
| Auth0 | OIDC | Supported |
| Custom | SAML 2.0 | Supported |

### Configuration

```php
// config/sso.php
return [
    'enabled' => env('SSO_ENABLED', false),

    'provider' => env('SSO_PROVIDER', 'okta'),

    'saml' => [
        'entity_id' => env('SAML_ENTITY_ID'),
        'acs_url' => env('SAML_ACS_URL'),
        'slo_url' => env('SAML_SLO_URL'),
        'certificate' => env('SAML_CERTIFICATE'),
        'private_key' => env('SAML_PRIVATE_KEY'),
    ],

    'oidc' => [
        'client_id' => env('OIDC_CLIENT_ID'),
        'client_secret' => env('OIDC_CLIENT_SECRET'),
        'discovery_url' => env('OIDC_DISCOVERY_URL'),
        'redirect_uri' => env('OIDC_REDIRECT_URI'),
    ],

    'mapping' => [
        'email' => 'email',
        'name' => 'displayName',
        'groups' => 'memberOf',
        'role' => 'urn:oid:2.5.4.12',
    ],

    'role_sync' => [
        'enabled' => true,
        'default_role' => 'user',
        'group_role_map' => [
            'CN=Admins,OU=Groups' => 'admin',
            'CN=Editors,OU=Groups' => 'creator',
            'CN=Users,OU=Groups' => 'user',
        ],
    ],
];
```

### SSO Authentication Flow

```
┌──────────┐     SAML Request     ┌──────────────┐
│ User     │ ──────────────────►  │ gsmui        │
│ Browser  │                      │ Auth Service │
└──────────┘                      └──────┬───────┘
     ▲                                    │
     │                                    │ Redirect
     │                                    ▼
     │                             ┌──────────────┐
     │         SAML Response       │ Identity     │
     │ ◄───────────────────────── │ Provider     │
     │                             │ (Okta/Azure) │
     │                             └──────────────┘
     │
     ▼
┌──────────────┐    create/update   ┌──────────────┐
│ gsmui        │ ────────────────►  │ User Record  │
│ Auth Service │                    │ + Roles      │
└──────────────┘                    └──────────────┘
```

## Directory Sync

### LDAP Sync

```php
// config/directory-sync.php
return [
    'driver' => 'ldap',

    'ldap' => [
        'hosts' => [env('LDAP_HOST')],
        'port' => env('LDAP_PORT', 636),
        'base_dn' => env('LDAP_BASE_DN'),
        'username' => env('LDAP_USERNAME'),
        'password' => env('LDAP_PASSWORD'),
        'ssl' => env('LDAP_SSL', true),
    ],

    'sync' => [
        'enabled' => true,
        'interval_minutes' => 60,
        'batch_size' => 100,
    ],

    'mapping' => [
        'email' => 'mail',
        'name' => 'cn',
        'department' => 'department',
        'groups' => 'memberOf',
    ],

    'provisioning' => [
        'create_users' => true,
        'deactivate_users' => true,
        'sync_roles' => true,
    ],
];
```

### Directory Sync Job

```php
class DirectorySyncCommand extends Command
{
    protected $signature = 'directory:sync';

    public function handle(): int
    {
        $driver = DirectorySync::driver(config('directory-sync.driver'));

        $users = $driver->fetchUsers();
        $results = ['created' => 0, 'updated' => 0, 'deactivated' => 0];

        foreach (array_chunk($users, 100) as $batch) {
            foreach ($batch as $directoryUser) {
                $result = $driver->syncUser($directoryUser);
                $results[$result]++;
            }
        }

        $this->info("Sync complete: {$results['created']} created, {$results['updated']} updated, {$results['deactivated']} deactivated");

        return Command::SUCCESS;
    }
}
```

## Custom Roles

### Enterprise Custom Role Features

| Feature | Description |
|---------|-------------|
| Role cloning | Duplicate existing roles as templates |
| Role scoping | Restrict roles to specific teams or departments |
| Role expiry | Auto-revoke roles after a set duration |
| Role approval | Require manager approval for role changes |
| Role versioning | Track role permission history |

### Role Approval Workflow

```php
class RoleChangeRequest extends Model
{
    protected $fillable = [
        'user_id', 'requested_role_id', 'approved_by',
        'status', 'reason', 'expires_at',
    ];

    public function approve(User $approver): void
    {
        $this->update([
            'status' => 'approved',
            'approved_by' => $approver->id,
        ]);

        $this->user->assignRole(
            $this->requested_role_id,
            expiresAt: $this->expires_at
        );

        event(new RoleChangeApproved($this));
    }

    public function deny(User $approver, string $reason): void
    {
        $this->update([
            'status' => 'denied',
            'approved_by' => $approver->id,
            'denial_reason' => $reason,
        ]);

        event(new RoleChangeDenied($this));
    }
}
```

## Audit Logs

### Audit Event Types

| Event | Description | Data Captured |
|-------|-------------|---------------|
| `user.login` | User authentication | IP, user agent, method |
| `user.logout` | Session termination | Session duration |
| `role.assigned` | Role given to user | Role, assigned by, scope |
| `role.revoked` | Role removed from user | Role, revoked by, scope |
| `permission.changed` | Role permissions modified | Added, removed, by |
| `user.created` | New user account | Creator, method |
| `user.deactivated` | User account disabled | Reason, by |
| `settings.changed` | System settings modified | Setting, old, new, by |
| `data.exported` | Data export performed | Data type, by |
| `data.deleted` | Data deletion performed | Data type, by, reason |

### Audit Log Schema

| Column | Type | Description |
|--------|------|-------------|
| `id` | `bigint` | Primary key |
| `user_id` | `bigint?` | FK to users (null for system events) |
| `event` | `string` | Event type |
| `auditable_type` | `string` | Model class |
| `auditable_id` | `bigint?` | Model ID |
| `old_values` | `json` | Previous state |
| `new_values` | `json` | New state |
| `ip_address` | `string?` | Request IP |
| `user_agent` | `string?` | Request user agent |
| `tags` | `json` | Categorization tags |
| `created_at` | `timestamp` | |

### Querying Audit Logs

```php
use App\Models\AuditLog;

// User activity
AuditLog::where('user_id', $user->id)
    ->latest()
    ->paginate(20);

// Permission changes
AuditLog::whereIn('event', [
    'role.assigned',
    'role.revoked',
    'permission.changed',
])
    ->where('created_at', '>=', now()->subDays(30))
    ->get();

// Resource history
AuditLog::where('auditable_type', Post::class)
    ->where('auditable_id', $post->id)
    ->get();
```

## Compliance

### Compliance Features

| Feature | Standard | Description |
|---------|----------|-------------|
| SOC 2 | Audit logging | Complete activity trail |
| GDPR | Data export | User data export on request |
| GDPR | Right to deletion | Account and data erasure |
| HIPAA | Access controls | Role-based access enforcement |
| HIPAA | Audit trails | Detailed access logging |
| ISO 27001 | Security policies | Policy documentation support |

### GDPR Data Export

```php
class GdprExportCommand extends Command
{
    protected $signature = 'gdpr:export {user}';

    public function handle(User $user): int
    {
        $export = GdprExport::create($user);

        $export->includePersonalData();
        $export->includeActivityLogs();
        $export->includeContent();
        $export->includePermissions();

        $file = $export->generateZip();

        // Notify user
        GdprExportReadyMail::send($user, $file);

        return Command::SUCCESS;
    }
}
```

### GDPR Data Deletion

```php
class GdprDeleteCommand extends Command
{
    protected $signature = 'gdpr:delete {user} {--force}';

    public function handle(User $user): int
    {
        if (!$this->option('force')) {
            $this->warn('This will permanently delete all user data.');
            if (!$this->confirm('Continue?')) {
                return Command::SUCCESS;
            }
        }

        GdprDeletion::perform($user);

        $this->info("User data deleted for {$user->email}");

        return Command::SUCCESS;
    }
}
```

## Configuration

```php
// config/enterprise.php
return [
    'sso' => [
        'enabled' => env('SSO_ENABLED', false),
        'force_sso' => env('FORCE_SSO', false),
        'auto_provision' => env('SSO_AUTO_PROVISION', true),
    ],

    'directory_sync' => [
        'enabled' => env('DIRECTORY_SYNC_ENABLED', false),
    ],

    'audit' => [
        'enabled' => env('AUDIT_ENABLED', true),
        'retention_days' => env('AUDIT_RETENTION_DAYS', 365),
    ],

    'compliance' => [
        'gdpr' => env('GDPR_ENABLED', false),
        'hipaa' => env('HIPAA_ENABLED', false),
        'soc2' => env('SOC2_ENABLED', false),
    ],

    'custom_roles' => [
        'enabled' => env('CUSTOM_ROLES_ENABLED', false),
        'max_count' => env('CUSTOM_ROLES_MAX', 100),
        'require_approval' => env('ROLES_REQUIRE_APPROVAL', false),
    ],
];
```

## Best Practices

1. **Enable audit logging** in all production environments
2. **Use directory sync** for organizations with existing identity providers
3. **Set retention policies** for audit logs based on compliance requirements
4. **Test SSO flows** thoroughly before forcing SSO for all users
5. **Review custom roles** quarterly to remove unused role definitions
6. **Document compliance measures** in your security documentation
