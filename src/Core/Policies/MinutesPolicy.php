<?php
declare(strict_types=1);
namespace App\Core\Policies;
use App\Core\Auth\ActorContext;
final class MinutesPolicy {
  public function publish(ActorContext $actor,int $committeeId,string $statusAtual): bool {
    $roleOk=in_array('CoordComite',$actor->roles,true)||in_array('Admin',$actor->roles,true);
    $scopeOk=$actor->inScope('committee',$committeeId);
    $statusOk=($statusAtual==='DRAFT');
    return $roleOk && $scopeOk && $statusOk;
  }
}
