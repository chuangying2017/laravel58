<?php

namespace App\Model\Auth;

use App\Model\RoleAbles;
use Illuminate\Database\Eloquent\Model;

class PermissionModel extends Model
{
    protected $guarded = [];

    protected $primaryKey = 'id';

    public function role()
    {
        return $this->morphToMany(RoleAbles::class,'role_able');
    }
}
