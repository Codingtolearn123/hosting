<?php
/**
 * Theme header template.
 */

declare(strict_types=1);

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div class="site">
    <header class="site-header">
        <div class="vs-container" style="padding: 1.25rem 0; display:flex; align-items:center; justify-content:space-between; gap:1.5rem;">
            <div class="site-branding">
                <a href="<?php echo esc_url(home_url('/')); ?>" class="vs-button" style="padding:0.65rem 1.25rem; font-size:1rem;">
                    <span style="font-weight:700; letter-spacing:0.04em;">VirtualSkyHost</span>
                </a>
                <span class="vs-badge">Next-Gen Cloud Hosting</span>
            </div>
            <button class="nav-toggle" data-toggle-nav>
                <span class="dashicons dashicons-menu"></span>
                <span class="screen-reader-text"><?php esc_html_e('Toggle navigation', 'virtualskyhost'); ?></span>
            </button>
            <?php
            wp_nav_menu([
                'theme_location' => 'primary',
                'container' => 'nav',
                'container_class' => 'site-navigation',
                'menu_class' => '',
                'fallback_cb' => '__return_false',
            ]);
            ?>
            <div style="display:flex; gap:1rem; align-items:center;">
                <a class="vs-button" href="<?php echo esc_url(virtualskyhost_get_clientarea_url()); ?>">
                    <?php esc_html_e('Client Login', 'virtualskyhost'); ?>
                </a>
            </div>
        </div>
    </header>
    <main class="site-content">
