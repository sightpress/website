---
title: "Going blind as a web developer: what changed and what didn't"
author: 'Pedro Ferreira'
section: 'Personal story'
tags:
  - personal-story
  - mission
  - screen-readers
  - blind-developers
  - assistive-technology
status: published
published: '2026-11-16'
description: 'How losing my sight changed the way I write code, what stayed the same, and why it led me to build SightPress.'
slug: going-blind-as-a-web-developer
image: /assets/articles/going-blind-as-a-web-developer.jpg
image_alt: "A developer's hands typing on a keyboard at night, in a dark room lit blue by a monitor showing code, with sticky notes and headphones on the desk."
image_caption: "Writing code at night. With a screen reader, what matters isn't how the screen looks but how well its content is structured."
image_credit: 'Photo by [Jakub Żerdzicki](https://unsplash.com/@jakubzerdzicki) on [Unsplash](https://unsplash.com/photos/hands-typing-on-a-keyboard-with-computer-screens-8ljjFxQFwKM)'
canonical: 'https://sightpress.org/blog/going-blind-as-a-web-developer/'
---

# Going blind as a web developer: what changed and what didn't

By Pedro Ferreira

16 November 2026

I was told I would go blind in 1995. It took almost thirty years to arrive. When it finally did, the tool that got me back to work was Windows Notepad.

## A blank page and a voice

Notepad has no syntax highlighting, no panels, no tabs and no icons. For a sighted developer it feels like a punishment. In 2024 it was the first screen that made sense to me again: a blank page, a cursor, and a voice reading back each line I typed.

It was not elegant code, and it was not fast. But it was code, written by me, without seeing it. Some months earlier I had quietly decided my working life was over. Sitting in front of that old friend, the one we all used back when the web was new, I started to suspect I had been wrong.

## What changed

The diagnosis was retinitis pigmentosa, a genetic condition that narrows your sight slowly over many years. For most of my career it was background noise. Then, at the start of 2024, reading from a screen became very hard, and ordinary life became noticeably harder to manage with the sight I had left. Six months later I realised it was gone.

### Reading in order

The biggest change is that you can no longer glance. A sighted person looks at a screen and takes in its shape in a fraction of a second: where the menu is, where the error is, which part matters. A screen reader gives you none of that. Everything arrives one item at a time, in the order someone else decided, and you have to build the picture in your head.

My first weeks with screen readers were genuinely stressful. The narration was hard to follow, and working out where I was on a page felt like navigating a building by touch with the lights off. I had spent decades scanning code and interfaces. Now I had to listen to them.

What helps you is structure. Proper headings let you jump through a document instead of wading through it. Labels tell you what a control does before you press it. When they are there, a screen reader is fast. When they are missing, it is like reading a book with the chapter titles torn out and every sentence in the same voice.

### Learning again, quickly

The second change surprised me: how quickly I adapted once I stopped waiting to feel ready. Notepad led to VS Code. VS Code led back to my favourite command-line tools, which turned out to be some of the most accessible software I own, because text in a terminal is just text.

Before long I was back alongside my colleagues at the insurance company where I still work, reviewing pull requests, fixing bugs and improving code. I'm proud of that, and I don't think I need to pretend otherwise.

## What didn't change

Here is the part that I didn't expect, and that people rarely believe at first: almost everything that made me a good engineer is still there.

I came up through web development from its early days to the present, through small agencies, telecoms and finance. Over those years I learned modern object-oriented programming, the SOLID principles, automated testing, and the discipline of CI/CD pipelines that won't let bad code through. None of that lived in my eyes.

My judgement about how a system should be shaped is the same. I still know when a class is doing too much, when an abstraction is hiding a problem instead of solving it, and when a quick fix will cost us later. My debugging instincts are the same: form a theory, test it, narrow it down. My taste for clean, well-named code is, if anything, stronger, because now I hear every badly named variable read aloud.

Code review works too. A diff is text. A failing test is text. A stack trace is text. Good tools present them in a sensible order, and I can work through them as well as I ever did.

So when I took stock, the conclusion was clear. The developer was fine. The tools were the problem.

## Where the tools fail

Code turned out to be the easy part. The web browser was the next challenge, and it was much harder.

Most of the sites I used to enjoy turned into a nightmare almost overnight. Social networks, which are mostly visual, I simply had to stop using. Reading Gmail in the browser became a slog. Even reading the news, something I had done every day of my adult life without thinking, became a fight with menus, pop-ups and unlabelled controls between me and the first paragraph.

Then I tried to do what so many people do on the web every day: create and edit content. That is where it stopped being an inconvenience and became a wall.

To a screen reader user, a typical content management admin screen sounds something like this: "Button. Button. Link. Graphic. Button. Button." Icons with no names. Toolbars you can only operate with a mouse. Drag-and-drop with no alternative. Dialogs that open without telling you, and leave you stranded somewhere behind them.

If you can see, you never notice any of this. If you can't, you can't publish. For most blind people I've spoken to, reading the web is hard, but adding to it is often impossible. That's a strange situation for a medium that was supposed to give everyone a voice.

## Why I decided to build

I could have written a long list of complaints and sent it to vendors. Plenty of people have, and plenty of those lists are still waiting for answers.

Instead I looked at what I had: decades of experience building for the web, a fresh and very personal understanding of where it fails, and the time and stubbornness to do something about it. So I decided to put my coding skills to work and build a new content management system from the ground up. Some weeks ago I started planning it: who it was for, what it had to do and what it must never do. It didn't even have a name yet.

The key word is "ground". I've learned that accessibility bolted on at the end never quite fits. It has to be the foundation, there from the first line of code, so that it can't be forgotten or switched off.

## Beyond sight

The name came on 1 November 2026, the day I registered sightpress.org. The result is SightPress: a CMS for everyone, designed with blind and low-vision creators and audiences in mind. It is built on modern object-oriented PHP and released as free software under the GPL. It should be just as beautiful and easy to use for sighted people, because good accessible design is simply good design.

I want it to be the first choice for charities, public bodies, small businesses and individuals who care about accessibility. Our motto is "Beyond sight."

Notepad gave me a blank page and a voice that told me where I was. That isn't a high bar, and every tool that lets people publish on the web should clear it.

Follow the development of [SightPress on GitHub](https://github.com/sightpress).
