<?php
/**
 * Debug script para verificar o carregamento do actor
 */

require_once __DIR__ . '/../bootstrap/app.php';

echo "<h2>Debug - Sistema de Actor</h2>";

// Simular login
$_SESSION['user_id'] = 10; // SuperAdmin

echo "<p>SESSION user_id: " . ($_SESSION['user_id'] ?? 'NÃO DEFINIDO') . "</p>";

// Executar middleware
$mw = new App\Core\Http\ScopeMiddleware($GLOBALS['pdo']);
$mw->handle(fn() => null);

echo "<p>GLOBALS['actor']: " . (isset($GLOBALS['actor']) ? 'DEFINIDO' : 'NÃO DEFINIDO') . "</p>";

if (isset($GLOBALS['actor']) && $GLOBALS['actor']) {
    $actor = $GLOBALS['actor'];
    echo "<div>";
    echo "<h3>Dados do Actor:</h3>";
    echo "<p><strong>User ID:</strong> " . $actor->userId . "</p>";
    echo "<p><strong>Empresa ID:</strong> " . $actor->empresaId . "</p>";
    echo "<p><strong>Roles:</strong> " . implode(', ', $actor->roles) . "</p>";
    echo "<p><strong>Has SuperAdmin:</strong> " . ($actor->hasRole('SuperAdmin') ? 'SIM' : 'NÃO') . "</p>";
    echo "</div>";
} else {
    echo "<p style='color: red;'>❌ Actor não foi carregado</p>";
}

// Testar Guard
$guard = $GLOBALS['guard'];
echo "<p><strong>Guard can dashboard.view:</strong> " . ($guard->can('dashboard.view') ? 'SIM' : 'NÃO') . "</p>";

echo "<hr>";
echo "<p><a href='" . url('login') . "'>Ir para Login</a></p>";
?>