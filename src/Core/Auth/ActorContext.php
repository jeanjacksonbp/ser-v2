<?php
declare(strict_types=1);
namespace App\Core\Auth;
final class ActorContext {
  public int $userId; public int $empresaId;
  /** @var array<int,string> */ public array $roles;
  /** @var array<string,array<int,int>> */ public array $scopesByType;
  public function __construct(int $userId,int $empresaId,array $roles=[],array $scopesByType=[]) {
    $this->userId=$userId; $this->empresaId=$empresaId; $this->roles=$roles; $this->scopesByType=$scopesByType;
  }
  public function hasRole(string $name): bool { return in_array($name,$this->roles,true); }
  public function inScope(string $type,int $refId): bool { return isset($this->scopesByType[$type]) && in_array($refId,$this->scopesByType[$type],true); }
}
