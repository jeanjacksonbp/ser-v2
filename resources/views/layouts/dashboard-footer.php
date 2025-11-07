  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  
  <!-- Sidebar Toggle Script -->
  <script>
    document.addEventListener('DOMContentLoaded', function() {

      
      // Toggle sidebar no desktop
      window.toggleSidebar = function() {
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('mainContent');
        
        if (sidebar && mainContent) {
          sidebar.classList.toggle('sidebar-collapsed');
          mainContent.classList.toggle('content-expanded');
          
          // Salvar estado no localStorage
          const isCollapsed = sidebar.classList.contains('sidebar-collapsed');
          localStorage.setItem('sidebar-collapsed', isCollapsed);
        }
      };

      // Restaurar estado do sidebar ao carregar a página
      const sidebarCollapsed = localStorage.getItem('sidebar-collapsed') === 'true';
      
      if (sidebarCollapsed) {
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('mainContent');
        
        if (sidebar && mainContent) {
          sidebar.classList.add('sidebar-collapsed');
          mainContent.classList.add('content-expanded');
        }
      }

      // Fechar sidebar automaticamente no mobile após clique
      const sidebarLinks = document.querySelectorAll('#sidebarOffcanvas .list-group-item a');
      
      sidebarLinks.forEach(link => {
        link.addEventListener('click', function() {
          if (window.innerWidth < 992) {
            const offcanvasEl = document.getElementById('sidebarOffcanvas');
            const offcanvas = bootstrap.Offcanvas.getInstance(offcanvasEl);
            if (offcanvas) {
              offcanvas.hide();
            }
          }
        });
      });
    });
  </script>
</body>
</html>