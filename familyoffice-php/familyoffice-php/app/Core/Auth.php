<?php
declare(strict_types=1);

namespace App\Core;

class Auth
{
	public static function hashPassword(string $password): string
	{
		if (defined('PASSWORD_ARGON2ID')) {
			return password_hash($password, PASSWORD_ARGON2ID);
		}
		return password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
	}

	public static function verifyPassword(string $password, string $hash): bool
	{
		return password_verify($password, $hash);
	}

	public static function login(array $user): void
	{
		$_SESSION['user'] = [
			'id' => $user['id'] ?? null,
			'email' => $user['email'] ?? null,
			'name' => $user['name'] ?? null,
			'role' => $user['role'] ?? 'INVESTOR',
		];
	}

	public static function user(): ?array
	{
		return $_SESSION['user'] ?? null;
	}

	public static function logout(): void
	{
		unset($_SESSION['user']);
	}

	public static function requireRole(array $roles): void
	{
		$user = self::user();
		if (!$user || !in_array($user['role'], $roles, true)) {
			http_response_code(403);
			echo 'Forbidden';
			exit;
		}
	}
}