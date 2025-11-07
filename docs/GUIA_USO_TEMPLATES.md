# 📋 GUIA DE USO DOS TEMPLATES - SER v2.0

## 🎯 **TEMPLATES DISPONÍVEIS**

### 📁 **Templates Base (Mínimos)**
- `TEMPLATE_PAGINA_BASE.php` - Controller mínimo
- `TEMPLATE_VIEW_BASE.php` - View mínima

### 🏗️ **Templates Completos (Recomendados)**
- `TEMPLATE_PAGINA_COMPLETA.php` - Controller com exemplos
- `TEMPLATE_VIEW_COMPLETA.php` - View com layout completo

---

## 🚀 **COMO CRIAR UMA NOVA PÁGINA**

### **Passo 1: Controller**
```bash
# Copie o template do controller
cp docs/TEMPLATE_PAGINA_COMPLETA.php public/diagnostico-analise-financeira.php
```

### **Passo 2: View**  
```bash
# Copie o template da view
cp docs/TEMPLATE_VIEW_COMPLETA.php resources/views/pages/diagnostico-analise-financeira.php
```

### **Passo 3: Personalizar Controller**
Abra `public/diagnostico-analise-financeira.php` e altere:

```php
// [PERSONALIZAR] - Definir permissão específica da página
$requiredPermission = 'view_financial_analysis'; // ✅ OK para análise financeira

// [PERSONALIZAR] - Dados específicos da página
$pageData = [
    'pageTitle' => 'Análise Financeira', // ✅ Altere aqui
    'breadcrumbs' => [
        ['name' => 'Dashboard', 'url' => '/ser-v2/public/dashboard.php'],
        ['name' => 'Diagnóstico', 'url' => null],
        ['name' => 'Análise Financeira', 'url' => null] // ✅ Altere aqui
    ]
];

// ✅ 10. Include View (footer já incluído na view)
include __DIR__ . '/../resources/views/pages/diagnostico-analise-financeira.php'; // ✅ Altere aqui
```

### **Passo 4: Personalizar View**
Abra `resources/views/pages/diagnostico-analise-financeira.php` e substitua:

- Seções marcadas com `[PERSONALIZAR]`
- Conteúdo de exemplo por dados reais
- Cards, tabelas e gráficos conforme necessário

---

## 📐 **ESTRUTURA PADRÃO**

### **Controller (public/nome-pagina.php)**
```
1. ✅ Bootstrap + Auth
2. ✅ Permission Check  
3. ✅ Load User Data
4. ✅ Build Sidebar Modules
5. ✅ Prepare Dashboard Data
6. [PERSONALIZAR] Page Data
7. ✅ Include View
```

### **View (resources/views/pages/nome-pagina.php)**
```
1. ✅ Header + Sidebar
2. ✅ Breadcrumb  
3. ✅ Page Header
4. [PERSONALIZAR] Content
5. ✅ Footer
```

---

## ⚡ **COMPONENTES INCLUÍDOS**

### **Sidebar Responsivo**
- ✅ Desktop: Retrátil com botão toggle
- ✅ Mobile: Offcanvas com hamburger
- ✅ Estado persistente (localStorage)

### **Layout Responsivo** 
- ✅ Bootstrap 5.3.3 + Font Awesome 6.5.0
- ✅ Cards, tabelas, formulários
- ✅ Breadcrumbs automáticos

### **Autenticação Integrada**
- ✅ Guard system automático
- ✅ Permission checks
- ✅ User context
- ✅ Debug info (SuperAdmin)

### **CSS Customizado**
- ✅ dashboard.css com melhorias
- ✅ Transições suaves
- ✅ Design consistente

---

## 🎨 **CUSTOMIZAÇÕES COMUNS**

### **Alterar Permissão**
```php
$requiredPermission = 'view_operational_analysis'; // Para página operacional
```

### **Adicionar ao Sidebar**
```php
if ($canViewOperational) {
    $modules['diagnostico']['items'][] = [
        'name' => 'Análise Operacional',
        'url' => '/ser-v2/public/diagnostico-analise-operacional.php',
        'icon' => 'fa-cogs'
    ];
}
```

### **Cards de Estatísticas** 
```php
// Na view, seção [PERSONALIZAR]
<div class="col-md-3">
  <div class="card text-center">
    <div class="card-body">
      <i class="fa fa-chart-line fa-2x text-primary mb-2"></i>
      <h5 class="card-title">Receita Total</h5>
      <p class="card-text">
        <span class="h4">R$ 150.000,00</span>
        <small class="text-success d-block">+12% vs mês anterior</small>
      </p>
    </div>
  </div>
</div>
```

---

## 📝 **EXEMPLO COMPLETO**

### **Arquivo: public/diagnostico-analise-financeira.php**
```php
<?php
$requiredPermission = 'view_financial_analysis';
require_once __DIR__ . '/../bootstrap/app.php';
$guard->requireAuth();
$guard->requirePermission($requiredPermission);
// ... resto do template ...
$pageData = [
    'pageTitle' => 'Análise Financeira',
    'breadcrumbs' => [
        ['name' => 'Dashboard', 'url' => '/ser-v2/public/dashboard.php'],
        ['name' => 'Diagnóstico', 'url' => null],
        ['name' => 'Análise Financeira', 'url' => null]
    ]
];
include __DIR__ . '/../resources/views/pages/diagnostico-analise-financeira.php';
?>
```

---

## ✅ **CHECKLIST DE NOVA PÁGINA**

- [ ] Controller copiado e personalizado
- [ ] View copiada e personalizada  
- [ ] Permissão definida corretamente
- [ ] pageTitle e breadcrumbs atualizados
- [ ] Include path correto
- [ ] Itens adicionados ao sidebar (se necessário)
- [ ] Conteúdo específico implementado
- [ ] Testado com diferentes usuários/perfis

---

**🎯 Com estes templates, criar novas páginas é rápido, seguro e padronizado!**