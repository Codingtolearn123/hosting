<?php
declare(strict_types=1);

if (!isset($category)) {
    $category = 'shared';
}

$plans = virtualskywp_get_hosting_plans($category);
$options = virtualskywp_get_theme_options();
$one_dollar_enabled = !empty($options['enable_one_dollar_promo']);
$whmcs_cart = $options['whmcs_cart_url'] ?? '#';
?>
<section class="py-20 bg-slate-950">
    <div class="max-w-6xl mx-auto px-6 space-y-8 text-center">
        <span class="px-4 py-1 rounded-full bg-white/5 border border-white/10 text-xs uppercase tracking-[0.3em] text-indigo-200/90"><?php echo esc_html(ucwords(str_replace('-', ' ', $category))); ?> <?php esc_html_e('Hosting', 'virtualskywp'); ?></span>
        <h1 class="text-4xl lg:text-5xl font-semibold text-white"><?php the_title(); ?></h1>
        <p class="text-slate-300 max-w-2xl mx-auto"><?php echo apply_filters('the_content', get_the_content() ?: __('Choose a Virtual Sky plan synchronized with WHMCS and optimized for AI workloads.', 'virtualskywp')); ?></p>
    </div>
</section>

<section class="py-20 bg-gradient-to-b from-slate-950 via-slate-900 to-slate-950">
    <div class="max-w-6xl mx-auto px-6 space-y-12">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
            <div class="space-y-2">
                <h2 class="text-3xl font-semibold text-white"><?php esc_html_e('Select a plan', 'virtualskywp'); ?></h2>
                <p class="text-slate-300"><?php esc_html_e('All buttons redirect to WHMCS checkout for a consistent billing flow.', 'virtualskywp'); ?></p>
            </div>
            <a href="<?php echo esc_url($whmcs_cart); ?>" class="px-6 py-3 rounded-full bg-gradient-to-r from-indigo-500 to-pink-500 text-white font-semibold shadow-lg shadow-indigo-500/40">
                <?php esc_html_e('Open WHMCS Cart', 'virtualskywp'); ?>
            </a>
        </div>
        <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
            <?php foreach ($plans as $plan) : ?>
                <article class="relative p-8 rounded-3xl border border-white/10 bg-slate-950/70 backdrop-blur-xl flex flex-col gap-6 <?php echo $plan['highlighted'] ? 'ring-2 ring-pink-400/70' : ''; ?>">
                    <?php if ($plan['highlighted']) : ?>
                        <span class="absolute -top-3 left-1/2 -translate-x-1/2 px-3 py-1 rounded-full bg-gradient-to-r from-indigo-500 to-pink-500 text-xs font-semibold uppercase tracking-widest text-white">
                            <?php echo esc_html($plan['badge_text'] ?: __('Best Value', 'virtualskywp')); ?>
                        </span>
                    <?php endif; ?>
                    <div class="space-y-2">
                        <h3 class="text-2xl font-semibold text-white"><?php echo esc_html($plan['title']); ?></h3>
                        <p class="text-sm text-slate-300"><?php echo wp_kses_post($plan['content']); ?></p>
                    </div>
                    <div class="space-y-2">
                        <?php if (!empty($plan['promo_price']) && $one_dollar_enabled) : ?>
                            <div class="text-3xl font-bold text-white"><?php echo esc_html($plan['promo_price']); ?><span class="text-base text-slate-400 font-medium"> <?php esc_html_e('first month', 'virtualskywp'); ?></span></div>
                        <?php endif; ?>
                        <?php if (!empty($plan['price_monthly'])) : ?>
                            <div class="text-sm text-slate-400"><?php printf(esc_html__('Then %s/mo or %s/yr', 'virtualskywp'), esc_html($plan['price_monthly']), esc_html($plan['price_yearly'] ?: __('custom', 'virtualskywp'))); ?></div>
                        <?php endif; ?>
                    </div>
                    <ul class="space-y-2 text-sm text-slate-200">
                        <?php foreach ($plan['features'] as $feature) : ?>
                            <li class="flex items-start gap-2"><span class="mt-1 h-2 w-2 rounded-full bg-gradient-to-r from-indigo-500 to-pink-500"></span><span><?php echo esc_html($feature); ?></span></li>
                        <?php endforeach; ?>
                        <?php if ($plan['free_domain']) : ?>
                            <li class="flex items-start gap-2 text-indigo-200"><span class="mt-1 h-2 w-2 rounded-full bg-gradient-to-r from-indigo-500 to-pink-500"></span><span><?php esc_html_e('Free domain with annual billing', 'virtualskywp'); ?></span></li>
                        <?php endif; ?>
                        <?php if ($plan['ai_ready']) : ?>
                            <li class="flex items-start gap-2 text-pink-200"><span class="mt-1 h-2 w-2 rounded-full bg-gradient-to-r from-indigo-500 to-pink-500"></span><span><?php esc_html_e('AI-ready stack with GPU integration', 'virtualskywp'); ?></span></li>
                        <?php endif; ?>
                    </ul>
                    <?php if (!empty($plan['whmcs_link'])) : ?>
                        <a href="<?php echo esc_url($plan['whmcs_link']); ?>" class="mt-auto inline-flex items-center justify-center px-6 py-3 rounded-full bg-gradient-to-r from-indigo-500 to-pink-500 text-white font-semibold shadow">
                            <?php esc_html_e('Buy via WHMCS', 'virtualskywp'); ?>
                        </a>
                    <?php endif; ?>
                    <?php if (!empty($plan['n8n_webhook'])) : ?>
                        <p class="text-[11px] text-slate-500 italic"><?php esc_html_e('Triggers n8n webhook for automation after purchase.', 'virtualskywp'); ?></p>
                    <?php endif; ?>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="py-20 bg-slate-950">
    <div class="max-w-5xl mx-auto px-6 grid gap-8 md:grid-cols-2">
        <div class="p-8 rounded-3xl border border-white/10 bg-white/5 backdrop-blur-xl space-y-4">
            <h3 class="text-2xl font-semibold text-white"><?php esc_html_e('Included Services', 'virtualskywp'); ?></h3>
            <ul class="space-y-3 text-slate-200 text-sm">
                <li class="flex items-start gap-2"><span class="mt-1 h-2 w-2 rounded-full bg-indigo-400"></span><span><?php esc_html_e('Automated provisioning through WHMCS & Plesk/cPanel APIs.', 'virtualskywp'); ?></span></li>
                <li class="flex items-start gap-2"><span class="mt-1 h-2 w-2 rounded-full bg-indigo-400"></span><span><?php esc_html_e('Real-time malware scanning and daily backups.', 'virtualskywp'); ?></span></li>
                <li class="flex items-start gap-2"><span class="mt-1 h-2 w-2 rounded-full bg-indigo-400"></span><span><?php esc_html_e('n8n workflow templates for onboarding and upsells.', 'virtualskywp'); ?></span></li>
                <li class="flex items-start gap-2"><span class="mt-1 h-2 w-2 rounded-full bg-indigo-400"></span><span><?php esc_html_e('AI concierge support with migration specialists.', 'virtualskywp'); ?></span></li>
            </ul>
        </div>
        <div class="p-8 rounded-3xl border border-white/10 bg-white/5 backdrop-blur-xl space-y-4">
            <h3 class="text-2xl font-semibold text-white"><?php esc_html_e('Need enterprise scale?', 'virtualskywp'); ?></h3>
            <p class="text-slate-300 text-sm leading-relaxed"><?php esc_html_e('Work with our solution architects to design private clusters, custom AI stacks, and bespoke automations wired into WHMCS.', 'virtualskywp'); ?></p>
            <a href="mailto:hello@virtualsky.io" class="inline-flex items-center gap-2 px-6 py-3 rounded-full border border-white/20 text-white font-semibold">
                <?php esc_html_e('Talk to sales', 'virtualskywp'); ?>
            </a>
        </div>
    </div>
</section>
