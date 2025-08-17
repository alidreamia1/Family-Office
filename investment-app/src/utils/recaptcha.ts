import axios from 'axios';
import { env } from '../config/env';

export async function verifyRecaptcha(token?: string, remoteIp?: string): Promise<boolean> {
	if (!env.recaptcha.secret) return true;
	if (!token) return false;
	try {
		const params = new URLSearchParams();
		params.append('secret', env.recaptcha.secret);
		params.append('response', token);
		if (remoteIp) params.append('remoteip', remoteIp);
		const res = await axios.post('https://www.google.com/recaptcha/api/siteverify', params);
		return Boolean(res.data?.success);
	} catch {
		return false;
	}
}