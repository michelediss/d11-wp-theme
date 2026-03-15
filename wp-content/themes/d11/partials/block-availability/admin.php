<?php

declare(strict_types=1);

if (! defined('ABSPATH')) {
    exit;
}

/**
 * Registers the setting used to persist block availability controls.
 */
function d11_register_block_availability_setting(): void
{
    register_setting(
        'd11_block_availability',
        d11_block_availability_option_name(),
        [
            'type' => 'array',
            'sanitize_callback' => 'd11_sanitize_block_availability_settings',
            'default' => [
                'enabled_categories' => d11_get_default_enabled_block_categories(),
                'allowed_blocks' => d11_get_default_allowed_block_map(),
            ],
        ]
    );
}
add_action('admin_init', 'd11_register_block_availability_setting');

/**
 * Adds the block availability page under Appearance.
 */
function d11_add_block_availability_page(): void
{
    add_theme_page(
        __('Block Availability', 'd11'),
        __('Block Availability', 'd11'),
        'manage_options',
        'd11-block-availability',
        'd11_render_block_availability_page'
    );
}
add_action('admin_menu', 'd11_add_block_availability_page');

/**
 * Enqueues admin-only assets for the block availability screen.
 */
function d11_enqueue_block_availability_assets(string $hook_suffix): void
{
    if ('appearance_page_d11-block-availability' !== $hook_suffix) {
        return;
    }

    $script_path = get_theme_file_path('assets/js/block-availability-admin.js');
    $style_path = get_theme_file_path('assets/css/admin/block-availability-admin.css');
    $script_version = file_exists($script_path) ? (string) filemtime($script_path) : D11_VERSION;
    $style_version = file_exists($style_path) ? (string) filemtime($style_path) : D11_VERSION;

    wp_enqueue_script(
        'd11-block-availability-admin',
        get_theme_file_uri('assets/js/block-availability-admin.js'),
        [],
        $script_version,
        true
    );
    wp_add_inline_script(
        'd11-block-availability-admin',
        'window.d11BlockAvailability = ' . wp_json_encode([
            'activeLabel' => __('active', 'd11'),
        ]) . ';',
        'before'
    );

    wp_enqueue_style(
        'd11-block-availability-admin',
        get_theme_file_uri('assets/css/admin/block-availability-admin.css'),
        [],
        $style_version
    );
}
add_action('admin_enqueue_scripts', 'd11_enqueue_block_availability_assets');

/**
 * Marks the current request as a block availability save request.
 */
function d11_mark_block_availability_save_request(): void
{
    $GLOBALS['d11_block_availability_run_exports_on_shutdown'] = true;
}

/**
 * Detects explicit saves from options.php so exports also run when values do not change.
 */
function d11_detect_block_availability_save_request(): void
{
    if (! is_admin()) {
        return;
    }

    if ('POST' !== strtoupper($_SERVER['REQUEST_METHOD'] ?? '')) {
        return;
    }

    $optionPage = isset($_POST['option_page']) ? sanitize_text_field(wp_unslash($_POST['option_page'])) : '';

    if ('d11_block_availability' !== $optionPage) {
        return;
    }

    d11_mark_block_availability_save_request();
}
add_action('admin_init', 'd11_detect_block_availability_save_request', 5);

/**
 * Runs registry and whitelist exports after block availability settings are saved.
 */
function d11_maybe_run_block_availability_exports(): void
{
    if (empty($GLOBALS['d11_block_availability_run_exports_on_shutdown'])) {
        return;
    }

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
}
add_action('shutdown', 'd11_maybe_run_block_availability_exports', 20);

add_action(
    'update_option_' . 'd11_block_availability_settings',
    'd11_mark_block_availability_save_request',
    10,
    0
);
add_action(
    'add_option_' . 'd11_block_availability_settings',
    'd11_mark_block_availability_save_request',
    10,
    0
);

/**
 * Renders the inline script that powers the live block filter.
 */
function d11_render_block_availability_inline_script(): void
{
    ?>
    <script>
        if (typeof window.d11InitBlockAvailabilitySearch === 'function') {
            window.d11InitBlockAvailabilitySearch();
        }
    </script>
    <?php
}

/**
 * Returns the visible admin categories in their desired order.
 */
function d11_get_block_availability_page_sections(): array
{
    $catalog = d11_get_block_availability_admin_categories();
    $ordered_sections = [];

    foreach (['core', 'blog', 'woocommerce', 'third_party', 'custom'] as $category_key) {
        if (isset($catalog[$category_key])) {
            $ordered_sections[$category_key] = $catalog[$category_key];
        }
    }

    return $ordered_sections;
}

/**
 * Renders the controls for a single block category card.
 */
function d11_render_block_availability_category_card(
    string $category_key,
    array $category,
    array $settings
): void {
    $allowed_blocks = $settings['allowed_blocks'][$category_key] ?? [];
    $allowed_lookup = array_fill_keys($allowed_blocks, true);
    $blocks = $category['blocks'];
    $is_toggleable = 'blog' === $category_key;
    $is_enabled = d11_is_block_category_enabled($category_key, $settings);
    $active_count = count($allowed_blocks);
    $total_count = count($blocks);
    ?>
    <section class="tlt-block-availability-card" data-category="<?php echo esc_attr($category_key); ?>" data-role="block-card">
        <header class="tlt-block-availability-card__header">
            <div>
                <div class="tlt-block-availability-card__eyebrow"><?php echo esc_html(strtoupper($category_key)); ?></div>
                <h2><?php echo esc_html($category['label']); ?></h2>
                <p><?php echo esc_html($category['description']); ?></p>
            </div>
            <div class="tlt-block-availability-card__meta">
                <span class="tlt-block-availability-card__count" data-role="block-count">
                    <?php
                    printf(
                        /* translators: 1: active blocks count, 2: total blocks count */
                        esc_html__('%1$d / %2$d active', 'd11'),
                        $active_count,
                        $total_count
                    );
                    ?>
                </span>
                <?php if ($is_toggleable) : ?>
                    <label class="tlt-block-availability-toggle">
                        <input
                            type="checkbox"
                            name="<?php echo esc_attr(d11_block_availability_option_name()); ?>[enabled_categories][blog]"
                            value="1"
                            <?php checked($is_enabled); ?>
                            data-role="category-toggle"
                        >
                        <span><?php esc_html_e('Enable category', 'd11'); ?></span>
                    </label>
                <?php elseif ('core' === $category_key) : ?>
                    <span class="tlt-block-availability-badge is-fixed"><?php esc_html_e('Always on', 'd11'); ?></span>
                <?php elseif ('woocommerce' === $category_key) : ?>
                    <span class="tlt-block-availability-badge"><?php esc_html_e('Plugin detected', 'd11'); ?></span>
                <?php elseif ('third_party' === $category_key) : ?>
                    <span class="tlt-block-availability-badge"><?php esc_html_e('Plugin blocks', 'd11'); ?></span>
                <?php else : ?>
                    <span class="tlt-block-availability-badge"><?php esc_html_e('Separate area', 'd11'); ?></span>
                <?php endif; ?>
            </div>
        </header>

        <div class="tlt-block-availability-card__controls">
            <label class="tlt-block-availability-search">
                <span class="screen-reader-text">
                    <?php
                    printf(
                        /* translators: %s: category label */
                        esc_html__('Filter %s blocks', 'd11'),
                        $category['label']
                    );
                    ?>
                </span>
                <input
                    type="search"
                    placeholder="<?php esc_attr_e('Filter blocks…', 'd11'); ?>"
                    data-role="block-search"
                >
            </label>
        </div>

        <div class="tlt-block-availability-list" data-role="block-list" <?php disabled(! $is_enabled, true, true); ?>>
            <input
                type="hidden"
                name="<?php echo esc_attr(d11_block_availability_option_name()); ?>[submitted_categories][]"
                value="<?php echo esc_attr($category_key); ?>"
            >
            <?php foreach ($blocks as $block_name) : ?>
                <label class="tlt-block-availability-item" data-role="block-item">
                    <input
                        type="checkbox"
                        name="<?php echo esc_attr(d11_block_availability_option_name()); ?>[allowed_blocks][<?php echo esc_attr($category_key); ?>][]"
                        value="<?php echo esc_attr($block_name); ?>"
                        <?php checked(isset($allowed_lookup[$block_name])); ?>
                    >
                    <span class="tlt-block-availability-item__check" aria-hidden="true"></span>
                    <span class="tlt-block-availability-item__content">
                        <strong data-role="search-text"><?php echo esc_html($block_name); ?></strong>
                    </span>
                </label>
            <?php endforeach; ?>
            <p class="tlt-block-availability-list__empty" data-role="empty-state" hidden>
                <?php esc_html_e('No blocks match this filter.', 'd11'); ?>
            </p>
        </div>
    </section>
    <?php
}

/**
 * Renders the block availability admin page.
 */
function d11_render_block_availability_page(): void
{
    if (! current_user_can('manage_options')) {
        return;
    }

    $settings = d11_get_block_availability_settings();
    $sections = d11_get_block_availability_page_sections();

    if (isset($_GET['settings-updated']) && 'true' === $_GET['settings-updated']) {
        add_settings_error(
            'd11_block_availability',
            'd11-block-availability-saved',
            __('Block availability updated.', 'd11'),
            'updated'
        );
    }

    $exportError = get_transient('d11_block_availability_export_error');

    if (is_string($exportError) && $exportError !== '') {
        add_settings_error(
            'd11_block_availability',
            'd11-block-availability-export-error',
            sprintf(
                /* translators: %s: export error message */
                __('Block export failed: %s', 'd11'),
                $exportError
            ),
            'error'
        );
        delete_transient('d11_block_availability_export_error');
    }

    ?>
    <div class="wrap tlt-block-availability-page">
        <?php settings_errors('d11_block_availability'); ?>
        <form method="post" action="options.php">
            <?php settings_fields('d11_block_availability'); ?>
            <div class="tlt-block-availability-page__hero">
                <div>
                    <h1><?php esc_html_e('Block availability', 'd11'); ?></h1>
                    <p>
                        <?php esc_html_e('Control which core, blog, WooCommerce, third-party, and custom blocks remain available in the editor without mixing categories.', 'd11'); ?>
                    </p>
                    <?php submit_button(__('Save block availability', 'd11'), 'primary', 'submit', false); ?>
                </div>
                <div class="tlt-block-availability-page__summary">
                    <span class="tlt-block-availability-badge is-fixed"><?php esc_html_e('Core always enabled', 'd11'); ?></span>
                    <?php if (! d11_has_woocommerce()) : ?>
                        <span class="tlt-block-availability-badge"><?php esc_html_e('WooCommerce not installed', 'd11'); ?></span>
                    <?php endif; ?>
                </div>
            </div>
            <div class="tlt-block-availability-grid">
                <?php foreach ($sections as $category_key => $category) : ?>
                    <?php d11_render_block_availability_category_card($category_key, $category, $settings); ?>
                <?php endforeach; ?>
            </div>
        </form>
        <?php d11_render_block_availability_inline_script(); ?>
    </div>
    <?php
}
