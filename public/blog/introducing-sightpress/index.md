---
title: 'Introducing SightPress: a CMS for everyone, built from the ground up for accessibility'
author: 'Pedro Ferreira'
section: 'Behind the build'
tags:
  - mission
  - project-progress
  - blind-creators
  - low-vision
  - admin-panel
  - design-decisions
  - open-source
status: published
published: '2026-11-03'
description: "A blind web developer's plan for SightPress: a free, open-source CMS for everyone, built from the ground up for blind and low-vision creators."
slug: introducing-sightpress
image: /assets/articles/introducing-sightpress.jpg
image_alt: 'Close-up of two hands at a desk, one on a computer keyboard and one on a braille display, a device that shows the text on screen as a row of raised dots.'
image_caption: 'A braille display in front of a computer keyboard. Many blind people read and write with a display like this or a screen reader, or both.'
image_credit: 'Photo by [Compagnons](https://unsplash.com/@sigmund) on [Unsplash](https://unsplash.com/photos/person-using-braille-writer-4MoIpDcSlr4)'
canonical: 'https://sightpress.org/blog/introducing-sightpress/'
---

# Introducing SightPress: a CMS for everyone, built from the ground up for accessibility

By Pedro Ferreira

3 November 2026

I'm a blind web developer, and I can't comfortably run a website with most of the tools built for the job. For the past two months I have been planning something to fix that. On Sunday I registered its name.

SightPress is a powerful content management system for everyone, designed with blind and low-vision creators and audiences in mind. It will be written in modern, object-oriented PHP and released as free software under the GPL. Our motto is "Beyond sight."

There is no code to download yet. This article explains what I plan to build, why it should exist and what comes next.

## The problem

I lost my sight in 2024 to a genetic condition. With a screen reader, I went back to writing and reviewing code at work. Publishing on the web turned out to be much harder.

Many content management systems can produce a public website that a screen reader user can read. Far fewer let that same person build and run the website on their own. Their admin screens lean on small icons, drag and drop, floating toolbars and pop-ups that assume you can see what just changed.

That shuts out blind and low-vision people who want to write, and it causes problems for the organisations that employ them. A charity, a council or a small business can have an accessible website and still have an admin panel that one of its own staff can't use.

## The idea

SightPress starts from one rule: **accessibility is the floor, quality design is the goal, and neither is ever traded for the other.**

In practice, that means:

- Accessibility can't be switched off, by a setting, a theme or an add-on.
- Blind creators are treated as primary users of the admin panel, not as an edge case.
- The product should be just as clear and attractive for people who can see it. Good structure, plain language and sensible defaults help everyone.

## Major features

### An admin panel you can use without seeing it

The admin panel will be rendered on the server, with very little JavaScript, because plain and predictable pages work better with screen readers. Every task will work with a keyboard alone. Fields will have labels, errors will link to the field that needs fixing, and status changes will be announced. Move up and move down buttons will replace drag and drop.

Every admin task will also have a documented command-line equivalent, for people who prefer a terminal and as a fallback if a screen ever lets someone down.

### Publishing that helps you get it right

Pages are built from blocks such as headings, text, images, video, audio, downloads and forms. Before a page goes live, SightPress will check its heading order, image descriptions, video captions, audio transcripts and link text. Accessibility errors will block publishing until they're fixed, and search engine issues will appear as warnings.

Pages will move through a clear workflow from draft to review to published, with scheduling, revisions and text-based comparisons that don't rely on colour. If a page moves, its old address will keep working through an automatic redirect.

### Many sites and many languages

One installation will be able to run many sites. Each will have its own domains, database, file storage and users, so a group of charities or a web agency can keep them properly separate.

Every site can publish in any available language, including right-to-left languages and script variants such as Serbian in Cyrillic and Latin. The admin panel will start in UK English, followed by Portuguese, Spanish, French, Italian, German, Hebrew and Arabic.

### Themes that can't lower the floor

A theme will be able to change colours, typography, spacing and components, with dark mode, increased contrast and reduced motion supported. SightPress will check colour contrast and refuse a theme that fails. A theme can restyle a site, but it can't remove its accessibility features.

### Search and analytics, included

Every site will have an accessible search, with no outside service to pay for or configure.

The built-in analytics will use no cookies, tracking scripts or third parties. IP addresses won't be stored, and visitors can't be followed from one day to the next. Every chart will come with a plain-language summary and the same data in a table, so nobody needs to see a graph to understand how their site is doing. Site admins can turn either feature off.

### An optional AI assistant that never decides for you

If a site admin turns it on and adds a key from their chosen provider, an assistant will help with admin questions and draft text, summaries, image descriptions and translations. Self-hosted models will be supported too.

Everything it writes is a suggestion. A person reviews it, and the assistant can never publish, send or delete anything by itself. SightPress will never hold or resell a key.

### Found by people, search engines and AI

Pages will have clean, semantic HTML, complete metadata, structured data and sitemaps. Each public page will also be available as Markdown for AI tools, and site owners will decide whether AI crawlers can read their content.

### Open to extension

Every feature, including the core ones, will be built as a module using the same public contract. A third-party module will be able to do what a built-in one can, while working within the same accessibility rules.

## Why choose SightPress

- **Blind and low-vision creators** can publish on their own, without asking a sighted colleague to finish the job.
- **Charities, public bodies and schools** get a strong starting point for their accessibility duties, with WCAG 2.2 AA as the minimum target. No software can make an organisation compliant by itself, but the right tool can make it much easier to stay on track.
- **Small businesses and individuals** get search, analytics, languages and accessible design without assembling a stack of plugins.
- **Readers** get pages that work with screen readers, magnifiers, braille displays, voice control and keyboards.
- **PHP developers** get a modern, strictly typed codebase with automated tests and a clear way to extend it.
- **Everyone** keeps control of their data. SightPress won't send usage data back to the project, and the code will be open for anyone to inspect.

## How it will be built

I've learned the hard way that accessibility added at the end never quite fits, so the checks start with the first feature. Every change will go through automated tests and accessibility scans. Automated tools catch only part of the problem, so every milestone will also be tested by ear with real screen readers.

## What comes next

Planning is nearly finished, and the build starts now. I'm working towards version 1.0 in these stages:

1. **Foundations:** the code repositories, automated checks and module contract.
2. **First usable version:** sites, users and roles, pages and blocks, the publishing workflow, the admin panel, a default theme and the full accessibility and search baseline.
3. **Content and languages:** translations, page trees, members-only sites, site search, analytics and the AI assistant.
4. **Themes and media:** installable themes, cloud storage, content delivery networks, captions and transcripts.
5. **Extensibility:** third-party modules, custom roles and organisation-wide policies.
6. **Hardening:** a security audit, privacy and GDPR tools, performance work, full documentation and a complete screen reader audit.
7. **Version 1.0:** a stable public interface for developers and a documentation site.

After 1.0, the first planned add-on is a WordPress importer, so that moving an existing site doesn't mean starting again.

SightPress is based in the UK, so UK English and UK law come first. After that, I plan to roll out to the EU and its neighbouring countries, the Americas, Israel and then the rest of the world.

## Come along

I'd especially like to hear from blind and low-vision people who publish on the web, or who have given up trying. Tell me which tasks stop you. Testers, translators, designers, developers and organisations with real accessibility needs will all be welcome as the project grows.

You can find the project at [sightpress.org](https://sightpress.org), and the code will appear on [the SightPress GitHub organisation](https://github.com/sightpress) as the work begins.

The web was supposed to give everyone a voice. I'm building SightPress so that more of us can use it.
