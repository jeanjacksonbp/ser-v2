// Component Loader for Prototype
class ComponentLoader {
  static async loadComponent(selector, componentPath) {
    try {
      const response = await fetch(componentPath);
      const content = await response.text();
      const element = document.querySelector(selector);
      
      // Para o sidebar, substituir completamente o placeholder
      if (selector === '#sidebar-placeholder') {
        element.outerHTML = content;
      } else {
        element.innerHTML = content;
      }
    } catch (error) {
      console.error(`Erro ao carregar componente ${componentPath}:`, error);
    }
  }

  static async loadAll() {
    await Promise.all([
      this.loadComponent('#header-placeholder', 'components/header.html'),
      this.loadComponent('#sidebar-placeholder', 'components/sidebar.html'),
      this.loadComponent('#footer-placeholder', 'components/footer.html')
    ]);
    
    // Aguardar e tentar múltiplas vezes até os elementos estarem prontos
    this.waitForElementsAndInitialize();
  }
  
  static waitForElementsAndInitialize() {
    let attempts = 0;
    const maxAttempts = 20;
    
    const checkAndInit = () => {
      const sidebar = document.getElementById('sidebar');
      const toggleBtn = document.getElementById('sidebarToggle');
      const hamburgerMenu = document.getElementById('hamburgerMenu');
      
      if (sidebar && (toggleBtn || hamburgerMenu)) {
        this.activateNavigation();
        this.initializeSidebar();
        this.initializeMobileMenu();
        return;
      }
      
      attempts++;
      if (attempts < maxAttempts) {
        setTimeout(checkAndInit, 100);
      }
    };
    
    checkAndInit();
  }

  static activateNavigation() {
    // Detectar página atual e marcar link ativo
    const currentPage = document.body.dataset.page;
    const navLinks = document.querySelectorAll('.sidebar .nav-link');
    
    navLinks.forEach(link => {
      link.classList.remove('active');
      if (link.dataset.page === currentPage) {
        link.classList.add('active', 'fw-semibold');
      }
    });
  }

  static initializeSidebar() {
    // Aplicar estado imediatamente no carregamento (sem delay)
    const sidebar = document.getElementById('sidebar');
    if (sidebar) {
      const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
      if (isCollapsed) {
        sidebar.classList.add('preload-collapsed', 'collapsed');
        // Forçar reflow e remover classe preload após aplicar
        sidebar.offsetHeight;
        setTimeout(() => {
          sidebar.classList.remove('preload-collapsed');
        }, 50);
      }
    }
    
    // Inicializar sidebar toggle após componentes carregarem
    setTimeout(() => {
      const sidebar = document.getElementById('sidebar');
      const toggleBtn = document.getElementById('sidebarToggle');
      
      if (!sidebar || !toggleBtn) {
        return;
      }
      
      // Verificar se já tem event listener
      if (toggleBtn.dataset.initialized) {
        return;
      }
      toggleBtn.dataset.initialized = 'true';
      
      const toggleIcon = toggleBtn.querySelector('i');
      
      // Função para aplicar estilos aos ícones
      function applyIconStyles(collapsed) {
        const navLinks = sidebar.querySelectorAll('.nav-link');
        const icons = sidebar.querySelectorAll('.nav-link i');
        
        navLinks.forEach(link => {
          if (collapsed) {
            link.style.justifyContent = 'flex-start';
            link.style.paddingLeft = '12px';
            link.style.paddingRight = '12px';
          } else {
            link.style.justifyContent = '';
            link.style.paddingLeft = '';
            link.style.paddingRight = '';
          }
        });
        
        icons.forEach(icon => {
          if (collapsed) {
            icon.style.margin = '0';
            icon.style.marginRight = '0';
            icon.style.marginLeft = '0';
            icon.style.textAlign = 'left';
          } else {
            icon.style.margin = '';
            icon.style.marginRight = '0.5rem';
            icon.style.marginLeft = '';
            icon.style.textAlign = '';
          }
        });
      }
      
      // Recuperar estado do localStorage (já aplicado acima)
      const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
      if (isCollapsed) {
        toggleIcon.className = 'fa-solid fa-chevron-right';
        applyIconStyles(true);
      }

      // Event listener para o botão toggle
      toggleBtn.addEventListener('click', function() {
        sidebar.classList.toggle('collapsed');
        
        if (sidebar.classList.contains('collapsed')) {
          toggleIcon.className = 'fa-solid fa-chevron-right';
          localStorage.setItem('sidebarCollapsed', 'true');
          applyIconStyles(true);
        } else {
          toggleIcon.className = 'fa-solid fa-chevron-left';
          localStorage.setItem('sidebarCollapsed', 'false');
          applyIconStyles(false);
        }
      });
      
      // Configurar apenas tooltips nativos do navegador
      const navLinks = document.querySelectorAll('.sidebar .nav-link');
      navLinks.forEach(link => {
        const textSpan = link.querySelector('.nav-text');
        if (textSpan) {
          link.title = textSpan.textContent;
        }
      });
    }, 1000);
  }

  static initializeMobileMenu() {
    setTimeout(() => {
      const hamburgerMenu = document.getElementById('hamburgerMenu');
      const sidebar = document.getElementById('sidebar');
      const overlay = document.getElementById('sidebarOverlay');
      const navLinks = document.querySelectorAll('.sidebar .nav-link');
      
      if (!hamburgerMenu || !sidebar || !overlay) return;
      
      // Verificar se já tem event listener
      if (hamburgerMenu.dataset.initialized) return;
      hamburgerMenu.dataset.initialized = 'true';
      
      // Toggle menu mobile
      hamburgerMenu.addEventListener('click', () => {
        const isOpen = sidebar.classList.contains('show');
        
        if (isOpen) {
          this.closeMobileMenu();
        } else {
          this.openMobileMenu();
        }
      });
      
      // Fechar ao clicar no overlay
      overlay.addEventListener('click', () => {
        this.closeMobileMenu();
      });
      
      // Fechar ao clicar em qualquer link (navegação)
      navLinks.forEach(link => {
        link.addEventListener('click', () => {
          setTimeout(() => {
            this.closeMobileMenu();
          }, 150);
        });
      });
      
    }, 500);
  }
  
  static openMobileMenu() {
    const hamburgerMenu = document.getElementById('hamburgerMenu');
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebarOverlay');
    
    hamburgerMenu.classList.add('active');
    sidebar.classList.add('show');
    overlay.classList.add('show');
    document.body.style.overflow = 'hidden'; // Prevenir scroll
  }
  
  static closeMobileMenu() {
    const hamburgerMenu = document.getElementById('hamburgerMenu');
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebarOverlay');
    
    hamburgerMenu.classList.remove('active');
    sidebar.classList.remove('show');
    overlay.classList.remove('show');
    document.body.style.overflow = '';
  }

}

// Carregar componentes quando a página carrega
document.addEventListener('DOMContentLoaded', () => {
  ComponentLoader.loadAll();
});