# VirtualSkyHost WHMCS Theme

A Tailwind-powered WHMCS template that mirrors the VirtualSkyWP WordPress theme with glassmorphic styling and AI-forward branding.

## Structure

- `templates/virtualskyhost/` — Core Smarty templates (`header.tpl`, `footer.tpl`, `clientarea.tpl`, `cart.tpl`).
- `templates/virtualskyhost/css/virtualsky.css` — Supplemental CSS layered on top of Tailwind CDN classes.
- `includes/hooks/virtualsky_hooks.php` — Adds dark-mode enforcement, AI badge footer, and primary navigation links.

## Installation

1. Copy the `virtualsky-whmcs-theme` directory to your WHMCS installation (e.g., `whmcs/templates/virtualskyhost`).
2. Upload `includes/hooks/virtualsky_hooks.php` to the WHMCS `/includes/hooks/` directory.
3. In WHMCS admin, navigate to **Setup → General Settings → General** and select **VirtualSkyHost** as the default template.
4. Ensure the Tailwind CDN is accessible from your deployment environment.

## Customisation Tips

- Update navigation URIs in `header.tpl` to align with your WHMCS store routes.
- Adjust gradient colors or typography inside `css/virtualsky.css` to match any brand tweaks.
- Extend `virtualsky_hooks.php` to surface additional automation badges or announcements.
