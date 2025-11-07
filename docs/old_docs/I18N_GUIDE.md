# 🌍 Guia de Internacionalização - SER v2

## 📋 **Controle de Tradução**

### **Status por Idioma**
- ✅ **Português (pt-BR)**: 100% - Completo
- 🟡 **Inglês (en-US)**: 60% - Em andamento  
- 🔴 **Espanhol (es-ES)**: 30% - Básico

---

## 🛠️ **Como Adicionar Novas Traduções**

### **1. Para Desenvolvedores**
```html
<!-- Marcar elemento para tradução -->
<h1 data-i18n="pages.dashboard.title">Dashboard</h1>
<button data-i18n="common.save">Salvar</button>
<input data-i18n-placeholder="common.search" placeholder="Buscar...">
```

### **2. Para Tradutores**
```json
// Adicionar em assets/data/translations.json
{
  "pt-BR": {
    "nova_secao": {
      "titulo": "Novo Título",
      "descricao": "Nova descrição aqui"
    }
  }
}
```

---

## 📊 **Estrutura de Chaves**

### **Organização Hierárquica**
```
common.*          → Textos comuns (botões, mensagens)
navigation.*      → Menu e navegação
header.*          → Cabeçalho e controles
pages.{pagina}.*  → Conteúdo específico de cada página
footer.*          → Rodapé
```

### **Convenções de Nomenclatura**
- **snake_case** para chaves: `quick_access`, `user_menu`
- **Hierarquia clara**: `pages.dashboard.title`
- **Contexto específico**: `buttons.save` vs `common.save`

---

## 🎯 **Procedimento para Novos Conteúdos**

### **Passo 1: Criar Conteúdo em Português**
```html
<div class="card">
  <h5 data-i18n="pages.nova_pagina.titulo">Título da Nova Página</h5>
  <p data-i18n="pages.nova_pagina.descricao">Descrição da funcionalidade</p>
</div>
```

### **Passo 2: Adicionar Chaves no JSON**
```json
{
  "pt-BR": {
    "pages": {
      "nova_pagina": {
        "titulo": "Título da Nova Página",
        "descricao": "Descrição da funcionalidade"
      }
    }
  },
  "en-US": {
    "pages": {
      "nova_pagina": {
        "titulo": "[PENDENTE] New Page Title",
        "descricao": "[PENDENTE] Feature description"
      }
    }
  },
  "es-ES": {
    "pages": {
      "nova_pagina": {
        "titulo": "[PENDIENTE] Título de Nueva Página",
        "descricao": "[PENDIENTE] Descripción de funcionalidad"
      }
    }
  }
}
```

### **Passo 3: Testar**
```javascript
// No console do navegador
I18n.setLanguage('en-US');
I18n.getMissingKeys(); // Ver chaves faltantes
```

---

## 📝 **Lista de Tarefas Pendentes**

### **Português (pt-BR) - COMPLETO ✅**
- [x] Navegação
- [x] Dashboard  
- [x] Diagnóstico
- [x] Planejamento
- [x] Comitês
- [x] KPIs
- [x] Feedback
- [x] Avaliação

### **Inglês (en-US) - EM ANDAMENTO 🟡**
- [x] Navegação
- [x] Dashboard
- [x] Diagnóstico
- [x] Planejamento
- [ ] Comitês (50%)
- [ ] KPIs (0%)
- [ ] Feedback (0%) 
- [ ] Avaliação (0%)

### **Espanhol (es-ES) - BÁSICO 🔴**
- [x] Navegação
- [x] Dashboard
- [x] Diagnóstico
- [ ] Planejamento (0%)
- [ ] Comitês (0%)
- [ ] KPIs (0%)
- [ ] Feedback (0%)
- [ ] Avaliação (0%)

---

## 🔧 **Comandos Úteis**

### **Ver Chaves Faltantes**
```javascript
// No console do navegador
I18n.getMissingKeys()
```

### **Exportar Template para Tradução**
```javascript
// Gera template JSON com chaves faltantes
I18n.exportMissingKeys()
```

### **Verificar Idioma Atual**
```javascript
I18n.currentLanguage // "pt-BR"
```

---

## 📁 **Estrutura de Arquivos**

```
prototype/
├── assets/
│   ├── js/
│   │   └── i18n.js          # Sistema de tradução
│   └── data/
│       └── translations.json # Arquivo de traduções
├── components/
│   └── header.html          # Seletor de idioma
└── docs/
    └── I18N_GUIDE.md        # Este arquivo
```

---

## 🎨 **Interface do Seletor de Idioma**

### **Estados Visuais**
- 🇧🇷 **PT** - Português ativo
- 🇺🇸 **EN** - English disponível
- 🇪🇸 **ES** - Español disponível

### **Funcionalidades**
- ✅ Dropdown no header
- ✅ Persistência via localStorage
- ✅ Atualização automática do DOM
- ✅ Ícones de bandeiras
- ✅ Indicador de idioma atual

---

## 🚀 **Próximos Passos**

1. **Completar traduções** em inglês e espanhol
2. **Implementar backend** PHP para gestão via admin
3. **Adicionar mais idiomas** conforme demanda
4. **Tradução profissional** para textos críticos
5. **Testes de usabilidade** com usuários de diferentes idiomas

---

**Responsável**: Equipe de Desenvolvimento SER v2  
**Última atualização**: Outubro 2025