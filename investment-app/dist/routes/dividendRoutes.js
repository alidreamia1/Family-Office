"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
const express_1 = require("express");
const router = (0, express_1.Router)();
router.post('/periods', (req, res) => res.status(501).json({ message: 'Not implemented' }));
router.post('/periods/:periodId/distribute', (req, res) => res.status(501).json({ message: 'Not implemented' }));
router.get('/periods/:periodId/payouts', (req, res) => res.status(501).json({ message: 'Not implemented' }));
router.get('/payouts/:investorId/export/pdf', (req, res) => res.status(501).json({ message: 'Not implemented' }));
router.get('/payouts/:investorId/export/excel', (req, res) => res.status(501).json({ message: 'Not implemented' }));
exports.default = router;
//# sourceMappingURL=dividendRoutes.js.map