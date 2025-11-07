<?php
/**
 * TEMPLATE BASE PARA PÁGINAS DO DASHBOARD - SER v2.0
 * 
 * 🛡️ SISTEMA À PROVA DE FALHAS - Template Sagrado
 * 
 * ⚠️  ATENÇÃO: Este é o template DEFINITIVO para todas as páginas!
 * 📋 Copie este arquivo e siga o padrão rigorosamente
 * 🚫 NUNCA altere a estrutura base de autenticação
 * 
 * INSTRUÇÕES:
 * 1. Copie este arquivo para criar nova página
 * 2. Substitua apenas as seções marcadas com [PERSONALIZAR]
 * 3. Mantenha TODA a estrutura de autenticação intocada
 * 4. Use apenas $dashboardData para acessar dados do usuário
 */

// [PERSONALIZAR] - Definir permissão específica da página
$requiredPermission = 'view_financial_analysis'; // ⚠️ ALTERE AQUI

// ✅ 1. Bootstrap (sempre primeiro)
require_once __DIR__ . '/../bootstrap/app.php';

// ✅ 2. Auth Check (usando sistema definitivo)
$guard->requireAuth();

// ✅ 3. Permission Check (usando sistema definitivo) 
$guard->requirePermission($requiredPermission);

// ✅ 4. Load Data - Carregar dados do contexto do usuário
$user = $guard->getUser();
$actor = $guard->getActor();

// ✅ 5. Preparação dos Dados Base
$actorContext = $guard->getActorContext();
$organizationName = $actorContext->getOrganization()?->nome ?? 'Sistema';

// Determinar role primário
$primaryRole = 'Usuário';
if ($actor && !empty($actor->roles)) {
    $primaryRole = $actor->roles[0] ?? 'Usuário';
}

// ✅ 6. Verificações de Permissões Específicas
$canViewFinancial = $guard->hasPermission('view_financial_analysis');
$canViewOperational = $guard->hasPermission('view_operational_analysis');
$canViewRisk = $guard->hasPermission('view_risk_analysis');
$canViewCompliance = $guard->hasPermission('view_compliance_analysis');

// ✅ 7. Montagem dos Módulos do Dashboard (para sidebar)
$modules = [
    'diagnostico' => [
        'name' => '🔍 Diagnóstico',
        'items' => []
    ],
    'analise' => [
        'name' => '📊 Análise',  
        'items' => []
    ],
    'monitoramento' => [
        'name' => '📈 Monitoramento',
        'items' => []
    ],
    'relatorios' => [
        'name' => '📋 Relatórios',
        'items' => []
    ],
    'configuracoes' => [
        'name' => '⚙️ Configurações',
        'items' => []
    ],
    'admin' => [
        'name' => '👥 Administração',
        'items' => []
    ]
];

// Adicionar itens baseado nas permissões
if ($canViewFinancial) {
    $modules['diagnostico']['items'][] = [
        'name' => 'Análise Financeira',
        'url' => '/ser-v2/public/diagnostico-analise-financeira.php',
        'icon' => 'fa-chart-line'
    ];
}

// [PERSONALIZAR] - Remover módulos vazios
foreach ($modules as $moduleKey => $module) {
    if (empty($modules[$moduleKey]['items'])) {
        unset($modules[$moduleKey]);
    }
}

// ✅ 8. Dados para o Dashboard (sidebar e página)
$dashboardData = [
    'user' => (object) [
        'id' => $user->id,
        'name' => $user->nome ?? 'Usuário',
        'email' => $user->email,
        'role' => $primaryRole
    ],
    'organization' => (object) ['name' => $organizationName],
    'canViewFinancial' => $canViewFinancial,
    'canViewOperational' => $canViewOperational, 
    'canViewRisk' => $canViewRisk,
    'canViewCompliance' => $canViewCompliance,
    'modules' => $modules
];

// ✅ 9. Extract Variables for View
extract($dashboardData);
$primaryRole = $dashboardData['user']->role;

// [PERSONALIZAR] - Dados específicos da página
$pageData = [
    'pageTitle' => 'Nome da Página', // ⚠️ ALTERE AQUI
    'breadcrumbs' => [ // ⚠️ ALTERE AQUI
        ['name' => 'Dashboard', 'url' => '/ser-v2/public/dashboard.php'],
        ['name' => 'Módulo', 'url' => null],
        ['name' => 'Página Atual', 'url' => null]
    ]
];

// ✅ 10. Include View (footer já incluído na view)
include __DIR__ . '/../resources/views/pages/NOME_DA_PAGINA.php'; // ⚠️ ALTERE AQUI
?>