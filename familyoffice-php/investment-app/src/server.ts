import express from 'express';
import http from 'http';
import cors from 'cors';
import helmet from 'helmet';
import cookieParser from 'cookie-parser';
import morgan from 'morgan';
import path from 'path';
import { Server as SocketIOServer } from 'socket.io';
import { env } from './config/env';
import router from './routes';
import { errorHandler } from './middleware/errorHandler';
import fs from 'fs';

const app = express();

app.use(helmet());
app.use(cors({ origin: true, credentials: true }));
app.use(express.json({ limit: '10mb' }));
app.use(express.urlencoded({ extended: true }));
app.use(cookieParser());
app.use(morgan('dev'));

// Ensure upload dir exists
if (!fs.existsSync(env.uploadDir)) {
	fs.mkdirSync(env.uploadDir, { recursive: true });
}

// Static assets
const publicDir = path.isAbsolute(env.publicDir) ? env.publicDir : path.join(process.cwd(), env.publicDir);
app.use('/static', express.static(publicDir));

// Views
const viewsDir = path.isAbsolute(env.viewsDir) ? env.viewsDir : path.join(process.cwd(), env.viewsDir);
app.set('views', viewsDir);
app.set('view engine', 'ejs');

// Routes
app.use('/api', router);

// Health
app.get('/health', (_req, res) => res.json({ ok: true }));

// Error handler
app.use(errorHandler);

const server = http.createServer(app);

export const io = new SocketIOServer(server, {
	cors: { origin: true, credentials: true }
});

io.on('connection', () => {
	// socket connected
});

server.listen(env.port, () => {
	console.log(`Server listening on ${env.port}`);
});