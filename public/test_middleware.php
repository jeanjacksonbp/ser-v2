<?php
/**
 * Teste simples do middleware
 */

require_once __DIR__ . '/../bootstrap/app.php';

echo "<h2>Teste Middleware</h2>";

try {
    // Definir sessão
    $_SESSION['user_id'] = 10;
    
    // Testar se middleware funciona
    $mw = new App\Core\Http\ScopeMiddleware($GLOBALS['pdo']);
    echo "<p>✅ Middleware criado com sucesso</p>";
    
    $result = $mw->handle(function() {
        return "OK";
    });
    
    echo "<p>✅ Middleware executado: $result</p>";
    
    if (isset($GLOBALS['actor'])) {
        echo "<p>✅ Actor carregado</p>";
        var_dump($GLOBALS['actor']);
    } else {
        echo "<p>❌ Actor não carregado</p>";
    }
    
} catch (Exception $e) {
    echo "<p>❌ Erro: " . $e->getMessage() . "</p>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
}
?>