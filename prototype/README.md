# 🎨 Protótipos SER v2

Esta pasta contém protótipos navegáveis das principais páginas do sistema SER v2 para teste de layout e UX.

## 📁 Estrutura

```
prototype/
├── index.html          # Dashboard principal
├── diagnostico.html    # Diagnóstico organizacional
├── planejamento.html   # Planejamento estratégico
├── comites.html        # Comitês e atas
├── kpis.html          # KPIs e indicadores
├── feedback.html      # Feedback e cultura
├── avaliacao.html     # Avaliação e melhoria
└── assets/
    └── css/
        └── app.css    # Estilos personalizados SER
```

## 🚀 Como Usar

### 1. **Desenvolvimento Local**
```bash
# Acesse diretamente via browser
http://localhost/ser-v2/prototype/index.html
```

### 2. **Live Server (VS Code)**
- Instale extensão "Live Server"
- Clique direito em `index.html` → "Open with Live Server"

## 🎨 Design System

### **Cores Principais**
```css
--ser-start: #1e3a8a  /* Azul escuro */
--ser-end: #3b82f6    /* Azul claro */
```

### **Componentes**
- **Header**: Blur com backdrop-filter
- **Sidebar**: Semi-transparente responsiva
- **Cards**: `rgba(255,255,255,0.10)` com border-radius 18px
- **Botões**: `rgba(255,255,255,0.18)` com hover effects

### **Breakpoints**
- **Mobile**: < 576px
- **Tablet**: 576px - 991px  
- **Desktop**: > 992px

## 🔄 Integração com PHP

### **Próximos Passos:**
1. **Converter HTML para PHP views** em `resources/views/pages/`
2. **Mover CSS** para `public/assets/css/`
3. **Adaptar navegação** com helpers `url()` e `asset()`
4. **Integrar autenticação** com Guards e Policies
5. **Conectar dados** do banco de dados

### **Estrutura de Migração:**
```
prototype/index.html → resources/views/pages/dashboard.php
prototype/comites.html → resources/views/pages/comites.php
prototype/kpis.html → resources/views/pages/kpis.php
prototype/assets/css/app.css → public/assets/css/app.css
```

## 🧪 Testes

### **Checklist de Validação:**
- [ ] **Responsividade**: Mobile, tablet, desktop
- [ ] **Navegação**: Links funcionais entre páginas
- [ ] **Acessibilidade**: Contraste, foco, labels
- [ ] **Performance**: Carregamento rápido
- [ ] **Consistência**: Design pattern uniforme

### **Browsers Testados:**
- [ ] Chrome/Edge (desktop)
- [ ] Firefox (desktop)
- [ ] Safari (macOS/iOS)
- [ ] Chrome Mobile (Android)

## 💡 Melhorias Sugeridas

### **UX/UI:**
1. **Menu mobile**: Hamburger para < 992px
2. **Breadcrumbs**: Navegação contextual
3. **Loading states**: Spinners para ações
4. **Toasts**: Feedback de ações do usuário
5. **Modal dialogs**: Confirmações e forms

### **Acessibilidade:**
1. **ARIA labels**: Screen readers
2. **Focus management**: Navegação por teclado
3. **Color contrast**: WCAG 2.1 AA
4. **Text scaling**: Zoom até 200%

### **Performance:**
1. **CSS minificado**: Reduzir tamanho
2. **Lazy loading**: Imagens e componentes
3. **Cache headers**: Otimizar recarregamentos

## 📝 Notas de Desenvolvimento

- **Framework**: Bootstrap 5.3.3 (CDN)
- **Ícones**: Font Awesome 6.5.0 (CDN)
- **Responsividade**: Mobile-first
- **Compatibilidade**: Modern browsers (ES6+)

---

**Próxima etapa**: Converter protótipos para views PHP integradas ao sistema de autenticação.