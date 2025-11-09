# VirtualSkyHost Platform

VirtualSkyHost is a Hostinger-inspired hosting platform that pairs a WordPress marketing frontend with WHMCS-powered billing, a Node.js automation bridge, and n8n workflows for AI-driven onboarding and marketing.

## Repository Structure

- `frontend/`
  - `virtualskyhost-theme/` – WordPress theme providing the VirtualSkyHost marketing site with dynamic pricing, domain search, and responsive design.
  - `plugins/virtualskyhost-whmcs-bridge/` – WordPress plugin that exposes REST endpoints, shortcodes, and admin settings for WHMCS integration.
- `backend/` – Node.js (Express) service that proxies WHMCS, provisions Plesk accounts, and triggers n8n workflows.
- `automation/` – Example n8n workflow JSON exports for onboarding and marketing automation.
- `docs/` – Deployment and integration guide for WordPress, WHMCS, Plesk, and n8n.

## Frontend (WordPress)

1. Copy `frontend/virtualskyhost-theme` into your WordPress `wp-content/themes/` directory and activate it.
2. Install the accompanying plugin from `frontend/plugins/virtualskyhost-whmcs-bridge` for WHMCS API access.
3. Configure API credentials under **Settings → VirtualSkyHost WHMCS** and set up pages for each hosting category (Shared, WordPress, VPS, Dedicated).
4. The theme automatically pulls pricing from WHMCS via the plugin or backend API and wires domain search requests to `/api/domain/search`.

## Backend (Node.js)

1. Copy `backend/.env.example` to `.env` and populate WHMCS, Plesk, and n8n credentials.
2. Install dependencies and start the service:

   ```bash
   cd backend
   npm install
   npm run dev
   ```

3. The service exposes:
   - `GET /api/hosting/plans?category=shared`
   - `POST /api/order/create`
   - `GET /api/domain/search?domain=example.com`

   Use a reverse proxy (Nginx, Plesk) to publish the API under `https://api.virtualskyhost.com` and update WordPress environment variables accordingly.

## Automation (n8n)

Import the JSON files in `automation/workflows/` into your n8n instance. Update webhook URLs, SMTP, and AI provider credentials to match your environment.

## Documentation

Detailed setup instructions live in `docs/SETUP.md`, covering DNS, SSL, deployment, and integration steps between WordPress, WHMCS, Plesk, and n8n.

## Development Notes

- WordPress theme assets are plain CSS/JS—no build step required.
- Backend uses ES modules and includes an ESLint config (`npm run lint`).
- Environment variables can be shared between WordPress and the backend to ensure consistent endpoint URLs and order links.
- Buttons throughout the frontend target WHMCS order URLs like `https://billing.virtualskyhost.com/cart.php?a=add&pid=ID`.

## License

All code is released under the MIT license. Customize and extend the platform to fit your hosting business needs.
