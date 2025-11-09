<?php
declare(strict_types=1);

if (!defined('ABSPATH')) {
    exit;
}

const VIRTUALSKYHOST_OPTION_GROUP = 'virtualskyhost_whmcs_bridge';
const VIRTUALSKYHOST_OPTION_NAME = 'virtualskyhost_whmcs_settings';

add_action('admin_init', function (): void {
    register_setting(VIRTUALSKYHOST_OPTION_GROUP, VIRTUALSKYHOST_OPTION_NAME, [
        'sanitize_callback' => function ($values) {
            if (!is_array($values)) {
                $values = [];
            }
            return [
                'url' => esc_url_raw($values['url'] ?? ''),
                'identifier' => sanitize_text_field($values['identifier'] ?? ''),
                'secret' => sanitize_text_field($values['secret'] ?? ''),
            ];
        },
        'default' => [],
    ]);

    add_settings_section(
        'virtualskyhost_whmcs_connection',
        __('WHMCS API Connection', 'virtualskyhost'),
        function (): void {
            echo '<p>' . esc_html__('Configure the WHMCS API credentials used by the VirtualSkyHost integration layer.', 'virtualskyhost') . '</p>';
        },
        VIRTUALSKYHOST_OPTION_GROUP
    );

    add_settings_field(
        'virtualskyhost_whmcs_url',
        __('WHMCS URL', 'virtualskyhost'),
        function (): void {
            $options = get_option(VIRTUALSKYHOST_OPTION_NAME, []);
            printf('<input type="url" name="%1$s[url]" value="%2$s" class="regular-text" placeholder="https://billing.virtualskyhost.com/includes/api.php" />', esc_attr(VIRTUALSKYHOST_OPTION_NAME), esc_attr($options['url'] ?? ''));
        },
        VIRTUALSKYHOST_OPTION_GROUP,
        'virtualskyhost_whmcs_connection'
    );

    add_settings_field(
        'virtualskyhost_whmcs_identifier',
        __('API Identifier', 'virtualskyhost'),
        function (): void {
            $options = get_option(VIRTUALSKYHOST_OPTION_NAME, []);
            printf('<input type="text" name="%1$s[identifier]" value="%2$s" class="regular-text" />', esc_attr(VIRTUALSKYHOST_OPTION_NAME), esc_attr($options['identifier'] ?? ''));
        },
        VIRTUALSKYHOST_OPTION_GROUP,
        'virtualskyhost_whmcs_connection'
    );

    add_settings_field(
        'virtualskyhost_whmcs_secret',
        __('API Secret', 'virtualskyhost'),
        function (): void {
            $options = get_option(VIRTUALSKYHOST_OPTION_NAME, []);
            printf('<input type="password" name="%1$s[secret]" value="%2$s" class="regular-text" />', esc_attr(VIRTUALSKYHOST_OPTION_NAME), esc_attr($options['secret'] ?? ''));
        },
        VIRTUALSKYHOST_OPTION_GROUP,
        'virtualskyhost_whmcs_connection'
    );
});

add_action('admin_menu', function (): void {
    add_options_page(
        __('VirtualSkyHost WHMCS', 'virtualskyhost'),
        __('VirtualSkyHost WHMCS', 'virtualskyhost'),
        'manage_options',
        'virtualskyhost-whmcs',
        'virtualskyhost_render_settings_page'
    );
});

function virtualskyhost_render_settings_page(): void
{
    if (!current_user_can('manage_options')) {
        return;
    }

    echo '<div class="wrap">';
    echo '<h1>' . esc_html__('VirtualSkyHost WHMCS Bridge', 'virtualskyhost') . '</h1>';
    echo '<form method="post" action="options.php">';
    settings_fields(VIRTUALSKYHOST_OPTION_GROUP);
    do_settings_sections(VIRTUALSKYHOST_OPTION_GROUP);
    submit_button();
    echo '</form>';
    echo '</div>';
}

function virtualskyhost_get_settings(): array
{
    $defaults = [
        'url' => getenv('WHMCS_URL') ?: '',
        'identifier' => getenv('WHMCS_IDENTIFIER') ?: '',
        'secret' => getenv('WHMCS_SECRET') ?: '',
    ];

    $options = get_option(VIRTUALSKYHOST_OPTION_NAME, []);

    return array_merge($defaults, array_filter($options));
}
