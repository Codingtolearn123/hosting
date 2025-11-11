<?php
/**
 * Theme bootstrap for VirtualSkyWP.
 */

define( 'VIRTUALSKYWP_VERSION', '1.0.0' );

define( 'VIRTUALSKYWP_MIN_ELEMENTOR_VERSION', '3.18.0' );

define( 'VIRTUALSKYWP_THEME_DIR', get_template_directory() );

define( 'VIRTUALSKYWP_THEME_URL', get_template_directory_uri() );

require_once VIRTUALSKYWP_THEME_DIR . '/inc/helpers.php';
require_once VIRTUALSKYWP_THEME_DIR . '/inc/assets.php';
require_once VIRTUALSKYWP_THEME_DIR . '/inc/elementor-kit.php';
require_once VIRTUALSKYWP_THEME_DIR . '/inc/setup.php';
