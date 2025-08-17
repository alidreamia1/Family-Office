import { Request, Response } from 'express';
import prisma from '../config/prisma';

export async function deposit(req: Request, res: Response) {
	const { investorId, amount, note } = req.body;
	if (!investorId || !amount || Number(amount) <= 0) return res.status(400).json({ message: 'Invalid input' });
	const tx = await prisma.investmentTransaction.create({ data: { investorId, type: 'DEPOSIT', amount: Number(amount), note, approvedById: (req as any).user?.userId } });
	res.status(201).json(tx);
}

export async function withdraw(req: Request, res: Response) {
	const { investorId, amount, note } = req.body;
	if (!investorId || !amount || Number(amount) <= 0) return res.status(400).json({ message: 'Invalid input' });
	const balance = await getInvestorBalance(investorId);
	if (Number(amount) > balance) return res.status(400).json({ message: 'Saldo tidak cukup' });
	const tx = await prisma.investmentTransaction.create({ data: { investorId, type: 'WITHDRAWAL', amount: Number(amount), note, approvedById: (req as any).user?.userId } });
	res.status(201).json(tx);
}

export async function listTransactions(req: Request, res: Response) {
	const investorId = req.params.investorId;
	const txs = await prisma.investmentTransaction.findMany({ where: { investorId }, orderBy: { createdAt: 'desc' } });
	res.json({ transactions: txs, balance: await getInvestorBalance(investorId) });
}

export async function getInvestorBalance(investorId: string): Promise<number> {
	const deposits = await prisma.investmentTransaction.aggregate({ where: { investorId, type: 'DEPOSIT' }, _sum: { amount: true } });
	const withdrawals = await prisma.investmentTransaction.aggregate({ where: { investorId, type: 'WITHDRAWAL' }, _sum: { amount: true } });
	const dep = Number(deposits._sum.amount || 0);
	const wit = Number(withdrawals._sum.amount || 0);
	return dep - wit;
}