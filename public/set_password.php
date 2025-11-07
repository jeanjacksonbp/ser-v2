<?php
/**
 * Script para definir senhas nos usuários de teste
 */

require_once __DIR__ . '/../bootstrap/app.php';

// Definir senhas para usuários de teste
$usuarios = [
    ['email' => 'superadmin@example.com', 'senha' => '123456'],
    ['email' => 'admin@empresa.com', 'senha' => '123456'],
];

echo "<h2>Definindo senhas para usuários de teste</h2>";

foreach ($usuarios as $user) {
    $hash = password_hash($user['senha'], PASSWORD_DEFAULT);
    
    $stmt = $GLOBALS['pdo']->prepare("UPDATE usuarios SET senha_hash = ? WHERE email = ?");
    $success = $stmt->execute([$hash, $user['email']]);
    
    if ($success) {
        echo "<p>✅ Senha definida para usuário ({$user['email']})</p>";
    } else {
        echo "<p>❌ Erro ao definir senha para usuário {$user['email']}</p>";
    }
}

echo "<hr>";
echo "<h3>Credenciais de Teste:</h3>";
echo "<ul>";
foreach ($usuarios as $user) {
    echo "<li><strong>{$user['email']}</strong> / senha: <code>{$user['senha']}</code></li>";
}
echo "</ul>";

echo "<p><a href='" . url('login') . "'>🔐 Ir para Login</a></p>";
echo "<p><a href='" . url('dashboard') . "'>🏠 Ir para Dashboard</a></p>";
?>