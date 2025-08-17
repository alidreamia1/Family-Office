<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Database;
use App\Core\Auth;
use PDO;

class InstallerController
{
	private function basePath(): string { return dirname(__DIR__, 2); }

	private function envExists(): bool { return file_exists($this->basePath() . '/.env'); }

	private function tryConnect(array $cfg, ?string &$error = null): ?PDO
	{
		try {
			$dsn = sprintf('mysql:host=%s;port=%d;dbname=%s;charset=utf8mb4', $cfg['host'], (int)$cfg['port'], $cfg['database']);
			$pdo = new PDO($dsn, $cfg['username'], $cfg['password'], [
				PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
				PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
			]);
			return $pdo;
		} catch (\Throwable $e) {
			$error = $e->getMessage();
			return null;
		}
	}

	public function index(): void
	{
		$step = 'db';
		$error = null;
		$env = [
			'host' => $_ENV['DB_HOST'] ?? 'localhost',
			'port' => (int)($_ENV['DB_PORT'] ?? 3306),
			'database' => $_ENV['DB_DATABASE'] ?? '',
			'username' => $_ENV['DB_USERNAME'] ?? '',
			'password' => $_ENV['DB_PASSWORD'] ?? '',
		];
		$pdo = null;
		if ($this->envExists() && $env['database'] && $env['username'] !== '') {
			$pdo = $this->tryConnect($env, $error);
			if ($pdo) {
				$usersTable = $pdo->query("SELECT COUNT(*) FROM information_schema.tables WHERE table_schema = DATABASE() AND table_name='users'")->fetchColumn();
				if ((int)$usersTable === 0) {
					$step = 'migrate';
				} else {
					$adminCount = (int)$pdo->query("SELECT COUNT(*) FROM users WHERE role='ADMIN'")->fetchColumn();
					$step = $adminCount > 0 ? 'done' : 'admin';
				}
			}
		}
		include $this->basePath() . '/views/auth/setup.php';
	}

	public function saveDb(): void
	{
		$cfg = [
			'host' => trim($_POST['DB_HOST'] ?? 'localhost'),
			'port' => (int)($_POST['DB_PORT'] ?? 3306),
			'database' => trim($_POST['DB_DATABASE'] ?? ''),
			'username' => trim($_POST['DB_USERNAME'] ?? ''),
			'password' => (string)($_POST['DB_PASSWORD'] ?? ''),
			'app_url' => trim($_POST['APP_URL'] ?? ''),
		];
		$error = null;
		$pdo = $this->tryConnect($cfg, $error);
		if (!$pdo) {
			$_SESSION['setup_error'] = 'Koneksi DB gagal: ' . $error;
			header('Location: /install');
			return;
		}
		$env = "APP_ENV=production\nAPP_URL=" . ($cfg['app_url'] ?: (isset($_SERVER['HTTP_HOST']) ? ('https://' . $_SERVER['HTTP_HOST']) : '')) . "\nAPP_NAME=FamilyOffice\nAPP_DEBUG=false\n\nDB_HOST={$cfg['host']}\nDB_PORT={$cfg['port']}\nDB_DATABASE={$cfg['database']}\nDB_USERNAME={$cfg['username']}\nDB_PASSWORD=" . addslashes($cfg['password']) . "\n\nSESSION_NAME=FOSESSID\nENCRYPTION_KEY=base64:" . base64_encode(random_bytes(32)) . "\n";
		file_put_contents($this->basePath() . '/.env', $env);
		// run schema
		$schema = file_get_contents($this->basePath() . '/database/schema.sql');
		foreach (array_filter(array_map('trim', explode(';', $schema))) as $stmt) {
			if ($stmt !== '') { $pdo->exec($stmt); }
		}
		$_SESSION['setup_notice'] = 'Konfigurasi DB tersimpan dan skema dibuat.';
		header('Location: /install');
	}

	public function store(): void
	{
		$exists = false;
		try { $exists = (int)Database::pdo()->query("SELECT COUNT(*) FROM users WHERE role='ADMIN'")->fetchColumn() > 0; } catch (\Throwable $e) { $exists = false; }
		if ($exists) { header('Location: /login'); return; }
		$email = trim($_POST['email'] ?? '');
		$name = trim($_POST['name'] ?? 'Admin');
		$pwd = $_POST['password'] ?? '';
		if (!$email || !$pwd) { $_SESSION['setup_error'] = 'Email/Password wajib diisi'; header('Location: /install'); return; }
		$stmt = Database::pdo()->prepare('INSERT INTO users (email,name,password_hash,role,is_active) VALUES (?,?,?,?,1)');
		$stmt->execute([$email,$name,Auth::hashPassword($pwd),'ADMIN']);
		$_SESSION['setup_notice'] = 'Admin berhasil dibuat. Silakan login.';
		header('Location: /login');
	}
}