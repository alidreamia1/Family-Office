import { Request, Response } from 'express';
import prisma from '../config/prisma';
import dayjs from 'dayjs';
import { io } from '../server';
import { appendRows } from '../utils/googleSheets';
import { emitWebhook } from '../services/webhookService';
import { exportInvestorDividendsToExcel, exportInvestorDividendsToPDF } from '../utils/exporters';

export async function createPeriod(req: Request, res: Response) {
	const { label, startDate, endDate, totalProfit } = req.body;
	const period = await prisma.dividendPeriod.create({ data: { label, startDate: new Date(startDate), endDate: new Date(endDate), totalProfit: Number(totalProfit) } });
	res.status(201).json(period);
}

export async function distribute(req: Request, res: Response) {
	const periodId = req.params.periodId;
	const period = await prisma.dividendPeriod.findUnique({ where: { id: periodId } });
	if (!period) return res.status(404).json({ message: 'Periode tidak ditemukan' });
	const investors = await prisma.investorProfile.findMany();
	const capitals = await Promise.all(investors.map(async inv => ({ id: inv.id, capital: await getBalance(inv.id) })));
	const totalCapital = capitals.reduce((s, c) => s + c.capital, 0);
	if (totalCapital <= 0) return res.status(400).json({ message: 'Total modal 0' });
	const payouts = [] as any[];
	for (const c of capitals) {
		const percent = c.capital / totalCapital;
		const amount = percent * Number(period.totalProfit);
		const payout = await prisma.dividendPayout.create({ data: { periodId: period.id, investorId: c.id, investorCapital: c.capital, sharePercent: percent, amount } });
		payouts.push(payout);
	}
	await prisma.dividendPeriod.update({ where: { id: period.id }, data: { distributedAt: new Date() } });
	io.emit('dividend_distributed', { periodId: period.id, totalProfit: period.totalProfit });
	await appendRows('Payouts!A1', payouts.map(p => [period.label, p.investorId, p.investorCapital.toString(), p.sharePercent.toString(), p.amount.toString(), dayjs(p.createdAt).format('YYYY-MM-DD HH:mm')]));
	await emitWebhook('DIVIDEND_DISTRIBUTED', { periodId: period.id });
	res.json({ ok: true, count: payouts.length });
}

export async function listPayouts(req: Request, res: Response) {
	const periodId = req.params.periodId;
	const payouts = await prisma.dividendPayout.findMany({ where: { periodId }, include: { investor: { include: { user: true } }, period: true } });
	res.json(payouts);
}

export async function exportInvestorPDF(req: Request, res: Response) {
	const investorId = req.params.investorId;
	const payouts = await prisma.dividendPayout.findMany({ where: { investorId }, include: { period: true, investor: { include: { user: true } } } });
	if (!payouts.length) return res.status(404).json({ message: 'Data kosong' });
	const investorName = payouts[0].investor.user.name;
	const rows = payouts.map(p => ({ date: p.period.label, capital: String(p.investorCapital), percent: (Number(p.sharePercent) * 100).toFixed(2) + '%', amount: String(p.amount) }));
	exportInvestorDividendsToPDF({ investorName, periodLabel: 'all', rows, res });
}

export async function exportInvestorExcel(req: Request, res: Response) {
	const investorId = req.params.investorId;
	const payouts = await prisma.dividendPayout.findMany({ where: { investorId }, include: { period: true, investor: { include: { user: true } } } });
	if (!payouts.length) return res.status(404).json({ message: 'Data kosong' });
	const investorName = payouts[0].investor.user.name;
	const rows = payouts.map(p => ({ date: p.period.label, capital: String(p.investorCapital), percent: (Number(p.sharePercent) * 100).toFixed(2) + '%', amount: String(p.amount) }));
	await exportInvestorDividendsToExcel({ investorName, periodLabel: 'all', rows, res });
}

async function getBalance(investorId: string): Promise<number> {
	const deposits = await prisma.investmentTransaction.aggregate({ where: { investorId, type: 'DEPOSIT' }, _sum: { amount: true } });
	const withdrawals = await prisma.investmentTransaction.aggregate({ where: { investorId, type: 'WITHDRAWAL' }, _sum: { amount: true } });
	return Number(deposits._sum.amount || 0) - Number(withdrawals._sum.amount || 0);
}