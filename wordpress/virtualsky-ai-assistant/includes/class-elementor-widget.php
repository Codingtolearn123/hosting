<?php
namespace VirtualSkyAI;

use Elementor\Controls_Manager;
use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Elementor_Widget extends Widget_Base {
    public static function init() {
        add_action( 'elementor/widgets/register', function ( $widgets_manager ) {
            $widgets_manager->register( new self() );
        } );
    }

    public function get_name() {
        return 'virtualsky_ai_chat';
    }

    public function get_title() {
        return __( 'VirtualSky AI Chat', 'virtualsky-ai-assistant' );
    }

    public function get_icon() {
        return 'eicon-chat';
    }

    public function get_categories() {
        return array( 'general' );
    }

    protected function register_controls() {
        $this->start_controls_section(
            'section_content',
            array(
                'label' => __( 'Content', 'virtualsky-ai-assistant' ),
            )
        );

        $this->add_control(
            'intro_text',
            array(
                'label'   => __( 'Intro Message', 'virtualsky-ai-assistant' ),
                'type'    => Controls_Manager::TEXT,
                'default' => __( 'Ask our AI anything about Virtual Sky hosting.', 'virtualsky-ai-assistant' ),
            )
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        if ( ! empty( $settings['intro_text'] ) ) {
            echo '<p class="virtualsky-ai-intro">' . esc_html( $settings['intro_text'] ) . '</p>';
        }

        echo do_shortcode( '[virtualsky_ai_chat]' );
    }
}
