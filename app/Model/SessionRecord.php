<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class SessionRecord extends Model
{
    protected $table = 'session_record';

    public $timestamps = true;

    protected $guarded = ['id'];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
