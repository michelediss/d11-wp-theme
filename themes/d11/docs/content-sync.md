# Content Sync

This file documents the theme-owned content sync subsystem used to synchronize Gutenberg page content between the WordPress database and versioned JSON files in the active theme.

## Responsibilities

- own the DB ↔ filesystem sync logic for Gutenberg page content
- expose WP-CLI commands for export and import
- provide optional runtime override from JSON files
- keep synced page content versioned inside the active theme

## Runtime Sources Of Truth

- `inc/content-sync/bootstrap.php`: theme bootstrap for the content sync subsystem
- `inc/content-sync/config.php`: default configuration
- `inc/content-sync/class-content-sync-config.php`: config normalization and filter boundary
- `inc/content-sync/class-content-sync-service.php`: sync service, validation, hashing, runtime override
- `inc/content-sync/class-content-sync-cli.php`: `content:export` and `content:import`
- `content/`: versioned JSON payloads managed by the theme

## Runtime Model

- The subsystem never manipulates `post_content` via regex or string rewriting.
- Database content is parsed with `parse_blocks()`.
- Filesystem content is serialized with `serialize_blocks()`.
- Conflict detection compares canonical content hashes and uses timestamps only as diagnostics.
- Runtime override is optional and disabled by default.
- The default configuration filter is `d11_content_sync_config`.

## Conventions

- v1 supports `page` post type only.
- JSON filenames are deterministic and based on post type plus page path.
- The filesystem is the default source of truth when sync is intentionally enabled.
- Theme architecture and block composition rules remain documented under `docs/`.
- The content sync subsystem is theme-owned, but must remain conceptually separate from `.agents/` tooling.

## Maintenance Rules

- Update this file when sync behavior, CLI semantics, config keys, or JSON conventions change.
- Keep `content/` as a theme-level project asset, not as agent tooling.
