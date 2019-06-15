<?php

namespace App\Model\Auth;

use App\Model\RoleAbles;
use Illuminate\Database\Eloquent\Model;

class PermissionModel extends Model
{
    public function role()
    {
        return $this->morphToMany(RoleAbles::class,'role_able');
    }
}
