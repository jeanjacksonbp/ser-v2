# 📚 Documentação SER v2.0

## 🎯 Documentos Ativos (Desenvolvimento)

### Essenciais para Desenvolvimento
- **`GUIA_RETOMADA.md`** - 🚀 Para retomar projeto após pausa (⭐ INÍCIO)
- **`SISTEMA_PROVA_FALHAS.md`** - 🛡️ REGRAS ABSOLUTAS - Leia PRIMEIRO (⭐ OBRIGATÓRIO)
- **`ARCHITECTURE_MASTER.md`** - Diretrizes arquiteturais consolidadas (⭐ Principal)
- **`DEV_CHECKLIST.md`** - Checklist prático para desenvolvimento (⭐ Consulta diária)

---

## 📂 Estrutura Organizada

```
docs/
├── README.md                    # Este arquivo (índice)
├── ARCHITECTURE_MASTER.md       # ⭐ Documento principal - diretrizes completas
├── DEV_CHECKLIST.md            # ⭐ Checklist prático para desenvolvimento
└── old_docs/                   # 📁 Documentação de referência/histórica
    ├── PROJECT_BRIEF.md         # Brief original do projeto
    ├── ISSUE_PLANO_DE_VOO.md    # Issue inicial do plano de voo
    ├── I18N_GUIDE.md           # Guia de internacionalização
    ├── HYBRID_I18N_SYSTEM.md   # Sistema híbrido de i18n
    ├── deploy-production.md     # Guia de deploy em produção
    ├── development-guidelines/  # Guidelines detalhadas de desenvolvimento
    │   ├── README.md
    │   ├── automation-scripts.md
    │   ├── css-semantic-patterns.md
    │   ├── i18n-preparation.md
    │   └── message-templates.md
    └── prompts/                 # Prompts utilizados no desenvolvimento
        └── chat-prompts.md
```

---

## 🚀 Fluxo de Trabalho

### Para Desenvolver uma Nova Página:
1. **🚨 OBRIGATÓRIO**: `SISTEMA_PROVA_FALHAS.md` (regras absolutas)
2. **Consulte**: `DEV_CHECKLIST.md` (checklist rápido)  
3. **Referência**: `ARCHITECTURE_MASTER.md` (detalhes completos)
4. **Valide**: `validador-sistema.php` (antes de testar)
5. **Implemente**: Seguindo EXATAMENTE o template sagrado
6. **Atualize**: Os documentos com novas descobertas

### Para Consultas Específicas:
- **Arquitetura Geral**: `ARCHITECTURE_MASTER.md`
- **Processo de Desenvolvimento**: `DEV_CHECKLIST.md`
- **Contexto Histórico**: `old_docs/PROJECT_BRIEF.md`
- **Sistema i18n**: `old_docs/I18N_GUIDE.md`
- **Deploy**: `old_docs/deploy-production.md`

---

## 📋 Status dos Documentos

| Documento | Status | Uso |
|-----------|--------|-----|
| ARCHITECTURE_MASTER.md | ✅ Ativo | Referência principal |
| DEV_CHECKLIST.md | ✅ Ativo | Consulta diária |
| old_docs/* | 📚 Arquivo | Consulta eventual |

---

## 🔄 Manutenção

- **ARCHITECTURE_MASTER.md**: Atualizar quando descobrir novos requisitos
- **DEV_CHECKLIST.md**: Atualizar template conforme padrões evolem
- **old_docs/**: Manter para referência histórica

---

**💡 Dica**: Sempre comece consultando o `DEV_CHECKLIST.md` para desenvolvimento rápido!