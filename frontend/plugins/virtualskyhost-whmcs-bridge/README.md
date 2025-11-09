# VirtualSkyHost WHMCS Bridge

This WordPress plugin exposes REST endpoints, shortcodes, and admin settings that connect the VirtualSkyHost marketing site to WHMCS.

## Installation

1. Copy the plugin directory to `wp-content/plugins/virtualskyhost-whmcs-bridge`.
2. Activate it in the WordPress admin panel.
3. Navigate to **Settings → VirtualSkyHost WHMCS** and enter your WHMCS API URL, Identifier, and Secret.

## Features

- REST endpoints under `/wp-json/virtualskyhost/v1/*` for plans, domain search, and order creation.
- Shortcodes:
  - `[virtualskyhost_domain_search]`
  - `[virtualskyhost_pricing category="shared"]`
- Admin settings page with environment variable fallbacks.

The plugin can be used with the provided VirtualSkyHost theme or any custom theme that needs WHMCS pricing data.
