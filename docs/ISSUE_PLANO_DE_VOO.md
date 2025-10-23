# Plano de Voo — SER v2 (fixar/pinar)

Use esta issue como checklist de acompanhamento. Marque os itens conforme forem concluídos, linkando os PRs.

## Concluído ✅
- [x] **Interface base responsiva** (Bootstrap 5.3.3 + Font Awesome)
- [x] **Auth MVP integrado** (Guard + Middleware + Policy em `src/Core/`)
- [x] **Estrutura limpa** (PSR-4, bootstrap único, URLs helpers)
- [x] **Login responsivo** (mobile/tablet/desktop)

## Backlog imediato
- [ ] `docs/deploy-production.md` + `.env.production.example` (**PR #1: docs/deploy-guide**)
- [ ] Endpoint `POST /minutes/{id}/publish` com `audit_logs` (**PR #2**)
- [ ] Páginas Atas (listar/editar) - **RESPONSIVAS** (**PR #3**)
- [ ] KPIs (leitura + lançamento) com escopos `kpi:{id}` - **RESPONSIVAS** (**PR #4**)
- [ ] `docs/troubleshoot-migration.md` (**PR #5**)

## Checklist geral (sempre)
- [x] `public/` como document root
- [x] `.env` correto (local/produção)
- [x] Estrutura PSR-4 em `src/` 
- [x] Bootstrap 5.3.3 + responsividade mobile-first
- [ ] Seeds e migrações SQL aplicadas
- [ ] **TODAS as páginas responsivas** (mobile/tablet/desktop)
- [ ] Páginas e menus respeitando `Guard::can()`
- [ ] Auditoria em ações sensíveis
- [ ] CI verde (quando configurado)
- [ ] Releases anotadas no README

## Padrões de UI obrigatórios 🎨
- **Framework:** Bootstrap 5.3.3 + Font Awesome 6.5.0
- **Responsividade:** Mobile-first (576px, 768px, 992px breakpoints)
- **Cores:** Gradiente azul SER (#1e3a8a → #3b82f6)
- **Helpers:** Usar `url()` e `asset()` para caminhos
- **Teste:** Validar em mobile, tablet e desktop

> Dica: manter esta issue **fixada/pinada** para ser o ponto único de status.
