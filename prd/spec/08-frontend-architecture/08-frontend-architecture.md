A complete **08-frontend-architecture.md** for GsmUi is also **too large to fit into a single response**. For a platform of this scope, the frontend architecture would be approximately **500–900 pages** and should be organized into focused, implementation-ready documents.

A recommended structure is:

```text id="frontend-arch-01"
08-frontend-architecture/

08.01-overview.md
08.02-design-system.md
08.03-design-tokens.md
08.04-theme-architecture.md
08.05-tailwind-v4.md
08.06-css-architecture.md
08.07-blade-component-system.md
08.08-livewire-architecture.md
08.09-alpinejs-architecture.md
08.10-javascript-architecture.md
08.11-icon-system.md
08.12-layout-system.md
08.13-navigation-system.md
08.14-responsive-system.md
08.15-animation-system.md
08.16-accessibility.md
08.17-forms.md
08.18-data-display.md
08.19-feedback-components.md
08.20-overlay-components.md
08.21-dashboard-ui.md
08.22-admin-ui.md
08.23-documentation-ui.md
08.24-playground-ui.md
08.25-theme-builder-ui.md
08.26-component-showcase.md
08.27-template-gallery.md
08.28-marketplace-ui.md
08.29-billing-ui.md
08.30-user-dashboard-ui.md
08.31-blog-ui.md
08.32-cms-ui.md
08.33-showcase-ui.md
08.34-chart-system.md
08.35-code-highlighting.md
08.36-search-ui.md
08.37-notification-system.md
08.38-modal-system.md
08.39-table-system.md
08.40-file-upload.md
08.41-command-palette.md
08.42-shortcuts.md
08.43-dark-mode.md
08.44-theme-switcher.md
08.45-internationalization.md
08.46-performance.md
08.47-seo.md
08.48-pwa.md
08.49-testing.md
08.50-folder-structure.md
08.51-build-pipeline.md
08.52-component-guidelines.md
08.53-documentation-generation.md
08.54-storybook-strategy.md
08.55-frontend-security.md
08.56-coding-standards.md
08.57-complete-page-flow.md
```

### Frontend technology stack

This section should be written specifically for your chosen stack:

* **Laravel 13**
* **Livewire 4**
* **Blade Components**
* **GsmUi Component Library**
* **Tailwind CSS v4**
* **Vite**
* **Alpine.js**
* **Laravel Folio (optional for marketing/docs routes)**
* **Monaco Editor** (Playground)
* **Chart.js / ApexCharts / ECharts adapter**
* **Heroicons + Lucide support**
* **Design Token Engine**
* **CSS Variables**
* **Motion & Animation Layer**

### Major frontend domains

The architecture should cover:

* Marketing website
* Documentation portal
* Component explorer
* Live playground
* Theme builder
* Template gallery
* Marketplace
* User dashboard
* Admin panel
* Blog
* CMS
* Showcase
* Pricing
* MCP pages
* AI tools
* Swag store
* Authentication pages
* Error pages
* Search experience

### Recommended implementation order

Start with the foundations:

1. **08.01-overview.md**
2. **08.02-design-system.md**
3. **08.03-design-tokens.md**
4. **08.04-theme-architecture.md**
5. **08.05-tailwind-v4.md**
6. **08.06-css-architecture.md**
7. **08.07-blade-component-system.md**
8. **08.08-livewire-architecture.md**

Then build upward into layouts, navigation, components, feature modules, and finally performance, testing, and coding standards.

This approach creates a frontend architecture that is consistent with the backend and database documents you've already defined, while remaining directly implementable for the GsmUi platform.

---

## Detailed Document Summaries

Each document in the `08-frontend-architecture/` directory covers a specific domain. This section provides a detailed summary of what each document contains, its scope, key decisions, and how it connects to other documents.

---

### 08.01 — Overview

**Scope:** High-level introduction to the GsmUi frontend architecture. Establishes the "why" before the "how."

**Key decisions:**
- Server-rendered Blade + Livewire 4 as the primary rendering model
- Self-hosted assets only — zero CDN dependencies
- CSP-safe by default (eval-free, inline-free where possible)
- Component library as the core deliverable (not a framework)

**Connections:** References every other document in Section 08. Serves as the entry point for new contributors.

**Content areas:**
- Architectural principles (server-first, progressive enhancement, zero-external)
- Technology stack justification (why Laravel 13, why Livewire 4, why Tailwind v4)
- High-level system diagram showing Blade → Livewire → gsmui.js → Browser
- Relationship to Section 05 (conceptual architecture), Section 06 (data), Section 07 (backend)
- Glossary of frontend-specific terms (hydrate, morph, mixin, detangle, etc.)

---

### 08.02 — Design System

**Scope:** The visual language that underpins every GsmUi component — color, typography, spacing, elevation, motion.

**Key decisions:**
- System font stack (no web fonts, no @font-face)
- 4-point spacing grid (4px base unit)
- Consistent border-radius scale: `rounded-md` (6px), `rounded-lg` (8px), `rounded-xl` (12px)
- Shadow scale: `shadow-xs`, `shadow-sm`, `shadow-md`, `shadow-lg`
- Color palette derived from Tailwind's zinc scale with brand accent

**Connections:** `08.03` (tokens), `08.04` (theme), `08.52` (component guidelines)

**Content areas:**
- Color palette definition (primary, secondary, accent, neutral, semantic)
- Typography scale (font sizes, line heights, letter spacing)
- Spacing scale (4px increments: 1, 2, 3, 4, 5, 6, 8, 10, 12, 16, 20, 24)
- Elevation system (shadow + border combinations for depth layers)
- Motion principles (duration, easing, reduction for prefers-reduced-motion)
- Icon grid (24px standard, 20px small, 16px compact)
- Component anatomy diagrams (trigger, content, action zones)

---

### 08.03 — Design Tokens

**Scope:** The CSS custom properties that translate the design system into code. Every visual decision flows through `--gsmui-*` tokens.

**Key decisions:**
- All tokens use the `--gsmui-*` prefix (never `--flux-*`)
- Tokens are defined in CSS, not JavaScript
- Dark mode via `.dark` class override on `:root`
- Tokens are consumed by both Tailwind utilities and component styles

**Connections:** `08.02` (design system), `08.04` (theme), `08.06` (CSS architecture)

**Content areas:**
- Token naming convention: `--gsmui-{category}-{property}-{variant}`
- Color tokens: `--gsmui-color-primary-500`, `--gsmui-color-accent-*`
- Typography tokens: `--gsmui-font-sans`, `--gsmui-font-mono`, `--gsmui-text-*`
- Spacing tokens: `--gsmui-space-*` (maps to Tailwind scale)
- Shadow tokens: `--gsmui-shadow-*`
- Border radius tokens: `--gsmui-radius-*`
- Transition tokens: `--gsmui-duration-*`, `--gsmui-easing-*`
- Z-index tokens: `--gsmui-z-dropdown`, `--gsmui-z-modal`, `--gsmui-z-toast`
- Token consumption patterns in Blade and CSS

---

### 08.04 — Theme Architecture

**Scope:** How GsmUi supports multiple themes (light/dark, and potential custom themes) without component re-rendering.

**Key decisions:**
- Light/dark as the primary theme pair
- `.dark` class on `<html>` (not media query) for programmatic control
- Theme stored in `localStorage`, bootstrapped inline to prevent FOUC
- CSS variable cascade handles all visual changes (zero JS re-render)

**Connections:** `08.03` (tokens), `08.43` (dark mode), `08.44` (theme switcher), `08.57` (page flow)

**Content areas:**
- Theme variable override strategy (`.dark { --gsmui-*: ... }`)
- Bootstrap script (inline, eval-free, CSP-safe)
- Theme persistence (localStorage key: `gsmui-theme`)
- Theme event system (`gsmui:theme-changed` custom event)
- Future extensibility (custom themes, brand themes)
- Theme testing strategy (Playwright screenshots in both modes)

---

### 08.05 — Tailwind CSS v4

**Scope:** How Tailwind v4 is configured and used within the GsmUi component library.

**Key decisions:**
- Tailwind v4 with JIT (Just-In-Time) compilation
- Custom `--gsmui-*` token integration via `theme.extend`
- No Tailwind plugins (keep dependency surface minimal)
- Utility-first in templates; no custom CSS in Blade

**Connections:** `08.03` (tokens), `08.06` (CSS architecture), `08.52` (component guidelines)

**Content areas:**
- Tailwind v4 configuration (tailwind.config.js)
- Custom color palette mapped to `--gsmui-*` tokens
- Custom spacing, font, shadow extensions
- Dark mode configuration (`darkMode: 'class'`)
- Purge/content configuration for tree-shaking
- Build-time vs runtime Tailwind decisions
- Custom utility patterns (e.g., `has-focus-visible:`)

---

### 08.06 — CSS Architecture

**Scope:** The overall CSS strategy — how styles are loaded, organized, and applied at runtime.

**Key decisions:**
- `adoptedStyleSheets` for dynamic/runtime styles (no inline `<style>` tags)
- `dist/editor.css` as the only stylesheet file (plus Tailwind utilities)
- CSS containment (`contain: layout`) on isolated components
- No CSS-in-JS, no CSS Modules, no Sass

**Connections:** `08.05` (Tailwind), `08.55` (security — CSP), `08.46` (performance)

**Content areas:**
- Style loading order (Tailwind reset → tokens → component utilities → runtime)
- `adoptedStyleSheets` API usage and browser support
- CSS containment strategy
- Z-index management via tokens
- Responsive design approach (mobile-first, container queries where possible)
- Print stylesheet considerations
- High contrast mode support

---

### 08.07 — Blade Component System

**Scope:** How GsmUi components are structured as Blade anonymous components, registered under the `gsmui:` namespace.

**Key decisions:**
- Anonymous Blade components (no backing PHP class unless needed)
- `Gsmui::classes()` for class merging (never `Flux`)
- `$attributes->merge()` for attribute forwarding
- `__()` for all user-facing strings (localization)
- Sub-components as sibling files (not nested directories)

**Connections:** `08.50` (folder structure), `08.52` (component guidelines), `08.56` (coding standards)

**Content areas:**
- Anonymous vs named component registration
- `GsmuiProServiceProvider::bootComponentPath()` mechanism
- Component attribute ordering convention
- Slot patterns (default, named, scoped)
- Conditional rendering patterns
- Component composition (components using other components)
- ARIA attribute injection from Blade
- Localization integration

---

### 08.08 — Livewire Architecture

**Scope:** How Livewire 4 integrates with GsmUi components for server-side state management and real-time updates.

**Key decisions:**
- `wire:model` as the primary data binding mechanism
- Livewire signs and encrypts all payloads
- Server-side rendering is authoritative (client reconciles to server state)
- Component snapshot includes all Livewire-bound properties

**Connections:** `08.07` (Blade), `08.57` (page flow), `07.60` (backend request flow)

**Content areas:**
- Livewire component registration and mounting
- `wire:model`, `wire:model.live`, `wire:model.lazy`, `wire:model.blur` semantics
- Livewire lifecycle hooks (`mount`, `update`, `dehydrate`, `hydrate`)
- Livewire morphing (DOM diffing strategy)
- Livewire snapshot format and signing
- Event dispatching between components
- Livewire + CSP considerations (signed payloads)
- Error handling (419, 422, 500 responses)

---

### 08.09 — Alpine.js Architecture

**Scope:** When and how Alpine.js is used within GsmUi (sparingly, per AGENTS.md).

**Key decisions:**
- Alpine is used RARELY — only when reasonably necessary
- Interaction logic that needs disabled-state awareness lives in JS, not Alpine
- Alpine is acceptable for simple toggle/show-hide patterns
- Alpine never handles component coordination

**Connections:** `08.10` (JS architecture), `08.52` (component guidelines), `08.56` (coding standards)

**Content areas:**
- Alpine.js integration scope (what it does, what it doesn't)
- Approved Alpine patterns (x-show, x-bind, x-on for simple toggles)
- Anti-patterns (Alpine handling disabled state, Alpine coordinating components)
- Migration path from Alpine to vanilla JS when complexity grows
- Alpine + CSP considerations (no `x-eval` or inline event handlers)

---

### 08.10 — JavaScript Architecture

**Scope:** The overall JS strategy — module system, mixins, utilities, and the component initialization lifecycle.

**Key decisions:**
- ES modules with Vite bundling
- Class-based component definitions
- Shared mixins: Controllable, Disableable, Submittable, Focusable
- `utils.js` provides `setAttribute`/`removeAttribute` (MutationObserver-aware)
- `detangle()` prevents sync loops

**Connections:** `08.09` (Alpine), `08.51` (build pipeline), `08.52` (component guidelines), `08.56` (coding standards)

**Content areas:**
- Module system (ES modules, Vite tree-shaking)
- Mixin architecture (how mixins compose, priority order)
- Utility functions (setAttribute, removeAttribute, detangle, debounce, throttle)
- MutationObserver strategy (what attributes to watch, how to respond)
- Event system (custom events, bubbling, naming conventions)
- Error handling (silent degradation, no throws in component code)
- Memory management (destroy patterns, leak prevention)
- Browser API usage (URL, canvas, Intl for color parsing, date formatting)

---

### 08.11 — Icon System

**Scope:** How icons are rendered, sized, and colored across all GsmUi components.

**Key decisions:**
- Inline SVG only (no icon fonts, no external SVG files)
- Heroicons as the primary icon set, Lucide as secondary
- Icons inherit text color via currentColor
- Consistent sizing: 16px (xs), 20px (sm), 24px (md)

**Connections:** `08.02` (design system), `08.55` (security — img-src), `08.07` (Blade)

**Content areas:**
- SVG inline pattern (how icons are embedded in Blade)
- Icon component wrapper (`<gsmui:icon>`)
- Size variants and consistent scaling
- Color inheritance via currentColor
- Accessibility (aria-hidden for decorative icons, aria-label for standalone icons)
- Icon sprite strategy (if needed for performance)
- Custom icon support (user-provided SVGs)

---

### 08.12 — Layout System

**Scope:** The page layout primitives — containers, grids, stacks, and responsive breakpoints.

**Key decisions:**
- Tailwind grid and flex utilities (no custom layout system)
- Container queries preferred over media queries where possible
- Consistent max-width scale
- Sidebar + main content pattern for admin/dashboard

**Connections:** `08.14` (responsive), `08.21` (dashboard UI), `08.22` (admin UI)

**Content areas:**
- Container widths (sm: 640px, md: 768px, lg: 1024px, xl: 1280px, 2xl: 1536px)
- Grid system (12-column, gap scale)
- Flex stack patterns (vertical, horizontal, wrap)
- Sidebar layout pattern
- Dashboard grid layout
- Content width constraints
- Responsive breakpoint definitions

---

### 08.13 — Navigation System

**Scope:** Navigation components — top nav, sidebar nav, breadcrumbs, tabs, pagination.

**Key decisions:**
- `<nav>` element with `aria-label` for all navigation regions
- Active state via `aria-current="page"` (not just visual class)
- Tab pattern follows ARIA APG
- Breadcrumbs use `ol` with `aria-label="Breadcrumb"`

**Connections:** `08.12` (layout), `08.16` (accessibility), `08.52` (component guidelines)

**Content areas:**
- Top navigation bar component
- Sidebar navigation component
- Breadcrumb component
- Tab component (horizontal and vertical)
- Pagination component
- Mobile navigation (hamburger menu, bottom nav)
- Keyboard navigation patterns for all nav components

---

### 08.14 — Responsive System

**Scope:** How GsmUi handles different screen sizes, from mobile to desktop.

**Key decisions:**
- Mobile-first (base = mobile, `sm:` = desktop)
- Touch targets minimum 44px on mobile
- Popovers become full-screen modals on mobile (`max-sm:fixed! max-sm:inset-0!`)
- Scroll lock on mobile for overlays

**Connections:** `08.12` (layout), `08.52` (component guidelines), `08.15` (animation)

**Content areas:**
- Breakpoint definitions and when to use each
- Touch vs pointer interaction patterns
- Popover/dialog responsive behavior
- Table responsive patterns (horizontal scroll, card view)
- Form responsive patterns (stacked vs inline)
- Image responsive patterns (srcset, art direction)
- Testing responsive states in Playwright

---

### 08.15 — Animation System

**Scope:** Motion design principles and implementation for GsmUi components.

**Key decisions:**
- `prefers-reduced-motion` respected globally (no exceptions)
- CSS transitions for simple state changes (opacity, transform)
- GSAP or similar NOT used — CSS only
- Duration scale: 100ms (instant), 200ms (fast), 300ms (normal), 500ms (slow)
- Easing: `ease-out` for entrances, `ease-in` for exits

**Connections:** `08.02` (design system), `08.46` (performance), `08.52` (component guidelines)

**Content areas:**
- Duration and easing tokens
- Enter/exit animation patterns (fade, slide, scale)
- Loading animation patterns (spinner, skeleton, progress)
- Scroll-triggered animations (IntersectionObserver-based)
- GPU-accelerated properties (transform, opacity only)
- Animation testing in Playwright (screenshot comparison)
- Reduced motion testing

---

### 08.16 — Accessibility

**Scope:** WCAG 2.1 AA compliance across all GsmUi components and pages.

**Key decisions:**
- WCAG 2.1 Level AA as the minimum standard
- ARIA APG patterns for all interactive components
- Keyboard navigation as a first-class concern (not an afterthought)
- axe-core integration in Playwright tests
- Manual screen reader testing protocol

**Connections:** `08.52` (component guidelines), `08.49` (testing), `08.13` (navigation)

**Content areas:**
- WCAG criteria mapping to GsmUi components
- ARIA pattern reference for each component type
- Keyboard navigation standards
- Focus management (trap, restore, roving tabindex)
- Screen reader testing protocol (VoiceOver, NVDA, TalkBack)
- Color contrast requirements and verification
- Reduced motion support
- High contrast mode support
- Accessibility documentation requirements

---

### 08.17 — Forms

**Scope:** Form components, validation patterns, error display, and submission flow.

**Key decisions:**
- Server-side validation is authoritative
- Client-side validation is optimistic (visual feedback only)
- Error messages use `role="alert"` for immediate announcement
- `wire:model` for all form bindings
- Label-input association via `for`/`id` (never implicit)

**Connections:** `08.07` (Blade), `08.08` (Livewire), `08.16` (accessibility), `08.52` (guidelines)

**Content areas:**
- Input component variants (text, email, password, number, tel, url)
- Textarea component
- Select/dropdown component
- Checkbox and radio components
- Toggle/switch component
- Date picker (references 08.24 playground for live demo)
- Color picker
- File upload
- Validation display patterns
- Required field indicators
- Help text and description patterns
- Form layout patterns (stacked, inline, grid)

---

### 08.18 — Data Display

**Scope:** Components for displaying data — tables, lists, cards, badges, tags.

**Key decisions:**
- Tables use semantic `<table>`, `<thead>`, `<tbody>`, `<th scope>` elements
- Sortable columns use `aria-sort` attribute
- Virtual scrolling for large datasets (if needed)
- Empty states are first-class (not an afterthought)

**Connections:** `08.39` (table system), `08.16` (accessibility), `08.52` (guidelines)

**Content areas:**
- Table component (basic, sortable, paginated, virtual)
- Data grid component (spreadsheet-like)
- List component (ordered, unordered, interactive)
- Card component
- Badge/tag component
- Avatar component
- Description list component
- Empty state component
- Loading/skeleton state component

---

### 08.19 — Feedback Components

**Scope:** Components that communicate system status — alerts, toasts, progress, loading.

**Key decisions:**
- Alerts use `role="alert"` and `aria-live="assertive"`
- Toasts use `role="status"` and `aria-live="polite"`
- Auto-dismiss for toasts (5s default, configurable)
- Progress components report determinate and indeterminate states

**Connections:** `08.37` (notification system), `08.16` (accessibility), `08.52` (guidelines)

**Content areas:**
- Alert component (info, success, warning, error)
- Toast/notification component
- Progress bar component
- Spinner/loading component
- Skeleton/placeholder component
- Confirmation dialog pattern
- Error boundary pattern (Livewire)
- Offline indicator

---

### 08.20 — Overlay Components

**Scope:** Components that render above the page — modals, popovers, dropdowns, tooltips.

**Key decisions:**
- Dialog/popover styling copied from date-picker (per AGENTS.md)
- Focus trap for modals and dialogs
- Scroll lock for full-screen overlays (mobile)
- `aria-haspopup="dialog"` on trigger buttons
- `role="dialog"` + `aria-modal="true"` on dialog content

**Connections:** `08.16` (accessibility), `08.15` (animation), `08.52` (guidelines), `08.57` (page flow)

**Content areas:**
- Modal/dialog component
- Popover component
- Dropdown menu component
- Tooltip component
- Confirm dialog component
- Full-screen overlay pattern (mobile)
- Backdrop patterns
- Focus management in overlays
- Animation patterns (fade, scale, slide)

---

### 08.21 — Dashboard UI

**Scope:** Layout and component patterns for the user dashboard.

**Key decisions:**
- Sidebar + main content layout
- Responsive: sidebar collapses to hamburger on mobile
- Dashboard cards with consistent spacing
- Real-time updates via Livewire polling

**Connections:** `08.12` (layout), `08.13` (navigation), `08.30` (user dashboard)

**Content areas:**
- Dashboard layout shell
- Sidebar navigation pattern
- Dashboard card grid
- Activity feed component
- Stats/metrics display
- Quick actions pattern
- Notification center

---

### 08.22 — Admin UI

**Scope:** Layout and component patterns for the admin panel.

**Key decisions:**
- Multi-level sidebar navigation
- Data tables with bulk actions
- Form-heavy pages (settings, configuration)
- Role-based UI visibility

**Connections:** `08.21` (dashboard), `08.39` (table system), `08.17` (forms)

**Content areas:**
- Admin layout shell
- Multi-level sidebar
- Data table with sorting, filtering, pagination
- Bulk action toolbar
- Settings page patterns
- User management patterns
- Role/permission display

---

### 08.23 — Documentation UI

**Scope:** The documentation portal layout and component patterns.

**Key decisions:**
- Sidebar + main content + on-page TOC
- Code blocks with syntax highlighting
- Copy-to-clipboard on code examples
- Responsive: TOC moves to top on mobile

**Connections:** `08.35` (code highlighting), `08.53` (documentation generation)

**Content areas:**
- Documentation layout shell
- Sidebar navigation (hierarchical)
- On-page table of contents
- Code block component (with copy button)
- Callout/admonition component (info, warning, tip)
- Props/attributes reference table
- Version selector
- Search integration

---

### 08.24 — Playground UI

**Scope:** The live component playground for testing and experimenting with GsmUi components.

**Key decisions:**
- Monaco Editor for code editing
- Live preview pane (rendered in real-time)
- Component props editor (form-based)
- Code export (copy, download)

**Connections:** `08.35` (code highlighting), `08.07` (Blade components)

**Content areas:**
- Playground layout (editor + preview split)
- Monaco Editor integration
- Live preview rendering (sandboxed)
- Component selector
- Props editor panel
- Code export functionality
- Responsive playground (stacked on mobile)

---

### 08.25 — Theme Builder UI

**Scope:** The visual theme builder for customizing GsmUi's appearance.

**Key decisions:**
- Color picker for brand colors
- Real-time preview of theme changes
- Export as CSS variables
- Import from existing theme

**Connections:** `08.03` (tokens), `08.04` (theme), `08.24` (playground)

**Content areas:**
- Theme builder layout
- Color picker integration
- Typography settings
- Spacing settings
- Preview pane (sample components with new theme)
- Export functionality (CSS variables, Tailwind config)
- Import from URL or file

---

### 08.26 — Component Showcase

**Scope:** The component showcase page that demonstrates every GsmUi component in all states.

**Key decisions:**
- One page per component
- State matrix display (base, hover, focus, disabled, invalid, sizes)
- Code snippets for each state
- Responsive layout

**Connections:** `08.53` (documentation generation), `08.54` (storybook strategy)

**Content areas:**
- Showcase page layout
- Component state grid
- Interactive state toggles
- Code snippet display
- Responsive testing links
- Accessibility annotation

---

### 08.27 — Template Gallery

**Scope:** Pre-built page templates using GsmUi components.

**Key decisions:**
- Templates are copy-paste ready
- Each template uses only Gsmui components
- Templates cover common use cases

**Connections:** `08.07` (Blade), `08.52` (guidelines)

**Content areas:**
- Landing page template
- Dashboard template
- Login/register template
- Settings page template
- Data table page template
- Form page template
- Error page templates (404, 403, 500)

---

### 08.28 — Marketplace UI

**Scope:** The marketplace page for selling/buying GsmUi templates and components.

**Key decisions:**
- Grid/card layout for product listing
- Search and filter functionality
- Product detail page
- Checkout flow

**Connections:** `08.18` (data display), `08.20` (overlays), `08.29` (billing)

**Content areas:**
- Marketplace layout
- Product card component
- Product detail page
- Search and filter sidebar
- Category navigation
- Rating/review display
- Purchase flow

---

### 08.29 — Billing UI

**Scope:** The billing and subscription management pages.

**Key decisions:**
- Stripe integration for payments
- Subscription plan comparison
- Invoice history table
- Payment method management

**Connections:** `08.17` (forms), `08.39` (table system), `08.19` (feedback)

**Content areas:**
- Pricing page layout
- Plan comparison table
- Subscription management
- Invoice history
- Payment method form
- Billing address form
- Receipt display

---

### 08.30 — User Dashboard UI

**Scope:** The user-facing dashboard (distinct from admin dashboard).

**Key decisions:**
- Personalized content
- Activity summary
- Quick actions
- Notification center

**Connections:** `08.21` (dashboard), `08.13` (navigation)

**Content areas:**
- User dashboard layout
- Welcome/header section
- Activity feed
- Stats cards
- Recent items
- Quick actions grid
- Notification center

---

### 08.31 — Blog UI

**Scope:** The blog listing and article pages.

**Key decisions:**
- SEO-optimized markup (structured data, semantic HTML)
- Responsive images
- Reading time estimate
- Table of contents for long articles

**Connections:** `08.47` (SEO), `08.23` (documentation), `08.35` (code highlighting)

**Content areas:**
- Blog listing page
- Blog article page
- Author card component
- Category/tag display
- Related articles section
- Comment section
- Social sharing buttons

---

### 08.32 — CMS UI

**Scope:** The content management system interface.

**Key decisions:**
- Block-based editor (similar to Gutenberg)
- Live preview
- Media library
- Drag-and-drop page builder

**Connections:** `08.40` (file upload), `08.24` (playground), `08.35` (code highlighting)

**Content areas:**
- CMS layout (editor + preview)
- Block editor component
- Block library (text, image, video, code, embed)
- Media library
- Page tree/navigation
- Publishing workflow
- Revision history

---

### 08.33 — Showcase UI

**Scope:** The showcase page for displaying GsmUi-powered projects.

**Key decisions:**
- Masonry/grid layout
- Project detail modal
- Filter by category/technology
- Before/after comparison

**Connections:** `08.26` (component showcase), `08.20` (overlays)

**Content areas:**
- Showcase listing page
- Project card component
- Project detail modal
- Category filter
- Technology filter
- Before/after slider
- Testimonial display

---

### 08.34 — Chart System

**Scope:** Data visualization components using Chart.js, ApexCharts, or ECharts adapter.

**Key decisions:**
- Chart.js as the primary charting library
- Consistent color palette from design tokens
- Responsive charts (resize with container)
- Accessible charts (aria-label, data tables as fallback)

**Connections:** `08.03` (tokens), `08.16` (accessibility), `08.18` (data display)

**Content areas:**
- Line chart component
- Bar chart component
- Pie/donut chart component
- Area chart component
- Scatter plot component
- Dashboard chart layout
- Chart color palette
- Responsive chart sizing
- Accessibility (screen reader data tables)
- Print-friendly chart export

---

### 08.35 — Code Highlighting

**Scope:** Syntax highlighting for code blocks in documentation and the playground.

**Key decisions:**
- Highlight.js or Prism.js for syntax highlighting
- Dark/light theme support (matches GsmUi theme)
- Line numbers (optional)
- Copy-to-clipboard button

**Connections:** `08.23` (documentation), `08.24` (playground), `08.55` (security — no eval)

**Content areas:**
- Code block component
- Language detection
- Theme integration (light/dark)
- Line numbers
- Copy button
- Line highlighting
- Diff display
- Inline code styling

---

### 08.36 — Search UI

**Scope:** The search experience across the GsmUi platform.

**Key decisions:**
- Command palette pattern (Cmd+K / Ctrl+K)
- Instant search (client-side for docs, server-side for marketplace)
- Search results grouped by type
- Keyboard navigation of results

**Connections:** `08.41` (command palette), `08.42` (shortcuts), `08.16` (accessibility)

**Content areas:**
- Search input component
- Command palette overlay
- Search results display
- Search suggestions/autocomplete
- Recent searches
- Keyboard shortcuts for search
- Search analytics

---

### 08.37 — Notification System

**Scope:** The toast/notification system for real-time user feedback.

**Key decisions:**
- Toast notifications (auto-dismiss, manual dismiss)
- Notification center (persistent notifications)
- Queue management (max visible, stacking)
- Sound/vibration options

**Connections:** `08.19` (feedback), `08.20` (overlays), `08.16` (accessibility)

**Content areas:**
- Toast component (info, success, warning, error)
- Notification center component
- Toast queue management
- Toast positioning (top-right, bottom-right)
- Notification read/unread state
- Notification grouping
- Sound notification option

---

### 08.38 — Modal System

**Scope:** The modal/dialog system with focus management and stacking.

**Key decisions:**
- Single modal at a time (no modal stacking)
- Focus trap within modal
- Scroll lock on body
- Close on backdrop click (optional)
- Close on Escape key

**Connections:** `08.20` (overlays), `08.16` (accessibility), `08.15` (animation)

**Content areas:**
- Modal component (sizes: sm, md, lg, full)
- Confirmation modal
- Form modal
- Full-screen modal
- Modal animation (fade, scale)
- Focus management
- Scroll lock
- Backdrop patterns
- Modal stacking prevention

---

### 08.39 — Table System

**Scope:** Data table component with sorting, filtering, pagination, and bulk actions.

**Key decisions:**
- Semantic `<table>` markup
- Server-side or client-side data (configurable)
- Virtual scrolling for large datasets
- Accessible sorting (`aria-sort`)

**Connections:** `08.18` (data display), `08.16` (accessibility), `08.17` (forms)

**Content areas:**
- Basic table component
- Sortable columns
- Filterable rows
- Paginated table
- Virtual scroll table
- Bulk action toolbar
- Row selection (checkbox)
- Column resize
- Export (CSV, PDF)
- Responsive table patterns

---

### 08.40 — File Upload

**Scope:** File upload components with drag-and-drop, preview, and progress.

**Key decisions:**
- Drag-and-drop zone
- File preview (images, documents)
- Upload progress indicator
- Multi-file upload
- File type validation

**Connections:** `08.17` (forms), `08.19` (feedback), `08.16` (accessibility)

**Content areas:**
- File drop zone component
- File input component
- File preview component (image, document, generic)
- Upload progress bar
- File list component
- File type validation
- Size limit validation
- Multi-file upload
- Accessibility (keyboard, screen reader)

---

### 08.41 — Command Palette

**Scope:** The Cmd+K / Ctrl+K command palette for quick actions.

**Key decisions:**
- Keyboard-first design
- Fuzzy search
- Grouped results (actions, navigation, recent)
- Extensible (plugins can add commands)

**Connections:** `08.36` (search), `08.42` (shortcuts), `08.20` (overlays)

**Content areas:**
- Command palette overlay
- Search input
- Command list (grouped)
- Command item (icon, label, shortcut)
- Recent commands
- Keyboard navigation
- Custom command registration

---

### 08.42 — Shortcuts

**Scope:** Keyboard shortcuts system for power users.

**Key decisions:**
- Global shortcuts (Cmd+K for search, Cmd+/ for help)
- Context-specific shortcuts (modal Escape, table navigation)
- Shortcut display in tooltips and help panels
- Customizable shortcuts (future)

**Connections:** `08.41` (command palette), `08.16` (accessibility), `08.52` (guidelines)

**Content areas:**
- Shortcut registry
- Global shortcut handler
- Context-specific shortcuts
- Shortcut display in tooltips
- Help panel with all shortcuts
- Shortcut customization (future)

---

### 08.43 — Dark Mode

**Scope:** Dark mode implementation details (companion to 08.04 theme architecture).

**Key decisions:**
- `.dark` class on `<html>` (not media query)
- Bootstrap script prevents FOUC
- localStorage persistence
- System preference detection

**Connections:** `08.04` (theme), `08.03` (tokens), `08.55` (security)

**Content areas:**
- Bootstrap script (inline, eval-free)
- `.dark` class toggle mechanism
- localStorage key and format
- System preference detection (`prefers-color-scheme`)
- CSS variable overrides for dark mode
- Component-specific dark mode adjustments
- Testing dark mode in Playwright

---

### 08.44 — Theme Switcher

**Scope:** The UI component for switching between themes.

**Key decisions:**
- Dropdown or toggle button
- Persisted to localStorage
- Dispatches `gsmui:theme-changed` event
- Accessible (keyboard, screen reader)

**Connections:** `08.04` (theme), `08.43` (dark mode), `08.52` (guidelines)

**Content areas:**
- Theme switcher component (toggle, dropdown)
- Theme persistence
- Theme change event
- Animation on theme change
- Accessible theme switching
- System preference option

---

### 08.45 — Internationalization (i18n)

**Scope:** How GsmUi supports multiple languages and locales.

**Key decisions:**
- `__()` for all user-facing strings in Blade
- RTL support via `dir` attribute
- Date/time formatting via `Intl.DateTimeFormat`
- Number formatting via `Intl.NumberFormat`

**Connections:** `08.07` (Blade), `08.10` (JS), `08.16` (accessibility)

**Content areas:**
- String extraction and translation
- Pluralization rules
- RTL layout support
- Date/time/number formatting
- Locale detection
- Language switcher component
- RTL testing

---

### 08.46 — Performance

**Scope:** Performance budgets, optimization strategies, and monitoring.

**Key decisions:**
- First contentful paint < 1.5s
- Time to interactive < 3s
- Bundle size budget: 90KB gzipped total
- Lazy loading for below-the-fold components

**Connections:** `08.51` (build pipeline), `08.15` (animation), `08.06` (CSS)

**Content areas:**
- Performance budgets
- Bundle size monitoring
- Lazy loading strategy
- Image optimization
- CSS optimization (containment, minimal reflows)
- JS optimization (code splitting, tree shaking)
- Caching strategy
- Performance testing in CI

---

### 08.47 — SEO

**Scope:** Search engine optimization for public-facing pages.

**Key decisions:**
- Server-rendered HTML (crawlers see full content)
- Semantic HTML (headings, landmarks, ARIA)
- Structured data (JSON-LD)
- Meta tags via Blade components

**Connections:** `08.01` (overview), `08.07` (Blade), `08.55` (security — JSON-LD)

**Content areas:**
- Meta tag components (title, description, og:image)
- Structured data (JSON-LD) templates
- Semantic HTML landmarks
- Sitemap generation
- Robots.txt configuration
- Canonical URLs
- Open Graph / Twitter Card tags

---

### 08.48 — PWA

**Scope:** Progressive Web App capabilities (offline support, installability).

**Key decisions:**
- Service worker for asset caching
- Web app manifest for installability
- Offline fallback page
- `worker-src 'self'` added to CSP

**Connections:** `08.55` (security — CSP), `08.46` (performance), `08.43` (dark mode)

**Content areas:**
- Service worker implementation
- Web app manifest
- Offline fallback page
- Cache strategy (cache-first for assets, network-first for API)
- Install prompt
- CSP additions for workers

---

### 08.49 — Testing

**Scope:** Testing strategy, tools, and protocols for the frontend.

**Key decisions:**
- Playwright for browser testing
- PHPUnit for PHP/CSP testing
- State matrix coverage for every component
- Screenshots after every CSS change
- Headless runs in CI

**Connections:** `08.52` (guidelines), `08.54` (storybook), `08.55` (security)

**Content areas:**
- Test pyramid (unit → integration → browser)
- Playwright setup and configuration
- Component test patterns (state matrix)
- Screenshot comparison testing
- CSP header testing
- Accessibility testing (axe-core)
- Performance testing
- CI integration

---

### 08.50 — Folder Structure

**Scope:** The directory layout for frontend assets, components, and configuration.

**Key decisions:**
- `stubs/resources/views/gsmui/<component>/index.blade.php` for all components
- `dist/` for built assets (never committed from this repo)
- `src/` for PHP service provider, manager, facade
- Config at `stubs/config/gsmui-pro-csp.php`

**Connections:** `08.07` (Blade), `08.51` (build pipeline)

**Content areas:**
- Complete directory tree
- Component directory structure
- Dist/ asset organization
- Config file locations
- Test file locations
- Documentation file locations

---

### 08.51 — Build Pipeline

**Scope:** The Vite build configuration for producing `dist/` assets.

**Key decisions:**
- Vite as the build tool
- Single entry point for `gsmui.js`
- Separate entry for `editor.js` (playground only)
- `manifest.json` for asset versioning
- No build config in the component repo (produced upstream)

**Connections:** `08.10` (JS), `08.06` (CSS), `08.50` (folder structure)

**Content areas:**
- Vite configuration
- Entry points (gsmui.js, editor.js, editor.css)
- Output format (ES modules, IIFE fallback)
- Manifest generation
- Source maps
- Tree shaking
- Code splitting strategy
- Asset hashing

---

### 08.52 — Component Guidelines

**Scope:** The detailed contract for every GsmUi component — class strings, ARIA patterns, prop ordering, size variants.

**Key decisions:**
- Internal consistency > external best practices
- Copy from sibling components before inventing
- Pixel-level parity (measure with Playwright, not eyeball)
- Verbatim class strings for trigger buttons, inputs, dialogs

**Connections:** `08.07` (Blade), `08.10` (JS), `08.16` (accessibility), `08.56` (coding standards)

**Content areas:**
- Component anatomy (trigger, content, action zones)
- Class string templates for every component type
- ARIA pattern reference
- Prop ordering convention
- Size variant specifications (sm, md, xs, lg)
- Disabled/invalid state styling
- Focus management patterns
- Cursor rules
- Dialog/popover styling (verbatim from date-picker)

---

### 08.53 — Documentation Generation

**Scope:** How component documentation is generated and maintained.

**Key decisions:**
- Preview section shows real component usage (dressed up)
- Code section shows minimal copy-paste target
- Props reference table auto-generated from component attributes
- ARIA documentation manual (generated from guidelines)

**Connections:** `08.23` (documentation), `08.26` (showcase), `08.52` (guidelines)

**Content areas:**
- Documentation template structure
- Preview/code separation
- Props table generation
- ARIA documentation
- Limitations documentation
- Example gallery
- Version documentation

---

### 08.54 — Storybook Strategy

**Scope:** How Storybook (or equivalent) is used for component development and visual testing.

**Key decisions:**
- Storybook as the component development environment
- Visual testing via screenshot comparison
- State matrix as stories (base, open, disabled, invalid, sizes, focus, empty)
- Accessibility addon for automated checks

**Connections:** `08.49` (testing), `08.52` (guidelines), `08.53` (documentation)

**Content areas:**
- Storybook setup
- Story patterns for GsmUi components
- Visual testing setup
- Accessibility addon configuration
- Story organization (by category)
- Interaction testing in Storybook
- Storybook build and deployment

---

### 08.55 — Frontend Security

**Scope:** CSP configuration, security headers, XSS mitigation, and secure development practices.

**Key decisions:**
- Zero external resources (no CDN, no external scripts)
- `script-src 'self'` (no `unsafe-eval`)
- `style-src 'self' 'unsafe-inline'` (for adoptedStyleSheets)
- `eval()`, `Function()`, `blob:` all forbidden
- Security headers middleware

**Connections:** `08.06` (CSS), `08.48` (PWA), `08.57` (page flow)

**Content areas:**
- Complete CSP directive reference
- Security headers (X-Content-Type-Options, Referrer-Policy, etc.)
- Subresource Integrity
- XSS attack vectors and mitigations
- CSRF protection
- Third-party script policy
- Secure development practices
- Input sanitization
- Session security
- Error handling security
- Production hardening checklist

---

### 08.56 — Coding Standards

**Scope:** Enforceable coding standards for all frontend work — file naming, JS patterns, Blade conventions, testing, documentation.

**Key decisions:**
- Internal consistency > external best practices
- Dead code is a liability (delete before shipping)
- Playwright verification is mandatory (no claiming "done" without it)
- Every user-facing string uses `__()` for localization

**Connections:** `08.52` (component guidelines), `08.49` (testing), `08.55` (security)

**Content areas:**
- Core philosophy (from AGENTS.md)
- Language/stack standards
- Naming and API standards
- File naming conventions
- JavaScript coding standards (setAttribute, MutationObserver, detangle, events)
- Blade template standards (attribute order, __(), ARIA patterns)
- CSS/Tailwind standards (utility-first, dark mode, focus, disabled, invalid)
- Testing standards (Playwright state matrix, PHP tests, assertions)
- Documentation standards
- Code review standards
- Performance standards
- Accessibility standards
- Git and version control standards
- CI/CD pipeline standards

---

### 08.57 — Complete Page Flow

**Scope:** The capstone document that traces a single page from Blade compilation through JS initialization, Livewire round-trip, and CSS reconciliation.

**Key decisions:**
- 12-phase lifecycle (bootstrap → Blade → assets → JS init → Livewire → CSS → verification)
- MutationObserver as the reconciliation bridge between Livewire DOM morphs and component state
- Server value always wins over optimistic client values
- Theme flip is pure CSS (no Livewire round-trip)

**Connections:** All documents in Section 08. References Section 07 (`07.60-complete-request-flow.md`) for the backend half.

**Content areas:**
- Phase 0: Bootstrap (pre-framework inline script)
- Phase 1: Blade compile and gsmui: render
- Phase 2: Asset delivery (dist/ bundles)
- Phase 3: gsmui.js initialization (mixins + MutationObserver)
- Phase 4: Livewire hydrate/request/hydrate cycle
- Phase 5: CSS and theme reconciliation
- Phase 6: Verification gate (Playwright)
- Phase 7: Error recovery and edge cases
- Phase 8: Lifecycle hooks and event flow
- Phase 9: Theme and dark mode reconciliation
- Phase 10: Scroll lock and focus management
- Phase 11: Accessibility state machine
- Phase 12: Performance optimization flow
- State reconciliation deep dive
- Cross-component communication
- Page navigation flow (full reload, wire:navigate, Folio)
- Complete lifecycle timing diagram
- Testing the complete flow (E2E scenarios)
- Synthesis paragraph

---

## Technology Stack Deep Dive

### Laravel 13

Laravel 13 provides the server-side foundation for GsmUi:

- **Blade templating engine** compiles `gsmui:` component directives into optimized PHP
- **Livewire 4** handles real-time component updates with signed/encrypted payloads
- **Artisan commands** for component scaffolding, publishing, and build automation
- **Service container** manages GsmUi service providers, middleware, and configuration
- **Middleware pipeline** handles CSP headers, security headers, authentication, and rate limiting
- **Routing** (including Laravel Folio for optional marketing/docs routes) maps URLs to controllers/components

**Version considerations:**
- Livewire 4 introduces morphing (precise DOM diffing) — critical for gsmui.js reconciliation
- Blade components support attribute forwarding (`$attributes->merge()`) — essential for GsmUi's composition model
- Service provider bootstrapping ensures `gsmui:` namespace is registered before any Blade compilation

### Livewire 4

Livewire 4 is the real-time backbone of GsmUi:

- **`wire:model`** binds component properties to DOM elements, enabling two-way data flow
- **Livewire morphs** apply server-rendered HTML changes to the client DOM with minimal disruption
- **Signed payloads** prevent tampering with Livewire requests (security)
- **Snapshot serialization** captures component state for hydration/dehydration cycles
- **Debouncing** (`wire:model.live` default 150ms) prevents excessive server requests
- **Error handling** (419 session expired, 422 validation, 500 server error) is built-in

**Integration with gsmui.js:**
- Livewire morphs the DOM → MutationObserver fires → component reconciles
- `detangle()` prevents sync loops between Livewire-driven and user-driven state changes
- `setAttribute`/`removeAttribute` from `utils.js` keeps MutationObserver informed

### Blade Components

GsmUi's Blade component system:

- **Anonymous components** — `stubs/resources/views/gsmui/<component>/index.blade.php`
- **`Gsmui::classes()`** — facade helper for class merging (never `Flux`)
- **`__()` localization** — all user-facing strings pass through translation
- **ARIA injection** — component attributes set ARIA roles, labels, and descriptions
- **Slot system** — default, named, and scoped slots for content composition
- **`$attributes->merge()`** — attribute forwarding for custom element composition

### Tailwind CSS v4

Tailwind v4 provides the utility-first CSS layer:

- **JIT compilation** — only generates CSS for classes actually used
- **`--gsmui-*` token integration** — custom design tokens as Tailwind theme extensions
- **`dark:` prefix** — conditional dark mode utilities (class-based, not media query)
- **`has-focus-visible:`** — custom variant for focus-visible on custom elements
- **Container queries** — `@container` and `@sm:`, `@md:`, etc. for component-level responsive
- **No plugins** — keep dependency surface minimal

### Vite

Vite handles the build pipeline:

- **ES module bundling** — modern output format with tree-shaking
- **`manifest.json`** — asset versioning for cache busting
- **Code splitting** — gsmui.js (core) separate from editor.js (playground)
- **Source maps** — for debugging in development
- **No Tailwind in Vite** — Tailwind runs as PostCSS plugin (standard approach)

### Alpine.js (Limited)

Alpine.js is used sparingly:

- **Approved:** Simple toggle patterns (`x-show`, `x-bind`)
- **Forbidden:** Disabled-state handling, component coordination, complex logic
- **Migration path:** When Alpine logic grows complex, move to vanilla JS in `dist/gsmui.js`
- **CSP consideration:** Alpine uses `eval()` internally for some directives — must be configured for CSP compliance or replaced

### Monaco Editor (Playground)

Monaco Editor powers the live playground:

- **Lazy-loaded** — only on playground pages
- **Theme integration** — Monaco theme matches GsmUi light/dark
- **Syntax highlighting** — supports Blade, PHP, JS, CSS, HTML
- **IntelliSense** — auto-completion for GsmUi component attributes

### Chart Libraries

Data visualization:

- **Chart.js** as primary (lightweight, extensible)
- **ApexCharts** as alternative (more chart types)
- **ECharts adapter** for complex dashboards
- All charting libraries loaded on-demand (not bundled in core)

### Icon Sets

Icon system:

- **Heroicons** — primary icon set (by Tailwind team)
- **Lucide** — secondary icon set (more icons, similar style)
- **All inline SVG** — no icon fonts, no external SVG files
- **currentColor** — icons inherit text color

### Design Token Engine

Token management:

- **CSS custom properties** — `--gsmui-*` variables defined in `:root` and `.dark`
- **Tailwind integration** — tokens mapped to Tailwind theme extensions
- **Runtime updates** — theme switcher updates variables via CSS cascade (no JS re-render)

### CSS Variables

Variable strategy:

- **Naming:** `--gsmui-{category}-{property}-{variant}`
- **Scope:** `:root` for light mode, `.dark` for dark mode overrides
- **Consumption:** Both CSS (`var(--gsmui-*)`) and Tailwind (`bg-(--gsmui-bg-primary)`)
- **Cascade:** Dark mode toggle changes `.dark` class → all variables swap automatically

### Motion & Animation Layer

Animation strategy:

- **CSS transitions** for state changes (opacity, transform)
- **`prefers-reduced-motion`** respected globally
- **GPU-accelerated** properties only (transform, opacity)
- **Duration scale:** 100ms / 200ms / 300ms / 500ms
- **Easing:** ease-out (entrances), ease-in (exits), ease-in-out (morphs)

---

## Major Frontend Domains — Detailed Descriptions

### Marketing Website

The marketing site is the public face of GsmUi:

- **Landing page:** Hero section, feature grid, pricing table, testimonials, CTA
- **Pricing page:** Plan comparison table, toggle (monthly/annual), feature matrix
- **About page:** Team, mission, history
- **Changelog page:** Version history with categorized changes
- **Blog:** Articles, tutorials, announcements
- **Contact:** Contact form, support links

**Technical considerations:**
- SEO-optimized (server-rendered, structured data, meta tags)
- Performance-critical (first contentful paint < 1.5s)
- Analytics integration (server-side preferred for CSP compliance)
- A/B testing capability (server-side, not client-side)

### Documentation Portal

The documentation site:

- **Sidebar navigation:** Hierarchical, collapsible
- **On-page TOC:** Auto-generated from headings
- **Code blocks:** Syntax highlighting, copy-to-clipboard
- **Search:** Client-side instant search
- **Version selector:** Switch between documentation versions
- **Interactive examples:** Embedded playground components

**Technical considerations:**
- Server-rendered for SEO and performance
- Client-side search ( Lunr.js or similar, CSP-safe)
- Code block component with dark/light theme support

### Component Explorer

The component explorer:

- **Browse all components** by category
- **Component detail page:** Description, props, ARIA, examples
- **State matrix display:** Every state visually demonstrated
- **Code snippets:** Copy-paste ready examples

**Technical considerations:**
- Auto-generated from component source (08.53)
- Interactive state toggles
- Responsive testing links

### Live Playground

The interactive playground:

- **Monaco Editor** for code editing
- **Live preview** pane (sandboxed rendering)
- **Props editor** panel (form-based)
- **Code export** (copy, download)

**Technical considerations:**
- Monaco loaded lazily (only on playground pages)
- Sandboxed preview (iframe or Shadow DOM for isolation)
- Monaco + GsmUi theme integration

### Theme Builder

The visual theme customization tool:

- **Color picker** for brand colors
- **Typography settings** (font family, sizes)
- **Spacing settings** (base unit, scale)
- **Preview pane** (sample components with new theme)
- **Export** (CSS variables, Tailwind config)

**Technical considerations:**
- Real-time preview via CSS variable updates
- Export as downloadable CSS/Tailwind config
- Import from URL or file

### Template Gallery

Pre-built page templates:

- **Landing page templates** (different styles)
- **Dashboard templates** (admin, analytics, project)
- **Auth templates** (login, register, forgot password)
- **Error templates** (404, 403, 500)
- **Form templates** (settings, profile, checkout)

**Technical considerations:**
- Templates use only GsmUi components
- Copy-paste ready (no external dependencies)
- Preview and code view

### Marketplace

The component/template marketplace:

- **Product listing** (grid/card layout)
- **Product detail** (description, preview, price)
- **Search and filter** (by category, price, rating)
- **Purchase flow** (Stripe integration)
- **Download management** (purchased items)

**Technical considerations:**
- SEO-optimized product pages
- Stripe integration for payments
- User authentication for purchases
- Download management with expiry

### User Dashboard

The authenticated user dashboard:

- **Activity feed** (recent actions)
- **Stats cards** (usage, projects, etc.)
- **Quick actions** (common tasks)
- **Notification center** (unread notifications)
- **Settings link**

**Technical considerations:**
- Livewire polling for real-time updates
- Responsive (sidebar collapses on mobile)
- Personalized content

### Admin Panel

The admin interface:

- **Multi-level sidebar** navigation
- **Data tables** with sorting, filtering, pagination
- **Form-heavy pages** (settings, configuration)
- **User management** (CRUD operations)
- **Role/permission management**
- **System health** dashboard

**Technical considerations:**
- Role-based UI visibility
- Bulk actions on data tables
- Audit logging display
- System configuration management

### Blog

The company blog:

- **Article listing** (grid/list layout)
- **Article detail** (rich content, code blocks)
- **Category/tag filtering**
- **Author profiles**
- **Comment system** (if enabled)
- **Social sharing**

**Technical considerations:**
- SEO-optimized (structured data, canonical URLs)
- Responsive images (srcset)
- Code highlighting in articles
- RSS feed

### CMS

The content management system:

- **Block editor** (drag-and-drop content blocks)
- **Media library** (image/file management)
- **Page tree** (content hierarchy)
- **Live preview** (real-time rendering)
- **Publishing workflow** (draft → review → publish)
- **Revision history**

**Technical considerations:**
- Block editor is complex — consider leveraging existing solutions
- Media library with upload, crop, resize
- Auto-save functionality
- Publishing permissions

### Showcase

The project showcase:

- **Project gallery** (masonry/grid layout)
- **Project detail** (screenshots, description, link)
- **Filter by category** (industry, technology, style)
- **Before/after comparison** (for redesign projects)

**Technical considerations:**
- Image optimization (lazy loading, WebP)
- Responsive images
- SEO-optimized project pages

---

## Recommended Implementation Order — Detailed

### Phase 1: Foundation (Weeks 1–4)

1. **08.01-overview.md** — Write the architectural overview
2. **08.02-design-system.md** — Define the visual language
3. **08.03-design-tokens.md** — Create the CSS variable system
4. **08.04-theme-architecture.md** — Implement light/dark theme
5. **08.05-tailwind-v4.md** — Configure Tailwind with GsmUi tokens
6. **08.06-css-architecture.md** — Establish the CSS loading strategy
7. **08.50-folder-structure.md** — Define the directory layout
8. **08.51-build-pipeline.md** — Set up Vite and the build process

**Deliverables:** Tailwind configured with tokens, theme switching working, build pipeline producing dist/ assets.

### Phase 2: Component System (Weeks 5–8)

9. **08.07-blade-component-system.md** — Define the Blade component architecture
10. **08.10-javascript-architecture.md** — Define the JS mixin and utility system
11. **08.52-component-guidelines.md** — Define the component contract (class strings, ARIA, sizes)
12. **08.56-coding-standards.md** — Establish coding standards
13. **08.11-icon-system.md** — Implement the icon system
14. **08.16-accessibility.md** — Define the accessibility requirements

**Deliverables:** Component system established, coding standards documented, first 5–10 components built (button, input, select, checkbox, toggle).

### Phase 3: Layout & Navigation (Weeks 9–12)

15. **08.12-layout-system.md** — Build layout primitives (containers, grids, stacks)
16. **08.13-navigation-system.md** — Build navigation components (nav, breadcrumbs, tabs)
17. **08.14-responsive-system.md** — Implement responsive behavior
18. **08.15-animation-system.md** — Add animation and motion

**Deliverables:** Page layout system working, navigation components built, responsive behavior implemented.

### Phase 4: Feature Components (Weeks 13–20)

19. **08.17-forms.md** — Build all form components
20. **08.18-data-display.md** — Build data display components
21. **08.19-feedback-components.md** — Build feedback components
22. **08.20-overlay-components.md** — Build overlay components (modal, popover, dropdown)
23. **08.34-chart-system.md** — Build chart components
24. **08.35-code-highlighting.md** — Implement code highlighting
25. **08.38-modal-system.md** — Build the modal system
26. **08.39-table-system.md** — Build the table system
27. **08.40-file-upload.md** — Build file upload components
28. **08.41-command-palette.md** — Build the command palette
29. **08.42-shortcuts.md** — Implement keyboard shortcuts
30. **08.37-notification-system.md** — Build the notification system

**Deliverables:** All core components built, tested, documented.

### Phase 5: Platform Pages (Weeks 21–28)

31. **08.21-dashboard-ui.md** — Build dashboard layout and components
32. **08.22-admin-ui.md** — Build admin panel layout and components
33. **08.23-documentation-ui.md** — Build documentation portal
34. **08.24-playground-ui.md** — Build the live playground
35. **08.25-theme-builder-ui.md** — Build the theme builder
36. **08.26-component-showcase.md** — Build the component showcase
37. **08.27-template-gallery.md** — Create template gallery
38. **08.28-marketplace-ui.md** — Build the marketplace
39. **08.29-billing-ui.md** — Build billing pages
40. **08.30-user-dashboard-ui.md** — Build user dashboard
41. **08.31-blog-ui.md** — Build blog pages
42. **08.32-cms-ui.md** — Build the CMS interface
43. **08.33-showcase-ui.md** — Build the project showcase
44. **08.36-search-ui.md** — Implement search experience

**Deliverables:** All platform pages built and functional.

### Phase 6: Quality & Polish (Weeks 29–32)

45. **08.08-livewire-architecture.md** — Finalize Livewire integration
46. **08.09-alpinejs-architecture.md** — Finalize Alpine.js usage
47. **08.43-dark-mode.md** — Polish dark mode
48. **08.44-theme-switcher.md** — Polish theme switcher
49. **08.45-internationalization.md** — Implement i18n
50. **08.46-performance.md** — Optimize performance
51. **08.47-seo.md** — Implement SEO
52. **08.48-pwa.md** — Implement PWA features
53. **08.49-testing.md** — Complete test coverage
54. **08.53-documentation-generation.md** — Generate component docs
55. **08.54-storybook-strategy.md** — Set up Storybook
56. **08.55-frontend-security.md** — Complete security audit
57. **08.57-complete-page-flow.md** — Finalize the complete page flow document

**Deliverables:** All quality gates passed, documentation complete, security verified.

---

## Risk Register

| Risk | Impact | Likelihood | Mitigation |
| --- | --- | --- | --- |
| Livewire morph incompatibility with gsmui.js MutationObserver | High | Medium | Early integration testing; detangle() as safety net |
| CSP `'unsafe-inline'` cannot be dropped for styles | Medium | High | Track adoptable stylesheet adoption; report progress |
| Bundle size exceeds budget | Medium | Medium | Automated size checks in CI; lazy loading strategy |
| Alpine.js eval() conflicts with CSP | High | Medium | Audit Alpine directives; replace with vanilla JS if needed |
| Dark mode FOUC on slow connections | Low | Medium | Inline bootstrap script; test on throttled connections |
| Third-party feature request breaks zero-external policy | High | Low | Exception request process; security review gate |
| Component inconsistency across 70+ components | High | High | Coding standards enforcement; automated linting |
| Playwright test flakiness | Medium | Medium | Deterministic test data; screenshot comparison tolerance |
| Monaco Editor bundle size | Low | Medium | Lazy load only on playground pages |
| RTL layout breaks in complex components | Medium | Medium | RTL testing in CI; `rtl:` Tailwind utilities |

---

## Architecture Decision Records (ADRs)

### ADR-001: Server-Rendered Blade + Livewire 4

**Status:** Accepted

**Context:** GsmUi needs a rendering approach that supports SEO, CSP compliance, and real-time interactivity.

**Decision:** Use Blade for server rendering and Livewire 4 for real-time updates.

**Consequences:**
- SEO-friendly (crawlers see full HTML)
- CSP-safe (no client-side rendering framework requiring eval)
- Real-time updates via wire:model
- Server-side state management reduces client-side complexity
- Trade-off: Less client-side flexibility than a SPA framework

### ADR-002: Self-Hosted Assets Only

**Status:** Accepted

**Context:** CSP compliance requires controlling all resources loaded by the page.

**Decision:** All JavaScript, CSS, fonts, and images are self-hosted. No CDN, no external scripts.

**Consequences:**
- Full CSP control (script-src 'self')
- No external dependencies to fail or compromise security
- Trade-off: Must host and serve all assets (CDN benefits lost)
- Must handle own cache invalidation and delivery

### ADR-003: MutationObserver as Reconciliation Bridge

**Status:** Accepted

**Context:** Livewire morphs the DOM, but GsmUi component JS needs to know when values change to reconcile internal state.

**Decision:** Use MutationObserver to watch `value` and config attributes on component elements.

**Consequences:**
- Components react to Livewire DOM changes without polling
- detangle() prevents sync loops between Livewire-driven and user-driven changes
- setAttribute/removeAttribute from utils.js ensures observer fires correctly
- Trade-off: Observer complexity; must be cleaned up properly (destroy())

### ADR-004: CSS-Only Dark Mode (No JS Re-render)

**Status:** Accepted

**Context:** Theme switching should be instant and not require Livewire round-trips.

**Decision:** Dark mode is a CSS class on <html> that triggers CSS variable cascade changes.

**Consequences:**
- Instant theme switching (no JS re-render, no Livewire request)
- Zero markup change for theme flip
- Bootstrap script prevents FOUC
- Trade-off: All theme variants must be expressible as CSS variable overrides

### ADR-005: System Fonts Over Web Fonts

**Status:** Accepted

**Context:** Web fonts add external dependencies, CSP complexity, and loading delay.

**Decision:** Use system font stack for all text. No @font-face declarations.

**Consequences:**
- Zero font loading delay
- No external font requests (CSP-safe)
- Consistent rendering across platforms (native feel)
- Trade-off: Less typographic control; font availability varies by OS
