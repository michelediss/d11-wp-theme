---
name: d11-create-custom-block
description: "Create one d11 custom block using the canonical theme block rules, shared block entrypoints, required documentation updates, and final build verification."
---

# d11-create-custom-block

Use this skill for one block at a time when the task is to add a new theme-owned custom block to the current `d11` theme.

## Required reading

Always read:

- `docs/ai-workflows.md`
- `docs/theme-overview.md`
- `docs/block/custom-blocks.md`
- `docs/block/block-composition-guide.md`
- `docs/block/whitelisted-blocks-summary.md`

Consult these when the task scope requires them:

- `docs/block/block-availability-system.md`
- `docs/block/whitelisted-blocks.md`
- `docs/skill-sync.md`

## What this skill does

- creates one custom block owned by the active theme
- follows the canonical block structure under `blocks/`, `src/js/blocks/`, and `src/css/blocks/`
- updates the shared block entrypoints so the new block is bundled correctly
- updates the required block documentation when the new block should be intentionally available to AI-assisted generation
- finishes with a minimum verification pass, including `npm run build`

## What this skill must not do

- do not create multiple custom blocks in one reasoning pass
- do not invent block naming, folder structure, or registration patterns that conflict with `docs/block/custom-blocks.md`
- do not hardcode theme identity assumptions when they can be resolved from the active theme
- do not manually add the block to the runtime allowlist unless there is an explicit exception in runtime code
- do not expose arbitrary visual editor controls when the requirement is not content-driven
- do not skip the required documentation updates when the block is meant to be used by AI-assisted composition
- do not leave the implementation unverified when a local build can confirm the bundle still compiles

## Workflow

1. Read the shared workflow foundation and canonical theme docs for architecture, custom block standards, and composition rules.
2. Resolve the current theme identity from the theme itself, including text domain and the existing naming conventions used by runtime code and assets.
3. Decide whether the block is static or dynamic, then create only the files that match that choice:
   - always `blocks/<slug>/block.json`
   - `blocks/<slug>/render.php` only for dynamic blocks
   - `src/js/blocks/<slug>/editor.js`
   - `src/js/blocks/<slug>/view.js` only when front-end behavior is actually needed
   - `src/css/blocks/<slug>.css`
4. Keep `block.json` as the source of truth for metadata and attributes, and keep attributes focused on content and behavior.
5. Register the new implementation through the shared entrypoints:
   - `src/js/blocks/editor.js`
   - `src/js/blocks/view.js` when the block has front-end JS
   - `src/css/blocks.css`
6. Use real previews in the editor when the block is dynamic, preferably with `ServerSideRender`.
7. Keep markup and styling aligned with theme rules:
   - use namespaced block-specific classes
   - use Tailwind tokens and utilities instead of Gutenberg design presets
   - avoid Bootstrap classes and legacy utilities
8. Update `docs/block/custom-blocks.md` and `docs/block/block-composition-guide.md` when the new block should be intentionally available to AI-assisted generation.
9. Run `npm run build` to verify that the theme bundles still compile with the new block included.
10. If this repository-local skill must also be available globally, sync it with the workflow documented in `docs/skill-sync.md`.

## Output contract

The output of this skill is one implemented custom block plus the required supporting updates.

The related report or handoff notes must include:

- whether the block is static or dynamic
- the main block files and shared entrypoints that were changed
- any documentation updates that were required
- any degradations, omissions, or follow-up work left intentionally out of scope

## Acceptance boundary

Stop when one custom block has been created in the correct theme-owned structure, the required shared entrypoints and docs are aligned, and the local build verifies the implementation without introducing new bundle errors.
