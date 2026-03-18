---
name: ai-engine
description: "Use this skill when a task depends on the canonical Markdown documentation of the current theme and its AI-assisted composition model. It loads and relies on `docs/theme-overview.md`, `docs/block/block-availability-system.md`, `docs/block/block-composition-guide.md`, `docs/block/custom-blocks.md`, and `docs/skill-sync.md`."
---

# AI Engine

Use this skill when the task must be grounded in the canonical theme documentation stored in `docs/`.

This skill's only specialization is that it must include, use, and know all Markdown files in `docs/`.

## Required files

Always read all of these files before acting:

- `docs/theme-overview.md`
- `docs/block/block-availability-system.md`
- `docs/block/block-composition-guide.md`
- `docs/block/custom-blocks.md`
- `docs/skill-sync.md`

Do not treat one of them as optional. This skill is only being used correctly when all five files are part of the working context.

When a task also touches `wp-content/plugins/cf7-sync`, additionally read:

- `wp-content/plugins/cf7-sync/README.md`

## Usage rules

- Treat `docs/theme-overview.md` as the architectural overview and maintenance guide.
- Treat `docs/block/block-availability-system.md` as the documentation of the runtime block availability system and allowlist behavior.
- Treat `docs/block/block-composition-guide.md` as the AI-facing guide to block usage and composition patterns.
- Treat `docs/block/custom-blocks.md` as the implementation standard for new custom blocks.
- Treat `docs/skill-sync.md` as the operational guide for keeping repository-local skills aligned with the global Codex skills directory.
- Treat `wp-content/plugins/cf7-sync/README.md` as the local operational reference for the CF7 sync plugin when the task involves that plugin.
- Resolve the current theme slug, text domain, and theme root from the active workspace instead of assuming fixed hardcoded values.
- When documentation and code appear inconsistent, call out the mismatch explicitly instead of silently choosing one.
- When changing theme behavior or conventions, update the affected file or files in `docs/` so the documentation remains canonical.

## Artifact Creation Rules

When the task involves creating or updating block-theme artifacts, do not stop at generic block validation. Apply block usage rules to the specific artifact type:

- For `patterns/`, treat patterns as the preferred place for reusable composed sections and for user-facing copy that must remain translatable. Use only blocks allowed by the runtime export and composition guide.
- For `parts/*.html`, treat parts as shared theme areas such as header, footer, hero, utility bars, or other globally reused sections. Prefer `core/template-part` composition and avoid hardcoded user-facing copy in the HTML file itself.
- For `templates/*.html`, treat templates as page-level or post-type-level skeletons that assemble shared parts, dynamic WordPress content, and layout structure. Prefer `template-part`, query/post blocks, and other dynamic blocks where content should come from WordPress data.
- Do not rebuild shared structural areas inline inside templates when they should be reusable theme parts or patterns.
- Do not place translatable editorial copy directly in `templates/*.html` or `parts/*.html`; prefer PHP-registered patterns or other translation-safe sources referenced by those files.
- For any pattern, part, or template task, derive allowed blocks from the runtime export and theme code, not from memory or from a stale static list.
- When a task proposes a block composition that is valid for a page but inappropriate for a shared theme artifact, call out that mismatch explicitly.

## When this skill applies

Use it for tasks such as:

- documenting or reviewing theme conventions
- creating or updating custom blocks according to theme rules
- validating whether a proposed template, pattern, or block uses allowed blocks
- updating AI skills or workflows that depend on theme documentation
- updating or validating repository-local Codex skill sync behavior
- documenting or changing the local `cf7-sync` plugin together with theme-adjacent workflows
- documenting interactions between this public repository and the separate private workflow plugin repository
- checking whether code changes remain aligned with documented architecture

Do not use this skill for generic WordPress work that does not depend on the theme documentation in `docs/`.
