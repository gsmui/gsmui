# Accessibility Testing

> PRD — Volume 23: Quality Assurance — Accessibility Testing

## Overview

Accessibility testing ensures the gsmui platform meets WCAG 2.1 AA standards using automated tools (axe-core, pa11y), manual audit checklists, and CI-integrated checks.

## Objectives

| Goal | Metric | Target |
|------|--------|--------|
| WCAG compliance | Level | AA |
| Automated score | axe-core violations | 0 |
| Keyboard navigation | All interactive elements | 100% |
| Screen reader | All content accessible | 100% |
| Color contrast | Minimum ratio | 4.5:1 |

## WCAG 2.1 AA Requirements

### Principle 1: Perceivable

| Criterion | Requirement | Test Method |
|-----------|-------------|-------------|
| 1.1.1 Text Alternatives | All images have alt text | Automated |
| 1.2.1 Audio/Video | Captions for media | Manual |
| 1.3.1 Info & Relationships | Semantic HTML | Automated |
| 1.3.2 Meaningful Sequence | DOM order matches visual | Automated |
| 1.3.3 Sensory Characteristics | Not color/shape alone | Manual |
| 1.4.1 Use of Color | Color not sole indicator | Manual |
| 1.4.3 Contrast (Minimum) | 4.5:1 text contrast | Automated |
| 1.4.4 Resize Text | Text scalable to 200% | Manual |
| 1.4.10 Reflow | No horizontal scroll at 320px | Automated |
| 1.4.11 Non-text Contrast | 3:1 UI component contrast | Automated |

### Principle 2: Operable

| Criterion | Requirement | Test Method |
|-----------|-------------|-------------|
| 2.1.1 Keyboard | All functionality keyboard accessible | Manual |
| 2.1.2 No Keyboard Trap | Focus can move freely | Manual |
| 2.4.1 Bypass Blocks | Skip navigation link | Automated |
| 2.4.2 Page Titled | Descriptive page titles | Automated |
| 2.4.3 Focus Order | Logical tab order | Manual |
| 2.4.4 Link Purpose | Descriptive link text | Automated |
| 2.4.6 Headings & Labels | Descriptive headings | Automated |
| 2.4.7 Focus Visible | Visible focus indicator | Manual |
| 2.5.1 Pointer Gestures | Multi-point alternatives | Manual |
| 2.5.3 Label in Name | Accessible name matches label | Automated |

### Principle 3: Understandable

| Criterion | Requirement | Test Method |
|-----------|-------------|-------------|
| 3.1.1 Language of Page | HTML lang attribute | Automated |
| 3.1.2 Language of Parts | Lang for content changes | Automated |
| 3.2.1 On Focus | No unexpected changes | Manual |
| 3.2.2 On Input | Predictable behavior | Manual |
| 3.3.1 Error Identification | Errors clearly identified | Automated |
| 3.3.2 Labels/Instructions | Form labels present | Automated |
| 3.3.3 Error Suggestion | Error correction suggested | Manual |
| 3.3.4 Error Prevention | Confirmations for submissions | Manual |

### Principle 4: Robust

| Criterion | Requirement | Test Method |
|-----------|-------------|-------------|
| 4.1.1 Parsing | Valid HTML | Automated |
| 4.1.2 Name, Role, Value | ARIA attributes correct | Automated |
| 4.1.3 Status Messages | ARIA live regions | Automated |

## Automated Testing

### axe-core Integration

```javascript
// tests/Browser/Accessibility/accessibility.spec.js
const { test, expect } = require('@playwright/test');
const AxeBuilder = require('@axe-core/playwright').default;

const PAGES = [
    { name: 'Homepage', url: '/' },
    { name: 'Blog', url: '/blog' },
    { name: 'Blog Post', url: '/blog/sample-post' },
    { name: 'Pages', url: '/pages/about' },
    { name: 'Contact', url: '/contact' },
    { name: 'Search', url: '/search' },
    { name: 'Login', url: '/login' },
];

for (const page of PAGES) {
    test(`${page.name} accessibility`, async ({ page: p }) => {
        await p.goto(page.url);

        const results = await new AxeBuilder({ page: p })
            .withTags(['wcag2a', 'wcag2aa', 'wcag21aa'])
            .analyze();

        expect(results.violations).toEqual([]);
    });
}
```

### pa11y Integration

```json
// .pa11yci.json
{
    "defaults": {
        "standard": "WCAG2AA",
        "timeout": 10000,
        "wait": 2000,
        "reporters": ["json"],
        "chromeLaunchConfig": {
            "args": ["--no-sandbox"]
        }
    },
    "urls": [
        "http://localhost:8000/",
        "http://localhost:8000/blog",
        "http://localhost:8000/login",
        "http://localhost:8000/admin/pages"
    ]
}
```

### CI Integration

```yaml
name: Accessibility Tests

on:
  pull_request:
    branches: [main]

jobs:
  accessibility:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v4
      - name: Start Server
        run: |
          composer install
          php artisan migrate:fresh --seed
          php artisan serve --port=8000 &
      - name: Install pa11y
        run: npm install -g pa11y-ci
      - name: Run pa11y
        run: npx pa11y-ci
      - name: Run axe-core
        run: npx playwright test tests/Browser/Accessibility/
```

## Manual Audit Checklist

### Keyboard Navigation

- [ ] All interactive elements are focusable
- [ ] Tab order follows logical reading order
- [ ] Focus indicator is visible on all elements
- [ ] Skip navigation link is present and works
- [ ] Modal dialogs trap focus correctly
- [ ] Escape key closes modals and dropdowns
- [ ] Arrow keys navigate within composite widgets
- [ ] Enter/Space activate buttons and links
- [ ] No keyboard traps exist

### Screen Reader

- [ ] All images have descriptive alt text
- [ ] Form inputs have associated labels
- [ ] Error messages are announced via ARIA
- [ ] Dynamic content uses ARIA live regions
- [ ] Headings create logical document outline
- [ ] Landmark regions are properly defined
- [ ] Tables have headers and captions
- [ ] Icon-only buttons have accessible names

### Visual

- [ ] Text contrast ratio meets 4.5:1 minimum
- [ ] Large text contrast ratio meets 3:1 minimum
- [ ] UI component contrast ratio meets 3:1
- [ ] Content is readable at 200% zoom
- [ ] No information conveyed by color alone
- [ ] Focus indicators have sufficient contrast
- [ ] Placeholder text has sufficient contrast

## Common Violations

| Violation | WCAG | Fix |
|-----------|------|-----|
| Missing alt text | 1.1.1 | Add descriptive alt attributes |
| Low contrast text | 1.4.3 | Increase color contrast |
| Missing form labels | 1.3.1 | Add `<label>` elements |
| Missing skip link | 2.4.1 | Add skip navigation |
| No focus indicator | 2.4.7 | Add visible focus styles |
| Missing page title | 2.4.2 | Add descriptive `<title>` |
| Missing lang attribute | 3.1.1 | Add `lang` to `<html>` |
| Empty buttons | 4.1.2 | Add accessible names |
| Duplicate IDs | 4.1.1 | Use unique element IDs |

## Acceptance Criteria

- [ ] Zero axe-core violations on all pages
- [ ] Zero pa11y WCAG2AA violations
- [ ] All pages pass keyboard-only navigation
- [ ] All images have descriptive alt text
- [ ] All form inputs have associated labels
- [ ] Color contrast ratios meet WCAG minimums
- [ ] Focus indicators are visible on all interactive elements
- [ ] Skip navigation link is present
- [ ] ARIA attributes are used correctly
- [ ] Accessibility tests run in CI pipeline
