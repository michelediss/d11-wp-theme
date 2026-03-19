<?php

declare(strict_types=1);

if (! defined('ABSPATH')) {
    exit;
}

/**
 * Registers Gutenberg block styles owned by the theme.
 */
function d11_register_block_styles(): void
{
    if (! function_exists('register_block_style')) {
        return;
    }

    register_block_style(
        'core/group',
        [
            'name' => 'card',
            'label' => __('Card', 'd11'),
        ]
    );
}
add_action('init', 'd11_register_block_styles');
