<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    //
    protected $table = 'record';
    public $timestamps = false;

    public function staff(){
        return $this->belongsTo('App\Staff','sid','id');
    }

    public function contract(){
        return $this->belongsTo('App\Contract','cid','id');
    }
}
