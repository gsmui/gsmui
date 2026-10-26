# Platform Settings

Comprehensive platform configuration with general settings, email config, payment config, feature toggles, and maintenance mode.

## Overview

Platform Settings provides centralized configuration for all platform operations including general settings, email, payments, features, and system maintenance.

## General Settings

### Site Configuration

| Setting | Description |
|---------|-------------|
| Site Name | Platform name |
| Site Description | Brief description |
| Site URL | Primary URL |
| Logo | Site logo |
| Favicon | Browser tab icon |
| Timezone | Default timezone |
| Language | Default language |
| Date Format | Display date format |
| Time Format | Display time format |

### General Settings Form

```yaml
general_settings:
  sections:
    - name: "Site Identity"
      fields:
        - site_name:
            type: "text"
            required: true
            
        - site_description:
            type: "textarea"
            
        - site_url:
            type: "url"
            required: true
            
    - name: "Branding"
      fields:
        - logo:
            type: "image"
            accept: "image/*"
            
        - favicon:
            type: "image"
            accept: "image/*"
            
    - name: "Localization"
      fields:
        - timezone:
            type: "select"
            options_from: "timezones"
            
        - language:
            type: "select"
            options: ["en", "es", "fr", "de"]
            
        - date_format:
            type: "select"
            options: ["Y-m-d", "d/m/Y", "m/d/Y"]
            
        - time_format:
            type: "select"
            options: ["H:i", "g:i A"]
```

### Registration Settings

```yaml
registration_settings:
  options:
    - allow_registration: true
    - require_email_verification: true
    - default_role: "user"
    - max_attempts: 5
    - lockout_duration: "15m"
    
  fields:
    - name: true
    - email: true
    - password: true
    - terms_accepted: true
    
  social_registration:
    - google: false
    - github: false
    - twitter: false
```

## Email Configuration

### Email Settings

| Setting | Description |
|---------|-------------|
| Driver | Mail driver (smtp, mailgun, ses) |
| Host | SMTP host |
| Port | SMTP port |
| Username | SMTP username |
| Password | SMTP password |
| Encryption | TLS/SSL |
| From Address | Sender email |
| From Name | Sender name |

### Email Configuration Form

```yaml
email_settings:
  sections:
    - name: "SMTP Configuration"
      fields:
        - driver:
            type: "select"
            options: ["smtp", "mailgun", "ses", "postmark"]
            
        - host:
            type: "text"
            placeholder: "smtp.gmail.com"
            
        - port:
            type: "number"
            placeholder: "587"
            
        - username:
            type: "text"
            
        - password:
            type: "password"
            
        - encryption:
            type: "select"
            options: ["tls", "ssl", "none"]
            
    - name: "Sender Information"
      fields:
        - from_address:
            type: "email"
            required: true
            
        - from_name:
            type: "text"
            required: true
            
    - name: "Queue Configuration"
      fields:
        - queue_enabled:
            type: "toggle"
            default: true
            
        - queue_connection:
            type: "select"
            options: ["sync", "database", "redis", "sqs"]
```

### Email Templates

```yaml
email_templates:
  types:
    - welcome:
        subject: "Welcome to {site_name}"
        template: "emails.welcome"
        
    - verify_email:
        subject: "Verify your email address"
        template: "emails.verify"
        
    - reset_password:
        subject: "Reset your password"
        template: "emails.reset"
        
    - order_confirmation:
        subject: "Order confirmation"
        template: "emails.order"
        
  features:
    - preview: true
    - test_send: true
    - customize: true
```

## Payment Configuration

### Payment Gateways

| Gateway | Description |
|---------|-------------|
| Stripe | Credit card processing |
| PayPal | PayPal payments |
| Square | Square payments |
| Bank Transfer | Direct bank payments |
| Cryptocurrency | Crypto payments |

### Stripe Configuration

```yaml
stripe_settings:
  fields:
    - mode:
        type: "select"
        options: ["test", "live"]
        
    - public_key:
        type: "text"
        required: true
        
    - secret_key:
        type: "password"
        required: true
        
    - webhook_secret:
        type: "password"
        
    - currency:
        type: "select"
        options: ["usd", "eur", "gbp"]
        
  options:
    - capture_method: "automatic"
    - statement_descriptor: "GSMUI"
```

### Payment Settings

```yaml
payment_settings:
  general:
    - currency: "USD"
    - tax_calculation: true
    - tax_rate: 0
    - invoice_generation: true
    
  subscriptions:
    - trial_period: 14
    - trial_enabled: true
    - grace_period: 3
    
  refunds:
    - allow_refunds: true
    - refund_window: "30d"
    - auto_approve: false
```

## Feature Toggles

### Feature Flags

| Feature | Description | Default |
|---------|-------------|---------|
| marketplace | Enable marketplace | true |
| playground | Enable playground | true |
| ai_features | Enable AI features | true |
| collaboration | Enable real-time collab | true |
| analytics | Enable analytics | true |
| dark_mode | Enable dark mode | true |
| multi_language | Enable i18n | false |
| maintenance | Maintenance mode | false |

### Feature Toggle Configuration

```yaml
feature_toggles:
  features:
    - marketplace:
        name: "Marketplace"
        description: "Enable digital marketplace"
        enabled: true
        beta: false
        
    - playground:
        name: "Playground"
        description: "Enable code playground"
        enabled: true
        beta: false
        
    - ai_features:
        name: "AI Features"
        description: "Enable AI-powered features"
        enabled: true
        beta: true
        
    - collaboration:
        name: "Real-time Collaboration"
        description: "Enable collaborative editing"
        enabled: false
        beta: true
        
  settings:
    - allow_override: true
    - cache_enabled: true
    - log_changes: true
```

### Feature Rollout

```yaml
feature_rollout:
  strategies:
    - percentage:
        description: "Roll out to percentage of users"
        options: ["1%", "5%", "10%", "25%", "50%", "100%"]
        
    - user_segment:
        description: "Roll out to specific segments"
        options: ["beta_users", "team", "all"]
        
    - date_based:
        description: "Roll out on specific date"
        options: ["immediate", "scheduled"]
```

## Maintenance Mode

### Maintenance Settings

| Setting | Description |
|---------|-------------|
| Enable | Toggle maintenance mode |
| Message | User-facing message |
| Allow IPs | IPs to bypass |
| Retry After | Retry duration |
| Template | Custom maintenance page |

### Maintenance Configuration

```yaml
maintenance_settings:
  options:
    - enabled: false
    - message: "We're currently performing maintenance. Please try again later."
    - retry_after: 60
    - template: "errors.maintenance"
    
  access:
    - allow_ips:
        - "127.0.0.1"
        - "::1"
        
    - allow_paths:
        - "/api/health"
        - "/admin"
        
  scheduling:
    - start_time: null
    - end_time: null
    - notify_users: true
```

### Maintenance Page

```yaml
maintenance_page:
  features:
    - countdown_timer: true
    - subscribe_for_updates: true
    - status_updates: true
    - custom_branding: true
    
  design:
    - logo: true
    - background: true
    - message: true
    - social_links: true
```

## System Settings

### Cache Configuration

```yaml
cache_settings:
  driver: "redis"
  prefix: "gsmui_"
  ttl: 3600
  
  stores:
    - file
    - database
    - redis
    - memcached
```

### Queue Configuration

```yaml
queue_settings:
  driver: "redis"
  connection: "default"
  queue: "default"
  retry_after: 90
  
  workers:
    - queue: "high"
      connection: "redis"
      max_time: 3600
      
    - queue: "default"
      connection: "redis"
      max_time: 3600
      
    - queue: "low"
      connection: "redis"
      max_time: 3600
```

### Session Configuration

```yaml
session_settings:
  driver: "redis"
  lifetime: 120
  expire_on_close: false
  encrypt: true
  
  cookie:
    name: "gsmui_session"
    path: "/"
    domain: null
    secure: true
    httponly: true
    samesite: "lax"
```

## Integration Points

- **Health**: System health monitoring
- **Monitoring**: System monitoring
- **Dashboard**: Platform metrics
- **Settings**: Configuration management
- **Security**: Security settings

## API Reference

### Get Settings

```http
GET /api/admin/settings
```

### Update Settings

```http
PUT /api/admin/settings
Content-Type: application/json

{
  "site_name": "My Platform",
  "timezone": "America/New_York"
}
```

### Toggle Feature

```http
POST /api/admin/settings/features/{feature}/toggle
```

### Enable Maintenance Mode

```http
POST /api/admin/settings/maintenance/enable
Content-Type: application/json

{
  "message": "Scheduled maintenance",
  "retry_after": 60
}
```

### Disable Maintenance Mode

```http
POST /api/admin/settings/maintenance/disable
```

## Performance

| Metric | Target |
|--------|--------|
| Settings load | < 500ms |
| Save settings | < 1s |
| Feature toggle | < 100ms |
| Maintenance enable | < 2s |
| Cache clear | < 1s |

## Security

| Measure | Description |
|---------|-------------|
| Access control | Role-based settings access |
| Audit logging | Track all setting changes |
| Backup | Automatic settings backup |
| Validation | Input validation |
| Encryption | Sensitive data encryption |