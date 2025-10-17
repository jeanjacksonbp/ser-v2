# PROJECT BRIEF — SER v2

> **Objetivo:** SaaS para implantar Gestão Participativa (baseado em “Empresas de Alto Desempenho” e no material “Treinamento — Gestão Participativa”), com trilha de autorização **RBAC + ABAC**, auditoria, KPIs e fluxo de atas/pareceres.

---

## 1) Status atual (MVP)
- **Stack:** PHP 8.3, MySQL/MariaDB, Composer. Document root em `public/`.
- **Repositório:** estrutura inicial criada (`public/`, `src/`, `resources/views/`, `database/sql/`, `docs/`).
- **Ambiente local:** domínio `ser-v2.local` funcional (VirtualHost apontando para `public/`).
- **Banco:** scripts `01_schema_up_*`, `02_seed_data.sql` aplicados; `04_auth_mvp.sql` disponível.
- **Auth MVP (em desenvolvimento):** `ActorContext`, `Guard`, `ScopeMiddleware`, `MinutesPolicy` prontos para integração.

> Referências auxiliares: `docs/cheatsheet-vscode-pr.md`, `docs/deploy-production.md` (adicionar via PR).

---

## 2) Arquitetura (visão geral)
- **Front (server-rendered):** layout com `header`, `sidebar`, `footer` ✅ (preservar).
- **Router/Controllers:** endpoints simples em `public/` + `src/Controllers/` (MVP).
- **Auth:** 
  - **RBAC**: ações de domínio em `acoes` e concessões em `permissoes_acoes` (por `perfil` e opcionalmente por `id_empresa`).
  - **ABAC/Scopes**: `role_scopes` com tipos (`org`, `committee`, `kpi`, `unit`, `resource`) e `ref_id`.
  - **Middleware:** `ScopeMiddleware` resolve usuário → empresa → roles → scopes e popula `$GLOBALS['actor']`.
  - **Guard:** `Guard::can('acao')` valida autorização por ação.
  - **Policy:** Regras por recurso (ex.: `MinutesPolicy::publish($actor, $committeeId, $statusAtual)`).
- **Auditoria:** `audit_logs` (quem/que/onde/payload/timestamp).
- **KPIs:** leitura/lançamento com papéis (ex.: `OwnerKPI`) + escopos `kpi:{id}`.

---

## 3) Convenções do repositório
- **Branches:** `feat/*` (funcionalidade), `fix/*` (correção), `chore/*` (infra/docs), `docs/*` (documentação).
- **PRs pequenos** com “Como validar” (passos de teste + dados de exemplo).
- **Padrões:** `.editorconfig` (LF, indentação 2) e `.gitattributes` (normalizar EOL). `.env` **não versionado**; apenas `/.env.example` e `/.env.production.example`.
- **CI (futuro próximo):** build PHP, lint, testes e (opcional) checagem SQL (MySQL container).

---

## 4) Itens do MVP (escopo fechado)
1. **Autorização base (RBAC+ABAC):** Guard + Middleware + Policy para atas.
2. **Atas:** listar, editar rascunho e **publicar** (`minutes.publish`) com auditoria.
3. **KPIs:** leitura (`kpi.read`) e lançamento (`kpi.write_reading`) com escopo por KPI.
4. **Páginas protegidas:** menu/rotas respeitando `Guard::can()` e policies (sem quebrar layout).
5. **Logs:** `audit_logs` em toda ação sensível (publish, parecer, kpi write).

---

## 5) Próximos PRs (ordem sugerida)
- **PR #1 — docs/deploy-guide**  
  `docs/deploy-production.md` + `/.env.production.example` (documentação de produção).

- **PR #2 — feature/auth-mvp**  
  `core/Auth/ActorContext.php`, `core/Auth/Guard.php`, `core/Http/ScopeMiddleware.php`, `core/Policies/MinutesPolicy.php`, SQL `04_auth_mvp.sql`, wire no bootstrap, exemplo de proteção de página.

- **PR #3 — feat/minutes-publish-endpoint**  
  `POST /minutes/{id}/publish` (controller + update de status + `audit_logs`), botão no front (visível se policy permitir), passos de validação com `curl`.

- **PR #4 — feat/kpi-basic**  
  leitura/lançamento inicial de KPIs, seeds de `kpi.*` e exemplo de escopo `kpi:{id}`.

- **PR #5 — docs/troubleshoot-migration**  
  Checklist de diagnóstico para ambientes (Apache/Nginx/PHP/DB/hosts/DNS/logs).

---

## 6) Riscos & decisões
- **Ambiente Windows (CRLF/LF):** mitigado com `.gitattributes` e `.editorconfig`.
- **Segurança de env:** `.env` fora do versionamento; bloquear acesso a arquivos sensíveis no servidor web.
- **Document root:** sempre em `public/` (produção e desenvolvimento).

---

## 7) Glossário rápido
- **RBAC:** Role-Based Access Control (por papéis).
- **ABAC/Scopes:** Attribute-Based Access Control (pelo contexto/escopos tipo `committee:{id}`).
- **Policy:** regra de negócio específica por recurso/ação.
- **Guard:** verificador de permissão por ação (`Guard::can('acao')`).

---

## 8) Como contribuir (VS Code, padrão)
1. Criar branch: `feat/...`, `fix/...`, `chore/...` ou `docs/...`  
2. Commitar mudanças com mensagens claras.  
3. Push da branch → **Create Pull Request** (base: `main`).  
4. PR com **“Como validar”** (passos e dados).  
5. CI verde → Merge → Delete branch.

---

**Owner:** @jeanjacksonbp  
**Última atualização:** (preencher na criação do PR)
