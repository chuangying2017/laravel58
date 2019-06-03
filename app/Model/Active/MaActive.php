<?php

namespace App\Model\Active;

use App\Model\ModelConfig;
use Illuminate\Database\Eloquent\Model;

class MaActive extends Model
{
    use ModelConfig;
    protected $table = 'ma_active';

    protected $guarded = ['id'];

    public $timestamps = false;

    protected $casts = [
        'createTime' => 'Y-m-d H:i:s',
    ];

    public function category()
    {
        return $this->belongsTo(MaCategory::class,'cid');
    }
}
