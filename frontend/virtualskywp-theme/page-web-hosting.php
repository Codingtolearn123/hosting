<?php
declare(strict_types=1);

/*
Template Name: Web Hosting
*/

get_header();

$category = 'shared';
the_post();
?>
<?php locate_template('template-parts/hosting-category.php', true, false); ?>
<?php get_footer(); ?>
