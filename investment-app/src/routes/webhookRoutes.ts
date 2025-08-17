import { Router } from 'express';

const router = Router();

router.post('/subscriptions', (req, res) => res.status(501).json({ message: 'Not implemented' }));
router.delete('/subscriptions/:id', (req, res) => res.status(501).json({ message: 'Not implemented' }));

export default router;