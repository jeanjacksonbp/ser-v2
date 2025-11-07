/**
 * Sistema i18n Simplificado para Debug
 */
class SimpleI18n {
  static currentLanguage = 'pt-BR';
  static translations = {
    'pt-BR': {
      'navigation.dashboard': 'Dashboard',
      'navigation.diagnostico': 'Diagnóstico',
      'navigation.planejamento': 'Planejamento',
      'navigation.modules': 'Módulos',
      'common.save': 'Salvar',
      'common.cancel': 'Cancelar'
    },
    'en-US': {
      'navigation.dashboard': 'Dashboard',
      'navigation.diagnostico': 'Diagnosis',
      'navigation.planejamento': 'Planning',
      'navigation.modules': 'Modules',
      'common.save': 'Save',
      'common.cancel': 'Cancel'
    },
    'es-ES': {
      'navigation.dashboard': 'Dashboard',
      'navigation.diagnostico': 'Diagnóstico',
      'navigation.planejamento': 'Planificación',
      'navigation.modules': 'Módulos',
      'common.save': 'Guardar',
      'common.cancel': 'Cancelar'
    }
  };

  static init() {
    console.log('🚀 SimpleI18n inicializado');
    console.log('Traduções carregadas:', this.translations);
    
    // Recuperar idioma salvo
    const saved = localStorage.getItem('ser-language') || 'pt-BR';
    this.setLanguage(saved);
    
    // Configurar listeners
    this.setupEventListeners();
  }

  static setLanguage(lang) {
    console.log(`🌍 Mudando para: ${lang}`);
    this.currentLanguage = lang;
    localStorage.setItem('ser-language', lang);
    this.updateDOM();
  }

  static t(key) {
    const translation = this.translations[this.currentLanguage]?.[key];
    console.log(`Traduzindo "${key}": ${translation || 'NÃO ENCONTRADO'}`);
    return translation || key;
  }

  static updateDOM() {
    console.log('🔄 Atualizando DOM...');
    const elements = document.querySelectorAll('[data-i18n]');
    console.log(`Encontrados ${elements.length} elementos para traduzir`);
    
    elements.forEach(el => {
      const key = el.getAttribute('data-i18n');
      const translation = this.t(key);
      el.textContent = translation;
      console.log(`  ${key} → ${translation}`);
    });
    
    // Atualizar indicador de idioma
    const indicator = document.getElementById('currentLanguage');
    if (indicator) {
      const langNames = {
        'pt-BR': 'PT',
        'en-US': 'EN', 
        'es-ES': 'ES'
      };
      indicator.textContent = langNames[this.currentLanguage] || this.currentLanguage;
    }
  }

  static setupEventListeners() {
    // Event delegation para links de idioma
    document.addEventListener('click', (e) => {
      const langLink = e.target.closest('[data-language]');
      if (langLink) {
        e.preventDefault();
        const lang = langLink.dataset.language;
        console.log(`Clicou no idioma: ${lang}`);
        this.setLanguage(lang);
      }
    });
  }
}

// Inicializar quando DOM carregar
document.addEventListener('DOMContentLoaded', () => {
  SimpleI18n.init();
});

// Disponibilizar globalmente
window.SimpleI18n = SimpleI18n;