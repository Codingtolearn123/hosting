<?php
/**
 * Helper utilities for VirtualSkyWP.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Retrieve a placeholder WHMCS link for a CTA button.
 *
 * @param string $target Identifier for the WHMCS product group.
 *
 * @return string
 */
function virtualskywp_get_whmcs_placeholder_url( $target ) {
    return '#';
}

/**
 * Render CTA buttons with consistent data attributes.
 *
 * @param array $buttons Array of button definitions.
 */
function virtualskywp_render_cta_buttons( array $buttons ) {
    if ( empty( $buttons ) ) {
        return;
    }

    echo '<div class="virtualskywp-cta-group">';
    foreach ( $buttons as $button ) {
        $label   = isset( $button['label'] ) ? esc_html( $button['label'] ) : '';
        $target  = isset( $button['target'] ) ? esc_attr( $button['target'] ) : 'web-hosting';
        $variant = isset( $button['variant'] ) ? esc_attr( $button['variant'] ) : 'primary';

        printf(
            '<a class="button-gradient button-%1$s" href="%2$s" data-whmcs-target="%3$s">%4$s</a>',
            $variant,
            esc_url( virtualskywp_get_whmcs_placeholder_url( $target ) ),
            $target,
            $label
        );
    }
    echo '</div>';
}
