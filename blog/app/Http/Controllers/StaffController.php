<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Staff;
class StaffController extends Controller
{
    //
    public function list(){
        $lists = DB::table('employer')->paginate(10);
        return view('staff.list',compact('lists'));
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

    public function edit(){

    }

    public function editInsert(){

    }


}
