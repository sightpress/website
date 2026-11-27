---
title: 'The accessibility rules that matter to blind and low-vision people, and why they matter to everyone'
author: 'Pedro Ferreira'
section: 'Accessible content'
tags:
  - accessible-content
  - screen-readers
  - low-vision
  - assistive-technology
  - colour-and-contrast
  - headings-and-links
  - alt-text
  - mission
status: published
published: '2026-11-27'
description: 'A plain-English guide to the web accessibility rules that matter most to blind and low-vision people, and why they make the web better for everyone.'
slug: accessibility-rules-for-blind-and-low-vision-users
image: /assets/articles/accessibility-rules-for-blind-and-low-vision-users.jpg
image_alt: 'A pedestrian crossing seen from ground level. A strip of raised tactile tiles runs straight across the middle of the painted white stripes and into the distance.'
image_caption: 'Tactile paving across a crossing in Tokyo. Rules for blind people are guides that everyone walks on.'
image_credit: 'Photo by [Josip Ivanković](https://unsplash.com/@piak) on [Unsplash](https://unsplash.com/photos/a-close-up-of-a-crosswalk-with-a-tactile-paving-strip-rUumOXGZ8jc)'
canonical: 'https://sightpress.org/blog/accessibility-rules-for-blind-and-low-vision-users/'
---

# The accessibility rules that matter to blind and low-vision people, and why they matter to everyone

By Pedro Ferreira

27 November 2026

In 1967, a Japanese inventor called Seiichi Miyake laid the first tactile paving tiles on a street in Okayama, near a school for the blind. Today you'll find those raised bumps and bars at almost every station platform and pedestrian crossing. Blind people use them to find the edge. Everyone else uses them too, mostly without noticing: they're the reason you slow down before the platform edge while looking at your phone.

The web has its own tactile paving. It's a set of rules, standards and habits that let blind and low-vision people find their way around a page. This article summarises the ones that matter most, in plain English, and explains why they aren't a favour to a small group. They make the web work better for all of us.

## Who we're talking about

According to the [World Health Organization's fact sheet on blindness and vision impairment](https://www.who.int/news-room/fact-sheets/detail/blindness-and-visual-impairment), at least 2.2 billion people worldwide have a near or distance vision impairment. That's more than one person in four.

Only some of them are blind. Many more have low vision: they use their remaining sight with magnification, high contrast, large text or a mix of all three. Others have colour vision deficiency, cataracts, glaucoma, macular degeneration, or simply eyes that have got older. Most of us will join this group at some point if we live long enough.

People with sight loss use the web with different tools:

- **Screen readers** such as JAWS, NVDA, VoiceOver, TalkBack and Narrator read the page aloud or send it to a **braille display**. Their users usually move with the keyboard or with gestures, jumping between headings, links, form fields and landmarks.
- **Screen magnifiers**, including the ones built into Windows, macOS, iOS and Android, enlarge part of the screen. The user sees only a small window of the page at once.
- **Browser and system settings** change the zoom, the text size, the colours, or switch to a high-contrast or dark theme.

Every rule below exists because one of these tools needs something from the page to work.

## The main rulebook: WCAG 2.2

The [Web Content Accessibility Guidelines (WCAG) 2.2](https://www.w3.org/TR/WCAG22/) are the standard almost every law points to. They're published by the W3C, the body that also looks after HTML and CSS. WCAG is built on four principles: content must be **perceivable**, **operable**, **understandable** and **robust**. Each rule, called a success criterion, has a level: A (the minimum), AA (the level the law usually asks for) and AAA (the highest).

Here are the criteria that make the biggest difference to blind and low-vision people, grouped by what they do.

### Give every image and control a meaning in words

- **Text alternatives** ([1.1.1 Non-text content](https://www.w3.org/WAI/WCAG22/Understanding/non-text-content.html)). Every meaningful image needs alt text that says what it shows or does. A screen reader can't describe a photo it can't see. Decorative images should be marked as decorative so they're skipped.
- **Names for controls** ([4.1.2 Name, role, value](https://www.w3.org/WAI/WCAG22/Understanding/name-role-value.html)). A button that shows only a magnifying glass icon must still be called "Search" in the code. Otherwise a screen reader announces "button" and nothing else.
- **Labels on form fields** ([3.3.2 Labels or instructions](https://www.w3.org/WAI/WCAG22/Understanding/labels-or-instructions.html)). Every field needs a label tied to it, not just grey placeholder text that disappears when you start typing.

### Build the page with real structure

- **Structure in the code, not just the look** ([1.3.1 Info and relationships](https://www.w3.org/WAI/WCAG22/Understanding/info-and-relationships.html)). Headings must be real headings, lists real lists and tables real tables. Making text big and bold isn't enough. Screen reader users navigate by headings more than by anything else, so a page with good headings is a page they can skim.
- **A meaningful order** ([1.3.2 Meaningful sequence](https://www.w3.org/WAI/WCAG22/Understanding/meaningful-sequence.html)). The order in the code should match the order that makes sense when read aloud.
- **Page titles and language** ([2.4.2 Page titled](https://www.w3.org/WAI/WCAG22/Understanding/page-titled.html) and [3.1.1 Language of page](https://www.w3.org/WAI/WCAG22/Understanding/language-of-page.html)). The title is the first thing a screen reader announces. The language tells it which voice and pronunciation to use, so English isn't read with a French accent.
- **Links that make sense on their own** ([2.4.4 Link purpose](https://www.w3.org/WAI/WCAG22/Understanding/link-purpose-in-context.html)). Screen reader users often pull up a list of all the links on a page. Ten links called "click here" are useless in that list.

### Don't rely on sight alone

- **Not by colour alone** ([1.4.1 Use of colour](https://www.w3.org/WAI/WCAG22/Understanding/use-of-color.html)). A red border on its own doesn't tell a colour-blind person or a screen reader user that a field has an error. Add words or an icon with a text label.
- **Not by shape or position alone** ([1.3.3 Sensory characteristics](https://www.w3.org/WAI/WCAG22/Understanding/sensory-characteristics.html)). "Press the round button on the right" means nothing if you can't see the screen.
- **Announce changes** ([4.1.3 Status messages](https://www.w3.org/WAI/WCAG22/Understanding/status-messages.html)). When a message such as "Saved" or "3 results found" appears without the page reloading, a screen reader must be told about it.
- **Describe what matters in videos** ([1.2.5 Audio description](https://www.w3.org/WAI/WCAG22/Understanding/audio-description-prerecorded.html)). If a video shows important information that nobody says out loud, blind viewers need it described.

### Make it readable for people with low vision

- **Contrast** ([1.4.3 Contrast (minimum)](https://www.w3.org/WAI/WCAG22/Understanding/contrast-minimum.html)). Normal text needs a contrast ratio of at least 4.5 to 1 against its background, and large text at least 3 to 1. Icons, input borders and focus outlines need at least 3 to 1 ([1.4.11 Non-text contrast](https://www.w3.org/WAI/WCAG22/Understanding/non-text-contrast.html)).
- **Text that can grow** ([1.4.4 Resize text](https://www.w3.org/WAI/WCAG22/Understanding/resize-text.html)). Text must still work at 200 percent of its size without anything being cut off.
- **Layouts that reflow** ([1.4.10 Reflow](https://www.w3.org/WAI/WCAG22/Understanding/reflow.html)). At a width of 320 CSS pixels, which is roughly what 400 percent zoom looks like on a laptop, the page should fit in one column without scrolling sideways to read each line.
- **Room to breathe** ([1.4.12 Text spacing](https://www.w3.org/WAI/WCAG22/Understanding/text-spacing.html)). If someone increases the spacing between lines, words and letters to make text easier to read, nothing should overlap or disappear.
- **No hidden focus** ([2.4.11 Focus not obscured](https://www.w3.org/WAI/WCAG22/Understanding/focus-not-obscured-minimum.html)). Sticky headers and cookie banners mustn't cover the thing you're working on. For someone using a magnifier, that may be the only part of the page they can see.

### Make everything work from the keyboard

- **Keyboard access** ([2.1.1 Keyboard](https://www.w3.org/WAI/WCAG22/Understanding/keyboard.html)). Blind people rarely use a mouse. Everything a mouse can do, a keyboard must be able to do as well, and focus must never get trapped ([2.1.2 No keyboard trap](https://www.w3.org/WAI/WCAG22/Understanding/no-keyboard-trap.html)).
- **Visible focus** ([2.4.7 Focus visible](https://www.w3.org/WAI/WCAG22/Understanding/focus-visible.html)). Low-vision keyboard users need a clear outline showing where they are.
- **A logical focus order** ([2.4.3 Focus order](https://www.w3.org/WAI/WCAG22/Understanding/focus-order.html)) and a way to **skip repeated menus** ([2.4.1 Bypass blocks](https://www.w3.org/WAI/WCAG22/Understanding/bypass-blocks.html)), so nobody has to listen to the whole navigation on every page.
- **Sign-in without puzzles** ([3.3.8 Accessible authentication](https://www.w3.org/WAI/WCAG22/Understanding/accessible-authentication-minimum.html)). New in WCAG 2.2: you mustn't have to solve a visual puzzle or retype a code from memory to sign in, and pasting passwords must be allowed. That helps blind users and everyone who uses a password manager.

## The protocols behind the scenes

WCAG says what the result must be. A few other standards explain how it actually reaches a blind person.

**The accessibility tree.** Browsers turn every page into a simplified tree of objects, each with a name, a role (button, link, heading) and a state (checked, expanded). Operating systems pass that tree to screen readers and magnifiers through their own accessibility interfaces. A screen reader never "sees" your design. It only gets that tree. If something isn't in it, for a blind user it doesn't exist.

**Semantic HTML.** The simplest and most reliable way to fill that tree correctly is to use the right HTML element: `<button>` for buttons, `<a>` for links, `<h2>` for headings, `<label>` for labels, `<nav>` and `<main>` for regions. They come with keyboard support and the right roles for free.

**WAI-ARIA.** When HTML has no suitable element, for example for tabs or a live notification area, [WAI-ARIA](https://www.w3.org/TR/wai-aria-1.2/) adds roles, states and properties to fill the gap. The [ARIA Authoring Practices Guide](https://www.w3.org/WAI/ARIA/apg/) shows how common widgets should behave from the keyboard. But the [first rule of ARIA](https://www.w3.org/TR/using-aria/#rule1) is not to use it when a native HTML element will do. Badly used ARIA is worse than none, because it tells the screen reader something untrue.

**ATAG for the tools we publish with.** The [Authoring Tool Accessibility Guidelines (ATAG) 2.0](https://www.w3.org/TR/ATAG20/) cover content management systems, editors and site builders. They ask two things: the tool itself must be accessible to authors with disabilities, and it must help every author produce accessible content, for example by prompting for alt text.

## What the law says

In most of the places where SightPress will be used, these rules aren't optional.

- **United Kingdom.** The Equality Act 2010 requires service providers to make reasonable adjustments for disabled people. Public sector websites must also meet [the public sector accessibility regulations](https://www.gov.uk/guidance/accessibility-requirements-for-public-sector-websites-and-apps), which are checked against WCAG 2.2 AA and require an accessibility statement.
- **European Union.** The [European Accessibility Act](https://eur-lex.europa.eu/eli/dir/2019/882/oj) has applied since 28 June 2025 to many private services, including online shops, banking and e-books. Public bodies were already covered by the Web Accessibility Directive. Both rely on the European standard EN 301 549, which includes WCAG.
- **The Americas.** In the United States, the Americans with Disabilities Act and Section 508 cover websites, and Ontario in Canada has the AODA. Both point to WCAG.
- **Israel.** The accessibility regulations rely on the Israeli standard IS 5568, which is also based on WCAG.

The law gives the rules teeth, but it isn't the best reason to follow them.

## Why these rules matter to everybody

### Because the web is still failing

Every year, WebAIM tests the home pages of the top million websites. Its [2026 WebAIM Million report](https://webaim.org/projects/million/) found detectable WCAG failures on 95.9 percent of them, with an average of 56.1 errors per page. The most common problems are exactly the ones in this article: low-contrast text on 83.9 percent of home pages, missing alt text on 53.1 percent, unlabelled form fields on 51 percent and empty links on 46.3 percent. And automated tools only catch part of what's wrong.

Each of those errors is a door that's locked for someone who can't see it.

### Because the same rules help in everyday life

[Microsoft's inclusive design toolkit](https://inclusive.microsoft.design/) describes disability as a spectrum, not a fixed group. For sight, it gives three examples of the same need: someone who is blind (permanent), someone with cataracts (temporary) and a distracted driver (situational). Design for the first and you help all three.

Look again at the rules above:

- **Good contrast** helps anyone reading a phone in bright sunlight or on a cheap, dim screen.
- **Text that resizes and reflows** helps everyone over 45 who has started holding their phone further away.
- **Clear headings and descriptive links** help everyone who skims, which is most of us, most of the time.
- **Alt text** shows up when images fail to load on a slow connection, and helps search engines understand your page.
- **Keyboard access** helps power users, people with a broken wrist and anyone whose trackpad has just died.
- **Captions and audio description** help people watching on a noisy train or listening with the screen off.
- **Accessible sign-in** helps everyone who uses a password manager, and reduces the number of people locked out of their account.

This is often called the [curb-cut effect](https://ssir.org/articles/entry/the_curb_cut_effect): dropped kerbs were fought for by wheelchair users, and are now used every day by parents with buggies, travellers with suitcases and delivery workers with trolleys. Tactile paving is the same story for blind people.

### Because almost everyone will need them one day

Sight changes with age for nearly everyone. Most people who live long enough will need reading glasses, many will develop cataracts, and some will lose much more. An accessible website isn't only for "them". It's for your parents now and for you later.

### Because it's simply better work

Accessible pages tend to be cleaner, faster and easier to maintain. They work better with search engines, voice assistants and AI tools, which all depend on the same structure a screen reader does. Accessibility isn't a coat of paint added at the end. It's what good engineering looks like.

## Where to start

You don't need to memorise every criterion. If you publish on the web, start with these habits:

1. Write meaningful alt text for every image that carries information.
2. Use real headings, in order, and make every link describe where it goes.
3. Check your colours with a contrast checker.
4. Zoom your page to 400 percent and see whether it still works.
5. Put your mouse away and try to use your site with only the keyboard.
6. Switch on the screen reader built into your phone or computer and listen to your own page for five minutes.

That last one is the most eye-opening of all, if you'll forgive the phrase.

## Why SightPress builds on these rules

I'm a blind web developer, and I depend on every one of these rules to do my job. That's why [SightPress](https://sightpress.org) treats them as a floor that nothing can lower. It's a CMS for everyone, designed with blind and low-vision creators and audiences in mind. Its own admin panel aims to meet WCAG 2.2 AA and ATAG, and it helps authors get alt text, headings and links right while they write, so that following the rules is the easy path, not the hard one.

Tactile paving didn't make streets worse for sighted people. It made them safer for everyone. The web can work the same way.

Follow the development of [SightPress on GitHub](https://github.com/sightpress).
