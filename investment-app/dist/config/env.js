"use strict";
var __importDefault = (this && this.__importDefault) || function (mod) {
    return (mod && mod.__esModule) ? mod : { "default": mod };
};
Object.defineProperty(exports, "__esModule", { value: true });
exports.env = void 0;
const dotenv_1 = __importDefault(require("dotenv"));
dotenv_1.default.config();
exports.env = {
    port: parseInt(process.env.PORT || '4000', 10),
    appUrl: process.env.APP_URL || 'http://localhost:4000',
    jwtSecret: process.env.JWT_SECRET || 'secret',
    jwtRefreshSecret: process.env.JWT_REFRESH_SECRET || 'refreshsecret',
    dbUrl: process.env.DATABASE_URL || '',
    smtp: {
        host: process.env.SMTP_HOST || '',
        port: parseInt(process.env.SMTP_PORT || '587', 10),
        user: process.env.SMTP_USER || '',
        pass: process.env.SMTP_PASS || ''
    },
    recaptcha: {
        secret: process.env.RECAPTCHA_SECRET || '',
        siteKey: process.env.RECAPTCHA_SITE_KEY || ''
    },
    googleSheets: {
        clientEmail: process.env.GOOGLE_SHEETS_CLIENT_EMAIL || '',
        privateKey: (process.env.GOOGLE_SHEETS_PRIVATE_KEY || '').replace(/\\n/g, '\n'),
        spreadsheetId: process.env.GOOGLE_SHEETS_SPREADSHEET_ID || ''
    },
    encryption: {
        key: process.env.ENCRYPTION_KEY || '',
        iv: process.env.ENCRYPTION_IV || ''
    },
    uploadDir: process.env.UPLOAD_DIR || 'src/public/uploads',
    viewsDir: process.env.VIEWS_DIR || 'src/views',
    publicDir: process.env.PUBLIC_DIR || 'src/public'
};
//# sourceMappingURL=env.js.map