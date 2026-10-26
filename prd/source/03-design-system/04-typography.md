# 04 — Typography

> The type scale, font stack, and typographic conventions that define readability across GsmUi.

---

## Font Stack

GsmUi uses Inter as its primary font with system font fallbacks for maximum performance and readability.

```css
--gsmui-font-sans: 'Inter', ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont,
  'Segoe UI', Roboto, 'Helvetica Neue', Arial, 'Noto Sans', sans-serif,
  'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol', 'Noto Color Emoji';

--gsmui-font-mono: 'JetBrains Mono', ui-monospace, SFMono-Regular, 'SF Mono', Menlo,
  Consolas, 'Liberation Mono', monospace;
```

### Font Loading

```html
<link rel="preconnect" href="https://fonts.googleapis.com" />
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
<link
  href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap"
  rel="stylesheet"
/>
```

- Only weights 400 (regular), 500 (medium), 600 (semibold), and 700 (bold) are loaded.
- Font loading is non-blocking: `display=swap` ensures text renders immediately.

---

## Type Scale

The type scale defines every text size used across the system. Sizes are expressed in `rem` for scalability.

| Token | Size | Rem | Line Height | Usage |
|---|---|---|---|---|
| `--gsmui-text-2xs` | 10px | 0.625rem | 0.875rem (14px) | Overline labels |
| `--gsmui-text-xs` | 12px | 0.75rem | 1rem (16px) | Captions, helper text |
| `--gsmui-text-sm` | 14px | 0.875rem | 1.25rem (20px) | Small body text |
| `--gsmui-text-base` | 16px | 1rem | 1.5rem (24px) | Body text (default) |
| `--gsmui-text-lg` | 18px | 1.125rem | 1.75rem (28px) | Large body, lead text |
| `--gsmui-text-xl` | 20px | 1.25rem | 1.75rem (28px) | Section headings |
| `--gsmui-text-2xl` | 24px | 1.5rem | 2rem (32px) | Page headings |
| `--gsmui-text-3xl` | 30px | 1.875rem | 2.25rem (36px) | Section titles |
| `--gsmui-text-4xl` | 36px | 2.25rem | 2.5rem (40px) | Feature headings |
| `--gsmui-text-5xl` | 48px | 3rem | 1 (3rem) | Hero headings |
| `--gsmui-text-6xl` | 60px | 3.75rem | 1 (3.75rem) | Display headings |
| `--gsmui-text-7xl` | 72px | 4.5rem | 1 (4.5rem) | Hero display |

---

## Font Weights

| Token | Weight | CSS Value | Usage |
|---|---|---|---|
| `--gsmui-font-regular` | 400 | `font-weight: 400` | Body text |
| `--gsmui-font-medium` | 500 | `font-weight: 500` | Labels, emphasis |
| `--gsmui-font-semibold` | 600 | `font-weight: 600` | Headings, buttons |
| `--gsmui-font-bold` | 700 | `font-weight: 700` | Strong emphasis |

### Rules

- Body text is always `font-regular` (400).
- Headings are `font-semibold` (600), not `font-bold` (700).
- Buttons use `font-medium` (500).
- Never use `font-light` (300) or `font-extrabold` (800).

---

## Line Heights

Line heights are tuned per size for optimal readability.

| Size Range | Line Height | Ratio |
|---|---|---|
| 2xs (10px) | 14px | 1.4 |
| xs (12px) | 16px | 1.33 |
| sm (14px) | 20px | 1.43 |
| base (16px) | 24px | 1.5 |
| lg (18px) | 28px | 1.56 |
| xl–2xl (20–24px) | 32px | 1.33–1.5 |
| 3xl–7xl (30–72px) | Tight | ~1.1 |

### Tight Line Heights for Display Text

```css
.text-5xl { line-height: 1; }
.text-6xl { line-height: 1; }
.text-7xl { line-height: 1; }
```

Large display text uses tight line heights (`leading-none`) to create visual impact and avoid excessive vertical space.

---

## Letter Spacing

| Token | Value | Usage |
|---|---|---|
| `--gsmui-tracking-tighter` | -0.05em | Large display text (5xl+) |
| `--gsmui-tracking-tight` | -0.025em | Headings (xl–4xl) |
| `--gsmui-tracking-normal` | 0em | Body text |
| `--gsmui-tracking-wide` | 0.025em | Small caps, overline |
| `--gsmui-tracking-wider` | 0.05em | Overline labels |

### Rules

- Display text (5xl+) uses `tracking-tighter` to tighten letterforms at large sizes.
- Headings (xl–4xl) use `tracking-tight` for a polished feel.
- Body text always uses `tracking-normal`.
- Overline labels use `tracking-wider` for uppercase readability.

---

## Responsive Typography

Text sizes scale down on smaller viewports for readability.

| Element | Mobile | Tablet | Desktop |
|---|---|---|---|
| h1 | `text-3xl` (30px) | `text-4xl` (36px) | `text-5xl` (48px) |
| h2 | `text-2xl` (24px) | `text-3xl` (30px) | `text-4xl` (36px) |
| h3 | `text-xl` (20px) | `text-2xl` (24px) | `text-3xl` (30px) |
| h4 | `text-lg` (18px) | `text-xl` (20px) | `text-2xl` (24px) |
| Body | `text-base` (16px) | `text-base` (16px) | `text-base` (16px) |
| Lead | `text-base` (16px) | `text-lg` (18px) | `text-lg` (18px) |
| Caption | `text-xs` (12px) | `text-xs` (12px) | `text-xs` (12px) |

### Tailwind Responsive Pattern

```html
<h1 class="text-3xl sm:text-4xl lg:text-5xl font-semibold tracking-tight text-gsmui-text-primary">
  Page Heading
</h1>
```

---

## Typography Components

### Heading Component

```blade
<x-gsmui:heading level="1" size="5xl">
  Main Title
</x-gsmui:heading>

<x-gsmui:heading level="2" size="3xl">
  Section Title
</x-gsmui:heading>
```

### Text Component

```blade
<x-gsmui:text size="base" color="secondary">
  Body text with secondary color.
</x-gsmui:text>

<x-gsmui:text size="sm" color="tertiary">
  Helper text with tertiary color.
</x-gsmui:text>
```

---

## Prose Styles

For long-form content (articles, documentation, markdown), GsmUi provides prose styles.

```html
<div class="gsmui-prose">
  <h1>Title</h1>
  <p>Paragraph text uses the base type scale with 1.5 line height.</p>
  <h2>Section</h2>
  <p>Subheadings use semibold weight with tight tracking.</p>
  <ul>
    <li>List items have consistent spacing.</li>
    <li>Every element follows the type scale.</li>
  </ul>
  <blockquote>
    <p>Quotes use italic style with a left border.</p>
  </blockquote>
  <pre><code>Code blocks use the mono font stack.</code></pre>
  <table>
    <thead>
      <tr><th>Column A</th><th>Column B</th></tr>
    </thead>
    <tbody>
      <tr><td>Cell</td><td>Cell</td></tr>
    </tbody>
  </table>
</div>
```

### Prose Token Mapping

| Element | Font Size | Weight | Line Height | Color |
|---|---|---|---|---|
| h1 | `text-4xl` | 600 | 1.2 | `text-primary` |
| h2 | `text-3xl` | 600 | 1.3 | `text-primary` |
| h3 | `text-2xl` | 600 | 1.4 | `text-primary` |
| h4 | `text-xl` | 600 | 1.4 | `text-primary` |
| p | `text-base` | 400 | 1.6 | `text-secondary` |
| li | `text-base` | 400 | 1.6 | `text-secondary` |
| blockquote | `text-lg` | 400 | 1.6 | `text-secondary` |
| code | `text-sm` | 400 | 1.5 | `text-primary` (mono) |
| table | `text-sm` | 400 | 1.5 | `text-secondary` |
| caption | `text-xs` | 400 | 1.5 | `text-tertiary` |

---

## Text Colors in Context

| Context | Token | Color |
|---|---|---|
| Primary heading | `--gsmui-text-primary` | Neutral-900 |
| Body text | `--gsmui-text-primary` | Neutral-900 |
| Secondary text | `--gsmui-text-secondary` | Neutral-500 |
| Helper / caption | `--gsmui-text-tertiary` | Neutral-400 |
| Disabled text | `--gsmui-text-disabled` | Neutral-300 |
| Link | `--gsmui-action-primary` | Blue-600 |
| Link hover | `--gsmui-action-primary-hover` | Blue-700 |
| Error text | `--gsmui-feedback-error` | Error-600 |
| Success text | `--gsmui-feedback-success` | Success-600 |
| Text on dark bg | `--gsmui-text-inverse` | White |

---

## Tailwind Utilities

```js
// tailwind.config.js
module.exports = {
  theme: {
    extend: {
      fontSize: {
        '2xs': ['0.625rem', { lineHeight: '0.875rem' }],
        xs: ['0.75rem', { lineHeight: '1rem' }],
        sm: ['0.875rem', { lineHeight: '1.25rem' }],
        base: ['1rem', { lineHeight: '1.5rem' }],
        lg: ['1.125rem', { lineHeight: '1.75rem' }],
        xl: ['1.25rem', { lineHeight: '1.75rem' }],
        '2xl': ['1.5rem', { lineHeight: '2rem' }],
        '3xl': ['1.875rem', { lineHeight: '2.25rem' }],
        '4xl': ['2.25rem', { lineHeight: '2.5rem' }],
        '5xl': ['3rem', { lineHeight: '1' }],
        '6xl': ['3.75rem', { lineHeight: '1' }],
        '7xl': ['4.5rem', { lineHeight: '1' }],
      },
      fontFamily: {
        sans: ['Inter', 'ui-sans-serif', 'system-ui', 'sans-serif'],
        mono: ['JetBrains Mono', 'ui-monospace', 'monospace'],
      },
    },
  },
}
```

---

## Summary

| Principle | Rule |
|---|---|
| Scale | 12 sizes from 10px to 72px |
| Weights | 4 weights only (400, 500, 600, 700) |
| Line height | Tighter for large text, looser for body |
| Tracking | Tighter for display, normal for body |
| Color | Always via semantic tokens |
| Responsive | Sizes scale down on mobile |
| Font stack | Inter primary, system fallback |
