<?php
/**
 * Gutenberg block patterns and categories.
 */

declare(strict_types=1);

if (!defined('ABSPATH')) {
    exit;
}

add_action('init', static function (): void {
    register_block_pattern_category('virtualskywp', [
        'label' => __('Virtual Sky', 'virtualskywp'),
    ]);

    register_block_pattern(
        'virtualskywp/hero',
        [
            'title' => __('Virtual Sky Hero', 'virtualskywp'),
            'description' => __('Full-width hero section with gradient overlay and buttons.', 'virtualskywp'),
            'categories' => ['virtualskywp'],
            'content' => '<!-- wp:cover {"url":"","dimRatio":0,"isDark":true,"className":"virtualskywp-hero"} -->
<div class="wp-block-cover virtualskywp-hero"><span aria-hidden="true" class="wp-block-cover__background has-background-dim-0"></span><div class="wp-block-cover__inner-container"><!-- wp:heading {"textAlign":"left","level":1,"style":{"typography":{"fontSize":"3rem"}}} -->
<h1 class="wp-block-heading has-text-align-left" style="font-size:3rem">' . esc_html__('Get Web Hosting Starting at $1', 'virtualskywp') . '</h1>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"left","style":{"typography":{"fontSize":"1.25rem"}}} -->
<p class="has-text-align-left" style="font-size:1.25rem">' . esc_html__('Fast, Secure & AI-Powered Hosting for Modern Creators', 'virtualskywp') . '</p>
<!-- /wp:paragraph -->

<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"left","flexWrap":"wrap"},"style":{"spacing":{"blockGap":"1rem"}}} -->
<div class="wp-block-buttons"><!-- wp:button {"className":"is-style-fill"} -->
<div class="wp-block-button is-style-fill"><a class="wp-block-button__link wp-element-button" href="#plans">' . esc_html__('Get Started', 'virtualskywp') . '</a></div>
<!-- /wp:button -->

<!-- wp:button {"className":"is-style-outline"} -->
<div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button" href="#pricing">' . esc_html__('View Plans', 'virtualskywp') . '</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div></div>
<!-- /wp:cover -->',
        ]
    );
});
