"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
const express_1 = require("express");
const router = (0, express_1.Router)();
router.get('/dashboard', (req, res) => res.status(501).json({ message: 'Not implemented' }));
router.put('/profile', (req, res) => res.status(501).json({ message: 'Not implemented' }));
router.get('/settings', (req, res) => res.status(501).json({ message: 'Not implemented' }));
router.put('/settings', (req, res) => res.status(501).json({ message: 'Not implemented' }));
exports.default = router;
//# sourceMappingURL=adminRoutes.js.map