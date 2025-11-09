<?php
declare(strict_types=1);

global $post;

get_header();
?>
<section class="vs-container">
    <div class="section-gradient" style="display:grid; gap:1.5rem;">
        <h1 style="margin:0; font-size: clamp(2rem, 4vw, 3rem);"><?php the_title(); ?></h1>
        <div class="page-content" style="display:grid; gap:1.25rem; color: var(--vs-text-muted);">
            <?php
            while (have_posts()) {
                the_post();
                the_content();
            }
            ?>
        </div>
    </div>
</section>
<?php get_footer(); ?>
