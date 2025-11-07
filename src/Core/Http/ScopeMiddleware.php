<?php
declare(strict_types=1);
namespace App\Core\Http;
use App\Core\Auth\ActorContext; 
use PDO, PDOException;

/**
 * ScopeMiddleware - Carregamento DEFINITIVO do Contexto do Usuário
 * Este middleware SEMPRE popula $GLOBALS['actor'] corretamente
 */
final class ScopeMiddleware {
  private PDO $db;
  
  public function __construct(PDO $db) {
    $this->db = $db;
  }
  
  /**
   * Carrega o contexto do usuário autenticado
   * SEMPRE popula $GLOBALS['actor'] - null se não autenticado
   */
  public function handle(callable $next) {
    // Sempre inicializa como null
    $GLOBALS['actor'] = null;
    
    // Se não há sessão, mantém null e continua
    if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
      return $next();
    }
    
    $userId = (int)$_SESSION['user_id'];
    
    try {
      // Carregar dados completos do usuário
      $stmt = $this->db->prepare("
        SELECT id, nome, email, id_empresa, ativo 
        FROM usuarios 
        WHERE id = ? AND ativo = 1
      ");
      $stmt->execute([$userId]);
      $userData = $stmt->fetch();
      
      // Se usuário não existe ou inativo, manter null
      if (!$userData) {
        return $next();
      }
      
      // Carregar todas as roles do usuário
      $stmt = $this->db->prepare("
        SELECT DISTINCT p.nome 
        FROM perfis p 
        JOIN user_roles ur ON p.id = ur.role_id 
        WHERE ur.user_id = ?
        ORDER BY p.nome
      ");
      $stmt->execute([$userId]);
      $roles = $stmt->fetchAll(PDO::FETCH_COLUMN);
      
      // Carregar scopes (ABAC) - por enquanto vazio, expandir depois
      $scopesByType = []; // TODO: Implementar carregamento de scopes quando necessário
      
      // Criar ActorContext com dados completos
      $actor = new ActorContext(
        (int)$userData['id'],
        (int)($userData['id_empresa'] ?? 0),
        $roles,
        $scopesByType
      );
      
      // Disponibilizar globalmente - SEMPRE
      $GLOBALS['actor'] = $actor;
      
    } catch (PDOException $e) {
      // Em caso de erro de banco, log e mantém null
      error_log("ScopeMiddleware error: " . $e->getMessage());
      $GLOBALS['actor'] = null;
    }
    
    return $next();
  }
  
  /**
   * Força recarregamento do contexto (útil após login)
   */
  public static function reload(PDO $db): void {
    $middleware = new self($db);
    $middleware->handle(fn() => null);
  }
}
