<?php
// public/login.php
require __DIR__ . '/../bootstrap/bootstrap.php';

// (opcional) Se já tem middleware para bloquear logado, pode redirecionar daqui
// if (!empty($_SESSION['user'])) { header('Location: ' . url('/dashboard.php')); exit; }

require view_path('layouts/header.php');
require view_path('auth/login.php');
require view_path('layouts/footer.php');
