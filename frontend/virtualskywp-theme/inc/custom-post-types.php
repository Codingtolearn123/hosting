<?php
/**
 * Registers all custom post types and taxonomies for the theme.
 */

declare(strict_types=1);

if (!defined('ABSPATH')) {
    exit;
}

add_action('init', static function (): void {
    register_post_type('ai_tool', [
        'labels' => [
            'name' => __('AI Tools', 'virtualskywp'),
            'singular_name' => __('AI Tool', 'virtualskywp'),
        ],
        'public' => true,
        'show_in_rest' => true,
        'supports' => ['title', 'editor', 'thumbnail', 'custom-fields'],
        'menu_icon' => 'dashicons-art',
        'rewrite' => ['slug' => 'ai-tool'],
    ]);

    register_post_type('testimonial', [
        'labels' => [
            'name' => __('Testimonials', 'virtualskywp'),
            'singular_name' => __('Testimonial', 'virtualskywp'),
        ],
        'public' => true,
        'show_in_rest' => true,
        'supports' => ['title', 'editor', 'thumbnail', 'custom-fields'],
        'menu_icon' => 'dashicons-format-quote',
        'rewrite' => ['slug' => 'testimonials'],
    ]);

    register_post_type('faq', [
        'labels' => [
            'name' => __('FAQs', 'virtualskywp'),
            'singular_name' => __('FAQ', 'virtualskywp'),
        ],
        'public' => true,
        'show_in_rest' => true,
        'supports' => ['title', 'editor'],
        'menu_icon' => 'dashicons-editor-help',
        'rewrite' => ['slug' => 'faqs'],
    ]);

    register_post_type('hero_slide', [
        'labels' => [
            'name' => __('Hero Slides', 'virtualskywp'),
            'singular_name' => __('Hero Slide', 'virtualskywp'),
        ],
        'public' => false,
        'show_ui' => true,
        'show_in_rest' => true,
        'supports' => ['title', 'thumbnail'],
        'menu_icon' => 'dashicons-format-video',
    ]);
});
