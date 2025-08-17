import { Router } from 'express';

const router = Router();

router.post('/deposit', (req, res) => res.status(501).json({ message: 'Not implemented' }));
router.post('/withdraw', (req, res) => res.status(501).json({ message: 'Not implemented' }));
router.get('/transactions/:investorId', (req, res) => res.status(501).json({ message: 'Not implemented' }));

export default router;