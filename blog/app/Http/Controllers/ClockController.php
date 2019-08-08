<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Staff;
use App\Clock;
class ClockController extends Controller
{
    //考勤列表
    public function list(){
        $lists = Clock::where('eid',session('eid'))->paginate(10);
        return view('clock.list',compact('lists'));
    }

    //打卡视频
    public function video(){
        $video = request('video');
        return view('clock.video',compact('video'));
    }

}
