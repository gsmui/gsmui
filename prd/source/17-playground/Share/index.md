---
title: "Sharing"
description: "Share playground creations through URLs and embed snippets"
volume: "17"
---

# Sharing

Share your playground creations through URLs, embed snippets, and controlled access for collaboration and demonstration.

## Overview

The Sharing system enables distribution of playground projects, components, and code snippets through various channels. It includes access control, expiration, and analytics to track engagement.

## Shareable URLs

### URL Structure

```
https://playground.gsmui.dev/share/{share_id}
```

### URL Features

| Feature | Description |
|---------|-------------|
| Permanent links | Stay valid indefinitely (until deleted) |
| Expiring links | Auto-expire after set duration |
| Password protection | Require password to access |
| View-only mode | Prevent editing by viewers |
| Fork enabled | Allow viewers to create copies |

### URL Configuration

```yaml
sharing:
  urls:
    base: "https://playground.gsmui.dev/share"
    length: 12
    charset: "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789"
    
  options:
    default_expiry: "30d"
    max_expiry: "365d"
    password_min_length: 8
    max_views: 10000
```

## Embed Snippets

### Embed Types

| Type | Description | Use Case |
|------|-------------|----------|
| iframe | Full preview embed | Blog posts, documentation |
| code block | Syntax-highlighted code | Forums, wikis |
| live editor | Interactive playground | Tutorials, courses |
| component | Rendered component | Demo pages |

### iframe Embed Code

```html
<iframe 
  src="https://playground.gsmui.dev/embed/{share_id}"
  width="100%" 
  height="500"
  frameborder="0"
  allowfullscreen>
</iframe>
```

### Embed Configuration

```yaml
embed:
  options:
    width: "100%"
    height: 500
    theme: "auto"
    allow: "fullscreen"
    sandbox: "allow-scripts allow-same-origin"
    
  preview:
    show_header: true
    show_footer: true
    show_code: true
    show_preview: true
    
  styling:
    border_radius: "8px"
    shadow: "0 4px 6px rgba(0,0,0,0.1)"
    background: "#ffffff"
```

## Access Control

### Permission Levels

| Level | Description | Capabilities |
|-------|-------------|--------------|
| Public | Anyone with link | View, fork |
| Unlisted | Link holders only | View, fork |
| Private | Invited users only | View, edit, fork |
| Restricted | Specific users | Custom permissions |

### User Roles

```yaml
roles:
  viewer:
    - view_code
    - view_preview
    - download_single_file
    
  editor:
    - all_viewer_permissions
    - edit_files
    - save_changes
    
  admin:
    - all_editor_permissions
    - manage_sharing
    - delete_project
    - manage_collaborators
    
  owner:
    - all_admin_permissions
    - transfer_ownership
    - delete_project
```

### Access Control Lists

```yaml
acl:
  rules:
    - user: "user@example.com"
      role: "editor"
      expires: "2024-12-31"
      
    - team: "design-team"
      role: "viewer"
      
    - domain: "@company.com"
      role: "editor"
```

## Expiration Settings

### Expiration Options

| Duration | Use Case |
|----------|----------|
| 1 hour | Quick demo sharing |
| 24 hours | Day-long collaboration |
| 7 days | Week-long review |
| 30 days | Default sharing period |
| 90 days | Long-term projects |
| Never | Permanent sharing |

### Expiration Behavior

```yaml
expiration:
  actions:
    on_expire:
      - show_message: "This share link has expired"
      - offer_renewal: true
      - notify_owner: true
      
    before_expire:
      - days: 7
        action: "email_warning"
      - days: 1
        action: "email_warning"
        
  renewal:
    allowed: true
    max_renewals: 5
    renewal_period: "30d"
```

## Share Analytics

### Tracked Metrics

| Metric | Description |
|--------|-------------|
| Views | Total page views |
| Unique visitors | Distinct user sessions |
| Forks | Number of times forked |
| Downloads | Export/download count |
| Time spent | Average session duration |
| Device types | Desktop, mobile, tablet |
| Geographic | Visitor locations |

### Analytics Dashboard

```yaml
analytics:
  display:
    - views_over_time
    - visitor_map
    - device_breakdown
    - referrer_sources
    - engagement_timeline
    
  retention:
    - return_visits
    - average_session_length
    - pages_per_visit
    
  export:
    format: "csv"
    date_range: "last_30_days"
```

## Collaboration Features

### Real-Time Collaboration

| Feature | Description |
|---------|-------------|
| Live cursors | See other users' cursors |
| Presence indicators | Who's currently viewing |
| Conflict resolution | Merge simultaneous edits |
| Version history | Track all changes |
| Comments | Inline code comments |

### Collaboration Settings

```yaml
collaboration:
  max_collaborators: 10
  permissions:
    can_edit: true
    can_comment: true
    can_view_history: true
    can_export: true
    
  notifications:
    on_join: true
    on_edit: true
    on_comment: true
    on_leave: true
```

## Share Management

### Share List

| Column | Description |
|--------|-------------|
| Share ID | Unique identifier |
| Title | Project/component name |
| Created | Creation timestamp |
| Expires | Expiration date |
| Views | Total view count |
| Status | Active, expired, revoked |

### Bulk Operations

```yaml
bulk_operations:
  actions:
    - expire_selected
    - delete_selected
    - export_analytics
    - change_permissions
    
  selection:
    max_items: 100
    filters:
      - by_status
      - by_date
      - by_views
```

## Social Sharing

### Supported Platforms

| Platform | Share Type |
|----------|------------|
| Twitter/X | Preview card with link |
| LinkedIn | Professional sharing |
| Facebook | Open Graph preview |
| Slack | Rich embed |
| Discord | Code block preview |
| Email | Formatted HTML email |

### Open Graph Tags

```html
<meta property="og:title" content="{component_name}">
<meta property="og:description" content="gsmui component preview">
<meta property="og:image" content="{preview_screenshot}">
<meta property="og:url" content="{share_url}">
<meta property="og:type" content="website">
```

## API Reference

### Create Share

```http
POST /api/shares
Content-Type: application/json

{
  "project_id": "abc123",
  "expires_at": "2024-12-31",
  "password": "optional_password",
  "permissions": ["view", "fork"]
}
```

### Update Share

```http
PUT /api/shares/{share_id}
Content-Type: application/json

{
  "expires_at": "2025-01-31",
  "permissions": ["view"]
}
```

### Delete Share

```http
DELETE /api/shares/{share_id}
```

## Privacy & Security

### Security Measures

| Measure | Description |
|---------|-------------|
| Rate limiting | 100 requests/minute per IP |
| IP blocking | Block suspicious activity |
| Content scanning | Malware detection |
| XSS prevention | Input sanitization |
| CSRF protection | Token validation |

### Privacy Controls

```yaml
privacy:
  options:
    - anonymous_viewing: true
    - tracking_enabled: false
    - data_retention: "90d"
    - gdpr_compliance: true
    
  data_collection:
    - ip_address: "hashed"
    - user_agent: "stored"
    - location: "country_only"
    - behavior: "anonymized"
```

## Integration Points

- **Export**: Generate shareable export links
- **Templates**: Share template implementations
- **Projects**: Share entire project states
- **Collaboration**: Real-time shared editing
- **Analytics**: Track share performance

## Error Handling

| Error | Solution |
|-------|----------|
| Share not found | Check share ID validity |
| Access denied | Verify permissions |
| Expired link | Request renewal |
| Rate limited | Wait and retry |
| Invalid password | Verify password |

## Testing

| Test Type | Description |
|-----------|-------------|
| Unit tests | Share creation logic |
| Integration tests | Access control |
| Performance tests | High traffic scenarios |
| Security tests | Permission bypass attempts |
| UI tests | Share interface |

## Edge Cases

| Scenario | Handling |
|----------|----------|
| Concurrent share creation | UUID deduplication |
| Password brute force | Rate limiting |
| Expired links | Graceful redirect |
| Large shared projects | Lazy loading |
| Mobile sharing | Responsive embeds |
| Deep linking | URL scheme handling