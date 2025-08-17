"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
const express_1 = require("express");
const router = (0, express_1.Router)();
router.post('/subscriptions', (req, res) => res.status(501).json({ message: 'Not implemented' }));
router.delete('/subscriptions/:id', (req, res) => res.status(501).json({ message: 'Not implemented' }));
exports.default = router;
//# sourceMappingURL=webhookRoutes.js.map