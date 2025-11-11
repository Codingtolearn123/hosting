<?php
/**
 * WHMCS integration helpers for syncing plan data.
 */

declare(strict_types=1);

if (!defined('ABSPATH')) {
    exit;
}

const VIRTUALSKYWP_WHMCS_TYPES = ['shared', 'wordpress', 'reseller', 'vps', 'ai'];
const VIRTUALSKYWP_WHMCS_CACHE_PREFIX = 'virtualskywp_whmcs_plans_';

function virtualskywp_get_hosting_plans(string $type = 'shared'): array
{
    if ($type === '') {
        $all = [];
        foreach (VIRTUALSKYWP_WHMCS_TYPES as $slug) {
            $all[$slug] = virtualskywp_get_hosting_plans($slug);
        }

        return $all;
    }

    if (!in_array($type, VIRTUALSKYWP_WHMCS_TYPES, true)) {
        return [];
    }

    $cache_key = VIRTUALSKYWP_WHMCS_CACHE_PREFIX . $type;
    $cached = get_transient($cache_key);
    if ($cached !== false) {
        return is_array($cached) ? $cached : [];
    }

    $plans = virtualskywp_fetch_whmcs_products($type);

    set_transient($cache_key, $plans, HOUR_IN_SECONDS);

    return $plans;
}

function virtualskywp_fetch_whmcs_products(string $type): array
{
    $options = virtualskywp_get_theme_options();
    $endpoint = trim((string) ($options['whmcs_api_endpoint'] ?? ''));
    $identifier = trim((string) ($options['whmcs_api_identifier'] ?? ''));
    $secret = trim((string) ($options['whmcs_api_secret'] ?? ''));
    $group_id = trim((string) ($options['whmcs_group_' . $type] ?? ''));
    $currency = strtoupper(trim((string) ($options['whmcs_currency'] ?? 'USD')));

    if ($endpoint === '' || $group_id === '') {
        return [];
    }

    $request = [
        'timeout' => 20,
        'body' => [
            'action' => 'GetProducts',
            'responsetype' => 'json',
            'gid' => $group_id,
        ],
    ];

    if ($identifier !== '' && $secret !== '') {
        $request['body']['identifier'] = $identifier;
        $request['body']['secret'] = $secret;
    }

    $response = wp_remote_post($endpoint, $request);

    if (is_wp_error($response)) {
        return [];
    }

    $data = json_decode((string) wp_remote_retrieve_body($response), true);

    if (!is_array($data) || ($data['result'] ?? '') !== 'success') {
        return [];
    }

    $products = $data['products']['product'] ?? [];

    if (!is_array($products)) {
        return [];
    }

    $plans = [];

    foreach ($products as $product) {
        if (!is_array($product)) {
            continue;
        }

        $plans[] = virtualskywp_map_whmcs_product($product, $options, $currency, $type);
    }

    return $plans;
}

function virtualskywp_map_whmcs_product(array $product, array $options, string $currency, string $type): array
{
    $pricing = $product['pricing'] ?? [];
    $currencyPricing = $pricing[$currency] ?? (is_array($pricing) ? reset($pricing) : []);

    $monthly = is_array($currencyPricing) ? ($currencyPricing['monthly'] ?? '') : '';
    $yearly = is_array($currencyPricing) ? ($currencyPricing['annually'] ?? ($currencyPricing['yearly'] ?? '')) : '';
    $setupFee = is_array($currencyPricing) ? ($currencyPricing['setupfee'] ?? '') : '';

    $promo = virtualskywp_whmcs_custom_field($product, 'Promo Price')
        ?? virtualskywp_whmcs_custom_field($product, 'First Month Price')
        ?? '';

    $badge = virtualskywp_whmcs_custom_field($product, 'Badge')
        ?? virtualskywp_whmcs_custom_field($product, 'Badge Text')
        ?? '';

    $freeDomainField = virtualskywp_whmcs_custom_field($product, 'Free Domain')
        ?? ($product['freedomain'] ?? '');
    $aiReadyField = virtualskywp_whmcs_custom_field($product, 'AI Ready')
        ?? virtualskywp_whmcs_custom_field($product, 'AI Optimized');
    $highlightField = virtualskywp_whmcs_custom_field($product, 'Highlight')
        ?? virtualskywp_whmcs_custom_field($product, 'Featured');

    $featuresRaw = virtualskywp_whmcs_custom_field($product, 'Features')
        ?? virtualskywp_whmcs_custom_field($product, 'Feature List')
        ?? '';

    if ($featuresRaw === '' && isset($product['description'])) {
        $featuresRaw = virtualskywp_extract_features_from_description((string) $product['description']);
    }

    $features = array_filter(array_map('trim', is_array($featuresRaw) ? $featuresRaw : preg_split('/\r\n|\n|\r/', (string) $featuresRaw)));

    $excerpt = virtualskywp_generate_excerpt_from_description((string) ($product['description'] ?? ''));
    $description = wp_kses_post(wpautop((string) ($product['description'] ?? '')));

    $baseCart = trim((string) ($options['whmcs_cart_url'] ?? ''));
    $cartLink = $baseCart !== '' ? trailingslashit($baseCart) . 'cart.php?a=add&pid=' . (int) ($product['pid'] ?? 0) : '';

    $n8nWebhook = virtualskywp_whmcs_custom_field($product, 'n8n Webhook')
        ?? virtualskywp_whmcs_custom_field($product, 'Automation Webhook')
        ?? '';

    return [
        'id' => (int) ($product['pid'] ?? 0),
        'title' => wp_strip_all_tags((string) ($product['name'] ?? '')),
        'content' => $description,
        'excerpt' => $excerpt,
        'price_monthly' => virtualskywp_format_currency($monthly, $currency),
        'price_yearly' => virtualskywp_format_currency($yearly, $currency),
        'promo_price' => virtualskywp_format_currency($promo, $currency),
        'badge_text' => wp_strip_all_tags((string) $badge),
        'whmcs_link' => $cartLink,
        'n8n_webhook' => esc_url_raw((string) $n8nWebhook),
        'highlighted' => virtualskywp_truthy_string($highlightField),
        'free_domain' => virtualskywp_truthy_string($freeDomainField),
        'ai_ready' => virtualskywp_truthy_string($aiReadyField),
        'features' => $features,
        'thumbnail' => '',
        'types' => [$type],
        'setup_fee' => virtualskywp_format_currency($setupFee, $currency),
    ];
}

function virtualskywp_format_currency($value, string $currency): string
{
    if ($value === '' || $value === null) {
        return '';
    }

    $amount = (float) $value;

    if ($amount <= 0.0) {
        return '';
    }

    $symbol = virtualskywp_whmcs_currency_symbol($currency);
    $formatted = number_format_i18n($amount, $amount === (float) (int) $amount ? 0 : 2);

    return sprintf('%s%s', $symbol, $formatted);
}

function virtualskywp_whmcs_currency_symbol(string $currency): string
{
    $map = [
        'USD' => '$',
        'EUR' => '€',
        'GBP' => '£',
        'AUD' => 'A$',
        'CAD' => 'C$',
        'JPY' => '¥',
        'INR' => '₹',
    ];

    return $map[$currency] ?? $currency . ' ';
}

function virtualskywp_whmcs_custom_field(array $product, string $key)
{
    $customfields = $product['customfields']['customfield'] ?? [];

    if (!is_array($customfields)) {
        return null;
    }

    foreach ($customfields as $field) {
        if (!is_array($field)) {
            continue;
        }

        if (isset($field['name']) && strcasecmp((string) $field['name'], $key) === 0) {
            return $field['value'] ?? '';
        }
    }

    return null;
}

function virtualskywp_extract_features_from_description(string $description)
{
    if ($description === '') {
        return [];
    }

    $plain = wp_strip_all_tags($description);
    $lines = preg_split('/\r\n|\n|\r/', (string) $plain);

    if (!is_array($lines)) {
        return [];
    }

    $features = [];

    foreach ($lines as $line) {
        $clean = trim((string) $line);
        if ($clean === '') {
            continue;
        }

        if (preg_match('/^[-*•]/u', $clean)) {
            $clean = trim((string) preg_replace('/^[-*•\s]+/u', '', $clean));
        }

        if ($clean !== '') {
            $features[] = $clean;
        }
    }

    return $features;
}

function virtualskywp_generate_excerpt_from_description(string $description): string
{
    if ($description === '') {
        return '';
    }

    $plain = wp_strip_all_tags($description);
    $plain = trim(preg_replace('/\s+/', ' ', $plain));

    if ($plain === '') {
        return '';
    }

    $excerpt = wp_trim_words($plain, 30, '…');

    return esc_html($excerpt);
}

function virtualskywp_truthy_string($value): bool
{
    if (is_bool($value)) {
        return $value;
    }

    $normalized = strtolower(trim((string) $value));

    return in_array($normalized, ['1', 'yes', 'true', 'on', 'enabled'], true);
}

function virtualskywp_clear_whmcs_plan_cache(): void
{
    foreach (VIRTUALSKYWP_WHMCS_TYPES as $type) {
        delete_transient(VIRTUALSKYWP_WHMCS_CACHE_PREFIX . $type);
    }
}

add_action('update_option_' . VIRTUALSKYWP_OPTION_KEY, static function (): void {
    virtualskywp_clear_whmcs_plan_cache();
});
