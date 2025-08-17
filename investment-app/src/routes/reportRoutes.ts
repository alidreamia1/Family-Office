import { Router } from 'express';

const router = Router();

router.get('/overview', (req, res) => res.status(501).json({ message: 'Not implemented' }));
router.get('/dividends', (req, res) => res.status(501).json({ message: 'Not implemented' }));
router.get('/export/csv', (req, res) => res.status(501).json({ message: 'Not implemented' }));
router.get('/export/excel', (req, res) => res.status(501).json({ message: 'Not implemented' }));
router.get('/export/pdf', (req, res) => res.status(501).json({ message: 'Not implemented' }));

export default router;