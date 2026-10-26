# Brand Guidelines — GsmUi

> **Last updated:** 2026-07-16
> **Owner:** Design & Marketing Team
> **Status:** Active

---

## 1. Brand Identity

### 1.1 Brand Essence

| Element | Definition |
|---------|-----------|
| **Brand name** | GsmUi |
| **Pronunciation** | "Gism-oo-eye" or "G-S-M-You-Eye" |
| **Tagline** | "Ship beautiful Laravel UIs." |
| **Elevator pitch** | GsmUi is the open-source Livewire component framework that gives Laravel developers production-grade, accessible, dark-mode-ready UI components in days, not months. |

### 1.2 Brand Personality

| Trait | Expression | Anti-Pattern |
|-------|-----------|--------------|
| **Confident** | We know what we ship. No hedging. | Arrogant, dismissive of alternatives |
| **Pragmatic** | We solve real problems, not theoretical ones | Cuts corners on quality |
| **Approachable** | Docs that make you smile, not squint | Dumbing down technical content |
| **Opinionated** | We make choices so you don't have to | Rigid, refusing valid alternatives |
| **Technical** | We speak developer, not marketing | Jargon-heavy, exclusionary |

---

## 2. Voice & Tone

### 2.1 Voice Characteristics

| Characteristic | What it sounds like | What it doesn't sound like |
|---------------|---------------------|---------------------------|
| **Direct** | "Use `<gsmui:input>` for text fields." | "You might consider using our input component for entering text data." |
| **Helpful** | "Here's how to fix the CSP violation." | "Refer to the documentation." |
| **Concise** | "Dark mode. Built in." | "Our comprehensive dark mode solution leverages CSS custom properties..." |
| **Technical** | "Uses `adoptedStyleSheets` for dynamic CSS." | "Uses advanced browser technology." |

### 2.2 Tone by Context

| Context | Tone | Example |
|---------|------|---------|
| **Documentation** | Precise, calm, authoritative | "The `size` prop accepts `sm`, `md`, or `lg`. Default is `md`." |
| **Error messages** | Helpful, specific, actionable | "CSP blocked inline script. Add `'unsafe-inline'` to `script-src` or move code to `gsmui.js`." |
| **Changelog** | Direct, factual, minimal | "Fixed: Date picker popover positioning in Safari." |
| **Social media** | Enthusiastic, concise, developer-focused | "70+ components. Zero CDN deps. Laravel-native. Ship fast." |
| **RFC discussions** | Collaborative, respectful, evidence-based | "I'd keep it simple. Here's why..." |

### 2.3 Writing Rules

| Rule | Example | Counter-Example |
|------|---------|-----------------|
| **Use active voice** | "GsmUi ships 70+ components." | "70+ components are shipped by GsmUi." |
| **Avoid jargon** | "Click the button." | "Execute the button interaction." |
| **Use contractions** | "You're all set." | "You are all set." |
| **No emojis in docs** | ✅ (clean) | 🎉🚀✨ (noisy) |
| **One idea per sentence** | Split complex sentences | Run-on sentences with multiple clauses |

---

## 3. Logo Usage

### 3.1 Logo Variants

| Variant | Use Case | Dimensions |
|---------|----------|------------|
| **Primary** | Website header, presentations | 200×48px min |
| **Compact** | Favicons, app icons, small spaces | 32×32px min |
| **Wordmark** | Documentation, email signatures | 160×32px min |
| **Icon-only** | Social profiles, CDN badges | 48×48px min |

### 3.2 Logo Rules

| Rule | Specification |
|------|--------------|
| **Clear space** | Minimum 1× logo height on all sides |
| **Minimum size** | 32px height (digital), 10mm (print) |
| **Backgrounds** | Use white variant on dark backgrounds, dark variant on light backgrounds |
| **Do not** | Stretch, rotate, recolor, add shadows, crop, or place on busy backgrounds |

---

## 4. Color Palette

### 4.1 Primary Colors

| Color | Hex | RGB | Usage |
|-------|-----|-----|-------|
| **GsmUi Blue** | `#3B82F6` | 59, 130, 246 | Primary brand, links, CTAs |
| **GsmUi Dark** | `#1E293B` | 30, 41, 59 | Text, dark backgrounds |
| **GsmUi White** | `#FFFFFF` | 255, 255, 255 | Light backgrounds, text on dark |

### 4.2 Secondary Colors

| Color | Hex | Usage |
|-------|-----|-------|
| **Slate 50** | `#F8FAFC` | Page backgrounds |
| **Slate 100** | `#F1F5F9` | Card backgrounds |
| **Slate 200** | `#E2E8F0` | Borders, dividers |
| **Slate 500** | `#64748B` | Secondary text |
| **Slate 700** | `#334155` | Headings |
| **Slate 900** | `#0F172A` | Primary text |

### 4.3 Semantic Colors

| Color | Hex | Usage |
|-------|-----|-------|
| **Success** | `#22C55E` | Valid states, confirmations |
| **Warning** | `#F59E0B` | Caution states, warnings |
| **Error** | `#EF4444` | Invalid states, destructive actions |
| **Info** | `#3B82F6` | Informational states, links |

### 4.4 Dark Mode Palette

| Light Mode | Dark Mode | Usage |
|-----------|-----------|-------|
| `#FFFFFF` | `#1E293B` | Background |
| `#F8FAFC` | `#0F172A` | Surface |
| `#E2E8F0` | `#334155` | Border |
| `#0F172A` | `#F8FAFC` | Text |
| `#3B82F6` | `#60A5FA` | Primary |

---

## 5. Typography

### 5.1 Font Stack

| Priority | Font | Fallback |
|----------|------|----------|
| 1 | **Inter** | system-ui, -apple-system, sans-serif |
| 2 | **System UI** | -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto |
| 3 | **Monospace** | "JetBrains Mono", "Fira Code", monospace |

### 5.2 Type Scale

| Token | Size | Weight | Line Height | Use Case |
|-------|------|--------|-------------|----------|
| `text-xs` | 12px | 400 | 16px | Captions, labels |
| `text-sm` | 14px | 400 | 20px | Body (compact) |
| `text-base` | 16px | 400 | 24px | Body (default) |
| `text-lg` | 18px | 400 | 28px | Large body |
| `text-xl` | 20px | 600 | 28px | Subheadings |
| `text-2xl` | 24px | 600 | 32px | Section headings |
| `text-3xl` | 30px | 700 | 36px | Page headings |
| `text-4xl` | 36px | 700 | 40px | Hero text |

---

## 6. Imagery

### 6.1 Photography Style

| Aspect | Guideline |
|--------|-----------|
| **Style** | Clean, minimal, developer-focused |
| **Subjects** | Code editors, terminals, laptops, abstract UI |
| **Mood** | Professional, focused, productive |
| **Color treatment** | Cool tones, desaturated backgrounds |
| **Avoid** | Stock photos of people pointing at screens,握手握手握手 |

### 6.2 Illustration Style

| Aspect | Guideline |
|--------|-----------|
| **Style** | Geometric, minimal, line-based |
| **Colors** | GsmUi Blue + Slate palette |
| **Complexity** | Simple shapes, clear concepts |
| **Use case** | Empty states, onboarding, error pages |

### 6.3 Screenshots

| Rule | Specification |
|------|--------------|
| **Resolution** | 2× retina minimum |
| **Browser chrome** | Minimal or hidden |
| **Content** | Realistic, not placeholder |
| **Annotations** | Red arrows/circles for documentation |

---

## 7. Brand Pillars

| Pillar | Description | Evidence |
|--------|-------------|----------|
| **Quality** | Every component is production-grade | Test coverage, accessibility audits |
| **Accessibility** | WCAG 2.1 AA compliance by default | Screen reader testing, keyboard navigation |
| **Laravel-native** | First-class Blade/Livewire integration | No custom build step, Tailwind-first |
| **Open-source** | Community-driven, MIT-licensed | Public roadmap, RFC process |
| **Developer experience** | Docs that teach, not just list | Interactive examples, copy-paste code |

---

## 8. Messaging Framework

### 8.1 Elevator Pitches

| Length | Pitch |
|--------|-------|
| **5 seconds** | "Beautiful Laravel UI components." |
| **15 seconds** | "GsmUi is the open-source Livewire component framework for Laravel. 70+ accessible, dark-mode-ready components that ship in days." |
| **30 seconds** | "GsmUi gives Laravel developers production-grade Livewire UI components without the vendor lock-in. Built on Tailwind CSS, accessible by default, CSP-safe, and dark-mode-ready. Open-source with a Pro tier for teams." |

### 8.2 Key Messages

| Audience | Primary Message | Supporting Proof |
|----------|----------------|------------------|
| **Solo developers** | "Ship beautiful UIs in days, not months." | 70+ components, zero config |
| **Agencies** | "Consistent design across every client project." | Token system, component library |
| **SaaS teams** | "Accessible, compliant, production-ready." | WCAG 2.1 AA, CSP-safe, dark mode |
| **Enterprise** | "No vendor lock-in. Open-source foundation." | MIT license, self-hosted, community |

### 8.3 Taglines

| Tagline | Use Case |
|---------|----------|
| "Ship beautiful Laravel UIs." | Primary brand tagline |
| "70+ components. Zero CDN deps." | Technical positioning |
| "Accessible by default." | Accessibility messaging |
| "Laravel-native. Livewire-first." | Ecosystem positioning |

---

## 9. Co-Branding

| Partner Type | Co-Brand Rule |
|-------------|---------------|
| **Laravel ecosystem** | "Built for Laravel" badge |
| **Tailwind CSS** | "Powered by Tailwind" attribution |
| **Livewire** | "Livewire-native" badge |
| **Community packages** | "Works with GsmUi" compatibility mark |

---

## 10. Brand Dos and Don'ts

| Do | Don't |
|----|-------|
| Use "GsmUi" (capital G, capital S, capital M, capital U, lowercase i) | Use "GSmui", "gsmUI", "GSMUI", "GSM UI" |
| Say "GsmUi" in prose | Say "The GsmUi Framework" |
| Use the official color palette | Invent new brand colors |
| Link to official docs | Link to forked/unofficial docs |
| Credit community contributions | Claim community work as internal |

---

*Review brand guidelines annually. Update as the brand evolves.*
