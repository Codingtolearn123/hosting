# Virtual Sky Theme System

This repository ships coordinated themes for WordPress (Elementor) and WHMCS that mirror Hostinger's modern aesthetic while keeping all commerce inside WHMCS.

## Contents

- `wordpress/VirtualSkyWP/` – WordPress theme
- `wordpress/virtualsky-ai-assistant/` – WordPress AI assistant plugin
- `whmcs/VirtualSky/` – WHMCS client theme
- `dist/` – Installable ZIP packages generated from the sources
- `scripts/package.sh` – Helper script to regenerate the ZIPs

## Installation

### WordPress

1. Log in to your WordPress admin dashboard.
2. Download and extract `dist/VirtualSky_WordPress.zip`. Inside you will find `VirtualSkyWP.zip`.
3. Navigate to **Appearance → Themes → Add New → Upload Theme** and upload `VirtualSkyWP.zip`, then activate the **VirtualSkyWP** theme.
4. From the extracted package, upload `virtualsky-ai-assistant.zip` via **Plugins → Add New → Upload Plugin**, then activate the **VirtualSky AI Assistant** plugin.
5. Visit **Settings → VirtualSky AI Assistant** to store your OpenAI API key or define `OPENAI_API_KEY` in `wp-config.php`. The saved option takes precedence.
6. Elementor templates for Home, Hosting, VPS, Reseller, AI Agent Builder, About, and Contact pages are imported automatically on theme activation. The pages are provisioned with Elementor content so editors can adjust them immediately.
7. Replace each CTA hyperlink by editing the Elementor button and updating the `data-whmcs-target` attribute or URL after your WHMCS products exist.

### WHMCS

1. Copy `dist/VirtualSky_WHMCS.zip` to your WHMCS installation server and extract it.
2. Move the bundled `templates/VirtualSky/` directory into your WHMCS installation so that `templates/VirtualSky/header.tpl` exists.
3. Copy `templates/VirtualSky/includes/hooks/virtualsky_hooks.php` into your WHMCS `includes/hooks/` directory if it is not already there after extraction.
4. In WHMCS admin, go to **Setup → General Settings → General** and choose **VirtualSky** as the client area template.
5. Store your OpenAI key via `Setup → General Settings → Other` with the setting name `VirtualSkyAIKey`, or define `VIRTUALSKY_OPENAI_API_KEY` in `configuration.php`. The key is used by the optional AI widget.
6. The sidebar navigation links are placeholders. Once your product groups exist, update the URLs in `templates/VirtualSky/header.tpl` (search for `data-whmcs-target`) or map them via WHMCS language overrides.

## Mapping WordPress CTAs to WHMCS

All WordPress buttons ship with `href="#"` and a descriptive `data-whmcs-target` attribute (e.g. `web-hosting`, `reseller-hosting`). After you create the corresponding product groups inside WHMCS, update each Elementor button to point to the correct WHMCS URL such as `/cart.php?gid=1`. A quick search in Elementor for `data-whmcs-target` reveals every CTA.

## Customisation Tips

- **Colors & Typography** – Adjust the CSS variables in `wordpress/VirtualSkyWP/assets/css/theme.css` and `whmcs/VirtualSky/assets/css/style.css` to tailor the gradient, accent, or typography system.
- **Elementor layouts** – Use Elementor to modify any section. Because every page is built with Elementor widgets, you can drag-and-drop new sections without editing PHP.
- **AI Assistant** – In WordPress the `[virtualsky_ai_chat]` shortcode and Elementor widget render the assistant. In WHMCS the floating widget posts to the server-side hook which proxies requests to OpenAI so the key never leaves the backend.
- **Packaging** – Run `scripts/package.sh` after editing theme or plugin files to rebuild fresh ZIPs into the `dist/` directory.

## Product Ownership

No product or pricing logic lives inside WordPress or the WHMCS theme. All orders and plan management remain inside WHMCS. Replace placeholder URLs once your Web Hosting, Reseller, VPS/Cloud, and AI Agent Builder packages are live.
