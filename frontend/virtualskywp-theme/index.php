<?php
declare(strict_types=1);

get_header();
?>
<section class="py-24 bg-slate-950">
    <div class="max-w-5xl mx-auto px-6 space-y-12">
        <div class="text-center space-y-4">
            <span class="px-4 py-1 rounded-full bg-white/5 border border-white/10 text-xs uppercase tracking-[0.3em] text-indigo-200/90"><?php esc_html_e('Insights', 'virtualskywp'); ?></span>
            <h1 class="text-4xl font-semibold text-white"><?php esc_html_e('Latest from the Virtual Sky blog', 'virtualskywp'); ?></h1>
        </div>
        <div class="grid gap-8 md:grid-cols-2">
            <?php if (have_posts()) : ?>
                <?php while (have_posts()) : the_post(); ?>
                    <article class="p-6 rounded-3xl border border-white/10 bg-slate-950/70 backdrop-blur-xl space-y-4">
                        <h2 class="text-2xl font-semibold text-white"><a class="hover:text-indigo-200 transition" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                        <p class="text-sm text-slate-300"><?php echo esc_html(wp_trim_words(get_the_excerpt(), 26)); ?></p>
                        <a class="inline-flex items-center gap-2 text-sm font-semibold text-indigo-300" href="<?php the_permalink(); ?>"><?php esc_html_e('Read more', 'virtualskywp'); ?><span class="dashicons dashicons-arrow-right-alt"></span></a>
                    </article>
                <?php endwhile; ?>
            <?php else : ?>
                <p class="text-center text-slate-300"><?php esc_html_e('No content found.', 'virtualskywp'); ?></p>
            <?php endif; ?>
        </div>
        <div class="flex justify-center">
            <?php the_posts_pagination([
                'prev_text' => __('Previous', 'virtualskywp'),
                'next_text' => __('Next', 'virtualskywp'),
            ]); ?>
        </div>
    </div>
</section>
<?php get_footer(); ?>
