# 🔄 Plano de Migração dos Protótipos

## 📋 Checklist de Integração

### **Fase 1: Preparação**
- [x] Protótipos HTML criados
- [x] CSS personalizado (`app.css`)
- [x] Design system documentado
- [ ] Aprovação do layout pelas partes interessadas
- [ ] Testes de responsividade concluídos

### **Fase 2: Migração Estrutural**
- [ ] Mover `prototype/assets/css/app.css` → `public/assets/css/app.css`
- [ ] Converter HTMLs para PHP views em `resources/views/pages/`
- [ ] Adaptar includes para usar `layouts/header.php` e `layouts/footer.php`
- [ ] Substituir links absolutos por helpers `url()` e `asset()`

### **Fase 3: Integração Backend**
- [ ] Adicionar autenticação (`Guard::can()`) nas páginas
- [ ] Conectar dados reais do banco
- [ ] Implementar formulários funcionais
- [ ] Adicionar validação e sanitização

### **Fase 4: Funcionalidades**
- [ ] CRUD de comitês
- [ ] Sistema de atas e aprovações
- [ ] Dashboard com dados reais
- [ ] KPIs com lançamento de dados
- [ ] Sistema de feedback

## 🗺️ Mapeamento de Arquivos

```
# Migração de Views
prototype/index.html      → resources/views/pages/dashboard.php
prototype/diagnostico.html → resources/views/pages/diagnostico.php
prototype/planejamento.html → resources/views/pages/planejamento.php
prototype/comites.html    → resources/views/pages/comites.php
prototype/kpis.html       → resources/views/pages/kpis.php
prototype/feedback.html   → resources/views/pages/feedback.php
prototype/avaliacao.html  → resources/views/pages/avaliacao.php

# Migração de Assets
prototype/assets/css/app.css → public/assets/css/app.css
```

## 🔧 Modificações Necessárias

### **1. Header/Footer**
```php
// Substituir header HTML por:
<?php require __DIR__ . '/../layouts/header.php'; ?>

// E footer por:
<?php require __DIR__ . '/../layouts/footer.php'; ?>
```

### **2. Links e Assets**
```php
// Substituir:
<a href="comites.html">
// Por:
<a href="<?= url('comites') ?>">

// Substituir:
<link rel="stylesheet" href="assets/css/app.css" />
// Por:
<link rel="stylesheet" href="<?= asset('css/app.css') ?>" />
```

### **3. Dados Dinâmicos**
```php
// Substituir dados estáticos por:
<?php foreach ($comites as $comite): ?>
  <tr>
    <td><?= htmlspecialchars($comite['nome']) ?></td>
    <td><?= htmlspecialchars($comite['coordenador']) ?></td>
    <!-- ... -->
  </tr>
<?php endforeach; ?>
```

## 🎯 Rotas a Implementar

```php
// Em public/index.php adicionar:

/** DASHBOARD */
if ($uri === '/dashboard' && $method === 'GET') {
  require __DIR__ . '/../resources/views/pages/dashboard.php';
  exit;
}

/** COMITÊS */
if ($uri === '/comites' && $method === 'GET') {
  // Verificar permissão
  if (!$guard->can('comites.view')) {
    header('Location: ' . url('dashboard'));
    exit;
  }
  require __DIR__ . '/../resources/views/pages/comites.php';
  exit;
}

/** KPIs */
if ($uri === '/kpis' && $method === 'GET') {
  if (!$guard->can('kpis.view')) {
    header('Location: ' . url('dashboard'));
    exit;
  }
  require __DIR__ . '/../resources/views/pages/kpis.php';
  exit;
}
```

## 📊 Estimativa de Tempo

| Fase | Atividade | Tempo Estimado |
|------|-----------|----------------|
| 1 | Aprovação e testes | 2-3 dias |
| 2 | Migração estrutural | 3-4 dias |
| 3 | Integração backend | 5-7 dias |
| 4 | Funcionalidades | 10-15 dias |
| **Total** | | **20-29 dias** |

## 🧪 Critérios de Aceitação

### **Cada página deve:**
- [ ] Carregar corretamente no sistema PHP
- [ ] Manter design idêntico ao protótipo
- [ ] Ser responsiva (mobile/tablet/desktop)
- [ ] Respeitar permissões de usuário
- [ ] Ter navegação funcional
- [ ] Carregar dados reais do banco
- [ ] Ter formulários funcionais (quando aplicável)

---

**Próximo PR sugerido**: `feat/migrate-dashboard-prototype`