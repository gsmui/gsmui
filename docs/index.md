# GsmUi Documentation

Welcome to the **GsmUi** documentation — a comprehensive, Laravel-native UI component library built on **Livewire 4**, **Blade components**, **Tailwind CSS v4**, and a **design token architecture**.

## Quick Links

| Section | Description |
|---------|-------------|
| [Getting Started](/docs/guides/getting-started) | Installation, setup, and first component |
| [Components](/docs/components) | All 70+ components organized by category |
| [Theming](/docs/guides/theming) | Design tokens, dark mode, custom themes |
| [Playground](/playground) | Live component editor |
| [API Reference](/docs/api) | Programmatic APIs |
| [Changelog](/CHANGELOG.md) | Version history |

---

## Component Categories

### [Actions](/docs/components/actions)
Interactive elements for user actions
- [Button](/docs/components/actions/button) — Primary action trigger with variants, sizes, icons
- Icon Button — Icon-only actions
- Link — Styled anchor tags
- Split Button — Button with attached dropdown
- Dropdown Button — Button that opens a menu
- Floating Action Button — Prominent circular action

### [Forms](/docs/components/forms)
Input and data entry components
- [Input](/docs/components/forms/input) — Single-line text with validation, icons, Livewire
- [Textarea](/docs/components/forms/textarea) — Multi-line with auto-resize, character count
- [Select](/docs/components/forms/select) — Native & searchable dropdown
- [Autocomplete](/docs/components/forms/autocomplete) — Free-text with suggestions
- [Checkbox](/docs/components/forms/checkbox) — Boolean with indeterminate state
- [Radio](/docs/components/forms/radio) — Single-choice groups
- [Switch](/docs/components/forms/switch) — Toggle for on/off states
- [Slider](/docs/components/forms/slider) — Single value range
- Range Slider — Dual-handle range selection
- OTP Input — One-time password fields
- [File Upload](/docs/components/forms/file-upload) — Drag-and-drop with preview
- [Date Picker](/docs/components/forms/date-picker) — Calendar date/range selection
- Time Picker — Time selection
- Color Picker — Color selection with eyedropper
- [Editor](/docs/components/forms/editor) — WYSIWYG rich text editor
- Pillbox — Token/tag input

### [Layout](/docs/components/layout)
Structural and spacing components
- [Container](/docs/components/layout/container) — Responsive max-width wrapper
- Grid — Flexible grid system
- [Stack](/docs/components/layout/stack) — Vertical/horizontal spacing
- Flex — Flexbox wrapper
- [Card](/docs/components/layout/card) — Content container with header/body/footer
- Panel — Collapsible content panel
- Section — Semantic page section
- [Divider](/docs/components/layout/divider) — Horizontal/vertical divider
- Spacer — Configurable spacing

### [Navigation](/docs/components/navigation)
Wayfinding and menu components
- [Navbar](/docs/components/navigation/navbar) — Top-level application header
- Sidebar — Collapsible side navigation
- [Tabs](/docs/components/navigation/tabs) — Tabbed content panes
- Breadcrumbs — Hierarchical location trail
- Pagination — Page navigation controls
- Menu — Dropdown/action menu
- Navlist — Vertical navigation list
- Navmenu — Multi-level navigation menu
- Steps — Step-by-step progress
- Dock — Mac-style app dock
- [Command Palette](/docs/components/navigation/command) — Keyboard-first command interface

### [Data Display](/docs/components/data-display)
Presenting structured data
- [Table](/docs/components/data-display/table) — Data table with sorting, selection
- DataTable — Advanced table with pagination, filtering
- [Badge](/docs/components/data-display/badge) — Status/count label
- [Avatar](/docs/components/data-display/avatar) — User/profile image with fallback
- Stat — Key metric display with trend
- Timeline — Chronological event list
- Calendar — Monthly calendar view
- List — Structured list with actions
- Description List — Key-value pairs

### [Feedback](/docs/components/feedback)
User feedback and status indicators
- [Alert](/docs/components/feedback/alert) — Dismissible notification banner
- [Toast](/docs/components/feedback/toast) — Transient auto-dismissing notifications
- [Progress](/docs/components/feedback/progress) — Linear progress bar
- Radial Progress — Circular progress indicator
- Spinner — Indeterminate loading spinner
- Skeleton — Placeholder loading state
- Empty State — No-data illustration with action
- Status — Inline status indicator

### [Overlays](/docs/components/overlays)
Floating and layered content
- [Modal](/docs/components/overlays/modal) — Dialog overlay with backdrop
- Drawer — Slide-in panel from edge
- Popover — Anchored floating content
- Tooltip — Hover/focus text hint
- Dropdown — Contextual action menu
- Context Menu — Right-click menu
- Hover Card — Rich hover preview

### [Media](/docs/components/media)
Rich media display
- Image — Responsive images with lazy loading
- Image Gallery — Multi-image gallery with lightbox
- Carousel — Swipeable content carousel
- Video — Custom video player
- Audio — Custom audio player
- Code Block — Syntax-highlighted code display
- Markdown Viewer — Rendered Markdown with components

### [Charts](/docs/components/charts)
Data visualization
- Line Chart — Trend over time
- Area Chart — Filled trend
- Bar Chart — Categorical comparison
- Horizontal Bar — Horizontal bars
- Pie Chart — Proportional segments
- Donut Chart — Ring with center label
- Radar Chart — Multi-dimensional comparison
- Heatmap — Matrix intensity
- Treemap — Hierarchical areas

### [Advanced](/docs/components/advanced)
Complex application components
- Kanban — Drag-and-drop board
- Scheduler — Calendar scheduler
- Whiteboard — Collaborative canvas
- File Explorer — Tree file browser
- Terminal — Interactive shell
- JSON Viewer — Collapsible JSON tree
- Code Editor — Monaco-based editor
- Diff Viewer — Side-by-side diff

---

## Design Principles

| Principle | Description |
|-----------|-------------|
| **Laravel-Native First** | Every component is a Blade anonymous component with optional Livewire enhancement |
| **Design Token Driven** | All styling derives from design tokens (colors, spacing, typography, radii, shadows, motion) |
| **Livewire-Enhanced, Not Dependent** | Components work as pure Blade; add `wire:model` for reactivity |
| **Accessibility by Default** | WCAG 2.1 AA compliance mandatory — ARIA, keyboard nav, focus management built-in |
| **Theme-Aware** | Automatic light/dark mode and custom theme adaptation via CSS custom properties |
| **Composable Architecture** | Components compose via slots and sub-components — no monolithic "do-everything" components |
| **Developer Experience First** | Type-safe props via PHP docblocks, IDE autocomplete, live playground, AI-assisted docs |

---

## Installation

```bash
composer require gsmui/gsmui-pro
```

```bash
php artisan gsmui:install
```

```bash
npm install && npm run build
```

Add to `tailwind.config.js`:
```js
import gsmui from 'gsmui/tailwind'

export default {
  content: [
    './vendor/gsmui/gsmui-pro/stubs/resources/views/**/*.blade.php',
    gsmui.content()
  ],
  plugins: [gsmui],
}
```

---

## Community & Support

- **GitHub**: [github.com/gsmui/gsmui](https://github.com/gsmui/gsmui)
- **Discord**: [discord.gg/gsmui](https://discord.gg/gsmui)
- **Twitter**: [@gsmui](https://twitter.com/gsmui)
- **Sponsor**: [github.com/sponsors/gsmui](https://github.com/sponsors/gsmui)

---

## License

GsmUi Pro is a commercial product. See [LICENSE.md](/LICENSE.md) for details.