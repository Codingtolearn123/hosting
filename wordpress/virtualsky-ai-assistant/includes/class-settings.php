<?php
namespace VirtualSkyAI;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Settings {
    const OPTION_NAME = 'virtualsky_ai_assistant_settings';

    public static function init() {
        add_action( 'admin_menu', array( __CLASS__, 'register_menu' ) );
        add_action( 'admin_init', array( __CLASS__, 'register_settings' ) );
    }

    public static function register_menu() {
        add_options_page(
            __( 'VirtualSky AI Assistant', 'virtualsky-ai-assistant' ),
            __( 'VirtualSky AI Assistant', 'virtualsky-ai-assistant' ),
            'manage_options',
            'virtualsky-ai-assistant',
            array( __CLASS__, 'render_page' )
        );
    }

    public static function register_settings() {
        register_setting( 'virtualsky_ai_assistant', self::OPTION_NAME, array( __CLASS__, 'sanitize' ) );
    }

    public static function sanitize( $value ) {
        $value = is_array( $value ) ? $value : array();
        $value['api_key'] = isset( $value['api_key'] ) ? trim( $value['api_key'] ) : '';
        return $value;
    }

    public static function render_page() {
        if ( ! current_user_can( 'manage_options' ) ) {
            return;
        }

        $options  = get_option( self::OPTION_NAME, array( 'api_key' => '' ) );
        $stored   = ! empty( $options['api_key'] );
        $constant = defined( 'OPENAI_API_KEY' ) ? OPENAI_API_KEY : '';
        ?>
        <div class="wrap">
            <h1><?php esc_html_e( 'VirtualSky AI Assistant', 'virtualsky-ai-assistant' ); ?></h1>
            <p><?php esc_html_e( 'Provide your OpenAI API key to enable the assistant. The option value overrides the wp-config constant if both are set.', 'virtualsky-ai-assistant' ); ?></p>
            <form method="post" action="options.php">
                <?php
                settings_fields( 'virtualsky_ai_assistant' );
                ?>
                <table class="form-table" role="presentation">
                    <tr>
                        <th scope="row"><label for="virtualsky-ai-api-key"><?php esc_html_e( 'OpenAI API Key', 'virtualsky-ai-assistant' ); ?></label></th>
                        <td>
                            <input type="password" id="virtualsky-ai-api-key" name="<?php echo esc_attr( self::OPTION_NAME ); ?>[api_key]" value="<?php echo esc_attr( $options['api_key'] ); ?>" class="regular-text" />
                            <?php if ( $constant && ! $stored ) : ?>
                                <p class="description"><?php esc_html_e( 'Using wp-config constant OPENAI_API_KEY.', 'virtualsky-ai-assistant' ); ?></p>
                            <?php elseif ( $stored ) : ?>
                                <p class="description"><?php esc_html_e( 'Using the saved key stored in the database.', 'virtualsky-ai-assistant' ); ?></p>
                            <?php else : ?>
                                <p class="description"><?php esc_html_e( 'No API key found. Add one here or define OPENAI_API_KEY.', 'virtualsky-ai-assistant' ); ?></p>
                            <?php endif; ?>
                        </td>
                    </tr>
                </table>
                <?php submit_button(); ?>
            </form>
        </div>
        <?php
    }

    public static function get_api_key() {
        $options = get_option( self::OPTION_NAME, array() );
        if ( ! empty( $options['api_key'] ) ) {
            return $options['api_key'];
        }

        if ( defined( 'OPENAI_API_KEY' ) ) {
            return OPENAI_API_KEY;
        }

        return '';
    }
}
