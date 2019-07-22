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
        return view('public.commonView');
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

}
