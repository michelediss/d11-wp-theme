<?php

declare(strict_types=1);

if (! defined('ABSPATH')) {
    exit;
}

final class D11_Privacy
{
    public const VERSION = '0.2.1';
    public const REGISTRY_OPTION = 'd11_privacy_registry';
    public const CONSENT_COOKIE = 'd11_privacy';
    public const REST_NAMESPACE = 'd11/privacy/v1';
    public const TEXT_DOMAIN = 'd11';

    private static ?self $instance = null;

    /** @var array<int, array<string, mixed>> */
    private static array $fallback_cookie_store = [];

    private string $theme_file;

    private function __construct(string $theme_file)
    {
        $this->theme_file = $theme_file;
        $this->register_hooks();
    }

    public static function instance(?string $theme_file = null): self
    {
        if (self::$instance === null) {
            if ($theme_file === null) {
                throw new RuntimeException('Theme file is required on first boot.');
            }
            self::$instance = new self($theme_file);
        }

        return self::$instance;
    }

    public static function fallback_add_cookie_info(
        string $name,
        string $service,
        string $category,
        string $duration,
        string $description,
        bool $first_party = false,
        bool $personal = false,
        bool $non_eu = false
    ): void {
        self::$fallback_cookie_store[] = [
            'cookie_name' => $name,
            'service' => $service,
            'category' => $category,
            'duration' => $duration,
            'description' => $description,
            'first_party' => $first_party,
            'personal' => $personal,
            'non_eu' => $non_eu,
        ];
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public static function fallback_get_cookie_info(): array
    {
        return self::$fallback_cookie_store;
    }

    private function register_hooks(): void
    {
        add_action('init', [$this, 'load_textdomain']);
        add_action('init', [$this, 'register_cookies_info'], 20);
        add_action('init', [$this, 'register_blocks']);
        add_action('wp_enqueue_scripts', [$this, 'enqueue_frontend_assets']);
        add_action('rest_api_init', [$this, 'register_rest_routes']);
        add_action('admin_menu', [$this, 'register_admin_page']);
        add_action('admin_post_d11_privacy_add_cookie', [$this, 'handle_admin_add_cookie']);
        add_action('admin_post_d11_privacy_update_cookie', [$this, 'handle_admin_update_cookie']);
        add_action('admin_post_d11_privacy_delete_cookie', [$this, 'handle_admin_delete_cookie']);

        add_filter('wp_get_consent_type', [$this, 'filter_consent_type'], 10, 1);

    }

    public function load_textdomain(): void
    {
        load_theme_textdomain(self::TEXT_DOMAIN, get_theme_file_path('languages'));
    }

    public function register_blocks(): void
    {
        d11_register_vite_style('d11-privacy', 'src/css/privacy.css');

        wp_register_script(
            'd11-privacy-editor',
            get_theme_file_uri('inc/privacy/assets/js/editor.js'),
            ['wp-block-editor', 'wp-blocks', 'wp-components', 'wp-element', 'wp-i18n', 'wp-server-side-render'],
            self::VERSION,
            true
        );

        if (function_exists('wp_set_script_translations')) {
            wp_set_script_translations(
                'd11-privacy-editor',
                self::TEXT_DOMAIN,
                get_theme_file_path('languages')
            );
        }

        register_block_type(
            $this->theme_path('blocks/banner'),
            [
                'editor_script' => 'd11-privacy-editor',
                'style' => 'd11-privacy',
                'render_callback' => [$this, 'render_banner_block'],
            ]
        );

        register_block_type(
            $this->theme_path('blocks/cookie-table'),
            [
                'editor_script' => 'd11-privacy-editor',
                'style' => 'd11-privacy',
                'render_callback' => [$this, 'render_cookie_table_block'],
            ]
        );
    }

    public function enqueue_frontend_assets(): void
    {
        wp_register_script(
            'd11-privacy-frontend',
            get_theme_file_uri('inc/privacy/assets/js/frontend.js'),
            ['wp-i18n'],
            self::VERSION,
            true
        );

        if (function_exists('wp_set_script_translations')) {
            wp_set_script_translations(
                'd11-privacy-frontend',
                self::TEXT_DOMAIN,
                get_theme_file_path('languages')
            );
        }

        wp_localize_script(
            'd11-privacy-frontend',
            'D11Privacy',
            [
                'restUrl' => esc_url_raw(rest_url(self::REST_NAMESPACE . '/consent')),
                'restNonce' => wp_create_nonce('wp_rest'),
                'initialConsent' => $this->get_localized_consent_state(),
                'cookieDetails' => $this->get_cookie_details(),
                'cookiePolicyUrl' => esc_url(home_url('/cookie-policy/')),
            ]
        );

        wp_enqueue_script('d11-privacy-frontend');
    }

    public function register_rest_routes(): void
    {
        register_rest_route(
            self::REST_NAMESPACE,
            '/consent',
            [
                'methods' => WP_REST_Server::CREATABLE,
                'permission_callback' => '__return_true',
                'callback' => [$this, 'rest_set_consent'],
                'args' => [
                    'preferences' => ['type' => 'boolean'],
                    'statisticsAnonymous' => ['type' => 'boolean'],
                    'statistics' => ['type' => 'boolean'],
                    'marketing' => ['type' => 'boolean'],
                ],
            ]
        );
    }

    public function rest_set_consent(WP_REST_Request $request): WP_REST_Response
    {
        if (is_user_logged_in()) {
            $nonce = $request->get_header('X-WP-Nonce');
            if (! wp_verify_nonce((string) $nonce, 'wp_rest')) {
                return new WP_REST_Response(['code' => 'invalid_nonce'], 403);
            }
        }

        $preferences = (bool) $request->get_param('preferences');
        $statistics_anonymous = (bool) $request->get_param('statisticsAnonymous');
        $statistics = (bool) $request->get_param('statistics');
        $marketing = (bool) $request->get_param('marketing');

        if ($statistics) {
            $statistics_anonymous = true;
        }

        $map = [
            'functional' => 'allow',
            'preferences' => $preferences ? 'allow' : 'deny',
            'statistics-anonymous' => $statistics_anonymous ? 'allow' : 'deny',
            'statistics' => $statistics ? 'allow' : 'deny',
            'marketing' => $marketing ? 'allow' : 'deny',
        ];

        if (function_exists('wp_set_consent')) {
            foreach ($map as $category => $value) {
                wp_set_consent($category, $value);
            }
        }

        self::persist_cookie_consent($map);

        return new WP_REST_Response(['consent' => $map], 200);
    }

    public function filter_consent_type($type): string
    {
        return 'optin';
    }

    public function register_admin_page(): void
    {
        add_options_page(
            __('Simple Cookie Consent', 'd11'),
            __('Cookie Registry', 'd11'),
            'manage_options',
            'd11',
            [$this, 'render_admin_page']
        );
    }

    public function handle_admin_add_cookie(): void
    {
        if (! current_user_can('manage_options')) {
            wp_die(esc_html__('Insufficient permissions.', 'd11'));
        }

        check_admin_referer('d11_privacy_add_cookie');

        $entry = $this->sanitize_cookie_entry($this->get_cookie_entry_from_request());
        if ($entry === null) {
            wp_safe_redirect($this->get_admin_page_url(['d11_privacy_status' => 'error']));
            exit;
        }

        $entries = $this->get_registry_entries();
        $entries[] = $entry;
        $this->save_registry_entries($entries);

        wp_safe_redirect($this->get_admin_page_url(['d11_privacy_status' => 'added']));
        exit;
    }

    public function handle_admin_update_cookie(): void
    {
        if (! current_user_can('manage_options')) {
            wp_die(esc_html__('Insufficient permissions.', 'd11'));
        }

        check_admin_referer('d11_privacy_update_cookie');

        $index = isset($_POST['cookie_index']) ? (int) $_POST['cookie_index'] : -1;
        $entries = $this->get_registry_entries();

        if (! isset($entries[$index])) {
            wp_safe_redirect($this->get_admin_page_url(['d11_privacy_status' => 'error']));
            exit;
        }

        $entry = $this->sanitize_cookie_entry($this->get_cookie_entry_from_request());
        if ($entry === null) {
            wp_safe_redirect(
                $this->get_admin_page_url(
                    [
                        'd11_privacy_status' => 'error',
                        'd11_privacy_edit' => $index,
                    ]
                )
            );
            exit;
        }

        $entries[$index] = $entry;
        $this->save_registry_entries($entries);

        wp_safe_redirect($this->get_admin_page_url(['d11_privacy_status' => 'updated']));
        exit;
    }

    public function handle_admin_delete_cookie(): void
    {
        if (! current_user_can('manage_options')) {
            wp_die(esc_html__('Insufficient permissions.', 'd11'));
        }

        check_admin_referer('d11_privacy_delete_cookie');

        $index = isset($_POST['cookie_index']) ? (int) $_POST['cookie_index'] : -1;
        $entries = $this->get_registry_entries();

        if (! isset($entries[$index])) {
            wp_safe_redirect($this->get_admin_page_url(['d11_privacy_status' => 'error']));
            exit;
        }

        unset($entries[$index]);
        $this->save_registry_entries(array_values($entries));

        wp_safe_redirect($this->get_admin_page_url(['d11_privacy_status' => 'deleted']));
        exit;
    }

    public function render_admin_page(): void
    {
        if (! current_user_can('manage_options')) {
            return;
        }

        $entries = $this->get_registry_entries();
        $status = isset($_GET['d11_privacy_status']) ? sanitize_key((string) $_GET['d11_privacy_status']) : '';
        $edit_index = isset($_GET['d11_privacy_edit']) ? (int) $_GET['d11_privacy_edit'] : -1;
        $edit_entry = $entries[$edit_index] ?? null;
        ?>
        <div class="wrap">
            <h1><?php esc_html_e('Cookie Registry', 'd11'); ?></h1>
            <p><?php esc_html_e('Cookie definitions are stored in WordPress options and exposed to Gutenberg blocks and the consent API integration.', 'd11'); ?></p>

            <?php if ($status === 'added') : ?>
                <div class="notice notice-success is-dismissible"><p><?php esc_html_e('Cookie added.', 'd11'); ?></p></div>
            <?php elseif ($status === 'updated') : ?>
                <div class="notice notice-success is-dismissible"><p><?php esc_html_e('Cookie updated.', 'd11'); ?></p></div>
            <?php elseif ($status === 'deleted') : ?>
                <div class="notice notice-success is-dismissible"><p><?php esc_html_e('Cookie deleted.', 'd11'); ?></p></div>
            <?php elseif ($status === 'error') : ?>
                <div class="notice notice-error is-dismissible"><p><?php esc_html_e('Operation failed. Check required fields and try again.', 'd11'); ?></p></div>
            <?php endif; ?>

            <h2><?php esc_html_e('Registered Cookies', 'd11'); ?></h2>
            <table class="widefat striped">
                <thead>
                    <tr>
                        <th><?php esc_html_e('Name', 'd11'); ?></th>
                        <th><?php esc_html_e('Service', 'd11'); ?></th>
                        <th><?php esc_html_e('Category', 'd11'); ?></th>
                        <th><?php esc_html_e('Duration', 'd11'); ?></th>
                        <th><?php esc_html_e('Description', 'd11'); ?></th>
                        <th><?php esc_html_e('First party', 'd11'); ?></th>
                        <th><?php esc_html_e('Actions', 'd11'); ?></th>
                    </tr>
                </thead>
                <tbody>
                <?php if ($entries === []) : ?>
                    <tr><td colspan="7"><?php esc_html_e('No cookies registered.', 'd11'); ?></td></tr>
                <?php else : ?>
                    <?php foreach ($entries as $index => $entry) : ?>
                        <tr>
                            <td><?php echo esc_html((string) ($entry['name'] ?? '')); ?></td>
                            <td><?php echo esc_html((string) ($entry['service'] ?? '')); ?></td>
                            <td><code><?php echo esc_html((string) ($entry['category'] ?? '')); ?></code></td>
                            <td><?php echo esc_html((string) ($entry['duration'] ?? '')); ?></td>
                            <td><?php echo esc_html((string) ($entry['description'] ?? '')); ?></td>
                            <td><?php echo ! empty($entry['first_party']) ? 'true' : 'false'; ?></td>
                            <td>
                                <a class="button button-secondary" href="<?php echo esc_url($this->get_admin_page_url(['d11_privacy_edit' => $index])); ?>">
                                    <?php esc_html_e('Edit', 'd11'); ?>
                                </a>
                                <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" style="display:inline-block;">
                                    <?php wp_nonce_field('d11_privacy_delete_cookie'); ?>
                                    <input type="hidden" name="action" value="d11_privacy_delete_cookie">
                                    <input type="hidden" name="cookie_index" value="<?php echo esc_attr((string) $index); ?>">
                                    <button type="submit" class="button button-link-delete"><?php esc_html_e('Delete', 'd11'); ?></button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                </tbody>
            </table>

            <?php if (is_array($edit_entry)) : ?>
                <h2 style="margin-top:30px;"><?php esc_html_e('Edit Cookie', 'd11'); ?></h2>
                <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
                    <?php wp_nonce_field('d11_privacy_update_cookie'); ?>
                    <input type="hidden" name="action" value="d11_privacy_update_cookie">
                    <input type="hidden" name="cookie_index" value="<?php echo esc_attr((string) $edit_index); ?>">
                    <?php $this->render_cookie_form_fields($edit_entry, 'd11-privacy-edit'); ?>
                    <?php submit_button(__('Save changes', 'd11')); ?>
                    <a href="<?php echo esc_url($this->get_admin_page_url()); ?>" class="button"><?php esc_html_e('Cancel', 'd11'); ?></a>
                </form>
            <?php endif; ?>

            <h2 style="margin-top:30px;"><?php esc_html_e('Add Cookie', 'd11'); ?></h2>
            <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
                <?php wp_nonce_field('d11_privacy_add_cookie'); ?>
                <input type="hidden" name="action" value="d11_privacy_add_cookie">
                <?php $this->render_cookie_form_fields([], 'd11-privacy-new'); ?>
                <?php submit_button(__('Add cookie', 'd11')); ?>
            </form>
        </div>
        <?php
    }

    /**
     * @param array<string, mixed> $values
     */
    private function render_cookie_form_fields(array $values, string $id_prefix): void
    {
        ?>
        <table class="form-table" role="presentation">
            <tr>
                <th scope="row"><label for="<?php echo esc_attr($id_prefix); ?>-name"><?php esc_html_e('Cookie name', 'd11'); ?></label></th>
                <td><input id="<?php echo esc_attr($id_prefix); ?>-name" name="name" type="text" class="regular-text" required value="<?php echo esc_attr((string) ($values['name'] ?? '')); ?>"></td>
            </tr>
            <tr>
                <th scope="row"><label for="<?php echo esc_attr($id_prefix); ?>-service"><?php esc_html_e('Service', 'd11'); ?></label></th>
                <td><input id="<?php echo esc_attr($id_prefix); ?>-service" name="service" type="text" class="regular-text" required value="<?php echo esc_attr((string) ($values['service'] ?? '')); ?>"></td>
            </tr>
            <tr>
                <th scope="row"><label for="<?php echo esc_attr($id_prefix); ?>-category"><?php esc_html_e('Category', 'd11'); ?></label></th>
                <td>
                    <select id="<?php echo esc_attr($id_prefix); ?>-category" name="category">
                        <?php foreach ($this->get_category_options() as $category) : ?>
                            <option value="<?php echo esc_attr($category); ?>" <?php selected((string) ($values['category'] ?? ''), $category); ?>><?php echo esc_html($category); ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>
            <tr>
                <th scope="row"><label for="<?php echo esc_attr($id_prefix); ?>-duration"><?php esc_html_e('Duration', 'd11'); ?></label></th>
                <td><input id="<?php echo esc_attr($id_prefix); ?>-duration" name="duration" type="text" class="regular-text" value="<?php echo esc_attr((string) ($values['duration'] ?? '')); ?>"></td>
            </tr>
            <tr>
                <th scope="row"><label for="<?php echo esc_attr($id_prefix); ?>-description"><?php esc_html_e('Description', 'd11'); ?></label></th>
                <td><textarea id="<?php echo esc_attr($id_prefix); ?>-description" name="description" rows="4" class="large-text"><?php echo esc_textarea((string) ($values['description'] ?? '')); ?></textarea></td>
            </tr>
            <tr>
                <th scope="row"><?php esc_html_e('First party', 'd11'); ?></th>
                <td><label><input type="checkbox" name="first_party" value="1" <?php checked(! array_key_exists('first_party', $values) || ! empty($values['first_party'])); ?>> <?php esc_html_e('First-party cookie', 'd11'); ?></label></td>
            </tr>
        </table>
        <?php
    }

    /**
     * @param array<string, mixed> $attributes
     */
    public function render_banner_block(array $attributes = [], string $content = '', ?WP_Block $block = null): string
    {
        $settings_groups = [
            ['key' => 'functional', 'label' => __('Necessary', 'd11'), 'supports_toggle' => false],
            ['key' => 'preferences', 'label' => __('Preferences', 'd11'), 'supports_toggle' => true],
            ['key' => 'statistics-anonymous', 'label' => __('Anonymous analytics', 'd11'), 'supports_toggle' => true],
            ['key' => 'statistics', 'label' => __('Analytics', 'd11'), 'supports_toggle' => true],
            ['key' => 'marketing', 'label' => __('Marketing', 'd11'), 'supports_toggle' => true],
        ];

        ob_start();
        ?>
        <div id="d11-privacy-banner" class="wp-block-d11-privacy-banner scc-banner scc-hidden" role="dialog" aria-modal="true" aria-labelledby="d11-privacy-title" aria-describedby="d11-privacy-description" tabindex="-1">
            <div class="scc-banner__card">
                <div class="scc-banner__header">
                    <div class="scc-banner__eyebrow"><?php esc_html_e('Privacy', 'd11'); ?></div>
                    <h2 id="d11-privacy-title" class="scc-banner__title"><?php esc_html_e('Cookie preferences', 'd11'); ?></h2>
                </div>

                <div class="scc-banner__body">
                    <div id="d11-privacy-description" class="scc-banner__description">
                        <p><?php esc_html_e('We use necessary cookies and, with your consent, optional cookies for preferences, analytics, and embedded third-party media.', 'd11'); ?></p>
                        <p class="scc-banner__policy">
                            <a href="<?php echo esc_url(home_url('/cookie-policy/')); ?>">
                                <?php esc_html_e('Read the cookie policy', 'd11'); ?>
                            </a>
                        </p>
                    </div>

                    <div id="d11-privacy-settings" class="scc-banner__settings scc-hidden">
                        <div class="scc-banner__settings-intro">
                            <p><?php esc_html_e('Necessary cookies are always active. You can opt in to the other categories below.', 'd11'); ?></p>
                        </div>

                        <?php foreach ($settings_groups as $group) : ?>
                            <div class="scc-banner__setting" data-d11-privacy-cookie-row="<?php echo esc_attr($group['key']); ?>">
                                <button type="button" class="scc-banner__toggle-button" data-d11-privacy-cookie-toggle="<?php echo esc_attr($group['key']); ?>" aria-expanded="false" aria-label="<?php echo esc_attr(sprintf(__('Show cookies for %s', 'd11'), $group['label'])); ?>">
                                    <span aria-hidden="true">+</span>
                                </button>
                                <div class="scc-banner__setting-main">
                                    <div class="scc-banner__setting-copy">
                                        <strong><?php echo esc_html($group['label']); ?></strong>
                                        <span class="scc-banner__setting-caption">
                                            <?php echo esc_html($group['supports_toggle'] ? __('Optional category', 'd11') : __('Always enabled', 'd11')); ?>
                                        </span>
                                    </div>
                                    <?php if ($group['supports_toggle']) : ?>
                                        <input type="checkbox" data-d11-privacy-toggle="<?php echo esc_attr($group['key']); ?>" aria-label="<?php echo esc_attr(sprintf(__('Enable %s cookies', 'd11'), $group['label'])); ?>">
                                    <?php else : ?>
                                        <input type="checkbox" checked disabled aria-disabled="true" aria-label="<?php echo esc_attr(sprintf(__('%s cookies are required', 'd11'), $group['label'])); ?>">
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="scc-banner__cookie-panel scc-hidden" data-d11-privacy-cookie-panel="<?php echo esc_attr($group['key']); ?>">
                                <div class="scc-banner__cookie-list" data-d11-privacy-cookie-list="<?php echo esc_attr($group['key']); ?>"></div>
                            </div>
                        <?php endforeach; ?>

                        <div class="scc-banner__settings-footer">
                            <div class="scc-banner__actions scc-banner__actions--settings">
                                <button type="button" class="scc-button scc-button--primary" data-d11-privacy-action="save"><?php esc_html_e('Save preferences', 'd11'); ?></button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="scc-banner__footer">
                    <div class="scc-banner__actions">
                    <button type="button" class="scc-button scc-button--primary" data-d11-privacy-action="acceptAll"><?php esc_html_e('Accept all', 'd11'); ?></button>
                    <button type="button" class="scc-button scc-button--secondary" data-d11-privacy-action="rejectAll"><?php esc_html_e('Reject all', 'd11'); ?></button>
                    <button type="button" class="scc-button scc-button--ghost" data-d11-privacy-action="openSettings"><?php esc_html_e('Settings', 'd11'); ?></button>
                    </div>
                </div>
            </div>
        </div>
        <?php

        return (string) ob_get_clean();
    }

    /**
     * @param array<string, mixed> $attributes
     */
    public function render_cookie_table_block(array $attributes = [], string $content = '', ?WP_Block $block = null): string
    {
        $layout = isset($attributes['layout']) ? sanitize_key((string) $attributes['layout']) : 'table';
        $category_filter = isset($attributes['category']) ? sanitize_key((string) $attributes['category']) : '';
        $show_category = ! isset($attributes['showCategory']) || (bool) $attributes['showCategory'];
        $show_duration = ! isset($attributes['showDuration']) || (bool) $attributes['showDuration'];

        $cookie_details = $this->get_cookie_details();
        $rows = [];

        foreach ($cookie_details as $category => $items) {
            if ($category_filter !== '' && $category_filter !== $category) {
                continue;
            }

            foreach ($items as $item) {
                $item['category'] = $category;
                $rows[] = $item;
            }
        }

        if ($rows === []) {
            return '<p>' . esc_html__('No cookies registered.', 'd11') . '</p>';
        }

        ob_start();
        ?>
        <div class="wp-block-d11-privacy-cookie-table scc-cookie-table scc-cookie-table--<?php echo esc_attr($layout); ?>">
            <?php if ($layout === 'cards') : ?>
                <div class="scc-cookie-table__cards">
                    <?php foreach ($rows as $row) : ?>
                        <article class="scc-cookie-card">
                            <h3 class="scc-cookie-card__title"><?php echo esc_html((string) ($row['name'] ?? '')); ?></h3>
                            <dl class="scc-cookie-card__meta">
                                <div><dt><?php esc_html_e('Service', 'd11'); ?></dt><dd><?php echo esc_html((string) ($row['service'] ?? '')); ?></dd></div>
                                <?php if ($show_category) : ?>
                                    <div><dt><?php esc_html_e('Category', 'd11'); ?></dt><dd><?php echo esc_html((string) ($row['category'] ?? '')); ?></dd></div>
                                <?php endif; ?>
                                <?php if ($show_duration) : ?>
                                    <div><dt><?php esc_html_e('Duration', 'd11'); ?></dt><dd><?php echo esc_html((string) ($row['duration'] ?? '')); ?></dd></div>
                                <?php endif; ?>
                            </dl>
                            <?php if (! empty($row['description'])) : ?>
                                <p class="scc-cookie-card__description"><?php echo esc_html((string) $row['description']); ?></p>
                            <?php endif; ?>
                        </article>
                    <?php endforeach; ?>
                </div>
            <?php else : ?>
                <div class="scc-cookie-table__wrap">
                    <table>
                        <thead>
                            <tr>
                                <th><?php esc_html_e('Cookie', 'd11'); ?></th>
                                <th><?php esc_html_e('Service', 'd11'); ?></th>
                                <?php if ($show_category) : ?>
                                    <th><?php esc_html_e('Category', 'd11'); ?></th>
                                <?php endif; ?>
                                <?php if ($show_duration) : ?>
                                    <th><?php esc_html_e('Duration', 'd11'); ?></th>
                                <?php endif; ?>
                                <th><?php esc_html_e('Description', 'd11'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($rows as $row) : ?>
                                <tr>
                                    <td><?php echo esc_html((string) ($row['name'] ?? '')); ?></td>
                                    <td><?php echo esc_html((string) ($row['service'] ?? '')); ?></td>
                                    <?php if ($show_category) : ?>
                                        <td><?php echo esc_html((string) ($row['category'] ?? '')); ?></td>
                                    <?php endif; ?>
                                    <?php if ($show_duration) : ?>
                                        <td><?php echo esc_html((string) ($row['duration'] ?? '')); ?></td>
                                    <?php endif; ?>
                                    <td><?php echo esc_html((string) ($row['description'] ?? '')); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
        <?php

        return (string) ob_get_clean();
    }

    public function register_cookies_info(): void
    {
        if (! function_exists('wp_add_cookie_info')) {
            return;
        }

        foreach ($this->get_registry_entries() as $entry) {
            $name = (string) ($entry['name'] ?? '');
            $service = (string) ($entry['service'] ?? '');
            $category = self::normalize_cookie_category((string) ($entry['category'] ?? ''));

            if ($name === '' || $service === '' || $category === '') {
                continue;
            }

            $duration = (string) ($entry['duration'] ?? '');
            $description = (string) ($entry['description'] ?? '');
            $first_party = array_key_exists('first_party', $entry) && $entry['first_party'] !== null
                ? (bool) $entry['first_party']
                : ! $this->is_third_party_service($service);

            wp_add_cookie_info($name, $service, $category, $duration, $description, $first_party, false, false);
        }

        do_action('d11_privacy_register_cookies');
    }

    /**
     * @return array<string, array<int, array<string, string>>>
     */
    public function get_cookie_details(): array
    {
        $groups = [
            'functional' => [],
            'preferences' => [],
            'statistics-anonymous' => [],
            'statistics' => [],
            'marketing' => [],
        ];

        $items = function_exists('wp_get_cookie_info') ? wp_get_cookie_info() : self::$fallback_cookie_store;
        if (! is_array($items)) {
            return $groups;
        }

        foreach ($items as $row) {
            if (! is_array($row)) {
                continue;
            }

            $category = self::normalize_cookie_category((string) ($row['category'] ?? ($row['purpose'] ?? '')));
            if ($category === '') {
                continue;
            }

            $groups[$category][] = [
                'name' => (string) ($row['cookie_name'] ?? ($row['name'] ?? '')),
                'service' => (string) ($row['service'] ?? ($row['cookie_service'] ?? '')),
                'duration' => (string) ($row['duration'] ?? ($row['cookie_duration'] ?? '')),
                'description' => (string) ($row['description'] ?? ($row['cookie_description'] ?? '')),
            ];
        }

        return $groups;
    }

    /**
     * @return array<string, mixed>
     */
    private function get_cookie_entry_from_request(): array
    {
        return [
            'name' => isset($_POST['name']) ? wp_unslash($_POST['name']) : '',
            'service' => isset($_POST['service']) ? wp_unslash($_POST['service']) : '',
            'category' => isset($_POST['category']) ? wp_unslash($_POST['category']) : '',
            'duration' => isset($_POST['duration']) ? wp_unslash($_POST['duration']) : '',
            'description' => isset($_POST['description']) ? wp_unslash($_POST['description']) : '',
            'first_party' => ! empty($_POST['first_party']),
        ];
    }

    private function get_admin_page_url(array $args = []): string
    {
        $base = admin_url('options-general.php?page=d11-privacy');
        return $args === [] ? $base : add_query_arg($args, $base);
    }

    /**
     * @return array<int, string>
     */
    private function get_category_options(): array
    {
        return ['functional', 'preferences', 'statistics-anonymous', 'statistics', 'marketing'];
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    private function get_default_cookie_entries(): array
    {
        return [
            [
                'name' => self::CONSENT_COOKIE,
                'service' => 'Simple Cookie Consent',
                'category' => 'functional',
                'duration' => '1 year',
                'description' => 'Stores the consent decision for each cookie category.',
                'first_party' => true,
            ],
            [
                'name' => 'wordpress_[hash]',
                'service' => 'WordPress',
                'category' => 'functional',
                'duration' => 'Session',
                'description' => 'Keeps the authenticated session active in wp-admin.',
                'first_party' => true,
            ],
            [
                'name' => 'wordpress_sec_[hash]',
                'service' => 'WordPress',
                'category' => 'functional',
                'duration' => 'Session',
                'description' => 'Keeps the authenticated session active while plugins are in use.',
                'first_party' => true,
            ],
            [
                'name' => 'wordpress_logged_in_[hash]',
                'service' => 'WordPress',
                'category' => 'functional',
                'duration' => 'Session',
                'description' => 'Stores the logged-in user after authentication.',
                'first_party' => true,
            ],
            [
                'name' => 'wordpress_test_cookie',
                'service' => 'WordPress',
                'category' => 'functional',
                'duration' => 'Session',
                'description' => 'Checks whether the browser accepts cookies.',
                'first_party' => true,
            ],
            [
                'name' => 'wp_lang',
                'service' => 'WordPress',
                'category' => 'functional',
                'duration' => 'Session',
                'description' => 'Stores the current interface language.',
                'first_party' => true,
            ],
            [
                'name' => 'wp-settings-1',
                'service' => 'WordPress',
                'category' => 'functional',
                'duration' => '1 year',
                'description' => 'Stores dashboard preferences for the current user.',
                'first_party' => true,
            ],
            [
                'name' => 'wp-settings-time-1',
                'service' => 'WordPress',
                'category' => 'functional',
                'duration' => '1 year',
                'description' => 'Stores the update timestamp for user settings.',
                'first_party' => true,
            ],
            [
                'name' => 'youtube_*',
                'service' => 'YouTube',
                'category' => 'marketing',
                'duration' => 'Up to 2 years',
                'description' => 'Used by YouTube for embedded video playback and engagement tracking.',
                'first_party' => false,
            ],
            [
                'name' => 'spotify_*',
                'service' => 'Spotify',
                'category' => 'marketing',
                'duration' => 'Session / 1 year',
                'description' => 'Allows Spotify to load embedded players and collect listening statistics.',
                'first_party' => false,
            ],
            [
                'name' => 'x.com_*',
                'service' => 'X (Twitter)',
                'category' => 'marketing',
                'duration' => 'Up to 2 years',
                'description' => 'Tracks interactions with embedded tweets and personalizes advertising content.',
                'first_party' => false,
            ],
            [
                'name' => 'facebook_*',
                'service' => 'Facebook',
                'category' => 'marketing',
                'duration' => 'Up to 2 years',
                'description' => 'Used by Facebook to measure and personalize embedded content.',
                'first_party' => false,
            ],
            [
                'name' => 'instagram_*',
                'service' => 'Instagram',
                'category' => 'marketing',
                'duration' => 'Session / 1 year',
                'description' => 'Handles embedded posts and stories and collects basic usage metrics.',
                'first_party' => false,
            ],
            [
                'name' => 'tiktok_*',
                'service' => 'TikTok',
                'category' => 'marketing',
                'duration' => 'Up to 13 months',
                'description' => 'Used by TikTok to render embedded videos and analyze engagement.',
                'first_party' => false,
            ],
        ];
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    private function get_registry_entries(): array
    {
        $entries = get_option(self::REGISTRY_OPTION, []);
        if (! is_array($entries) || $entries === []) {
            return $this->get_default_cookie_entries();
        }

        $clean_entries = [];
        foreach ($entries as $entry) {
            if (! is_array($entry)) {
                continue;
            }

            $sanitized = $this->sanitize_cookie_entry($entry);
            if ($sanitized !== null) {
                $clean_entries[] = $sanitized;
            }
        }

        return $clean_entries === [] ? $this->get_default_cookie_entries() : $clean_entries;
    }

    /**
     * @param array<int, array<string, mixed>> $entries
     */
    private function save_registry_entries(array $entries): void
    {
        update_option(self::REGISTRY_OPTION, array_values($entries), false);
    }


    /**
     * @param array<string, mixed> $entry
     * @return array<string, mixed>|null
     */
    private function sanitize_cookie_entry(array $entry): ?array
    {
        $name = sanitize_text_field((string) ($entry['name'] ?? ''));
        $service = sanitize_text_field((string) ($entry['service'] ?? ''));
        $category = self::normalize_cookie_category((string) ($entry['category'] ?? ''));
        $duration = sanitize_text_field((string) ($entry['duration'] ?? ''));
        $description = sanitize_textarea_field((string) ($entry['description'] ?? ''));

        if ($name === '' || $service === '' || $category === '') {
            return null;
        }

        $first_party = null;
        if (array_key_exists('first_party', $entry)) {
            $first_party = (bool) $entry['first_party'];
        }

        return [
            'name' => $name,
            'service' => $service,
            'category' => $category,
            'duration' => $duration,
            'description' => $description,
            'first_party' => $first_party,
        ];
    }

    private static function normalize_cookie_category(string $value): string
    {
        $value = sanitize_key($value);
        if ($value === 'statistics_anonymous') {
            $value = 'statistics-anonymous';
        }

        $allowed = ['functional', 'preferences', 'statistics-anonymous', 'statistics', 'marketing'];
        return in_array($value, $allowed, true) ? $value : '';
    }

    private function is_third_party_service(string $service): bool
    {
        $service = strtolower(trim($service));
        $known = ['youtube', 'spotify', 'x (twitter)', 'twitter', 'facebook', 'instagram', 'tiktok'];

        return in_array($service, $known, true);
    }

    /**
     * @return array<string, mixed>
     */
    private function get_localized_consent_state(): array
    {
        $categories = [];
        foreach (['preferences', 'statistics-anonymous', 'statistics', 'marketing'] as $category) {
            $categories[$category] = self::get_consent_value($category) === 'allow';
        }

        if (! empty($categories['statistics'])) {
            $categories['statistics-anonymous'] = true;
        }

        return [
            'categories' => $categories,
            'decisionMade' => self::is_decision_made(),
        ];
    }

    private static function get_consent_value(string $category): string
    {
        if (function_exists('wp_get_consent')) {
            $value = wp_get_consent($category);
            if (is_string($value) && $value !== '') {
                return $value;
            }
        }

        $cookie_map = self::get_cookie_consent_map();
        return isset($cookie_map[$category]) && is_string($cookie_map[$category]) ? $cookie_map[$category] : '';
    }

    /**
     * @return array<string, string>
     */
    private static function get_cookie_consent_map(): array
    {
        if (empty($_COOKIE[self::CONSENT_COOKIE])) {
            return [];
        }

        $raw = wp_unslash((string) $_COOKIE[self::CONSENT_COOKIE]);
        $decoded = base64_decode($raw, true);
        if ($decoded === false) {
            return [];
        }

        $data = json_decode($decoded, true);
        if (! is_array($data)) {
            return [];
        }

        $allowed = ['functional', 'preferences', 'statistics-anonymous', 'statistics', 'marketing'];
        return array_intersect_key($data, array_flip($allowed));
    }

    private static function is_decision_made(): bool
    {
        $categories = ['preferences', 'statistics-anonymous', 'statistics', 'marketing'];
        $seen = 0;

        foreach ($categories as $category) {
            $value = self::get_consent_value($category);
            if ($value === 'allow' || $value === 'deny') {
                $seen++;
            }
        }

        return $seen > 0;
    }

    /**
     * @param array<string, string> $map
     */
    private static function persist_cookie_consent(array $map): void
    {
        $allowed = ['functional', 'preferences', 'statistics-anonymous', 'statistics', 'marketing'];
        $payload = [];

        foreach ($allowed as $key) {
            if (isset($map[$key])) {
                $payload[$key] = $map[$key] === 'allow' ? 'allow' : 'deny';
            }
        }

        if ($payload === []) {
            return;
        }

        $json = wp_json_encode($payload);
        if (! $json) {
            return;
        }

        $encoded = base64_encode($json);
        $cookie_args = [
            'expires' => time() + YEAR_IN_SECONDS,
            'path' => defined('COOKIEPATH') && COOKIEPATH ? COOKIEPATH : '/',
            'secure' => is_ssl(),
            'httponly' => true,
            'samesite' => 'Lax',
        ];

        if (defined('COOKIE_DOMAIN') && COOKIE_DOMAIN) {
            $cookie_args['domain'] = COOKIE_DOMAIN;
        }

        setcookie(self::CONSENT_COOKIE, $encoded, $cookie_args);
        $_COOKIE[self::CONSENT_COOKIE] = $encoded;
    }

    private function theme_path(string $relative = ''): string
    {
        $base = dirname($this->theme_file) . '/';
        return $relative === '' ? $base : $base . ltrim($relative, '/');
    }
}
