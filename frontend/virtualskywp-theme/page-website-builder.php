<?php
declare(strict_types=1);

/*
Template Name: Website Builder
*/

get_header();
the_post();

$options = virtualskywp_get_theme_options();
$builder_url = $options['cta_builder_url'] ?? '#';
$ai_tools = virtualskywp_get_ai_tools();
?>
<section class="relative overflow-hidden py-24 bg-gradient-to-b from-slate-950 via-slate-900 to-slate-950">
    <div class="max-w-5xl mx-auto px-6 text-center space-y-6">
        <span class="px-4 py-1 rounded-full bg-white/5 border border-white/10 text-xs uppercase tracking-[0.3em] text-indigo-200/90"><?php esc_html_e('Virtual Sky Builder', 'virtualskywp'); ?></span>
        <h1 class="text-4xl lg:text-5xl font-semibold text-white"><?php the_title(); ?></h1>
        <div class="prose prose-invert max-w-3xl mx-auto text-slate-300">
            <?php the_content(); ?>
        </div>
        <a href="<?php echo esc_url($builder_url); ?>" class="inline-flex items-center gap-2 px-8 py-3 rounded-full bg-gradient-to-r from-indigo-500 to-pink-500 text-white font-semibold shadow-lg shadow-indigo-500/40" target="_blank" rel="noopener">
            <?php esc_html_e('Launch Builder', 'virtualskywp'); ?>
            <span class="dashicons dashicons-external"></span>
        </a>
    </div>
</section>
<section class="py-20 bg-slate-950">
    <div class="max-w-6xl mx-auto px-6 grid gap-10 lg:grid-cols-2 items-center">
        <div class="space-y-6">
            <h2 class="text-3xl font-semibold text-white"><?php esc_html_e('Build cinematic layouts powered by AI', 'virtualskywp'); ?></h2>
            <p class="text-slate-300 leading-relaxed"><?php esc_html_e('Compose sections with Tailwind presets, generate copy with AI, and publish instantly to your Virtual Sky hosting plan.', 'virtualskywp'); ?></p>
            <ul class="space-y-3 text-slate-200 text-sm">
                <li class="flex items-start gap-3"><span class="h-8 w-8 rounded-full bg-white/5 border border-white/10 flex items-center justify-center">🎨</span><span><?php esc_html_e('Glassmorphic hero, pricing, and testimonial presets', 'virtualskywp'); ?></span></li>
                <li class="flex items-start gap-3"><span class="h-8 w-8 rounded-full bg-white/5 border border-white/10 flex items-center justify-center">⚙️</span><span><?php esc_html_e('WHMCS product linking baked into CTA buttons', 'virtualskywp'); ?></span></li>
                <li class="flex items-start gap-3"><span class="h-8 w-8 rounded-full bg-white/5 border border-white/10 flex items-center justify-center">🤖</span><span><?php esc_html_e('AI prompts for copy, imagery, and SEO metadata', 'virtualskywp'); ?></span></li>
            </ul>
        </div>
        <div class="rounded-3xl border border-white/10 bg-white/5 backdrop-blur-xl p-8 space-y-6">
            <h3 class="text-2xl font-semibold text-white"><?php esc_html_e('AI Design Toolkit', 'virtualskywp'); ?></h3>
            <p class="text-slate-300 text-sm"><?php esc_html_e('Use our AI tools to accelerate your builder workflow.', 'virtualskywp'); ?></p>
            <div class="grid gap-4">
                <?php foreach (array_slice($ai_tools, 0, 4) as $tool) : ?>
                    <article class="p-4 rounded-2xl border border-white/10 bg-slate-950/70 flex items-center gap-4">
                        <?php if (!empty($tool['thumbnail'])) : ?>
                            <span class="h-12 w-12 rounded-2xl overflow-hidden border border-white/10">
                                <img src="<?php echo esc_url($tool['thumbnail']); ?>" alt="<?php echo esc_attr($tool['title']); ?>" class="h-full w-full object-cover" />
                            </span>
                        <?php else : ?>
                            <span class="h-12 w-12 rounded-2xl border border-white/10 bg-slate-950/80 flex items-center justify-center">🤖</span>
                        <?php endif; ?>
                        <div>
                            <h4 class="text-lg font-semibold text-white"><?php echo esc_html($tool['title']); ?></h4>
                            <p class="text-xs uppercase tracking-[0.3em] text-slate-400"><?php echo esc_html($tool['tool_type']); ?></p>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>
<?php get_footer(); ?>
