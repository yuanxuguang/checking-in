<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    //
    protected $table = 'job';
    public $timestamps = false;

    //j_id 是 staff 外键
    public function staff(){
        return $this->hasOne('App\Staff','j_id','id');
    }

}
