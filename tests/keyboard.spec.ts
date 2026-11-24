import { expect, test } from '@playwright/test';

test('the main navigation marks the current page and works with the keyboard', async ({ page }) => {
  await page.goto('/');
  const nav = page.getByRole('navigation', { name: 'Main' });
  await expect(nav.getByRole('link', { name: 'Home' })).toHaveAttribute('aria-current', 'page');

  const features = nav.getByRole('link', { name: 'Features' });
  await features.focus();
  await expect(features).toBeFocused();
  await page.keyboard.press('Enter');
  await expect(page).toHaveURL(/\/features\/$/);
  await expect(page.getByRole('navigation', { name: 'Main' }).getByRole('link', { name: 'Features' })).toHaveAttribute('aria-current', 'page');
});

test('the colour scheme button is reachable by keyboard and remembers the choice', async ({ page }) => {
  await page.goto('/about/');
  const toggle = page.locator('#theme-toggle');
  await expect(toggle).toBeVisible();
  await expect(toggle).toHaveText('Switch to light theme');
  await toggle.focus();
  await page.keyboard.press('Enter');
  await expect(page.locator('html')).toHaveAttribute('data-color-scheme', 'light');
  await expect(toggle).toHaveText('Switch to dark theme');
  await page.reload();
  await expect(page.locator('html')).toHaveAttribute('data-color-scheme', 'light');
});

test('the pre-launch banner and the footer are on every kind of page', async ({ page }) => {
  for (const path of ['/', '/about/', '/features/', '/articles/', '/accessibility/', '/404.html']) {
    await page.goto(path);
    await expect(page.locator('.prelaunch')).toContainText('SightPress is in early development.');
    await expect(page.getByRole('navigation', { name: 'Footer' }).getByRole('link', { name: 'Accessibility statement' })).toBeVisible();
  }
});

test('old one-page links still land on a matching section', async ({ page }) => {
  await page.goto('/');
  for (const id of ['about', 'features', 'roadmap', 'creator', 'faq', 'share', 'contact']) {
    await expect(page.locator(`#${id}`)).toHaveCount(1);
  }
});

test('a missing page answers 404 with a helpful page', async ({ page }) => {
  const response = await page.goto('/no-such-page/');
  expect(response?.status()).toBe(404);
  await expect(page.getByRole('heading', { level: 1 })).toHaveText('Page not found');
});
