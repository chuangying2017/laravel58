<?php

namespace App\Model\Auth;

use Illuminate\Database\Eloquent\Model;

class RoleModel extends Model
{
    protected $guarded = [];

    public function permission()
    {
        return $this->morphMany(PermissionModel::class,'role_able');
    }
}
