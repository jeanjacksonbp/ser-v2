<?php
// Não exige guard; é página pública
?><!doctype html>
<html lang="pt-br">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Login — SER</title>
  <link rel="stylesheet" href="/assets/css/auth.css" />
</head>
<body>
  <div class="auth-wrap">
    <div class="auth-head">
      <div class="brand">
        <div class="badge">SR</div>
        <div class="name">SER — Sistema de Excelência em Resultados</div>
      </div>
    </div>

    <div class="auth-body">
      <h1 class="title">Entrar</h1>
      <p class="subtitle">Use seu e-mail corporativo e senha.</p>

      <?php if (!empty($_GET['err'])): ?>
        <div class="error"><?= htmlspecialchars($_GET['err']) ?></div>
      <?php endif; ?>

      <form method="post" action="/login">
        <div class="form-field">
          <label class="label" for="email">E-mail</label>
          <input class="input" type="email" id="email" name="email" required autofocus />
        </div>
        <div class="form-field">
          <label class="label" for="senha">Senha</label>
          <input class="input" type="password" id="senha" name="senha" required />
        </div>
        <div class="actions">
          <button class="btn" type="submit">Entrar</button>
          <a class="link" href="#">Esqueci minha senha</a>
        </div>
      </form>
    </div>
  </div>
</body>
</html>

