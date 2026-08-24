<?php

declare(strict_types=1);

if (! defined('ABSPATH')) {
    exit;
}

/**
 * Returns public post types supported by the SEO toolbox.
 */
function d11_seo_supported_post_types(): array
{
    $post_types = get_post_types(
        [
            'public' => true,
        ],
        'names'
    );

    unset($post_types['attachment']);

    return array_values($post_types);
}

/**
 * Checks whether a post type is supported by the SEO toolbox.
 */
function d11_seo_is_supported_post_type(string $post_type): bool
{
    return in_array($post_type, d11_seo_supported_post_types(), true);
}

/**
 * Registers REST-exposed post meta used by the block editor.
 */
function d11_seo_register_post_meta(): void
{
    $meta_keys = [
        '_seo_title' => [
            'type' => 'string',
            'sanitize_callback' => 'sanitize_text_field',
        ],
        '_seo_description' => [
            'type' => 'string',
            'sanitize_callback' => 'sanitize_textarea_field',
        ],
        '_seo_noindex' => [
            'type' => 'boolean',
            'sanitize_callback' => 'rest_sanitize_boolean',
        ],
        '_seo_nofollow' => [
            'type' => 'boolean',
            'sanitize_callback' => 'rest_sanitize_boolean',
        ],
    ];

    foreach (d11_seo_supported_post_types() as $post_type) {
        foreach ($meta_keys as $meta_key => $meta_args) {
            register_post_meta(
                $post_type,
                $meta_key,
                [
                    'single' => true,
                    'show_in_rest' => true,
                    'type' => $meta_args['type'],
                    'default' => $meta_args['type'] === 'boolean' ? false : '',
                    'sanitize_callback' => $meta_args['sanitize_callback'],
                    'auth_callback' => static function (bool $allowed, string $meta_key, int $post_id): bool {
                        return current_user_can('edit_post', $post_id);
                    },
                ]
            );
        }
    }
}
add_action('init', 'd11_seo_register_post_meta');

/**
 * Returns the current post-like object used for front-end meta output.
 */
function d11_seo_target_post(): ?WP_Post
{
    if (is_home() && ! is_front_page()) {
        $blog_page_id = (int) get_option('page_for_posts');

        return $blog_page_id > 0 ? get_post($blog_page_id) : null;
    }

    if (is_front_page() || is_singular()) {
        $target = get_queried_object();

        return $target instanceof WP_Post ? $target : null;
    }

    return null;
}

/**
 * Generates a default SEO description from the available post content.
 */
function d11_seo_default_description(WP_Post $post): string
{
    $content = has_excerpt($post) ? $post->post_excerpt : $post->post_content;
    $description = wp_trim_words(wp_strip_all_tags((string) $content), 30, '...');

    if ($description !== '') {
        return $description;
    }

    return (string) get_bloginfo('description', 'display');
}

/**
 * Returns the effective SEO title and description for a post.
 *
 * @return array{title: string, description: string}
 */
function d11_seo_resolve_meta(WP_Post $post): array
{
    $site_name = (string) get_bloginfo('name');
    $post_title = trim((string) get_the_title($post));
    $default_title = $post_title !== '' ? sprintf('%s - %s', $post_title, $site_name) : $site_name;

    return [
        'title' => (string) (get_post_meta($post->ID, '_seo_title', true) ?: $default_title),
        'description' => (string) (get_post_meta($post->ID, '_seo_description', true) ?: d11_seo_default_description($post)),
    ];
}

/**
 * Builds the effective robots directives for the current request.
 *
 * @return array{noindex: bool, nofollow: bool}
 */
function d11_seo_resolve_robots(): array
{
    $target = d11_seo_target_post();

    $noindex = false;
    $nofollow = false;

    if ($target instanceof WP_Post) {
        $noindex = $noindex || rest_sanitize_boolean(get_post_meta($target->ID, '_seo_noindex', true));
        $nofollow = $nofollow || rest_sanitize_boolean(get_post_meta($target->ID, '_seo_nofollow', true));
    }

    return [
        'noindex' => $noindex,
        'nofollow' => $nofollow,
    ];
}

/**
 * Injects SEO robots directives through the core robots API.
 *
 * @param array<string, bool|string> $robots
 * @return array<string, bool|string>
 */
function d11_seo_filter_wp_robots(array $robots): array
{
    $directives = d11_seo_resolve_robots();

    if ($directives['noindex']) {
        unset($robots['index']);
        $robots['noindex'] = true;
    }

    if ($directives['nofollow']) {
        unset($robots['follow']);
        $robots['nofollow'] = true;
    }

    return $robots;
}
add_filter('wp_robots', 'd11_seo_filter_wp_robots');

/**
 * Uses a custom SEO title as the full document title when one is set.
 */
function d11_seo_filter_document_title(string $title): string
{
    $target = d11_seo_target_post();

    if (! $target instanceof WP_Post) {
        return $title;
    }

    $custom_title = trim((string) get_post_meta($target->ID, '_seo_title', true));

    return $custom_title !== '' ? $custom_title : $title;
}
add_filter('pre_get_document_title', 'd11_seo_filter_document_title');

/**
 * Excludes individually noindexed posts from the core XML sitemap.
 *
 * @param array<string, mixed> $args
 * @return array<string, mixed>
 */
function d11_seo_filter_sitemap_posts_query_args(array $args, string $post_type): array
{
    $noindex_query = [
        'relation' => 'OR',
        [
            'key' => '_seo_noindex',
            'compare' => 'NOT EXISTS',
        ],
        [
            'key' => '_seo_noindex',
            'value' => '1',
            'compare' => '!=',
        ],
    ];

    if (isset($args['meta_query']) && is_array($args['meta_query'])) {
        $args['meta_query'] = [
            'relation' => 'AND',
            $args['meta_query'],
            $noindex_query,
        ];

        return $args;
    }

    $args['meta_query'] = $noindex_query;

    return $args;
}
add_filter('wp_sitemaps_posts_query_args', 'd11_seo_filter_sitemap_posts_query_args', 10, 2);

/**
 * Returns the preferred image URL for social previews.
 */
function d11_seo_resolve_image_url(?WP_Post $post = null): string
{
    if ($post instanceof WP_Post) {
        $image_url = (string) get_the_post_thumbnail_url($post, 'full');
        if ($image_url !== '') {
            return $image_url;
        }
    }

    $front_page_id = (int) get_option('page_on_front');
    if ($front_page_id > 0) {
        $front_page_image = (string) get_the_post_thumbnail_url($front_page_id, 'full');
        if ($front_page_image !== '') {
            return $front_page_image;
        }
    }

    return (string) get_site_icon_url();
}

/**
 * Outputs description, Open Graph, and Twitter tags.
 */
function d11_seo_output_head_tags(): void
{
    $target = d11_seo_target_post();
    $image_url = d11_seo_resolve_image_url($target);

    if (! $target instanceof WP_Post) {
        if ($image_url !== '') {
            echo '<meta property="og:image" content="' . esc_url($image_url) . '" />' . "\n";
            echo '<meta property="og:image:width" content="1200" />' . "\n";
            echo '<meta property="og:image:height" content="630" />' . "\n";
            echo '<meta name="twitter:card" content="summary_large_image" />' . "\n";
            echo '<meta name="twitter:image" content="' . esc_url($image_url) . '" />' . "\n";
        }

        return;
    }

    $meta = d11_seo_resolve_meta($target);
    $permalink = (string) get_permalink($target);
    $og_type = is_singular('post') ? 'article' : 'website';

    echo '<meta name="description" content="' . esc_attr($meta['description']) . '" />' . "\n";
    echo '<meta property="og:type" content="' . esc_attr($og_type) . '" />' . "\n";
    echo '<meta property="og:site_name" content="' . esc_attr((string) get_bloginfo('name')) . '" />' . "\n";
    echo '<meta property="og:title" content="' . esc_attr($meta['title']) . '" />' . "\n";
    echo '<meta property="og:description" content="' . esc_attr($meta['description']) . '" />' . "\n";
    echo '<meta property="og:url" content="' . esc_url($permalink) . '" />' . "\n";
    echo '<meta name="twitter:card" content="summary_large_image" />' . "\n";
    echo '<meta name="twitter:title" content="' . esc_attr($meta['title']) . '" />' . "\n";
    echo '<meta name="twitter:description" content="' . esc_attr($meta['description']) . '" />' . "\n";

    if ($image_url !== '') {
        echo '<meta property="og:image" content="' . esc_url($image_url) . '" />' . "\n";
        echo '<meta name="twitter:image" content="' . esc_url($image_url) . '" />' . "\n";
    }
}
add_action('wp_head', 'd11_seo_output_head_tags', 5);
