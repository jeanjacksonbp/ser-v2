<!doctype html>
<html lang="pt-br">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>SER v2</title>
  <link rel="stylesheet" href="/assets/app.css" />
</head>
<body>
<header>
  <h1>SER v2</h1>
  <nav>
  <a href="/dashboard">Início</a>
  <?php if (($GLOBALS['guard'] ?? null) && $GLOBALS['guard']->can('dashboard.superadmin.view')): ?>
    <a href="/superadmin">Painel Global</a>
  <?php endif; ?>
  <?php if (($GLOBALS['guard'] ?? null) && $GLOBALS['guard']->can('dashboard.org.view')): ?>
    <a href="/org">Minha Organização</a>
  <?php endif; ?>

  <span style="flex:1"></span>
  <?php if (!empty($_SESSION['user_id'])): ?>
    <a href="/logout">Sair</a>
  <?php else: ?>
    <a href="/login">Entrar</a>
  <?php endif; ?>
</nav>

  <nav>
    <a href="/dashboard">Dashboard</a>
    <?php if (($GLOBALS['guard'] ?? null) && $GLOBALS['guard']->can('minutes.view')): ?>
      <a href="/minutes">Atas</a>
    <?php endif; ?>
  </nav>
</header>
<main>
