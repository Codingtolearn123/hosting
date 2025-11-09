<?php
declare(strict_types=1);

get_header();
?>
<section class="vs-container">
    <div class="section-gradient" style="display:grid; gap:1.5rem;">
        <h1 style="margin:0; font-size: clamp(2rem, 4vw, 3rem);">Latest Updates</h1>
        <div class="vs-grid two">
            <?php if (have_posts()) : ?>
                <?php while (have_posts()) : the_post(); ?>
                    <article class="vs-card">
                        <h2 style="margin-top:0;"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                        <p style="color: var(--vs-text-muted);"><?php echo esc_html(wp_trim_words(get_the_excerpt(), 24)); ?></p>
                        <a class="vs-button" style="justify-self:flex-start;" href="<?php the_permalink(); ?>"><?php esc_html_e('Read more', 'virtualskyhost'); ?></a>
                    </article>
                <?php endwhile; ?>
            <?php else : ?>
                <p><?php esc_html_e('No content found.', 'virtualskyhost'); ?></p>
            <?php endif; ?>
        </div>
    </div>
</section>
<?php get_footer(); ?>
