<?php
/**
 * Dashboard Header - SER v2.0
 * Header específico para o dashboard seguindo o design do prototype_2
 */
?>
<!doctype html>
<html lang="pt-br">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Dashboard · SER v2</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <link rel="stylesheet" href="/ser-v2/public/assets/css/dashboard.css" />
</head>
<body>
  <header class="header">
    <div class="container-fluid h-100 d-flex align-items-center justify-content-between px-3">
      <div class="d-flex align-items-center gap-2">
        <!-- Mobile sidebar toggle -->
        <button class="btn btn-outline-secondary d-lg-none" type="button" 
                data-bs-toggle="offcanvas" data-bs-target="#sidebarOffcanvas" 
                aria-controls="sidebarOffcanvas" id="sidebarToggle">
          <i class="fa-solid fa-bars"></i>
        </button>
        
        <!-- Desktop sidebar toggle -->
        <button class="btn btn-outline-secondary d-none d-lg-inline-block" type="button" 
                onclick="toggleSidebar()" id="sidebarToggleDesktop">
          <i class="fa-solid fa-bars"></i>
        </button>
        
        <span class="brand">SER v2</span>
        <span class="badge">Sistema</span>
      </div>
      <div class="d-flex align-items-center">
        <?php if (!empty($_SESSION['user_id'])): ?>
        <!-- User dropdown -->
        <div class="dropdown">
          <button class="btn btn-link text-muted dropdown-toggle" type="button" id="userDropdown" 
                  data-bs-toggle="dropdown" aria-expanded="false" style="text-decoration: none;">
            <i class="fa-solid fa-user-circle fa-lg"></i>
          </button>
          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
            <li>
              <a class="dropdown-item" href="/ser-v2/public/profile.php">
                <i class="fa fa-user-edit me-2"></i> Meu Perfil
              </a>
            </li>
            <li><hr class="dropdown-divider"></li>
            <li>
              <a class="dropdown-item text-danger" href="/ser-v2/public/logout.php">
                <i class="fa fa-sign-out-alt me-2"></i> Sair
              </a>
            </li>
          </ul>
        </div>
        <?php else: ?>
        <i class="fa-solid fa-user-circle text-muted fa-lg"></i>
        <?php endif; ?>
      </div>
    </div>
  </header>