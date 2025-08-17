import { Router } from 'express';

const router = Router();

router.get('/dashboard', (req, res) => res.status(501).json({ message: 'Not implemented' }));
router.put('/profile', (req, res) => res.status(501).json({ message: 'Not implemented' }));
router.get('/settings', (req, res) => res.status(501).json({ message: 'Not implemented' }));
router.put('/settings', (req, res) => res.status(501).json({ message: 'Not implemented' }));

export default router;