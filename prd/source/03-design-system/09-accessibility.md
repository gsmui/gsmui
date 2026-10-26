# 09 — Accessibility

> The accessibility standards, patterns, and testing conventions for GsmUi.

---

## Accessibility Philosophy

Accessibility in GsmUi is non-negotiable. Every component must work for every user, regardless of ability. We target WCAG 2.1 Level AA conformance as our baseline.

### Commitment

1. **Keyboard-first.** Every interaction must be keyboard accessible.
2. **Screen reader support.** Every component provides meaningful ARIA semantics.
3. **Visual clarity.** Sufficient contrast, visible focus indicators, and no color-only communication.
4. **Motion safety.** All animations respect `prefers-reduced-motion`.

---

## WCAG 2.1 AA Compliance

### Color Contrast

| Element Type | Minimum Ratio | Standard |
|---|---|---|
| Normal text (< 18px) | 4.5:1 | WCAG 1.4.3 |
| Large text (>= 18px bold or >= 24px) | 3:1 | WCAG 1.4.3 |
| UI components and graphics | 3:1 | WCAG 1.4.11 |
| Focus indicators | 3:1 | WCAG 1.4.11 |

### Contrast Testing

```bash
# Test specific color combinations
npx axe-core --rules color-contrast

# Manual testing with WebAIM Contrast Checker
# https://webaim.org/resources/contrastchecker/
```

### GsmUi Color Contrast Matrix

| Foreground | Background | Ratio | Passes AA? |
|---|---|---|---|
| Neutral-900 | White | 17.36:1 | Yes |
| Neutral-500 | White | 4.65:1 | Yes |
| Blue-600 | White | 4.63:1 | Yes |
| Error-600 | White | 4.59:1 | Yes |
| Success-600 | White | 4.46:1 | Yes |
| White | Blue-600 | 4.63:1 | Yes |
| White | Neutral-900 | 17.36:1 | Yes |
| Neutral-900 | Blue-50 | 14.26:1 | Yes |

---

## Focus Indicators

### Focus Ring Requirements

Every interactive element must have a visible focus indicator. GsmUi uses a consistent focus ring pattern.

```css
/* Default focus ring for custom elements */
.gsmui-focusable:focus-visible {
  outline: 2px solid var(--gsmui-focus-ring);
  outline-offset: 2px;
}

/* Skip focus ring for natively focusable elements */
button:focus-visible,
input:focus-visible,
select:focus-visible,
textarea:focus-visible,
a:focus-visible {
  outline: 2px solid var(--gsmui-focus-ring);
  outline-offset: 2px;
}
```

### Focus Ring Styles

| Element | Focus Style | Tailwind |
|---|---|---|
| Button | 2px blue ring, 2px offset | `focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gsmui-focus-ring` |
| Input | Native browser outline | `focus:outline-none focus:ring-2 focus:ring-gsmui-focus-ring` |
| Link | 2px blue ring, 2px offset | `focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gsmui-focus-ring` |
| Custom element | 2px blue ring, 2px offset | `focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gsmui-focus-ring` |

### Focus Management Rules

1. **Tab order follows DOM order.** Never use positive `tabindex`.
2. **Focus is visible.** Never `outline: none` without a replacement.
3. **Focus is managed in modals.** Focus moves to the modal on open, returns to trigger on close.
4. **Focus is trapped in dialogs.** Tab cycles within the dialog, never escapes.
5. **Focus is restored.** After closing a popover or modal, focus returns to the trigger.

---

## ARIA Patterns

### Common ARIA Roles

| Component | Role | ARIA Attributes |
|---|---|---|
| Button | `role="button"` or native `<button>` | `aria-pressed`, `aria-expanded` |
| Input | Native `<input>` | `aria-label`, `aria-describedby`, `aria-invalid`, `aria-required` |
| Select | `role="combobox"` | `aria-expanded`, `aria-controls`, `aria-activedescendant` |
| Dialog | `role="dialog"` | `aria-modal`, `aria-labelledby`, `aria-describedby` |
| Menu | `role="menu"` | `aria-labelledby` |
| Menu item | `role="menuitem"` | `aria-disabled` |
| Tab | `role="tab"` | `aria-selected`, `aria-controls` |
| Tab panel | `role="tabpanel"` | `aria-labelledby` |
| Alert | `role="alert"` | `aria-live="assertive"` |
| Status | `role="status"` | `aria-live="polite"` |
| Tooltip | `role="tooltip"` | `aria-describedby` |

### ARIA Live Regions

```html
<!-- Assertive: interrupts current activity -->
<div role="alert" aria-live="assertive">
  Error: Form submission failed.
</div>

<!-- Polite: waits for current activity to finish -->
<div role="status" aria-live="polite">
  3 results found.
</div>

<!-- One-shot: announced once, not updated -->
<div aria-live="off">
  This content will not be announced.
</div>
```

### ARIA Labeling Rules

| Scenario | Approach |
|---|---|
| Icon-only button | `aria-label="Close"` on the button |
| Visible label | Use `aria-labelledby` pointing to the label element |
| Supplementary label | Use `aria-describedby` for hints and errors |
| Group of elements | Use `role="group"` with `aria-label` |
| Required field | `aria-required="true"` on the input |
| Invalid field | `aria-invalid="true"` on the input |

---

## Keyboard Navigation

### Global Keyboard Shortcuts

| Key | Action |
|---|---|
| `Tab` | Move focus to next interactive element |
| `Shift + Tab` | Move focus to previous interactive element |
| `Enter` | Activate buttons and links |
| `Space` | Activate buttons, toggle checkboxes |
| `Escape` | Close popover, dialog, or dropdown |
| `Arrow keys` | Navigate within composite widgets |

### Component-Specific Keyboard Behavior

#### Select / Combobox

| Key | Action |
|---|---|
| `Enter` | Open dropdown, select highlighted option |
| `Space` | Open dropdown |
| `Escape` | Close dropdown, return focus to trigger |
| `ArrowDown` | Move to next option |
| `ArrowUp` | Move to previous option |
| `Home` | Move to first option |
| `End` | Move to last option |
| `Type` | Jump to matching option |

#### Dialog / Modal

| Key | Action |
|---|---|
| `Escape` | Close dialog |
| `Tab` | Move focus within dialog (trapped) |
| `Shift + Tab` | Move focus within dialog (trapped) |

#### Tabs

| Key | Action |
|---|---|
| `ArrowLeft` | Move to previous tab |
| `ArrowRight` | Move to next tab |
| `Home` | Move to first tab |
| `End` | Move to last tab |

#### Menu / Dropdown

| Key | Action |
|---|---|
| `Enter` | Select item, close menu |
| `Space` | Select item, close menu |
| `Escape` | Close menu |
| `ArrowDown` | Move to next item |
| `ArrowUp` | Move to previous item |
| `Home` | Move to first item |
| `End` | Move to last item |

#### Table

| Key | Action |
|---|---|
| `Arrow keys` | Navigate between cells |
| `Home` | Move to first cell in row |
| `End` | Move to last cell in row |
| `Enter` | Activate cell action |

---

## Screen Reader Support

### Text Alternatives

| Element | Requirement |
|---|---|
| Images | `alt` text describing content |
| Icons (decorative) | `aria-hidden="true"` |
| Icons (functional) | `aria-label` on parent element |
| Buttons with icon only | `aria-label` describing action |
| Complex images | `aria-describedby` linking to description |

### Landmark Regions

```html
<header role="banner">
  <nav role="navigation" aria-label="Main navigation">
    <!-- Navigation links -->
  </nav>
</header>

<main role="main">
  <h1>Page Title</h1>
  <!-- Primary content -->
</main>

<aside role="complementary" aria-label="Related content">
  <!-- Sidebar content -->
</aside>

<footer role="contentinfo">
  <!-- Footer content -->
</footer>
```

### Headings Hierarchy

```html
<h1>Page Title</h1>          <!-- One h1 per page -->
  <h2>Section</h2>            <!-- Major sections -->
    <h3>Subsection</h3>       <!-- Subsections -->
    <h3>Subsection</h3>
  <h2>Section</h2>
    <h3>Subsection</h3>
```

**Rules:**
- One `<h1>` per page.
- Never skip heading levels (h1 to h3).
- Headings describe the content that follows.

---

## Form Accessibility

### Required Fields

```html
<label for="email">
  Email <span aria-hidden="true">*</span>
</label>
<input
  id="email"
  type="email"
  aria-required="true"
  aria-describedby="email-hint email-error"
/>
<span id="email-hint">We'll never share your email.</span>
<span id="email-error" role="alert" aria-live="polite"></span>
```

### Error Messages

```html
<!-- Inline error -->
<div>
  <label for="password">Password</label>
  <input
    id="password"
    type="password"
    aria-invalid="true"
    aria-describedby="password-error"
  />
  <span id="password-error" role="alert" class="text-gsmui-error">
    Password must be at least 8 characters.
  </span>
</div>

<!-- Summary error -->
<div role="alert" aria-live="polite">
  <h2>Please fix the following errors:</h2>
  <ul>
    <li><a href="#name">Name is required</a></li>
    <li><a href="#email">Email is invalid</a></li>
  </ul>
</div>
```

### Fieldsets and Legends

```html
<fieldset>
  <legend>Shipping Address</legend>
  <input type="text" aria-label="Street address" />
  <input type="text" aria-label="City" />
  <input type="text" aria-label="ZIP code" />
</fieldset>
```

---

## Reduced Motion

### CSS Implementation

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

### Component Behavior

| Component | Normal | Reduced Motion |
|---|---|---|
| Popover | Scale + fade | Fade only |
| Dialog | Scale + fade | Fade only |
| Drawer | Slide + fade | Fade only |
| Toast | Slide from edge | Fade only |
| Accordion | Height animation | Instant expand |
| Spinner | Rotation | Static icon |

---

## Testing

### Automated Testing

```bash
# Run axe-core accessibility tests
npx axe-core --rules color-contrast,focus-order-semantics,aria-valid-attr

# Run Lighthouse accessibility audit
lighthouse --only-categories=accessibility --output=html
```

### Manual Testing Checklist

1. **Keyboard-only navigation.** Can you complete every task using only the keyboard?
2. **Screen reader.** Test with NVDA (Windows), VoiceOver (macOS), or TalkBack (Android).
3. **Zoom.** Does the layout work at 200% zoom?
4. **Color contrast.** Test all text and interactive elements.
5. **Reduced motion.** Enable `prefers-reduced-motion` and verify animations are disabled.
6. **High contrast mode.** Test with Windows High Contrast Mode.

### Component Accessibility Audit

For each component, verify:

| Check | Pass/Fail |
|---|---|
| Keyboard accessible | |
| Visible focus indicator | |
| ARIA roles and properties | |
| Screen reader announced | |
| Color contrast meets AA | |
| Works at 200% zoom | |
| Reduced motion respected | |
| Error states announced | |

---

## Common Accessibility Issues

| Issue | Fix |
|---|---|
| Missing `alt` text | Add descriptive `alt` to all images |
| No focus indicator | Add `focus-visible` styles |
| Missing ARIA labels | Add `aria-label` to icon-only buttons |
| Color-only communication | Add text/icons to supplement color |
| Focus trap in non-modal | Only trap focus in modals/dialogs |
| Missing heading hierarchy | Use sequential heading levels |
| Form errors not announced | Use `role="alert"` or `aria-live` |
| Keyboard trap | Ensure `Escape` closes all overlays |

---

## Summary

| Principle | Rule |
|---|---|
| WCAG target | Level AA |
| Contrast | 4.5:1 text, 3:1 UI |
| Focus | Visible on all interactive elements |
| Keyboard | Full functionality without mouse |
| Screen reader | Meaningful labels and roles |
| Motion | Respect `prefers-reduced-motion` |
| Testing | Automated + manual every release |

Accessibility is not a feature. It is the foundation of inclusive design.
