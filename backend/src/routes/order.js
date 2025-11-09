import { Router } from 'express';
import { createOrder } from '../services/whmcs.js';
import { provisionPleskAccount } from '../services/plesk.js';
import { triggerWorkflow } from '../services/n8n.js';

const router = Router();

router.post('/create', async (req, res, next) => {
  try {
    const orderPayload = req.body;
    const orderResult = await createOrder(orderPayload);

    if (!orderResult.success) {
      res.status(422).json(orderResult);
      return;
    }

    if (orderPayload.provisionPlesk) {
      await provisionPleskAccount(orderPayload.provisionPlesk);
    }

    await triggerWorkflow('post-purchase', {
      order: orderResult,
      customer: orderPayload.client,
    });

    res.json({
      message: 'Order created successfully.',
      order: orderResult,
    });
  } catch (error) {
    next(error);
  }
});

export default router;
