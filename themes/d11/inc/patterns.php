<?php

declare(strict_types=1);

/**
 * Registers the theme block pattern category and theme-owned PHP patterns.
 */

if (! defined('ABSPATH')) {
    exit;
}

/**
 * Creates the custom pattern category used by this theme.
 */
function d11_register_pattern_category(): void
{
    register_block_pattern_category(
        'd11',
        ['label' => __('D11', 'd11')]
    );
}
add_action('init', 'd11_register_pattern_category');

/**
 * Registers PHP-backed theme patterns from the theme patterns directory.
 */
function d11_register_theme_patterns(): void
{
    $pattern_files = glob(get_theme_file_path('patterns/*.php')) ?: [];

    foreach ($pattern_files as $pattern_file) {
        $pattern_data = get_file_data(
            $pattern_file,
            [
                'title' => 'Title',
                'slug' => 'Slug',
                'description' => 'Description',
                'categories' => 'Categories',
                'keywords' => 'Keywords',
                'viewportWidth' => 'Viewport Width',
                'blockTypes' => 'Block Types',
                'postTypes' => 'Post Types',
                'inserter' => 'Inserter',
                'templateTypes' => 'Template Types',
            ]
        );

        $slug = isset($pattern_data['slug']) ? trim((string) $pattern_data['slug']) : '';
        $title = isset($pattern_data['title']) ? trim((string) $pattern_data['title']) : '';

        if (
            '' === $slug
            || ! preg_match('/^[a-z0-9-]+\/[a-z0-9-]+$/', $slug)
            || '' === $title
            || ! function_exists('register_block_pattern')
        ) {
            continue;
        }

        if (WP_Block_Patterns_Registry::get_instance()->is_registered($slug)) {
            continue;
        }

        ob_start();
        include $pattern_file;
        $content = trim((string) ob_get_clean());

        if ('' === $content) {
            continue;
        }

        $properties = [
            'title' => $title,
            'content' => $content,
        ];

        if (! empty($pattern_data['description'])) {
            $properties['description'] = (string) $pattern_data['description'];
        }

        foreach (
            [
                'categories' => 'categories',
                'keywords' => 'keywords',
                'blockTypes' => 'blockTypes',
                'postTypes' => 'postTypes',
                'templateTypes' => 'templateTypes',
            ] as $source_key => $target_key
        ) {
            if (empty($pattern_data[$source_key])) {
                continue;
            }

            $properties[$target_key] = array_values(
                array_filter(
                    array_map('trim', explode(',', (string) $pattern_data[$source_key]))
                )
            );
        }

        if (! empty($pattern_data['viewportWidth'])) {
            $properties['viewportWidth'] = (int) $pattern_data['viewportWidth'];
        }

        if (isset($pattern_data['inserter']) && '' !== (string) $pattern_data['inserter']) {
            $properties['inserter'] = 'no' !== strtolower(trim((string) $pattern_data['inserter']));
        }

        register_block_pattern($slug, $properties);
    }
}
add_action('init', 'd11_register_theme_patterns', 20);
