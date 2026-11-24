import { defineConfig, devices } from '@playwright/test';

// Serves public/ with PHP's built-in server; every page listed in public/sitemap.xml is tested.
const port = Number(process.env.WEBSITE_PORT ?? 8070);

export default defineConfig({
  testDir: 'tests',
  testMatch: '*.spec.ts',
  fullyParallel: true,
  forbidOnly: !!process.env.CI,
  retries: process.env.CI ? 1 : 0,
  reporter: process.env.CI ? [['list'], ['html', { open: 'never' }]] : 'list',
  use: {
    baseURL: `http://127.0.0.1:${port}`,
    trace: 'retain-on-failure',
  },
  projects: [{ name: 'chromium', use: { ...devices['Desktop Chrome'] } }],
  webServer: {
    command: `php -S 127.0.0.1:${port} -t public tests/router.php`,
    url: `http://127.0.0.1:${port}/`,
    reuseExistingServer: !process.env.CI,
  },
});
