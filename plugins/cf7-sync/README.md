# CF7 Sync

`cf7-sync` is the plugin that allows Contact Form 7 forms to be treated as versioned configuration instead of content maintained only through the WordPress admin.

## What it is for

This plugin is useful when you want to:

- keep forms inside the project
- sync them predictably across environments
- avoid untracked manual changes
- keep forms aligned with a compositional theme workflow

Forms are not an isolated detail. They are part of the observable structure of the site and should remain consistent with the rest of the project.

## How it works

The plugin reads versioned JSON manifests and synchronizes them with Contact Form 7 through WP-CLI.

Typical flow:

1. define or update a JSON manifest
2. run the sync command
3. the plugin creates or updates the matching form
4. if nothing changed, it leaves the existing form untouched

## Available command

```bash
wp cf7 sync
```

Main options:

- `--dir=<path>` to specify the manifest directory
- `--slug=<slug>` to sync only one form
- `--dry-run` to preview changes without writing to the database

Examples:

```bash
wp cf7 sync --dir=wp-content/themes/example-theme/cf7-forms
wp cf7 sync --slug=contatti --dry-run
```

If `--dir` is omitted, the plugin uses this default location:

```text
wp-content/themes/<active-theme>/cf7-forms
```

## Why it fits the project

This workflow treats the site as an emergent system made of combinable foundational structures. In that model, forms should also be:

- described
- versioned
- synchronized
- reused

`cf7-sync` makes that part of the system more reliable and better suited for compositional and AI-assisted workflows.
