<?php

declare(strict_types=1);

/**
 * Registers the theme block pattern category.
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
