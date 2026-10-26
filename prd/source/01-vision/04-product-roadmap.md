# Product Roadmap — GsmUi

> **Last updated:** 2026-07-16
> **Owner:** Product Team
> **Status:** Active
> **Planning horizon:** 12 months (Q3 2026 – Q2 2027)

---

## 1. Roadmap Overview

| Phase | Timeline | Theme | Goal |
|-------|----------|-------|------|
| **Q3 2026** | Jul–Sep | Foundation | Ship core components, establish patterns |
| **Q4 2026** | Oct–Dec | Completeness | Reach 50+ components, dark mode, accessibility |
| **Q1 2027** | Jan–Mar | Quality | Performance, testing, documentation polish |
| **Q2 2027** | Apr–Jun | Ecosystem | Pro launch, marketplace, integrations |

---

## 2. Q3 2026 — Foundation

### 2.1 Objectives

| # | Objective | Key Results |
|---|-----------|-------------|
| O1 | Ship 25 core components | All components pass visual regression tests |
| O2 | Establish component architecture | Controllable, Disableable, Focusable mixins documented |
| O3 | Launch documentation site | 100% component pages live, interactive examples |

### 2.2 Component Delivery

| Component | Status | Priority | Dependencies |
|-----------|--------|----------|--------------|
| `gsmui:button` | ✅ Done | P0 | — |
| `gsmui:input` | ✅ Done | P0 | — |
| `gsmui:select` | ✅ Done | P0 | — |
| `gsmui:dialog` | 🔧 In Progress | P0 | — |
| `gsmui:dropdown` | 🔧 In Progress | P0 | — |
| `gsmui:toast` | 📋 Planned | P0 | — |
| `gsmui:tabs` | 📋 Planned | P1 | — |
| `gsmui:accordion` | 📋 Planned | P1 | — |
| `gsmui:tooltip` | 📋 Planned | P1 | — |
| `gsmui:slider` | 📋 Planned | P1 | — |

### 2.3 Milestones

| Milestone | Target Date | Deliverables |
|-----------|-------------|--------------|
| M1: Architecture complete | Jul 31, 2026 | Mixins, base classes, CSS variable system |
| M2: Core components ship | Aug 31, 2026 | 15 components with tests |
| M3: Documentation launch | Sep 15, 2026 | Full docs site with interactive examples |
| M4: Beta release | Sep 30, 2026 | `gsmui/gsmui v0.1.0-beta` |

### 2.4 Risks

| Risk | Probability | Impact | Mitigation |
|------|------------|--------|------------|
| Component scope creep | High | High | Strict MVP per component, punt semi-aggressively |
| Documentation delays | Medium | Medium | Docs-first development, write as you build |
| Livewire 3 edge cases | Low | High | Test against latest Livewire release |

---

## 3. Q4 2026 — Completeness

### 3.1 Objectives

| # | Objective | Key Results |
|---|-----------|-------------|
| O1 | Reach 50+ components | All form, data display, and feedback components shipped |
| O2 | Ship dark mode | Zero-config dark/light toggle for all components |
| O3 | Accessibility audit | WCAG 2.1 AA compliance verified by third-party auditor |

### 3.2 Component Delivery

| Component | Status | Priority | Dependencies |
|-----------|--------|----------|--------------|
| `gsmui:date-picker` | 📋 Planned | P0 | — |
| `gsmui:calendar` | 📋 Planned | P0 | date-picker |
| `gsmui:data-table` | 📋 Planned | P0 | — |
| `gsmui:pagination` | 📋 Planned | P1 | — |
| `gsmui:modal` | 📋 Planned | P1 | — |
| `gsmui:popover` | 📋 Planned | P1 | — |
| `gsmui:color-picker` | 📋 Planned | P1 | slider |
| `gsmui:editor` | 📋 Planned | P1 | — |
| `gsmui:upload` | 📋 Planned | P2 | — |
| `gsmui:avatar` | 📋 Planned | P2 | — |

### 3.3 Milestones

| Milestone | Target Date | Deliverables |
|-----------|-------------|--------------|
| M5: 50 components | Oct 31, 2026 | Full component catalog |
| M6: Dark mode | Nov 15, 2026 | Theme system, dark mode toggle |
| M7: Accessibility audit | Dec 1, 2026 | WCAG 2.1 AA report |
| M8: Stable release | Dec 15, 2026 | `gsmui/gsmui v1.0.0` |

---

## 4. Q1 2027 — Quality

### 4.1 Objectives

| # | Objective | Key Results |
|---|-----------|-------------|
| O1 | Performance optimization | Bundle size < 15KB gzipped, LCP < 100ms |
| O2 | Test coverage at 90% | All components have unit + integration tests |
| O3 | Documentation overhaul | Every component has 5+ examples, API reference, accessibility notes |

### 4.2 Work Items

| Item | Priority | Effort | Impact |
|------|----------|--------|--------|
| Bundle size audit | P0 | 2 weeks | Performance |
| Tree-shaking support | P0 | 3 weeks | Bundle size |
| Visual regression tests (Playwright) | P0 | 4 weeks | Quality |
| Keyboard navigation audit | P1 | 2 weeks | Accessibility |
| Screen reader testing (NVDA/VoiceOver) | P1 | 3 weeks | Accessibility |
| SSR compatibility testing | P1 | 2 weeks | Laravel support |
| Mobile responsiveness audit | P2 | 2 weeks | UX |

### 4.3 Milestones

| Milestone | Target Date | Deliverables |
|-----------|-------------|--------------|
| M9: Performance audit | Jan 31, 2027 | Bundle analysis, optimization report |
| M10: Test coverage | Feb 15, 2027 | 90% coverage, CI pipeline |
| M11: Docs overhaul | Mar 1, 2027 | Complete documentation |
| M12: v1.1 release | Mar 15, 2027 | `gsmui/gsmui v1.1.0` |

---

## 5. Q2 2027 — Ecosystem

### 5.1 Objectives

| # | Objective | Key Results |
|---|-----------|-------------|
| O1 | Launch GsmUi Pro | 500+ subscribers, $5K MRR |
| O2 | Component marketplace | 10+ community component packs |
| O3 | Framework integrations | Filament, Laravel Pulse, Nova support |

### 5.2 Work Items

| Item | Priority | Effort | Impact |
|------|----------|--------|--------|
| Pro license system | P0 | 3 weeks | Revenue |
| Pro components (10+) | P0 | 6 weeks | Revenue |
| Marketplace platform | P1 | 8 weeks | Ecosystem |
| Filament integration | P1 | 4 weeks | Adoption |
| Figma plugin | P2 | 6 weeks | Design workflow |
| Laravel Pulse widgets | P2 | 3 weeks | Adoption |

### 5.3 Milestones

| Milestone | Target Date | Deliverables |
|-----------|-------------|--------------|
| M13: Pro launch | Apr 15, 2027 | License system, 10 Pro components |
| M14: Marketplace beta | May 15, 2027 | Submission system, 10 packs |
| M15: Integrations | Jun 1, 2027 | Filament, Pulse, Nova support |
| M16: v2.0 release | Jun 15, 2027 | `gsmui/gsmui v2.0.0` |

---

## 6. Feature Prioritization Matrix

| Feature | Impact | Effort | Priority | Quarter |
|---------|--------|--------|----------|---------|
| Core form components | High | Low | P0 | Q3 |
| Data display components | High | Medium | P0 | Q4 |
| Dark mode | High | Medium | P0 | Q4 |
| Accessibility audit | High | High | P0 | Q4 |
| Performance optimization | Medium | Medium | P1 | Q1 |
| Tree-shaking | Medium | High | P1 | Q1 |
| Pro license system | High | Medium | P0 | Q2 |
| Marketplace | Medium | High | P1 | Q2 |
| Figma plugin | Low | High | P2 | Q2 |
| AI component generation | Low | Very High | P2 | Q3+ |

---

## 7. Dependencies

| Dependency | Type | Risk | Mitigation |
|-----------|------|------|------------|
| Laravel 12 release | External | Medium | Early access to betas |
| Livewire 4 roadmap | External | Medium | Core team relationships |
| Tailwind CSS v4 | External | Low | CSS variable system is framework-agnostic |
| Playwright testing | Internal | Low | Already established in repo |
| Community contributions | External | Medium | Contribution guidelines, incentives |

---

## 8. Resource Requirements

| Role | Q3 | Q4 | Q1 | Q2 |
|------|----|----|----|----|
| **Lead maintainer** | 1 | 1 | 1 | 1 |
| **Component developer** | 1 | 2 | 1 | 2 |
| **Documentation** | 0.5 | 0.5 | 1 | 0.5 |
| **Design** | 0.5 | 0.5 | 0 | 0.5 |
| **QA/Testing** | 0 | 0.5 | 1 | 0.5 |

---

## 9. Communication Plan

| Audience | Channel | Frequency | Content |
|----------|---------|-----------|---------|
| **Community** | GitHub Discussions | Weekly | Progress updates, RFCs |
| **Community** | Discord | Daily | Support, feature requests |
| **Contributors** | Monthly call | Monthly | Roadmap review, priorities |
| **Pro customers** | Email | Quarterly | Roadmap preview, feedback |

---

## 10. Success Criteria

| Quarter | Criterion | Measurement |
|---------|-----------|-------------|
| **Q3** | 25 components ship | Component count |
| **Q3** | Docs site live | Traffic + engagement |
| **Q4** | 50+ components | Component count |
| **Q4** | Accessibility audit passes | Third-party report |
| **Q1** | Performance targets met | Bundle size + LCP |
| **Q1** | Test coverage at 90% | CI report |
| **Q2** | Pro launches successfully | $5K MRR |
| **Q2** | Marketplace has 10+ packs | Submission count |

---

*Roadmap is a living document. Review monthly and adjust based on community feedback and market conditions.*
