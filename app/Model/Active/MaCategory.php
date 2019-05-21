<?php

namespace App\Model\Active;

use App\Model\ModelConfig;
use Illuminate\Database\Eloquent\Model;

class MaCategory extends Model
{
    protected $table = 'ma_category';

    protected $guarded = ['id'];

    public $timestamps = false;

    protected $casts = [
        'time' => 'Y-m-d H:i:s',
    ];

    /**
     * @param bool $timestamps
     */
    public function setTimestamps(bool $timestamps): void
    {
        $this->timestamps = $timestamps;
    }

    public function active()
    {
        return $this->hasMany(MaActive::class,'cid','id');
    }
}
