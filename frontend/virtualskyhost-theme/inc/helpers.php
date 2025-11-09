<?php
/**
 * Helper utilities for VirtualSkyHost theme.
 */

declare(strict_types=1);

if (!defined('ABSPATH')) {
    exit;
}

function virtualskyhost_get_option(string $key, ?string $default = null): ?string
{
    $value = getenv(strtoupper($key));

    if ($value !== false) {
        return $value === '' ? $default : $value;
    }

    $option_key = 'virtualskyhost_' . $key;
    $option_value = get_option($option_key, $default);

    return is_string($option_value) ? $option_value : $default;
}

function virtualskyhost_get_api_base_url(): string
{
    return virtualskyhost_get_option('api_base_url', 'https://api.virtualskyhost.com');
}

function virtualskyhost_get_domain_search_endpoint(): string
{
    return virtualskyhost_get_api_base_url() . '/api/domain/search';
}

function virtualskyhost_get_pricing_endpoint(): string
{
    return virtualskyhost_get_api_base_url() . '/api/hosting/plans';
}

function virtualskyhost_get_order_base_url(): string
{
    return virtualskyhost_get_option('order_base_url', 'https://billing.virtualskyhost.com/cart.php');
}

function virtualskyhost_get_clientarea_url(): string
{
    return virtualskyhost_get_option('clientarea_url', 'https://billing.virtualskyhost.com/clientarea.php');
}

function virtualskyhost_fetch_pricing(string $category): array
{
    if (function_exists('virtualskyhost_whmcs_get_pricing')) {
        return virtualskyhost_whmcs_get_pricing($category);
    }

    $response = wp_remote_get(virtualskyhost_get_pricing_endpoint() . '?category=' . urlencode($category));

    if (is_wp_error($response)) {
        return [];
    }

    $data = json_decode((string) wp_remote_retrieve_body($response), true);

    return is_array($data) ? $data : [];
}

function virtualskyhost_format_category(string $category): string
{
    $map = [
        'wordpress' => 'WordPress',
    ];

    if (isset($map[$category])) {
        return $map[$category];
    }

    return ucwords(str_replace('-', ' ', $category));
}

