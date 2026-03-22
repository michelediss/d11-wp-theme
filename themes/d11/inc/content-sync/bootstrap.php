<?php

declare(strict_types=1);

if (! defined('ABSPATH')) {
    exit;
}

require_once get_theme_file_path('inc/content-sync/class-content-sync-config.php');
require_once get_theme_file_path('inc/content-sync/class-content-sync-service.php');
require_once get_theme_file_path('inc/content-sync/class-content-sync-cli.php');

if (! class_exists('D11_Content_Sync')) {
    final class D11_Content_Sync
    {
        private static ?D11_Content_Sync_Service $service = null;

        public static function init(): void
        {
            add_action('after_setup_theme', [__CLASS__, 'bootstrap'], 20);
        }

        public static function bootstrap(): void
        {
            if (null !== self::$service) {
                return;
            }

            $config = D11_Content_Sync_Config::get(get_theme_file_path('inc/content-sync'));
            self::$service = new D11_Content_Sync_Service($config);

            if (defined('WP_CLI') && WP_CLI && class_exists('WP_CLI')) {
                D11_Content_Sync_CLI::register(self::$service);
            }

            if (self::$service->should_enable_runtime_override()) {
                add_filter('the_content', [self::$service, 'maybe_override_the_content'], 1);
            }
        }

        public static function get_service(): ?D11_Content_Sync_Service
        {
            return self::$service;
        }
    }
}

D11_Content_Sync::init();
