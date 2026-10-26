# Product Vision — GsmUi

> **Last updated:** 2026-07-16
> **Owner:** Product Team
> **Status:** Active

---

## 1. Vision Statement

GsmUi is the definitive open-source Livewire UI component framework for Laravel, delivering production-grade, accessible, and beautiful interfaces that ship in days—not months.

We believe every Laravel developer deserves a Flux-class component library without the vendor lock-in or licensing friction. GsmUi exists to close the gap between what Laravel apps look like today and what they could become.

---

## 2. Mission

| Dimension | Statement |
|-----------|-----------|
| **Core mission** | Make high-quality UI components the default for every Laravel/Livewire application. |
| **Developer mission** | Eliminate the "build vs. buy" paralysis that stalls Laravel projects at the UI layer. |
| **Community mission** | Grow the largest, most active Livewire component ecosystem in the Laravel world. |

---

## 3. Target Audience

### 3.1 Primary Audience

| Segment | Profile | Needs |
|---------|---------|-------|
| **Solo Laravel developers** | Freelancers, indie hackers, small-agency owners building client projects | Fast setup, polished defaults, minimal config |
| **Small-to-mid agencies** | 2–15 person shops delivering Laravel projects for SMB clients | Consistent design language, reusable across projects, fast onboarding |
| **Internal dev teams** | SaaS companies running Laravel backends with Livewire frontends | Accessibility compliance, dark mode, component extensibility |

### 3.2 Secondary Audience

| Segment | Profile | Needs |
|---------|---------|-------|
| **Laravel learners** | Developers transitioning from WordPress, Django, or vanilla PHP | Clear documentation, opinionated patterns, working examples |
| **Open-source maintainers** | Authors of Laravel packages that need a UI layer | Composable primitives, non-conflicting CSS, thin integration surface |

---

## 4. Value Proposition

### 4.1 Core Value Props

| # | Value Prop | Evidence |
|---|-----------|----------|
| 1 | **Ship 3× faster** | Pre-built components eliminate CSS/JS work for 70+ UI patterns |
| 2 | **Accessible by default** | WCAG 2.1 AA compliance baked into every component |
| 3 | **Dark mode out of the box** | Zero-config dark/light toggle with CSS custom properties |
| 4 | **CSP-safe** | No CDN dependencies, no `eval()`, strict Content Security Policy compatible |
| 5 | **Laravel-native** | Uses Blade components, Livewire wiring, Tailwind CSS—no new paradigms |

### 4.2 Value Proposition Canvas

```
┌─────────────────────────────────┬─────────────────────────────────┐
│       CUSTOMER JOBS             │       PAINS                    │
│  - Build admin panels fast      │  - Writing CSS from scratch     │
│  - Ship accessible UIs          │  - Accessibility audits costly  │
│  - Maintain brand consistency   │  - Component drift across apps  │
│  - Support dark mode            │  - Dark mode is a nightmare     │
├─────────────────────────────────┼─────────────────────────────────┤
│       GAIN CREATORS             │       PAIN RELIEVERS           │
│  - Professional look & feel     │  - 70+ pre-styled components   │
│  - Consistent design tokens     │  - Token system enforces rules │
│  - Easy customization           │  - CSS vars + Tailwind merge   │
│  - Community support            │  - Active Discord + docs        │
└─────────────────────────────────┴─────────────────────────────────┘
```

---

## 5. Success Metrics

### 5.1 North Star Metric

**Weekly Active Developers (WAD)** — developers who import or update `gsmui/gsmui` in a `composer.json` within a rolling 7-day window.

### 5.2 Supporting Metrics

| Category | Metric | Target (12 months) | Target (24 months) |
|----------|--------|--------------------|--------------------|
| **Adoption** | GitHub stars | 3,000 | 10,000 |
| **Adoption** | Monthly npm installs | 15,000 | 50,000 |
| **Adoption** | Composer downloads/month | 25,000 | 80,000 |
| **Engagement** | Docs page views/month | 50,000 | 150,000 |
| **Engagement** | Average docs session duration | 4:30 min | 5:00 min |
| **Quality** | Component test coverage | 85% | 92% |
| **Quality** | Accessibility audit pass rate | 95% | 98% |
| **Community** | Discord members | 1,200 | 4,000 |
| **Community** | External contributions/month | 8 | 20 |
| **Revenue** | Pro license MRR | $5,000 | $25,000 |

---

## 6. Competitive Advantage

### 6.1 Competitive Landscape

| Competitor | Type | Pricing | GsmUi Advantage |
|-----------|------|---------|-----------------|
| **Flux Pro** | Closed-source Livewire components | $199+/yr | Open-source, CSP-safe, community-driven |
| **Livewire UI** | Community components | Free | Production-grade quality, accessibility, dark mode |
| **Filament** | Admin panel framework | Free / Pro | Focused on UI primitives, not admin CRUD |
| **Bootstrap** | General CSS framework | Free | Laravel-native, no jQuery, Livewire-first |
| **Headless UI** | Unstyled primitives | Free | Styled out-of-the-box, Blade components |

### 6.2 Moat

| Moat Type | Description |
|-----------|-------------|
| **Network effects** | Community contributions expand the component catalog faster than any single team can |
| **Switching costs** | Once integrated, component APIs become part of app architecture |
| **Brand** | "The Laravel UI framework" positioning in the community |
| **Data** | Usage patterns from opt-in telemetry inform better defaults |

---

## 7. Long-Term Goals

### 7.1 12-Month Goals

| # | Goal | Key Result |
|---|------|------------|
| G1 | Ship 70+ production-ready components | All components pass accessibility audit |
| G2 | Establish GsmUi as the #1 Livewire UI library | 3,000+ GitHub stars, 25K+ monthly downloads |
| G3 | Launch GsmUi Pro | 500+ paying subscribers, $5K MRR |
| G4 | Build community infrastructure | Discord, contribution guidelines, RFC process |

### 7.2 24-Month Goals

| # | Goal | Key Result |
|---|------|------------|
| G5 | Expand to Livewire 4 + Laravel 12 | Day-one support on new Laravel releases |
| G6 | Component marketplace | 50+ community-published component packs |
| G7 | Enterprise tier | 10+ enterprise customers, SSO, dedicated support |
| G8 | Design tool integration | Figma plugin for GsmUi component preview |

### 7.3 36-Month Vision

| Vision | Description |
|--------|-------------|
| **Full-stack Laravel UI** | GsmUi covers not just Livewire but also Inertia, Filament, and Laravel Pulse UI |
| **AI-assisted component generation** | Natural language → GsmUi component code |
| **Global localization** | RTL support, 20+ locale translations for all component labels |

---

## 8. Principles

| # | Principle | Meaning |
|---|-----------|---------|
| 1 | **Internal consistency > external best practices** | If one component does something, match it. Don't make one component "better" if it creates inconsistency. |
| 2 | **Punt semi-aggressively** | If a feature adds meaningful complexity without proportional value, cut it. Ship the simpler version. |
| 3 | **The most useful variant is the default** | Don't make users opt-in to the better experience. |
| 4 | **If it changes the component's shape, it's a separate component** | Inline mode is a different component, not an `inline` prop. |
| 5 | **Accept pragmatic imperfections** | Precision loss in color round-trips? Accept and move on. Don't over-engineer edge cases. |

---

## 9. Non-Goals

| Non-Goal | Rationale |
|----------|-----------|
| Admin panel builder | Filament owns this. GsmUi provides primitives, not CRUD scaffolding. |
| CSS framework replacement | We build on Tailwind CSS, not against it. |
| JavaScript framework competition | We are Livewire-first, not a generic JS library. |
| Mobile native apps | GsmUi targets web UIs only. |
| Real-time collaboration | Out of scope for the component layer. |

---

## 10. Risks & Mitigations

| Risk | Probability | Impact | Mitigation |
|------|------------|--------|------------|
| Livewire adoption plateaus | Low | High | Maintain compatibility with Blade-only usage |
| Flux Pro undercuts pricing | Medium | Medium | Open-source moat, community trust, CSP safety |
| Community contributions stall | Medium | High | Dedicated maintainer budget, contribution incentives |
| Laravel 12 breaking changes | Low | Medium | Early access to betas, core team relationships |

---

*This document is a living artifact. Review quarterly and update targets based on actual performance.*
