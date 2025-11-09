<?php
declare(strict_types=1);

$options = virtualskywp_get_theme_options();
$hero_video = $options['hero_video_url'] ?? '';
$hero_headline = $options['hero_headline'] ?? __('Get Web Hosting Starting at $1', 'virtualskywp');
$hero_subheadline = $options['hero_subheadline'] ?? __('Fast, Secure & AI-Powered Hosting for Modern Creators', 'virtualskywp');
$cta_cart = $options['whmcs_cart_url'] ?? '#';
$cta_view_plans = $options['cta_view_plans_anchor'] ?? '#pricing';
$cta_login = $options['whmcs_login_url'] ?? '#';
$cta_builder = $options['cta_builder_url'] ?? '#';
$one_dollar_enabled = !empty($options['enable_one_dollar_promo']);

$shared_plans = virtualskywp_get_hosting_plans('shared');
$wp_plans = virtualskywp_get_hosting_plans('wordpress');
$reseller_plans = virtualskywp_get_hosting_plans('reseller');
$vps_plans = virtualskywp_get_hosting_plans('vps');
$ai_plans = virtualskywp_get_hosting_plans('ai');

$ai_tools = virtualskywp_get_ai_tools();
$testimonials = virtualskywp_get_testimonials();
$faqs = virtualskywp_get_faqs();
$hero_slides = virtualskywp_get_hero_slides();

get_header();
?>
<section class="relative overflow-hidden">
    <?php if ($hero_video) : ?>
        <video class="absolute inset-0 h-full w-full object-cover" autoplay muted loop playsinline>
            <source src="<?php echo esc_url($hero_video); ?>" type="video/mp4" />
        </video>
    <?php endif; ?>
    <div class="absolute inset-0 bg-gradient-to-b from-slate-950/80 via-slate-950/70 to-slate-950"></div>
    <div class="relative max-w-7xl mx-auto px-6 py-32 lg:py-44 grid lg:grid-cols-[1.2fr,0.8fr] gap-16 items-center">
        <div class="space-y-8 text-white">
            <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full border border-white/10 bg-white/5 backdrop-blur text-xs uppercase tracking-[0.3em]">
                <?php esc_html_e('Hosting starts at just $1', 'virtualskywp'); ?>
            </span>
            <h1 class="text-4xl lg:text-6xl font-semibold leading-tight">
                <?php echo esc_html($hero_headline); ?>
            </h1>
            <p class="text-lg text-slate-200 max-w-2xl">
                <?php echo esc_html($hero_subheadline); ?>
            </p>
            <div class="flex flex-wrap gap-4">
                <a href="<?php echo esc_url($cta_cart); ?>" class="px-8 py-3 rounded-full bg-gradient-to-r from-indigo-500 to-pink-500 text-white font-semibold shadow-lg shadow-indigo-500/40">
                    <?php esc_html_e('Get Started', 'virtualskywp'); ?>
                </a>
                <a href="<?php echo esc_url($cta_view_plans); ?>" class="px-8 py-3 rounded-full border border-white/20 bg-white/5 text-white font-semibold">
                    <?php esc_html_e('View Plans', 'virtualskywp'); ?>
                </a>
                <?php if (!empty($cta_login)) : ?>
                    <a href="<?php echo esc_url($cta_login); ?>" class="px-8 py-3 rounded-full border border-white/20 bg-white/5 text-white font-semibold">
                        <?php esc_html_e('Client Login', 'virtualskywp'); ?>
                    </a>
                <?php endif; ?>
            </div>
            <div class="flex items-center gap-6 text-slate-300">
                <div class="flex -space-x-4">
                    <?php foreach (array_slice($hero_slides, 0, 3) as $slide) : ?>
                        <span class="h-12 w-12 rounded-full border-2 border-white/20 overflow-hidden">
                            <?php if (!empty($slide['image'])) : ?>
                                <img src="<?php echo esc_url($slide['image']); ?>" alt="<?php echo esc_attr($slide['title']); ?>" class="h-full w-full object-cover" />
                            <?php endif; ?>
                        </span>
                    <?php endforeach; ?>
                </div>
                <p class="text-sm uppercase tracking-[0.3em] text-slate-400"><?php esc_html_e('Join creators building with AI', 'virtualskywp'); ?></p>
            </div>
        </div>
        <div class="rounded-3xl border border-white/10 bg-white/5 backdrop-blur-xl p-8 shadow-2xl shadow-indigo-500/30 space-y-6" data-floating-card>
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold text-white"><?php esc_html_e('Quick Launch Plans', 'virtualskywp'); ?></h2>
                <?php if ($one_dollar_enabled) : ?>
                    <span class="px-3 py-1 rounded-full bg-gradient-to-r from-indigo-500 to-pink-500 text-xs font-semibold uppercase tracking-widest">
                        <?php esc_html_e('$1 First Month', 'virtualskywp'); ?>
                    </span>
                <?php endif; ?>
            </div>
            <ul class="space-y-4">
                <?php if (empty($shared_plans)) : ?>
                    <li class="p-4 rounded-2xl bg-slate-950/60 border border-white/10 text-sm text-slate-300">
                        <?php esc_html_e('Add shared hosting plans in the dashboard to populate this section.', 'virtualskywp'); ?>
                    </li>
                <?php endif; ?>
                <?php foreach (array_slice($shared_plans, 0, 3) as $plan) : ?>
                    <li class="p-4 rounded-2xl bg-slate-950/60 border border-white/10 hover:border-indigo-400/60 transition">
                        <div class="flex items-center justify-between gap-3">
                            <div>
                                <h3 class="text-lg font-semibold text-white"><?php echo esc_html($plan['title']); ?></h3>
                                <p class="text-xs uppercase tracking-[0.3em] text-slate-400"><?php esc_html_e('Shared Hosting', 'virtualskywp'); ?></p>
                            </div>
                            <div class="text-right">
                                <?php if (!empty($plan['promo_price']) && $one_dollar_enabled) : ?>
                                    <span class="text-2xl font-bold text-white"><?php echo esc_html($plan['promo_price']); ?></span>
                                    <span class="text-xs text-slate-400 block"><?php esc_html_e('First month', 'virtualskywp'); ?></span>
                                <?php endif; ?>
                                <?php if (!empty($plan['price_monthly'])) : ?>
                                    <span class="text-xs text-slate-400 block"><?php printf(esc_html__('Then %s/mo', 'virtualskywp'), esc_html($plan['price_monthly'])); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="mt-3 flex flex-wrap items-center gap-2 text-xs text-slate-300">
                            <?php foreach (array_slice($plan['features'], 0, 3) as $feature) : ?>
                                <span class="px-3 py-1 rounded-full bg-white/5 border border-white/10"><?php echo esc_html($feature); ?></span>
                            <?php endforeach; ?>
                        </div>
                        <?php if (!empty($plan['whmcs_link'])) : ?>
                            <a href="<?php echo esc_url($plan['whmcs_link']); ?>" class="mt-4 inline-flex items-center gap-2 text-sm font-semibold text-indigo-300">
                                <?php esc_html_e('Order via WHMCS', 'virtualskywp'); ?>
                                <span class="dashicons dashicons-arrow-right-alt"></span>
                            </a>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</section>

<section id="pricing" class="py-24 bg-slate-950">
    <div class="max-w-7xl mx-auto px-6 space-y-16">
        <div class="text-center space-y-4">
            <span class="px-4 py-1 rounded-full bg-white/5 border border-white/10 text-xs uppercase tracking-[0.3em] text-indigo-200/90"><?php esc_html_e('Plans & Pricing', 'virtualskywp'); ?></span>
            <h2 class="text-4xl font-semibold text-white"><?php esc_html_e('Hosting built for speed, security, and AI workloads', 'virtualskywp'); ?></h2>
            <p class="text-slate-300 max-w-2xl mx-auto"><?php esc_html_e('Every Virtual Sky plan includes NVMe storage, global CDN, AI support, and automated WHMCS provisioning.', 'virtualskywp'); ?></p>
        </div>
        <div class="relative" data-pricing-switcher>
            <div class="flex items-center justify-center gap-4">
                <button class="px-4 py-2 rounded-full bg-gradient-to-r from-indigo-500 to-pink-500 text-white font-medium shadow" data-billing-toggle value="monthly"><?php esc_html_e('Monthly', 'virtualskywp'); ?></button>
                <button class="px-4 py-2 rounded-full border border-white/10 text-slate-200" data-billing-toggle value="yearly"><?php esc_html_e('Yearly', 'virtualskywp'); ?></button>
            </div>
        </div>
        <div class="grid gap-8 lg:grid-cols-4" data-plan-grid>
            <?php if (empty($shared_plans)) : ?>
                <article class="p-8 rounded-3xl border border-dashed border-white/20 text-center text-slate-400">
                    <?php esc_html_e('Create hosting plans to showcase pricing here.', 'virtualskywp'); ?>
                </article>
            <?php endif; ?>
            <?php foreach ($shared_plans as $plan) : ?>
                <article class="relative p-8 rounded-3xl border border-white/10 bg-slate-950/70 backdrop-blur-xl shadow-xl shadow-slate-900/40 flex flex-col gap-6 <?php echo $plan['highlighted'] ? 'ring-2 ring-pink-400/70' : ''; ?>">
                    <?php if ($plan['highlighted']) : ?>
                        <span class="absolute -top-3 left-1/2 -translate-x-1/2 px-3 py-1 rounded-full bg-gradient-to-r from-indigo-500 to-pink-500 text-xs font-semibold uppercase tracking-widest text-white">
                            <?php echo esc_html($plan['badge_text'] ?: __('Best Value', 'virtualskywp')); ?>
                        </span>
                    <?php endif; ?>
                    <div class="space-y-3">
                        <h3 class="text-2xl font-semibold text-white"><?php echo esc_html($plan['title']); ?></h3>
                        <p class="text-sm text-slate-400"><?php echo wp_kses_post($plan['excerpt']); ?></p>
                    </div>
                    <div class="space-y-2">
                        <?php if (!empty($plan['promo_price']) && $one_dollar_enabled) : ?>
                            <div class="text-3xl font-bold text-white"><?php echo esc_html($plan['promo_price']); ?><span class="text-base text-slate-400 font-medium"> <?php esc_html_e('first month', 'virtualskywp'); ?></span></div>
                        <?php endif; ?>
                        <?php if (!empty($plan['price_monthly'])) : ?>
                            <div class="text-sm text-slate-400"><?php printf(esc_html__('Then %s/mo or %s/yr', 'virtualskywp'), esc_html($plan['price_monthly']), esc_html($plan['price_yearly'] ?: __('custom', 'virtualskywp'))); ?></div>
                        <?php endif; ?>
                    </div>
                    <ul class="space-y-2 text-sm text-slate-300">
                        <?php foreach (array_slice($plan['features'], 0, 6) as $feature) : ?>
                            <li class="flex items-start gap-2"><span class="mt-1 h-2 w-2 rounded-full bg-gradient-to-r from-indigo-500 to-pink-500"></span><span><?php echo esc_html($feature); ?></span></li>
                        <?php endforeach; ?>
                        <?php if ($plan['free_domain']) : ?>
                            <li class="flex items-start gap-2 text-indigo-200"><span class="mt-1 h-2 w-2 rounded-full bg-gradient-to-r from-indigo-500 to-pink-500"></span><span><?php esc_html_e('Free domain for the first year', 'virtualskywp'); ?></span></li>
                        <?php endif; ?>
                        <?php if ($plan['ai_ready']) : ?>
                            <li class="flex items-start gap-2 text-pink-200"><span class="mt-1 h-2 w-2 rounded-full bg-gradient-to-r from-indigo-500 to-pink-500"></span><span><?php esc_html_e('Optimized for AI workloads', 'virtualskywp'); ?></span></li>
                        <?php endif; ?>
                    </ul>
                    <?php if (!empty($plan['whmcs_link'])) : ?>
                        <a href="<?php echo esc_url($plan['whmcs_link']); ?>" class="mt-auto inline-flex items-center justify-center px-6 py-3 rounded-full bg-gradient-to-r from-indigo-500 to-pink-500 text-white font-semibold shadow">
                            <?php esc_html_e('Buy via WHMCS', 'virtualskywp'); ?>
                        </a>
                    <?php endif; ?>
                    <?php if (!empty($plan['n8n_webhook'])) : ?>
                        <p class="text-[11px] text-slate-500 italic"><?php esc_html_e('Automates VPS deployment with n8n on purchase.', 'virtualskywp'); ?></p>
                    <?php endif; ?>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="py-24 bg-gradient-to-b from-slate-950 via-slate-900 to-slate-950">
    <div class="max-w-7xl mx-auto px-6 grid gap-16 lg:grid-cols-2 items-center">
        <div class="space-y-6">
            <span class="px-4 py-1 rounded-full bg-white/5 border border-white/10 text-xs uppercase tracking-[0.3em] text-indigo-200/90"><?php esc_html_e('Hyper-optimized performance', 'virtualskywp'); ?></span>
            <h2 class="text-4xl font-semibold text-white"><?php esc_html_e('Speed, uptime, and AI copilots out of the box', 'virtualskywp'); ?></h2>
            <p class="text-slate-300 leading-relaxed"><?php esc_html_e('Virtual Sky combines NVMe infrastructure, real-time security, and AI copilots to accelerate every stage of your workflow.', 'virtualskywp'); ?></p>
            <ul class="space-y-3 text-slate-200">
                <li class="flex items-start gap-3"><span class="h-8 w-8 rounded-full bg-white/5 border border-white/10 flex items-center justify-center text-indigo-200">⚡</span><span><?php esc_html_e('NVMe-powered servers with LiteSpeed caching for WordPress & WooCommerce.', 'virtualskywp'); ?></span></li>
                <li class="flex items-start gap-3"><span class="h-8 w-8 rounded-full bg-white/5 border border-white/10 flex items-center justify-center text-indigo-200">🛡️</span><span><?php esc_html_e('Managed WAF, DDoS protection, and daily backups orchestrated via WHMCS webhooks.', 'virtualskywp'); ?></span></li>
                <li class="flex items-start gap-3"><span class="h-8 w-8 rounded-full bg-white/5 border border-white/10 flex items-center justify-center text-indigo-200">🤖</span><span><?php esc_html_e('AI assistants for migration, copywriting, and technical troubleshooting.', 'virtualskywp'); ?></span></li>
            </ul>
        </div>
        <div class="rounded-3xl border border-white/10 bg-white/5 backdrop-blur-xl p-8 space-y-6">
            <h3 class="text-2xl font-semibold text-white"><?php esc_html_e('Automation Pipelines', 'virtualskywp'); ?></h3>
            <p class="text-slate-300"><?php esc_html_e('Connect WHMCS purchases to n8n workflows that deploy VPS nodes, provision DNS templates, and send welcome journeys.', 'virtualskywp'); ?></p>
            <div class="grid gap-4">
                <div class="p-4 rounded-2xl bg-slate-950/60 border border-white/10">
                    <h4 class="text-lg font-semibold text-white"><?php esc_html_e('WordPress Hosting', 'virtualskywp'); ?></h4>
                    <p class="text-sm text-slate-400"><?php esc_html_e('Auto-install WordPress with caching, CDN, and malware scanning in one click.', 'virtualskywp'); ?></p>
                </div>
                <div class="p-4 rounded-2xl bg-slate-950/60 border border-white/10">
                    <h4 class="text-lg font-semibold text-white"><?php esc_html_e('Reseller Cloud', 'virtualskywp'); ?></h4>
                    <p class="text-sm text-slate-400"><?php esc_html_e('White-label cPanel and WHMCS integration with automated branding assets.', 'virtualskywp'); ?></p>
                </div>
                <div class="p-4 rounded-2xl bg-slate-950/60 border border-white/10">
                    <h4 class="text-lg font-semibold text-white"><?php esc_html_e('VPS with n8n', 'virtualskywp'); ?></h4>
                    <p class="text-sm text-slate-400"><?php esc_html_e('Trigger n8n webhooks to spin up KVM instances and push credentials securely.', 'virtualskywp'); ?></p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-24 bg-slate-950" id="hosting-grid">
    <div class="max-w-7xl mx-auto px-6 space-y-12">
        <div class="text-center space-y-4">
            <span class="px-4 py-1 rounded-full bg-white/5 border border-white/10 text-xs uppercase tracking-[0.3em] text-indigo-200/90"><?php esc_html_e('Explore the platform', 'virtualskywp'); ?></span>
            <h2 class="text-4xl font-semibold text-white"><?php esc_html_e('Hosting for every mission', 'virtualskywp'); ?></h2>
            <p class="text-slate-300 max-w-2xl mx-auto"><?php esc_html_e('Launch shared sites, scale to VPS, or build AI-native experiences. Every plan routes checkout through WHMCS for consistent billing.', 'virtualskywp'); ?></p>
        </div>
        <div class="grid gap-8 lg:grid-cols-3">
            <?php
            $product_pages = [
                ['title' => __('Shared Hosting', 'virtualskywp'), 'link' => home_url('/web-hosting'), 'description' => __('Start for $1 with blazing-fast shared hosting and AI support.', 'virtualskywp'), 'icon' => '🌐'],
                ['title' => __('WordPress Hosting', 'virtualskywp'), 'link' => home_url('/wordpress-hosting'), 'description' => __('Turbocharged WordPress installs with built-in caching and staging.', 'virtualskywp'), 'icon' => '🧩'],
                ['title' => __('Reseller Hosting', 'virtualskywp'), 'link' => home_url('/reseller-hosting'), 'description' => __('Launch your hosting business with WHMCS reseller automation.', 'virtualskywp'), 'icon' => '🤝'],
                ['title' => __('VPS Hosting', 'virtualskywp'), 'link' => home_url('/vps-hosting'), 'description' => __('Provision VPS nodes via n8n workflows and monitor with WHMCS.', 'virtualskywp'), 'icon' => '🚀'],
                ['title' => __('AI Hosting', 'virtualskywp'), 'link' => home_url('/ai-hosting'), 'description' => __('GPU-ready infrastructure with AI API acceleration and NVMe storage.', 'virtualskywp'), 'icon' => '🧠'],
                ['title' => __('Website Builder', 'virtualskywp'), 'link' => home_url('/website-builder'), 'description' => __('Craft cinematic landing pages in minutes with the AI Website Builder.', 'virtualskywp'), 'icon' => '🎬'],
            ];
            foreach ($product_pages as $card) :
                ?>
                <a href="<?php echo esc_url($card['link']); ?>" class="group p-8 rounded-3xl border border-white/10 bg-slate-950/70 backdrop-blur-xl hover:border-indigo-400/60 transition flex flex-col gap-4">
                    <span class="text-4xl"><?php echo esc_html($card['icon']); ?></span>
                    <div class="space-y-2">
                        <h3 class="text-2xl font-semibold text-white group-hover:text-indigo-200/90 transition"><?php echo esc_html($card['title']); ?></h3>
                        <p class="text-sm text-slate-300"><?php echo esc_html($card['description']); ?></p>
                    </div>
                    <span class="mt-auto text-sm font-semibold text-indigo-300 group-hover:text-pink-200 transition inline-flex items-center gap-2"><?php esc_html_e('View Details', 'virtualskywp'); ?><span class="dashicons dashicons-arrow-right-alt"></span></span>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="py-24 bg-gradient-to-r from-indigo-600/20 via-purple-600/20 to-pink-600/20">
    <div class="max-w-7xl mx-auto px-6 grid gap-12 lg:grid-cols-[1.1fr,0.9fr] items-center">
        <div class="space-y-6">
            <span class="px-4 py-1 rounded-full bg-white/5 border border-white/10 text-xs uppercase tracking-[0.3em] text-indigo-200/90"><?php esc_html_e('AI Website Builder', 'virtualskywp'); ?></span>
            <h2 class="text-4xl font-semibold text-white"><?php esc_html_e('Design cinematic experiences with AI', 'virtualskywp'); ?></h2>
            <p class="text-slate-200 leading-relaxed"><?php esc_html_e('Drag-and-drop sections, AI copy suggestions, and Tailwind-powered styling ship inside the Virtual Sky website builder.', 'virtualskywp'); ?></p>
            <div class="flex flex-wrap gap-3 text-sm text-slate-200">
                <span class="px-3 py-1 rounded-full bg-white/5 border border-white/10"><?php esc_html_e('Real-time Tailwind preview', 'virtualskywp'); ?></span>
                <span class="px-3 py-1 rounded-full bg-white/5 border border-white/10"><?php esc_html_e('AI copy & image generator', 'virtualskywp'); ?></span>
                <span class="px-3 py-1 rounded-full bg-white/5 border border-white/10"><?php esc_html_e('WHMCS checkout links', 'virtualskywp'); ?></span>
            </div>
            <a href="<?php echo esc_url($cta_builder); ?>" class="inline-flex items-center gap-2 px-6 py-3 rounded-full bg-gradient-to-r from-indigo-500 to-pink-500 text-white font-semibold shadow-lg shadow-indigo-500/40">
                <?php esc_html_e('Launch Builder', 'virtualskywp'); ?>
                <span class="dashicons dashicons-external"></span>
            </a>
        </div>
        <div class="rounded-3xl border border-white/10 bg-slate-950/80 backdrop-blur-xl p-8 space-y-6">
            <h3 class="text-2xl font-semibold text-white"><?php esc_html_e('AI Tools', 'virtualskywp'); ?></h3>
            <div class="grid gap-4" data-ai-tools-grid>
                <?php if (empty($ai_tools)) : ?>
                    <p class="text-sm text-slate-300"><?php esc_html_e('Add AI tools from the dashboard to highlight them here.', 'virtualskywp'); ?></p>
                <?php endif; ?>
                <?php foreach ($ai_tools as $tool) : ?>
                    <article class="p-5 rounded-2xl border border-white/10 bg-white/5 flex flex-col gap-3">
                        <div class="flex items-center gap-3">
                            <?php if (!empty($tool['thumbnail'])) : ?>
                                <span class="h-12 w-12 rounded-2xl overflow-hidden border border-white/10">
                                    <img src="<?php echo esc_url($tool['thumbnail']); ?>" alt="<?php echo esc_attr($tool['title']); ?>" class="h-full w-full object-cover" />
                                </span>
                            <?php else : ?>
                                <span class="h-12 w-12 rounded-2xl border border-white/10 bg-slate-950/80 flex items-center justify-center">🤖</span>
                            <?php endif; ?>
                            <div>
                                <h4 class="text-lg font-semibold text-white"><?php echo esc_html($tool['title']); ?></h4>
                                <?php if (!empty($tool['tool_type'])) : ?>
                                    <p class="text-xs uppercase tracking-[0.3em] text-slate-400"><?php echo esc_html($tool['tool_type']); ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="text-sm text-slate-200"><?php echo wp_kses_post($tool['description']); ?></div>
                        <?php if (!empty($tool['tool_link'])) : ?>
                            <a href="<?php echo esc_url($tool['tool_link']); ?>" class="mt-auto inline-flex items-center gap-2 text-sm font-semibold text-indigo-300">
                                <?php echo esc_html($tool['cta_label']); ?>
                                <span class="dashicons dashicons-arrow-right-alt"></span>
                            </a>
                        <?php endif; ?>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>

<section class="py-24 bg-slate-950" id="testimonials">
    <div class="max-w-7xl mx-auto px-6 space-y-12">
        <div class="text-center space-y-4">
            <span class="px-4 py-1 rounded-full bg-white/5 border border-white/10 text-xs uppercase tracking-[0.3em] text-indigo-200/90"><?php esc_html_e('Testimonials', 'virtualskywp'); ?></span>
            <h2 class="text-4xl font-semibold text-white"><?php esc_html_e('Loved by innovators worldwide', 'virtualskywp'); ?></h2>
            <p class="text-slate-300 max-w-2xl mx-auto"><?php esc_html_e('Agencies, SaaS teams, and indie hackers trust Virtual Sky to keep their projects online and automated.', 'virtualskywp'); ?></p>
        </div>
        <div class="relative" data-testimonial-slider>
            <div class="grid gap-6 lg:grid-cols-3" data-testimonial-track>
                <?php if (empty($testimonials)) : ?>
                    <p class="text-center text-slate-300"><?php esc_html_e('Publish testimonials to activate the slider.', 'virtualskywp'); ?></p>
                <?php endif; ?>
                <?php foreach ($testimonials as $testimonial) : ?>
                    <blockquote class="p-8 rounded-3xl border border-white/10 bg-slate-950/70 backdrop-blur-xl flex flex-col gap-4 text-slate-200">
                        <p class="text-lg leading-relaxed"><?php echo wp_kses_post($testimonial['content']); ?></p>
                        <footer class="mt-auto flex items-center gap-3">
                            <?php if (!empty($testimonial['thumbnail'])) : ?>
                                <span class="h-12 w-12 rounded-full border border-white/10 overflow-hidden">
                                    <img src="<?php echo esc_url($testimonial['thumbnail']); ?>" alt="<?php echo esc_attr($testimonial['title']); ?>" class="h-full w-full object-cover" />
                                </span>
                            <?php endif; ?>
                            <div>
                                <cite class="not-italic font-semibold text-white"><?php echo esc_html($testimonial['title']); ?></cite>
                                <?php if (!empty($testimonial['role'])) : ?>
                                    <p class="text-xs uppercase tracking-[0.3em] text-slate-400"><?php echo esc_html($testimonial['role']); ?></p>
                                <?php endif; ?>
                            </div>
                        </footer>
                    </blockquote>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>

<section class="py-24 bg-gradient-to-b from-slate-900 to-slate-950" id="faq">
    <div class="max-w-5xl mx-auto px-6 space-y-10">
        <div class="text-center space-y-4">
            <span class="px-4 py-1 rounded-full bg-white/5 border border-white/10 text-xs uppercase tracking-[0.3em] text-indigo-200/90"><?php esc_html_e('FAQs', 'virtualskywp'); ?></span>
            <h2 class="text-4xl font-semibold text-white"><?php esc_html_e('Answers before you launch', 'virtualskywp'); ?></h2>
            <p class="text-slate-300"><?php esc_html_e('Everything you need to know about WHMCS integrations, automation, and AI experiences.', 'virtualskywp'); ?></p>
        </div>
        <div class="space-y-4" data-accordion>
            <?php if (empty($faqs)) : ?>
                <p class="text-center text-slate-300"><?php esc_html_e('Add FAQs in the admin to populate this section.', 'virtualskywp'); ?></p>
            <?php endif; ?>
            <?php foreach ($faqs as $index => $faq) : ?>
                <article class="rounded-3xl border border-white/10 bg-slate-950/70 backdrop-blur-xl">
                    <button class="w-full flex items-center justify-between gap-4 px-6 py-5 text-left" data-accordion-toggle>
                        <span class="text-lg font-semibold text-white"><?php echo esc_html($faq['question']); ?></span>
                        <span class="dashicons dashicons-plus text-indigo-200"></span>
                    </button>
                    <div class="px-6 pb-6 hidden" data-accordion-panel>
                        <div class="text-slate-200 text-sm leading-relaxed"><?php echo wp_kses_post($faq['answer']); ?></div>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="py-24 bg-slate-950">
    <div class="max-w-5xl mx-auto px-6 text-center space-y-6">
        <h2 class="text-4xl font-semibold text-white"><?php esc_html_e('Join Virtual Sky — Where Innovation Meets Speed', 'virtualskywp'); ?></h2>
        <p class="text-slate-300 max-w-2xl mx-auto"><?php esc_html_e('Start for just $1, bundle a free domain, and scale with AI copilots, WHMCS automation, and n8n integrations.', 'virtualskywp'); ?></p>
        <div class="flex flex-wrap gap-4 justify-center">
            <a href="<?php echo esc_url($cta_cart); ?>" class="px-8 py-3 rounded-full bg-gradient-to-r from-indigo-500 to-pink-500 text-white font-semibold shadow-lg shadow-indigo-500/40">
                <?php esc_html_e('Get Started', 'virtualskywp'); ?>
            </a>
            <a href="<?php echo esc_url(home_url('/contact')); ?>" class="px-8 py-3 rounded-full border border-white/20 text-white font-semibold">
                <?php esc_html_e('Talk to Sales', 'virtualskywp'); ?>
            </a>
        </div>
    </div>
</section>
<?php get_footer(); ?>
