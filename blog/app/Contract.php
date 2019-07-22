<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    //
    protected $table = 'contract';
    public $timestamps = false;
    protected $fillable = ['c_type'];
    public function employer(){
        return $this->hasOne('employer');
    }

}
