# Mapeamento de Classes CSS para I18n

## 🎨 **Diretrizes de CSS Semântico**

Este arquivo define padrões de classes CSS que facilitarão a identificação automática de elementos para internacionalização futura.

---

## 🏷️ **Classes Identificadoras**

### **Títulos e Cabeçalhos**
```css
/* Classes que identificam títulos traduzíveis */
.page-title { }         /* Título principal da página */
.section-title { }      /* Título de seção */
.module-title { }       /* Título de módulo */
.card-title { }         /* Título de card */
.modal-title { }        /* Título de modal */

/* Futura aplicação automática */
.page-title → data-i18n="pages.[page].title"
.section-title → data-i18n="sections.[section].title"
```

### **Botões e Ações**
```css
/* Padrão: .action-[acao] */
.action-save { }        /* Botão Salvar */
.action-cancel { }      /* Botão Cancelar */
.action-edit { }        /* Botão Editar */
.action-delete { }      /* Botão Excluir */
.action-create { }      /* Botão Criar */
.action-view { }        /* Botão Visualizar */

/* Futura aplicação automática */
.action-save → data-i18n="buttons.save"
.action-cancel → data-i18n="buttons.cancel"
```

### **Labels e Campos**
```css
/* Labels de formulário */
.field-label { }        /* Label genérico */
.required-label { }     /* Label obrigatório */

/* Por campo específico */
.label-name { }         /* Label "Nome" */
.label-email { }        /* Label "Email" */
.label-password { }     /* Label "Senha" */

/* Futura aplicação automática */
.label-name → data-i18n="labels.name"
.label-email → data-i18n="labels.email"
```

### **Mensagens e Feedback**
```css
/* Status e estados */
.status-label { }       /* Label de status */
.success-message { }    /* Mensagem de sucesso */
.error-message { }      /* Mensagem de erro */
.warning-message { }    /* Mensagem de aviso */
.info-message { }       /* Mensagem informativa */

/* Futura aplicação automática */
.success-message → data-i18n="messages.success.[key]"
.error-message → data-i18n="messages.error.[key]"
```

### **Navegação**
```css
/* Menu principal */
.nav-dashboard { }      /* Link Dashboard */
.nav-users { }          /* Link Usuários */
.nav-reports { }        /* Link Relatórios */
.nav-settings { }       /* Link Configurações */

/* Breadcrumbs */
.breadcrumb-item { }    /* Item de breadcrumb */

/* Futura aplicação automática */
.nav-dashboard → data-i18n="nav.dashboard"
.nav-users → data-i18n="nav.users"
```

---

## 🔍 **Padrões de Identificação**

### **Convenções de Nomenclatura**

```css
/* Padrão Geral: [tipo]-[contexto]-[elemento] */

/* Páginas */
.page-dashboard-title
.page-users-subtitle
.page-reports-description

/* Módulos do SER */
.module-diagnostic-title
.module-planning-description
.module-committees-action

/* Formulários */
.form-user-field
.form-login-button
.form-validation-message

/* Tabelas */
.table-header-name
.table-cell-status
.table-action-edit
```

### **Identificadores por Contexto**

```css
/* Dashboard */
.dashboard-welcome-message
.dashboard-quick-access
.dashboard-stats-card

/* Usuários */
.users-list-title
.users-create-form
.users-edit-modal

/* Relatórios */
.reports-filter-panel
.reports-export-button
.reports-chart-title

/* Configurações */
.settings-section-title
.settings-save-button
.settings-reset-link
```

---

## 📋 **Mapeamento para Data Attributes**

### **Script de Conversão Futura**

```javascript
// Mapeamento automático baseado em classes CSS
const CSS_TO_I18N_MAP = {
    // Títulos
    'page-title': (context) => `pages.${context}.title`,
    'section-title': (context) => `sections.${context}.title`,
    'module-title': (context) => `modules.${context}.title`,
    
    // Botões
    'action-save': () => 'buttons.save',
    'action-cancel': () => 'buttons.cancel',
    'action-edit': () => 'buttons.edit',
    'action-delete': () => 'buttons.delete',
    
    // Labels
    'label-name': () => 'labels.name',
    'label-email': () => 'labels.email',
    'label-password': () => 'labels.password',
    
    // Navegação
    'nav-dashboard': () => 'nav.dashboard',
    'nav-users': () => 'nav.users',
    'nav-reports': () => 'nav.reports',
    
    // Mensagens
    'success-message': (key) => `messages.success.${key}`,
    'error-message': (key) => `messages.error.${key}`,
};
```

---

## 🏗️ **Estrutura HTML Recomendada**

### **Páginas**
```html
<!-- Template base de página -->
<div class="page-container">
    <header class="page-header">
        <h1 class="page-title">Título da Página</h1>
        <p class="page-description">Descrição da página</p>
    </header>
    
    <main class="page-content">
        <section class="content-section">
            <h2 class="section-title">Seção</h2>
            <!-- Conteúdo -->
        </section>
    </main>
</div>
```

### **Formulários**
```html
<!-- Template de formulário -->
<form class="form-container">
    <div class="form-group">
        <label class="field-label label-name">Nome</label>
        <input type="text" class="form-control">
        <small class="form-help">Texto de help</small>
    </div>
    
    <div class="form-actions">
        <button class="btn btn-primary action-save">Salvar</button>
        <button class="btn btn-secondary action-cancel">Cancelar</button>
    </div>
</form>
```

### **Tabelas**
```html
<!-- Template de tabela -->
<div class="table-container">
    <div class="table-header">
        <h3 class="table-title">Lista de Usuários</h3>
        <div class="table-actions">
            <button class="btn btn-primary action-create">Criar Novo</button>
        </div>
    </div>
    
    <table class="table">
        <thead>
            <tr>
                <th class="table-header-name">Nome</th>
                <th class="table-header-email">Email</th>
                <th class="table-header-actions">Ações</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="table-cell-name">João</td>
                <td class="table-cell-email">joao@email.com</td>
                <td class="table-cell-actions">
                    <button class="btn btn-sm action-edit">Editar</button>
                    <button class="btn btn-sm action-delete">Excluir</button>
                </td>
            </tr>
        </tbody>
    </table>
</div>
```

### **Modais**
```html
<!-- Template de modal -->
<div class="modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Título do Modal</h4>
                <button class="modal-close action-close">×</button>
            </div>
            <div class="modal-body">
                <p class="modal-message">Mensagem do modal</p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary action-confirm">Confirmar</button>
                <button class="btn btn-secondary action-cancel">Cancelar</button>
            </div>
        </div>
    </div>
</div>
```

---

## 🎯 **Classes Específicas do SER**

### **Módulos do Sistema**
```css
/* Diagnóstico */
.diagnostic-container { }
.diagnostic-section-engagement { }
.diagnostic-section-leadership { }
.diagnostic-result-card { }

/* Planejamento */
.planning-canvas { }
.planning-goal-item { }
.planning-roadmap { }

/* Comitês */
.committee-card { }
.committee-member-list { }
.committee-meeting-item { }

/* KPIs */
.kpi-dashboard { }
.kpi-metric-card { }
.kpi-chart-container { }

/* Feedback */
.feedback-form { }
.feedback-question-item { }
.feedback-result-summary { }

/* Avaliação */
.evaluation-criteria { }
.evaluation-score-item { }
.evaluation-report { }
```

### **Estados e Status**
```css
/* Status específicos do SER */
.status-pilot { }           /* Status: Piloto */
.status-in-progress { }     /* Status: Em Andamento */
.status-completed { }       /* Status: Concluído */
.status-not-started { }     /* Status: Não Iniciado */

/* Níveis de maturidade */
.maturity-basic { }         /* Básico */
.maturity-intermediate { }  /* Intermediário */
.maturity-advanced { }      /* Avançado */
```

---

## 🔧 **Ferramentas de Desenvolvimento**

### **CSS Linting Rules**
```css
/* Regras para validar nomenclatura */
/* 
- Classes devem seguir padrão kebab-case
- Usar prefixos semânticos: page-, section-, action-, nav-, etc.
- Evitar classes por aparência: .text-blue, .margin-10, etc.
- Preferir classes por função: .status-label, .action-button, etc.
*/
```

### **Comentários Orientativos**
```css
/* 
TODO I18N: Esta classe será mapeada para data-i18n
Contexto: páginas de usuário
Chave sugerida: pages.users.create_title
*/
.users-create-title {
    font-size: 1.5rem;
    font-weight: bold;
}
```

---

## 📊 **Relatório de Cobertura Futura**

### **Elementos Identificáveis**
```css
/* Categorias que terão detecção automática */
.page-*          /* Títulos de página */
.section-*       /* Títulos de seção */
.action-*        /* Botões de ação */
.nav-*           /* Links de navegação */
.label-*         /* Labels de campo */
.message-*       /* Mensagens do sistema */
.status-*        /* Labels de status */
.module-*        /* Elementos específicos do SER */
```

### **Script de Análise**
```bash
# Comando para analisar cobertura CSS → I18n
php scripts/analyze-css-coverage.php
# Output: Relatório de elementos identificáveis vs não identificáveis
```

---

**Objetivo:** Garantir que toda interface construída com essas classes CSS possa ser automaticamente identificada e preparada para internacionalização quando necessário.