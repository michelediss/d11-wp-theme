# AI Engine Skill

This repository-local skill keeps agents aligned with the canonical documentation of the active theme and, when relevant, with the integrated theme-owned content sync system.

## Purpose

Use `ai-engine` when a task depends on:

- `docs/theme-overview.md`
- `docs/block/block-availability-system.md`
- `docs/block/block-composition-guide.md`
- `docs/block/custom-blocks.md`
- `docs/content-sync.md`
- `docs/skill-sync.md`

The skill is intended for documentation-driven work, theme-aware AI workflows, and tasks that must stay consistent with the theme-owned DB-to-filesystem sync model.

## Source Of Truth

- Repository-local source: `wp-content/themes/d11/.agents/skills/ai-engine/`
- Main instructions: `SKILL.md`
- Skill metadata: `skill.yaml`

If this skill is changed and must also be available globally, sync it with:

```bash
wp-content/plugins/d11-engine-figma/scripts/sync-codex-skill.sh --skill ai-engine
```

To sync every repository-local skill in one run:

```bash
wp-content/plugins/d11-engine-figma/scripts/sync-codex-skill.sh --skill all
```

## Notes

- The repository copy is the source of truth.
- The sync script copies the whole skill directory, not just `SKILL.md`.
- Global runtime copies may live under `~/.codex/skills` and `~/.opencode/skills`.
