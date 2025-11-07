<?php
declare(strict_types=1);
namespace App\Core\Auth;
use PDO, PDOException;

/**
 * Guard - Sistema de Controle de Acesso Definitivo
 * Este é o sistema ÚNICO e DEFINITIVO para todas as verificações de acesso
 */
final class Guard {
  private PDO $db;
  
  public function __construct(PDO $db) {
    $this->db = $db;
  }
  
  /**
   * Verifica se usuário está autenticado
   * Redireciona para login se não estiver
   */
  public function requireAuth(): void {
    if (!$this->isAuthenticated()) {
      header('Location: ' . url('login'));
      exit;
    }
  }
  
  /**
   * Verifica se usuário está autenticado (sem redirecionamento)
   */
  public function isAuthenticated(): bool {
    return isset($_SESSION['user_id']) && $this->getActor() !== null;
  }
  
  /**
   * Verifica se usuário tem permissão específica
   * Exibe erro 403 se não tiver
   */
  public function requirePermission(string $acaoChave): void {
    if (!$this->can($acaoChave)) {
      http_response_code(403);
      echo "Acesso negado. Permissão necessária: " . htmlspecialchars($acaoChave);
      exit;
    }
  }
  
  /**
   * Verifica se usuário tem permissão (sem erro)
   */
  public function can(string $acaoChave): bool {
    $actor = $this->getActor();
    if (!$actor) return false;
    
    // SuperAdmin tem acesso a tudo
    if (in_array('SuperAdmin', $actor->roles, true)) return true;
    
    // Admin também tem acesso amplo (compatibilidade)
    if (in_array('Admin', $actor->roles, true)) return true;
    
    if (!$actor->roles) return false;
    
    $ph = implode(',', array_fill(0, count($actor->roles), '?'));
    $sql = "SELECT 1 FROM acoes a 
            JOIN permissoes_acoes pa ON pa.acao_id = a.id 
            JOIN perfis p ON p.id = pa.perfil_id
            WHERE a.chave = ? AND pa.permitido = 1 
            AND (pa.id_empresa IS NULL OR pa.id_empresa = ?)
            AND p.nome IN ($ph) LIMIT 1";
    
    $params = array_merge([$acaoChave, $actor->empresaId], $actor->roles);
    
    try {
      $st = $this->db->prepare($sql);
      $st->execute($params);
      return (bool)$st->fetchColumn();
    } catch (PDOException) {
      return false;
    }
  }
  
  /**
   * Verifica se usuário tem permissão (alias para can)
   */
  public function hasPermission(string $acaoChave): bool {
    return $this->can($acaoChave);
  }
  
  /**
   * Obtém o usuário atual
   */
  public function getUser(): ?object {
    $actor = $this->getActor();
    if (!$actor) return null;
    
    try {
      $stmt = $this->db->prepare("SELECT id, nome, email, id_empresa FROM usuarios WHERE id = ?");
      $stmt->execute([$actor->userId]);
      $userData = $stmt->fetch();
      
      return $userData ? (object)$userData : null;
    } catch (PDOException) {
      return null;
    }
  }
  
  /**
   * Obtém o contexto do ator atual
   */
  public function getActor(): ?ActorContext {
    return $GLOBALS['actor'] ?? null;
  }
  
  /**
   * Obtém o contexto do ator (alias)
   */
  public function getActorContext(): ?ActorContext {
    return $this->getActor();
  }
}
