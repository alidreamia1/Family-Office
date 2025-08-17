import nodemailer from 'nodemailer';
import { env } from './env';

export const mailTransport = nodemailer.createTransport({
	host: env.smtp.host,
	port: env.smtp.port,
	secure: env.smtp.port === 465,
	auth: env.smtp.user && env.smtp.pass ? { user: env.smtp.user, pass: env.smtp.pass } : undefined
});

export async function sendMail(options: {
	to: string;
	subject: string;
	html?: string;
	text?: string;
	from?: string;
}) {
	const from = options.from || `Investment App <${env.smtp.user || 'no-reply@example.com'}>`;
	return mailTransport.sendMail({ ...options, from });
}