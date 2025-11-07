<?php
/**
 * 🎨 TEMPLATE VIEW COMPLETA - SER v2.0
 * Template atualizado para as views das páginas do dashboard
 * ✨ Incluindo sidebar responsivo e todas as melhorias
 */
?>

<?php require __DIR__ . '/../layouts/dashboard-header.php'; ?>

<div class="container-fluid">
  <div class="row">
    
    <!-- Sidebar Component (Responsivo + Retrátil) -->
    <?php require __DIR__ . '/../layouts/dashboard-sidebar.php'; ?>
    
    <!-- Main Content -->
    <main class="col-12 col-lg-9 col-xl-10 p-3 p-md-4" id="mainContent">
      
      <!-- Breadcrumb Navigation -->
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
          <div class="d-flex justify-content-between align-items-start flex-wrap">
            <div class="mb-2 mb-md-0">
              <h1 class="h3 mb-2"><?= htmlspecialchars($pageData['pageTitle']) ?></h1>
              <p class="text-muted mb-0">
                Usuário: <strong><?= htmlspecialchars($dashboardData['user']->name) ?></strong> · 
                Perfil: <strong><?= htmlspecialchars($primaryRole) ?></strong> ·
                Organização: <strong><?= htmlspecialchars($dashboardData['organization']->name) ?></strong>
              </p>
            </div>
            <div class="d-flex gap-2">
              <!-- [PERSONALIZAR] Botões de ação da página -->
              <button class="btn btn-outline-primary btn-sm">
                <i class="fa fa-download me-1"></i> Exportar
              </button>
              <button class="btn btn-primary btn-sm">
                <i class="fa fa-plus me-1"></i> Novo
              </button>
            </div>
          </div>
        </div>
      </div>
      
      <!-- [PERSONALIZAR] Conteúdo Principal da Página -->
      <div class="row mb-4">
        <!-- Cards de estatísticas/resumo -->
        <div class="col-md-3">
          <div class="card text-center">
            <div class="card-body">
              <i class="fa fa-chart-line fa-2x text-primary mb-2"></i>
              <h5 class="card-title">Indicador 1</h5>
              <p class="card-text">
                <span class="h4">R$ 0,00</span>
                <small class="text-muted d-block">Valor exemplo</small>
              </p>
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card text-center">
            <div class="card-body">
              <i class="fa fa-chart-bar fa-2x text-success mb-2"></i>
              <h5 class="card-title">Indicador 2</h5>
              <p class="card-text">
                <span class="h4">0</span>
                <small class="text-muted d-block">Quantidade exemplo</small>
              </p>
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card text-center">
            <div class="card-body">
              <i class="fa fa-percentage fa-2x text-warning mb-2"></i>
              <h5 class="card-title">Indicador 3</h5>
              <p class="card-text">
                <span class="h4">0%</span>
                <small class="text-muted d-block">Percentual exemplo</small>
              </p>
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card text-center">
            <div class="card-body">
              <i class="fa fa-trending-up fa-2x text-info mb-2"></i>
              <h5 class="card-title">Indicador 4</h5>
              <p class="card-text">
                <span class="h4">+0%</span>
                <small class="text-muted d-block">Crescimento exemplo</small>
              </p>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Conteúdo Principal -->
      <div class="row">
        <!-- Seção Principal -->
        <div class="col-lg-8">
          <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
              <h5 class="mb-0">
                <i class="fa fa-chart-line me-2"></i>
                Análise Principal
              </h5>
              <div class="btn-group btn-group-sm" role="group">
                <input type="radio" class="btn-check" name="periodo" id="periodo1" checked>
                <label class="btn btn-outline-secondary" for="periodo1">7d</label>
                
                <input type="radio" class="btn-check" name="periodo" id="periodo2">
                <label class="btn btn-outline-secondary" for="periodo2">30d</label>
                
                <input type="radio" class="btn-check" name="periodo" id="periodo3">
                <label class="btn btn-outline-secondary" for="periodo3">90d</label>
              </div>
            </div>
            <div class="card-body">
              <!-- [PERSONALIZAR] Substitua por gráfico ou conteúdo real -->
              <div class="text-center py-5 bg-light rounded">
                <i class="fa fa-chart-area fa-3x text-muted mb-3"></i>
                <h6 class="text-muted">Gráfico/Análise Principal</h6>
                <p class="text-muted mb-0">Substitua por conteúdo específico da página</p>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Sidebar Direita -->
        <div class="col-lg-4">
          <!-- Filtros/Controles -->
          <div class="card mb-4">
            <div class="card-header">
              <h6 class="mb-0">
                <i class="fa fa-filter me-2"></i>
                Filtros e Controles
              </h6>
            </div>
            <div class="card-body">
              <!-- [PERSONALIZAR] Adicione filtros específicos -->
              <div class="mb-3">
                <label for="filtroData" class="form-label">Período</label>
                <select id="filtroData" class="form-select form-select-sm">
                  <option>Último mês</option>
                  <option>Últimos 3 meses</option>
                  <option>Último ano</option>
                </select>
              </div>
              <div class="mb-3">
                <label for="filtroTipo" class="form-label">Tipo</label>
                <select id="filtroTipo" class="form-select form-select-sm">
                  <option>Todos</option>
                  <option>Tipo A</option>
                  <option>Tipo B</option>
                </select>
              </div>
              <button class="btn btn-primary btn-sm w-100">
                <i class="fa fa-search me-1"></i>
                Aplicar Filtros
              </button>
            </div>
          </div>
          
          <!-- Ações Rápidas -->
          <div class="card mb-4">
            <div class="card-header">
              <h6 class="mb-0">
                <i class="fa fa-bolt me-2"></i>
                Ações Rápidas
              </h6>
            </div>
            <div class="card-body">
              <!-- [PERSONALIZAR] Adicione ações específicas -->
              <div class="d-grid gap-2">
                <button class="btn btn-outline-primary btn-sm">
                  <i class="fa fa-plus me-1"></i> Nova Análise
                </button>
                <button class="btn btn-outline-secondary btn-sm">
                  <i class="fa fa-download me-1"></i> Exportar Dados
                </button>
                <button class="btn btn-outline-info btn-sm">
                  <i class="fa fa-sync me-1"></i> Atualizar
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Tabela/Lista de Dados -->
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
              <h5 class="mb-0">
                <i class="fa fa-table me-2"></i>
                Dados Detalhados
              </h5>
              <div class="input-group" style="width: 250px;">
                <input type="search" class="form-control form-control-sm" placeholder="Buscar...">
                <button class="btn btn-outline-secondary btn-sm" type="button">
                  <i class="fa fa-search"></i>
                </button>
              </div>
            </div>
            <div class="card-body">
              <!-- [PERSONALIZAR] Substitua por tabela real -->
              <div class="table-responsive">
                <table class="table table-hover">
                  <thead class="table-light">
                    <tr>
                      <th>ID</th>
                      <th>Item</th>
                      <th>Valor</th>
                      <th>Status</th>
                      <th>Data</th>
                      <th>Ações</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>001</td>
                      <td>Item Exemplo</td>
                      <td>R$ 1.000,00</td>
                      <td><span class="badge bg-success">Ativo</span></td>
                      <td>06/11/2025</td>
                      <td>
                        <button class="btn btn-outline-primary btn-sm">
                          <i class="fa fa-eye"></i>
                        </button>
                        <button class="btn btn-outline-secondary btn-sm">
                          <i class="fa fa-edit"></i>
                        </button>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              
              <!-- Paginação -->
              <nav class="mt-3">
                <ul class="pagination pagination-sm justify-content-center mb-0">
                  <li class="page-item disabled">
                    <span class="page-link">Anterior</span>
                  </li>
                  <li class="page-item active">
                    <span class="page-link">1</span>
                  </li>
                  <li class="page-item">
                    <a class="page-link" href="#">2</a>
                  </li>
                  <li class="page-item">
                    <a class="page-link" href="#">3</a>
                  </li>
                  <li class="page-item">
                    <a class="page-link" href="#">Próximo</a>
                  </li>
                </ul>
              </nav>
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
              <h6 class="text-muted">🔧 Debug - Permissões e Dados</h6>
              <div class="row">
                <div class="col-md-6">
                  <small>
                    <strong>Permissões:</strong><br>
                    Financial: <?= $canViewFinancial ? '✅ Sim' : '❌ Não' ?><br>
                    Operational: <?= $canViewOperational ? '✅ Sim' : '❌ Não' ?><br>
                    Risk: <?= $canViewRisk ? '✅ Sim' : '❌ Não' ?><br>
                    Compliance: <?= $canViewCompliance ? '✅ Sim' : '❌ Não' ?>
                  </small>
                </div>
                <div class="col-md-6">
                  <small>
                    <strong>Módulos Carregados:</strong><br>
                    <?php foreach ($dashboardData['modules'] as $key => $module): ?>
                      • <?= $module['name'] ?> (<?= count($module['items']) ?> itens)<br>
                    <?php endforeach; ?>
                  </small>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php endif; ?>
      
    </main>
    
  </div>
</div>

<?php require __DIR__ . '/../layouts/dashboard-footer.php'; ?>