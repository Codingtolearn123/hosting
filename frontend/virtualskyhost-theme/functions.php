<?php
/**
 * Theme setup and integration helpers for VirtualSkyHost.
 */

declare(strict_types=1);

if (!defined('ABSPATH')) {
    exit;
}

require_once get_template_directory() . '/inc/helpers.php';

add_action('after_setup_theme', function (): void {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('editor-styles');
    add_theme_support('responsive-embeds');
    add_theme_support('wp-block-styles');

    register_nav_menus([
        'primary' => __('Primary Menu', 'virtualskyhost'),
        'footer' => __('Footer Menu', 'virtualskyhost'),
    ]);
});

add_action('wp_enqueue_scripts', function (): void {
    $theme_version = wp_get_theme()->get('Version');

    wp_enqueue_style(
        'virtualskyhost-theme',
        get_template_directory_uri() . '/style.css',
        [],
        $theme_version
    );

    wp_enqueue_style('dashicons');

    wp_enqueue_script(
        'virtualskyhost-theme',
        get_template_directory_uri() . '/assets/js/theme.js',
        ['wp-api-fetch'],
        $theme_version,
        true
    );

    wp_localize_script(
        'virtualskyhost-theme',
        'virtualSkyHost',
        [
            'apiBase' => esc_url_raw(virtualskyhost_get_api_base_url()),
            'domainSearchEndpoint' => esc_url_raw(virtualskyhost_get_domain_search_endpoint()),
            'pricingEndpoint' => esc_url_raw(virtualskyhost_get_pricing_endpoint()),
            'orderBaseUrl' => esc_url_raw(virtualskyhost_get_order_base_url()),
        ]
    );
});

add_filter('body_class', function (array $classes): array {
    $classes[] = 'virtualskyhost-theme';
    return $classes;
});
