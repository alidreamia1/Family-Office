<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Database;

class InvestorController
{
	public function index(): void
	{
		Auth::requireRole(['ADMIN','ADVISOR']);
		$list = Database::pdo()->query('SELECT ip.id,u.name,u.email,ip.national_id,ip.kyc_status FROM investor_profiles ip JOIN users u ON u.id=ip.user_id ORDER BY u.name')->fetchAll();
		include __DIR__ . '/../../views/investors/index.php';
	}

	public function create(): void
	{
		Auth::requireRole(['ADMIN']);
		include __DIR__ . '/../../views/investors/create.php';
	}

	public function store(): void
	{
		Auth::requireRole(['ADMIN']);
		$name = trim($_POST['name'] ?? '');
		$email = trim($_POST['email'] ?? '');
		$pwd = bin2hex(random_bytes(6));
		$pdo = Database::pdo();
		$pdo->beginTransaction();
		$u = $pdo->prepare('INSERT INTO users (email,name,password_hash,role) VALUES (?,?,?,"INVESTOR")');
		$u->execute([$email, $name, password_hash($pwd, PASSWORD_BCRYPT)]);
		$userId = (int)$pdo->lastInsertId();
		$p = $pdo->prepare('INSERT INTO investor_profiles (user_id, national_id, rdn_account, bank_name) VALUES (?,?,?,?)');
		$p->execute([$userId, $_POST['national_id'] ?? null, $_POST['rdn_account'] ?? null, $_POST['bank_name'] ?? null]);
		$pdo->commit();
		header('Location: /investors');
	}

	public function show(array $params): void
	{
		Auth::requireRole(['ADMIN','ADVISOR']);
		$id = (int)($params['id'] ?? 0);
		$stmt = Database::pdo()->prepare('SELECT ip.*,u.name,u.email FROM investor_profiles ip JOIN users u ON u.id=ip.user_id WHERE ip.id=?');
		$stmt->execute([$id]);
		$investor = $stmt->fetch();
		include __DIR__ . '/../../views/investors/show.php';
	}

	public function update(array $params): void
	{
		Auth::requireRole(['ADMIN']);
		$id = (int)($params['id'] ?? 0);
		$stmt = Database::pdo()->prepare('UPDATE investor_profiles SET national_id=?, rdn_account=?, bank_name=?, kyc_status=? WHERE id=?');
		$stmt->execute([$_POST['national_id'] ?? null, $_POST['rdn_account'] ?? null, $_POST['bank_name'] ?? null, $_POST['kyc_status'] ?? 'PENDING', $id]);
		header('Location: /investors/'.$id);
	}

	public function destroy(array $params): void
	{
		Auth::requireRole(['ADMIN']);
		$id = (int)($params['id'] ?? 0);
		$stmt = Database::pdo()->prepare('DELETE FROM investor_profiles WHERE id=?');
		$stmt->execute([$id]);
		header('Location: /investors');
	}
}