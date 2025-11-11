<?php
/**
 * Theme supports, assets, and global filters.
 */

declare(strict_types=1);

if (!defined('ABSPATH')) {
    exit;
}

if (!function_exists('virtualskywp_tailwind_config_js')) {
    function virtualskywp_tailwind_config_js(): string
    {
        return 'tailwind.config = { theme: { extend: { colors: { primary: "#6C63FF", secondary: "#007BFF", accent: "#FF6CAB" }, fontFamily: { sans: ["Inter", "Poppins", "system-ui", "sans-serif"] }, }, }, corePlugins: { preflight: true } };';
    }
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
        $tailwind_handle = 'virtualskywp-tailwind-runtime';

        wp_enqueue_script(
            $tailwind_handle,
            'https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4.0.0-alpha.10/dist/tailwind.js',
            [],
            '4.0.0-alpha.10',
            false
        );

        wp_add_inline_script($tailwind_handle, virtualskywp_tailwind_config_js(), 'before');

        wp_enqueue_style(
            'virtualskywp-theme',
            get_template_directory_uri() . '/style.css',
            [],
            $theme_version
        );

        wp_enqueue_script(
            'virtualskywp-theme',
            get_template_directory_uri() . '/assets/js/theme.js',
            ['wp-api-fetch', 'wp-element', 'wp-i18n'],
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
    $tailwind_handle = 'virtualskywp-editor-tailwind-runtime';

    wp_enqueue_script(
        $tailwind_handle,
        'https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4.0.0-alpha.10/dist/tailwind.js',
        [],
        '4.0.0-alpha.10',
        false
    );

    wp_add_inline_script($tailwind_handle, virtualskywp_tailwind_config_js(), 'before');

    wp_enqueue_style(
        'virtualskywp-editor',
        get_template_directory_uri() . '/assets/css/editor.css',
        [],
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
