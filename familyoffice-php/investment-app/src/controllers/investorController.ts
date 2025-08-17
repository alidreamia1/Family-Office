import { Request, Response } from 'express';
import prisma from '../config/prisma';
import { encryptSensitive } from '../utils/crypto';

export async function listInvestors(_req: Request, res: Response) {
	const investors = await prisma.investorProfile.findMany({ include: { user: true } });
	res.json(investors);
}

export async function getInvestor(req: Request, res: Response) {
	const investor = await prisma.investorProfile.findUnique({ where: { id: req.params.id }, include: { user: true } });
	if (!investor) return res.status(404).json({ message: 'Not found' });
	res.json(investor);
}

export async function createInvestor(req: Request, res: Response) {
	const { email, name, phone, address, bankName, bankAccount, nationalIdNumber } = req.body;
	const exists = await prisma.user.findUnique({ where: { email } });
	if (exists) return res.status(400).json({ message: 'Email sudah digunakan' });
	const { cipherText, iv } = bankAccount ? encryptSensitive(bankAccount) : { cipherText: null, iv: null } as any;
	const selfie = (req as any).files?.photoSelfie?.[0]?.filename;
	const ktp = (req as any).files?.photoKtp?.[0]?.filename;
	const bankbook = (req as any).files?.photoBankbook?.[0]?.filename;
	const user = await prisma.user.create({
		data: {
			email,
			passwordHash: '$2a$10$abcdefghijklmnopqrstuv',
			name,
			phone,
			role: 'INVESTOR',
			investorProfile: {
				create: {
					address,
					bankName,
					bankAccountEncrypted: cipherText || undefined,
					bankAccountIV: iv || undefined,
					nationalIdNumber,
					photoSelfiePath: selfie,
					photoKtpPath: ktp,
					photoBankbookPath: bankbook
				}
			}
		}
	});
	res.status(201).json(user);
}

export async function updateInvestor(req: Request, res: Response) {
	const id = req.params.id;
	const { name, phone, address, bankName, bankAccount, nationalIdNumber, kycStatus } = req.body;
	const invest = await prisma.investorProfile.findUnique({ where: { id } });
	if (!invest) return res.status(404).json({ message: 'Not found' });
	const { cipherText, iv } = bankAccount ? encryptSensitive(bankAccount) : { cipherText: undefined, iv: undefined } as any;
	const selfie = (req as any).files?.photoSelfie?.[0]?.filename;
	const ktp = (req as any).files?.photoKtp?.[0]?.filename;
	const bankbook = (req as any).files?.photoBankbook?.[0]?.filename;
	const updated = await prisma.investorProfile.update({
		where: { id },
		data: {
			address, bankName, nationalIdNumber,
			bankAccountEncrypted: cipherText,
			bankAccountIV: iv,
			photoSelfiePath: selfie || undefined,
			photoKtpPath: ktp || undefined,
			photoBankbookPath: bankbook || undefined,
			kycStatus
		},
		include: { user: true }
	});
	if (name || phone) {
		await prisma.user.update({ where: { id: updated.userId }, data: { name: name || undefined, phone: phone || undefined } });
	}
	res.json(updated);
}

export async function deleteInvestor(req: Request, res: Response) {
	const id = req.params.id;
	await prisma.investorProfile.delete({ where: { id } });
	res.json({ ok: true });
}