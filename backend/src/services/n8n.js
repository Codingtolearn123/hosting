import { http } from '../utils/http.js';

const WORKFLOW_MAP = {
  onboarding: process.env.N8N_WEBHOOK_URL,
  'post-purchase': process.env.N8N_WEBHOOK_URL,
};

export async function triggerWorkflow(workflow, payload = {}) {
  const url = WORKFLOW_MAP[workflow];

  if (!url) {
    return { skipped: true };
  }

  const { data } = await http.post(url, payload);
  return data;
}
