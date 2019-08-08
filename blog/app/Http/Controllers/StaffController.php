<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Staff;
class StaffController extends Controller
{
    //
    public function list(Request $request){
//        echo $request['role'];
//        dd($request['condition']);
        //条件搜索
        if($request['condition']) {
            if (preg_match("/^1[345678]{1}\d{9}$/", $request['condition'])) {
                $where_phone = $request['condition'];
                $where_name = 0;
            } else {
                $where_phone = 0;
                $where_name = $request['condition'];
            }
        }

        if($request['condition'] && $request['role'] != 0){
            $lists = Staff::when($where_phone,function($query) use ($where_phone){
                            return $query->where('phone_num',$where_phone);
                        },function($query) use ($where_name){
                            return $query->where('name',$where_name);
                        })
                    ->where('role',$request['role'])
                    ->paginate(10);
        }elseif($request['condition'] && $request['role'] == 0){
            $lists = Staff::when($where_phone,function($query) use ($where_phone){
                        return $query->where('phone_num',$where_phone);
                        },function($query) use ($where_name){ return $query->where('name',$where_name); })
                    ->paginate(10);


        }elseif(!$request['condition'] && $request['role'] != 0){
            $lists = Staff::where('role',$request['role'])->paginate(10);
//            dd($lists);
        }else{
            $lists = Staff::paginate(10);
        }

//        $lists = Staff::paginate(10);
        $employerName = DB::table('employer')->where('id',session('eid'))->select('name')->first();
        $outEmployer = DB::table('employer')->where('boss',session('eid'))->where('type','2')->get();
        return view('staff.list',compact('lists','employerName','outEmployer'));
    }

    public function add(){
        $contracts = DB::table('contract')->where('eid',session('eid'))->get();
        $jobs = DB::table('job')->where('eid',session('eid'))->get();
        return view('staff.add',compact('jobs','contracts'));
    }

    public function insert(Request $request){
        $data = $request->except('repass');
        $data['password'] = md5($data['password']);
        $data['eid'] = session('eid');
//        dd($data);
        $bool = Staff::insert($data);
        return ['info' => $bool];
    }

    //员工绑定外判雇主
    public function staffOutEmployer($sid,$eid){
        $bool = DB::table('staff')->where('id',$sid)->update(['out_eid' => $eid]);

        return ['info' => $bool];
    }

    public function edit($id){
        $list = Staff::where('id',$id)->first();
        $contracts = DB::table('contract')->where('eid',session('eid'))->get();
        $jobs = DB::table('job')->where('eid',session('eid'))->get();
        return view('staff.edit',compact('list','contracts','jobs'));
    }

    public function editInsert(Request $request){
        $password = Staff::where('id',request('id'))->select('password')->first();
        if($password->password == $request['password']){
            $data = $request->except(['password','repass']);

        }else{
            $password = md5($request['password']);
            $data = $request->except('repass');
            $data['password'] = $password;
        }
//dd($data);
        $bool = Staff::where('id',$request['id'])->update($data);
        return ['info'=>$bool];

    }

    public function setStaffStatus(){
        $bool = Staff::where('id',request('id'))->update(['status'=>request('status')]);
        return ['info'=>$bool];
    }


}
