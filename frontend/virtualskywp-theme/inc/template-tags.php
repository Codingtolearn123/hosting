<?php
/**
 * Utility template helpers.
 */

declare(strict_types=1);

if (!defined('ABSPATH')) {
    exit;
}

function virtualskywp_get_ai_tools(): array
{
    $query = new \WP_Query([
        'post_type' => 'ai_tool',
        'posts_per_page' => -1,
        'orderby' => [
            'menu_order' => 'ASC',
            'title' => 'ASC',
        ],
    ]);

    $tools = [];

    foreach ($query->posts as $post) {
        $meta = get_post_meta($post->ID);
        $tools[] = [
            'id' => $post->ID,
            'title' => get_the_title($post),
            'description' => apply_filters('the_content', $post->post_content),
            'cta_label' => $meta['_virtualskywp_cta_label'][0] ?? __('Use Now', 'virtualskywp'),
            'tool_link' => $meta['_virtualskywp_tool_link'][0] ?? '',
            'tool_type' => $meta['_virtualskywp_tool_type'][0] ?? '',
            'thumbnail' => get_the_post_thumbnail_url($post, 'medium'),
        ];
    }

    wp_reset_postdata();

    return $tools;
}

function virtualskywp_get_testimonials(): array
{
    $query = new \WP_Query([
        'post_type' => 'testimonial',
        'posts_per_page' => -1,
        'orderby' => [
            'menu_order' => 'ASC',
            'title' => 'ASC',
        ],
    ]);

    $testimonials = [];

    foreach ($query->posts as $post) {
        $meta = get_post_meta($post->ID);
        $testimonials[] = [
            'id' => $post->ID,
            'title' => get_the_title($post),
            'content' => apply_filters('the_content', $post->post_content),
            'role' => $meta['_virtualskywp_author_role'][0] ?? '',
            'rating' => (int) ($meta['_virtualskywp_rating'][0] ?? 5),
            'thumbnail' => get_the_post_thumbnail_url($post, 'thumbnail'),
        ];
    }

    wp_reset_postdata();

    return $testimonials;
}

function virtualskywp_get_faqs(): array
{
    $query = new \WP_Query([
        'post_type' => 'faq',
        'posts_per_page' => -1,
        'orderby' => [
            'menu_order' => 'ASC',
            'title' => 'ASC',
        ],
    ]);

    $items = [];

    foreach ($query->posts as $post) {
        $items[] = [
            'id' => $post->ID,
            'question' => get_the_title($post),
            'answer' => apply_filters('the_content', $post->post_content),
        ];
    }

    wp_reset_postdata();

    return $items;
}

function virtualskywp_get_hero_slides(): array
{
    $query = new \WP_Query([
        'post_type' => 'hero_slide',
        'posts_per_page' => -1,
        'orderby' => [
            'menu_order' => 'ASC',
            'title' => 'ASC',
        ],
    ]);

    $slides = [];

    foreach ($query->posts as $post) {
        $slides[] = [
            'id' => $post->ID,
            'title' => get_the_title($post),
            'image' => get_the_post_thumbnail_url($post, 'full'),
        ];
    }

    wp_reset_postdata();

    return $slides;
}
