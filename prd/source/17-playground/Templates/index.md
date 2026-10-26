---
title: "Playground Templates"
description: "Pre-built component templates and project starters"
volume: "17"
---

# Playground Templates

Pre-built component templates and project starters to accelerate development and ensure consistency across projects.

## Overview

Templates provide ready-to-use implementations of common patterns and components. They follow gsmui best practices and can be customized to fit specific needs.

## Starter Templates

### Available Starters

| Template | Description | Use Case |
|----------|-------------|----------|
| Basic Component | Minimal Livewire component | Learning, simple widgets |
| Form Component | Input with validation | Contact forms, surveys |
| Modal Dialog | Accessible modal | Confirmations, details |
| Data Table | Sortable, filterable table | Admin dashboards |
| Dashboard | Stats cards layout | Analytics pages |
| Auth Forms | Login/register forms | Authentication flows |
| Settings Page | User preferences | Account management |
| Landing Page | Marketing page | Product pages |

### Starter Template Structure

```
starter-template/
├── app/
│   └── Http/
│       └── Livewire/
│           └── Components/
│               └── {ComponentName}.php
├── resources/
│   └── views/
│       └── livewire/
│           └── {component-name}.blade.php
├── routes/
│   └── web.php
├── composer.json
├── package.json
├── tailwind.config.js
└── README.md
```

## Component Examples

### Form Components

| Component | Features |
|-----------|----------|
| Contact Form | Name, email, message with validation |
| Login Form | Email/password with remember me |
| Registration Form | Full registration with terms |
| Search Form | Autocomplete with filters |
| Upload Form | Drag-drop with preview |
| Multi-step Form | Wizard with validation |

### Display Components

| Component | Features |
|-----------|----------|
| User Profile | Avatar, info, actions |
| Product Card | Image, price, quick actions |
| Stats Widget | Numbers, trends, charts |
| Timeline | Chronological events |
| Notification List | Read/unread states |
| Comment Thread | Nested replies |

### Navigation Components

| Component | Features |
|-----------|----------|
| Sidebar Menu | Collapsible, active states |
| Breadcrumbs | Hierarchical navigation |
| Tabs | Vertical/horizontal tabs |
| Pagination | Page numbers, size selector |
| Step Progress | Multi-step indicator |
| Search Results | Filtered, sorted results |

## Full-Page Templates

### Admin Dashboard

```yaml
admin_dashboard:
  sections:
    - header: "Navigation bar with user menu"
    - sidebar: "Collapsible navigation"
    - main:
        - stats: "KPI cards row"
        - charts: "Revenue, users graphs"
        - table: "Recent orders"
        - activity: "Latest activity feed"
  features:
    - responsive_layout
    - dark_mode_toggle
    - notification_center
    - quick_actions
```

### E-commerce Product Page

```yaml
product_page:
  sections:
    - header: "Search, cart, user"
    - breadcrumbs: "Category > Product"
    - hero: "Product images carousel"
    - details: "Title, price, options"
    - description: "Rich text content"
    - reviews: "Star rating, comments"
    - related: "Similar products"
  features:
    - image_zoom
    - add_to_cart
    - wishlist
    - share_buttons
```

### Landing Page

```yaml
landing_page:
  sections:
    - hero: "Headline, CTA, background"
    - features: "3-column feature grid"
    - testimonials: "Customer quotes"
    - pricing: "Plan comparison table"
    - faq: "Accordion questions"
    - footer: "Links, newsletter signup"
  features:
    - scroll_animations
    - sticky_header
    - mobile_menu
    - newsletter_form
```

## Template Customization

### Customization Options

| Option | Description |
|--------|-------------|
| Colors | Primary, secondary, accent colors |
| Typography | Font family, sizes, weights |
| Spacing | Margins, padding, gaps |
| Borders | Radius, width, color |
| Shadows | Elevation levels |
| Icons | Icon library selection |

### Theme Integration

```yaml
template_customization:
  colors:
    primary: "var(--gsmui-primary)"
    secondary: "var(--gsmui-secondary)"
    accent: "var(--gsmui-accent)"
    background: "var(--gsmui-bg)"
    text: "var(--gsmui-text)"
    
  typography:
    heading_font: "Inter, sans-serif"
    body_font: "Inter, sans-serif"
    mono_font: "Fira Code, monospace"
    
  spacing:
    container: "max-w-7xl mx-auto"
    section: "py-16"
    component: "p-6"
```

### Prop Customization

```yaml
component_props:
  data_table:
    columns:
      - key: "name"
        label: "Name"
        sortable: true
      - key: "email"
        label: "Email"
        sortable: true
      - key: "role"
        label: "Role"
        filterable: true
        
    actions:
      - edit
      - delete
      - view
      
    pagination:
      per_page: 10
      per_page_options: [5, 10, 25, 50]
```

## Template Categories

### By Component Type

| Category | Templates |
|----------|-----------|
| Forms | Contact, login, register, search, upload |
| Data Display | Table, list, cards, stats, timeline |
| Navigation | Menu, tabs, breadcrumbs, pagination |
| Feedback | Modal, toast, alert, progress |
| Layout | Dashboard, sidebar, header, footer |
| Content | Blog post, article, profile, settings |

### By Industry

| Industry | Templates |
|----------|-----------|
| SaaS | Dashboard, settings, billing, analytics |
| E-commerce | Product, cart, checkout, orders |
| Healthcare | Patient form, appointment, records |
| Education | Course, quiz, progress, certificates |
| Finance | Account, transactions, reports |
| Portfolio | Projects, about, contact |

### By Complexity

| Level | Description |
|-------|-------------|
| Beginner | Simple components, minimal logic |
| Intermediate | Forms with validation, basic state |
| Advanced | Complex interactions, API integration |
| Expert | Full applications, multiple components |

## Template Features

### Built-in Features

| Feature | Description |
|---------|-------------|
| Validation | Laravel validation rules |
| Accessibility | ARIA attributes, keyboard nav |
| Responsive | Mobile-first design |
| Dark mode | Theme switching support |
| Loading states | Skeleton, spinner, progress |
| Error handling | Graceful error states |
| Empty states | No data placeholders |
| Animations | Transitions, micro-interactions |

### Code Quality

| Metric | Standard |
|--------|----------|
| PHPStan | Level 8 |
| Laravel Pint | PSR-12 |
| ESLint | Recommended |
| Accessibility | WCAG 2.1 AA |
| Performance | 90+ Lighthouse score |

## Creating Custom Templates

### Template Structure

```yaml
custom_template:
  name: "My Custom Template"
  description: "Template description"
  author: "Your Name"
  version: "1.0.0"
  category: "forms"
  tags: ["contact", "form", "validation"]
  
  files:
    - path: "app/Http/Livewire/Components/ContactForm.php"
      content: "..."
    - path: "resources/views/livewire/contact-form.blade.php"
      content: "..."
      
  dependencies:
    - "livewire/livewire"
    - "gsmui/gsmui"
    
  config:
    tailwind: true
    dark_mode: true
    responsive: true
```

### Publishing Templates

```yaml
publishing:
  requirements:
    - complete_documentation
    - example_usage
    - screenshots
    - video_demo_optional
    
  review:
    - code_quality_check
    - accessibility_audit
    - security_scan
    - performance_test
    
  distribution:
    - marketplace_listing
    - github_release
    - npm_package
```

## Integration Points

- **Export**: Templates as export presets
- **Share**: Share template implementations
- **AI Assistant**: AI-enhanced template customization
- **Projects**: Template-based project creation
- **Snippets**: Template code snippets

## Performance

| Metric | Target |
|--------|--------|
| Template load | < 100ms |
| Preview render | < 500ms |
| Template search | < 200ms |
| Template apply | < 1s |
| Max template size | 1MB |

## Browser Support

Full support in all modern browsers. Templates use standard web technologies with no browser-specific requirements.

## Security

| Measure | Description |
|---------|-------------|
| Template validation | Verify template integrity |
| Code scanning | Detect malicious patterns |
| Permission controls | Template access management |
| Version pinning | Prevent template tampering |
| Audit logging | Track template usage |

## Testing

| Test Type | Description |
|-----------|-------------|
| Unit tests | Template rendering |
| Integration tests | Template application |
| Performance tests | Template load time |
| Security tests | Malicious template detection |
| Compatibility tests | Cross-browser rendering |

## Edge Cases

| Scenario | Handling |
|----------|----------|
| Corrupted templates | Fallback to defaults |
| Missing dependencies | Partial template apply |
| Version conflicts | Graceful degradation |
| Large templates | Progressive loading |
| Custom configurations | Template merging |
| Invalid syntax | Error messages with suggestions