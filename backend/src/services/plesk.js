import { http, basicAuth } from '../utils/http.js';

function pleskConfig() {
  const url = process.env.PLESK_API_URL;
  const username = process.env.PLESK_USERNAME;
  const password = process.env.PLESK_PASSWORD;

  if (!url || !username || !password) {
    throw new Error('Missing Plesk API credentials.');
  }

  return { url, username, password };
}

export async function provisionPleskAccount(options = {}) {
  const { url, username, password } = pleskConfig();
  const payload = {
    name: options.domain,
    hosting_type: 'vrt_hst',
    ip_address: options.ipAddress,
    ftp_login: options.ftpLogin,
    ftp_password: options.ftpPassword,
    plan: options.planId,
  };

  const { data } = await http.post(
    `${url}/clients/${options.clientId}/sites`,
    payload,
    {
      ...basicAuth(username, password),
      headers: { 'Content-Type': 'application/json' },
    }
  );

  return data;
}
