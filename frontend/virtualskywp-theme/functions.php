<?php
/**
 * Theme bootstrap for the VirtualSkyWP theme.
 */

declare(strict_types=1);

if (!defined('ABSPATH')) {
    exit;
}

$virtualskywp_includes = [
    'inc/options.php',
    'inc/setup.php',
    'inc/custom-post-types.php',
    'inc/meta-boxes.php',
    'inc/whmcs.php',
    'inc/template-tags.php',
    'inc/block-patterns.php',
];

foreach ($virtualskywp_includes as $file) {
    $path = get_template_directory() . '/' . $file;

    if (file_exists($path)) {
        require_once $path;
    }
}
