---
title: 'SightPress 0.1.0: the first usable version'
author: 'Pedro Ferreira'
section: Releases
tags:
  - release-notes
  - project-progress
  - admin-panel
  - block-editor
  - publishing-workflow
  - verification-codes
status: published
published: '2026-11-17'
description: 'SightPress 0.1.0 is out: the first version you can run on your own computer to create a website and publish pages.'
slug: sightpress-0-1-0-first-usable-version
image: /assets/articles/sightpress-0-1-0-first-usable-version.png
image_alt: 'SightPress logo. SightPress 0.1 is out! The first usable version.'
canonical: 'https://sightpress.org/blog/sightpress-0-1-0-first-usable-version/'
---

# SightPress 0.1.0: the first usable version

By Pedro Ferreira

17 November 2026

Two weeks ago I announced a plan with no code to download. Today, SightPress 0.1.0 is out, and you can run it on your own computer, create a website and publish pages.

SightPress is a powerful content management system for everyone, designed with blind and low-vision creators and audiences in mind. It's free software, written in modern, object-oriented PHP.

## What you can do

### Build pages from blocks

There are ten block types: heading, text, image, gallery, video, audio, file download, columns, call to action and contact form. Pages move from draft through review to published.

### Catch problems before publishing

SightPress checks each page before it goes live, including its image descriptions, link text, captions, transcripts and heading order. Accessibility errors stop the page from being published until they're fixed, and search engine issues appear as warnings.

### Work from an accessible admin panel

The admin panel covers pages, media, menus, people, site settings and branding. Upload progress is announced, and the menu shows only what your role can use. An audit log records who changed what.

### Sign in without risky links

Password resets and invitations use a six-digit code that you type on a page, never a link in an email. That's easier with a screen reader, and it gives people one less link to be tricked by.

### Run several sites

One installation can run several sites, each with its own people, pages and files. Each new site starts with ready-made pages and menus in the default theme, and SightPress checks that theme's colour contrast and base font size.

### Be found by people, search engines and AI

Every public page has its own title, description and structured data, and is listed in a sitemap. It's also available as Markdown for AI tools, and each site decides how AI crawlers may use its content.

## What it isn't yet

This is an early release for trying out and testing. The admin panel is in UK English only, and running SightPress on a public server isn't covered yet.

## Try it and tell me what breaks

The [SightPress documentation](https://docs.sightpress.org/) has a getting started guide for non-developers, and the [0.1.0 release notes](https://github.com/sightpress/core/releases/tag/0.1.0) list every change.

If you use a screen reader, a magnifier, a braille display, voice control or only a keyboard, I especially want to hear where SightPress gets in your way.
