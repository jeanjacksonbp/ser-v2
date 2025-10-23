# PROJECT BRIEF — SER v2

> **Objetivo:** SaaS para implantar Gestão Participativa (baseado em “Empresas de Alto Desempenho” e no material “Treinamento — Gestão Participativa”), com trilha de autorização **RBAC + ABAC**, auditoria, KPIs e fluxo de atas/pareceres.

---

## 1) Status atual (MVP)
- **Stack:** PHP 8.3, MySQL/MariaDB, Composer. Document root em `public/`.
- **Estrutura:** `src/` (classes PSR-4), `resources/views/` (templates), `public/` (assets + entry point).
- **Bootstrap:** unificado em `bootstrap/app.php` com helpers `url()` e `asset()`.
- **Interface:** Bootstrap 5.3.3 + Font Awesome, design responsivo implementado.
- **Ambiente local:** `http://localhost/ser-v2/public/` funcional, redirecionamento em `/ser-v2/`.
- **Banco:** scripts `01_schema_up_*`, `02_seed_data.sql` aplicados; `04_auth_mvp.sql` disponível.
- **Auth MVP:** `Guard`, `ScopeMiddleware`, `MinutesPolicy` integrados em `src/Core/`.

> Referências auxiliares: `docs/cheatsheet-vscode-pr.md`, `docs/deploy-production.md` (adicionar via PR).

---

## 2) Arquitetura (visão geral)
- **Front (server-rendered):** 
  - Layout responsivo com `header`, `footer` (Bootstrap 5.3.3) ✅
  - **Responsividade obrigatória**: Mobile-first, breakpoints: 576px, 768px, 992px
  - Views em `resources/views/` (auth/, layouts/, pages/)
- **Router:** `public/index.php` com roteamento simples + helpers `url()` e `asset()`.
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
- **PRs pequenos** com "Como validar" (passos de teste + dados de exemplo).
- **Padrões:** 
  - `.editorconfig` (LF, indentação 2) e `.gitattributes` (normalizar EOL)
  - **PSR-4**: Classes em `src/` namespace `App\`
  - **Responsividade**: Todas as novas páginas DEVEM ser mobile-first
  - **Bootstrap 5.3.3**: Framework UI padrão + Font Awesome para ícones
- **Environment:** `.env` **não versionado**; apenas `/.env.example` e `/.env.production.example`.
- **CI (futuro próximo):** build PHP, lint, testes e (opcional) checagem SQL (MySQL container).

---

## 4) Itens do MVP (escopo fechado)
1. **Interface base:** ✅ Login responsivo + Header/Footer Bootstrap implementados
2. **Autorização base (RBAC+ABAC):** ✅ Guard + Middleware + Policy para atas integrados
3. **Atas:** listar, editar rascunho e **publicar** (`minutes.publish`) com auditoria
4. **KPIs:** leitura (`kpi.read`) e lançamento (`kpi.write_reading`) com escopo por KPI
5. **Páginas protegidas:** menu/rotas respeitando `Guard::can()` e policies 
6. **Logs:** `audit_logs` em toda ação sensível (publish, parecer, kpi write)
7. **Responsividade:** Todas as páginas funcionais em mobile/tablet/desktop

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

## 6) Padrões de Interface (UI/UX)
- **Framework:** Bootstrap 5.3.3 (CDN) + Font Awesome 6.5.0 para ícones
- **Responsividade obrigatória:**
  - Mobile-first design (min-width breakpoints)
  - Breakpoints: 576px (sm), 768px (md), 992px (lg), 1200px (xl)
  - Todos os formulários e tabelas devem ser responsivos
- **Cores padrão:** Gradiente azul `#1e3a8a → #3b82f6` (identidade SER)
- **Componentes reutilizáveis:**
  - Header: navegação responsiva + dropdown usuário
  - Forms: campos com ícones + validação visual
  - Botões: estilo consistente com hover effects
- **Helpers disponíveis:**
  - `url('caminho')`: URLs com base correta
  - `asset('arquivo')`: Assets (CSS/JS/imagens)

---

## 7) Riscos & decisões
- **Ambiente Windows (CRLF/LF):** mitigado com `.gitattributes` e `.editorconfig`.
- **Estrutura limpa:** ✅ Removidas pastas `app/` e `bootstrap/bootstrap.php` obsoletos
- **Segurança de env:** `.env` fora do versionamento; bloquear acesso a arquivos sensíveis no servidor web.
- **Document root:** sempre em `public/` (produção e desenvolvimento).

---

## 8) Glossário rápido
- **RBAC:** Role-Based Access Control (por papéis).
- **ABAC/Scopes:** Attribute-Based Access Control (pelo contexto/escopos tipo `committee:{id}`).
- **Policy:** regra de negócio específica por recurso/ação.
- **Guard:** verificador de permissão por ação (`Guard::can('acao')`).

---

## 9) Como contribuir (VS Code, padrão)
1. Criar branch: `feat/...`, `fix/...`, `chore/...` ou `docs/...`  
2. Commitar mudanças com mensagens claras.  
3. Push da branch → **Create Pull Request** (base: `main`).  
4. PR com **“Como validar”** (passos e dados).  
5. CI verde → Merge → Delete branch.

---

**Owner:** @jeanjacksonbp  
**Última atualização:** 22/10/2025 - Estrutura limpa + Interface responsiva implementada
