# Gsmui Pro

The pro version of Gsmui, the official UI component library for Livewire. A Laravel package providing 200+ production-ready Blade components with beautiful design and seamless Livewire integration.

## Features

- **200+ Components** — From basic UI elements to complex interactive widgets
- **Livewire Native** — Built specifically for Livewire with full `wire:model` support
- **Blade Components** — Clean `<x-gsmui::component>` syntax
- **Dark Mode** — Automatic dark mode support with system preference detection
- **TypeScript** — Full type safety with included type definitions
- **Zero External Dependencies** — No CDN fonts, scripts, or external resources
- **CSP Compatible** — Works with strict Content Security Policy headers
- **Accessibility** — ARIA labels, keyboard navigation, and screen reader support

## Requirements

- PHP 8.1+
- Laravel 10, 11, 12, or 13
- Livewire 3.7.4+ or 4.0+
- Gsmui Base (1.0)

## Installation

```bash
composer require gsmui/gsmui-pro
```

The package will automatically register its service provider and publish configuration.

### Publish Configuration

```bash
php artisan vendor:publish --tag=gsmui-pro-csp-config
```

## Quick Start

```blade
{{-- Basic button --}}
<x-gsmui::button>Click me</x-gsmui::button>

{{-- Input with wire:model --}}
<x-gsmui::input wire:model="name" placeholder="Enter your name" />

{{-- Modal --}}
<x-gsmui::modal>
    <x-gsmui::modal.trigger>
        <x-gsmui::button>Open Modal</x-gsmui::button>
    </x-gsmui::modal.trigger>
    <x-gsmui::modal.content>
        <h2>Hello World</h2>
    </x-gsmui::modal.content>
</x-gsmui::modal>
```

## Component Categories

### Form Components
| Component | Description |
|-----------|-------------|
| `<x-gsmui::input>` | Text input with validation states |
| `<x-gsmui::textarea>` | Multi-line text input |
| `<x-gsmui::select>` | Dropdown select |
| `<x-gsmui::checkbox>` | Checkbox input |
| `<x-gsmui::radio>` | Radio button group |
| `<x-gsmui::switch>` | Toggle switch |
| `<x-gsmui::slider>` | Range slider |
| `<x-gsmui::otp>` | One-time password input |

### Layout Components
| Component | Description |
|-----------|-------------|
| `<x-gsmui::card>` | Content container |
| `<x-gsmui::tabs>` | Tabbed interface |
| `<x-gsmui::accordion>` | Collapsible content |
| `<x-gsmui::sidebar>` | Side navigation |
| `<x-gsmui::navbar>` | Top navigation bar |

### Feedback Components
| Component | Description |
|-----------|-------------|
| `<x-gsmui::modal>` | Dialog overlay |
| `<x-gsmui::toast>` | Notification messages |
| `<x-gsmui::tooltip>` | Hover information |
| `<x-gsmui::popover>` | Floating content |
| `<x-gsmui::progress>` | Progress indicator |

### Data Display
| Component | Description |
|-----------|-------------|
| `<x-gsmui::table>` | Data tables |
| `<x-gsmui::stat>` | Statistics display |
| `<x-gsmui::avatar>` | User avatars |
| `<x-gsmui::badge>` | Status badges |
| `<x-gsmui::tag>` | Tags and labels |

### Navigation
| Component | Description |
|-----------|-------------|
| `<x-gsmui::breadcrumb>` | Breadcrumb navigation |
| `<x-gsmui::pagination>` | Page navigation |
| `<x-gsmui::navlist>` | Navigation list |

### Specialized Components
| Component | Description |
|-----------|-------------|
| `<x-gsmui::color-picker>` | Color selection |
| `<x-gsmui::date-picker>` | Date selection |
| `<x-gsmui::time-picker>` | Time selection |
| `<x-gsmui::phone>` | Phone input |
| `<x-gsmui::pillbox>` | Multi-select pillbox |
| `<x-gsmui::kanban>` | Kanban board |

### Template Components
| Component | Description |
|-----------|-------------|
| `<x-gsmui::templates.dashboard>` | Dashboard layouts |
| `<x-gsmui::templates.saas-landing>` | SaaS landing pages |
| `<x-gsmui::templates.real-estate>` | Real estate templates |

### Frame Components
| Component | Description |
|-----------|-------------|
| `<x-gsmui::frame.3d>` | 3D effect frames |
| `<x-gsmui::frame.glass>` | Glassmorphism frames |
| `<x-gsmui::frame.neon>` | Neon glow frames |
| `<x-gsmui::frame.polaroid>` | Polaroid-style frames |

## Dark Mode

Gsmui Pro automatically supports dark mode. Add the `dark` class to your `<html>` element:

```html
<html class="dark">
```

Use the theme switcher component for user control:

```blade
<x-gsmui::theme-switcher />
```

## Content Security Policy

Gsmui Pro is CSP-compatible. When using the CSP middleware:

```php
// app/Http/Kernel.php
protected $middlewareGroups = [
    'web' => [
        // ...
        \GsmuiPro\Http\Middleware\CspMiddleware::class,
    ],
];
```

### CSP Configuration

```php
// config/gsmui-pro-csp.php
return [
    'enabled' => true,
    'use_nonce' => false,
    'report_only' => false,
];
```

## Component Usage Patterns

### With Livewire

```blade
<x-gsmui::input wire:model="user.name" label="Name" />
<x-gsmui::select wire:model="user.role" :options="$roles" />
<x-gsmui::button wire:click="save" variant="primary">Save</x-gsmui::button>
```

### Size Variants

```blade
<x-gsmui::button size="xs">Extra Small</x-gsmui::button>
<x-gsmui::button size="sm">Small</x-gsmui::button>
<x-gsmui::button size="md">Medium</x-gsmui::button>
<x-gsmui::button size="lg">Large</x-gsmui::button>
```

### Invalid State

```blade
<x-gsmui::input 
    wire:model="email" 
    :invalid="$errors->has('email')"
    :error="$errors->first('email')"
/>
```

### Disabled State

```blade
<x-gsmui::input disabled placeholder="Disabled input" />
<x-gsmui::button disabled>Disabled Button</x-gsmui::button>
```

## Development

### Local Development

```bash
# Install dependencies
composer install

# Start development server
composer serve
```

The dev server runs on `http://localhost:3000`.

### Running Tests

```bash
# PHP tests
./vendor/bin/testbench test

# Browser tests (requires running server)
cd tests/Browser
npm install
npx playwright test
```

## Security

Gsmui Pro bundles load zero external resources:
- No CDN fonts
- No external scripts
- No iframes
- No `eval()` or `Function()` constructors

This makes a strict CSP possible with just `'self'` directives.

## License

Proprietary license. See [LICENSE.md](LICENSE.md) for details.

## Support

- Documentation: [https://gsmui.dev](https://gsmui.dev)
- Issues: [GitHub Issues](https://github.com/gsmui/gsmui-pro/issues)
- Email: shamimstack@gmail.com

## Credits

Created by Md Shamim Hossain and contributors.
