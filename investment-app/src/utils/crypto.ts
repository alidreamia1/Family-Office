import crypto from 'crypto';
import { env } from '../config/env';

const algorithm = 'aes-256-cbc';

export function encryptSensitive(plainText: string): { cipherText: string; iv: string } {
	const key = Buffer.from(env.encryption.key, 'utf8');
	const iv = env.encryption.iv ? Buffer.from(env.encryption.iv, 'utf8') : crypto.randomBytes(16);
	const cipher = crypto.createCipheriv(algorithm, key, iv);
	let encrypted = cipher.update(plainText, 'utf8', 'base64');
	encrypted += cipher.final('base64');
	return { cipherText: encrypted, iv: iv.toString('base64') };
}

export function decryptSensitive(cipherText: string, ivBase64: string): string {
	const key = Buffer.from(env.encryption.key, 'utf8');
	const iv = Buffer.from(ivBase64, 'base64');
	const decipher = crypto.createDecipheriv(algorithm, key, iv);
	let decrypted = decipher.update(cipherText, 'base64', 'utf8');
	decrypted += decipher.final('utf8');
	return decrypted;
}