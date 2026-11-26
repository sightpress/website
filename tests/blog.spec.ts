import { expect, test } from '@playwright/test';
import { pages } from './pages';

const articles = pages().filter((path) => /^\/blog\/(?!section\/|tag\/)[^/]+\/$/.test(path));

test('the blog feed is valid Atom', async ({ request }) => {
  const response = await request.get('/blog/feed.xml');
  expect(response.ok()).toBeTruthy();
  const body = await response.text();
  expect(body).toContain('<feed xmlns="http://www.w3.org/2005/Atom"');
  expect(body.match(/<entry>/g)?.length ?? 0).toBe(articles.length);
});

for (const path of articles) {
  test(`${path} heading links are keyboard reachable and named`, async ({ page }) => {
    await page.goto(path);
    const anchors = page.locator('.heading-anchor');
    const count = await anchors.count();
    for (let i = 0; i < count; i++) {
      const anchor = anchors.nth(i);
      await expect(anchor).toHaveAccessibleName(/^Link to this section: /);
      await anchor.focus();
      await expect(anchor).toBeFocused();
    }
    await expect(page.locator('link[rel="alternate"][type="text/markdown"]')).toHaveCount(1);
    const markdown = await page.request.get(`${path}index.md`);
    expect(markdown.ok()).toBeTruthy();
  });
}
