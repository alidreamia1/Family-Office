<?php
declare(strict_types=1);

namespace App\Services;

class Crypto
{
	public static function encrypt(string $plaintext): array
	{
		$keyB64 = $_ENV['ENCRYPTION_KEY'] ?? '';
		if (str_starts_with($keyB64, 'base64:')) {
			$key = base64_decode(substr($keyB64, 7));
		} else {
			$key = $keyB64;
		}
		if (!$key || strlen($key) < 32) {
			throw new \RuntimeException('Invalid ENCRYPTION_KEY');
		}
		$iv = random_bytes(16);
		$cipher = openssl_encrypt($plaintext, 'aes-256-cbc', $key, OPENSSL_RAW_DATA, $iv);
		return [
			'cipher' => base64_encode($cipher),
			'iv' => base64_encode($iv)
		];
	}

	public static function decrypt(string $cipherB64, string $ivB64): string
	{
		$keyB64 = $_ENV['ENCRYPTION_KEY'] ?? '';
		$key = str_starts_with($keyB64, 'base64:') ? base64_decode(substr($keyB64, 7)) : $keyB64;
		$iv = base64_decode($ivB64);
		$cipher = base64_decode($cipherB64);
		$plain = openssl_decrypt($cipher, 'aes-256-cbc', $key, OPENSSL_RAW_DATA, $iv);
		return $plain ?: '';
	}
}