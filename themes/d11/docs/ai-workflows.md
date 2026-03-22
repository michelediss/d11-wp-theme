# AI Workflows

This document defines the shared rules for repository-local AI workflows in the current `d11` theme.

Use it as the common foundation for task-specific skills under `.agents/skills/`.

## Purpose

This file exists to keep workflow-specific skills small and specialized.

It centralizes the shared rules that every theme-aware AI workflow must follow:

- source-of-truth boundaries
- required theme documentation
- block usage and content sync constraints
- screenshot tooling availability
- documentation and skill-maintenance expectations

This file is not a complete implementation workflow for page generation or page review. Those flows belong in the dedicated skills that reference this document.

## Required Theme Documentation

When a task touches theme architecture, theme-owned page content, block composition, templates, parts, patterns, or local workflow tooling, read these files first:

- `docs/theme-overview.md`
- `docs/block/block-composition-guide.md`
- `docs/block/whitelisted-blocks-summary.md`

Read these additional files when the task scope requires them:

- `docs/block/block-availability-system.md` to understand how runtime availability is determined and which export is authoritative
- `docs/block/whitelisted-blocks.md` when a specific allowed block needs extended metadata, supports, attributes, or parent constraints
- `docs/content-sync.md` for theme-owned DB-to-filesystem page content sync
- `docs/screenshot-validation.md` for visual validation through the local screenshot CLI
- `docs/skill-sync.md` when repository-local skills are created, renamed, or updated

## Runtime And Documentation Boundaries

- Theme runtime code is authoritative when runtime behavior and docs disagree.
- Theme documentation under `docs/` is the canonical human-readable guide and must be updated when workflow conventions change.
- Theme-local skills under `.agents/skills/` are workflow wrappers. They must reference the canonical docs instead of duplicating them.
- Resolve theme identity from the active workspace instead of assuming hardcoded values for slug, text domain, prefixes, or theme root.

## Block And Artifact Rules

- Treat the runtime block availability export and whitelist artifacts as the source of truth for available blocks.
- Use `docs/block/whitelisted-blocks-summary.md` as the compact operational list of currently allowed blocks.
- Use `docs/block/whitelisted-blocks.md` only when you need technical detail for one block.
- Use `docs/block/block-composition-guide.md` for usage guidance, not for availability truth.
- Prefer synced page JSON under `content/` for editor-visible page bodies when the page is content-driven.
- Keep shared layout structure in `parts/` and `templates/`; keep reusable editorial sections in `patterns/` only when they are intentionally shared.
- Do not place translatable editorial copy directly in `templates/*.html` or `parts/*.html`.

## Content Sync Rules

- Treat the theme-owned content sync subsystem as the only supported DB-to-filesystem boundary for page content.
- Do not describe or implement raw `post_content` regex rewriting as a primary workflow.
- When a page template renders the page body with `post-content`, treat the synced JSON payload as the canonical owner of the page body.

## Screenshot Validation

The local screenshot CLI is available at:

```text
tools/review-screenshot/index.js
```

It is the shared visual validation tool for front-end page workflows.

Use screenshot validation according to workflow intent:

- `single-pass validation`: capture one final set of screenshots after a generation task or one-off change
- `baseline/verify review`: capture one set before a review correction pass and one set after it for explicit before/after comparison

The semantic distinction matters even if the screenshot CLI implementation evolves later.

## Documentation And Skill Maintenance

- Keep this file aligned with the real theme workflow conventions.
- Keep workflow-specific instructions inside the relevant skill, not here.
- When changing repository-local skills that must also exist in global skill directories, use the sync flow documented in `docs/skill-sync.md`.
- When changing the screenshot workflow expectations used by a skill, keep `docs/screenshot-validation.md` aligned with the actual local tooling.
