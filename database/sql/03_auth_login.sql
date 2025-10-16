-- 1) Adiciona coluna de senha (idempotente)
SET @col := (
  SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
  WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME='usuarios' AND COLUMN_NAME='senha_hash'
);
SET @sql := IF(@col=0,
  'ALTER TABLE usuarios ADD COLUMN senha_hash VARCHAR(255) NULL AFTER email',
  'SELECT "ok"'
);
PREPARE s FROM @sql; EXECUTE s; DEALLOCATE PREPARE s;

-- 2) Garante perfis base (seeds)
INSERT IGNORE INTO perfis (nome) VALUES ('SuperAdmin'),('AdminEmpresa');

-- 3) Garante um SuperAdmin (usuário 1) sem senha (vamos definir com script)
INSERT IGNORE INTO usuarios (id, id_empresa, nome, email)
VALUES (1, 1, 'Super Admin', 'superadmin@example.com');

INSERT IGNORE INTO user_roles (user_id, role_id)
SELECT 1, id FROM perfis WHERE nome='SuperAdmin';

-- 4) Garante um AdminEmpresa (usuário 2) sem senha
INSERT IGNORE INTO usuarios (id, id_empresa, nome, email)
VALUES (2, 10, 'Admin Empresa X', 'admin@empresa.com');

INSERT IGNORE INTO user_roles (user_id, role_id)
SELECT 2, id FROM perfis WHERE nome='AdminEmpresa';

-- 5) Painéis (RBAC) — ações e permissões, se ainda não existem
INSERT IGNORE INTO acoes (chave, descricao) VALUES
 ('dashboard.superadmin.view','Ver painel global (SuperAdmin)'),
 ('dashboard.org.view','Ver painel da organização (AdminEmpresa)');

INSERT INTO permissoes_acoes (perfil_id, acao_id, id_empresa, permitido)
SELECT p.id, a.id, NULL, 1
FROM perfis p, acoes a
WHERE p.nome='SuperAdmin' AND a.chave='dashboard.superadmin.view'
  AND NOT EXISTS (SELECT 1 FROM permissoes_acoes pa WHERE pa.perfil_id=p.id AND pa.acao_id=a.id AND pa.id_empresa IS NULL);

INSERT INTO permissoes_acoes (perfil_id, acao_id, id_empresa, permitido)
SELECT p.id, a.id, NULL, 1
FROM perfis p, acoes a
WHERE p.nome='AdminEmpresa' AND a.chave='dashboard.org.view'
  AND NOT EXISTS (SELECT 1 FROM permissoes_acoes pa WHERE pa.perfil_id=p.id AND pa.acao_id=a.id AND pa.id_empresa IS NULL);
