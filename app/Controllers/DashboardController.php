<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Database;

class DashboardController
{
	public function index(): void
	{
		$user = Auth::user();
		if (!$user) { header('Location: /login'); return; }
		$pdo = Database::pdo();
		$totals = [
			'capital' => (float)$pdo->query("SELECT COALESCE(SUM(amount),0) FROM family_capital WHERE type='DEPOSIT'")->fetchColumn() - (float)$pdo->query("SELECT COALESCE(SUM(amount),0) FROM family_capital WHERE type='WITHDRAWAL'")->fetchColumn(),
			'dividends' => (float)$pdo->query("SELECT COALESCE(SUM(amount),0) FROM dividends")->fetchColumn(),
			'stocks_value' => (float)$pdo->query("SELECT COALESCE(SUM(quantity*avg_price),0) FROM stock_positions")->fetchColumn(),
		];
		$chartData = [
			'labels' => ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
			'values' => [100,120,130,110,150,160,170,165,180,190,200,210],
		];
		include __DIR__ . '/../../views/dashboard/index.php';
	}
}