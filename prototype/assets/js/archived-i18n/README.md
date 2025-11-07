# Arquivos de I18n - Sistema de Internacionalização

## 📋 **Conteúdo desta pasta**

Esta pasta contém os arquivos do sistema de internacionalização que foi desenvolvido durante o protótipo, mas foi removido da versão atual para manter o foco no desenvolvimento em português.

### **Arquivos Arquivados:**

1. **`i18n.js`** - Sistema complexo de internacionalização com carregamento JSON
2. **`simple-i18n.js`** - Sistema simples com traduções inline
3. **`hybrid-i18n.js`** - Sistema híbrido (JSON + fallback inline)
4. **`translations.json`** - Arquivo com traduções em PT/EN/ES

## 🎯 **Por que foram removidos?**

- **Foco no desenvolvimento:** Protótipo deve ser simples e direto em português
- **Evitar confusão:** Não misturar preocupações de i18n com design/UX
- **Baseamento futuro:** Quando o projeto PHP for baseado no protótipo, não haverá elementos confusos de tradução

## 🚀 **Quando usar novamente?**

Estes arquivos serão úteis quando o projeto principal PHP estiver pronto e decidirmos implementar internacionalização:

1. **Sistema Simples (`simple-i18n.js`)** - Para testes rápidos
2. **Sistema Híbrido (`hybrid-i18n.js`)** - Para produção (recomendado)
3. **Traduções (`translations.json`)** - Como base para estrutura de dados

## 📚 **Documentação Completa**

A documentação completa sobre internacionalização está em:
- `docs/development-guidelines/` - Diretrizes para projeto PHP
- `docs/HYBRID_I18N_SYSTEM.md` - Documentação do sistema híbrido

## ⚡ **Recuperação Rápida**

Para reativar o sistema i18n no protótipo:

```bash
# Voltar arquivos para pasta original
Move-Item "C:\xampp\htdocs\ser-v2\prototype\assets\js\archived-i18n\*.js" "C:\xampp\htdocs\ser-v2\prototype\assets\js\"
Move-Item "C:\xampp\htdocs\ser-v2\prototype\assets\js\archived-i18n\translations.json" "C:\xampp\htdocs\ser-v2\prototype\assets\data\"

# Adicionar script no HTML
<script src="assets/js/hybrid-i18n.js"></script>

# Adicionar seletor de idioma no header
# (Ver backup dos componentes se necessário)
```

---

**Status:** Arquivado temporariamente para manter protótipo focado em português.  
**Objetivo:** Preservar trabalho realizado para uso futuro quando necessário.