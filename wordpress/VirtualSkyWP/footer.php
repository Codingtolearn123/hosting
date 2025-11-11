<?php
/**
 * Footer template.
 */
?>
</main>
<footer class="site-footer">
    <div class="container" style="max-width:1200px;margin:0 auto;padding:0 2rem;">
        <div class="footer-grid">
            <div>
                <h4><?php esc_html_e( 'Virtual Sky', 'virtualskywp' ); ?></h4>
                <p><?php esc_html_e( 'Your future in the cloud, powered by AI and lightning fast infrastructure.', 'virtualskywp' ); ?></p>
            </div>
            <div>
                <h4><?php esc_html_e( 'Hosting', 'virtualskywp' ); ?></h4>
                <ul>
                    <li><a href="#" data-whmcs-target="web-hosting"><?php esc_html_e( 'Web Hosting', 'virtualskywp' ); ?></a></li>
                    <li><a href="#" data-whmcs-target="reseller-hosting"><?php esc_html_e( 'Reseller Hosting', 'virtualskywp' ); ?></a></li>
                    <li><a href="#" data-whmcs-target="vps-cloud"><?php esc_html_e( 'VPS & Cloud', 'virtualskywp' ); ?></a></li>
                    <li><a href="#" data-whmcs-target="ai-agent-builder"><?php esc_html_e( 'AI Agent Builder', 'virtualskywp' ); ?></a></li>
                </ul>
            </div>
            <div>
                <h4><?php esc_html_e( 'Company', 'virtualskywp' ); ?></h4>
                <?php
                wp_nav_menu(
                    array(
                        'theme_location' => 'footer',
                        'menu_class'     => '',
                        'container'      => false,
                        'items_wrap'     => '<ul>%3$s</ul>',
                        'fallback_cb'    => '__return_false',
                    )
                );
                ?>
            </div>
            <div>
                <h4><?php esc_html_e( 'Support', 'virtualskywp' ); ?></h4>
                <ul>
                    <li><a href="mailto:support@virtualsky.io">support@virtualsky.io</a></li>
                    <li><a href="tel:+18881234567">+1 (888) 123-4567</a></li>
                    <li><a href="#" data-whmcs-target="support"><?php esc_html_e( 'Submit Ticket', 'virtualskywp' ); ?></a></li>
                </ul>
            </div>
        </div>
        <small>&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> Virtual Sky. <?php esc_html_e( 'All rights reserved.', 'virtualskywp' ); ?></small>
    </div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
