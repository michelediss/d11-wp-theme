<?php
/**
 * Plugin Name: Site Maintenance
 * Description: Maintenance mode powered by Gutenberg.
 * Version: 0.1.1
 * Plugin URI: https://michelepaolino.com
 * Author: Michele Paolino
 * Author URI: https://michelepaolino.com
 * Text Domain: site-maintenance
 * Domain Path: /languages
 */

declare(strict_types=1);

if (! defined('ABSPATH')) {
    exit;
}

require_once __DIR__ . '/includes/class-site-maintenance-plugin.php';

function site_maintenance(): Site_Maintenance_Plugin
{
    return Site_Maintenance_Plugin::instance(__FILE__);
}

register_activation_hook(__FILE__, ['Site_Maintenance_Plugin', 'activate']);

site_maintenance();
