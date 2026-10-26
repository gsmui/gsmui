# Milestones

**Product:** GsmUi Platform
**Timeline:** 6 months (24 weeks)
**Sprint Cadence:** 2-week sprints (12 sprints total)
**Last Updated:** 2026-07-16

---

## Overview

| Milestone | Name | Duration | Weeks | Sprint Range |
|-----------|------|----------|-------|--------------|
| M1 | Foundation | Month 1 | 1–4 | S1–S2 |
| M2 | Core Components | Month 2 | 5–8 | S3–S4 |
| M3 | Billing & Auth Polish | Month 3 | 9–12 | S5–S6 |
| M4 | Marketplace MVP | Month 4 | 13–16 | S7–S8 |
| M5 | Documentation & Polish | Month 5 | 17–20 | S9–S10 |
| M6 | Launch | Month 6 | 21–24 | S11–S12 |

---

## M1: Foundation (Weeks 1–4, Sprints 1–2)

**Goal:** Project infrastructure, design system, and first two components operational.

### Deliverables

| Deliverable | Type | Status | Sprint |
|-------------|------|--------|--------|
| Laravel project setup | Infrastructure | Not Started | S1 |
| Database schema & migrations | Backend | Not Started | S1 |
| Authentication scaffolding (Breeze) | Backend | Not Started | S1 |
| CI/CD pipeline (GitHub Actions) | DevOps | Not Started | S1 |
| Design system tokens (colors, spacing, typography) | Design | Not Started | S1 |
| Button component (reference implementation) | Frontend | Not Started | S1 |
| Input component | Frontend | Not Started | S2 |
| Component testing framework | QA | Not Started | S2 |
| Internal documentation site scaffold | Docs | Not Started | S2 |
| Staging environment deployment | DevOps | Not Started | S2 |

### Key Metrics

| Metric | Target |
|--------|--------|
| CI pipeline green | 100% pass rate |
| Design tokens defined | 50+ tokens |
| Component test coverage | 90%+ |
| Staging deployment | Automated on merge to main |

### Exit Criteria

- [ ] All P0 infrastructure tasks complete
- [ ] Design system documented and tokenized
- [ ] Button and Input components pass visual regression tests
- [ ] Authentication flow works end-to-end in staging
- [ ] CI/CD pipeline deploys to staging automatically

### Risks & Mitigations

| Risk | Mitigation |
|------|------------|
| CI/CD setup delays | Use Laravel Forge/Vapor for quick setup |
| Design token bikeshedding | Use Tailwind defaults as starting point |
| Component scope creep | Strict MVP — Button and Input only |

---

## M2: Core Components (Weeks 5–8, Sprints 3–4)

**Goal:** 12 production-ready components with tests and documentation.

### Deliverables

| Deliverable | Type | Status | Sprint |
|-------------|------|--------|--------|
| Select component | Frontend | Not Started | S3 |
| Modal component | Frontend | Not Started | S3 |
| Dropdown component | Frontend | Not Started | S3 |
| Toast/Alert component | Frontend | Not Started | S3 |
| Card component | Frontend | Not Started | S3 |
| Table component | Frontend | Not Started | S4 |
| Tabs component | Frontend | Not Started | S4 |
| Badge component | Frontend | Not Started | S4 |
| Avatar component | Frontend | Not Started | S4 |
| Tooltip component | Frontend | Not Started | S4 |
| Pagination component | Frontend | Not Started | S4 |
| Breadcrumb component | Frontend | Not Started | S4 |
| Component API documentation (12 components) | Docs | Not Started | S4 |
| Visual regression test suite | QA | Not Started | S4 |

### Key Metrics

| Metric | Target |
|--------|--------|
| Components shipped | 12 (14 total) |
| Test coverage | 90%+ per component |
| Visual regression baseline | All variants captured |
| Documentation pages | 12 API references |
| Bundle size | < 15KB gzipped total |

### Exit Criteria

- [ ] All 12 components pass accessibility audit (axe-core)
- [ ] Visual regression tests pass for all variants
- [ ] API documentation complete for all 12 components
- [ ] Components work in Chrome, Firefox, Safari, Edge
- [ ] No P0 bugs in any component

### Risks & Mitigations

| Risk | Mitigation |
|------|------------|
| Component complexity (Table, Select) | Start with simple versions, iterate |
| Cross-browser issues | Test early and often with Playwright |
| Documentation lag | Write docs alongside component development |

---

## M3: Billing & Auth Polish (Weeks 9–12, Sprints 5–6)

**Goal:** Complete billing integration, OAuth providers, and team management.

### Deliverables

| Deliverable | Type | Status | Sprint |
|-------------|------|--------|--------|
| Stripe integration | Backend | Not Started | S5 |
| Free tier enforcement | Backend | Not Started | S5 |
| Pro tier checkout flow | Full-Stack | Not Started | S5 |
| Team tier checkout flow | Full-Stack | Not Started | S5 |
| OAuth: GitHub login | Backend | Not Started | S5 |
| OAuth: Google login | Backend | Not Started | S5 |
| Team invitation flow | Full-Stack | Not Started | S6 |
| Role-based access control | Backend | Not Started | S6 |
| Password reset flow (polish) | Full-Stack | Not Started | S6 |
| Email transactional templates | Design | Not Started | S6 |
| Subscription management page | Full-Stack | Not Started | S6 |
| Invoice history & download | Full-Stack | Not Started | S6 |

### Key Metrics

| Metric | Target |
|--------|--------|
| Billing success rate | 99%+ |
| OAuth login success rate | 99%+ |
| Email delivery rate | 98%+ |
| Checkout completion rate | 80%+ |
| Subscription churn (monthly) | < 5% |

### Exit Criteria

- [ ] Stripe checkout works end-to-end in production
- [ ] OAuth login works for GitHub and Google
- [ ] Team invitation flow tested with real emails
- [ ] Subscription upgrade/downgrade prorates correctly
- [ ] Invoice PDFs generate correctly
- [ ] All email templates render correctly

### Risks & Mitigations

| Risk | Mitigation |
|------|------------|
| Stripe integration complexity | Use Stripe Checkout (hosted) first |
| Email delivery issues | Use Postmark, set up SPF/DKIM |
| OAuth provider downtime | Implement retry logic, show helpful errors |

---

## M4: Marketplace MVP (Weeks 13–16, Sprints 7–8)

**Goal:** Functional marketplace with publisher submission, consumer browsing, and payments.

### Deliverables

| Deliverable | Type | Status | Sprint |
|-------------|------|--------|--------|
| Publisher registration & verification | Full-Stack | Not Started | S7 |
| Component submission workflow | Full-Stack | Not Started | S7 |
| Component listing page | Frontend | Not Started | S7 |
| Search functionality (Meilisearch) | Backend | Not Started | S7 |
| Filter by category | Frontend | Not Started | S7 |
| Component detail page | Frontend | Not Started | S8 |
| Rating and review system | Full-Stack | Not Started | S8 |
| Publisher payout dashboard | Full-Stack | Not Started | S8 |
| Revenue share calculation | Backend | Not Started | S8 |
| Content moderation tools | Admin | Not Started | S8 |
| Paid component purchase flow | Full-Stack | Not Started | S8 |

### Key Metrics

| Metric | Target |
|--------|--------|
| Publisher signups | 20+ beta publishers |
| Components submitted | 50+ components |
| Consumer searches | 1,000+/week |
| Purchase conversion | 5%+ of detail views |
| Publisher satisfaction | NPS 40+ |

### Exit Criteria

- [ ] Publisher can submit a component and see it listed
- [ ] Consumer can search, filter, and view component details
- [ ] Consumer can purchase a paid component
- [ ] Publisher receives payout after threshold met
- [ ] Admin can review and approve/reject submissions
- [ ] Review system works (rate, comment, vote)

### Risks & Mitigations

| Risk | Mitigation |
|------|------------|
| Low publisher adoption | Seed with 10 internal components |
| Search relevance issues | Use Meilisearch faceted search |
| Payment disputes | Clear refund policy, Stripe dispute handling |

---

## M5: Documentation & Polish (Weeks 17–20, Sprints 9–10)

**Goal:** Complete documentation, performance optimization, and accessibility compliance.

### Deliverables

| Deliverable | Type | Status | Sprint |
|-------------|------|--------|--------|
| Getting started guide | Docs | Not Started | S9 |
| Installation guide | Docs | Not Started | S9 |
| Quick start tutorial | Docs | Not Started | S9 |
| Component API reference (all 20) | Docs | Not Started | S9 |
| Interactive code examples | Docs | Not Started | S10 |
| Migration guide from Flux | Docs | Not Started | S10 |
| Accessibility audit (WCAG 2.1 AA) | QA | Not Started | S10 |
| Performance optimization pass | Frontend | Not Started | S10 |
| Security audit | Security | Not Started | S10 |
| Dark mode documentation | Docs | Not Started | S10 |
| FAQ page | Docs | Not Started | S10 |

### Key Metrics

| Metric | Target |
|--------|--------|
| Documentation coverage | 100% of public API |
| Page load time | < 2 seconds |
| Lighthouse score | 90+ all categories |
| WCAG compliance | 2.1 AA |
| Security vulnerabilities | 0 critical/high |

### Exit Criteria

- [ ] All 20 components fully documented
- [ ] Interactive examples work for all components
- [ ] Migration guide tested with real migration
- [ ] Accessibility audit passes (axe-core zero violations)
- [ ] Lighthouse performance score 90+
- [ ] Security audit finds no critical issues
- [ ] All documentation renders correctly in all browsers

### Risks & Mitigations

| Risk | Mitigation |
|------|------------|
| Documentation scope | Prioritize P0 components first |
| Accessibility issues | Fix during component development, not after |
| Performance regressions | Bundle analysis on every PR |

---

## M6: Launch (Weeks 21–24, Sprints 11–12)

**Goal:** Public launch with beta testing, marketing, and post-launch monitoring.

### Deliverables

| Deliverable | Type | Status | Sprint |
|-------------|------|--------|--------|
| Beta testing program (50 users) | QA | Not Started | S11 |
| Bug bash and stabilization | QA | Not Started | S11 |
| Launch landing page | Marketing | Not Started | S11 |
| Product Hunt launch preparation | Marketing | Not Started | S11 |
| Email marketing sequence | Marketing | Not Started | S11 |
| Social media campaign | Marketing | Not Started | S12 |
| Production deployment | DevOps | Not Started | S12 |
| Post-launch monitoring | DevOps | Not Started | S12 |
| Customer support setup | Operations | Not Started | S12 |
| Post-launch retrospective | Process | Not Started | S12 |

### Key Metrics

| Metric | Target |
|--------|--------|
| Beta testers | 50+ active |
| Beta NPS | 40+ |
| Launch day signups | 200+ |
| Week 1 signups | 500+ |
| Month 1 signups | 1,000 |
| Month 1 MRR | $10,000 |
| Post-launch critical bugs | 0 |

### Exit Criteria

- [ ] Beta feedback is net positive (NPS 40+)
- [ ] All P0/P1 bugs resolved
- [ ] Production monitoring active
- [ ] Customer support team briefed
- [ ] Marketing materials ready
- [ ] Launch day checklist complete
- [ ] Rollback plan tested

### Risks & Mitigations

| Risk | Mitigation |
|------|------------|
| Low launch day traffic | Pre-launch marketing, Product Hunt |
| Production incidents | On-call rotation, rollback plan |
| Negative beta feedback | Iterate on critical feedback before launch |
| Support overload | Self-service docs, chatbot, limited support hours |

---

## Milestone Dependencies

```
M1 (Foundation) ──► M2 (Components) ──► M5 (Docs & Polish) ──► M6 (Launch)
                          │
                          ▼
                    M3 (Billing) ──► M4 (Marketplace) ──► M5 (Docs & Polish)
```

---

## Sprint Planning Summary

| Sprint | Dates | Focus | Key Deliverable |
|--------|-------|-------|-----------------|
| S1 | W1–W2 | Foundation | Project setup, auth scaffold |
| S2 | W3–W4 | Foundation | Button, Input, CI/CD |
| S3 | W5–W6 | Components | Select, Modal, Dropdown, Toast |
| S4 | W7–W8 | Components | Table, Tabs, remaining components |
| S5 | W9–W10 | Billing | Stripe, OAuth, checkout flows |
| S6 | W11–W12 | Auth Polish | Teams, RBAC, email templates |
| S7 | W13–W14 | Marketplace | Publisher, submission, search |
| S8 | W15–W16 | Marketplace | Reviews, payouts, moderation |
| S9 | W17–W18 | Docs | Getting started, API reference |
| S10 | W19–W20 | Polish | Interactive examples, a11y, perf |
| S11 | W21–W22 | Pre-Launch | Beta testing, bug bash, marketing |
| S12 | W23–W24 | Launch | Production deploy, monitoring |

---

## Velocity Assumptions

| Metric | Value |
|--------|-------|
| Team size | 2 full-time developers |
| Sprint velocity | 40 story points |
| Total capacity | 480 points (12 sprints) |
| Buffer (20%) | 96 points |
| Available for features | 384 points |
| MVP scope (P0 only) | ~350 points |
| **Feasibility** | **Tight but achievable** |

---

## Go/No-Go Checkpoints

| Checkpoint | Date | Criteria | Decision |
|------------|------|----------|----------|
| Post-M1 | End of Week 4 | Infrastructure stable, 2 components done | Proceed or replan |
| Post-M2 | End of Week 8 | 12 components done, tests passing | Proceed or cut scope |
| Post-M3 | End of Week 12 | Billing works end-to-end | Proceed or delay billing |
| Post-M4 | End of Week 16 | Marketplace functional | Proceed or simplify |
| Post-M5 | End of Week 20 | Docs complete, a11y passing | Proceed or delay launch |
| Pre-Launch | Week 21 | Beta NPS 40+, no P0 bugs | Launch or delay |
