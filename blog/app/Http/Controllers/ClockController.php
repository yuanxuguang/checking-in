<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Clock;
class ClockController extends Controller
{
    //考勤列表
    public function list(Request $request){
        if(request('start')){
            $start = request('start');
        }else{
            $start = date('Y-m-d H:i:s',strtotime(date('Y-m-d',time()))-7*86400);
        }
        if(request('end')){
            $end = request('end');
        }else{
            $end = date('Y-m-d H:i:s',strtotime(date('Y-m-d',time()))+86400);
        }
        if(request('condition')){
            $staff = DB::table('staff')->where('phone_num',request('condition'))->select('id')->first();
            if($staff){
                $lists = Clock::where('eid',session('eid'))->where('type','1')->where('start_time','>',$start)->where('end_time','<',$end)->where('sid',$staff->id)->paginate(10);
            }else{
                $lists = Clock::where('eid',session('eid'))->where('start_time','>',$start)->where('end_time','<',$end)->where('type','1')->paginate(10);
            }
        }else{
            $lists = Clock::where('eid',session('eid'))->where('type','1')->paginate(10);
        }
        return view('clock.list',compact('lists'));
    }

    //打卡视频
    public function video(){
        $video = request('video');
        $type = request('type');
        return view('clock.video',compact('video','type'));
    }

    public function stationList(){
        if(request('start')){
            $lists = Clock::where('type','2')->where('start_time','>',request('start'))->where('sid',request('sid'))->paginate(10);
        }else{
            $lists = Clock::where('type','2')->where('eid',session('eid'))->paginate(10);
        }
        return view('clock.stationList',compact('lists'));
    }

    public function safetyEquipList(){
        if(request('date')){
            $lists = Clock::where('type','3')->where('date',request('date'))->where('sid',request('sid'))->get();
            return view('clock.safetyEquipList',compact('lists'));
        }
    }

}
