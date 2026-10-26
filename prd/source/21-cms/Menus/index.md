# Menu Builder

> PRD — Volume 21: CMS & Content — Menus

## Overview

The Menu Builder provides a drag-and-drop interface for creating and managing navigation menus. It supports multiple menu locations, mega menus for complex navigation structures, responsive mobile menus, and dynamic menu items that auto-update with content changes.

## Objectives

| Goal | Metric | Target |
|------|--------|--------|
| Menu creation time | Time to build a standard nav | < 5 minutes |
| Menu render time | Server-side menu generation | < 10ms |
| Mobile responsiveness | Touch-friendly menu interactions | 100% |
| Dynamic items | Auto-update on content change | Real-time |
| Accessibility | WCAG 2.1 AA compliance | Full |

## Menu Locations

| Location | Description | Default Items |
|----------|-------------|---------------|
| `primary` | Main site navigation | Home, Blog, About, Contact |
| `footer` | Footer navigation links | Privacy, Terms, Sitemap |
| `footer-secondary` | Footer secondary column | Social links |
| `sidebar` | Sidebar navigation | None |
| `mobile` | Mobile slide-out menu | Mirrors `primary` |
| `legal` | Legal pages links | Privacy, Terms, Cookie Policy |
| `social` | Social media links | None |

### Location Registration

```php
// config/menus.php
return [
    'locations' => [
        'primary' => [
            'label' => 'Primary Navigation',
            'description' => 'Main site header navigation',
            'max_depth' => 3,
            'max_items' => 15,
            'supports_mega' => true,
        ],
        'footer' => [
            'label' => 'Footer Navigation',
            'description' => 'Footer links section',
            'max_depth' => 2,
            'max_items' => 20,
            'supports_mega' => false,
        ],
        'mobile' => [
            'label' => 'Mobile Navigation',
            'description' => 'Mobile slide-out menu',
            'max_depth' => 2,
            'max_items' => 25,
            'supports_mega' => false,
        ],
    ],
];
```

## Menu Builder Interface

### Menu Item Properties

| Property | Type | Description |
|----------|------|-------------|
| `id` | `uuid` | Unique identifier |
| `label` | `string` | Display text |
| `url` | `string` | Link URL |
| `type` | `string` | `page`, `post`, `category`, `custom`, `home`, `blog`, `search` |
| `target` | `string` | `_self`, `_blank` |
| `css_class` | `string` | Custom CSS classes |
| `icon` | `string` | Optional icon identifier |
| `children` | `array` | Nested menu items |
| `is_active` | `boolean` | Whether item is active |
| `open_mega` | `boolean` | Open mega menu on hover |
| `mega_width` | `string` | Mega menu width: `narrow`, `wide`, `full` |
| `mega_template` | `string` | Custom mega menu Blade template |

### Menu Item Types

| Type | Description | Auto-Updates |
|------|-------------|-------------|
| `page` | Link to a specific page | Yes — title changes |
| `post` | Link to a specific post | Yes — title changes |
| `category` | Link to a category listing | Yes — post count |
| `collection` | Link to a collection index | Yes — item count |
| `home` | Link to homepage | Never changes |
| `blog` | Link to blog index | Never changes |
| `search` | Link to search page | Never changes |
| `custom` | Custom URL with label | Never changes |
| `divider` | Visual separator | N/A |
| `heading` | Section heading (non-clickable) | N/A |

### Livewire Menu Builder

```php
class MenuBuilder extends Component
{
    public Menu $menu;
    public array $items = [];
    public ?string $editingItemId = null;
    public bool $isDirty = false;

    protected $listeners = [
        'item-added' => 'handleItemAdded',
        'item-removed' => 'handleItemRemoved',
        'item-updated' => 'handleItemUpdated',
        'items-reordered' => 'handleReorder',
    ];

    public function mount(int $menuId): void
    {
        $this->menu = Menu::with('items')->findOrFail($menuId);
        $this->items = $this->menu->items->toArray();
    }

    public function addItem(string $type, ?string $parentId = null, int $position = 0): void
    {
        $item = MenuItemFactory::create($type);
        $item['parent_id'] = $parentId;

        if ($parentId) {
            $this->addChildToParent($parentId, $item, $position);
        } else {
            array_splice($this->items, $position, 0, [$item]);
        }

        $this->isDirty = true;
        $this->editingItemId = $item['id'];
    }

    public function removeItem(string $itemId): void
    {
        $this->items = $this->removeRecursive($this->items, $itemId);
        $this->isDirty = true;
    }

    public function updateItem(string $itemId, array $data): void
    {
        $this->items = $this->updateRecursive($this->items, $itemId, $data);
        $this->isDirty = true;
    }

    public function save(): void
    {
        $this->menu->update(['items' => $this->items]);
        $this->isDirty = false;
        $this->dispatch('menu-saved');
    }
}
```

## Mega Menus

### Mega Menu Layouts

| Layout | Columns | Description |
|--------|---------|-------------|
| `simple` | 1 | Single column of links |
| `2-column` | 2 | Two columns of links |
| `3-column` | 3 | Three columns of links |
| `4-column` | 4 | Four columns of links |
| `featured` | Sidebar + Content | Featured item sidebar with links |
| `image` | Image + Links | Hero image with link columns |

### Mega Menu Schema

```json
{
  "id": "mega-uuid",
  "layout": "3-column",
  "columns": [
    {
      "title": "Products",
      "links": [
        {"label": "Feature A", "url": "/features/a", "description": "Description here"},
        {"label": "Feature B", "url": "/features/b", "description": "Description here"}
      ]
    },
    {
      "title": "Resources",
      "links": [
        {"label": "Documentation", "url": "/docs"},
        {"label": "API Reference", "url": "/api"}
      ]
    },
    {
      "title": "Company",
      "links": [
        {"label": "About", "url": "/about"},
        {"label": "Careers", "url": "/careers"}
      ]
    }
  ],
  "featured": {
    "image": "/images/feature-hero.jpg",
    "title": "New Feature Release",
    "description": "Check out our latest feature",
    "url": "/blog/new-feature"
  }
}
```

## Mobile Menus

### Mobile Menu Behavior

| Behavior | Configuration | Default |
|----------|--------------|---------|
| Animation | `slide-left`, `slide-right`, `fade`, `none` | `slide-left` |
| Overlay | Show dark overlay behind menu | `true` |
| Close on escape | Close menu on Escape key | `true` |
| Close on outside click | Close on tap outside | `true` |
| Body scroll lock | Prevent body scroll when open | `true` |
| Accordion mode | Expand sub-items inline | `true` |
| Back button | Show back button for sub-menus | `true` |
| Search integration | Include search input in mobile menu | `false` |

### Mobile Menu Component

```html
<gsmui:menu-mobile location="mobile" :close-on-click="true">
    <x-slot:trigger>
        <gsmui:button icon="bars" aria-label="Open navigation menu" />
    </x-slot:trigger>

    <x-slot:header>
        <x-logo class="h-8" />
    </x-slot:header>

    <x-slot:items>
        @foreach($menuItems as $item)
            @if($item->children->count())
                <gsmui:menu-mobile-accordion :item="$item" />
            @else
                <gsmui:menu-mobile-link :item="$item" />
            @endif
        @endforeach
    </x-slot:items>

    <x-slot:footer>
        <gsmui:button variant="primary" full-width>Get Started</gsmui:button>
    </x-slot:footer>
</gsmui:menu-mobile>
```

## Dynamic Menu Items

### Auto-Update Triggers

| Event | Action |
|-------|--------|
| Page created | Add to `page` type menus |
| Page deleted | Remove from all menus |
| Page slug changed | Update URL in all menus |
| Category created | Add to `category` type menus |
| Category deleted | Remove from all menus |
| Post published | Add to `post` type menus if configured |

### Event Listener

```php
class MenuContentListener
{
    public function handlePageUpdated(Page $page): void
    {
        Menu::dynamic()
            ->where('items->type', 'page')
            ->where('items->type_id', $page->id)
            ->each(function (Menu $menu) use ($page) {
                $menu->updateItemLink($page->id, [
                    'label' => $page->title,
                    'url' => $page->url,
                ]);
            });
    }
}
```

## Database Schema

```sql
CREATE TABLE menus (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    slug VARCHAR(100) NOT NULL,
    location VARCHAR(50) NULL,
    items JSON NULL,
    settings JSON NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    UNIQUE KEY menus_slug_unique (slug),
    KEY menus_location_index (location)
);

CREATE TABLE menu_items (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    menu_id BIGINT UNSIGNED NOT NULL,
    parent_id BIGINT UNSIGNED NULL,
    label VARCHAR(255) NOT NULL,
    url VARCHAR(2048) NULL,
    type VARCHAR(50) NOT NULL DEFAULT 'custom',
    type_id BIGINT UNSIGNED NULL,
    target VARCHAR(10) NOT NULL DEFAULT '_self',
    css_class VARCHAR(255) NULL,
    icon VARCHAR(50) NULL,
    sort_order INT NOT NULL DEFAULT 0,
    is_active BOOLEAN NOT NULL DEFAULT TRUE,
    mega JSON NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    KEY menu_items_menu_index (menu_id),
    KEY menu_items_parent_index (parent_id),
    CONSTRAINT menu_items_menu FOREIGN KEY (menu_id) REFERENCES menus(id) ON DELETE CASCADE
);
```

## Access Control

| Permission | Description | Default Role |
|------------|-------------|-------------|
| `menus.create` | Create menus | Editor |
| `menus.edit` | Edit menu items | Editor |
| `menus.delete` | Delete menus | Admin |
| `menus.reorder` | Reorder menu items | Editor |
| `menus.assign-location` | Assign menu to location | Admin |
| `menus.mega-edit` | Edit mega menu content | Editor |

## Acceptance Criteria

- [ ] Drag-and-drop menu builder supports unlimited nesting
- [ ] Multiple menu locations can be registered and assigned
- [ ] Mega menus support multiple column layouts
- [ ] Mobile menus animate smoothly and lock body scroll
- [ ] Dynamic menu items auto-update when linked content changes
- [ ] Menu items support custom CSS classes and icons
- [ ] Menu rendering completes in under 10ms
- [ ] Keyboard navigation works for all menu types
- [ ] ARIA attributes are correctly applied for accessibility
- [ ] Menu changes are previewed in real-time before saving
