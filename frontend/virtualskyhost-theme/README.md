# VirtualSkyHost WordPress Theme

A Hostinger-inspired WordPress theme tailored for the VirtualSkyHost brand. It ships with gradient/glassmorphism styling, live WHMCS pricing hooks, responsive navigation, and reusable hosting templates.

## Key Features

- Hero, pricing, testimonials, FAQ, and CTA sections optimized for hosting conversions.
- Domain search form wired to the backend `/api/domain/search` endpoint or WHMCS plugin REST routes.
- Hosting category templates (`Shared`, `WordPress`, `VPS`, `Dedicated`) that auto-fetch plan data.
- Sticky navigation with mobile toggle and call-to-action buttons pointing at WHMCS order links.

## Usage

1. Install the VirtualSkyHost WHMCS Bridge plugin for live pricing.
2. Set environment variables (via `wp-config.php` or server) to customize API endpoints:
   - `API_BASE_URL`
   - `ORDER_BASE_URL`
   - `CLIENTAREA_URL`
3. Create pages for each hosting product and assign the corresponding template.
4. Customize copy using the WordPress editor or Elementor/Gutenberg blocks.

## Development

- CSS lives in `style.css` and uses CSS custom properties—no build step required.
- JavaScript lives in `assets/js/theme.js` and powers pricing hydration, domain search toast notifications, and mobile nav.
- Update the `functions.php` localization data if backend endpoints change.
