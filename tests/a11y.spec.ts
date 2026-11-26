import AxeBuilder from '@axe-core/playwright';
import { expect, test, type Page } from '@playwright/test';
import { pages } from './pages';

const WCAG = ['wcag2a', 'wcag2aa', 'wcag21a', 'wcag21aa', 'wcag22aa'];

async function setScheme(page: Page, scheme: 'light' | 'dark') {
  await page.addInitScript((value) => localStorage.setItem('sp-color-scheme', value), scheme);
}

async function expectNoViolations(page: Page) {
  const results = await new AxeBuilder({ page }).withTags(WCAG).analyze();
  const summary = results.violations.map((v) => `${v.id}: ${v.nodes.map((n) => n.target.join(' ')).join(', ')}`);
  expect(summary).toEqual([]);
}

for (const path of pages()) {
  test.describe(path, () => {
    for (const scheme of ['light', 'dark'] as const) {
      test(`no WCAG 2.2 AA violations in ${scheme} mode`, async ({ page }) => {
        await setScheme(page, scheme);
        await page.goto(path);
        await expect(page.locator('html')).toHaveAttribute('data-color-scheme', scheme);
        await expectNoViolations(page);
      });
    }

    test('reflows at 320 px (400% zoom) without sideways scrolling', async ({ page }) => {
      await page.setViewportSize({ width: 320, height: 640 });
      await page.goto(path);
      const overflow = await page.evaluate(() => document.documentElement.scrollWidth - document.documentElement.clientWidth);
      expect(overflow).toBeLessThanOrEqual(0);
      await expectNoViolations(page);
    });

    test('has one h1, landmarks and a working skip link', async ({ page }) => {
      await page.goto(path);
      await expect(page.locator('h1')).toHaveCount(1);
      await expect(page.locator('header.site-header')).toHaveCount(1);
      await expect(page.locator('main#main')).toHaveCount(1);
      await expect(page.locator('footer.site-footer')).toHaveCount(1);
      await page.keyboard.press('Tab');
      await expect(page.locator('.skip-link')).toBeFocused();
    });
  });
}

test('pages work without JavaScript, and the theme button stays hidden', async ({ browser }) => {
  const context = await browser.newContext({ javaScriptEnabled: false });
  const page = await context.newPage();
  await page.goto('/');
  await expect(page.locator('#theme-toggle')).toBeHidden();
  await expect(page.getByRole('navigation', { name: 'Main' }).getByRole('link', { name: 'Features' })).toBeVisible();
  await context.close();
});
