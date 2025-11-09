# VirtualSky AI Builder

A WordPress plugin that ships with the VirtualSkyWP theme to create, manage, and embed AI agents inside marketing pages.

## Features

- Registers an **AI Agents** custom post type stored as `virtualsky_agent`.
- Provides an interactive admin builder (Tools → AI Agent Builder) for creating agents with name, model, tone, goal, and prompt.
- Adds REST endpoints under `virtualsky/v1/agents` for future integrations.
- Supplies shortcodes:
  - `[virtualskywp_agent id="123"]` renders a chat-ready agent widget.
  - `[virtualskywp_agent_preview]` outputs the most recent agent, ideal for preview blocks.
- Ships with glassmorphic styling that matches the Virtual Sky brand.

## Usage

1. Install and activate the plugin alongside the **VirtualSkyWP** theme.
2. Navigate to **AI Agent Builder** in the WordPress admin sidebar.
3. Create agents and paste the generated shortcode into any Gutenberg block or template.
4. Configure API keys inside **Appearance → Virtual Sky Options** for production integrations.
