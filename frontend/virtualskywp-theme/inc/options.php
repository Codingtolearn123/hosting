<?php
/**
 * Theme Options Panel registration and helpers.
 */

declare(strict_types=1);

if (!defined('ABSPATH')) {
    exit;
}

const VIRTUALSKYWP_OPTION_KEY = 'virtualskywp_options';

if (!function_exists('virtualskywp_get_theme_options')) {
    function virtualskywp_get_theme_options(): array
    {
        $defaults = [
            'primary_color' => '#6c63ff',
            'secondary_color' => '#007bff',
            'accent_gradient_start' => '#6c63ff',
            'accent_gradient_end' => '#ff6cab',
            'hero_headline' => __('Get Web Hosting Starting at $1', 'virtualskywp'),
            'hero_subheadline' => __('Fast, Secure & AI-Powered Hosting for Modern Creators', 'virtualskywp'),
            'hero_video_url' => '',
            'whmcs_cart_url' => '',
            'whmcs_login_url' => '',
            'cta_view_plans_anchor' => '#pricing',
            'cta_builder_url' => '',
            'free_domain_banner' => __('Free Domain with Annual Plan', 'virtualskywp'),
            'enable_one_dollar_promo' => true,
            'enable_dark_mode' => true,
            'n8n_api_key' => '',
            'ai_api_key' => '',
            'floating_chat_enabled' => true,
            'whmcs_api_endpoint' => '',
            'whmcs_api_identifier' => '',
            'whmcs_api_secret' => '',
            'whmcs_currency' => 'USD',
            'whmcs_group_shared' => '',
            'whmcs_group_wordpress' => '',
            'whmcs_group_reseller' => '',
            'whmcs_group_vps' => '',
            'whmcs_group_ai' => '',
        ];

        $options = get_option(VIRTUALSKYWP_OPTION_KEY, []);

        return wp_parse_args($options, $defaults);
    }
}

if (!function_exists('virtualskywp_get_option')) {
    function virtualskywp_get_option(string $key, $default = null)
    {
        $options = virtualskywp_get_theme_options();

        return $options[$key] ?? $default;
    }
}

add_action('admin_menu', static function (): void {
    add_theme_page(
        __('Virtual Sky Options', 'virtualskywp'),
        __('Virtual Sky Options', 'virtualskywp'),
        'manage_options',
        'virtualskywp-options',
        'virtualskywp_render_options_page'
    );
});

add_action('admin_init', static function (): void {
    register_setting(VIRTUALSKYWP_OPTION_KEY, VIRTUALSKYWP_OPTION_KEY, [
        'type' => 'array',
        'sanitize_callback' => 'virtualskywp_sanitize_options',
        'default' => virtualskywp_get_theme_options(),
    ]);

    add_settings_section(
        'virtualskywp_general',
        __('Brand Settings', 'virtualskywp'),
        '__return_false',
        'virtualskywp-options'
    );

    $fields = [
        'hero_headline' => __('Hero Headline', 'virtualskywp'),
        'hero_subheadline' => __('Hero Subheadline', 'virtualskywp'),
        'hero_video_url' => __('Hero Video URL (MP4/WebM)', 'virtualskywp'),
        'whmcs_cart_url' => __('WHMCS Cart URL', 'virtualskywp'),
        'whmcs_login_url' => __('WHMCS Client Login URL', 'virtualskywp'),
        'cta_view_plans_anchor' => __('View Plans Anchor/URL', 'virtualskywp'),
        'cta_builder_url' => __('AI Builder URL', 'virtualskywp'),
        'free_domain_banner' => __('Global Free Domain Banner Text', 'virtualskywp'),
    ];

    foreach ($fields as $field => $label) {
        add_settings_field(
            $field,
            $label,
            'virtualskywp_render_text_field',
            'virtualskywp-options',
            'virtualskywp_general',
            [
                'key' => $field,
                'type' => 'text',
            ]
        );
    }

    add_settings_field(
        'enable_one_dollar_promo',
        __('Enable $1 First Month Banner', 'virtualskywp'),
        'virtualskywp_render_checkbox_field',
        'virtualskywp-options',
        'virtualskywp_general',
        [
            'key' => 'enable_one_dollar_promo',
        ]
    );

    add_settings_field(
        'floating_chat_enabled',
        __('Enable Floating Chat Widget', 'virtualskywp'),
        'virtualskywp_render_checkbox_field',
        'virtualskywp-options',
        'virtualskywp_general',
        [
            'key' => 'floating_chat_enabled',
        ]
    );

    add_settings_section(
        'virtualskywp_integrations',
        __('Integrations', 'virtualskywp'),
        '__return_false',
        'virtualskywp-options'
    );

    add_settings_field(
        'n8n_api_key',
        __('n8n API Key', 'virtualskywp'),
        'virtualskywp_render_text_field',
        'virtualskywp-options',
        'virtualskywp_integrations',
        [
            'key' => 'n8n_api_key',
            'type' => 'password',
        ]
    );

    add_settings_field(
        'ai_api_key',
        __('AI Platform API Key', 'virtualskywp'),
        'virtualskywp_render_text_field',
        'virtualskywp-options',
        'virtualskywp_integrations',
        [
            'key' => 'ai_api_key',
            'type' => 'password',
        ]
    );

    add_settings_section(
        'virtualskywp_whmcs',
        __('WHMCS Sync', 'virtualskywp'),
        static function (): void {
            echo '<p class="description">' . esc_html__('Connect the VirtualSkyWP front end to your WHMCS catalog. Pricing, badges, and automation flags come directly from product custom fields so all edits stay inside WHMCS.', 'virtualskywp') . '</p>';
        },
        'virtualskywp-options'
    );

    $whmcs_fields = [
        ['whmcs_api_endpoint', __('WHMCS API Endpoint (includes/api.php)', 'virtualskywp'), 'text', __('Example: https://billing.virtualsky.io/includes/api.php', 'virtualskywp')],
        ['whmcs_api_identifier', __('API Identifier', 'virtualskywp'), 'text', ''],
        ['whmcs_api_secret', __('API Secret', 'virtualskywp'), 'password', ''],
        ['whmcs_currency', __('Default Currency Code', 'virtualskywp'), 'text', __('Matches your WHMCS pricing currency (USD, EUR, etc.)', 'virtualskywp')],
        ['whmcs_group_shared', __('Shared Hosting Group ID', 'virtualskywp'), 'text', __('Numeric WHMCS product group ID for shared hosting', 'virtualskywp')],
        ['whmcs_group_wordpress', __('WordPress Hosting Group ID', 'virtualskywp'), 'text', __('Numeric WHMCS product group ID for WordPress hosting', 'virtualskywp')],
        ['whmcs_group_reseller', __('Reseller Hosting Group ID', 'virtualskywp'), 'text', __('Numeric WHMCS product group ID for reseller plans', 'virtualskywp')],
        ['whmcs_group_vps', __('VPS Hosting Group ID', 'virtualskywp'), 'text', __('Numeric WHMCS product group ID for VPS plans', 'virtualskywp')],
        ['whmcs_group_ai', __('AI Hosting Group ID', 'virtualskywp'), 'text', __('Numeric WHMCS product group ID for AI hosting', 'virtualskywp')],
    ];

    foreach ($whmcs_fields as [$key, $label, $type, $description]) {
        add_settings_field(
            $key,
            $label,
            'virtualskywp_render_text_field',
            'virtualskywp-options',
            'virtualskywp_whmcs',
            [
                'key' => $key,
                'type' => $type,
                'description' => $description,
            ]
        );
    }
});

if (!function_exists('virtualskywp_render_options_page')) {
    function virtualskywp_render_options_page(): void
    {
        if (!current_user_can('manage_options')) {
            return;
        }

        ?>
        <div class="wrap virtualskywp-options">
            <h1><?php esc_html_e('Virtual Sky Options', 'virtualskywp'); ?></h1>
            <form action="options.php" method="post">
                <?php
                settings_fields(VIRTUALSKYWP_OPTION_KEY);
                do_settings_sections('virtualskywp-options');
                submit_button();
                ?>
            </form>
        </div>
        <?php
    }
}

if (!function_exists('virtualskywp_render_text_field')) {
    function virtualskywp_render_text_field(array $args): void
    {
        $key = $args['key'];
        $type = $args['type'] ?? 'text';
        $value = virtualskywp_get_option($key, '');
        $description = $args['description'] ?? '';
        printf('<input type="%1$s" name="%2$s[%3$s]" value="%4$s" class="regular-text" />', esc_attr($type), esc_attr(VIRTUALSKYWP_OPTION_KEY), esc_attr($key), esc_attr((string) $value));

        if ($description) {
            printf('<p class="description">%s</p>', esc_html($description));
        }
    }
}

if (!function_exists('virtualskywp_render_checkbox_field')) {
    function virtualskywp_render_checkbox_field(array $args): void
    {
        $key = $args['key'];
        $value = (bool) virtualskywp_get_option($key, false);
        printf(
            '<label><input type="checkbox" name="%1$s[%2$s]" value="1" %3$s /> %4$s</label>',
            esc_attr(VIRTUALSKYWP_OPTION_KEY),
            esc_attr($key),
            checked($value, true, false),
            esc_html__('Enable', 'virtualskywp')
        );
    }
}

if (!function_exists('virtualskywp_sanitize_options')) {
    function virtualskywp_sanitize_options(array $input): array
    {
        $options = virtualskywp_get_theme_options();

        foreach ($input as $key => $value) {
            switch ($key) {
                case 'enable_one_dollar_promo':
                case 'floating_chat_enabled':
                case 'enable_dark_mode':
                    $options[$key] = (bool) $value;
                    break;
                case 'whmcs_api_endpoint':
                case 'whmcs_cart_url':
                case 'whmcs_login_url':
                case 'cta_builder_url':
                case 'hero_video_url':
                    $options[$key] = esc_url_raw((string) $value);
                    break;
                case 'n8n_api_key':
                case 'ai_api_key':
                case 'whmcs_api_identifier':
                case 'whmcs_api_secret':
                case 'whmcs_group_shared':
                case 'whmcs_group_wordpress':
                case 'whmcs_group_reseller':
                case 'whmcs_group_vps':
                case 'whmcs_group_ai':
                    $options[$key] = sanitize_text_field((string) $value);
                    break;
                case 'whmcs_currency':
                    $options[$key] = strtoupper(sanitize_text_field((string) $value));
                    break;
                default:
                    $options[$key] = sanitize_text_field((string) $value);
                    break;
            }
        }

        return $options;
    }
}
