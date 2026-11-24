import { readFileSync } from 'node:fs';
import { join } from 'node:path';

/** Every page in the sitemap, as a path, plus the 404 page. */
export function pages(): string[] {
  const root = process.env.WEBSITE_ROOT ?? join(__dirname, '..', 'public');
  const sitemap = readFileSync(`${root}/sitemap.xml`, 'utf8');
  const paths = [...sitemap.matchAll(/<loc>https:\/\/sightpress\.org([^<]*)<\/loc>/g)].map((m) => m[1]);
  return [...paths, '/404.html'];
}
