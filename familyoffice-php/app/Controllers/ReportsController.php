<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Database;
use Dompdf\Dompdf;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ReportsController
{
	public function index(): void
	{
		Auth::requireRole(['ADMIN','ADVISOR']);
		$pdo = Database::pdo();
		$capital = (float)$pdo->query("SELECT COALESCE(SUM(CASE WHEN type='DEPOSIT' THEN amount ELSE -amount END),0) FROM family_capital")->fetchColumn();
		$dividends = (float)$pdo->query("SELECT COALESCE(SUM(amount),0) FROM dividends")->fetchColumn();
		$positions = (float)$pdo->query("SELECT COALESCE(SUM(quantity*avg_price),0) FROM stock_positions")->fetchColumn();
		include __DIR__ . '/../../views/reports/index.php';
	}

	public function exportPdf(): void
	{
		Auth::requireRole(['ADMIN','ADVISOR']);
		$pdo = Database::pdo();
		$data = [
			'capital' => (float)$pdo->query("SELECT COALESCE(SUM(CASE WHEN type='DEPOSIT' THEN amount ELSE -amount END),0) FROM family_capital")->fetchColumn(),
			'dividends' => (float)$pdo->query("SELECT COALESCE(SUM(amount),0) FROM dividends")->fetchColumn(),
			'positions' => (float)$pdo->query("SELECT COALESCE(SUM(quantity*avg_price),0) FROM stock_positions")->fetchColumn(),
		];
		$html = '<h3>Laporan Ringkas</h3>'
			. '<p>Total Modal: Rp ' . number_format($data['capital'],0,',','.') . '</p>'
			. '<p>Total Dividen: Rp ' . number_format($data['dividends'],0,',','.') . '</p>'
			. '<p>Nilai Saham: Rp ' . number_format($data['positions'],0,',','.') . '</p>';
		$dompdf = new Dompdf();
		$dompdf->loadHtml($html, 'UTF-8');
		$dompdf->render();
		$dompdf->stream('laporan_familyoffice.pdf', ['Attachment' => true]);
	}

	public function exportExcel(): void
	{
		Auth::requireRole(['ADMIN','ADVISOR']);
		$pdo = Database::pdo();
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->setCellValue('A1', 'Kategori');
		$sheet->setCellValue('B1', 'Nilai');
		$rows = [
			['Total Modal', (float)$pdo->query("SELECT COALESCE(SUM(CASE WHEN type='DEPOSIT' THEN amount ELSE -amount END),0) FROM family_capital")->fetchColumn()],
			['Total Dividen', (float)$pdo->query("SELECT COALESCE(SUM(amount),0) FROM dividends")->fetchColumn()],
			['Nilai Saham', (float)$pdo->query("SELECT COALESCE(SUM(quantity*avg_price),0) FROM stock_positions")->fetchColumn()],
		];
		$rowNum = 2;
		foreach ($rows as $r) {
			$sheet->setCellValue('A'.$rowNum, $r[0]);
			$sheet->setCellValue('B'.$rowNum, (float)$r[1]);
			$rowNum++;
		}
		headers(['Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet']);
		headers(['Content-Disposition' => 'attachment; filename="laporan_familyoffice.xlsx"']);
		$writer = new Xlsx($spreadsheet);
		$writer->save('php://output');
	}
}