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

if (!function_exists('virtualskywp_ensure_core_pages')) {
    function virtualskywp_ensure_core_pages(): void
    {
        $pages = [
            [
                'title' => __('Home', 'virtualskywp'),
                'slug' => 'home',
                'template' => '',
                'content' => '<!-- wp:cover {"dimRatio":70,"overlayColor":"black","minHeight":520,"isDark":true} -->\n<div class="wp-block-cover is-dark" style="min-height:520px"><span aria-hidden="true" class="wp-block-cover__background has-black-background-color has-background-dim-70 has-background-dim"></span><div class="wp-block-cover__inner-container"><!-- wp:heading {"textAlign":"center","textColor":"primary","fontSize":"huge"} -->\n<h2 class="has-text-align-center has-primary-color has-text-color has-huge-font-size">' . esc_html__('Welcome to Virtual Sky', 'virtualskywp') . '</h2>\n<!-- /wp:heading --><!-- wp:paragraph {"align":"center","textColor":"white"} -->\n<p class="has-text-align-center has-white-color has-text-color">' . esc_html__('Your Hostinger-inspired AI hosting experience is ready. Customize this page or replace it with your own blocks.', 'virtualskywp') . '</p>\n<!-- /wp:paragraph --></div></div>\n<!-- /wp:cover -->',
            ],
            [
                'title' => __('Web Hosting', 'virtualskywp'),
                'slug' => 'web-hosting',
                'template' => 'page-web-hosting.php',
                'content' => '',
            ],
            [
                'title' => __('WordPress Hosting', 'virtualskywp'),
                'slug' => 'wordpress-hosting',
                'template' => 'page-wordpress-hosting.php',
                'content' => '',
            ],
            [
                'title' => __('Reseller Hosting', 'virtualskywp'),
                'slug' => 'reseller-hosting',
                'template' => 'page-reseller-hosting.php',
                'content' => '',
            ],
            [
                'title' => __('VPS Hosting', 'virtualskywp'),
                'slug' => 'vps-hosting',
                'template' => 'page-vps-hosting.php',
                'content' => '',
            ],
            [
                'title' => __('AI Hosting', 'virtualskywp'),
                'slug' => 'ai-hosting',
                'template' => 'page-ai-hosting.php',
                'content' => '',
            ],
            [
                'title' => __('Website Builder', 'virtualskywp'),
                'slug' => 'website-builder',
                'template' => 'page-website-builder.php',
                'content' => '',
            ],
            [
                'title' => __('AI Tools', 'virtualskywp'),
                'slug' => 'ai-tools',
                'template' => 'page-ai-tools.php',
                'content' => '',
            ],
            [
                'title' => __('AI Agent Builder', 'virtualskywp'),
                'slug' => 'ai-agent-builder',
                'template' => 'page-ai-agent-builder.php',
                'content' => '',
            ],
            [
                'title' => __('Contact', 'virtualskywp'),
                'slug' => 'contact',
                'template' => 'page.php',
                'content' => '<!-- wp:heading -->\n<h2>' . esc_html__('Talk with Virtual Sky', 'virtualskywp') . '</h2>\n<!-- /wp:heading --><!-- wp:paragraph -->\n<p>' . esc_html__('Drop us a line at hello@virtualsky.io or connect via WHMCS support to reach the team.', 'virtualskywp') . '</p>\n<!-- /wp:paragraph -->',
            ],
        ];

        $homeId = null;

        foreach ($pages as $page) {
            $existing = get_page_by_path($page['slug']);
            $pageId = $existing instanceof \WP_Post ? (int) $existing->ID : 0;

            if (!$pageId) {
                $pageId = (int) wp_insert_post([
                    'post_title' => $page['title'],
                    'post_name' => $page['slug'],
                    'post_status' => 'publish',
                    'post_type' => 'page',
                    'post_content' => $page['content'] !== '' ? wp_slash($page['content']) : '',
                ]);
            }

            if ($pageId && $page['template'] && $page['template'] !== 'page.php') {
                update_post_meta($pageId, '_wp_page_template', $page['template']);
            }

            if ($page['slug'] === 'home' && $pageId) {
                $homeId = $pageId;
            }
        }

        if ($homeId) {
            update_option('show_on_front', 'page');
            update_option('page_on_front', $homeId);
        }
    }
}
add_action('after_switch_theme', 'virtualskywp_ensure_core_pages');

add_filter('body_class', static function (array $classes): array {
    $classes[] = 'virtualskywp';

    if (virtualskywp_get_option('enable_dark_mode', true)) {
        $classes[] = 'theme-dark';
    }

    return $classes;
});
