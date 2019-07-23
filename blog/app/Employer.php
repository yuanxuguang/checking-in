<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employer extends Model
{
    //
    protected $table = 'employer';
    public $timestamps = false;

    public function contracts(){
        return $this->hasMany('App\Contract');
    }
}
