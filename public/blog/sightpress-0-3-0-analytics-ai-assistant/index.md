---
title: 'SightPress 0.3.0: private analytics and an AI assistant that only suggests'
author: 'Pedro Ferreira'
section: Releases
tags:
  - release-notes
  - project-progress
  - accessible-content
  - alt-text
  - multilingual
  - admin-panel
status: published
published: '2026-11-19'
description: 'SightPress 0.3.0 adds private analytics you can understand without seeing a chart, and an optional AI assistant that only suggests.'
slug: sightpress-0-3-0-analytics-ai-assistant
image: /assets/articles/sightpress-0-3-0-analytics-ai-assistant.png
image_alt: 'SightPress logo. SightPress 0.3 is out! Private analytics and an AI assistant that only suggests.'
canonical: 'https://sightpress.org/blog/sightpress-0-3-0-analytics-ai-assistant/'
---

# SightPress 0.3.0: private analytics and an AI assistant that only suggests

By Pedro Ferreira

19 November 2026

SightPress 0.3.0 is out, later on the same day as 0.2.0. It adds two features I've wanted from the start: analytics you can understand without seeing a chart, and an optional AI assistant that leaves every decision to you.

## What's new

### Analytics without cookies

SightPress now counts visits, popular pages, sources, searches and bots on your own server. It uses no cookies or tracking scripts and sends nothing to other companies. It never stores visitors' IP addresses or browser details, and it doesn't count people whose browser asks not to be tracked.

Every chart comes with a summary in words, such as "Visitors went up 12% compared with the previous 30 days", and the same data in a table. Lines differ by shape as well as colour, and any table can be downloaded as a CSV file. Analytics is on by default, and an admin can turn it off for a site.

### An optional AI assistant

The assistant is off for new sites. An admin can turn it on with their own key from Anthropic, OpenAI or Mistral, or connect any service or self-hosted server that works like OpenAI's. Keys are stored encrypted, and a monthly budget keeps costs under control.

Once it's on, the assistant can:

- answer questions about using SightPress, pointing only to screens you can use
- draft summaries, search descriptions, rewrites and whole pages
- explain a publishing check
- suggest image descriptions
- draft translations that keep a page's blocks and links

### A person always decides

Nothing the assistant writes is used until a person inserts it and saves. AI-written alt text and translations stay marked until someone has checked them, and a page that uses them can't be published before then. AI can be a real help for a blind creator, but it can also be confidently wrong about a picture, so the final word stays with a person.

### Clearer upload limits

SightPress now shows the largest file you can upload, warns admins about server settings that stop uploads, and explains what happened when a file is too large.

## What it isn't yet

SightPress is still an early release for trying out and testing, and running it on a public server isn't covered yet.

## Try it

The [SightPress documentation](https://docs.sightpress.org/) includes guides to reading your analytics and setting up the assistant, and the [0.3.0 release notes](https://github.com/sightpress/core/releases/tag/0.3.0) list every change.

If you try the charts with a screen reader, or the image descriptions on your own pictures, please tell me what worked and what didn't.
