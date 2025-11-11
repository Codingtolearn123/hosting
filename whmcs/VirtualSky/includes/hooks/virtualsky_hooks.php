<?php
use WHMCS\Config\Setting;

if ( ! defined( 'WHMCS' ) ) {
    die( 'This file cannot be accessed directly.' );
}

add_hook( 'ClientAreaPage', 0, function () {
    if ( session_status() === PHP_SESSION_NONE ) {
        session_start();
    }

    if ( isset( $_POST['virtualsky_ai_action'] ) ) {
        $action = $_POST['virtualsky_ai_action'];
        header( 'Content-Type: application/json' );

        if ( 'reset' === $action ) {
            unset( $_SESSION['virtualsky_ai_history'] );
            echo json_encode( array( 'success' => true, 'reply' => 'Conversation reset.' ) );
            exit;
        }

        $message = isset( $_POST['message'] ) ? trim( (string) $_POST['message'] ) : '';
        if ( '' === $message ) {
            echo json_encode( array( 'success' => false, 'message' => 'Message is required.' ) );
            exit;
        }

        $history = isset( $_SESSION['virtualsky_ai_history'] ) ? (array) $_SESSION['virtualsky_ai_history'] : array();
        $history[] = array( 'role' => 'user', 'content' => $message );

        $apiKey = Setting::getValue( 'VirtualSkyAIKey' );
        if ( ! $apiKey && defined( 'VIRTUALSKY_OPENAI_API_KEY' ) ) {
            $apiKey = VIRTUALSKY_OPENAI_API_KEY;
        }

        if ( ! $apiKey ) {
            echo json_encode( array( 'success' => false, 'message' => 'OpenAI API key not configured.' ) );
            exit;
        }

        try {
            $client   = new \GuzzleHttp\Client( array( 'timeout' => 15 ) );
            $response = $client->post(
                'https://api.openai.com/v1/chat/completions',
                array(
                    'headers' => array(
                        'Authorization' => 'Bearer ' . $apiKey,
                        'Content-Type'  => 'application/json',
                    ),
                    'json'    => array(
                        'model'    => 'gpt-4o-mini',
                        'messages' => $history,
                    ),
                )
            );

            $body = json_decode( (string) $response->getBody(), true );
            $reply = $body['choices'][0]['message']['content'] ?? '';
            if ( ! $reply ) {
                throw new \RuntimeException( 'Unexpected response from OpenAI.' );
            }

            $history[] = array( 'role' => 'assistant', 'content' => $reply );
            $_SESSION['virtualsky_ai_history'] = array_slice( $history, -10 );

            echo json_encode( array( 'success' => true, 'reply' => $reply ) );
            exit;
        } catch ( \Throwable $th ) {
            echo json_encode( array( 'success' => false, 'message' => $th->getMessage() ) );
            exit;
        }
    }
});
