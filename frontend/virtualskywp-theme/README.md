# VirtualSkyWP WordPress Theme

A futuristic, Hostinger-inspired WordPress theme crafted for the **Virtual Sky** platform. It pairs Tailwind-powered layouts, cinematic hero sections, and deep WHMCS integration with editable Custom Post Types for plans, testimonials, FAQs, and hero media.

## Highlights

- Glassmorphic hero with looping video background and CTA buttons wired to WHMCS.
- Custom Post Types: `hosting_plan`, `ai_tool`, `testimonial`, `faq`, and `hero_slide` plus taxonomy support for plan categories.
- Theme Options panel (Appearance → Virtual Sky Options) controlling hero copy, video, colors, WHMCS URLs, $1 promotion toggles, chat widget, and API keys.
- Gutenberg block pattern for the hero and Tailwind editor styles for consistent typography.
- Animated pricing tables with $1 first-month badge logic and n8n webhook hints for VPS plans.
- Dark/light mode toggle, sticky header, floating AI assistant teaser, and FAQ accordions.

## Development

- Tailwind is loaded via CDN and layered with custom CSS in `style.css` for gradients/animations.
- JavaScript lives in `assets/js/theme.js` for navigation, accordions, testimonials, pricing toggles, and the floating chat widget shell.
- Template helpers inside `inc/template-tags.php` supply formatted data to templates and shortcodes.
- Custom post meta fields are managed via meta boxes in `inc/meta-boxes.php`.

## Customization

1. Install the theme like any other WordPress theme and activate it.
2. Visit **Appearance → Virtual Sky Options** to configure hero content, WHMCS URLs, builder endpoints, and automation toggles.
3. Populate Hosting Plans, AI Tools, Testimonials, FAQs, and Hero Slides from the WordPress admin menu.
4. Assign provided templates to product pages (`/web-hosting`, `/wordpress-hosting`, `/reseller-hosting`, `/vps-hosting`, `/ai-hosting`, `/website-builder`, `/ai-tools`, `/ai-agent-builder`).
5. Use the **VirtualSky AI Builder** plugin for the AI Agent post type and admin experience.

## Integrations

- **WHMCS:** Buttons redirect to URLs configured in the options panel, and plan-specific links can be stored per plan entry.
- **n8n:** VPS plans include a webhook meta field surfaced in templates for automation callouts.
- **AI Builder:** Options provide the hosted builder URL and API keys, enabling future deep integrations.

For full setup instructions (WHMCS theming, n8n, packaging zips), see `docs/virtualsky-setup.md`.
