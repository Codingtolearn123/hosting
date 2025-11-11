# Virtual Sky Hosting Platform

Virtual Sky is an AI-powered hosting stack combining a cinematic WordPress marketing site, WHMCS billing experience, automation workflows, and an AI agent builder.

## Repository Structure

- `frontend/`
  - `virtualskywp-theme/` – WordPress theme (VirtualSkyWP) with Tailwind styling, WHMCS redirects, custom post types, and AI-driven sections.
  - `plugins/virtualsky-ai-builder/` – WordPress plugin that powers the AI Agent Builder admin app and shortcodes.
  - `virtualsky-whmcs-theme/` – Tailwind-themed WHMCS template mirroring the WordPress UI.
  - `plugins/virtualskyhost-whmcs-bridge/` – Legacy bridge plugin kept for reference.
- `backend/` – Node.js service used for WHMCS proxies, domain search, and provisioning automation.
- `automation/` – Sample n8n workflows for onboarding, migrations, and marketing.
- `docs/` – Deployment notes, including `virtualsky-setup.md` for packaging and integration.

## WordPress Frontend

1. Zip and upload `frontend/virtualskywp-theme` as **VirtualSkyWP**.
2. Activate the theme and configure **Appearance → Virtual Sky Options**:
   - Hero copy, hero video URL, and CTA buttons.
   - WHMCS cart/login URLs, builder endpoint, automation toggles, and API keys.
   - `$1` promotion, floating chat widget, and color palette.
3. Populate Custom Post Types: Hosting Plans (with taxonomy slugs), AI Tools, Testimonials, FAQs, Hero Slides.
4. Install the **VirtualSky AI Builder** plugin to manage AI agents and embed shortcodes.
5. Assign templates to key landing pages (`/web-hosting`, `/wordpress-hosting`, `/reseller-hosting`, `/vps-hosting`, `/ai-hosting`, `/website-builder`, `/ai-tools`, `/ai-agent-builder`).

## WHMCS Theme

1. Copy `frontend/virtualsky-whmcs-theme/templates/virtualskyhost` into your WHMCS `templates/` directory.
2. Upload `frontend/virtualsky-whmcs-theme/includes/hooks/virtualsky_hooks.php` into WHMCS `/includes/hooks/`.
3. Choose **VirtualSkyHost** as the active template in WHMCS settings.
4. Tailor navigation URLs and checkout CTA links to match your WHMCS store.

## Automation & Integrations

- Use n8n workflows from `automation/` to trigger provisioning or onboarding sequences after WHMCS purchases.
- Store per-plan n8n webhook URLs and WHMCS product links via the Hosting Plan meta boxes.
- Expose backend endpoints (domain search, pricing) if you need real-time API data instead of manual plan entries.

## Documentation

See `docs/virtualsky-setup.md` for packaging instructions, WHMCS integration notes, and API configuration guidance.

## Development Notes

- Tailwind CSS is loaded via CDN; additional animations live in `style.css`.
- JavaScript enhancements reside in `frontend/virtualskywp-theme/assets/js/theme.js`.
- WordPress and WHMCS assets require no build step—zip the directories directly for deployment.

## License

Released under the MIT License. Customize and extend the platform for your Virtual Sky hosting business.
