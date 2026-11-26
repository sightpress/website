---
title: 'SightPress 0.4.0: themes you can choose and media without limits'
author: 'Pedro Ferreira'
section: Releases
tags:
  - release-notes
  - project-progress
  - themes
  - colour-and-contrast
  - accessible-content
  - admin-panel
status: published
published: '2026-11-24'
description: 'SightPress 0.4.0 lets you choose a theme for each site and change its colours, and handles large files, captions, transcripts and cloud storage.'
slug: sightpress-0-4-0-themes-and-media
image: /assets/articles/sightpress-0-4-0-themes-and-media.png
image_alt: 'SightPress logo. SightPress 0.4 is out! Themes you can choose and media without limits.'
canonical: 'https://sightpress.org/blog/sightpress-0-4-0-themes-and-media/'
---

# SightPress 0.4.0: themes you can choose and media without limits

By Pedro Ferreira

24 November 2026

SightPress 0.4.0 is out. It's about two things: how your website looks, and the pictures, videos and recordings you put on it. You can now choose a theme for each site and change its colours, and SightPress handles large files, captions, transcripts and cloud storage.

## What's new

### Choose a theme for each site

A new **Appearance** screen lists every installed theme, with its status in words and a picture of the theme with a description. If there's no picture, the screen describes the theme in words. **Preview** opens a sample page with every kind of block in that theme, so you can look before you change anything. Each site can use its own theme, and your pages and their content stay the same when you change it.

Themes are installed on the server by whoever runs SightPress, never uploaded through the website. That keeps your site safe.

### Change the colours, but never lose contrast

You can change a theme's colours for light and dark mode. SightPress checks every pair of colours that appear together. If a colour would be too hard to read, it's refused, and the message names the colours that clash and their contrast. What you typed is kept, so you can adjust it. Every theme goes through the same checks before it can be installed, and again before it's applied.

The admin panel keeps its own colours whatever you choose, so you can always find your way around.

### More page layouts

Besides the home page and standard layouts, pages can now use a **landing** layout, a **sidebar** layout that lists the other pages in the same section, and a **full width** layout for wide galleries and tables. On a narrow screen or when zoomed in, every layout becomes a single column. If you switch to a theme that lacks a layout, SightPress lists the pages affected before anything changes.

### Make your own theme

Developers can start a new theme from the theme template. It comes with the checks, the tests and a step-by-step tutorial, and the checks explain in words what needs fixing.

### Captions and transcripts

Videos can now have captions in each of your site's languages. SightPress checks each captions file and tells you which line to fix. Videos and recordings get a transcript that visitors open with a button under the player. A page with a video or recording can't be published until it has them.

If the AI assistant is on, it can add punctuation, paragraphs and speaker labels to a transcript. It can't change the words, and a person still checks the result against the recording before the page can be published.

### Upload large files, and carry on if they stop

Large files are now sent in small parts, with a progress bar that screen readers announce every 10%. You can pause, resume or cancel an upload. If your connection drops, or you close the page, you can carry on from where the upload stopped for up to a day. Each site can also have its own upload limits, and files too large for the browser can be imported from the server, with the same safety checks.

### Keep your files in the cloud, if you want to

A site can keep its files in cloud storage such as AWS S3 or Cloudflare R2, and let a content delivery network (CDN) send public files from near each visitor. Unpublished files and every file of a members-only site stay protected: their addresses stop working after a short time, so a shared link doesn't give them away. SightPress can set everything up at AWS or Cloudflare, and moves your files safely, checking each one.

All of this is optional. By default your files stay on your own server, and nothing goes to another company unless you choose to set it up. When you do, SightPress picks a location that matches the site's country: London for UK sites, and the EU for sites in Europe.

## What it isn't yet

SightPress is still an early release for trying out and testing, and running it on a public server isn't covered yet. The next release is about extending SightPress: modules from other developers, custom roles and optional text messages.

## Try it

The [SightPress documentation](https://docs.sightpress.org/) has new guides to changing a theme, choosing page layouts, adding captions and transcripts, uploading large files and keeping files in the cloud. There's also a tutorial for creating your own theme. The [0.4.0 release notes](https://github.com/sightpress/core/releases/tag/0.4.0) list every change.

If you design themes, or you rely on captions and transcripts, I'd love to hear how this release works for you.
