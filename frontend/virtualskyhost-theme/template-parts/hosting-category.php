<?php
declare(strict_types=1);

if (!isset($category)) {
    $category = 'shared';
}
?>
<section class="vs-container">
    <div class="section-gradient" style="display:grid; gap:1.5rem;">
        <span class="vs-badge"><?php echo esc_html(virtualskyhost_format_category($category)); ?> Plans</span>
        <h1 style="margin:0; font-size: clamp(2.4rem, 5vw, 3.5rem);"><?php the_title(); ?></h1>
        <p style="margin:0; max-width:720px; color: var(--vs-text-muted);">
            <?php echo wp_kses_post(get_post_meta(get_the_ID(), 'virtualskyhost_intro', true) ?: __('Explore fully managed hosting backed by VirtualSkyHost infrastructure, synchronized with WHMCS and provisioned through Plesk automations.', 'virtualskyhost')); ?>
        </p>
        <div class="vs-domain-search" data-domain-search>
            <input type="search" name="domain" placeholder="Search domain e.g. launch.virtualskyhost.com" aria-label="<?php esc_attr_e('Search domain', 'virtualskyhost'); ?>" />
            <button class="vs-button" data-domain-submit><?php esc_html_e('Check Domain', 'virtualskyhost'); ?></button>
        </div>
    </div>
</section>

<section class="vs-container">
    <div class="section-gradient" style="display:grid; gap:1.5rem;">
        <h2 style="margin:0;">Select a plan</h2>
        <?php $category_pricing = virtualskyhost_fetch_pricing($category); ?>
        <div class="vs-pricing" data-pricing-grid data-category="<?php echo esc_attr($category); ?>">
            <?php if (empty($category_pricing)) : ?>
                <article class="vs-card">
                    <h3 style="margin:0; font-size:1.35rem;"><?php esc_html_e('Plan coming soon', 'virtualskyhost'); ?></h3>
                    <p><?php esc_html_e('Pricing will sync automatically once WHMCS products are published.', 'virtualskyhost'); ?></p>
                    <a class="vs-button" href="<?php echo esc_url(virtualskyhost_get_order_base_url()); ?>">
                        <?php esc_html_e('View all plans', 'virtualskyhost'); ?>
                    </a>
                </article>
            <?php endif; ?>
            <?php foreach ($category_pricing as $plan) : ?>
                <article class="vs-card" data-plan="<?php echo esc_attr($plan['id'] ?? ''); ?>">
                    <h3 style="margin:0; font-size:1.35rem;">
                        <?php echo esc_html($plan['name'] ?? 'Plan'); ?>
                    </h3>
                    <div class="price"><?php echo esc_html($plan['price'] ?? '$0.00'); ?> <span>/mo</span></div>
                    <p><?php echo esc_html($plan['description'] ?? __('Optimized for performance and scalability.', 'virtualskyhost')); ?></p>
                    <ul style="list-style:none; padding:0; display:grid; gap:0.6rem;">
                        <?php if (!empty($plan['features']) && is_array($plan['features'])) : ?>
                            <?php foreach ($plan['features'] as $feature) : ?>
                                <li><?php echo esc_html($feature); ?></li>
                            <?php endforeach; ?>
                        <?php else : ?>
                                <li><?php esc_html_e('Managed WordPress toolkit', 'virtualskyhost'); ?></li>
                                <li><?php esc_html_e('Daily backups & malware scanning', 'virtualskyhost'); ?></li>
                                <li><?php esc_html_e('Global CDN edge caching', 'virtualskyhost'); ?></li>
                        <?php endif; ?>
                    </ul>
                    <a class="vs-button" href="<?php echo esc_url(virtualskyhost_get_order_base_url()); ?>&a=add&pid=<?php echo esc_attr($plan['product_id'] ?? ''); ?>">
                        <?php esc_html_e('Buy Now', 'virtualskyhost'); ?>
                    </a>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="vs-container">
    <div class="vs-grid two">
        <div class="section-gradient" style="display:grid; gap:1rem;">
            <h2 style="margin:0;">Included services</h2>
            <ul style="list-style:none; padding:0; display:grid; gap:0.6rem;">
                <li>Automated provisioning via Plesk API</li>
                <li>Instant SSL deployment using Let’s Encrypt</li>
                <li>Anycast DNS templates per region</li>
                <li>n8n-powered onboarding workflows</li>
            </ul>
        </div>
        <div class="section-gradient" style="display:grid; gap:1rem;">
            <h2 style="margin:0;">Need enterprise scale?</h2>
            <p style="margin:0; color: var(--vs-text-muted);">Contact our solution architects for fully isolated clusters, private cloud builds, and custom automation requirements.</p>
            <a class="vs-button" href="mailto:hello@virtualskyhost.com">Talk to sales</a>
        </div>
    </div>
</section>
