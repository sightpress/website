// Lighthouse budgets, as for SightPress itself: accessibility 100, SEO 100, best practices ≥ 95, performance ≥ 90.
// Serves public/ (or WEBSITE_ROOT) with PHP's built-in server and uses Playwright's Chromium.
import { spawn } from 'node:child_process';
import { mkdtempSync, rmSync } from 'node:fs';
import { tmpdir } from 'node:os';
import { join } from 'node:path';
import { chromium } from '@playwright/test';
import * as chromeLauncher from 'chrome-launcher';
import lighthouse from 'lighthouse';

const port = Number(process.env.WEBSITE_PORT ?? 8069);
const pages = ['/', '/about/', '/features/', '/faq/', '/blog/', '/accessibility/'];
const budgets = { accessibility: 1, seo: 1, 'best-practices': 0.95, performance: 0.9 };

const server = spawn('php', ['-S', `127.0.0.1:${port}`, '-t', process.env.WEBSITE_ROOT ?? 'public', 'tests/router.php'], { stdio: 'ignore' });
await new Promise((resolve) => setTimeout(resolve, 1000));
const profile = mkdtempSync(join(tmpdir(), 'website-lighthouse-'));
const chrome = await chromeLauncher.launch({ chromePath: chromium.executablePath(), userDataDir: profile, chromeFlags: ['--headless=new', '--no-sandbox'] });

let failed = false;
try {
  for (const path of pages) {
    const result = await lighthouse(`http://127.0.0.1:${port}${path}`, {
      port: chrome.port,
      output: 'json',
      onlyCategories: Object.keys(budgets),
      formFactor: 'mobile',
      // Canonical addresses point at https://sightpress.org, which is right for the live site but not for localhost.
      skipAudits: ['canonical', 'is-on-https', 'redirects-http', 'uses-http2'],
    });
    const scores = Object.fromEntries(Object.keys(budgets).map((id) => [id, result.lhr.categories[id].score]));
    const misses = Object.entries(budgets).filter(([id, min]) => scores[id] < min);
    console.log(`${misses.length ? '✗' : '✓'} ${path} ${JSON.stringify(scores)}`);
    for (const [id] of misses) {
      const audits = result.lhr.categories[id].auditRefs
        .map((ref) => result.lhr.audits[ref.id])
        .filter((audit) => audit.score !== null && audit.score < 1 && audit.scoreDisplayMode !== 'informative');
      for (const audit of audits) console.log(`    ${id}: ${audit.id} (${audit.score}) ${audit.title}`);
    }
    failed ||= misses.length > 0;
  }
} finally {
  await chrome.kill();
  server.kill();
  rmSync(profile, { recursive: true, force: true });
}
process.exit(failed ? 1 : 0);
