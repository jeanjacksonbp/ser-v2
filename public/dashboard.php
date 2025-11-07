<?php
/**
 * Dashboard Principal - SER v2.0
 * Implementado com SISTEMA DEFINITIVO de controle de acesso
 */

// ✅ 1. Bootstrap (sempre primeiro)
require_once __DIR__ . '/../bootstrap/app.php';

// ✅ 2. Auth Check (usando sistema definitivo)
$guard->requireAuth();

// ✅ 3. Permission Check (usando sistema definitivo) 
$guard->requirePermission('dashboard.view');

// ✅ 4. Verificar permissões específicas para dados sensíveis
$canViewFinancial = $guard->hasPermission('dashboard.financial.view');
$canViewKPIs = $guard->hasPermission('dashboard.kpis.view');

// ✅ 5. Load Data - Carregar dados do contexto do usuário (sistema definitivo)
$user = $guard->getUser();
$actor = $guard->getActor();

// Obter role principal do usuário para exibição
$primaryRole = 'Usuário';
if ($actor && $actor->roles) {
    $primaryRole = $actor->roles[0] ?? 'Usuário';
}

// Nome da organização (por enquanto usando ID da empresa como identificador)
$organizationName = 'Organização Exemplo';
if ($actor && $actor->empresaId) {
    $organizationName = 'Empresa ' . $actor->empresaId;
}

// Preparar dados para o dashboard baseado nas permissões
$dashboardData = [
    'user' => (object) [
        'id' => $user->id,
        'name' => $user->nome ?? 'Usuário',
        'email' => $user->email,
        'role' => $primaryRole
    ],
    'organization' => (object) ['name' => $organizationName],
    'canViewFinancial' => $canViewFinancial,
    'canViewKPIs' => $canViewKPIs,
    'modules' => [
        'diagnostico' => [
            'name' => 'Diagnóstico',
            'items' => [
                [
                    'name' => 'Financeiro (DRE real/oculto)',
                    'url' => url('diagnostico-analise-financeira'),
                    'icon' => 'fa-file-invoice-dollar',
                    'permission' => 'financial.view'
                ],
                [
                    'name' => 'Competitividade & Mercado',
                    'url' => url('diagnostico-competitividade'),
                    'icon' => 'fa-ranking-star',
                    'permission' => 'market.analyze'
                ],
                [
                    'name' => 'Potencial & Competências',
                    'url' => url('diagnostico-organizacional'),
                    'icon' => 'fa-magnifying-glass',
                    'permission' => 'diagnosis.organizational'
                ]
            ]
        ],
        'planejamento' => [
            'name' => 'Planejamento',
            'items' => [
                [
                    'name' => 'Planejamento 360°',
                    'url' => url('planejamento-plano-estrategico'),
                    'icon' => 'fa-bullseye',
                    'permission' => 'planning.strategic.view'
                ],
                [
                    'name' => 'Cronograma & Metas (trimestral)',
                    'url' => url('planejamento-cronograma'),
                    'icon' => 'fa-calendar-check',
                    'permission' => 'schedule.view'
                ]
            ]
        ],
        'execucao' => [
            'name' => 'Execução',
            'items' => [
                [
                    'name' => 'Comitês & Atas',
                    'url' => url('execucao-comites'),
                    'icon' => 'fa-users',
                    'permission' => 'committee.view'
                ],
                [
                    'name' => 'Gestão Integrada (7a–7l)',
                    'url' => url('execucao-gestao-integrada'),
                    'icon' => 'fa-diagram-project',
                    'permission' => 'projects.manage'
                ]
            ]
        ],
        'metricas' => [
            'name' => 'Métricas',
            'items' => [
                [
                    'name' => 'KPIs & Indicadores',
                    'url' => url('metricas-kpis'),
                    'icon' => 'fa-chart-line',
                    'permission' => 'kpis.view'
                ]
            ]
        ],
        'vendas' => [
            'name' => 'Mercado & Vendas',
            'items' => [
                [
                    'name' => 'Prospecção & Retenção',
                    'url' => url('vendas-clientes'),
                    'icon' => 'fa-user-group',
                    'permission' => 'crm.view'
                ],
                [
                    'name' => 'Vendas Previsíveis (7l)',
                    'url' => url('vendas-previsoes'),
                    'icon' => 'fa-chart-simple',
                    'permission' => 'sales.forecast'
                ]
            ]
        ],
        'cultura' => [
            'name' => 'Cultura',
            'items' => [
                [
                    'name' => 'Cultura Empresarial',
                    'url' => url('cultura-avaliacao'),
                    'icon' => 'fa-spa',
                    'permission' => 'culture.assess'
                ]
            ]
        ]
    ]
];

// Filtrar módulos baseado nas permissões do usuário
foreach ($dashboardData['modules'] as $moduleKey => $module) {
    foreach ($module['items'] as $itemKey => $item) {
        if (!$guard->can($item['permission'])) {
            unset($dashboardData['modules'][$moduleKey]['items'][$itemKey]);
        }
    }
    // Remover módulo se não houver itens acessíveis
    if (empty($dashboardData['modules'][$moduleKey]['items'])) {
        unset($dashboardData['modules'][$moduleKey]);
    }
}

// ✅ 6. Audit Log - Dashboard access
// TODO: Implementar AuditLogger
// AuditLogger::log('dashboard.access', [
//     'user_id' => $user->id,
//     'organization_id' => $actorContext->getOrganization()?->id,
//     'accessible_modules' => array_keys($dashboardData['modules'])
// ]);

// ✅ 7. Extract Variables for View
extract($dashboardData);
$primaryRole = $dashboardData['user']->role; // Para compatibilidade com a view

// ✅ 8. Include View
include __DIR__ . '/../resources/views/pages/dashboard.php';
?>