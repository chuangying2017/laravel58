<?php

namespace App\Model;

use App\Model\Auth\RoleModel;
use Illuminate\Database\Eloquent\Relations\Pivot;

class UserAbles extends Pivot
{
    protected $table = 'user_able';

    public function user()
    {
        return $this->morphToMany(User::class,'user_able');
    }

    public function role()
    {
        return $this->morphToMany(RoleModel::class,'user_able');
    }
}
