import { Request, Response } from 'express';
import prisma from '../config/prisma';

export async function overview(_req: Request, res: Response) {
	const totalDeposit = await prisma.investmentTransaction.aggregate({ where: { type: 'DEPOSIT' }, _sum: { amount: true } });
	const totalWithdraw = await prisma.investmentTransaction.aggregate({ where: { type: 'WITHDRAWAL' }, _sum: { amount: true } });
	const totalProfit = await prisma.dividendPeriod.aggregate({ _sum: { totalProfit: true } });
	res.json({
		capital: Number(totalDeposit._sum.amount || 0) - Number(totalWithdraw._sum.amount || 0),
		profit: Number(totalProfit._sum.totalProfit || 0)
	});
}

export async function dividends(_req: Request, res: Response) {
	const payouts = await prisma.dividendPayout.findMany({ include: { investor: { include: { user: true } }, period: true } });
	res.json(payouts);
}