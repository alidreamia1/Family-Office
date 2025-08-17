<?php
declare(strict_types=1);

namespace App\Core;

use PDO;
use PDOException;

class Database
{
	private static ?PDO $pdo = null;

	public static function init(array $config): void
	{
		$dsn = sprintf('mysql:host=%s;port=%d;dbname=%s;charset=utf8mb4', $config['host'], $config['port'], $config['database']);
		try {
			self::$pdo = new PDO($dsn, $config['username'], $config['password'], [
				PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
				PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
				PDO::MYSQL_ATTR_INIT_COMMAND => 'SET sql_mode=STRICT_ALL_TABLES'
			]);
		} catch (PDOException $e) {
			throw $e;
		}
	}

	public static function pdo(): PDO
	{
		if (!self::$pdo) {
			throw new \RuntimeException('Database not initialized');
		}
		return self::$pdo;
	}
}