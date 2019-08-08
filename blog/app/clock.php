<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class clock extends Model
{
    //
    protected $table = 'clock';
    public $timestamps = false;


    public function staff()
    {
        return $this->belongsTo('App\Staff','sid','id');
    }

}
