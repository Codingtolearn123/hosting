import { Router } from 'express';
import { searchDomain } from '../services/whmcs.js';

const router = Router();

router.get('/search', async (req, res, next) => {
  try {
    const domain = (req.query.domain || '').toString().trim();
    if (!domain) {
      res.status(400).json({ message: 'Domain parameter is required.' });
      return;
    }

    const result = await searchDomain(domain);
    res.json(result);
  } catch (error) {
    next(error);
  }
});

export default router;
