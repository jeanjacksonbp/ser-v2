<?php
/**
 * TEMPLATE VIEW BASE - SER v2.0
 * Template para as views das páginas do dashboard
 */
?>

<?php require __DIR__ . '/../layouts/dashboard-header.php'; ?>

<div class="container-fluid">
  <div class="row">
    
    <!-- Sidebar Component -->
    <?php require __DIR__ . '/../layouts/dashboard-sidebar.php'; ?>
    
    <!-- Main Content -->
    <main class="col-12 col-lg-9 col-xl-10 p-3 p-md-4" id="mainContent">
      
      <!-- Breadcrumb -->
      <ol class="breadcrumb mb-3">
        <?php foreach ($pageData['breadcrumbs'] as $index => $breadcrumb): ?>
          <?php if ($breadcrumb['url']): ?>
            <li class="breadcrumb-item">
              <a href="<?= htmlspecialchars($breadcrumb['url']) ?>">
                <?= htmlspecialchars($breadcrumb['name']) ?>
              </a>
            </li>
          <?php else: ?>
            <li class="breadcrumb-item active" aria-current="page">
              <?= htmlspecialchars($breadcrumb['name']) ?>
            </li>
          <?php endif; ?>
        <?php endforeach; ?>
      </ol>
      
      <!-- Page Header -->
      <div class="row mb-4">
        <div class="col-12">
          <div class="d-flex justify-content-between align-items-start">
            <div>
              <h1 class="h3 mb-2"><?= htmlspecialchars($pageData['pageTitle']) ?></h1>
              <p class="text-muted mb-0">
                Usuário: <strong><?= htmlspecialchars($dashboardData['user']->name) ?></strong> · 
                Perfil: <strong><?= htmlspecialchars($primaryRole) ?></strong>
              </p>
            </div>
            <div>
              <!-- [PERSONALIZAR] Botões de ação da página -->
            </div>
          </div>
        </div>
      </div>
      
      <!-- [PERSONALIZAR] Conteúdo específico da página -->
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h5 class="mb-0">Conteúdo da Página</h5>
            </div>
            <div class="card-body">
              <p>Esta é uma página em desenvolvimento do SER v2.0</p>
              <p>Substitua este conteúdo pelo código específico da sua página.</p>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Debug Info (remover em produção) -->
      <?php if ($primaryRole === 'SuperAdmin'): ?>
      <div class="row mt-4">
        <div class="col-12">
          <div class="card bg-light">
            <div class="card-body">
              <h6>Debug - Permissões do Usuário</h6>
              <small>
                Financial: <?= $canViewFinancial ? '✅' : '❌' ?> | 
                Operational: <?= $canViewOperational ? '✅' : '❌' ?> | 
                Risk: <?= $canViewRisk ? '✅' : '❌' ?> | 
                Compliance: <?= $canViewCompliance ? '✅' : '❌' ?>
              </small>
            </div>
          </div>
        </div>
      </div>
      <?php endif; ?>
      
    </main>
    
  </div>
</div>

<?php require __DIR__ . '/../layouts/dashboard-footer.php'; ?>