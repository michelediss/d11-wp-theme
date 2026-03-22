# Custom Blocks Standard

This theme registers custom blocks from `blocks/*/block.json` and uses shared assets managed by Vite.

## Core Rules

- The block slug must always be `custom/<block-name>`.
- Each block must live in `blocks/<block-name>/`.
- `block.json` is the source of truth for block metadata.
- If the block is dynamic, it must include `render.php` in the same directory.
- The block must use namespaced CSS classes with a block-specific prefix, for example `.wp-block-custom-social-share` and `.social-share__button`.
- Visual styling must come from Tailwind tokens and utilities, not from Gutenberg color, typography, border, or shadow presets.
- Keep block attributes focused on content and behavior. Do not add editor-facing design controls unless the requirement is explicitly content-driven.
- Do not use Bootstrap classes or legacy utilities in block markup.
- Do not register theme-owned custom blocks inside plugins.

## Standard Structure

For a `custom/example-block` block:

```text
blocks/example-block/block.json
blocks/example-block/render.php
src/js/blocks/example-block/editor.js
src/js/blocks/example-block/view.js
src/css/blocks/example-block.css
```

Shared entrypoints:

```text
src/js/blocks/editor.js
src/js/blocks/view.js
src/css/blocks.css
```

## How To Add a New Block

1. Create `blocks/<slug>/block.json`.
2. If the block is dynamic, create `blocks/<slug>/render.php`.
3. Create `src/js/blocks/<slug>/editor.js` and register the block with `registerBlockType`.
4. Create `src/js/blocks/<slug>/view.js` for front-end behavior, only if needed.
5. Create `src/css/blocks/<slug>.css` with namespaced selectors.
6. Import the new files into:
   - `src/js/blocks/editor.js`
   - `src/js/blocks/view.js` if front-end JS exists
   - `src/css/blocks.css`
7. Run `npm run build`.

## Editor Conventions

- The editor should prefer real previews with `ServerSideRender` for dynamic blocks.
- Block attributes must be declared in `block.json`.
- Editor JS may redefine metadata useful at runtime, but the slug must match `block.json`.
- Prefer `window.wp.*` in editor modules, consistently with the theme's current pipeline.
- Editor controls should avoid exposing arbitrary visual choices. Prefer a fixed preview plus content-oriented settings.
- Any user-facing label, description, help text, or placeholder in block metadata, editor JS, render PHP, or front-end JS must be wrapped with the text domain declared in `style.css` so it can be extracted into `languages/`. In this repository that value is `d11`.
- If a front-end block script uses `wp.i18n`, ensure its registered script handle receives `wp_set_script_translations()`.

## Registration And Whitelist

- Automatic registration happens in `inc/blocks.php`.
- The theme block whitelist automatically includes custom blocks discovered from `block.json`.
- Do not manually add a new custom block to `partials/block-availability.php` unless there is an explicit exception.
- Always update `docs/block/block-composition-guide.md` when adding a new custom block so AI-assisted template generation can use it intentionally.
- Do not duplicate runtime logic in that file: document availability and usage rules only.
- External workflow skills should discover custom block availability from runtime exports or whitelist artifacts, then use this document only for implementation standards and usage constraints.

## Minimum Checklist

- The block appears in the inserter.
- The block is registered with the slug `custom/<name>`.
- The editor preview works without JS errors.
- The front-end markup works without plugin dependencies.
- `npm run build` passes.
- The block CSS does not break other blocks.
