# d11-optimize-lighthouse

This repository-local skill handles one-page Lighthouse-driven optimization work for the `d11` theme.

## Purpose

Use this skill when the page already exists, visual review has reached an acceptable baseline, and the next step is to audit performance, accessibility, and SEO with the local `optimize-lighthouse` CLI.

The analyzer value comes from filtered metrics plus prioritized interpretation, not from blindly forwarding the full Lighthouse payload.

## Tooling

The local CLI lives under:

- `wp-content/themes/d11/tools/optimize-lighthouse/`

Typical usage:

```bash
node wp-content/themes/d11/tools/optimize-lighthouse/cli/index.js https://example.test/page --device=mobile --runs=3
```

## Source Of Truth

- Repository-local source: `wp-content/themes/d11/.agents/skills/d11-optimize-lighthouse/`
- Main instructions: `SKILL.md`
- Skill metadata: `skill.yaml`
