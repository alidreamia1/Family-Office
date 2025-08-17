"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
const express_1 = require("express");
const router = (0, express_1.Router)();
router.post('/register', (req, res) => res.status(501).json({ message: 'Not implemented' }));
router.post('/login', (req, res) => res.status(501).json({ message: 'Not implemented' }));
router.post('/request-reset', (req, res) => res.status(501).json({ message: 'Not implemented' }));
router.post('/verify-reset', (req, res) => res.status(501).json({ message: 'Not implemented' }));
exports.default = router;
//# sourceMappingURL=authRoutes.js.map