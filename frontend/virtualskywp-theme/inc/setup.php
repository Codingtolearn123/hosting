<?php
/**
 * Theme supports, assets, and global filters.
 */

declare(strict_types=1);

if (!defined('ABSPATH')) {
    exit;
}

if (!function_exists('virtualskywp_setup')) {
    function virtualskywp_setup(): void
    {
        add_theme_support('title-tag');
        add_theme_support('post-thumbnails');
        add_theme_support('editor-styles');
        add_theme_support('responsive-embeds');
        add_theme_support('wp-block-styles');
        add_theme_support('align-wide');

        add_editor_style('assets/css/editor.css');

        register_nav_menus([
            'primary' => __('Primary Menu', 'virtualskywp'),
            'footer' => __('Footer Menu', 'virtualskywp'),
        ]);
    }
}
add_action('after_setup_theme', 'virtualskywp_setup');

if (!function_exists('virtualskywp_enqueue_assets')) {
    function virtualskywp_enqueue_assets(): void
    {
        $theme_version = wp_get_theme()->get('Version');

        wp_enqueue_style(
            'virtualskywp-tailwind',
            'https://cdn.jsdelivr.net/npm/tailwindcss@3.4.3/dist/tailwind.min.css',
            [],
            '3.4.3'
        );

        wp_enqueue_style(
            'virtualskywp-theme',
            get_template_directory_uri() . '/style.css',
            ['virtualskywp-tailwind'],
            $theme_version
        );

        wp_enqueue_script(
            'virtualskywp-theme',
            get_template_directory_uri() . '/assets/js/theme.js',
            ['wp-api-fetch', 'wp-element'],
            $theme_version,
            true
        );

        wp_localize_script(
            'virtualskywp-theme',
            'virtualSkyWP',
            [
                'options' => virtualskywp_get_theme_options(),
                'restUrl' => esc_url_raw(get_rest_url()),
                'whmcs' => [
                    'cart' => esc_url_raw(virtualskywp_get_option('whmcs_cart_url')),
                    'login' => esc_url_raw(virtualskywp_get_option('whmcs_login_url')),
                ],
            ]
        );
    }
}
add_action('wp_enqueue_scripts', 'virtualskywp_enqueue_assets');

add_action('enqueue_block_editor_assets', static function (): void {
    wp_enqueue_style(
        'virtualskywp-editor-tailwind',
        'https://cdn.jsdelivr.net/npm/tailwindcss@3.4.3/dist/tailwind.min.css',
        [],
        '3.4.3'
    );

    wp_enqueue_style(
        'virtualskywp-editor',
        get_template_directory_uri() . '/assets/css/editor.css',
        ['virtualskywp-editor-tailwind'],
        wp_get_theme()->get('Version')
    );
});

add_filter('body_class', static function (array $classes): array {
    $classes[] = 'virtualskywp';

    if (virtualskywp_get_option('enable_dark_mode', true)) {
        $classes[] = 'theme-dark';
    }

    return $classes;
});
