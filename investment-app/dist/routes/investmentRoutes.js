"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
const express_1 = require("express");
const router = (0, express_1.Router)();
router.post('/deposit', (req, res) => res.status(501).json({ message: 'Not implemented' }));
router.post('/withdraw', (req, res) => res.status(501).json({ message: 'Not implemented' }));
router.get('/transactions/:investorId', (req, res) => res.status(501).json({ message: 'Not implemented' }));
exports.default = router;
//# sourceMappingURL=investmentRoutes.js.map