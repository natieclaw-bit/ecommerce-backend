import { chromium } from '@playwright/test';

const BASE_URL = process.env.APP_URL ?? 'http://127.0.0.1:8000';

const run = async () => {
  const browser = await chromium.launch();
  const page = await browser.newPage();
  await page.goto(`${BASE_URL}/admin/login`);
  await page.waitForSelector('input[name="email"]', { timeout: 10000 });
  await page.fill('input[name="email"]', 'admin@stockflow.test');
  await page.fill('input[name="password"]', 'password');
  await page.click('button[type="submit"]');
  await page.waitForURL(`${BASE_URL}/admin`, { timeout: 10000 });
  await page.waitForTimeout(500);
  await page.screenshot({ path: 'storage/app/public/admin-dashboard.png', fullPage: true });
  await browser.close();
};

run().catch((error) => {
  console.error(error);
  process.exit(1);
});
