<?php
declare(strict_types=1);

/*
Template Name: Reseller Hosting
*/

get_header();

$category = 'reseller';
the_post();
?>
<?php locate_template('template-parts/hosting-category.php', true, false); ?>
<?php get_footer(); ?>
