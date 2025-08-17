"use strict";
var __importDefault = (this && this.__importDefault) || function (mod) {
    return (mod && mod.__esModule) ? mod : { "default": mod };
};
Object.defineProperty(exports, "__esModule", { value: true });
exports.encryptSensitive = encryptSensitive;
exports.decryptSensitive = decryptSensitive;
const crypto_1 = __importDefault(require("crypto"));
const env_1 = require("../config/env");
const algorithm = 'aes-256-cbc';
function encryptSensitive(plainText) {
    const key = Buffer.from(env_1.env.encryption.key, 'utf8');
    const iv = env_1.env.encryption.iv ? Buffer.from(env_1.env.encryption.iv, 'utf8') : crypto_1.default.randomBytes(16);
    const cipher = crypto_1.default.createCipheriv(algorithm, key, iv);
    let encrypted = cipher.update(plainText, 'utf8', 'base64');
    encrypted += cipher.final('base64');
    return { cipherText: encrypted, iv: iv.toString('base64') };
}
function decryptSensitive(cipherText, ivBase64) {
    const key = Buffer.from(env_1.env.encryption.key, 'utf8');
    const iv = Buffer.from(ivBase64, 'base64');
    const decipher = crypto_1.default.createDecipheriv(algorithm, key, iv);
    let decrypted = decipher.update(cipherText, 'base64', 'utf8');
    decrypted += decipher.final('utf8');
    return decrypted;
}
//# sourceMappingURL=crypto.js.map