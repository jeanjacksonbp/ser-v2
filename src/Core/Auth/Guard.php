<?php
declare(strict_types=1);
namespace App\Core\Auth;
use PDO, PDOException;
final class Guard {
  private PDO $db; public function __construct(PDO $db){$this->db=$db;}
  public function can(string $acaoChave): bool {
    /** @var ActorContext|null $actor */ $actor=$GLOBALS['actor']??null; if(!$actor)return false;
    if(in_array('Admin',$actor->roles,true)) return true; if(!$actor->roles) return false;
    $ph=implode(',',array_fill(0,count($actor->roles),'?'));
    $sql="SELECT 1 FROM acoes a JOIN permissoes_acoes pa ON pa.acao_id=a.id JOIN perfis p ON p.id=pa.perfil_id
          WHERE a.chave=? AND pa.permitido=1 AND (pa.id_empresa IS NULL OR pa.id_empresa=?)
          AND p.nome IN ($ph) LIMIT 1";
    $params=array_merge([$acaoChave,$actor->empresaId],$actor->roles);
    try{$st=$this->db->prepare($sql);$st->execute($params);return (bool)$st->fetchColumn();}catch(PDOException){return false;}
  }
}
