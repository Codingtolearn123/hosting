<?php
declare(strict_types=1);

if (!defined('ABSPATH')) {
    exit;
}

add_action('rest_api_init', function (): void {
    register_rest_route('virtualskyhost/v1', '/plans', [
        'methods' => 'GET',
        'callback' => function (\WP_REST_Request $request) {
            $category = (string) $request->get_param('category');
            return rest_ensure_response(virtualskyhost_whmcs_get_pricing($category ?: 'shared'));
        },
        'permission_callback' => '__return_true',
    ]);

    register_rest_route('virtualskyhost/v1', '/domain-search', [
        'methods' => 'GET',
        'callback' => function (\WP_REST_Request $request) {
            $domain = trim((string) $request->get_param('domain'));
            if ($domain === '') {
                return new \WP_Error('invalid_domain', __('Domain parameter is required.', 'virtualskyhost'), ['status' => 400]);
            }
            return rest_ensure_response(virtualskyhost_whmcs_domain_search($domain));
        },
        'permission_callback' => '__return_true',
    ]);

    register_rest_route('virtualskyhost/v1', '/order', [
        'methods' => 'POST',
        'callback' => function (\WP_REST_Request $request) {
            $params = $request->get_json_params();
            $payload = is_array($params) ? $params : [];
            $result = virtualskyhost_whmcs_create_order($payload);

            if (empty($result['success'])) {
                return new \WP_Error('order_failed', $result['message'] ?? __('Unable to create order.', 'virtualskyhost'), ['status' => 422]);
            }

            return rest_ensure_response($result);
        },
        'permission_callback' => function () {
            if (current_user_can('manage_options')) {
                return true;
            }

            $headerToken = $_SERVER['HTTP_X_VIRTUALSKYHOST_TOKEN'] ?? '';
            $expected = getenv('VIRTUALSKYHOST_API_TOKEN') ?: '';

            if ($expected !== '' && hash_equals($expected, $headerToken)) {
                return true;
            }

            return wp_verify_nonce($headerToken, 'virtualskyhost_api');
        },
        'args' => [
            'clientid' => [
                'required' => false,
                'sanitize_callback' => 'absint',
            ],
        ],
    ]);
});
