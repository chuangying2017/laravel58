<?php

namespace App\Model\Auth;

use App\Model\User;
use Illuminate\Database\Eloquent\Model;

class RoleModel extends Model
{
    protected $guarded = [];

    public function permission()
    {
        return $this->morphToMany(PermissionModel::class,'roleable','role_ables');
    }

    public function user()
    {
        return $this->morphToMany(User::class,'userable');
    }
}
