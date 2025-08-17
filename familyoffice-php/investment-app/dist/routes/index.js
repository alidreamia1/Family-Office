"use strict";
var __importDefault = (this && this.__importDefault) || function (mod) {
    return (mod && mod.__esModule) ? mod : { "default": mod };
};
Object.defineProperty(exports, "__esModule", { value: true });
const express_1 = require("express");
const authRoutes_1 = __importDefault(require("./authRoutes"));
const investorRoutes_1 = __importDefault(require("./investorRoutes"));
const investmentRoutes_1 = __importDefault(require("./investmentRoutes"));
const dividendRoutes_1 = __importDefault(require("./dividendRoutes"));
const reportRoutes_1 = __importDefault(require("./reportRoutes"));
const adminRoutes_1 = __importDefault(require("./adminRoutes"));
const webhookRoutes_1 = __importDefault(require("./webhookRoutes"));
const router = (0, express_1.Router)();
router.use('/auth', authRoutes_1.default);
router.use('/investors', investorRoutes_1.default);
router.use('/investments', investmentRoutes_1.default);
router.use('/dividends', dividendRoutes_1.default);
router.use('/reports', reportRoutes_1.default);
router.use('/admin', adminRoutes_1.default);
router.use('/webhooks', webhookRoutes_1.default);
exports.default = router;
//# sourceMappingURL=index.js.map