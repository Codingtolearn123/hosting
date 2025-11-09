# VirtualSkyHost Automation Workflows

This directory contains example n8n workflow exports that demonstrate how VirtualSkyHost orchestrates AI onboarding and marketing automation.

## Workflows

- `onboarding-workflow.json` – Webhook-triggered workflow that generates a welcome email with OpenAI/Claude and sends it via SMTP.
- `marketing-automation.json` – Scheduled workflow that syncs WHMCS leads, segments high-intent customers, and publishes retargeting audiences to Facebook Ads.

## Usage

1. Navigate to your n8n instance and select **Import from File**.
2. Upload the JSON file and update credentials:
   - OpenAI/Anthropic API keys for AI messages.
   - SMTP credentials for transactional email.
   - Facebook/Meta marketing API tokens.
3. Update webhook URLs to match the deployment (for example, `https://automation.virtualskyhost.com/webhook/virtualskyhost/onboarding`).

These workflows are starting points—extend them with CRM integrations, Slack alerts, or Plesk provisioning hooks to match your business processes.
