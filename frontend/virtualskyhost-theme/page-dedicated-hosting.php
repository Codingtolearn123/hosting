<?php
declare(strict_types=1);

/*
Template Name: Dedicated Hosting
*/

get_header();

$category = 'dedicated';
?>
<?php locate_template('template-parts/hosting-category.php', true, false); ?>
<?php get_footer(); ?>
