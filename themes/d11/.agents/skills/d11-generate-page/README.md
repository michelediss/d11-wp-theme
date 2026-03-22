# d11-generate-page

This repository-local skill handles one-page initial implementation work for the `d11` theme.

## Purpose

Use this skill when the task is to create a page from scratch or to produce the first substantial draft of a page implementation.

This skill depends on the shared workflow foundation in:

- `wp-content/themes/d11/docs/ai-workflows.md`

It also relies on the canonical theme docs under `docs/` for architecture, a compact whitelist of allowed blocks, and content sync.

## Output

The expected result is a draft or initial implementation, not a final iterative review pass.

## Source Of Truth

- Repository-local source: `wp-content/themes/d11/.agents/skills/d11-generate-page/`
- Main instructions: `SKILL.md`
- Skill metadata: `skill.yaml`

If this skill must also be available globally, sync it with:

```bash
wp-content/themes/d11/scripts/sync-codex-skill.sh --skill d11-generate-page
```
