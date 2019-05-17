<?php

namespace App\Model\Active;

use Illuminate\Database\Eloquent\Model;

class MaActive extends Model
{
    protected $table = 'ma_active';

    protected $guarded = ['id'];

    public $timestamps = false;

    public function category()
    {
        return $this->belongsTo(MaCategory::class,'cid');
    }
}
