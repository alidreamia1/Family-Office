"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
const express_1 = require("express");
const router = (0, express_1.Router)();
router.get('/', (req, res) => res.status(501).json({ message: 'Not implemented' }));
router.post('/', (req, res) => res.status(501).json({ message: 'Not implemented' }));
router.get('/:id', (req, res) => res.status(501).json({ message: 'Not implemented' }));
router.put('/:id', (req, res) => res.status(501).json({ message: 'Not implemented' }));
router.delete('/:id', (req, res) => res.status(501).json({ message: 'Not implemented' }));
exports.default = router;
//# sourceMappingURL=investorRoutes.js.map