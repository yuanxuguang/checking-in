<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/7/19
 * Time: 14:17
 */

namespace App\Http\Controllers;
use \App\Contract;
use Illuminate\Http\Request;
use Storage;
use DB;
class ContractController extends Controller
{
    public function list(){
        $contracts = DB::table('contract');
        return view('contract.list');
    }

    public function add(){
        //外判雇主列表
        $out_employers = DB::table('employer')->where('id',session('eid'))->get();
        $up_contracts = DB::table('contract')->where('c_type',"1")->get();
        return view('contract.add',compact('out_employers','up_contracts'));
    }

    public function insert(Request $request){
//        if(!$request['out_employer']){
//            $data = $request->except('out_employer','up_contract');
//        }else{
//
//        }
        $data = $request->except('out_employer');

        $data['eid'] = session('eid');
//        $employer = DB::table('employer')->where('id',session('eid'))->first();
        if(request()->hasFile('c_img')){
            $path = Storage::putFileAs('/public/c_img',request('c_img'),date('Ymd').'_'.date('His').'.png');
            $path = str_replace('public','storage',$path);
            $data['c_img'] = $path;
        }
//        $data = $this->array_to_object($data);
//        dd($data);
        $info = \DB::table('contract')->insert($data);
        $info = empty($info)?0:1;

        return ['info' =>$info];

    }

    public function edit(){
        return view('contract.edit');
    }

    public function editInsert(){

    }

    public function delete(){

    }

    public function array_to_object($arr) {
        if (gettype($arr) != 'array') {
            return;
        }
        foreach ($arr as $k => $v) {
            if (gettype($v) == 'array' || getType($v) == 'object') {
                $arr[$k] = (object)array_to_object($v);
            }
        }

        return (object)$arr;
    }


}