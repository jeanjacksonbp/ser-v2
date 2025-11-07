# 🚀 DESENVOLVIMENTO CHECKLIST - SER v2.0

## ⚡ CHECKLIST RÁPIDO POR PÁGINA

### � **OBRIGATÓRIO - LER ANTES DE TUDO:**
```
□ Li SISTEMA_PROVA_FALHAS.md completamente?
□ Entendi as regras absolutas que NUNCA podem ser quebradas?
□ Identifiquei a permissão específica necessária?
□ Vou usar EXATAMENTE o template sagrado?
□ NÃO vou criar atalhos temporários?
```

### �📋 ANTES DE COMEÇAR
```
□ Consultar SISTEMA_PROVA_FALHAS.md (OBRIGATÓRIO)
□ Consultar ARCHITECTURE_MASTER.md
□ Identificar página no prototype_2
□ Mapear permissões necessárias
□ Definir contexto de escopo
□ Verificar dados sensíveis envolvidos
```

### 🔨 DURANTE IMPLEMENTAÇÃO
```php
<?php
/**
 * TEMPLATE DEFINITIVO - Use EXATAMENTE este padrão em TODAS as páginas
 * NÃO CRIE ATALHOS - Este é o sistema definitivo e robusto
 */

// ✅ 1. Bootstrap (SEMPRE primeiro)
require_once __DIR__ . '/../../bootstrap/app.php';

// ✅ 2. Auth Check (sistema definitivo - redireciona automaticamente)
$guard->requireAuth();

// ✅ 3. Permission Check (sistema definitivo - erro 403 automático)
$guard->requirePermission('DEFINIR_PERMISSAO_AQUI');

// ✅ 4. Verificações de permissões específicas (se necessário)
$canEdit = $guard->hasPermission('recurso.edit');
$canDelete = $guard->hasPermission('recurso.delete');

// ✅ 5. Load Data (usando sistema definitivo)
$user = $guard->getUser();           // Dados do usuário atual
$actor = $guard->getActor();         // Contexto completo (roles, empresa, etc)

// ✅ 6. Lógica específica da página
// $data = carregarDadosEspecificos();

// ✅ 7. Audit Log (TODO: implementar quando necessário)
// AuditLogger::log('action', $context);

// ✅ 8. Include View
include __DIR__ . '/../../resources/views/pages/NOME_PAGINA.php';
?>
```

### 🎯 MÉTODOS DISPONÍVEIS NO GUARD (Sistema Definitivo)
```php
// Verificações de autenticação
$guard->requireAuth();              // Força login ou redireciona
$guard->isAuthenticated();          // true/false sem redirecionamento

// Verificações de permissão  
$guard->requirePermission('acao');  // Força permissão ou erro 403
$guard->can('acao');                // true/false sem erro
$guard->hasPermission('acao');      // Alias para can()

// Obter dados do usuário
$user = $guard->getUser();          // Array com dados do usuário
$actor = $guard->getActor();        // ActorContext completo
$actor = $guard->getActorContext(); // Alias para getActor()
```

### 🎯 PERMISSÕES POR MÓDULO

#### Dashboard
- `dashboard.view`
- `dashboard.financial.view`
- `dashboard.kpis.view`

#### Diagnóstico
- `financial.view` / `financial.analyze` / `financial.report`
- `business.model.view` / `business.model.edit`
- `swot.analyze`
- `diagnosis.organizational`

#### Planejamento
- `planning.strategic.view` / `planning.strategic.edit`
- `budget.view` / `budget.create` / `budget.approve`
- `schedule.view` / `schedule.manage`
- `risk.assess` / `risk.manage`

#### Execução
- `projects.view` / `projects.manage`
- `processes.view` / `processes.optimize`
- `monitoring.view`
- `change.manage`

#### Métricas
- `kpis.view` / `kpis.configure`
- `scorecard.view`
- `dashboard.executive.view`
- `reports.performance.view`

#### Vendas
- `market.analyze`
- `sales.strategy`
- `crm.manage`

#### Cultura
- `culture.assess`
- `people.develop`

### ⚠️ PONTOS CRÍTICOS
```
🔴 SEMPRE verificar contexto organizacional
🔴 Dados financeiros = auditoria obrigatória
🔴 Usar MessageHelper para textos
🔴 Testar com diferentes roles
🔴 Aplicar escopo correto
```

### 🧪 TESTE POR PÁGINA
```
□ SuperAdmin - acesso total
□ AdminEmpresa - acesso organizacional
□ Admin - acesso por escopo
□ CoordComite - acesso limitado
□ Colaborador - acesso básico
□ Consultor - acesso específico
□ Terceiro - acesso mínimo
```

### 📝 APÓS IMPLEMENTAÇÃO
```
□ Documentar novas permissões
□ Atualizar banco se necessário
□ Testar fluxo completo
□ Verificar logs de auditoria
□ Atualizar ARCHITECTURE_MASTER.md
```

---

## 🎯 ORDEM DE IMPLEMENTAÇÃO SUGERIDA

### Fase 1 - Core (Semana 1)
1. **Dashboard** (`dashboard.php`)
2. **Análise Financeira** (`diagnostico-analise-financeira.php`)

### Fase 2 - Diagnóstico (Semana 2)  
3. **Canvas Negócio** (`diagnostico-canvas.php`)
4. **Matriz SWOT** (`diagnostico-swot.php`)
5. **Diagnóstico Organizacional** (`diagnostico-organizacional.php`)

### Fase 3 - Planejamento (Semana 3)
6. **Plano Estratégico** (`planejamento-plano-estrategico.php`)
7. **Orçamento** (`planejamento-orcamento.php`)

### Fase 4 - Continuação (Semanas 4-6)
- Demais páginas conforme prioridade do cliente

---

## 🔍 LINKS RÁPIDOS DE REFERÊNCIA

- **Documentação Completa**: `docs/ARCHITECTURE_MASTER.md`
- **Auth System**: `src/Core/Auth/Guard.php`
- **Middleware**: `src/Core/Http/ScopeMiddleware.php`
- **Prototype Aprovado**: `prototype_2/`
- **Database Schema**: `database/sql/01_schema_core.sql`

---

*Sempre consulte este checklist antes de implementar uma nova página!*