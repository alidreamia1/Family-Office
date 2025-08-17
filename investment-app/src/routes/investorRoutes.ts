import { Router } from 'express';
import { authRequired, requireRole } from '../middleware/auth';
import { upload } from '../config/upload';
import { createInvestor, deleteInvestor, getInvestor, listInvestors, updateInvestor } from '../controllers/investorController';

const router = Router();

router.use(authRequired);

router.get('/', requireRole(['ADMIN']), listInvestors);
router.get('/:id', requireRole(['ADMIN', 'INVESTOR']), getInvestor);
router.post('/', requireRole(['ADMIN']), upload.fields([{ name: 'photoSelfie', maxCount: 1 }, { name: 'photoKtp', maxCount: 1 }, { name: 'photoBankbook', maxCount: 1 }]), createInvestor);
router.put('/:id', requireRole(['ADMIN']), upload.fields([{ name: 'photoSelfie', maxCount: 1 }, { name: 'photoKtp', maxCount: 1 }, { name: 'photoBankbook', maxCount: 1 }]), updateInvestor);
router.delete('/:id', requireRole(['ADMIN']), deleteInvestor);

export default router;