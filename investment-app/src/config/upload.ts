import multer from 'multer';
import path from 'path';
import fs from 'fs';
import { env } from './env';

const storage = multer.diskStorage({
	destination: (_req, _file, cb) => {
		const dest = path.isAbsolute(env.uploadDir) ? env.uploadDir : path.join(process.cwd(), env.uploadDir);
		if (!fs.existsSync(dest)) fs.mkdirSync(dest, { recursive: true });
		cb(null, dest);
	},
	filename: (_req, file, cb) => {
		const unique = `${Date.now()}-${Math.round(Math.random()*1e9)}`;
		cb(null, `${unique}${path.extname(file.originalname)}`);
	}
});

function fileFilter(_req: any, file: Express.Multer.File, cb: multer.FileFilterCallback) {
	const allowed = ['image/jpeg', 'image/png', 'image/webp', 'application/pdf'];
	if (!allowed.includes(file.mimetype)) return cb(new Error('File type not allowed'));
	cb(null, true);
}

export const upload = multer({ storage, fileFilter, limits: { fileSize: 5 * 1024 * 1024 } });