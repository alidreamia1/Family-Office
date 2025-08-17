import ExcelJS from 'exceljs';
import PDFDocument from 'pdfkit';
import { Response } from 'express';

export async function exportInvestorDividendsToExcel(opts: {
	investorName: string;
	periodLabel: string;
	rows: Array<{ date: string; capital: string; percent: string; amount: string }>; 
	res: Response;
}) {
	const workbook = new ExcelJS.Workbook();
	const sheet = workbook.addWorksheet('Dividends');
	sheet.columns = [
		{ header: 'Tanggal', key: 'date', width: 15 },
		{ header: 'Modal', key: 'capital', width: 20 },
		{ header: 'Persentase', key: 'percent', width: 15 },
		{ header: 'Dividen', key: 'amount', width: 20 }
	];
	opts.rows.forEach(r => sheet.addRow(r));
	const fileName = `dividen_${opts.investorName}_${opts.periodLabel}.xlsx`;
	opts.res.setHeader('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	opts.res.setHeader('Content-Disposition', `attachment; filename="${fileName}"`);
	await workbook.xlsx.write(opts.res);
	opts.res.end();
}

export function exportInvestorDividendsToPDF(opts: {
	investorName: string;
	periodLabel: string;
	rows: Array<{ date: string; capital: string; percent: string; amount: string }>;
	res: Response;
}) {
	const doc = new PDFDocument({ margin: 40 });
	const fileName = `dividen_${opts.investorName}_${opts.periodLabel}.pdf`;
	opts.res.setHeader('Content-Type', 'application/pdf');
	opts.res.setHeader('Content-Disposition', `attachment; filename="${fileName}"`);
	doc.pipe(opts.res);
	doc.fontSize(18).text('Laporan Dividen', { align: 'center' });
	doc.moveDown();
	doc.fontSize(12).text(`Investor: ${opts.investorName}`);
	doc.text(`Periode: ${opts.periodLabel}`);
	doc.moveDown();
	opts.rows.forEach((r) => {
		doc.text(`${r.date} | Modal: ${r.capital} | Persentase: ${r.percent} | Dividen: ${r.amount}`);
	});
	doc.end();
}