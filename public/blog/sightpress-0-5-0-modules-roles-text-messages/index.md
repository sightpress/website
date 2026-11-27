---
title: 'SightPress 0.5.0: modules, your own roles and text messages'
author: 'Pedro Ferreira'
section: Releases
tags:
  - release-notes
  - project-progress
  - accounts-and-membership
  - sign-in-and-security
  - verification-codes
  - block-editor
  - accessible-content
status: published
published: '2026-11-27'
description: 'SightPress 0.5.0 adds modules from other developers, custom roles, organisation-only sign-up, optional text messages and two-step confirmation.'
slug: sightpress-0-5-0-modules-roles-text-messages
image: /assets/articles/sightpress-0-5-0-modules-roles-text-messages.png
image_alt: 'SightPress logo. SightPress 0.5 is out! Modules, your own roles and text messages.'
canonical: 'https://sightpress.org/blog/sightpress-0-5-0-modules-roles-text-messages/'
---

# SightPress 0.5.0: modules, your own roles and text messages

By Pedro Ferreira

27 November 2026

SightPress 0.5.0 is out. This release is about making SightPress fit your organisation: features from other developers, roles that match how your team works, sign-up limited to your own people, and optional text messages for sign-in and important changes. Nothing changes on your websites until you choose to set these up.

## What's new

### Add features with modules

Developers can now publish **modules** that add features to SightPress, such as an events calendar. Whoever runs SightPress installs a module once, and an admin turns it on only for the websites that need it. A module that is off leaves no trace on a website: no menu item, no block in the editor and no pages in the sitemap.

A broken or removed module never takes your websites down. The **Features** screen lists it as unavailable and says why in plain words, and every other website and feature keeps working. If you reinstall it, its data is still there.

### Build your own module

There's a new module template and a step-by-step tutorial. It builds a small events feature with an admin screen, a block, search results and structured data for search engines, and checks that it's accessible along the way. Modules only use the public module contract, so they keep working as SightPress changes.

### Make your own roles

The four built-in roles (admin, editor, contributor and member) don't fit every team. A new **Roles** screen lets admins create roles with exactly the permissions someone needs, such as "Events editor" or "Shop staff". Permissions are grouped by area, and each one says in plain English what it allows.

SightPress won't let you lock yourself out. It refuses to remove the last admin, to take away your own way back to the Roles screen, or to give risky permissions to people who sign themselves up, and it explains why.

### Keep websites to your organisation

If your organisation runs SightPress for its own teams, you can now allow only your own email addresses to join, and only your own domain names for websites. On members-only websites, colleagues can register with their work email without waiting for an invitation. They still confirm their address with a 6-digit code, as everywhere else in SightPress.

### Text messages, if you want them

Text messages are optional and off by default. They cost money and share phone numbers with another company, so SightPress only sends them once whoever runs it connects a provider (Twilio or Vonage to start with) and sets a monthly budget. Then people can:

- add their mobile number, checked with a 6-digit code;
- choose to get notifications by text, such as when a page waits for their review, and reply STOP at any time;
- sign in with their mobile number instead of their email address;
- reset a forgotten password with a code by text.

A text never contains a link, the content of your pages or a secret. Phone numbers are personal data, so they're shown in full only to their owner and to admins who manage people. SightPress also has limits to stop people running up your bill by sending codes to expensive numbers.

### Confirm important changes

A website can now ask for a code by text before important changes: giving someone a role, changing who can read the website, turning features on or off, deleting analytics data and more. A stolen password alone is then not enough to take over a website. Admins choose whether to ask for it, and whoever runs SightPress can make it required everywhere. If someone loses their phone, there's a guide for that too.

### Three new blocks, and a look for each block

- **Video or map from another site** shows a YouTube or Vimeo video, or an OpenStreetMap map. Nothing loads from the other site until the reader asks for it, so visitors aren't tracked just by opening your page.
- **List of pages** shows the pages in a section, or the latest changes, and keeps itself up to date. It never lists members-only pages to the public.
- **Sign language video** names the sign language it's in, and still needs captions for people who don't sign.

Each block can also have its own look: a background, a width, the space around it, and the layout of a form. SightPress checks every theme's colours, so text stays readable on every background.

## What it isn't yet

SightPress is still an early release for trying out and testing, and running it on a public server isn't covered yet. Text messages have so far been tested with simulated providers; tests with real provider accounts and real phones come next. Tools to download or delete someone's personal data are planned for a later release.

## Try it

The [SightPress documentation](https://docs.sightpress.org/) has new guides to adding a module, creating a custom role, keeping websites to your organisation, setting up text messages, signing in with your phone and confirming important changes. Developers can follow the new tutorial to create a module. The [0.5.0 release notes](https://github.com/sightpress/core/releases/tag/0.5.0) list every change.

If you build add-ons, or you run websites for an organisation, I'd love to hear how this release works for you.
