# Acceptance Criteria Templates

**Product:** GsmUi Platform
**Format:** Given/When/Then (Gherkin)
**Last Updated:** 2026-07-16
**Usage:** All stories must have AC in this format

---

## Format Guide

### Standard Structure

```gherkin
Feature: [Feature Name]
  As a [role]
  I want [action]
  So that [benefit]

  Background:
    Given [precondition that applies to all scenarios]

  Scenario: [Happy path]
    Given [initial context]
    When [action taken]
    Then [expected outcome]
    And [additional outcome]

  Scenario: [Error case]
    Given [initial context]
    When [invalid action]
    Then [error message]
    And [system state unchanged]

  Scenario: [Edge case]
    Given [edge case context]
    When [action taken]
    Then [expected handling]
```

### Keywords Reference

| Keyword | Meaning | Example |
|---------|---------|---------|
| **Given** | Initial context/state | Given I am logged in |
| **When** | Action taken | When I click "Save" |
| **Then** | Expected outcome | Then I see a success message |
| **And** | Additional condition | And the data is saved |
| **But** | Negative condition | But I do not see the admin panel |
| **Background** | Common preconditions | Given the database is seeded |
| **Scenario** | Single test case | Scenario: Valid login |
| **Scenario Outline** | Parameterized test | Scenario Outline: Login with `<provider>` |

---

## Module: Authentication

### Scenario: Successful Registration

```gherkin
Feature: User Registration
  As a new visitor
  I want to register with email and password
  So that I can create an account

  Scenario: Successful registration with valid data
    Given I am on the registration page
    When I enter "user@example.com" as email
    And I enter "SecurePass123!" as password
    And I enter "SecurePass123!" as password confirmation
    And I click "Create Account"
    Then I am redirected to "/verify-email"
    And I see "Check your email" message
    And a verification email is sent to "user@example.com"
    And my account status is "unverified"

  Scenario: Registration with existing email
    Given I am on the registration page
    And a user exists with email "existing@example.com"
    When I enter "existing@example.com" as email
    And I enter "SecurePass123!" as password
    And I click "Create Account"
    Then I see "Email already taken" error
    And my account is not created
    And no email is sent

  Scenario: Registration with weak password
    Given I am on the registration page
    When I enter "user@example.com" as email
    And I enter "123" as password
    And I click "Create Account"
    Then I see "Password must be at least 8 characters" error
    And my account is not created

  Scenario: Registration with mismatched passwords
    Given I am on the registration page
    When I enter "user@example.com" as email
    And I enter "SecurePass123!" as password
    And I enter "DifferentPass456!" as password confirmation
    And I click "Create Account"
    Then I see "Passwords do not match" error
    And my account is not created
```

### Scenario: OAuth Login

```gherkin
Feature: GitHub OAuth Login
  As a developer
  I want to login with GitHub
  So that I don't need another password

  Scenario: Successful GitHub login
    Given I am on the login page
    When I click "Login with GitHub"
    Then I am redirected to GitHub's OAuth page
    When I authorize the application on GitHub
    Then I am redirected to "/dashboard"
    And I am logged in
    And my GitHub profile is linked

  Scenario: GitHub login with existing account
    Given I am logged in with email "user@example.com"
    And my GitHub account is linked
    When I click "Login with GitHub"
    Then I am redirected to "/dashboard"
    And I see my profile information

  Scenario: GitHub login denied by user
    Given I am on the login page
    When I click "Login with GitHub"
    And I deny access on GitHub
    Then I am redirected to "/login"
    And I see "Authorization was denied" error
    And I am not logged in
```

### Scenario: Password Reset

```gherkin
Feature: Password Reset
  As a user who forgot their password
  I want to reset it via email
  So that I can regain access

  Scenario: Successful password reset request
    Given I am on the forgot password page
    When I enter "user@example.com" as email
    And I click "Send Reset Link"
    Then I see "Reset link sent" message
    And a reset email is sent to "user@example.com"

  Scenario: Password reset with invalid email
    Given I am on the forgot password page
    When I enter "nonexistent@example.com" as email
    And I click "Send Reset Link"
    Then I see "Reset link sent" message (for security)
    And no email is sent

  Scenario: Successful password reset
    Given I have a valid reset token for "user@example.com"
    And I am on the reset password page
    When I enter "NewSecurePass123!" as password
    And I enter "NewSecurePass123!" as password confirmation
    And I click "Reset Password"
    Then I am redirected to "/login"
    And I see "Password reset successfully" message
    And I can login with the new password
    And all previous sessions are invalidated
```

---

## Module: Billing

### Scenario: Subscription Checkout

```gherkin
Feature: Subscription Checkout
  As a user
  I want to subscribe to the Pro tier
  So that I can access premium features

  Scenario: Successful checkout
    Given I am logged in
    And I am on the pricing page
    When I click "Subscribe to Pro" ($29/mo)
    Then I am redirected to Stripe Checkout
    And the checkout shows "Pro Plan - $29/month"
    When I enter valid card details
    And I confirm payment
    Then I am redirected to "/billing/success"
    And I see "Subscription active" message
    And my subscription status is "active"
    And I have access to Pro features
    And a confirmation email is sent
    And an invoice is generated

  Scenario: Failed payment
    Given I am on Stripe Checkout
    When I enter invalid card details
    And I confirm payment
    Then I see "Payment failed" error
    And I am redirected to "/billing/error"
    And my subscription remains "inactive"
    And I can retry payment

  Scenario: Checkout abandoned
    Given I am on Stripe Checkout
    When I close the browser
    Then my subscription remains "inactive"
    And after 24 hours, I receive a reminder email
```

### Scenario: Subscription Upgrade

```gherkin
Feature: Subscription Upgrade
  As a Pro subscriber
  I want to upgrade to Team tier
  So that my team can access the platform

  Scenario: Successful upgrade with proration
    Given I have an active Pro subscription
    And I am on the billing settings page
    When I click "Upgrade to Team" ($79/mo)
    And I confirm the upgrade
    Then I am charged the prorated amount
    And my subscription changes to "team"
    And my team members get access
    And I receive an upgrade confirmation email

  Scenario: Upgrade with existing team
    Given I have an active Team subscription
    And I have 3 team members
    When I view my billing
    Then I see "Team Plan - $79/month"
    And I see "3 team members included"
```

### Scenario: Subscription Cancellation

```gherkin
Feature: Subscription Cancellation
  As a subscriber
  I want to cancel my subscription
  So that I am not charged again

  Scenario: Successful cancellation
    Given I have an active Pro subscription
    When I click "Cancel Subscription"
    And I confirm cancellation
    Then my subscription status becomes "canceled"
    And I retain access until "2026-08-15" (period end)
    And I receive a cancellation email
    And I see "Reactivate" option

  Scenario: Cancellation during trial
    Given I am on a free trial
    When I click "Cancel Subscription"
    And I confirm cancellation
    Then my trial ends immediately
    And I am downgraded to free tier
    And I receive a cancellation email

  Scenario: Reactivation after cancellation
    Given I have a canceled subscription
    And the billing period has not ended
    When I click "Reactivate"
    Then my subscription status becomes "active"
    And I continue to be charged at the original rate
```

---

## Module: Components

### Scenario: Button Component

```gherkin
Feature: Button Component
  As a developer
  I want a Button component with consistent behavior
  So that I can create reliable action triggers

  Scenario: Button click
    Given I render a primary Button component
    When I click the button
    Then the click event is fired
    And the button shows hover state during hover

  Scenario: Button loading state
    Given I render a Button with loading=true
    Then the button is disabled
    And a spinner icon is displayed
    And the button text is hidden
    And aria-busy="true" is set

  Scenario: Button disabled state
    Given I render a Button with disabled=true
    Then the button is disabled
    And clicking has no effect
    And the button has reduced opacity
    And aria-disabled="true" is set

  Scenario: Button keyboard interaction
    Given I render a primary Button component
    When I focus the button
    And I press Enter
    Then the click event is fired
    When I press Space
    Then the click event is fired

  Scenario: Button sizes
    Given I render a Button with size="sm"
    Then the button height is "2rem" (h-8)
    And the text size is "text-xs"
    Given I render a Button with size="md"
    Then the button height is "2.5rem" (h-10)
    And the text size is "text-sm"
    Given I render a Button with size="lg"
    Then the button height is "3rem" (h-12)
    And the text size is "text-base"
```

### Scenario: Input Component

```gherkin
Feature: Input Component
  As a developer
  I want an Input component with validation
  So that I can collect and validate user data

  Scenario: Text input
    Given I render a Text input component
    When I type "Hello World"
    Then the input value is "Hello World"
    And the wire:model is updated

  Scenario: Input validation error
    Given I render an Email input with required=true
    When I leave the input empty
    And I blur the input
    Then I see a validation error
    And the input border turns red
    And aria-invalid="true" is set

  Scenario: Input helper text
    Given I render a Text input with helper="Enter your full name"
    Then I see the helper text below the input
    And the helper text is styled differently from error text

  Scenario: Password toggle
    Given I render a Password input
    Then the input type is "password"
    When I click the toggle button
    Then the input type changes to "text"
    When I click the toggle button again
    Then the input type changes back to "password"

  Scenario: Clearable input
    Given I render a Text input with clearable=true
    And the input has value "Hello"
    Then I see a clear button (X icon)
    When I click the clear button
    Then the input value is ""
    And the wire:model is updated to ""
```

### Scenario: Modal Component

```gherkin
Feature: Modal Component
  As a developer
  I want a Modal component for dialogs
  So that I can show important information or collect input

  Scenario: Open and close modal
    Given I render a Modal component
    When I click the trigger button
    Then the modal is visible
    And the modal has role="dialog"
    And aria-modal="true" is set
    When I click the close button
    Then the modal is hidden

  Scenario: Close modal on escape
    Given the modal is open
    When I press Escape
    Then the modal is hidden
    And focus returns to the trigger button

  Scenario: Close modal on backdrop click
    Given the modal is open
    When I click the backdrop
    Then the modal is hidden

  Scenario: Modal focus trap
    Given the modal is open
    When I press Tab
    Then focus cycles within the modal
    And focus does not leave the modal

  Scenario: Alert modal
    Given I render an Alert modal with title="Warning"
    Then I see the title "Warning"
    And I see an OK button
    When I click OK
    Then the modal closes

  Scenario: Confirm modal
    Given I render a Confirm modal with message="Are you sure?"
    When I click "Confirm"
    Then the onConfirm event is fired
    And the modal closes
    When I open the modal again
    And I click "Cancel"
    Then the onCancel event is fired
    And the modal closes
```

### Scenario: Table Component

```gherkin
Feature: Table Component
  As a developer
  I want a Table component with sorting and pagination
  So that I can display large datasets

  Scenario: Sortable column
    Given I render a Table with sortable columns
    When I click the "Name" header
    Then the rows are sorted by name ascending
    And the sort indicator shows ascending
    When I click the "Name" header again
    Then the rows are sorted by name descending
    And the sort indicator shows descending

  Scenario: Pagination
    Given I render a Table with 50 rows and 10 per page
    Then I see 10 rows
    And I see pagination controls
    And I see "Page 1 of 5"
    When I click page 2
    Then I see rows 11–20
    And the URL updates to "?page=2"

  Scenario: Row selection
    Given I render a Table with selection enabled
    When I click a row checkbox
    Then the row is selected
    And the selected count updates
    When I click "Select All"
    Then all rows are selected
    When I click "Deselect All"
    Then no rows are selected

  Scenario: Empty state
    Given I render a Table with no data
    Then I see "No data available" message
    And I see an empty state illustration
```

---

## Module: Marketplace

### Scenario: Component Search

```gherkin
Feature: Component Search
  As a consumer
  I want to search for components
  So that I can find what I need quickly

  Scenario: Search by keyword
    Given I am on the marketplace page
    When I type "button" in the search box
    Then I see components matching "button"
    And results update as I type (debounced 300ms)

  Scenario: Search with no results
    Given I am on the marketplace page
    When I type "xyznonexistent"
    Then I see "No components found" message
    And I see suggested search terms

  Scenario: Filter by category
    Given I am on the marketplace page
    When I select category "Form Components"
    Then I see only components in that category
    And the filter is highlighted as active
    When I clear the filter
    Then I see all components again
```

### Scenario: Component Purchase

```gherkin
Feature: Component Purchase
  As a consumer
  I want to purchase a paid component
  So that I can use it in my project

  Scenario: Purchase free component
    Given I am viewing a free component
    When I click "Add to Library"
    Then the component is added to my library
    And I see "Component added" success message
    And installation instructions are shown

  Scenario: Purchase paid component
    Given I am viewing a paid component ($19)
    When I click "Purchase"
    Then I am redirected to Stripe Checkout
    And the checkout shows "Component Name - $19"
    When I complete payment
    Then I see "Purchase successful" message
    And the component is in my library
    And a license key is generated
    And I receive a receipt email

  Scenario: Already purchased component
    Given I have already purchased "Component X"
    When I view "Component X"
    Then I see "In Your Library" badge
    And I see installation instructions
    And I do not see a purchase button
```

---

## Module: Documentation

### Scenario: Documentation Navigation

```gherkin
Feature: Documentation Navigation
  As a developer
  I want to navigate documentation easily
  So that I can find information quickly

  Scenario: Sidebar navigation
    Given I am on the documentation site
    Then I see a sidebar with component list
    When I click "Button"
    Then I am on the Button documentation page
    And the sidebar highlights "Button"

  Scenario: Search documentation
    Given I am on the documentation site
    When I type "modal" in the search box
    Then I see search results
    And results include "Modal" component page
    And results include "Modal" in API reference
    When I click a result
    Then I am taken to that page

  Scenario: Table of contents
    Given I am on a documentation page
    Then I see a table of contents on the right
    And it shows all headings on the page
    When I click a heading
    Then I scroll to that section
```

### Scenario: Code Examples

```gherkin
Feature: Code Examples
  As a developer
  I want to copy code examples
  So that I can use components immediately

  Scenario: Copy code snippet
    Given I am on a component documentation page
    Then I see a code example
    And I see a copy button on the code block
    When I click the copy button
    Then the code is copied to my clipboard
    And I see "Copied!" confirmation

  Scenario: Interactive example
    Given I am on a component documentation page
    Then I see an interactive preview
    And I can interact with the preview
    When I change a prop in the code
    Then the preview updates
```

---

## Edge Cases and Negative Tests

### Authentication Edge Cases

```gherkin
Feature: Authentication Edge Cases

  Scenario: Login with rate limiting
    Given I have failed login 5 times in 1 minute
    When I attempt to login again
    Then I see "Too many attempts" error
    And I am locked out for 60 seconds

  Scenario: Session expiration
    Given I have been inactive for 24 hours
    When I try to access a protected page
    Then I am redirected to "/login"
    And I see "Session expired" message

  Scenario: Concurrent session limit
    Given I am logged in on Device A
    When I login on Device B
    Then I am logged in on Device B
    And I remain logged in on Device A
    And I see "2 active sessions" in settings

  Scenario: OAuth provider downtime
    Given GitHub is experiencing downtime
    When I click "Login with GitHub"
    Then I see "GitHub is temporarily unavailable" error
    And I am offered email/password login as alternative
```

### Billing Edge Cases

```gherkin
Feature: Billing Edge Cases

  Scenario: Payment method expiration
    Given I have an active subscription
    And my card expires next month
    When the next billing attempt fails
    Then I receive a "Payment failed" email
    And my subscription enters grace period
    And I see "Update payment method" prompt
    After 3 days without update
    Then my subscription is suspended
    And I am downgraded to free tier

  Scenario: Subscription during trial
    Given I am on a free trial (14 days)
    When I view my billing
    Then I see "Trial ends in X days"
    And I see upgrade options
    When I upgrade to Pro during trial
    Then my trial converts to paid subscription
    And I am charged immediately

  Scenario: Currency conversion
    Given I am in the United Kingdom
    When I view pricing
    Then I see prices in GBP
    And the exchange rate is updated daily
```

### Component Edge Cases

```gherkin
Feature: Component Edge Cases

  Scenario: Modal with long content
    Given I render a Modal with very long content
    Then the modal scrolls internally
    And the modal does not exceed viewport height
    And the close button remains visible

  Scenario: Table with empty columns
    Given I render a Table with some empty cells
    Then empty cells show a dash (—)
    And sorting still works correctly

  Scenario: Select with many options
    Given I render a Select with 1000 options
    Then the dropdown is virtualized
    And scrolling is smooth
    And search still works quickly

  Scenario: Button in a form
    Given I render a Button inside a form
    When I press Enter anywhere in the form
    Then the form submits (not the button)
    Unless the button is the only focusable element
```

### Marketplace Edge Cases

```gherkin
Feature: Marketplace Edge Cases

  Scenario: Component version conflict
    Given I have version 1.0.0 of "Component X"
    And version 1.1.0 is available
    When I view my library
    Then I see "Update available" badge
    And I see changelog for 1.1.0
    When I click "Update"
    Then I am shown breaking changes (if any)
    And I confirm the update

  Scenario: Publisher account deletion
    Given a publisher has 5 published components
    When the publisher requests account deletion
    Then I see a warning about published components
    And I must transfer or unpublish all components first
    And I must wait 30 days for full deletion

  Scenario: Review on free component
    Given I have added a free component to my library
    When I navigate to the component page
    Then I see "Write a Review" button
    When I submit a review with 4 stars
    Then my review is posted
    And the component rating updates
```

---

## AC Quality Checklist

Every acceptance criteria set must pass this checklist:

| Check | Criterion | Pass? |
|-------|-----------|-------|
| 1 | Each criterion is testable | [ ] |
| 2 | Each criterion is unambiguous | [ ] |
| 3 | Happy path covered | [ ] |
| 4 | Error cases covered | [ ] |
| 5 | Edge cases identified | [ ] |
| 6 | Performance criteria included (if applicable) | [ ] |
| 7 | Accessibility criteria included | [ ] |
| 8 | Security criteria included (if applicable) | [ ] |
| 9 | No implementation details leaked | [ ] |
| 10 | Stakeholder review complete | [ ] |

---

## AC Anti-Patterns to Avoid

| Anti-Pattern | Bad Example | Good Example |
|--------------|-------------|--------------|
| Vague language | "The page should look good" | "The page matches design system tokens" |
| Implementation details | "Use Redux to manage state" | "State persists across page reloads" |
| Multiple assertions | "X and Y and Z happen" | Split into separate criteria |
| Untestable criteria | "Users should be happy" | "NPS score > 40" |
| Missing negative cases | Only happy path | Include error/edge cases |
| UI-specific criteria | "Button is blue" | "Button uses primary variant style" |
