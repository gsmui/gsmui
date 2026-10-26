---
title: Template Marketplace
description: Page templates, starter kits, demo preview, and one-click install.
order: 15.3
group: Marketplace Templates
---

# Template Marketplace

The GsmUi Template Marketplace provides pre-built page and application templates for rapid development.

## Template Types

| Type | Description | Price Range |
|---|---|---|
| Page Template | Single page layouts | $5–$25 |
| Starter Kit | Complete app scaffold | $25–$79 |
| Section Kit | Reusable page sections | $15–$49 |
| Email Template | Transactional emails | $10–$30 |
| Dashboard Kit | Admin dashboard layouts | $39–$99 |

## Template Listings

### Listing Display

```
┌─────────────────────────────────────────────┐
│ 📄 SaaS Dashboard Kit                       │
│ by AppTemplates ⭐⭐⭐⭐⭐ (4.9)           │
├─────────────────────────────────────────────┤
│ [Screenshot Grid]                           │
│                                             │
│ Complete admin dashboard with 20+ pages.    │
│ Includes auth, settings, analytics, and     │
│ user management layouts.                    │
│                                             │
│ $69.00  |  [Live Demo]  |  [Buy]           │
│                                             │
│ ✓ 20+ pages  ✓ Dark mode  ✓ Responsive     │
│ ✓ TypeScript  ✓ Tests  ✓ Documentation     │
└─────────────────────────────────────────────┘
```

### Template Metadata

| Field | Description |
|---|---|
| `name` | Template name |
| `type` | Template type |
| `pages` | Number of pages |
| `components` | Components used |
| `features` | Feature list |
| `screenshots` | Preview images |

## Demo Preview

### Preview Interface

```blade
<x-gsmui:template-preview
    :template="$template"
    :demo-url="$template['demo_url']"
    :screenshots="$template['screenshots']"
/>
```

### Preview Features

| Feature | Description |
|---|---|
| Live demo | Interactive preview |
| Screenshot gallery | Multiple views |
| Code preview | Browse template code |
| Responsive test | Test viewports |
| Dark mode toggle | Preview theme |

### Preview Layout

```
┌─────────────────────────────────────────────┐
│ Template Preview: SaaS Dashboard            │
├──────────┬──────────────────────────────────┤
│ Desktop  │ [Live Preview]                   │
│ Tablet   │                                  │
│ Mobile   │                                  │
├──────────┴──────────────────────────────────┤
│ [Screenshots]  [Code]  [Components]         │
└─────────────────────────────────────────────┘
```

## One-Click Install

### Install Process

```
Click "Buy" or "Install Free"
    ↓
Confirm installation
    ↓
Select project directory
    ↓
Download template files
    ↓
Copy to project
    ↓
Install dependencies
    ↓
Run setup commands
    ↓
Template ready
```

### Install Dialog

```blade
<x-gsmui:template-install
    :template="$template"
    wire:model="showInstall"
>
    <gsmui:form-field
        name="projectPath"
        label="Project Path"
        placeholder="/path/to/your/project"
        required
    />

    <gsmui:form-field
        name="installType"
        type="select"
        label="Install Mode"
        :options="[
            'full' => 'Full install (all pages)',
            'selective' => 'Choose pages',
            'reference' => 'Reference only',
        ]"
    />
</x-gsmui:template-install>
```

### Install Options

| Option | Description |
|---|---|
| Full install | Copy all template files |
| Selective | Choose which pages to install |
| Reference | Link without copying |
| Merge | Add to existing project |

## Starter Kits

### Kit Contents

| Item | Description |
|---|---|
| Pages | Complete page templates |
| Components | Reusable UI components |
| Layouts | Page layout templates |
| Config | Configuration files |
| Assets | Images, fonts, icons |
| Documentation | Setup guide |

### Starter Kit Structure

```
saas-dashboard-kit/
├── resources/
│   ├── views/
│   │   ├── layouts/
│   │   ├── pages/
│   │   └── components/
│   └── css/
├── app/
│   ├── Http/
│   │   └── Livewire/
│   └── Models/
├── routes/
├── database/
│   └── migrations/
├── tests/
├── README.md
└── composer.json
```

### Kit Categories

| Category | Examples |
|---|---|
| SaaS | Dashboard, settings, billing |
| E-commerce | Product pages, cart, checkout |
| Portfolio | Projects, blog, contact |
| Admin | CRUD, user management, reports |
| Marketing | Landing page, pricing, features |

## Page Templates

### Page Types

| Type | Pages Included |
|---|---|
| Auth | Login, register, forgot password, reset |
| Dashboard | Overview, analytics, reports |
| Settings | Profile, security, notifications |
| CRUD | List, create, edit, view |
| Marketing | Landing, pricing, features, FAQ |

### Page Template Schema

```json
{
  "id": "dashboard-overview",
  "name": "Dashboard Overview",
  "type": "dashboard",
  "route": "/dashboard",
  "components": ["card", "table", "chart", "stat"],
  "files": [
    "resources/views/pages/dashboard.blade.php",
    "app/Http/Livewire/Dashboard.php"
  ]
}
```

## Template Management

### Installed Templates

| Action | Description |
|---|---|
| Update | Apply template updates |
| Remove | Delete template files |
| Customize | Modify template |
| Revert | Restore original |

### Template Conflicts

| Conflict Type | Resolution |
|---|---|
| File exists | Prompt overwrite/skip/merge |
| Route exists | Prompt rename/skip |
| Component exists | Prompt override/skip |

## Quality Standards

### Template Requirements

| Requirement | Standard |
|---|---|
| Responsive | Mobile-first design |
| Accessible | WCAG 2.1 AA |
| Performant | < 3s load time |
| Documented | README + code comments |
| Tested | 80%+ coverage |

### Quality Checklist

```
□ Responsive on mobile, tablet, desktop
□ Dark mode support
□ Accessible (keyboard, screen reader)
□ No console errors
□ Valid HTML
□ Optimized images
□ Clean code (PSR-12)
□ Complete documentation
□ Working demo
□ Install script
```
