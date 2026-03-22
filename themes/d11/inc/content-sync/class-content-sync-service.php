<?php

declare(strict_types=1);

if (! defined('ABSPATH')) {
    exit;
}

if (! class_exists('D11_Content_Sync_Service')) {
    final class D11_Content_Sync_Service
    {
        private array $config;

        /**
         * In-request cache keyed by file path + mtime to avoid repeated JSON decoding.
         *
         * @var array<string, array<string, mixed>>
         */
        private array $runtime_cache = [];

        public function __construct(array $config)
        {
            $this->config = $config;
        }

        public function get_config(): array
        {
            return $this->config;
        }

        public function should_enable_runtime_override(): bool
        {
            if (empty($this->config['enabled']) || empty($this->config['runtime_override'])) {
                return false;
            }

            if (($this->config['source_of_truth'] ?? 'filesystem') !== 'filesystem') {
                return false;
            }

            $environments = $this->config['runtime_override_environments'] ?? [];
            if (! is_array($environments) || [] === $environments) {
                return true;
            }

            return in_array(wp_get_environment_type(), $environments, true);
        }

        public function maybe_override_the_content(string $content): string
        {
            if (! $this->should_enable_runtime_override()) {
                return $content;
            }

            if (is_admin() || is_feed() || is_preview() || ! is_singular('page') || ! in_the_loop() || ! is_main_query()) {
                return $content;
            }

            if ((defined('REST_REQUEST') && REST_REQUEST) || (defined('WP_CLI') && WP_CLI)) {
                return $content;
            }

            $post = get_post();
            if (! $post instanceof WP_Post || ! $this->supports_post($post)) {
                return $content;
            }

            $path = $this->resolve_path_for_post($post);
            if (! is_file($path)) {
                return $content;
            }

            try {
                $payload = $this->load_json_payload($path);
                return $this->serialize_blocks_for_storage($payload['blocks']);
            } catch (Throwable) {
                return $content;
            }
        }

        public function export_post(int $post_id, array $options = []): array
        {
            $post = get_post($post_id);
            if (! $post instanceof WP_Post) {
                throw new RuntimeException(sprintf('Post not found: %d', $post_id));
            }

            $this->assert_supported_post($post);

            $blocks = $this->parse_post_blocks($post);
            $payload = $this->build_payload($post, $blocks);
            $path = $this->resolve_path_for_post($post, $options['dir'] ?? null);
            $force = ! empty($options['force']);
            $dry_run = ! empty($options['dry_run']);
            $action = is_file($path) ? 'updated' : 'created';

            if (is_file($path)) {
                $existing_payload = $this->load_json_payload($path);
                $existing_hash = $this->extract_payload_hash($existing_payload);

                if ($existing_hash === $payload['contentHash']) {
                    return $this->build_result('no-change', $post, $path, $payload['contentHash']);
                }

                if (! $force && $this->is_file_newer_than_post($path, $existing_payload, $post)) {
                    throw new RuntimeException(
                        sprintf(
                            'Export conflict for "%s". The filesystem copy appears newer than the database. Re-run with --force to overwrite.',
                            $post->post_name
                        )
                    );
                }
            }

            if ($dry_run) {
                return $this->build_result('dry-run:' . $action, $post, $path, $payload['contentHash']);
            }

            $this->write_payload_to_file($payload, $path);

            return $this->build_result($action, $post, $path, $payload['contentHash']);
        }

        public function import_slug(string $slug, array $options = []): array
        {
            $normalized_slug = $this->normalize_slug_input($slug);
            if ('' === $normalized_slug) {
                throw new RuntimeException('A non-empty page slug is required for import.');
            }

            $path = $this->resolve_path_for_slug($normalized_slug, 'page', $options['dir'] ?? null);
            if (! is_file($path)) {
                throw new RuntimeException(sprintf('Content file not found: %s', $path));
            }

            $payload = $this->load_json_payload($path);
            $lookup_path = isset($payload['path']) && is_string($payload['path']) && '' !== $payload['path']
                ? $this->normalize_slug_input((string) $payload['path'])
                : $normalized_slug;

            $post = get_page_by_path($lookup_path, OBJECT, 'page');
            if (! $post instanceof WP_Post) {
                throw new RuntimeException(sprintf('Page not found for slug/path "%s".', $lookup_path));
            }

            $this->assert_supported_post($post);

            $force = ! empty($options['force']);
            $dry_run = ! empty($options['dry_run']);
            $db_hash = $this->compute_content_hash($this->parse_post_blocks($post));
            $file_hash = $this->extract_payload_hash($payload);

            if ($db_hash === $file_hash) {
                return $this->build_result('no-change', $post, $path, $file_hash);
            }

            if (! $force && $this->is_post_newer_than_payload($post, $payload, $path)) {
                throw new RuntimeException(
                    sprintf(
                        'Import conflict for "%s". The database copy appears newer than the file. Re-run with --force to overwrite.',
                        $lookup_path
                    )
                );
            }

            if ($dry_run) {
                return $this->build_result('dry-run:updated', $post, $path, $file_hash);
            }

            $serialized = $this->serialize_blocks_for_storage($payload['blocks']);
            $result = wp_update_post(
                [
                    'ID' => $post->ID,
                    'post_content' => $serialized,
                ],
                true
            );

            if ($result instanceof WP_Error) {
                throw new RuntimeException(sprintf('Unable to import page "%s": %s', $lookup_path, $result->get_error_message()));
            }

            return $this->build_result('updated', $post, $path, $file_hash);
        }

        public function load_blocks_from_file(string $slug): array
        {
            $path = $this->resolve_path_for_slug($slug);

            return $this->load_json_payload($path)['blocks'];
        }

        public function validate_payload(array $payload): void
        {
            $this->normalize_payload($payload);
        }

        public function validate_block_list(array $blocks, string $path = 'blocks'): void
        {
            foreach ($blocks as $index => $block) {
                $this->normalize_block($block, $path . '[' . $index . ']');
            }
        }

        public function walk_blocks(array $blocks, callable $callback): array
        {
            $walk = function (array $items, array $path) use (&$walk, $callback): array {
                $transformed = [];

                foreach ($items as $index => $block) {
                    $current_path = array_merge($path, [$index]);
                    $normalized = $this->normalize_block($block, 'blocks[' . implode('][', $current_path) . ']');
                    $normalized['innerBlocks'] = $walk($normalized['innerBlocks'], $current_path);
                    $updated = $callback($normalized, $current_path);

                    if (! is_array($updated)) {
                        throw new InvalidArgumentException('walk_blocks callback must return a block array.');
                    }

                    $transformed[] = $this->normalize_block($updated, 'blocks[' . implode('][', $current_path) . ']');
                }

                return $transformed;
            };

            return $walk($blocks, []);
        }

        public function serialize_blocks_for_storage(array $blocks): string
        {
            $normalized_blocks = array_map(
                fn (array $block, int $index): array => $this->normalize_block($block, 'blocks[' . $index . ']'),
                $blocks,
                array_keys($blocks)
            );

            return serialize_blocks($normalized_blocks);
        }

        public function compute_content_hash(array $blocks): string
        {
            return hash('sha256', $this->serialize_blocks_for_storage($blocks));
        }

        public function resolve_path_for_post(WP_Post $post, ?string $content_dir = null): string
        {
            $this->assert_supported_post($post);

            $page_path = get_page_uri($post);
            if (! is_string($page_path) || '' === $page_path) {
                $page_path = $post->post_name;
            }

            return $this->resolve_path_for_slug($page_path, $post->post_type, $content_dir);
        }

        public function resolve_path_for_slug(string $slug, string $post_type = 'page', ?string $content_dir = null): string
        {
            $normalized_slug = $this->normalize_slug_input($slug);
            if ('' === $normalized_slug) {
                throw new InvalidArgumentException('The slug/path used to resolve a content file cannot be empty.');
            }

            $normalized_post_type = sanitize_key($post_type);
            if ('' === $normalized_post_type) {
                throw new InvalidArgumentException('The post type used to resolve a content file cannot be empty.');
            }

            $segments = array_map('sanitize_title', array_filter(explode('/', $normalized_slug), 'strlen'));
            if ([] === $segments) {
                throw new InvalidArgumentException('Unable to derive a valid content filename from the provided slug/path.');
            }

            $filename = $normalized_post_type . '-' . implode('--', $segments) . '.json';

            return trailingslashit($this->resolve_content_directory($content_dir)) . $filename;
        }

        private function parse_post_blocks(WP_Post $post): array
        {
            $blocks = parse_blocks((string) $post->post_content);
            $this->validate_block_list($blocks);

            return $blocks;
        }

        private function build_payload(WP_Post $post, array $blocks): array
        {
            $page_path = get_page_uri($post);
            if (! is_string($page_path) || '' === $page_path) {
                $page_path = $post->post_name;
            }

            return [
                'version' => 1,
                'postType' => $post->post_type,
                'slug' => $post->post_name,
                'path' => $this->normalize_slug_input($page_path),
                'postId' => (int) $post->ID,
                'updatedAtGmt' => $this->normalize_gmt_string($post->post_modified_gmt) ?? gmdate('Y-m-d H:i:s'),
                'contentHash' => $this->compute_content_hash($blocks),
                'blocks' => $blocks,
            ];
        }

        private function build_result(string $action, WP_Post $post, string $path, string $hash): array
        {
            return [
                'action' => $action,
                'post_id' => (int) $post->ID,
                'post_type' => $post->post_type,
                'slug' => $post->post_name,
                'path' => $path,
                'content_hash' => $hash,
            ];
        }

        private function normalize_payload(array $payload): array
        {
            if (! array_key_exists('blocks', $payload) || ! is_array($payload['blocks'])) {
                throw new InvalidArgumentException('Payload must contain a "blocks" array.');
            }

            $post_type = isset($payload['postType']) ? sanitize_key((string) $payload['postType']) : 'page';
            $slug = isset($payload['slug']) ? sanitize_title((string) $payload['slug']) : '';
            $path = isset($payload['path']) ? $this->normalize_slug_input((string) $payload['path']) : $slug;
            $updated_at = isset($payload['updatedAtGmt']) ? $this->normalize_gmt_string((string) $payload['updatedAtGmt']) : null;
            $content_hash = isset($payload['contentHash']) ? strtolower((string) $payload['contentHash']) : '';

            if ('' === $post_type) {
                throw new InvalidArgumentException('Payload "postType" must be a non-empty string.');
            }

            if ('' === $slug) {
                throw new InvalidArgumentException('Payload "slug" must be a non-empty string.');
            }

            $blocks = [];
            foreach ($payload['blocks'] as $index => $block) {
                $blocks[] = $this->normalize_block($block, 'blocks[' . $index . ']');
            }

            return [
                'version' => isset($payload['version']) ? (int) $payload['version'] : 1,
                'postType' => $post_type,
                'slug' => $slug,
                'path' => '' !== $path ? $path : $slug,
                'postId' => isset($payload['postId']) ? (int) $payload['postId'] : 0,
                'updatedAtGmt' => $updated_at,
                'contentHash' => $content_hash,
                'blocks' => $blocks,
            ];
        }

        private function normalize_block(mixed $block, string $path): array
        {
            if (! is_array($block)) {
                throw new InvalidArgumentException(sprintf('Block at %s must be an object-like array.', $path));
            }

            foreach (['blockName', 'attrs', 'innerBlocks', 'innerHTML', 'innerContent'] as $required_key) {
                if (! array_key_exists($required_key, $block)) {
                    throw new InvalidArgumentException(sprintf('Missing required key "%s" at %s.', $required_key, $path));
                }
            }

            $block_name = $block['blockName'];
            if (! is_string($block_name) && null !== $block_name) {
                throw new InvalidArgumentException(sprintf('The "blockName" value at %s must be a string or null.', $path));
            }

            $attrs = $block['attrs'];
            if (null === $attrs) {
                $attrs = [];
            }
            if (! is_array($attrs)) {
                throw new InvalidArgumentException(sprintf('The "attrs" value at %s must be an array.', $path));
            }

            $inner_blocks = $block['innerBlocks'];
            if (! is_array($inner_blocks)) {
                throw new InvalidArgumentException(sprintf('The "innerBlocks" value at %s must be an array.', $path));
            }

            $inner_html = $block['innerHTML'];
            if (! is_string($inner_html)) {
                throw new InvalidArgumentException(sprintf('The "innerHTML" value at %s must be a string.', $path));
            }

            $inner_content = $block['innerContent'];
            if (! is_array($inner_content)) {
                throw new InvalidArgumentException(sprintf('The "innerContent" value at %s must be an array.', $path));
            }

            foreach ($inner_content as $inner_index => $inner_fragment) {
                if (! is_string($inner_fragment) && null !== $inner_fragment) {
                    throw new InvalidArgumentException(
                        sprintf('The "innerContent[%d]" value at %s must be a string or null.', $inner_index, $path)
                    );
                }
            }

            $normalized_inner_blocks = [];
            foreach ($inner_blocks as $inner_index => $inner_block) {
                $normalized_inner_blocks[] = $this->normalize_block($inner_block, $path . '.innerBlocks[' . $inner_index . ']');
            }

            return [
                'blockName' => $block_name,
                'attrs' => $attrs,
                'innerBlocks' => $normalized_inner_blocks,
                'innerHTML' => $inner_html,
                'innerContent' => array_values($inner_content),
            ];
        }

        private function resolve_content_directory(?string $override = null): string
        {
            $path = is_string($override) && '' !== trim($override)
                ? trim($override)
                : (string) ($this->config['content_path'] ?? '');

            if ('' === $path) {
                throw new RuntimeException('No content directory has been configured for theme content sync.');
            }

            if (! $this->is_absolute_path($path)) {
                $path = trailingslashit(ABSPATH) . ltrim($path, '/\\');
            }

            return untrailingslashit($path);
        }

        private function write_payload_to_file(array $payload, string $path): void
        {
            $directory = dirname($path);
            if (! is_dir($directory) && ! wp_mkdir_p($directory)) {
                throw new RuntimeException(sprintf('Unable to create content directory: %s', $directory));
            }

            $json = wp_json_encode(
                $payload,
                JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE
            );

            if (! is_string($json)) {
                throw new RuntimeException('Unable to encode the blocks payload as JSON.');
            }

            $json .= "\n";

            $temp_path = tempnam($directory, 'd11-content-sync-');
            if (false === $temp_path) {
                throw new RuntimeException(sprintf('Unable to create a temporary file in %s.', $directory));
            }

            $bytes_written = file_put_contents($temp_path, $json, LOCK_EX);
            if (false === $bytes_written) {
                @unlink($temp_path);
                throw new RuntimeException(sprintf('Unable to write content file: %s', $path));
            }

            if (! @rename($temp_path, $path)) {
                @unlink($temp_path);
                throw new RuntimeException(sprintf('Unable to finalize content file: %s', $path));
            }

            unset($this->runtime_cache[$this->build_cache_key($path)]);
        }

        private function load_json_payload(string $path): array
        {
            if (! is_file($path) || ! is_readable($path)) {
                throw new RuntimeException(sprintf('Unable to read content file: %s', $path));
            }

            $cache_key = $this->build_cache_key($path);
            if (! empty($this->config['cache_json_reads'])) {
                if (isset($this->runtime_cache[$cache_key])) {
                    return $this->runtime_cache[$cache_key];
                }

                $cached = wp_cache_get($cache_key, 'd11_content_sync');
                if (is_array($cached)) {
                    $this->runtime_cache[$cache_key] = $cached;
                    return $cached;
                }
            }

            $raw_json = file_get_contents($path);
            if (false === $raw_json) {
                throw new RuntimeException(sprintf('Unable to read content file: %s', $path));
            }

            $decoded = json_decode($raw_json, true);
            if (JSON_ERROR_NONE !== json_last_error()) {
                throw new InvalidArgumentException(sprintf('Invalid JSON in %s: %s', $path, json_last_error_msg()));
            }

            if (! is_array($decoded)) {
                throw new InvalidArgumentException(sprintf('Content file must decode to a JSON object: %s', $path));
            }

            $payload = $this->normalize_payload($decoded);
            if ('' === $payload['contentHash']) {
                $payload['contentHash'] = $this->compute_content_hash($payload['blocks']);
            }

            if (! empty($this->config['cache_json_reads'])) {
                $this->runtime_cache[$cache_key] = $payload;
                wp_cache_set($cache_key, $payload, 'd11_content_sync');
            }

            return $payload;
        }

        private function extract_payload_hash(array $payload): string
        {
            $hash = isset($payload['contentHash']) ? strtolower((string) $payload['contentHash']) : '';

            if ('' === $hash) {
                return $this->compute_content_hash($payload['blocks'] ?? []);
            }

            return $hash;
        }

        private function is_file_newer_than_post(string $path, array $payload, WP_Post $post): bool
        {
            $file_timestamp = $this->payload_timestamp($payload);
            if (null === $file_timestamp && is_file($path)) {
                $file_timestamp = filemtime($path) ?: null;
            }

            $post_timestamp = $this->post_timestamp($post);
            if (null === $file_timestamp || null === $post_timestamp) {
                return true;
            }

            return $file_timestamp > $post_timestamp;
        }

        private function is_post_newer_than_payload(WP_Post $post, array $payload, string $path): bool
        {
            $post_timestamp = $this->post_timestamp($post);
            $file_timestamp = $this->payload_timestamp($payload);

            if (null === $file_timestamp && is_file($path)) {
                $file_timestamp = filemtime($path) ?: null;
            }

            if (null === $post_timestamp || null === $file_timestamp) {
                return true;
            }

            return $post_timestamp > $file_timestamp;
        }

        private function payload_timestamp(array $payload): ?int
        {
            if (empty($payload['updatedAtGmt']) || ! is_string($payload['updatedAtGmt'])) {
                return null;
            }

            $timestamp = strtotime($payload['updatedAtGmt'] . ' UTC');

            return false === $timestamp ? null : $timestamp;
        }

        private function post_timestamp(WP_Post $post): ?int
        {
            if (empty($post->post_modified_gmt) || '0000-00-00 00:00:00' === $post->post_modified_gmt) {
                return null;
            }

            $timestamp = strtotime($post->post_modified_gmt . ' UTC');

            return false === $timestamp ? null : $timestamp;
        }

        private function normalize_gmt_string(string $value): ?string
        {
            $trimmed = trim($value);
            if ('' === $trimmed || '0000-00-00 00:00:00' === $trimmed) {
                return null;
            }

            $timestamp = strtotime($trimmed . ' UTC');
            if (false === $timestamp) {
                return null;
            }

            return gmdate('Y-m-d H:i:s', $timestamp);
        }

        private function build_cache_key(string $path): string
        {
            $mtime = is_file($path) ? (string) filemtime($path) : '0';

            return md5($path . '|' . $mtime);
        }

        private function supports_post(WP_Post $post): bool
        {
            $post_types = $this->config['post_types'] ?? ['page'];

            return in_array($post->post_type, $post_types, true);
        }

        private function assert_supported_post(WP_Post $post): void
        {
            if (! $this->supports_post($post)) {
                throw new RuntimeException(sprintf('Unsupported post type "%s".', $post->post_type));
            }

            if ('' === (string) $post->post_name) {
                throw new RuntimeException(sprintf('Post %d does not have a usable slug.', $post->ID));
            }
        }

        private function normalize_slug_input(string $slug): string
        {
            $trimmed = trim($slug, " \t\n\r\0\x0B/");
            if ('' === $trimmed) {
                return '';
            }

            $segments = array_map('sanitize_title', array_filter(explode('/', $trimmed), 'strlen'));

            return implode('/', $segments);
        }

        private function is_absolute_path(string $path): bool
        {
            return 1 === preg_match('#^(?:[A-Za-z]:[\\\\/]|/)#', $path);
        }
    }
}
