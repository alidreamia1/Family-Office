<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Database;
use App\Core\Auth;

class InstallerController
{
	public function index(): void
	{
		$exists = (int)Database::pdo()->query("SELECT COUNT(*) FROM users WHERE role='ADMIN'")->fetchColumn() > 0;
		if ($exists) { header('Location: /'); return; }
		include __DIR__ . '/../../views/auth/install.php';
	}

	public function store(): void
	{
		$exists = (int)Database::pdo()->query("SELECT COUNT(*) FROM users WHERE role='ADMIN'")->fetchColumn() > 0;
		if ($exists) { header('Location: /'); return; }
		$email = trim($_POST['email'] ?? '');
		$name = trim($_POST['name'] ?? 'Admin');
		$pwd = $_POST['password'] ?? '';
		if (!$email || !$pwd) { http_response_code(400); echo 'Email/Password wajib diisi'; return; }
		$stmt = Database::pdo()->prepare('INSERT INTO users (email,name,password_hash,role,is_active) VALUES (?,?,?,?,1)');
		$stmt->execute([$email,$name,Auth::hashPassword($pwd),'ADMIN']);
		header('Location: /login');
	}
}