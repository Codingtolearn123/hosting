<?php
/**
 * Elementor template provisioning.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

add_action( 'after_setup_theme', 'virtualskywp_maybe_import_elementor_templates', 20 );

/**
 * Import Elementor templates if Elementor is active.
 */
function virtualskywp_maybe_import_elementor_templates() {
    if ( ! did_action( 'elementor/loaded' ) ) {
        add_action( 'elementor/init', 'virtualskywp_maybe_import_elementor_templates' );
        return;
    }

    if ( get_option( 'virtualskywp_elementor_templates_imported' ) ) {
        return;
    }

    $template_dir = VIRTUALSKYWP_THEME_DIR . '/elementor/templates';
    $files        = glob( trailingslashit( $template_dir ) . '*.json' );

    if ( empty( $files ) ) {
        update_option( 'virtualskywp_elementor_templates_imported', 1 );
        return;
    }

    foreach ( $files as $file ) {
        virtualskywp_import_single_template( $file );
    }

    update_option( 'virtualskywp_elementor_templates_imported', 1 );
}

/**
 * Apply a template to a given page.
 *
 * @param int    $page_id   Page ID.
 * @param string $file_name Template file name.
 */
function virtualskywp_apply_elementor_template( $page_id, $file_name ) {
    $path = VIRTUALSKYWP_THEME_DIR . '/elementor/templates/' . $file_name;

    if ( ! file_exists( $path ) ) {
        return;
    }

    $data = json_decode( file_get_contents( $path ), true );

    if ( empty( $data['content'] ) ) {
        return;
    }

    $content = wp_slash( wp_json_encode( $data['content'] ) );

    update_post_meta( $page_id, '_elementor_edit_mode', 'builder' );
    update_post_meta( $page_id, '_elementor_data', $content );
    update_post_meta( $page_id, '_elementor_version', VIRTUALSKYWP_MIN_ELEMENTOR_VERSION );

    if ( ! empty( $data['page_settings'] ) ) {
        update_post_meta( $page_id, '_elementor_page_settings', $data['page_settings'] );
    }
}

/**
 * Import templates into the Elementor library.
 *
 * @param string $file_path Absolute path to the template JSON.
 */
function virtualskywp_import_single_template( $file_path ) {
    $data = json_decode( file_get_contents( $file_path ), true );

    if ( empty( $data['title'] ) || empty( $data['content'] ) ) {
        return;
    }

    $existing = get_page_by_title( $data['title'], OBJECT, 'elementor_library' );
    if ( $existing ) {
        return;
    }

    wp_insert_post(
        array(
            'post_title'   => sanitize_text_field( $data['title'] ),
            'post_status'  => 'publish',
            'post_type'    => 'elementor_library',
            'post_content' => '',
            'meta_input'   => array(
                '_elementor_edit_mode'    => 'builder',
                '_elementor_version'      => VIRTUALSKYWP_MIN_ELEMENTOR_VERSION,
                '_elementor_template_type'=> 'page',
                '_elementor_data'         => wp_slash( wp_json_encode( $data['content'] ) ),
            ),
        )
    );
}
