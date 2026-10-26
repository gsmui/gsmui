# 03 - Brand Guidelines

**Project:** GsmUi
**Version:** 1.0.0

---

# Introduction

The GsmUi brand represents a modern, developer-first Laravel UI ecosystem. Every visual element, interaction, and communication should reinforce the values of simplicity, consistency, performance, and innovation.

These guidelines define the visual and verbal standards for all GsmUi products, including the website, documentation, component library, templates, admin panel, marketing assets, social media, and merchandise.

---

# Brand Vision

Build the most trusted and recognizable Laravel UI ecosystem by delivering beautiful, accessible, and highly productive developer experiences.

---

# Brand Mission

Enable developers to build professional Laravel applications faster through high-quality UI components, templates, documentation, and tooling.

---

# Brand Values

## Developer First

Every decision should improve the developer experience.

---

## Simplicity

Interfaces should be intuitive, uncluttered, and easy to learn.

---

## Consistency

Visual language, naming, spacing, and interactions should remain uniform across all products.

---

## Performance

Every page, component, and interaction should be optimized for speed and efficiency.

---

## Accessibility

All interfaces should meet or exceed WCAG 2.2 AA standards.

---

## Community

Encourage collaboration, contributions, and knowledge sharing within the Laravel ecosystem.

---

# Brand Personality

GsmUi should be perceived as:

* Modern
* Professional
* Friendly
* Reliable
* Innovative
* Clean
* Minimal
* Open
* Developer-focused

Avoid being:

* Overly corporate
* Overly playful
* Visually noisy
* Complex
* Trend-dependent

---

# Logo Guidelines

## Primary Logo

* Wordmark: **GsmUi**
* Simple geometric icon paired with the wordmark
* Flat design
* No gradients in the default version

---

## Logo Variants

* Primary
* Monochrome
* White
* Icon Only
* Horizontal
* Vertical
* Small Icon (favicon)
* App Icon

---

## Clear Space

Maintain clear space around the logo equal to the height of the "G".

---

## Minimum Size

Digital:

* 24px height

Print:

* 8mm height

---

# Color System

## Primary Colors

The primary palette is the foundation of the GsmUi brand. It communicates trust, professionalism, and modernity.

| Token | Hex (Light) | Hex (Dark) | Purpose | Usage |
|-------|-------------|------------|---------|-------|
| Primary | `#6366f1` | `#818cf8` | Brand identity, primary CTAs, key interactive elements | Headers, buttons, links, active indicators |
| Primary Hover | `#4f46e5` | `#a5b4fc` | Interactive hover states | Button hover, link hover, card hover |
| Primary Active | `#4338ca` | `#c7d2fe` | Active/pressed states | Button active, selected tab, active link |
| Primary Subtle | `#eef2ff` | `#1e1b4b` | Subtle backgrounds, highlights | Selection bg, hover bg, notification bg |
| Primary Muted | `#c7d2fe` | `#3730a3` | Muted accents, borders | Tag bg, badge bg, subtle borders |

### Primary Color Psychology

Indigo was chosen for its psychological associations:

* **Trust**: Indigo is universally associated with reliability and dependability
* **Intelligence**: Reflects the technical, developer-focused nature of the platform
* **Stability**: Conveys a sense of established quality without being corporate
* **Innovation**: Modern indigo tones feel fresh and forward-thinking
* **Calm**: Reduces visual anxiety in complex developer interfaces

### Primary Color Accessibility

| Combination | Contrast Ratio | WCAG AA | WCAG AAA |
|-------------|---------------|---------|----------|
| Primary on White | 4.6:1 | Pass (normal text) | Fail |
| Primary on White | 4.6:1 | Pass (large text) | Pass (large text) |
| White on Primary | 4.6:1 | Pass (normal text) | Fail |
| Primary on Dark (`#1a1a2e`) | 7.2:1 | Pass | Pass |
| Primary Hover on White | 6.8:1 | Pass | Pass |
| Primary Active on White | 8.1:1 | Pass | Pass |

### Primary Color Usage Rules

1. Primary color must never be used for large background fills exceeding 200px²
2. Primary text on primary backgrounds must use white or `--gsm-primary-subtle`
3. Minimum 4.5:1 contrast ratio required for all primary text combinations
4. Primary gradients are permitted only in marketing hero sections (max 2 per page)
5. Primary color must not be applied to icons smaller than 16px without sufficient contrast

---

## Secondary Colors

Secondary colors complement the primary palette and provide additional expressive range.

| Token | Hex (Light) | Hex (Dark) | Purpose | Usage |
|-------|-------------|------------|---------|-------|
| Secondary | `#0ea5e9` | `#38bdf8` | Supporting accents, links, secondary CTAs | Secondary buttons, inline links, highlights |
| Secondary Hover | `#0284c7` | `#7dd3fc` | Hover states for secondary elements | Button hover, link hover |
| Secondary Active | `#0369a1` | `#bae6fd` | Active/pressed states | Button active |
| Secondary Subtle | `#f0f9ff` | `#0c4a6e` | Subtle backgrounds | Info banners, subtle highlights |

### Secondary Color Psychology

Sky blue communicates:

* **Clarity**: Open, clean, and transparent
* **Communication**: Approachable and friendly
* **Openness**: Inviting and non-threatening
* **Technical**: Associated with developer tools and cloud platforms

### Secondary Color Accessibility

| Combination | Contrast Ratio | WCAG AA | WCAG AAA |
|-------------|---------------|---------|----------|
| Secondary on White | 3.8:1 | Fail (normal) | Fail |
| Secondary on White | 3.8:1 | Pass (large text) | Fail |
| White on Secondary | 3.8:1 | Fail (normal) | Fail |
| Secondary on Dark (`#1a1a2e`) | 6.5:1 | Pass | Pass |

**Important**: Secondary color must only be used for large text (18px+ bold or 24px+ regular) when on white backgrounds, or paired with dark backgrounds.

---

## Accent Colors

Accent colors are used sparingly for emphasis, notifications, and interactive highlights.

| Token | Hex (Light) | Hex (Dark) | Purpose | Usage |
|-------|-------------|------------|---------|-------|
| Accent | `#f59e0b` | `#fbbf24` | Highlights, badges, star ratings | Star ratings, badges, callouts |
| Accent Hover | `#d97706` | `#fcd34d` | Hover states for accent elements | Button hover |
| Accent Subtle | `#fffbeb` | `#78350f` | Subtle backgrounds | Warning banners, highlighted content |

---

## Neutral Palette

The neutral palette forms the backbone of the interface, providing structure and hierarchy.

| Token | Hex (Light) | Hex (Dark) | Purpose | Usage |
|-------|-------------|------------|---------|-------|
| Background | `#ffffff` | `#0f172a` | Page background | Body bg, main container |
| Foreground | `#0f172a` | `#f8fafc` | Primary text color | Body text, headings |
| Surface | `#f8fafc` | `#1e293b` | Card/panel backgrounds | Cards, modals, popovers |
| Surface Hover | `#f1f5f9` | `#334155` | Interactive surface hover | Card hover, list item hover |
| Surface Active | `#e2e8f0` | `#475569` | Active surface states | Selected list item |
| Border | `#e2e8f0` | `#334155` | Default borders | Card borders, dividers, inputs |
| Border Strong | `#cbd5e1` | `#475569` | Emphasized borders | Focused inputs, active tabs |
| Divider | `#f1f5f9` | `#1e293b` | Section separators | Horizontal rules, list dividers |
| Muted | `#64748b` | `#94a3b8` | Secondary text, placeholders | Captions, hints, disabled text |
| Muted Foreground | `#475569` | `#cbd5e1` | Subdued text | Descriptions, meta text |

### Neutral Color Accessibility

| Combination | Contrast Ratio | WCAG AA | WCAG AAA |
|-------------|---------------|---------|----------|
| Foreground on Background | 16.8:1 | Pass | Pass |
| Muted on Background | 5.2:1 | Pass | Fail |
| Muted Foreground on Background | 7.4:1 | Pass | Pass |
| Background on Surface | 1.04:1 | N/A (decorative) | N/A |
| Border on Background | 1.3:1 | N/A (decorative) | N/A |

### Neutral Color Rules

1. Text must always use `--gsm-foreground` or `--gsm-muted-foreground` — never raw black or white
2. Backgrounds must use `--gsm-background` or `--gsm-surface` — never raw hex values
3. Borders must use `--gsm-border` — never `border-gray-300` or similar utility classes
4. Disabled states must use `--gsm-muted` with 50% opacity
5. Placeholder text must use `--gsm-muted`

---

## Semantic Colors

Each semantic color communicates system state and requires specific contrast ratios.

### Success

| Token | Hex (Light) | Hex (Dark) | Usage |
|-------|-------------|------------|-------|
| Success 50 | `#f0fdf4` | `#022c22` | Success background |
| Success 100 | `#dcfce7` | `#064e3b` | Success light bg |
| Success 200 | `#bbf7d0` | `#065f46` | Success border |
| Success 300 | `#86efac` | `#047857` | Success icon |
| Success 400 | `#4ade80` | `#10b981` | Success accent |
| Success 500 | `#22c55e` | `#34d399` | Primary success |
| Success 600 | `#16a34a` | `#6ee7b7` | Success text on dark |
| Success 700 | `#15803d` | `#a7f3d0` | Success dark text |
| Success 800 | `#166534` | `#d1fae5` | Success subtle |
| Success 900 | `#14532d` | `#ecfdf5` | Success faint |
| Success 950 | `#052e16` | `#f0fdf4` | Success ghost |

**Accessibility**: Success 500 on white = 2.9:1 (Fail for text). Use Success 700+ for text, Success 500 for icons only.

### Warning

| Token | Hex (Light) | Hex (Dark) | Usage |
|-------|-------------|------------|-------|
| Warning 50 | `#fffbeb` | `#451a03` | Warning background |
| Warning 100 | `#fef3c7` | `#78350f` | Warning light bg |
| Warning 200 | `#fde68a` | `#92400e` | Warning border |
| Warning 300 | `#fcd34d` | `#b45309` | Warning icon |
| Warning 400 | `#fbbf24` | `#d97706` | Warning accent |
| Warning 500 | `#f59e0b` | `#f59e0b` | Primary warning |
| Warning 600 | `#d97706` | `#fbbf24` | Warning text on dark |
| Warning 700 | `#b45309` | `#fcd34d` | Warning dark text |
| Warning 800 | `#92400e` | `#fde68a` | Warning subtle |
| Warning 900 | `#78350f` | `#fef3c7` | Warning faint |
| Warning 950 | `#451a03` | `#fffbeb` | Warning ghost |

**Accessibility**: Warning 500 on white = 2.2:1 (Fail for text). Use Warning 700+ for text, Warning 500 for icons only.

### Error

| Token | Hex (Light) | Hex (Dark) | Usage |
|-------|-------------|------------|-------|
| Error 50 | `#fef2f2` | `#450a0a` | Error background |
| Error 100 | `#fee2e2` | `#7f1d1d` | Error light bg |
| Error 200 | `#fecaca` | `#991b1b` | Error border |
| Error 300 | `#fca5a5` | `#b91c1c` | Error icon |
| Error 400 | `#f87171` | `#dc2626` | Error accent |
| Error 500 | `#ef4444` | `#f87171` | Primary error |
| Error 600 | `#dc2626` | `#fca5a5` | Error text on dark |
| Error 700 | `#b91c1c` | `#fecaca` | Error dark text |
| Error 800 | `#991b1b` | `#fee2e2` | Error subtle |
| Error 900 | `#7f1d1d` | `#fef2f2` | Error faint |
| Error 950 | `#450a0a` | `#fef2f2` | Error ghost |

**Accessibility**: Error 500 on white = 3.9:1 (Fail for normal text). Use Error 600+ for text, Error 500 for icons.

### Info

| Token | Hex (Light) | Hex (Dark) | Usage |
|-------|-------------|------------|-------|
| Info 50 | `#eff6ff` | `#172554` | Info background |
| Info 100 | `#dbeafe` | `#1e3a5f` | Info light bg |
| Info 200 | `#bfdbfe` | `#1e40af` | Info border |
| Info 300 | `#93c5fd` | `#2563eb` | Info icon |
| Info 400 | `#60a5fa` | `#3b82f6` | Info accent |
| Info 500 | `#3b82f6` | `#60a5fa` | Primary info |
| Info 600 | `#2563eb` | `#93c5fd` | Info text on dark |
| Info 700 | `#1d4ed8` | `#bfdbfe` | Info dark text |
| Info 800 | `#1e40af` | `#dbeafe` | Info subtle |
| Info 900 | `#1e3a8a` | `#eff6ff` | Info faint |
| Info 950 | `#172554` | `#eff6ff` | Info ghost |

**Accessibility**: Info 500 on white = 3.6:1 (Fail for normal text). Use Info 700+ for text, Info 500 for icons.

---

## Extended Palette

### Surface Variations

| Token | Hex (Light) | Hex (Dark) | Usage |
|-------|-------------|------------|-------|
| Surface Raised | `#ffffff` | `#1e293b` | Elevated cards, popovers |
| Surface Sunken | `#f1f5f9` | `#0f172a` | Inset areas, code blocks |
| Surface Overlay | `rgba(0,0,0,0.5)` | `rgba(0,0,0,0.7)` | Modal backdrops, tooltips |

### Interactive States

| Token | Hex (Light) | Hex (Dark) | Usage |
|-------|-------------|------------|-------|
| Focus Ring | `#6366f1` | `#818cf8` | Keyboard focus indicators |
| Focus Ring Offset | `#ffffff` | `#0f172a` | Focus ring background |
| Selection | `#eef2ff` | `#1e1b4b` | Text selection background |
| Selection Text | `#4338ca` | `#c7d2fe` | Selected text color |

### Brand Gradient

Primary gradient (marketing use only):

```css
--gsm-gradient-primary: linear-gradient(135deg, #6366f1 0%, #0ea5e9 100%);
```

Secondary gradient (marketing use only):

```css
--gsm-gradient-secondary: linear-gradient(135deg, #0ea5e9 0%, #22c55e 100%);
```

**Gradient Rules**:
1. Maximum 2 gradients per page
2. Only in marketing/hero sections
3. Never in component backgrounds
4. Never behind text without sufficient contrast overlay
5. Must pass WCAG AA contrast when used with text

---

# Theme Architecture

Every theme must define design tokens for:

## Colors

* Primary
* Secondary
* Accent
* Neutral
* Base
* Surface
* Success
* Warning
* Error
* Info

---

## Typography

* Heading
* Body
* Mono

---

## Borders

* Radius
* Width
* Style

---

## Shadows

* XS
* SM
* MD
* LG
* XL
* XXL

---

## Spacing

Based on an 8px grid. All spacing in GsmUi derives from a base unit of 8px, ensuring visual rhythm and consistency across all components.

### Spacing Scale

| Token | Value | Pixels | Usage |
|-------|-------|--------|-------|
| `--gsm-space-0` | 0 | 0px | Reset, no spacing |
| `--gsm-space-px` | 1px | 1px | Borders, hairline dividers |
| `--gsm-space-0.5` | 0.125rem | 2px | Tight internal padding |
| `--gsm-space-1` | 0.25rem | 4px | Icon gaps, compact spacing |
| `--gsm-space-1.5` | 0.375rem | 6px | Small internal padding |
| `--gsm-space-2` | 0.5rem | 8px | Base unit, small gaps |
| `--gsm-space-2.5` | 0.625rem | 10px | Form field padding |
| `--gsm-space-3` | 0.75rem | 12px | Button padding (SM), card padding |
| `--gsm-space-3.5` | 0.875rem | 14px | Input padding |
| `--gsm-space-4` | 1rem | 16px | Standard gap, card padding |
| `--gsm-space-5` | 1.25rem | 20px | Section spacing |
| `--gsm-space-6` | 1.5rem | 24px | Component spacing |
| `--gsm-space-7` | 1.75rem | 28px | Large section spacing |
| `--gsm-space-8` | 2rem | 32px | Major section breaks |
| `--gsm-space-9` | 2.25rem | 36px | Extra large spacing |
| `--gsm-space-10` | 2.5rem | 40px | Page section spacing |
| `--gsm-space-12` | 3rem | 48px | Section dividers |
| `--gsm-space-14` | 3.5rem | 56px | Large section breaks |
| `--gsm-space-16` | 4rem | 64px | Major page sections |
| `--gsm-space-20` | 5rem | 80px | Hero section spacing |
| `--gsm-space-24` | 6rem | 96px | Page-level spacing |
| `--gsm-space-32` | 8rem | 128px | Maximum spacing |

### Spacing Rules

1. **8px grid alignment**: All spacing must be a multiple of 8px (or 4px for tight spaces)
2. **Consistent component padding**: Use `--gsm-space-4` (16px) as default component padding
3. **Section spacing**: Use `--gsm-space-8` (32px) minimum between major sections
4. **Element gaps**: Use `--gsm-space-2` (8px) for related items, `--gsm-space-4` (16px) for distinct groups
5. **Never use arbitrary values**: All spacing must come from the spacing scale

### Spacing in Components

| Component | Padding | Gap | Notes |
|-----------|---------|-----|-------|
| Button (XS) | 8px 12px | — | `--gsm-space-2` × `--gsm-space-3` |
| Button (SM) | 8px 16px | — | `--gsm-space-2` × `--gsm-space-4` |
| Button (MD) | 12px 24px | — | `--gsm-space-3` × `--gsm-space-6` |
| Button (LG) | 16px 32px | — | `--gsm-space-4` × `--gsm-space-8` |
| Card | 16px | 16px | `--gsm-space-4` |
| Modal | 24px | 16px | `--gsm-space-6` × `--gsm-space-4` |
| Input | 8px 12px | — | `--gsm-space-2` × `--gsm-space-3` |
| Table cell | 12px 16px | — | `--gsm-space-3` × `--gsm-space-4` |
| Badge | 4px 8px | — | `--gsm-space-1` × `--gsm-space-2` |
| Tooltip | 8px 12px | — | `--gsm-space-2` × `--gsm-space-3` |

### Responsive Spacing

Spacing scales down on smaller screens:

```css
/* Mobile: tighter spacing */
.section { padding: var(--gsm-space-6); } /* 24px */

/* Tablet: standard spacing */
@media (min-width: 768px) {
  .section { padding: var(--gsm-space-8); } /* 32px */
}

/* Desktop: generous spacing */
@media (min-width: 1024px) {
  .section { padding: var(--gsm-space-12); } /* 48px */
}
```

---

# Typography

## Font Stack

### Sans

Primary interface font. Inter is the default for its excellent readability at small sizes and comprehensive character set.

```css
--gsm-font-sans: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
```

**Why Inter?**
* Designed specifically for computer screens
* Excellent legibility at small sizes (11px-14px)
* Tabular numbers for data tables
* Large x-height for improved readability
* Free and open-source (SIL Open Font License)

### Serif

Marketing pages only. Used for long-form content and editorial sections.

```css
--gsm-font-serif: 'Lora', Georgia, 'Times New Roman', serif;
```

**Usage Rules**:
* Hero section headings on marketing pages
* Blog post titles and long-form content
* Testimonial quotes
* Never in component interfaces, dashboards, or forms

### Monospace

Code blocks, terminal output, and technical data.

```css
--gsm-font-mono: 'JetBrains Mono', 'Fira Code', 'Cascadia Code', Consolas, monospace;
```

**Usage Rules**:
* Code examples and snippets
* Terminal/command-line output
* API references and technical data
* Version numbers and hash values
* Never for body text, labels, or navigation

---

## Type Scale

The type scale follows a modular scale with a 1.25 ratio (major third) for harmonious progression.

### Desktop Scale (≥1024px)

| Token | Size | Line Height | Letter Spacing | Weight | Usage |
|-------|------|-------------|----------------|--------|-------|
| `text-xs` | 12px | 16px (1.33) | 0 | 400 | Captions, badges, timestamps |
| `text-sm` | 14px | 20px (1.43) | 0 | 400 | Secondary text, descriptions |
| `text-base` | 16px | 24px (1.5) | 0 | 400 | Body text, paragraphs |
| `text-lg` | 18px | 28px (1.56) | -0.01em | 400 | Lead paragraphs, intros |
| `text-xl` | 20px | 28px (1.4) | -0.01em | 500 | Card titles, section headers |
| `text-2xl` | 24px | 32px (1.33) | -0.02em | 600 | H4, subsection titles |
| `text-3xl` | 30px | 36px (1.2) | -0.02em | 600 | H3, component titles |
| `text-4xl` | 36px | 40px (1.11) | -0.03em | 700 | H2, section titles |
| `text-5xl` | 48px | 48px (1.0) | -0.03em | 700 | H1, hero headings |
| `text-6xl` | 60px | 56px (0.93) | -0.04em | 800 | Display, marketing heroes |
| `text-7xl` | 72px | 64px (0.89) | -0.04em | 800 | Large display |

### Mobile Scale (≤640px)

| Token | Size | Line Height | Letter Spacing | Weight |
|-------|------|-------------|----------------|--------|
| `text-xs` | 10px | 14px (1.4) | 0 | 400 |
| `text-sm` | 12px | 16px (1.33) | 0 | 400 |
| `text-base` | 14px | 20px (1.43) | 0 | 400 |
| `text-lg` | 16px | 24px (1.5) | 0 | 400 |
| `text-xl` | 18px | 24px (1.33) | -0.01em | 500 |
| `text-2xl` | 20px | 28px (1.4) | -0.01em | 600 |
| `text-3xl` | 24px | 32px (1.33) | -0.02em | 600 |
| `text-4xl` | 28px | 36px (1.29) | -0.02em | 700 |
| `text-5xl` | 36px | 40px (1.11) | -0.03em | 700 |
| `text-6xl` | 44px | 48px (1.09) | -0.03em | 800 |
| `text-7xl` | 52px | 52px (1.0) | -0.04em | 800 |

### Responsive Behavior

Typography must scale smoothly across breakpoints:

```html
<!-- Example: Responsive heading -->
<h1 class="text-4xl md:text-5xl lg:text-6xl font-bold tracking-tight">
  Hero Title
</h1>

<!-- Example: Responsive body -->
<p class="text-sm md:text-base lg:text-lg text-muted-foreground">
  Lead paragraph text
</p>
```

---

## Font Weights

| Weight | Name | CSS Value | Usage |
|--------|------|-----------|-------|
| 400 | Regular | `font-normal` | Body text, paragraphs, labels |
| 500 | Medium | `font-medium` | Emphasized text, navigation, buttons |
| 600 | Semibold | `font-semibold` | Subheadings, card titles, table headers |
| 700 | Bold | `font-bold` | Headings, strong emphasis |
| 800 | Extrabold | `font-extrabold` | Hero text, display type (marketing only) |

**Weight Rules**:
1. Never use font weights below 400 in the interface
2. Body text must always be weight 400
3. Headings progress from 600 (H3) to 800 (Display)
4. Maximum 2 font weights per component
5. Bold (700) is the maximum for body text; display type may use 800

---

## Line Height

Line height is critical for readability and accessibility.

| Context | Line Height | Reasoning |
|---------|-------------|-----------|
| Headings | 1.1-1.3 | Tighter for visual impact |
| Body text | 1.5-1.6 | Optimal reading rhythm |
| Code blocks | 1.5-1.7 | Clear line separation |
| Small text | 1.3-1.4 | Compact but legible |
| Labels | 1.2-1.3 | Single-line, tight |

### Line Height Accessibility

* Body text line height must be ≥1.5 for WCAG AAA compliance
* Paragraph spacing must be ≥0.5× the font size
* Line spacing must not be less than 1.3 for any text content

---

## Letter Spacing

| Context | Letter Spacing | Usage |
|---------|---------------|-------|
| Tight | -0.04em | Large display headings (48px+) |
| Normal | -0.02em | Headings (24px-48px) |
| Default | 0 | Body text, labels |
| Wide | 0.05em | Uppercase labels, badges |
| Extra Wide | 0.1em | Small uppercase labels, timestamps |

**Rules**:
* Never apply positive letter spacing to body text
* Negative letter spacing only on text ≥24px
* Uppercase text always uses 0.05em minimum
* Code text never uses letter spacing adjustments

---

## Text Truncation

When text exceeds its container:

```html
<!-- Single line truncation -->
<p class="truncate max-w-xs">Long text content here...</p>

<!-- Multi-line truncation -->
<p class="line-clamp-2">Long paragraph content that wraps to multiple lines and is truncated after two lines.</p>
```

**Truncation Rules**:
1. Always indicate truncation visually (ellipsis)
2. Provide tooltip or expand mechanism for truncated content
3. Never truncate critical information (error messages, prices, names)
4. Truncation limits: 1 line for titles, 2-3 lines for descriptions

---

## Typography in Components

### Buttons

| Size | Font Size | Weight | Letter Spacing | Line Height |
|------|-----------|--------|----------------|-------------|
| XS | 12px | 500 | 0.02em | 16px |
| SM | 14px | 500 | 0.01em | 20px |
| MD | 14px | 500 | 0.01em | 20px |
| LG | 16px | 500 | 0 | 24px |

### Form Inputs

| Element | Font Size | Weight | Line Height | Color |
|---------|-----------|--------|-------------|-------|
| Placeholder | 14px | 400 | 20px | `--gsm-muted` |
| Value | 14px | 400 | 20px | `--gsm-foreground` |
| Label | 14px | 500 | 20px | `--gsm-foreground` |
| Helper | 12px | 400 | 16px | `--gsm-muted` |
| Error | 12px | 400 | 16px | `--gsm-error-600` |

### Navigation

| Element | Font Size | Weight | Letter Spacing | Color |
|---------|-----------|--------|----------------|-------|
| Nav item | 14px | 500 | 0 | `--gsm-muted-foreground` |
| Nav item active | 14px | 600 | 0 | `--gsm-primary` |
| Breadcrumb | 14px | 400 | 0 | `--gsm-muted` |
| Tab | 14px | 500 | 0 | `--gsm-muted-foreground` |

---

## Typography Accessibility

### Minimum Sizes

| Context | Minimum Size | Reasoning |
|---------|-------------|-----------|
| Body text | 16px | Standard readability |
| Form labels | 14px | Clear identification |
| Captions | 12px | Supporting info |
| Error messages | 12px | Must be readable |

### Readability Requirements

1. **Contrast ratios**: All text must meet WCAG AA (4.5:1 normal, 3:1 large)
2. **Line length**: 45-75 characters per line for body text
3. **Paragraph spacing**: ≥0.5× font size between paragraphs
4. **Text alignment**: Left-aligned for LTR, right-aligned for RTL
5. **Font smoothing**: Enable antialiasing on macOS (`-webkit-font-smoothing: antialiased`)

### Dyslexia Considerations

* Use Inter's dyslexia-friendly features (open letterforms, distinct characters)
* Avoid justified text in body content
* Maintain consistent line spacing
* Use adequate contrast without excessive brightness

---

# Iconography

## Icon System

Use a single, unified icon system throughout the platform. GsmUi uses Heroicons as its base set, with custom icons for brand-specific elements.

## Icon Style

### Outline Style (Default)

* 1.5px stroke width (at 24px base size)
* Rounded line caps and joins
* No filled areas
* Consistent 2px optical spacing between elements
* Minimum 2px padding from canvas edge

### Solid Style (Secondary)

* Used sparingly for active states and emphasis
* 24×24px canvas
* Filled with current color (`currentColor`)
* Only for: active navigation, selected checkboxes, filled bookmarks

### Rules

* Never mix outline and solid styles within a single UI context
* Default to outline style unless design system specifies solid
* Icons must use `currentColor` to inherit text color
* Never apply custom colors to icons without design review

---

## Icon Grid

All icons are built on a consistent grid system.

### Canvas Sizes

| Size | Canvas | Stroke | Usage |
|------|--------|--------|-------|
| 16px | 16×16 | 1.5px | Inline text, badges, compact UI |
| 20px | 20×20 | 1.5px | Form inputs, buttons, navigation |
| 24px | 24×24 | 1.5px | Default, most UI elements |
| 32px | 32×32 | 2px | Feature highlights, cards |
| 48px | 48×48 | 2px | Empty states, onboarding |
| 64px | 64×64 | 2.5px | Hero sections, marketing |

### Grid Construction

* **Pixel grid**: All icons snap to a 1px pixel grid
* **Optical alignment**: Visual center, not mathematical center
* **Padding**: 2px minimum padding at base size (scales proportionally)
* **Key shapes**: Use consistent geometric primitives (circles, squares, lines)

---

## Icon Categories

### Navigation Icons

Icons for wayfinding and orientation.

| Icon | Name | Usage |
|------|------|-------|
| `home` | Home | Main navigation, dashboard link |
| `menu` | Menu | Mobile hamburger, sidebar toggle |
| `chevron-right` | Chevron Right | Breadcrumbs, expandable items |
| `chevron-down` | Chevron Down | Dropdowns, accordions |
| `arrow-left` | Arrow Left | Back navigation |
| `arrow-right` | Arrow Right | Forward navigation, CTAs |
| `search` | Search | Search functionality |
| `close` | Close | Dismiss modals, close panels |

### Action Icons

Icons for user actions and operations.

| Icon | Name | Usage |
|------|------|-------|
| `plus` | Plus | Add new items, create |
| `pencil` | Pencil | Edit, modify |
| `trash` | Trash | Delete, remove |
| `copy` | Copy | Duplicate, clipboard |
| `download` | Download | Export, save |
| `upload` | Upload | Import, file upload |
| `share` | Share | Share functionality |
| `bookmark` | Bookmark | Save, favorite |

### Status Icons

Icons for system state and feedback.

| Icon | Name | Usage |
|------|------|-------|
| `check-circle` | Check Circle | Success, completed |
| `exclamation-triangle` | Warning Triangle | Warning, attention |
| `x-circle` | X Circle | Error, failed |
| `information-circle` | Information | Info, help |
| `question-mark-circle` | Question | Help, FAQ |
| `clock` | Clock | Pending, loading |

### Content Icons

Icons for content types and media.

| Icon | Name | Usage |
|------|------|-------|
| `document` | Document | Files, pages |
| `folder` | Folder | Categories, directories |
| `image` | Image | Photos, media |
| `video` | Video | Video content |
| `link` | Link | URLs, references |
| `code` | Code | Code snippets, development |
| `terminal` | Terminal | Command line, CLI |

---

## Icon Sizing Rules

### Size Progression

```
16px → 20px → 24px → 32px → 48px → 64px
```

### Context-Specific Sizing

| Context | Size | Reasoning |
|---------|------|-----------|
| Inline with text | Match text size | Visual alignment |
| Button (XS) | 16px | Compact buttons |
| Button (SM/MD) | 20px | Standard buttons |
| Button (LG) | 24px | Large buttons |
| Form input prefix | 20px | Visual balance |
| Form input suffix | 16px | Subtle action |
| Navigation item | 20px | Clear identification |
| Card header | 24px | Section emphasis |
| Empty state | 48-64px | Visual impact |
| Onboarding | 48-64px | Guidance emphasis |

### Icon + Text Pairing

```html
<!-- Leading icon -->
<button class="inline-flex items-center gap-2">
  <svg class="w-5 h-5"><!-- icon --></svg>
  <span>Button Text</span>
</button>

<!-- Trailing icon -->
<button class="inline-flex items-center gap-2">
  <span>Button Text</span>
  <svg class="w-4 h-4"><!-- icon --></svg>
</button>
```

**Spacing Rules**:
* 4px gap between icon and text (default)
* 8px gap when icon is 24px+
* 2px gap for compact inline text
* Icons must vertically center with text baseline

---

## Icon Accessibility

### ARIA Requirements

* Decorative icons: `aria-hidden="true"` (no semantic meaning)
* Interactive icons: Must have accessible name (text label or `aria-label`)
* Status icons: Must include `role="img"` with `aria-label`
* Icon buttons: Must have `aria-label` describing the action

### Examples

```html
<!-- Decorative icon -->
<svg class="w-5 h-5" aria-hidden="true">
  <!-- icon path -->
</svg>

<!-- Interactive icon button -->
<button aria-label="Delete item">
  <svg class="w-5 h-5" aria-hidden="true">
    <!-- trash icon -->
  </svg>
</button>

<!-- Status icon with label -->
<div role="img" aria-label="Success">
  <svg class="w-5 h-5 text-success-500" aria-hidden="true">
    <!-- check-circle icon -->
  </svg>
</div>
```

### Contrast Requirements

| Background | Icon Color | Contrast |
|------------|-----------|----------|
| White | `--gsm-foreground` | 16.8:1 |
| White | `--gsm-muted` | 5.2:1 |
| Dark | `--gsm-foreground` (dark) | 16.8:1 |
| Primary | White | 4.6:1 |

---

## Icon Performance

### SVG Optimization

1. **Minify SVGs**: Remove metadata, comments, and unnecessary attributes
2. **Use viewBox**: Always include `viewBox` for scalable rendering
3. **Consolidate paths**: Merge multiple paths when possible
4. **Remove editor data**: Strip Illustrator/Sketch metadata

### Loading Strategy

```html
<!-- Critical icons: inline SVG -->
<svg class="w-5 h-5"><!-- critical icon --></svg>

<!-- Non-critical: lazy load or sprite -->
<svg class="w-5 h-5" loading="lazy"><!-- icon --></svg>
```

### Icon Font Alternative

Do **not** use icon fonts. SVGs are preferred because:
* Better accessibility
* Better performance (tree-shakable)
* Better rendering at all sizes
* Better color control
* Better animation support

---

# Illustration Style

## Visual Language

GsmUi illustrations communicate complex developer concepts through a clean, geometric visual language. Illustrations should feel modern, approachable, and technically precise.

### Style Principles

1. **Flat Design**: No gradients, shadows, or 3D effects in illustrations
2. **Geometric Forms**: Built from basic shapes (circles, rectangles, lines)
3. **Minimal Detail**: Only essential details that aid comprehension
4. **Consistent Stroke**: Uniform stroke width throughout each illustration
5. **Brand Colors**: Use only colors from the GsmUi palette

### Visual Characteristics

* **Shapes**: Rounded rectangles (4px radius), circles, clean polygons
* **Lines**: 2px stroke weight for primary elements, 1px for details
* **Corners**: Rounded (4px radius) — never sharp corners
* **Proportions**: Modular grid-based composition
* **Negative Space**: Generous, intentional whitespace

---

## Illustration Categories

### Concept Illustrations

Abstract representations of developer concepts.

| Concept | Visual Metaphor | Usage |
|---------|----------------|-------|
| Component System | Interlocking shapes, puzzle pieces | Architecture docs |
| Data Flow | Connected nodes, flowing lines | API documentation |
| Security | Shields, locks, barriers | Security guides |
| Performance | Speedometer, lightning bolts | Performance docs |
| Accessibility | Eye, hand, universal symbol | Accessibility guides |

### Onboarding Illustrations

Welcome users and guide them through setup.

| Scene | Elements | Colors |
|-------|----------|--------|
| Welcome | Developer at desk, code editor | Primary + Neutral |
| Installation | Terminal, code blocks | Primary + Success |
| First Component | Building blocks assembling | Primary + Secondary |
| Customization | Paint palette, theme switcher | Primary + Accent |
| Deployment | Rocket, cloud, server | Primary + Success |

### Empty State Illustrations

Communicate when content is unavailable.

| State | Visual | Message |
|-------|--------|---------|
| No data | Empty folder with magnifying glass | "No items found" |
| No results | Broken chain link | "No matches" |
| Error | Gentle warning triangle | "Something went wrong" |
| Coming soon | Clock with construction cone | "Under development" |
| Success | Checkmark in circle | "All done!" |

### Feature Illustrations

Highlight product capabilities.

* **Component Library**: Grid of UI elements (buttons, cards, inputs)
* **Theming**: Color swatches, theme switcher
* **Documentation**: Book, code snippets, diagrams
* **Marketplace**: Shopping bag, component cards
* **Community**: Connected people, chat bubbles

---

## Illustration Grid

All illustrations are built on a 8px grid system.

### Grid Sizes

| Canvas | Grid | Usage |
|--------|------|-------|
| 64×64 | 8px | Icons, small illustrations |
| 128×128 | 8px | Card illustrations |
| 256×256 | 8px | Feature illustrations |
| 512×512 | 16px | Hero illustrations |
| 1024×512 | 16px | Banner illustrations |

### Composition Rules

1. **Center of Interest**: Place focal point at grid intersection
2. **Rule of Thirds**: Divide canvas into thirds, place key elements at intersections
3. **Balance**: Distribute visual weight evenly across the canvas
4. **Flow**: Guide eye movement through intentional element placement

---

## Illustration Color Usage

### Primary Palette

```css
--gsm-illustration-primary: #6366f1;
--gsm-illustration-secondary: #0ea5e9;
--gsm-illustration-accent: #22c55e;
--gsm-illustration-neutral: #94a3b8;
```

### Color Application

| Element | Color | Opacity |
|---------|-------|---------|
| Primary objects | `--gsm-illustration-primary` | 100% |
| Secondary objects | `--gsm-illustration-secondary` | 100% |
| Accent/highlights | `--gsm-illustration-accent` | 100% |
| Backgrounds | `--gsm-surface` | 100% |
| Outlines | `--gsm-border` | 100% |
| Shadows | `--gsm-foreground` | 5-10% |

### Dark Mode

* Increase opacity of primary colors by 10-20%
* Use lighter versions of neutral elements
* Ensure sufficient contrast against dark backgrounds
* Never use pure white for illustration elements

---

## Illustration制作 Workflow

### Tools

* **Primary**: Figma (vector creation)
* **Secondary**: Illustrator (complex paths)
* **Optimization**: SVGO (SVG optimization)
* **Testing**: Browser preview at all sizes

### File Formats

| Format | Usage | Notes |
|--------|-------|-------|
| SVG | Primary format | Scalable, accessible, performant |
| PNG | Fallback only | When SVG not supported |
| WebP | Optimized delivery | When supported |

### SVG Guidelines

```xml
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256" fill="none">
  <!-- Use currentColor for themeable elements -->
  <path stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
  
  <!-- Use CSS variables for brand colors -->
  <rect fill="var(--gsm-illustration-primary)"/>
  
  <!-- Include title for accessibility -->
  <title>Component system illustration</title>
</svg>
```

---

## Illustration Sizing

### Responsive Sizing

```css
/* Small illustration (icons, inline) */
.illustration-sm {
  width: 64px;
  height: 64px;
}

/* Medium illustration (cards, features) */
.illustration-md {
  width: 128px;
  height: 128px;
}

/* Large illustration (hero, sections) */
.illustration-lg {
  width: 256px;
  height: 256px;
}

/* Full-width illustration (banners) */
.illustration-full {
  width: 100%;
  max-width: 512px;
  height: auto;
}
```

### Aspect Ratios

| Type | Ratio | Usage |
|------|-------|-------|
| Square | 1:1 | Icons, small illustrations |
| Landscape | 4:3 | Feature illustrations |
| Wide | 16:9 | Hero sections, banners |
| Tall | 3:4 | Mobile illustrations |

---

## Illustration Accessibility

### Requirements

1. **Alt Text**: All illustrations must have descriptive alt text
2. **Decorative Marking**: Decorative illustrations use `aria-hidden="true"`
3. **Color Independence**: Illustrations must be understandable without color
4. **Text Alternatives**: Complex illustrations need text explanations

### Examples

```html
<!-- Informative illustration -->
<figure>
  <img src="component-system.svg" alt="Diagram showing how GsmUi components connect through a shared design token system">
  <figcaption>Component architecture overview</figcaption>
</figure>

<!-- Decorative illustration -->
<img src="decorative-shape.svg" alt="" aria-hidden="true">
```

---

# Photography

## Photography Purpose

Photography in GsmUi serves to humanize the platform, showcase community work, and create authentic connections with developers. Photography should feel genuine, not stock-like.

### When to Use Photography

| Context | Photography Type | Usage |
|---------|-----------------|-------|
| Blog posts | Authentic, editorial | Tutorial illustrations, event coverage |
| Community showcases | User-submitted | Project screenshots, developer portraits |
| Team pages | Professional portraits | Team member photos |
| Events | Candid, documentary | Conference coverage, meetups |
| Merchandise | Lifestyle | Product shots in context |

### When NOT to Use Photography

* Component documentation (use illustrations)
* Error states (use illustrations)
* Empty states (use illustrations)
* Feature highlights (use illustrations)
* Loading states (use animations)

---

## Photography Style

### Visual Characteristics

* **Lighting**: Natural, soft, diffused — avoid harsh shadows
* **Color Treatment**: Slightly desaturated, warm tones — not oversaturated
* **Composition**: Clean, uncluttered with intentional negative space
* **Subject Matter**: Real developers, real workspaces, real code
* **Perspective**: Eye-level or slightly above — avoid dramatic angles

### Editing Standards

| Adjustment | Value | Reasoning |
|------------|-------|-----------|
| Exposure | +0.3 to +0.7 | Bright, optimistic feel |
| Contrast | -10 to -20 | Soft, approachable look |
| Saturation | -15 to -25 | Muted, professional tone |
| Temperature | +5 to +10 | Warm, inviting feel |
| Sharpness | +20 to +30 | Clear, detailed without harshness |

### Color Grading

Apply a consistent color grade across all photography:

```css
/* Overlay for brand consistency */
.photo-overlay {
  background: linear-gradient(135deg, rgba(99, 102, 241, 0.05) 0%, rgba(14, 165, 233, 0.05) 100%);
}
```

---

## Photography Categories

### Developer Portraits

Authentic portraits of developers using GsmUi.

| Style | Setting | Lighting |
|-------|---------|----------|
| Environmental | Office/workspace | Natural window light |
| Candid | Working on code | Mixed lighting |
| Lifestyle | Coffee shop, co-working | Warm ambient |

**Rules**:
* Show diverse representation
* Capture genuine expressions (not forced smiles)
* Include context (laptop, code, workspace)
* Never use stock photos of people

### Workspace Photography

Real development environments.

| Element | Style | Notes |
|---------|-------|-------|
| Desks | Clean, organized | Minimal clutter |
| Screens | Show code/GsmUi | Not mockups |
| Equipment | Modern, realistic | Not staged |
| Atmosphere | Natural, lived-in | Not sterile |

### Code Screenshots

Real code examples captured from actual projects.

| Requirement | Standard |
|-------------|----------|
| Syntax theme | Gsmui dark theme |
| Font | JetBrains Mono, 14px |
| Line numbers | Enabled, subtle |
| Background | `--gsm-surface` |
| Border radius | 8px |
| Padding | 16px |

---

## Photography Composition

### Framing Rules

1. **Rule of Thirds**: Place subjects at intersection points
2. **Leading Lines**: Guide eye toward focal point
3. **Negative Space**: Leave room for text overlays
4. **Depth**: Use foreground/background blur for focus

### Aspect Ratios

| Usage | Ratio | Pixels |
|-------|-------|--------|
| Hero images | 16:9 | 1920×1080 |
| Blog headers | 2:1 | 1200×600 |
| Card thumbnails | 4:3 | 800×600 |
| Square thumbnails | 1:1 | 600×600 |
| Social media | 1.91:1 | 1200×630 |

### Cropping Guidelines

* Keep subjects centered or at rule-of-thirds intersections
* Maintain headroom for portraits
* Preserve important details when cropping
* Never crop into faces or text

---

## Photography Accessibility

### Alt Text Requirements

All photographs must have descriptive alt text:

```html
<!-- Good alt text -->
<img src="developer-workspace.jpg" alt="Developer at standing desk with dual monitors showing Gsmui component documentation and code editor">

<!-- Bad alt text -->
<img src="developer-workspace.jpg" alt="Developer">
```

### Alt Text Guidelines

1. Describe the content, not the appearance
2. Include relevant context (what's happening)
3. Keep under 125 characters when possible
4. Skip "image of" or "photo of" — screen readers already announce it
5. Include technical details when relevant (code shown, tools used)

---

## Photography Sourcing

### Authentic Sources

| Source | Priority | Notes |
|--------|----------|-------|
| Community submissions | High | Real users, real projects |
| Team photos | High | Internal team, genuine |
| Event coverage | Medium | Conferences, meetups |
| Stock photography | Low | Only when necessary |

### Stock Photography Rules

If stock photography is necessary:

1. **Selection Criteria**:
   * Diverse, inclusive representation
   * Natural, non-staged compositions
   * Appropriate lighting and color
   * Relevant to developer context

2. **Restrictions**:
   * Never use obvious stock photos (handshakes, lightbulbs)
   * Never use photos with visible watermarks
   * Never use photos with text overlays
   * Maximum 10% of total photography should be stock

3. **Approved Sources**:
   * Unsplash (free, commercial license)
   * Pexels (free, commercial license)
   * Custom shoots (preferred)

---

## Photography File Standards

### File Formats

| Format | Usage | Quality |
|--------|-------|---------|
| WebP | Primary delivery | 85% quality |
| JPEG | Fallback | 80% quality |
| PNG | Transparent backgrounds | Lossless |

### Naming Convention

```
{category}-{subject}-{variant}.{format}

Examples:
hero-developer-workspace.webp
blog-laravel-conference.jpg
team-john-doe-portrait.webp
showcase-ecommerce-project.png
```

### File Organization

```
/photos
  /hero          # Hero section images
  /blog          # Blog post images
  /team          # Team member portraits
  /showcase      # Community project screenshots
  /events        # Event coverage
  /workspace     # Developer workspace shots
  /code          # Code screenshots
```

---

## Photography Responsive Delivery

### Image Sizes

| Context | Width | Height | Format |
|---------|-------|--------|--------|
| Hero (desktop) | 1920px | 1080px | WebP |
| Hero (tablet) | 1200px | 675px | WebP |
| Hero (mobile) | 750px | 422px | WebP |
| Blog (desktop) | 1200px | 600px | WebP |
| Blog (mobile) | 750px | 375px | WebP |
| Card | 800px | 600px | WebP |
| Thumbnail | 400px | 300px | WebP |

### Responsive Images

```html
<picture>
  <source srcset="hero-1920.webp" media="(min-width: 1024px)" type="image/webp">
  <source srcset="hero-1200.webp" media="(min-width: 640px)" type="image/webp">
  <source srcset="hero-750.webp" type="image/webp">
  <img src="hero-1200.jpg" alt="Developer workspace" loading="lazy" width="1920" height="1080">
</picture>
```

### Lazy Loading

* All images below the fold: `loading="lazy"`
* Hero images: `loading="eager"` with `fetchpriority="high"`
* Always specify `width` and `height` to prevent layout shift

---

# Design Tokens

Every visual property should be represented by design tokens.

Examples:

* Color
* Font
* Radius
* Shadow
* Border
* Opacity
* Animation
* Transition
* Blur
* Z-index

These tokens become the single source of truth for:

* Components
* Templates
* Themes
* Documentation
* Playground

---

# Component Philosophy

Each component should be:

* Reusable
* Composable
* Accessible
* Responsive
* Themeable
* Lightweight

Avoid duplicated functionality.

---

# Component Naming

Use consistent naming.

Examples:

Button

Card

Modal

Drawer

Dropdown

Accordion

Avatar

Badge

Alert

Table

Chart

Timeline

Tabs

Toast

Pagination

Navbar

Sidebar

Breadcrumb

Do not abbreviate component names.

---

# Naming Conventions

## Components

PascalCase

Example:

Button

UserCard

PricingTable

---

## Blade Components

kebab-case

Example

x-gsm-button

x-gsm-card

---

## Livewire Components

Namespace based

Example

Docs/ComponentViewer

Admin/UserTable

Dashboard/Profile

---

## CSS Variables

Use semantic names.

Example

--gsm-primary

--gsm-background

--gsm-radius

--gsm-shadow

---

# Motion

## Motion Principles

Animation in GsmUi should feel purposeful, subtle, and helpful. Motion is not decoration — it communicates state changes, guides attention, and provides feedback.

### Core Principles

1. **Purposeful**: Every animation must serve a functional purpose
2. **Subtle**: Animations should be felt, not watched
3. **Consistent**: Similar actions use similar animations
4. **Accessible**: All animations respect `prefers-reduced-motion`
5. **Performant**: Animations must maintain 60fps

---

## Duration

### Standard Durations

| Token | Duration | Usage |
|-------|----------|-------|
| `duration-instant` | 0ms | Immediate feedback (color changes) |
| `duration-fast` | 100ms | Micro-interactions (hover states, focus) |
| `duration-normal` | 200ms | Standard transitions (buttons, inputs) |
| `duration-slow` | 300ms | Complex transitions (modals, drawers) |
| `duration-slower` | 400ms | Page transitions, large animations |
| `duration-slowest` | 500ms | Hero animations, orchestrated sequences |

### Duration Rules

1. Maximum 500ms for any single animation
2. Maximum 1000ms for orchestrated sequences
3. Hover effects: 100-150ms
4. Focus transitions: 150-200ms
5. Enter/exit animations: 200-300ms
6. Layout animations: 300-400ms

---

## Easing

### Standard Easings

| Token | Curve | Usage |
|-------|-------|-------|
| `ease-default` | `cubic-bezier(0.4, 0, 0.2, 1)` | Most transitions |
| `ease-in` | `cubic-bezier(0.4, 0, 1, 1)` | Exiting elements |
| `ease-out` | `cubic-bezier(0, 0, 0.2, 1)` | Entering elements |
| `ease-in-out` | `cubic-bezier(0.4, 0, 0.2, 1)` | Element size changes |
| `ease-bounce` | `cubic-bezier(0.34, 1.56, 0.64, 1)` | Playful feedback (sparingly) |
| `ease-spring` | `cubic-bezier(0.175, 0.885, 0.32, 1.275)` | Natural motion |

### Easing Rules

* Default to `ease-default` for all transitions
* Use `ease-in` for elements leaving the viewport
* Use `ease-out` for elements entering the viewport
* `ease-bounce` only for success confirmations (max 1 per page)
* Never use linear easing for UI animations

---

## Animation Types

### Micro-Interactions

Small, immediate feedback animations.

**Hover States**
```css
/* Button hover */
transition: background-color 150ms ease-default, 
            box-shadow 150ms ease-default;

/* Card hover */
transition: transform 200ms ease-default, 
            box-shadow 200ms ease-default;
```

**Focus States**
```css
/* Focus ring */
transition: box-shadow 150ms ease-default;

/* Input focus */
transition: border-color 150ms ease-default, 
            box-shadow 150ms ease-default;
```

**Toggle States**
```css
/* Checkbox/Radio */
transition: background-color 150ms ease-default, 
            border-color 150ms ease-default;

/* Switch */
transition: background-color 200ms ease-default;
```

### Enter/Exit Animations

Elements appearing or disappearing from the DOM.

**Fade**
```css
/* Fade in */
@keyframes fadeIn {
  from { opacity: 0; }
  to { opacity: 1; }
}

/* Fade out */
@keyframes fadeOut {
  from { opacity: 1; }
  to { opacity: 0; }
}
```

**Slide**
```css
/* Slide up (from below) */
@keyframes slideUp {
  from { transform: translateY(8px); opacity: 0; }
  to { transform: translateY(0); opacity: 1; }
}

/* Slide down (from above) */
@keyframes slideDown {
  from { transform: translateY(-8px); opacity: 0; }
  to { transform: translateY(0); opacity: 1; }
}

/* Slide in from left */
@keyframes slideInLeft {
  from { transform: translateX(-16px); opacity: 0; }
  to { transform: translateX(0); opacity: 1; }
}
```

**Scale**
```css
/* Scale in (pop) */
@keyframes scaleIn {
  from { transform: scale(0.95); opacity: 0; }
  to { transform: scale(1); opacity: 1; }
}
```

### Layout Animations

Smooth transitions when layout changes.

**Collapse/Expand**
```css
/* Accordion */
@keyframes collapse {
  from { height: var(--gsm-collapsible-height); }
  to { height: 0; }
}

/* Duration: 200-300ms */
/* Easing: ease-in-out */
```

**Resize**
```css
/* Sidebar resize */
transition: width 300ms ease-default;
```

### Loading States

Animations that indicate system activity.

**Spinner**
```css
@keyframes spin {
  from { transform: rotate(0deg); }
  to { transform: rotate(360deg); }
}
/* Duration: 800ms */
/* Easing: linear */
/* Must be reduced motion friendly */
```

**Skeleton**
```css
@keyframes shimmer {
  0% { background-position: -200% 0; }
  100% { background-position: 200% 0; }
}
/* Duration: 1500ms */
/* Easing: linear */
```

**Pulse**
```css
@keyframes pulse {
  0%, 100% { opacity: 1; }
  50% { opacity: 0.5; }
}
/* Duration: 2000ms */
/* Easing: ease-in-out */
```

---

## Orchestration

### Staggered Animations

When multiple elements animate together, stagger them for a polished effect.

```css
/* Staggered list items */
.list-item:nth-child(1) { animation-delay: 0ms; }
.list-item:nth-child(2) { animation-delay: 50ms; }
.list-item:nth-child(3) { animation-delay: 100ms; }
.list-item:nth-child(4) { animation-delay: 150ms; }

/* Maximum stagger: 50ms between items */
/* Maximum total delay: 300ms */
```

### Animation Chains

Sequential animations for complex flows.

```css
/* Modal entrance */
@keyframes modalEntrance {
  0% { opacity: 0; transform: scale(0.95) translateY(8px); }
  50% { opacity: 1; transform: scale(1) translateY(0); }
  100% { opacity: 1; transform: scale(1) translateY(0); }
}
/* Duration: 300ms */
/* The modal "settles" into place */
```

---

## Reduced Motion

### Implementation

```css
@media (prefers-reduced-motion: reduce) {
  *,
  *::before,
  *::after {
    animation-duration: 0.01ms !important;
    animation-iteration-count: 1 !important;
    transition-duration: 0.01ms !important;
    scroll-behavior: auto !important;
  }
}
```

### Rules

1. All animations must have a reduced-motion alternative
2. Essential animations (loading indicators) can be simplified but not removed
3. Parallax and scroll-triggered animations must be disabled
4. Auto-playing animations must pause on `prefers-reduced-motion`
5. Provide manual toggle for non-essential animations

---

## Performance

### Requirements

* Animations must maintain 60fps
* Only animate `transform` and `opacity` for smooth performance
* Avoid animating `width`, `height`, `top`, `left` (triggers layout)
* Use `will-change` sparingly and remove after animation completes
* Test on low-end devices

### Profiling

```javascript
// Check animation performance
const observer = new PerformanceObserver((list) => {
  for (const entry of list.getEntries()) {
    if (entry.duration > 16.67) { // Below 60fps
      console.warn('Janky animation:', entry);
    }
  }
});
observer.observe({ entryTypes: ['longtask'] });
```

###禁忌

* Never animate more than 3 elements simultaneously
* Never use `box-shadow` animation (triggers paint)
* Never animate `font-size` (triggers layout recalculations)
* Never animate `color` (use opacity overlay instead for smooth transitions)

---

# Border Radius Scale

Use a consistent radius system. Border radius provides visual softness and helps distinguish interactive elements from static content.

## Radius Scale

| Token | Value | Pixels | Usage |
|-------|-------|--------|-------|
| `--gsm-radius-none` | 0 | 0px | No radius, sharp corners |
| `--gsm-radius-xs` | 0.125rem | 2px | Badges, small elements |
| `--gsm-radius-sm` | 0.25rem | 4px | Inputs, buttons (compact) |
| `--gsm-radius-md` | 0.375rem | 6px | Buttons, standard elements |
| `--gsm-radius-lg` | 0.5rem | 8px | Cards, modals, panels |
| `--gsm-radius-xl` | 0.75rem | 12px | Large cards, feature blocks |
| `--gsm-radius-2xl` | 1rem | 16px | Hero sections, large containers |
| `--gsm-radius-3xl` | 1.5rem | 24px | Decorative elements |
| `--gsm-radius-full` | 9999px | — | Pills, circles, avatars |

## Radius Rules

1. **Consistent within components**: All corners of a single element must use the same radius
2. **Nested radius**: Inner elements should have smaller radius than outer containers
3. **Maximum radius**: Never exceed `--gsm-radius-3xl` (24px) except for pills/circles
4. **Sharp corners**: Use `--gsm-radius-none` only for code blocks and特殊元素
5. **Responsive**: Radius does not scale with viewport — use consistent values

## Component Radius Mapping

| Component | Radius | Reasoning |
|-----------|--------|-----------|
| Button | `--gsm-radius-md` | Standard interactive element |
| Input | `--gsm-radius-md` | Form element consistency |
| Card | `--gsm-radius-lg` | Container distinction |
| Modal | `--gsm-radius-xl` | Prominent overlay |
| Dropdown | `--gsm-radius-lg` | Popover consistency |
| Tooltip | `--gsm-radius-sm` | Small, unobtrusive |
| Badge | `--gsm-radius-full` | Compact, pill shape |
| Avatar | `--gsm-radius-full` | Circular by default |
| Avatar (Square) | `--gsm-radius-lg` | When square variant needed |
| Table | `--gsm-radius-none` | Sharp edges for data density |
| Code block | `--gsm-radius-lg` | Distinct from content |
| Alert | `--gsm-radius-lg` | Notification consistency |
| Toast | `--gsm-radius-lg` | Popover consistency |
| Tab | `--gsm-radius-md` | Button consistency |
| Accordion | `--gsm-radius-lg` | Container consistency |

## Radius in Dark Mode

Radius values remain constant in dark mode. The visual softness is maintained through consistent application regardless of theme.

---

# Shadow Scale

Provide six elevation levels. Shadows communicate depth, hierarchy, and focus state in the interface.

## Shadow Scale

| Token | Value | Usage |
|-------|-------|-------|
| `--gsm-shadow-none` | `none` | Flat elements, no elevation |
| `--gsm-shadow-xs` | `0 1px 2px 0 rgba(0,0,0,0.05)` | Subtle lift, buttons |
| `--gsm-shadow-sm` | `0 1px 3px 0 rgba(0,0,0,0.1), 0 1px 2px -1px rgba(0,0,0,0.1)` | Cards, inputs |
| `--gsm-shadow-md` | `0 4px 6px -1px rgba(0,0,0,0.1), 0 2px 4px -2px rgba(0,0,0,0.1)` | Dropdowns, popovers |
| `--gsm-shadow-lg` | `0 10px 15px -3px rgba(0,0,0,0.1), 0 4px 6px -4px rgba(0,0,0,0.1)` | Modals, dialogs |
| `--gsm-shadow-xl` | `0 20px 25px -5px rgba(0,0,0,0.1), 0 8px 10px -6px rgba(0,0,0,0.1)` | Floating panels |
| `--gsm-shadow-2xl` | `0 25px 50px -12px rgba(0,0,0,0.25)` | Maximum elevation |

## Shadow Rules

1. **Progressive elevation**: Higher elevation = larger, softer shadow
2. **Consistent blur**: Blur radius increases with elevation level
3. **Subtle colors**: Use `rgba(0,0,0,0.1)` for light mode, `rgba(0,0,0,0.3)` for dark mode
4. **No colored shadows**: Shadows must always be black/white — never colored
5. **Focus states**: Use `--gsm-shadow-ring` for focus indicators, not elevation shadows

## Component Shadow Mapping

| Component | Default | Hover/Focus | Active |
|-----------|---------|-------------|--------|
| Button | `--gsm-shadow-xs` | `--gsm-shadow-sm` | `--gsm-shadow-none` |
| Card | `--gsm-shadow-sm` | `--gsm-shadow-md` | `--gsm-shadow-sm` |
| Modal | `--gsm-shadow-xl` | — | — |
| Dropdown | `--gsm-shadow-md` | — | — |
| Tooltip | `--gsm-shadow-md` | — | — |
| Toast | `--gsm-shadow-lg` | — | — |
| Input | `--gsm-shadow-xs` (inset) | `--gsm-shadow-sm` (inset) | — |
| Popover | `--gsm-shadow-lg` | — | — |

## Focus Ring Shadow

```css
--gsm-shadow-ring: 0 0 0 2px var(--gsm-background), 0 0 0 4px var(--gsm-primary);
```

This creates a double-ring focus indicator:
1. Inner ring: 2px background color (creates separation)
2. Outer ring: 2px primary color (visible focus indicator)

## Shadow in Dark Mode

Dark mode shadows require higher opacity for visibility:

```css
/* Light mode */
--gsm-shadow-sm: 0 1px 3px 0 rgba(0,0,0,0.1), 0 1px 2px -1px rgba(0,0,0,0.1);

/* Dark mode */
--gsm-shadow-sm: 0 1px 3px 0 rgba(0,0,0,0.3), 0 1px 2px -1px rgba(0,0,0,0.3);
```

## Shadow Performance

* Use `will-change: box-shadow` sparingly — only on animated elements
* Avoid animating shadow properties — use opacity transitions instead
* Consider `filter: drop-shadow()` for complex shapes (SVGs, images)
* Test shadow rendering on low-end devices

---

# Grid System

GsmUi uses a responsive grid system based on Flexbox and CSS Grid. The grid provides consistent spacing and alignment across all layouts.

## Grid Specifications

### Desktop (≥1024px)

* **Columns**: 12
* **Gutter**: 24px (`--gsm-space-6`)
* **Margin**: 32px (`--gsm-space-8`)
* **Max Width**: 1280px

### Tablet (≥768px)

* **Columns**: 8
* **Gutter**: 24px (`--gsm-space-6`)
* **Margin**: 24px (`--gsm-space-6`)
* **Max Width**: 768px

### Mobile (<768px)

* **Columns**: 4
* **Gutter**: 16px (`--gsm-space-4`)
* **Margin**: 16px (`--gsm-space-4`)
* **Max Width**: 100%

## Container Widths

| Token | Max Width | Usage |
|-------|-----------|-------|
| `--gsm-container-sm` | 640px | Narrow content, single-column |
| `--gsm-container-md` | 768px | Standard content |
| `--gsm-container-lg` | 1024px | Wide content, two-column |
| `--gsm-container-xl` | 1280px | Full-width layouts |
| `--gsm-container-2xl` | 1440px | Extra-wide layouts |
| `--gsm-container-full` | 100% | Edge-to-edge |

## Grid Usage

### Standard Layout

```html
<div class="gsm-container gsm-container-lg">
  <div class="gsm-grid gsm-grid-cols-12 gsm-gap-6">
    <div class="gsm-col-span-8"><!-- Main content --></div>
    <div class="gsm-col-span-4"><!-- Sidebar --></div>
  </div>
</div>
```

### Responsive Layout

```html
<div class="gsm-grid gsm-grid-cols-4 md:gsm-grid-cols-8 lg:gsm-grid-cols-12 gsm-gap-4 md:gsm-gap-6">
  <div class="gsm-col-span-4 md:gsm-col-span-8 lg:gsm-col-span-12">
    <!-- Full width on all screens -->
  </div>
</div>
```

## Grid Rules

1. **Always use containers**: Content must never touch viewport edges
2. **Consistent gutters**: Use `--gsm-space-4` (mobile) or `--gsm-space-6` (desktop)
3. **Responsive columns**: Start with 4 columns, scale to 8, then 12
4. **No nested grids**: Avoid grids within grids — use flexbox for internal layouts
5. **Alignment**: Use `gsm-items-center` for vertical alignment, `gsm-justify-between` for horizontal

---

# Responsive Breakpoints

GsmUi follows a mobile-first responsive design approach. All styles are written for mobile first, then enhanced for larger screens.

## Breakpoint Scale

| Token | Min Width | Label | Target |
|-------|-----------|-------|--------|
| `sm` | 640px | Small | Large phones, small tablets |
| `md` | 768px | Medium | Tablets, small laptops |
| `lg` | 1024px | Large | Laptops, desktops |
| `xl` | 1280px | Extra Large | Desktops, large screens |
| `2xl` | 1536px | 2XL | Ultra-wide screens |

## Breakpoint Usage

### Mobile (Default)

* Single column layout
* Stacked navigation
* Full-width components
* Simplified interactions

```html
<!-- Mobile: stack vertically -->
<div class="gsm-flex gsm-flex-col gsm-gap-4">
  <div><!-- Header --></div>
  <div><!-- Content --></div>
  <div><!-- Footer --></div>
</div>
```

### Tablet (≥768px)

* Two-column layouts possible
* Side navigation
* Expanded components

```html
<!-- Tablet: side by side -->
<div class="md:gsm-flex md:gsm-gap-6">
  <div class="md:gsm-w-1/3"><!-- Sidebar --></div>
  <div class="md:gsm-w-2/3"><!-- Content --></div>
</div>
```

### Desktop (≥1024px)

* Multi-column layouts
* Full navigation
* Complex interactions

```html
<!-- Desktop: three columns -->
<div class="lg:gsm-grid lg:gsm-grid-cols-12 lg:gsm-gap-6">
  <div class="lg:gsm-col-span-3"><!-- Sidebar --></div>
  <div class="lg:gsm-col-span-6"><!-- Main --></div>
  <div class="lg:gsm-col-span-3"><!-- Aside --></div>
</div>
```

## Responsive Rules

1. **Mobile-first**: Always write mobile styles first, then enhance
2. **Progressive enhancement**: Add complexity as screen size increases
3. **Touch targets**: Minimum 44×44px on mobile, 32×32px on desktop
4. **Text size**: Scale down on mobile (use `text-sm` or `text-base`)
5. **Spacing**: Reduce padding/margin on mobile (use `--gsm-space-4` or less)
6. **Navigation**: Collapse to hamburger on mobile, expand on desktop
7. **Tables**: Horizontal scroll on mobile, full-width on desktop
8. **Modals**: Full-screen on mobile, centered on desktop

## Container Queries

For component-level responsiveness:

```css
/* Component adapts to its container, not viewport */
@container (min-width: 400px) {
  .component { /* Wide layout */ }
}

@container (min-width: 600px) {
  .component { /* Extra wide layout */ }
}
```

## Responsive Testing

All components must be tested at:

1. 320px (small phone)
2. 375px (standard phone)
3. 768px (tablet)
4. 1024px (laptop)
5. 1280px (desktop)
6. 1536px (ultra-wide)

---

# Accessibility Standards

All products must meet or exceed WCAG 2.2 AA standards. Accessibility is not optional — it's a core requirement for every component, template, and interaction.

## WCAG 2.2 Compliance

### Level AA Requirements (Minimum)

| Criterion | Requirement | Testing Method |
|-----------|-------------|----------------|
| 1.1.1 Non-text Content | Alt text for images, labels for inputs | Automated + Manual |
| 1.3.1 Info and Relationships | Semantic HTML, proper headings | Automated |
| 1.3.5 Identify Input Purpose | Autocomplete attributes | Automated |
| 1.4.1 Use of Color | Color not sole indicator | Manual |
| 1.4.3 Contrast Minimum | 4.5:1 text, 3:1 large text | Automated |
| 1.4.4 Resize Text | 200% zoom without loss | Manual |
| 1.4.10 Reflow | 320px width without scroll | Manual |
| 1.4.11 Non-text Contrast | 3:1 UI components | Automated |
| 1.4.13 Content on Hover/Focus | Dismissible, hoverable, persistent | Manual |
| 2.1.1 Keyboard | All functionality via keyboard | Manual |
| 2.1.2 No Keyboard Trap | Tab can leave all components | Manual |
| 2.4.1 Bypass Blocks | Skip navigation link | Automated |
| 2.4.3 Focus Order | Logical tab order | Manual |
| 2.4.7 Focus Visible | Visible focus indicator | Manual |
| 2.5.3 Label in Name | Accessible name matches visible label | Manual |
| 3.1.1 Language of Page | `lang` attribute on `<html>` | Automated |
| 3.2.1 On Focus | No unexpected context changes | Manual |
| 3.3.1 Error Identification | Errors clearly identified | Manual |
| 3.3.3 Error Suggestion | Error correction suggestions | Manual |
| 4.1.2 Name, Role, Value | ARIA states and properties | Automated |

### Level AAA (Target)

| Criterion | Requirement |
|-----------|-------------|
| 1.4.6 Contrast Enhanced | 7:1 text, 4.5:1 large text |
| 1.4.8 Visual Presentation | 80 characters per line, 1.5 line height |
| 2.4.13 Focus Appearance | Large, high-contrast focus indicators |

## Keyboard Navigation

### Tab Order

1. Skip navigation link (first focusable element)
2. Header navigation
3. Main content (in DOM order)
4. Footer navigation

### Keyboard Patterns

**Button**
```
Tab: Move to button
Enter/Space: Activate button
```

**Link**
```
Tab: Move to link
Enter: Activate link
```

**Input**
```
Tab: Move to input
Type: Enter value
Enter: Submit form (if applicable)
```

**Select/Dropdown**
```
Tab: Move to select
Space/Enter: Open dropdown
↑/↓: Navigate options
Enter: Select option
Escape: Close dropdown
```

**Modal/Dialog**
```
Tab: Move focus within modal
Shift+Tab: Move focus backwards
Escape: Close modal
```

**Tabs**
```
Tab: Move to tab list
←/→: Navigate between tabs
Enter/Space: Activate tab
Tab: Move focus to tab panel
```

### Focus Management

```css
/* Focus visible only for keyboard users */
:focus:not(:focus-visible) {
  outline: none;
}

:focus-visible {
  outline: 2px solid var(--gsm-primary);
  outline-offset: 2px;
}

/* High contrast focus for custom elements */
.custom-element:focus-visible {
  outline: 2px solid var(--gsm-primary);
  outline-offset: 2px;
  box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.2);
}
```

## Screen Reader Support

### ARIA Patterns

**Live Regions**
```html
<!-- Dynamic content updates -->
<div aria-live="polite" aria-atomic="true">
  <!-- Status messages appear here -->
</div>

<!-- Urgent notifications -->
<div aria-live="assertive" role="alert">
  <!-- Error messages appear here -->
</div>
```

**Landmarks**
```html
<header role="banner"><!-- Site header --></header>
<nav role="navigation" aria-label="Main"><!-- Main nav --></nav>
<main role="main"><!-- Main content --></main>
<aside role="complementary"><!-- Sidebar --></aside>
<footer role="contentinfo"><!-- Footer --></footer>
```

**Labels**
```html
<!-- Visible labels -->
<label for="email">Email Address</label>
<input id="email" type="email">

<!-- Hidden labels (when visual context is clear) -->
<label for="search" class="sr-only">Search</label>
<input id="search" type="search">

<!-- ARIA labels (when label can't be in DOM) -->
<button aria-label="Close dialog">
  <svg aria-hidden="true"><!-- X icon --></svg>
</button>
```

### Screen Reader Testing

Test with:
* NVDA (Windows, free)
* JAWS (Windows, commercial)
* VoiceOver (macOS, built-in)
* TalkBack (Android, built-in)

### Testing Checklist

- [ ] All images have appropriate alt text
- [ ] Form inputs have associated labels
- [ ] Headings are hierarchical (H1 → H2 → H3)
- [ ] Landmarks are properly identified
- [ ] Dynamic content uses ARIA live regions
- [ ] Focus order is logical
- [ ] All interactive elements are keyboard accessible

## Color Contrast

### Contrast Requirements

| Element | Minimum Ratio | Target Ratio |
|---------|---------------|--------------|
| Normal text (<24px) | 4.5:1 | 7:1 |
| Large text (≥24px) | 3:1 | 4.5:1 |
| UI components | 3:1 | 4.5:1 |
| Focus indicators | 3:1 | 4.5:1 |
| Decorative elements | N/A | N/A |

### Contrast Testing

```javascript
// Automated contrast checking
function checkContrast(foreground, background) {
  const ratio = getContrastRatio(foreground, background);
  return {
    ratio: ratio.toFixed(2),
    aa: ratio >= 4.5,
    aaa: ratio >= 7,
    largeAa: ratio >= 3,
    largeAaa: ratio >= 4.5
  };
}
```

### Color Independence

Information must not be conveyed by color alone:

```html
<!-- Bad: Color only indicates error -->
<input class="border-red-500">

<!-- Good: Color + icon + text indicate error -->
<div class="error">
  <svg class="error-icon"><!-- Error icon --></svg>
  <span class="error-text">Invalid email address</span>
  <input class="border-error">
</div>
```

## Reduced Motion

### Implementation

```css
@media (prefers-reduced-motion: reduce) {
  *,
  *::before,
  *::after {
    animation-duration: 0.01ms !important;
    animation-iteration-count: 1 !important;
    transition-duration: 0.01ms !important;
    scroll-behavior: auto !important;
  }
}
```

### Rules

1. All animations must have a reduced-motion alternative
2. Auto-playing animations must pause on `prefers-reduced-motion`
3. Parallax effects must be disabled
4. Essential animations (loading indicators) can be simplified but not removed

## High Contrast Mode

### Support

```css
/* Windows High Contrast Mode */
@media (forced-colors: active) {
  .button {
    border: 2px solid ButtonText;
    color: ButtonText;
  }
  
  .input {
    border: 2px solid ButtonText;
  }
  
  .focus-ring {
    outline: 2px solid Highlight;
  }
}
```

### Rules

1. Never use `display: none` to hide content — use `visibility: hidden` or semantic hiding
2. Always use semantic HTML elements
3. Support `forced-colors` media query
4. Ensure all interactive elements have visible borders

## Touch Targets

### Minimum Sizes

| Context | Minimum Size | Target Size |
|---------|-------------|-------------|
| Mobile buttons | 44×44px | 48×48px |
| Mobile links | 44×44px | 48×48px |
| Desktop buttons | 32×32px | 40×40px |
| Desktop links | 32×32px | 40×40px |

### Implementation

```css
/* Ensure minimum touch target size */
.button {
  min-height: 44px;
  min-width: 44px;
  padding: 12px 24px;
}

/* When visual size is smaller, expand hit area */
.icon-button {
  width: 32px;
  height: 32px;
  padding: 6px;
  /* Total touch area: 44×44px */
}
```

## Semantic HTML

### Required Elements

| Element | Usage |替代 |
|---------|-------|-----|
| `<button>` | Interactive actions | Not `<div onclick>` |
| `<a>` | Navigation links | Not `<span onclick>` |
| `<input>` | Form inputs | Not `<div contenteditable>` |
| `<select>` | Dropdowns | Not custom div dropdowns |
| `<table>` | Tabular data | Not `<div>` grid |
| `<nav>` | Navigation | Not `<div>` |
| `<main>` | Main content | Not `<div>` |
| `<header>` | Page header | Not `<div>` |
| `<footer>` | Page footer | Not `<div>` |
| `<article>` | Standalone content | Not `<div>` |
| `<section>` | Thematic grouping | Not `<div>` |

### Heading Hierarchy

```html
<h1>Page Title</h1>
  <h2>Section</h2>
    <h3>Subsection</h3>
    <h3>Subsection</h3>
  <h2>Section</h2>
    <h3>Subsection</h3>
```

**Rules**:
1. Only one `<h1>` per page
2. Never skip heading levels (H1 → H3)
3. Headings must be in logical order
4. Headings must not be used for styling only

## Accessibility Testing

### Automated Testing

```javascript
// axe-core integration
const axe = require('axe-core');

async function testAccessibility() {
  const results = await axe.run();
  
  return {
    violations: results.violations.length,
    passes: results.passes.length,
    incomplete: results.incomplete.length
  };
}
```

### Manual Testing Checklist

- [ ] All functionality available via keyboard
- [ ] Focus order is logical
- [ ] Focus indicator is visible
- [ ] Screen reader announces all content
- [ ] Dynamic content is announced
- [ ] Color contrast meets WCAG AA
- [ ] Text resizes to 200% without loss
- [ ] Content reflows at 320px width
- [ ] No content flashes more than 3 times per second
- [ ] Touch targets meet minimum size requirements

### Testing Tools

| Tool | Type | Usage |
|------|------|-------|
| axe-core | Automated | CI/CD integration |
| Lighthouse | Automated | Performance + accessibility |
| WAVE | Browser extension | Visual accessibility checking |
| NVDA | Screen reader | Manual testing |
| VoiceOver | Screen reader | Manual testing |
| Color Contrast Analyzer | Tool | Manual contrast checking |

---

# Documentation Style

Documentation should be:

* Beginner-friendly
* Searchable
* Interactive
* Example-driven
* Consistent
* Versioned

Every component page includes:

* Overview
* Installation
* Props
* Slots
* Events
* Examples
* Playground
* Accessibility
* API Reference

---

# Code Style

Generated examples should follow:

* PSR-12
* Laravel conventions
* Livewire best practices
* Tailwind utility ordering
* Meaningful variable names

---

# Marketing Tone

## Voice

GsmUi's voice is the consistent personality behind all communications. It remains constant across contexts, while tone adapts to the situation.

### Voice Characteristics

| Characteristic | What It Means | What It Doesn't Mean |
|---------------|---------------|---------------------|
| **Confident** | We know our product and speak with authority | Arrogant, dismissive, or condescending |
| **Helpful** | We genuinely want developers to succeed | Patronizing, overbearing, or pushy |
| **Honest** | We're transparent about capabilities and limitations | Blunt, negative, or discouraging |
| **Technical** | We use precise terminology and provide accurate details | Jargon-heavy, inaccessible, or confusing |
| **Professional** | We maintain high standards in all communication | Cold, corporate, or impersonal |

### Voice Principles

1. **Show expertise without showing off**: We know our stuff, but we don't make developers feel inadequate
2. **Be direct, not terse**: Get to the point without being rude
3. **Be helpful, not patronizing**: Assume developers are competent and want to learn
4. **Be honest, not negative**: Acknowledge limitations while focusing on solutions
5. **Be technical, not alienating**: Use precise language while remaining accessible

---

## Tone

Tone is the emotional coloring of our voice. It adapts to context while maintaining our core voice characteristics.

### Tone Spectrum

```
Formal ←————————————————————→ Casual

Technical Documentation:     ████████░░  (70% Formal)
Component Documentation:     ██████░░░░  (60% Formal)
Blog Posts:                  ████░░░░░░  (40% Formal)
Social Media:                ███░░░░░░░  (30% Formal)
Community Chat:              ██░░░░░░░░  (20% Formal)
```

### Context-Specific Tone

#### Technical Documentation

**Tone**: Precise, authoritative, reference-focused

**Do**:
* Use specific terminology
* Provide complete code examples
* Include edge cases and limitations
* Reference official specifications

**Don't**:
* Use casual language
* Add unnecessary commentary
* Oversimplify complex concepts
* Skip important details

**Example**:
> The `gsm:input` component accepts a `type` attribute that determines the input behavior. Supported types include `text`, `email`, `password`, `number`, `tel`, `url`, and `search`. The default type is `text`.

#### Getting Started Guides

**Tone**: Encouraging, step-by-step, beginner-friendly

**Do**:
* Break complex tasks into small steps
* Explain why each step matters
* Provide context for commands
* Celebrate progress

**Don't**:
* Assume prior knowledge
* Skip "obvious" steps
* Use unexplained jargon
* Rush through explanations

**Example**:
> Great! You've just created your first GsmUi component. Let's take a moment to understand what happened. The `x-gsm-button` directive registered a new Blade component, and GsmUi automatically configured it with our design tokens. You can now use this button throughout your application.

#### Blog Posts

**Tone**: Conversational, opinionated, storytelling

**Do**:
* Share real experiences
* Include personal perspectives
* Tell stories about the journey
* Be authentic and relatable

**Don't**:
* Sound like a press release
* Be overly self-promotional
* Ignore counterarguments
* Make unsupported claims

**Example**:
> We've been working on this for months, and I'm thrilled to finally share it with you. When we started building GsmUi, we knew we wanted something different — a UI ecosystem that felt like it was built by developers, for developers. Today, that vision becomes reality.

#### Error Messages

**Tone**: Clear, helpful, solution-oriented

**Do**:
* Explain what went wrong
* Suggest how to fix it
* Provide relevant documentation links
* Use plain language

**Don't**:
* Blame the user
* Use cryptic error codes
* Provide vague instructions
* Leave users stuck

**Example**:
> **Component not found**
> 
> The component `x-gsm-button` could not be found. This usually means:
> 
> 1. The component hasn't been installed yet
> 2. There's a typo in the component name
> 3. The component namespace is incorrect
> 
> **Solution**: Run `php artisan gsmui:install` to install all components, or check the [component reference](/docs/components/button) for the correct name.

#### Social Media

**Tone**: Enthusiastic, concise, engaging

**Do**:
* Share genuine excitement
* Ask questions
* Celebrate community wins
* Provide quick tips

**Don't**:
* Sound like a corporate account
* Overpost or spam
* Ignore conversations
* Be defensive

**Example**:
> Just shipped GsmUi 2.0! The new theming system is a game-changer. What feature are you most excited about? 👇

#### Community Chat (Discord, etc.)

**Tone**: Friendly, helpful, casual

**Do**:
* Welcome newcomers
* Share knowledge freely
* Celebrate contributions
* Be patient with questions

**Don't**:
* Gatekeep information
* Be dismissive of questions
* Over-moderate
* Ignore help requests

**Example**:
> Hey! Welcome to the GsmUi community. Feel free to ask any questions — we're all here to help each other build awesome things. What are you working on?

---

## Writing Guidelines

### Voice Consistency

| Situation | Voice | Example |
|-----------|-------|---------|
| Announcing a feature | Confident + Excited | "We're excited to announce..." |
| Explaining a concept | Helpful + Technical | "This works by..." |
| Acknowledging a bug | Honest + Solution-focused | "We've identified this issue and..." |
| Asking for feedback | Open + Welcoming | "We'd love to hear your thoughts..." |
| Declining a feature request | Honest + Helpful | "While this is a great idea, it doesn't align with..." |

### Language Rules

1. **Use active voice**: "Click the button" not "The button should be clicked"
2. **Be direct**: "Install the package" not "You might want to consider installing the package"
3. **Use present tense**: "The component renders" not "The component will render"
4. **Avoid jargon**: Use "select" not "dropdown menu UI element"
5. **Be inclusive**: Use "they" for singular subjects, avoid gendered language

### Terminology

| Use | Don't Use | Why |
|-----|-----------|-----|
| Component | Widget | Industry standard |
| Prop | Attribute | Laravel/React convention |
| Slot | Content area | Blade convention |
| Theme | Skin | More professional |
| Documentation | Docs | More formal |
| Repository | Repo | More complete |
| Configuration | Config | More precise |

---

## Brand Messages

### Elevator Pitch

> GsmUi is the complete Laravel UI ecosystem — a comprehensive component library, theming system, and developer tooling platform that helps you build beautiful, accessible applications faster.

### Taglines

* "Build beautiful Laravel apps, faster"
* "The UI ecosystem for Laravel developers"
* "Professional components. Beautiful themes. Happy developers."
* "Your complete Laravel frontend toolkit"

### Value Propositions

| Audience | Value Proposition |
|----------|------------------|
| Solo developers | Ship faster with production-ready components |
| Teams | Consistent UI with shared design tokens |
| Agencies | Reduce development time with reusable components |
| Enterprises | Accessible, maintainable, scalable UI systems |

---

## Communication Examples

### Feature Announcement

> **New: Theme Builder**
> 
> We've just released the Theme Builder — a powerful tool that lets you create custom GsmUi themes visually. Adjust colors, typography, spacing, and more with live preview. Export your theme as a Tailwind config or CSS variables file.
> 
> This is just the beginning. We're working on AI-powered theme suggestions and community theme sharing. Stay tuned!

### Bug Fix Announcement

> **Fixed: Modal focus trap**
> 
> We've resolved an issue where modal dialogs weren't properly trapping keyboard focus. This fix ensures that:
> 
> * Tab key cycles through focusable elements within the modal
> * Shift+Tab cycles backwards
> * Focus returns to the trigger element when the modal closes
> * Screen readers properly announce the modal content
> 
> Update to GsmUi 2.0.1 to get this fix.

### Community Highlight

> **Community Spotlight: Laravel Blog Starter**
> 
> Huge shoutout to @developer for building this amazing Laravel blog starter using GsmUi! It includes:
> 
> * Beautiful responsive design
> * Dark mode support
> * MDX blog posts
> * RSS feed generation
> * SEO optimization
> 
> Check it out and give them a star on GitHub!

---

## Content Review Checklist

Before publishing any GsmUi content, verify:

- [ ] **Voice**: Does it sound like GsmUi? (Confident, helpful, honest, technical, professional)
- [ ] **Tone**: Is the tone appropriate for the context?
- [ ] **Clarity**: Would a developer understand this without external context?
- [ ] **Accuracy**: Are all technical details correct?
- [ ] **Examples**: Are code examples complete and working?
- [ ] **Inclusivity**: Is the language inclusive and welcoming?
- [ ] **Grammar**: Is the grammar and spelling correct?
- [ ] **Formatting**: Is the content properly formatted for its medium?

---

# Merchandise Guidelines

Products include:

* T-Shirts
* Hoodies
* Stickers
* Mugs
* Caps
* Laptop Sleeves
* Mouse Pads

Merchandise should use:

* Minimal branding
* High-contrast printing
* Consistent typography
* Flat vector artwork

---

# Brand Application

## Business Cards

### Dimensions

| Market | Size | Bleed |
|--------|------|-------|
| US Standard | 3.5 × 2 inches | 0.125 inches |
| EU Standard | 85 × 55 mm | 3 mm |
| UK Standard | 85 × 55 mm | 3 mm |

### Layout

**Front**
```
┌─────────────────────────────────────┐
│                                     │
│  [Logo]                             │
│                                     │
│  Name                              │
│  Title                              │
│                                     │
│                                     │
│  ─────────────────────────────      │
│  email@example.com                  │
│  +1 (555) 123-4567                  │
│  gsmui.dev                          │
│                                     │
└─────────────────────────────────────┘
```

**Back**
```
┌─────────────────────────────────────┐
│                                     │
│                                     │
│          [Logo Mark]                │
│                                     │
│         Build beautiful             │
│         Laravel apps, faster        │
│                                     │
│                                     │
│                                     │
└─────────────────────────────────────┘
```

### Specifications

| Element | Value |
|---------|-------|
| Paper | 350gsm matte or soft-touch laminate |
| Primary text | Inter Medium, 9pt |
| Secondary text | Inter Regular, 8pt |
| Name | Inter Semibold, 12pt |
| Logo | Minimum 24px height equivalent |
| Margins | 5mm minimum from all edges |
| Color | CMYK — Primary: C:61 M:53 Y:0 K:0 |

### Business Card Templates

Available in Figma as "GsmUi Business Card — [Name]" with auto-layout for easy editing.

---

## Social Media

### Profile Images

| Platform | Size | Format | Notes |
|----------|------|--------|-------|
| GitHub | 500×500 | PNG | Icon only, no wordmark |
| Twitter/X | 400×400 | PNG | Icon only, safe area 320×320 |
| LinkedIn | 400×400 | PNG | Icon only |
| Discord | 512×512 | PNG | Icon only |
| YouTube | 800×800 | PNG | Icon only |
| Figma Community | 512×512 | PNG | Icon only |

### Cover Images

| Platform | Size | Format |
|----------|------|--------|
| Twitter/X | 1500×500 | PNG/JPG |
| LinkedIn | 1584×396 | PNG/JPG |
| YouTube | 2560×1440 | PNG |
| GitHub Profile | 1280×640 | PNG |

### Social Media Post Templates

**Feature Announcement**
```
┌─────────────────────────────────────┐
│ [Gradient Background]               │
│                                     │
│  NEW FEATURE                        │
│  Feature Name                       │
│                                     │
│  Brief description of what it       │
│  does and why developers should     │
│  care about it.                     │
│                                     │
│  [Logo]          gsmui.dev          │
└─────────────────────────────────────┘
```

**Community Spotlight**
```
┌─────────────────────────────────────┐
│ [Surface Background]                │
│                                     │
│  COMMUNITY SPOTLIGHT                │
│                                     │
│  "Quote from community member"      │
│                                     │
│  — Name, Project Name               │
│                                     │
│  [Logo]          gsmui.dev          │
└─────────────────────────────────────┘
```

**Tutorial Teaser**
```
┌─────────────────────────────────────┐
│ [Dark Background]                   │
│                                     │
│  TUTORIAL                           │
│  How to Build X with GsmUi         │
│                                     │
│  [Code Screenshot]                  │
│                                     │
│  Read more →                        │
│  [Logo]          gsmui.dev          │
└─────────────────────────────────────┘
```

### Hashtag Guidelines

| Primary | Secondary | Community |
|---------|-----------|-----------|
| #GsmUi | #LaravelUI | #GsmUiCommunity |
| | #LivewireUI | #BuiltWithGsmUi |
| | #LaravelDev | #GsmUiTheme |

---

## Presentations

### Slide Dimensions

| Format | Size | Aspect Ratio |
|--------|------|--------------|
| Standard | 1920×1080 | 16:9 |
| Wide | 2560×1440 | 16:9 |
| Vertical | 1080×1920 | 9:16 |

### Slide Layouts

**Title Slide**
```
┌─────────────────────────────────────┐
│                                     │
│  [Logo]                             │
│                                     │
│  Presentation Title                 │
│  Subtitle or event name             │
│                                     │
│  Presenter Name                     │
│  Date                               │
│                                     │
└─────────────────────────────────────┘
```

**Content Slide**
```
┌─────────────────────────────────────┐
│  Section Title              [Logo]  │
│  ─────────────────────────────────  │
│                                     │
│  Content area with text, code,      │
│  or images                          │
│                                     │
│                                     │
│  ─────────────────────────────────  │
│  Page 5                             │
└─────────────────────────────────────┘
```

**Code Slide**
```
┌─────────────────────────────────────┐
│  Code Example               [Logo]  │
│  ─────────────────────────────────  │
│                                     │
│  ┌─────────────────────────────┐   │
│  │ // Code block                │   │
│  │ <x-gsm-button>              │   │
│  │   Click me                  │   │
│  │ </x-gsm-button>             │   │
│  └─────────────────────────────┘   │
│                                     │
│  ─────────────────────────────────  │
│  Page 5                             │
└─────────────────────────────────────┘
```

### Presentation Typography

| Element | Font | Size | Weight |
|---------|------|------|--------|
| Title | Inter | 48pt | Bold |
| Subtitle | Inter | 24pt | Regular |
| Section Header | Inter | 32pt | Semibold |
| Body Text | Inter | 20pt | Regular |
| Code | JetBrains Mono | 18pt | Regular |
| Caption | Inter | 14pt | Regular |

### Presentation Colors

| Element | Color |
|---------|-------|
| Background | `#ffffff` or `#0f172a` |
| Text | `#0f172a` or `#f8fafc` |
| Headings | `#6366f1` |
| Code background | `#1e293b` |
| Accent | `#0ea5e9` |

---

## Email Templates

### Transactional Emails

**Welcome Email**
```
Subject: Welcome to GsmUi!

Hi [Name],

Welcome to GsmUi! We're excited to have you join our community of Laravel developers building beautiful applications.

Here's what you can do next:

1. Browse the component library
2. Try the theme builder
3. Join our Discord community

Happy coding!
The GsmUi Team
```

**Password Reset**
```
Subject: Reset your GsmUi password

Hi [Name],

We received a request to reset your password. Click the link below to create a new password:

[Reset Button]

This link expires in 24 hours. If you didn't request this, you can safely ignore this email.

The GsmUi Team
```

### Marketing Emails

**Newsletter Template**
```
┌─────────────────────────────────────┐
│  [Logo]                             │
│                                     │
│  GsmUi Newsletter — [Month Year]    │
│                                     │
│  ─────────────────────────────────  │
│                                     │
│  FEATURED ARTICLE                   │
│  Title                              │
│  Brief excerpt...                   │
│  [Read More]                        │
│                                     │
│  ─────────────────────────────────  │
│                                     │
│  NEW COMPONENTS                     │
│  • Component 1                      │
│  • Component 2                      │
│  • Component 3                      │
│                                     │
│  ─────────────────────────────────  │
│                                     │
│  COMMUNITY HIGHLIGHTS               │
│  • Project showcase                 │
│  • Tutorial of the month            │
│                                     │
│  ─────────────────────────────────  │
│                                     │
│  [Footer with unsubscribe link]     │
└─────────────────────────────────────┘
```

### Email Specifications

| Element | Value |
|---------|-------|
| Max width | 600px |
| Background | `#f8fafc` |
| Content background | `#ffffff` |
| Primary text | `#0f172a` |
| Secondary text | `#64748b` |
| Link color | `#6366f1` |
| Button color | `#6366f1` |
| Font stack | `-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif` |
| Font size | 16px body, 14px secondary |

---

## Documentation Assets

### Code Block Styling

```css
.code-block {
  background: var(--gsm-surface);
  border: 1px solid var(--gsm-border);
  border-radius: 8px;
  padding: 16px;
  font-family: 'JetBrains Mono', monospace;
  font-size: 14px;
  line-height: 1.6;
  overflow-x: auto;
}
```

### Callout Boxes

| Type | Icon | Border Color | Background |
|------|------|--------------|------------|
| Info | ℹ️ | `#3b82f6` | `#eff6ff` |
| Success | ✅ | `#22c55e` | `#f0fdf4` |
| Warning | ⚠️ | `#f59e0b` | `#fffbeb` |
| Error | ❌ | `#ef4444` | `#fef2f2` |

### Documentation Images

| Type | Size | Format |
|------|------|--------|
| Screenshot | Max 1200px wide | WebP |
| Diagram | Max 800px wide | SVG |
| GIF (demo) | Max 800×600 | GIF (max 5MB) |
| Video (demo) | 1920×1080 | MP4 (max 50MB) |

---

## Co-Branding Guidelines

### Partnership Levels

| Level | Description | Usage Rights |
|-------|-------------|--------------|
| Official Partner | Strategic integration, joint marketing | Full co-branding, joint logo placement |
| Contributing Partner | Community contributions, marketplace | "Built with GsmUi" badge |
| Community Member | General usage | "Uses GsmUi" attribution |

### Co-Brand Logo Placement

**Partner Logo + GsmUi Logo**

```
┌─────────────────────────────────────┐
│                                     │
│  [Partner Logo]  ×  [GsmUi Logo]   │
│                                     │
└─────────────────────────────────────┘
```

**Rules**:
1. Both logos must be equal in visual weight
2. Minimum 24px gap between logos
3. "×" symbol used as separator (not "+" or "&")
4. Both logos must be on the same baseline
5. Neither logo may be modified

### Attribution Text

| Level | Text | Placement |
|-------|------|-----------|
| Partner | "Partnered with GsmUi" | Footer, about page |
| Contributing | "Built with GsmUi" | Footer, README |
| Community | "Uses GsmUi components" | Optional |

### Co-Brand Guidelines

1. **Logo Lockups**: Pre-approved lockups available in brand kit
2. **Minimum Size**: Both logos must be ≥24px height
3. **Clear Space**: Maintain original clear space for both logos
4. **Color**: Both logos may use their original colors or monochrome
5. **Background**: Logos must have sufficient contrast with background

### Digital Co-Branding

**Website Footer**
```html
<footer>
  <p>Built with <a href="https://gsmui.dev">GsmUi</a></p>
</footer>
```

**README Badge**
```markdown
[![Built with GsmUi](https://img.shields.io/badge/Built%20with-GsmUi-6366f1)](https://gsmui.dev)
```

**Social Media**
```
Built with @GsmUi — the Laravel UI ecosystem 🚀
```

---

## Digital Asset Specifications

### Logo File Formats

| Format | Usage | Files |
|--------|-------|-------|
| SVG | Web, scalable | `gsmui-logo.svg`, `gsmui-icon.svg` |
| PNG | Fallback, social | `gsmui-logo-{size}.png` |
| ICO | Favicon | `favicon.ico` |
| PDF | Print | `gsmui-logo.pdf` |

### Logo Size Variants

| Name | Width | Height | Usage |
|------|-------|--------|-------|
| Full (SM) | 80px | 24px | Compact headers |
| Full (MD) | 120px | 36px | Standard headers |
| Full (LG) | 160px | 48px | Hero sections |
| Icon (SM) | 24px | 24px | Favicons, small spaces |
| Icon (MD) | 32px | 32px | App icons, standard |
| Icon (LG) | 48px | 48px | Feature highlights |
| Icon (XL) | 64px | 64px | Hero sections |

### Color Palette Files

| Format | Usage | Content |
|--------|-------|---------|
| CSS | Web | `:root { --gsm-primary: #6366f1; }` |
| SCSS | Web | `$gsm-primary: #6366f1;` |
| Tailwind | Web | `tailwind.config.js` colors object |
| JSON | Design tools | `{ "primary": "#6366f1" }` |
| Figma | Design | Color styles library |

### Font Files

| Format | Usage | Notes |
|--------|-------|-------|
| WOFF2 | Web (primary) | Smallest file size |
| WOFF | Web (fallback) | Older browser support |
| TTF | Desktop | Installation |
| OTF | Print | High-quality rendering |

### Icon Files

| Format | Usage | Optimization |
|--------|-------|--------------|
| SVG | Web (inline) | SVGO optimized |
| SVG Sprite | Web (sprite) | Combined SVGs |
| PNG | Fallback | @2x, @3x variants |

### Asset Naming Convention

```
gsmui-{category}-{variant}-{size}.{format}

Examples:
gsmui-logo-full-md.svg
gsmui-icon-primary-32.png
gsmui-font-inter-medium.woff2
gsmui-icon-check-circle-24.svg
```

### Asset Directory Structure

```
/assets
  /brand
    /logo
      /svg
      /png
      /pdf
    /icons
      /outline
      /solid
      /sprite
    /colors
      /css
      /scss
      /tailwind
      /figma
    /fonts
      /inter
      /jetbrains-mono
      /lora
  /templates
    /business-cards
    /social-media
    /presentations
    /email
  /documentation
    /callouts
    /code-blocks
    /screenshots
```

---

## Asset Versioning

### Version Format

```
MAJOR.MINOR.PATCH

MAJOR: Breaking changes to assets (new logo, color palette changes)
MINOR: Additions (new icon variants, new templates)
PATCH: Fixes (typo corrections, minor adjustments)
```

### Changelog Format

```markdown
## [2.1.0] - 2026-01-15

### Added
- 10 new navigation icons
- Business card template for EU format
- Email newsletter template

### Changed
- Updated primary color from #5B5FC7 to #6366f1
- Improved icon grid consistency

### Fixed
- Corrected SVG viewBox on 5 icons
- Fixed color contrast in dark mode templates
```

### Asset Registry

Maintain a central registry of all approved assets:

| Asset | Version | Last Updated | Status |
|-------|---------|--------------|--------|
| Logo (SVG) | 2.0.0 | 2026-01-15 | Active |
| Logo (PNG) | 2.0.0 | 2026-01-15 | Active |
| Icon Set | 1.5.0 | 2026-01-10 | Active |
| Color Palette | 2.1.0 | 2026-01-15 | Active |
| Font Files | 1.0.0 | 2025-12-01 | Active |
| Business Cards | 1.0.0 | 2025-11-15 | Active |
| Social Templates | 1.2.0 | 2026-01-05 | Active |
| Email Templates | 1.1.0 | 2025-12-20 | Active |

---

# Brand Assets

Maintain a centralized asset library containing:

* Logos
* Icons
* Color palettes
* Design tokens
* Figma components
* Social media templates
* Presentation templates
* Merchandise artwork

---

# Brand Governance

Changes to the design system must:

1. Be proposed through RFCs.
2. Include accessibility review.
3. Include performance review.
4. Maintain backward compatibility where practical.
5. Be documented before release.

---

# Success Criteria

The GsmUi brand should be immediately recognizable through:

* Consistent visual identity
* Cohesive design language
* High-quality documentation
* Uniform component behavior
* Professional communication
* Reliable developer experience

Every new feature, template, or component should reinforce these principles, ensuring GsmUi remains a trusted and scalable ecosystem for Laravel developers.

---

# Security Standards

## Brand Security

### Logo Protection
- All logo usage must be approved by brand team
- Watermarks required for unauthorized usage
- Usage tracking for all brand assets
- Legal protection for intellectual property

### Asset Security
- Encrypted storage for brand assets
- Access control for brand team members
- Version control for all brand files
- Audit logs for asset modifications

### Platform Security
- SSL/TLS encryption for all brand assets
- Secure CDN for asset delivery
- Regular security audits
- Vulnerability scanning

---

## Content Security

### Documentation Security
- Input validation for all user content
- XSS prevention for code examples
- CSRF protection for interactive features
- Content security policies

### Community Content
- Moderation for user submissions
- Spam prevention
- Inappropriate content filtering
- Version control for community assets

### API Security
- Rate limiting for brand API
- Authentication for asset access
- Authorization for modifications
- Audit logging for all changes

---

# Testing Standards

## Brand Testing

### Visual Testing
- Cross-browser compatibility
- Responsive design testing
- Dark mode testing
- RTL support testing
- High contrast testing

### Accessibility Testing
- WCAG 2.2 AA compliance
- Keyboard navigation testing
- Screen reader testing
- Color contrast testing
- Focus state testing

### Performance Testing
- Asset loading speed
- CDN performance
- Image optimization
- Font loading performance

---

## Component Testing

### Unit Testing
- Component rendering
- Props validation
- Event handling
- State management

### Integration Testing
- Component composition
- Theme integration
- Documentation integration
- Marketplace integration

### E2E Testing
- User workflows
- Cross-browser testing
- Mobile testing
- Performance testing

---

## Documentation Testing

### Content Testing
- Link validation
- Code example testing
- Search functionality
- Version compatibility

### Usability Testing
- Developer feedback
- Onboarding testing
- Support ticket analysis
- Community feedback

---

# Conclusion

The GsmUi brand represents a commitment to excellence in the Laravel UI ecosystem. Through consistent application of these guidelines, we ensure:

- **Visual Consistency**: Every touchpoint reinforces the brand identity
- **Developer Trust**: Professional, reliable, and accessible experiences
- **Community Growth**: Clear guidelines enable contribution and collaboration
- **Business Value**: Strong brand recognition drives adoption and retention

## Key Success Factors

1. **Consistency**: Apply guidelines uniformly across all products
2. **Quality**: Maintain high standards in all brand applications
3. **Evolution**: Update guidelines as the ecosystem grows
4. **Community**: Enable contributions while maintaining brand integrity
5. **Measurement**: Track brand health through key metrics

## Brand Health Metrics

- **Recognition**: 80%+ brand recognition in Laravel community
- **Consistency**: 95%+ guideline compliance across products
- **Satisfaction**: 90%+ developer satisfaction with brand experience
- **Growth**: 50%+ annual growth in brand awareness

---

# Future Evolution

## Short-Term (1-2 Years)

### Brand Expansion
- Multi-language brand support
- Regional brand variations
- Mobile-first brand experiences
- Social media brand guidelines
- Video content brand standards

### Asset Evolution
- 3D component previews
- Interactive brand guidelines
- AI-powered brand tools
- Real-time brand monitoring
- Automated brand compliance

### Community Integration
- Brand ambassador program
- Community brand contributions
- Brand certification program
- Brand asset marketplace
- Brand collaboration tools

---

## Medium-Term (2-3 Years)

### Brand Intelligence
- AI brand analysis
- Predictive brand trends
- Automated brand optimization
- Brand performance analytics
- Competitive brand analysis

### Global Expansion
- International brand guidelines
- Cultural adaptation guidelines
- Regional brand partnerships
- Localized brand assets
- Global brand governance

### Enterprise Features
- White-label brand solutions
- Enterprise brand management
- Brand compliance reporting
- Brand asset licensing
- Brand analytics dashboard

---

## Long-Term (3-5 Years)

### Brand Leadership
- Industry-standard brand guidelines
- Brand innovation leadership
- Brand thought leadership
- Brand education programs
- Brand research initiatives

### Technology Integration
- AR/VR brand experiences
- AI brand creation
- Blockchain brand verification
- IoT brand applications
- Metaverse brand presence

### Ecosystem Maturity
- Complete brand ecosystem
- Global brand community
- Brand industry standards
- Brand innovation lab
- Brand future research

---

# Brand Governance Evolution

## Governance Model

### Current State
- Centralized brand team
- Manual approval processes
- Quarterly brand reviews
- Annual guideline updates

### Future State
- Distributed brand community
- Automated compliance checks
- Real-time brand monitoring
- Continuous guideline evolution

## Brand Evolution Process

1. **Research**: Market and community feedback
2. **Analysis**: Brand performance data
3. **Proposal**: Guideline updates
4. **Testing**: A/B testing and feedback
5. **Implementation**: Rollout and monitoring
6. **Review**: Performance assessment

## Brand Success Framework

### Brand Health Score
- Visual consistency: 25%
- Developer satisfaction: 25%
- Community engagement: 25%
- Business impact: 25%

### Brand Evolution Metrics
- Guideline adoption rate
- Brand asset usage
- Community contributions
- Developer feedback scores

---

*These brand guidelines will evolve with the GsmUi ecosystem, ensuring continued relevance and effectiveness in representing our commitment to Laravel developers worldwide.*

---

# Brand Timeline

The brand rollout follows a phased approach to ensure consistency and quality across all touchpoints.

## Phase 1 — Identity Foundation (Month 1-2)

| Deliverable | Status | Owner |
|-------------|--------|-------|
| Logo finalization (all variants) | Planned | Design |
| Color palette definition | Planned | Design |
| Typography selection and licensing | Planned | Design |
| Icon set (50 core icons) | Planned | Design |
| Design tokens (v1) | Planned | Design + Engineering |
| Brand guidelines document (v1) | Planned | Design |
| Figma component library (v1) | Planned | Design |

## Phase 2 — Digital Presence (Month 3-4)

| Deliverable | Status | Owner |
|-------------|--------|-------|
| Marketing website redesign | Planned | Design + Engineering |
| Documentation site theming | Planned | Engineering |
| Email templates | Planned | Design |
| Social media profiles | Planned | Marketing |
| Brand asset download page | Planned | Engineering |
| Figma community profile | Planned | Design |

## Phase 3 — Component Library (Month 5-6)

| Deliverable | Status | Owner |
|-------------|--------|-------|
| Component design tokens applied | Planned | Engineering |
| 50 components with brand styling | Planned | Engineering |
| Dark mode theme | Planned | Engineering |
| RTL support | Planned | Engineering |
| Component documentation | Planned | Technical Writing |
| Playground integration | Planned | Engineering |

## Phase 4 — Documentation Publication (Month 7-8)

| Deliverable | Status | Owner |
|-------------|--------|-------|
| Complete component documentation | Planned | Technical Writing |
| Getting started guide | Planned | Technical Writing |
| Theming guide | Planned | Technical Writing |
| Contribution guide | Planned | Technical Writing |
| API reference | Planned | Technical Writing |
| Video tutorials (5) | Planned | Marketing |

## Phase 5 — Community Launch (Month 9-10)

| Deliverable | Status | Owner |
|-------------|--------|-------|
| Discord server | Planned | Community |
| GitHub community health | Planned | Engineering |
| Showcase platform | Planned | Engineering |
| Blog launch | Planned | Marketing |
| Newsletter | Planned | Marketing |
| Community brand toolkit | Planned | Design |

## Phase 6 — Ecosystem Expansion (Month 11-12)

| Deliverable | Status | Owner |
|-------------|--------|-------|
| 150+ components | Planned | Engineering |
| Marketplace launch | Planned | Engineering + Design |
| Theme builder | Planned | Engineering |
| AI assistant | Planned | Engineering |
| Enterprise features | Planned | Engineering |
| Brand audit and refresh | Planned | Design |

---

# Budget Allocation

## Design System Budget

| Category | Q1 | Q2 | Q3 | Q4 | Total |
|----------|----|----|----|----|-------|
| Logo and identity design | $5,000 | $0 | $0 | $0 | $5,000 |
| Figma component library | $3,000 | $4,000 | $3,000 | $2,000 | $12,000 |
| Icon set creation | $2,000 | $1,000 | $1,000 | $1,000 | $5,000 |
| Design token system | $2,000 | $1,000 | $500 | $500 | $4,000 |
| Documentation design | $1,000 | $2,000 | $2,000 | $1,000 | $6,000 |
| Marketing website | $4,000 | $2,000 | $2,000 | $2,000 | $10,000 |
| **Total** | **$17,000** | **$10,000** | **$8,500** | **$6,500** | **$42,000** |

## Tool Costs

| Tool | Purpose | Monthly | Annual |
|------|---------|---------|--------|
| Figma Professional | Design tool | $15/user | $180/user |
| Figma Organization | Team management | $45/user | $540/user |
| Adobe Creative Cloud | Asset creation | $55/user | $660/user |
| Sketch (optional) | Mac design | $10/user | $120/user |
| Abstract | Version control for design | $10/user | $120/user |
| Brandpad | Brand guidelines hosting | $49/month | $588 |

## Licensing Fees

| License | Purpose | Cost |
|---------|---------|------|
| Inter font | Primary typeface | Free (SIL) |
| JetBrains Mono | Code font | Free (SIL) |
| Heroicons | Icon library | Free (MIT) |
| Stock photography | Marketing assets | $200/month |
| Video hosting | Tutorials | $50/month |

## Marketing Spend

| Channel | Monthly | Annual |
|---------|---------|--------|
| Content creation | $1,000 | $12,000 |
| Social media advertising | $500 | $6,000 |
| Developer conference sponsorship | $500 | $6,000 |
| Newsletter platform | $50 | $600 |
| SEO tools | $100 | $1,200 |
| **Total** | **$2,150** | **$25,800** |

## Merchandise Production

| Item | Unit Cost | Quantity | Total |
|------|-----------|----------|-------|
| T-shirts | $12 | 200 | $2,400 |
| Stickers (packs) | $3 | 500 | $1,500 |
| Hoodies | $25 | 50 | $1,250 |
| Mugs | $8 | 100 | $800 |
| Laptop sleeves | $15 | 50 | $750 |
| **Total** | — | — | **$6,700** |

---

# Risk Management

## Brand Risks

| Risk | Impact | Probability | Mitigation |
|------|--------|-------------|------------|
| Visual inconsistency across products | High | Medium | Design system enforcement, audits |
| Logo misuse by third parties | Medium | Low | Usage guidelines, legal protection |
| Color palette inaccessibility | High | Low | WCAG testing, color contrast checks |
| Typography rendering issues | Medium | Medium | Web font fallbacks, cross-browser testing |
| Dark mode quality gaps | High | Medium | Dedicated dark mode testing |
| Community brand dilution | Medium | Low | Brand guidelines for contributors |

## Mitigation Strategies

| Strategy | Implementation |
|----------|---------------|
| Design system audits | Quarterly visual audits across all products |
| Automated compliance | CI/CD checks for color contrast, spacing |
| Contribution guidelines | Brand requirements for PRs |
| Asset versioning | All brand assets versioned in Git |
| Training materials | Onboarding docs for new team members |

## Brand Protection

| Protection | Method |
|------------|--------|
| Trademark registration | Logo and wordmark in key jurisdictions |
| Domain registration | gsmui.com, gsmui.dev, gsmui.io |
| Social media handles | @gsmui on all major platforms |
| Copyright | All original content and designs |
| License enforcement | GPL/Commercial dual licensing |

## Legal Considerations

| Area | Action |
|------|--------|
| Trademark search | Pre-launch clearance |
| Logo trademark filing | Within 3 months of launch |
| Terms of service | Legal review before launch |
| Privacy policy | GDPR-compliant, legal review |
| License compliance | Audit all dependencies |
| Contributor agreements | CLA for code contributions |

## Trademark Registration

| Jurisdiction | Status | Timeline |
|--------------|--------|----------|
| United States (USPTO) | Planned | Q1-Q2 |
| European Union (EUIPO) | Planned | Q2-Q3 |
| United Kingdom (UKIPO) | Planned | Q2-Q3 |
| International (WIPO) | Planned | Q3-Q4 |

---

# Competitive Analysis

## Competitor Brand Analysis

| Competitor | Brand Strength | Visual Quality | Developer Perception |
|------------|---------------|----------------|---------------------|
| DaisyUI | Strong | High | Trusted, established |
| Flux UI | Strong | Very High | Premium, official |
| Mary UI | Moderate | High | Community-driven, modern |
| Aura UI | Growing | High | Fresh, innovative |
| Tailwind UI | Very Strong | Excellent | Industry standard |

## Differentiation Strategy

| Dimension | GsmUi Approach | Competitor Approach |
|-----------|---------------|-------------------|
| Visual identity | Modern, clean, developer-focused | Varies |
| Brand voice | Technical, helpful, confident | Varies |
| Documentation | Interactive, example-driven | Static, reference-heavy |
| Community | Centralized, active | Distributed, passive |
| Marketplace | Integrated, curated | Separate or absent |
| AI tools | Built-in, native | Separate integrations |

## Market Positioning

```
                    Premium Quality
                          │
                    Flux UI ●
                          │
         GsmUi ●──────────┼──────● Tailwind UI
                          │
              Aura UI ●   │
                          │
    ──────────────────────┼──────────────────────
    Narrow Focus          │          Broad Ecosystem
                          │
         Mary UI ●        │
                          │
              DaisyUI ●   │
                          │
                    Community-Driven
```

## SWOT Analysis

### Strengths

- Complete ecosystem (components, templates, docs, marketplace)
- Laravel-native with Livewire-first approach
- Modern visual identity and brand consistency
- Interactive tools (playground, theme builder)
- Community-first philosophy

### Weaknesses

- New brand, limited recognition
- Smaller initial component library
- Higher development costs for full ecosystem
- Brand guidelines need real-world validation

### Opportunities

- Growing Laravel ecosystem
- Developer demand for premium UI tools
- AI-powered development tools
- Enterprise adoption of Laravel
- Community contribution ecosystem

### Threats

- Established competitors with strong brands
- Open-source alternatives
- Rapid frontend technology changes
- Brand perception battles

---

# API Design Standards

## Naming Conventions

| Element | Convention | Example |
|---------|-----------|---------|
| Endpoints | kebab-case | `/api/v1/components` |
| Query parameters | snake_case | `?sort_by=created_at` |
| Response keys | snake_case | `"component_name"` |
| Error codes | SCREAMING_SNAKE | `VALIDATION_ERROR` |
| Version prefix | v{number} | `/api/v1/` |

## Response Formats

### Success Response

```json
{
  "status": "success",
  "data": {},
  "meta": {
    "request_id": "req_abc123",
    "timestamp": "2026-01-15T10:30:00Z",
    "pagination": {
      "current_page": 1,
      "total_pages": 10,
      "per_page": 20,
      "total": 200
    }
  }
}
```

### Error Response

```json
{
  "status": "error",
  "error": {
    "code": "VALIDATION_ERROR",
    "message": "The given data was invalid.",
    "details": [
      {
        "field": "email",
        "message": "The email field is required."
      }
    ]
  },
  "meta": {
    "request_id": "req_abc123"
  }
}
```

## Error Handling

| HTTP Status | Error Code | Usage |
|-------------|-----------|-------|
| 400 | BAD_REQUEST | Malformed request |
| 401 | UNAUTHORIZED | Missing or invalid auth |
| 403 | FORBIDDEN | Insufficient permissions |
| 404 | NOT_FOUND | Resource not found |
| 409 | CONFLICT | Resource conflict |
| 422 | VALIDATION_ERROR | Validation failure |
| 429 | RATE_LIMITED | Too many requests |
| 500 | INTERNAL_ERROR | Server error |

## Versioning

| Strategy | Details |
|----------|---------|
| URL versioning | `/api/v1/`, `/api/v2/` |
| Deprecation notice | 6-month window |
| Sunset header | RFC 8594 compliant |
| Backward compatibility | Minor versions only |

## Documentation Standards

| Requirement | Description |
|-------------|-------------|
| OpenAPI 3.1 | Machine-readable spec |
| Interactive testing | Try-it-out in docs |
| Code examples | cURL, PHP, JS, Python |
| Authentication guide | Step-by-step setup |
| Error reference | All error codes documented |
| Changelog | Version-by-version changes |

---

# Event System

## Design Events

| Event | Trigger | Payload |
|-------|---------|---------|
| `DesignTokenCreated` | New token added | Token data, author |
| `DesignTokenUpdated` | Token modified | Token data, changes |
| `ColorPaletteChanged` | Palette updated | Old palette, new palette |
| `TypographyUpdated` | Font changes | Typography config |
| `IconSetPublished` | Icon set released | Icons list, version |

## Component Events

| Event | Trigger | Payload |
|-------|---------|---------|
| `ComponentCreated` | New component | Component metadata |
| `ComponentPublished` | Version release | Version data, changelog |
| `ComponentDeprecated` | Deprecation | Replacement info |
| `ComponentReviewSubmitted` | User review | Rating, comment |
| `ComponentInstalled` | User install | User, version |

## Theme Events

| Event | Trigger | Payload |
|-------|---------|---------|
| `ThemeCreated` | New theme | Theme data |
| `ThemeInstalled` | User applies theme | Theme, user |
| `ThemePublished` | Theme marketplace | Theme, author |
| `ThemeCustomized` | User modifications | Customizations |

## Documentation Events

| Event | Trigger | Payload |
|-------|---------|---------|
| `DocPageCreated` | New page | Page content |
| `DocPageUpdated` | Edit | Changes, author |
| `DocVersionPublished` | Version release | Version data |
| `SearchQueryPerformed` | User search | Query, results |
| `TutorialCompleted` | User completes | Tutorial, user |

## Community Events

| Event | Trigger | Payload |
|-------|---------|---------|
| `ShowcaseProjectSubmitted` | Submission | Project data |
| `ShowcaseProjectFeatured` | Featured | Project, reason |
| `DiscussionCreated` | New thread | Thread data |
| `TutorialPublished` | New tutorial | Tutorial, author |
| `ContributionMerged` | PR merge | PR data, contributor |

---

# Database Schema

## Design Token Storage

| Table | Purpose | Key Columns |
|-------|---------|-------------|
| `design_tokens` | Token definitions | id, name, category, value, type |
| `design_token_sets` | Token groupings | id, name, description, version |
| `design_token_set_tokens` | Token-set mapping | token_id, set_id |

## Component Metadata

| Table | Purpose | Key Columns |
|-------|---------|-------------|
| `components` | Component registry | id, slug, name, category, status |
| `component_versions` | Version history | id, component_id, version, changelog |
| `component_dependencies` | Dependencies | id, component_id, dependency_id |
| `component_tags` | Tagging | id, component_id, tag |

## Theme Configurations

| Table | Purpose | Key Columns |
|-------|---------|-------------|
| `themes` | Theme definitions | id, name, author_id, is_premium |
| `theme_tokens` | Token overrides | id, theme_id, token_id, value |
| `theme_components` | Component styles | id, theme_id, component_id, overrides |
| `theme_variants` | Theme variants | id, theme_id, variant_name |

## User Preferences

| Table | Purpose | Key Columns |
|-------|---------|-------------|
| `user_preferences` | Settings | id, user_id, key, value |
| `user_theme_settings` | Theme choices | id, user_id, theme_id, dark_mode |
| `user_favorites` | Saved items | id, user_id, favoritable_type, favoritable_id |
| `user_recent_views` | View history | id, user_id, viewable_type, viewable_id |

## Analytics Data

| Table | Purpose | Key Columns |
|-------|---------|-------------|
| `analytics_events` | Event tracking | id, event_type, user_id, payload |
| `page_views` | Page traffic | id, url, user_id, duration |
| `component_views` | Component popularity | id, component_id, user_id, timestamp |
| `search_queries` | Search patterns | id, query, results_count, user_id |
| `download_logs` | Download tracking | id, user_id, asset_type, asset_id |

---

# Resource Allocation

## Design Team Structure

| Role | Count | Focus |
|------|-------|-------|
| Design lead | 1 | Brand strategy, design system |
| UI designer | 1 | Component design, themes |
| Visual designer | 1 | Marketing, illustrations |
| Motion designer | 1 | Animations, micro-interactions |
| Design intern | 1 | Asset production |

## Tool Licenses

| Tool | Users | Cost/Year |
|------|-------|-----------|
| Figma Organization | 5 | $2,700 |
| Adobe Creative Cloud | 2 | $1,320 |
| Brandpad | 1 | $588 |
| Abstract | 5 | $600 |
| **Total** | — | **$5,208** |

## External Contractors

| Role | Usage | Cost |
|------|-------|------|
| Brand photographer | 2 shoots/year | $3,000 |
| Video production | Tutorials, promo | $5,000 |
| Motion graphics | Animations | $2,000 |
| Copywriter | Marketing content | $4,000 |
| **Total** | — | **$14,000** |

## Training Requirements

| Training | Audience | Frequency |
|----------|----------|-----------|
| Design system workshop | All designers | Quarterly |
| Accessibility training | All designers + devs | Semi-annual |
| Brand guidelines onboarding | New hires | On start |
| Figma advanced techniques | Design team | Quarterly |
| Color theory and contrast | Design team | Annual |

## Equipment Needs

| Equipment | Quantity | Cost |
|-----------|----------|------|
| MacBook Pro M3 | 3 | $7,500 |
| 4K monitors | 3 | $2,400 |
| Drawing tablets | 2 | $600 |
| Color-calibrated displays | 2 | $3,000 |
| Camera for documentation | 1 | $1,500 |
| **Total** | — | **$15,000** |
