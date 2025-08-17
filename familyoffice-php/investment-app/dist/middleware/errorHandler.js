"use strict";
var __importDefault = (this && this.__importDefault) || function (mod) {
    return (mod && mod.__esModule) ? mod : { "default": mod };
};
Object.defineProperty(exports, "__esModule", { value: true });
exports.errorHandler = errorHandler;
const express_1 = require("express");
const logger_1 = __importDefault(require("../config/logger"));
function errorHandler(err, req, res, next) {
    logger_1.default.error(err?.stack || String(err));
    if (res.headersSent)
        return next(err);
    const status = err.status || 500;
    res.status(status).json({ message: err.message || 'Internal Server Error' });
}
//# sourceMappingURL=errorHandler.js.map