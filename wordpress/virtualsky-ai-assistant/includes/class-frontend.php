<?php
namespace VirtualSkyAI;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Frontend {
    public static function init() {
        add_shortcode( 'virtualsky_ai_chat', array( __CLASS__, 'render_shortcode' ) );
        add_action( 'wp_enqueue_scripts', array( __CLASS__, 'enqueue_assets' ) );
        add_action( 'wp_footer', array( __CLASS__, 'render_floating_widget' ) );
    }

    public static function enqueue_assets() {
        wp_enqueue_style(
            'virtualsky-ai-assistant',
            plugins_url( '../assets/css/assistant.css', __FILE__ ),
            array(),
            '1.0.0'
        );

        wp_enqueue_script(
            'virtualsky-ai-assistant',
            plugins_url( '../assets/js/assistant.js', __FILE__ ),
            array( 'jquery' ),
            '1.0.0',
            true
        );

        wp_localize_script(
            'virtualsky-ai-assistant',
            'VirtualSkyAI',
            array(
                'ajaxUrl' => admin_url( 'admin-ajax.php' ),
                'nonce'   => wp_create_nonce( 'virtualsky_ai_chat' ),
            )
        );
    }

    public static function render_shortcode( $atts = array(), $content = '' ) {
        ob_start();
        self::render_chat_markup();
        return ob_get_clean();
    }

    protected static function render_chat_markup() {
        ?>
        <div class="virtualsky-ai-chat" data-virtualsky-ai>
            <div class="virtualsky-ai-messages" role="log"></div>
            <form class="virtualsky-ai-form">
                <label class="screen-reader-text" for="virtualsky-ai-input"><?php esc_html_e( 'Ask the AI assistant', 'virtualsky-ai-assistant' ); ?></label>
                <textarea id="virtualsky-ai-input" name="message" rows="3" placeholder="<?php esc_attr_e( 'How can we help?', 'virtualsky-ai-assistant' ); ?>" required></textarea>
                <div class="virtualsky-ai-actions">
                    <button type="submit" class="button button-primary"><?php esc_html_e( 'Send', 'virtualsky-ai-assistant' ); ?></button>
                    <button type="button" class="button virtualsky-ai-reset"><?php esc_html_e( 'Reset', 'virtualsky-ai-assistant' ); ?></button>
                </div>
            </form>
        </div>
        <?php
    }

    public static function render_floating_widget() {
        ?>
        <div class="virtualsky-ai-floating" aria-live="polite">
            <button class="virtualsky-ai-toggle" type="button">
                <span><?php esc_html_e( 'AI Assistant', 'virtualsky-ai-assistant' ); ?></span>
            </button>
            <div class="virtualsky-ai-floating-panel" hidden>
                <?php self::render_chat_markup(); ?>
            </div>
        </div>
        <?php
    }
}
