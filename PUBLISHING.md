# Publishing on sightpress.org

The website is a small static site. `bin/build` turns Twig templates (`src/templates/`) and Markdown articles into
HTML in `public/`, and the generated files are committed, so every change can be reviewed in the pull request. Amplify
publishes `public/` on every merge to `main`; there is no manual deploy step.

## Set up

You need PHP 8.4 or later and Composer.

```sh
composer install
bin/build            # build the site into public/
php -S localhost:8000 -t public tests/router.php   # preview it at http://localhost:8000
```

## Blog articles

The blog lives at `/blog/` (the old `/articles/` addresses redirect there). Article drafts are kept **outside** this
repository. By default the build reads them from `../articles` (a folder next to this one); pass another folder as an
argument: `bin/build path/to/articles`. Only articles marked `status: published` are built. For each one, the build
commits the page and a Markdown copy (`public/blog/<slug>/index.md`, with its front matter), and CI rebuilds the site
from those copies.

Each draft is a file named `YYYY-MM-DD-slug.md` that starts with front matter:

```yaml
---
section: Releases                 # one section from src/taxonomy.php
tags: [release-notes, themes]     # tags from src/taxonomy.php
status: draft                     # draft or published; only published articles are built
published: 2026-11-24             # optional; defaults to the date in the file name
updated: 2026-11-30               # optional; shown as "Updated" and used in the sitemap and feed
description: "One sentence, at most 160 characters, for search results and sharing."
slug: my-article                  # optional; defaults to the file name without the date
image: /assets/articles/my-article.jpg  # optional share image, 1200 × 630, PNG or JPEG, with image_alt
image_alt: "What the image shows."
image_caption: "Why the picture is here."  # optional; inline Markdown
image_credit: "Photo by [Name](https://unsplash.com/@name) on [Unsplash](https://unsplash.com/photos/…)"  # optional
copies:                           # optional; copies on other sites, each linking back here
  - https://dev.to/…
---

# The article title

By Pedro Ferreira

24 November 2026

The text…
```

Article images live in `public/assets/articles/`, named after the article's slug. An image with a caption or a
credit is also shown at the top of the article, with both under it; an image with neither (like the release cards) is
only used when the article is shared. Every word drawn in an image must also be in its `image_alt`.

- **Release announcements** get a card made from the brand colours and logo that says "SightPress x.y is out!" with
  the release's subtitle.
- **Other articles** get a free stock photo (for example from Unsplash, never an Unsplash+ photo), cropped to
  1200 × 630, with a caption that links it to the text and a credit naming the photographer and the source.

The first heading is the title. The "By …" and date lines under it are optional; the page shows the byline and dates
itself.

The build refuses to publish an article that:

- has no `description`, or one longer than 160 characters;
- uses a section or tag that isn't in `src/taxonomy.php` (add new terms there first, with the label readers see);
- has more or fewer than one main heading (`#`), or skips a heading level;
- has an image without alt text, or an `image` without `image_alt`;
- has link text that doesn't say where the link goes ("click here", "here", "read more" …), or a link to a PDF that
  doesn't say it's a PDF.

Drafts with these problems are listed as warnings, so you can fix them before publishing.

### Publish an article

1. In the drafts folder, set `status: published`, check `published:` and write the `description:`.
2. Run `bin/build`, then preview the page locally.
3. Commit `public/` on a branch, open a pull request and merge it. The merge deploys the site.
4. Copy the article to other sites with a canonical link back to sightpress.org, add their addresses under `copies:`,
   rebuild and merge again.

To see every draft as it would look, run `bin/build --include-drafts`. It writes to a temporary folder (never to
`public/`) and prints how to preview it.

### Unpublish an article

Set `status: draft` and rebuild: the build deletes the page, its Markdown copy and its feed entry. Amplify can't answer
`410 Gone`, so if people may still follow links to it, add a `301` redirect to `/blog/` in
`amplify/custom-rules.json` (above the last rule).

## Pages

- Home, About, Features, FAQ and the accessibility statement are templates in `src/templates/`.
- The FAQ's structured data is read from the rendered `faq.twig`, so add or change a question there only: each
  question is an `h2` followed by one `<p>` answer inside `<ul class="faq">`.
- Facts used on several pages (the latest release, what's in progress, contact addresses, the date each page last
  changed) live in `src/site.php`.
- After every SightPress feature release: update `release`, `releases` and `next` in `src/site.php`, the *Available
  now* and *In progress* sections of `src/templates/features.twig` (only claim what the release does, and link the
  matching guide), and the `pages` dates. `llms.txt`, the sitemap and the structured data follow from the build.

Never edit the generated files in `public/` by hand: `composer check` fails if they differ from a fresh build. The
hand-made files in `public/` (`assets/`, `brand/`, `en-gb/`, `favicon.ico`, `robots.txt`) are edited directly.

## Checks

| Command | What it checks |
|---|---|
| `composer check` | PHPStan, and that `public/` matches a fresh build |
| `npm ci && npx playwright test` | axe-core (WCAG 2.2 AA) on every page in light and dark mode and at 320 px, keyboard tests, the feed and heading links |
| `npm run lighthouse` | Lighthouse: accessibility 100, SEO 100, best practices ≥ 95, performance ≥ 90 |

CI also validates the HTML with the Nu HTML Checker and checks internal links with lychee on every pull request, and
external links every week. Before a new kind of page goes live, read it with NVDA and Firefox and with VoiceOver and
Safari, and note the result in the pull request.

## Hosting

The site is hosted on AWS Amplify, which builds nothing: `amplify.yml` tells it to publish `public/`. Redirect rules
and response headers (including the Content Security Policy) are kept in `amplify/` and applied by the `Amplify`
workflow when they change.
