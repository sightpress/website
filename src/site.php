<?php

declare(strict_types=1);

/*
 * Facts used across the website, in one place. Update `release` and `inProgress` after every feature release,
 * together with the Features page (see PUBLISHING.md).
 */
return [
    'name' => 'SightPress',
    'url' => 'https://sightpress.org',
    'motto' => 'Beyond sight.',
    'tagline' => 'A powerful CMS for everyone, designed with blind and low-vision creators and audiences in mind.',
    'description' => 'An accessible, open-source CMS for everyone, designed with blind and low-vision creators and audiences in mind.',
    'language' => 'en-GB',
    'locale' => 'en_GB',
    'email' => 'team@sightpress.org',
    'contributeEmail' => 'contribute@sightpress.org',
    'conductEmail' => 'conduct@sightpress.org',
    'securityEmail' => 'security@sightpress.org',
    'author' => 'Pedro Ferreira',
    'github' => 'https://github.com/sightpress',
    'docs' => 'https://docs.sightpress.org/',
    'docsLatest' => 'https://docs.sightpress.org/latest/',
    'community' => [
        'conduct' => 'https://github.com/sightpress/.github/blob/main/CODE_OF_CONDUCT.md',
        'contributing' => 'https://github.com/sightpress/.github/blob/main/CONTRIBUTING.md',
        'support' => 'https://github.com/sightpress/.github/blob/main/SUPPORT.md',
        'security' => 'https://github.com/sightpress/.github/blob/main/SECURITY.md',
        'issues' => 'https://github.com/sightpress/core/issues/new/choose',
    ],
    'shareImage' => [
        'path' => '/brand/social/sightpress-share-card-motto.png',
        'width' => 1200,
        'height' => 630,
        'alt' => 'SightPress logo. Beyond sight. A powerful CMS for everyone, designed with blind and low-vision creators and audiences in mind.',
    ],
    'shareText' => 'SightPress is a new, open-source CMS for everyone, designed with blind and low-vision creators and audiences in mind.',

    // The latest test release. Every claim on the Features page is checked against this version.
    'release' => [
        'version' => '0.4.0',
        'date' => '2026-11-24',
        'notes' => 'https://github.com/sightpress/core/releases/tag/0.4.0',
    ],
    // Every release so far, newest first, with one line each (shown on the home page).
    'releases' => [
        ['version' => '0.4.0', 'date' => '2026-11-24', 'summary' => 'Themes you can choose per site, captions and transcripts, large and resumable uploads, and optional cloud storage.'],
        ['version' => '0.3.0', 'date' => '2026-11-19', 'summary' => 'Private analytics with charts you can read in words and tables, and an optional AI assistant that only suggests.'],
        ['version' => '0.2.0', 'date' => '2026-11-19', 'summary' => 'Languages and translations, site search, members-only pages, older versions, scheduling and redirects.'],
        ['version' => '0.1.0', 'date' => '2026-11-17', 'summary' => 'The first usable version: build pages from blocks, publish checks, the admin panel and several sites in one installation.'],
    ],
    'next' => [
        'version' => '0.5.0',
        'summary' => 'Add-on modules from other developers, custom roles, email and domain rules, and optional text messages.',
    ],

    // Last content change of each hand-written page, for the sitemap and structured data.
    'pages' => [
        'home' => '2026-11-24',
        'about' => '2026-11-24',
        'features' => '2026-11-24',
        'accessibility' => '2026-11-24',
    ],
];
