# Epic Definitions

**Product:** GsmUi Platform
**Total Epics:** 6
**Last Updated:** 2026-07-16
**Sprint Duration:** 2 weeks

---

## Epic 1: Authentication & User Management

**Epic ID:** AUTH-EPIC
**Priority:** P0
**Target Release:** v1.0
**Total Story Points:** 89
**Owner:** Backend Lead

### Epic Description

Implement a complete authentication system supporting email/password, OAuth providers, team management, and security features. This epic is foundational — all other modules depend on user identity.

### User Stories

| Story ID | Story | Points | Priority |
|----------|-------|--------|----------|
| AUTH-S01 | As a new user, I want to register with email/password so that I can create an account | 3 | P0 |
| AUTH-S02 | As a user, I want to verify my email address so that my account is confirmed | 2 | P0 |
| AUTH-S03 | As a user, I want to reset my password so that I can regain access if I forget it | 3 | P0 |
| AUTH-S04 | As a user, I want to login with email/password so that I can access my account | 2 | P0 |
| AUTH-S05 | As a user, I want to stay logged in (remember me) so that I don't re-authenticate frequently | 1 | P0 |
| AUTH-S06 | As a user, I want to login with GitHub so that I don't need another password | 5 | P0 |
| AUTH-S07 | As a user, I want to login with Google so that I can use my existing account | 5 | P0 |
| AUTH-S08 | As a user, I want to link multiple OAuth providers so that I have login flexibility | 5 | P1 |
| AUTH-S09 | As a user, I want to manage my profile so that others can identify me | 3 | P0 |
| AUTH-S10 | As a user, I want to change my password so that I can maintain security | 2 | P0 |
| AUTH-S11 | As a user, I want to enable 2FA so that my account is more secure | 8 | P2 |
| AUTH-S12 | As a user, I want to manage sessions so that I can see where I'm logged in | 3 | P1 |
| AUTH-S13 | As a team owner, I want to invite members so that I can collaborate | 5 | P1 |
| AUTH-S14 | As a team owner, I want to assign roles so that I can control permissions | 5 | P1 |
| AUTH-S15 | As a user, I want to delete my account so that I can remove my data | 3 | P1 |

### Acceptance Criteria

```
AUTH-S01: Email/Password Registration
  Given I am on the registration page
  When I enter a valid email and password (min 8 chars, 1 uppercase, 1 number)
  And I click "Create Account"
  Then I receive a verification email
  And I am redirected to the "Check your email" page
  And my account status is "unverified"

AUTH-S06: GitHub OAuth Login
  Given I am on the login page
  When I click "Login with GitHub"
  Then I am redirected to GitHub's OAuth page
  After I authorize the application
  Then I am redirected back to the dashboard
  And my GitHub profile is linked to my account
  And a session is created
```

### Dependencies

- None (this is the foundational epic)

### Technical Notes

- Use Laravel Breeze for scaffolding
- OAuth via Laravel Socialite
- Session management via database driver
- Rate limiting on auth endpoints: 5 attempts/minute

---

## Epic 2: Billing & Subscriptions

**Epic ID:** BILL-EPIC
**Priority:** P0
**Target Release:** v1.0
**Total Story Points:** 112
**Owner:** Full-Stack Lead

### Epic Description

Implement subscription billing using Stripe, supporting free and paid tiers, invoice management, and promotional features. Revenue generation is critical for sustainability.

### User Stories

| Story ID | Story | Points | Priority |
|----------|-------|--------|----------|
| BILL-S01 | As a user, I want to see pricing plans so that I can choose the right tier | 2 | P0 |
| BILL-S02 | As a user, I want to subscribe to the free tier so that I can try the platform | 3 | P0 |
| BILL-S03 | As a user, I want to subscribe to the Pro tier so that I can access all components | 8 | P0 |
| BILL-S04 | As a user, I want to upgrade my plan so that I can get more features | 5 | P0 |
| BILL-S05 | As a user, I want to downgrade my plan so that I can reduce costs | 5 | P0 |
| BILL-S06 | As a user, I want to cancel my subscription so that I am not charged | 5 | P0 |
| BILL-S07 | As a user, I want to manage my payment methods so that I can update my card | 5 | P0 |
| BILL-S08 | As a user, I want to view my invoice history so that I can track spending | 3 | P0 |
| BILL-S09 | As a user, I want to download invoices as PDF so that I can keep records | 2 | P1 |
| BILL-S10 | As a user, I want to start a free trial so that I can evaluate before buying | 5 | P1 |
| BILL-S11 | As a team owner, I want to subscribe to the Team tier so that my team has access | 5 | P1 |
| BILL-S12 | As a user, I want to apply a promo code so that I can get a discount | 3 | P2 |
| BILL-S13 | As an admin, I want to create coupons so that I can run promotions | 5 | P2 |
| BILL-S14 | As a user, I want to receive renewal reminders so that I know when I'm billed | 2 | P1 |
| BILL-S15 | As a user, I want to handle failed payments gracefully so that my service isn't interrupted | 8 | P1 |

### Acceptance Criteria

```
BILL-S03: Subscribe to Pro Tier
  Given I am logged in and on the pricing page
  When I click "Subscribe to Pro" ($29/mo)
  Then I am redirected to Stripe Checkout
  After I enter valid payment details
  Then my subscription status becomes "active"
  And I have access to Pro features
  And I receive a confirmation email
  And my next billing date is displayed

BILL-S06: Cancel Subscription
  Given I have an active Pro subscription
  When I go to Billing Settings and click "Cancel Subscription"
  Then I see a confirmation dialog
  After I confirm cancellation
  Then my subscription status becomes "canceled"
  And I retain access until the end of the billing period
  And I receive a cancellation confirmation email
```

### Dependencies

- AUTH-EPIC (user identity required)
- Stripe account setup
- Email service (transactional emails)

### Technical Notes

- Use Stripe Billing for subscription lifecycle
- Webhook endpoint for payment events
- Idempotent webhook handling
- Grace period: 3 days for failed payments
- Proration for mid-cycle upgrades

---

## Epic 3: Marketplace

**Epic ID:** MKT-EPIC
**Priority:** P1
**Target Release:** v1.0
**Total Story Points:** 145
**Owner:** Full-Stack Lead

### Epic Description

Build a marketplace where publishers can submit components and consumers can discover, purchase, and install them. This is the primary revenue and growth engine.

### User Stories

| Story ID | Story | Points | Priority |
|----------|-------|--------|----------|
| MKT-S01 | As a consumer, I want to browse components so that I can find what I need | 5 | P0 |
| MKT-S02 | As a consumer, I want to search components so that I can find specific items | 5 | P0 |
| MKT-S03 | As a consumer, I want to filter by category so that I can narrow results | 3 | P0 |
| MKT-S04 | As a consumer, I want to view component details so that I can evaluate quality | 5 | P0 |
| MKT-S05 | As a consumer, I want to see ratings and reviews so that I can trust the component | 8 | P1 |
| MKT-S06 | As a consumer, I want to install a component so that I can use it in my project | 5 | P0 |
| MKT-S07 | As a publisher, I want to register so that I can submit components | 3 | P1 |
| MKT-S08 | As a publisher, I want to submit a component so that I can share it | 8 | P0 |
| MKT-S09 | As a publisher, I want to manage versions so that I can update my component | 5 | P0 |
| MKT-S10 | As a publisher, I want to see analytics so that I can track usage | 5 | P2 |
| MKT-S11 | As a publisher, I want to receive payouts so that I can earn revenue | 8 | P1 |
| MKT-S12 | As a consumer, I want to purchase paid components so that I can access premium content | 8 | P0 |
| MKT-S13 | As a consumer, I want to leave reviews so that I can help others decide | 5 | P1 |
| MKT-S14 | As an admin, I want to review submissions so that quality is maintained | 5 | P1 |
| MKT-S15 | As a consumer, I want to favorite components so that I can find them later | 3 | P2 |

### Acceptance Criteria

```
MKT-S01: Browse Components
  Given I am on the marketplace page
  When the page loads
  Then I see a grid of component cards
  And each card shows: name, publisher, rating, price, category
  And the page loads in under 2 seconds
  And pagination is available for 20+ results

MKT-S08: Submit Component
  Given I am a verified publisher
  When I fill out the submission form (name, description, category, price, code)
  And I upload at least 1 screenshot
  And I click "Submit for Review"
  Then my component enters the review queue
  And I receive a confirmation email
  And the component is not publicly visible until approved
```

### Dependencies

- AUTH-EPIC (publisher accounts)
- BILL-EPIC (payment processing for paid components)

### Technical Notes

- Search: Laravel Scout with Meilisearch
- File storage: S3-compatible (component code, screenshots)
- Versioning: semver enforced on submission
- Revenue share: 70% publisher / 30% platform
- Payout threshold: $50 minimum

---

## Epic 4: Component Library

**Epic ID:** COMP-EPIC
**Priority:** P0
**Target Release:** v1.0
**Total Story Points:** 156
**Owner:** Frontend Lead

### Epic Description

Build 20 production-ready Livewire components with consistent API, full accessibility, and comprehensive documentation. This is the core product value.

### User Stories

| Story ID | Story | Points | Priority |
|----------|-------|--------|----------|
| COMP-S01 | As a developer, I want a Button component so that I can create consistent actions | 5 | P0 |
| COMP-S02 | As a developer, I want an Input component so that I can collect user data | 5 | P0 |
| COMP-S03 | As a developer, I want a Select component so that I can offer choices | 8 | P0 |
| COMP-S04 | As a developer, I want a Modal component so that I can show dialogs | 8 | P0 |
| COMP-S05 | As a developer, I want a Table component so that I can display data | 13 | P0 |
| COMP-S06 | As a developer, I want Tabs so that I can organize content | 5 | P0 |
| COMP-S07 | As a developer, I want a Toast/Alert component so that I can show notifications | 5 | P0 |
| COMP-S08 | As a developer, I want a Card component so that I can group content | 3 | P0 |
| COMP-S09 | As a developer, I want a Dropdown component so that I can show menus | 5 | P0 |
| COMP-S10 | As a developer, I want a Badge component so that I can label items | 2 | P0 |
| COMP-S11 | As a developer, I want an Avatar component so that I can show users | 2 | P0 |
| COMP-S12 | As a developer, I want a Tooltip so that I can provide hints | 3 | P0 |
| COMP-S13 | As a developer, I want Pagination so that I can navigate lists | 5 | P0 |
| COMP-S14 | As a developer, I want a Breadcrumb so that I can show navigation | 2 | P0 |
| COMP-S15 | As a developer, I want an Accordion so that I can collapse content | 5 | P0 |
| COMP-S16 | As a developer, I want a Toggle/Switch so that I can toggle settings | 3 | P0 |
| COMP-S17 | As a developer, I want Checkboxes so that I can select options | 3 | P0 |
| COMP-S18 | As a developer, I want Radio buttons so that I can select one option | 3 | P0 |
| COMP-S19 | As a developer, I want a Progress bar so that I can show completion | 3 | P0 |
| COMP-S20 | As a developer, I want Skeleton loaders so that I can show loading states | 3 | P0 |

### Acceptance Criteria (Component Quality Standards)

```
Every component must meet these standards:

1. ACCESSIBILITY
   - All interactive elements are keyboard navigable
   - ARIA attributes are correctly applied
   - Screen reader announces state changes
   - Focus management follows WAI-ARIA APG patterns

2. VISUAL CONSISTENCY
   - Matches design system tokens (colors, spacing, typography)
   - Supports light and dark mode
   - Responsive at all breakpoints (sm, md, lg, xl)
   - Animations use 150ms ease-out default

3. API CONSISTENCY
   - Props follow naming conventions (see AGENTS.md)
   - Events fire consistently (input, change, blur)
   - Wire:model support for Livewire binding
   - Disabled/invalid states supported

4. TESTING
   - Unit tests for all public methods
   - Browser tests for user interactions
   - Visual regression tests for all variants
   - Accessibility tests (axe-core)
```

### Dependencies

- None (can be built independently)
- Design system tokens (colors, spacing, typography)

### Technical Notes

- Use Alpine.js for client-side interactivity
- Livewire for server-side state management
- Tailwind CSS for styling
- Follow patterns from AGENTS.md (Detangle, Controllable mixins)
- Each component in `stubs/resources/views/gsmui/<component>/index.blade.php`

---

## Epic 5: Documentation

**Epic ID:** DOC-EPIC
**Priority:** P0
**Target Release:** v1.0
**Total Story Points:** 78
**Owner:** Technical Writer + Frontend Dev

### Epic Description

Build comprehensive documentation including getting started guides, API references, interactive examples, and migration guides. Documentation is the first developer experience.

### User Stories

| Story ID | Story | Points | Priority |
|----------|-------|--------|----------|
| DOC-S01 | As a developer, I want a getting started guide so that I can quickly onboard | 5 | P0 |
| DOC-S02 | As a developer, I want installation instructions so that I can set up the library | 2 | P0 |
| DOC-S03 | As a developer, I want API reference for each component so that I can use them correctly | 13 | P0 |
| DOC-S04 | As a developer, I want interactive examples so that I can see components in action | 8 | P0 |
| DOC-S05 | As a developer, I want copy-paste code so that I can use components immediately | 3 | P0 |
| DOC-S06 | As a developer, I want full-text search so that I can find information quickly | 5 | P1 |
| DOC-S07 | As a developer, I want dark mode so that I can read docs comfortably | 2 | P1 |
| DOC-S08 | As a developer, I want a migration guide from Flux so that I can switch easily | 5 | P1 |
| DOC-S09 | As a developer, I want accessibility guidelines so that I can build inclusively | 5 | P1 |
| DOC-S10 | As a developer, I want theming documentation so that I can customize the look | 8 | P1 |
| DOC-S11 | As a developer, I want a changelog so that I can track updates | 2 | P1 |
| DOC-S12 | As a developer, I want error code references so that I can debug issues | 3 | P1 |
| DOC-S13 | As a developer, I want a FAQ so that I can find common answers | 2 | P1 |
| DOC-S14 | As a contributor, I want a contribution guide so that I can help improve | 3 | P2 |
| DOC-S15 | As a developer, I want performance guidelines so that I can optimize usage | 5 | P2 |

### Acceptance Criteria

```
DOC-S03: Component API Reference
  Given I navigate to a component's API page
  When the page loads
  Then I see:
    - Component name and description
    - Available props in a table (name, type, default, description)
    - Available events
    - Available slots
    - Live code example
    - Copy button for each code snippet
  And the page loads in under 1 second
  And the code examples are syntactically correct
  And the examples render correctly in the preview
```

### Dependencies

- COMP-EPIC (components must exist to document)
- Design tokens for visual examples

### Technical Notes

- Use a static site generator (VitePress or similar)
- Interactive examples via Livewire sandbox
- Code highlighting via Shiki
- Search via Pagefind (static search)
- Host on Vercel/Cloudflare Pages

---

## Epic 6: Admin Dashboard

**Epic ID:** ADM-EPIC
**Priority:** P1
**Target Release:** v1.1
**Total Story Points:** 95
**Owner:** Full-Stack Lead

### Epic Description

Build an internal admin dashboard for managing users, content, billing, and system health. This is operational infrastructure for running the platform.

### User Stories

| Story ID | Story | Points | Priority |
|----------|-------|--------|----------|
| ADM-S01 | As an admin, I want to view all users so that I can manage the platform | 5 | P0 |
| ADM-S02 | As an admin, I want to search users so that I can find specific accounts | 3 | P0 |
| ADM-S03 | As an admin, I want to view user details so that I can investigate issues | 5 | P0 |
| ADM-S04 | As an admin, I want to suspend users so that I can enforce policies | 3 | P1 |
| ADM-S05 | As an admin, I want to review component submissions so that quality is maintained | 5 | P1 |
| ADM-S06 | As an admin, I want to approve/reject components so that the marketplace is curated | 5 | P1 |
| ADM-S07 | As an admin, I want to view system health so that I can monitor reliability | 5 | P0 |
| ADM-S08 | As an admin, I want to view error logs so that I can debug issues | 5 | P0 |
| ADM-S09 | As an admin, I want to manage feature flags so that I can control rollouts | 8 | P1 |
| ADM-S10 | As an admin, I want to view revenue reports so that I can track business health | 5 | P1 |
| ADM-S11 | As an admin, I want to manage email campaigns so that I can communicate with users | 8 | P2 |
| ADM-S12 | As an admin, I want to view analytics so that I can make data-driven decisions | 8 | P1 |
| ADM-S13 | As an admin, I want to manage content (pages, blog) so that I can keep info current | 5 | P2 |
| ADM-S14 | As an admin, I want to configure system settings so that I can tune the platform | 5 | P1 |
| ADM-S15 | As an admin, I want audit logs so that I can track administrative actions | 5 | P2 |

### Acceptance Criteria

```
ADM-S01: User Listing
  Given I am logged in as an admin
  When I navigate to Admin > Users
  Then I see a paginated table of all users
  And the table shows: name, email, role, status, joined date, last active
  And I can sort by any column
  And I can search by name or email
  And I can filter by status (active, suspended, banned)

ADM-S05: Component Review Queue
  Given I am logged in as an admin
  When I navigate to Admin > Components > Pending Review
  Then I see a list of submitted components awaiting review
  And each entry shows: component name, publisher, submission date, category
  And I can click to view full submission details
  And I can approve or reject with a reason
```

### Dependencies

- AUTH-EPIC (admin roles and permissions)
- MKT-EPIC (component review queue)
- BILL-EPIC (revenue data)

### Technical Notes

- Admin-only routes protected by middleware
- Role check: `auth()->user()->isAdmin()`
- Separate admin layout (not public-facing)
- Consider using Filament or similar for rapid admin build
- Real-time updates via Laravel Echo for queue monitoring

---

## Epic Dependencies Diagram

```
AUTH-EPIC ──────────┬────────────────────────────┐
  (Foundation)      │                            │
                    ▼                            ▼
              BILL-EPIC                    COMP-EPIC
              (Billing)                    (Components)
                    │                            │
                    └──────────┬─────────────────┘
                               ▼
                         MKT-EPIC
                        (Marketplace)
                               │
                    ┌──────────┴──────────┐
                    ▼                     ▼
              DOC-EPIC              ADM-EPIC
              (Documentation)      (Admin)
```

---

## Summary

| Epic | Stories | Points | Priority | Target | Owner |
|------|---------|--------|----------|--------|-------|
| Authentication | 15 | 89 | P0 | v1.0 | Backend Lead |
| Billing | 15 | 112 | P0 | v1.0 | Full-Stack Lead |
| Marketplace | 15 | 145 | P1 | v1.0 | Full-Stack Lead |
| Component Library | 20 | 156 | P0 | v1.0 | Frontend Lead |
| Documentation | 15 | 78 | P0 | v1.0 | Tech Writer |
| Admin Dashboard | 15 | 95 | P1 | v1.1 | Full-Stack Lead |
| **Total** | **95** | **675** | | | |
