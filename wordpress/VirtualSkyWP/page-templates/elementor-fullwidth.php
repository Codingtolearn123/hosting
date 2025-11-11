<?php
/**
 * Template Name: Elementor Full Width
 * Description: Blank canvas for Elementor-powered layouts.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();
?>
<div class="container" style="max-width:1300px;margin:0 auto;padding:0 2rem;">
    <?php
    while ( have_posts() ) :
        the_post();
        the_content();
    endwhile;
    ?>
</div>
<?php
get_footer();
