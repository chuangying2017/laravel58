<?php

namespace App\Model;

use App\Model\Auth\PermissionModel;
use App\Model\Auth\RoleModel;
use Illuminate\Database\Eloquent\Relations\Pivot;

class RoleAbles extends Pivot
{

    protected $table = 'role_able';

   public function permission()
   {
       return $this->morphedByMany(PermissionModel::class,'role_able','role_able');
   }

   public function role()
   {
       return $this->morphedByMany(RoleModel::class,'role_able','role_able');
   }
}
