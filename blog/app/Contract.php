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
        //第一个参数是属于哪个模型。 第二个是当前模型的外键，第三个参数是关联模型的主键
        return $this->belongsTo('App\Employer','eid','id');
    }

    public function upContract(){
        return $this->hasOne('App\Contract','up_contract');
    }

    public function byUpContract(){
        return $this->belongsTo('App\Contract','up_contract','id');
    }

}
