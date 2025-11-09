<?php
declare(strict_types=1);

/*
Template Name: Shared Hosting
*/

get_header();

$category = 'shared';
?>
<?php locate_template('template-parts/hosting-category.php', true, false); ?>
<?php get_footer(); ?>
