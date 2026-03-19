# Skill Sync

This document explains how to sync repository-local skills to the global Codex and OpenCode skills directories in the current workspace.

## Purpose

Some environments discover available skills from global directories instead of using only the repository copy.

This workspace provides a sync utility so the repository version of each skill remains the source of truth and can then be copied into the global runtime directories when needed.

## Script

The sync script is:

```text
wp-content/plugins/d11-engine-figma/scripts/sync-codex-skill.sh
```

## What It Does

- copies one skill directory from a repository-local source root
- writes it into one or more target skills roots
- removes files in the target that no longer exist in the source when `rsync` is available
- validates that the source skill exists and contains `SKILL.md`
- warns when optional companion files such as `skill.yaml` or `README.md` are missing

## Default Paths

- source root: `wp-content/plugins/d11-engine-figma/.agents/skills` for workflow skills such as `d11-generate-page`, `d11-review-page`, and `d11-optimize-lighthouse`
- source root: `wp-content/plugins/d11-pages/.agents/skills` for `ai-engine`
- compatibility fallback: `wp-content/themes/d11/.agents/skills` is still checked for `ai-engine` if the plugin-local copy is not present
- target roots: `~/.codex/skills`, `~/.opencode/skills`

Because these are defaults, the script works out of the box for the plugin-local workflow skills and for the repository-local `ai-engine` documentation skill.

## Usage

List available local skills:

```bash
wp-content/plugins/d11-engine-figma/scripts/sync-codex-skill.sh --list
```

Sync a specific workflow skill:

```bash
wp-content/plugins/d11-engine-figma/scripts/sync-codex-skill.sh --skill d11-generate-page
```

Sync the repository-local `ai-engine` skill:

```bash
wp-content/plugins/d11-engine-figma/scripts/sync-codex-skill.sh --skill ai-engine
```

Sync all local skills:

```bash
wp-content/plugins/d11-engine-figma/scripts/sync-codex-skill.sh --skill all
```

Use custom roots:

```bash
wp-content/plugins/d11-engine-figma/scripts/sync-codex-skill.sh \
  --skill my-skill \
  --source-root /path/to/.agents/skills \
  --target-root /path/to/.codex/skills
```

## Rules

- The repository copy should be treated as the source of truth.
- Run the sync script after changing a repository-local skill that must also exist in `~/.codex/skills` or `~/.opencode/skills`.
- If a skill is not visible in Codex or OpenCode but exists in the repository, check whether the global copy is missing or outdated.
- The script syncs one skill at a time on purpose, so changes remain explicit and reviewable.
- `--skill all` is available when you intentionally want to sync every local skill in one run.
- Sync the whole skill directory so `SKILL.md`, `skill.yaml`, `README.md`, and any future bundled files stay aligned across repository-local and global copies.
