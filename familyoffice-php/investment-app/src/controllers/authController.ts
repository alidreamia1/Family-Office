import { Request, Response } from 'express';
import { body } from 'express-validator';
import prisma from '../config/prisma';
import bcrypt from 'bcryptjs';
import jwt from 'jsonwebtoken';
import { env } from '../config/env';
import { sendMail } from '../config/mailer';
import { verifyRecaptcha } from '../utils/recaptcha';

export const registerValidators = [
	body('email').isEmail(),
	body('password').isStrongPassword({ minLength: 8 }),
	body('name').isString().isLength({ min: 2 }),
	body('recaptchaToken').optional().isString()
];

export async function register(req: Request, res: Response) {
	const okCaptcha = await verifyRecaptcha(req.body.recaptchaToken, req.ip);
	if (!okCaptcha) return res.status(400).json({ message: 'reCAPTCHA gagal' });
	const { email, password, name } = req.body;
	const exists = await prisma.user.findUnique({ where: { email } });
	if (exists) return res.status(400).json({ message: 'Email sudah terdaftar' });
	const passwordHash = await bcrypt.hash(password, 10);
	const user = await prisma.user.create({ data: { email, passwordHash, name, role: 'INVESTOR' } });
	const token = jwt.sign({ userId: user.id, role: user.role }, env.jwtSecret, { expiresIn: '1d' });
	return res.json({ token });
}

export const loginValidators = [
	body('email').isEmail(),
	body('password').isString().isLength({ min: 6 }),
	body('recaptchaToken').optional().isString()
];

export async function login(req: Request, res: Response) {
	const okCaptcha = await verifyRecaptcha(req.body.recaptchaToken, req.ip);
	if (!okCaptcha) return res.status(400).json({ message: 'reCAPTCHA gagal' });
	const { email, password } = req.body;
	const user = await prisma.user.findUnique({ where: { email } });
	if (!user) return res.status(401).json({ message: 'Kredensial salah' });
	const ok = await bcrypt.compare(password, user.passwordHash);
	if (!ok) return res.status(401).json({ message: 'Kredensial salah' });
	await prisma.user.update({ where: { id: user.id }, data: { lastLoginAt: new Date() } });
	const token = jwt.sign({ userId: user.id, role: user.role }, env.jwtSecret, { expiresIn: '1d' });
	return res.json({ token, role: user.role, name: user.name });
}

export const requestResetValidators = [body('email').isEmail()];

export async function requestReset(req: Request, res: Response) {
	const { email } = req.body;
	const user = await prisma.user.findUnique({ where: { email } });
	if (!user) return res.json({ message: 'Jika email valid, OTP telah dikirim' });
	const otp = Math.floor(100000 + Math.random() * 900000).toString();
	const expires = new Date(Date.now() + 10 * 60 * 1000);
	await prisma.user.update({ where: { id: user.id }, data: { resetOtp: otp, resetOtpExpiresAt: expires } });
	try {
		await sendMail({ to: email, subject: 'OTP Reset Password', text: `Kode OTP: ${otp} (berlaku 10 menit)` });
	} catch {}
	return res.json({ message: 'Jika email valid, OTP telah dikirim' });
}

export const verifyResetValidators = [
	body('email').isEmail(),
	body('otp').isLength({ min: 6, max: 6 }),
	body('newPassword').isStrongPassword({ minLength: 8 })
];

export async function verifyReset(req: Request, res: Response) {
	const { email, otp, newPassword } = req.body;
	const user = await prisma.user.findUnique({ where: { email } });
	if (!user || !user.resetOtp || !user.resetOtpExpiresAt) return res.status(400).json({ message: 'OTP tidak valid' });
	if (user.resetOtp !== otp || user.resetOtpExpiresAt < new Date()) return res.status(400).json({ message: 'OTP tidak valid' });
	await prisma.user.update({ where: { id: user.id }, data: { passwordHash: await bcrypt.hash(newPassword, 10), resetOtp: null, resetOtpExpiresAt: null } });
	return res.json({ message: 'Password berhasil direset' });
}