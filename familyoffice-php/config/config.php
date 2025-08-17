<?php
declare(strict_types=1);

return [
    'app' => [
        'name' => $_ENV['APP_NAME'] ?? 'FamilyOffice',
        'url' => $_ENV['APP_URL'] ?? 'http://localhost',
        'env' => $_ENV['APP_ENV'] ?? 'production',
        'debug' => (bool)($_ENV['APP_DEBUG'] ?? false),
    ],
    'db' => [
        'host' => $_ENV['DB_HOST'] ?? 'localhost',
        'port' => (int)($_ENV['DB_PORT'] ?? 3306),
        'database' => $_ENV['DB_DATABASE'] ?? '',
        'username' => $_ENV['DB_USERNAME'] ?? '',
        'password' => $_ENV['DB_PASSWORD'] ?? '',
    ],
    'security' => [
        'encryption_key' => $_ENV['ENCRYPTION_KEY'] ?? '',
        'recaptcha_site_key' => $_ENV['RECAPTCHA_SITE_KEY'] ?? '',
        'recaptcha_secret' => $_ENV['RECAPTCHA_SECRET'] ?? '',
    ],
    'mail' => [
        'host' => $_ENV['SMTP_HOST'] ?? '',
        'port' => (int)($_ENV['SMTP_PORT'] ?? 587),
        'user' => $_ENV['SMTP_USER'] ?? '',
        'pass' => $_ENV['SMTP_PASS'] ?? '',
    ],
];