<?php

declare(strict_types=1);

if (! defined('ABSPATH')) {
    exit;
}

/**
 * Returns the option name used to persist block availability settings.
 */
function d11_block_availability_option_name(): string
{
    return 'd11_block_availability_settings';
}

/**
 * Returns the curated default block groups used by the theme.
 */
function d11_curated_block_groups(): array
{
    return [
        'core' => [
            'label' => __('Core', 'd11'),
            'description' => __('Content and theme structure blocks always available to the theme.', 'd11'),
            'blocks' => [
                'core/group',
                'core/columns',
                'core/column',
                'core/spacer',
                'core/separator',
                'core/heading',
                'core/paragraph',
                'core/list',
                'core/list-item',
                'core/quote',
                'core/details',
                'core/image',
                'core/gallery',
                'core/cover',
                'core/media-text',
                'core/buttons',
                'core/button',
                'core/accordion',
                'core/accordion-item',
                'core/accordion-heading',
                'core/accordion-panel',
                'core/social-links',
                'core/social-link',
                'core/search',
                'core/navigation',
                'core/navigation-link',
                'core/navigation-submenu',
                'core/home-link',
                'core/template-part',
                'core/site-logo',
                'core/site-title',
                'core/site-tagline',
            ],
        ],
        'blog' => [
            'label' => __('Blog', 'd11'),
            'description' => __('Dynamic post and query blocks used for editorial content.', 'd11'),
            'blocks' => [
                'core/query',
                'core/post-template',
                'core/query-title',
                'core/query-total',
                'core/query-no-results',
                'core/query-pagination',
                'core/query-pagination-previous',
                'core/query-pagination-numbers',
                'core/query-pagination-next',
                'core/post-title',
                'core/post-content',
                'core/post-excerpt',
                'core/post-date',
                'core/post-featured-image',
                'core/post-terms',
                'core/post-navigation-link',
            ],
        ],
        'woocommerce' => [
            'label' => __('WooCommerce', 'd11'),
            'description' => __('Commerce-specific blocks available only when WooCommerce is active.', 'd11'),
            'blocks' => [],
        ],
        'third_party' => [
            'label' => __('Third-Party', 'd11'),
            'description' => __('Blocks registered by installed plugins or external code outside the theme-managed categories.', 'd11'),
            'blocks' => [],
        ],
        'custom' => [
            'label' => __('Custom', 'd11'),
            'description' => __('Theme custom blocks managed separately from the curated core categories.', 'd11'),
            'blocks' => [],
        ],
    ];
}

/**
 * Returns all registered block types keyed by name.
 */
function d11_get_registered_block_types(): array
{
    if (! class_exists('WP_Block_Type_Registry')) {
        return [];
    }

    return WP_Block_Type_Registry::get_instance()->get_all_registered();
}

/**
 * Returns all registered block names for a namespace prefix.
 */
function d11_get_registered_block_names_by_prefix(string $prefix): array
{
    $block_names = [];

    foreach (d11_get_registered_block_types() as $block_name => $block_type) {
        if (! is_string($block_name) || ! str_starts_with($block_name, $prefix)) {
            continue;
        }

        $block_names[] = $block_name;
    }

    sort($block_names);

    return array_values(array_unique($block_names));
}

/**
 * Returns the registered core block names that belong in the blog category.
 */
function d11_get_registered_blog_block_names(): array
{
    $blog_blocks = d11_curated_block_groups()['blog']['blocks'];
    $forced_core_lookup = array_fill_keys(
        d11_curated_block_groups()['core']['blocks'],
        true
    );

    foreach (d11_get_registered_block_types() as $block_name => $block_type) {
        if (! is_string($block_name) || ! str_starts_with($block_name, 'core/')) {
            continue;
        }

        if (isset($forced_core_lookup[$block_name])) {
            continue;
        }

        if (method_exists($block_type, 'is_dynamic') && $block_type->is_dynamic()) {
            $blog_blocks[] = $block_name;
        }
    }

    sort($blog_blocks);

    return array_values(array_unique($blog_blocks));
}

/**
 * Returns the registered core block names that belong in the core category.
 */
function d11_get_registered_core_block_names(): array
{
    $core_blocks = d11_get_registered_block_names_by_prefix('core/');
    $blog_lookup = array_fill_keys(d11_get_registered_blog_block_names(), true);

    return array_values(array_filter(
        $core_blocks,
        static fn (string $block_name): bool => ! isset($blog_lookup[$block_name])
    ));
}

/**
 * Returns whether WooCommerce is active in the current request.
 */
function d11_has_woocommerce(): bool
{
    return class_exists('WooCommerce') || defined('WC_VERSION');
}

/**
 * Returns registered WooCommerce block names.
 */
function d11_get_woocommerce_block_names(): array
{
    if (! d11_has_woocommerce()) {
        return [];
    }

    return d11_get_registered_block_names_by_prefix('woocommerce/');
}

/**
 * Returns registered third-party block names outside the theme-managed namespaces.
 */
function d11_get_third_party_block_names(): array
{
    $block_names = [];

    foreach (d11_get_registered_block_types() as $block_name => $block_type) {
        if (! is_string($block_name) || ! str_contains($block_name, '/')) {
            continue;
        }

        if (
            str_starts_with($block_name, 'core/')
            || str_starts_with($block_name, 'woocommerce/')
            || str_starts_with($block_name, 'custom/')
        ) {
            continue;
        }

        $block_names[] = $block_name;
    }

    sort($block_names);

    return array_values(array_unique($block_names));
}

/**
 * Returns the full block catalog grouped by category.
 */
function d11_get_block_catalog(): array
{
    $groups = d11_curated_block_groups();
    $groups['core']['blocks'] = d11_get_registered_core_block_names();
    $groups['blog']['blocks'] = d11_get_registered_blog_block_names();
    $groups['woocommerce']['blocks'] = d11_get_woocommerce_block_names();
    $groups['third_party']['blocks'] = d11_get_third_party_block_names();
    $groups['custom']['blocks'] = d11_get_custom_block_names();

    return $groups;
}

/**
 * Returns the categories shown in the admin UI.
 */
function d11_get_block_availability_admin_categories(): array
{
    $groups = d11_get_block_catalog();

    if (! d11_has_woocommerce()) {
        unset($groups['woocommerce']);
    }

    return $groups;
}

/**
 * Returns the enabled-by-default category flags.
 */
function d11_get_default_enabled_block_categories(): array
{
    return [
        'blog' => true,
    ];
}

/**
 * Returns the default allowed block map derived from the runtime catalog.
 */
function d11_get_default_allowed_block_map(): array
{
    $catalog = d11_get_block_catalog();
    $curated_groups = d11_curated_block_groups();
    $allowed_blocks = [
        'core' => array_values(array_intersect($catalog['core']['blocks'], $curated_groups['core']['blocks'])),
        'blog' => array_values(array_intersect($catalog['blog']['blocks'], $curated_groups['blog']['blocks'])),
        'woocommerce' => [],
        'third_party' => $catalog['third_party']['blocks'],
        'custom' => $catalog['custom']['blocks'],
    ];

    if (! empty($catalog['woocommerce']['blocks'])) {
        $allowed_blocks['woocommerce'] = $catalog['woocommerce']['blocks'];
    }

    return $allowed_blocks;
}

/**
 * Normalizes block availability settings against the runtime catalog.
 */
function d11_normalize_block_availability_settings($value, bool $strict_submitted_categories = false): array
{
    $catalog = d11_get_block_catalog();
    $defaults = [
        'enabled_categories' => d11_get_default_enabled_block_categories(),
        'allowed_blocks' => d11_get_default_allowed_block_map(),
    ];

    if (! is_array($value)) {
        return $defaults;
    }

    $sanitized = $defaults;
    $enabled_categories = isset($value['enabled_categories']) && is_array($value['enabled_categories'])
        ? $value['enabled_categories']
        : [];

    $sanitized['enabled_categories']['blog'] = ! empty($enabled_categories['blog']);

    $raw_allowed_blocks = isset($value['allowed_blocks']) && is_array($value['allowed_blocks'])
        ? $value['allowed_blocks']
        : [];
    $submitted_categories = isset($value['submitted_categories']) && is_array($value['submitted_categories'])
        ? array_map('sanitize_text_field', wp_unslash($value['submitted_categories']))
        : [];
    $submitted_lookup = array_fill_keys($submitted_categories, true);

    foreach ($catalog as $category_key => $category) {
        $category_catalog = array_values(array_unique($category['blocks']));
        $category_lookup = array_fill_keys($category_catalog, true);
        $has_submitted_category = isset($submitted_lookup[$category_key]);
        $has_saved_category = array_key_exists($category_key, $raw_allowed_blocks) && is_array($raw_allowed_blocks[$category_key]);
        $requested_blocks = $category_catalog;

        if ($strict_submitted_categories) {
            if ($has_submitted_category) {
                $requested_blocks = $has_saved_category ? $raw_allowed_blocks[$category_key] : [];
            }
        } elseif ($has_saved_category) {
            $requested_blocks = isset($raw_allowed_blocks[$category_key]) && is_array($raw_allowed_blocks[$category_key])
                ? $raw_allowed_blocks[$category_key]
                : $category_catalog;
        }

        $sanitized_blocks = [];

        foreach ($requested_blocks as $block_name) {
            if (! is_string($block_name)) {
                continue;
            }

            $normalized_block_name = sanitize_text_field(wp_unslash($block_name));

            if (isset($category_lookup[$normalized_block_name])) {
                $sanitized_blocks[] = $normalized_block_name;
            }
        }

        $sanitized['allowed_blocks'][$category_key] = array_values(array_unique($sanitized_blocks));
    }

    return $sanitized;
}

/**
 * Sanitizes persisted block availability settings.
 */
function d11_sanitize_block_availability_settings($value): array
{
    $sanitized = d11_normalize_block_availability_settings($value, true);

    $GLOBALS['d11_block_availability_settings_override'] = $sanitized;
    $GLOBALS['d11_block_availability_run_exports_on_shutdown'] = false;

    try {
        $registryPath = d11_export_block_registry_json();
        d11_export_whitelisted_blocks_markdown($registryPath);
        delete_transient('d11_block_availability_export_error');
    } catch (Throwable $throwable) {
        set_transient(
            'd11_block_availability_export_error',
            $throwable->getMessage(),
            MINUTE_IN_SECONDS * 5
        );
    }

    unset($GLOBALS['d11_block_availability_settings_override']);

    return $sanitized;
}

/**
 * Returns normalized block availability settings.
 */
function d11_get_block_availability_settings(): array
{
    if (
        isset($GLOBALS['d11_block_availability_settings_override'])
        && is_array($GLOBALS['d11_block_availability_settings_override'])
    ) {
        return $GLOBALS['d11_block_availability_settings_override'];
    }

    $saved_settings = get_option(d11_block_availability_option_name(), []);

    return d11_normalize_block_availability_settings($saved_settings);
}

/**
 * Returns whether a category is enabled for the editor whitelist.
 */
function d11_is_block_category_enabled(string $category_key, array $settings): bool
{
    if ('core' === $category_key || 'custom' === $category_key || 'third_party' === $category_key) {
        return true;
    }

    if ('blog' === $category_key) {
        return ! empty($settings['enabled_categories']['blog']);
    }

    if ('woocommerce' === $category_key) {
        return d11_has_woocommerce();
    }

    return false;
}

/**
 * Returns the current allowed block list.
 */
function d11_allowed_blocks(): array
{
    $catalog = d11_get_block_catalog();
    $settings = d11_get_block_availability_settings();
    $allowed_blocks = [];

    foreach ($catalog as $category_key => $category) {
        if (! d11_is_block_category_enabled($category_key, $settings)) {
            continue;
        }

        $allowed_blocks = array_merge(
            $allowed_blocks,
            $settings['allowed_blocks'][$category_key] ?? []
        );
    }

    return array_values(array_unique($allowed_blocks));
}

add_filter('allowed_block_types_all', function ($allowed_blocks, $editor_context) {
    return d11_allowed_blocks();
}, 10, 2);
