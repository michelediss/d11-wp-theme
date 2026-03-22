---
name: d11-optimize-lighthouse
description: "Audit one stable d11 page with the local optimize-lighthouse CLI, prioritize Lighthouse findings, and produce concrete frontend optimization guidance."
---

# d11-optimize-lighthouse

Use this skill for one page at a time after generation and visual review have already reached an acceptable baseline.

## Required reading

Always read:

- `docs/ai-workflows.md`
- `docs/theme-overview.md`
- `docs/block/whitelisted-blocks-summary.md`

Consult these when the task scope requires them:

- `docs/content-sync.md`
- `tools/optimize-lighthouse/cli/index.js`
- `tools/optimize-lighthouse/core/orchestrator.js`

## What this skill does

- runs the local `optimize-lighthouse` CLI against one target page
- reads filtered Lighthouse metrics instead of the full raw report
- prioritizes performance, accessibility, and SEO issues through the rules engine
- uses the analyzer layer to produce concrete implementation guidance
- compares against a previous JSON baseline when requested

## What this skill must not do

- do not regenerate the page from scratch
- do not replace `d11-review-page` as the visual validation workflow
- do not pass the full Lighthouse report into the analyzer layer
- do not optimize multiple pages in one reasoning pass
- do not introduce frontend changes that violate the theme block constraints without calling that out explicitly

## Workflow

1. Confirm the page is already visually stable enough for audit work.
2. Run `optimize-lighthouse` with the requested device and run count.
3. Inspect the filtered metrics, normalized opportunities, and prioritized issues.
4. If a baseline JSON exists, run compare mode and inspect regressions first.
5. Produce or apply concrete frontend fixes that are safe within the current theme architecture.
6. Re-run the audit when verification is needed after changes.

## Output contract

The output of this skill is one performance-oriented optimization pass for one page.

The related report or handoff notes must include:

- summarized scores and core metrics
- prioritized issues and why they matter
- concrete fixes applied or recommended
- compare deltas when baseline mode was used
- residual risks or deferred work

## Acceptance boundary

Stop when the page has one documented optimization pass with clear findings and concrete fixes, or when an external blocker prevents a reliable Lighthouse run.
