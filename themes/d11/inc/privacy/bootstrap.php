<?php

declare(strict_types=1);

if (! defined('ABSPATH')) {
    exit;
}

require_once __DIR__ . '/class-d11-privacy.php';
require_once __DIR__ . '/controller-data.php';

function d11_privacy(): D11_Privacy
{
    return D11_Privacy::instance(__FILE__);
}

if (! function_exists('wp_add_cookie_info')) {
    function wp_add_cookie_info($name, $service, $category, $duration, $description, $first_party = false, $personal = false, $non_eu = false): bool
    {
        D11_Privacy::fallback_add_cookie_info((string) $name, (string) $service, (string) $category, (string) $duration, (string) $description, (bool) $first_party, (bool) $personal, (bool) $non_eu);
        return true;
    }
}

if (! function_exists('wp_get_cookie_info')) {
    function wp_get_cookie_info(): array
    {
        return D11_Privacy::fallback_get_cookie_info();
    }
}

function d11_privacy_blocked_script(string $category, string $inline_js): void
{
    printf('<script type="text/plain" data-wp-consent-category="%s">%s</script>', esc_attr(sanitize_key($category)), $inline_js);
}

d11_privacy();
