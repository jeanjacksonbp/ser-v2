# ARCHITECTURE MASTER - Diretrizes Consolidadas SER v2.0

## 📋 ÍNDICE DE NAVEGAÇÃO RÁPIDA
- [Sistema de Autorização](#sistema-de-autorização)
- [Estrutura de Permissões](#estrutura-de-permissões)
- [Mapeamento Prototype_2](#mapeamento-prototype_2)
- [Guidelines de Desenvolvimento](#guidelines-de-desenvolvimento)
- [Checklist por Página](#checklist-por-página)

---

## 🔐 SISTEMA DE AUTORIZAÇÃO

### RBAC + ABAC Implementado
**Localização:** `src/Core/Auth/Guard.php`, `src/Core/Http/ScopeMiddleware.php`

#### Roles Principais:
- **SuperAdmin**: Acesso total ao sistema
- **AdminEmpresa**: Administração completa da empresa
- **Admin**: Administração limitada por escopo
- **CoordComite**: Coordenação de comitês específicos
- **Colaborador**: Acesso básico por escopo
- **Consultor**: Acesso específico por contrato
- **Terceiro**: Acesso muito limitado

#### Scopes de Contexto:
- **org**: Nível organizacional
- **committee**: Nível de comitê
- **kpi**: Nível de indicadores
- **unit**: Nível de unidade
- **resource**: Nível de recurso específico

---

## 🎯 ESTRUTURA DE PERMISSÕES POR MÓDULO

### 1. DASHBOARD (dashboard.php)
**Permissões Necessárias:**
- `dashboard.view` - Visualização geral
- `dashboard.financial.view` - Dados financeiros
- `dashboard.kpis.view` - Indicadores chave

**Implementação:**
```php
$guard->requirePermission('dashboard.view');
$canViewFinancial = $guard->hasPermission('dashboard.financial.view');
$canViewKPIs = $guard->hasPermission('dashboard.kpis.view');
```

### 2. DIAGNÓSTICO EMPRESARIAL
#### Análise Financeira (diagnostico-analise-financeira.php)
- `financial.view` - Visualizar dados financeiros
- `financial.analyze` - Analisar tendências
- `financial.report` - Gerar relatórios

#### Canvas Modelo de Negócios (diagnostico-canvas.php)
- `business.model.view` - Visualizar canvas
- `business.model.edit` - Editar modelo
- `business.model.validate` - Validar estrutura

### 3. PLANEJAMENTO ESTRATÉGICO
#### Plano Estratégico (planejamento-plano-estrategico.php)
- `planning.strategic.view` - Visualizar planos
- `planning.strategic.edit` - Editar estratégias
- `planning.strategic.approve` - Aprovar planos

#### Orçamento (planejamento-orcamento.php)
- `budget.view` - Visualizar orçamentos
- `budget.create` - Criar orçamentos
- `budget.approve` - Aprovar valores

### 4. EXECUÇÃO
#### Projetos (execucao-projetos.php)
- `projects.view` - Visualizar projetos
- `projects.manage` - Gerenciar execução
- `projects.report` - Relatórios de progresso

#### Processos (execucao-processos.php)
- `processes.view` - Visualizar processos
- `processes.optimize` - Otimizar fluxos
- `processes.audit` - Auditar execução

### 5. MÉTRICAS E INDICADORES
#### KPIs (metricas-kpis.php)
- `kpis.view` - Visualizar indicadores
- `kpis.configure` - Configurar métricas
- `kpis.analyze` - Analisar resultados

### 6. MERCADO E VENDAS
#### Análise Mercado (vendas-analise-mercado.php)
- `market.analyze` - Analisar mercado
- `market.research` - Pesquisas de mercado
- `sales.forecast` - Previsão de vendas

### 7. CULTURA ORGANIZACIONAL
#### Avaliação Cultural (cultura-avaliacao.php)
- `culture.assess` - Avaliar cultura
- `culture.develop` - Desenvolver programas
- `culture.monitor` - Monitorar mudanças

---

## 🗺️ MAPEAMENTO PROTOTYPE_2

### Estrutura Aprovada (21 Páginas):
```
prototype_2/
├── index.html (Dashboard Principal)
├── diagnostico/
│   ├── analise-financeira.html
│   ├── canvas-modelo-negocio.html
│   ├── matriz-swot.html
│   └── diagnostico-organizacional.html
├── planejamento/
│   ├── plano-estrategico.html
│   ├── orcamento-investimento.html
│   ├── cronograma-implementacao.html
│   └── gestao-riscos.html
├── execucao/
│   ├── projetos-iniciativas.html
│   ├── processos-operacionais.html
│   ├── monitoramento-progresso.html
│   └── gestao-mudancas.html
├── metricas/
│   ├── kpis-indicadores.html
│   ├── balanced-scorecard.html
│   ├── dashboard-executivo.html
│   └── relatorios-performance.html
├── vendas/
│   ├── analise-mercado.html
│   ├── estrategia-vendas.html
│   └── gestao-relacionamento.html
└── cultura/
    ├── avaliacao-cultura.html
    └── desenvolvimento-pessoas.html
```

---

## 📋 GUIDELINES DE DESENVOLVIMENTO

### 1. Padrão de Implementação por Página:
```php
<?php
// 1. Carregar dependências
require_once __DIR__ . '/../../bootstrap/app.php';

// 2. Verificar autenticação
$guard->requireAuth();

// 3. Verificar permissões específicas
$guard->requirePermission('modulo.acao');

// 4. Aplicar middleware de escopo se necessário
$scopeMiddleware->apply(['org', 'committee']);

// 5. Carregar dados específicos do contexto
$data = loadContextualData($guard->getActorContext());

// 6. Renderizar view
include __DIR__ . '/../../resources/views/pages/nome-pagina.php';
?>
```

### 2. Sistema de Mensagens (MessageHelper):
```php
// Preparação para i18n
$messages = MessageHelper::getMessages();
echo $messages['page.title']; // Ao invés de texto direto
```

### 3. Auditoria Obrigatória:
```php
// Para ações sensíveis
AuditLogger::log('action.performed', [
    'user_id' => $guard->getUser()->id,
    'resource' => 'page_name',
    'context' => $guard->getActorContext()->toArray()
]);
```

---

## ✅ CHECKLIST POR PÁGINA

### Antes de Implementar uma Página:
- [ ] Definir permissões necessárias
- [ ] Mapear contextos de escopo
- [ ] Identificar dados sensíveis
- [ ] Planejar auditoria necessária
- [ ] Verificar dependências do prototype_2

### Durante a Implementação:
- [ ] Implementar verificações de permissão
- [ ] Aplicar middleware de escopo
- [ ] Usar MessageHelper para textos
- [ ] Implementar logs de auditoria
- [ ] Testar com diferentes roles

### Após Implementação:
- [ ] Testar todos os níveis de acesso
- [ ] Validar comportamento por escopo
- [ ] Verificar logs de auditoria
- [ ] Documentar permissões específicas
- [ ] Atualizar este documento se necessário

---

## 🚨 PONTOS CRÍTICOS A NÃO ESQUECER

### 1. Multi-tenancy:
Sempre verificar o contexto organizacional correto antes de exibir dados.

### 2. Dados Financeiros:
Requerem permissões específicas e auditoria completa.

### 3. Aprovações:
Implementar workflow de aprovação para ações críticas.

### 4. Contexto de Escopo:
Sempre aplicar o escopo correto (org/committee/kpi/unit/resource).

### 5. Preparação i18n:
Usar MessageHelper para todos os textos visíveis ao usuário.

---

## 📞 REFERÊNCIAS RÁPIDAS

- **Auth System**: `src/Core/Auth/Guard.php`
- **Middleware**: `src/Core/Http/ScopeMiddleware.php`
- **Database Schema**: `database/sql/01_schema_core.sql`
- **Seed Data**: `database/sql/02_seed_data.sql`
- **Prototype Aprovado**: `prototype_2/`
- **Views Layout**: `resources/views/layouts/`

---

## 📝 NOTAS DE DESENVOLVIMENTO

**Próximos Passos Priorizados:**
1. Dashboard principal (maior prioridade)
2. Módulo Diagnóstico (análise financeira primeiro)
3. Módulo Planejamento (plano estratégico primeiro)
4. Demais módulos conforme aprovação

**Lembretes Importantes:**
- Sempre consultar este documento antes de implementar nova página
- Atualizar permissões no banco quando necessário
- Manter consistência com o prototype_2 aprovado
- Documentar novas permissões descobertas durante desenvolvimento

---

*Este documento será atualizado conforme descobrimos novos requisitos durante o desenvolvimento.*