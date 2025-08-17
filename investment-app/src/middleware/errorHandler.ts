import { Request, Response, NextFunction } from 'express';
import logger from '../config/logger';

export function errorHandler(err: any, req: Request, res: Response, next: NextFunction) {
	logger.error(err?.stack || String(err));
	if (res.headersSent) return next(err);
	const status = err.status || 500;
	res.status(status).json({ message: err.message || 'Internal Server Error' });
}