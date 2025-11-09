<?php
declare(strict_types=1);
?>
    </main>
    <footer class="vs-footer">
        <div class="vs-container">
            <div class="columns">
                <div>
                    <h3 style="margin-top:0;">VirtualSkyHost</h3>
                    <p>Cloud-first hosting engineered for creators, agencies, and enterprises who demand low-latency performance.</p>
                    <div class="vs-pill-list">
                        <span class="vs-badge">99.99% uptime SLA</span>
                        <span class="vs-badge">Global Anycast DNS</span>
                        <span class="vs-badge">24/7 support</span>
                    </div>
                </div>
                <div>
                    <h4><?php esc_html_e('Hosting', 'virtualskyhost'); ?></h4>
                    <ul>
                        <li><a href="<?php echo esc_url(home_url('/shared-hosting')); ?>"><?php esc_html_e('Shared Hosting', 'virtualskyhost'); ?></a></li>
                        <li><a href="<?php echo esc_url(home_url('/wordpress-hosting')); ?>"><?php esc_html_e('WordPress Hosting', 'virtualskyhost'); ?></a></li>
                        <li><a href="<?php echo esc_url(home_url('/vps-hosting')); ?>"><?php esc_html_e('VPS Hosting', 'virtualskyhost'); ?></a></li>
                        <li><a href="<?php echo esc_url(home_url('/dedicated-hosting')); ?>"><?php esc_html_e('Dedicated Hosting', 'virtualskyhost'); ?></a></li>
                    </ul>
                </div>
                <div>
                    <h4><?php esc_html_e('Company', 'virtualskyhost'); ?></h4>
                    <ul>
                        <li><a href="<?php echo esc_url(home_url('/about')); ?>"><?php esc_html_e('About', 'virtualskyhost'); ?></a></li>
                        <li><a href="<?php echo esc_url(home_url('/support')); ?>"><?php esc_html_e('Support', 'virtualskyhost'); ?></a></li>
                        <li><a href="<?php echo esc_url(home_url('/contact')); ?>"><?php esc_html_e('Contact', 'virtualskyhost'); ?></a></li>
                        <li><a href="https://status.virtualskyhost.com">Status</a></li>
                    </ul>
                </div>
                <div>
                    <h4><?php esc_html_e('Get Started', 'virtualskyhost'); ?></h4>
                    <p><?php esc_html_e('Launch your first site in minutes with automated Plesk provisioning and one-click WordPress installs.', 'virtualskyhost'); ?></p>
                    <a class="vs-button" href="<?php echo esc_url(virtualskyhost_get_order_base_url()); ?>&step=1">
                        <?php esc_html_e('View Plans', 'virtualskyhost'); ?>
                    </a>
                </div>
            </div>
            <div style="margin-top:3rem; display:flex; flex-wrap:wrap; gap:1rem; align-items:center; justify-content:space-between;">
                <span>&copy; <?php echo esc_html(date_i18n('Y')); ?> VirtualSkyHost. <?php esc_html_e('All rights reserved.', 'virtualskyhost'); ?></span>
                <?php
                wp_nav_menu([
                    'theme_location' => 'footer',
                    'container' => false,
                    'menu_class' => 'vs-pill-list',
                    'fallback_cb' => '__return_false',
                ]);
                ?>
            </div>
        </div>
    </footer>
</div>
<?php wp_footer(); ?>
</body>
</html>
