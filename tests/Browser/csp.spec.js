// @ts-check
const { test, expect } = require('@playwright/test');

/**
 * CSP Violation Test Suite
 *
 * Prerequisites:
 *   1. Start a Laravel dev server with CSP middleware enabled:
 *      php artisan serve --port=8000
 *   2. Run Playwright:
 *      npx playwright test
 *
 * These tests navigate to the CSP test page and assert that:
 *   - No CSP violation errors appear in the browser console
 *   - All component interactions work without triggering CSP blocks
 *   - The Content-Security-Policy header is present and correct
 */

const CSP_TEST_URL = '/gsmui-csp-test';

/**
 * Sets up listeners on a page to capture all CSP violations from both
 * console messages and securitypolicyviolation DOM events.
 *
 * Returns an array of violation objects: { source, text }
 *   - source: 'console' | 'event'
 *   - text: the violation description
 */
async function setupCspViolationCapture(page) {
  /** @type {Array<{source: string, text: string}>} */
  const violations = [];

  // Capture console messages that indicate CSP violations
  page.on('console', (msg) => {
    const text = msg.text();

    const isCspViolation =
      text.includes('Content Security Policy') ||
      text.includes('Refused to apply inline style') ||
      text.includes('Refused to load') ||
      text.includes('Refused to execute') ||
      text.includes('Refused to connect') ||
      text.includes('Refused to frame') ||
      text.includes('violates the following Content Security Policy') ||
      text.includes('CSP') ||
      (msg.type() === 'error' && (
        text.toLowerCase().includes('csp') ||
        text.toLowerCase().includes('security policy')
      ));

    if (isCspViolation) {
      violations.push({ source: 'console', text });
    }
  });

  // Capture securitypolicyviolation DOM events via page.exposeFunction
  await page.exposeFunction('__cspViolationHandler', (violation) => {
    violations.push({
      source: 'event',
      text: `[${violation.violatedDirective}] blocked: ${violation.blockedURI || violation.originalPolicy?.slice(0, 80)}`,
    });
  });

  // Inject event listener for securitypolicyviolation
  await page.addInitScript(() => {
    document.addEventListener('securitypolicyviolation', (e) => {
      // Forward to the exposed function
      if (window.__cspViolationHandler) {
        window.__cspViolationHandler({
          violatedDirective: e.violatedDirective || e.effectiveDirective,
          blockedURI: e.blockedURI,
          originalPolicy: e.originalPolicy,
          sourceFile: e.sourceFile,
          lineNumber: e.lineNumber,
          columnNumber: e.columnNumber,
        });
      }
    });
  });

  return violations;
}

test.describe('CSP Compliance', () => {
  test.describe.configure({ mode: 'serial' });

  test('page loads without CSP violations', async ({ page }) => {
    const violations = await setupCspViolationCapture(page);

    const response = await page.goto(CSP_TEST_URL, {
      waitUntil: 'networkidle',
    });

    expect(response?.status()).toBe(200);

    // Allow async operations and component hydration to settle
    await page.waitForTimeout(2000);

    if (violations.length > 0) {
      console.log(`Found ${violations.length} CSP violation(s):`);
      violations.forEach((v) => console.log(`  [${v.source}] ${v.text}`));
    }

    expect(violations).toEqual([]);
  });

  test('interacting with components does not trigger CSP violations', async ({ page }) => {
    const violations = await setupCspViolationCapture(page);

    await page.goto(CSP_TEST_URL, { waitUntil: 'networkidle' });

    // Wait for components to hydrate
    await page.waitForTimeout(1000);

    // Interact with the select component (click to open dropdown)
    const selectTrigger = page.locator('[data-gsmui-select]').first();
    if (await selectTrigger.isVisible()) {
      await selectTrigger.click();
      await page.waitForTimeout(500);
      await page.keyboard.press('Escape');
      await page.waitForTimeout(300);
    }

    // Interact with the date picker button
    const datePicker = page.locator('[data-gsmui-date-picker]').first();
    if (await datePicker.isVisible()) {
      await datePicker.click();
      await page.waitForTimeout(500);
      await page.keyboard.press('Escape');
      await page.waitForTimeout(300);
    }

    // Click the accordion heading to expand/collapse
    const accordionHeading = page.locator('[data-gsmui-accordion-heading]').first();
    if (await accordionHeading.isVisible()) {
      await accordionHeading.click();
      await page.waitForTimeout(300);
    }

    // Click the modal trigger button
    const modalButton = page.getByRole('button', { name: 'Open Modal' }).first();
    if (await modalButton.isVisible()) {
      await modalButton.click();
      await page.waitForTimeout(500);
      // Close modal via Escape
      await page.keyboard.press('Escape');
      await page.waitForTimeout(300);
    }

    // Allow final interactions to settle
    await page.waitForTimeout(1000);

    if (violations.length > 0) {
      console.log(`Found ${violations.length} CSP violation(s) after interactions:`);
      violations.forEach((v) => console.log(`  [${v.source}] ${v.text}`));
    }

    expect(violations).toEqual([]);
  });
});

test.describe('CSP Header', () => {
  test('response includes Content-Security-Policy header', async ({ page }) => {
    const response = await page.goto(CSP_TEST_URL, { waitUntil: 'networkidle' });

    // Playwright returns all header names as lowercase
    const headers = response?.headers() || {};
    const cspHeader = headers['content-security-policy'];

    expect(cspHeader).toBeTruthy();
    expect(cspHeader).toContain("default-src 'self'");
    expect(cspHeader).toContain("script-src 'self'");
    expect(cspHeader).toContain("style-src 'self'");
    expect(cspHeader).toContain("img-src 'self' data:");
    expect(cspHeader).toContain('upgrade-insecure-requests');
  });
});
