---
name: d11-generate-page
description: "Generate one d11 page as an initial implementation draft using the canonical theme docs, content-sync rules, and allowed block constraints."
---

# d11-generate-page

Use this skill for one page at a time when the task is to create or substantially rebuild the page as an initial implementation.

## Required reading

Always read:

- `docs/ai-workflows.md`
- `docs/theme-overview.md`
- `docs/block/block-composition-guide.md`
- `docs/block/whitelisted-blocks-summary.md`

Consult these when the task scope requires them:

- `docs/block/block-availability-system.md`
- `docs/block/whitelisted-blocks.md`
- `docs/content-sync.md`

## What this skill does

- builds one draft page implementation that respects the theme architecture
- uses runtime block constraints and composition guidance
- follows the theme-owned content sync model when page content is content-driven
- produces a result that is ready for later visual review if refinement is still needed

## What this skill must not do

- do not work on multiple pages in one reasoning pass
- do not turn generation into an iterative before-and-after review loop
- do not require `baseline` plus `verify` screenshots
- do not optimize Lighthouse or Core Web Vitals in this skill
- do not duplicate shared workflow rules that already live in `docs/ai-workflows.md`

## Workflow

1. Read the shared workflow foundation and canonical theme docs.
2. Resolve the current theme identity, allowed blocks, and relevant artifact boundary.
3. Build the page in the correct theme-owned artifact, usually synced JSON when the page body is content-driven.
4. Keep templates and parts thin and reusable; do not move page-specific editorial copy into shared structural artifacts.
5. Produce an initial implementation draft that is structurally sound and visually plausible.

## Output contract

The output of this skill is an initial page implementation draft.

The related report or handoff notes must include:

- the main page structure that was created
- important block choices and degradations
- assumptions made during implementation
- known items that should be reviewed in a later review pass

## Acceptance boundary

Stop when the page has a coherent first implementation that follows the theme rules and is ready for a later dedicated review pass if refinement is still required.
