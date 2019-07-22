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
        if($request['condition']) {
            if (preg_match("/^1[345678]{1}\d{9}$/", $request['condition'])) {
                $where_phone = $request['condition'];
                $where_name = 0;
            } else {
                $where_phone = 0;
                $where_name = $request['condition'];
            }

        }

        if($request['employerType'] === '1'){
            $where2 = '1';
        }else if($request['employerType'] === '2'){
            $where2 = '2';
        }

        if($request['condition'] && $request['employerType'] === '0'){
            $lists = DB::table('employer')
                ->when($where_phone,function($query) use ($where_phone){
                    return $query->where('phone',$where_phone);
                    },function($query) use ($where_name){ return $query->where('name',$where_name); })
                ->paginate(10);

        }else if(isset($where2) && is_null($request['condition'])){
            $lists = DB::table('employer')
                ->where('type',$where2)
                ->paginate(10);
        }else if(isset($where2) && $request['condition']){
            $lists = DB::table('employer')
                ->when($where_phone,function($query) use ($where_phone){
                    return $query->where('phone',$where_phone);
                },function($query) use ($where_name){ return $query->where('name',$where_name); })
                ->where('type',$where2)
                ->paginate(10);
        }else{
            $lists = DB::table('employer')->paginate(10);
        }
//        foreach($lists as $k => $v){
//            if($v->boss != 0){
//                $bossName = DB::table('employer')->where('id',$v->boss)->select('name')->first();
//                $lists[$k]->bossName = $bossName->name;
//            }
//        }
//        $lists = json_decode(json_encode($lists,true));
//        //当前页数 默认1
//        $page = $request->page ?: 1;
//        //每页的条数
//        $perPage = 10;
//        //计算每页分页的初始位置
//        $offset = ($page * $perPage) - $perPage;
//        //实例化LengthAwarePaginator类，并传入对应的参数
//        $lists = new LengthAwarePaginator(array_slice($lists, $offset, $perPage, true), count($lists), $perPage,
//        $page, ['path' => $request->url(), 'query' => $request->query()]);
        return view('employer.list',compact('lists'));
    }

    public function add(){
        $bigEmployers = DB::table('employer')->where('type','1')->select('id','name')->get();
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
            'phone' => 'required',
            'password' => 'required'
        ],[
            'unique' => '该手机号已经存在'
        ]);
        if($validate->fails()){
            return response()->json(['error' => $validate->errors(),'code' => 0]);
        }

        $data = $request->except('leader','id');
        $data['boss'] = $request['leader'];
        if($request['leader']){  //如果有主雇主，获取主顾主name 写入.
            $bossName = DB::table('employer')->where('id',$request['leader'])->select('name')->first();
            $data['boss_name'] = $bossName->name;
        }

        $bool = DB::table('employer')->where('id',$request['id'])->update($data);
        $info = empty($bool)?-1:1;
        return ['info' => $info];
    }

    public function setEmployerStatus(){
        $bool = DB::table('employer')->where('id',request('id'))->update(['status' => request('status')]);
        $info = empty($bool)?-1:1;
        return ['info' => $info];
    }

}
