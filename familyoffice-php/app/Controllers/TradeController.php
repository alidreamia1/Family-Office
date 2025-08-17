<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Database;
use PDO;

class TradeController
{
	public function index(array $params): void
	{
		Auth::requireRole(['ADMIN','ADVISOR','INVESTOR']);
		$investorId = (int)($_GET['investor_id'] ?? 0);
		$pdo = Database::pdo();
		$trades = [];
		if ($investorId) {
			$stmt = $pdo->prepare('SELECT st.*, s.symbol FROM stock_trades st JOIN stocks s ON s.id=st.stock_id WHERE investor_id=? ORDER BY trade_date DESC, id DESC');
			$stmt->execute([$investorId]);
			$trades = $stmt->fetchAll();
		}
		include __DIR__ . '/../../views/stocks/trades.php';
	}

	public function buy(): void
	{
		Auth::requireRole(['ADMIN']);
		$pdo = Database::pdo();
		[$investorId, $stockId, $lots, $price, $fee, $date] = [
			(int)$_POST['investor_id'], (int)$_POST['stock_id'], (int)$_POST['lots'], (float)$_POST['price'], (float)$_POST['fee'], $_POST['trade_date']
		];
		$shares = $lots * 100;
		$pdo->beginTransaction();
		$pdo->prepare('INSERT INTO stock_trades (investor_id,stock_id,trade_type,lots,price,fee,trade_date) VALUES (?,?,?,?,?,?,?)')
			->execute([$investorId,$stockId,'BUY',$lots,$price,$fee,$date]);
		// Update position
		$pos = $pdo->prepare('SELECT quantity,avg_price FROM stock_positions WHERE investor_id=? AND stock_id=? FOR UPDATE');
		$pos->execute([$investorId,$stockId]);
		$row = $pos->fetch(PDO::FETCH_ASSOC);
		if ($row) {
			$newQty = (int)$row['quantity'] + $shares;
			$newCost = ($row['quantity'] * (float)$row['avg_price']) + ($shares * $price) + $fee;
			$newAvg = $newQty > 0 ? $newCost / $newQty : 0;
			$pdo->prepare('UPDATE stock_positions SET quantity=?, avg_price=? WHERE investor_id=? AND stock_id=?')
				->execute([$newQty,$newAvg,$investorId,$stockId]);
		} else {
			$avg = ($shares * $price + $fee) / $shares;
			$pdo->prepare('INSERT INTO stock_positions (investor_id,stock_id,quantity,avg_price) VALUES (?,?,?,?)')
				->execute([$investorId,$stockId,$shares,$avg]);
		}
		$pdo->commit();
		header('Location: /stocks');
	}

	public function sell(): void
	{
		Auth::requireRole(['ADMIN']);
		$pdo = Database::pdo();
		[$investorId, $stockId, $lots, $price, $fee, $date] = [
			(int)$_POST['investor_id'], (int)$_POST['stock_id'], (int)$_POST['lots'], (float)$_POST['price'], (float)$_POST['fee'], $_POST['trade_date']
		];
		$shares = $lots * 100;
		$pdo->beginTransaction();
		$pos = $pdo->prepare('SELECT quantity,avg_price FROM stock_positions WHERE investor_id=? AND stock_id=? FOR UPDATE');
		$pos->execute([$investorId,$stockId]);
		$row = $pos->fetch(PDO::FETCH_ASSOC);
		if (!$row || (int)$row['quantity'] < $shares) {
			$pdo->rollBack();
			http_response_code(400);
			echo 'Kuantitas tidak cukup';
			return;
		}
		$realized = ($price - (float)$row['avg_price']) * $shares - $fee;
		$pdo->prepare('INSERT INTO stock_trades (investor_id,stock_id,trade_type,lots,price,fee,trade_date,realized_pl) VALUES (?,?,?,?,?,?,?,?)')
			->execute([$investorId,$stockId,'SELL',$lots,$price,$fee,$date,$realized]);
		$newQty = (int)$row['quantity'] - $shares;
		if ($newQty === 0) {
			$pdo->prepare('UPDATE stock_positions SET quantity=0, avg_price=0 WHERE investor_id=? AND stock_id=?')
				->execute([$investorId,$stockId]);
		} else {
			$pdo->prepare('UPDATE stock_positions SET quantity=? WHERE investor_id=? AND stock_id=?')
				->execute([$newQty,$investorId,$stockId]);
		}
		$pdo->commit();
		header('Location: /stocks');
	}
}