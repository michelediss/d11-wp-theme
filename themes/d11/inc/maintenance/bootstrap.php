<?php

declare(strict_types=1);

if (! defined('ABSPATH')) {
    exit;
}

require_once __DIR__ . '/class-d11-maintenance.php';

function d11_maintenance(): D11_Maintenance
{
    return D11_Maintenance::instance(__FILE__);
}

d11_maintenance();
