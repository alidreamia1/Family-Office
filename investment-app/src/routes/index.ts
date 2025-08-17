import { Router } from 'express';
import authRoutes from './authRoutes';
import investorRoutes from './investorRoutes';
import investmentRoutes from './investmentRoutes';
import dividendRoutes from './dividendRoutes';
import reportRoutes from './reportRoutes';
import adminRoutes from './adminRoutes';
import webhookRoutes from './webhookRoutes';

const router = Router();

router.use('/auth', authRoutes);
router.use('/investors', investorRoutes);
router.use('/investments', investmentRoutes);
router.use('/dividends', dividendRoutes);
router.use('/reports', reportRoutes);
router.use('/admin', adminRoutes);
router.use('/webhooks', webhookRoutes);

export default router;