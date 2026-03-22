# Screenshot Validation

This document explains the local screenshot workflow used to validate front-end pages after creation or modification.

## Purpose

Use the local screenshot CLI when a task changes the visual output of a page and a structural block validation pass is not enough.

The screenshot pass exists to catch issues such as:

- duplicated sticky or fixed UI during long-page capture
- incomplete lazy-loaded content
- broken spacing, hierarchy, or alignment across breakpoints
- overflow, clipping, or empty regions introduced by block composition changes

Use screenshot captures according to task intent:

- single-pass validation for initial implementation or one-off front-end changes
- `baseline` plus `verify` comparison for iterative review and correction work

## Tooling

The local entrypoint is:

```text
tools/review-screenshot/index.js
```

The package shortcut is:

```bash
npm run screenshots -- <url>
```

## Supported Breakpoints

Each run produces one stitched PNG per breakpoint:

- `desktop`: `1440x900`
- `tablet`: `768x1024`
- `mobile`: `375x812`

The viewport defines the layout and media-query behavior. The final image height is derived from the full document height gathered through manual scrolling and stitching.

## Usage

Basic usage:

```bash
npm run screenshots -- https://example.test/page-slug
```

By default this writes to:

```text
wp-content/uploads/dev-screenshots/page-slug/
```

Direct invocation:

```bash
node tools/review-screenshot/index.js https://example.test/page-slug
```

Hide transient UI when needed:

```bash
npm run screenshots -- https://example.test/page-slug \
  --out-dir=../../uploads/dev-screenshots/page-slug-review \
  --exclude=.simple-cookie-consent,.chat-widget
```

Useful flags:

- `--out-dir=<path>`: override the default destination under `wp-content/uploads/dev-screenshots/<page-name>`
- `--timeout=<ms>`: increase timeouts for slow pages or media-heavy pages
- `--exclude=<selector>`: hide known transient UI before capture
- `--wait-until=<event>`: override Playwright navigation readiness

When the screenshot CLI later supports labeled review runs, keep the review labels stable and predictable so a review skill can distinguish `baseline` from `verify` artifacts without redefining screenshot semantics at the skill layer.

## Validation Workflow

For page work, use this sequence:

1. Complete the intended page or content change.
2. Run the screenshot CLI for the target page.
3. Review the generated `desktop.png`, `tablet.png`, and `mobile.png`.
4. If the screenshots show visual regressions or weak composition, refine the page and run the capture again.
5. Finish only when the screenshots support the claimed result, or when an external blocker prevents a reliable capture.

For iterative review work, use this sequence:

1. Capture a `baseline` set before applying corrections.
2. Review the current rendered page and identify the highest-value mismatches.
3. If the screenshots do not explain the likely cause clearly enough, use a scoped direct Playwright inspection of the relevant selector or container.
4. Apply one controlled correction pass.
5. Capture a `verify` set after the correction.
6. Compare `baseline` and `verify` before declaring the review pass complete.

## Rules

- Treat screenshots as validation artifacts, not as the content source of truth.
- Prefer one output directory per page or validation pass.
- Run all three breakpoints unless the task explicitly limits scope.
- Use screenshots to validate real rendered output, especially after changes to synced content, patterns, templates, parts, or CSS.
- When screenshots are not enough to explain a defect, a review workflow may use direct Playwright inspection as a scoped fallback, but not as a replacement for screenshot validation.
- If browser execution is blocked by the environment, state that clearly instead of claiming visual validation.
