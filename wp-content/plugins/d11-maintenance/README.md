# D11 Maintenance

`d11-maintenance` is the plugin that provides a maintenance mode consistent with the site itself, reusing Gutenberg content instead of switching to a disconnected technical placeholder page.

## Core idea

Even during maintenance, D11 stays inside its own compositional model.

Instead of showing an external maintenance screen:

- it uses a normal WordPress page
- it reuses that page's Gutenberg content
- it keeps visual and structural continuity with the rest of the site

## What it does

- enables a site-wide maintenance response
- renders the content of the page with slug `maintenance`
- returns HTTP `503` for public requests
- supports administrator access and a controlled bypass flow

## When it is useful

Use it when you want to:

- put a site into maintenance mode without breaking its visual identity
- let editors manage the maintenance message directly in Gutenberg
- avoid a separate hard-coded maintenance template outside the system

## Why it fits D11

In D11, even a maintenance page is treated as part of the observable output of the system:

- blocks
- content
- structure
- composition

It is not an isolated technical exception. It remains part of the same compositional universe as the rest of the site.
