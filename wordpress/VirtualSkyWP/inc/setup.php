<?php
/**
 * Theme setup and page provisioning.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

add_action( 'after_setup_theme', 'virtualskywp_setup' );
add_action( 'after_switch_theme', 'virtualskywp_provision_pages' );

/**
 * Register theme support.
 */
function virtualskywp_setup() {
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'menus' );
    add_theme_support( 'automatic-feed-links' );
    add_theme_support( 'editor-styles' );
    add_editor_style( 'assets/css/theme.css' );

    register_nav_menus(
        array(
            'primary' => __( 'Primary Navigation', 'virtualskywp' ),
            'footer'  => __( 'Footer Navigation', 'virtualskywp' ),
        )
    );
}

/**
 * Provision Elementor-ready pages on activation.
 */
function virtualskywp_provision_pages() {
    if ( get_option( 'virtualskywp_pages_provisioned' ) ) {
        return;
    }

    $pages = array(
        'home' => array(
            'title'      => __( 'Home', 'virtualskywp' ),
            'template'   => 'elementor-home.json',
            'is_front'   => true,
            'menu_order' => 0,
        ),
        'web-hosting' => array(
            'title'    => __( 'Web Hosting', 'virtualskywp' ),
            'template' => 'elementor-web-hosting.json',
        ),
        'reseller-hosting' => array(
            'title'    => __( 'Reseller Hosting', 'virtualskywp' ),
            'template' => 'elementor-reseller-hosting.json',
        ),
        'vps-cloud' => array(
            'title'    => __( 'VPS & Cloud', 'virtualskywp' ),
            'template' => 'elementor-vps-cloud.json',
        ),
        'ai-agent-builder' => array(
            'title'    => __( 'AI Agent Builder', 'virtualskywp' ),
            'template' => 'elementor-ai-agent.json',
        ),
        'about' => array(
            'title'    => __( 'About', 'virtualskywp' ),
            'template' => 'elementor-about.json',
        ),
        'contact' => array(
            'title'    => __( 'Contact', 'virtualskywp' ),
            'template' => 'elementor-contact.json',
        ),
    );

    foreach ( $pages as $slug => $args ) {
        $existing = get_page_by_path( $slug );
        if ( $existing ) {
            continue;
        }

        $page_id = wp_insert_post(
            array(
                'post_title'   => $args['title'],
                'post_name'    => $slug,
                'post_status'  => 'publish',
                'post_type'    => 'page',
                'post_content' => __( 'This page is managed by Elementor.', 'virtualskywp' ),
            )
        );

        if ( $page_id ) {
            virtualskywp_apply_elementor_template( $page_id, $args['template'] );

            if ( ! empty( $args['is_front'] ) ) {
                update_option( 'show_on_front', 'page' );
                update_option( 'page_on_front', $page_id );
            }
        }
    }

    update_option( 'virtualskywp_pages_provisioned', 1 );
}
