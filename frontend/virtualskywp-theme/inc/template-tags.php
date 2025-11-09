<?php
/**
 * Utility template helpers.
 */

declare(strict_types=1);

if (!defined('ABSPATH')) {
    exit;
}

function virtualskywp_get_hosting_plans(string $type = ''): array
{
    $args = [
        'post_type' => 'hosting_plan',
        'posts_per_page' => -1,
        'orderby' => [
            'menu_order' => 'ASC',
            'title' => 'ASC',
        ],
    ];

    if ($type) {
        $args['tax_query'] = [
            [
                'taxonomy' => 'hosting_type',
                'field' => 'slug',
                'terms' => $type,
            ],
        ];
    }

    $query = new \WP_Query($args);

    $plans = [];

    foreach ($query->posts as $post) {
        $plans[] = virtualskywp_format_hosting_plan($post);
    }

    wp_reset_postdata();

    return $plans;
}

function virtualskywp_format_hosting_plan(\WP_Post $post): array
{
    $meta = get_post_meta($post->ID);
    $features = get_post_meta($post->ID, '_virtualskywp_features', true);

    return [
        'id' => $post->ID,
        'title' => get_the_title($post),
        'content' => apply_filters('the_content', $post->post_content),
        'excerpt' => get_the_excerpt($post),
        'price_monthly' => $meta['_virtualskywp_price_monthly'][0] ?? '',
        'price_yearly' => $meta['_virtualskywp_price_yearly'][0] ?? '',
        'promo_price' => $meta['_virtualskywp_promo_price'][0] ?? '',
        'badge_text' => $meta['_virtualskywp_badge_text'][0] ?? '',
        'whmcs_link' => $meta['_virtualskywp_whmcs_link'][0] ?? '',
        'n8n_webhook' => $meta['_virtualskywp_n8n_webhook'][0] ?? '',
        'highlighted' => !empty($meta['_virtualskywp_highlighted'][0]),
        'free_domain' => !empty($meta['_virtualskywp_free_domain'][0]),
        'ai_ready' => !empty($meta['_virtualskywp_ai_ready'][0]),
        'features' => is_array($features) ? $features : [],
        'thumbnail' => get_the_post_thumbnail_url($post, 'large'),
        'types' => wp_get_post_terms($post->ID, 'hosting_type', ['fields' => 'slugs']),
    ];
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
