<?php
// Ponto de inicialização único
require dirname(__DIR__) . '/vendor/autoload.php';

use App\Core\Bootstrap;

Bootstrap::init();

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
