<?php
require __DIR__ . '/../bootstrap/app.php';

// Exemplo: definir senha para usuário 1 (SuperAdmin)
$userId = isset($_GET['user']) ? (int)$_GET['user'] : 1;
$nova  = $_GET['pass'] ?? '123456';

$hash = password_hash($nova, PASSWORD_BCRYPT);
$st = $GLOBALS['pdo']->prepare("UPDATE usuarios SET senha_hash=? WHERE id=?");
$st->execute([$hash, $userId]);

echo "Senha definida para o usuário {$userId}.";
