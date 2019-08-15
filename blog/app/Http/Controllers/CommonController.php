<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use DB;
class CommonController extends Controller
{
    //
    public function loginView(){
        return view("login");
    }

    public function commonView(){
        $employer = DB::table('employer')->where('id',session('eid'))->first();
        return view('public.commonView',compact('employer'));
    }

    public function indexView(){
        return view('hello');
    }

    public function doLogin(){
        $company_num = request('company_num');
        $user = DB::table('employer')->where('company_num',$company_num)->first();

        if($user){
            if(request('password') == $user->password ){
                session(['eid' => $user->id,'c_num' => $user->company_num,'e_type' => $user->type,'e_status' => $user->status]);
                return redirect('/commonView');
            }else{
                return redirect('/loginView')->with('error','账号或密码错误');
            }
        }else{
            return redirect('/loginView')->with('error','账号或密码错误');
        }
    }

    public function loginOut(Request $request){
        $request->session()->flush();
        return redirect('/loginView');
    }

    public function setDistance(){
        $list = DB::table('distance')->where('eid',session('eid'))->first();

        return view('distance',compact('list'));
    }

    public function updateDistance(){
        if(request('office_distance') < 40){
            return back()->with('error','上班打卡距离不能小于40');
        }
        if(request('work_distance') < 10){
            return back()->with('error','工作地点打卡距离不能小于10');
        }
        $data = request()->all();
        $data['eid'] = session('eid');
        $is_set = DB::table('distance')->where('eid',session('eid'))->count();
        if($is_set){
            $bool = DB::table('distance')->update($data);
        }else{
            $bool = DB::table('distance')->insert($data);
        }
        if($bool){
            return redirect('/setDistance')->with('success','修改成功');
        }else{
            return back()->with('error','修改失败');
        }
    }
}
