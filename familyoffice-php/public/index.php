<?php
declare(strict_types=1);

use App\Core\Router;
use App\Core\Database;
use App\Core\Auth;

session_name($_ENV['SESSION_NAME'] ?? 'FOSESSID');
session_start();

require_once __DIR__ . '/../vendor/autoload.php';

$envPath = dirname(__DIR__);
if (file_exists($envPath . '/.env')) {
    $dotenv = Dotenv\Dotenv::createImmutable($envPath);
    $dotenv->safeLoad();
}

ini_set('display_errors', '1');
error_reporting(E_ALL);

try {
    Database::init([
        'host' => $_ENV['DB_HOST'] ?? 'localhost',
        'port' => (int)($_ENV['DB_PORT'] ?? 3306),
        'database' => $_ENV['DB_DATABASE'] ?? '',
        'username' => $_ENV['DB_USERNAME'] ?? '',
        'password' => $_ENV['DB_PASSWORD'] ?? '',
    ]);
} catch (Throwable $e) {
    http_response_code(500);
    echo 'Database error: ' . htmlspecialchars($e->getMessage());
    exit;
}

try {
    $router = new Router();
    require_once __DIR__ . '/../routes/web.php';
    $router->dispatch($_SERVER['REQUEST_METHOD'] ?? 'GET', strtok($_SERVER['REQUEST_URI'] ?? '/', '?'));
} catch (Throwable $e) {
    http_response_code(500);
    echo 'Unhandled error: ' . htmlspecialchars($e->getMessage());
}