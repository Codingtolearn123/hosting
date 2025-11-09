import { Router } from 'express';
import { fetchHostingPlans, fetchPlanCategories } from '../services/whmcs.js';

const router = Router();

router.get('/plans', async (req, res, next) => {
  try {
    const category = req.query.category || 'shared';
    const plans = await fetchHostingPlans(category);
    res.json(plans);
  } catch (error) {
    next(error);
  }
});

router.get('/categories', async (req, res, next) => {
  try {
    const categories = await fetchPlanCategories();
    res.json(categories);
  } catch (error) {
    next(error);
  }
});

export default router;
