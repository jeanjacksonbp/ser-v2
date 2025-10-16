<?php
declare(strict_types=1);

use App\Core\Http\ScopeMiddleware;

require __DIR__ . '/../vendor/autoload.php';

if (file_exists(__DIR__ . '/../.env')) {
  Dotenv\Dotenv::createImmutable(dirname(__DIR__))->load();
}

date_default_timezone_set($_ENV['TIMEZONE'] ?? 'UTC');
session_start();

$dsn = sprintf(
  'mysql:host=%s;port=%s;dbname=%s;charset=utf8mb4',
  $_ENV['DB_HOST'] ?? '127.0.0.1',
  $_ENV['DB_PORT'] ?? '3306',
  $_ENV['DB_DATABASE'] ?? 'ser_v2'
);
$pdo = new PDO($dsn, $_ENV['DB_USERNAME'] ?? 'root', $_ENV['DB_PASSWORD'] ?? '', [
  PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
  PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
]);

$mw = new ScopeMiddleware($pdo);
$mw->handle(fn () => null);

$GLOBALS['pdo'] = $pdo;
$GLOBALS['guard'] = new App\Core\Auth\Guard($pdo);
