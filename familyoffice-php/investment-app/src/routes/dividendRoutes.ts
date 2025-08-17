import { Router } from 'express';

const router = Router();

router.post('/periods', (req, res) => res.status(501).json({ message: 'Not implemented' }));
router.post('/periods/:periodId/distribute', (req, res) => res.status(501).json({ message: 'Not implemented' }));
router.get('/periods/:periodId/payouts', (req, res) => res.status(501).json({ message: 'Not implemented' }));
router.get('/payouts/:investorId/export/pdf', (req, res) => res.status(501).json({ message: 'Not implemented' }));
router.get('/payouts/:investorId/export/excel', (req, res) => res.status(501).json({ message: 'Not implemented' }));

export default router;