"use strict";
var __importDefault = (this && this.__importDefault) || function (mod) {
    return (mod && mod.__esModule) ? mod : { "default": mod };
};
Object.defineProperty(exports, "__esModule", { value: true });
exports.logger = void 0;
const winston_1 = __importDefault(require("winston"));
const { combine, timestamp, printf, colorize } = winston_1.default.format;
const logFormat = printf(({ level, message, timestamp: ts }) => {
    return `${ts} [${level}] ${message}`;
});
exports.logger = winston_1.default.createLogger({
    level: 'info',
    format: combine(timestamp(), logFormat),
    transports: [
        new winston_1.default.transports.Console({
            format: combine(colorize(), timestamp(), logFormat)
        })
    ]
});
exports.default = exports.logger;
//# sourceMappingURL=logger.js.map