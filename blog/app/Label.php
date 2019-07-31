<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Label extends Model
{
    protected $table = 'label';
    public $timestamps = false;
    //
    public function contract(){
        return $this->belongsTo('App\Contract','c_id','id');
    }

    public function school(){
        return $this->belongsTo('App\School','s_id','id');
    }
}
