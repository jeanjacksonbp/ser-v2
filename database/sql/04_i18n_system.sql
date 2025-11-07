-- =====================================================
-- SISTEMA DE INTERNACIONALIZAÇÃO - SER v2
-- Estrutura de banco para múltiplos idiomas
-- =====================================================

-- Tabela principal de traduções
CREATE TABLE translations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    translation_key VARCHAR(255) NOT NULL COMMENT 'Chave hierárquica (ex: pages.dashboard.title)',
    language_code VARCHAR(5) NOT NULL COMMENT 'Código do idioma (pt-BR, en-US, es-ES)',
    value TEXT NOT NULL COMMENT 'Texto traduzido',
    context VARCHAR(100) NULL COMMENT 'Contexto/seção (navigation, common, pages)',
    status ENUM('active', 'pending', 'review', 'deprecated') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    created_by INT NULL COMMENT 'ID do usuário que criou',
    updated_by INT NULL COMMENT 'ID do usuário que atualizou',
    
    -- Índices para performance
    UNIQUE KEY unique_key_lang (translation_key, language_code),
    INDEX idx_language (language_code),
    INDEX idx_context (context),
    INDEX idx_status (status),
    INDEX idx_key (translation_key)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci 
COMMENT='Armazena todas as traduções do sistema';

-- Tabela de idiomas suportados
CREATE TABLE supported_languages (
    language_code VARCHAR(5) PRIMARY KEY,
    language_name VARCHAR(50) NOT NULL COMMENT 'Nome do idioma',
    native_name VARCHAR(50) NOT NULL COMMENT 'Nome nativo (Português, English)',
    flag_code VARCHAR(2) NOT NULL COMMENT 'Código da bandeira (BR, US, ES)',
    is_active BOOLEAN DEFAULT TRUE,
    is_default BOOLEAN DEFAULT FALSE,
    completion_percentage DECIMAL(5,2) DEFAULT 0.00 COMMENT 'Percentual de tradução completa',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
COMMENT='Configuração dos idiomas disponíveis';

-- Tabela de log de mudanças (auditoria)
CREATE TABLE translation_history (
    id INT AUTO_INCREMENT PRIMARY KEY,
    translation_id INT NOT NULL,
    translation_key VARCHAR(255) NOT NULL,
    language_code VARCHAR(5) NOT NULL,
    old_value TEXT NULL,
    new_value TEXT NOT NULL,
    action ENUM('create', 'update', 'delete') NOT NULL,
    changed_by INT NULL,
    changed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    INDEX idx_translation (translation_id),
    INDEX idx_key_lang (translation_key, language_code),
    INDEX idx_date (changed_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
COMMENT='Histórico de mudanças nas traduções';

-- =====================================================
-- DADOS INICIAIS
-- =====================================================

-- Inserir idiomas suportados
INSERT INTO supported_languages (language_code, language_name, native_name, flag_code, is_active, is_default, completion_percentage) VALUES
('pt-BR', 'Portuguese (Brazil)', 'Português', 'BR', TRUE, TRUE, 100.00),
('en-US', 'English (United States)', 'English', 'US', FALSE, FALSE, 0.00),
('es-ES', 'Spanish (Spain)', 'Español', 'ES', FALSE, FALSE, 0.00);

-- Inserir traduções básicas (apenas português inicialmente)
INSERT INTO translations (translation_key, language_code, value, context, status) VALUES
-- Navegação
('navigation.dashboard', 'pt-BR', 'Dashboard', 'navigation', 'active'),
('navigation.diagnostico', 'pt-BR', 'Diagnóstico', 'navigation', 'active'),
('navigation.planejamento', 'pt-BR', 'Planejamento', 'navigation', 'active'),
('navigation.comites', 'pt-BR', 'Comitês e Atas', 'navigation', 'active'),
('navigation.kpis', 'pt-BR', 'KPIs', 'navigation', 'active'),
('navigation.feedback', 'pt-BR', 'Feedback e Cultura', 'navigation', 'active'),
('navigation.avaliacao', 'pt-BR', 'Avaliação', 'navigation', 'active'),
('navigation.modules', 'pt-BR', 'Módulos', 'navigation', 'active'),

-- Comum
('common.save', 'pt-BR', 'Salvar', 'common', 'active'),
('common.cancel', 'pt-BR', 'Cancelar', 'common', 'active'),
('common.edit', 'pt-BR', 'Editar', 'common', 'active'),
('common.delete', 'pt-BR', 'Excluir', 'common', 'active'),
('common.back', 'pt-BR', 'Voltar', 'common', 'active'),
('common.loading', 'pt-BR', 'Carregando...', 'common', 'active'),

-- Header
('header.title', 'pt-BR', 'SER v2', 'header', 'active'),
('header.subtitle', 'pt-BR', 'Implantação', 'header', 'active'),
('header.language', 'pt-BR', 'Idioma', 'header', 'active'),

-- Dashboard
('pages.dashboard.title', 'pt-BR', 'Dashboard', 'pages', 'active'),
('pages.dashboard.quick_access', 'pt-BR', 'Acesso rápido', 'pages', 'active'),
('pages.dashboard.program_vision', 'pt-BR', 'Visão do Programa', 'pages', 'active'),

-- Placeholders para outros idiomas (status = 'pending')
('navigation.dashboard', 'en-US', '[PENDING] Dashboard', 'navigation', 'pending'),
('navigation.diagnostico', 'en-US', '[PENDING] Diagnosis', 'navigation', 'pending'),
('common.save', 'en-US', '[PENDING] Save', 'common', 'pending'),
('navigation.dashboard', 'es-ES', '[PENDIENTE] Dashboard', 'navigation', 'pending'),
('navigation.diagnostico', 'es-ES', '[PENDIENTE] Diagnóstico', 'navigation', 'pending'),
('common.save', 'es-ES', '[PENDIENTE] Guardar', 'common', 'pending');

-- =====================================================
-- VIEWS ÚTEIS PARA GESTÃO
-- =====================================================

-- View para ver status de tradução por idioma
CREATE VIEW v_translation_status AS
SELECT 
    sl.language_code,
    sl.language_name,
    sl.native_name,
    sl.is_active,
    COUNT(t.id) as total_translations,
    COUNT(CASE WHEN t.status = 'active' THEN 1 END) as active_translations,
    COUNT(CASE WHEN t.status = 'pending' THEN 1 END) as pending_translations,
    ROUND(
        (COUNT(CASE WHEN t.status = 'active' THEN 1 END) * 100.0 / 
         NULLIF(COUNT(t.id), 0)), 2
    ) as completion_percentage
FROM supported_languages sl
LEFT JOIN translations t ON sl.language_code = t.language_code
GROUP BY sl.language_code, sl.language_name, sl.native_name, sl.is_active;

-- View para identificar chaves faltantes por idioma
CREATE VIEW v_missing_translations AS
SELECT 
    ref.translation_key,
    ref.context,
    missing_lang.language_code,
    missing_lang.language_name
FROM (
    SELECT DISTINCT translation_key, context 
    FROM translations 
    WHERE language_code = 'pt-BR'
) ref
CROSS JOIN supported_languages missing_lang
LEFT JOIN translations t ON ref.translation_key = t.translation_key 
    AND missing_lang.language_code = t.language_code
WHERE t.id IS NULL
    AND missing_lang.is_active = TRUE
    AND missing_lang.language_code != 'pt-BR'
ORDER BY missing_lang.language_code, ref.context, ref.translation_key;

-- =====================================================
-- STORED PROCEDURES ÚTEIS
-- =====================================================

DELIMITER $$

-- Procedure para criar tradução em todos os idiomas
CREATE PROCEDURE sp_create_translation(
    IN p_key VARCHAR(255),
    IN p_value_pt TEXT,
    IN p_context VARCHAR(100)
)
BEGIN
    DECLARE done INT DEFAULT FALSE;
    DECLARE lang_code VARCHAR(5);
    DECLARE lang_cursor CURSOR FOR 
        SELECT language_code FROM supported_languages WHERE is_active = TRUE;
    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;

    OPEN lang_cursor;
    
    lang_loop: LOOP
        FETCH lang_cursor INTO lang_code;
        IF done THEN
            LEAVE lang_loop;
        END IF;
        
        INSERT INTO translations (translation_key, language_code, value, context, status)
        VALUES (
            p_key, 
            lang_code, 
            CASE 
                WHEN lang_code = 'pt-BR' THEN p_value_pt
                WHEN lang_code = 'en-US' THEN CONCAT('[PENDING] ', p_value_pt)
                WHEN lang_code = 'es-ES' THEN CONCAT('[PENDIENTE] ', p_value_pt)
                ELSE CONCAT('[TODO] ', p_value_pt)
            END,
            p_context,
            CASE WHEN lang_code = 'pt-BR' THEN 'active' ELSE 'pending' END
        )
        ON DUPLICATE KEY UPDATE
            value = VALUES(value),
            updated_at = CURRENT_TIMESTAMP;
            
    END LOOP;
    
    CLOSE lang_cursor;
END$$

-- Procedure para atualizar percentual de completude
CREATE PROCEDURE sp_update_completion_percentages()
BEGIN
    UPDATE supported_languages sl
    SET completion_percentage = (
        SELECT ROUND(
            (COUNT(CASE WHEN t.status = 'active' THEN 1 END) * 100.0 / 
             NULLIF(COUNT(t.id), 0)), 2
        )
        FROM translations t 
        WHERE t.language_code = sl.language_code
    );
END$$

DELIMITER ;

-- =====================================================
-- CONSULTAS ÚTEIS PARA ADMINISTRAÇÃO
-- =====================================================

-- Ver status geral das traduções
-- SELECT * FROM v_translation_status;

-- Ver traduções faltantes por idioma
-- SELECT * FROM v_missing_translations LIMIT 20;

-- Buscar tradução específica
-- SELECT * FROM translations WHERE translation_key LIKE '%dashboard%';

-- Contar traduções por contexto
-- SELECT context, language_code, COUNT(*) as total
-- FROM translations 
-- GROUP BY context, language_code 
-- ORDER BY context, language_code;

-- Exemplo de uso da procedure
-- CALL sp_create_translation('pages.nova_funcionalidade.titulo', 'Nova Funcionalidade', 'pages');
-- CALL sp_update_completion_percentages();