<?php
declare(strict_types=1);

/*
Template Name: AI Tools
*/

get_header();
the_post();

$tools = virtualskywp_get_ai_tools();
?>
<section class="py-24 bg-slate-950">
    <div class="max-w-5xl mx-auto px-6 text-center space-y-6">
        <span class="px-4 py-1 rounded-full bg-white/5 border border-white/10 text-xs uppercase tracking-[0.3em] text-indigo-200/90"><?php esc_html_e('AI Toolkit', 'virtualskywp'); ?></span>
        <h1 class="text-4xl lg:text-5xl font-semibold text-white"><?php the_title(); ?></h1>
        <div class="prose prose-invert max-w-3xl mx-auto text-slate-300">
            <?php the_content(); ?>
        </div>
    </div>
</section>
<section class="py-20 bg-gradient-to-b from-slate-950 via-slate-900 to-slate-950">
    <div class="max-w-6xl mx-auto px-6 grid gap-8 md:grid-cols-2 lg:grid-cols-3">
        <?php foreach ($tools as $tool) : ?>
            <article class="p-6 rounded-3xl border border-white/10 bg-slate-950/70 backdrop-blur-xl flex flex-col gap-4">
                <div class="flex items-center gap-4">
                    <?php if (!empty($tool['thumbnail'])) : ?>
                        <span class="h-14 w-14 rounded-2xl overflow-hidden border border-white/10">
                            <img src="<?php echo esc_url($tool['thumbnail']); ?>" alt="<?php echo esc_attr($tool['title']); ?>" class="h-full w-full object-cover" />
                        </span>
                    <?php else : ?>
                        <span class="h-14 w-14 rounded-2xl border border-white/10 bg-slate-950/80 flex items-center justify-center">🤖</span>
                    <?php endif; ?>
                    <div>
                        <h2 class="text-xl font-semibold text-white"><?php echo esc_html($tool['title']); ?></h2>
                        <?php if (!empty($tool['tool_type'])) : ?>
                            <p class="text-xs uppercase tracking-[0.3em] text-slate-400"><?php echo esc_html($tool['tool_type']); ?></p>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="text-sm text-slate-200 leading-relaxed"><?php echo wp_kses_post($tool['description']); ?></div>
                <?php if (!empty($tool['tool_link'])) : ?>
                    <a href="<?php echo esc_url($tool['tool_link']); ?>" class="mt-auto inline-flex items-center gap-2 text-sm font-semibold text-indigo-300">
                        <?php echo esc_html($tool['cta_label']); ?>
                        <span class="dashicons dashicons-arrow-right-alt"></span>
                    </a>
                <?php endif; ?>
            </article>
        <?php endforeach; ?>
    </div>
</section>
<?php get_footer(); ?>
