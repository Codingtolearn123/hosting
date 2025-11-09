<?php
/**
 * Plugin Name: VirtualSkyHost WHMCS Bridge
 * Description: Provides WordPress helpers, REST endpoints, and shortcodes for integrating VirtualSkyHost marketing pages with WHMCS pricing, orders, and domain search.
 * Version: 1.0.0
 * Author: VirtualSkyHost Team
 */

declare(strict_types=1);

if (!defined('ABSPATH')) {
    exit;
}

require_once __DIR__ . '/includes/options.php';
require_once __DIR__ . '/includes/api.php';
require_once __DIR__ . '/includes/rest-routes.php';
require_once __DIR__ . '/includes/shortcodes.php';

add_action('plugins_loaded', function (): void {
    load_plugin_textdomain('virtualskyhost', false, dirname(plugin_basename(__FILE__)) . '/languages');
});
