<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>SER v2 – Sistema de Excelência em Resultados</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <style>
        .ser-header {
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
            color: white;
            min-height: 70px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .dropdown-menu-mobile {
            background: #1e3a8a;
            border: none;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .dropdown-menu-mobile .dropdown-item {
            color: white;
            transition: background-color 0.2s;
        }
        .dropdown-menu-mobile .dropdown-item:hover {
            background-color: rgba(255,255,255,0.1);
            color: white;
        }
        .text-primary-custom {
            color: #3b82f6 !important;
        }
        .btn-link.text-primary {
            color: white !important;
            text-decoration: none;
        }
        .btn-link.text-primary:hover {
            color: #e5e7eb !important;
        }
    </style>
</head>
<body>
<header class="ser-header d-flex align-items-center justify-content-between px-4">
    <div class="d-flex align-items-center position-relative">
        <button class="btn btn-link text-primary sidebar-toggle-mobile d-lg-none me-2" id="sidebarMobileToggle" style="font-size:1.5rem;">
            <i class="fa fa-bars"></i>
        </button>
        <span class="fw-bold fs-4 text-white">SER</span>

        <!-- Dropdown mobile menu -->
        <div id="mobileDropdownMenu" class="dropdown-menu-mobile d-lg-none" style="display:none; position:absolute; top:60px; left:0; z-index:2000; background:#1e3a8a; border-radius:0 0 1rem 1rem; min-width:200px;">
            <a class="dropdown-item text-white" href="<?= url('dashboard') ?>">
                <i class="fa fa-home me-2"></i> Dashboard</a>
            <?php if (($GLOBALS['guard'] ?? null) && $GLOBALS['guard']->can('dashboard.superadmin.view')): ?>
                <a class="dropdown-item text-white" href="<?= url('superadmin') ?>">
                    <i class="fa fa-cog me-2"></i> Painel Global</a>
            <?php endif; ?>
            <?php if (($GLOBALS['guard'] ?? null) && $GLOBALS['guard']->can('dashboard.org.view')): ?>
                <a class="dropdown-item text-white" href="<?= url('org') ?>">
                    <i class="fa fa-building me-2"></i> Minha Organização</a>
            <?php endif; ?>
            <?php if (($GLOBALS['guard'] ?? null) && $GLOBALS['guard']->can('minutes.view')): ?>
                <a class="dropdown-item text-white" href="<?= url('minutes') ?>">
                    <i class="fa fa-tasks me-2"></i> Atas</a>
            <?php endif; ?>
        </div>
    </div>
    
    <!-- Desktop Navigation -->
    <nav class="d-none d-lg-flex align-items-center">
        <a class="text-white text-decoration-none me-4" href="<?= url('dashboard') ?>">
            <i class="fa fa-home me-1"></i> Dashboard</a>
        <?php if (($GLOBALS['guard'] ?? null) && $GLOBALS['guard']->can('dashboard.superadmin.view')): ?>
            <a class="text-white text-decoration-none me-4" href="<?= url('superadmin') ?>">
                <i class="fa fa-cog me-1"></i> Painel Global</a>
        <?php endif; ?>
        <?php if (($GLOBALS['guard'] ?? null) && $GLOBALS['guard']->can('dashboard.org.view')): ?>
            <a class="text-white text-decoration-none me-4" href="<?= url('org') ?>">
                <i class="fa fa-building me-1"></i> Minha Organização</a>
        <?php endif; ?>
        <?php if (($GLOBALS['guard'] ?? null) && $GLOBALS['guard']->can('minutes.view')): ?>
            <a class="text-white text-decoration-none me-4" href="<?= url('minutes') ?>">
                <i class="fa fa-tasks me-1"></i> Atas</a>
        <?php endif; ?>
    </nav>

    <div class="d-flex align-items-center">
        <?php if (!empty($_SESSION['user_id'])): ?>
            <!-- Ícone de usuário com dropdown -->
            <div class="dropdown">
                <button class="btn btn-link text-primary dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-user fa-lg"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                    <li>
                        <a class="dropdown-item" href="<?= url('profile') ?>">
                            <i class="fa fa-user-edit me-2"></i> Meu Perfil
                        </a>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <a class="dropdown-item text-danger" href="<?= url('logout') ?>">
                            <i class="fa fa-sign-out-alt me-2"></i> Sair
                        </a>
                    </li>
                </ul>
            </div>
        <?php else: ?>
            <a class="btn btn-outline-light" href="<?= url('login') ?>">
                <i class="fa fa-sign-in-alt me-1"></i> Entrar
            </a>
        <?php endif; ?>
    </div>
</header>

<!-- JavaScript do Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Toggle mobile menu
    document.getElementById('sidebarMobileToggle')?.addEventListener('click', function() {
        const menu = document.getElementById('mobileDropdownMenu');
        menu.style.display = menu.style.display === 'none' ? 'block' : 'none';
    });
    
    // Close mobile menu when clicking outside
    document.addEventListener('click', function(event) {
        const menu = document.getElementById('mobileDropdownMenu');
        const toggle = document.getElementById('sidebarMobileToggle');
        if (!toggle?.contains(event.target) && !menu?.contains(event.target)) {
            menu.style.display = 'none';
        }
    });
</script>

<main class="container-fluid py-4">
