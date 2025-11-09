# VirtualSkyHost Backend Service

The VirtualSkyHost backend is an Express application that bridges the marketing frontend with WHMCS, Plesk, and n8n.

## Features

- Fetch hosting plans and categories directly from WHMCS via `/api/hosting/*`
- Perform domain availability lookups with `/api/domain/search`
- Create orders and trigger optional Plesk provisioning and n8n workflows via `/api/order/create`
- Centralize environment variables for WordPress, WHMCS, and automation services

## Getting Started

```bash
cp .env.example .env
npm install
npm run dev
```

Configure the `.env` file with the same WHMCS credentials used in WordPress. When running locally, update the WordPress theme/plugin environment variables to point to `http://localhost:4000`.

## Docker

To deploy with Docker, create a `Dockerfile` similar to:

```Dockerfile
FROM node:20-alpine
WORKDIR /app
COPY package*.json ./
RUN npm ci --only=production
COPY src ./src
CMD ["node", "src/server.js"]
```

Expose port 4000 and mount your `.env` file or provide environment variables via your orchestrator.

## Error Handling

Errors returned from WHMCS or upstream services bubble to the global error handler, ensuring JSON responses with an HTTP status code.

## Future Enhancements

- Add caching for WHMCS pricing responses
- Integrate cPanel provisioning in addition to Plesk
- Emit events to a message queue (RabbitMQ/Kafka) for advanced automation
