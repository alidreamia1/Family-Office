import { google } from 'googleapis';
import { env } from '../config/env';

function getSheetsClient() {
	if (!env.googleSheets.clientEmail || !env.googleSheets.privateKey) return null;
	const jwt = new google.auth.JWT({
		email: env.googleSheets.clientEmail,
		key: env.googleSheets.privateKey,
		scopes: ['https://www.googleapis.com/auth/spreadsheets']
	});
	return google.sheets({ version: 'v4', auth: jwt });
}

export async function appendRows(range: string, values: any[][]) {
	const sheets = getSheetsClient();
	if (!sheets || !env.googleSheets.spreadsheetId) return;
	await sheets.spreadsheets.values.append({
		spreadsheetId: env.googleSheets.spreadsheetId,
		range,
		valueInputOption: 'USER_ENTERED',
		requestBody: { values }
	});
}