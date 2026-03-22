<?php

declare(strict_types=1);

if (! defined('ABSPATH')) {
    exit;
}

if (! class_exists('D11_Content_Sync_Config')) {
    final class D11_Content_Sync_Config
    {
        public static function get(string $theme_sync_root): array
        {
            $defaults_path = untrailingslashit($theme_sync_root) . '/config.php';
            $defaults = file_exists($defaults_path) ? require $defaults_path : [];

            if (! is_array($defaults)) {
                $defaults = [];
            }

            $config = apply_filters('d11_content_sync_config', $defaults);

            return self::normalize($config, $defaults, $theme_sync_root);
        }

        private static function normalize(mixed $config, array $defaults, string $theme_sync_root): array
        {
            if (! is_array($config)) {
                $config = [];
            }

            $merged = array_merge($defaults, $config);
            $content_path = isset($merged['content_path']) ? (string) $merged['content_path'] : $theme_sync_root . '/../../content';

            return [
                'enabled' => ! empty($merged['enabled']),
                'content_path' => self::normalize_path($content_path, $theme_sync_root),
                'source_of_truth' => self::normalize_source_of_truth($merged['source_of_truth'] ?? 'filesystem'),
                'runtime_override' => ! empty($merged['runtime_override']),
                'runtime_override_environments' => self::normalize_environments($merged['runtime_override_environments'] ?? []),
                'post_types' => self::normalize_post_types($merged['post_types'] ?? ['page']),
                'conflict_policy' => self::normalize_conflict_policy($merged['conflict_policy'] ?? 'fail'),
                'cache_json_reads' => ! empty($merged['cache_json_reads']),
            ];
        }

        private static function normalize_path(string $path, string $theme_sync_root): string
        {
            $trimmed = trim($path);

            if ('' === $trimmed) {
                return untrailingslashit($theme_sync_root) . '/../../content';
            }

            if (self::is_absolute_path($trimmed)) {
                return untrailingslashit($trimmed);
            }

            return untrailingslashit(ABSPATH) . '/' . ltrim($trimmed, '/\\');
        }

        private static function normalize_source_of_truth(mixed $value): string
        {
            $source = sanitize_key((string) $value);

            return in_array($source, ['filesystem', 'database'], true) ? $source : 'filesystem';
        }

        private static function normalize_conflict_policy(mixed $value): string
        {
            $policy = sanitize_key((string) $value);

            return in_array($policy, ['fail', 'filesystem', 'newest'], true) ? $policy : 'fail';
        }

        private static function normalize_post_types(mixed $value): array
        {
            if (! is_array($value)) {
                $value = ['page'];
            }

            $post_types = array_values(array_filter(array_map(
                static fn (mixed $post_type): string => sanitize_key((string) $post_type),
                $value
            )));

            return [] !== $post_types ? $post_types : ['page'];
        }

        private static function normalize_environments(mixed $value): array
        {
            if (! is_array($value)) {
                return [];
            }

            return array_values(array_filter(array_map(
                static fn (mixed $environment): string => sanitize_key((string) $environment),
                $value
            )));
        }

        private static function is_absolute_path(string $path): bool
        {
            return 1 === preg_match('#^(?:[A-Za-z]:[\\\\/]|/)#', $path);
        }
    }
}
