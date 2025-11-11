<?php
/**
 * Plugin Name: VirtualSky AI Assistant
 * Description: Adds a secure OpenAI-powered assistant with Elementor widget and shortcode.
 * Version: 1.0.0
 * Author: Virtual Sky
 * Text Domain: virtualsky-ai-assistant
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

require_once __DIR__ . '/includes/class-settings.php';
require_once __DIR__ . '/includes/class-rest.php';
require_once __DIR__ . '/includes/class-frontend.php';

register_activation_hook( __FILE__, 'virtualsky_ai_assistant_activate' );

/**
 * Ensure session availability and default options on activation.
 */
function virtualsky_ai_assistant_activate() {
    if ( ! session_id() ) {
        session_start();
    }

    if ( false === get_option( 'virtualsky_ai_assistant_settings' ) ) {
        add_option( 'virtualsky_ai_assistant_settings', array( 'api_key' => '' ) );
    }
}

add_action( 'init', 'virtualsky_ai_assistant_bootstrap', 5 );

/**
 * Bootstrap plugin features.
 */
function virtualsky_ai_assistant_bootstrap() {
    if ( ! session_id() ) {
        session_start();
    }

    \VirtualSkyAI\Settings::init();
    \VirtualSkyAI\Frontend::init();
    \VirtualSkyAI\Rest::init();

    if ( did_action( 'elementor/loaded' ) ) {
        require_once __DIR__ . '/includes/class-elementor-widget.php';
        \VirtualSkyAI\Elementor_Widget::init();
    }
}
