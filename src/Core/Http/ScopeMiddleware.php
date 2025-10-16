<?php
declare(strict_types=1);
namespace App\Core\Http;
use App\Core\Auth\ActorContext; use PDO;
final class ScopeMiddleware {
  private PDO $db; public function __construct(PDO $db){$this->db=$db;}
  public function handle(callable $next){
    if (!isset($_SESSION['user_id'])) {
      // Sem usuário logado: apenas segue. As rotas protegidas devem redirecionar/forçar login.
      return $next();
    }
    $userId = (int)$_SESSION['user_id'];
    // ... resto igual: carrega empresa, roles, scopes e popula $GLOBALS['actor']
    // (mantenha o código existente de queries e montagem)
    // ...
    return $next();
  }
}
