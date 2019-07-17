<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use DB;
class EmployerController extends Controller
{
    //
    public function list(){
        return view('employer.list');
    }

    public function add(){
        return view('employer.add');
    }

    public function getBigEmployer(){
        $res = DB::table('employer')->where('type','0')->select('id','name')->get();

        return json_encode($res);
    }

    public function insert(Request $request){

        $validate = Validator::make(request()->all(),[
            'type' => 'required',
            'name' => 'required',
            'company_name' => 'required',
            'company_num' => 'required',
            'phone' => 'required|unique:employer',
            'password' => 'required'
        ],[
            'unique' => '该手机号已经存在'
        ]);
        if($validate->fails()){
            return response()->json(['error' => $validate->errors(),'code' => 0]);
        }

        $data = $request->except('leader');
        $bool = DB::table('employer')->insert($data);
        $info = empty($bool)?-1:1;
        return ['info' => $info];

    }

    public function edit(){

    }

    public function editInsert(){

    }
}
