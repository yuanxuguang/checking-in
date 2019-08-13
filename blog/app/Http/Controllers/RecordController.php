<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Record;
use DB;
class RecordController extends Controller
{
    //记录列表
    public function list(){
        if(request('type')){
            if(request('phone_num')){
                $lists = Record::where('eid',session('eid'))->where('type',request('type'))->where('phone_num',request('phone_num'))->paginate(10);
            }else{
                $lists = Record::where('eid',session('eid'))->where('type',request('type'))->paginate(10);
            }
        }elseif(request('phone_num')){
            $lists = Record::where('eid',session('eid'))->where('phone_num',request('phone_num'))->paginate(10);
        }else{
            $lists = Record::where('eid',session('eid'))->paginate(10);
        }
        return view('record.list',compact('lists'));
    }

    public function recordText(){
        $text = DB::table('record')->where('id',request('rid'))->select('text')->first();
        return view('record.text',compact('text'));
    }

    public function record(){
        $type = request('type');
        if($type == '3'){
            $info = DB::table('record')->where('id',request('rid'))->select('img')->first();
            $info = json_decode($info->img);
        }else{
            $info = DB::table('record')->where('id',request('rid'))->select('video')->first();
            $info = json_decode($info->video);
        }
        return view('record.record',compact('info','type'));
    }
}
