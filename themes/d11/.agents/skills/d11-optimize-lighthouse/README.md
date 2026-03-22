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

In the `d11` Docker workspace, the CLI now performs an environment preflight first. When the canonical site URL is not reachable from the current host, it delegates automatically to the internal Docker audit runner and records both the canonical URL and the audit URL in the report.

The default report directory for a page is replaceable. Re-running the audit on the same page removes the previous JSON reports under `wp-content/uploads/dev-lighthouse/<page-name>/` before writing the new report set.

## Source Of Truth

- Repository-local source: `wp-content/themes/d11/.agents/skills/d11-optimize-lighthouse/`
- Main instructions: `SKILL.md`
- Skill metadata: `skill.yaml`
