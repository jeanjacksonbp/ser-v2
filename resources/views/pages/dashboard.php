<?php require __DIR__ . '/../layouts/dashboard-header.php'; ?>

<div class="container-fluid">
  <div class="row">
    <!-- Sidebar Component -->
    <?php require __DIR__ . '/../layouts/dashboard-sidebar.php'; ?>
    
    <!-- Main Content -->
    <main class="col-12 col-lg-9 col-xl-10 p-3 p-md-4" id="mainContent">
      <ol class="breadcrumb mb-2">
        <li class="breadcrumb-item"><a href="/ser-v2/public/dashboard.php">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
      </ol>
      
      <!-- Welcome Section -->
      <div class="row mb-4">
        <div class="col-12">
          <div class="card p-3">
            <h4 class="mb-2">Bem-vindo, <?= htmlspecialchars($dashboardData['user']->name ?? 'Usuário') ?>!</h4>
            <p class="text-muted mb-1">
              Organização: <strong><?= htmlspecialchars($dashboardData['organization']?->name ?? 'Não definida') ?></strong>
            </p>
            <p class="text-muted mb-0">
              Perfil: <strong><?= htmlspecialchars($primaryRole) ?></strong>
            </p>
          </div>
        </div>
      </div>
      
      <!-- Dashboard Cards -->
      <div class="row g-3">
        <div class="col-md-6">
          <div class="card p-3 h-100">
            <h5 class="mb-2">Macro-etapas</h5>
            <ol class="mb-3 text-muted">
              <li>Diagnóstico (Financeiro, Competitividade, Potencial)</li>
              <li>Planejamento (360°, Cronograma & Metas)</li>
              <li>Execução (Comitês, Programas 7a–7l)</li>
              <li>Métricas (KPIs)</li>
              <li>Mercado & Vendas (Clientes, Vendas)</li>
              <li>Cultura</li>
            </ol>
            <?php if (isset($dashboardData['modules']['planejamento'])): ?>
            <a class="btn btn-primary" href="<?= url('planejamento-plano-estrategico') ?>">
              <i class="fa-solid fa-bullseye me-1"></i> Ir para Planejamento
            </a>
            <?php endif; ?>
          </div>
        </div>
        
        <div class="col-md-6">
          <div class="card p-3 h-100">
            <h5 class="mb-2">Atalhos</h5>
            <div class="d-flex flex-wrap gap-2">
              <?php foreach ($dashboardData['modules'] as $module): ?>
                <?php foreach ($module['items'] as $item): ?>
                  <a class="btn btn-sm btn-outline-primary" href="<?= htmlspecialchars($item['url']) ?>">
                    <?= htmlspecialchars($item['name']) ?>
                  </a>
                <?php endforeach; ?>
              <?php endforeach; ?>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Permissions Info (only for debugging - remove in production) -->
      <?php if ($primaryRole === 'SuperAdmin'): ?>
      <div class="row mt-3">
        <div class="col-12">
          <div class="card p-3 bg-light">
            <h6 class="mb-2">Debug - Permissões Ativas</h6>
            <div class="small">
              <strong>Financeiro:</strong> <?= $dashboardData['canViewFinancial'] ? '✅ Sim' : '❌ Não' ?> | 
              <strong>KPIs:</strong> <?= $dashboardData['canViewKPIs'] ? '✅ Sim' : '❌ Não' ?>
            </div>
            <div class="small mt-1">
              <strong>Módulos Acessíveis:</strong> <?= count($dashboardData['modules']) ?>/6
            </div>
          </div>
        </div>
      </div>
      <?php endif; ?>
      
      <div class="mt-4 footer-note">© SER v2 · Layout limpo e leve</div>
    </main>
  </div>
</div>

<?php require __DIR__ . '/../layouts/dashboard-footer.php'; ?>
