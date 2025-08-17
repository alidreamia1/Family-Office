import { Request, Response } from 'express';
import prisma from '../config/prisma';
import bcrypt from 'bcryptjs';

export async function dashboard(_req: Request, res: Response) {
	const investors = await prisma.investorProfile.count();
	const periods = await prisma.dividendPeriod.count();
	res.json({ investors, periods });
}

export async function getSettings(_req: Request, res: Response) {
	const s = await prisma.setting.findUnique({ where: { id: 'singleton' } });
	res.json(s);
}

export async function updateSettings(req: Request, res: Response) {
	const s = await prisma.setting.upsert({ where: { id: 'singleton' }, update: req.body, create: { id: 'singleton', ...req.body } });
	res.json(s);
}

export async function initialSetup(req: Request, res: Response) {
	const adminExists = await prisma.user.findFirst({ where: { role: 'ADMIN' } });
	if (adminExists) return res.status(400).json({ message: 'Admin sudah ada' });
	const { email, password, name, phone } = req.body;
	const admin = await prisma.user.create({ data: { email, passwordHash: await bcrypt.hash(password, 10), name, phone, role: 'ADMIN' } });
	res.json({ ok: true, admin: { id: admin.id, email: admin.email } });
}