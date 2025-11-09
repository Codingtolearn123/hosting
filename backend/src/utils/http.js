import axios from 'axios';

export const http = axios.create({
  timeout: 15000,
});

export function basicAuth(username, password) {
  return {
    auth: {
      username,
      password,
    },
  };
}
