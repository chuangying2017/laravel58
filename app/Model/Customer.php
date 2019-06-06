<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{

    protected $table = 'customer';

    public $timestamps = true;

    protected $guarded = ['id'];

    //
    public function session_record()
    {
        return $this->hasMany(SessionRecord::class);
    }

    public function scopeStatus($query)
    {
        return $query->where('status','active');
    }
}
