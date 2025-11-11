# Virtual Sky Hosting Platform Setup

This guide explains how to assemble the WordPress theme, AI Builder plugin, and WHMCS theme into deployable ZIP archives and connect external services such as WHMCS and n8n.

## 1. Packaging Deliverables

| Deliverable | Source Directory | Packaging Command |
|-------------|------------------|-------------------|
| `virtualsky-wp-theme.zip` | `frontend/virtualskywp-theme` | `zip -r virtualsky-wp-theme.zip virtualskywp-theme` |
| `virtualsky-ai-builder.zip` | `frontend/plugins/virtualsky-ai-builder` | `zip -r virtualsky-ai-builder.zip virtualsky-ai-builder` |
| `virtualsky-whmcs-theme.zip` | `frontend/virtualsky-whmcs-theme` *(create from WHMCS templates below)* | `zip -r virtualsky-whmcs-theme.zip virtualsky-whmcs-theme` |

> Copy the resulting ZIP files into your WordPress/WHMCS installation or release artifact repository.

## 2. WordPress Theme Installation

1. From `wp-admin`, navigate to **Appearance → Themes → Add New → Upload Theme** and upload `virtualsky-wp-theme.zip`.
2. Activate the theme and follow the onboarding prompts.
3. Go to **Appearance → Virtual Sky Options** and configure:
   - Hero headline, subheading, and video URL.
   - WHMCS cart and client URLs.
   - Builder endpoint (`builder.virtualsky.io`) and AI/n8n API keys.
   - WHMCS API endpoint + credentials, default currency, and product group IDs (shared/WordPress/reseller/VPS/AI) so pricing syncs from WHMCS.
   - Toggle the `$1` promotion banner or floating chat widget.
4. Populate the following Custom Post Types:
   - **AI Tools**, **Testimonials**, **FAQs**, **Hero Slides**.
5. Create pages using the supplied templates:
   - `/web-hosting` → *Shared Hosting*
   - `/wordpress-hosting` → *WordPress Hosting*
   - `/reseller-hosting` → *Reseller Hosting*
   - `/vps-hosting` → *VPS Hosting*
   - `/ai-hosting` → *AI Hosting*
   - `/website-builder`, `/ai-tools`, `/ai-agent-builder`

## 3. VirtualSky AI Builder Plugin

1. Upload `virtualsky-ai-builder.zip` under **Plugins → Add New → Upload Plugin** and activate it.
2. The plugin registers a custom post type (`virtualsky_agent`) and adds **AI Agent Builder** to the admin menu along with an **API Settings** submenu.
3. Open **AI Agent Builder → API Settings** and store your OpenAI-compatible provider, base URL, default model, and API key. The builder UI surfaces connection status but never exposes the raw key publicly.
4. Create agents with goal, tone, model, and prompts; copy the generated shortcode `[virtualskywp_agent id="123"]` into Gutenberg blocks or templates.
5. Use `[virtualskywp_agent_preview]` for live previews on the AI Agent Builder landing page.

## 4. WHMCS Theme (VirtualSkyHost)

1. Duplicate WHMCS six template into `frontend/virtualsky-whmcs-theme/` and update:
   - `templates/virtualskyhost/cart.tpl` for the one-page checkout with gradient banner.
   - `header.tpl`, `footer.tpl`, and `clientarea.tpl` to mirror the WordPress navigation/footer.
   - Include Tailwind CDN in `head.tpl` and ensure dark mode classes align with the WordPress palette.
2. Add `/includes/hooks/virtualsky_hooks.php` to append branded footer notices, enforce dark mode, and display an “AI Powered” badge on service tables.
3. Compress the folder into `virtualsky-whmcs-theme.zip` and upload to WHMCS under **Setup → General Settings → General → Template**.
4. Configure product group friendly URLs to match the WordPress plan buttons (e.g., `/index.php?rp=/store/shared-hosting`).

## 5. n8n Automation

1. Create workflow webhooks in n8n for each VPS or automation-enabled plan.
2. In WHMCS, add a product custom field titled `n8n Webhook` (or `Automation Webhook`) and paste the webhook URL. The theme reads and displays it automatically.
3. In WHMCS, configure the product’s “Module Settings” or “After Module Create” hooks to call the webhook with order details.
4. Use the stored API key from **Virtual Sky Options** to authenticate requests (e.g., `x-virtualsky-key` header).

## 6. Hero Video & Media

- Upload the MP4/WebM hero asset under **Media → Add New**.
- Paste the URL into the Theme Options hero video field.
- Additional hero imagery can be stored as `Hero Slides` for the front-page avatar reel.

## 7. Pricing & $1 Offer Logic

- Pricing now flows exclusively from WHMCS. Populate `Monthly`, `Annually`, and promo overrides inside the WHMCS product pricing UI.
- Optional custom fields recognised by the theme:
  - `Promo Price` or `First Month Price`
  - `Badge` / `Badge Text`
  - `Free Domain` (`yes`/`no`)
  - `AI Ready` (`yes`/`no`)
  - `Features` (one item per line)
  - `n8n Webhook`
- Enabling the `$1 First Month` toggle in Theme Options applies marketing copy when a promo price is returned.
- For billing, create a WHMCS promotion or first-invoice override instead of editing WordPress content.

## 8. Floating Chat / Future Integrations

- The theme ships with a placeholder floating chat widget toggled via Theme Options.
- Replace the placeholder with a production chat or agent iframe by editing `assets/js/theme.js` (look for `injectChatWidget`).

---

Need more? Review the inline documentation across theme and plugin files, or connect the WHMCS hook scaffolding to your automation stack.
