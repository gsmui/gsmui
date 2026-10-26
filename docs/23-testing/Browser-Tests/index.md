# Browser Testing

> PRD — Volume 23: Quality Assurance — Browser Testing

## Overview

Browser testing uses Playwright for end-to-end testing of the gsmui platform, including page object models, assertions, visual regression testing, and CI execution.

## Objectives

| Goal | Metric | Target |
|------|--------|--------|
| Critical path coverage | E-commerce/user flows | 100% |
| Test execution | Full browser test suite | < 10 minutes |
| Visual regression | Screenshot comparison accuracy | 99%+ |
| Cross-browser | Chrome, Firefox, Safari support | All 3 |
| CI reliability | Flaky test rate | < 2% |

## Playwright Setup

### Installation

```bash
# Install Playwright
npm init playwright@latest

# Install browsers
npx playwright install --with-deps chromium firefox webkit

# Install dependencies
npm install -D @playwright/test
```

### Configuration

```typescript
// playwright.config.ts
import { defineConfig, devices } from '@playwright/test';

export default defineConfig({
  testDir: './tests/Browser',
  fullyParallel: true,
  forbidOnly: !!process.env.CI,
  retries: process.env.CI ? 2 : 0,
  workers: process.env.CI ? 1 : undefined,
  reporter: [
    ['html', { outputFolder: 'tests/Browser/report' }],
    ['junit', { outputFile: 'tests/Browser/results.xml' }],
  ],
  use: {
    baseURL: 'http://localhost:8000',
    trace: 'on-first-retry',
    screenshot: 'only-on-failure',
    video: 'retain-on-failure',
  },
  projects: [
    {
      name: 'chromium',
      use: { ...devices['Desktop Chrome'] },
    },
    {
      name: 'firefox',
      use: { ...devices['Desktop Firefox'] },
    },
    {
      name: 'webkit',
      use: { ...devices['Desktop Safari'] },
    },
    {
      name: 'mobile-chrome',
      use: { ...devices['Pixel 5'] },
    },
    {
      name: 'mobile-safari',
      use: { ...devices['iPhone 13'] },
    },
  ],
  webServer: {
    command: 'php artisan serve --port=8000',
    port: 8000,
    reuseExistingServer: !process.env.CI,
  },
});
```

## Page Objects

### Page Object Structure

```typescript
// tests/Browser/Pages/PageBuilder.ts
import { Page, Locator, expect } from '@playwright/test';

export class PageBuilder {
    readonly page: Page;
    readonly addBlockButton: Locator;
    readonly saveButton: Locator;
    readonly blockList: Locator;

    constructor(page: Page) {
        this.page = page;
        this.addBlockButton = page.getByRole('button', { name: 'Add Block' });
        this.saveButton = page.getByRole('button', { name: 'Save' });
        this.blockList = page.locator('[data-block-list]');
    }

    async goto(pageId: number) {
        await this.page.goto(`/admin/pages/${pageId}/edit`);
        await this.page.waitForLoadState('networkidle');
    }

    async addBlock(type: string) {
        await this.addBlockButton.click();
        await this.page.getByRole('option', { name: type }).click();
    }

    async removeBlock(index: number) {
        const block = this.blockList.locator('[data-block]').nth(index);
        await block.getByRole('button', { name: 'Remove' }).click();
    }

    async moveBlock(from: number, to: number) {
        const fromBlock = this.blockList.locator('[data-block]').nth(from);
        const toBlock = this.blockList.locator('[data-block]').nth(to);

        await fromBlock.dragTo(toBlock);
    }

    async save() {
        await this.saveButton.click();
        await this.page.waitForResponse(resp =>
            resp.url().includes('/admin/pages/') && resp.status() === 200
        );
    }

    async getBlockCount(): Promise<number> {
        return this.blockList.locator('[data-block]').count();
    }

    async expectBlockVisible(type: string, index: number) {
        const block = this.blockList.locator(`[data-block-type="${type}"]`).nth(index);
        await expect(block).toBeVisible();
    }
}
```

### Auth Helper

```typescript
// tests/Browser/Helpers/Auth.ts
import { Page } from '@playwright/test';

export async function loginAsAdmin(page: Page) {
    await page.goto('/login');
    await page.fill('input[name="email"]', 'admin@example.com');
    await page.fill('input[name="password"]', 'password');
    await page.click('button[type="submit"]');
    await page.waitForURL('/dashboard');
}

export async function loginAsEditor(page: Page) {
    await page.goto('/login');
    await page.fill('input[name="email"]', 'editor@example.com');
    await page.fill('input[name="password"]', 'password');
    await page.click('button[type="submit"]');
    await page.waitForURL('/dashboard');
}
```

## Test Examples

### Page Builder Test

```typescript
import { test, expect } from '@playwright/test';
import { PageBuilder } from '../Pages/PageBuilder';
import { loginAsAdmin } from '../Helpers/Auth';

test.describe('Page Builder', () => {
    let pageBuilder: PageBuilder;

    test.beforeEach(async ({ page }) => {
        await loginAsAdmin(page);
        pageBuilder = new PageBuilder(page);
    });

    test('can add a heading block', async ({ page }) => {
        await pageBuilder.goto(1);

        const initialCount = await pageBuilder.getBlockCount();
        await pageBuilder.addBlock('heading');

        const newCount = await pageBuilder.getBlockCount();
        expect(newCount).toBe(initialCount + 1);
        await pageBuilder.expectBlockVisible('heading', initialCount);
    });

    test('can remove a block', async ({ page }) => {
        await pageBuilder.goto(1);

        await pageBuilder.addBlock('paragraph');
        const count = await pageBuilder.getBlockCount();
        await pageBuilder.removeBlock(count - 1);

        expect(await pageBuilder.getBlockCount()).toBe(count - 1);
    });

    test('can reorder blocks via drag and drop', async ({ page }) => {
        await pageBuilder.goto(1);

        await pageBuilder.addBlock('heading');
        await pageBuilder.addBlock('paragraph');

        await pageBuilder.moveBlock(1, 0);

        await pageBuilder.expectBlockVisible('paragraph', 0);
        await pageBuilder.expectBlockVisible('heading', 1);
    });

    test('can save page', async ({ page }) => {
        await pageBuilder.goto(1);
        await pageBuilder.addBlock('heading');
        await pageBuilder.save();

        await expect(page.getByText('Page saved successfully')).toBeVisible();
    });
});
```

### Visual Regression Test

```typescript
import { test, expect } from '@playwright/test';

test.describe('Visual Regression', () => {
    test('homepage matches snapshot', async ({ page }) => {
        await page.goto('/');
        await expect(page).toHaveScreenshot('homepage.png', {
            maxDiffPixels: 100,
        });
    });

    test('blog post matches snapshot', async ({ page }) => {
        await page.goto('/blog/sample-post');
        await expect(page).toHaveScreenshot('blog-post.png', {
            maxDiffPixels: 100,
        });
    });

    test('admin dashboard matches snapshot', async ({ page }) => {
        await loginAsAdmin(page);
        await expect(page).toHaveScreenshot('admin-dashboard.png', {
            maxDiffPixels: 100,
        });
    });
});
```

## Assertions

### Available Assertions

| Assertion | Description |
|-----------|-------------|
| `expect(locator).toBeVisible()` | Element is visible |
| `expect(locator).toBeHidden()` | Element is hidden |
| `expect(locator).toHaveText(text)` | Element has exact text |
| `expect(locator).toContainText(text)` | Element contains text |
| `expect(locator).toHaveValue(value)` | Input has value |
| `expect(locator).toBeChecked()` | Checkbox is checked |
| `expect(locator).toBeDisabled()` | Element is disabled |
| `expect(page).toHaveTitle(title)` | Page has title |
| `expect(page).toHaveURL(url)` | Page has URL |
| `expect(page).toHaveScreenshot()` | Visual snapshot match |

### Custom Assertions

```typescript
// tests/Browser/Assertions/Custom.ts
import { expect, Page } from '@playwright/test';

export async function expectNotification(page: Page, message: string) {
    const notification = page.locator('[data-notification]');
    await expect(notification).toBeVisible();
    await expect(notification).toContainText(message);
}

export async function expectTableRows(page: Page, count: number) {
    const rows = page.locator('table tbody tr');
    await expect(rows).toHaveCount(count);
}
```

## Visual Regression

### Screenshot Management

```typescript
// Update snapshots
// npx playwright test --update-snapshots

// Compare screenshots
test('component renders correctly', async ({ page }) => {
    await page.goto('/components/button');
    await expect(page).toHaveScreenshot('button-default.png', {
        animations: 'disabled',
    });
});
```

### Snapshot Configuration

| Setting | Description | Default |
|---------|-------------|---------|
| `maxDiffPixels` | Max pixel difference allowed | 100 |
| `maxDiffPixelRatio` | Max ratio of different pixels | 0.01 |
| `threshold` | Per-pixel color difference threshold | 0.2 |
| `animations` | Disable animations for snapshots | `'disabled'` |

## CI Execution

### GitHub Actions Workflow

```yaml
name: Browser Tests

on:
  push:
    branches: [main, develop]
  pull_request:
    branches: [main]

jobs:
  test:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v4
      - uses: actions/setup-node@v4
        with:
          node-version: 20
      - name: Install Dependencies
        run: npm ci
      - name: Install Playwright
        run: npx playwright install --with-deps
      - name: Start Server
        run: |
          composer install
          php artisan migrate:fresh --seed
          php artisan serve --port=8000 &
      - name: Wait for Server
        run: npx wait-on http://localhost:8000
      - name: Run Browser Tests
        run: npx playwright test
      - name: Upload Report
        if: failure()
        uses: actions/upload-artifact@v4
        with:
          name: playwright-report
          path: tests/Browser/report/
      - name: Upload Screenshots
        if: failure()
        uses: actions/upload-artifact@v4
        with:
          name: screenshots
          path: tests/Browser/test-results/
```

## Acceptance Criteria

- [ ] Page objects encapsulate page interactions
- [ ] Tests run across Chrome, Firefox, and Safari
- [ ] Visual regression catches UI changes
- [ ] Mobile responsive tests verify layouts
- [ ] CI runs browser tests on every PR
- [ ] Failed tests capture screenshots and traces
- [ ] Auth helpers simplify login flows
- [ ] Custom assertions reduce test verbosity
- [ ] Test reports generate HTML summaries
- [ ] Snapshots update intentionally via CLI flag
