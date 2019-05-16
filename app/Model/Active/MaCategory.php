<?php

namespace App\Model\Active;

use Illuminate\Database\Eloquent\Model;

class MaCategory extends Model
{
    protected $table = 'ma_category';

    protected $guarded = ['id'];

    public function active()
    {
        return $this->hasMany(MaActive::class,'category_id','id');
    }
}
