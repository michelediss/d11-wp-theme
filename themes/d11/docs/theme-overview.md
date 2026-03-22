# Theme Summary

This scaffolded theme is a block-first WordPress theme with a small PHP bootstrap layer and a Vite-based front-end pipeline where Tailwind is the canonical visual design system and `theme.json` is reduced to Gutenberg layout/editor essentials.

## Architecture

- `functions.php` loads the theme bootstrap and hooks setup, front-end assets, editor assets, and custom blocks into WordPress.
- `inc/assets.php` switches between the local Vite dev server and the production manifest in `assets/.vite/manifest.json`.
- `inc/blocks.php` discovers and registers custom theme blocks from `blocks/*/block.json`.
- `inc/content-sync/` contains the theme-owned content sync subsystem for versioned Gutenberg page JSON, CLI import/export, and optional runtime override.
- `inc/patterns.php` registers the custom block pattern category and loads theme-owned PHP block patterns from `patterns/`.
- `templates/` and `parts/` contain the block theme HTML templates used by the Site Editor.
- `templates/front-page.html` should remain a thin shell that mounts the shared header/footer and renders the assigned front page content through `post-content`.
- `parts/cookie-banner.html` mounts the plugin-owned `simple-cookie-consent/banner` block so cookie consent layout is controlled from the Site Editor instead of plugin PHP hooks.
- `src/js/` and `src/css/` contain the authored source files, including theme-owned admin assets and the Tailwind stylesheet entrypoints; built output is written to `assets/`.
- `theme.json` exists only to keep Gutenberg useful for content entry and macro layout controls such as constrained widths, wide widths, and spacing presets.

## Naming Conventions

- PHP functions use an explicit theme-specific prefix and snake_case, following WordPress naming conventions. In this repository the current prefix is `d11_`.
- Asset handles use a theme-specific prefix derived from the generated theme slug. In this repository the current handle prefix is `d11-`.
- Theme text-domain values must match the `Text Domain` declared in `style.css`. In this repository the current text domain is `d11`.
- JavaScript uses descriptive camelCase names, with one module per concern.
- Custom blocks use slug format `custom/<name>` and live in `blocks/<name>/`.

## Important Files

- `functions.php`: theme bootstrap and core hooks.
- `inc/assets.php`: Vite integration, asset registration, and dev-server/manifest switching.
- `inc/blocks.php`: custom block discovery and registration.
- `inc/patterns.php`: custom block pattern category and PHP pattern registration.
- `cf7-forms/`: versioned Contact Form 7 JSON manifests owned by the theme and synced with the local `cf7-sync` WP-CLI plugin.
- `content/`: versioned Gutenberg page JSON payloads owned by the integrated theme content sync subsystem.
- `theme.json`: minimal Gutenberg configuration for layout and editor controls.
- `partials/block-availability.php`: block availability bootstrap that loads `partials/block-availability/runtime.php` for the runtime whitelist logic across core, blog, WooCommerce, third-party plugin blocks, and theme custom blocks, plus `partials/block-availability/admin.php` for the related Appearance admin UI.
- `partials/block-availability/utility/`: export utilities that regenerate the derived block reference files in `docs/block/`, including `block-registry.json`, `whitelisted-blocks-summary.md`, and `whitelisted-blocks.md`.
- `partials/theme-options.php`: Settings admin screen for theme-owned runtime options such as frontend jQuery disable, comments disable, and image upload restrictions.
- `partials/privacy-controller-data.php`: Settings admin screen for the global `privacy_controller_data` option and the `[privacy key="..."]` shortcode used in policy pages.
- `docs/ai-workflows.md`: shared foundation document for repository-local AI workflows, including source-of-truth boundaries, content sync constraints, and screenshot workflow semantics.
- `.agents/skills/d11-generate-page/`: repository-local skill for initial page generation and draft implementation.
- `.agents/skills/d11-review-page/`: repository-local skill for iterative page review using a `baseline` plus `verify` screenshot pass.
- `.agents/skills/d11-optimize-lighthouse/`: repository-local skill for Lighthouse-driven optimization after the page already has a stable visual baseline.
- Some AI-assisted page workflow tooling may live outside the theme repository and be installed separately in runtime environments.
- `tools/review-screenshot/`: local Playwright plus `sharp` screenshot tool used to capture stitched full-page validation images for desktop, tablet, and mobile.
- `tools/optimize-lighthouse/`: local Node.js CLI for Lighthouse-based auditing, metric extraction, prioritization, and optimization guidance.
- External workflow tooling may still own prep, ingest, or other automation flows that are not part of the theme-local screenshot and documentation workflows.
- `tailwind.config.js`: canonical source of theme colors, typography, radius, shadows, and ergonomic utility aliases.
- `src/js/app.js`: front-end bootstrap entrypoint.
- `src/css/app.css`: main Tailwind-aware stylesheet entrypoint; it imports local CSS layers and expands `@tailwind` directives during the Vite build.
- `src/js/blocks/editor.js`: shared editor entry for custom blocks.
- `src/js/blocks/view.js`: shared front-end entry for custom block behavior.
- `docs/block/block-availability-system.md`: documentation of the runtime block availability system, category model, and allowlist behavior.
- `docs/block/block-composition-guide.md`: AI-facing guide to block usage and composition patterns.
- `docs/block/whitelisted-blocks-summary.md`: compact operational list of currently allowed blocks for AI-assisted workflows.
- `docs/block/custom-blocks.md`: development rules for future custom blocks.
- `docs/content-sync.md`: operational reference for the theme-owned DB ↔ filesystem content sync subsystem.
- `docs/ai-workflows.md`: shared workflow rules for repository-local AI skills.
- `docs/screenshot-validation.md`: operational reference for the local screenshot capture and review workflow used to validate front-end pages.
- `docs/skill-sync.md`: operational guide for syncing repository-local skills to the global Codex and OpenCode skill directories.
- `tools/review-screenshot/index.js`: local CLI entrypoint for screenshot-based review validation.
- `tools/optimize-lighthouse/cli/index.js`: local CLI entrypoint for multi-run Lighthouse audits and optimization reporting.
- `style.css`: theme registration metadata required by WordPress.
- `vite.config.js` and `tailwind.config.js`: build pipeline configuration.

## JavaScript

- `src/js/app.js` is the front-end bootstrap entrypoint. It waits for `DOMContentLoaded` and then initializes the small progressive-enhancement modules used by the theme.
- `src/js/modules/` contains one module per concern:
  - `fade-in.js` reveals explicitly marked front-end sections on scroll with GSAP and `ScrollTrigger`. It only targets nodes marked with `data-fade-in`, skips nodes marked with `.no-fadein`, and shows content immediately when the user prefers reduced motion. Do not rely on implicit `main > *` targeting for primary content, because above-the-fold sections must remain visible before JavaScript bootstraps.
  - `menu.js` keeps the theme-level `.menu-is-open` state on `<html>` synchronized with the core Navigation block responsive overlay, so scroll locking reflects the real open or closed state of the mobile menu.
  - `page-transitions.js` handles subtle page entry animation and intercepts eligible same-origin links to run a short exit transition before navigation. External links, modified clicks, downloads, admin routes, and same-page hash jumps are ignored.
  - `simple-cookie-consent-banner.js` owns frontend motion for the plugin-rendered cookie banner, including GSAP entry/exit and settings-panel reveal coordination.
- `src/js/blocks/` contains editor and front-end scripts for custom blocks. Shared entrypoints (`editor.js` and `view.js`) import block-specific modules so Vite can bundle them into the assets consumed by WordPress.
- `src/js/patterns/` contains lightweight hooks for pattern-level DOM behavior. These hooks should stay optional and should not become a second application bootstrap layer.
- Keep JavaScript as progressive enhancement. Theme templates, patterns, and custom blocks must remain usable without client-side JS.
- Theme-authored frontend presentation for the plugin cookie banner lives in `src/css/blocks/simple-cookie-consent-banner.css`, while the plugin remains responsible for markup and consent logic.

## Vite Asset Flow

- In development, `inc/assets.php` checks whether the local Vite dev server is available and, if so, enqueues source entries such as `src/js/app.js` directly from `http://localhost:5173`.
- In production, Vite builds the source files into `assets/` and writes `assets/.vite/manifest.json`. WordPress resolves the final bundle filenames from that manifest before enqueueing them.
- The main front-end entrypoints are `src/js/app.js` for JavaScript and `src/css/app.css` for styles. The CSS entry imports local layers and expands Tailwind directives during the Vite build.
- Additional entries exist for block editor scripts, block view scripts, SEO editor utilities, admin-only settings screens, and CSS bundles as defined in `vite.config.js`.
- When JavaScript or CSS files under `src/` change, run `npm run build` so the production bundles in `assets/` stay aligned with the source.

## Design System Contract

- `tailwind.config.js` is the source of truth for colors, typography, radius, shadows, and other visual tokens.
- The current presentation-site direction for D11 uses a cool SaaS-oriented palette: `paper` and `sand` for bright product surfaces, `ink` and `cinder` for interface text and contrast, `primary` or `ember` for core actions, and `accent` or `sun` for product highlights.
- The current typography pairing uses `Space Grotesk` for headings, `Inter` for body copy, and `IBM Plex Mono` for compact labels, metadata, and system-style kickers.
- Reusable component-level classes that express the D11 presentation language should live in `src/css/blocks.css`, while one-off section styling should stay in block markup through Tailwind utility classes.
- Homepage presentation copy should live in PHP pattern files under `patterns/`, not in `templates/front-page.html` or shared `parts/*.html`.
- For the D11 presentation site homepage, the page body is owned by `content/page-home.json` and imported into the `Home` page, while the front-page template only frames it with header and footer.
- `theme.json` must stay intentionally narrow: layout widths, spacing presets used by Gutenberg, and disabling editor UI that would reintroduce ad-hoc styling.
- `src/css/app.css` remains the place where Tailwind layers are assembled. Theme CSS may use `@apply`, but should resolve to Tailwind tokens instead of WordPress preset variables.
- Theme-authored patterns, parts, templates, and custom block markup should prefer Tailwind utility classes directly in block `className` values.
- Avoid using Gutenberg color, typography, border, and shadow presets for theme styling. Gutenberg should primarily handle content entry and macro layout structure.
- Keep `settings.layout` in `theme.json` so the editor and front end share the same `contentSize` and `wideSize` baseline.

## Maintenance Notes

- When source files in `src/` change, rebuild assets with `npm run build` so production bundles in `assets/` stay aligned.
- Keep all user-facing theme strings translatable with the text domain declared in `style.css`. In this repository that value is `d11`. Load translations from `languages/`, use WordPress i18n helpers in PHP, and call `wp_set_script_translations()` for any theme-owned JS handle that uses `wp.i18n`.
- Keep theme-owned admin pages under a single clear ownership boundary. `Settings -> Theme Options` is reserved for global runtime toggles owned by the theme, while more specific feature pages can still live under `Settings` or `Appearance` when their scope is narrower.
- Keep the privacy content source centralized in `Settings -> Privacy Data`, backed by the single `privacy_controller_data` option and consumed in content through `[privacy key="..."]`.
- Do not leave user-facing copy hardcoded inside `templates/*.html` or `parts/*.html`. In block themes those files are not reliable extraction targets, so translatable copy should live in PHP-registered patterns referenced by the HTML templates.
- After adding or changing strings, regenerate catalogs with `npm run i18n:build` so the generated `.pot`, locale `.po/.mo`, and JS translation JSON files stay aligned with the current theme text domain.
- Keep new PHP APIs prefixed with the current theme-specific PHP prefix to avoid collisions with plugins or other themes. In this repository that prefix is `d11_`.
- Prefer block patterns and editor-native layout blocks over custom PHP rendering unless the editor cannot express the requirement cleanly.
- When updating visual tokens, change `tailwind.config.js` first. When updating editor layout behavior, change `theme.json`.
- Keep Contact Form 7 manifests under the active theme root in `cf7-forms/` so they are versioned with the theme; the local `cf7-sync` WP-CLI command reads from that path by default.
- Keep synced page JSON payloads under `content/` at the theme root so they are versioned with the active theme and remain clearly separate from `.agents/` tooling.
- When page-oriented AI workflows change front-end output, validate the rendered result with the local screenshot CLI and review the generated images before declaring the task complete.
- Keep shared workflow rules in `docs/ai-workflows.md` and keep task-specific skill behavior inside the relevant repository-local skill.
- Use the local `optimize-lighthouse` CLI only after the page already has an acceptable visual baseline; it is not a replacement for screenshot-based review.
- When adding a new custom block, update both `docs/block/custom-blocks.md` and `docs/block/block-composition-guide.md` if the block should be available to AI-assisted template generation.
- Repository-local page workflow skills should read `docs/ai-workflows.md` together with the canonical theme docs in `docs/`, while any external page workflow skills must still derive runtime facts for blocks, tokens, screenshots, and audits from concrete theme code plus workflow artifacts.
- After changing a repository-local skill that should also be available globally, run the sync workflow documented in `docs/skill-sync.md`.
