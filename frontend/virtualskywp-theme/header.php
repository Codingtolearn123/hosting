<?php
/**
 * Theme header template.
 */

declare(strict_types=1);

$options = virtualskywp_get_theme_options();
$whmcs_login = virtualskywp_get_option('whmcs_login_url');
$free_domain = virtualskywp_get_option('free_domain_banner');
$dark_mode_enabled = (bool) virtualskywp_get_option('enable_dark_mode', true);
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> data-theme="<?php echo $dark_mode_enabled ? 'dark' : 'light'; ?>">
<head>
    <meta charset="<?php bloginfo('charset'); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <?php wp_head(); ?>
</head>
<body <?php body_class('bg-slate-950 text-slate-100'); ?>>
<?php wp_body_open(); ?>
<div class="site min-h-screen flex flex-col">
    <?php if (!empty($free_domain)) : ?>
        <div class="w-full text-center text-sm py-2 bg-gradient-to-r from-indigo-500/80 via-fuchsia-500/60 to-pink-500/80 text-white backdrop-blur border-b border-white/10">
            <span class="font-semibold tracking-wide uppercase"><?php echo esc_html($free_domain); ?></span>
        </div>
    <?php endif; ?>
    <header class="sticky top-0 z-50 backdrop-blur-xl bg-slate-950/70 border-b border-white/10">
        <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between gap-6">
            <a href="<?php echo esc_url(home_url('/')); ?>" class="flex items-center gap-3 text-white">
                <span class="h-12 w-12 rounded-2xl bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500 flex items-center justify-center shadow-lg shadow-indigo-500/40">
                    <span class="text-xl font-bold">VS</span>
                </span>
                <span class="text-left">
                    <span class="block text-lg font-semibold tracking-wide">Virtual Sky</span>
                    <span class="block text-xs uppercase tracking-[0.4em] text-indigo-200/90">AI Cloud Hosting</span>
                </span>
            </a>
            <button class="lg:hidden inline-flex items-center justify-center rounded-full border border-white/20 bg-white/5 px-4 py-2 text-sm font-medium" data-toggle-nav>
                <span class="dashicons dashicons-menu"></span>
                <span class="sr-only"><?php esc_html_e('Toggle navigation', 'virtualskywp'); ?></span>
            </button>
            <?php
            wp_nav_menu([
                'theme_location' => 'primary',
                'container' => 'nav',
                'container_class' => 'hidden lg:flex items-center gap-8 text-sm font-medium',
                'menu_class' => 'flex items-center gap-8',
                'fallback_cb' => '__return_false',
            ]);
            ?>
            <div class="hidden lg:flex items-center gap-3">
                <?php if ($whmcs_login) : ?>
                    <a href="<?php echo esc_url($whmcs_login); ?>" class="px-4 py-2 rounded-full border border-white/20 bg-white/5 hover:bg-white/10 transition">
                        <?php esc_html_e('Client Login', 'virtualskywp'); ?>
                    </a>
                <?php endif; ?>
                <button type="button" class="px-4 py-2 rounded-full border border-white/10 bg-gradient-to-r from-indigo-500 to-pink-500 shadow-lg shadow-indigo-500/40 text-white" data-theme-toggle>
                    <?php esc_html_e('Toggle Mode', 'virtualskywp'); ?>
                </button>
            </div>
        </div>
        <nav class="virtualskywp-mobile-nav hidden lg:hidden flex-col gap-4 px-6 pb-6" data-mobile-nav>
            <?php
            wp_nav_menu([
                'theme_location' => 'primary',
                'container' => false,
                'menu_class' => 'flex flex-col gap-4 text-base',
                'fallback_cb' => '__return_false',
            ]);
            ?>
            <?php if ($whmcs_login) : ?>
                <a href="<?php echo esc_url($whmcs_login); ?>" class="px-4 py-3 rounded-2xl border border-white/20 bg-white/5 text-center">
                    <?php esc_html_e('Client Login', 'virtualskywp'); ?>
                </a>
            <?php endif; ?>
            <button type="button" class="px-4 py-3 rounded-2xl border border-white/10 bg-gradient-to-r from-indigo-500 to-pink-500 text-white" data-theme-toggle>
                <?php esc_html_e('Toggle Mode', 'virtualskywp'); ?>
            </button>
        </nav>
    </header>
    <main class="flex-1">
