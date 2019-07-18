<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use DB;
use Illuminate\Pagination\LengthAwarePaginator;
class EmployerController extends Controller
{
    //
    public function list(Request $request){
        $lists = DB::table('employer')->get();
        foreach($lists as $k => $v){
            if($v->boss != 0){
                $bossName = DB::table('employer')->where('id',$v->boss)->select('name')->first();
                $lists[$k]->bossName = $bossName->name;
            }
        }
        $lists = json_decode(json_encode($lists,true));
        //当前页数 默认1
        $page = $request->page ?: 1;
        //每页的条数
        $perPage = 10;
        //计算每页分页的初始位置
        $offset = ($page * $perPage) - $perPage;
        //实例化LengthAwarePaginator类，并传入对应的参数
        $lists = new LengthAwarePaginator(array_slice($lists, $offset, $perPage, true), count($lists), $perPage,
        $page, ['path' => $request->url(), 'query' => $request->query()]);
        return view('employer.list',compact('lists'));
    }

    public function add(){
        $bigEmployers = DB::table('employer')->where('type','0')->select('id','name')->get();
        return view('employer.add',compact('bigEmployers'));
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
        $data['boss'] = $request['leader'];
        if($request['leader']){  //如果有主雇主，获取主顾主name 写入.
            $bossName = DB::table('employer')->where('id',$request['leader'])->select('name')->first();
            $data['boss_name'] = $bossName->name;
        }

        $bool = DB::table('employer')->insert($data);
        $info = empty($bool)?-1:1;
        return ['info' => $info];

    }

    public function edit($id){
        $list = DB::table('employer')->where('id',$id)->first();
        $bigEmployers = DB::table('employer')->where('type','0')->select('id','name')->get();
        return view('employer.edit',compact('bigEmployers','list'));
    }

    public function editInsert(Request $request){
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
        $data['boss'] = $request['leader'];
        if($request['leader']){  //如果有主雇主，获取主顾主name 写入.
            $bossName = DB::table('employer')->where('id',$request['leader'])->select('name')->first();
            $data['boss_name'] = $bossName->name;
        }

        $bool = DB::table('employer')->insert($data);
        $info = empty($bool)?-1:1;
        return ['info' => $info];
    }
}
