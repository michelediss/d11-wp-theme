# d11-review-page

This repository-local skill handles one-page iterative review and correction work for the `d11` theme.

## Purpose

Use this skill when the page already exists and the goal is to review it, apply one controlled correction pass, and validate the outcome with before-and-after screenshots.

This skill depends on the shared workflow foundation in:

- `wp-content/themes/d11/docs/ai-workflows.md`

It also relies on the canonical theme docs under `docs/` for architecture, a compact whitelist of allowed blocks, content sync, and screenshot validation.

Screenshots remain the primary review artifact. Direct Playwright MCP inspection is allowed only as a scoped fallback when the screenshots do not explain a defect clearly enough.

## Output

The expected result is a reviewed page with explicit screenshot artifacts for:

- `baseline`
- `verify`

This skill is intentionally separate from initial generation and from future Lighthouse optimization work.

## Source Of Truth

- Repository-local source: `wp-content/themes/d11/.agents/skills/d11-review-page/`
- Main instructions: `SKILL.md`
- Skill metadata: `skill.yaml`

If this skill must also be available globally, sync it with:

```bash
wp-content/themes/d11/scripts/sync-codex-skill.sh --skill d11-review-page
```
