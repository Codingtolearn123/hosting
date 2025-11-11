# VirtualSkyWP WordPress Theme

A futuristic, Hostinger-inspired WordPress theme crafted for the **Virtual Sky** platform. It pairs Tailwind-powered layouts, cinematic hero sections, and live WHMCS pricing sync with editable Custom Post Types for testimonials, FAQs, hero media, and AI tooling.

## Highlights

- Glassmorphic hero with looping video background and CTA buttons wired to WHMCS.
- Theme Options panel (Appearance → Virtual Sky Options) controlling hero copy, video, colors, WHMCS URLs, WHMCS API credentials, $1 promotion toggles, chat widget, and automation keys.
- WHMCS-driven pricing tables: plan names, badges, promo prices, feature bullets, and n8n webhook URLs are read from WHMCS product custom fields so billing edits happen in one place.
- Custom Post Types: `ai_tool`, `testimonial`, `faq`, and `hero_slide` keep marketing content editable without touching pricing.
- Gutenberg block pattern for the hero and Tailwind editor styles for consistent typography.
- Dark/light mode toggle, sticky header, floating AI assistant teaser, and FAQ accordions.

## Development

- Tailwind is loaded via CDN and layered with custom CSS in `style.css` for gradients/animations.
- JavaScript lives in `assets/js/theme.js` for navigation, accordions, testimonials, pricing toggles, and the floating chat widget shell.
- WHMCS API helpers inside `inc/whmcs.php` normalize product payloads (prices, promo badges, feature bullets, automation hooks) for PHP templates and React hydration.
- Template helpers inside `inc/template-tags.php` supply formatted data for AI tools, testimonials, FAQs, and hero slides.
- Custom post meta fields are managed via meta boxes in `inc/meta-boxes.php`.

## Customization

1. Install the theme like any other WordPress theme and activate it.
2. Visit **Appearance → Virtual Sky Options** to configure hero content, WHMCS URLs, builder endpoints, automation toggles, and the new WHMCS API credentials + product group IDs.
3. In WHMCS, populate the product groups referenced above. Custom fields named `Promo Price`, `Badge`, `Features`, `Free Domain`, `AI Ready`, and `n8n Webhook` automatically flow into the theme. Pricing edits should remain in WHMCS.
4. Populate AI Tools, Testimonials, FAQs, and Hero Slides from the WordPress admin menu.
5. Assign provided templates to product pages (`/web-hosting`, `/wordpress-hosting`, `/reseller-hosting`, `/vps-hosting`, `/ai-hosting`, `/website-builder`, `/ai-tools`, `/ai-agent-builder`).
6. Use the **VirtualSky AI Builder** plugin for the AI Agent post type, including the new API settings submenu for OpenAI-compatible keys.

## Integrations

- **WHMCS:** All pricing data, promo badges, plan highlights, and automation flags are read from WHMCS via its API. Update the product group IDs and credentials in the options panel to sync the front end.
- **n8n:** VPS products can expose an `n8n Webhook` custom field in WHMCS; when present it is surfaced in plan cards as an automation hint.
- **AI Builder:** Options provide the hosted builder URL and API keys. The companion plugin now stores OpenAI-compatible credentials in a dedicated settings page and surfaces their status in the agent composer.

For full setup instructions (WHMCS theming, n8n, packaging zips), see `docs/virtualsky-setup.md`.
