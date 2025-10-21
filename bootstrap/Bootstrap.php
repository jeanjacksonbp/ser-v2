<?php
// Ponto de inicialização único
require dirname(__DIR__) . '/vendor/autoload.php';

use App\Core\Bootstrap;

Bootstrap::init();

// Detecta caminho base onde a app está montada (ex.: /ser-v2/public ou /)
if (!function_exists('app_base_path')) {
  function app_base_path(): string {
    // Ex.: /ser-v2/public/index.php  →  /ser-v2/public
    $scriptName = $_SERVER['SCRIPT_NAME'] ?? '';
    $base = rtrim(str_replace('\\', '/', dirname($scriptName)), '/');
    return $base === '' ? '/' : $base . '/';
  }
}

// Versão que retorna APENAS o caminho (útil em headers ou redireções internas)
if (!function_exists('path')) {
  function path(string $path = ''): string {
    $path = ltrim($path, '/');
    return app_base_path() . $path; // ex.: /ser-v2/public/dashboard.php
  }
}

// Monta URL ABSOLUTA (com host) respeitando o base path
if (!function_exists('url')) {
  function url(string $path = ''): string {
    $path = ltrim($path, '/'); // não permitir // duplicado
    // esquema+host
    $https = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || (($_SERVER['SERVER_PORT'] ?? '') === '443');
    $scheme = $https ? 'https' : 'http';
    $host   = $_SERVER['HTTP_HOST'] ?? 'localhost';
    // base path
    $base = app_base_path(); // ex.: /ser-v2/public/
    return $scheme . '://' . $host . $base . $path;
  }
}

// Atalhos globais (compatíveis com seu código atual)
if (!function_exists('base_url')) {
  function base_url(string $path = ''): string { return \App\Core\Bootstrap::baseUrl($path); }
}
if (!function_exists('db')) {
  function db(): \PDO { return \App\Core\Bootstrap::db(); }
}
if (!function_exists('view_path')) {
  function view_path(string $rel): string { return \App\Core\Bootstrap::view($rel); }
}
// Assets dentro de /public/assets (CSS, JS, imagens)
if (!function_exists('asset')) {
  function asset(string $rel): string {
    $rel = ltrim($rel, '/');
    return url('assets/' . $rel); // URL absoluta correta
  }
}