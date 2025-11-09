<?php
declare(strict_types=1);

/*
Template Name: AI Agent Builder
*/

get_header();
the_post();
?>
<section class="py-24 bg-slate-950">
    <div class="max-w-4xl mx-auto px-6 text-center space-y-6">
        <span class="px-4 py-1 rounded-full bg-white/5 border border-white/10 text-xs uppercase tracking-[0.3em] text-indigo-200/90"><?php esc_html_e('AI Agent Studio', 'virtualskywp'); ?></span>
        <h1 class="text-4xl lg:text-5xl font-semibold text-white"><?php the_title(); ?></h1>
        <div class="prose prose-invert max-w-3xl mx-auto text-slate-300">
            <?php the_content(); ?>
        </div>
    </div>
</section>
<section class="py-20 bg-gradient-to-b from-slate-950 via-slate-900 to-slate-950">
    <div class="max-w-6xl mx-auto px-6 grid gap-12 lg:grid-cols-[1fr,1.1fr] items-start">
        <div class="rounded-3xl border border-white/10 bg-white/5 backdrop-blur-xl p-8 space-y-6">
            <h2 class="text-2xl font-semibold text-white"><?php esc_html_e('How it works', 'virtualskywp'); ?></h2>
            <ol class="space-y-4 text-sm text-slate-200">
                <li class="flex items-start gap-3"><span class="mt-1 h-6 w-6 rounded-full bg-gradient-to-r from-indigo-500 to-pink-500 flex items-center justify-center text-xs font-bold">1</span><span><?php esc_html_e('Open the AI Agent Builder under Tools → AI Agent Builder.', 'virtualskywp'); ?></span></li>
                <li class="flex items-start gap-3"><span class="mt-1 h-6 w-6 rounded-full bg-gradient-to-r from-indigo-500 to-pink-500 flex items-center justify-center text-xs font-bold">2</span><span><?php esc_html_e('Create an agent with a name, goal, tone, and default model.', 'virtualskywp'); ?></span></li>
                <li class="flex items-start gap-3"><span class="mt-1 h-6 w-6 rounded-full bg-gradient-to-r from-indigo-500 to-pink-500 flex items-center justify-center text-xs font-bold">3</span><span><?php esc_html_e('Attach API keys and optional knowledge base URLs.', 'virtualskywp'); ?></span></li>
                <li class="flex items-start gap-3"><span class="mt-1 h-6 w-6 rounded-full bg-gradient-to-r from-indigo-500 to-pink-500 flex items-center justify-center text-xs font-bold">4</span><span><?php esc_html_e('Embed the [virtualskywp_agent id="123"] shortcode anywhere on your site.', 'virtualskywp'); ?></span></li>
            </ol>
        </div>
        <div class="rounded-3xl border border-white/10 bg-white/5 backdrop-blur-xl p-8 space-y-6">
            <h2 class="text-2xl font-semibold text-white"><?php esc_html_e('Preview your agents', 'virtualskywp'); ?></h2>
            <p class="text-slate-300 text-sm leading-relaxed"><?php esc_html_e('Use the live preview below to interact with agents you create in the WordPress dashboard.', 'virtualskywp'); ?></p>
            <div class="virtualskywp-agent-preview" data-agent-preview>
                <?php echo do_shortcode('[virtualskywp_agent_preview]'); ?>
            </div>
        </div>
    </div>
</section>
<?php get_footer(); ?>
