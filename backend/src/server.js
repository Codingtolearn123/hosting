import express from 'express';
import morgan from 'morgan';
import dotenv from 'dotenv';

import hostingRoutes from './routes/hosting.js';
import domainRoutes from './routes/domain.js';
import orderRoutes from './routes/order.js';

dotenv.config();

const app = express();
app.use(express.json());
app.use(morgan('dev'));

app.get('/api/health', (req, res) => {
  res.json({ status: 'ok', service: 'virtualskyhost-backend' });
});

app.use('/api/hosting', hostingRoutes);
app.use('/api/domain', domainRoutes);
app.use('/api/order', orderRoutes);

const port = process.env.PORT || 4000;

// eslint-disable-next-line no-unused-vars
app.use((error, req, res, next) => {
  const status = error.response?.status || 500;
  const message = error.message || 'Unexpected error';
  res.status(status).json({ message });
});

app.listen(port, () => {
  // eslint-disable-next-line no-console
  console.log(`VirtualSkyHost backend listening on port ${port}`);
});
