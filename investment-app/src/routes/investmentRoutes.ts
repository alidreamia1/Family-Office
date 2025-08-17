import { Router } from 'express';
import { authRequired, requireRole } from '../middleware/auth';
import { deposit, listTransactions, withdraw } from '../controllers/investmentController';

const router = Router();

router.use(authRequired);
router.post('/deposit', requireRole(['ADMIN']), deposit);
router.post('/withdraw', requireRole(['ADMIN']), withdraw);
router.get('/transactions/:investorId', requireRole(['ADMIN', 'INVESTOR']), listTransactions);

export default router;