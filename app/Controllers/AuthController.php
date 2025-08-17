<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Database;
use App\Core\Auth;

class AuthController
{
	public function showLogin(): void
	{
		include __DIR__ . '/../../views/auth/login.php';
	}

	public function login(): void
	{
		$email = $_POST['email'] ?? '';
		$password = $_POST['password'] ?? '';
		$stmt = Database::pdo()->prepare('SELECT id,email,name,role,password_hash FROM users WHERE email = ? AND is_active = 1 LIMIT 1');
		$stmt->execute([$email]);
		$user = $stmt->fetch();
		if (!$user || !Auth::verifyPassword($password, $user['password_hash'])) {
			http_response_code(401);
			echo 'Kredensial salah';
			return;
		}
		Auth::login($user);
		header('Location: /');
	}

	public function logout(): void
	{
		Auth::logout();
		header('Location: /login');
	}
}