<?php

declare(strict_types=1);

if (! defined('ABSPATH')) {
    exit;
}

if (! class_exists('D11_Content_Sync_CLI')) {
    final class D11_Content_Sync_CLI
    {
        private D11_Content_Sync_Service $service;

        public function __construct(D11_Content_Sync_Service $service)
        {
            $this->service = $service;
        }

        public static function register(D11_Content_Sync_Service $service): void
        {
            if (! class_exists('WP_CLI')) {
                return;
            }

            $instance = new self($service);

            WP_CLI::add_command('content:export', [$instance, 'export']);
            WP_CLI::add_command('content:import', [$instance, 'import']);
        }

        /**
         * Export a page's Gutenberg block tree from the database into a JSON file.
         *
         * ## OPTIONS
         *
         * <post_id>
         * : Numeric ID of the page to export.
         *
         * [--dir=<path>]
         * : Override the configured content directory.
         *
         * [--force]
         * : Overwrite conflicting filesystem content.
         *
         * [--dry-run]
         * : Validate and report without writing files.
         *
         * ## EXAMPLES
         *
         *     wp content:export 42
         *     wp content:export 42 --dry-run
         */
        public function export(array $args, array $assoc_args): void
        {
            $post_id = isset($args[0]) ? absint((string) $args[0]) : 0;
            if ($post_id <= 0) {
                WP_CLI::error('A valid numeric <post_id> is required.');
            }

            try {
                $result = $this->service->export_post($post_id, $this->normalize_options($assoc_args));
            } catch (Throwable $throwable) {
                WP_CLI::error($throwable->getMessage());
            }

            $this->render_result($result);
        }

        /**
         * Import a page's Gutenberg block tree from a JSON file into the database.
         *
         * ## OPTIONS
         *
         * <slug>
         * : Page slug or hierarchical page path, for example "home" or "company/about".
         *
         * [--dir=<path>]
         * : Override the configured content directory.
         *
         * [--force]
         * : Overwrite conflicting database content.
         *
         * [--dry-run]
         * : Validate and report without updating the database.
         *
         * ## EXAMPLES
         *
         *     wp content:import home
         *     wp content:import company/about --force
         */
        public function import(array $args, array $assoc_args): void
        {
            $slug = isset($args[0]) ? (string) $args[0] : '';
            if ('' === trim($slug)) {
                WP_CLI::error('A non-empty <slug> is required.');
            }

            try {
                $result = $this->service->import_slug($slug, $this->normalize_options($assoc_args));
            } catch (Throwable $throwable) {
                WP_CLI::error($throwable->getMessage());
            }

            $this->render_result($result);
        }

        private function normalize_options(array $assoc_args): array
        {
            return [
                'dir' => isset($assoc_args['dir']) ? (string) $assoc_args['dir'] : null,
                'force' => isset($assoc_args['force']),
                'dry_run' => isset($assoc_args['dry-run']),
            ];
        }

        private function render_result(array $result): void
        {
            $items = [[
                'action' => (string) ($result['action'] ?? ''),
                'post_id' => (int) ($result['post_id'] ?? 0),
                'post_type' => (string) ($result['post_type'] ?? ''),
                'slug' => (string) ($result['slug'] ?? ''),
                'path' => (string) ($result['path'] ?? ''),
                'content_hash' => (string) ($result['content_hash'] ?? ''),
            ]];

            \WP_CLI\Utils\format_items('table', $items, ['action', 'post_id', 'post_type', 'slug', 'path', 'content_hash']);

            WP_CLI::success(sprintf(
                'Theme content sync completed with action "%s".',
                (string) ($result['action'] ?? 'unknown')
            ));
        }
    }
}
