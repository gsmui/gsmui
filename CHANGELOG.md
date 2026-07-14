# Changelog

All notable changes to Gsmui Pro will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [2.15.0] - 2026-07-15

### Added
- **Emoji Components** — Full emoji picker with search functionality and categories
- **Range Slider** — 20 categories and 20 variants including vertical and curved styles
- **Radial Progress** — 100 categories and 100 variants with animated states
- **Steps Component** — 100 categories and 100 variants for step-by-step flows
- **Dock Component** — macOS-style dock with 100 categories and 100 variants
- **Status Component** — 100 categories and 100 variants for status indicators
- **Frame Components** — 100 unique frame styles (3D, glass, neon, polaroid, etc.)
- **Dashboard Templates** — 100 unique dashboard UI templates
- **Template Builder** — Customizable dashboard builder with color and layout options
- **Theme Switcher** — Light/dark mode toggle with system preference detection
- **Frame Index** — Searchable and filterable frame component index
- **Dashboard Index** — Searchable and filterable dashboard template index
- **Drag-and-Drop Widgets** — Widget templates for dashboard builder
- **Keyboard Shortcuts** — Ctrl+K for search, Escape to clear

### Changed
- Updated README.md with comprehensive documentation
- Updated CHANGELOG.md with version history
- Updated LICENSE.md with proper licensing terms
- Added dark mode support to all frame components

### Fixed
- Dashboard builder x-data function name mismatch
- Copy usage text format in frame index
- Dynamic Tailwind class issues in dashboard templates

## [2.14.0] - 2026-06-01

### Added
- **Image Gallery** — 20 categories, 40 variants, 80 image gallery styles
- **Kanban Board** — Drag-and-drop kanban with customizable columns
- **Timeline Component** — Vertical and horizontal timeline layouts
- **Terminal Component** — Terminal emulator UI component
- **Video Player** — Multiple video player styles (YouTube, Netflix, TikTok)

### Changed
- Improved component rendering performance
- Updated Tailwind CSS classes for better compatibility

## [2.13.0] - 2026-04-15

### Added
- **Team Components** — 12 team layout variants
- **Profile Components** — User profile display options
- **Lightbox Component** — Image lightbox with zoom and navigation
- **Toast Notifications** — Stacked toast notification system

### Changed
- Enhanced dark mode support across all components
- Improved accessibility with better ARIA labels

## [2.12.0] - 2026-03-01

### Added
- **Color Picker** — Full-featured color picker with swatches and dropper
- **Date Picker** — Date selection with range support
- **Time Picker** — Time selection component
- **Pillbox** — Multi-select pillbox component

### Changed
- Updated service provider for Laravel 12 compatibility
- Improved CSP middleware with nonce support

## [2.11.0] - 2026-01-15

### Added
- **Content Security Policy** — Built-in CSP middleware and configuration
- **CSP Test Page** — Browser test for CSP compliance
- **Nonce Support** — Dynamic nonce generation for inline scripts

### Fixed
- CSP header issues with Livewire updates
- Nonce injection timing issues

## [2.10.0] - 2025-12-01

### Added
- **Initial Release** — Gsmui Pro v2.10.0
- **100+ Components** — Comprehensive UI component library
- **Livewire Integration** — Full wire:model support
- **Dark Mode** — Automatic dark mode support
- **TypeScript** — Full type definitions included

### Components
- Form: input, textarea, select, checkbox, radio, switch, slider, otp
- Layout: card, tabs, accordion, sidebar, navbar
- Feedback: modal, toast, tooltip, popover, progress
- Data: table, stat, avatar, badge, tag
- Navigation: breadcrumb, pagination, navlist
- Specialized: phone, search, rating, separator

## [1.0.0] - 2025-10-01

### Added
- **Gsmui Base** — Initial release of the base Gsmui package
- **Core Components** — Basic UI component set
- **Blade Components** — Anonymous Blade component support
- **Livewire Support** — Basic Livewire integration

---

## Upgrade Guide

### Upgrading from 2.14.x to 2.15.0

1. Update composer dependency:
   ```bash
   composer update gsmui/gsmui-pro
   ```

2. No breaking changes — all additions are new components and features.

### Upgrading from 2.13.x to 2.14.0

1. Update composer dependency:
   ```bash
   composer update gsmui/gsmui-pro
   ```

2. If using CSP middleware, publish the new config:
   ```bash
   php artisan vendor:publish --tag=gsmui-pro-csp-config --force
   ```

### Upgrading from 2.12.x to 2.13.0

1. Update composer dependency:
   ```bash
   composer update gsmui/gsmui-pro
   ```

2. No breaking changes.

---

## Support

- Documentation: [https://gsmui.dev](https://gsmui.dev)
- Issues: [GitHub Issues](https://github.com/gsmui/gsmui-pro/issues)
- Email: shamimstack@gmail.com
