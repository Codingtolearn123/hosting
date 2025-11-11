<?php
declare(strict_types=1);

global $post;

get_header();
?>
<section class="py-24 bg-slate-950">
    <div class="max-w-4xl mx-auto px-6 space-y-8">
        <div class="text-center space-y-4">
            <h1 class="text-4xl lg:text-5xl font-semibold text-white"><?php the_title(); ?></h1>
        </div>
        <div class="prose prose-invert max-w-none text-slate-200">
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
