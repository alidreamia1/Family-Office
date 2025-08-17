"use strict";
var __importDefault = (this && this.__importDefault) || function (mod) {
    return (mod && mod.__esModule) ? mod : { "default": mod };
};
Object.defineProperty(exports, "__esModule", { value: true });
exports.io = void 0;
const express_1 = __importDefault(require("express"));
const http_1 = __importDefault(require("http"));
const cors_1 = __importDefault(require("cors"));
const helmet_1 = __importDefault(require("helmet"));
const cookie_parser_1 = __importDefault(require("cookie-parser"));
const morgan_1 = __importDefault(require("morgan"));
const path_1 = __importDefault(require("path"));
const socket_io_1 = require("socket.io");
const env_1 = require("./config/env");
const routes_1 = __importDefault(require("./routes"));
const errorHandler_1 = require("./middleware/errorHandler");
const fs_1 = __importDefault(require("fs"));
const app = (0, express_1.default)();
app.use((0, helmet_1.default)());
app.use((0, cors_1.default)({ origin: true, credentials: true }));
app.use(express_1.default.json({ limit: '10mb' }));
app.use(express_1.default.urlencoded({ extended: true }));
app.use((0, cookie_parser_1.default)());
app.use((0, morgan_1.default)('dev'));
// Ensure upload dir exists
if (!fs_1.default.existsSync(env_1.env.uploadDir)) {
    fs_1.default.mkdirSync(env_1.env.uploadDir, { recursive: true });
}
// Static assets
const publicDir = path_1.default.isAbsolute(env_1.env.publicDir) ? env_1.env.publicDir : path_1.default.join(process.cwd(), env_1.env.publicDir);
app.use('/static', express_1.default.static(publicDir));
// Views
const viewsDir = path_1.default.isAbsolute(env_1.env.viewsDir) ? env_1.env.viewsDir : path_1.default.join(process.cwd(), env_1.env.viewsDir);
app.set('views', viewsDir);
app.set('view engine', 'ejs');
// Routes
app.use('/api', routes_1.default);
// Health
app.get('/health', (_req, res) => res.json({ ok: true }));
// Error handler
app.use(errorHandler_1.errorHandler);
const server = http_1.default.createServer(app);
exports.io = new socket_io_1.Server(server, {
    cors: { origin: true, credentials: true }
});
exports.io.on('connection', () => {
    // socket connected
});
server.listen(env_1.env.port, () => {
    console.log(`Server listening on ${env_1.env.port}`);
});
//# sourceMappingURL=server.js.map