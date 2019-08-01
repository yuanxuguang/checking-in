<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/7/25
 * Time: 16:07
 */
namespace App;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model{
    protected $table = 'staff';
    public $timestamps = false;

    //属于哪个合约
    public function contract(){
        return $this->belongsTo('App\Contract','c_id','id');
    }

    //属于哪个职位   j_id 是staff 外键
    public function job(){
        return $this->belongsTo('App\Job','j_id','id');
    }


}
