"use strict";
var __importDefault = (this && this.__importDefault) || function (mod) {
    return (mod && mod.__esModule) ? mod : { "default": mod };
};
Object.defineProperty(exports, "__esModule", { value: true });
exports.mailTransport = void 0;
exports.sendMail = sendMail;
const nodemailer_1 = __importDefault(require("nodemailer"));
const env_1 = require("./env");
exports.mailTransport = nodemailer_1.default.createTransport({
    host: env_1.env.smtp.host,
    port: env_1.env.smtp.port,
    secure: env_1.env.smtp.port === 465,
    auth: env_1.env.smtp.user && env_1.env.smtp.pass ? { user: env_1.env.smtp.user, pass: env_1.env.smtp.pass } : undefined
});
async function sendMail(options) {
    const from = options.from || `Investment App <${env_1.env.smtp.user || 'no-reply@example.com'}>`;
    return exports.mailTransport.sendMail({ ...options, from });
}
//# sourceMappingURL=mailer.js.map