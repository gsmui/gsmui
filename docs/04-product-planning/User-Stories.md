# User Stories

**Product:** GsmUi Platform
**Format:** As a [role], I want [feature], So that [benefit]
**Story Points:** Fibonacci (1, 2, 3, 5, 8, 13, 21)
**Last Updated:** 2026-07-16

---

## Story Point Reference

| Points | Complexity | Time Estimate | Description |
|--------|------------|---------------|-------------|
| 1 | Trivial | < 1 hour | Typo fix, config change |
| 2 | Simple | 1–3 hours | Small bug fix, minor feature |
| 3 | Moderate | 3–8 hours | Standard feature, well-understood |
| 5 | Medium | 1–2 days | Feature with some complexity |
| 8 | Complex | 2–5 days | Feature with multiple components |
| 13 | Very Complex | 1–2 weeks | Large feature, unknowns |
| 21 | Epic | 2–4 weeks | Massive feature, needs breakdown |

---

## Story Template

```markdown
### STORY-ID: [Title]

**Story Points:** [1|2|3|5|8|13|21]
**Priority:** [P0|P1|P2|P3]
**Module:** [Auth|Billing|Component|Marketplace|Docs|Admin]
**Sprint:** [S1–S12]
**Dependencies:** [List of dependent stories]

#### User Story
As a [role],
I want [feature/capability],
So that [benefit/value].

#### Acceptance Criteria
- [ ] Criterion 1
- [ ] Criterion 2
- [ ] Criterion 3

#### Technical Notes
- Implementation details
- API considerations
- Performance requirements

#### Definition of Done
- [ ] Code complete
- [ ] Tests written and passing
- [ ] Documentation updated
- [ ] Visual regression tests pass
- [ ] Accessibility verified
- [ ] Code reviewed
```

---

## Module: Authentication

### AUTH-S01: Email/Password Registration

**Story Points:** 3
**Priority:** P0
**Module:** Auth
**Sprint:** S1
**Dependencies:** None

#### User Story
As a new visitor,
I want to register with my email and password,
So that I can create an account and access the platform.

#### Acceptance Criteria
- [ ] Registration form with email, password, confirm password fields
- [ ] Email validation (valid format, not already registered)
- [ ] Password requirements: min 8 chars, 1 uppercase, 1 number, 1 special char
- [ ] Passwords must match
- [ ] On success: create account, send verification email, redirect to "Check email" page
- [ ] On error: display specific error messages inline
- [ ] Rate limiting: 5 registration attempts per IP per minute
- [ ] CSRF token validated

#### Technical Notes
- Use Laravel Breeze auth scaffolding
- Store passwords hashed with bcrypt
- Queue verification email (not synchronous)
- Log registration attempt for security

---

### AUTH-S06: GitHub OAuth Login

**Story Points:** 5
**Priority:** P0
**Module:** Auth
**Sprint:** S5
**Dependencies:** AUTH-S01

#### User Story
As a developer,
I want to login using my GitHub account,
So that I don't need to remember another password.

#### Acceptance Criteria
- [ ] "Login with GitHub" button on login page
- [ ] Button styled per design system (GitHub icon, dark background)
- [ ] Redirect to GitHub OAuth authorization page
- [ ] Request scopes: `read:user`, `user:email`
- [ ] On success: create/link account, create session, redirect to dashboard
- [ ] On user denial: show error message, remain on login page
- [ ] On email conflict: prompt user to link existing account
- [ ] Store GitHub access token encrypted
- [ ] Handle GitHub API errors gracefully

#### Technical Notes
- Use Laravel Socialite
- GitHub OAuth App credentials in `.env`
- Handle edge case: user has account with same email but different provider
- Token encrypted with `Crypt::encryptString()`

---

### AUTH-S13: Team Invitation

**Story Points:** 5
**Priority:** P1
**Module:** Auth
**Sprint:** S6
**Dependencies:** AUTH-S19, BILL-004

#### User Story
As a team owner,
I want to invite colleagues by email,
So that we can collaborate on components together.

#### Acceptance Criteria
- [ ] "Invite Member" button on team settings page
- [ ] Email input field with validation
- [ ] Role selector (admin, member, viewer)
- [ ] Custom message field (optional)
- [ ] On submit: send invitation email with unique link
- [ ] Invitation link expires after 7 days
- [ ] Invitee can accept or decline
- [ ] If invitee has account: add to team directly
- [ ] If invitee has no account: prompt registration, then add to team
- [ ] Maximum team size based on subscription tier
- [ ] Activity log records invitation sent

#### Technical Notes
- Store invitations in `team_invitations` table
- Token generated with `Str::random(64)`
- Email via Postmark/Resend
- Queue email for async delivery

---

## Module: Billing

### BILL-S03: Subscribe to Pro Tier

**Story Points:** 8
**Priority:** P0
**Module:** Billing
**Sprint:** S5
**Dependencies:** AUTH-S01, BILL-001

#### User Story
As a user,
I want to subscribe to the Pro tier,
So that I can access all components and premium features.

#### Acceptance Criteria
- [ ] Pricing page shows Free vs Pro comparison
- [ ] "Subscribe to Pro" button ($29/mo)
- [ ] Redirect to Stripe Checkout (hosted)
- [ ] Checkout shows: plan name, price, billing cycle
- [ ] On success: subscription created, user redirected to success page
- [ ] On failure: user redirected to error page with retry option
- [ ] Webhook confirms subscription activation
- [ ] Pro features immediately accessible after activation
- [ ] Confirmation email sent
- [ ] Invoice generated and visible in billing history

#### Technical Notes
- Use Stripe Checkout Sessions (hosted)
- Price ID configured in `.env`
- Webhook endpoint: `/webhooks/stripe`
- Idempotent webhook handling (check `already processed`)
- Store `stripe_subscription_id` on user

---

### BILL-S06: Cancel Subscription

**Story Points:** 5
**Priority:** P0
**Module:** Billing
**Sprint:** S5
**Dependencies:** BILL-S03

#### User Story
As a subscriber,
I want to cancel my subscription,
So that I am no longer charged.

#### Acceptance Criteria
- [ ] "Cancel Subscription" link in billing settings
- [ ] Confirmation dialog with cancellation reason (optional)
- [ ] On confirm: subscription status set to "canceled"
- [ ] Access retained until end of current billing period
- [ ] Cancellation email sent
- [ ] Reactivation option available during grace period
- [ ] After grace period: downgrade to free tier
- [ ] User data preserved (not deleted)

#### Technical Notes
- Use Stripe Subscription cancel (at period end)
- Do NOT cancel immediately — retain access
- Store `canceled_at` timestamp
- Grace period: 3 days after period end

---

## Module: Components

### COMP-S01: Button Component

**Story Points:** 5
**Priority:** P0
**Module:** Component
**Sprint:** S1
**Dependencies:** None

#### User Story
As a developer,
I want a Button component with multiple variants,
So that I can create consistent action triggers across my application.

#### Acceptance Criteria
- [ ] Variants: primary, secondary, ghost, danger
- [ ] Sizes: sm (h-8), md (h-10), lg (h-12)
- [ ] States: default, hover, active, disabled, loading
- [ ] Icon support: left icon, right icon, icon-only
- [ ] Full-width mode
- [ ] Proper focus-visible styling
- [ ] Keyboard accessible (Enter/Space triggers click)
- [ ] ARIA attributes: `aria-disabled`, `aria-busy` (loading)
- [ ] Events: `click`, `blur`, `focus`
- [ ] Wire:model support
- [ ] Works with `<a>` tags (as="a") and `<button>` tags
- [ ] Dark mode support
- [ ] All variants pass visual regression tests

#### Technical Notes
- Follow AGENTS.md cursor rules (no cursor-pointer on buttons)
- Use native focus outlines, no custom focus rings
- Loading state: spinner icon + disabled
- Disabled: `disabled` attribute + `[&[disabled]]:shadow-none!`

---

### COMP-S05: Table Component

**Story Points:** 13
**Priority:** P0
**Module:** Component
**Sprint:** S4
**Dependencies:** COMP-S01, COMP-S13

#### User Story
As a developer,
I want a Table component with sorting and pagination,
So that I can display large datasets in a structured format.

#### Acceptance Criteria
- [ ] Basic table with headers and rows
- [ ] Sortable columns (click header to sort)
- [ ] Sort indicators (ascending/descending)
- [ ] Pagination (numbered, 10/25/50 per page)
- [ ] Row selection (checkbox)
- [ ] Select all / deselect all
- [ ] Empty state when no data
- [ ] Loading skeleton while data loads
- [ ] Responsive: horizontal scroll on mobile
- [ ] Striped rows option
- [ ] Compact mode option
- [ ] Keyboard navigation (arrow keys between cells)
- [ ] ARIA: `role="table"`, `role="row"`, `role="columnheader"`

#### Technical Notes
- Use `tabular-nums` for numeric columns
- Sort via wire:click or Alpine
- Pagination: server-side (Livewire) or client-side
- Performance: virtual scrolling for 1000+ rows (v1.1)

---

### COMP-S20: Skeleton Loader

**Story Points:** 3
**Priority:** P0
**Module:** Component
**Sprint:** S4
**Dependencies:** None

#### User Story
As a developer,
I want Skeleton loader components,
So that I can show loading placeholders while content loads.

#### Acceptance Criteria
- [ ] Text skeleton (single line, multi-line)
- [ ] Avatar skeleton (circle, square)
- [ ] Card skeleton (header + body)
- [ ] Table skeleton (rows)
- [ ] Image skeleton
- [ ] Pulse animation (subtle, not distracting)
- [ ] Customizable width/height
- [ ] Dark mode support
- [ ] ARIA: `aria-hidden="true"`, `aria-busy` on parent

#### Technical Notes
- Use CSS `@keyframes pulse` animation
- Base color: `bg-zinc-200 dark:bg-zinc-700`
- Animation: `animate-pulse`
- Wrap in container with `aria-busy="true"`

---

## Module: Marketplace

### MKT-S08: Submit Component

**Story Points:** 8
**Priority:** P0
**Module:** Marketplace
**Sprint:** S7
**Dependencies:** MKT-S01, AUTH-S01

#### User Story
As a verified publisher,
I want to submit a component to the marketplace,
So that other developers can discover and use it.

#### Acceptance Criteria
- [ ] Submission form with: name, slug, description, category, tags
- [ ] Price field (0 for free, or paid amount)
- [ ] Code upload (ZIP archive or Git URL)
- [ ] Screenshot upload (1–5 images, max 5MB each)
- [ ] Version field (semver format, validated)
- [ ] Changelog field (markdown supported)
- [ ] License selector (MIT, Apache, GPL, proprietary)
- [ ] Preview URL field (optional)
- [ ] On submit: component enters review queue
- [ ] Confirmation email sent
- [ ] Component not publicly visible until approved
- [ ] Validation: all required fields, file sizes, image formats

#### Technical Notes
- Store component code in S3
- Generate thumbnail from first screenshot
- Validate semver with `Composer\Semver\VersionParser`
- Queue code quality checks (linting, structure)

---

### MKT-S12: Purchase Paid Component

**Story Points:** 8
**Priority:** P0
**Module:** Marketplace
**Sprint:** S8
**Dependencies:** BILL-S01, MKT-S04

#### User Story
As a consumer,
I want to purchase a paid component,
So that I can use it in my project.

#### Acceptance Criteria
- [ ] "Purchase" button on component detail page
- [ ] Price clearly displayed
- [ ] Click opens Stripe Checkout
- [ ] Checkout shows: component name, price, license terms
- [ ] On success: license key generated, component accessible
- [ ] On failure: error message, retry option
- [ ] Invoice generated and emailed
- [ ] Component appears in "My Components" library
- [ ] License key stored securely
- [ ] One-click install instructions shown after purchase

#### Technical Notes
- Stripe Checkout for payment
- License key: UUID stored encrypted
- License validation API endpoint
- Rate limit license checks (prevent abuse)

---

## Module: Documentation

### DOC-S03: Component API Reference

**Story Points:** 13
**Priority:** P0
**Module:** Docs
**Sprint:** S9
**Dependencies:** COMP-* (all components)

#### User Story
As a developer,
I want comprehensive API reference for each component,
So that I can use components correctly without guessing.

#### Acceptance Criteria
- [ ] Page for each of 20 components
- [ ] Sections: Overview, Props, Events, Slots, Examples
- [ ] Props table: name, type, default, required, description
- [ ] Events table: name, payload, description
- [ ] Slots table: name, description
- [ ] At least 3 code examples per component
- [ ] Copy button on all code blocks
- [ ] Syntax highlighting (HTML, PHP, Blade)
- [ ] Interactive preview (Livewire sandbox)
- [ ] Search results link to specific sections
- [ ] Mobile responsive
- [ ] Dark mode support

#### Technical Notes
- Use VitePress or similar static generator
- Code examples in `<pre><code>` with Shiki highlighting
- Interactive preview: iframe to Livewire sandbox
- Search: Pagefind (static search)

---

### DOC-S08: Migration Guide from Flux

**Story Points:** 5
**Priority:** P1
**Module:** Docs
**Sprint:** S10
**Dependencies:** COMP-* (all components)

#### User Story
As a developer currently using Flux,
I want a migration guide to GsmUi,
So that I can switch libraries with minimal effort.

#### Acceptance Criteria
- [ ] Flux component → GsmUi component mapping table
- [ ] API differences documented (props, events)
- [ ] Code examples: Flux syntax → GsmUi syntax
- [ ] Breaking changes highlighted
- [ ] Step-by-step migration process
- [ ] Automated migration script (if feasible)
- [ ] Common pitfalls documented
- [ ] Testing checklist for migrated projects

#### Technical Notes
- Research Flux API thoroughly
- Create side-by-side comparison tables
- Test migration with real Flux project
- Consider providing codemods for common patterns

---

## Module: Admin

### ADM-S01: User Listing

**Story Points:** 5
**Priority:** P0
**Module:** Admin
**Sprint:** S11
**Dependencies:** AUTH-EPIC

#### User Story
As an admin,
I want to view all registered users,
So that I can manage the platform effectively.

#### Acceptance Criteria
- [ ] Paginated table of all users
- [ ] Columns: name, email, role, status, joined date, last active
- [ ] Sort by any column
- [ ] Search by name or email
- [ ] Filter by status (active, suspended, banned)
- [ ] Filter by role (admin, member, viewer)
- [ ] Filter by subscription tier
- [ ] Click row to view user details
- [ ] Bulk actions (suspend, delete)
- [ ] Export to CSV
- [ ] Real-time updates (user count)

#### Technical Notes
- Admin-only route (middleware: `admin`)
- Use Livewire for real-time filtering
- Pagination: 25 per page
- CSV export via queue (large datasets)

---

### ADM-S09: Feature Flag Management

**Story Points:** 8
**Priority:** P1
**Module:** Admin
**Sprint:** S11
**Dependencies:** ADM-001

#### User Story
As an admin,
I want to manage feature flags,
So that I can control feature rollouts and run A/B tests.

#### Acceptance Criteria
- [ ] List of all feature flags
- [ ] Create new flag with: name, description, percentage, conditions
- [ ] Toggle flag on/off
- [ ] Set rollout percentage (0–100%)
- [ ] Condition rules: user role, subscription tier, geographic
- [ ] Schedule rollout changes
- [ ] Audit log of all flag changes
- [ ] API endpoint for flag evaluation
- [ ] Cache flag evaluations (5 minute TTL)

#### Technical Notes
- Store flags in database with cache layer
- Use Laravel's ` Illuminate\Support\Feature` or custom
- Cache with Redis (5 min TTL)
- Invalidate cache on flag change
- API endpoint: `GET /api/flags`

---

## Story Point Distribution by Module

| Module | Stories | Total Points | Avg Points/Story |
|--------|---------|-------------|------------------|
| Authentication | 15 | 89 | 5.9 |
| Billing | 15 | 112 | 7.5 |
| Component Library | 20 | 156 | 7.8 |
| Marketplace | 15 | 145 | 9.7 |
| Documentation | 15 | 78 | 5.2 |
| Admin Dashboard | 15 | 95 | 6.3 |
| **Total** | **95** | **675** | **7.1** |

## Story Point Distribution by Priority

| Priority | Stories | Total Points |
|----------|---------|-------------|
| P0 | 35 | 210 |
| P1 | 30 | 245 |
| P2 | 20 | 150 |
| P3 | 10 | 70 |
| **Total** | **95** | **675** |

## Sprint Allocation

| Sprint | Stories | Points | Focus |
|--------|---------|--------|-------|
| S1 | 8 | 35 | Foundation |
| S2 | 7 | 35 | Foundation |
| S3 | 8 | 40 | Components |
| S4 | 8 | 40 | Components |
| S5 | 8 | 45 | Billing |
| S6 | 7 | 40 | Auth Polish |
| S7 | 8 | 45 | Marketplace |
| S8 | 7 | 40 | Marketplace |
| S9 | 8 | 40 | Documentation |
| S10 | 7 | 38 | Polish |
| S11 | 8 | 45 | Pre-Launch |
| S12 | 7 | 37 | Launch |
| **Total** | **95** | **480** | |
