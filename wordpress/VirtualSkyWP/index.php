<?php
/**
 * Default template.
 */

get_header();
?>
<div class="container" style="max-width:1200px;margin:0 auto;padding:0 2rem;">
    <?php if ( have_posts() ) : ?>
        <?php while ( have_posts() ) : the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header class="entry-header">
                    <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
                </header>
                <div class="entry-content">
                    <?php the_content(); ?>
                </div>
            </article>
        <?php endwhile; ?>
    <?php else : ?>
        <p><?php esc_html_e( 'No content found.', 'virtualskywp' ); ?></p>
    <?php endif; ?>
</div>
<?php
get_footer();
