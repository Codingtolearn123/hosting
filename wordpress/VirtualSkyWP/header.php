<?php
/**
 * Header template.
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<header class="site-header">
    <div class="container" style="max-width:1200px;margin:0 auto;padding:1rem 2rem;display:flex;align-items:center;justify-content:space-between;">
        <a class="brand" href="<?php echo esc_url( home_url( '/' ) ); ?>">
            <span class="brand-logo">VS</span>
            <span class="brand-title"><?php bloginfo( 'name' ); ?></span>
        </a>
        <nav aria-label="<?php esc_attr_e( 'Primary menu', 'virtualskywp' ); ?>">
            <?php
            wp_nav_menu(
                array(
                    'theme_location' => 'primary',
                    'menu_class'     => '',
                    'container'      => false,
                    'items_wrap'     => '<ul>%3$s</ul>',
                    'fallback_cb'    => '__return_false',
                )
            );
            ?>
        </nav>
        <div class="header-cta">
            <a class="button-gradient" href="#" data-whmcs-target="client-area"><?php esc_html_e( 'Client Login', 'virtualskywp' ); ?></a>
        </div>
    </div>
</header>
<main class="main-content">
