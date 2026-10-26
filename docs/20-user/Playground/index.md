# User Playground

Personal playground management with saved projects, templates, recent edits, and fork history.

## Overview

User Playground provides a personalized workspace for managing playground projects, templates, recent work, and forked projects.

## Saved Projects

### Project Properties

| Property | Description |
|----------|-------------|
| Name | Project name |
| Description | Brief description |
| Created | Creation date |
| Updated | Last modification |
| Files | File count |
| Size | Project size |
| Status | Active, archived |

### Project List

```yaml
project_list:
  columns:
    - name: "Name"
    - description: "Description"
    - files: "Files"
    - updated: "Last Updated"
    - actions: "Actions"
    
  features:
    - search: true
    - filter_by_status: true
    - sort_by_name: true
    - sort_by_updated: true
    - grid_view: true
    - list_view: true
    
  filters:
    - status:
        options: ["active", "archived", "all"]
    - date_range:
        options: ["7d", "30d", "90d", "all"]
```

### Project Actions

| Action | Description |
|--------|-------------|
| Open | Open in playground |
| Edit | Edit project details |
| Duplicate | Create a copy |
| Archive | Move to archive |
| Delete | Remove project |
| Share | Share project |
| Export | Download project |

### Project Management

```yaml
project_management:
  operations:
    - create_project: "Create new project"
    - edit_project: "Edit project details"
    - archive_project: "Archive project"
    - delete_project: "Delete project"
    
  features:
    - drag_drop: true
    - bulk_operations: true
    - project_templates: true
```

## Templates

### Template Categories

| Category | Description |
|----------|-------------|
| Starter | Basic project templates |
| Components | Component examples |
| Full-page | Complete page layouts |
| Custom | User-created templates |

### Template List

```yaml
template_list:
  columns:
    - name: "Name"
    - category: "Category"
    - description: "Description"
    - uses: "Uses"
    - actions: "Actions"
    
  features:
    - search: true
    - filter_by_category: true
    - sort_by_uses: true
    - preview: true
    
  filters:
    - category:
        options: ["starter", "components", "full-page", "custom"]
```

### Template Actions

| Action | Description |
|--------|-------------|
| Use | Create project from template |
| Preview | Preview template |
| Edit | Edit template |
| Duplicate | Copy template |
| Delete | Remove template |
| Share | Share template |

### Template Management

```yaml
template_management:
  operations:
    - create_template: "Save project as template"
    - edit_template: "Edit template details"
    - delete_template: "Delete template"
    
  features:
    - template_preview: true
    - template_variables: true
    - template_sharing: true
```

## Recent Edits

### Edit History

| Property | Description |
|----------|-------------|
| Project | Project name |
| File | File edited |
| Date | Edit timestamp |
| Changes | Change summary |

### Recent Edits List

```yaml
recent_edits:
  columns:
    - project: "Project"
    - file: "File"
    - date: "Date"
    - changes: "Changes"
    - actions: "Actions"
    
  features:
    - search: true
    - filter_by_project: true
    - sort_by_date: true
    
  filters:
    - project:
        options: ["all"]
    - date_range:
        options: ["24h", "7d", "30d", "all"]
```

### Edit Actions

| Action | Description |
|--------|-------------|
| Open | Open file in editor |
| View Changes | See diff |
| Restore | Restore previous version |
| Delete | Remove from history |

### Edit History Management

```yaml
edit_history:
  features:
    - version_history: true
    - diff_view: true
    - restore_version: true
    - compare_versions: true
    
  retention:
    - keep_history: true
    - retention_days: 90
    - max_versions: 50
```

## Fork History

### Fork Properties

| Property | Description |
|----------|-------------|
| Original | Original project |
| Forked From | Fork source |
| Date | Fork date |
| Changes | Modifications made |
| Status | Active, archived |

### Fork History List

```yaml
fork_history:
  columns:
    - original: "Original Project"
    - forked_from: "Forked From"
    - date: "Date"
    - changes: "Changes"
    - actions: "Actions"
    
  features:
    - search: true
    - filter_by_date: true
    - sort_by_date: true
    
  filters:
    - date_range:
        options: ["30d", "90d", "1y", "all"]
```

### Fork Actions

| Action | Description |
|--------|-------------|
| Open | Open forked project |
| View Original | View source project |
| Compare | Compare with original |
| Sync | Sync with original |
| Delete | Remove fork |

### Fork Management

```yaml
fork_management:
  features:
    - fork_tracking: true
    - original_linking: true
    - sync_capability: true
    
  operations:
    - fork_project: "Fork existing project"
    - sync_fork: "Sync with original"
    - compare_forks: "Compare forks"
```

## Playground Settings

### User Preferences

| Setting | Description |
|---------|-------------|
| Default Theme | Editor theme |
| Font Size | Editor font size |
| Tab Size | Indentation spaces |
| Auto-save | Auto-save frequency |
| Keybindings | Keyboard shortcuts |

### Settings Form

```yaml
playground_settings:
  sections:
    - editor:
        - theme: "dark"
        - font_size: 14
        - tab_size: 4
        - word_wrap: true
        - auto_save: true
        - auto_save_interval: "30s"
        
    - keybindings:
        - preset: "default"
        - custom_shortcuts: {}
        
    - general:
        - show_line_numbers: true
        - highlight_active_line: true
        - auto_complete: true
```

### Settings Management

```yaml
settings_management:
  features:
    - import_settings: true
    - export_settings: true
    - reset_settings: true
    
  sync:
    - cloud_sync: true
    - cross_device: true
```

## Playground Storage

### Storage Usage

| Metric | Description |
|--------|-------------|
| Projects | Total projects |
| Templates | Saved templates |
| Storage Used | Total storage |
| Storage Limit | Maximum storage |

### Storage Display

```yaml
storage_display:
  metrics:
    - total_projects
    - total_templates
    - storage_used
    - storage_limit
    
  charts:
    - storage_over_time
    - projects_by_size
    
  features:
    - storage_alerts: true
    - cleanup_suggestions: true
```

### Storage Management

```yaml
storage_management:
  features:
    - usage_monitoring: true
    - cleanup_tools: true
    - archive_old_projects: true
    
  limits:
    - free_tier: "500MB"
    - pro_tier: "5GB"
    - team_tier: "50GB"
```

## Integration Points

- **Code Editor**: Edit playground files
- **Live Preview**: Preview projects
- **Share**: Share playground projects
- **Export**: Download projects
- **Templates**: Template management
- **Collaboration**: Collaborative editing

## API Reference

### List Projects

```http
GET /api/user/playground/projects?status=active&limit=20
```

### Get Project Details

```http
GET /api/user/playground/projects/{id}
```

### Create Project

```http
POST /api/user/playground/projects
Content-Type: application/json

{
  "name": "My Project",
  "template": "basic-component"
}
```

### List Templates

```http
GET /api/user/playground/templates?category=starter&limit=20
```

### List Recent Edits

```http
GET /api/user/playground/recent?limit=20
```

### List Fork History

```http
GET /api/user/playground/forks?limit=20
```

## Performance

| Metric | Target |
|--------|--------|
| Project list load | < 500ms |
| Template list load | < 300ms |
| Recent edits load | < 200ms |
| Fork history load | < 300ms |
| Project creation | < 1 second |

## Browser Support

Full support in all modern browsers. Playground features require JavaScript enabled.