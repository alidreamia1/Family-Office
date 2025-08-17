import { Request, Response, NextFunction } from 'express';
import jwt from 'jsonwebtoken';
import { env } from '../config/env';

export interface JwtPayload {
	userId: string;
	role: 'ADMIN' | 'INVESTOR';
}

export function authRequired(req: Request, res: Response, next: NextFunction) {
	const authHeader = req.headers.authorization || '';
	const token = authHeader.startsWith('Bearer ') ? authHeader.substring(7) : undefined;
	if (!token) return res.status(401).json({ message: 'Unauthorized' });
	try {
		const payload = jwt.verify(token, env.jwtSecret) as JwtPayload;
		(req as any).user = payload;
		return next();
	} catch (err) {
		return res.status(401).json({ message: 'Invalid token' });
	}
}

export function requireRole(roles: Array<'ADMIN' | 'INVESTOR'>) {
	return (req: Request, res: Response, next: NextFunction) => {
		const user = (req as any).user as JwtPayload | undefined;
		if (!user || !roles.includes(user.role)) return res.status(403).json({ message: 'Forbidden' });
		next();
	};
}