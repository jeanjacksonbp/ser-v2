/**
 * Sistema Híbrido de Internacionalização
 * Tenta carregar traduções de JSON, mas sempre tem fallback inline
 * Garante funcionamento imediato mesmo se JSON falhar
 */
class HybridI18n {
    constructor() {
        this.currentLanguage = 'pt';
        this.translations = {};
        this.jsonLoaded = false;
        this.initialized = false;
        
        // Traduções inline como fallback (sempre disponíveis)
        this.fallbackTranslations = {
            pt: {
                nav: {
                    dashboard: "Dashboard",
                    usuarios: "Usuários",
                    relatorios: "Relatórios",
                    configuracoes: "Configurações",
                    sair: "Sair"
                },
                common: {
                    loading: "Carregando...",
                    save: "Salvar",
                    cancel: "Cancelar",
                    edit: "Editar",
                    delete: "Excluir",
                    search: "Pesquisar",
                    filter: "Filtrar",
                    export: "Exportar",
                    import: "Importar",
                    add: "Adicionar",
                    remove: "Remover",
                    close: "Fechar",
                    confirm: "Confirmar",
                    warning: "Aviso",
                    error: "Erro",
                    success: "Sucesso",
                    info: "Informação"
                },
                pages: {
                    diagnostico: {
                        title: "Diagnóstico do Sistema",
                        server_status: "Status do Servidor",
                        database_connection: "Conexão com Banco",
                        permissions: "Permissões",
                        dependencies: "Dependências"
                    }
                }
            },
            en: {
                nav: {
                    dashboard: "Dashboard",
                    usuarios: "Users",
                    relatorios: "Reports",
                    configuracoes: "Settings",
                    sair: "Logout"
                },
                common: {
                    loading: "Loading...",
                    save: "Save",
                    cancel: "Cancel",
                    edit: "Edit",
                    delete: "Delete",
                    search: "Search",
                    filter: "Filter",
                    export: "Export",
                    import: "Import",
                    add: "Add",
                    remove: "Remove",
                    close: "Close",
                    confirm: "Confirm",
                    warning: "Warning",
                    error: "Error",
                    success: "Success",
                    info: "Information"
                },
                pages: {
                    diagnostico: {
                        title: "System Diagnostics",
                        server_status: "Server Status",
                        database_connection: "Database Connection",
                        permissions: "Permissions",
                        dependencies: "Dependencies"
                    }
                }
            },
            es: {
                nav: {
                    dashboard: "Dashboard",
                    usuarios: "Usuarios",
                    relatorios: "Reportes",
                    configuracoes: "Configuraciones",
                    sair: "Salir"
                },
                common: {
                    loading: "Cargando...",
                    save: "Guardar",
                    cancel: "Cancelar",
                    edit: "Editar",
                    delete: "Eliminar",
                    search: "Buscar",
                    filter: "Filtrar",
                    export: "Exportar",
                    import: "Importar",
                    add: "Añadir",
                    remove: "Eliminar",
                    close: "Cerrar",
                    confirm: "Confirmar",
                    warning: "Advertencia",
                    error: "Error",
                    success: "Éxito",
                    info: "Información"
                },
                pages: {
                    diagnostico: {
                        title: "Diagnóstico del Sistema",
                        server_status: "Estado del Servidor",
                        database_connection: "Conexión a Base de Datos",
                        permissions: "Permisos",
                        dependencies: "Dependencias"
                    }
                }
            }
        };
        
        this.init();
    }
    
    async init() {
        console.log('🚀 HybridI18n: Iniciando sistema híbrido...');
        
        // Primeiro usa o fallback para garantir funcionamento imediato
        this.translations = { ...this.fallbackTranslations };
        
        // Recupera idioma salvo
        const savedLang = localStorage.getItem('language') || 'pt';
        this.currentLanguage = savedLang;
        
        // Aplica traduções imediatamente com fallback
        this.updateContent();
        this.updateLanguageSelector();
        
        // Tenta carregar JSON em paralelo (sem bloquear)
        this.loadJsonTranslations();
        
        // Configura event listeners
        this.setupEventListeners();
        
        this.initialized = true;
        console.log('✅ HybridI18n: Sistema inicializado com fallback');
    }
    
    async loadJsonTranslations() {
        try {
            console.log('📄 HybridI18n: Tentando carregar JSON...');
            
            const response = await fetch('./assets/data/translations.json');
            if (!response.ok) {
                throw new Error(`HTTP ${response.status}`);
            }
            
            const jsonTranslations = await response.json();
            
            // Merge JSON com fallback (JSON tem prioridade)
            this.translations = this.mergeTranslations(this.fallbackTranslations, jsonTranslations);
            this.jsonLoaded = true;
            
            console.log('✅ HybridI18n: JSON carregado, atualizando interface...');
            
            // Atualiza novamente com dados mais completos do JSON
            this.updateContent();
            
        } catch (error) {
            console.warn('⚠️ HybridI18n: Falha ao carregar JSON, usando fallback:', error.message);
            // Sistema continua funcionando com fallback inline
        }
    }
    
    mergeTranslations(fallback, jsonData) {
        const merged = {};
        
        // Para cada idioma
        for (const lang in fallback) {
            merged[lang] = this.deepMerge(fallback[lang], jsonData[lang] || {});
        }
        
        // Adiciona idiomas que existem apenas no JSON
        for (const lang in jsonData) {
            if (!merged[lang]) {
                merged[lang] = jsonData[lang];
            }
        }
        
        return merged;
    }
    
    deepMerge(target, source) {
        const result = { ...target };
        
        for (const key in source) {
            if (source.hasOwnProperty(key)) {
                if (typeof source[key] === 'object' && source[key] !== null && !Array.isArray(source[key])) {
                    result[key] = this.deepMerge(result[key] || {}, source[key]);
                } else {
                    result[key] = source[key];
                }
            }
        }
        
        return result;
    }
    
    setupEventListeners() {
        // Event delegation para language selector
        document.addEventListener('click', (e) => {
            if (e.target.matches('.language-option')) {
                e.preventDefault();
                const newLang = e.target.getAttribute('data-lang');
                if (newLang && newLang !== this.currentLanguage) {
                    this.changeLanguage(newLang);
                }
            }
        });
        
        // Listener para quando componentes são carregados dinamicamente
        document.addEventListener('DOMContentLoaded', () => {
            this.updateContent();
        });
        
        // Observer para detectar mudanças no DOM
        const observer = new MutationObserver((mutations) => {
            let shouldUpdate = false;
            mutations.forEach(mutation => {
                if (mutation.type === 'childList' && mutation.addedNodes.length > 0) {
                    // Verifica se algum nó adicionado tem atributos i18n
                    for (const node of mutation.addedNodes) {
                        if (node.nodeType === Node.ELEMENT_NODE) {
                            if (node.hasAttribute && node.hasAttribute('data-i18n') || 
                                node.querySelector && node.querySelector('[data-i18n]')) {
                                shouldUpdate = true;
                                break;
                            }
                        }
                    }
                }
            });
            
            if (shouldUpdate) {
                setTimeout(() => this.updateContent(), 50);
            }
        });
        
        observer.observe(document.body, {
            childList: true,
            subtree: true
        });
    }
    
    changeLanguage(newLang) {
        console.log(`🔄 HybridI18n: Mudando idioma ${this.currentLanguage} → ${newLang}`);
        
        if (!this.translations[newLang]) {
            console.warn(`⚠️ HybridI18n: Idioma '${newLang}' não encontrado`);
            return;
        }
        
        this.currentLanguage = newLang;
        localStorage.setItem('language', newLang);
        
        this.updateContent();
        this.updateLanguageSelector();
        
        // Dispara evento customizado
        document.dispatchEvent(new CustomEvent('languageChanged', {
            detail: { 
                language: newLang,
                jsonLoaded: this.jsonLoaded 
            }
        }));
        
        console.log(`✅ HybridI18n: Idioma alterado para ${newLang}`);
    }
    
    updateContent() {
        if (!this.initialized) return;
        
        const elements = document.querySelectorAll('[data-i18n]');
        let translated = 0;
        let missing = 0;
        
        elements.forEach(element => {
            const key = element.getAttribute('data-i18n');
            const translation = this.getTranslation(key);
            
            if (translation) {
                if (element.tagName === 'INPUT' && (element.type === 'text' || element.type === 'search')) {
                    element.placeholder = translation;
                } else {
                    element.textContent = translation;
                }
                translated++;
            } else {
                console.warn(`⚠️ HybridI18n: Tradução não encontrada: ${key}`);
                missing++;
            }
        });
        
        console.log(`📊 HybridI18n: ${translated} traduzidos, ${missing} faltando, JSON: ${this.jsonLoaded ? 'Sim' : 'Não'}`);
    }
    
    updateLanguageSelector() {
        // Atualiza flag do idioma atual
        const currentFlag = document.querySelector('#currentLanguageFlag');
        if (currentFlag) {
            const flags = { pt: '🇧🇷', en: '🇺🇸', es: '🇪🇸' };
            currentFlag.textContent = flags[this.currentLanguage] || '🌐';
        }
        
        // Atualiza opções do dropdown
        const options = document.querySelectorAll('.language-option');
        options.forEach(option => {
            const lang = option.getAttribute('data-lang');
            if (lang === this.currentLanguage) {
                option.style.fontWeight = 'bold';
                option.style.backgroundColor = '#e3f2fd';
            } else {
                option.style.fontWeight = 'normal';
                option.style.backgroundColor = '';
            }
        });
    }
    
    getTranslation(key) {
        const keys = key.split('.');
        let current = this.translations[this.currentLanguage];
        
        for (const k of keys) {
            if (current && typeof current === 'object' && current.hasOwnProperty(k)) {
                current = current[k];
            } else {
                return null;
            }
        }
        
        return typeof current === 'string' ? current : null;
    }
    
    // Método público para adicionar traduções dinamicamente
    addTranslations(newTranslations) {
        this.translations = this.mergeTranslations(this.translations, newTranslations);
        this.updateContent();
        console.log('📝 HybridI18n: Traduções adicionadas dinamicamente');
    }
    
    // Método público para obter status
    getStatus() {
        return {
            initialized: this.initialized,
            currentLanguage: this.currentLanguage,
            jsonLoaded: this.jsonLoaded,
            availableLanguages: Object.keys(this.translations),
            translationsCount: Object.keys(this.translations[this.currentLanguage] || {}).length
        };
    }
}

// Inicialização automática
let hybridI18n;

// Aguarda DOM estar pronto
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => {
        hybridI18n = new HybridI18n();
    });
} else {
    hybridI18n = new HybridI18n();
}

// Exporta para uso global
window.HybridI18n = HybridI18n;
window.hybridI18n = hybridI18n;