<?php
namespace App\Core;

use PDO;

final class Bootstrap
{
    private static bool $booted = false;
    private static ?PDO $pdo = null;

    public static function init(): void
    {
        if (self::$booted) return;
        self::$booted = true;

        // Caminhos globais
        if (!defined('APP_ROOT'))    define('APP_ROOT', dirname(__DIR__, 2));
        if (!defined('PUBLIC_PATH')) define('PUBLIC_PATH', APP_ROOT . '/public');
        if (!defined('VIEW_PATH'))   define('VIEW_PATH',   APP_ROOT . '/resources/views');
        if (!defined('APP_PATH'))    define('APP_PATH',    APP_ROOT . '/app');

        // Sessão
        if (session_status() === PHP_SESSION_NONE) session_start();

        // .env simples (se houver)
        $env = APP_ROOT.'/.env';
        if (is_file($env)) {
            foreach (file($env, FILE_IGNORE_NEW_LINES|FILE_SKIP_EMPTY_LINES) as $line) {
                if (str_starts_with(ltrim($line), '#') || !str_contains($line, '=')) continue;
                [$k,$v] = array_map('trim', explode('=', $line, 2));
                $_ENV[$k] = $v;
            }
        }
    }

    public static function baseUrl(string $path = ''): string
    {
        $base = $_ENV['BASE_URL'] ?? '';
        return rtrim($base, '/') . '/' . ltrim($path, '/');
    }

    public static function db(): PDO
    {
        if (self::$pdo) return self::$pdo;

        $dsn = sprintf(
            'mysql:host=%s;port=%s;dbname=%s;charset=utf8mb4',
            $_ENV['DB_HOST'] ?? '127.0.0.1',
            $_ENV['DB_PORT'] ?? '3306',
            $_ENV['DB_NAME'] ?? 'ser_v2'
        );
        self::$pdo = new PDO($dsn, $_ENV['DB_USER'] ?? 'root', $_ENV['DB_PASS'] ?? '', [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
        return self::$pdo;
    }

    // Caminhos de views
    public static function view(string $rel): string { return VIEW_PATH.'/'.ltrim($rel, '/'); }
}
