<?php
declare(strict_types=1);

if (!defined('ABSPATH')) {
    exit;
}

function virtualskyhost_whmcs_request(string $action, array $params = []): array
{
    $settings = virtualskyhost_get_settings();

    if (empty($settings['url']) || empty($settings['identifier']) || empty($settings['secret'])) {
        return ['success' => false, 'message' => __('WHMCS credentials are not configured.', 'virtualskyhost')];
    }

    $body = array_merge(
        [
            'identifier' => $settings['identifier'],
            'secret' => $settings['secret'],
            'action' => $action,
            'responsetype' => 'json',
        ],
        $params
    );

    $response = wp_remote_post($settings['url'], [
        'timeout' => 20,
        'body' => $body,
    ]);

    if (is_wp_error($response)) {
        return ['success' => false, 'message' => $response->get_error_message()];
    }

    $data = json_decode((string) wp_remote_retrieve_body($response), true);

    if (!is_array($data)) {
        return ['success' => false, 'message' => __('Unexpected response from WHMCS.', 'virtualskyhost')];
    }

    return $data;
}

function virtualskyhost_whmcs_get_pricing(string $category): array
{
    $result = virtualskyhost_whmcs_request('GetProducts', [
        'gid' => $category,
        'module' => true,
    ]);

    if (!empty($result['result']) && $result['result'] === 'success' && !empty($result['products']['product'])) {
        return array_map(static function ($product) {
            return [
                'id' => $product['pid'] ?? '',
                'product_id' => $product['pid'] ?? '',
                'name' => $product['name'] ?? '',
                'description' => wp_strip_all_tags($product['description'] ?? ''),
                'price' => isset($product['pricing']['USD']['monthly'])
                    ? '$' . number_format((float) $product['pricing']['USD']['monthly'], 2)
                    : '',
                'features' => !empty($product['features']) ? (array) $product['features'] : [],
            ];
        }, $result['products']['product']);
    }

    return [];
}

function virtualskyhost_whmcs_domain_search(string $domain): array
{
    $result = virtualskyhost_whmcs_request('DomainWhois', [
        'domain' => $domain,
    ]);

    if (!empty($result['result']) && $result['result'] === 'success') {
        return [
            'domain' => $domain,
            'available' => ($result['status'] ?? '') === 'available',
            'message' => $result['status'] ?? '',
        ];
    }

    return [
        'domain' => $domain,
        'available' => false,
        'message' => $result['message'] ?? __('Unable to determine domain status.', 'virtualskyhost'),
    ];
}

function virtualskyhost_whmcs_create_order(array $payload): array
{
    $result = virtualskyhost_whmcs_request('AddOrder', $payload);

    if (!empty($result['result']) && $result['result'] === 'success') {
        return [
            'success' => true,
            'orderid' => $result['orderid'] ?? null,
            'invoiceid' => $result['invoiceid'] ?? null,
        ];
    }

    return [
        'success' => false,
        'message' => $result['message'] ?? __('Unable to create order.', 'virtualskyhost'),
    ];
}
