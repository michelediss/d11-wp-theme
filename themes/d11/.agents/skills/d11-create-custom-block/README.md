# d11-create-custom-block

This repository-local skill handles one custom block implementation at a time for the `d11` theme.

## Purpose

Use this skill when the task is to create a new theme-owned custom block that must follow the canonical block standards, shared entrypoints, required documentation updates, and local build verification.

This skill depends on the shared workflow foundation in:

- `wp-content/themes/d11/docs/ai-workflows.md`

It also relies on the canonical theme docs under `docs/` for architecture, custom block standards, composition guidance, and skill sync.

## Output

The expected result is one implemented custom block plus the required shared entrypoint updates, documentation changes, and build verification.

## Source Of Truth

- Repository-local source: `wp-content/themes/d11/.agents/skills/d11-create-custom-block/`
- Main instructions: `SKILL.md`
- Skill metadata: `skill.yaml`

If this skill must also be available globally, sync it with:

```bash
wp-content/themes/d11/scripts/sync-codex-skill.sh --skill d11-create-custom-block
```
