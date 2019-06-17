<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{

    protected $table = 'customer';

    public $timestamps = true;

    protected $guarded = ['id'];

    protected $foreignKey = 'manger_id';

    //
    public function session_record()
    {
        return $this->hasMany(SessionRecord::class);
    }

    public function scopeStatus($query)
    {
        return $query->where('status','active');
    }

    public function user()
    {
        return $this->belongsTo(User::class,$this->foreignKey);
    }
}
