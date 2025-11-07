<?php
/**
 * 🏗️ TEMPLATE COMPLETO PARA NOVA PÁGINA - SER v2.0
 * 
 * 🛡️ SISTEMA À PROVA DE FALHAS - Template Sagrado Atualizado
 * ✨ Incluindo todas as melhorias: Sidebar responsivo, CSS corrigido, etc.
 * 
 * ⚠️  ATENÇÃO: Este é o template DEFINITIVO mais atual!
 * 📋 Copie este arquivo e siga o padrão rigorosamente
 * 🚫 NUNCA altere a estrutura base de autenticação
 * 
 * INSTRUÇÕES DE USO:
 * 1. Copie este arquivo para /public/nome-da-pagina.php
 * 2. Copie TEMPLATE_VIEW_COMPLETA.php para /resources/views/pages/nome-da-pagina.php  
 * 3. Substitua apenas as seções marcadas com [PERSONALIZAR]
 * 4. Mantenha TODA a estrutura de autenticação intocada
 * 5. Use apenas $dashboardData para acessar dados do usuário
 * 
 * EXEMPLO DE USO:
 * - Controller: /public/diagnostico-analise-financeira.php
 * - View: /resources/views/pages/diagnostico-analise-financeira.php
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

// [PERSONALIZAR] - Adicionar itens específicos baseado nas permissões
if ($canViewFinancial) {
    $modules['diagnostico']['items'][] = [
        'name' => 'Análise Financeira',
        'url' => '/ser-v2/public/diagnostico-analise-financeira.php',
        'icon' => 'fa-chart-line'
    ];
    $modules['analise']['items'][] = [
        'name' => 'Relatórios Financeiros', 
        'url' => '/ser-v2/public/analise-relatorios-financeiros.php',
        'icon' => 'fa-file-invoice-dollar'
    ];
}

if ($canViewOperational) {
    $modules['diagnostico']['items'][] = [
        'name' => 'Análise Operacional',
        'url' => '/ser-v2/public/diagnostico-analise-operacional.php', 
        'icon' => 'fa-cogs'
    ];
}

if ($canViewRisk) {
    $modules['diagnostico']['items'][] = [
        'name' => 'Análise de Riscos',
        'url' => '/ser-v2/public/diagnostico-analise-riscos.php',
        'icon' => 'fa-exclamation-triangle'
    ];
}

// Remover módulos vazios
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
    'pageTitle' => 'Análise Financeira', // ⚠️ ALTERE AQUI
    'breadcrumbs' => [ // ⚠️ ALTERE AQUI
        ['name' => 'Dashboard', 'url' => '/ser-v2/public/dashboard.php'],
        ['name' => 'Diagnóstico', 'url' => null],
        ['name' => 'Análise Financeira', 'url' => null]
    ]
];

// [PERSONALIZAR] - Dados específicos da funcionalidade desta página
$pageSpecificData = [
    // Adicione aqui dados específicos para a página
    // Ex: lista de relatórios, dados financeiros, etc.
    'example' => 'Substitua por dados reais'
];

// ✅ 10. Include View (footer já incluído na view)
include __DIR__ . '/../resources/views/pages/diagnostico-analise-financeira.php'; // ⚠️ ALTERE AQUI
?>