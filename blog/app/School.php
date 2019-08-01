<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    protected $table = 'school';
    public $timestamps = false;
    //
    public function label(){
        return $this->hasOne('App\School','s_id','id');
    }
}
