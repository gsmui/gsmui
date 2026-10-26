# Backlog Management

**Product:** GsmUi Platform
**Methodology:** Kanban + Scrum hybrid
**Last Updated:** 2026-07-16
**Sprint Duration:** 2 weeks

---

## Backlog Structure

### Backlog Columns

| Column | Description | WIP Limit |
|--------|-------------|-----------|
| **Backlog** | All stories not yet groomed | None |
| **Ready** | Groomed, estimated, ready for sprint | None |
| **In Progress** | Currently being worked on | 2 per developer |
| **In Review** | Code complete, under review | 3 per developer |
| **QA** | Testing phase | 5 total |
| **Done** | Completed and deployed | None |

### Story States

```
Backlog → Ready → In Progress → In Review → QA → Done
                                  ↓
                              Rejected → In Progress
```

---

## Grooming Process

### Weekly Grooming (Every Wednesday, 30 min)

| Step | Action | Owner | Time |
|------|--------|-------|------|
| 1 | Review new backlog items | Product Owner | 5 min |
| 2 | Clarify requirements | Product Owner | 10 min |
| 3 | Estimate stories (planning poker) | Team | 10 min |
| 4 | Identify dependencies | Tech Lead | 5 min |

### Grooming Checklist

- [ ] Story follows template format
- [ ] Acceptance criteria are clear and testable
- [ ] Dependencies identified
- [ ] Story points assigned
- [ ] Priority assigned (P0–P3)
- [ ] Sprint target identified
- [ ] Design mockups attached (if UI)
- [ ] API contract defined (if backend)

### Story Ready Criteria (Definition of Ready)

A story is "Ready" when:

| Criterion | Requirement |
|-----------|-------------|
| User story | Written in As a/I want/So that format |
| Acceptance criteria | At least 3 criteria, all testable |
| Dependencies | Identified and resolved or planned |
| Design | Mockups attached (if UI component) |
| API contract | Defined (if backend endpoint) |
| Estimate | Story points assigned |
| Priority | P0, P1, P2, or P3 assigned |
| Sprint | Target sprint identified |

---

## Prioritization: MoSCoW Method

### Priority Levels

| Level | Definition | Release Target | Criteria |
|-------|------------|----------------|----------|
| **Must Have (P0)** | Critical for MVP, blocks launch | v1.0 | No workaround exists |
| **Should Have (P1)** | High value, important for launch | v1.0–v1.1 | Workaround exists but painful |
| **Could Have (P2)** | Nice to have, improves experience | v1.2–v1.5 | Easy to defer |
| **Won't Have (P3)** | Out of scope for now | v2.0+ | Explicitly deferred |

### Prioritization Matrix

```
              HIGH VALUE
                  │
    ┌─────────────┼─────────────┐
    │  MUST HAVE  │ SHOULD HAVE │
    │    (P0)     │    (P1)     │
    │             │             │
    │ • Auth      │ • OAuth     │
    │ • Billing   │ • Teams     │
    │ • 20 Comps  │ • Reviews   │
LOW ├─────────────┼─────────────┤ HIGH
EFFORT│ COULD HAVE │  WON'T HAVE │ EFFORT
    │    (P2)     │    (P3)     │
    │             │             │
    │ • Dark mode │ • AI tools  │
    │ • Badges    │ • Mobile    │
    │ • Search    │ • SSO       │
    └─────────────┼─────────────┘
                  │
              LOW VALUE
```

### Priority Decision Framework

| Question | If Yes → | If No → |
|----------|----------|---------|
| Does it block the MVP launch? | P0 | Next question |
| Would users be very frustrated without it? | P0 | Next question |
| Is there a reasonable workaround? | P1 | P0 |
| Does it significantly improve UX? | P1 | Next question |
| Is it requested by multiple users? | P1 | Next question |
| Is it easy to implement (< 2 days)? | P2 | P3 |
| Does it align with our 6-month goals? | P2 | P3 |
| Is it a "nice to have" luxury? | P3 | Deprioritize |

---

## Story Point Estimation

### Planning Poker

| Step | Action |
|------|--------|
| 1 | Product Owner reads the story |
| 2 | Team asks clarifying questions |
| 3 | Each estimator selects a card (1, 2, 3, 5, 8, 13, 21) |
| 4 | Cards revealed simultaneously |
| 5 | If consensus (±1 point): accept estimate |
| 6 | If divergence: highest and lowest explain reasoning |
| 7 | Re-estimate after discussion |
| 8 | Repeat until consensus |

### Estimation Factors

| Factor | Weight | Questions to Ask |
|--------|--------|-----------------|
| Complexity | 40% | How complex is the logic? |
| Effort | 30% | How much work is involved? |
| Uncertainty | 20% | How well do we understand this? |
| Dependencies | 10% | How many dependencies exist? |

### Point Reference

| Points | Complexity | Typical Duration | Example |
|--------|------------|------------------|---------|
| 1 | Trivial | < 1 hour | Config change, typo fix |
| 2 | Simple | 1–3 hours | Small bug fix, minor tweak |
| 3 | Moderate | 3–8 hours | Standard feature |
| 5 | Medium | 1–2 days | Feature with some complexity |
| 8 | Complex | 2–5 days | Multiple components involved |
| 13 | Very Complex | 1–2 weeks | Large feature, many unknowns |
| 21 | Epic | 2–4 weeks | Needs to be broken down |

### Velocity Tracking

| Sprint | Committed Points | Completed Points | Velocity |
|--------|-----------------|------------------|----------|
| S1 | 40 | — | — |
| S2 | 40 | — | — |
| S3 | 40 | — | — |
| S4 | 40 | — | — |
| S5 | 45 | — | — |
| S6 | 40 | — | — |
| S7 | 45 | — | — |
| S8 | 40 | — | — |
| S9 | 40 | — | — |
| S10 | 38 | — | — |
| S11 | 45 | — | — |
| S12 | 37 | — | — |
| **Average** | **41** | — | **Target: 40** |

---

## Sprint Planning

### Sprint Planning Meeting (Day 1, 2 hours)

| Phase | Duration | Activity |
|-------|----------|----------|
| Part 1 | 30 min | Review sprint goal and capacity |
| Part 2 | 60 min | Select stories from Ready column |
| Part 3 | 30 min | Break down stories into tasks |

### Sprint Planning Checklist

- [ ] Previous sprint velocity known
- [ ] Team capacity confirmed (PTO, holidays)
- [ ] Ready column has enough stories
- [ ] No blocking dependencies unresolved
- [ ] Sprint goal drafted
- [ ] Stories selected and ordered
- [ ] Tasks created for each story
- [ ] Story owner assigned
- [ ] Sprint board updated

### Sprint Goal Template

```
Sprint [N] Goal: [One sentence describing the sprint's focus]

Key Deliverables:
1. [Deliverable 1]
2. [Deliverable 2]
3. [Deliverable 3]

Success Criteria:
- [ ] [Criterion 1]
- [ ] [Criterion 2]
- [ ] [Criterion 3]
```

### Example Sprint Goals

| Sprint | Goal | Key Deliverables |
|--------|------|------------------|
| S1 | Project foundation and first components | Laravel setup, Auth scaffold, Button, Input |
| S3 | Core component library | Select, Modal, Dropdown, Toast |
| S5 | Billing integration | Stripe setup, checkout flows, subscription mgmt |
| S7 | Marketplace MVP | Publisher registration, component submission, search |
| S9 | Documentation foundation | Getting started guide, 10 API references |
| S11 | Pre-launch preparation | Beta testing, bug fixes, marketing prep |

---

## Backlog Refinement Process

### Weekly Refinement (1 hour)

| Step | Action | Time |
|------|--------|------|
| 1 | Review newly added stories | 10 min |
| 2 | Break down large stories (> 8 points) | 20 min |
| 3 | Update estimates based on new information | 15 min |
| 4 | Re-prioritize based on current context | 10 min |
| 5 | Identify and resolve blockers | 5 min |

### Story Breakdown Rules

| Rule | Description |
|------|-------------|
| Max size | No story should exceed 8 points |
| Vertical slice | Story should deliver end-to-end value |
| Independent | Story should be deployable independently |
| Testable | Story must have testable acceptance criteria |
| Negotiable | Story details can be discussed during planning |

### When to Break Down Stories

| Signal | Action |
|--------|--------|
| Story > 8 points | Break into smaller stories |
| Story has > 5 acceptance criteria | Consider splitting |
| Story spans multiple components | Split by component |
| Story has unclear scope | Clarify before estimation |
| Story depends on 3+ other stories | Evaluate dependencies |

---

## Backlog Health Metrics

### Metrics Dashboard

| Metric | Target | Current | Status |
|--------|--------|---------|--------|
| Ready stories | 20+ | — | — |
| Average story size | 5 points | — | — |
| Stories > 8 points | < 10% | — | — |
| Stale stories (> 3 sprints) | < 5% | — | — |
| Blocked stories | 0 | — | — |
| Backlog age | < 6 months | — | — |

### Backlog Hygiene Rules

| Rule | Frequency | Owner |
|------|-----------|-------|
| Remove stale stories | Monthly | Product Owner |
| Update estimates | Bi-weekly | Team |
| Re-prioritize | Weekly | Product Owner |
| Break down large stories | Weekly | Tech Lead |
| Resolve blockers | Daily | Scrum Master |
| Archive completed epics | After release | Product Owner |

---

## Sprint Ceremonies

### Daily Standup (15 min)

| Format | Questions |
|--------|-----------|
| What did I complete yesterday? | Focus on Done column |
| What am I working on today? | Focus on In Progress column |
| Any blockers? | Identify and assign owners |

### Sprint Review (1 hour, End of Sprint)

| Activity | Time | Owner |
|----------|------|-------|
| Demo completed features | 30 min | Team |
| Review sprint metrics | 15 min | Scrum Master |
| Stakeholder feedback | 15 min | Product Owner |

### Sprint Retrospective (1 hour, After Review)

| Activity | Time | Output |
|----------|------|--------|
| What went well? | 15 min | Keep doing |
| What could improve? | 15 min | Action items |
| Action item review | 15 min | Previous action items |
| Action item assignment | 15 min | New action items |

---

## Backlog Template

### New Story Template

```markdown
### [STORY-ID]: [Title]

**Story Points:** [1|2|3|5|8|13|21]
**Priority:** [P0|P1|P2|P3]
**Module:** [Auth|Billing|Component|Marketplace|Docs|Admin]
**Status:** Backlog
**Sprint:** [TBD|S1–S12]
**Dependencies:** [None|List]
**Design:** [Link to mockup]
**API:** [Link to contract]

#### User Story
As a [role],
I want [feature],
So that [benefit].

#### Acceptance Criteria
- [ ] Criterion 1
- [ ] Criterion 2
- [ ] Criterion 3

#### Technical Notes
- Implementation details
- Considerations
- Risks

#### Definition of Done
- [ ] Code complete
- [ ] Tests passing
- [ ] Documentation updated
- [ ] Code reviewed
- [ ] Visual regression verified
- [ ] Accessibility verified
```

---

## Backlog Grooming Session Agenda

### Weekly Grooming (30 minutes)

```
1. OPENING (2 min)
   - Review agenda
   - Confirm attendees

2. NEW STORIES (10 min)
   - Product Owner presents new stories
   - Team asks clarifying questions
   - Stories added to Backlog column

3. BREAKDOWN (10 min)
   - Identify stories > 8 points
   - Break down into smaller stories
   - Update estimates

4. PRIORITIZATION (5 min)
   - Re-prioritize based on current context
   - Move critical items to top

5. CLOSING (3 min)
   - Confirm Ready column has 20+ stories
   - Identify any blockers for next sprint
   - Schedule next grooming session
```

---

## Story Lifecycle

```
┌─────────────────────────────────────────────────────────┐
│                     STORY LIFECYCLE                      │
├─────────────────────────────────────────────────────────┤
│                                                          │
│  ┌──────────┐    ┌──────────┐    ┌──────────┐          │
│  │ Backlog  │───▶│  Ready   │───▶│In Progress│          │
│  └──────────┘    └──────────┘    └──────────┘          │
│       │                               │                 │
│       │                               ▼                 │
│       │                         ┌──────────┐           │
│       │                         │In Review │           │
│       │                         └──────────┘           │
│       │                               │                 │
│       │                    ┌──────────┴──────────┐    │
│       │                    ▼                     ▼    │
│       │              ┌──────────┐          ┌──────────┐│
│       │              │    QA    │          │ Rejected ││
│       │              └──────────┘          └──────────┘│
│       │                    │                     │     │
│       │                    ▼                     │     │
│       │              ┌──────────┐                │     │
│       │              │   Done   │◀───────────────┘     │
│       │              └──────────┘                      │
│       │                                                │
│       └────────────────────────────────────────────────┘
│                   (Archived/Dropped)
```

---

## Backlog Import/Export

### Export Format

```json
{
  "stories": [
    {
      "id": "AUTH-S01",
      "title": "Email/Password Registration",
      "points": 3,
      "priority": "P0",
      "module": "Auth",
      "status": "Ready",
      "sprint": "S1",
      "acceptance_criteria": ["..."],
      "dependencies": []
    }
  ]
}
```

### Import Sources

| Source | Format | Frequency |
|--------|--------|-----------|
| GitHub Issues | JSON API | Weekly |
| User feedback | CSV | Bi-weekly |
| Support tickets | CSV | Weekly |
| Analytics insights | Manual | Monthly |
| Stakeholder requests | Email | As needed |
