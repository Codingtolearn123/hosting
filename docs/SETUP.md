# VirtualSkyHost Platform Setup

This guide walks through installing the WordPress marketing frontend, connecting WHMCS for billing and automation, and deploying the Node.js integration service with Plesk/n8n support.

## 1. Prerequisites

- Ubuntu 22.04 LTS server (VPS or dedicated) with sudo access
- Docker Engine or Plesk Obsidian with SSH enabled
- Node.js 20+
- MySQL 8 (required by WHMCS)
- Registered domains for `virtualskyhost.com` and `billing.virtualskyhost.com`
- SSL certificates issued by Let’s Encrypt or your preferred CA

## 2. WordPress Frontend

1. Install WordPress on `virtualskyhost.com`.
2. Upload the theme located at `frontend/virtualskyhost-theme` to `wp-content/themes/` and activate it from **Appearance → Themes**.
3. Install and activate the **VirtualSkyHost WHMCS Bridge** plugin from `frontend/plugins/virtualskyhost-whmcs-bridge`.
4. Configure API credentials under **Settings → VirtualSkyHost WHMCS** using the WHMCS API Identifier and Secret.
5. Create pages and assign templates:
   - Home page → set as front page under **Settings → Reading**.
   - Create pages for Shared, WordPress, VPS, and Dedicated hosting using the provided templates.
   - Add About, Support, and Contact pages using the block editor.
6. Update menu locations (**Appearance → Menus**) for the primary and footer navigation.

## 3. WHMCS Configuration

1. Install WHMCS on `billing.virtualskyhost.com` with MySQL.
2. Enable the WHMCS API and generate Identifier/Secret (Setup → API Credentials).
3. Create product groups matching the categories used by the theme: `shared`, `wordpress`, `vps`, `dedicated`.
4. Enable the Domain Lookup provider (e.g., Namecheap, ResellerClub) under **Setup → Domain Registrars**.
5. Configure order links to use `https://billing.virtualskyhost.com/cart.php?a=add&pid=PRODUCT_ID` and ensure SSL is enabled.

## 4. Node.js Backend Service

The backend bridges WordPress, WHMCS, Plesk, and n8n.

```bash
cd backend
cp .env.example .env
npm install
npm run dev
```

Environment variables required:

- `WHMCS_URL`, `WHMCS_IDENTIFIER`, `WHMCS_SECRET`
- `WHMCS_ORDER_BASE_URL` to generate CTA links
- `PLESK_API_URL`, `PLESK_USERNAME`, `PLESK_PASSWORD`
- `CPANEL_API_URL`, `CPANEL_USERNAME`, `CPANEL_TOKEN` (optional future use)
- `N8N_WEBHOOK_URL` for automation triggers

Deploy the service with Docker or systemd. Reverse-proxy `/api/*` through Nginx or Plesk to `localhost:4000`.

## 5. Plesk Automation

1. Create an API user in Plesk (Tools & Settings → API & CLI → Remote API).
2. Grant permissions to manage customers, subscriptions, and SSL.
3. Provide the credentials via environment variables and ensure firewall access.
4. The `/api/order/create` endpoint accepts a `provisionPlesk` payload with `clientId`, `domain`, `planId`, `ipAddress`, `ftpLogin`, and `ftpPassword` to automatically spin up a subscription.

## 6. n8n Workflows

- Import the JSON workflows from `automation/workflows/` into your n8n instance.
- Update credentials for SMTP, OpenAI/Anthropic, and social ad accounts.
- Set webhook URLs to match the environment (e.g., `https://automation.virtualskyhost.com/webhook/virtualskyhost/onboarding`).

## 7. WordPress ↔️ WHMCS Sync

- The plugin exposes REST endpoints at `/wp-json/virtualskyhost/v1/*`.
- The theme consumes either the plugin or the Node backend for live pricing.
- Use WP-Cron or server cron to refresh cached pricing via `wp cron event run virtualskyhost_refresh_pricing` (custom event stub).

## 8. Deployment Checklist

- [ ] DNS records configured for WordPress, WHMCS, API, and n8n subdomains.
- [ ] HTTPS certificates issued and auto-renewed.
- [ ] WordPress + plugin environment variables set in `.env` or server config.
- [ ] Node backend running behind reverse proxy with health checks.
- [ ] WHMCS cron and automation tasks scheduled.
- [ ] Backups configured for MySQL and n8n workflows.

## 9. Additional Resources

- WHMCS API docs: <https://developers.whmcs.com/api/>
- Plesk XML API docs: <https://docs.plesk.com/en-US/obsidian/api-rpc/about-plesk-api.28709/>
- n8n workflows: <https://docs.n8n.io/> (import JSON files provided)
