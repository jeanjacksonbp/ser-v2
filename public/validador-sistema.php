<?php
/**
 * VALIDADOR AUTOMÁTICO DE PÁGINAS - SER v2.0
 * Executa antes de testar qualquer página nova
 */

require_once __DIR__ . '/../bootstrap/app.php';

function validarPagina($arquivo) {
    echo "<h2>🔍 Validando: " . basename($arquivo) . "</h2>";
    
    if (!file_exists($arquivo)) {
        echo "<p>❌ Arquivo não encontrado</p>";
        return false;
    }
    
    $conteudo = file_get_contents($arquivo);
    $erros = [];
    $avisos = [];
    
    // Verificar estrutura obrigatória
    if (!strpos($conteudo, "require_once __DIR__ . '/../../bootstrap/app.php';")) {
        $erros[] = "Falta bootstrap obrigatório";
    }
    
    if (!strpos($conteudo, '$guard->requireAuth();')) {
        $erros[] = "Falta \$guard->requireAuth() obrigatório";
    }
    
    if (!strpos($conteudo, '$guard->requirePermission(')) {
        $erros[] = "Falta \$guard->requirePermission() obrigatório";
    }
    
    // Verificar comandos proibidos
    if (strpos($conteudo, '$_SESSION[\'user_id\']')) {
        $erros[] = "USO PROIBIDO: \$_SESSION['user_id'] direto";
    }
    
    if (strpos($conteudo, '$GLOBALS[\'actor\']')) {
        $avisos[] = "CUIDADO: \$GLOBALS['actor'] direto (prefira \$guard->getActor())";
    }
    
    if (strpos($conteudo, '$user[')) {
        $erros[] = "ERRO DE TIPO: \$user[] - deve ser \$user-> (objeto)";
    }
    
    if (strpos($conteudo, '$pdo->prepare') || strpos($conteudo, '$GLOBALS[\'pdo\']')) {
        $avisos[] = "CUIDADO: Query direta no banco (prefira métodos do \$guard)";
    }
    
    // Verificar estrutura correta
    if (strpos($conteudo, '$user = $guard->getUser();')) {
        echo "<p>✅ Carregamento correto do usuário</p>";
    }
    
    if (strpos($conteudo, '$actor = $guard->getActor();')) {
        echo "<p>✅ Carregamento correto do actor</p>";
    }
    
    // Exibir resultados
    if (empty($erros) && empty($avisos)) {
        echo "<p style='color: green; font-weight: bold;'>🎉 PÁGINA VÁLIDA - Segue todas as regras!</p>";
        return true;
    }
    
    if (!empty($erros)) {
        echo "<div style='color: red; background: #ffe6e6; padding: 10px; border-radius: 5px;'>";
        echo "<h3>❌ ERROS CRÍTICOS (CORRIGIR ANTES DE USAR):</h3>";
        foreach ($erros as $erro) {
            echo "<li>" . $erro . "</li>";
        }
        echo "</div>";
    }
    
    if (!empty($avisos)) {
        echo "<div style='color: orange; background: #fff3e0; padding: 10px; border-radius: 5px;'>";
        echo "<h3>⚠️ AVISOS (RECOMENDADO CORRIGIR):</h3>";
        foreach ($avisos as $aviso) {
            echo "<li>" . $aviso . "</li>";
        }
        echo "</div>";
    }
    
    return empty($erros);
}

echo "<h1>🛡️ VALIDADOR DE SISTEMA À PROVA DE FALHAS</h1>";

// Validar dashboard atual
echo "<hr>";
validarPagina(__DIR__ . '/dashboard.php');

// Listar outras páginas para validar
$paginas = glob(__DIR__ . '/*.php');
foreach ($paginas as $pagina) {
    $nome = basename($pagina);
    if ($nome !== 'dashboard.php' && $nome !== 'index.php' && 
        $nome !== 'set_password.php' && $nome !== 'setup_permissions.php' &&
        !strpos($nome, 'debug') && !strpos($nome, 'test') && !strpos($nome, 'validador')) {
        
        echo "<hr>";
        validarPagina($pagina);
    }
}

echo "<hr>";
echo "<h2>📋 Para validar nova página:</h2>";
echo "<p>Acesse: <code>validador-sistema.php?arquivo=NOME_PAGINA.php</code></p>";

if (isset($_GET['arquivo'])) {
    $arquivo = __DIR__ . '/' . basename($_GET['arquivo']);
    echo "<hr>";
    validarPagina($arquivo);
}
?>