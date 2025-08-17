import axios from 'axios';
import prisma from '../config/prisma';

export async function emitWebhook(event: 'INVESTOR_UPDATED' | 'DIVIDEND_DISTRIBUTED', payload: any) {
	const subs = await prisma.webhookSubscription.findMany({ where: { isActive: true, event } });
	for (const sub of subs) {
		try {
			const res = await axios.post(sub.url, { event, payload }, { timeout: 5000 });
			await prisma.webhookAttempt.create({
				data: { webhookId: sub.id, event, statusCode: res.status, response: String(res.data).slice(0, 1000) }
			});
		} catch (err: any) {
			await prisma.webhookAttempt.create({
				data: { webhookId: sub.id, event, error: err.message?.slice(0, 1000) }
			});
		}
	}
}