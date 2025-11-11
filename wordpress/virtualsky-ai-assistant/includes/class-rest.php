<?php
namespace VirtualSkyAI;

use WP_Error;
use WP_REST_Request;
use WP_REST_Response;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Rest {
    const ROUTE = '/virtualsky-ai/v1/chat';

    public static function init() {
        add_action( 'rest_api_init', array( __CLASS__, 'register_routes' ) );
        add_action( 'wp_ajax_virtualsky_ai_chat', array( __CLASS__, 'handle_ajax' ) );
        add_action( 'wp_ajax_nopriv_virtualsky_ai_chat', array( __CLASS__, 'handle_ajax' ) );
    }

    public static function register_routes() {
        register_rest_route(
            'virtualsky-ai/v1',
            '/chat',
            array(
                'methods'             => 'POST',
                'callback'            => array( __CLASS__, 'rest_callback' ),
                'permission_callback' => '__return_true',
            )
        );
    }

    public static function handle_ajax() {
        check_ajax_referer( 'virtualsky_ai_chat', 'nonce' );

        $message = isset( $_POST['message'] ) ? sanitize_text_field( wp_unslash( $_POST['message'] ) ) : '';

        $response = self::complete_chat( $message );

        if ( is_wp_error( $response ) ) {
            wp_send_json_error( array( 'message' => $response->get_error_message() ), 400 );
        }

        wp_send_json_success( $response );
    }

    public static function rest_callback( WP_REST_Request $request ) {
        $message = $request->get_param( 'message' );
        $result  = self::complete_chat( $message );

        if ( is_wp_error( $result ) ) {
            return new WP_REST_Response( array( 'message' => $result->get_error_message() ), 400 );
        }

        return new WP_REST_Response( $result, 200 );
    }

    protected static function complete_chat( $message ) {
        $message = trim( (string) $message );

        if ( '__reset__' === $message ) {
            unset( $_SESSION['virtualsky_ai_history'] );
            return array(
                'reply'   => __( 'Conversation reset.', 'virtualsky-ai-assistant' ),
                'history' => array(),
            );
        }

        if ( '' === $message ) {
            return new WP_Error( 'virtualsky_ai_empty', __( 'Message cannot be empty.', 'virtualsky-ai-assistant' ) );
        }

        $history = isset( $_SESSION['virtualsky_ai_history'] ) ? (array) $_SESSION['virtualsky_ai_history'] : array();
        $history[] = array( 'role' => 'user', 'content' => $message );

        $api_key = Settings::get_api_key();
        if ( ! $api_key ) {
            return new WP_Error( 'virtualsky_ai_missing_key', __( 'OpenAI API key is not configured.', 'virtualsky-ai-assistant' ) );
        }

        $body = array(
            'model'       => 'gpt-4o-mini',
            'messages'    => $history,
            'temperature' => 0.7,
        );

        $response = wp_remote_post(
            'https://api.openai.com/v1/chat/completions',
            array(
                'timeout' => 20,
                'headers' => array(
                    'Authorization' => 'Bearer ' . $api_key,
                    'Content-Type'  => 'application/json',
                ),
                'body'    => wp_json_encode( $body ),
            )
        );

        if ( is_wp_error( $response ) ) {
            return new WP_Error( 'virtualsky_ai_http', $response->get_error_message() );
        }

        $code = wp_remote_retrieve_response_code( $response );
        $data = json_decode( wp_remote_retrieve_body( $response ), true );

        if ( 200 !== $code || empty( $data['choices'][0]['message']['content'] ) ) {
            return new WP_Error( 'virtualsky_ai_bad_response', __( 'Unexpected response from OpenAI.', 'virtualsky-ai-assistant' ) );
        }

        $assistant_message = $data['choices'][0]['message']['content'];
        $history[]         = array( 'role' => 'assistant', 'content' => $assistant_message );
        $_SESSION['virtualsky_ai_history'] = array_slice( $history, -10 );

        return array(
            'reply'   => $assistant_message,
            'history' => $_SESSION['virtualsky_ai_history'],
        );
    }
}
