# User Settings

Complete user settings with profile, email, password, 2FA, notifications, connected accounts, and danger zone management.

## Overview

User Settings provides comprehensive account management including personal information, security settings, notification preferences, and account deletion.

## Profile Settings

### Profile Properties

| Property | Description |
|----------|-------------|
| Name | Full name |
| Email | Email address |
| Avatar | Profile picture |
| Bio | Short biography |
| Location | City, country |
| Website | Personal website |
| Timezone | Preferred timezone |

### Profile Form

```yaml
profile_form:
  sections:
    - personal:
        - name:
            type: "text"
            required: true
            
        - email:
            type: "email"
            required: true
            verified: true
            
        - avatar:
            type: "image"
            accept: "image/*"
            
    - about:
        - bio:
            type: "textarea"
            max_length: 500
            
        - location:
            type: "text"
            placeholder: "City, Country"
            
        - website:
            type: "url"
            placeholder: "https://example.com"
            
    - preferences:
        - timezone:
            type: "select"
            options_from: "timezones"
            
        - language:
            type: "select"
            options: ["en", "es", "fr", "de"]
```

### Profile Features

| Feature | Description |
|---------|-------------|
| Avatar upload | Upload profile picture |
| Bio editing | Add personal bio |
| Social links | Add social profiles |
| Privacy settings | Control visibility |

## Email Settings

### Email Configuration

| Setting | Description |
|---------|-------------|
| Current Email | Current email address |
| New Email | New email address |
| Password | Confirm password |
| Verification | Email verification |

### Email Change Form

```yaml
email_change_form:
  fields:
    - current_email:
        type: "email"
        readonly: true
        
    - new_email:
        type: "email"
        required: true
        
    - password:
        type: "password"
        required: true
        
  process:
    - submit_request: "Submit email change"
    - verify_new_email: "Verify new email"
    - confirm_change: "Confirm email change"
    
  options:
    - send_verification: true
    - require_password: true
```

### Email Preferences

```yaml
email_preferences:
  types:
    - marketing: "Marketing emails"
    - product: "Product updates"
    - security: "Security alerts"
    - billing: "Billing notifications"
    
  options:
    - subscribe_all: true
    - unsubscribe_all: false
    - manage_per_type: true
```

## Password Settings

### Password Change

| Field | Description |
|-------|-------------|
| Current Password | Current password |
| New Password | New password |
| Confirm Password | Confirm new password |

### Password Form

```yaml
password_form:
  fields:
    - current_password:
        type: "password"
        required: true
        
    - new_password:
        type: "password"
        required: true
        
    - confirm_password:
        type: "password"
        required: true
        
  validation:
    - min_length: 8
    - require_uppercase: true
    - require_lowercase: true
    - require_number: true
    - require_special: false
```

### Password Security

```yaml
password_security:
  features:
    - password_strength_indicator: true
    - password_history: true
    - password_expiry: false
    
  options:
    - require_password_change: false
    - password_expiry_days: 90
```

## Two-Factor Authentication

### 2FA Methods

| Method | Description |
|--------|-------------|
| Authenticator App | TOTP authenticator |
| SMS | Text message codes |
| Email | Email verification |
| Backup Codes | Recovery codes |

### 2FA Setup

```yaml
two_factor_setup:
  methods:
    - authenticator_app:
        steps:
          - scan_qr_code
          - enter_code
          - verify_setup
          
    - sms:
        steps:
          - enter_phone
          - verify_code
          - enable_sms
          
    - email:
        steps:
          - verify_email
          - enable_email
          
  options:
    - generate_backup_codes: true
    - show_recovery_options: true
```

### 2FA Configuration

```yaml
two_factor_config:
  options:
    - enabled: false
    - trusted_devices: true
    - remember_device: true
    
  settings:
    - remember_duration: "30d"
    - max_trusted_devices: 5
    
  backup_codes:
    - count: 10
    - length: 8
    - format: "XXXX-XXXX"
```

### 2FA Management

```yaml
two_factor_management:
  operations:
    - enable: "Enable 2FA"
    - disable: "Disable 2FA"
    - regenerate_codes: "Regenerate backup codes"
    - view_codes: "View backup codes"
    
  security:
    - require_password: true
    - require_verification: true
```

## Notification Settings

### Notification Types

| Type | Description |
|------|-------------|
| Order Updates | Order status changes |
| License Expiry | License expiration warnings |
| Downloads | Download notifications |
| Promotions | Marketing notifications |
| Security | Security alerts |
| System | Platform announcements |

### Notification Preferences

```yaml
notification_preferences:
  channels:
    - email: true
    - push: true
    - in_app: true
    
  types:
    - order_updates:
        email: true
        push: true
        in_app: true
        
    - license_expiry:
        email: true
        push: true
        in_app: true
        
    - downloads:
        email: false
        push: true
        in_app: true
        
    - promotions:
        email: false
        push: false
        in_app: true
        
    - security:
        email: true
        push: true
        in_app: true
        
    - system:
        email: true
        push: false
        in_app: true
```

### Notification Schedule

```yaml
notification_schedule:
  options:
    - quiet_hours: true
    - quiet_start: "22:00"
    - quiet_end: "08:00"
    
  preferences:
    - immediate: true
    - daily_digest: false
    - weekly_digest: false
```

## Connected Accounts

### Connected Services

| Service | Status |
|---------|--------|
| Google | Connected |
| GitHub | Not connected |
| Twitter | Not connected |
| Facebook | Not connected |

### Connected Accounts List

```yaml
connected_accounts:
  columns:
    - service: "Service"
    - status: "Status"
    - connected_date: "Connected"
    - actions: "Actions"
    
  services:
    - google:
        name: "Google"
        icon: "google"
        scopes: ["email", "profile"]
        
    - github:
        name: "GitHub"
        icon: "github"
        scopes: ["user", "repo"]
        
    - twitter:
        name: "Twitter"
        icon: "twitter"
        scopes: ["email", "profile"]
        
    - facebook:
        name: "Facebook"
        icon: "facebook"
        scopes: ["email", "profile"]
```

### Account Connection

```yaml
connection_process:
  steps:
    - select_service: "Choose service to connect"
    - authorize: "Authorize application"
    - confirm: "Confirm connection"
    
  options:
    - link_existing: true
    - create_new: true
    - merge_accounts: true
```

### Account Management

```yaml
account_management:
  operations:
    - connect: "Connect new account"
    - disconnect: "Disconnect account"
    - set_primary: "Set as primary"
    
  features:
    - multiple_accounts: true
    - account_merge: true
    - primary_account: true
```

## Danger Zone

### Dangerous Actions

| Action | Description |
|--------|-------------|
| Export Data | Download all user data |
| Delete Account | Permanently delete account |
| Deactivate Account | Temporarily disable account |

### Danger Zone Settings

```yaml
danger_zone:
  actions:
    - export_data:
        description: "Download all your data"
        confirmation: true
        process_time: "24h"
        
    - deactivate_account:
        description: "Temporarily disable your account"
        confirmation: true
        reversible: true
        retention_days: 90
        
    - delete_account:
        description: "Permanently delete your account"
        confirmation: true
        reversible: false
        requires_password: true
        
  warnings:
    - data_loss: "This action cannot be undone"
    - backup_reminder: "Export your data first"
    - confirmation_required: "Type your email to confirm"
```

### Account Deletion Process

```yaml
deletion_process:
  steps:
    - request_deletion: "Request account deletion"
    - confirm_deletion: "Confirm deletion"
    - cooling_off: "7-day cooling off period"
    - final_confirmation: "Final confirmation"
    - deletion: "Account deleted"
    
  options:
    - immediate: false
    - cooling_off_days: 7
    - data_retention_days: 30
```

## Integration Points

- **Dashboard**: User settings overview
- **Billing**: Payment settings
- **Security**: Security settings
- **Notifications**: Notification preferences
- **Support**: Account assistance

## API Reference

### Get Profile

```http
GET /api/user/settings/profile
```

### Update Profile

```http
PUT /api/user/settings/profile
Content-Type: application/json

{
  "name": "John Doe",
  "bio": "Developer",
  "timezone": "America/New_York"
}
```

### Change Email

```http
POST /api/user/settings/email
Content-Type: application/json

{
  "new_email": "new@example.com",
  "password": "current-password"
}
```

### Change Password

```http
POST /api/user/settings/password
Content-Type: application/json

{
  "current_password": "old-password",
  "new_password": "new-password",
  "confirm_password": "new-password"
}
```

### Enable 2FA

```http
POST /api/user/settings/2fa/enable
```

### Disable 2FA

```http
POST /api/user/settings/2fa/disable
Content-Type: application/json

{
  "password": "current-password"
}
```

### Get Notifications

```http
GET /api/user/settings/notifications
```

### Update Notifications

```http
PUT /api/user/settings/notifications
Content-Type: application/json

{
  "email": {
    "order_updates": true,
    "promotions": false
  }
}
```

### Connect Account

```http
POST /api/user/settings/connections/{service}
```

### Disconnect Account

```http
DELETE /api/user/settings/connections/{service}
```

### Export Data

```http
POST /api/user/settings/export
```

### Delete Account

```http
DELETE /api/user/settings/account
Content-Type: application/json

{
  "password": "current-password",
  "confirmation": "DELETE"
}
```

## Performance

| Metric | Target |
|--------|--------|
| Settings load | < 500ms |
| Profile update | < 1 second |
| Password change | < 2 seconds |
| 2FA setup | < 3 seconds |
| Data export | < 5 minutes |

## Security

| Measure | Description |
|---------|-------------|
| Password validation | Strong password enforcement |
| 2FA | Two-factor authentication |
| Session management | Secure session handling |
| Audit logging | Track all account changes |
| Data encryption | Encrypt sensitive data |