<?php
/**
 * Script para adicionar permissões básicas do dashboard
 */

require_once __DIR__ . '/../bootstrap/app.php';

echo "<h2>Adicionando permissões básicas do Dashboard</h2>";

// Permissões básicas necessárias para o dashboard
$acoes = [
    'dashboard.view' => 'Visualizar dashboard',
    'dashboard.financial.view' => 'Visualizar dados financeiros no dashboard',
    'dashboard.kpis.view' => 'Visualizar KPIs no dashboard',
    'financial.view' => 'Visualizar análise financeira',
    'market.analyze' => 'Analisar mercado e competitividade',
    'diagnosis.organizational' => 'Diagnóstico organizacional',
    'planning.strategic.view' => 'Visualizar planejamento estratégico',
    'schedule.view' => 'Visualizar cronogramas',
    'committee.view' => 'Visualizar comitês',
    'projects.manage' => 'Gerenciar projetos',
    'kpis.view' => 'Visualizar KPIs',
    'crm.view' => 'Visualizar CRM',
    'sales.forecast' => 'Previsões de vendas',
    'culture.assess' => 'Avaliar cultura organizacional'
];

try {
    // Inserir ações
    foreach ($acoes as $chave => $descricao) {
        $stmt = $GLOBALS['pdo']->prepare("INSERT IGNORE INTO acoes (chave, descricao) VALUES (?, ?)");
        $stmt->execute([$chave, $descricao]);
        echo "<p>✅ Ação adicionada: {$chave}</p>";
    }
    
    // Dar todas as permissões para SuperAdmin
    $stmt = $GLOBALS['pdo']->prepare("
        INSERT IGNORE INTO permissoes_acoes (perfil_id, acao_id, id_empresa, permitido)
        SELECT p.id, a.id, NULL, 1
        FROM perfis p 
        JOIN acoes a ON a.chave IN ('" . implode("', '", array_keys($acoes)) . "')
        WHERE p.nome = 'SuperAdmin'
    ");
    $stmt->execute();
    echo "<p>✅ Permissões concedidas para SuperAdmin</p>";
    
    // Dar permissões básicas para AdminEmpresa
    $basicPermissions = ['dashboard.view', 'financial.view', 'planning.strategic.view', 'kpis.view'];
    $stmt = $GLOBALS['pdo']->prepare("
        INSERT IGNORE INTO permissoes_acoes (perfil_id, acao_id, id_empresa, permitido)
        SELECT p.id, a.id, NULL, 1
        FROM perfis p 
        JOIN acoes a ON a.chave IN ('" . implode("', '", $basicPermissions) . "')
        WHERE p.nome = 'AdminEmpresa'
    ");
    $stmt->execute();
    echo "<p>✅ Permissões básicas concedidas para AdminEmpresa</p>";
    
    echo "<hr>";
    echo "<h3>Permissões configuradas com sucesso!</h3>";
    echo "<p><a href='" . url('login') . "'>🔐 Fazer Login</a></p>";
    echo "<p><a href='" . url('dashboard') . "'>🏠 Ir para Dashboard</a></p>";
    
} catch (Exception $e) {
    echo "<p>❌ Erro: " . $e->getMessage() . "</p>";
}
?>