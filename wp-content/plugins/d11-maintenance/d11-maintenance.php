<?php
/**
 * Plugin Name: D11 Maintenance
 * Description: Maintenance mode powered by the Gutenberg content of the fixed Maintenance page.
 * Version: 0.1.0
 * Plugin URI: https://github.com/michelediss/d11-wp-theme
 * Author: Michele Paolino
 * Author URI: https://michelepaolino.com
 * Text Domain: d11-maintenance
 * Domain Path: /languages
 */

declare(strict_types=1);

if (! defined('ABSPATH')) {
    exit;
}

require_once __DIR__ . '/includes/class-d11-maintenance-plugin.php';

function d11_maintenance(): D11_Maintenance_Plugin
{
    return D11_Maintenance_Plugin::instance(__FILE__);
}

register_activation_hook(__FILE__, ['D11_Maintenance_Plugin', 'activate']);

d11_maintenance();
