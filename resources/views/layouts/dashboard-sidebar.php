<?php
/**
 * Dashboard Sidebar - SER v2.0
 * Sidebar reutilizável para todas as páginas do dashboard
 * Seguindo o padrão de nomenclatura dashboard-[componente].php
 */

// Verifica se as variáveis necessárias estão disponíveis
if (!isset($dashboardData) || !isset($dashboardData['modules'])) {
    // Se não temos os dados do dashboard, carregamos um menu básico
    $dashboardData['modules'] = [
        'diagnostico' => [
            'name' => 'Diagnóstico',
            'items' => [
                ['name' => 'Dashboard', 'url' => '/ser-v2/public/dashboard.php', 'icon' => 'fa-tachometer-alt']
            ]
        ]
    ];
}
?>

<!-- Desktop Sidebar -->
<nav class="col-lg-3 col-xl-2 sidebar d-none d-lg-block p-3" id="sidebar">
  <div class="sidebar-content">
    <div class="mb-2 text-uppercase small text-muted">Módulos</div>
    <div class="accordion" id="serAccordion">
    
    <?php foreach ($dashboardData['modules'] as $moduleKey => $module): ?>
    <div class="accordion-item bg-transparent border-0">
      <h2 class="accordion-header" id="heading<?= $moduleKey ?>">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
                data-bs-target="#collapse<?= $moduleKey ?>" aria-expanded="false" 
                aria-controls="collapse<?= $moduleKey ?>">
          <?= htmlspecialchars($module['name']) ?>
        </button>
      </h2>
      <div id="collapse<?= $moduleKey ?>" class="accordion-collapse collapse" 
           aria-labelledby="heading<?= $moduleKey ?>" data-bs-parent="#serAccordion">
        <div class="accordion-body pt-2">
          <ul class="list-group list-group-flush">
            <?php foreach ($module['items'] as $item): ?>
            <li class="list-group-item">
              <a class="d-flex align-items-center" href="<?= htmlspecialchars($item['url']) ?>">
                <i class="fa-solid <?= htmlspecialchars($item['icon']) ?> me-2"></i> 
                <?= htmlspecialchars($item['name']) ?>
              </a>
            </li>
            <?php endforeach; ?>
          </ul>
        </div>
      </div>
    </div>
    <?php endforeach; ?>

    <!-- Link direto para Dashboard sempre visível -->
    <div class="mt-3 pt-3 border-top">
      <a class="d-flex align-items-center text-decoration-none mb-2" href="/ser-v2/public/dashboard.php">
        <i class="fa-solid fa-tachometer-alt me-2"></i> 
        <span>Dashboard</span>
      </a>
    </div>

  </div>
  
    <!-- Footer da organização -->
    <div class="mt-4 footer-note">
      SER v2 · <?= htmlspecialchars($dashboardData['organization']?->name ?? 'Sistema') ?>
    </div>
  </div>
</nav>

<!-- Mobile Sidebar (Offcanvas) -->
<div class="offcanvas offcanvas-start d-lg-none" tabindex="-1" id="sidebarOffcanvas" aria-labelledby="sidebarOffcanvasLabel">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title" id="sidebarOffcanvasLabel">
      <span class="brand">SER v2</span>
      <span class="badge bg-primary ms-2">Sistema</span>
    </h5>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body p-3">
    <div class="mb-2 text-uppercase small text-muted">Módulos</div>
    <div class="accordion" id="serAccordionMobile">
      
      <?php foreach ($dashboardData['modules'] as $moduleKey => $module): ?>
      <div class="accordion-item bg-transparent border-0">
        <h2 class="accordion-header" id="headingMobile<?= $moduleKey ?>">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
                  data-bs-target="#collapseMobile<?= $moduleKey ?>" aria-expanded="false" 
                  aria-controls="collapseMobile<?= $moduleKey ?>">
            <?= htmlspecialchars($module['name']) ?>
          </button>
        </h2>
        <div id="collapseMobile<?= $moduleKey ?>" class="accordion-collapse collapse" 
             aria-labelledby="headingMobile<?= $moduleKey ?>" data-bs-parent="#serAccordionMobile">
          <div class="accordion-body pt-2">
            <ul class="list-group list-group-flush">
              <?php foreach ($module['items'] as $item): ?>
              <li class="list-group-item">
                <a class="d-flex align-items-center" href="<?= htmlspecialchars($item['url']) ?>">
                  <i class="fa-solid <?= htmlspecialchars($item['icon']) ?> me-2"></i> 
                  <?= htmlspecialchars($item['name']) ?>
                </a>
              </li>
              <?php endforeach; ?>
            </ul>
          </div>
        </div>
      </div>
      <?php endforeach; ?>

    </div>
    
    <!-- Link direto para Dashboard sempre visível -->
    <div class="mt-3 pt-3 border-top">
      <a class="d-flex align-items-center text-decoration-none mb-2" href="/ser-v2/public/dashboard.php">
        <i class="fa-solid fa-tachometer-alt me-2"></i> 
        <span>Dashboard</span>
      </a>
    </div>
    
    <!-- Footer da organização -->
    <div class="mt-4 footer-note">
      SER v2 · <?= htmlspecialchars($dashboardData['organization']?->name ?? 'Sistema') ?>
    </div>
  </div>
</div>