<?php
declare(strict_types=1);

get_header();
?>
<section class="vs-container">
    <div class="section-gradient" style="text-align:center; display:grid; gap:2rem;">
        <span class="vs-badge">VirtualSkyHost Global Cloud</span>
        <h1 style="margin:0; font-size: clamp(2.5rem, 6vw, 4.5rem);">Launch lightning-fast websites backed by AI-driven automation.</h1>
        <p style="margin:0 auto; max-width:640px; color: var(--vs-text-muted); font-size:1.1rem;">
            Deploy shared, managed WordPress, VPS, and dedicated hosting in seconds with seamless WHMCS billing and automated Plesk provisioning.
        </p>
        <div class="vs-domain-search" data-domain-search>
            <input type="search" name="domain" placeholder="Search domain e.g. virtualskyhost.com" aria-label="<?php esc_attr_e('Search domain name', 'virtualskyhost'); ?>" />
            <button class="vs-button" data-domain-submit>
                <?php esc_html_e('Check Availability', 'virtualskyhost'); ?>
            </button>
        </div>
        <ul class="vs-pill-list" style="justify-content:center;">
            <li>.com $9.99</li>
            <li>.cloud $3.99</li>
            <li>.ai $69.99</li>
            <li>Free migration</li>
        </ul>
        <div style="display:flex; flex-wrap:wrap; gap:1rem; justify-content:center;">
            <a class="vs-button" href="<?php echo esc_url(virtualskyhost_get_order_base_url()); ?>&a=add&pid=1">Get Started</a>
            <a class="vs-button" style="background:rgba(255,255,255,0.1); box-shadow:none;" href="#pricing">View Pricing</a>
        </div>
    </div>
</section>

<section id="pricing" class="vs-container">
    <div class="section-gradient">
        <div style="display:flex; flex-direction:column; gap:1.5rem;">
            <header style="display:grid; gap:0.75rem;">
                <span class="vs-badge">Pricing synced with WHMCS</span>
                <h2 style="margin:0; font-size: clamp(2rem, 4vw, 3rem);">Choose the right VirtualSkyHost plan</h2>
                <p style="margin:0; color: var(--vs-text-muted);">All plans include NVMe storage, global CDN, managed security, and 24/7 AI-assisted support.</p>
            </header>
            <?php $shared_pricing = virtualskyhost_fetch_pricing('shared'); ?>
            <div class="vs-pricing" data-pricing-grid data-category="shared">
                <?php if (empty($shared_pricing)) : ?>
                    <article class="vs-card">
                        <h3 style="margin:0; font-size:1.4rem;">Starter Cloud</h3>
                        <div class="price">$2.99 <span>/mo</span></div>
                        <p><?php esc_html_e('Ideal for portfolios, blogs, and early startups.', 'virtualskyhost'); ?></p>
                        <ul style="list-style:none; padding:0; display:grid; gap:0.6rem;">
                            <li>1 website</li>
                            <li>50 GB NVMe storage</li>
                            <li>Free SSL &amp; CDN</li>
                        </ul>
                        <a class="vs-button" href="<?php echo esc_url(virtualskyhost_get_order_base_url()); ?>&a=add&pid=1">
                            <?php esc_html_e('Buy Now', 'virtualskyhost'); ?>
                        </a>
                    </article>
                <?php endif; ?>
                <?php foreach ($shared_pricing as $plan) : ?>
                    <article class="vs-card" data-plan="<?php echo esc_attr($plan['id'] ?? ''); ?>">
                        <h3 style="margin:0; font-size:1.4rem;"><?php echo esc_html($plan['name'] ?? 'Shared Plan'); ?></h3>
                        <div class="price"><?php echo esc_html($plan['price'] ?? '$2.99'); ?> <span>/mo</span></div>
                        <p><?php echo esc_html($plan['description'] ?? 'Perfect for personal projects and new ideas.'); ?></p>
                        <ul style="list-style:none; padding:0; display:grid; gap:0.6rem;">
                            <?php if (!empty($plan['features']) && is_array($plan['features'])) : ?>
                                <?php foreach ($plan['features'] as $feature) : ?>
                                    <li><?php echo esc_html($feature); ?></li>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <li>1 website</li>
                                <li>50 GB NVMe storage</li>
                                <li>Free SSL &amp; CDN</li>
                            <?php endif; ?>
                        </ul>
                        <a class="vs-button" href="<?php echo esc_url(virtualskyhost_get_order_base_url()); ?>&a=add&pid=<?php echo esc_attr($plan['product_id'] ?? '1'); ?>">
                            <?php esc_html_e('Buy Now', 'virtualskyhost'); ?>
                        </a>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>

<section class="vs-container">
    <div class="vs-grid two">
        <div class="section-gradient" style="gap:1.25rem; display:grid;">
            <span class="vs-badge">Automated onboarding</span>
            <h2 style="margin:0;">n8n workflows &amp; AI copilots</h2>
            <p style="color: var(--vs-text-muted);">Trigger n8n automation for welcome emails, SSL provisioning, DNS updates, and CRM enrollment the moment a WHMCS order is marked paid.</p>
            <ul style="list-style:none; padding:0; display:grid; gap:0.6rem;">
                <li>AI onboarding assistant (Claude / OpenAI)</li>
                <li>Marketing automation sync with HubSpot &amp; Meta Ads</li>
                <li>Post-purchase Plesk provisioning with auto SSL</li>
            </ul>
        </div>
        <div class="section-gradient" style="gap:1.25rem; display:grid;">
            <span class="vs-badge">Control planes</span>
            <h2 style="margin:0;">Managed Plesk &amp; cPanel integration</h2>
            <p style="color: var(--vs-text-muted);">Provision WordPress, mailboxes, and databases instantly via secure API calls. VirtualSkyHost ensures compliance across Ubuntu 22.04 fleets.</p>
            <ul style="list-style:none; padding:0; display:grid; gap:0.6rem;">
                <li>Single-sign-on from WHMCS client area</li>
                <li>Automated DNS templates per region</li>
                <li>One-click WordPress Toolkit activation</li>
            </ul>
        </div>
    </div>
</section>

<section class="vs-container">
    <div class="section-gradient" style="display:grid; gap:1.5rem;">
        <span class="vs-badge">Trusted worldwide</span>
        <h2 style="margin:0;">Global data centers and CDN POPs</h2>
        <div class="vs-grid three">
            <div class="vs-card">
                <h3>North America</h3>
                <p>Chicago, Ashburn, Los Angeles, Toronto</p>
            </div>
            <div class="vs-card">
                <h3>Europe</h3>
                <p>London, Frankfurt, Amsterdam, Paris, Warsaw</p>
            </div>
            <div class="vs-card">
                <h3>Asia Pacific</h3>
                <p>Singapore, Tokyo, Sydney, Mumbai</p>
            </div>
        </div>
    </div>
</section>

<section class="vs-container">
    <div class="section-gradient" style="display:grid; gap:1.5rem;">
        <span class="vs-badge">What customers say</span>
        <h2 style="margin:0;">Loved by agencies, SaaS, and creators</h2>
        <div class="vs-grid three">
            <blockquote class="vs-card">
                <p>“VirtualSkyHost migrated 87 WordPress sites from our legacy provider with zero downtime. Billing and automation are finally in sync.”</p>
                <cite>&mdash; Ava Martinez, Creative Director</cite>
            </blockquote>
            <blockquote class="vs-card">
                <p>“The n8n workflows fire off everything we need: onboarding, DNS, CRM, and welcome journeys. Our ops team sleeps better.”</p>
                <cite>&mdash; Liam Chen, CTO, GrowthForge</cite>
            </blockquote>
            <blockquote class="vs-card">
                <p>“Pricing updates from WHMCS flow straight to WordPress. We change a product in billing and the site updates instantly.”</p>
                <cite>&mdash; Priya Patel, Product Manager</cite>
            </blockquote>
        </div>
    </div>
</section>

<section class="vs-container">
    <div class="vs-cta-banner">
        <span class="vs-badge">Migration concierge</span>
        <h2 style="margin:0;">Move to VirtualSkyHost with free white-glove onboarding</h2>
        <p style="margin:0; color: var(--vs-text-muted);">Let our experts migrate your cPanel, Plesk, or custom stack. We coordinate domain transfer, staging, and go-live.</p>
        <div style="display:flex; gap:1rem; flex-wrap:wrap;">
            <a class="vs-button" href="<?php echo esc_url(virtualskyhost_get_order_base_url()); ?>&a=add&pid=12">Start Migration</a>
            <a class="vs-button" style="background:rgba(255,255,255,0.1); box-shadow:none;" href="mailto:hello@virtualskyhost.com">Talk to sales</a>
        </div>
    </div>
</section>

<section class="vs-container">
    <div class="section-gradient" style="display:grid; gap:1.5rem;">
        <span class="vs-badge">FAQ</span>
        <h2 style="margin:0;">Answers to common questions</h2>
        <div class="vs-grid two">
            <article class="vs-card">
                <h3>How does the WordPress site sync with WHMCS pricing?</h3>
                <p>Our WordPress theme calls the VirtualSkyHost WHMCS Bridge plugin (or backend API) to fetch live plan pricing, ensuring marketing pages match checkout totals.</p>
            </article>
            <article class="vs-card">
                <h3>Can I automate onboarding tasks?</h3>
                <p>Yes. We ship n8n workflow examples to handle welcome emails, DNS provisioning, SSL, CRM enrollment, and AI-powered customer outreach.</p>
            </article>
            <article class="vs-card">
                <h3>Which control panels do you support?</h3>
                <p>VirtualSkyHost integrates with both Plesk and cPanel through secure API calls orchestrated via our Node.js backend microservice.</p>
            </article>
            <article class="vs-card">
                <h3>Where do the “Buy Now” buttons link?</h3>
                <p>Each button redirects to WHMCS order URLs like <code>billing.virtualskyhost.com/cart.php?a=add&pid=ID</code> so customers can complete checkout instantly.</p>
            </article>
        </div>
    </div>
</section>

<?php get_footer(); ?>
