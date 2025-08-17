"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
const express_1 = require("express");
const router = (0, express_1.Router)();
router.get('/overview', (req, res) => res.status(501).json({ message: 'Not implemented' }));
router.get('/dividends', (req, res) => res.status(501).json({ message: 'Not implemented' }));
router.get('/export/csv', (req, res) => res.status(501).json({ message: 'Not implemented' }));
router.get('/export/excel', (req, res) => res.status(501).json({ message: 'Not implemented' }));
router.get('/export/pdf', (req, res) => res.status(501).json({ message: 'Not implemented' }));
exports.default = router;
//# sourceMappingURL=reportRoutes.js.map