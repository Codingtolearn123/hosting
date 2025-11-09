<?php
declare(strict_types=1);

if (!defined('ABSPATH')) {
    exit;
}

function virtualskyhost_bridge_order_base_url(): string
{
    if (function_exists('virtualskyhost_get_option')) {
        $option = virtualskyhost_get_option('order_base_url');
        if (!empty($option)) {
            return $option;
        }
    }

    return getenv('WHMCS_ORDER_BASE_URL') ?: 'https://billing.virtualskyhost.com/cart.php';
}

add_shortcode('virtualskyhost_domain_search', function (array $atts = []): string {
    $atts = shortcode_atts([
        'label' => __('Search for a domain', 'virtualskyhost'),
    ], $atts);

    ob_start();
    ?>
    <div class="vs-domain-search" data-domain-search>
        <input type="search" name="domain" placeholder="virtualskyhost.com" aria-label="<?php echo esc_attr($atts['label']); ?>" />
        <button class="vs-button" data-domain-submit><?php esc_html_e('Check Availability', 'virtualskyhost'); ?></button>
    </div>
    <?php
    return (string) ob_get_clean();
});

add_shortcode('virtualskyhost_pricing', function (array $atts = []): string {
    $atts = shortcode_atts([
        'category' => 'shared',
    ], $atts);

    $plans = virtualskyhost_whmcs_get_pricing($atts['category']);

    if (empty($plans)) {
        return '<p>' . esc_html__('No plans available right now.', 'virtualskyhost') . '</p>';
    }

    ob_start();
    ?>
    <div class="vs-pricing" data-pricing-grid data-category="<?php echo esc_attr($atts['category']); ?>">
        <?php foreach ($plans as $plan) : ?>
            <article class="vs-card">
                <h3 style="margin:0; font-size:1.35rem;">
                    <?php echo esc_html($plan['name'] ?? 'Plan'); ?>
                </h3>
                <div class="price"><?php echo esc_html($plan['price'] ?? '$0.00'); ?> <span>/mo</span></div>
                <p><?php echo esc_html($plan['description'] ?? ''); ?></p>
                <?php if (!empty($plan['features'])) : ?>
                    <ul style="list-style:none; padding:0; display:grid; gap:0.6rem;">
                        <?php foreach ((array) $plan['features'] as $feature) : ?>
                            <li><?php echo esc_html($feature); ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
                <a class="vs-button" href="<?php echo esc_url(virtualskyhost_bridge_order_base_url()); ?>&a=add&pid=<?php echo esc_attr($plan['product_id'] ?? ''); ?>">
                    <?php esc_html_e('Buy Now', 'virtualskyhost'); ?>
                </a>
            </article>
        <?php endforeach; ?>
    </div>
    <?php
    return (string) ob_get_clean();
});
