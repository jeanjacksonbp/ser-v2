/**
 * Sistema de Internacionalização (i18n) - SER v2
 * Suporta PT-BR, EN-US, ES-ES
 * 
 * Uso: I18n.t('navigation.dashboard') → 'Dashboard'
 * Uso: I18n.setLanguage('en-US') → Muda idioma
 */

class I18n {
  static currentLanguage = 'pt-BR';
  static supportedLanguages = ['pt-BR', 'en-US', 'es-ES'];
  static translations = {};
  static missingKeys = new Set(); // Para controle de traduções pendentes
  
  /**
   * Inicializar sistema de traduções
   */
  static async init() {
    try {
      console.log('🔄 Inicializando sistema i18n...');
      
      // Carregar traduções do arquivo JSON
      const response = await fetch('assets/data/translations.json');
      if (!response.ok) {
        throw new Error(`HTTP ${response.status}: ${response.statusText}`);
      }
      
      this.translations = await response.json();
      console.log('📄 Arquivo translations.json carregado:', this.translations);
      
      // Recuperar idioma salvo ou usar padrão
      const savedLanguage = localStorage.getItem('ser-language') || 'pt-BR';
      
      console.log('✅ Sistema i18n inicializado:', {
        idioma_atual: this.currentLanguage,
        idioma_salvo: savedLanguage,
        idiomas_disponiveis: this.supportedLanguages,
        chaves_pt: Object.keys(this.translations['pt-BR'] || {}).length,
        chaves_en: Object.keys(this.translations['en-US'] || {}).length,
        chaves_es: Object.keys(this.translations['es-ES'] || {}).length
      });
      
      // Aplicar idioma salvo
      this.setLanguage(savedLanguage);
      
    } catch (error) {
      console.error('❌ Erro ao inicializar i18n:', error);
      console.warn('🔄 Carregando traduções de fallback...');
      // Fallback para traduções inline se arquivo não existir
      this.loadFallbackTranslations();
      
      // Ainda assim aplicar o idioma
      const savedLanguage = localStorage.getItem('ser-language') || 'pt-BR';
      this.setLanguage(savedLanguage);
    }
  }
  
  /**
   * Traduzir uma chave
   * @param {string} key - Chave da tradução (ex: 'navigation.dashboard')
   * @param {object} params - Parâmetros para interpolação
   * @returns {string} Texto traduzido
   */
  static t(key, params = {}) {
    console.log(`🔍 Traduzindo: "${key}" para idioma "${this.currentLanguage}"`);
    
    const translation = this.getTranslation(key);
    
    if (!translation) {
      // Registrar chave faltante para futura tradução
      this.missingKeys.add(key);
      console.warn(`❌ Tradução não encontrada: ${key} (${this.currentLanguage})`);
      console.log('Traduções disponíveis para este idioma:', Object.keys(this.translations[this.currentLanguage] || {}));
      return key; // Retorna a própria chave como fallback
    }
    
    console.log(`✅ Tradução encontrada: "${key}" → "${translation}"`);
    
    // Interpolação de parâmetros {nome} → valor
    return translation.replace(/\{(\w+)\}/g, (match, param) => {
      return params[param] !== undefined ? params[param] : match;
    });
  }
  
  /**
   * Buscar tradução por chave hierárquica
   * @param {string} key - Chave hierárquica (ex: 'pages.dashboard.title')
   * @returns {string|null} Tradução encontrada ou null
   */
  static getTranslation(key) {
    const langData = this.translations[this.currentLanguage];
    console.log(`🔎 Buscando "${key}" em dados do idioma:`, langData ? 'encontrado' : 'não encontrado');
    
    if (!langData) {
      console.error(`❌ Dados do idioma "${this.currentLanguage}" não encontrados`);
      return null;
    }
    
    // Navegar pela hierarquia: 'pages.dashboard.title' → obj.pages.dashboard.title
    const keys = key.split('.');
    let current = langData;
    
    console.log(`🗂️ Navegando pela hierarquia: ${keys.join(' → ')}`);
    
    for (let i = 0; i < keys.length; i++) {
      const k = keys[i];
      console.log(`  📁 Nível ${i + 1}: buscando "${k}" em`, typeof current);
      
      if (current && typeof current === 'object' && current[k] !== undefined) {
        current = current[k];
        console.log(`  ✅ Encontrado: "${k}" →`, typeof current === 'string' ? `"${current}"` : typeof current);
      } else {
        console.log(`  ❌ Não encontrado: "${k}"`);
        return null;
      }
    }
    
    const result = typeof current === 'string' ? current : null;
    console.log(`🎯 Resultado final:`, result);
    return result;
  }
  
  /**
   * Mudar idioma do sistema
   * @param {string} language - Código do idioma (pt-BR, en-US, es-ES)
   */
  static setLanguage(language) {
    console.log(`🌍 Tentando mudar idioma para: ${language}`);
    
    if (!this.supportedLanguages.includes(language)) {
      console.warn(`⚠️ Idioma não suportado: ${language}. Idiomas disponíveis:`, this.supportedLanguages);
      return;
    }
    
    if (!this.translations[language]) {
      console.error(`❌ Traduções não encontradas para: ${language}`);
      console.log('Traduções disponíveis:', Object.keys(this.translations));
      return;
    }
    
    const oldLanguage = this.currentLanguage;
    this.currentLanguage = language;
    
    // Salvar preferência
    localStorage.setItem('ser-language', language);
    console.log(`💾 Idioma salvo no localStorage: ${language}`);
    
    // Atualizar DOM
    this.updateDOM();
    
    // Atualizar seletor de idioma
    this.updateLanguageSelector();
    
    console.log(`✅ Idioma alterado com sucesso: ${oldLanguage} → ${language}`);
    
    // Disparar evento personalizado para outros componentes
    document.dispatchEvent(new CustomEvent('languageChanged', {
      detail: { oldLanguage, newLanguage: language }
    }));
  }
  
  /**
   * Atualizar todos os elementos com data-i18n no DOM
   */
  static updateDOM() {
    const elements = document.querySelectorAll('[data-i18n]');
    console.log(`🔄 Atualizando ${elements.length} elementos com data-i18n para ${this.currentLanguage}`);
    
    let updatedCount = 0;
    
    elements.forEach(element => {
      const key = element.getAttribute('data-i18n');
      const translation = this.t(key);
      
      console.log(`📝 ${key} → "${translation}"`);
      
      // Decidir se atualiza textContent ou innerHTML
      if (element.hasAttribute('data-i18n-html')) {
        element.innerHTML = translation;
      } else {
        element.textContent = translation;
      }
      
      // Atualizar atributos como title, placeholder
      const titleKey = element.getAttribute('data-i18n-title');
      if (titleKey) {
        element.title = this.t(titleKey);
      }
      
      const placeholderKey = element.getAttribute('data-i18n-placeholder');
      if (placeholderKey) {
        element.placeholder = this.t(placeholderKey);
      }
      
      updatedCount++;
    });
    
    console.log(`✅ ${updatedCount} elementos atualizados com sucesso`);
  }
  
  /**
   * Atualizar seletor de idioma no header
   */
  static updateLanguageSelector() {
    const selector = document.getElementById('languageSelector');
    if (selector) {
      selector.value = this.currentLanguage;
    }
  }
  
  /**
   * Obter lista de chaves faltantes para tradução
   * @returns {Array} Lista de chaves que precisam ser traduzidas
   */
  static getMissingKeys() {
    return Array.from(this.missingKeys).sort();
  }
  
  /**
   * Exportar chaves faltantes para JSON (útil para tradutores)
   */
  static exportMissingKeys() {
    const missing = this.getMissingKeys();
    const template = {};
    
    missing.forEach(key => {
      const keys = key.split('.');
      let current = template;
      
      for (let i = 0; i < keys.length - 1; i++) {
        if (!current[keys[i]]) current[keys[i]] = {};
        current = current[keys[i]];
      }
      
      current[keys[keys.length - 1]] = `[TRADUZIR: ${key}]`;
    });
    
    console.log('📝 Template para tradução:', JSON.stringify(template, null, 2));
    return template;
  }
  
  /**
   * Carregar traduções de fallback (caso arquivo JSON falhe)
   */
  static loadFallbackTranslations() {
    this.translations = {
      'pt-BR': {
        common: {
          save: 'Salvar',
          cancel: 'Cancelar',
          edit: 'Editar',
          delete: 'Excluir',
          back: 'Voltar'
        },
        navigation: {
          dashboard: 'Dashboard',
          diagnostico: 'Diagnóstico',
          planejamento: 'Planejamento',
          comites: 'Comitês e Atas',
          kpis: 'KPIs',
          feedback: 'Feedback e Cultura',
          avaliacao: 'Avaliação'
        }
      },
      'en-US': {
        common: {
          save: 'Save',
          cancel: 'Cancel',
          edit: 'Edit',
          delete: 'Delete',
          back: 'Back'
        },
        navigation: {
          dashboard: 'Dashboard',
          diagnostico: 'Diagnosis',
          planejamento: 'Planning',
          comites: 'Committees & Minutes',
          kpis: 'KPIs',
          feedback: 'Feedback & Culture',
          avaliacao: 'Evaluation'
        }
      },
      'es-ES': {
        common: {
          save: 'Guardar',
          cancel: 'Cancelar',
          edit: 'Editar',
          delete: 'Eliminar',
          back: 'Volver'
        },
        navigation: {
          dashboard: 'Dashboard',
          diagnostico: 'Diagnóstico',
          planejamento: 'Planificación',
          comites: 'Comités y Actas',
          kpis: 'KPIs',
          feedback: 'Feedback y Cultura',
          avaliacao: 'Evaluación'
        }
      }
    };
    
    console.log('⚠️ Usando traduções de fallback');
  }
}

// Inicializar quando DOM estiver pronto
document.addEventListener('DOMContentLoaded', () => {
  I18n.init();
});

// Exportar para uso global
window.I18n = I18n;