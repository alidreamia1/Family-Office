<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Database;

class StockController
{
	public function index(): void
	{
		Auth::requireRole(['ADMIN','ADVISOR']);
		$list = Database::pdo()->query('SELECT * FROM stocks ORDER BY symbol')->fetchAll();
		include __DIR__ . '/../../views/stocks/index.php';
	}

	public function store(): void
	{
		Auth::requireRole(['ADMIN']);
		$symbol = strtoupper(trim($_POST['symbol'] ?? ''));
		$name = trim($_POST['name'] ?? '');
		$stmt = Database::pdo()->prepare('INSERT INTO stocks (symbol,name) VALUES (?,?) ON DUPLICATE KEY UPDATE name=VALUES(name)');
		$stmt->execute([$symbol, $name]);
		header('Location: /stocks');
	}

	public function destroy(array $params): void
	{
		Auth::requireRole(['ADMIN']);
		$id = (int)($params['id'] ?? 0);
		$stmt = Database::pdo()->prepare('DELETE FROM stocks WHERE id=?');
		$stmt->execute([$id]);
		header('Location: /stocks');
	}
}