<?php
declare(strict_types=1);
?>
    </main>
    <footer class="bg-slate-950/90 border-t border-white/10 py-16">
        <div class="max-w-7xl mx-auto px-6 grid gap-12 lg:grid-cols-4 text-sm text-slate-300">
            <div class="space-y-4">
                <a href="<?php echo esc_url(home_url('/')); ?>" class="flex items-center gap-3 text-white">
                    <span class="h-12 w-12 rounded-2xl bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500 flex items-center justify-center shadow-lg shadow-indigo-500/40">
                        <span class="text-xl font-bold">VS</span>
                    </span>
                    <span class="text-left">
                        <span class="block text-lg font-semibold tracking-wide">Virtual Sky</span>
                        <span class="block text-xs uppercase tracking-[0.4em] text-indigo-200/90">Your Future in the Cloud</span>
                    </span>
                </a>
                <p class="text-slate-400 leading-relaxed">
                    <?php esc_html_e('AI-powered hosting crafted for creators, agencies, and SaaS teams that demand cinematic experiences and supercharged automation.', 'virtualskywp'); ?>
                </p>
                <div class="flex flex-wrap gap-2">
                    <span class="px-3 py-1 rounded-full bg-white/5 border border-white/10 text-xs font-medium uppercase tracking-wide"><?php esc_html_e('99.99% Uptime', 'virtualskywp'); ?></span>
                    <span class="px-3 py-1 rounded-full bg-white/5 border border-white/10 text-xs font-medium uppercase tracking-wide"><?php esc_html_e('AI Support 24/7', 'virtualskywp'); ?></span>
                    <span class="px-3 py-1 rounded-full bg-white/5 border border-white/10 text-xs font-medium uppercase tracking-wide"><?php esc_html_e('Global Edge CDN', 'virtualskywp'); ?></span>
                </div>
            </div>
            <div>
                <h3 class="text-white text-base font-semibold mb-4"><?php esc_html_e('Hosting', 'virtualskywp'); ?></h3>
                <ul class="space-y-2">
                    <li><a class="hover:text-white transition" href="<?php echo esc_url(home_url('/web-hosting')); ?>"><?php esc_html_e('Shared Hosting', 'virtualskywp'); ?></a></li>
                    <li><a class="hover:text-white transition" href="<?php echo esc_url(home_url('/wordpress-hosting')); ?>"><?php esc_html_e('WordPress Hosting', 'virtualskywp'); ?></a></li>
                    <li><a class="hover:text-white transition" href="<?php echo esc_url(home_url('/reseller-hosting')); ?>"><?php esc_html_e('Reseller Hosting', 'virtualskywp'); ?></a></li>
                    <li><a class="hover:text-white transition" href="<?php echo esc_url(home_url('/vps-hosting')); ?>"><?php esc_html_e('VPS Hosting', 'virtualskywp'); ?></a></li>
                    <li><a class="hover:text-white transition" href="<?php echo esc_url(home_url('/ai-hosting')); ?>"><?php esc_html_e('AI Hosting', 'virtualskywp'); ?></a></li>
                </ul>
            </div>
            <div>
                <h3 class="text-white text-base font-semibold mb-4"><?php esc_html_e('AI Platform', 'virtualskywp'); ?></h3>
                <ul class="space-y-2">
                    <li><a class="hover:text-white transition" href="<?php echo esc_url(home_url('/ai-tools')); ?>"><?php esc_html_e('AI Tools', 'virtualskywp'); ?></a></li>
                    <li><a class="hover:text-white transition" href="<?php echo esc_url(home_url('/ai-agent-builder')); ?>"><?php esc_html_e('AI Agent Builder', 'virtualskywp'); ?></a></li>
                    <li><a class="hover:text-white transition" href="<?php echo esc_url(virtualskywp_get_option('cta_builder_url')); ?>"><?php esc_html_e('Launch Website Builder', 'virtualskywp'); ?></a></li>
                    <li><a class="hover:text-white transition" href="<?php echo esc_url(home_url('/blog')); ?>"><?php esc_html_e('Insights & Updates', 'virtualskywp'); ?></a></li>
                </ul>
            </div>
            <div class="space-y-4">
                <h3 class="text-white text-base font-semibold"><?php esc_html_e('Let’s Build Together', 'virtualskywp'); ?></h3>
                <p class="text-slate-400 leading-relaxed"><?php esc_html_e('Get started for just $1 and unlock premium NVMe hosting, AI copilots, and automated provisioning connected to WHMCS.', 'virtualskywp'); ?></p>
                <a href="<?php echo esc_url(virtualskywp_get_option('whmcs_cart_url')); ?>" class="inline-flex items-center justify-center px-6 py-3 rounded-full bg-gradient-to-r from-indigo-500 to-pink-500 text-white font-semibold shadow-lg shadow-indigo-500/40">
                    <?php esc_html_e('View Plans', 'virtualskywp'); ?>
                </a>
            </div>
        </div>
        <div class="max-w-7xl mx-auto px-6 mt-12 pt-8 border-t border-white/10 flex flex-col md:flex-row items-center justify-between gap-4 text-xs text-slate-500">
            <span>&copy; <?php echo esc_html(date_i18n('Y')); ?> Virtual Sky. <?php esc_html_e('All rights reserved.', 'virtualskywp'); ?></span>
            <?php
            wp_nav_menu([
                'theme_location' => 'footer',
                'container' => false,
                'menu_class' => 'flex flex-wrap gap-4',
                'fallback_cb' => '__return_false',
            ]);
            ?>
        </div>
    </footer>
</div>
<?php wp_footer(); ?>
</body>
</html>
