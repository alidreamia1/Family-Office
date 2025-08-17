<?php
declare(strict_types=1);

use App\Core\Router;
use App\Controllers\AuthController;
use App\Controllers\DashboardController;
use App\Controllers\InvestorController;
use App\Controllers\StockController;
use App\Controllers\TradeController;
use App\Controllers\InstallerController;
use App\Controllers\ReportsController;
use App\Core\Database;

/** @var Router $router */
$needSetup = !file_exists(dirname(__DIR__) . '/.env');
if (!$needSetup) {
	try {
		Database::pdo();
	} catch (Throwable $e) {
		$needSetup = true;
	}
}

$router->get('/', $needSetup ? [InstallerController::class, 'index'] : [DashboardController::class, 'index']);
$router->get('/health', function () { echo 'ok'; });

$router->get('/install', [InstallerController::class, 'index']);
$router->post('/install/db', [InstallerController::class, 'saveDb']);
$router->post('/install', [InstallerController::class, 'store']);

$router->get('/login', [AuthController::class, 'showLogin']);
$router->post('/login', [AuthController::class, 'login']);
$router->post('/logout', [AuthController::class, 'logout']);

$router->get('/investors', [InvestorController::class, 'index']);
$router->get('/investors/create', [InvestorController::class, 'create']);
$router->post('/investors', [InvestorController::class, 'store']);
$router->get('/investors/{id}', [InvestorController::class, 'show']);
$router->post('/investors/{id}', [InvestorController::class, 'update']);
$router->post('/investors/{id}/delete', [InvestorController::class, 'destroy']);

$router->get('/stocks', [StockController::class, 'index']);
$router->post('/stocks', [StockController::class, 'store']);
$router->post('/stocks/{id}/delete', [StockController::class, 'destroy']);

$router->get('/stocks/trades', [TradeController::class, 'index']);
$router->post('/stocks/buy', [TradeController::class, 'buy']);
$router->post('/stocks/sell', [TradeController::class, 'sell']);

$router->get('/reports', [ReportsController::class, 'index']);
$router->get('/reports/export/pdf', [ReportsController::class, 'exportPdf']);
$router->get('/reports/export/excel', [ReportsController::class, 'exportExcel']);