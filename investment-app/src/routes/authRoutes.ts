import { Router } from 'express';
import { authLimiter } from '../middleware/rateLimit';
import { handleValidation } from '../middleware/validate';
import { login, loginValidators, register, registerValidators, requestReset, requestResetValidators, verifyReset, verifyResetValidators } from '../controllers/authController';

const router = Router();

router.post('/register', authLimiter, registerValidators, handleValidation, register);
router.post('/login', authLimiter, loginValidators, handleValidation, login);
router.post('/request-reset', authLimiter, requestResetValidators, handleValidation, requestReset);
router.post('/verify-reset', authLimiter, verifyResetValidators, handleValidation, verifyReset);

export default router;