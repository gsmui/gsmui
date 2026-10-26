# Admin Dashboard

Comprehensive admin dashboard with KPI widgets, charts, recent activity, quick actions, and system status monitoring.

## Overview

The Admin Dashboard provides a centralized view of platform performance, user activity, and system health. It enables administrators to monitor metrics, take quick actions, and identify issues at a glance.

## KPI Widgets

### Available KPIs

| KPI | Description | Update Frequency |
|-----|-------------|------------------|
| Total Users | Registered user count | Real-time |
| Active Users | Users active in last 24h | Real-time |
| Revenue | Total revenue | Daily |
| Orders | Total orders | Real-time |
| Conversion Rate | Visitor to customer | Daily |
| Average Order Value | Revenue per order | Daily |
| Churn Rate | User cancellation rate | Weekly |
| Support Tickets | Open support requests | Real-time |

### Widget Configuration

```yaml
kpi_widgets:
  layout:
    columns: 4
    rows: 2
    responsive:
      mobile: 2
      tablet: 3
      desktop: 4
      
  widgets:
    - id: "total_users"
      title: "Total Users"
      type: "counter"
      data_source: "users_count"
      icon: "users"
      color: "blue"
      trend: true
      period: "30d"
      
    - id: "revenue"
      title: "Revenue"
      type: "currency"
      data_source: "revenue_total"
      icon: "dollar"
      color: "green"
      trend: true
      comparison: "previous_period"
      
    - id: "conversion_rate"
      title: "Conversion Rate"
      type: "percentage"
      data_source: "conversion_rate"
      icon: "trending-up"
      color: "purple"
      trend: true
      target: 5.0
```

### Widget Features

| Feature | Description |
|---------|-------------|
| Real-time updates | Auto-refresh on data change |
| Trend indicators | Up/down arrows with percentage |
| Comparison | Compare with previous period |
| Drill-down | Click to see detailed view |
| Customization | Drag-drop reordering |

## Charts

### Chart Types

| Type | Use Case |
|------|----------|
| Line | Trends over time |
| Bar | Comparisons between categories |
| Pie/Doughnut | Distribution breakdown |
| Area | Volume over time |
| Scatter | Correlation analysis |
| Heatmap | Activity patterns |

### Chart Configuration

```yaml
charts:
  revenue_chart:
    type: "area"
    title: "Revenue Over Time"
    data_source: "revenue_daily"
    time_range: "30d"
    granularity: "daily"
    show_legend: true
    interactive: true
    
  user_growth:
    type: "line"
    title: "User Growth"
    data_source: "users_daily"
    time_range: "90d"
    show_targets: true
    
  category_distribution:
    type: "doughnut"
    title: "Sales by Category"
    data_source: "sales_by_category"
    show_percentages: true
```

### Chart Features

| Feature | Description |
|---------|-------------|
| Time range selector | 7d, 30d, 90d, 1y, custom |
| Granularity | Hourly, daily, weekly, monthly |
| Export | PNG, SVG, CSV |
| Drill-down | Click to see details |
| Comparison | Compare multiple metrics |
| Forecasting | Predict future trends |

### Chart Interactions

```yaml
interactions:
  hover:
    show_tooltip: true
    highlight_series: true
    
  click:
    drill_down: true
    open_details: true
    
  zoom:
    enable: true
    reset: true
    
  pan:
    enable: true
    momentum: true
```

## Recent Activity

### Activity Types

| Type | Description |
|------|-------------|
| User registration | New user signed up |
| Purchase | Order completed |
| Support ticket | New support request |
| Content publish | New content published |
| System alert | System notification |
| Security event | Security-related event |

### Activity Feed

```yaml
activity_feed:
  display:
    max_items: 50
    show_avatar: true
    show_timestamp: true
    show_description: true
    show_actions: true
    
  filtering:
    - by_type: true
    - by_user: true
    - by_date: true
    
  actions:
    - view_details: true
    - dismiss: true
    - mark_read: true
```

### Activity Configuration

```yaml
activity_config:
  types:
    - name: "user_registration"
      icon: "user-plus"
      color: "blue"
      priority: "normal"
      
    - name: "purchase"
      icon: "shopping-cart"
      color: "green"
      priority: "high"
      
    - name: "support_ticket"
      icon: "question-circle"
      color: "orange"
      priority: "high"
      
  notifications:
    - desktop: true
    - email: true
    - slack: true
```

## Quick Actions

### Available Actions

| Action | Description |
|--------|-------------|
| Create user | Add new user |
| Create product | Add new product |
| Send broadcast | Send platform notification |
| Clear cache | Clear system cache |
| Run backup | Create system backup |
| Toggle maintenance | Enable maintenance mode |

### Action Configuration

```yaml
quick_actions:
  actions:
    - id: "create_user"
      label: "Create User"
      icon: "user-plus"
      permission: "users.create"
      modal: "create_user_form"
      
    - id: "create_product"
      label: "Create Product"
      icon: "package-plus"
      permission: "products.create"
      modal: "create_product_form"
      
    - id: "send_broadcast"
      label: "Send Broadcast"
      icon: "megaphone"
      permission: "broadcasts.create"
      modal: "broadcast_form"
      
  display:
    max_visible: 6
    layout: "grid"
    columns: 3
```

### Action Modal

```yaml
action_modal:
  features:
    - form_validation: true
    - preview: true
    - confirmation: true
    - undo: true
    
  fields:
    - name: "title"
      type: "text"
      required: true
      
    - name: "message"
      type: "textarea"
      required: true
      
    - name: "recipients"
      type: "select"
      options: ["all", "active", "custom"]
```

## System Status

### Status Indicators

| Indicator | Description |
|-----------|-------------|
| CPU Usage | Server CPU utilization |
| Memory Usage | RAM consumption |
| Disk Usage | Storage utilization |
| Database | Database status |
| Cache | Cache system status |
| Queue | Job queue status |
| Mail | Email service status |
| External APIs | Third-party API status |

### Status Dashboard

```yaml
system_status:
  display:
    - cpu_usage:
        type: "gauge"
        thresholds:
          warning: 70
          critical: 90
          
    - memory_usage:
        type: "gauge"
        thresholds:
          warning: 80
          critical: 95
          
    - disk_usage:
        type: "gauge"
        thresholds:
          warning: 75
          critical: 90
          
    - database:
        type: "status"
        check: "connection"
        interval: "60s"
        
    - cache:
        type: "status"
        check: "connection"
        interval: "60s"
        
    - queue:
        type: "status"
        check: "workers"
        interval: "30s"
```

### Status History

```yaml
status_history:
  retention: "30d"
  granularity: "5m"
  metrics:
    - cpu_usage
    - memory_usage
    - disk_usage
    - response_time
    - error_rate
```

### Alerting

```yaml
alerting:
  rules:
    - name: "High CPU Usage"
      condition: "cpu_usage > 90"
      duration: "5m"
      severity: "critical"
      notification: ["email", "slack"]
      
    - name: "Low Disk Space"
      condition: "disk_usage > 85"
      duration: "10m"
      severity: "warning"
      notification: ["email"]
      
    - name: "Database Down"
      condition: "database.status == 'down'"
      duration: "1m"
      severity: "critical"
      notification: ["email", "slack", "sms"]
```

## Dashboard Customization

### Layout Options

```yaml
layout_options:
  widgets:
    - resizable: true
    - draggable: true
    - removable: true
    - configurable: true
    
  presets:
    - name: "Executive"
      widgets: ["revenue", "users", "orders", "conversion"]
      
    - name: "Operations"
      widgets: ["system_status", "queue", "errors", "performance"]
      
    - name: "Marketing"
      widgets: ["traffic", "conversion", "campaigns", "engagement"]
```

### Widget Customization

```yaml
widget_customization:
  options:
    - title: true
    - time_range: true
    - data_source: true
    - visualization: true
    - refresh_rate: true
    
  themes:
    - light
    - dark
    - compact
```

## Integration Points

- **User Management**: Quick user actions
- **Billing**: Revenue and order data
- **Analytics**: Detailed analytics drill-down
- **Settings**: System configuration
- **Health**: System health details
- **Monitoring**: Error and performance monitoring

## API Reference

### Get Dashboard Data

```http
GET /api/admin/dashboard
```

### Get Widget Data

```http
GET /api/admin/dashboard/widgets/{widget_id}
```

### Update Dashboard Layout

```http
PUT /api/admin/dashboard/layout
Content-Type: application/json

{
  "widgets": [
    {"id": "revenue", "position": {"x": 0, "y": 0, "w": 2, "h": 1}},
    {"id": "users", "position": {"x": 2, "y": 0, "w": 1, "h": 1}}
  ]
}
```

### Get Activity Feed

```http
GET /api/admin/dashboard/activity?limit=50&type=purchase
```

## Performance

| Metric | Target |
|--------|--------|
| Dashboard load | < 2 seconds |
| Widget load | < 500ms |
| Chart render | < 300ms |
| Activity feed | < 200ms |
| Auto-refresh | 30 seconds |
| Real-time updates | < 1 second |

## Browser Support

Full support in all modern browsers. Real-time features require WebSocket connection.