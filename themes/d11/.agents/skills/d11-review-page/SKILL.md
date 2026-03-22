---
name: d11-review-page
description: "Review one d11 page with a controlled correction pass and explicit baseline plus verify screenshot comparison."
---

# d11-review-page

Use this skill for one page at a time when the page already exists and the task is to review, correct, and validate the result through a before-and-after visual pass.

## Required reading

Always read:

- `docs/ai-workflows.md`
- `docs/theme-overview.md`
- `docs/block/block-composition-guide.md`
- `docs/block/whitelisted-blocks-summary.md`
- `docs/screenshot-validation.md`

Consult these when the task scope requires it:

- `docs/block/block-availability-system.md`
- `docs/block/whitelisted-blocks.md`
- `docs/content-sync.md`

## What this skill does

- reviews one existing page or one previously drafted page
- captures a `baseline` screenshot set before changes
- identifies the highest-value mismatches or defects
- uses direct Playwright MCP inspection only when screenshots do not explain the defect clearly enough
- applies one controlled correction pass
- captures a `verify` screenshot set after changes
- compares the two visual states before stopping

## What this skill must not do

- do not work on multiple pages in one reasoning pass
- do not skip the `baseline` screenshot set for iterative review work
- do not turn review into full regeneration from zero unless the task explicitly changes scope
- do not run repeated uncontrolled auto-fix loops
- do not use Playwright MCP as the default path for every review
- do not dump the full page DOM or mass CSS output when a scoped inspection would be enough
- do not optimize Lighthouse or Core Web Vitals in this skill
- do not duplicate shared workflow rules that already live in `docs/ai-workflows.md`

## Playwright MCP Fallback

Use direct Playwright MCP inspection only as a fallback diagnostic step when screenshots are not enough to explain the defect or to choose a safe correction.

Allowed fallback uses:

- inspect one problematic container or selector before editing
- inspect a small subtree after `verify` if the screenshots still show an unexplained defect
- read scoped HTML, classes, attributes, and a small set of computed styles

Keep CSS inspection narrow and problem-driven. Prefer only the properties needed to explain the issue, such as:

- `display`
- `position`
- `width`
- `height`
- `gap`
- `padding`
- `margin`
- `overflow`
- `z-index`
- `font-size`
- `line-height`

Do not use full-page `page.content()` output or broad computed-style dumps as a standard step.

## Workflow

1. Read the shared workflow foundation and canonical theme docs.
2. Inspect the current page state and capture a `baseline` screenshot set before editing.
3. Identify the highest-value visual or structural mismatches that can be fixed safely within one review pass.
4. If the screenshots do not explain the likely cause clearly enough, use scoped Playwright MCP inspection on the relevant selector or container.
5. Apply one controlled correction pass within the current theme constraints.
6. Capture a `verify` screenshot set after the correction.
7. Compare `baseline` and `verify` before declaring the review pass complete.

## Output contract

The output of this skill is a reviewed page after one controlled correction pass.

The related report or handoff notes must include:

- prioritized mismatches that were found
- mismatches intentionally ignored and why
- corrections applied during the review pass
- any Playwright MCP fallback usage, including the selector inspected and the reason it was needed
- residual issues that still require manual follow-up

## Acceptance boundary

Stop when one review pass has been completed, documented, and validated through `baseline` plus `verify` screenshots, or when an external blocker prevents reliable visual validation.
