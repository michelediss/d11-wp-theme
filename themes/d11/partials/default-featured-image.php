<?php

declare(strict_types=1);

if (! defined('ABSPATH')) {
    exit;
}

/**
 * Returns the option name used to store the theme default featured image.
 */
function d11_default_featured_image_option_name(): string
{
    return 'd11_default_featured_image_id';
}

/**
 * Returns the legacy option name from the previous plugin implementation.
 */
function d11_legacy_default_featured_image_option_name(): string
{
    return 'pap_default_featured_image_id';
}

/**
 * Reads the configured default featured image, with legacy fallback.
 */
function d11_get_default_featured_image_id(): int
{
    $option_name = d11_default_featured_image_option_name();
    $attachment_id = absint(get_option($option_name, 0));

    if ($attachment_id > 0) {
        return $attachment_id;
    }

    return absint(get_option(d11_legacy_default_featured_image_option_name(), 0));
}

/**
 * Registers the setting used by the theme to store a fallback featured image.
 */
function d11_register_default_featured_image_setting(): void
{
    register_setting(
        'd11_default_featured_image',
        d11_default_featured_image_option_name(),
        [
            'type' => 'integer',
            'sanitize_callback' => 'absint',
            'default' => 0,
        ]
    );
}
add_action('admin_init', 'd11_register_default_featured_image_setting');

/**
 * Migrates the old plugin option into the theme option once.
 */
function d11_maybe_migrate_default_featured_image_setting(): void
{
    $option_name = d11_default_featured_image_option_name();
    $legacy_option_name = d11_legacy_default_featured_image_option_name();

    if (false !== get_option($option_name, false)) {
        return;
    }

    $legacy_attachment_id = absint(get_option($legacy_option_name, 0));

    if ($legacy_attachment_id < 1) {
        return;
    }

    add_option($option_name, $legacy_attachment_id);
}
add_action('admin_init', 'd11_maybe_migrate_default_featured_image_setting', 5);

/**
 * Adds the theme admin page under Appearance.
 */
function d11_add_default_featured_image_page(): void
{
    add_theme_page(
        __('Default Featured Image', 'd11'),
        __('Default Featured Image', 'd11'),
        'manage_options',
        'd11-default-featured-image',
        'd11_render_default_featured_image_page'
    );
}
add_action('admin_menu', 'd11_add_default_featured_image_page');

/**
 * Enqueues admin assets for the theme featured image screen only.
 */
function d11_enqueue_default_featured_image_assets(string $hook_suffix): void
{
    if ('appearance_page_d11-default-featured-image' !== $hook_suffix) {
        return;
    }

    $script_path = get_theme_file_path('assets/js/default-featured-image-admin.js');
    $style_path = get_theme_file_path('assets/css/admin/default-featured-image-admin.css');
    $script_version = file_exists($script_path) ? (string) filemtime($script_path) : D11_VERSION;
    $style_version = file_exists($style_path) ? (string) filemtime($style_path) : D11_VERSION;

    wp_enqueue_media();
    wp_enqueue_script(
        'd11-default-featured-image-admin',
        get_theme_file_uri('assets/js/default-featured-image-admin.js'),
        ['jquery'],
        $script_version,
        true
    );
    wp_localize_script(
        'd11-default-featured-image-admin',
        'd11DefaultFeaturedImage',
        [
            'frameTitle' => __('Select the default featured image', 'd11'),
            'chooseButton' => __('Use this image', 'd11'),
            'removeConfirm' => __('Remove the default featured image?', 'd11'),
            'placeholderText' => __('No image selected', 'd11'),
        ]
    );

    wp_enqueue_style(
        'd11-default-featured-image-admin',
        get_theme_file_uri('assets/css/admin/default-featured-image-admin.css'),
        [],
        $style_version
    );
}
add_action('admin_enqueue_scripts', 'd11_enqueue_default_featured_image_assets');

/**
 * Renders the theme settings page for the fallback featured image.
 */
function d11_render_default_featured_image_page(): void
{
    if (! current_user_can('manage_options')) {
        return;
    }

    $attachment_id = d11_get_default_featured_image_id();
    ?>
    <div class="wrap tlt-default-featured-image-settings">
        <h1><?php esc_html_e('Default featured image', 'd11'); ?></h1>
        <p><?php esc_html_e('Used automatically for posts and pages that are saved without a featured image.', 'd11'); ?></p>

        <form method="post" action="options.php">
            <?php settings_fields('d11_default_featured_image'); ?>
            <div class="tlt-default-featured-image-field">
                <div class="tlt-default-featured-image-preview">
                    <?php
                    if ($attachment_id > 0) {
                        echo wp_get_attachment_image($attachment_id, 'medium');
                    } else {
                        echo '<div class="tlt-default-featured-image-placeholder">' .
                            esc_html__('No image selected', 'd11') .
                            '</div>';
                    }
                    ?>
                </div>

                <div class="tlt-default-featured-image-panel">
                    <input
                        type="hidden"
                        id="tlt-default-featured-image-id"
                        name="<?php echo esc_attr(d11_default_featured_image_option_name()); ?>"
                        value="<?php echo esc_attr((string) $attachment_id); ?>"
                    >

                    <div class="tlt-default-featured-image-actions">
                        <button type="button" class="button button-primary" id="tlt-default-featured-image-select">
                            <?php esc_html_e('Choose from media library', 'd11'); ?>
                        </button>
                        <button type="button" class="button" id="tlt-default-featured-image-remove" <?php disabled($attachment_id < 1); ?>>
                            <?php esc_html_e('Remove', 'd11'); ?>
                        </button>
                    </div>
                </div>
            </div>

            <?php submit_button(__('Save image', 'd11')); ?>
        </form>
    </div>
    <?php
}

/**
 * Applies the configured fallback featured image on supported post types.
 */
function d11_assign_default_featured_image(int $post_id, WP_Post $post): void
{
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (wp_is_post_revision($post_id) || 'revision' === $post->post_type) {
        return;
    }

    if ('auto-draft' === $post->post_status) {
        return;
    }

    if (! post_type_supports($post->post_type, 'thumbnail')) {
        return;
    }

    if (get_post_thumbnail_id($post_id)) {
        return;
    }

    $default_image_id = d11_get_default_featured_image_id();

    if ($default_image_id < 1) {
        return;
    }

    set_post_thumbnail($post_id, $default_image_id);
}
add_action('save_post', 'd11_assign_default_featured_image', 20, 2);
