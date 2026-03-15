# D11 WP Theme

Public monorepo for the D11 WordPress theme and public custom plugins.

## Contents

- `wp-content/themes/d11`
- `wp-content/plugins/d11-maintenance`
- `wp-content/plugins/cf7-sync`
- `wp-content/plugins/simple-cookie-consent`

`d11-engine` is intentionally not part of this repository. It lives in a separate private repository and is installed as a normal WordPress plugin at `wp-content/plugins/d11-engine` in target environments.

## Branches

- `dev`: default branch for active development
- `master`: stable branch that triggers release packaging

## Releases

Every push or merge to `master` triggers automated packaging and GitHub Releases for each installable component in this repository:

- `d11.zip`
- `d11-maintenance.zip`
- `cf7-sync.zip`
- `simple-cookie-consent.zip`

The workflow reads version numbers from the theme and plugin headers. Bump the version in the relevant component before merging to `master`.

## Notes

- This repository does not include WordPress core.
- This repository does not include third-party plugins.
- Installable ZIPs are intended for WordPress admin upload/install flows.
