<?php

namespace App\Model\Auth;

use App\Model\RoleAbles;
use App\Model\UserAbles;
use Illuminate\Database\Eloquent\Model;

class RoleModel extends Model
{
    protected $guarded = [];

    public function permission()
    {
        return $this->morphToMany(RoleAbles::class,'role_able');
    }

    public function user()
    {
        return $this->morphToMany(UserAbles::class,'user_able');
    }
}
