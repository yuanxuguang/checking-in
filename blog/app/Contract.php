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

    public function staff(){
        //第二个参数是Staff 中与改模型相关联的外键，第三个是该模型中的主键
        return $this->hasOne('App\Staff','c_id','id');
    }

    public function label(){
        return $this->hasOne('App\Label','c_id','id');
    }

//    public function upContract(){
//        return $this->hasOne('App\Contract','up_contract');
//    }
//
//    public function byUpContract(){
//        return $this->belongsTo('App\Contract','up_contract','id');
//    }

}
