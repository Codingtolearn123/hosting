<?php
/**
 * Handle theme assets.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

add_action( 'wp_enqueue_scripts', 'virtualskywp_enqueue_assets' );
add_action( 'enqueue_block_editor_assets', 'virtualskywp_enqueue_editor_assets' );

/**
 * Frontend assets.
 */
function virtualskywp_enqueue_assets() {
    wp_enqueue_style(
        'virtualskywp-fontawesome',
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css',
        array(),
        '6.5.1'
    );

    wp_enqueue_style(
        'virtualskywp-theme',
        VIRTUALSKYWP_THEME_URL . '/assets/css/theme.css',
        array(),
        VIRTUALSKYWP_VERSION
    );

    wp_enqueue_script(
        'virtualskywp-theme',
        VIRTUALSKYWP_THEME_URL . '/assets/js/theme.js',
        array( 'jquery' ),
        VIRTUALSKYWP_VERSION,
        true
    );
}

/**
 * Editor assets for Elementor and block editor.
 */
function virtualskywp_enqueue_editor_assets() {
    wp_enqueue_style(
        'virtualskywp-fontawesome-editor',
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css',
        array(),
        '6.5.1'
    );

    wp_enqueue_style(
        'virtualskywp-editor',
        VIRTUALSKYWP_THEME_URL . '/assets/css/theme.css',
        array(),
        VIRTUALSKYWP_VERSION
    );
}
