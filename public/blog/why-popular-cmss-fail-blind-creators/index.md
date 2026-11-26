---
title: 'Why WordPress and other popular CMSs still fail blind and low-vision creators'
author: 'Pedro Ferreira'
section: 'Comparisons and myths'
tags:
  - cms-comparison
  - blind-creators
  - low-vision
  - admin-panel
  - atag
  - retrofitting
  - mission
status: published
published: '2026-11-18'
description: "Popular CMSs can build accessible websites, but few let a blind or low-vision person run one on their own. Here's why."
slug: why-popular-cmss-fail-blind-creators
image: /assets/articles/why-popular-cmss-fail-blind-creators.jpg
image_alt: 'An eye doctor in a white coat points to a row of numbers on a sight-test chart hanging on a door, while a patient reads it.'
image_caption: 'A sight test. Most admin panels quietly set one too: they assume the person running the website can see it.'
image_credit: 'Photo by [CDC](https://unsplash.com/@cdc) on [Unsplash](https://unsplash.com/photos/a-woman-pointing-at-a-sign-on-a-door-cguXr4imkks)'
canonical: 'https://sightpress.org/blog/why-popular-cmss-fail-blind-creators/'
---

# Why WordPress and other popular CMSs still fail blind and low-vision creators

By Pedro Ferreira

18 November 2026

[Nearly four in ten websites run on WordPress](https://w3techs.com/technologies/details/cm-wordpress). Add Wix, Squarespace, Joomla, Drupal and the rest, and most of the web is built with a handful of content management systems. If you're blind or have low vision and you want to publish something, one of these is almost certainly what you'll be offered.

Most of them can produce an accessible website. Far fewer let a blind person build and run that website on their own. That gap is what this article is about.

## Two sides of every CMS

Every CMS has two faces. The public website is what visitors see. The admin panel is where someone writes the pages, uploads the images, fixes the menu and presses "Publish".

Most accessibility work in the CMS world goes into the public side, and that's understandable. That's where the law looks first, and it's where most people are. With a good theme, care and some expertise, WordPress, Drupal and the others can all produce pages that a screen reader user can read comfortably.

The admin panel gets much less attention. The unspoken assumption is that the person running the site can see it. For a blind charity worker, a partially sighted councillor or a small business owner losing their sight, that assumption decides whether they can do their job.

There's a standard for this side too, the [Authoring Tool Accessibility Guidelines (ATAG)](https://www.w3.org/TR/ATAG20/). It asks two things of a CMS: that its own interface is accessible, and that it helps authors produce accessible content. Hardly any mainstream CMS claims to meet it in full, and WordPress [states that it does not currently conform](https://wordpress.org/about/accessibility/).

## Built for the eye first

Modern editors are designed around looking. You see the page as it will appear, you drag a block where you want it, and you click a small icon to change it. For a sighted person this is quick and pleasant. With a screen reader it turns into a guessing game.

WordPress's block editor, Gutenberg, is the best-known example. Two months before it [shipped in December 2018](https://wordpress.org/news/2018/12/bebo/), the WordPress accessibility team lead, Rian Rietveld, [resigned, citing political complications and new features that weren't keyboard tested](https://rianrietveld.com/?p=2046) before they were implemented. In 2019 WPCampus [commissioned an independent accessibility audit](https://wpcampus.org/blog/2019/05/gutenberg-audit-results/) of the editor, [funded by community donations and Automattic](https://wptavern.com/wpcampus-selects-tenon-llc-for-wp-campus-gutenberg-accessibility-audit-completed-report-expected). It found ["significant and pervasive accessibility problems" (PDF, 1.6 MB)](https://documents.wpcampus.org/gutenberg/audit/Gutenberg_Executive_Summary.pdf), affecting blind, low-vision and motor-impaired users among others.

Things have improved since then, and the people working on WordPress accessibility deserve credit for that. But the editor's basic shape hasn't changed. It's still a visual canvas with floating toolbars, nested blocks and controls that appear and disappear depending on where your mouse or cursor is. To a screen reader user that means:

- toolbars that only exist while a block is selected, so you have to know they're there before you can find them;
- the same sort of block nested inside itself, with little to tell you which level you're on;
- settings tucked into sidebars, popovers and "more options" menus behind icons, in an admin where [missing labels were still being fixed in 2026](https://make.wordpress.org/core/2026/08/13/accessibility-improvements-in-wordpress-7-1/);
- moving content by drag and drop, with keyboard [alternatives](https://wordpress.org/documentation/article/moving-blocks/) that are easy to miss or hard to use.

Hosted builders like Wix and Squarespace lean even harder on the visual canvas. Their editors are built around dragging things around a design. Wix has added an [accessibility checker](https://support.wix.com/en/article/accessibility-using-the-accessibility-wizard), which is welcome, but both editors are still tools you mostly operate with your eyes.

## The plugin problem

Even when the core of a CMS is reasonably accessible, very few people use it on its own.

A typical WordPress site has a theme, a page builder, a forms plugin, an SEO plugin, a cookie banner, a gallery and a backup tool. Each comes from a different company, with its own screens, its own idea of a button and its own approach to accessibility, which is often none at all. Popular page builders replace the editor completely with an even more visual one.

So the question "Is WordPress accessible?" has no real answer. Your WordPress is a combination nobody has tested. One plugin update can put an unlabelled toggle on the screen you use every day, or a pop-up that takes your keyboard focus and never gives it back. Nothing in the system stops that happening, and nothing tells you it has.

Accessibility in these systems is something you can add. That also means it's something that can be left out.

## Low vision is its own problem

Blindness gets most of the attention, but many more people have low vision. They often use their remaining sight with magnification, high contrast or very large text, and different things break for them.

Admin panels are dense. They're full of small grey text, thin outlines and icons that only make sense at normal size. Zoom in to 300 or 400 percent and many of them fall apart. Sidebars cover the content, sticky toolbars hide the very text you're editing, and controls go off the edge of the screen. The media library, a grid of small thumbnails, is especially hard if you can only see part of the screen at once.

The Web Content Accessibility Guidelines (WCAG) 2.2, the current web accessibility standard, added rules for exactly these problems. For example, it says that the thing you're working on [must not be hidden behind sticky bars](https://www.w3.org/WAI/WCAG22/Understanding/focus-not-obscured-minimum.html), and that [every drag action needs a simple alternative](https://www.w3.org/WAI/WCAG22/Understanding/dragging-movements.html). Many admin panels were designed long before those rules existed.

## Retrofitting is the hardest way to do it

None of this happens because the people behind these systems don't care. Many of them care a great deal. The problem is history.

WordPress [started in 2003](https://wordpress.org/support/article/history/) as [blogging software](https://ma.tt/2003/01/the-blogging-software-dilemma/). Wix started as a visual site builder. Each decade added another layer: new editors, new frameworks, thousands of plugins and millions of sites that depend on all of it staying as it is. Making that admin panel truly accessible means redesigning its core interactions without breaking everything built on top. That's slow, expensive and politically difficult, so progress comes one bug fix at a time.

Retrofitting accessibility almost never catches up with the speed of new visual features. Every release adds new screens, and the accessibility work goes on chasing them.

## What a blind creator actually needs

The needs aren't exotic. A blind or low-vision person running a website needs:

- screens with real headings and landmarks, so they can jump around instead of listening to everything;
- every control labelled with words, not just an icon;
- everything possible with a keyboard, including reordering and moving content;
- clear spoken feedback when something is saved, fails or changes;
- layouts that still work at 400 percent zoom and in high-contrast modes;
- an editor that helps them write accessible content, such as prompting for image descriptions and checking the heading outline;
- the confidence that an add-on or update can't quietly take any of this away.

None of these is a nice-to-have. Each one decides whether a person can publish on their own or has to ask someone sighted for help.

## Starting from the other end

I'm a blind web developer, and this is why I'm building SightPress instead of filing more bug reports. [SightPress](https://sightpress.org) is a CMS for everyone, designed with blind and low-vision creators and audiences in mind. It is built on modern object-oriented PHP and released as free software under the GPL. It starts from the admin panel, not the public website. Accessibility is a floor that themes and modules can't lower. Every change is tested automatically, and every milestone is checked by ear with real screen readers.

The popular systems will keep improving, and I hope they do. But "you can make it accessible if you know how and choose the right plugins" isn't good enough for people who can't see the screen. Publishing on the web should work for them from the moment they first sign in.

Follow the development of [SightPress on GitHub](https://github.com/sightpress).
