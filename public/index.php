<?php
declare(strict_types=1);
require __DIR__ . '/../bootstrap/app.php';

$uri = strtok($_SERVER['REQUEST_URI'] ?? '/', '?');
$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';

/** LOGIN (GET) */
if ($uri === '/login' && $method === 'GET') {
  require __DIR__ . '/../resources/views/pages/login.php';
  exit;
}

/** LOGIN (POST) */
if ($uri === '/login' && $method === 'POST') {
  $email = trim($_POST['email'] ?? '');
  $senha = (string)($_POST['senha'] ?? '');

  // Busca usuário
  $st = $GLOBALS['pdo']->prepare("SELECT id, id_empresa, email, senha_hash FROM usuarios WHERE email=? LIMIT 1");
  $st->execute([$email]);
  $u = $st->fetch();

  if (!$u || empty($u['senha_hash']) || !password_verify($senha, $u['senha_hash'])) {
    header('Location: /login?err=Credenciais+inválidas');
    exit;
  }

  // Autentica
  $_SESSION['user_id'] = (int)$u['id'];

  // Recarrega contexto do ator (middleware usa $_SESSION['user_id'])
  $mw = new App\Core\Http\ScopeMiddleware($GLOBALS['pdo']);
  $mw->handle(fn() => null);
  $actor = $GLOBALS['actor'];
  $guard = $GLOBALS['guard'];

  // Redireciona conforme perfil/permissão
  if ($actor->hasRole('SuperAdmin')) { header('Location: /superadmin'); exit; }
  if ($guard->can('dashboard.org.view')) { header('Location: /org'); exit; }
  header('Location: /dashboard'); exit;
}

/** LOGOUT */
if ($uri === '/logout') {
  $_SESSION = [];
  if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
  }
  session_destroy();
  header('Location: /login');
  exit;
}

/** Painéis (já existiam ou você criou) */
if ($uri === '/' || $uri === '/dashboard') {
  require __DIR__ . '/../resources/views/pages/dashboard.php'; exit;
}
if ($uri === '/superadmin') {
  require __DIR__ . '/../resources/views/pages/superadmin.php'; exit;
}
if ($uri === '/org') {
  require __DIR__ . '/../resources/views/pages/org-dashboard.php'; exit;
}

/** 404 */
http_response_code(404);
echo "Not Found";
