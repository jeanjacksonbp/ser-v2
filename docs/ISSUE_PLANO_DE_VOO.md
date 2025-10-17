# Plano de Voo — SER v2 (fixar/pinar)

Use esta issue como checklist de acompanhamento. Marque os itens conforme forem concluídos, linkando os PRs.

## Backlog imediato
- [ ] `docs/deploy-production.md` + `.env.production.example` (**PR #1: docs/deploy-guide**)
- [ ] Auth MVP integrado (Guard + Middleware + Policy + SQL `04_auth_mvp.sql`) (**PR #2**)
- [ ] Endpoint `POST /minutes/{id}/publish` com `audit_logs` (**PR #3**)
- [ ] KPIs (leitura + lançamento) com escopos `kpi:{id}` (**PR #4**)
- [ ] `docs/troubleshoot-migration.md` (**PR #5**)

## Checklist geral (sempre)
- [ ] `public/` como document root
- [ ] `.env` correto (local/produção)
- [ ] Seeds e migrações SQL aplicadas
- [ ] Páginas e menus respeitando `Guard::can()`
- [ ] Auditoria em ações sensíveis
- [ ] CI verde (quando configurado)
- [ ] Releases anotadas no README

> Dica: manter esta issue **fixada/pinada** para ser o ponto único de status.
