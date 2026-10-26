# Favorites/Wishlist

Saved items management with collections, price alerts, and shareable lists.

## Overview

Favorites/Wishlist provides users with a personalized space to save, organize, and track products they're interested in, with features for collections, price alerts, and sharing.

## Saved Items

### Item Properties

| Property | Description |
|----------|-------------|
| Product | Product name |
| Price | Current price |
| Creator | Product creator |
| Category | Product category |
| Date Added | When saved |
| Price History | Price changes |
| Availability | Stock status |

### Saved Items List

```yaml
saved_items:
  columns:
    - product: "Product"
    - price: "Price"
    - creator: "Creator"
    - date_added: "Added"
    - actions: "Actions"
    
  features:
    - search: true
    - filter_by_category: true
    - filter_by_price: true
    - sort_by_date: true
    - sort_by_price: true
    - grid_view: true
    - list_view: true
    
  filters:
    - category:
        options: ["components", "templates", "themes"]
    - price_range:
        min: 0
        max: 1000
    - availability:
        options: ["in_stock", "out_of_stock", "all"]
```

### Item Actions

| Action | Description |
|--------|-------------|
| View | See product details |
| Buy | Purchase item |
| Remove | Remove from favorites |
| Move | Move to collection |
| Share | Share item |

## Collections

### Collection Properties

| Property | Description |
|----------|-------------|
| Name | Collection name |
| Description | Collection description |
| Items | Saved items count |
| Created | Creation date |
| Updated | Last modification |
| Visibility | Public, private |

### Collection Management

```yaml
collection_management:
  operations:
    - create: "Create new collection"
    - edit: "Edit collection details"
    - delete: "Delete collection"
    - share: "Share collection"
    - merge: "Merge collections"
    
  features:
    - drag_drop: true
    - bulk_move: true
    - bulk_delete: true
    - import: true
    - export: true
```

### Collection Display

```yaml
collection_display:
  columns:
    - name: "Name"
    - items: "Items"
    - created: "Created"
    - visibility: "Visibility"
    - actions: "Actions"
    
  features:
    - create_collection: true
    - edit_collection: true
    - delete_collection: true
```

### Collection Items

```yaml
collection_items:
  display:
    - grid_view: true
    - list_view: true
    - detail_view: true
    
  features:
    - add_items: true
    - remove_items: true
    - reorder_items: true
    - move_items: true
```

## Price Alerts

### Alert Types

| Type | Description |
|------|-------------|
| Price Drop | Alert when price decreases |
| Back in Stock | Alert when item available |
| Sale | Alert when item on sale |
| New Version | Alert when updated |

### Alert Configuration

```yaml
price_alerts:
  types:
    - price_drop:
        threshold: "10%"
        frequency: "immediate"
        
    - back_in_stock:
        frequency: "immediate"
        
    - sale:
        threshold: "20%"
        frequency: "daily"
        
  options:
    - email_notification: true
    - push_notification: true
    - in_app_notification: true
```

### Alert Management

```yaml
alert_management:
  operations:
    - create_alert: "Set price alert"
    - edit_alert: "Modify alert settings"
    - delete_alert: "Remove price alert"
    - view_alerts: "See all active alerts"
    
  features:
    - bulk_create: true
    - bulk_delete: true
    - alert_history: true
```

### Alert Display

```yaml
alert_display:
  columns:
    - product: "Product"
    - type: "Alert Type"
    - threshold: "Threshold"
    - status: "Status"
    - actions: "Actions"
    
  features:
    - edit_alert: true
    - delete_alert: true
    - view_history: true
```

## Share Lists

### Sharing Options

| Option | Description |
|--------|-------------|
| Public Link | Shareable URL |
| Private Link | Password-protected |
| Email Share | Send via email |
| Social Share | Share on social media |

### Share Configuration

```yaml
share_configuration:
  options:
    - public_link: true
    - private_link: true
    - email_share: true
    - social_share: true
    
  settings:
    - require_password: false
    - expiration_days: 30
    - view_count_limit: 1000
```

### Share Features

```yaml
share_features:
  options:
    - generate_link: true
    - copy_link: true
    - qr_code: true
    - embed_code: true
    
  permissions:
    - view_only: true
    - allow_purchase: true
    - show_prices: true
```

### Share Display

```yaml
share_display:
  features:
    - share_button: true
    - copy_link: true
    - qr_code: true
    - social_icons: true
    
  social_platforms:
    - twitter: true
    - facebook: true
    - linkedin: true
    - pinterest: true
```

## Favorites Analytics

### Usage Metrics

| Metric | Description |
|--------|-------------|
| Total Favorites | Items saved |
| Collections | Number of collections |
| Price Alerts | Active alerts |
| Shared Lists | Shared collections |

### Analytics Dashboard

```yaml
favorites_analytics:
  metrics:
    - total_favorites
    - total_collections
    - total_alerts
    - total_shares
    
  charts:
    - favorites_over_time
    - price_changes
    - alert_notifications
    
  insights:
    - most_favorited_categories
    - price_trends
    - alert_effectiveness
```

## Integration Points

- **Orders**: Purchase from favorites
- **Downloads**: Download purchased favorites
- **Marketplace**: Browse marketplace
- **Dashboard**: Favorites overview
- **Settings**: Favorites preferences

## API Reference

### List Favorites

```http
GET /api/user/favorites?category=components&limit=20
```

### Add to Favorites

```http
POST /api/user/favorites
Content-Type: application/json

{
  "product_id": "abc123",
  "collection": "My Collection"
}
```

### Remove from Favorites

```http
DELETE /api/user/favorites/{product_id}
```

### List Collections

```http
GET /api/user/favorites/collections
```

### Create Collection

```http
POST /api/user/favorites/collections
Content-Type: application/json

{
  "name": "My Collection",
  "description": "Favorite components",
  "visibility": "private"
}
```

### Create Price Alert

```http
POST /api/user/favorites/alerts
Content-Type: application/json

{
  "product_id": "abc123",
  "type": "price_drop",
  "threshold": "10%"
}
```

### Share Favorites

```http
POST /api/user/favorites/share
Content-Type: application/json

{
  "collection_id": "xyz789",
  "visibility": "public"
}
```

## Performance

| Metric | Target |
|--------|--------|
| Favorites load | < 500ms |
| Collection load | < 300ms |
| Price alert check | < 1 second |
| Share link generation | < 500ms |
| Search response | < 200ms |

## Browser Support

Full support in all modern browsers. Price alerts require background processing.