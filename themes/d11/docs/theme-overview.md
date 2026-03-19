# Theme Summary

This scaffolded theme is a block-first WordPress theme with a small PHP bootstrap layer and a Vite-based front-end pipeline.

## Architecture

- `functions.php` loads the theme bootstrap and hooks setup, front-end assets, editor assets, and custom blocks into WordPress.
- `inc/assets.php` switches between the local Vite dev server and the production manifest in `assets/.vite/manifest.json`.
- `inc/blocks.php` discovers and registers custom theme blocks from `blocks/*/block.json`.
- `inc/patterns.php` registers the custom block pattern category, while WordPress auto-discovers native pattern files from `patterns/`.
- `templates/` and `parts/` contain the block theme HTML templates used by the Site Editor.
- `parts/cookie-banner.html` mounts the plugin-owned `simple-cookie-consent/banner` block so cookie consent layout is controlled from the Site Editor instead of plugin PHP hooks.
- `src/js/` and `src/css/` contain the authored source files, including theme-owned admin assets; built output is written to `assets/`.
- `theme.json` defines the source-of-truth design tokens and editorial defaults that Gutenberg must know natively, while a generated Tailwind bridge consumes those same tokens instead of defining a second design system.

## Naming Conventions

- PHP functions use an explicit theme-specific prefix and snake_case, following WordPress naming conventions. In this repository the current prefix is `d11_`.
- Asset handles use a theme-specific prefix derived from the generated theme slug. In this repository the current handle prefix is `d11-`.
- Theme text-domain values must match the `Text Domain` declared in `style.css`. In this repository the current text domain is `d11`.
- JavaScript uses descriptive camelCase names, with one module per concern.
- Custom blocks use slug format `custom/<name>` and live in `blocks/<name>/`.

## Important Files

- `functions.php`: theme bootstrap and core hooks.
- `inc/assets.php`: Vite integration and asset registration.
- `inc/blocks.php`: custom block discovery and registration.
- `inc/block-styles.php`: theme-owned Gutenberg block style registrations such as the `Card` style for `core/group`.
- `inc/patterns.php`: custom block pattern category registration.
- `cf7-forms/`: versioned Contact Form 7 JSON manifests owned by the theme and synced with the local `cf7-sync` WP-CLI plugin.
- `theme.json`: design system and editor configuration.
- `partials/block-availability.php`: block availability bootstrap that loads `partials/block-availability/runtime.php` for the runtime whitelist logic across core, blog, WooCommerce, third-party plugin blocks, and theme custom blocks, plus `partials/block-availability/admin.php` for the related Appearance admin UI.
- `partials/block-availability/utility/`: export utilities that regenerate the derived block reference files in `docs/block/`, including `block-registry.json` and `whitelisted-blocks.md`.
- `partials/theme-options.php`: Settings admin screen for theme-owned runtime options such as frontend jQuery disable, comments disable, and image upload restrictions.
- `partials/privacy-controller-data.php`: Settings admin screen for the global `privacy_controller_data` option and the `[privacy key="..."]` shortcode used in policy pages.
- `.agents/skills/ai-engine/`: theme-local documentation skill that keeps Codex aligned with the canonical theme docs and the AI-assisted composition model used by this theme.
- `d11-engine-figma` lives in a separate private repository and is installed in runtime environments as `wp-content/plugins/d11-engine-figma`.
- The private `d11-engine-figma` repository contains the repository-local workflow skills and deterministic prep, screenshot, ingest, and skill-sync tooling for Figma Make to WordPress workflows.
- `tailwind.config.js`: stable Tailwind shell that imports generated token mappings instead of hardcoding primitive theme tokens.
- `scripts/generate-tailwind-config.js`: generator that reads `theme.json` and writes the derived Tailwind token bridge plus debug metadata.
- `scripts/generated/tailwind-theme.generated.js`: generated Tailwind `theme.extend` partial derived from `theme.json`. Do not edit it manually.
- `src/js/app.js`: front-end bootstrap entrypoint.
- `src/js/blocks/editor.js`: shared editor entry for custom blocks.
- `src/js/blocks/view.js`: shared front-end entry for custom block behavior.
- `docs/block/block-availability-system.md`: documentation of the runtime block availability system, category model, and allowlist behavior.
- `docs/block/block-composition-guide.md`: AI-facing guide to block usage and composition patterns.
- `docs/block/custom-blocks.md`: development rules for future custom blocks.
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
- The main front-end entrypoint is `src/js/app.js`. Additional entries exist for block editor scripts, block view scripts, SEO editor utilities, admin-only settings screens, and CSS bundles as defined in `vite.config.js`.
- When JavaScript or CSS files under `src/` change, run `npm run build` so the production bundles in `assets/` stay aligned with the source.

## Design System Contract

- `theme.json` is the source of truth for stable global tokens and Gutenberg-facing defaults such as palette, typography presets, spacing scale, layout widths, and shared radius values.
- `theme.json` is the only source of primitive design tokens. Tailwind must consume those tokens through the generated bridge under `scripts/generated/`; it must not become a parallel token registry with divergent colors, spacing values, or widths.
- `tailwind.config.js` should remain a thin shell for content scanning, plugins, and derived ergonomic aliases such as component radius or shadow names. Primitive colors, font families, spacing, and layout widths must come from the generated bridge.
- Keep `settings.layout` in `theme.json` so the editor, front-end styles, and AI generation flows share the same `contentSize` and `wideSize` baseline.
- Avoid using `theme.json` to impose broad layout behavior on neutral containers. Section spacing and composition should usually live in patterns, templates, block supports, or scoped CSS instead of global `core/group` padding.
- Keep `styles.elements` minimal and global. Component-specific variants should live in Gutenberg block styles, patterns, or custom block CSS rather than being forced into every core element default or encoded as pseudo-components inside `theme.json`.

## Maintenance Notes

- When source files in `src/` change, rebuild assets with `npm run build` so production bundles in `assets/` stay aligned.
- Keep all user-facing theme strings translatable with the text domain declared in `style.css`. In this repository that value is `d11`. Load translations from `languages/`, use WordPress i18n helpers in PHP, and call `wp_set_script_translations()` for any theme-owned JS handle that uses `wp.i18n`.
- Keep theme-owned admin pages under a single clear ownership boundary. `Settings -> Theme Options` is reserved for global runtime toggles owned by the theme, while more specific feature pages can still live under `Settings` or `Appearance` when their scope is narrower.
- Keep the privacy content source centralized in `Settings -> Privacy Data`, backed by the single `privacy_controller_data` option and consumed in content through `[privacy key="..."]`.
- Do not leave user-facing copy hardcoded inside `templates/*.html` or `parts/*.html`. In block themes those files are not reliable extraction targets, so translatable copy should live in PHP-registered patterns referenced by the HTML templates.
- After adding or changing strings, regenerate catalogs with `npm run i18n:build` so the generated `.pot`, locale `.po/.mo`, and JS translation JSON files stay aligned with the current theme text domain.
- Keep new PHP APIs prefixed with the current theme-specific PHP prefix to avoid collisions with plugins or other themes. In this repository that prefix is `d11_`.
- Prefer block patterns and `theme.json` settings over custom PHP rendering unless the editor cannot express the requirement cleanly.
- When updating tokens or layout defaults, change `theme.json` first, then regenerate the Tailwind bridge with `npm run tokens:generate`. `npm run build` will enforce that the generated files are current through `npm run tokens:check`.
- Keep Contact Form 7 manifests under the active theme root in `cf7-forms/` so they are versioned with the theme; the local `cf7-sync` WP-CLI command reads from that path by default.
- When adding a new custom block, update both `docs/block/custom-blocks.md` and `docs/block/block-composition-guide.md` if the block should be available to AI-assisted template generation.
- The theme-local documentation skill should read `docs/` when theme documentation is required, while page workflow skills provided by the separate private `d11-engine-figma` repository must still derive runtime facts for blocks, tokens, screenshots, and audits from concrete theme code plus workflow artifacts.
