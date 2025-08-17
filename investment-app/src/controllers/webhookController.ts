import { Request, Response } from 'express';
import prisma from '../config/prisma';

export async function createSubscription(req: Request, res: Response) {
	const { name, url, event } = req.body;
	const sub = await prisma.webhookSubscription.create({ data: { name, url, event } });
	res.status(201).json(sub);
}

export async function deleteSubscription(req: Request, res: Response) {
	await prisma.webhookSubscription.delete({ where: { id: req.params.id } });
	res.json({ ok: true });
}