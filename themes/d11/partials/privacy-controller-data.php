<?php

declare(strict_types=1);

if (! defined('ABSPATH')) {
    exit;
}

/**
 * Returns the option name used to store privacy controller details.
 */
function d11_privacy_controller_option_name(): string
{
    return 'privacy_controller_data';
}

/**
 * Returns the supported privacy controller fields grouped for admin rendering.
 *
 * @return array<string, array<string, string>>
 */
function d11_get_privacy_controller_field_groups(): array
{
    return [
        'identity' => [
            'label' => __('Identity', 'd11'),
            'fields' => [
                'display_name' => __('Display name', 'd11'),
                'nome' => __('First name', 'd11'),
                'cognome' => __('Last name', 'd11'),
                'ragione_sociale' => __('Company name', 'd11'),
                'piva' => __('VAT number', 'd11'),
                'codice_fiscale' => __('Tax code', 'd11'),
            ],
        ],
        'contacts' => [
            'label' => __('Contacts', 'd11'),
            'fields' => [
                'email' => __('Email', 'd11'),
                'pec' => __('PEC', 'd11'),
                'telefono' => __('Phone', 'd11'),
            ],
        ],
        'address' => [
            'label' => __('Address', 'd11'),
            'fields' => [
                'indirizzo' => __('Street address', 'd11'),
                'citta' => __('City', 'd11'),
                'provincia' => __('Province', 'd11'),
                'cap' => __('Postal code', 'd11'),
                'nazione' => __('Country', 'd11'),
            ],
        ],
        'dpo' => [
            'label' => __('DPO', 'd11'),
            'fields' => [
                'dpo_nome' => __('DPO name', 'd11'),
                'dpo_email' => __('DPO email', 'd11'),
            ],
        ],
    ];
}

/**
 * Returns the flat list of supported privacy controller field keys.
 *
 * @return array<int, string>
 */
function d11_get_privacy_controller_supported_keys(): array
{
    $keys = [];

    foreach (d11_get_privacy_controller_field_groups() as $group) {
        foreach (array_keys($group['fields']) as $field_key) {
            $keys[] = $field_key;
        }
    }

    return $keys;
}

/**
 * Returns the default privacy controller data structure.
 *
 * @return array<string, string>
 */
function d11_get_default_privacy_controller_data(): array
{
    return array_fill_keys(d11_get_privacy_controller_supported_keys(), '');
}

/**
 * Returns the current privacy controller data with defaults merged in.
 *
 * @return array<string, string>
 */
function d11_get_privacy_controller_data(): array
{
    $defaults = d11_get_default_privacy_controller_data();
    $saved = get_option(d11_privacy_controller_option_name(), []);

    if (! is_array($saved)) {
        return $defaults;
    }

    foreach ($defaults as $key => $default_value) {
        $saved[$key] = is_scalar($saved[$key] ?? null) ? (string) $saved[$key] : $default_value;
    }

    return $saved + $defaults;
}

/**
 * Returns one privacy controller value by key.
 */
function d11_get_privacy_controller_value(string $key): string
{
    if (! in_array($key, d11_get_privacy_controller_supported_keys(), true)) {
        return '';
    }

    $data = d11_get_privacy_controller_data();

    return (string) ($data[$key] ?? '');
}

/**
 * Registers the privacy controller setting.
 */
function d11_register_privacy_controller_setting(): void
{
    register_setting(
        'd11_privacy_controller_data',
        d11_privacy_controller_option_name(),
        [
            'type' => 'array',
            'sanitize_callback' => 'd11_sanitize_privacy_controller_data',
            'default' => d11_get_default_privacy_controller_data(),
        ]
    );
}
add_action('admin_init', 'd11_register_privacy_controller_setting');

/**
 * Sanitizes the privacy controller payload.
 *
 * @param mixed $raw_value
 * @return array<string, string>
 */
function d11_sanitize_privacy_controller_data($raw_value): array
{
    $defaults = d11_get_default_privacy_controller_data();
    $value = is_array($raw_value) ? $raw_value : [];
    $sanitized = $defaults;

    foreach ($defaults as $key => $default_value) {
        $raw_field_value = is_scalar($value[$key] ?? null) ? (string) $value[$key] : $default_value;

        switch ($key) {
            case 'email':
            case 'pec':
            case 'dpo_email':
                $sanitized[$key] = sanitize_email($raw_field_value);
                break;

            case 'indirizzo':
                $sanitized[$key] = sanitize_textarea_field($raw_field_value);
                break;

            default:
                $sanitized[$key] = sanitize_text_field($raw_field_value);
                break;
        }
    }

    return $sanitized;
}

/**
 * Adds the privacy controller settings page under Settings.
 */
function d11_add_privacy_controller_page(): void
{
    add_options_page(
        __('Data Controller Details', 'd11'),
        __('Privacy Data', 'd11'),
        'manage_options',
        'd11-privacy-controller-data',
        'd11_render_privacy_controller_page'
    );
}
add_action('admin_menu', 'd11_add_privacy_controller_page');

/**
 * Renders one privacy controller field.
 */
function d11_render_privacy_controller_field(string $key, string $label, string $value): void
{
    $option_name = d11_privacy_controller_option_name();
    $is_textarea = 'indirizzo' === $key;
    ?>
    <tr>
        <th scope="row">
            <label for="tlt-privacy-controller-<?php echo esc_attr($key); ?>"><?php echo esc_html($label); ?></label>
        </th>
        <td>
            <?php if ($is_textarea) : ?>
                <textarea
                    class="large-text"
                    rows="4"
                    id="tlt-privacy-controller-<?php echo esc_attr($key); ?>"
                    name="<?php echo esc_attr($option_name); ?>[<?php echo esc_attr($key); ?>]"
                ><?php echo esc_textarea($value); ?></textarea>
            <?php else : ?>
                <input
                    type="text"
                    class="regular-text"
                    id="tlt-privacy-controller-<?php echo esc_attr($key); ?>"
                    name="<?php echo esc_attr($option_name); ?>[<?php echo esc_attr($key); ?>]"
                    value="<?php echo esc_attr($value); ?>"
                >
            <?php endif; ?>
        </td>
    </tr>
    <?php
}

/**
 * Renders the privacy controller settings page.
 */
function d11_render_privacy_controller_page(): void
{
    if (! current_user_can('manage_options')) {
        return;
    }

    $data = d11_get_privacy_controller_data();
    ?>
    <div class="wrap">
        <h1><?php esc_html_e('Data Controller Details', 'd11'); ?></h1>
        <p>
            <?php esc_html_e('Fill in the site-wide privacy details and reuse them in pages with the shortcode [privacy key="..."].', 'd11'); ?>
        </p>

        <?php settings_errors('d11_privacy_controller_data'); ?>

        <form method="post" action="options.php">
            <?php settings_fields('d11_privacy_controller_data'); ?>

            <?php foreach (d11_get_privacy_controller_field_groups() as $group) : ?>
                <h2><?php echo esc_html($group['label']); ?></h2>
                <table class="form-table" role="presentation">
                    <tbody>
                        <?php foreach ($group['fields'] as $key => $label) : ?>
                            <?php d11_render_privacy_controller_field($key, $label, $data[$key] ?? ''); ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endforeach; ?>

            <?php submit_button(__('Save Privacy Data', 'd11')); ?>
        </form>
    </div>
    <?php
}

/**
 * Normalizes a phone number for safe tel links.
 */
function d11_normalize_privacy_phone_href(string $phone): string
{
    $normalized = preg_replace('/(?!^\+)[^\d]/', '', trim($phone));

    if (! is_string($normalized) || '' === $normalized) {
        return '';
    }

    if (str_starts_with($normalized, '00')) {
        $normalized = '+' . substr($normalized, 2);
    }

    return preg_match('/^\+?\d+$/', $normalized) === 1 ? $normalized : '';
}

/**
 * Renders the privacy shortcode output for one field.
 */
function d11_render_privacy_shortcode_value(string $key, string $value): string
{
    if ('' === $value) {
        return '';
    }

    switch ($key) {
        case 'email':
        case 'pec':
        case 'dpo_email':
            $email = sanitize_email($value);

            if ('' === $email) {
                return '';
            }

            return sprintf(
                '<a href="%1$s">%2$s</a>',
                esc_url('mailto:' . $email),
                esc_html($email)
            );

        case 'telefono':
            $href = d11_normalize_privacy_phone_href($value);

            if ('' === $href) {
                return esc_html($value);
            }

            return sprintf(
                '<a href="%1$s">%2$s</a>',
                esc_url('tel:' . $href),
                esc_html($value)
            );

        case 'indirizzo':
            return nl2br(esc_html($value));

        default:
            return esc_html($value);
    }
}

/**
 * Handles the [privacy key="..."] shortcode.
 *
 * @param array<string, mixed> $atts
 */
function d11_privacy_shortcode(array $atts = []): string
{
    $attributes = shortcode_atts(
        [
            'key' => '',
        ],
        $atts,
        'privacy'
    );

    $key = is_scalar($attributes['key']) ? sanitize_key((string) $attributes['key']) : '';

    if (! in_array($key, d11_get_privacy_controller_supported_keys(), true)) {
        return '';
    }

    return d11_render_privacy_shortcode_value(
        $key,
        d11_get_privacy_controller_value($key)
    );
}
add_shortcode('privacy', 'd11_privacy_shortcode');
