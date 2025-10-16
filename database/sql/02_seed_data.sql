-- PERFIS (roles)
INSERT IGNORE INTO perfis (id, nome) VALUES
  (1,'Admin'),(2,'CoordComite'),(3,'Diretoria'),(4,'Membro');

-- USUÁRIO de teste (id=1). Ajuste email/nome se quiser.
INSERT IGNORE INTO usuarios (id, id_empresa, nome, email)
VALUES (1, 1, 'Usuário de Teste', 'teste@example.com');

-- USER_ROLES: usuário 1 como Admin e CoordComite
INSERT IGNORE INTO user_roles (user_id, role_id) VALUES
  (1, 1), -- Admin
  (1, 2); -- CoordComite

-- AÇÕES de domínio
INSERT IGNORE INTO acoes (chave, descricao) VALUES
  ('minutes.view','Ver atas'),
  ('minutes.update','Editar atas (rascunho)'),
  ('minutes.publish','Publicar atas');

-- PERMISSÕES por perfil (org-wide, id_empresa NULL)
-- Admin + CoordComite podem ver/editar/publicar atas
INSERT INTO permissoes_acoes (perfil_id, acao_id, id_empresa, permitido)
SELECT p.id, a.id, NULL, 1
FROM perfis p JOIN acoes a
WHERE p.nome IN ('Admin','CoordComite')
  AND a.chave IN ('minutes.view','minutes.update','minutes.publish')
  AND NOT EXISTS (
    SELECT 1 FROM permissoes_acoes pa
    WHERE pa.perfil_id = p.id AND pa.acao_id = a.id AND pa.id_empresa IS NULL
  );

-- ESCOPO (ABAC): usuário 1 vinculado ao committee:12 (exemplo)
-- troque 12 pelo ID real do seu comitê quando existir
INSERT INTO role_scopes (user_id, role_id, type, ref_id)
SELECT 1, 2, 'committee', 12
WHERE NOT EXISTS (
  SELECT 1 FROM role_scopes WHERE user_id=1 AND role_id=2 AND type='committee' AND ref_id=12
);
