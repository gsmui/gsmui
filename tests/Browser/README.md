# CSP Browser Tests

## Prerequisites

- Node.js 18+
- A running Laravel dev server with Gsmui Pro installed

## Setup

```bash
cd tests/Browser

# Install Playwright
npm init -y
npm install -D @playwright/test

# Install browsers
npx playwright install chromium
```

## Running the Tests

### 1. Start the Laravel dev server with CSP enabled

```bash
# Make sure CSP is enabled in your .env
CSP_ENABLED=true

# Start the server
php artisan serve --port=8000
```

### 2. Run the Playwright tests

```bash
cd tests/Browser
npx playwright test
```

### 3. View the HTML report

```bash
npx playwright show-report
```

## What the Tests Cover

| Test | What it checks |
|---|---|
| `page loads without CSP violations` | All components render without CSP errors in console |
| `interacting with components` | Clicking select, date-picker, slider, and modal doesn't trigger CSP violations |
| `response includes CSP header` | Server sends the `Content-Security-Policy` header with expected directives |

## Adding New Components

When adding a new component to Gsmui Pro:

1. Add the component to `csp-test.blade.php`
2. Add interaction steps to the `interacting with components` test in `csp.spec.js`
3. Run the tests to verify no CSP violations
